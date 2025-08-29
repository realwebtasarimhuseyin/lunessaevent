<?php

namespace App\Http\Controllers;

use App\Http\Requests\SifreSifirlaRequest;
use App\Mail\SifreSifirlaMail;
use App\Models\Kullanici;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SifreSifirlaController extends Controller
{

    public function sifreSifirlaTalepForm()
    {
        return view('web.kullanici.sifre-sifirla-talep');
    }

    public function sifreSifirlamaLinkiGonder(SifreSifirlaRequest $request)
    {

        $kullanici = Kullanici::where('eposta', $request->eposta)->first();

        if ($kullanici) {
            $siteMail = ayar('gonderenEpostaAdresi');
            $kullanici->email = $request->eposta;

            if ($siteMail) {

                try {
                    config(['mail.mailers.smtp.host' => ayar('smtpSunucuAdresi')]);
                    config(['mail.mailers.smtp.port' => ayar('smtpPort')]);
                    config(['mail.mailers.smtp.username' => ayar('smtpKullaniciAdi')]);
                    config(['mail.mailers.smtp.password' => ayar('smtpSifresi')]);
                    config(['mail.mailers.smtp.encryption' => ayar('guvenlikProtokolu')]);

                    $token = app('auth.password.broker')->createToken($kullanici);

                    Mail::to($request->eposta)
                        ->send(new SifreSifirlaMail($token, $siteMail, $request->eposta));

                    return response()->json(['mesaj' => "Şifre Sıfırlama Bağlantısı Gönderildi"], 200);
                } catch (\Throwable $th) {
                    return response()->json(['mesaj' => $th->getMessage()], 400);
                }
            }

            return response()->json(['mesaj' => "Hata"], 400);
        }

        return response()->json(['mesaj' => "Hata"], 400);
    }

    public function sifreSifirlaForm(Request $request, $token)
    {
        $eposta = $request->query('eposta', '');

        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $eposta)
            ->first();

        if ($tokenData) {
            $tokenKontrol = Hash::check($token, $tokenData->token);

            if ($tokenKontrol) {
                return view('web.kullanici.sifre-sifirla', compact('token', 'eposta'));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }



    public function sifreSifirlaOnay(Request $request)
    {
        try {
            $request->validate([
                'eposta' => 'required|email',
                'sifre' => 'required|confirmed',
                'token' => 'required'
            ]);

            $kullanici = Kullanici::where('eposta', $request->eposta)->first();

            if ($kullanici) {
                $tokenData = DB::table('password_reset_tokens')
                    ->where('email', $request->eposta)
                    ->first();

                if ($tokenData && Hash::check($request->token, $tokenData->token)) {
                    $kullanici = Kullanici::find($kullanici->id);
                    $kullanici->sifre = Hash::make($request->sifre);
                    $kullanici->save();

                    DB::table('password_reset_tokens')
                        ->where('email', $request->eposta)
                        ->delete();

                    return response()->json(["mesaj" => "Şifreniz Başarıyla Değiştirildi !"], 200);
                }
            } else {
                abort(404);
            }
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => __('global.sifrenizDegistirilemedi')], 400);
        }
    }
}
