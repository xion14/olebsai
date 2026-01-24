<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountVerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kode;
    public $email;
    public $name;

    public function __construct($kode = null, $email = null , $name = null)
    {
        $this->kode = $kode;
        $this->email = $email;
        $this->name = $name;
    }

    public function build()
    {
        return $this->subject('Kode Verifikasi Akun Anda - Olebsai')
                    ->markdown('emails.account-verification-code');
    }

}
