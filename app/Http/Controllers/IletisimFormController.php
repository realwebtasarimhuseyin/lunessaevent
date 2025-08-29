<?php

namespace App\Http\Controllers;

use App\Http\Requests\IletisimFormRequest;
use App\Models\IletisimForm;
use App\Services\IletisimFormServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class IletisimFormController extends Controller
{

    public function adminIndex()
    {
        return view("admin.iletisimform.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $iletisimFormlar = IletisimFormServis::veriAlma($arama);
        return $dataTables->eloquent($iletisimFormlar)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function eklePost(IletisimFormRequest $request)
    {
        try {
            $veri = [
                "isim" => $request->input("isimSoyisim"),
                "telefon" => $request->input("telefon"),
                "eposta" => $request->input("eposta"),
                "mesaj" => $request->input("mesaj"),
            ];

            IletisimFormServis::ekle($veri);
            return response()->json(["mesaj" => "Mesajınız Başarıyla İletildi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster(IletisimForm $iletisimForm)
    {
        return view("admin.iletisimform.detay", compact('iletisimForm'));
    }

    public function sil(IletisimForm $iletisimForm)
    {
        try {
            IletisimFormServis::sil($iletisimForm);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
