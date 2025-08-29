<?php

namespace App\Http\Controllers;

use App\Http\Requests\PopupRequest;
use App\Models\Popup;
use App\Services\PopupServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PopupController extends Controller
{

    public function index()
    {
        return view("admin.popup.index");
    }

    public function adminIndex()
    {
        return view("admin.popup.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $popuplar = PopupServis::veriAlma($arama);

        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('popup-tumunugor') && yetkiKontrol('popup-gor')) {
                $popuplar->where('admin_id', admin()->id);
            }
        }


        return $dataTables->eloquent($popuplar)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.popup.ekle");
    }

    public function eklePost(PopupRequest $request)
    {

        try {

            $baslangic_tarih = \DateTime::createFromFormat('d.m.Y H:i', $request->input("baslangic_tarih"));
            $bitis_tarih = \DateTime::createFromFormat('d.m.Y H:i', $request->input("bitis_tarih"));

            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "baslangic_tarih" => $baslangic_tarih->format('Y-m-d H:i:s'),
                "bitis_tarih" => $bitis_tarih->format('Y-m-d H:i:s'),
                "durum" => $request->input("durum")
            ];

            PopupServis::ekle($request, $veri);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function duzenle(Popup $popup)
    {
        return view("admin.popup.duzenle", compact('popup'));
    }

    public function duzenlePost(PopupRequest $request, Popup $popup)
    {
        try {
            $baslangic_tarih = \DateTime::createFromFormat('d.m.Y H:i', $request->input("baslangic_tarih"));
            $bitis_tarih = \DateTime::createFromFormat('d.m.Y H:i', $request->input("bitis_tarih"));

            $veri = [
                "admin_id" => admin()->id,
                "baslangic_tarih" => $baslangic_tarih->format('Y-m-d H:i:s'),
                "bitis_tarih" => $bitis_tarih->format('Y-m-d H:i:s'),
                "durum" => $request->input("durum")
            ];

            PopupServis::duzenle($popup, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function siralamaDuzenle(Request $request)
    {
        try {
            $popuplar = $request->input('popuplar', []);
            if (count($popuplar) > 0) {
                PopupServis::siralamaDuzenle($popuplar);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Popup $popup)
    {
        try {
            PopupServis::sil($popup);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
