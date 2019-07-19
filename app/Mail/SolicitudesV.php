<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SolicitudesV extends Mailable
{
    use Queueable, SerializesModels;

    public $param; //Variable publica
    public $param1;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($param, $param1)
    {
        $this->param = $param;
        $this->param1 = $param1;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Solicitud de viático')->view('mail.solicitudV');
    }
}
