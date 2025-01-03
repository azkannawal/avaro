<?php

namespace Database\Seeders\Account;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Account\role;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        role::create([
            'nama_role' => 'superAdmin',
            'message' => 'Super Admin',
        ]);

        role::create([
            'nama_role' => 'admin',
            'message' => 'Admin',
        ]);

        role::create([
            'nama_role' => 'kepalaKantor',
            'message' => 'Kepala Kantor',
        ]);

        role::create([
            'nama_role' => 'pool',
            'message' => 'Pool',
        ]);

        role::create([
            'nama_role' => 'service',
            'message' => 'Service',
        ]);
    }
}
