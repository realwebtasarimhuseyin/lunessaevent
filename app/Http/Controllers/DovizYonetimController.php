<?php

namespace App\Http\Controllers;

use App\Http\Requests\DovizYonetimRequest;
use App\Models\DovizYonetim;
use App\Services\DovizYonetimServis;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DovizYonetimController extends Controller
{

    public function adminIndex()
    {
        return view("admin.dovizyonetim.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $dovizYonetimler = DovizYonetimServis::veriAlma($arama);

        return $dataTables->eloquent($dovizYonetimler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at);
        })->toJson();
    }

    public function duzenle(DovizYonetim $dovizYonetim)
    {
        return view("admin.dovizyonetim.duzenle", compact('dovizYonetim'));
    }

    public function duzenlePost(DovizYonetimRequest $request, DovizYonetim $dovizYonetim)
    {
        try {
            $veriler = [
                "kaynak" => $request->input('kaynak'),
                "yuzde" => $request->input("yuzde"),
                "birim" => $request->input("birim")
            ];

            DovizYonetimServis::duzenle($dovizYonetim, $veriler);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
