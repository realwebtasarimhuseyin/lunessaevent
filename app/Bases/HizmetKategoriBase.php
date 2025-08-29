<?php

namespace App\Bases;

use App\Models\HizmetKategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class HizmetKategoriBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = App::getLocale();

        return HizmetKategori::join('hizmet_kategori_dil as hkd', 'hizmet_kategori.id', '=', 'hkd.hizmet_kategori_id')
            ->leftJoin('admin as a', 'hizmet_kategori.admin_id', '=', 'a.id')
            ->select(
                'hizmet_kategori.*',
                'hkd.isim',
                DB::raw("CONCAT(a.isim, ' ', a.soyisim) as ekliyen_kullanici"),
                DB::raw("(
                    SELECT COUNT(h.id) 
                    FROM hizmet as h
                    WHERE h.hizmet_kategori_id = hizmet_kategori.id
                    ) 
                as toplam_hizmet")
            )
            ->where('hkd.dil', $varsayilanDil)
            ->orderBy('hizmet_kategori.sira_no', 'asc');
    }

    public static function ekle($veri)
    {
        $hizmetKategori = HizmetKategori::create($veri);
        return $hizmetKategori;
    }


    public static function duzenle(HizmetKategori $hizmetKategori, $veri)
    {
        $guncelHizmetKategori = $hizmetKategori->update($veri);
        return $guncelHizmetKategori;
    }

    public static function sil(HizmetKategori $hizmetKategori)
    {
        return $hizmetKategori->delete();
    }
}
