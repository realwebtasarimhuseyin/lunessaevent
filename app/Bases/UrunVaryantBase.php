<?php

namespace App\Bases;

use App\Models\UrunVaryant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class UrunVaryantBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();

        return UrunVaryant::join('urun_varyant_dil as uvd', 'urun_varyant.id', '=', 'uvd.urun_varyant_id')
            ->leftJoin('admin as a', 'urun_varyant.admin_id', '=', 'a.id')
            ->select('urun_varyant.*', 'uvd.isim', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"))
            ->where('uvd.dil', $varsayilanDil);
    }

    public static function ekle($veri)
    {
        $urunVaryant = UrunVaryant::create($veri);
        return $urunVaryant;
    }


    public static function duzenle(UrunVaryant $urunVaryant, $veri)
    {
        $guncelUrunVaryant = $urunVaryant->update($veri);
        return $guncelUrunVaryant;
    }

    public static function sil(UrunVaryant $urunVaryant)
    {
        return $urunVaryant->delete();
    }
}
