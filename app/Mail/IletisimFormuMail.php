<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IletisimFormuMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formVerileri;

    /**
     * Create a new message instance.
     */
    public function __construct($formVerileri)
    {
        $this->formVerileri = $formVerileri;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('İletişim Formu Mesajı')
                    ->view('emails.iletisim')
                    ->with('veriler', $this->formVerileri);
    }
}
