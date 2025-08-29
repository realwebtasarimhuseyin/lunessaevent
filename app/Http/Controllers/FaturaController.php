<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

require_once app_path('Helper/FaturaHelper.php');

use EFatura\Fatura;

class FaturaController extends Controller
{
    public function gonderFatura(Request $request)
    {
        $data = $request->all();
        $user = $data['user'];

        if (strlen($user['identity_number']) == 10) {
            $unvan = $user['company'];
        } elseif (strlen($user['identity_number']) == 11) {
            $unvan = $user['first_name'] . ' ' . $user['last_name'];
        }

        $fatura = new Fatura();
        $fatura->setProfileId("TICARIFATURA");
        $fatura->setId($data['invoice_number']);
        $fatura->setUuid(\EFatura\Util::GUID());
        $fatura->setIssueDate(\EFatura\Util::issueDate());
        $fatura->setIssueTime(\EFatura\Util::issueTime());
        $fatura->setInvoiceTypeCode("SATIS");
        $fatura->setNote("");
        $fatura->setDocumentCurrencyCode("TRY");
        $fatura->setLineCountNumeric("2");

        $duzenleyen = new \EFatura\Cari();
        $duzenleyen->setUnvan("ER-AY TEKSTİL OTOMOTİV İNŞAAT SAN. VE TİC. LTD. ŞTİ.");
        $duzenleyen->setAdres("Orduzu Mah. Kültür Cad. Arslan-2 Apt. No: 38/B");
        $duzenleyen->setIl("Malatya");
        $duzenleyen->setIlce("Battalgazi");
        $duzenleyen->setUlkeKod("TR");
        $duzenleyen->setUlkeAd("Türkiye");
        $duzenleyen->setVergiDaire("Fırat V.D.");
        $duzenleyen->setVkn("3230512384");
        $duzenleyen->setTelefon("0422 325 44 09");
        $duzenleyen->setEposta("enbiyaer@eraytekstil.com");
        $duzenleyen->setWebsite("www.messtrend.com");
        $fatura->setDuzenleyen($duzenleyen);

        $alici = new \EFatura\Cari();
        $alici->setUnvan($unvan);
        $alici->setAdres($user['street']);
        $alici->setIl($user['city']);
        $alici->setIlce($user['district']);
        $alici->setUlkeKod("TR");
        $alici->setUlkeAd("TÜRKİYE");
        $alici->setVergiDaire($user['tax_office']);
        $alici->setVkn($user['identity_number']);
        /*$alici->setTip("TUZELKISI");
        $alici->setMersisno("ALICIMERSISNO");
        $alici->setHizmetno("ALICIHIZMETNO");
        $alici->setTicaretSicilNo("ALICITICSICNO");*/
        $alici->setTelefon($user['phone']);
        $alici->setEposta($user['email']);
        //$alici->setWebsite("ALICIWEBSITE");
        $alici->setGibUrn("urn:mail:defaultpk@edmbilisim.com.tr");
        $fatura->setAlici($alici);

        // Satırlar ve toplamları ekliyoruz
        $fatura->setSatirToplam($data['total_without_tax_amount']);
        $fatura->setVergiDahilToplam($data['total_amount']);
        $fatura->setToplamIskonto(0);
        $fatura->setYuvarlamaTutar(0);
        $fatura->setOdenecekTutar($data['total_amount']);

        $index = 1;
        foreach ($data['products'] as $product) {
            $satir = new \EFatura\Satir();
            $satir->setSiraNo($index);
            $satir->setBirim("NIU");
            $satir->setMiktar($product['quantity']);
            $satir->setBirimFiyat($product['unit_price']);
            $satir->setSatirToplam($product['total_price']);

            $satir_vergi = new \EFatura\Vergi();
            $satir_vergi->setSiraNo($index);
            $satir_vergi->setVergiHaricTutar($product['quantity'] * $product['unit_price']);
            $satir_vergi->setVergiTutar($product['unit_price'] * ($product['tax_rate'] / 100));
            $satir_vergi->setParaBirimKod("TRY");
            $satir_vergi->setVergiOran($product['tax_rate']);
            $satir_vergi->setVergiKod("0015");
            $satir_vergi->setVergiAd("KDV GERCEK");
            $satir->setVergi($satir_vergi);

            $mal_hizmet = new \EFatura\Urun();
            $mal_hizmet->setSerbestAciklama("Serbest açıklama: " . $product['product_title']);
            $mal_hizmet->setAd($product['product_title']);
            $satir->setUrun($mal_hizmet);

            $fatura->addSatir($satir);
            $index++;
        }

        try {
            //$client = new \EFatura\Client("https://test.edmbilisim.com.tr/EFaturaEDM21ea/EFaturaEDM.svc?singleWsdl");
            $client = new \EFatura\Client("https://portal2.edmbilisim.com.tr/EFaturaEDM/EFaturaEDM.svc?singleWsdl");
            $login = $client->login("eray.tek", "Abc.123");
            if ($login) {
                $sonuc = $client->sendInvoice($fatura);

                return response()->json([
                    'success' => true,
                    'message' => 'Fatura başarıyla gönderildi.',
                    'data' => $sonuc
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Fatura gönderiminde hata oluştu: ' . $e->getMessage()
            ]);
        }
    }
}


/* 

~Mustafa Şimşek tarafından yukarıdaki kod laravele uygun olarak çevrilmiştir lakin test edilmemiştir.

namespace App\Http\Controllers;

use App\Http\Requests\FaturaRequest;
use Illuminate\Http\JsonResponse;
use EFatura\Fatura;
use EFatura\Util;
use EFatura\Cari;
use EFatura\Satir;
use EFatura\Vergi;
use EFatura\Urun;
use EFatura\Client;

class FaturaController extends Controller
{
    public function gonderFatura(FaturaRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $data['user'];

        $unvan = $this->getUnvan($user);

        $fatura = $this->createFatura($data, $unvan);

        return $this->sendInvoice($fatura);
    }

    private function getUnvan(array $user): string
    {
        return (strlen($user['identity_number']) == 10)
            ? $user['company']
            : "{$user['first_name']} {$user['last_name']}";
    }

    private function createFatura(array $data, string $unvan): Fatura
    {
        $fatura = new Fatura();
        $fatura->setProfileId("TICARIFATURA")
               ->setId($data['invoice_number'])
               ->setUuid(Util::GUID())
               ->setIssueDate(Util::issueDate())
               ->setIssueTime(Util::issueTime())
               ->setInvoiceTypeCode("SATIS")
               ->setNote("")
               ->setDocumentCurrencyCode("TRY")
               ->setLineCountNumeric(count($data['products']));

        $fatura->setDuzenleyen($this->getDuzenleyen());
        $fatura->setAlici($this->getAlici($data['user'], $unvan));
        $fatura->setSatirToplam($data['total_without_tax_amount']);
        $fatura->setVergiDahilToplam($data['total_amount']);
        $fatura->setToplamIskonto(0);
        $fatura->setYuvarlamaTutar(0);
        $fatura->setOdenecekTutar($data['total_amount']);

        $this->addFaturaSatirlar($fatura, $data['products']);

        return $fatura;
    }

    private function getDuzenleyen(): Cari
    {
        return (new Cari())
            ->setUnvan("ER-AY TEKSTİL OTOMOTİV İNŞAAT SAN. VE TİC. LTD. ŞTİ.")
            ->setAdres("Orduzu Mah. Kültür Cad. Arslan-2 Apt. No: 38/B")
            ->setIl("Malatya")
            ->setIlce("Battalgazi")
            ->setUlkeKod("TR")
            ->setUlkeAd("Türkiye")
            ->setVergiDaire("Fırat V.D.")
            ->setVkn("3230512384")
            ->setTelefon("0422 325 44 09")
            ->setEposta("enbiyaer@eraytekstil.com")
            ->setWebsite("www.messtrend.com");
    }

    private function getAlici(array $user, string $unvan): Cari
    {
        return (new Cari())
            ->setUnvan($unvan)
            ->setAdres($user['street'])
            ->setIl($user['city'])
            ->setIlce($user['district'])
            ->setUlkeKod("TR")
            ->setUlkeAd("TÜRKİYE")
            ->setVergiDaire($user['tax_office'])
            ->setVkn($user['identity_number'])
            ->setTelefon($user['phone'])
            ->setEposta($user['email'])
            ->setGibUrn("urn:mail:defaultpk@edmbilisim.com.tr");
    }

    private function addFaturaSatirlar(Fatura $fatura, array $products): void
    {
        foreach ($products as $index => $product) {
            $satir = new Satir();
            $satir->setSiraNo($index + 1)
                  ->setBirim("NIU")
                  ->setMiktar($product['quantity'])
                  ->setBirimFiyat($product['unit_price'])
                  ->setSatirToplam($product['total_price'])
                  ->setVergi($this->createVergi($product, $index + 1))
                  ->setUrun($this->createUrun($product));

            $fatura->addSatir($satir);
        }
    }

    private function createVergi(array $product, int $index): Vergi
    {
        return (new Vergi())
            ->setSiraNo($index)
            ->setVergiHaricTutar($product['quantity'] * $product['unit_price'])
            ->setVergiTutar($product['unit_price'] * ($product['tax_rate'] / 100))
            ->setParaBirimKod("TRY")
            ->setVergiOran($product['tax_rate'])
            ->setVergiKod("0015")
            ->setVergiAd("KDV GERCEK");
    }

    private function createUrun(array $product): Urun
    {
        return (new Urun())
            ->setSerbestAciklama("Serbest açıklama: " . $product['product_title'])
            ->setAd($product['product_title']);
    }

    private function sendInvoice(Fatura $fatura): JsonResponse
    {
        try {
            $client = new Client("https://portal2.edmbilisim.com.tr/EFaturaEDM/EFaturaEDM.svc?singleWsdl");
            $login = $client->login("eray.tek", "Abc.123");

            if (!$login) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giriş başarısız. Lütfen bilgilerinizi kontrol edin.'
                ], 401);
            }

            $sonuc = $client->sendInvoice($fatura);

            return response()->json([
                'success' => true,
                'message' => 'Fatura başarıyla gönderildi.',
                'data' => $sonuc
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Fatura gönderiminde hata oluştu.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
 */