<?php

namespace App\Http\Requests;

use App\Enums\DilEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class UrunRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return yetkiKontrol(['urun-ekle', 'urun-duzenle']);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $diller = Config::get('app.supported_locales');
        foreach ($diller as $dil) {
            $input = json_decode($this->input($dil), true);
            if (is_array($input)) {
                $this->merge([
                    "baslik_{$dil}" => $input["baslik_{$dil}"] ?? '',
                    "icerik_{$dil}" => $input["icerik_{$dil}"] ?? '',
                    "metaBaslik_{$dil}" => $input["metaBaslik_{$dil}"] ?? '',
                    "metaIcerik_{$dil}" => $input["metaIcerik_{$dil}"] ?? '',
                    "metaAnahtar_{$dil}" => $input["metaAnahtar_{$dil}"] ?? '',
                ]);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $diller = config('app.supported_locales');
        $rules = [
            'urunKategoriId' => 'required|integer|exists:urun_kategori,id',
            'stokAdet' => 'required|numeric|min:0',
            'kdvDurum' => 'required|boolean',
            'birimFiyat' => 'required|numeric|min:0',
            'kdvOran' => 'required|numeric|min:0',
            'durum' => 'required|boolean',
        ];

        foreach ($diller as $dil) {
            $rules["baslik_{$dil}"] = 'required|string|max:255';
            $rules["icerik_{$dil}"] = 'required|string';
            $rules["metaBaslik_{$dil}"] = 'required|string|max:255';
            $rules["metaIcerik_{$dil}"] = 'required|string';
            $rules["metaAnahtar_{$dil}"] = 'required|string|max:255';
        }

        return $rules;
    }

    /**
     * Get the custom validation messages for attributes.
     *
     * @return array
     */
    public function messages(): array
    {
        $diller = config('app.supported_locales');
        $messages = [
            'urunKategoriId.required' => 'Ürün kategori ID alanı gereklidir.',
            'urunKategoriId.integer' => 'Ürün kategori ID geçerli bir tam sayı olmalıdır.',
            'urunKategoriId.exists' => 'Seçilen ürün kategori ID geçerli değil.',
            'stokAdet.required' => 'Stok adet alanı gereklidir.',
            'stokAdet.numeric' => 'Stok adet geçerli bir sayı olmalıdır.',
            'stokAdet.min' => 'Stok adet 0\'dan küçük olamaz.',
            'kdvDurum.required' => 'KDV durum alanı gereklidir.',
            'kdvDurum.boolean' => 'KDV durum geçerli bir boolean olmalıdır.',
            'birimFiyat.required' => 'Birim fiyat alanı gereklidir.',
            'birimFiyat.numeric' => 'Birim fiyat geçerli bir sayı olmalıdır.',
            'birimFiyat.min' => 'Birim fiyat 0\'dan küçük olamaz.',
            'kdvOran.required' => 'KDV oranı alanı gereklidir.',
            'kdvOran.numeric' => 'KDV oranı geçerli bir sayı olmalıdır.',
            'kdvOran.min' => 'KDV oranı 0\'dan küçük olamaz.',
            'indirimYuzde.required' => 'İndirim yüzdesi alanı gereklidir.',
            'indirimYuzde.numeric' => 'İndirim yüzdesi geçerli bir sayı olmalıdır.',
            'indirimYuzde.min' => 'İndirim yüzdesi 0\'dan küçük olamaz.',
            'indirimTutar.required' => 'İndirim tutarı alanı gereklidir.',
            'indirimTutar.numeric' => 'İndirim tutarı geçerli bir sayı olmalıdır.',
            'indirimTutar.min' => 'İndirim tutarı 0\'dan küçük olamaz.',
            'durum.required' => 'Durum alanı gereklidir.',
            'durum.boolean' => 'Durum geçerli bir boolean olmalıdır.',
        ];

        foreach ($diller as $dil) {
            $dilEnum = DilEnum::fromValue($dil);
            if ($dilEnum) {
                $dilValue = $dilEnum->value; 
    
                $messages["baslik_{$dil}.required"] = 'Ürün başlığı (' . $dilValue . ') alanı boş bırakılamaz.';
                $messages["baslik_{$dil}.max"] = 'Ürün başlığı (' . $dilValue . ') en fazla 150 karakter olabilir.';
                $messages["icerik_{$dil}.required"] = 'İçerik alanı (' . $dilValue . ') boş bırakılamaz.';
                $messages["metaBaslik_{$dil}.required"] = 'Meta başlığı (' . $dilValue . ') seçimi zorunludur.';
                $messages["metaBaslik_{$dil}.max"] = 'Meta başlığı (' . $dilValue . ') en fazla 150 karakter olabilir.';
                $messages["metaIcerik_{$dil}.required"] = 'Meta içerik (' . $dilValue . ') alanı boş bırakılamaz.';
                $messages["metaIcerik_{$dil}.max"] = 'Meta içerik (' . $dilValue . ') en fazla 1000 karakter olabilir.';
                $messages["metaAnahtar_{$dil}.required"] = 'Meta anahtar (' . $dilValue . ') alanı boş bırakılamaz.';
                $messages["metaAnahtar_{$dil}.max"] = 'Meta anahtar (' . $dilValue . ') en fazla 150 karakter olabilir.';
            }
        }

        return $messages;
    }
}
