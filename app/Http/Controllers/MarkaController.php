<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkaRequest;
use App\Models\Marka;
use App\Services\MarkaServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class MarkaController extends Controller
{

    public function index()
    {
        $markalar  = Marka::orderBy('isim')->get()
            ->groupBy(function ($marka) {
                return strtoupper(substr($marka->isim, 0, 1));
            });


        return view("web.marka.index", compact('markalar'));
    }

    public function adminIndex()
    {
        return view("admin.marka.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $markalar = MarkaServis::veriAlma($arama);
        return $dataTables->eloquent($markalar)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.marka.ekle");
    }

    public function eklePost(MarkaRequest $request)
    {

        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "isim" => $request->input("isim"),
                "slug" => Marka::slugUret($request->input("isim")),
                "durum" => $request->input("durum"),

            ];

            MarkaServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster($locale, $slug)
    {
        $marka = Marka::slugBul($slug)->first();
        return view("web.marka.detay", compact('marka'));
    }

    public function duzenle(Marka $marka)
    {
        return view("admin.marka.duzenle", compact('marka'));
    }

    public function duzenlePost(MarkaRequest $request, Marka $marka)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "isim" => $request->input("isim"),
                "slug" => Marka::slugUret($request->input("isim")),
                "durum" => $request->input("durum")
            ];

            MarkaServis::duzenle($marka, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }


    public function siralamaDuzenle(Request $request)
    {
        try {

            $markalar = $request->input('markalar', []);
            if (count($markalar) > 0) {
                MarkaServis::siralamaDuzenle($markalar);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }



    public function sil(Marka $marka)
    {
        try {
            MarkaServis::sil($marka);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
