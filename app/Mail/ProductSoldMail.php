<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductSoldMail extends Mailable
{
    use Queueable, SerializesModels;

    public $owner;
    public $product;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($owner, $product)
    {
        $this->owner = $owner;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): ProductSoldMail
    {
        return $this->view('mails.product_sold')->to($this->owner->email, $this->owner->name)
            ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->subject('Planta Vendida - INAGAVE');
    }
}
