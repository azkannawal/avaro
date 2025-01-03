<?php

namespace Database\Factories\Kendaraan;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class driverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'nama_driver' => $this->faker->name(),
            'status_driver' => $this->faker->randomElement(['sedang bekerja', 'tidak bekerja']),
            'penempatan' => $this->faker->randomElement(['utama', 'cabang']),
        ];
    }
}
