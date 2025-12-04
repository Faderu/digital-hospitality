<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Poli;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@rs.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'poli_id' => null, 
        ]);
        
        $poliUmum = Poli::first(); 

        if($poliUmum) {
            User::create([
                'name' => 'Dr. Budi Santoso',
                'email' => 'dokter@rs.com',
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'poli_id' => $poliUmum->id,
            ]);
        }
    }
}