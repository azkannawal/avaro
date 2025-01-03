<?php

namespace App\Exports\superAdmin;

use App\Models\DataControl\dataApprove;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Carbon\Carbon;

class dataApproveExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $dataApproves = dataApprove::all();
        $result = [];

        foreach ($dataApproves as $dataApprove) {
            $status = '';

            if ($dataApprove->status == 1) {
                $status = 'Menunggu Pool';
            } elseif ($dataApprove->status == 2) {
                $status = 'Menunggu Kepala Kantor';
            } elseif ($dataApprove->status == 3) {
                $status = 'Menunggu Pengisian BBM';
            } elseif ($dataApprove->status == 4) {
                $status = 'Approve';
            } elseif ($dataApprove->status == 5) {
                $status = 'Reject';
            } elseif ($dataApprove->status == 6) {
                $status = 'Selesai';
            }

            $result[] = [
                'id_pegawai' => $dataApprove->id_pegawai,
                'nama_pegawai' => $dataApprove->pegawai->nama_pegawai,
                'kantor' => $dataApprove->pegawai->kantor->nama_kantor,
                'tujuan_tambang' => $dataApprove->tujuan->nama_tambang,
                'nama_kendaraan' => $dataApprove->kendaraan->nama_kendaraan,
                'jenis_kendaraan' => $dataApprove->kendaraan->jenis_kendaraan,
                'plat_nomor' => $dataApprove->kendaraan->plat_nomor,
                'driver' => $dataApprove->driver->nama_driver,
                'approve_1' => $dataApprove->approve_1 == 1 ? Carbon::parse($dataApprove->updated_at)->format('Y-M-d') : '-',
                'approve_2' => $dataApprove->approve_2 == 1 ? Carbon::parse($dataApprove->updated_at)->format('Y-M-d') : '-',
                'status' => $status,
            ];
        }

        return collect($result);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Pegawai',
            'Nama Pegawai',
            'Kantor',
            'Tujuan Tambang',
            'Nama Kendaraan',
            'Jenis Kendaraan',
            'Plat Nomor',
            'Driver',
            'Approve 1',
            'Approve 2',
            'Status',
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Data Pegawai';
    }

}
