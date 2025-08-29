<?php

namespace App\Bases;

use App\Models\UrunAltKategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class UrunAltKategoriBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();

        return UrunAltKategori::join('urun_alt_kategori_dil as uakd', 'urun_alt_kategori.id', '=', 'uakd.urun_alt_kategori_id')
            ->leftJoin('admin as a', 'urun_alt_kategori.admin_id', '=', 'a.id')
            ->leftJoin('urun_kategori as uk', 'urun_alt_kategori.urun_kategori_id', '=', 'uk.id')
            ->leftJoin('urun_kategori_dil as ukd', 'uk.id', '=', 'ukd.urun_kategori_id')
            ->select('urun_alt_kategori.*', 'uakd.isim', 'ukd.isim as kategori', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"))
            ->where('uakd.dil', $varsayilanDil)
            ->where('ukd.dil', $varsayilanDil);
    }

    public static function ekle($veri)
    {
        $urunAltKategori = UrunAltKategori::create($veri);
        return $urunAltKategori;
    }


    public static function duzenle(UrunAltKategori $urunAltKategori, $veri)
    {
        $guncelUrunAltKategori = $urunAltKategori->update($veri);
        return $guncelUrunAltKategori;
    }

    public static function sil(UrunAltKategori $urunAltKategori)
    {
        return $urunAltKategori->delete();
    }
}
