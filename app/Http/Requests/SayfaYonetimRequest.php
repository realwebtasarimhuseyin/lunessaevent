<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SayfaYonetimRequest extends FormRequest
{
    /**
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        return yetkiKontrol(['sayfayonetim-duzenle']);
    }

    protected function prepareForValidation()
    {
        $diller = Config::get('app.supported_locales');
        foreach ($diller as $dil) {
            $input = json_decode($this->input($dil), true);
            if (is_array($input)) {
                $this->merge([
                    "icerik_{$dil}" => $input["icerik_{$dil}"] ?? '',
                    "sayfaIcerikBaslik_{$dil}" => $input["sayfaIcerikBaslik_{$dil}"] ?? '',
                    "metaBaslik_{$dil}" => $input["metaBaslik_{$dil}"] ?? '',
                    "metaIcerik_{$dil}" => $input["metaIcerik_{$dil}"] ?? '',
                    "metaAnahtar_{$dil}" => $input["metaAnahtar_{$dil}"] ?? '',
                ]);
            }
        }
    }

    public function rules(): array
    {
        $diller = config('app.supported_locales');
        $rules = [];
        foreach ($diller as $dil) {
            $rules["sayfaIcerikBaslik_{$dil}"] = 'required|string|max:150';
            $rules["metaBaslik_{$dil}"] = 'required|string|max:150';
            $rules["metaIcerik_{$dil}"] = 'required|string|max:600';
            $rules["metaAnahtar_{$dil}"] = 'required|string|max:150';
        }

        return $rules;
    }


    public function messages(): array
    {
        $diller = config('app.supported_locales');
        $messages = [];
        foreach ($diller as $dil) {
            $messages["icerik_{$dil}.required"] = 'İçerik alanı (' . $dil . ') boş bırakılamaz.';
            $messages["sayfaIcerikBaslik_{$dil}.required"] = 'Başlığı (' . $dil . ') boş bırakılamaz.';
            $messages["sayfaIcerikBaslik_{$dil}.max"] = 'Meta başlığı (' . $dil . ') geçerli bir tam sayı olmalıdır.';
            $messages["metaBaslik_{$dil}.required"] = 'Meta başlığı (' . $dil . ') seçimi zorunludur.';
            $messages["metaBaslik_{$dil}.max"] = 'Meta başlığı (' . $dil . ') geçerli bir tam sayı olmalıdır.';
            $messages["metaIcerik_{$dil}.required"] = 'Meta içerik (' . $dil . ') alanı boş bırakılamaz.';
            $messages["metaIcerik_{$dil}.max"] = 'Meta içerik (' . $dil . ') en fazla 600 karakter olabilir.';
            $messages["metaAnahtar_{$dil}.required"] = 'Meta anahtar (' . $dil . ') alanı boş bırakılamaz.';
            $messages["metaAnahtar_{$dil}.max"] = 'Meta anahtar (' . $dil . ') en fazla 150 karakter olabilir.';
        }
        return $messages;
    }
}
