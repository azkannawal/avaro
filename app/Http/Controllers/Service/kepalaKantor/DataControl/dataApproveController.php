<?php

namespace App\Http\Controllers\Service\kepalaKantor\DataControl;

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
        $getData = dataApprove::where('approve_2', 0)->where('status', 2)->get();
        $getJenisKendaraan = kendaraan::pluck('nama_kendaraan', 'id')->unique();
        
        // Start Control kendaraan
            for ($i=0; $i < count($getData); $i++) { 
                // get jarak kantor ke tambang
                $jarakKantorKeTambang[] = jarakKantorKeTambang::where('id_kantor', $getData[$i]->pegawai->penempatan)
                    ->where('id_tambang', $getData[$i]->tujuan_tambang)
                    ->pluck('jarak')
                    ->first();

                // hitung bbm yang dibutuhkan
                $jumlahBbm[] = $getData[$i]->kendaraan->jumlah_bbm;
                $jumlahKonsumsiBbm[] = $getData[$i]->kendaraan->konsumsi_bbm;
                $bbmYangDibutuhkan[] = $jarakKantorKeTambang[$i] * $jumlahKonsumsiBbm[$i];

                // inisialisasi cek bbm
                if ($jumlahBbm[$i] < $bbmYangDibutuhkan[$i]) {
                    $cekBbm[] = 'BBM kurang '. $bbmYangDibutuhkan[$i] - $jumlahBbm[$i] .' liter';
                } 
                else{
                    $cekBbm[] = 'BBM cukup';
                }

                // hitung berpa bulan atau hari lagi untuk service berikutnya
                $hitungHari = Carbon::parse($getData[$i]->kendaraan->service_berikutnya)->diffInDays(Carbon::now());
                $hitungBulan = Carbon::parse($getData[$i]->kendaraan->service_berikutnya)->diffInMonths(Carbon::now());
                $serviceBerikutnya[] = 1;
                // jika service berikutnya kurang dari 7 hari
                if ($hitungHari < 7) {
                    $serviceBerikutnya[$i] = 2;
                }
                // jika service berikutnya kurang dari 1 bulan
                elseif ($hitungBulan < 1) {
                    $serviceBerikutnya[$i] = $hitungHari;
                }
            }
        // End Control kendaraan
        // jika data kosong 
        if (count($getData) == 0) {
            $getData = collect([]);
            $jarakKantorKeTambang = null;
            $jumlahBbm = null;
            $jumlahKonsumsiBbm = null;
            $bbmYangDibutuhkan = null;
            $cekBbm = null;
            $serviceBerikutnya = null;
        }
        // dd($getData, $jarakKantorKeTambang, $jumlahBbm, $jumlahKonsumsiBbm, $bbmYangDibutuhkan, $cekBbm, $serviceBerikutnya);
        return view('components.'.auth()->user()->getRole->nama_role. '.DataControl.dataApprove', 
            compact (
                'getData', 
                'jarakKantorKeTambang', 
                'jumlahBbm', 
                'jumlahKonsumsiBbm', 
                'bbmYangDibutuhkan',
                'cekBbm',
                'serviceBerikutnya',
                'getJenisKendaraan'
            ));
    }

    /**
     * Approve data
     */
    public function approve(Request $request, string $id)
    {
        $findData = dataApprove::find($id);

        // cek kondisi kendaraan dan bbm
        if ($request->kondisKendaraan == 'Segera Service Kendaraan') {
            return redirect()->back()->with('error', 'Kendaraan dalam masa service, segera hubungi bagian service');
        }
        elseif ($request->cekBbm != 'BBM cukup') {
            return redirect()->back()->with('error', 'BBM kurang, segera hubungi bagian pengisian BBM');
        }

        if ($findData->approve_1 == 0) {
            return redirect()->back()->with('error', 'Data belum di approve oleh bagian pool');
        }

        try {
            // update data approve
            $findData->update([
                'approve_2' => 1,
                'approve_2_at' => Carbon::now(),
                'status' => 4,
            ]);

            // update status kendaraan
            $findData->kendaraan->update([
                'status_pakai' => 1,
                'tanggal_pakai' => 'Kendaraan sedang dipakai',
            ]);

            // update driver
            $findData->driver->update([
                'status_driver' => 'sedang bekerja',
            ]);

            return redirect()->route('kepalaKantor.data-approve.index')->with('success', 'Data berhasil di approve');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data gagal di approve');
        }
    }

    /**
     * Reject data
     */
    public function reject(Request $request, string $id)
    {
        $findData = dataApprove::find($id);

        try {
            // update data
            $findData->update([
                'status' => 5,
            ]);
            return redirect()->back()->with('success', 'Data berhasil di reject');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data gagal di reject');
        }
    }
}
