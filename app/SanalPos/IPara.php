<?php

namespace App\SanalPos;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class IPara
{
    private string $apiUrl;
    private string $mode;

    public function __construct()
    {
        $this->apiUrl = 'https://api.ipara.com/rest/payment/threed';
        $this->mode = 'T'; // Test modunda çalıştırmak için
    }

    public function odemeYap(array $veriler): array
    {
        $gonderilecekVeriler = $this->verileriHazirla($veriler);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($this->apiUrl, $gonderilecekVeriler);

            if ($response->failed()) {
                Log::error('iPara API isteği başarısız.', [
                    'response' => $response->json(),
                ]);
                throw new Exception('iPara ödeme isteği başarısız.');
            }

            return $response->json();
        } catch (Exception $e) {
            Log::error('iPara API bağlantı hatası.', [
                'exception' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    private function verileriHazirla(array $veriler): array
    {
        $token = $this->tokenOlustur($veriler);

        return array_merge($veriler, [
            'mode' => $this->mode,
            'token' => $token,
        ]);
    }

    private function tokenOlustur(array $veriler): string
    {
        $privateKey = env('IPARA_PRIVATE_KEY');
        $publicKey = env('IPARA_PUBLIC_KEY');

        $rawData = $privateKey . $veriler['orderId'] . $this->mode . $veriler['transactionDate'];
        $hashedData = base64_encode(sha1($rawData, true));

        return $publicKey . ':' . $hashedData;
    }
}
