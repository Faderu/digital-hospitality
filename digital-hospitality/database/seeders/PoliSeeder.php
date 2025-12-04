<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poli;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        Poli::create([
            'name' => 'Poli Umum',
            'description' => 'Layanan kesehatan umum untuk berbagai keluhan ringan.',
            'icon' => null,
        ]);
    }
}