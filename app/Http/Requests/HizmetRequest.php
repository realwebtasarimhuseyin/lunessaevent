<?php

namespace App\Http\Requests;

use App\Enums\DilEnum;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class HizmetRequest extends FormRequest
{
   /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
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
                    "kisaIcerik_{$dil}" => $input["kisaIcerik_{$dil}"] ?? '',
                    "icerik_{$dil}" => $input["icerik_{$dil}"] ?? '',
                    "metaBaslik_{$dil}" => $input["metaBaslik_{$dil}"] ?? '',
                    "metaIcerik_{$dil}" => $input["metaIcerik_{$dil}"] ?? '',
                    "metaAnahtar_{$dil}" => $input["metaAnahtar_{$dil}"] ?? '',
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
            $rules["baslik_{$dil}"] = 'required|string|max:150';
            $rules["kisaIcerik_{$dil}"] = 'required|string';
            $rules["icerik_{$dil}"] = 'required|string';
            $rules["metaBaslik_{$dil}"] = 'required|string|max:150';
            $rules["metaIcerik_{$dil}"] = 'required|string';
            $rules["metaAnahtar_{$dil}"] = 'required|string|max:150';
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
    
                $messages["baslik_{$dil}.required"] = 'Ürün başlığı (' . $dilValue . ') alanı boş bırakılamaz.';
                $messages["baslik_{$dil}.max"] = 'Ürün başlığı (' . $dilValue . ') en fazla 150 karakter olabilir.';
                $messages["icerik_{$dil}.required"] = 'İçerik alanı (' . $dilValue . ') boş bırakılamaz.';
                $messages["metaBaslik_{$dil}.required"] = 'Meta başlığı (' . $dilValue . ') seçimi zorunludur.';
                $messages["metaBaslik_{$dil}.max"] = 'Meta başlığı (' . $dilValue . ') en fazla 150 karakter olabilir.';
                $messages["metaIcerik_{$dil}.required"] = 'Meta içerik (' . $dilValue . ') alanı boş bırakılamaz.';
                $messages["metaIcerik_{$dil}.max"] = 'Meta içerik (' . $dilValue . ') en fazla 1000 karakter olabilir.';
                $messages["metaAnahtar_{$dil}.required"] = 'Meta anahtar (' . $dilValue . ') alanı boş bırakılamaz.';
                $messages["metaAnahtar_{$dil}.max"] = 'Meta anahtar (' . $dilValue . ') en fazla 150 karakter olabilir.';
            }
        }

        return $messages;
    }
}
