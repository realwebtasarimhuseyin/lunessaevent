<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Services\AdminServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{

    public function index()
    {
        return view("admin.admin.index");
    }

    public function adminIndex()
    {
        return view("admin.admin.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $adminlar = AdminServis::veriAlma($arama);
        return $dataTables->eloquent($adminlar)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        $yetkiler = Role::all();
        return view("admin.admin.ekle", compact('yetkiler'));
    }

    public function eklePost(AdminRequest $request)
    {

        try {
            $veri = [
                "isim" => $request->input("isim"),
                "soyisim" => $request->input("soyisim"),
                "eposta" => $request->input("eposta"),
                "sifre" => Hash::make($request->input("sifre")),
                "yetki" => $request->input("yetki", "010"),
                "durum" => $request->input("durum"),
            ];

            AdminServis::ekle($veri);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function duzenle(Admin $admin)
    {
        $yetkiler = Role::all();
        return view("admin.admin.duzenle", compact('admin', 'yetkiler'));
    }

    public function duzenlePost(AdminRequest $request, Admin $admin)
    {
        try {
            $veri = [
                "isim" => $request->input("isim"),
                "soyisim" => $request->input("soyisim"),
                "eposta" => $request->input("eposta"),
                "yetki" => $request->input("yetki", "010"),
                "durum" => $request->input("durum"),
            ];

            if (!empty($request->input("sifre"))) {
                $veri["sifre"] = Hash::make($request->input("sifre"));
            }

            AdminServis::duzenle($admin, $veri);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Admin $admin)
    {
        try {
            AdminServis::sil($admin);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
