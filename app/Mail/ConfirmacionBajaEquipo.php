<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmacionBajaEquipo extends Mailable
{
  use Queueable, SerializesModels;

  public $equipment;
  public $param1;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($equipment, $param1)
  {
      $this->equipment = $equipment;
      $this->param1 = $param1;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
      return $this->subject('Notificación Baja de Equipo')->view('mail.confirmacionBajaEquipo');
  }

}
