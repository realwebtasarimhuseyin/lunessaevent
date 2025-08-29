<?php

namespace App\Http\Controllers;

use App\Http\Requests\AyarRequest;
use App\Models\Ayar;
use App\Services\AyarServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AyarController extends Controller
{

    public function adminIndex()
    {
        return view("admin.ayar.index");
    }

    public function duzenlePost(Request $request)
    {
        try {
            AyarServis::duzenle($request);
            return response()->json(["mesaj" => "Ayar Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
