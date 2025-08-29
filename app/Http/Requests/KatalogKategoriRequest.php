<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KatalogKategoriRequest extends FormRequest
{
    /**
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        return yetkiKontrol(['katalog-kategori-ekle', 'katalog-kategori-duzenle']);
    }

    protected function prepareForValidation()
    {
        $diller = Config::get('app.supported_locales');
        foreach ($diller as $dil) {
            $input = json_decode($this->input($dil), true);
            if (is_array($input)) {
                $this->merge([
                    "isim_{$dil}" => $input["isim_{$dil}"] ?? '',
                ]);
            }
        }
    }

    public function rules(): array
    {
        $diller = config('app.supported_locales');
        $rules = [];
        foreach ($diller as $dil) {
            $rules["isim_{$dil}"] = 'required|string|max:150';
        }

        return $rules;
    }

    public function messages(): array
    {
        $diller = config('app.supported_locales');
        $messages = [];
        foreach ($diller as $dil) {
            $messages["isim_{$dil}.required"] = 'Katalog Kategori isim (' . $dil . ') alanı boş bırakılamaz.';
            $messages["isim_{$dil}.max"] = 'Katalog Kategori isim (' . $dil . ') en fazla 150 karakter olabilir.';
        }
        return $messages;
    }
}
