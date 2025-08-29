<?php

namespace App\Bases;

use App\Models\Siparis;
use Illuminate\Support\Facades\DB;

class SiparisBase
{
    public static function veriIsleme()
    {

        return Siparis::with(['siparisUrun', 'kullanici']) // Kullanıcı ve ürün ilişkilerini dahil et
            ->select(
                'id',
                'kullanici_id',
                'indirim_tutar',
                'created_at',
                'updated_at'
            )
            ->map(function ($siparis) {
                // Toplam fiyat hesaplama
                $toplamBirimFiyat = $siparis->siparisUrun->sum('birim_fiyat');
                $siparis->toplam_tutar = $toplamBirimFiyat - ($siparis->indirim_tutar ?? 0);
                return $siparis;
            });

    }

    public static function ekle($veri)
    {
        $Siparis = Siparis::create($veri);
        return $Siparis;
    }


    public static function duzenle(Siparis $Siparis, $veri)
    {
        $guncelSiparis = $Siparis->update($veri);
        return $guncelSiparis;
    }

    public static function sil(Siparis $Siparis)
    {
        return $Siparis->delete();
    }
}
