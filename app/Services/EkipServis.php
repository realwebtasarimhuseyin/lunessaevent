<?php

namespace App\Services;

use App\Models\Ekip;
use App\Bases\EkipBase;
use App\Models\EkipDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EkipServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = EkipBase::veriIsleme();

        if ($arama !== "") {
            $builder->whereAny(['k.kod'], 'like', "%$arama%");
        }

        return $builder;
    }

    public static function tekliVeri($ekipId)
    {
        $builder = EkipBase::veriIsleme();
        $builder->where("k.id", $ekipId)->first();
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {

                $varsayilanDil = Config::get('app.locale');
                $resimServis = new EkipResimServis();

                if ($request->hasFile("resim")) {
                    $image = $request->file("resim");
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $veri["resim_url"] = $resimServis->resimKaydet($image, $request->input("isim"));
                    }
                }

                EkipBase::ekle($veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Ekip kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Ekip $ekip, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($ekip, $veri, $request) {
                $varsayilanDil = Config::get('app.locale');
                $resimServis = new EkipResimServis();

                if ($request->hasFile("resim")) {
                    $image = $request->file("resim");
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $veri["resim_url"] = $resimServis->resimKaydet($image, $request->input("isim"), $ekip);
                    }
                } else {
                    if (!empty($ekip) && !empty($ekip->resim_url)) {
                        if (Storage::exists($ekip->resim_url)) {
                            Storage::delete($ekip->resim_url);
                            $veri["resim_url"] = null;
                        }
                    }
                }

                EkipBase::duzenle($ekip, $veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Ekip düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function sil(Ekip $ekip)
    {
        try {
            return DB::transaction(function () use ($ekip) {
                if (!empty($ekip) && !empty($ekip->resim_url)) {
                    if (Storage::exists($ekip->resim_url)) {
                        Storage::delete($ekip->resim_url);
                    }
                }

                EkipBase::sil($ekip);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Ekip silinemedi : ' . $th->getMessage());
        }
    }
}
