<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SifreSifirlaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return !(Auth::guard('web')->check());
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
