<?php

namespace Database\Seeders\Account;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Account\account;

use Illuminate\Support\Str;

class accountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        account::create([
            'id' => Str::uuid(),
            'name' => 'Developer',
            'email' => 'dev@example.com',
            'password' => bcrypt('dev12345'),
            'role' => 1,
        ]);

        account::create([
            'id' => Str::uuid(),
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 2,
        ]);

        account::create([
            'id' => Str::uuid(),
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('password123'),
            'role' => 3,
        ]);

        account::create([
            'id' => Str::uuid(),
            'name' => 'SPV',
            'email' => 'spv@example.com',
            'password' => bcrypt('password123'),
            'role' => 4,
        ]);

        account::create([
            'id' => Str::uuid(),
            'name' => 'Service',
            'email' => 'service@example.com',
            'password' => bcrypt('12345678'),
            'role' => 5,
        ]);
    }
}
