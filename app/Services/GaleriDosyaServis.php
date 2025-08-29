<?php

namespace App\Services;

use App\Helper\WebpDonusturHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class GaleriDosyaServis
{
    /**
     * Klasör oluşturma işlemi (varsa numaralandırır).
     *
     * @param string $uzanti Ana klasör yolu.
     * @return string Kullanılabilir klasör yolu.
     */
    public static function klasorOlusturArtanNumaraIle(string $uzanti): string
    {
        $sayac = 1;
        $yol = $uzanti;

        while (Storage::directoryExists($yol)) {
            $yol = "{$uzanti}_{$sayac}";
            $sayac++;
        }

        Storage::makeDirectory($yol);

        return $yol;
    }

    /**
     * Resmi kaydetme işlemi.
     *
     * @param UploadedFile $resim Yüklenen resim dosyası.
     * @param string $galeriBaslik Slider başlığı (slug oluşturmak için kullanılır).
     * @param string $dizin Kaydedilecek ana dizin (varsayılan: 'galeri_resim').
     * @return string Kaydedilen resmin yolu.
     */
    public function resimKaydet(UploadedFile $resim, string $galeriBaslik, string $dizin = 'galeri_resim'): string
    {
        $galeriBaslik = Str::slug($galeriBaslik);

        $klasor = self::klasorOlusturArtanNumaraIle("{$dizin}/{$galeriBaslik}");

        $resimAdi = "{$galeriBaslik}-" . time() . '.webp';

        $resimYolu = "{$klasor}/{$resimAdi}";

        WebpDonusturHelper::webpDonustur($resim, $resimYolu);

        return $resimYolu;
    }

    /**
     * Videoyu kaydetme işlemi.
     *
     * @param UploadedFile $video Yüklenen video dosyası.
     * @param string $galeriBaslik Slider başlığı (slug oluşturmak için kullanılır).
     * @param string $dizin Kaydedilecek ana dizin (varsayılan: 'galeri_video').
     * @return string Kaydedilen videonun yolu.
     */
    public function videoKaydet(UploadedFile $video, string $galeriBaslik, string $dizin = 'galeri_video'): string
    {
        $galeriBaslik = Str::slug($galeriBaslik);

        $klasor = self::klasorOlusturArtanNumaraIle("{$dizin}/{$galeriBaslik}");

        $videoAdi = "{$galeriBaslik}-" . time() . '.' . $video->extension();

        $videoYolu = $video->storeAs($klasor, $videoAdi, 'public');

        return $videoYolu;
    }
}
