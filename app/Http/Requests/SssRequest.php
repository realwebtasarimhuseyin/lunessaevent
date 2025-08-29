<?php

namespace App\Http\Requests;

use App\Enums\DilEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class SssRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return yetkiKontrol(['sss-ekle', 'sss-duzenle']);
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
                    "baslik_{$dil}" => $input["baslik_{$dil}"] ?? '',
                    "icerik_{$dil}" => $input["icerik_{$dil}"] ?? '',
                ]);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $diller = config('app.supported_locales');
        $rules = [
            'durum' => 'required|boolean',
        ];

        foreach ($diller as $dil) {
            $rules["baslik_{$dil}"] = 'required|string|max:255';
            $rules["icerik_{$dil}"] = 'required|string';
        }

        return $rules;
    }

    /**
     * Get the custom validation messages for attributes.
     *
     * @return array
     */
    public function messages(): array
    {
        $diller = config('app.supported_locales');
        $messages = [
            'durum.required' => 'Durum alanı gereklidir.',
            'durum.boolean' => 'Durum geçerli bir boolean olmalıdır.',
        ];

        foreach ($diller as $dil) {
            $dilEnum = DilEnum::fromValue($dil);
            if ($dilEnum) {
                $dilValue = $dilEnum->value; 
    
                $messages["baslik_{$dil}.required"] = 'Sss Başlık (' . $dilValue . ') alanı boş bırakılamaz.';
                $messages["baslik_{$dil}.max"] = 'Sss Başlık (' . $dilValue . ') en fazla 150 karakter olabilir.';
                $messages["icerik_{$dil}.required"] = 'İçerik alanı (' . $dilValue . ') boş bırakılamaz.';
             
            }
        }

        return $messages;
    }
}
