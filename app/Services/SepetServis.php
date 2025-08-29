<?php

namespace App\Services;

use App\Helper\FacebookConversionHelper;
use App\Models\Sepet;
use App\Bases\SepetBase;
use App\Models\SepetUrunVaryant;
use App\Models\Urun;
use App\Models\UrunVaryantOzellik;
use App\Models\UrunVaryantSecim;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\FacebookConversionServis;

class SepetServis
{
    public static function veriAlma()
    {
        return SepetBase::veriIsleme();
    }

    public static function duzenle($veri)
    {
        try {
            return DB::transaction(function () use ($veri) {
                $mevcutSepet = session()->get('sepet', []);
                $locale = app()->getLocale();

                foreach ($veri['urunler'] as $urun) {
                    self::sepetUrunuIsle($urun, $mevcutSepet, $locale);
                }

                session()->put('sepet', $mevcutSepet);

                if (Auth::check()) {
                    $veri["kullanici_id"] = Auth::id();
                    self::veritabaninaKaydet($veri);
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    private static function sepetUrunuIsle($urun, &$mevcutSepet, $locale)
    {
        $varyantliUrun = false;
        $urunVaryantlar = !empty($urun['varyantlar']) ? array_map('intval', $urun['varyantlar']) : [];

        sort($urunVaryantlar);

        $urunDetay = Urun::firstWhere('id', $urun['id']);
        $urunDilVerisi = dilVerisi($urunDetay, 'urunDiller')->first();

        if (!empty($urunDetay->secilenVaryatlar) && count($urunDetay->secilenVaryatlar) > 0) {

            $varyantSecimKontrol = UrunVaryantSecim::where('urun_id', $urun['id'])
                ->whereJsonContains('urun_varyantlar', array_map('strval', $urunVaryantlar))->first();

            if (empty($urunVaryantlar) || !$varyantSecimKontrol) {
                throw new \Exception("Seçtiğiniz Ürün Geçersiz !");
            }

            $varyantliUrun = true;
        }

        $urunKey = self::mevcutUrunuBul($mevcutSepet, $urun, $urunVaryantlar);
        $varyantlar = self::varyantBilgileriGetir($urunVaryantlar, $locale);

        if (($varyantliUrun && $varyantSecimKontrol && $varyantSecimKontrol->stok_adet >= $urun["adet"]) || (!$varyantliUrun && $urunDetay->stok_adet >= $urun["adet"])) {


            if ($urunKey !== null) {
                $mevcutSepet[$urunKey]['adet'] = $urun['adet'];
            } else {

                if(!empty($varyantSecimKontrol)){
                    $birimFiyat = indirimliFiyatHesapla($urunDetay, $varyantSecimKontrol);

                }else {
                    $birimFiyat = indirimliFiyatHesapla($urunDetay);

                }

                FacebookConversionHelper::send('AddToCart', [
                    'content_name' => $urunDilVerisi->baslik,
                    'content_ids' => [$urunDetay->id],
                    'content_type' => 'product',
                    'value' => max((float) $birimFiyat, 0.01),
                    'currency' => 'TRY',
                ]);

                $mevcutSepet[] = [
                    "sepet_id" => count($mevcutSepet) + 1,
                    "urun_id" => $urun["id"],
                    "adet" => $urun["adet"],
                    "varyantlar" => $varyantlar,
                ];
            }
        } else {
            throw new \Exception("Maalesef " . $urunDilVerisi->baslik . " ürünümüz stoklarımızda kalmamıştır !");
        }
    }

    private static function mevcutUrunuBul($mevcutSepet, $urun, $urunVaryantlar)
    {
        foreach ($mevcutSepet as $key => $mevcutUrun) {
            $mevcutVaryantIds = !empty($mevcutUrun['varyantlar']) ? array_column($mevcutUrun['varyantlar'], 'urun_varyant_ozellik_id') : [];
            sort($mevcutVaryantIds);

            if ($mevcutUrun['urun_id'] === $urun['id'] && $mevcutVaryantIds === $urunVaryantlar) {
                return $key;
            }
        }
        return null;
    }

    private static function varyantBilgileriGetir($urunVaryantlar, $locale)
    {
        return array_map(function ($varyant) use ($locale) {
            $varyantOzellik = UrunVaryantOzellik::with('urunVaryant')->find($varyant);
            return [
                'urun_varyant_ozellik_id' => $varyantOzellik->id,
                'ana_varyant_isim' => $varyantOzellik->urunVaryant->urunVaryantDiller->where('dil', $locale)->first()->isim,
                'urun_varyant_ozellik_isim' => $varyantOzellik->urunVaryantOzellikDiller->where('dil', $locale)->first()->isim,
            ];
        }, $urunVaryantlar);
    }

    private static function veritabaninaKaydet($veri)
    {
        foreach ($veri["urunler"] as $urun) {
            $urunVaryantlar = array_map('intval', $urun['varyantlar']);
            sort($urunVaryantlar);

            $mevcutSepet = Sepet::where('urun_id', $urun['id'])
                ->where('kullanici_id', $veri['kullanici_id'])
                ->with('sepetUrunVaryant')
                ->get()
                ->first(function ($sepet) use ($urunVaryantlar) {
                    $sepetVaryantlar = $sepet->sepetUrunVaryant->pluck('urun_varyant_ozellik_id')->toArray();
                    sort($sepetVaryantlar);
                    return $sepetVaryantlar === $urunVaryantlar;
                });

            if ($mevcutSepet) {
                $mevcutSepet->adet = $urun['adet'];
                $mevcutSepet->save();
            } else {
                self::yeniSepetOlustur($urun, $veri["kullanici_id"], $urunVaryantlar);
            }
        }
    }

    private static function yeniSepetOlustur($urun, $kullaniciId, $urunVaryantlar)
    {
        $sepet = Sepet::create([
            "urun_id" => $urun["id"],
            "kullanici_id" => $kullaniciId,
            "adet" => $urun["adet"],
        ]);

        foreach ($urunVaryantlar as $key => $varyant) {
            SepetUrunVaryant::create([
                "sepet_id" => $sepet->id,
                "urun_id" => $urun["id"],
                "urun_varyant_id" => UrunVaryantOzellik::find($varyant)->urunVaryant->id,
                "urun_varyant_ozellik_id" => $varyant,
            ]);
        }
    }

    /**
     * Sepet ürünlerini hazırlar.
     *
     * @param string $dil Geçerli dil
     * @return \Illuminate\Support\Collection
     */
    public static function sepetiHazirla($dil): array
    {
        $sepetUrunler = collect(session()->get('sepet', []));
        $araToplam = 0;
        $kdvToplam = 0;
        $kargoTutar = 0;
        $sepetToplam = 0;
        $sepetAdet = 0;

        $sepetUrunler = $sepetUrunler->map(function ($sepetUrun) use ($dil, &$sepetAdet, &$araToplam, &$kdvToplam, &$sepetToplam, $sepetUrunler) {

            $urun = Urun::firstWhere('id', $sepetUrun['urun_id']);
            $varyantSecimKontrol = null;

            if (!empty($urun->secilenVaryatlar) && count($urun->secilenVaryatlar) > 0) {
                if (!empty($sepetUrun['varyantlar'])) {
                    $varyantIds = array_column($sepetUrun['varyantlar'], 'urun_varyant_ozellik_id');

                    $varyantSecimKontrol = UrunVaryantSecim::where('urun_id', $urun->id)
                        ->whereJsonContains('urun_varyantlar', array_map('strval', $varyantIds))
                        ->first();

                    if (empty($varyantIds) || !$varyantSecimKontrol) {
                        return null;
                    }

                    if ($sepetUrun['adet'] > $varyantSecimKontrol->stok_adet) {
                        return null;
                    }
                } else {
                    return null;
                }
            } else {
                if ($sepetUrun['adet'] > $urun->stok_adet) {
                    return null;
                }
            }

            $anaResim = depolamaUrl($urun->urunResimler->where('tip', 1)->first());
            $urunDil = $urun->urunDiller->where('dil', $dil)->first();

            $sepetUrun['ana_resim'] = $anaResim;
            $sepetUrun['urun_baslik'] = $urunDil->baslik;
            $sepetUrun['slug'] = rota('urun-detay', [
                'slug' => $urunDil->slug,
            ]);

            $sepetUrun['birim_fiyat'] = indirimliFiyatHesapla($urun, $varyantSecimKontrol);

            $kdvOran = $urun->urunKdv ? $urun->urunKdv->kdv : 0;
            $sepetUrun["kdv_oran"] = $kdvOran ?? 0;
            $kdvOrani = $kdvOran / 100;
            $urunFiyati = $sepetUrun["birim_fiyat"];

            if ($urun->kdv_durum) {
                $kdvHaricFiyat = $urunFiyati / (1 + $kdvOrani);
                $kdvTutar = $urunFiyati - $kdvHaricFiyat;
            } else {
                $kdvTutar = $urunFiyati * $kdvOrani;
                $kdvHaricFiyat = $urunFiyati;
            }


            $sepetAdet += $sepetUrun["adet"];
            $araToplam += $kdvHaricFiyat * $sepetUrun["adet"];
            $kdvToplam += $kdvTutar * $sepetUrun["adet"];
            $sepetToplam += ($kdvHaricFiyat + $kdvTutar) * $sepetUrun["adet"];

            return $sepetUrun;
        })->filter()
            ->values();

        $minKargoTutari = ayar('sepetMinKargoTutari');
        $kargoTutar = ($minKargoTutari > 0 && $sepetToplam >= $minKargoTutari) ? 0 : (int) ayar('kargoTutari');

        $sepetToplam += (int) $kargoTutar;

        $kuponKod = session()->get('kupon_kod', "");
        $kuponTutar = 0;
        $kuponBilgileri = null;
        $kuponKontrol = KuponServis::kontrol($kuponKod);

        if ($kuponKontrol) {

            $kuponTutar = $kuponKontrol->tutar;
            $kuponYuzde = $kuponKontrol->yuzde;

            if ($kuponYuzde > 0) {
                $kuponTutar = $araToplam * ($kuponYuzde / 100);
            }

            $sepetToplam -= $kuponTutar;

            if ($sepetToplam < 0) {
                $sepetToplam = 0;
            }

            $kuponBilgileri = [
                "kod" => $kuponKod,
                "yuzde" => $kuponYuzde,
                "tutar" => $kuponKontrol->tutar,
            ];
        }

        return [
            "urunler" => $sepetUrunler->toArray(),
            "sepet_adet" => $sepetAdet,
            "ara_toplam" => $araToplam,
            "kdv_toplam" => $kdvToplam,
            "kupon_tutar" => $kuponTutar,
            "kupon_bilgi" => $kuponBilgileri,
            "kargo_tutar" => $kargoTutar,
            "sepet_toplam" => $sepetToplam,
        ];
    }

    public static function sil(Sepet $sepet)
    {
        try {
            return DB::transaction(fn() => SepetBase::sil($sepet));
        } catch (\Throwable $th) {
            throw new \Exception('Sepet silinemedi: ' . $th->getMessage());
        }
    }
}
