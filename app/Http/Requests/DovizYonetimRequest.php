<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DovizYonetimRequest extends FormRequest
{
    /**
     * Kullanıcının bu isteği yapmaya yetkili olup olmadığını belirler.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }


    /**
     * İsteğe uygulanacak doğrulama kuralları.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'yuzde' => 'nullable|numeric|min:0|max:100', 
            'birim' => 'nullable|numeric|min:0', 
        ];

        return $rules;
    }
}
