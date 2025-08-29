<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookConversionServis
{
    protected $accessToken;
    protected $pixelId;
    protected $testEventCode;

    public function __construct()
    {
        $this->accessToken = config('services.meta.access_token');
        $this->pixelId = config('services.meta.pixel_id');
        $this->testEventCode = config('services.meta.test_kod');
    }

    public function sendEvent(array $eventData)
    {
        // Cookie'lerden fbp ve fbc'yi çek
        $fbp = request()->cookie('_fbp');
        $fbc = request()->cookie('_fbc');

        // user_data içinde varsa ekleyelim
        if (!isset($eventData['user_data'])) {
            $eventData['user_data'] = [];
        }

        if ($fbp) {
            $eventData['user_data']['fbp'] = $fbp;
        }

        if ($fbc) {
            $eventData['user_data']['fbc'] = $fbc;
        }

        $payload = [
            'data' => [$eventData],
        ];

        if ($this->testEventCode) {
            $payload['test_event_code'] = $this->testEventCode;
        }

        try {
            $response = Http::withToken($this->accessToken)
                ->post("https://graph.facebook.com/v19.0/{$this->pixelId}/events", $payload);

            $result = $response->json();

            Log::info('Meta Conversion API Yanıtı', [
                'request' => $payload,
                'response' => $result,
                'test_kodu' => $this->testEventCode
            ]);

            return $result;

        } catch (\Throwable $e) {
            Log::error('Meta Conversion API Hatası', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);

            return ['error' => $e->getMessage()];
        }
    }
}
