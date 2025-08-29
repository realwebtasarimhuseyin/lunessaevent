<?php

namespace App\Http\Controllers;

use App\Http\Requests\EkipRequest;
use App\Models\Ekip;
use App\Services\EkipServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class EkipController extends Controller
{

    public function index()
    {
        $ekibimiz = Ekip::where('durum', 1)->get();
        return view("web.ekip.index", compact('ekibimiz'));
    }

    public function adminIndex()
    {
        return view("admin.ekip.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $ekibimiz = EkipServis::veriAlma($arama);
        return $dataTables->eloquent($ekibimiz)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.ekip.ekle");
    }

    public function eklePost(EkipRequest $request)
    {

        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "isim" => $request->input("isim"),
                "unvan" => $request->input("unvan"),
                "durum" => $request->input("durum")
            ];

            EkipServis::ekle($veri, $request);
            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster($locale, Ekip $ekip)
    {
        return view("admin.ekip.goster");
    }

    public function duzenle(Ekip $ekip)
    {
        return view("admin.ekip.duzenle", compact('ekip'));
    }

    public function duzenlePost(EkipRequest $request, Ekip $ekip)
    {
        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "isim" => $request->input("isim"),
                "unvan" => $request->input("unvan"),
                "durum" => $request->input("durum")
            ];

            EkipServis::duzenle($ekip, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Ekip $ekip)
    {
        try {
            EkipServis::sil($ekip);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
