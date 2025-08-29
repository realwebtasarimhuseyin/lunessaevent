<?php

namespace App\Services;

use App\Models\Katalog;
use App\Bases\KatalogBase;
use App\Models\KatalogDil;
use App\Models\KatalogResim;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KatalogServis
{
    public static function veriAlma($arama = 0, $yazar = 0)
    {
        $builder = KatalogBase::veriIsleme();

        if ($arama !== "") {
            $builder->whereAny(['bd.baslik', 'bd.icerik'], 'like', "%$arama%");
        }
        if ($yazar > 0) {
            $builder->where("admin_id", $yazar);
        }

        return $builder;
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $resimServis = new KatalogResimServis();
                $varsayilanDil = Config::get('app.locale');

                $resimServis = new KatalogResimServis();
                $dosyaServis = new KatalogDosyaServis();

                if ($request->hasFile('anaResim')) {
                    $image = $request->file('anaResim');
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $veri['resim_url'] = $resimServis->resmiKaydet($image,  Katalog::slugUret($request->input("baslik_$varsayilanDil")));
                    }
                }

                if ($request->hasFile('katalogDosya')) {
                    $dosya = $request->file('katalogDosya');
                    if ($dosya instanceof \Illuminate\Http\UploadedFile) {
                        $veri['dosya_url'] = $dosyaServis->dosyaKaydet($dosya,  Katalog::slugUret($request->input("baslik_$varsayilanDil")));
                    }
                }

                $katalog = KatalogBase::ekle($veri);
                self::katalogDilleriKaydet($katalog->id, $request);

                return $katalog;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Katalog kayıt edilemedi: ' . $th->getMessage());
        }
    }

    public static function duzenle(Katalog $katalog, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($katalog, $veri, $request) {
                KatalogDil::where('katalog_id', $katalog->id)->delete();

                $resimServis = new KatalogResimServis();
                $varsayilanDil = Config::get('app.locale');

                
                $resimServis = new KatalogResimServis();
                $dosyaServis = new KatalogDosyaServis();

                if ($request->hasFile('anaResim')) {
                    $image = $request->file('anaResim');
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $veri['resim_url'] = $resimServis->resmiKaydet($image,  Katalog::slugUret($request->input("baslik_$varsayilanDil")));
                    }
                }

                if ($request->hasFile('katalogDosya')) {
                    $dosya = $request->file('katalogDosya');
                    if ($dosya instanceof \Illuminate\Http\UploadedFile) {
                        $veri['dosya_url'] = $dosyaServis->dosyaKaydet($dosya,  Katalog::slugUret($request->input("baslik_$varsayilanDil")));
                    }
                }


                self::katalogDilleriKaydet($katalog->id, $request);
                return KatalogBase::duzenle($katalog, $veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Katalog düzenlenemedi: ' . $th->getFile());
        }
    }

    private static function katalogDilleriKaydet($katalogId, $request)
    {
        $desteklenenDil = Config::get('app.supported_locales');

        foreach ($desteklenenDil as $dil) {
            KatalogDil::create([
                'katalog_id' => $katalogId,
                'baslik' => $request->input("baslik_$dil"),
                'icerik' => $request->input("icerik_$dil"),
                'meta_baslik' => $request->input("metaBaslik_$dil"),
                'meta_icerik' => $request->input("metaIcerik_$dil"),
                'meta_anahtar' => $request->input("metaAnahtar_$dil"),
                'slug' => Katalog::slugUret($request->input("baslik_$dil")),
                'dil' => $dil,
            ]);
        }
    }
    
    public static function siralamaDuzenle($kataloglar)
    {
        try {
            return DB::transaction(function () use ($kataloglar) {

                foreach ($kataloglar as $katalog) {
                    $katalogDetay = Katalog::firstWhere('id', $katalog["id"]);

                    $katalogDetay->sira_no = $katalog["sira"];
                    $katalogDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
    public static function sil(Katalog $katalog)
    {
        try {
            return DB::transaction(function () use ($katalog) {
                if (!empty($katalog) && !empty($katalog->resim_url)) {
                    if (Storage::exists($katalog->resim_url)) {
                        Storage::delete($katalog->resim_url);
                    }
                }

                KatalogBase::sil($katalog);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Katalog silinemedi : ' . $th->getMessage());
        }
    }
}
