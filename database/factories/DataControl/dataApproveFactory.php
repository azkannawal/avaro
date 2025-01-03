<?php

namespace Database\Factories\DataControl;

use Illuminate\Database\Eloquent\Factories\Factory;

// Call Models
use App\Models\Kendaraan\kendaraan;
use App\Models\Kendaraan\driver;
use App\Models\Pegawai\pegawai;

// Str
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataControl\dataApprove>
 */
class dataApproveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $getPegawai = pegawai::all()->pluck('id_pegawai')->toArray();
        $getDriver = driver::all()->pluck('id')->toArray();
        $getKendaraan = kendaraan::all()->pluck('id')->toArray();
        $tujuan_tambang = ['1', '2', '3', '4', '5', '6'];
        $approve_1 = rand(0, 1);
        $approve_2 = rand(0, 1);

        $randomDate = $this->faker->dateTimeBetween('-1 years', 'now');
        // check approve_1 true or false
        if ($approve_1 == 1) {
            $approve_1_at = $randomDate;
        } else {
            $approve_1_at = null;
        }

        // check approve_2 true or false
        if ($approve_2 == 1) {
            $approve_2_at = $randomDate;
        } else {
            $approve_2_at = null;
        }

        if ($approve_1 == 0 && $approve_2 == 0) {
            $status = 1 ?? 5;
        } elseif ($approve_1 == 1 && $approve_2 == 0) {
            $status = 2 ?? 3;
        } elseif ($approve_1 == 1 && $approve_2 == 1) {
            $status = 4 ?? 6;
        } else {
            $status = 6;
        }

        return [
            'id' => Str::uuid(),
            'id_pegawai' => $this->faker->randomElement($getPegawai),
            'id_driver' => $this->faker->randomElement($getDriver),
            'id_kendaraan' => $this->faker->randomElement($getKendaraan),
            'tujuan_tambang' => $this->faker->randomElement($tujuan_tambang),
            'approve_1' => $approve_1,
            'approve_1_at' => $approve_1_at,
            'approve_2' => $approve_2,
            'approve_2_at' => $approve_2_at,
            'status' => $status,
        ];
    }
}
