<?php

namespace App\Bases;

use App\Models\KatalogKategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class KatalogKategoriBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();

        return KatalogKategori::join('katalog_kategori_dil as ukd', 'katalog_kategori.id', '=', 'ukd.katalog_kategori_id')
            ->leftJoin('admin as a', 'katalog_kategori.admin_id', '=', 'a.id')
            ->select(
                'katalog_kategori.*',
                'ukd.isim',
                DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"),
                DB::raw("(
                    SELECT COUNT(u.id) 
                    FROM katalog as u
                    WHERE u.katalog_kategori_id = katalog_kategori.id
                    ) 
                as toplam_katalog")
            )
            ->where('ukd.dil', $varsayilanDil)
            ->orderBy('katalog_kategori.sira_no', 'asc');
    }

    public static function ekle($veri)
    {
        $katalogKategori = KatalogKategori::create($veri);
        return $katalogKategori;
    }


    public static function duzenle(KatalogKategori $katalogKategori, $veri)
    {
        $guncelKatalogKategori = $katalogKategori->update($veri);
        return $guncelKatalogKategori;
    }

    public static function sil(KatalogKategori $katalogKategori)
    {
        return $katalogKategori->delete();
    }
}
