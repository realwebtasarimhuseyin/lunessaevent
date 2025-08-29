<?php

namespace App\Http\Controllers;

use App\Http\Requests\KuponRequest;
use App\Models\Kupon;
use App\Services\KuponServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class KuponController extends Controller
{

    public function index()
    {
        return view("admin.kupon.index");
    }

    public function adminIndex()
    {
        return view("admin.kupon.index");
    }

    public function kontrol(Request $request)
    {

        try {
            if ($request->ajax()) {

                $kuponKod = $request->query("kupon_kod", null);
                if ($kuponKod) {

                    $kuponKontrol = KuponServis::kontrol($kuponKod);

                    if ($kuponKontrol) {

                        session()->put('kupon_kod', $kuponKod);

                        $kuponTutar = $kuponKontrol->tutar;
                        $kuponYuzde = $kuponKontrol->yuzde;

                        if ($kuponTutar > 0) {
                            return response()->json(["mesaj" => __('global.kuponOnaylandi'), 'tutar' => $kuponTutar], 200);
                        } else if ($kuponYuzde > 0) {
                            return response()->json(["mesaj" => __('global.kuponOnaylandi'), 'yuzde' => $kuponYuzde], 200);
                        }
                    } else {
                        return response()->json(["mesaj" => __('global.gecersizKupon')], 400);
                    }
                }
            } else {
                throw new \Exception('Maalesef ... ');
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function iptal(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new \Exception('Maalesef, geçersiz istek türü!');
            }

            $request->session()->forget('kupon_kod');
            return response()->json(["mesaj" => "Kupon Kaldırıldı"], 200);
        
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }




    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $kuponlar = KuponServis::veriAlma($arama);

        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('kupon-tumunugor') && yetkiKontrol('kupon-gor')) {
                $kuponlar->where('admin_id', admin()->id);
            }
        }

        return $dataTables->eloquent($kuponlar)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.kupon.ekle");
    }

    public function eklePost(KuponRequest $request)
    {

        try {

            $baslangic_tarih = \DateTime::createFromFormat('d.m.Y H:i', $request->input("baslangic_tarih"));
            $bitis_tarih = \DateTime::createFromFormat('d.m.Y H:i', $request->input("bitis_tarih"));

            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "kod" => $request->input("kod"),
                "adet" => $request->input("adet"),
                "tutar" => $request->input("tutar"),
                "yuzde" => $request->input("yuzde"),
                "baslangic_tarih" => $baslangic_tarih->format('Y-m-d H:i:s'),
                "bitis_tarih" => $bitis_tarih->format('Y-m-d H:i:s'),
                "durum" => $request->input("durum")
            ];

            KuponServis::ekle($veri);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function duzenle(Kupon $kupon)
    {
        return view("admin.kupon.duzenle", compact('kupon'));
    }

    public function duzenlePost(KuponRequest $request, Kupon $kupon)
    {
        try {
            $baslangic_tarih = \DateTime::createFromFormat('d.m.Y H:i', $request->input("baslangic_tarih"));
            $bitis_tarih = \DateTime::createFromFormat('d.m.Y H:i', $request->input("bitis_tarih"));

            $veri = [
                "admin_id" => admin()->id,
                "adet" => $request->input("adet"),
                "tutar" => $request->input("tutar"),
                "yuzde" => $request->input("yuzde"),
                "baslangic_tarih" => $baslangic_tarih->format('Y-m-d H:i:s'),
                "bitis_tarih" => $bitis_tarih->format('Y-m-d H:i:s'),
                "durum" => $request->input("durum")
            ];

            KuponServis::duzenle($kupon, $veri);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Kupon $kupon)
    {
        try {
            KuponServis::sil($kupon);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
