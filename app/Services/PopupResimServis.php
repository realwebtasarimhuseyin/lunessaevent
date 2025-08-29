<?php

namespace App\Services;

use App\Models\Popup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class PopupResimServis
{
    /**
     * Ana resmi kaydeder ve veritabanına yazar.
     * 
     * @param UploadedFile $resim Yüklenecek ana resim dosyası
     * @param int|null $popupId Ürün ID'si (isteğe bağlı)
     * @return string Kaydedilen resmin yolu
     */
    public function resmiKaydet(UploadedFile $resim, string $popupBaslik, int $popupId)
    {
        $popup = Popup::firstWhere("id", $popupId);
        $popupSlug = Str::slug($popupBaslik);
        $klasor = 'popup_resim/' . $popupSlug;
        $resimAdi = $popupSlug . '-' . time() . '.' . $resim->extension();

        if (Storage::exists($klasor . '/' . $resimAdi)) {
            Storage::deleteDirectory($klasor . '/' . $resimAdi);
        }

        $resimYolu = $resim->storeAs($klasor, $resimAdi, 'public');
        $popup->resim_url = $resimYolu;

        return $popup->save();
    }
}
