<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PopupRequest extends FormRequest
{
    /**
     * Kullanıcının bu isteği yapmaya yetkili olup olmadığını belirler.
     */
    public function authorize(): bool
    {
        return yetkiKontrol(['popup-ekle', 'popup-duzenle']);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $diller = Config::get('app.supported_locales');
        foreach ($diller as $dil) {
            $input = json_decode($this->input($dil), true);
            if (is_array($input)) {
                $this->merge([
                    "baslik_{$dil}" => $input["baslik"] ?? '',
                    "icerik_{$dil}" => $input["icerik"] ?? '',
                ]);
            }
        }
    }

    /**
     * İsteğe uygulanacak doğrulama kuralları.
     */
    public function rules(): array
    {
        return [
            'baslangic_tarih' => 'required|date_format:d.m.Y H:i|before:bitis_tarih', // Belirli formatta ve bitiş tarihinden önce olmalı
            'bitis_tarih' => 'required|date_format:d.m.Y H:i|after:baslangic_tarih', // Belirli formatta ve başlangıç tarihinden sonra olmalı
        ];
    }
}
