<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class YetkiRequest extends FormRequest
{

    public function authorize(): bool
    {
        return yetkiKontrol('super-admin');
    }

    public function rules(): array
    {
        return [
            'isim' => 'required|string|max:255',
            'yetkiler' => 'required|array',
        ];
    }
}
