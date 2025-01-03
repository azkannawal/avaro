<?php

namespace App\Http\Controllers\Service\superAdmin\DataControl;

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

class approveAsPool extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getData = dataApprove::where('approve_1', 0)->where('status', 1)->get();
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
        return view('components.'.auth()->user()->getRole->nama_role. '.DataControl.approveAsPool', 
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

        try {
            // update data
            $findData->update([
                'approve_1' => 1,
                'approve_1_at' => Carbon::now(),
                'status' => 2,
            ]);
            return redirect()->route('superAdmin.data-approve.index')->with('success', 'Data berhasil di approve');
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

    /**
     * Isi BBM data
     */
    public function isiBbm(Request $request, string $id)
    {
        $findData = dataApprove::find($id);

        $jumlahBbm = $findData->kendaraan->jumlah_bbm;
        $fullTank = $findData->kendaraan->full_tank;
        if ($jumlahBbm == $fullTank) {
            return redirect()->back()->with('error', 'BBM sudah penuh');
        }

        try {
            // update data
            $findData->update([
                'approve_1' => 1,
                'approve_1_at' => Carbon::now(),
                'status' => 3,
            ]);
            return redirect()->route('superAdmin.data-approve.index')->with('success', 'Data berhasil di approve');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data gagal di approve');
        }
    }

    /**
     * Ganti Kendaraan Dan Service data
     */
    public function gantiService(Request $request, string $id)
    {
        $findData = dataApprove::find($id);

        // Start Service Kendaraan
            if ($request->serviceBerikutnya != 1) {
                $findData->kendaraan->update([
                    'service_terakhir' => 'service',
                    'service_berikutnya' => 'service',
                ]);
                $message = 'Service';
            } else {
                $message = null;
            }
        // End Service Kendaraan
        // Start Ganti Kendaraan
            if ($request->namaKendaraan == $findData->kendaraan->nama_kendaraan) {
                // cari kendaraan selain kendaraan yang dipakai
                $findNewKendaraan = kendaraan::whereNotIn('id',[$findData->kendaraan->id])
                    ->where('nama_kendaraan', $request->namaKendaraan)
                    ->where('status_pakai', 0)
                    ->where('penempatan', $findData->pegawai->kantor->jenis_kantor)
                    ->whereNotIn('service_terakhir', ['service'])
                    ->whereNotIn('service_berikutnya', ['service'])
                ->first();
            }
            else {
                $findNewKendaraan = kendaraan::where('nama_kendaraan', $request->namaKendaraan)
                    ->where('status_pakai', 0)
                    ->where('penempatan', $findData->pegawai->kantor->jenis_kantor)
                    ->whereNotIn('service_terakhir', ['service'])
                    ->whereNotIn('service_berikutnya', ['service'])
                ->first();
            }
            if ($findData->id_kendaraan == $findNewKendaraan->id) {
                return redirect()->back()->with('error', 'Gagal mengganti kendaraan, kendaraan yang dipilih sama dengan kendaraan yang dipakai');
            }
        // End Ganti Kendaraan

        try {
            // update data
            $findData->update([
                'id_kendaraan' => $findNewKendaraan->id,
            ]);
            return redirect()->back()->with('success', $message == null ? 'Kendaran berhasil diganti menjadi '. $findNewKendaraan->nama_kendaraan : 'Kendaran berhasil diganti menjadi '. $findNewKendaraan->nama_kendaraan .' dan '. $message);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
