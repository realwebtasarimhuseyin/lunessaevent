<?php

namespace App\Services;

use App\Models\Kullanici;
use App\Bases\KullaniciBase;
use App\Models\KullaniciIndirim;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KullaniciServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = KullaniciBase::veriIsleme();
        return $builder;
    }

    public static function tekliVeri($kullaniciId)
    {
        $builder = KullaniciBase::veriIsleme();
        $builder->where("k.id", $kullaniciId)->first();
    }

    public static function ekle($veri)
    {
        try {
            return DB::transaction(function () use ($veri) {
                KullaniciBase::ekle($veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Kullanici kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Kullanici $kullanici, $veri, $request = null)
    {
        try {
            return DB::transaction(function () use ($kullanici, $veri, $request) {

                if ($request) {
                    $kategoriIndirimler = $request->input('kategoriIndirimler', []);
                    $gelenKategoriIdleri = array_keys($kategoriIndirimler);
                    $mevcutKategoriler = KullaniciIndirim::where("kullanici_id", $kullanici->id)
                        ->pluck("urun_kategori_id")
                        ->toArray();

                    foreach ($kategoriIndirimler as $key => $indirim) {
                        if (!empty($indirim)) {
                            KullaniciIndirim::updateOrCreate(
                                [
                                    "kullanici_id" => $kullanici->id,
                                    "urun_kategori_id" => $key
                                ],
                                [
                                    "deger" => $indirim
                                ]
                            );
                        }
                    }

                    $silinmesiGerekenler = array_diff($mevcutKategoriler, $gelenKategoriIdleri);

                    if (!empty($silinmesiGerekenler)) {
                        KullaniciIndirim::where("kullanici_id", $kullanici->id)
                            ->whereIn("kullanici_indirim_id", $silinmesiGerekenler)
                            ->delete();
                    }
                }

                KullaniciBase::duzenle($kullanici, $veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Kullanici düzenlenemedi : ' . $th->getMessage());
        }
    }
    public static function sil(Kullanici $kullanici)
    {
        try {
            return DB::transaction(function () use ($kullanici) {
                KullaniciBase::sil($kullanici);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Kullanici silinemedi : ' . $th->getMessage());
        }
    }
}
