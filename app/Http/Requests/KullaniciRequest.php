<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KullaniciRequest extends FormRequest
{
    /**
     * Kullanıcının bu isteği yapmaya yetkili olup olmadığını belirler.
     */
    public function authorize(): bool
    {
        return yetkiKontrol(['kullanici-ekle', 'kullanici-duzenle']);
    }


    /**
     * İsteğe uygulanacak doğrulama kuralları.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'isim_soyisim' => 'required|string|max:300',
            'eposta' => 'required|email|max:200|unique:kullanici,eposta',
            'telefon' => 'required|string|regex:/^\+?[0-9\s\-]{10,20}$/',
            'sifre' => 'required|string|min:8|max:100',
        ];
    }

    /**
     * Hata mesajlarını özelleştirme.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'isim_soyisim.required' => 'İsim alanı zorunludur.',
            'isim_soyisim.max' => 'İsim en fazla 300 karakter olabilir.',
            'eposta.required' => 'E-posta alanı zorunludur.',
            'eposta.email' => 'Geçerli bir e-posta adresi girin.',
            'eposta.unique' => 'Bu e-posta adresi zaten kullanılıyor.',
            'telefon.required' => 'Telefon alanı zorunludur.',
            'telefon.regex' => 'Telefon numarası geçersiz. Örnek: +905555555555',
            'sifre.required' => 'Şifre alanı zorunludur.',
            'sifre.min' => 'Şifre en az 8 karakter olmalıdır.',
            'sifre.max' => 'Şifre en fazla 100 karakter olabilir.',
        ];
    }
}
