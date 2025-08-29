<?php

namespace App\Services;

use App\Helper\WebpDonusturHelper;
use App\Models\Urun;
use App\Models\UrunResim;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UrunResimServis
{
    /**
     * Ana resmi kaydeder ve veritabanına yazar.
     * 
     * @param UploadedFile $resim Yüklenecek ana resim dosyası
     * @param int|null $urunId Ürün ID'si (isteğe bağlı)
     * @return string Kaydedilen resmin yolu
     */
    public function anaResmiKaydet(UploadedFile $resim, string $urunSlug, $urunId = null): string
    {
        $klasor = 'urun_resim/' . $urunSlug . '/ana_resim';

        if (Storage::exists($klasor)) {
            Storage::deleteDirectory($klasor);
        }

        $hedef = $klasor . '/' . $urunSlug . '-' . time() . '.webp';
        WebpDonusturHelper::webpDonustur($resim, $hedef, 80, "", false);

        UrunResim::updateOrCreate(
            ['urun_id' => $urunId, 'tip' => 1],
            ['resim_url' => $hedef]
        );

        return $hedef;
    }

    /**
     * Ek resimleri kaydeder ve veritabanına yazar.
     * 
     * @param array $resimler Yüklenecek ek resim dosyaları
     * @param int|null $urunId Ürün ID'si (isteğe bağlı)
     * @return array Kaydedilen resimlerin yolları
     */
   public function ekResimleriKaydet(array $dosyalar, string $urunSlug, $urunId = null): array
{
    $klasor = 'urun_resim/' . $urunSlug . '/normal_resim';
    $dosyaYollari = [];

    // Eski ek resimleri/dosyaları sil
    UrunResim::where('urun_id', $urunId)
        ->where('tip', 2)
        ->each(function ($resim) {
            if (Storage::exists($resim->resim_url)) {
                Storage::delete($resim->resim_url);
            }
            $resim->delete();
        });

    // Yeni dosyaları kaydet
    foreach ($dosyalar as $key => $dosya) {
        $uzanti = strtolower($dosya->getClientOriginalExtension());
        $dosyaAdi = $urunSlug . time() . $key . '.' . $uzanti;
        $hedef = $klasor . '/' . $dosyaAdi;

        if (in_array($dosya->getClientMimeType(), ['image/png', 'image/jpeg', 'image/webp'])) {
            // Resim dosyası ise webp'e dönüştür
            WebpDonusturHelper::webpDonustur($dosya, $hedef, 80, "", false);
        } else {
            // PDF veya diğer dosyaları olduğu gibi kaydet
            Storage::putFileAs($klasor, $dosya, $dosyaAdi);
        }

        $dosyaYollari[] = $hedef;

        // Veritabanında kaydı oluştur
        UrunResim::create([
            'urun_id' => $urunId,
            'resim_url' => $hedef,
            'tip' => 2,
        ]);
    }

    return $dosyaYollari;
}
    public function tumResimleriSil(int $urunId): void
    {
        $resimler = UrunResim::where('urun_id', $urunId)->get();

        foreach ($resimler as $resim) {
            if (Storage::exists($resim->resim_url)) {
                Storage::delete($resim->resim_url);
            }
            $resim->delete();
        }
    }
}
