<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IletisimFormRequest extends FormRequest
{
    /**
     * Kullanıcının bu isteği yapmaya yetkili olup olmadığını belirler.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * İsteğe uygulanacak doğrulama kuralları.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'isimSoyisim' => 'required|string|max:255',
            'telefon' => 'required|string|regex:/^\+?[0-9\s\-]{10,20}$/',
            'eposta' => 'required|email|max:255',
            'mesaj' => 'required|string|max:5000',
        ];
    }
}
