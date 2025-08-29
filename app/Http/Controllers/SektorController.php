<?php

namespace App\Http\Controllers;

use App\Http\Requests\SektorRequest;
use App\Models\Sektor;
use App\Models\SektorKategori;
use App\Services\SektorKategoriServis;
use App\Services\SektorServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SektorController extends Controller
{

    public function index(Request $request)
    {

        $sektor = Sektor::aktif()->get();

        return view("web.sektor.index", compact('sektor'));
    }

    public function adminIndex()
    {
        return view("admin.sektor.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $sektorler = SektorServis::veriAlma($arama);
        return $dataTables->eloquent($sektorler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.sektor.ekle");
    }

    public function eklePost(SektorRequest $request)
    {

        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "durum" => $request->input("durum")
            ];

            SektorServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Sektor Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster($locale, $slug)
    {
        $sektor = Sektor::getBySlug($slug);

        if (!$sektor) {
            abort(404);
        }
        return view("web.sektor.detay", compact('sektor'));
    }

    public function duzenle(Sektor $sektor)
    {
        return view("admin.sektor.duzenle", compact('sektor'));
    }

    public function duzenlePost(SektorRequest $request, Sektor $sektor)
    {
        try {
            $veri = [
                "durum" => $request->input("durum")
            ];

            SektorServis::duzenle($sektor, $veri, $request);

            return response()->json(["mesaj" => "Sektor Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }



    public function siralamaDuzenle(Request $request)
    {

        try {

            $sektorler = $request->input('sektorler', []);
            if (count($sektorler) > 0) {
                SektorServis::siralamaDuzenle($sektorler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }




    public function sil(Sektor $sektor)
    {
        try {
            SektorServis::sil($sektor);
            return response()->json(["mesaj" => "Sektor Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
