<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GaleriRequest extends FormRequest
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
        $rules = [];
        foreach ($diller as $dil) {
            $rules["baslik_{$dil}"] = 'required|string|max:150';
        }

        return $rules;
    }

    public function messages(): array
    {
        $diller = config('app.supported_locales');
        $messages = [];
        foreach ($diller as $dil) {
            $messages["baslik_{$dil}.required"] = 'Görsel başlığı (' . $dil . ') alanı boş bırakılamaz.';
            $messages["baslik_{$dil}.max"] = 'Görsel başlığı (' . $dil . ') en fazla 150 karakter olabilir.';
        }
        return $messages;
    }
}
