<?php

namespace App\Services;

use App\Models\Ayar;
use App\Models\AyarDil;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AyarServis
{
    public static function duzenle($request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $desteklenenDil = Config::get('app.supported_locales');
                $istekler = $request->all();

                foreach ($istekler as $key => $value) {
                    if (in_array($key, $desteklenenDil)) {
                        $dilliDeger = json_decode($value, true);


                        $dil = $key;
                        foreach ($dilliDeger as $key => $value) {
                            if ($dil == "tr") {
                                $ayarKontrol = Ayar::where('ayar_isim', $key)->exists();
                                if (!$ayarKontrol) {
                                    Ayar::create([
                                        'ayar_isim' => $key,
                                    ]);
                                }
                            }

                            AyarDil::updateOrCreate(
                                ['ayar_isim' => $key, 'dil' => $dil],
                                ['deger' => $value]
                            );
                        }
                    } else {

                        if ($request->hasFile($key)) {
                            $file = $request->file($key);

                            if ($file->isValid()) {
                                $slugifiedKey = Str::slug($key);
                                $fileName = $slugifiedKey . '.' . "png";
                                $filePath = $file->storeAs('site', $fileName, 'public');
                                $value = 'site/' . $fileName;
                            } else {
                                throw new \Exception('Dosya geçerli değil: ' . $key);
                            }
                        }

                        if ($key == "scriptKod" ||  $key == "scriptKodBody") {
                            $value = base64_decode($value);
                        }


                        $ayarKontrol = Ayar::where('ayar_isim', $key)->exists();

                        if (!$ayarKontrol) {
                            Ayar::create([
                                'ayar_isim' => $key,
                            ]);
                        }

                        AyarDil::updateOrCreate(
                            ['ayar_isim' => $key, 'dil' => "tr"],
                            ['deger' => $value]
                        );
                    }
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception('Ayarlar düzenlenemedi: ' . $th->getMessage());
        }
    }
}
