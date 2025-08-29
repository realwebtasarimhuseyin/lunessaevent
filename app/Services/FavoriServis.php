<?php

namespace App\Services;

use App\Models\Favori;
use App\Bases\FavoriBase;
use App\Models\FavoriDil;
use App\Models\FavoriUrunVaryant;
use App\Models\Urun;
use App\Models\UrunVaryantOzellik;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FavoriServis
{
    public static function veriAlma()
    {
        $builder = FavoriBase::veriIsleme();
        return $builder;
    }

    public static function duzenle($veri)
    {
        try {
            return DB::transaction(function () use ($veri) {

                FavoriBase::ekle($veri);

            });
        } catch (\Throwable $th) {
            throw new \Exception('Favori kayıt edilemedi: ' . $th->getMessage());
        }
    }


    public static function sil(Favori $favori)
    {
        try {
            return DB::transaction(function () use ($favori) {
                FavoriBase::sil($favori);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Favori silinemedi: ' . $th->getMessage());
        }
    }
}
