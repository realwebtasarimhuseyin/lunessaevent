<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DuyuruRequest extends FormRequest
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
                    "icerik_{$dil}" => $input["icerik_{$dil}"] ?? '',
                ]);
            }
        }
    }

    public function rules(): array
    {
        $diller = config('app.supported_locales');
        $rules = [];
        foreach ($diller as $dil) {
            $rules["icerik_{$dil}"] = 'required|string|max:255';
        }

        return $rules;
    }

    public function messages(): array
    {
        $diller = config('app.supported_locales');
        $messages = [];
        foreach ($diller as $dil) {
            $messages["icerik_{$dil}.required"] = 'Duyuru içerik alanı (' . $dil . ') boş bırakılamaz.';
            $messages["icerik_{$dil}.max"] = 'Duyuru içerik (' . $dil . ') en fazla 255 karakter olabilir.';
        }
        return $messages;
    }
}
