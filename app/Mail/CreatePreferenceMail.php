<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreatePreferenceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.create_preference')->to(auth()->user()->email, auth()->user()->name)
            ->cc(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->subject('Creación de Pedido')
            ->with(['user' => auth()->user()]);
    }
}
