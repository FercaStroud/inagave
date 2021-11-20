<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $product;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payment, $product)
    {
        $this->payment = $payment;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.feedback')->to(auth()->user()->email, auth()->user()->name)
            ->cc(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->subject('Pedido Completado')
            ->with(['user' => auth()->user()]);
    }
}
