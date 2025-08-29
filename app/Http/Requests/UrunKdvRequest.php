<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UrunKdvRequest extends FormRequest
{
    /**
     * Kullanıcının bu isteği yapmaya yetkili olup olmadığını belirler.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return yetkiKontrol(['urun-kdv-ekle', 'urun-kdv-duzenle']);
    }

    /**
     * İsteğe uygulanacak doğrulama kuralları.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'kdv' => 'nullable|numeric|min:0|max:100',
        ];

        return $rules;
    }
}
