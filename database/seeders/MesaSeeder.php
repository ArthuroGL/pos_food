<?php

namespace Database\Seeders;

use App\Models\Mesa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesaSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 12; $i++) {
            Mesa::create(['nombre' => 'Mesa ' . $i]);
        }
    }
}
