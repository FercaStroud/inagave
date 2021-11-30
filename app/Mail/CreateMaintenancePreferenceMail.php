<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateMaintenancePreferenceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $maintenance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maintenance)
    {
        $this->maintenance = $maintenance;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.create_maintenance_preference')->to(auth()->user()->email, auth()->user()->name)
            ->cc(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'))
            ->subject('Creación Pago por Mantenimiento')
            ->with(['user' => auth()->user()]);
    }
}
