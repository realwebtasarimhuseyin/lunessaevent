<?php

namespace App\Http\Controllers;

use App\Http\Requests\BultenRequest;
use App\Models\Bulten;
use App\Services\BultenServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BultenController extends Controller
{

    public function adminIndex()
    {
        return view("admin.bulten.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $bultenMailler = BultenServis::veriAlma();
        return $dataTables->eloquent($bultenMailler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function eklePost(BultenRequest $request)
    {
        try {
            $veri = [
                "eposta" => $request->input("eposta"),
            ];
            
            $bultenKontrol = Bulten::where('eposta', $veri["eposta"])->exists();
            if (!$bultenKontrol) {
                BultenServis::ekle($veri);
            }else{
                return response()->json(["mesaj" => "Abonelik Kaydı Zaten Var"], 200);
            }

            return response()->json(["mesaj" => "Abonelik Kaydı Oluşturuldu"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Bulten $bulten)
    {
        try {
            BultenServis::sil($bulten);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
