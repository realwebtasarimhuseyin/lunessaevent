<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Services\SliderServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SliderController extends Controller
{
    /**
     * Admin paneli için slider listeleme sayfasını gösterir.
     *
     * @return \Illuminate\View\View
     */
    public function adminIndex()
    {
        return view("admin.slider.index");
    }

    /**
     * DataTables bileşeni için slider verilerini sağlar.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Yajra\DataTables\DataTables $dataTables
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", ""); // Arama terimini al
        $sliderler = SliderServis::veriAlma($arama); // Arama terimine göre slider verilerini al

        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('slider-tumunugor') && yetkiKontrol('slider-gor')) {
                $sliderler->where('admin_id', admin()->id);
            }
        }

        return $dataTables->eloquent($sliderler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson(); // DataTables için JSON formatında döndür
    }

    /**
     * Yeni slider ekleme formunu gösterir.
     *
     * @return \Illuminate\View\View
     */
    public function ekle()
    {
        return view("admin.slider.ekle");
    }

    /**
     * Yeni slider ekleme formunu işler.
     *
     * @param \App\Http\Requests\SliderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eklePost(SliderRequest $request)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum") // Slider durumu
            ];

            // Yeni slider ekle
            SliderServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Slider Başarıyla Eklendi!"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => 'Slider eklenemedi: ' . $th->getMessage()], 400);
        }
    }

    /**
     * Slider düzenleme formunu gösterir.
     *
     * @param \App\Models\Slider $slider
     * @return \Illuminate\View\View
     */
    public function duzenle(Slider $slider)
    {
        return view("admin.slider.duzenle", compact('slider'));
    }

    /**
     * Slider düzenleme formunu işler.
     *
     * @param \App\Http\Requests\SliderRequest $request
     * @param \App\Models\Slider $slider
     * @return \Illuminate\Http\JsonResponse
     */
    public function duzenlePost(SliderRequest $request, Slider $slider)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum") // Slider durumu
            ];

            SliderServis::duzenle($slider, $veri, $request);

            return response()->json(["mesaj" => "Slider Başarıyla Güncellendi!"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => 'Slider güncellenemedi: ' . $th->getMessage()], 400);
        }
    }


    public function siralamaDuzenle(Request $request)
    {
        try {

            $sliderlar = $request->input('sliderlar', []);
            if (count($sliderlar) > 0) {
                SliderServis::siralamaDuzenle($sliderlar);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }




    /**
     * Belirli bir slider'ı siler.
     *
     * @param \App\Models\Slider $slider
     * @return \Illuminate\Http\JsonResponse
     */
    public function sil(Slider $slider)
    {
        try {
            SliderServis::sil($slider);
            return response()->json(["mesaj" => "Slider Başarıyla Silindi!"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => 'Slider silinemedi: ' . $th->getMessage()], 400);
        }
    }
}
