<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $product;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payment, $product)
    {
        $this->payment = $payment;
        $this->product = $product;
        $this->user = User::find($this->payment->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): FeedbackMail
    {
        return $this->view('mails.feedback')->to($this->user->email, $this->user->name)
            ->cc(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->subject('Pedido Completado');
    }
}
