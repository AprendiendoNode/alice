<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CmdAlerts extends Mailable
{
    use Queueable, SerializesModels;

    public $param; //Variable publica

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        $this->param = $param;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('SNMP Error - ' . 'Cliente: ' . $this->param['hotel'])->view('mail.priority');
    }
}
