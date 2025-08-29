<?php

namespace App\Http\Requests;

use App\Enums\DilEnum;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KatalogRequest extends FormRequest
{
    /**
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }
    protected function prepareForValidation()
    {
        $diller = Config::get('app.supported_locales');
        foreach ($diller as $dil) {
            $input = json_decode($this->input($dil), true);
            if (is_array($input)) {
                $this->merge([

                    "baslik_{$dil}" => $input["baslik_{$dil}"] ?? '',

                ]);
            }
        }
    }
    public function rules(): array
    {
        $diller = config('app.supported_locales');

        foreach ($diller as $dil) {

            $rules["baslik_{$dil}"] = 'required|string';
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

                $messages["baslik_{$dil}.required"] = 'Katalog başlığı (' . $dilValue . ') alanı boş bırakılamaz.';
                $messages["baslik_{$dil}.max"] = 'Katalog başlığı (' . $dilValue . ') en fazla 255 karakter olabilir.';
            }
        }
        return $messages;
    }
}
