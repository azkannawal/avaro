<?php

namespace Database\Seeders\Tambang;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DataControl\tambang;

use Faker\Factory as Faker;

class tambangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tambang::create([
            'nama_tambang' => 'Tambang 1',
        ]);
        tambang::create([
            'nama_tambang' => 'Tambang 2',
        ]);
        tambang::create([
            'nama_tambang' => 'Tambang 3',
        ]);
        tambang::create([
            'nama_tambang' => 'Tambang 4',
        ]);
        tambang::create([
            'nama_tambang' => 'Tambang 5',
        ]);
        tambang::create([
            'nama_tambang' => 'Tambang 6',
        ]);
    }
}
