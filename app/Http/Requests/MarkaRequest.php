<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MarkaRequest extends FormRequest
{
    /**
     * Kullanıcının bu isteği yapmaya yetkili olup olmadığını belirler.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * İsteğe uygulanacak doğrulama kuralları.
     */
    public function rules(): array
    {
        return [
            'isim' => 'required|string|max:255', // İsim alanı zorunlu, string ve maksimum 255 karakter
            'durum' => 'required|boolean', // Durum alanı zorunlu, boolean (true/false)
        ];
    }

    /**
     * Hata mesajları.
     */
    public function messages(): array
    {
        return [
            'isim.required' => 'İsim alanı zorunludur.',
            'isim.string' => 'İsim alanı geçerli bir metin olmalıdır.',
            'isim.max' => 'İsim alanı en fazla 255 karakter olabilir.',
            'durum.required' => 'Durum alanı zorunludur.',
            'durum.boolean' => 'Durum alanı geçerli bir değer olmalıdır (true/false).',
        ];
    }
}
