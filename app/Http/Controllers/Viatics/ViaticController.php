<?php

namespace App\Http\Controllers\Viatics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Base\Message;
use \Carbon\Carbon;
use Auth;
use DB;
use App\Notifications\MessageViatic;

class ViaticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $recipient_user = '7';
        $message = Message::create([
          'sender_id' => auth()->id(), //USUARIO LOGUEADO
          'recipient_id' => $recipient_user, //USUARIO QUE RECIBE LA NOTIFICACION
          'body' =>  'Ejemplo',
          'folio' => 'SP-JUL19-235885',
          'status' => 'Elaboro',
          'date' => '2019-07-10 11:330:36',
          'link' => route('home'),

          /*
          'body' => array(
            'folio' => 'SP-JUL19-235885',
            'estatus' => 'Elaboro',
            'fecha' => '2019-07-10 11:330:36',
            'link' => route('home'),
          )*/
           //'Folio: SP-JUL19-003398 <BR> ESTATUS: Elaborado' //Mensaje a visualizar
        ]);

        $recipient = User::find($recipient_user);
        $recipient->notify(new MessageViatic($message));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
