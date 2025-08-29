<?php

namespace App\Bases;

use App\Models\Galeri;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class GaleriBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();

        return Galeri::join('galeri_dil as gd', 'galeri.id', '=', 'gd.galeri_id')
            ->leftJoin('admin as a', 'galeri.admin_id', '=', 'a.id')
            ->select('galeri.*', 'gd.baslik', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"))
            ->where('gd.dil', $varsayilanDil);
    }

    public static function ekle($veri)
    {
        $galeri = Galeri::create($veri);
        return $galeri;
    }


    public static function duzenle(Galeri $galeri, $veri)
    {
        $guncelGaleri = $galeri->update($veri);
        return $guncelGaleri;
    }

    public static function sil(Galeri $galeri)
    {
        return $galeri->delete();
    }
}
