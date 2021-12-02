<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DepositToWalletMail extends Mailable
{
    use Queueable, SerializesModels;

    public $owner;
    public $transactions;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($owner, $transactions)
    {
        $this->owner = $owner;
        $this->transactions = $transactions;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.deposit_to_wallet')->to($this->owner->email, $this->owner->name)
            ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->subject('Se ha depositado a tu cuenta de INAGAVE');
    }
}
