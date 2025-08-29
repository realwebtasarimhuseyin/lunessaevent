<?php

namespace App\Bases;

use App\Models\Urun;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class UrunBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = Config::get('app.locale');
        return Urun::join('urun_dil as ud', 'urun.id', '=', 'ud.urun_id')
            ->leftJoin('admin as a', 'urun.admin_id', '=', 'a.id')
            ->select(
                'urun.*',
                'ud.baslik',
                'ud.icerik',
                'ud.slug',
                DB::raw("CONCAT(a.isim, ' ', a.soyisim) as yazar"),
                DB::raw("(
                    SELECT COUNT(s.id) 
                    FROM sepet as s 
                    WHERE s.urun_id = urun.id
                ) as sepet_urun_sayisi")
            )
            ->where('ud.dil', $varsayilanDil); // Burada 'sira_no' alanına göre sıralama yapıyoruz
    }

    public static function ekle($veri)
    {
        try {
            $urun = Urun::create($veri);
            return $urun;
        } catch (\Exception $e) {
            throw new \Exception("Ürün eklenemedi: " . $e->getMessage());
        }
    }

    public static function duzenle(Urun $urun, $veri)
    {
        try {
            $urun->update($veri);
            return $urun->refresh();
        } catch (\Exception $e) {
            throw new \Exception("Ürün güncellenemedi: " . $e->getMessage());
        }
    }

    public static function sil(Urun $urun)
    {
        try {
            return $urun->delete();
        } catch (\Exception $e) {
            throw new \Exception("Ürün silinemedi: " . $e->getMessage());
        }
    }
}
