<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('users')->insert([
            'nama_lengkap' => 'Admin LaptoPedia',
            'email' => 'admin@laptoppedia.com',
            'password' => Hash::make('password123'), 
            'role' => 'admin',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Bandar Lampung No. 1',
        ]);
        
    }
}