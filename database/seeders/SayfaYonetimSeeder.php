<?php

namespace Database\Seeders;

use App\Models\SayfaYonetim;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SayfaYonetimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sayafalar = [
            ["sayfa_baslik" => "hakkimizda", "resim_izin" => true],
            ["sayfa_baslik" => "gizlilik-politikasi", "resim_izin" => false],
            ["sayfa_baslik" => "mesafeli-satis", "resim_izin" => false],
            ["sayfa_baslik" => "iade-politikasi", "resim_izin" => false],
            ["sayfa_baslik" => "teslimat-kosullari", "resim_izin" => false],
            ["sayfa_baslik" => "kvkk", "resim_izin" => false],
            ["sayfa_baslik" => "misyon", "resim_izin" => true],
            ["sayfa_baslik" => "vizyon", "resim_izin" => true],
        ];


        foreach ($sayafalar as $sayfa) {
            SayfaYonetim::create([
                "slug" => $sayfa["sayfa_baslik"],
                "resim_izin" => $sayfa["resim_izin"],
                "durum" => false
            ]);
        }
    }
}
