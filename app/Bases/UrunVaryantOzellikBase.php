<?php

namespace App\Bases;

use App\Models\UrunVaryantOzellik;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class UrunVaryantOzellikBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();

        return UrunVaryantOzellik::join('urun_varyant_ozellik_dil as uvod', 'urun_varyant_ozellik.id', '=', 'uvod.urun_varyant_ozellik_id')
        ->leftJoin('admin as a', 'urun_varyant_ozellik.admin_id', '=', 'a.id')
        ->leftJoin('urun_varyant as uv', 'urun_varyant_ozellik.urun_varyant_id', '=', 'uv.id')
        ->leftJoin('urun_varyant_dil as uvd', 'uv.id', '=', 'uvd.urun_varyant_id')
        ->select('urun_varyant_ozellik.*', 'uvod.isim', 'uvd.isim as varyant', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"))
        ->where('uvod.dil', $varsayilanDil)
        ->where('uvd.dil', $varsayilanDil);
    
    }

    public static function ekle($veri)
    {
        $urunVaryantOzellik = UrunVaryantOzellik::create($veri);
        return $urunVaryantOzellik;
    }


    public static function duzenle(UrunVaryantOzellik $urunVaryantOzellik, $veri)
    {
        $guncelUrunVaryantOzellik = $urunVaryantOzellik->update($veri);
        return $guncelUrunVaryantOzellik;
    }

    public static function sil(UrunVaryantOzellik $urunVaryantOzellik)
    {
        return $urunVaryantOzellik->delete();
    }
}
