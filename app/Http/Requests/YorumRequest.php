<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class YorumRequest extends FormRequest
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
        $rules = [
            'kisiIsim' => 'required|string',
            'kisiUnvan' => 'required|string',
            'durum' => 'required|boolean',
        ];
        foreach ($diller as $dil) {
            $rules["icerik_{$dil}"] = 'required|string';
        }
        return $rules;
    }

    public function messages(): array
    {
        $diller = config('app.supported_locales');
        $messages = [];
        foreach ($diller as $dil) {
            $messages["icerik_{$dil}.required"] = 'Yorum içerik alanı (' . $dil . ') boş bırakılamaz.';
        }
        return $messages;
    }
}
