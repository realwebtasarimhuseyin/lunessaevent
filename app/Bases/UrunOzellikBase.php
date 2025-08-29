<?php

namespace App\Bases;

use App\Models\UrunOzellik;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class UrunOzellikBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();

        return UrunOzellik::join('urun_ozellik_dil as uvd', 'urun_ozellik.id', '=', 'uvd.urun_ozellik_id')
            ->leftJoin('admin as a', 'urun_ozellik.admin_id', '=', 'a.id')
            ->select('urun_ozellik.*', 'uvd.isim', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"))
            ->where('uvd.dil', $varsayilanDil);
    }

    public static function ekle($veri)
    {
        $urunOzellik = UrunOzellik::create($veri);
        return $urunOzellik;
    }


    public static function duzenle(UrunOzellik $urunOzellik, $veri)
    {
        $guncelUrunOzellik = $urunOzellik->update($veri);
        return $guncelUrunOzellik;
    }

    public static function sil(UrunOzellik $urunOzellik)
    {
        return $urunOzellik->delete();
    }
}
