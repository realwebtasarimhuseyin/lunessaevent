<?php

namespace App\Services;

use App\Models\Popup;
use App\Bases\PopupBase;
use App\Models\PopupDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PopupServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = PopupBase::veriIsleme();

        return $builder;
    }

    public static function kontrol($popupKod)
    {

        return $popup = Popup::where("kod", $popupKod)->where("durum", true)
            ->where('baslangic_tarih', '<=', now())
            ->where('bitis_tarih', '>=', now())
            ->first();
    }

    public static function ekle($request, $veri)
    {
        try {
            return DB::transaction(function () use ($request, $veri) {
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $resimServis = new PopupResimServis();

                $popup = PopupBase::ekle($veri);

                self::popupDilBilgileriniEkle($request, $popup, $desteklenenDil);
                self::resimleriKaydet($request, $popup, $varsayilanDil, $resimServis);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Popup kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Popup $popup, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($popup, $veri, $request) {
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $resimServis = new PopupResimServis();

                PopupBase::duzenle($popup, $veri);

                self::popupDilBilgileriniEkle($request, $popup, $desteklenenDil);
                self::resimleriKaydet($request, $popup, $varsayilanDil, $resimServis);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Popup düzenlenemedi : ' . $th->getMessage());
        }
    }

    private static function popupDilBilgileriniEkle($request, $popup, $desteklenenDil)
    {

        PopupDil::where('popup_id', $popup->id)->delete();

        foreach ($desteklenenDil as $dil) {
            PopupDil::create([
                'popup_id' => $popup->id,
                'baslik' => $request->input("baslik_$dil"),
                'icerik' => $request->input("icerik_$dil"),
                'dil' => $dil,
            ]);
        }
    }


    private static function resimleriKaydet($request, $popup, $varsayilanDil, $resimServis)
    {
        $resimler = [
            'popupResim' => 'resmiKaydet',
        ];

        $popupDilVerisi = $popup->popupDiller->where('dil', $varsayilanDil)->first();

        foreach ($resimler as $field => $method) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $resimServis->$method($file, $popupDilVerisi->baslik, $popup->id);
                }
            } else {
                if (!empty($popup->resim_url)) {

                    if (Storage::exists($popup->resim_url)) {
                        Storage::deleteDirectory($popup->resim_url);
                    }

                    $popup->resim_url = null;
                    $popup->save();
                }
            }
        }
    }

    public static function siralamaDuzenle($popuplar)
    {
        try {
            return DB::transaction(function () use ($popuplar) {

                foreach ($popuplar as $popup) {
                    $popupDetay = Popup::firstWhere('id', $popup["id"]);

                    $popupDetay->sira_no = $popup["sira"];
                    $popupDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public static function sil(Popup $popup)
    {
        try {
            return DB::transaction(function () use ($popup) {
                if (!empty($popup) && !empty($popup->resim_url)) {
                    if (Storage::exists($popup->resim_url)) {
                        Storage::deleteDirectory($popup->resim_url);
                    }
                }

                PopupBase::sil($popup);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Popup silinemedi : ' . $th->getMessage());
        }
    }
}
