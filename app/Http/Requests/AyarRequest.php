<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AyarRequest extends FormRequest
{
    public function authorize()
    {
        return yetkiKontrol(['ayar-duzenle']);
    }

    public function rules()
    {
        $diller = config('app.supported_locales');

        $rules = [
            'eposta' => 'required|email',
            'telefon' => 'required|string|max:20',
            'faks' => 'nullable|string|max:20',
            'adres' => 'nullable|string',
            'iframeLink' => 'nullable|url',

            'smtpSunucuAdresi' => 'required|string',
            'smtpPort' => 'required|integer',
            'smtpKullaniciAdi' => 'required|string',
            'smtpSifresi' => 'required|string',
            'guvenlikProtokolu' => 'required|string',
            'gonderenAdi' => 'required|string',
            'gonderenEpostaAdresi' => 'required|email',

            'ustLogo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'altLogo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',

           /*  'reklamBanner1Resim' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'reklamBanner1Link' => 'nullable|url',
            'reklamBanner2Resim' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'reklamBanner2Link' => 'nullable|url',
            'reklamBanner3Resim' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'reklamBanner3Link' => 'nullable|url',
            'reklamBanner4Resim' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'reklamBanner4Link' => 'nullable|url',

            'ortaBannerResim' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ortaBannerLink' => 'nullable|url', */
        ];

       

        return $rules;
    }

    public function messages()
    {
        $diller = config('app.supported_locales');
        $messages = [
            // Genel Alanlar
            'eposta.required' => 'E-posta alanı zorunludur.',
            'eposta.email' => 'Geçerli bir e-posta adresi giriniz.',
            'telefon.required' => 'Telefon alanı zorunludur.',
            'telefon.max' => 'Telefon alanı en fazla 20 karakter olabilir.',
            'faks.string' => 'Faks alanı metin olmalıdır.',
            'faks.max' => 'Faks alanı en fazla 20 karakter olabilir.',
            'adres.string' => 'Adres alanı metin olmalıdır.',
            'iframeLink.url' => 'Geçerli bir iframe bağlantısı giriniz.',
            
            // SMTP Alanları
            'smtpSunucuAdresi.required' => 'SMTP sunucu adresi zorunludur.',
            'smtpPort.required' => 'SMTP port alanı zorunludur.',
            'smtpPort.integer' => 'SMTP port alanı sayı olmalıdır.',
            'smtpKullaniciAdi.required' => 'SMTP kullanıcı adı zorunludur.',
            'smtpSifresi.required' => 'SMTP şifresi zorunludur.',
            'guvenlikProtokolu.required' => 'Güvenlik protokolü zorunludur.',
            'gonderenAdi.required' => 'Gönderen adı zorunludur.',
            'gonderenEpostaAdresi.required' => 'Gönderen e-posta adresi zorunludur.',
            'gonderenEpostaAdresi.email' => 'Geçerli bir gönderen e-posta adresi giriniz.',
            
            // Dosyalar
            'ustLogo.mimes' => 'Üst logo, jpeg, png, jpg, gif veya svg formatında olmalıdır.',
            'ustLogo.max' => 'Üst logo en fazla 2MB olabilir.',
            'altLogo.mimes' => 'Alt logo, jpeg, png, jpg, gif veya svg formatında olmalıdır.',
            'altLogo.max' => 'Alt logo en fazla 2MB olabilir.',
            'favicon.mimes' => 'Favicon, jpeg, png, jpg, gif, svg veya ico formatında olmalıdır.',
            'favicon.max' => 'Favicon en fazla 2MB olabilir.',
    
            // Reklam Bannerları
            /* 'reklamBanner1Resim.mimes' => 'Reklam banner 1 resmi, jpeg, png, jpg, gif veya svg formatında olmalıdır.',
            'reklamBanner1Resim.max' => 'Reklam banner 1 resmi en fazla 2MB olabilir.',
            'reklamBanner1Link.url' => 'Geçerli bir reklam banner 1 bağlantısı giriniz.',
            'reklamBanner2Resim.mimes' => 'Reklam banner 2 resmi, jpeg, png, jpg, gif veya svg formatında olmalıdır.',
            'reklamBanner2Resim.max' => 'Reklam banner 2 resmi en fazla 2MB olabilir.',
            'reklamBanner2Link.url' => 'Geçerli bir reklam banner 2 bağlantısı giriniz.',
            'reklamBanner3Resim.mimes' => 'Reklam banner 3 resmi, jpeg, png, jpg, gif veya svg formatında olmalıdır.',
            'reklamBanner3Resim.max' => 'Reklam banner 3 resmi en fazla 2MB olabilir.',
            'reklamBanner3Link.url' => 'Geçerli bir reklam banner 3 bağlantısı giriniz.',
            'reklamBanner4Resim.mimes' => 'Reklam banner 4 resmi, jpeg, png, jpg, gif veya svg formatında olmalıdır.',
            'reklamBanner4Resim.max' => 'Reklam banner 4 resmi en fazla 2MB olabilir.',
            'reklamBanner4Link.url' => 'Geçerli bir reklam banner 4 bağlantısı giriniz.',
    
            'ortaBannerResim.mimes' => 'Orta banner resmi, jpeg, png, jpg, gif veya svg formatında olmalıdır.',
            'ortaBannerResim.max' => 'Orta banner resmi en fazla 2MB olabilir.',
            'ortaBannerLink.url' => 'Geçerli bir orta banner bağlantısı giriniz.', */
        ];
    
       
    
        return $messages;
    }
    

}
