<?php

namespace App\Http\Controllers;

use App\Http\Requests\YorumRequest;
use App\Models\Yorum;
use App\Services\YorumServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class YorumController extends Controller
{



    public function adminIndex()
    {
        return view("admin.yorum.index");
    }
    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $yorumlar = YorumServis::veriAlma($arama);
        return $dataTables->eloquent($yorumlar)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.yorum.ekle");
    }

    public function eklePost(YorumRequest $request)
    {

        try {
            $veriler = [
                "admin_id" => admin()->id,
                "kisi_isim" => $request->input("kisiIsim"),
                "kisi_unvan" => $request->input("kisiUnvan"),
                "durum" => $request->input("durum")
            ];

            YorumServis::ekle($veriler, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster(Yorum $yorum)
    {
        return view("admin.yorum.goster");
    }

    public function duzenle(Yorum $yorum)
    {
        return view("admin.yorum.duzenle", compact('yorum'));
    }

    public function duzenlePost(YorumRequest $request, Yorum $yorum)
    {
        try {

            $veriler = [
                "admin_id" => admin()->id,
                "kisi_isim" => $request->input("kisiIsim"),
                "kisi_unvan" => $request->input("kisiUnvan"),
                "durum" => $request->input("durum")
            ];

            YorumServis::duzenle($yorum, $veriler, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Yorum $yorum)
    {
        try {
            YorumServis::sil($yorum);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
