<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $products;
    public $customer;
    public $seller;
    public $customer_address;
    public $total;
    public $otherCost;

    public function __construct($transaction, $products, $customer, $seller, $customer_address , $total, $otherCost)
    {
        $this->transaction = $transaction;
        $this->products = $products;
        $this->customer = $customer;
        $this->seller = $seller;
        $this->customer_address = $customer_address;
        $this->total = $total;
        $this->otherCost = $otherCost;

    }

    public function build()
    {
        return $this->subject('Pembayaran Berhasil - Olebsai')
                    ->markdown('emails.payment-sucessfully');
    }

}

