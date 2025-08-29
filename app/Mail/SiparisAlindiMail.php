<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiparisAlindiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $siparis;

    /**
     * Sipariş verilerini Mail sınıfına ilet.
     *
     * @param $siparis
     */
    public function __construct($siparis)
    {
        $this->siparis = $siparis;
    }


    public function build()
    {
     
        // Burada, ayarlardan gelen mail adresini kullanabilirsiniz
        return $this->from($this->siparis->siparisBilgi->eposta) // Burayı ayar dosyası üzerinden dinamik hale getirebilirsiniz
            ->subject('Siparişiniz Alındı!')
            ->view('emails.siparis-alindi') // E-posta içeriği için kullanacağınız Blade görünümü
            ->with([
                'siparis' => $this->siparis
            ]);
    }
}
