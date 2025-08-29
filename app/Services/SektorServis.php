<?php

namespace App\Services;

use App\Models\Sektor;
use App\Bases\SektorBase;
use App\Models\SektorDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SektorServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = SektorBase::veriIsleme();

        return $builder;
    }


    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $resimServis = new SektorResimServis();



                if ($request->hasFile('sektorResim')) {
                    $resim = $request->file("sektorResim");
                    if ($resim instanceof \Illuminate\Http\UploadedFile) {
                        $veri["resim_url"] = $resimServis->resimKaydet($resim, $request->input("baslik_$varsayilanDil"));
                    }
                }



                $sektor = SektorBase::ekle($veri);

                foreach ($desteklenenDil as $dil) {
                    $slug = Sektor::generateSlug($request->input("baslik_$dil"));

                    SektorDil::create([
                        'sektor_id' => $sektor->id,
                        'baslik' => $request->input("baslik_$dil"),
                        'kisa_icerik' => $request->input("kisaIcerik_$dil"),
                        'icerik' => formatEditor("sektor",  $slug, $request->input("icerik_$dil")),
                        'meta_baslik' => $request->input("metaBaslik_$dil"),
                        'meta_icerik' =>  $request->input("metaIcerik_$dil"),
                        'meta_anahtar' => $request->input("metaAnahtar_$dil"),
                        'slug' => $slug,
                        'dil' => $dil,
                    ]);
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception('Sektor kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Sektor $sektor, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($sektor, $veri, $request) {

                SektorDil::where('sektor_id', $sektor->id)->delete();

                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $resimServis = new SektorResimServis();

                if ($request->hasFile('sektorResim')) {
                    $resim = $request->file("sektorResim");
                    if ($resim instanceof \Illuminate\Http\UploadedFile) {
                        $veri["resim_url"] = $resimServis->resimKaydet($resim, $request->input("baslik_$varsayilanDil"));
                    }
                }else{
                    if (!empty($sektor) && !empty($sektor->resim_url)) {
                        if (Storage::exists($sektor->resim_url)) {
                            Storage::deleteDirectory($sektor->resim_url);
                        }
                    }
                }


                foreach ($desteklenenDil as $dil) {
                    $slug = Sektor::generateSlug($request->input("baslik_$dil"));

                    SektorDil::create([
                        'sektor_id' => $sektor->id,
                        'baslik' => $request->input("baslik_$dil"),
                        'kisa_icerik' => $request->input("kisaIcerik_$dil"),
                        'icerik' => formatEditor("sektor",  $slug, $request->input("icerik_$dil")),
                        'meta_baslik' => $request->input("metaBaslik_$dil"),
                        'meta_icerik' =>  $request->input("metaIcerik_$dil"),
                        'meta_anahtar' => $request->input("metaAnahtar_$dil"),
                        'slug' => $slug,
                        'dil' => $dil,
                    ]);
                }

                $guncelSektor = SektorBase::duzenle($sektor, $veri);
                return $guncelSektor;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Sektor düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function siralamaDuzenle($sektorler)
    {
        try {
            return DB::transaction(function () use ($sektorler) {

                foreach ($sektorler as $sektor) {
                    $sektorDetay = Sektor::firstWhere('id', $sektor["id"]);

                    $sektorDetay->sira_no = $sektor["sira"];
                    $sektorDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }


    public static function sil(Sektor $sektor)
    {
        try {
            return DB::transaction(function () use ($sektor) {
                if (!empty($sektor) && !empty($sektor->resim_url)) {
                    if (Storage::exists($sektor->resim_url)) {
                        Storage::deleteDirectory($sektor->resim_url);
                    }
                }
                
                SektorBase::sil($sektor);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Sektor silinemedi : ' . $th->getMessage());
        }
    }
}
