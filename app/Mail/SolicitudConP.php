<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SolicitudConP extends Mailable
{
    use Queueable, SerializesModels;

    public $param; //Variable publica
    public $totales; //Variable publica
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($param, $totales)
    {
        $this->param = $param;
        $this->totales = $totales;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmación de pago.')->view('mail.solicitudConP_mod');
        //return $this->view('view.name');
    }
}
