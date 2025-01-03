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

class approveAsService extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getData = dataApprove::where('approve_1', 1)->where('status', 3)->get();
        $getKendaraan = kendaraan::where('service_berikutnya', 'service')->where('service_terakhir', 'service')->get();        

        $getData = $getData->merge($getKendaraan);
        // cek kendaraan perlu di service atau isi bbm
        for ($i=0; $i < count($getData); $i++) { 
            if ($getData[$i]->service_berikutnya == 'service' && $getData[$i]->service_terakhir == 'service') {
                $requestKendaraan[$i] = 1;
            }
            elseif ($getData[$i]->status == 3) {
                $requestKendaraan[$i] = 2;
            }
        }
        
        if (count($getData) == 0) {
            $requestKendaraan = null;
        }
        
        return view('components.'.auth()->user()->getRole->nama_role. '.DataControl.approveAsService', 
            compact (
                'getData', 
                'requestKendaraan'
            ));
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
                'status' => 2,
            ]);

            // update data kendaraan
            $findData->kendaraan->update([
                'jumlah_bbm' => $fullTank,
            ]);
            return redirect()->back()->with('success', 'BBM berhasil di isi');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'BBM gagal di isi');
        }
    }

    /**
     * Ganti Kendaraan Dan Service data
     */
    public function service(Request $request, string $id)
    {
        $findData = kendaraan::find($id);

        try {
            // update data
            $findData->update([
                'service_terakhir' => Carbon::now(),
                'service_berikutnya' => Carbon::now()->addYear(1),
            ]);
            return redirect()->back()->with('success', 'Kendaran berhasil diservice');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Kendaran gagal diservice');
        }
    }
}
