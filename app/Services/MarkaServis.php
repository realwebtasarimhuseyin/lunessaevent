<?php

namespace App\Services;

use App\Models\Marka;
use App\Bases\MarkaBase;
use App\Models\MarkaDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MarkaServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = MarkaBase::veriIsleme();

        /* if ($arama !== "") {
            $builder->whereAny(['gd.baslik', 'gd.icerik'], 'like', "%$arama%");
        } */

        return $builder;
    }

    public static function tekliVeri($markaId)
    {
        $builder = MarkaBase::veriIsleme();
        $builder->where("marka.id", $markaId)->first();
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $resimServis = new MarkaResimServis();

                if ($request->hasFile('resim')) {
                    $image = $request->file('resim');
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $veri["resim_url"] = $resimServis->resimKaydet($image, $request->input("isim"));
                    }
                }

                MarkaBase::ekle($veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Marka kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Marka $marka, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($marka, $veri, $request) {

                $resimServis = new MarkaResimServis();

                if ($request->hasFile('resim')) {
                    $image = $request->file('resim');
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $veri["resim_url"] = $resimServis->resimKaydet($image, $request->input("isim"));
                    }
                } else {
                    if (!empty($marka) && !empty($marka->resim_url)) {
                        if (Storage::exists($marka->resim_url)) {
                            Storage::delete($marka->resim_url);
                            $veri["resim_url"] = null;
                        }
                    }
                }

                $guncelMarka = MarkaBase::duzenle($marka, $veri);
                return $guncelMarka;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Marka düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function siralamaDuzenle($markalar)
    {
        try {
            return DB::transaction(function () use ($markalar) {

                foreach ($markalar as $marka) {
                    $markaDetay = Marka::firstWhere('id', $marka["id"]);

                    $markaDetay->sira_no = $marka["sira"];
                    $markaDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public static function sil(Marka $marka)
    {
        try {
            return DB::transaction(function () use ($marka) {

                if (!empty($marka) && !empty($marka->resim_url)) {
                    if (Storage::exists($marka->resim_url)) {
                        Storage::delete($marka->resim_url);
                    }
                }

                MarkaBase::sil($marka);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Marka silinemedi : ' . $th->getMessage());
        }
    }
}
