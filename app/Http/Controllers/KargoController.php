<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SuratKargo;

class KargoController extends Controller
{
    public function createCargo(Request $request)
    {
        $kargo = new SuratKargo([
            'username' => env('SURAT_KARGO_USERNAME'),
            'password' => env('SURAT_KARGO_PASSWORD')
        ]);

        $kargoBilgileri = $request->all();
        $response = $kargo->createCargo($kargoBilgileri);

        //\Log::info('API Yanıtı:', (array) $response);

        if (isset($response->GonderiyiKargoyaGonderYeniResult) && $response->GonderiyiKargoyaGonderYeniResult === "Tamam") {
            return response()->json([
                'success' => true,
                'message' => 'Kargo başarıyla gönderildi!',
                'GonderiyiKargoyaGonderYeniResult' => $response->GonderiyiKargoyaGonderYeniResult
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kargo oluşturulamadı.',
                'GonderiyiKargoyaGonderYeniResult' => $response->GonderiyiKargoyaGonderYeniResult ?? 'Bilinmeyen hata'
            ]);
        }
    }

    /*public function trackCargo(Request $request)
    {
        $kargo = new SuratKargo([
            'username' => env('SURAT_KARGO_USERNAME'),
            'password' => env('SURAT_KARGO_PASSWORD')
        ]);

        // Kullanıcıdan gelen takip numarası
        $cargoKeys = $request->input('cargoKeys');

        $response = $kargo->cargoStatus(['cargoKeys' => $cargoKeys]);

        if (isset($response->queryShipmentResult)) {
            return response()->json([
                'success' => true,
                'message' => 'Kargo durumu başarıyla sorgulandı!',
                'cargoStatus' => $response->queryShipmentResult
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kargo durumu sorgulanamadı.',
                'error' => 'Bilinmeyen hata veya geçersiz takip numarası.'
            ]);
        }
    }*/

    public function trackCargo($cargoKey = null)
    {
        if (request()->has('cargoKey')) {
            return redirect('/kargo-takip/' . request()->cargoKey);
        }

        if (!$cargoKey) {
            return view('web.kargo-takip');
        }

        $kargo = new SuratKargo([
            'username' => env('SURAT_KARGO_USERNAME'),
            'password' => env('SURAT_KARGO_PASSWORD')
        ]);

        $data = ['cargoKeys' => $cargoKey];
        $response = $kargo->cargoStatus($data);

        $shipmentStatus = 'Kargo durumu bulunamadı.';
        if ($response && isset($response->KargoTakipHareketDetayliResult)) {
            $shipmentStatus = $response->KargoTakipHareketDetayliResult;
        }

        return view('web.kargo-takip', ['cargoStatus' => $shipmentStatus]);
    }
      
}
