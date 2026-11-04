<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    DB::table('users')->insert([
        'name' => 'Admin MediaHub',
        'email' => 'admin@mediahub.com',
        'password' => Hash::make('password123'), // Always hash passwords!
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
}
