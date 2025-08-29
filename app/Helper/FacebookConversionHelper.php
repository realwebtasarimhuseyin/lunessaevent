<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Services\FacebookConversionServis;

class FacebookConversionHelper
{
    public static function send(string $eventName, array $customData, array $options = [])
    {
        $conversionService = new FacebookConversionServis();

        $eventData = [
            'event_name' => $eventName,
            'event_time' => time(),
            'event_source_url' => url()->current(),
            'action_source' => 'website',
            'user_data' => [
                'client_ip_address' => Request::ip(),
                'client_user_agent' => Request::header('User-Agent'),
            ],
            'custom_data' => $customData,
        ];

        // Kullanıcı giriş yaptıysa kullanıcı bilgilerini hash'leyerek ekle
        if (Auth::check()) {
            $user = Auth::user();
            $isimParcalari = explode(' ', $user->ad_soyad);

            $eventData['user_data'] = array_merge($eventData['user_data'], [
                'em' => hash('sha256', strtolower(trim($user->email ?? ''))),
                'ph' => hash('sha256', preg_replace('/\D/', '', $user->telefon ?? '')),
                'fn' => hash('sha256', strtolower(trim($isimParcalari[0] ?? ''))),
                'ln' => hash('sha256', strtolower(trim($isimParcalari[1] ?? ''))),
                'ct' => hash('sha256', 'istanbul'),
                'st' => hash('sha256', 'istanbul'),
                'zp' => hash('sha256', '34000'),
                'country' => hash('sha256', 'tr'),
            ]);
        } else {
            // Misafir kullanıcı için varsayılan değerler
            $eventData['user_data'] = array_merge($eventData['user_data'], [
                'fn' => hash('sha256', 'misafir'),
                'ln' => hash('sha256', 'kullanici'),
                'ct' => hash('sha256', 'istanbul'),
                'st' => hash('sha256', 'istanbul'),
                'zp' => hash('sha256', '34000'),
                'country' => hash('sha256', 'tr'),
            ]);
        }

        return $conversionService->sendEvent($eventData);
    }
}
