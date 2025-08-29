<?php

namespace App\Services;

use App\Models\Slider;
use App\Bases\SliderBase;
use App\Models\SliderDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = SliderBase::veriIsleme();

        if ($arama !== "") {
            // Arama terimine göre filtreleme
            $builder->whereAny(['gd.baslik', 'gd.icerik'], 'like', "%$arama%");
        }

        return $builder;
    }

    public static function ekle(array $veri, Request $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $dosyaServis = new SliderDosyaServis();

                $dosya = $request->file("dosya");


                if ($dosya instanceof \Illuminate\Http\UploadedFile) {
                    // MIME tipi kontrolü
                    $mimeType = $dosya->getMimeType();
                    if (strpos($mimeType, 'image') !== false) {
                        // Resim dosyası, resim olarak kaydet
                        $veri["resim_url"] = $dosyaServis->resimKaydet($dosya, $request->input("baslik_$varsayilanDil", 'basliksiz'));
                    } elseif (strpos($mimeType, 'video') !== false) {
                        // Video dosyası, video olarak kaydet
                        $veri["video_url"] = $dosyaServis->videoKaydet($dosya, $request->input("baslik_$varsayilanDil", 'basliksiz'));
                    }
                }
                // Slider kaydı
                $slider = SliderBase::ekle($veri);

                // Desteklenen dillere göre dil verilerini kaydetme
                foreach ($desteklenenDil as $dil) {
                    SliderDil::create([
                        'slider_id' => $slider->id,
                        'baslik' => $request->input("baslik_$dil"),
                        'alt_baslik' => $request->input("alt_baslik_$dil"),
                        'buton_icerik' => $request->input("buton_icerik_$dil"),
                        'buton_url' => $request->input("buton_url_$dil"),
                        'dil' => $dil,
                    ]);
                }

                return $slider;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Slider kayıt edilemedi: ' . $th->getMessage());
        }
    }

    public static function duzenle(Slider $slider, array $veri, Request $request)
    {
        try {
            return DB::transaction(function () use ($slider, $veri, $request) {
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $dosyaServis = new SliderDosyaServis();

                $dosya = $request->file("dosya");

                if (!$dosya) {
                    $veri["resim_url"] = null;
                    $veri["video_url"] = null;

                    if ($slider->resim_url) {
                        Storage::delete($slider->resim_url);
                    }

                    if ($slider->video_url) {
                        Storage::delete($slider->video_url);
                    }
                } else {
                    if ($dosya instanceof \Illuminate\Http\UploadedFile) {
                        $mimeType = $dosya->getMimeType();

                        if ($slider->resim_url) {
                            Storage::delete($slider->resim_url);
                        }
                        if ($slider->video_url) {
                            Storage::delete($slider->video_url);
                        }

                        if (strpos($mimeType, 'image') !== false) {
                            $veri["resim_url"] = $dosyaServis->resimKaydet($dosya, $request->input("baslik_$varsayilanDil", 'basliksiz'));
                            $veri["video_url"] = null;
                        } elseif (strpos($mimeType, 'video') !== false) {
                            $veri["resim_url"] = null;
                            $veri["video_url"] = $dosyaServis->videoKaydet($dosya, $request->input("baslik_$varsayilanDil", 'basliksiz'));
                        }
                    }
                }

                $guncelSlider = SliderBase::duzenle($slider, $veri);


                foreach ($desteklenenDil as $dil) {
                    $sliderDil = SliderDil::where('slider_id', $guncelSlider->id)
                        ->where('dil', $dil)
                        ->first();

                    if ($sliderDil) {
                        $sliderDil->update([
                            'baslik' => $request->input("baslik_$dil"),
                            'icerik' => $request->input("icerik_$dil"),
                            'alt_baslik' => $request->input("alt_baslik_$dil"),
                            'buton_icerik' => $request->input("buton_icerik_$dil"),
                            'buton_url' => $request->input("buton_url_$dil"),
                        ]);
                    } else {
                        SliderDil::create([
                            'slider_id' => $guncelSlider->id,
                            'baslik' => $request->input("baslik_$dil"),
                            'icerik' => $request->input("icerik_$dil"),
                            'alt_baslik' => $request->input("alt_baslik_$dil"),
                            'buton_icerik' => $request->input("buton_icerik_$dil"),
                            'buton_url' => $request->input("buton_url_$dil"),
                            'dil' => $dil,
                        ]);
                    }
                }

                return $guncelSlider;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Slider düzenlenemedi: ' . $th->getMessage());
        }
    }


    public static function siralamaDuzenle($sliderlar)
    {
        try {
            return DB::transaction(function () use ($sliderlar) {

                foreach ($sliderlar as $slider) {
                    $sliderDetay = Slider::firstWhere('id', $slider["id"]);

                    $sliderDetay->sira_no = $slider["sira"];
                    $sliderDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public static function sil(Slider $slider)
    {
        try {
            return DB::transaction(function () use ($slider) {

                if (!empty($slider) && !empty($slider->resim_url)) {
                    if (Storage::exists($slider->resim_url)) {
                        Storage::delete($slider->resim_url);
                    }
                }
                if (!empty($slider) && !empty($slider->video_url)) {

                    if (Storage::exists($slider->video_url)) {
                        Storage::delete($slider->video_url);
                    }
                }


                SliderBase::sil($slider);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Slider silinemedi: ' . $th->getMessage());
        }
    }
}
