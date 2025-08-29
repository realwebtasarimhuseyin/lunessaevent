<?php

namespace App\Http\Controllers;

use App\Models\Sepet;
use App\Models\Siparis;
use App\Services\SiparisServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SiparisController extends Controller
{
    // Admin siparişler sayfası
    public function adminIndex()
    {
        return view("admin.siparis.index");
    }

    // Sipariş detayını getirir
    public function siparisDetay(Request $request)
    {
        $siparisId = $request->input('siparis-id');
        $siparis = Siparis::with(['siparisUrun', 'siparisUrun.siparisUrunVaryant'])
            ->where('id', $siparisId)
            ->first();

        if (!$siparis) {
            return response()->json(['message' => 'Sipariş bulunamadı'], 404);
        }

        return response()->json(['data' => $siparis], 200);
    }

    // Admin sipariş listesi
    public function adminList(Request $request, DataTables $dataTables)
    {
        $siparisler = Siparis::with(['siparisUrun', 'kullanici'])
            ->select('id', 'kod','kullanici_id', 'indirim_tutar', 'durum', 'created_at');

        return $dataTables->eloquent($siparisler)
            ->addColumn('toplam_tutar', function ($siparis) {
                return number_format($siparis->butun_tutarlar["genel_toplam"], 2);
            })->editColumn('created_at', function ($nesne) {
                return formatZaman($nesne->created_at, 'plus');
            })->editColumn('durum', function ($siparis) {
                return $siparis->durumText();
            })
            ->make(true);
    }

    // Yeni sipariş oluşturma
    public function eklePost(Request $request)
    {
        try {
            $siparisVeriler = [
                "isim" => $request->input("siparisIsim"),
                "telefon" => $request->input("siparisTelefon"),
                "eposta" => $request->input("siparisEposta"),
                "il" => $request->input("siparisIl"),
                "ilce" => $request->input("siparisIlce"),
                "adres" => $request->input("siparisAdres"),
                "posta_kod" => $request->input("siparisPostaKodu"),
                "faturaFarklimi" => $request->input("faturaFarklimi"),
                "odeme_tip" => $request->input("siparisOdemeTip", 'havale'),
            ];

            $siparis = SiparisServis::ekle($siparisVeriler);

            if ($siparis["siparisKayitDurum"]) {
                return response()->json(["mesaj" => __('global.siparisOlusturuldu'), "data" => $siparis], 200);
            } else {
                return response()->json(["mesaj" => "Sipariş Oluşturulamadı !"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    // Sipariş detay sayfası
    public function goster(Siparis $siparis)
    {
        return view("admin.siparis.detay", compact('siparis'));
    }

    // Müşteri sipariş detay sayfası
    public function musteriSiparisDetay($kod)
    {
        $siparis = Siparis::kod($kod)->first();
        abort_unless($siparis, 404);

        return view('web.siparis.index', compact('siparis'));
    }

    // Sipariş düzenleme sayfası
    public function duzenle(Siparis $siparis)
    {
        return view("admin.siparis.duzenle");
    }

    public function duzenlePost(Request $request, Siparis $siparis)
    {
        try {

            $veri = [
                "durum" => $request->input('durum'),
            ];

            // Sipariş Servis ile güncelle
            SiparisServis::duzenle($siparis, $veri);

            // Başarılı yanıt döndür
            return response()->json(["mesaj" => "Sipariş Başarıyla Düzenlendi!"], 200);
        } catch (\Throwable $th) {
            // Hata durumunda yanıt döndür
            return response()->json(["mesaj" => 'Sipariş düzenlenmedi: ' . $th->getMessage()], 400);
        }
    }

    // Sipariş silme işlemi
    public function sil(Siparis $siparis)
    {
        try {
            SiparisServis::sil($siparis);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
