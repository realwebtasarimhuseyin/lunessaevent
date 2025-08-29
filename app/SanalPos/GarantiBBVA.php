<?php

namespace App\SanalPos;

class GarantiBBVA
{

    private string $merchantId;
    private string $provUserId;
    private string $provisionPassword;
    private string $terminalId;
    private string $storeKey;

    public function __construct()
    {
        $this->merchantId = config('garanti.merchant_id');
        $this->provUserId = config('garanti.prov_user_id');
        $this->provisionPassword = config('garanti.provision_password');
        $this->terminalId = config('garanti.terminal_id');
        $this->storeKey = config('garanti.store_key');
    }

    public function formVerisiHazirla(array $veri): array
    {

        $formVerileri = [
            "secure3dsecuritylevel" => "3D_PAY",
            "cardnumber" => $veri["kartNo"],
            "cardexpiredatemonth" => $veri["kartAy"],
            "cardexpiredateyear" => $veri["kartYil"],
            "cardcvv2" => $veri["kartCvv"],
            "mode" => "PROD",
            "apiversion" => "512",
            "terminalprovuserid" => $this->provUserId,
            "terminaluserid" =>  $this->terminalId,
            "terminalmerchantid" => $this->merchantId,
            "txntype" => "sales",
            "txnamount" => $veri["siparisTutar"],
            "txncurrencycode" => "949",
            "txninstallmentcount" => $veri["taksit"] ?? '',
            "orderid" => $veri["siparisId"],
            "terminalid" => $this->terminalId,
            "successurl" => route('odeme.basarili'),
            "errorurl" => route('odeme.basarisiz'),
            "customeripaddress" => request()->ip(),
            "customeremailaddress" => $veri['eposta'],
            "secure3dhash" => $this->hashDizesiOlustur($veri)
        ];

        return $formVerileri;
    }


    private function guvenlikKoduOlustur()
    {
        $data = [
            $this->provisionPassword,
            str_pad((int)$this->terminalId, 9, 0, STR_PAD_LEFT)
        ];
        $shaData =  sha1(implode('', $data));
        return strtoupper($shaData);
    }

    private function hashDizesiOlustur(array $veri): string
    {
        $orderId  = $veri["siparisId"];
        $terminalId =  (int)$this->terminalId;
        $amount = $veri["siparisTutar"];
        $currencyCode = (int)949;
        $storeKey = $this->storeKey;
        $installmentCount = $veri["taksit"];
        $successUrl = route('odeme.basarili');
        $errorUrl = route('odeme.basarisiz');
        $type = "sales";
        $hashedPassword = $this->guvenlikKoduOlustur();
        return strtoupper(hash('sha512', $terminalId . $orderId . $amount  . $currencyCode . $successUrl . $errorUrl . $type . $installmentCount . $storeKey . $hashedPassword));
    }

    public function hashDogrulama()
    {
        $responseHash = $_POST['hash'] ?? '';
        $responseHashparams = $_POST['hashparams'] ?? '';

        $paramList = explode(':', $responseHashparams);

        $digestData = '';

        foreach ($paramList as $param) {
            $digestData .= isset($_POST[$param]) ? $_POST[$param] : '';
        }

        $digestData .= $this->storeKey;

        $hashBytes = strtoupper(hash('sha512', $digestData));

        if ($responseHash === $hashBytes) {
            return  true;
        } else {
            return false;
        }
    }
}
