<?php

namespace App\Bases;

use App\Models\UrunKategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class UrunKategoriBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();

        return UrunKategori::join('urun_kategori_dil as ukd', 'urun_kategori.id', '=', 'ukd.urun_kategori_id')
            ->leftJoin('admin as a', 'urun_kategori.admin_id', '=', 'a.id')
            ->select(
                'urun_kategori.*',
                'ukd.isim',
                DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"),
                DB::raw("(
                    SELECT COUNT(u.id) 
                    FROM urun as u
                    WHERE u.urun_kategori_id = urun_kategori.id
                    ) 
                as toplam_urun")
            )
            ->where('ukd.dil', $varsayilanDil)
            ->orderBy('urun_kategori.sira_no', 'asc');
    }

    public static function ekle($veri)
    {
        $urunKategori = UrunKategori::create($veri);
        return $urunKategori;
    }


    public static function duzenle(UrunKategori $urunKategori, $veri)
    {
        $guncelUrunKategori = $urunKategori->update($veri);
        return $guncelUrunKategori;
    }

    public static function sil(UrunKategori $urunKategori)
    {
        return $urunKategori->delete();
    }
}
