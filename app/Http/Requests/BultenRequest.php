<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BultenRequest extends FormRequest
{
    /**
     * Kullanıcının bu isteği yapmaya yetkili olup olmadığını belirler.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * İsteğe uygulanacak doğrulama kuralları.
     */
    public function rules(): array
    {
        return [
            'eposta' => 'required|email',
        ];
    }
}
