<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MessageViatic extends Notification
{
    protected $message;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
        // return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
      $mensaje = $this->message->toArray();
      if($mensaje['status'] == 'Denegado') {
        $mensaje['link'] = "http://localhost:8000/notificaciones_read/".$this->id;
      }
      return $mensaje; //Guardo el mensaje en forma de array
      // return []; //Definimos la informacion a almacenar
      /* return [
         'folio' => 'SP-JUL19-235885',
         'estatus' => 'Elaboro',
         'fecha' => '2019-07-10 11:330:36',
         'link' => route('home'),
       ];
      */
    }
}
