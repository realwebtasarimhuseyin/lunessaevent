<?php

namespace App\Services;

use App\Models\Galeri;
use App\Bases\GaleriBase;
use App\Models\GaleriDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GaleriServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = GaleriBase::veriIsleme();

        if ($arama !== "") {
            $builder->whereAny(['gd.baslik'], 'like', "%$arama%");
        }

        return $builder;
    }

    public static function tekliVeri($galeriId)
    {
        $builder = GaleriBase::veriIsleme();
        $builder->where("b.id", $galeriId)->first();
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $dosyaServis = new GaleriDosyaServis();

                $dosya = $request->file("dosya");

                if ($dosya instanceof \Illuminate\Http\UploadedFile) {
                    $mimeType = $dosya->getMimeType();
                    if (strpos($mimeType, 'image') !== false) {
                        // Resim dosyası, resim olarak kaydet
                        $veri["resim_url"] = $dosyaServis->resimKaydet($dosya, $request->input("baslik_$varsayilanDil"));
                    } elseif (strpos($mimeType, 'video') !== false) {
                        // Video dosyası, video olarak kaydet
                        $veri["video_url"] = $dosyaServis->videoKaydet($dosya, $request->input("baslik_$varsayilanDil"));
                    }
                }

                $galeri = GaleriBase::ekle($veri);

                foreach ($desteklenenDil as $dil) {
                    GaleriDil::create([
                        'galeri_id' => $galeri->id,
                        'baslik' => $request->input("baslik_$dil"),
                        'dil' => $dil,
                    ]);
                }

                return $galeri;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Galeri kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Galeri $galeri, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($galeri, $veri, $request) {
                GaleriDil::where('galeri_id', $galeri->id)->delete();

                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');

                $dosyaServis = new GaleriDosyaServis();

                $dosya = $request->file("dosya");

                if (!$dosya) {
                    $veri["resim_url"] = null;
                    $veri["video_url"] = null;

                    if ($galeri->resim_url) {
                        Storage::delete($galeri->resim_url);
                    }

                    if ($galeri->video_url) {
                        Storage::delete($galeri->video_url);
                    }
                } else {
                    if ($dosya instanceof \Illuminate\Http\UploadedFile) {
                        $mimeType = $dosya->getMimeType();

                        if ($galeri->resim_url) {
                            Storage::delete($galeri->resim_url);
                        }
                        if ($galeri->video_url) {
                            Storage::delete($galeri->video_url);
                        }

                        if (strpos($mimeType, 'image') !== false) {
                            $veri["resim_url"] = $dosyaServis->resimKaydet($dosya, $request->input("baslik_$varsayilanDil"));
                            $veri["video_url"] = null;
                        } elseif (strpos($mimeType, 'video') !== false) {
                            $veri["resim_url"] = null;
                            $veri["video_url"] = $dosyaServis->videoKaydet($dosya, $request->input("baslik_$varsayilanDil"));
                        }
                    }
                }

                foreach ($desteklenenDil as $dil) {
                    GaleriDil::create([
                        'galeri_id' => $galeri->id,
                        'baslik' => $request->input("baslik_$dil"),
                        'dil' => $dil,
                    ]);
                }

                $guncelGaleri = GaleriBase::duzenle($galeri, $veri);
                return $guncelGaleri;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Galeri düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function siralamaDuzenle($galeriler)
    {
        try {
            return DB::transaction(function () use ($galeriler) {

                foreach ($galeriler as $galeri) {
                    $galeriDetay = Galeri::firstWhere('id', $galeri["id"]);

                    $galeriDetay->sira_no = $galeri["sira"];
                    $galeriDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }


    public static function sil(Galeri $galeri)
    {
        try {
            return DB::transaction(function () use ($galeri) {

                if (!empty($galeri) && !empty($galeri->resim_url)) {
                    if (Storage::exists($galeri->resim_url)) {
                        Storage::delete($galeri->resim_url);
                    }
                }
                if (!empty($galeri) && !empty($galeri->video_url)) {

                    if (Storage::exists($galeri->video_url)) {
                        Storage::delete($galeri->video_url);
                    }
                }

                GaleriBase::sil($galeri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Galeri silinemedi : ' . $th->getMessage());
        }
    }
}
