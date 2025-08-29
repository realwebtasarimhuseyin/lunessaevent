<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KuponRequest extends FormRequest
{
    /**
     * Kullanıcının bu isteği yapmaya yetkili olup olmadığını belirler.
     */
    public function authorize(): bool
    {
        return yetkiKontrol(['kupon-ekle', 'kupon-duzenle']);
    }

    /**
     * İsteğe uygulanacak doğrulama kuralları.
     */
    public function rules(): array
    {
        return [
            'kod' => 'nullable|string|max:50|unique:kupon,kod',
            'adet' => 'required|integer|min:0',
            'baslangic_tarih' => 'required|date_format:d.m.Y H:i|after_or_equal:today|before:bitis_tarih',
            'bitis_tarih' => 'required|date_format:d.m.Y H:i|after:baslangic_tarih',
        ];
    }

    /**
     * Hata mesajları.
     */
    public function messages(): array
    {
        return [
            'kod.required' => 'Kupon kodu alanı zorunludur.',
            'kod.unique' => 'Bu kupon kodu zaten kullanılıyor. Lütfen farklı bir kod deneyin.',
            'kod.max' => 'Kupon kodu en fazla 50 karakter uzunluğunda olabilir.',
            'adet.required' => 'Kupon adeti alanı zorunludur.',
            'adet.integer' => 'Kupon adeti sayısal bir değer olmalıdır.',
            'adet.min' => 'Kupon adeti en az 0 olabilir.',
            'baslangic_tarih.required' => 'Başlangıç tarihi alanı zorunludur.',
            'baslangic_tarih.date_format' => 'Başlangıç tarihi formatı hatalı. Doğru format: GG.AA.YYYY SS:DD',
            'baslangic_tarih.after_or_equal' => 'Başlangıç tarihi bugünden önce olamaz.',
            'baslangic_tarih.before' => 'Başlangıç tarihi, bitiş tarihinden önce olmalıdır.',
            'bitis_tarih.required' => 'Bitiş tarihi alanı zorunludur.',
            'bitis_tarih.date_format' => 'Bitiş tarihi formatı hatalı. Doğru format: GG.AA.YYYY SS:DD',
            'bitis_tarih.after' => 'Bitiş tarihi, başlangıç tarihinden sonra olmalıdır.',
        ];
    }
}
