<?php

namespace App\Mail;

use App\Product;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MaintenanceFeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $maintenance;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maintenance)
    {
        $this->product = Product::Find($maintenance->product_id);
        $this->maintenance = $maintenance;
        $this->user = User::find($this->product->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): MaintenanceFeedbackMail
    {
        return $this->view('mails.maintenance_feedback')->to($this->user->email, $this->user->name)
            ->cc(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->subject('Pago de Mantenimiento Completado');
    }
}
