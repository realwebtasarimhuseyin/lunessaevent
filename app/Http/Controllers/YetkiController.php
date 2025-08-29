<?php

namespace App\Http\Controllers;

use App\Http\Requests\YetkiRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;

class YetkiController extends Controller
{

    public function adminIndex()
    {
        return view("admin.yetki.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");

        $yetkiler = Role::query()
            ->where('name', 'like', "%$arama%");


        return $dataTables->eloquent($yetkiler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.yetki.ekle");
    }

    public function eklePost(YetkiRequest $request)
    {

        try {
            $adminRole = Role::firstOrCreate(['name' => $request->input("isim"), 'guard_name' => 'admin']);
            $adminRole->syncPermissions($request->input('yetkiler'));

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function duzenle(Role $yetki)
    {
        return view("admin.yetki.duzenle", compact('yetki'));
    }

    public function duzenlePost(YetkiRequest $request, Role $yetki)
    {
        try {
            $yetki->name =  $request->input("isim");
            $yetki->syncPermissions($request->input('yetkiler'));
            $yetki->save();

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Role $yetki)
    {
        try {
            $yetki->delete();
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
