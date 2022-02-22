<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreatePreferenceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payment, $user)
    {
        $this->payment = $payment;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.create_preference')->to($this->user->email, $this->user->name)
            ->cc(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->subject('Creación de Pedido')
            ->with(['user' => auth()->user()]);
    }
}
