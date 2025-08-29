<?php

namespace App\Http\Controllers;

use App\Helper\FacebookConversionHelper;
use Illuminate\Http\Request;
use App\Models\Favori;
use App\Models\Urun;
use App\Services\FavoriServis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FavoriController extends Controller
{

    public function index()
    {
        $kullaniciId = Auth::guard('web')->id();

        $favoriUrunler = Favori::where('kullanici_id', $kullaniciId)->get();
        $aktifDil = app()->getLocale();

        return view("web.kullanici.favori", compact('favoriUrunler'));
    }

    public function ekle(Request $request)
    {
        try {
            if ($request->ajax()) {
                $kullaniciId = Auth::guard('web')->id();

                $veri = [
                    "urun_id" => $request->input('urun_id', []),
                    "kullanici_id" => $kullaniciId
                ];

                $favoriKontrol = Favori::where('urun_id', $veri["urun_id"])->where('kullanici_id', $veri["urun_id"])->exists();

                if ($favoriKontrol == false) {
                    
                    $urun = Urun::with('urunDiller')->find($veri["urun_id"]);
                    $urunDil = $urun->urunDiller->where('dil', app()->getLocale())->first();
                    $fiyat = indirimliFiyatHesapla($urun);

                    FacebookConversionHelper::send('AddToWishlist', [
                        'content_name' => $urunDil->baslik,
                        'content_ids' => [$urun->id],
                        'content_type' => 'product',
                        'value' => max((float) $fiyat, 0.01),
                        'currency' => 'TRY',
                    ]);

                    FavoriServis::duzenle($veri);
                }

                return response()->json(["mesaj" => "success"], 200);

            } else {
                throw new \Exception('Maalesef ... ');
            }
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
    public function sil(Request $request)
    {
        try {
            if ($request->ajax()) {
                $kullaniciId = Auth::guard('web')->id();
                $urunId = $request->input('urun_id');

                $favori = Favori::where('kullanici_id', $kullaniciId)->where('urun_id', $urunId)->first();

                FavoriServis::sil($favori);

                return response()->json(["mesaj" => "success"], 200);
            } else {
                throw new \Exception('Maalesef ... ');
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}