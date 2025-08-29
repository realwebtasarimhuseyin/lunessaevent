<?php

namespace App\Services;

use App\Models\IletisimForm;
use App\Bases\IletisimFormBase;
use App\Mail\IletisimFormuMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IletisimFormServis
{
    public static function veriAlma($arama = 0)
    {
        $builder = IletisimFormBase::veriIsleme();

        if ($arama !== "") {
            $builder->whereAny(['k.kod'], 'like', "%$arama%");
        }

        return $builder;
    }

    public static function ekle($veri)
    {
        try {
            return DB::transaction(function () use ($veri) {
                try {
                    config(['mail.mailers.smtp.transport' => 'smtp']);
                    config(['mail.mailers.smtp.host' => ayar('smtpSunucuAdresi')]);
                    config(['mail.mailers.smtp.port' => ayar('smtpPort')]);
                    config(['mail.mailers.smtp.username' => ayar('smtpKullaniciAdi')]);
                    config(['mail.mailers.smtp.password' => ayar('smtpSifresi')]);
                    config(['mail.mailers.smtp.encryption' => ayar('guvenlikProtokolu')]);
                    config(['mail.from.name' => ayar('gonderenAdi') ]);

                    Mail::to(ayar('smtpKullaniciAdi'))->send(new IletisimFormuMail($veri));
                } catch (\Throwable $th) {
                    // Hata varsa log dosyasına yaz
                    Log::error('Mail gönderimi başarısız: ' . $th->getMessage());
                }

                IletisimFormBase::ekle($veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('IletisimForm kayıt edilemedi : ' . $th->getMessage());
        }
    }

    public static function duzenle(IletisimForm $iletisimForm, $veri)
    {
        try {
            return DB::transaction(function () use ($iletisimForm, $veri) {
                IletisimFormBase::duzenle($iletisimForm, $veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('IletisimForm düzenlenemedi : ' . $th->getMessage());
        }
    }

    public static function sil(IletisimForm $iletisimForm)
    {
        try {
            return DB::transaction(function () use ($iletisimForm) {
                IletisimFormBase::sil($iletisimForm);
            });
        } catch (\Throwable $th) {
            throw new \Exception('IletisimForm silinemedi : ' . $th->getMessage());
        }
    }
}
