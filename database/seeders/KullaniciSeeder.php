<?php

namespace Database\Seeders;

use App\Models\Kullanici;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KullaniciSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kullanici::factory()->create();
    }
}
