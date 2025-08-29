<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BlogRequest extends FormRequest
{
    /**
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        return yetkiKontrol(['blog-ekle', 'blog-duzenle']);
    }

    protected function prepareForValidation()
    {
        $diller = Config::get('app.supported_locales');
        foreach ($diller as $dil) {
            $input = json_decode($this->input($dil), true);
            if (is_array($input)) {
                $this->merge([
                    "baslik_{$dil}" => $input["baslik_{$dil}"] ?? '',
                    "icerik_{$dil}" => $input["icerik_{$dil}"] ?? '',
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
            $rules["baslik_{$dil}"] = 'required|string|max:255';
            $rules["icerik_{$dil}"] = 'required|string';
            $rules["metaBaslik_{$dil}"] = 'required|string|max:255';
            $rules["metaIcerik_{$dil}"] = 'required|string';
            $rules["metaAnahtar_{$dil}"] = 'required|string|max:255';
        }

        return $rules;
    }


    public function messages(): array
    {
        $diller = config('app.supported_locales');
        $messages = [];
        foreach ($diller as $dil) {
            $messages["baslik_{$dil}.required"] = 'Blog başlığı (' . $dil . ') alanı boş bırakılamaz.';
            $messages["baslik_{$dil}.max"] = 'Blog başlığı (' . $dil . ') en fazla 255 karakter olabilir.';
            $messages["icerik_{$dil}.required"] = 'İçerik alanı (' . $dil . ') boş bırakılamaz.';
            $messages["metaBaslik_{$dil}.required"] = 'Meta başlığı (' . $dil . ') seçimi zorunludur.';
            $messages["metaBaslik_{$dil}.max"] = 'Meta başlığı (' . $dil . ') en fazla 255 karakter olabilir.';
            $messages["metaIcerik_{$dil}.required"] = 'Meta içerik (' . $dil . ') alanı boş bırakılamaz.';
            $messages["metaAnahtar_{$dil}.required"] = 'Meta anahtar (' . $dil . ') alanı boş bırakılamaz.';
            $messages["metaAnahtar_{$dil}.max"] = 'Meta anahtar (' . $dil . ') en fazla 255 karakter olabilir.';
        }
        return $messages;
    }
}
