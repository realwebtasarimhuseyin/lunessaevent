<?php

namespace App\Http\Controllers;

use App\Models\Sepet;
use App\Models\Urun;
use App\Services\SepetServis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SepetController extends Controller
{
    /**
     * Sepet sayfasını gösterir.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $sepet = SepetServis::sepetiHazirla(app()->getLocale());
        return view("web.kullanici.sepet", compact('sepet'));
    }

    /**
     * Sepet listesini JSON olarak döner.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function liste(Request $request)
    {
        try {
            if ($request->ajax()) {
                // Dil bilgisi al ve sepeti hazırla.
                $aktifDil = $request->query('dil');
                $sepet = SepetServis::sepetiHazirla($aktifDil);
                return response()->json($sepet, 200);
            } else {
                throw new \Exception('Geçersiz istek.');
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Sepete ürün ekleme veya düzenleme işlemi.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function duzenle(Request $request)
    {
        try {
            if ($request->ajax()) {
                // Kullanıcıdan gelen veriyi al.
                $veri = [
                    "urunler" => $request->input('urunler', [])
                ];

                // Sepet servis sınıfını kullanarak sepeti düzenle.
                SepetServis::duzenle($veri);

                return response()->json(["mesaj" => "Ürün Sepete Eklendi"], 200);
            } else {
                throw new \Exception('Geçersiz istek.');
            }
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    /**
     * Sepetten ürün silme işlemi.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sil(Request $request)
    {
        try {
            if ($request->ajax()) {
                $sepetId = $request->input('sepet_id', null);

                if ($sepetId !== null) {
                    $sepetUrunler = collect(session()->get('sepet', []));

                    $eslesenSepet = $sepetUrunler->first(function ($urun) use ($sepetId) {
                        return isset($urun['sepet_id']) && $urun['sepet_id'] === (int) $sepetId;
                    });

                    if ($eslesenSepet) {
                        if (Auth::guard('web')->check()) {
                            $kullaniciId = Auth::guard('web')->id();

                            $urunId = $eslesenSepet['urun_id'];
                            $varyantlar = !empty($eslesenSepet['varyantlar']) ?
                                array_map('intval', array_column($eslesenSepet['varyantlar'], 'urun_varyant_ozellik_id')) : [];

                            $mevcutSepetler = Sepet::with('sepetUrunVaryant')
                                ->where('urun_id', $urunId)
                                ->where('kullanici_id', $kullaniciId)
                                ->get()
                                ->filter(function ($sepet) use ($varyantlar) {
                                    $sepetVaryantlar = $sepet->sepetUrunVaryant->pluck('urun_varyant_ozellik_id')->toArray();
                                    return !array_diff($varyantlar, $sepetVaryantlar) && !array_diff($sepetVaryantlar, $varyantlar);
                                });

                            if ($mevcutSepetler->isNotEmpty()) {
                                foreach ($mevcutSepetler as $mevcutSepet) {
                                    $mevcutSepet->sepetUrunVaryant()->delete();
                                    $mevcutSepet->delete();
                                }
                            }
                        }

                        $sepetUrunler->forget($sepetUrunler->search($eslesenSepet));
                        session()->put('sepet', $sepetUrunler->values()->all());

                        return response()->json(['mesaj' => __('global.urunBasariylaSilindi')], 200);
                    } else {
                        return response()->json(['mesaj' => __('global.urunBulunamadi')], 404);
                    }
                }

                // Eğer $sepetId null ise, hata döndür.
                return response()->json(['mesaj' => __('global.sepetIdGerekli')], 400);
            } else {
                throw new \Exception('Geçersiz istek.');
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
