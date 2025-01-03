<?php

namespace Database\Seeders\JarakTambang;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DataControl\jarakKantorKeTambang as jarak;

// faker
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class jarakTambangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 1,
            'id_tambang' => 1,
        ]);
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 1,
            'id_tambang' => 2,
        ]);
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 1,
            'id_tambang' => 3,
        ]);
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 1,
            'id_tambang' => 4,
        ]);
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 1,
            'id_tambang' => 5,
        ]);
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 1,
            'id_tambang' => 6,
        ]);
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 2,
            'id_tambang' => 1,
        ]);
        
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 2,
            'id_tambang' => 2,
        ]);
        
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 2,
            'id_tambang' => 3,
        ]);
        
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 2,
            'id_tambang' => 4,
        ]);
        
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 2,
            'id_tambang' => 5,
        ]);
        
        jarak::create([
            'id' => Str::uuid(),
            'jarak' => $faker->randomFloat(2, 0, 100),
            'id_kantor' => 2,
            'id_tambang' => 6,
        ]);
        
    }
}
