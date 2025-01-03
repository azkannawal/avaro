<?php

namespace Database\Factories\Kendaraan;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kendaraan\kendaraan>
 */
class kendaraanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaKendaraanTambang = [
            'Excavator',
            'Bulldozer',
            'Dump Truck',
            'Wheel Loader',
            'Motor Grader',
            'Vibro Roller',
            'Crane',
            'Forklift',
            'Trailer',
            'Low Bed',
            'Tronton',
        ];

        $namaKendaraanPenumpang = [
            'Bus',
            'Mobil',
        ];

        $getKendaraan = $this->faker->randomElement([$namaKendaraanTambang, $namaKendaraanPenumpang]);
        $namaKendaraan = $getKendaraan == $namaKendaraanTambang ? $getKendaraan[array_rand($getKendaraan)] : $getKendaraan[array_rand($getKendaraan)];
        $jenisKendaraan = $getKendaraan == $namaKendaraanTambang ? 'kendaraan tambang' : 'kendaraan penumpang';
        $platNomor = 'N ' . $this->faker->randomNumber(4) . ' ' . $this->faker->randomLetter() . $this->faker->randomLetter();

        $statusPakai = $this->faker->randomElement([1, 0]);
        $tanggalPakai = $statusPakai == 1 ? 'Kendaraan sedang dipakai' : $this->faker->dateTimeBetween('-5 month', 'now');

        $serviceTerakhir = $this->faker->dateTimeBetween('-3 month', 'now');
        $serviceBerikutnya = $this->faker->dateTimeBetween($serviceTerakhir, '+1 years');

        $konsumsiBbm = $getKendaraan == $namaKendaraanTambang ? 1.5 : 7;
        $fullTank = $getKendaraan == $namaKendaraanTambang ? 800 : 400;
        return [
            'id' => Str::uuid(),
            'nama_kendaraan' => $namaKendaraan,
            'jenis_kendaraan' => $jenisKendaraan,
            'plat_nomor' => $platNomor,
            'jumlah_bbm' => $this->faker->randomFloat(2, 50, 300),
            'konsumsi_bbm' => $konsumsiBbm,
            'full_tank' => $fullTank,
            'status_kendaraan' => $this->faker->randomElement([1, 2]),
            'status_pakai' => $statusPakai,
            'service_terakhir' => $serviceTerakhir,
            'service_berikutnya' => $serviceBerikutnya,
            'penempatan' => $this->faker->randomElement(['utama', 'cabang']),
            'tanggal_pakai' => $tanggalPakai,
        ];
    }
}
