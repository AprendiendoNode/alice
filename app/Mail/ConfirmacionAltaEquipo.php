<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmacionAltaEquipo extends Mailable
{
  use Queueable, SerializesModels;

  public $equipment;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($equipment)
  {
      $this->equipment = $equipment;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
      return $this->subject('Confirmación Alta de Equipo')->view('mail.confirmacionAltaEquipo');
  }

}
