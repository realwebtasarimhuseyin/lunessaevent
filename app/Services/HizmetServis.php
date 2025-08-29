<?php

namespace App\Services;

use App\Models\Hizmet;
use App\Bases\HizmetBase;
use App\Models\HizmetDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HizmetServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = HizmetBase::veriIsleme();

        return $builder;
    }


    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $resimServis = new HizmetResimServis();



                if ($request->hasFile('hizmetResim')) {
                    $resim = $request->file("hizmetResim");
                    if ($resim instanceof \Illuminate\Http\UploadedFile) {
                        $veri["resim_url"] = $resimServis->resimKaydet($resim, $request->input("baslik_$varsayilanDil"));
                    }
                }

                $hizmet = HizmetBase::ekle($veri);

                foreach ($desteklenenDil as $dil) {
                    $slug = Hizmet::generateSlug($request->input("baslik_$dil"));

                    HizmetDil::create([
                        'hizmet_id' => $hizmet->id,
                        'baslik' => $request->input("baslik_$dil"),
                        'kisa_icerik' => $request->input("kisaIcerik_$dil"),
                        'icerik' => formatEditor("hizmet",  $slug, $request->input("icerik_$dil")),
                        'meta_baslik' => $request->input("metaBaslik_$dil"),
                        'meta_icerik' =>  $request->input("metaIcerik_$dil"),
                        'meta_anahtar' => $request->input("metaAnahtar_$dil"),
                        'slug' => $slug,
                        'dil' => $dil,
                    ]);
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception('Hizmet kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Hizmet $hizmet, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($hizmet, $veri, $request) {

                HizmetDil::where('hizmet_id', $hizmet->id)->delete();

                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $resimServis = new HizmetResimServis();

                if ($request->hasFile('hizmetResim')) {
                    $resim = $request->file("hizmetResim");
                    if ($resim instanceof \Illuminate\Http\UploadedFile) {
                        $veri["resim_url"] = $resimServis->resimKaydet($resim, $request->input("baslik_$varsayilanDil"));
                    }
                }else {
                    if (!empty($hizmet) && !empty($hizmet->resim_url)) {
                        if (Storage::exists($hizmet->resim_url)) {
                            Storage::delete($hizmet->resim_url);
                            $veri["resim_url"] = null;
                        }
                    }
                }

                foreach ($desteklenenDil as $dil) {
                    $slug = Hizmet::generateSlug($request->input("baslik_$dil"));

                    HizmetDil::create([
                        'hizmet_id' => $hizmet->id,
                        'baslik' => $request->input("baslik_$dil"),
                        'kisa_icerik' => $request->input("kisaIcerik_$dil"),
                        'icerik' => formatEditor("hizmet",  $slug, $request->input("icerik_$dil")),
                        'meta_baslik' => $request->input("metaBaslik_$dil"),
                        'meta_icerik' =>  $request->input("metaIcerik_$dil"),
                        'meta_anahtar' => $request->input("metaAnahtar_$dil"),
                        'slug' => $slug,
                        'dil' => $dil,
                    ]);
                }

                $guncelHizmet = HizmetBase::duzenle($hizmet, $veri);
                return $guncelHizmet;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Hizmet düzenlenemedi : ' . $th->getMessage());
        }
    }


    public static function siralamaDuzenle($hizmetler)
    {
        try {
            return DB::transaction(function () use ($hizmetler) {

                foreach ($hizmetler as $hizmet) {
                    $hizmetDetay = Hizmet::firstWhere('id', $hizmet["id"]);

                    $hizmetDetay->sira_no = $hizmet["sira"];
                    $hizmetDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }



    public static function sil(Hizmet $hizmet)
    {
        try {
            return DB::transaction(function () use ($hizmet) {
                if (!empty($hizmet) && !empty($hizmet->resim_url)) {
                    if (Storage::exists($hizmet->resim_url)) {
                        Storage::delete($hizmet->resim_url);
                    }
                }
                HizmetBase::sil($hizmet);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Hizmet silinemedi : ' . $th->getMessage());
        }
    }
}
