<?php

namespace Database\Factories\Pegawai;

use Illuminate\Database\Eloquent\Factories\Factory;

// Call Models
use App\Models\Pegawai\pegawai;

use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai\pegawai>
 */
class pegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id_pegawai = 'P' . $this->faker->randomNumber(6, true);
        
        // solved duplicate id_pegawai
        while (true) {
            $cek = pegawai::where('id_pegawai', $id_pegawai)->first();
            if ($cek == null) {
                break;
            }
            $id_pegawai = 'P' . $this->faker->randomNumber(6, true);
        }

        return [
            'id' => Str::uuid(), 
            'id_pegawai' => $id_pegawai,
            'nama_pegawai' => $this->faker->name(),
            'penempatan' => $this->faker->randomElement([1,2]),
            'jabatan' => $this->faker->randomElement(['manager', 'supervisor', 'staff']),
        ];
    }
}
