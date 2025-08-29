<?php

namespace App\Bases;

use App\Models\ProjeKategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class ProjeKategoriBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();

        return ProjeKategori::join('proje_kategori_dil as pkd', 'proje_kategori.id', '=', 'pkd.proje_kategori_id')
            ->leftJoin('admin as a', 'proje_kategori.admin_id', '=', 'a.id')
            ->select(
                'proje_kategori.*',
                'pkd.isim',
                DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"),
                DB::raw("(
                    SELECT COUNT(p.id) 
                    FROM proje as p
                    WHERE p.proje_kategori_id = proje_kategori.id
                    ) 
                as toplam_proje")
            )
            ->where('pkd.dil', $varsayilanDil)
            ->orderBy('proje_kategori.sira_no', 'asc');
    }

    public static function ekle($veri)
    {
        $projeKategori = ProjeKategori::create($veri);
        return $projeKategori;
    }


    public static function duzenle(ProjeKategori $projeKategori, $veri)
    {
        $guncelProjeKategori = $projeKategori->update($veri);
        return $guncelProjeKategori;
    }

    public static function sil(ProjeKategori $projeKategori)
    {
        return $projeKategori->delete();
    }
}
