<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@jewelry.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
                'google_id' => null,
                'avatar' => null,
                'phone' => '081234567890',
                'address' => 'Admin Address',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@jewelry.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'customer',
                'google_id' => null,
                'avatar' => null,
                'phone' => '089876543210',
                'address' => 'Customer Address',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}