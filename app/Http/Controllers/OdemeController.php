<?php

namespace App\Http\Controllers;

use App\Helper\FacebookConversionHelper;
use App\Helper\IyzicoHelper;
use App\Mail\SiparisAlindiMail;
use App\Models\Il;
use App\Models\Siparis;
use App\Models\Urun;
use App\SanalPos\PayTr;
use Illuminate\Support\Facades\Mail;
use App\Services\SepetServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OdemeController extends Controller
{

    public function index()
    {
        $sepet = SepetServis::sepetiHazirla(app()->getLocale());

        if (count($sepet["urunler"]) <= 0) {
            abort(404);
        }

        $sepetUrunler = $sepet["urunler"];
        $araToplam = $sepet["ara_toplam"];
        $kdvToplam = $sepet["kdv_toplam"];
        $kargoTutar = $sepet["kargo_tutar"];
        $kuponTutar = $sepet["kupon_tutar"];
        $sepetToplam = $sepet["sepet_toplam"];
        $kuponTutar = $sepet["kupon_tutar"];

        $iller = Il::all();

        return view("web.odeme.index", compact('sepetUrunler', 'kuponTutar', 'araToplam', 'kdvToplam', 'kargoTutar', 'kuponTutar', 'sepetToplam', 'iller'));
    }

    public function basarili(Request $request)
    {
        $siparisId = session()->get('siparis_id', "");

        if ($siparisId) {
            $request->session()->forget('siparis_id');
            $request->session()->forget('sepet');
            $siparis = Siparis::where('id', $siparisId)->with('siparisUrun')->first();
        
            $toplamTutar = $siparis->butun_tutarlar["genel_toplam"];
        
            $contentIds = [];
            $contents = [];
        
            foreach ($siparis->siparisUrun as $siparisUrun) {
                $contentIds[] = $siparisUrun->urun_id;
                $contents[] = [
                    'id' => $siparisUrun->urun_id,
                    'quantity' => $siparisUrun->adet,
                ];
            }
        
            FacebookConversionHelper::send('Purchase', [
                'value' => $toplamTutar,
                'currency' => 'TRY',
                'content_type' => 'product',
                'content_ids' => $contentIds,
                'contents' => $contents,
            ]);
        
            return view("web.odeme.basarili", compact('siparis'));
        }

        abort(404);
    }

    public function basarisiz(Request $request)
    {

        $siparisId = session()->get('siparis_id');

        if ($siparisId) {
            $request->session()->forget('siparis_id');
            $siparis = Siparis::where('id', $siparisId)->first();
        } else {
            abort(404);
        }

        return view("web.odeme.basarisiz", compact('siparis'));
    }


    public function durum(Request $request)
    {
        $token = $request->input('token');
        $geriDonusSonucu = IyzicoHelper::geriDonus($request);
        $siparisId = session()->get('siparis_id');

        if (!$siparisId) {
            abort(404);
        }

        $siparis = Siparis::where('id', $siparisId)->first();

        if (!empty($siparis) && $geriDonusSonucu["dogrulandi"] && $geriDonusSonucu["status"] == 'success' && $geriDonusSonucu["odemeDurumu"] == 'SUCCESS') {

            $siparis->durum = 2;
            $siparis->save();

            foreach ($siparis->siparisUrun as $siparisUrun) {
                $urun = $siparisUrun->urun;


                if ($urun) {

                    if ($siparisUrun->siparisUrunVaryant && $siparisUrun->siparisUrunVaryant->count()) {

                        $varyantOzellikIdleri = [];

                        foreach ($siparisUrun->siparisUrunVaryant as $varyant) {
                            $ozellik = \App\Models\UrunVaryantOzellikDil::where('isim', $varyant->urun_varyant_ozellik_isim)->first();
                            if ($ozellik) {
                                $varyantOzellikIdleri[] = $ozellik->urun_varyant_ozellik_id;
                            }
                        }

                        sort($varyantOzellikIdleri);

                        $secimler = \App\Models\UrunVaryantSecim::where('urun_id', $urun->id)->get();

                        foreach ($secimler as $secim) {
                            $secimVaryantIds = $secim->urun_varyantlar;
                            sort($secimVaryantIds);

                            if ($secimVaryantIds === $varyantOzellikIdleri) {
                                $secim->stok_adet -= $siparisUrun->adet;
                                $seciim_stok_kod = $secim->stok_kod;

                                $secim->stok_adet = max($secim->stok_adet, 0);
                                $secim->save();

                                Urun::where('stok_kod', $seciim_stok_kod)->update(['stok_adet' => $secim->stok_adet]);

                                break;
                            }
                        }

                    } else {

                        $urun->stok_adet -= $siparisUrun->adet;
                        $urun->stok_adet = max($urun->stok_adet, 0);
                        $urun->save();
                    }
                }



            }

            $status = 'basarili';
            $redirectUrl = rota('odeme.basarili');
        } else {

            $siparis->durum = 0;
            $siparis->save();

            $status = 'basarisiz';
            $redirectUrl = rota('odeme.basarisiz');
        }

        return view('web.odeme.iframe-sonuc', compact('status', 'redirectUrl'));
    }
}
