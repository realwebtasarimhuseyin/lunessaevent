<?php

namespace App\Services;

use App\Models\Urun;
use App\Bases\UrunBase;
use App\Models\UrunDil;
use App\Models\UrunResim;
use App\Models\UrunVaryantOzellik;
use App\Models\UrunVaryantSecim;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UrunServis
{
    public static function veriAlma($ara = "", $durum = null, $kategori = 0)
    {
        $builder = UrunBase::veriIsleme();

        if (!empty($ara)) {
            $builder->where("ud.baslik", "LIKE", "%{$ara}%");
        }

        if ($durum !== null) {
            $builder->where("urun.durum", $durum);
        }

        if ($kategori > 0) {
            $builder->where("urun.urun_kategori_id", $kategori);
        }

        return $builder;
    }

    public static function tekliVeri($urunId)
    {
        $builder = UrunBase::veriIsleme();
        $builder->where("b.id", $urunId)->first();
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {

                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $resimServis = new UrunResimServis();
               
                $urun = UrunBase::ekle($veri);
                self::urunDilBilgileriniEkle($request, $urun, $desteklenenDil);
                self::urunVaryantBilgileriniEkle($request, $urun);
                self::resimleriKaydet($request, $urun, $varsayilanDil, $resimServis);
 
                return $urun;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(Urun $urun, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($urun, $veri, $request) {

                UrunDil::where('urun_id', $urun->id)->delete();
                UrunVaryantSecim::where('urun_id', $urun->id)->delete();

                $varsayilanDil = Config::get('app.locale');
                $desteklenenDil = Config::get('app.supported_locales');
                $resimServis = new UrunResimServis();

                self::urunDilBilgileriniEkle($request, $urun, $desteklenenDil);
                self::urunVaryantBilgileriniEkle($request, $urun);
                self::resimleriKaydet($request, $urun, $varsayilanDil, $resimServis);

                return UrunBase::duzenle($urun, $veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun düzenlenemedi : ' . $th->getMessage());
        }
    }

    private static function urunDilBilgileriniEkle($request, $urun, $desteklenenDil)
    {
        foreach ($desteklenenDil as $dil) {
            $slug = Urun::slugUret($request->input("baslik_$dil"));

            UrunDil::create([
                'urun_id' => $urun->id,
                'baslik' => $request->input("baslik_$dil"),
                'icerik' => formatEditor('urun', $slug, $request->input("icerik_$dil")),
                'meta_baslik' => $request->input("metaBaslik_$dil"),
                'meta_icerik' => $request->input("metaIcerik_$dil"),
                'meta_anahtar' => $request->input("metaAnahtar_$dil"),
                'slug' => $slug,
                'dil' => $dil,
            ]);
        }
    }

    private static function resimleriKaydet($request, $urun, $varsayilanDil, $resimServis)
    {
        $resimler = [
            'anaResim' => 'anaResmiKaydet',
            'normalResimler' => 'ekResimleriKaydet',
        ];

        $urunDilVerisi = $urun->urunDiller->where('dil', $varsayilanDil)->first();

        foreach ($resimler as $field => $method) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $resimServis->$method($file, $urunDilVerisi->slug, $urun->id);
                } else if (is_array($file)) {
                    $resimServis->$method($file, $urunDilVerisi->slug, $urun->id);
                }
            } elseif ($field == 'anaResim') {

                // Önceki kayıt varsa eski dosyayı sil
                $eskiResim = UrunResim::where('urun_id', $urun->id)->where('tip', 1)->first();
                if ($eskiResim && $eskiResim->resim_url && Storage::exists($eskiResim->resim_url)) {
                    Storage::delete($eskiResim->resim_url);
                    $eskiResim->delete();
                }
                
            } elseif ($field == 'normalResimler') {

                $eskiNormalResimler = UrunResim::where('urun_id', $urun->id)->where('tip', 2)->get();
                foreach ($eskiNormalResimler as $resim) {
                    if ($resim->resim_url && Storage::exists($resim->resim_url)) {
                        Storage::delete($resim->resim_url);
                    }
                }

                UrunResim::where('urun_id', $urun->id)
                    ->where('tip', 2)
                    ->delete();
            }
        }
    }


    private static function urunVaryantBilgileriniEkle($request, $urun)
    {


        $kombinasyonlar = json_decode($request->input('kombinasyonlar'),true);

        foreach ($kombinasyonlar as $kombinasyon) {
         UrunVaryantSecim::create([
            'urun_id' => $urun->id, 
            "urun_varyantlar" => $kombinasyon['varyantlar'],
            "birim_fiyat" => $kombinasyon["fiyat"],
            "stok_adet" => $kombinasyon["stokAdet"],
            "stok_kod" => $kombinasyon["stokKod"],
         ]);
        }


       /*  if (!empty($request->input("varyantlar")) && count($request->input("varyantlar")) > 0) {
            UrunVaryantSecim::where('urun_id', $urun->id)->delete();

            $urunVaryantOzellikler = $request->input("varyantlar");
            foreach ($urunVaryantOzellikler as $urunVaryantOzellik) {
                $varyantId = UrunVaryantOzellik::find($urunVaryantOzellik)->urunVaryant->id;

                UrunVaryantSecim::create([
                    "urun_id" => $urun->id,
                    "urun_varyant_id" => $varyantId,
                    "urun_varyant_ozellik_id" => $urunVaryantOzellik
                ]);
            }
        } */
    }

    public static function siralamaDuzenle($urunler)
    {
        try {
            return DB::transaction(function () use ($urunler) {

                foreach ($urunler as $urun) {
                    $urunDetay = Urun::firstWhere('id', $urun["id"]);

                    $urunDetay->sira_no = $urun["sira"];
                    $urunDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public static function stokAzalt($urunId, $adet)
    {
        $urun = Urun::where("id", $urunId)->first();

        if ($urun) {
            $urun->stok_adet -= $adet;
        }

        $urun->save();
    }

    public static function sil(Urun $urun)
    {
        try {
            return DB::transaction(function () use ($urun) {

                $urunResimler = UrunResim::where('urun_id', $urun->id)->get();
                if (!empty($urunResimler) && count($urunResimler) > 0) {
                    foreach ($urunResimler as $urunResim) {
                        if (Storage::exists($urunResim->resim_url)) {
                            Storage::deleteDirectory($urunResim->resim_url);
                        }
                    }
                }

                UrunBase::sil($urun);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Urun silinemedi : ' . $th->getMessage());
        }
    }
}
