<?php

namespace App\SanalPos;

use App\Mail\SiparisAlindiMail;
use App\Models\Sepet;
use App\Models\Siparis;
use App\Services\UrunServis;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PayTr
{
    private string $magazaId;
    private string $magazaAnahtari;
    private string $magazaGizliAnahtar;

    public function __construct()
    {
        $this->magazaId = config('paytr.merchant_id');
        $this->magazaAnahtari = config('paytr.merchant_key');
        $this->magazaGizliAnahtar = config('paytr.merchant_salt');
    }

    public function odemeTokenOlustur(array $odemeVerisi): string
    {
        $this->odemeVerisiniDogrula($odemeVerisi);

        $hashStr = $this->hashDizesiOlustur($odemeVerisi);
        $paytrToken = base64_encode(hash_hmac('sha256', $hashStr . $this->magazaGizliAnahtar, $this->magazaAnahtari, true));

        $postVerileri = array_merge($odemeVerisi, ['paytr_token' => $paytrToken]);

        $cevap = Http::asForm()->post('https://www.paytr.com/odeme/api/get-token', $postVerileri);

        if ($cevap->failed()) {
            throw new Exception('PAYTR IFRAME bağlantı hatası.');
        }

        $sonuc = $cevap->json();

        if ($sonuc['status'] !== 'success') {
            throw new Exception('PAYTR IFRAME başarısız. Sebep: ' . ($sonuc['reason'] ?? 'Bilinmeyen hata'));
        }

        return $sonuc['token'];
    }

    private function odemeVerisiniDogrula(array $veri): void
    {
        $gerekliAnahtarlar = [
            'merchant_id',
            'user_ip',
            'merchant_oid',
            'email',
            'payment_amount',
            'currency',
            'user_basket',
            'no_installment',
            'max_installment',
            'user_name',
            'user_address',
            'user_phone',
            'merchant_ok_url',
            'merchant_fail_url',
            'timeout_limit',
            'test_mode',
            'debug_on',
            'lang',
        ];

        foreach ($gerekliAnahtarlar as $anahtar) {
            if (!isset($veri[$anahtar])) {
                throw new Exception("Eksik ödeme verisi: $anahtar");
            }
        }
    }

    private function hashDizesiOlustur(array $veri): string
    {
        return $this->magazaId . $veri['user_ip'] . $veri['merchant_oid'] . $veri['email'] .
            $veri['payment_amount'] . $veri['user_basket'] . ($veri['no_installment'] ?? 0) .
            ($veri['max_installment'] ?? 0) . $veri['currency'] . $veri['test_mode'];
    }

    public function bildirimiIsle(array $post): string
    {
        $this->hashDogrula($post);


        if ($post['status'] === 'success') {
            $this->siparisiOnayla($post);
        } else {
            $this->siparisiIptalEt($post);
        }

        return "OK";
    }

    private function hashDogrula(array $post): void
    {
        $hash = base64_encode(hash_hmac('sha256', $post['merchant_oid'] . $this->magazaGizliAnahtar . $post['status'] . $post['total_amount'], $this->magazaAnahtari, true));

        if ($hash !== $post['hash']) {
            throw new Exception('PAYTR bildirim doğrulama hatası: Geçersiz hash.');
        }
    }

    private function siparisDurumunuSorgula(string $merchantOid): ?string
    {
        // Örneğin: Sipariş durumunu veri tabanından sorgulayın
        return DB::table('siparis')->where('kod', $merchantOid)->value('durum');
    }

    private function siparisiOnayla(array $post): void
    {
        $kullaniciId = Auth::guard('web')->id() ?? 0;
        $siparis = Siparis::where('kod', $post['merchant_oid'])->first();
        $siparisEposta = $siparis->siparisBilgi->eposta;

        DB::table('siparis')
            ->where('kod', $post['merchant_oid'])
            ->update([
                'durum' => 2,
                'toplam_tutar' => $post['total_amount']
            ]);


        if ($kullaniciId > 0) {
            Sepet::where('kullanici_id', $kullaniciId)->delete();
        }

        foreach ($siparis->siparisUrun as $siparisUrun) {
            UrunServis::stokAzalt($siparisUrun->urun_id, $siparisUrun->adet);
        }

        if (!empty($siparisEposta)) {
            $siteMail = ayar('gonderenEpostaAdresi');

            if (!empty($siteMail)) {
                try {

                    config(['mail.mailers.smtp.transport' => 'smtp']);
                    config(['mail.mailers.smtp.host' => ayar('smtpSunucuAdresi')]);
                    config(['mail.mailers.smtp.port' => ayar('smtpPort')]);
                    config(['mail.mailers.smtp.username' => ayar('smtpKullaniciAdi')]);
                    config(['mail.mailers.smtp.password' => ayar('smtpSifresi')]);
                    config(['mail.mailers.smtp.encryption' => ayar('guvenlikProtokolu')]);

                    Mail::to($siparisEposta)
                        ->send(new SiparisAlindiMail($siparis));
                } catch (\Throwable $th) {
                    // Hata varsa log dosyasına yaz
                    Log::error('Mail gönderimi başarısız: ' . $th->getMessage());
                }
            }
        }

        // İsteğe bağlı: Müşteriye bildirim gönderme işlemleri (e-posta, SMS vs.)
        Log::info('Sipariş onaylandı: ' . $post['merchant_oid']);
    }

    private function siparisiIptalEt(array $post): void
    {
        DB::table('siparis')
            ->where('kod', $post['merchant_oid'])
            ->update([
                'durum' => 5
            ]);

        Log::warning('Sipariş iptal edildi: ' . $post['merchant_oid']);
    }
}
