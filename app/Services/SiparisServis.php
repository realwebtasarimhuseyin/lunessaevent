<?php

namespace App\Services;

use App\Models\Siparis;
use App\Bases\SiparisBase;
use App\Helper\IyzicoHelper;
use App\Models\SiparisBilgi;
use App\Models\SiparisUrun;
use App\Models\SiparisUrunVaryant;
use App\Models\Urun;
use App\Models\UrunVaryantOzellik;
use App\SanalPos\ParamPos;
use App\SanalPos\PayTr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiparisServis
{
    public static function veriAlma()
    {
        $builder = SiparisBase::veriIsleme();
        return $builder->get();
    }


    public static function ekle($siparisVeriler)
    {
        try {
            return DB::transaction(function () use ($siparisVeriler) {

                $PayTrToken = "";
                $sepet = SepetServis::sepetiHazirla('tr');
                $sepetUrunler = collect($sepet["urunler"]);

                $kuponKod = session()->get('kupon_kod', null);
                $toplamVeriler = self::sepetUrunleriHesapla($sepetUrunler);
                $sepetToplamTutar = $toplamVeriler['toplam']; // Toplam tutarı al
                $kuponTutar = self::kuponTutarHesapla($kuponKod, $sepetToplamTutar);

                $siparisVeri = [
                    "durum" => 1,
                    "kullanici_id" => Auth::guard('web')->check() ? Auth::guard('web')->id() : 0,
                    "kupon_kod" => $kuponKod ?? null,
                    "indirim_tutar" => $kuponTutar,
                    "kargo_tutar" => $sepet["kargo_tutar"] ?? 0,
                    "kapida_odeme_tutar" => $siparisVeriler["odeme_tip"] == 'kapida' ? ayar('kapidaOdemeTutar') : 0,
                    "odeme_tip" => $siparisVeriler["odeme_tip"],
                ];

                $siparis = SiparisBase::ekle($siparisVeri);
                $siparis = Siparis::where('id', $siparis->id)->first();
                self::siparisBilgileriniKaydet($siparis->id, $siparisVeriler);
                $urunlerArray = self::siparisUrunleriniKaydet($siparis->id, $toplamVeriler['urunler']);

                $siparisToplamTutar = $sepetToplamTutar;
                $iframeLink = null;
                if ($siparisVeriler["odeme_tip"] == "krediKarti") {

                    $sepetUrunleri = [];
                    $sepetToplamTutar = 0;
                    foreach ($siparis->siparisUrun as $siparisUrun) {
                        $urun = $siparisUrun->urun;
                        $sepetUrunleri[] = [
                            'id' => $urun->id,
                            'ad' => $siparisUrun->urun_baslik,
                            'kategori1' => dilVerisi($urun->urunKategori, 'urunKategoriDiller')->first()->isim,
                            'kategori2' => '-',
                            'fiyat' => $siparisUrun->birim_fiyat * $siparisUrun->adet,
                        ];
                        $sepetToplamTutar += $siparisUrun->birim_fiyat * $siparisUrun->adet;
                    }

                    $parametreler = [
                        'konusma_id' => $siparis->kod,
                        'fiyat' => $sepetToplamTutar,
                        'odenen_fiyat' => $siparis->butun_tutarlar["genel_toplam"],
                        'sepet_id' => $siparis->id,
                        'alici_id' => auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0,
                        'alici_ad' => $siparisVeriler["isim"],
                        'alici_soyad' => '-',
                        'alici_telefon' => $siparisVeriler["telefon"],
                        'alici_email' => $siparisVeriler["eposta"],
                        'alici_tc' => '11111111111',
                        'alici_son_giris' => '',
                        'alici_kayit_tarihi' => '',
                        'alici_adres' => $siparisVeriler["adres"],
                        'alici_ip' => request()->ip(),
                        'alici_sehir' => $siparisVeriler["il"],
                        'alici_ulke' => 'Turkey',
                        'alici_posta_kodu' => $siparisVeriler["posta_kod"],
                        'teslimat_ad' => $siparisVeriler["isim"],
                        'teslimat_sehir' => $siparisVeriler["il"],
                        'teslimat_ulke' => 'Turkey',
                        'teslimat_adres' => $siparisVeriler["adres"],
                        'teslimat_posta_kodu' => $siparisVeriler["posta_kod"],
                        'fatura_ad' => $siparisVeriler["isim"],
                        'fatura_sehir' => $siparisVeriler["il"],
                        'fatura_ulke' => 'Turkey',
                        'fatura_adres' => $siparisVeriler["adres"],
                        'fatura_posta_kodu' => $siparisVeriler["posta_kod"],
                        'sepet_urunleri' => $sepetUrunleri,
                        'geri_donus_url' => route('odeme.durum')
                    ];

                    $odemeSonucu = IyzicoHelper::odemeOlustur($parametreler);
                    $iframeLink = $odemeSonucu['data']['odeme_sayfasi_url'];
                    if (!$odemeSonucu['imza_dogrulama']) {
                        throw new \Exception('Ödeme imza doğrulaması başarısız.' . $odemeSonucu['data']['hata_mesaji']);
                    }
                }

                session()->put('siparis_id', $siparis->id);

                return [
                    "siparisKayitDurum" => $siparis ? true : false,
                    "iframeLink" => $iframeLink
                ];
            });
        } catch (\Throwable $th) {
            throw new \Exception('Sipariş kayıt edilemedi : ' . $th->getMessage());
        }
    }


    private static function kuponTutarHesapla($kuponKod, $sepetToplamTutar)
    {
        $kuponKontrol = KuponServis::kontrol($kuponKod);

        if ($kuponKontrol) {
            // Kuponun yüzde indirimi mi, yoksa tutar indirimi mi olduğu kontrol edilir
            $indirimMiktari = $kuponKontrol->yuzde > 0
                ? $sepetToplamTutar * ($kuponKontrol->yuzde / 100)
                : $kuponKontrol->tutar;

            // Kupon adedini 1 azalt
            KuponServis::stokAzalt($kuponKod);

            return $indirimMiktari;
        }

        return 0;
    }

    private static function sepetUrunleriHesapla($sepetUrunler)
    {
        $sepetToplamTutar = 0;
        $toplamKdvTutar = 0;

        $urunler = $sepetUrunler->map(function ($sepetUrun) use (&$sepetToplamTutar, &$toplamKdvTutar) {
            $urun = Urun::find($sepetUrun["urun_id"]);
            $kdvTutar = self::kdvHesapla($urun, $sepetUrun["birim_fiyat"]);
            $sepetToplamTutar += ($kdvTutar['kdvHaricFiyat'] + $kdvTutar['kdvTutar']) * $sepetUrun["adet"];
            $toplamKdvTutar += $kdvTutar['kdvTutar'];

            return array_merge($sepetUrun, [
                "urun_baslik" => $urun->urunDiller->where('dil', app()->getLocale())->first()->baslik,
                "kdv_durum" => $urun->kdv_durum,
                "kdv_oran" => $sepetUrun["kdv_oran"],
            ]);
        });

        return [
            'toplam' => $sepetToplamTutar,
            'urunler' => $urunler
        ];
    }

    private static function kdvHesapla($urun, $urunFiyati)
    {
        $kdvOrani = $urun->kdv_oran / 100;

        if (!$urun->kdv_durum) {
            $kdvTutar = $urunFiyati * $kdvOrani;
            return [
                'kdvHaricFiyat' => $urunFiyati,
                'kdvTutar' => $kdvTutar
            ];
        }

        $kdvHaricFiyat = $urunFiyati / (1 + $kdvOrani);
        $kdvTutar = $urunFiyati - $kdvHaricFiyat;
        return [
            'kdvHaricFiyat' => $kdvHaricFiyat,
            'kdvTutar' => $kdvTutar
        ];
    }

    private static function siparisBilgileriniKaydet($siparisId, $siparisVeriler)
    {
        SiparisBilgi::create([
            "siparis_id" => $siparisId,
            "isim" => $siparisVeriler["isim"],
            "telefon" => $siparisVeriler["telefon"],
            "eposta" => $siparisVeriler["eposta"],
            "adres" => $siparisVeriler["adres"] . " " . $siparisVeriler["posta_kod"] . " " . $siparisVeriler["ilce"] . "/" . $siparisVeriler["il"],
            "fatura_adres" => 1
        ]);
    }

    private static function siparisUrunleriniKaydet($siparisId, $sepetUrunler)
    {
        $urunler = [];

        foreach ($sepetUrunler as $urun) {

            $urunVaryantlar = $urun['varyantlar'];

            $siparisUrun = SiparisUrun::create([
                "siparis_id" => $siparisId,
                "urun_id" => $urun["urun_id"],
                "urun_baslik" => $urun["urun_baslik"],
                "kdv_oran" => $urun["kdv_oran"],
                "kdv_durum" => $urun["kdv_durum"],
                "adet" => $urun["adet"],
                "birim_fiyat" => $urun["birim_fiyat"],
            ]);

            foreach ($urunVaryantlar as $urunVaryant) {
                $urunVaryantOzellikId = $urunVaryant["urun_varyant_ozellik_id"];
                $urunVaryantOzellik = UrunVaryantOzellik::where('id', $urunVaryantOzellikId)->first();
                $urunVaryantOzellikDilVerisi = dilVerisi($urunVaryantOzellik, 'urunVaryantOzellikDiller')->first();
                $urunVaryant = $urunVaryantOzellik->urunVaryant;
                $urunVaryantDilVerisi = dilVerisi($urunVaryant, 'urunVaryantDiller')->first();
                SiparisUrunVaryant::create([
                    "siparis_urun_id" => $siparisUrun->id,
                    "urun_varyant_isim" => $urunVaryantDilVerisi->isim,
                    "urun_varyant_ozellik_isim" => $urunVaryantOzellikDilVerisi->isim
                ]);
            }

            $urunler[] = [
                $urun["urun_baslik"],
                $urun["birim_fiyat"],
                $urun["adet"]
            ];
        }

        return $urunler;
    }

    public static function duzenle(Siparis $siparis, $veri)
    {
        try {
            return DB::transaction(function () use ($siparis, $veri) {
                SiparisBase::duzenle($siparis, $veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Sipariş düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function sil(Siparis $siparis)
    {
        try {
            return DB::transaction(function () use ($siparis) {
                SiparisBase::sil($siparis);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Sipariş silinemedi : ' . $th->getMessage());
        }
    }
}
