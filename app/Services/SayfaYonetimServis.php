<?php

namespace App\Services;

use App\Models\SayfaYonetim;
use App\Bases\SayfaYonetimBase;
use App\Models\SayfaYonetimDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SayfaYonetimServis
{

    public static function veriAlma()
    {

        $builder = SayfaYonetimBase::veriIsleme();

        return $builder;
    }
    public static function duzenle(SayfaYonetim $sayfaYonetim, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($sayfaYonetim, $veri, $request) {

                $sayfaYonetimId = $sayfaYonetim->id;
                $desteklenenDil = Config::get('app.supported_locales');
                $resimServis = new SayfaYonetimResimServis();

                if ($request->hasFile('resim')) {
                    $image = $request->file('resim');
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $veri["resim_url"] = $resimServis->resimKaydet($image, $sayfaYonetim->slug);
                    }
                } else {
                    if (!empty($sayfaYonetim) && !empty($sayfaYonetim->resim_url)) {
                        if (Storage::exists($sayfaYonetim->resim_url)) {
                            Storage::delete($sayfaYonetim->resim_url);
                            $veri["resim_url"] = null;
                        }
                    }
                }

                SayfaYonetimDil::where('sayfa_yonetim_id', $sayfaYonetimId)->delete();

                foreach ($desteklenenDil as $dil) {
                    SayfaYonetimDil::create([
                        'sayfa_yonetim_id' => $sayfaYonetimId,
                        'icerik' => $request->input("icerik_$dil"),
                        'baslik' => $request->input("sayfaIcerikBaslik_$dil"),
                        'meta_baslik' => $request->input("metaBaslik_$dil"),
                        'meta_icerik' => $request->input("metaIcerik_$dil"),
                        'meta_anahtar' => $request->input("metaAnahtar_$dil"),
                        'dil' => $dil,
                    ]);
                }

                SayfaYonetimBase::duzenle($sayfaYonetim, $veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Sayfa Yonetim düzenlenemedi : ' . $th->getMessage());
        }
    }


    public static function siralamaDuzenle($sayfayonetimler)
    {
        try {
            return DB::transaction(function () use ($sayfayonetimler) {

                foreach ($sayfayonetimler as $sayfayonetim) {
                    $sayfayonetimDetay = SayfaYonetim::firstWhere('id', $sayfayonetim["id"]);

                    $sayfayonetimDetay->sira_no = $sayfayonetim["sira"];
                    $sayfayonetimDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
