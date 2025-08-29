<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SifreSifirlaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $eposta;
    public $kullaniciEposta;

    public function __construct($token, $eposta, $kullaniciEposta)
    {
        $this->token = $token;
        $this->eposta = $eposta;
        $this->kullaniciEposta = $kullaniciEposta;
    }

    public function build()
    {
        // Burada, ayarlardan gelen mail adresini kullanabilirsiniz
        return $this->from($this->eposta) // Burayı ayar dosyası üzerinden dinamik hale getirebilirsiniz
                    ->subject('Şifre Sıfırlama')
                    ->view('emails.sifre-sifirla') // E-posta içeriği için kullanacağınız Blade görünümü
                    ->with([
                        'token' => $this->token,
                        'eposta' => $this->kullaniciEposta,
                    ]);
    }
}
