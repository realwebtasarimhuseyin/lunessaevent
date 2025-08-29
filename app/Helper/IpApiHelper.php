<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpApiHelper
{

    /**
     * IP adresiyle ilgili bilgileri alır.
     *
     * @param string $ip
     * @return array|null
     */

    public static function getIpInfo(): ?array
    {
            $ip = request()->ip();

            $url = "http://ip-api.com/json/{$ip}";
            $ipInfo = [];

            try {
                $response = Http::get($url);

                if ($response->successful()) {
                    $ipInfo = $response->json();
                }
            } catch (\Exception $e) {
                // Log the error if IP info cannot be retrieved
                Log::error("IP bilgisi alınamadı: " . $e->getMessage() . " | " . request()->ip());
            }
        
            

        return $ipInfo;
    }
}
