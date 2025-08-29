<?php

namespace App\Services;

use App\Models\Proje;
use App\Bases\ProjeBase;
use App\Models\ProjeDil;
use App\Models\ProjeResim;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjeServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = ProjeBase::veriIsleme();
        return $builder;
    }
    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $resimServis = new ProjeResimServis();

                $proje = ProjeBase::ekle($veri);

                self::projeDilBilgileriniEkle($request, $proje, $desteklenenDil);
                self::resimleriKaydet($request, $proje, $varsayilanDil, $resimServis);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Proje kayıt edilemedi : ' . $th->getMessage());
        }
    }
    public static function duzenle(Proje $proje, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($proje, $veri, $request) {
                ProjeDil::where('proje_id', $proje->id)->delete();
                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $resimServis = new ProjeResimServis();

                self::projeDilBilgileriniEkle($request, $proje, $desteklenenDil);
                self::resimleriKaydet($request, $proje, $varsayilanDil, $resimServis);

                $guncelProje = ProjeBase::duzenle($proje, $veri);
                return $guncelProje;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Proje düzenlenemedi : ' . $th->getMessage());
        }
    }




    private static function projeDilBilgileriniEkle($request, $proje, $desteklenenDil)
    {
        foreach ($desteklenenDil as $dil) {
            $slug = Proje::slugUret($request->input("baslik_$dil"));

            ProjeDil::create([
                'proje_id' => $proje->id,
                'baslik' => $request->input("baslik_$dil"),
                'icerik' => formatEditor('proje', $slug, $request->input("icerik_$dil")),
                'meta_baslik' => $request->input("metaBaslik_$dil"),
                'meta_icerik' => $request->input("metaIcerik_$dil"),
                'meta_anahtar' => $request->input("metaAnahtar_$dil"),
                'slug' => $slug,
                'dil' => $dil,
            ]);
        }
    }
    private static function resimleriKaydet($request, $proje, $varsayilanDil, $resimServis)
    {
        $resimler = [
            'anaResim' => 'anaResmiKaydet',
            'normalResimler' => 'ekResimleriKaydet',
        ];

        $projeDilVerisi = $proje->projeDiller->where('dil', $varsayilanDil)->first();

        foreach ($resimler as $field => $method) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $resimServis->$method($file, $projeDilVerisi->slug, $proje->id);
                } else if (is_array($file)) {
                    $resimServis->$method($file, $projeDilVerisi->slug, $proje->id);
                }
            } elseif ($field == 'anaResim') {

                $eskiResim = ProjeResim::where('proje_id', $proje->id)->where('tip', 1)->first();
                if ($eskiResim && $eskiResim->resim_url && Storage::exists($eskiResim->resim_url)) {
                    Storage::delete($eskiResim->resim_url);
                    $eskiResim->delete();
                }
            } elseif ($field == 'normalResimler') {

                $eskiNormalResimler = ProjeResim::where('proje_id', $proje->id)->where('tip', 2)->get();
                foreach ($eskiNormalResimler as $resim) {
                    if ($resim->resim_url && Storage::exists($resim->resim_url)) {
                        Storage::delete($resim->resim_url);
                    }
                }

                ProjeResim::where('proje_id', $proje->id)
                    ->where('tip', 2)
                    ->delete();
            }
        }
    }



    public static function siralamaDuzenle($projeler)
    {
        try {
            return DB::transaction(function () use ($projeler) {

                foreach ($projeler as $proje) {
                    $projeDetay = Proje::firstWhere('id', $proje["id"]);

                    $projeDetay->sira_no = $proje["sira"];
                    $projeDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }


    public static function sil(Proje $proje)
    {
        try {
            return DB::transaction(function () use ($proje) {
                ProjeBase::sil($proje);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Proje silinemedi : ' . $th->getMessage());
        }
    }
}
