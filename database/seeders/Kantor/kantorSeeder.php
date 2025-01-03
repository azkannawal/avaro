<?php

namespace Database\Seeders\Kantor;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DataControl\kantor;

class kantorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        kantor::create([
            'nama_kantor' => 'Kantor Utama',
            'jenis_kantor' => 'utama',
        ]);
        kantor::create([
            'nama_kantor' => 'Kantor Cabang',
            'jenis_kantor' => 'cabang',
        ]);
    }
}
