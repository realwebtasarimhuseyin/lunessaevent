<?php

namespace App\Http\Controllers;

use App\Models\Kullanici;
use App\Models\KullaniciIndirim;
use App\Models\UrunKategori;
use App\Services\KullaniciServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class KullaniciController extends Controller
{

    public function adminIndex()
    {
        return view("admin.kullanici.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $kullanicilar = KullaniciServis::veriAlma($arama);

        return $dataTables->eloquent($kullanicilar)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function adminDetay(Kullanici $kullanici)
    {
        return view("admin.kullanici.detay", compact('kullanici'));
    }

    public function goster(Kullanici $kullanici)
    {
        return view('admin.kullanici.detay', compact('kullanici'));
    }

    public function duzenle(Kullanici $kullanici)
    {
        $indirimKategoriler = UrunKategori::indirimAktif()->get();
        $kullaniciIndirimler = KullaniciIndirim::where('kullanici_id', $kullanici->id)->get();
        return view("admin.kullanici.duzenle", compact("kullanici", "indirimKategoriler", "kullaniciIndirimler"));
    }

    public function duzenlePost(Request $request, Kullanici $kullanici)
    {
        $request->validate([
            'isimSoyisim' => 'required|string',
            'eposta' => 'required|email',
            'telefon' => 'required|string',
            'durum' => 'required|boolean',
        ]);

        try {
            $veri = [
                "isim_soyisim" => $request->input('isimSoyisim'),
                "eposta" => $request->input('eposta'),
                "telefon" => $request->input('telefon'),
            ];

            if ($request->filled('sifre')) {
                $veri['sifre'] = Hash::make($request->input('sifre'));
            }

            KullaniciServis::duzenle($kullanici, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi!"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Kullanici $kullanici)
    {
        try {
            KullaniciServis::sil($kullanici);
            return response()->json(["mesaj" => "Başarıyla Silindi!"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
