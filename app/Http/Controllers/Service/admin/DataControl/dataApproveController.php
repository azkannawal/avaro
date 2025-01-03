<?php

namespace App\Http\Controllers\Service\admin\DataControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Call Models
use App\Models\DataControl\dataApprove;
use App\Models\DataControl\tambang;
use App\Models\DataControl\jarakKantorKeTambang;
use App\Models\Pegawai\pegawai;
use App\Models\Kendaraan\driver;
use App\Models\Kendaraan\kendaraan;

// Call Library
use Validator;
use Str;
use Carbon\Carbon;

class dataApproveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getData = dataApprove::orderBy('status', 'asc')->get();
        $getPegawai = pegawai::all();
        $getTujuan = tambang::pluck('nama_tambang', 'id')->unique();
        $getJenisKendaraan = kendaraan::pluck('nama_kendaraan', 'id')->unique();
        return view('components.'.auth()->user()->getRole->nama_role. '.DataControl.dataApprove', compact('getData', 'getPegawai', 'getJenisKendaraan', 'getTujuan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pegawai' => 'required|exists:pegawais,id_pegawai',
            'id_kendaraan' => 'required|exists:kendaraans,nama_kendaraan',
            'tujuan_tambang' => 'required|integer|exists:tambangs,id',
        ], [
            'required' => ':attribute tidak boleh kosong.',
            'exists' => ':attribute tidak ditemukan.',
            'uuid' => ':attribute tidak valid.',
            'integer' => ':attribute harus berupa angka.',
        ], [
            'id_pegawai' => 'ID Pegawai',
            'tujuan_tambang' => 'Tujuan',
            'id_kendaraan' => 'Kendaraan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        // cek apkah hari ini sudah pesen kendaraan atau belum
        $cekData = dataApprove::where('id_pegawai', $request->id_pegawai)
            ->whereDate('created_at', date('Y-m-d'))
            ->whereNotIn('status', [4,5,6])
            ->first();

        if ($cekData) {
            return redirect()->back()->with('error', 'Anda sudah memesan kendaraan hari ini.');
        }

        $findPegawai = pegawai::where('id_pegawai', $request->id_pegawai)->first();

        // cek apakah kendaraan tersedia
        $findKendaraan = kendaraan::where('nama_kendaraan', $request->id_kendaraan)
            ->where('status_pakai', 0) // 0 = tidak dipakai
            ->where('penempatan', $findPegawai->kantor->jenis_kantor)
            ->whereNotIn('service_terakhir', ['service'])
            ->whereNotIn('service_berikutnya', ['service'])
            ->first(); 
        
        // cek apakah driver tersedia
        $getDriver = driver::where('status_driver', 'tidak bekerja')
            ->where('penempatan', $findPegawai->kantor->jenis_kantor)
            ->first();

        // return jika tidak ada driver atau kendaraan yang tersedia
        if (!$getDriver) {
            return redirect()->back()->with('error', 'Tidak ada driver yang tersedia.');
        } else if (!$findKendaraan) {
            return redirect()->back()->with('error', 'Tidak ada kendaraan yang tersedia.');
        }

        try {
            $createData = dataApprove::create([
                'id' => Str::uuid(),
                'id_pegawai' => $request->id_pegawai,
                'id_driver' => $getDriver->id,
                'tujuan_tambang' => $request->tujuan_tambang,
                'id_kendaraan' => $findKendaraan->id,
                'approve_1' => 0,
                'approve_2' => 0,
            ]);

            return redirect()->back()->with('success', 'Berhasil menyimpan data.');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $findData = dataApprove::find($id);
        $findPegawai = pegawai::where('id_pegawai', $findData->id_pegawai)->first();
        $findKendaraan = kendaraan::where('nama_kendaraan', $request->kendaraan)
            ->where('status_pakai', 0) // 0 = tidak dipakai
            ->where('penempatan', $findPegawai->kantor->jenis_kantor)
            ->whereNotIn('service_terakhir', ['service'])
            ->whereNotIn('service_berikutnya', ['service'])
            ->first(); 
        if (!$findKendaraan) {
            return redirect()->back()->with('error', 'Tidak ada kendaraan yang tersedia.');
        }

        $getTujuan = tambang::where('id', $request->tujuanKe)->first();

        try {
            $findData->update([
                'id_kendaraan' => $findKendaraan->id ?? $findData->id_kendaraan,
                'tujuan_tambang' => $getTujuan->id ?? $findData->tujuan_tambang,
            ]);

            return redirect()->back()->with('success', 'Data berhasil di update.');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data gagal di update.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * check the specified resource from storage.
     */
    public function selesai(Request $request, string $id)
    {
        $findData = dataApprove::find($id);
        $findKendaraan = kendaraan::find($findData->id_kendaraan);
        $jarakKantorKeTambang = jarakKantorKeTambang::where('id_kantor', $findData->pegawai->kantor->id)
            ->where('id_tambang', $findData->tujuan_tambang)
            ->pluck('jarak')
            ->first();

        try {
            $bbmYangDibutuhkan = $jarakKantorKeTambang * $findData->kendaraan->konsumsi_bbm;
            $konsumsiPemakaianBbm = $findKendaraan->jumlah_bbm - $bbmYangDibutuhkan;
            $findKendaraan->update([
                'status_pakai' => 0,
                'tanggal_pakai' => Carbon::now(),
                'jumlah_bbm' => $konsumsiPemakaianBbm,
            ]);
    
            $findData->update([
                'status' => 6,
            ]);

            $findData->driver->update([
                'status_driver' => 'tidak bekerja',
            ]);

            return redirect()->back()->with('success', 'Data berhasil di seleseikan.');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data gagal di seleseikan.');
        }
    }
}
