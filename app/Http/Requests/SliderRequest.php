<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SliderRequest extends FormRequest
{
    /**
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        return yetkiKontrol(['slider-ekle', 'slider-duzenle']);
    }

    protected function prepareForValidation()
    {
        $diller = Config::get('app.supported_locales');
        foreach ($diller as $dil) {
            $input = json_decode($this->input($dil), true);
            if (is_array($input)) {
                $this->merge([
                    "baslik_{$dil}" => $input["baslik_{$dil}"] ?? '',
                    "alt_baslik_{$dil}" => $input["altBaslik_{$dil}"] ?? '',
                    "buton_icerik_{$dil}" => $input["butonIcerik_{$dil}"] ?? '',
                    "buton_url_{$dil}" => $input["butonUrl_{$dil}"] ?? '',
                ]);
            }
        }
    }

    public function rules(): array
    {
        $diller = config('app.supported_locales');
        $rules = [];
        

        return $rules;
    }

    public function messages(): array
    {
        $diller = config('app.supported_locales');
        $messages = [];
        
        return $messages;
    }
}
