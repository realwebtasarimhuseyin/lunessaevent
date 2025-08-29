<?php

namespace App\Bases;

use App\Models\Favori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class FavoriBase
{
    public static function ekle($veri)
    {
        $favori = Favori::create($veri);
        return $favori;
    }

    public static function duzenle(Favori $favori, $veri)
    {
        $guncelFavori = $favori->update($veri);
        return $guncelFavori;
    }

    public static function sil(Favori $favori)
    {
        return $favori->delete();
    }
}
