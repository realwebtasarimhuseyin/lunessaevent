<?php

namespace App\Http\Controllers;

use App\Http\Requests\SssRequest;
use App\Models\Sss;
use App\Services\SssServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SssController extends Controller
{

    public function index(Request $request)
    {

        $sssler = Sss::where('durum', "1")->get();

        return view("web.sss.index", compact('sssler'));
    }

    public function adminIndex()
    {
        return view("admin.sss.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $sssler = SssServis::veriAlma();

        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('sss-tumunugor') && yetkiKontrol('sss-gor')) {
                $sssler->where('admin_id', admin()->id);
            }
        }

        return $dataTables->eloquent($sssler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.sss.ekle");
    }

    public function eklePost(SssRequest $request)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum")
            ];

            SssServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function duzenle(Sss $sss)
    {
        return view("admin.sss.duzenle", compact('sss'));
    }

    public function duzenlePost(SssRequest $request, Sss $sss)
    {
        try {

            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum")
            ];

            SssServis::duzenle($sss, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function siralamaDuzenle(Request $request)
    {

        try {

            $sssler = $request->input('sssler', []);
            if (count($sssler) > 0) {
                SssServis::siralamaDuzenle($sssler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Sss $sss)
    {
        try {
            SssServis::sil($sss);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
