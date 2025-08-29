<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminRequest extends FormRequest
{
    /**
     * Kullanıcının bu isteği yapmaya yetkili olup olmadığını belirler.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return yetkiKontrol(['admin-ekle', 'admin-duzenle']);
    }

    /**
     * İsteğe uygulanacak doğrulama kuralları.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'isim' => 'required|string|max:255', // İsim zorunlu ve string olmalı, en fazla 255 karakter
            'soyisim' => 'required|string|max:255', // Soyisim zorunlu ve string olmalı, en fazla 255 karakter
            'eposta' => 'required|email|max:255', // E-posta zorunlu, geçerli bir e-posta adresi olmalı, 255 karakteri geçmemeli ve benzersiz olmalı
            'sifre' => 'nullable|string', // Şifre opsiyonel, string olmalı, en az 8 karakter uzunluğunda olmalı ve şifre tekrar doğrulama yapılmalı
            'durum' => 'required|boolean', // Durum zorunlu ve boolean olmalı
        ];
    }

    /**
     * Hata mesajları.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'isim.required' => 'İsim alanı zorunludur.',
            'isim.string' => 'İsim alanı metin formatında olmalıdır.',
            'isim.max' => 'İsim alanı en fazla 255 karakter olmalıdır.',
            'soyisim.required' => 'Soyisim alanı zorunludur.',
            'soyisim.string' => 'Soyisim alanı metin formatında olmalıdır.',
            'soyisim.max' => 'Soyisim alanı en fazla 255 karakter olmalıdır.',
            'eposta.required' => 'E-posta alanı zorunludur.',
            'eposta.email' => 'Geçerli bir e-posta adresi giriniz.',
            'eposta.max' => 'E-posta adresi en fazla 255 karakter olmalıdır.',
            'eposta.unique' => 'Bu e-posta adresi zaten kullanımda.',
            'sifre.string' => 'Şifre metin formatında olmalıdır.',
            'sifre.min' => 'Şifre en az 8 karakter uzunluğunda olmalıdır.',
            'durum.required' => 'Durum alanı zorunludur.',
            'durum.boolean' => 'Durum sadece true veya false olmalıdır.',
        ];
    }
}
