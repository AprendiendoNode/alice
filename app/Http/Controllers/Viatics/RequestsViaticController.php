<?php

namespace App\Http\Controllers\Viatics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\NotificationController;
use DB;
use Auth;
use Carbon\Carbon;
use App\User; //Importar el modelo eloquent
use App\Cadena;
use App\Jefedirecto;
use App\Hotel;

use App\Models\Viatics\Viatic_service;
//use App\Models\Viatics\Vitic_beneficiary;
use App\Models\Viatics\Viatic_state;
use App\Models\Viatics\Viatic_list_concept;
use App\Models\Viatics\Viatic;
use App\Models\Viatics\Concept;
use App\Models\Viatics\viatic_user_status;
use App\Models\Viatics\Viatic_state_concept;
use Mail;
use App\Mail\ConfirmacionV;
use App\Mail\NotifViatic;
use App\Models\Base\Message;
use App\Notifications\MessageViatic;

class RequestsViaticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('permitted.viaticos.history_requests');
    }
    public function deny_viatic (Request $request) {
  $user = Auth::user()->id;
  $viatic_id= $request->get('idents');
  $valor= 'false';
  $comment = $request->comment;

  if (auth()->user()->can('Deny travel allowance request')) {
    $count_md = DB::table('viatics')->where('id', '=', $viatic_id)->where('state_id', '!=', '5')->where('state_id', '!=', '6')->count();
    if ($count_md != '0') {
      $sql = DB::table('viatics')->where('id', '=', $viatic_id)->update(['state_id' => '5', 'updated_at' => Carbon::now()]);
      $new_reg_viatic = new viatic_user_status;
      $new_reg_viatic->viatic_id = $viatic_id;
      $new_reg_viatic->user_id = $user;
      $new_reg_viatic->status_id = '5';
      $new_reg_viatic->save();
      $insert = DB::table('deny_viacomments')->insert([
        'name' => $comment,
        'viatic_id' => $viatic_id,
        'user_id' => $user,
        'created_at' => Carbon::now()
      ]);
      $result = DB::select('CALL px_viatics_email_notif(?)', array($viatic_id));
        $service_name = $result[0]->service_name;
        $folio = $result[0]->folio;
        $beneficiario = $result[0]->beneficiario;
        $solicitado = $result[0]->solicitado;
        $benef_email = $result[0]->email;
        $url = action('Viatics\RequestsViaticController@index');
        $params = [
          'servicio' => $service_name,
          'folio' => $folio,
          'beneficiario' => $beneficiario,
          'solicitado' => $solicitado,
          'usuario' => Auth::user()->name,
          'mensaje' => 'DENEGADO',
          'url' => $url
        ];

      Mail::to($benef_email)->send(new NotifViatic($params));
      $valor= 'true';

      $NotificationOBJ= new NotificationController();
      $leer=DB::table('notifications')->select('id')->where('data','like','%'.$folio.'%')->get();
      foreach($leer as $folioleido){
        //info($folioleido->id);
        $NotificationOBJ->readbyfolio($folioleido->id);
      }

      $user_soli = viatic_user_status::select('user_id')->where([//Usuario que solicito el viatico
        ['viatic_id', $viatic_id],
        ['status_id', 1]
      ])->value('user_id');

      $benef_id=DB::table('users')->select('id')->where('email',$benef_email)->get();

      $recipients=array_unique(array($user_soli,$benef_id[0]->id));

      foreach($recipients as $recipient_id){
        $message = Message::create([
                    'sender_id' => auth()->id(), //USUARIO LOGUEADO
                    'recipient_id' => $recipient_id, //USUARIO QUE RECIBE LA NOTIFICACION
                    'body' =>  $service_name,
                    'folio' => $folio,
                    'status' => 'Denegado', //Status pendiente
                    'date' => Carbon::now(),
                    'link' => route('view_request_via'),
                  ]);
                  $recipient = User::find($recipient_id);
                  $recipient->notify(new MessageViatic($message));
      }

    }
  }
  return $valor;
}
public function history (Request $request) {
  $user = Auth::user()->id;
  $email = Auth::user()->email;

  $input_date_i= $request->get('date_to_search');

  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }

  if (auth()->user()->can('Travel allowance notification')) {
    if (auth()->user()->can('View level zero notifications')){ /*Le muestro sus solicitudes al usuario*/
      $result = DB::select('CALL history_viatic_user_solicitado_aprobado (?,?)', array($user, $date));
      return json_encode($result);
    }
    if (auth()->user()->can('View level one notifications')){ /*Notificaciones del usuario, con estatus nuevo*/
      $result = DB::select('CALL  history_viatic_user_solicitado_aprobado_N1 (?)', array($date));
      return json_encode($result);
    }
    if (auth()->user()->can('View level two notifications')){ /*Notificaciones del usuario, con estatus pendiente*/
      $result = DB::select('CALL  history_viatic_user_solicitado_aprobado_N2 (?,?)', array($date, $id_gerente));info($date);info($id_gerente);
      return json_encode($result);
    }
    if (auth()->user()->can('View level three notifications')){ /*Notificaciones del usuario, con estatus aprueba*/
      $result = DB::select('CALL history_viatic_user_solicitado_aprobado (?,?)', array($user, 3));
      return json_encode($result);
    }
    if (auth()->user()->can('View level four notifications')){ /*Notificaciones del usuario, con estatus pagado*/
      $result = DB::select('CALL history_viatic_user_solicitado_aprobado (?,?)', array($user, 4));
      return json_encode($result);
    }
  }
  else {}
}
public function history_zero (Request $request) {
  $user = Auth::user()->id;
  $result = array();
  $input_date_i= $request->get('date_to_search');
  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }

  if (auth()->user()->can('Travel allowance notification')) {
    if (auth()->user()->can('View level zero notifications')){ /*Le muestro sus solicitudes al usuario*/
      $result = DB::select('CALL history_viatic_user_solicitado_aprobado (?,?)', array($user, $date));
      $count = count($result);
      for($i = 0; $i < $count; $i++)
      {
        $solicitado = $result[$i]->solicitado;
        $solicitado_format = '$' . number_format($solicitado, 2, '.', ',') . ' MXN';

        $aprobado = $result[$i]->aprobado;
        $aprobado_format = '$' . number_format($aprobado, 2, '.', ',') . ' MXN';

        $result[$i]->solicitado = $solicitado_format;
        $result[$i]->aprobado = $aprobado_format;
      }

    }
  }

  return json_encode($result);
}
public function show_viatic_up (Request $request) {
  $viatic= $request->get('viatic');
  $result = DB::select('CALL history_viatic_user_beneficiarios (?)', array($viatic));
  return json_encode($result);
}
public function show_viatic_down (Request $request) {
  $viatic= $request->get('viatic');
  $result = DB::select('CALL history_viatic_user_conceptos (?)', array($viatic));
  $count = count($result);
  for($i = 0; $i < $count; $i++)
  {
    $amount = $result[$i]->amount;
    $amount_format = '$' . number_format($amount, 2, '.', ',') . ' MXN';

    $total = $result[$i]->total;
    $total_format = '$' . number_format($total, 2, '.', ',') . ' MXN';

    $result[$i]->amount = $amount_format;
    $result[$i]->total = $total_format;
  }
  return json_encode($result);
}
public function history_one (Request $request) { /*Devuelve todas las solicitudes del usuario con estatus *Nuevo* para aprobar y denegar conceptos*/
  $user = Auth::user()->id;
  $estado = 1;
  $result = array();
  $input_date_i= $request->get('date_to_search');
  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }

  if (auth()->user()->can('Travel allowance notification')) {
    if (auth()->user()->can('View level one notifications')){ /*Notificaciones del usuario, con estatus nuevo*/
      $result = DB::select('CALL history_viatic_user_solicitado_aprobado_status (?,?,?)', array($user, $date, $estado));
      $count = count($result);
      for($i = 0; $i < $count; $i++)
      {
        $solicitado = $result[$i]->solicitado;
        $solicitado_format = '$' . number_format($solicitado, 2, '.', ',') . ' MXN';

        $aprobado = $result[$i]->aprobado;
        $aprobado_format = '$' . number_format($aprobado, 2, '.', ',') . ' MXN';

        $result[$i]->solicitado = $solicitado_format;
        $result[$i]->aprobado = $aprobado_format;
      }
      return json_encode($result);
    }
  }
  return json_encode($result);
}
public function pertain_viatic (Request $request) { /*Me pertenece el viatico. 0 Significa NO. 1 Significa SI*/
  $user = Auth::user()->id;
  $viatic_id= $request->get('viatic');
  $input_date_i= $request->get('date_to_search');
  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }
  $find_pertain_viatic = DB::select('CALL pertain_viatic_user_nuevo (?,?,?)', array($user, $viatic_id, $date));
  $result_find_pertain_viatic = $find_pertain_viatic[0]->respuesta;
  return $result_find_pertain_viatic;
}
public function edit_status_one (Request $request) {
  info($request);
  $viaticos_id = json_decode($request->idents);
  $user = Auth::user()->id;
  $user_email = Auth::user()->email;
  $valor= 'false';

  for ($i=0; $i <= (count($viaticos_id)-1); $i++) {
    $sql = DB::table('viatics')->where('id', '=', $viaticos_id[$i])->update(['state_id' => '2', 'updated_at' => Carbon::now()]);
    $new_reg_viatic = new viatic_user_status;
    $new_reg_viatic->viatic_id = $viaticos_id[$i];
    $new_reg_viatic->user_id = $user;
    $new_reg_viatic->status_id = '2'; // Pendiente.
    $new_reg_viatic->save();
    $valor= 'true';

    // Variables de IDS.
    $service = DB::table('viatics')->where('id',$viaticos_id[$i])->value('service_id');
    $user_benef = DB::table('viatics')->where('id',$viaticos_id[$i])->value('user_id');
    $user_soli = viatic_user_status::select('user_id')->where([
      ['viatic_id', $viaticos_id[$i]],
      ['status_id', 1]
    ])->value('user_id');

    //email beneficiario.
    $benef_nombre = DB::table('users')->select('name')->where('id', $user_benef)->value('name');
    $benef_email =  DB::table('users')->select('email')->where('id', $user_benef)->value('email');
    $benef_email = trim($benef_email);
    //email del que solicito.
    $nombre_solic = DB::table('users')->select('name')->where('id', $user_soli)->value('name');
    $email_solic = DB::table('users')->select('email')->where('id', $user_soli)->value('email');
    $email_solic = trim($email_solic);

    $service_name = Viatic_service::select('name')->where('id', $service)->value('name');
    $folio = DB::table('viatics')->where('id',$viaticos_id[$i])->value('folio');
    $url = action('Viatics\RequestsViaticController@index');
    //$message = "";
    $params = [
      'servicio' => $service_name,
      'folio' => $folio,
      'beneficiario' => $benef_nombre,
      'solicitado' => $nombre_solic,
      'usuario' => Auth::user()->name,
      'mensaje' => 'PENDIENTE',
      'url' => $url
    ];
    //$result = DB::select('CALL history_viatic_user_conceptos (?)', array($viaticos_id[$i]));
    Mail::to($benef_email)->send(new NotifViatic($params));
    $NotificationOBJ= new NotificationController();
    $leer=DB::table('notifications')->select('id')->where('data','like','%'.$folio.'%')->get();
    foreach($leer as $folioleido){
      //info($folioleido->id);
      $NotificationOBJ->readbyfolio($folioleido->id);
    }
    // Notificacion
    $recipient_notification= DB::Select('CALL px_iduser_viaticsXfolio (?)',array($folio));//Usuario que autoriza el viatico
         $message = Message::create([
              'sender_id' => auth()->id(), //USUARIO LOGUEADO
              'recipient_id' => $recipient_notification[0]->id, //USUARIO QUE RECIBE LA NOTIFICACION
              'body' =>  $service_name,
              'folio' => $folio,
              'status' => 'Pendiente', //Status pendiente
              'date' => Carbon::now(),
              'link' => route('view_request_via'),
            ]);

            $recipient = User::find($recipient_notification[0]->id);
            $recipient->notify(new MessageViatic($message));


    }

  return $valor;
}
public function find_concept_all (Request $request) {
  $user = Auth::user()->id;
  $result = array();
  $viatic= $request->get('viatic');
  if (auth()->user()->can('Travel allowance notification')) {
    if (auth()->user()->can('View level one notifications')){ /*Le muestro los conceptos del viatico*/
      $result = DB::select('CALL history_viatic_user_conceptos (?)', array($viatic));
    }
  }
  return $result;
}
public function find_concept (Request $request) {
  $val = $request->val;
  $concept = Viatic_state_concept::select('id', 'name')->get();
  $conceptos_dc ="";

  for ($i=0; $i < count($concept); $i++) {
    if ($val === $concept[$i]->name) {
      $conceptos_dc = $conceptos_dc.'<option value="'.$concept[$i]->id.'" selected>'.$concept[$i]->name.'</option>';
    }
    else {
      $conceptos_dc = $conceptos_dc.'<option value="'.$concept[$i]->id.'">'.$concept[$i]->name.'</option>';
    }
  }

  return $conceptos_dc;
}
public function history_two (Request $request) { /*Devuelve todas las solicitudes del usuario con estatus *Pendiente* para aprobar y denegar conceptos*/
  $user = Auth::user()->id;
  $email = Auth::user()->email;
  // $user = 6;
  // $email = 'rgonzalez@sitwifi.com';
  // $email = 'aarciga@sitwifi.com' ;
  $find_gerente = DB::select('CALL find_email_jefe (?)', array($email));
  $result_find_gerente = $find_gerente[0]->respuesta;
  $estado = 2;
  $result = array();

  $input_date_i= $request->get('date_to_search');
  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }

  if (auth()->user()->can('Travel allowance notification')) {
    if (auth()->user()->can('View level two notifications')){ /*Notificaciones del usuario, con estatus nuevo*/
      $result = DB::select('CALL history_viatic_user_solicitado_aprobado_status_jefe (?,?,?,?)', array($user, $date, $estado, $result_find_gerente));
      $count = count($result);
      for($i = 0; $i < $count; $i++)
      {
        $solicitado = $result[$i]->solicitado;
        $solicitado_format = '$' . number_format($solicitado, 2, '.', ',') . ' MXN';

        $aprobado = $result[$i]->aprobado;
        $aprobado_format = '$' . number_format($aprobado, 2, '.', ',') . ' MXN';

        $result[$i]->solicitado = $solicitado_format;
        $result[$i]->aprobado = $aprobado_format;
      }

    }
  }
  return json_encode($result);
}
public function pertain_viatic_two (Request $request) { /*Me pertenece el viatico. 0 Significa NO. 1 Significa SI*/
  $user = Auth::user()->id;
  //$user = 16;
  $viatic_id= $request->get('viatic');
  $input_date_i= $request->get('date_to_search');
  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }

  $find_pertain_viatic = DB::select('CALL pertain_viatic_user_pendiente (?,?,?)', array($user, $viatic_id, $date));
  $result_find_pertain_viatic = $find_pertain_viatic[0]->respuesta;
  return $result_find_pertain_viatic;
}
public function edit_status_two (Request $request) {
  $viaticos_id = json_decode($request->idents);
  $user = Auth::user()->id;
  $valor= 'false';
  if (isset($request->stat)) {
    $state_id = DB::table('viatics')->where('id', $viaticos_id[0])->value('state_id');
    if ($state_id != 2) {
      $valor= 'false';
      return $valor;
    }else{
      $sql = DB::table('viatics')->where('id', $viaticos_id[0])->update(['state_id' => '3', 'updated_at' => Carbon::now()]);
      $new_reg_viatic = new viatic_user_status;
      $new_reg_viatic->viatic_id = $viaticos_id[0];
      $new_reg_viatic->user_id = $user;
      $new_reg_viatic->status_id = '3'; // Verificado.
      $new_reg_viatic->save();
      $valor= 'true';
      return $valor;
    }
  }else{
    for ($i=0; $i < count($viaticos_id); $i++) {
      $sql = DB::table('viatics')->where('id', '=', $viaticos_id[$i])->update(['state_id' => '3', 'updated_at' => Carbon::now()]);
      $new_reg_viatic = new viatic_user_status;
      $new_reg_viatic->viatic_id = $viaticos_id[$i];
      $new_reg_viatic->user_id = $user;
      $new_reg_viatic->status_id = '3'; // Verificado.
      $new_reg_viatic->save();
      $valor= 'true';

      // Variables de IDS.
      $service = DB::table('viatics')->where('id',$viaticos_id[$i])->value('service_id');
      $user_benef = DB::table('viatics')->where('id',$viaticos_id[$i])->value('user_id');
      $user_soli = viatic_user_status::select('user_id')->where([
        ['viatic_id', $viaticos_id[$i]],
        ['status_id', 1]
      ])->value('user_id');

      //email beneficiario.
      $benef_nombre = DB::table('users')->select('name')->where('id', $user_benef)->value('name');
      $benef_email =  DB::table('users')->select('email')->where('id', $user_benef)->value('email');
      $benef_email = trim($benef_email);
      $correos = [$benef_email, 'bdejesus@sitwifi.com'];
      //email del que solicito.
      $nombre_solic = DB::table('users')->select('name')->where('id', $user_soli)->value('name');
      $email_solic = DB::table('users')->select('email')->where('id', $user_soli)->value('email');
      $email_solic = trim($email_solic);

      $service_name = Viatic_service::select('name')->where('id', $service)->value('name');
      $folio = DB::table('viatics')->where('id',$viaticos_id[$i])->value('folio');
      $url = action('Viatics\RequestsViaticController@index');
      //$message = "";
      $params = [
        'servicio' => $service_name,
        'folio' => $folio,
        'beneficiario' => $benef_nombre,
        'solicitado' => $nombre_solic,
        'usuario' => Auth::user()->name,
        'mensaje' => 'VERIFICADO',
        'url' => $url
      ];
      $result = DB::select('CALL history_viatic_user_conceptos (?)', array($viaticos_id[$i]));
      Mail::to($benef_email)->send(new NotifViatic($params));
      $NotificationOBJ= new NotificationController();
      $leer=DB::table('notifications')->select('id')->where('data','like','%'.$folio.'%')->get();
      foreach($leer as $folioleido){
        //info($folioleido->id);
        $NotificationOBJ->readbyfolio($folioleido->id);
      }
      // Notificacion
      switch ($service) {
        case 2:
          // René González Sánchez
            $recipient_notification_id= 14; //14;
          break;
        case 3:
            // René González Sánchez
            $recipient_notification_id= 14;
        break;
        case 4:
              // John Thomas Walker Del Olmo
            $recipient_notification_id= 13;
        break;
        case 5:
                // Alejandro Espejo Sokol
            $recipient_notification_id= 11;
        break;
        case 6:
            // René González Sánchez
            $recipient_notification_id= 14;
        break;
        default:
          // code...
          break;
      }

           $message = Message::create([
                'sender_id' => auth()->id(), //USUARIO LOGUEADO
                'recipient_id' => $recipient_notification_id, //USUARIO QUE RECIBE LA NOTIFICACION dependiendo el servicio
                'body' =>  $service_name,
                'folio' => $folio,
                'status' => 'Verificado', //Status pendiente
                'date' => Carbon::now(),
                'link' => route('view_request_via'),
              ]);

              $recipient = User::find($recipient_notification_id);
              $recipient->notify(new MessageViatic($message));

    }
    return $valor;
  }
  return $valor;
}
public function history_three (Request $request) { /*Devuelve todas las solicitudes del usuario con estatus *Verifica* para aprobar y denegar conceptos*/
  $user = Auth::user()->id;
  $estado = 3;
  $result = array();
  if ($user === 424) {
    $user = 13;
  }
  $input_date_i= $request->get('date_to_search');
  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }

  if (auth()->user()->can('Travel allowance notification')) {
    if (auth()->user()->can('View level three notifications')){ /*Notificaciones del usuario, con estatus nuevo*/
      $result = DB::select('CALL history_viatic_user_solicitado_aprobado_status_verifica (?,?,?)', array($user, $date, $estado));
      $count = count($result);
      for($i = 0; $i < $count; $i++)
      {
        $solicitado = $result[$i]->solicitado;
        $solicitado_format = '$' . number_format($solicitado, 2, '.', ',') . ' MXN';

        $aprobado = $result[$i]->aprobado;
        $aprobado_format = '$' . number_format($aprobado, 2, '.', ',') . ' MXN';

        $result[$i]->solicitado = $solicitado_format;
        $result[$i]->aprobado = $aprobado_format;
      }
    }
  }
  return json_encode($result);
}
public function pertain_viatic_three (Request $request) { /*Me pertenece el viatico. 0 Significa NO. 1 Significa SI*/
  $user = Auth::user()->id;
  $viatic_id= $request->get('viatic');
  $input_date_i= $request->get('date_to_search');
  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }

  $find_pertain_viatic = DB::select('CALL pertain_viatic_user_verifica (?,?,?)', array($user, $viatic_id, $date));
  $result_find_pertain_viatic = $find_pertain_viatic[0]->respuesta;
  return $result_find_pertain_viatic;
}
public function edit_status_three (Request $request) {
  $viaticos_id = json_decode($request->idents);
  $user = Auth::user()->id;
  $valor= 'false';
  if (isset($request->stat)) {
    $state_id = DB::table('viatics')->where('id', $viaticos_id[0])->value('state_id');
    if ($state_id != 3) {
      $valor= 'false';
      return $valor;
    }else{
      $sql = DB::table('viatics')->where('id', $viaticos_id[0])->update(['state_id' => '4', 'updated_at' => Carbon::now()]);
      $new_reg_viatic = new viatic_user_status;
      $new_reg_viatic->viatic_id = $viaticos_id[0];
      $new_reg_viatic->user_id = $user;
      $new_reg_viatic->status_id = '4'; // Aprueba.
      $new_reg_viatic->save();
      $valor= 'true';
      return $valor;
    }
  }else{
    for ($i=0; $i < count($viaticos_id); $i++) {
      $sql = DB::table('viatics')->where('id', '=', $viaticos_id[$i])->update(['state_id' => '4', 'updated_at' => Carbon::now()]);
      $new_reg_viatic = new viatic_user_status;
      $new_reg_viatic->viatic_id = $viaticos_id[$i];
      $new_reg_viatic->user_id = $user;
      $new_reg_viatic->status_id = '4'; // Aprueba.
      $new_reg_viatic->save();
      $valor= 'true';

      // Variables de IDS.
      $service = DB::table('viatics')->where('id',$viaticos_id[$i])->value('service_id');
      $user_benef = DB::table('viatics')->where('id',$viaticos_id[$i])->value('user_id');
      $user_soli = viatic_user_status::select('user_id')->where([
        ['viatic_id', $viaticos_id[$i]],
        ['status_id', 1]
      ])->value('user_id');

      //email beneficiario.
      $benef_nombre = DB::table('users')->select('name')->where('id', $user_benef)->value('name');
      $benef_email =  DB::table('users')->select('email')->where('id', $user_benef)->value('email');
      $benef_email = trim($benef_email);
      //email del que solicito.
      $nombre_solic = DB::table('users')->select('name')->where('id', $user_soli)->value('name');
      $email_solic = DB::table('users')->select('email')->where('id', $user_soli)->value('email');
      $email_solic = trim($email_solic);

      $service_name = Viatic_service::select('name')->where('id', $service)->value('name');
      $folio = DB::table('viatics')->where('id',$viaticos_id[$i])->value('folio');
      $url = action('Viatics\RequestsViaticController@index');
      //$message = "";
      $params = [
        'servicio' => $service_name,
        'folio' => $folio,
        'beneficiario' => $benef_nombre,
        'solicitado' => $nombre_solic,
        'usuario' => Auth::user()->name,
        'mensaje' => 'APROBADO',
        'url' => $url
      ];
      //$result = DB::select('CALL history_viatic_user_conceptos (?)', array($viaticos_id[$i]));
      info($benef_email);
      $correos = [$benef_email, 'bdejesus@sitwifi.com'];
      Mail::to($benef_email)->send(new NotifViatic($params));
      $NotificationOBJ= new NotificationController();
      $leer=DB::table('notifications')->select('id')->where('data','like','%'.$folio.'%')->get();
      foreach($leer as $folioleido){
        //info($folioleido->id);
        $NotificationOBJ->readbyfolio($folioleido->id);
      }
      //Notificacion
      $Users_notif=User::permission('View level four notifications')->get();//Lista de usuarios
      //info($Users_notif[0]['id']);
      foreach($Users_notif as $user_notificado){
        //info($user_notificado['id']);

      $message = Message::create([
           'sender_id' => auth()->id(), //USUARIO LOGUEADO
           'recipient_id' => $user_notificado['id'], //USUARIO QUE RECIBE LA NOTIFICACION dependiendo el servicio
           'body' =>  $service_name,
           'folio' => $folio,
           'status' => 'Aprobado',
           'date' => Carbon::now(),
           'link' => route('view_request_via'),
         ]);

         $recipient = User::find($user_notificado['id']);
         $recipient->notify(new MessageViatic($message));

       } //Fin foreach
    }
    return $valor;
  }
  return $valor;
}
public function history_four (Request $request) { /*Devuelve todas las solicitudes del usuario con estatus *Verifica* para aprobar y denegar conceptos*/
  $user = Auth::user()->id;
  $estado = 4;
  $result = array();

  $input_date_i= $request->get('date_to_search');
  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }

  if (auth()->user()->can('Travel allowance notification')) {
    if (auth()->user()->can('View level four notifications')){ /*Notificaciones del usuario, con estatus nuevo*/
      $result = DB::select('CALL history_viatic_user_solicitado_aprobado_status_verifica (?,?,?)', array($user, $date, $estado));
      $count = count($result);
      for($i = 0; $i < $count; $i++)
      {
        $solicitado = $result[$i]->solicitado;
        $solicitado_format = '$' . number_format($solicitado, 2, '.', ',') . ' MXN';

        $aprobado = $result[$i]->aprobado;
        $aprobado_format = '$' . number_format($aprobado, 2, '.', ',') . ' MXN';

        $result[$i]->solicitado = $solicitado_format;
        $result[$i]->aprobado = $aprobado_format;
      }
    }
  }
  return json_encode($result);
}
public function pertain_viatic_four (Request $request) { /*Me pertenece el viatico. 0 Significa NO. 1 Significa SI*/
  $user = Auth::user()->id;
  $viatic_id= $request->get('viatic');
  $input_date_i= $request->get('date_to_search');
  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }

  $find_pertain_viatic = DB::select('CALL pertain_viatic_user_aprueba (?,?,?)', array($user, $viatic_id, $date));
  $result_find_pertain_viatic = $find_pertain_viatic[0]->respuesta;
  return $result_find_pertain_viatic;
}
public function edit_status_four (Request $request) {
  $viaticos_id = json_decode($request->idents);
  $user = Auth::user()->id;
  $valor= 'false';
  if (isset($request->stat)) {
    $state_id = DB::table('viatics')->where('id', $viaticos_id[0])->value('state_id');
    if ($state_id != 4) {
      $valor= 'false';
      return $valor;
    }else{
      $sql = DB::table('viatics')->where('id', $viaticos_id[0])->update(['state_id' => '6', 'updated_at' => Carbon::now()]);
      $new_reg_viatic = new viatic_user_status;
      $new_reg_viatic->viatic_id = $viaticos_id[0];
      $new_reg_viatic->user_id = $user;
      $new_reg_viatic->status_id = '6'; // Aprueba.
      $new_reg_viatic->save();
      $valor= 'true';
      return $valor;
    }
  }else{
    for ($i=0; $i < count($viaticos_id); $i++) {
      $sql = DB::table('viatics')->where('id', '=', $viaticos_id[$i])->update(['state_id' => '6', 'updated_at' => Carbon::now()]);
      $new_reg_viatic = new viatic_user_status;
      $new_reg_viatic->viatic_id = $viaticos_id[$i];
      $new_reg_viatic->user_id = $user;
      $new_reg_viatic->status_id = '6'; // Confirmación de pago.
      $new_reg_viatic->save();
      $valor= 'true';

      $service = DB::table('viatics')->where('id',$viaticos_id[$i])->value('service_id');
      $gerente = DB::table('viatics')->where('id',$viaticos_id[$i])->value('jefedirecto_id');
      $user_id = DB::table('viatics')->where('id',$viaticos_id[$i])->value('user_id');

      //email beneficiario
      $user_email =  DB::table('users')->select('email')->where('id', $user_id)->value('email');
      $user_email = trim($user_email);
      $bene_nombre = DB::table('users')->select('name')->where('id', $user_id)->value('name');

      $service_name = Viatic_service::select('name')->where('id', $service)->value('name'); //Aqui esta el error
      $gerente_name = Jefedirecto::select('Nombre')->where('id', $gerente)->value('Nombre');

      $folio = DB::table('viatics')->where('id',$viaticos_id[$i])->value('folio');
      $date_start = DB::table('viatics')->where('id',$viaticos_id[$i])->value('date_start');
      $date_end = DB::table('viatics')->where('id',$viaticos_id[$i])->value('date_end');
      $place_o = DB::table('viatics')->where('id',$viaticos_id[$i])->value('place_o');
      $place_d = DB::table('viatics')->where('id',$viaticos_id[$i])->value('place_d');
      $description = DB::table('viatics')->where('id',$viaticos_id[$i])->value('description');

      $result = DB::select('CALL history_viatic_user_conceptos (?)', array($viaticos_id[$i]));

      $parametros1 = [
        'servicio' => $service_name,
        'folio' => $folio,
        'gerente' => $gerente_name,
        'nombre_b' => $bene_nombre,
        'fecha_inicio' => $date_start,
        'fecha_fin' => $date_end,
        'lugar_o' => $place_o,
        'lugar_d' => $place_d,
        'descripcion' => $description,
      ];

      $parametros2=[];

      for ($j=0; $j <= (count($result)-1); $j++) {
        array_push($parametros2, ['venue' => $result[$j]->Cadena,
                                  'hotel' => $result[$j]->Hotel,
                                  'concept' => $result[$j]->Concepto,
                                  'cantidad' => $result[$j]->cantidad,
                                  'costo' => $result[$j]->amount,
                                  'total' => $result[$j]->total]);
     }
     $correos = [$user_email, 'bdejesus@sitwifi.com'];
     Mail::to($user_email)->send(new ConfirmacionV($parametros1, $parametros2));
     $NotificationOBJ= new NotificationController();
     $leer=DB::table('notifications')->select('id')->where('data','like','%'.$folio.'%')->get();
     foreach($leer as $folioleido){
       //info($folioleido->id);
       $NotificationOBJ->readbyfolio($folioleido->id);
     }
     //Notificaciones
     $user_soli = viatic_user_status::select('user_id')->where([//Usuario que solicito el viatico
       ['viatic_id', $viaticos_id[$i]],
       ['status_id', 1]
     ])->value('user_id');

     $recipients=array_unique(array($user_soli,$user_id));

     foreach($recipients as $recipient_user_notif){
     $message = Message::create([
          'sender_id' => auth()->id(), //USUARIO LOGUEADO
          'recipient_id' => $recipient_user_notif, //USUARIO QUE RECIBE LA NOTIFICACION dependiendo el servicio
          'body' =>  $service_name,
          'folio' => $folio,
          'status' => 'Pagado',
          'date' => Carbon::now(),
          'link' => route('view_request_via'),
        ]);

        $recipient = User::find($recipient_user_notif);
        $recipient->notify(new MessageViatic($message));
        }
    }
    return $valor;
  }
}
public function insert_data_1(Request $request)
{
  $result = 0;
  $id_viatic = $request->ident;
  $status = $request->status;
  $count_id = count($id_viatic);
  //$observation = $request->observation;
  //   $cant = $request->{"c_cant_" . $i};
  //   $amount = $request->{"m_ind_" . $i};
  //   $total = $request->{"subt_" . $i};
  // $sql = DB::select('call Px_idcontractsxkey(?,?,?,?)', array(1,4,27,'S-C-BDY-1-00'));
  $cant = $request->c_cant_;
  $amount = $request->m_ind_;
  $total = $request->subt_;
  // if($observation !== '' ){
  //   $query = DB::table('viatics')->where('id', $request->id_via)->update([
  //     'observacion' => $observation,
  //     'updated_at' => Carbon::now(),
  //   ]);
  // }
  for ($i=0; $i < $count_id; $i++) {
    $cant_for = $cant[$i];
    $amount_for = $amount[$i];
    $total_for = $total[$i];

    if ($cant_for == '' || $amount_for == '' || $total_for == '') {
      $result = 0;
    }else{
      $sql = DB::table('concepts')->where('id', $id_viatic[$i])->update([
        'cantidad' => $cant_for,
        'amount' => $amount_for,
        'total' => $total_for,
        'state_concept_id' => $status[$i],
        'updated_at' => Carbon::now()
      ]);
      $result = 1;
    }
  }
  // return $id_viatic;
  return (string)$result;
}
public function ndatos (Request $request) {
  $viatic= $request->get('viatic');
  $result = DB::select('CALL history_viatic_user_conceptos_monto0 (?)', array($viatic));
  info($result);
  return json_encode($result);
}
public function upd_datostab (Request $request) {
  $result = 0;
  $id_viatic = $request->id_via;
  $date_now = date('Y-m-d');
  $id_concept = $request->ident;
  if (empty($id_concept)) {
    $count_id = 0;
  }else{
    $count_id = count($id_concept);
  }
  // dinamicos
  $cadenas = $request->c_cadena;
  $sitios = $request->c_hotel;
  $concepts = $request->c_concept;
  //
  $cant = $request->c_cant;
  $amount = $request->m_ind;
  $total = $request->subt;
  $just = $request->c_just; // dinamico.
  //
  $cant_count = count($cant);

  $bandera = 0;
  // chequeo de campos vacios en campos dinamicos.

  for ($j=$count_id; $j < $cant_count; $j++) {
    if (empty($cadenas[$j]) || empty($sitios[$j]) || empty($concepts[$j]) || $cant[$j] == '' || $amount[$j] == '' || $total[$j] == '' || empty($just[$j]) ) {
      $bandera = 0;
      return $bandera;
    }else{
      $bandera = 1;
    }
  } // end validacion de campos dinamicos.
  // Update de conceptos definidos.
  for ($i=0; $i < $count_id; $i++) {
    if ($cant[$i] == '' || $amount[$i] == '' || $total[$i] == '') {
      $result = 0;
      return $result;
    }
    else {
      $sql = DB::table('concepts')->where('id', $id_concept[$i])->update([
        'cantidad' => $cant[$i],
        'amount' => $amount[$i],
        'total' => $total[$i],
        'updated_at' => \Carbon\Carbon::now()
      ]);
      $result = 1;
      // returns 1 si se cambio
      // returns 0 no se cambio
    }
  } // end update de conceptos definidos.

  if ($bandera || $result) {
    for ($j=$count_id; $j < $cant_count; $j++) {
      $res_concept = DB::table('concepts')->insertGetId([
        'cadena_id' => $cadenas[$j],
        'hotels_id' => $sitios[$j],
        'fecha_concept' => $date_now,
        'justificacion' => $just[$j],
        'list_concept_id' => $concepts[$j],
        'cantidad' => $cant[$j],
        'amount' => $amount[$j],
        'total' => $total[$j],
        'state_concept_id' => 1,
        'created_at' => \Carbon\Carbon::now()
      ]);

      $res_concept_viatic = DB::table('concept_viatic')->insertGetId([
        'concept_id' => $res_concept,
         'viatic_id' => $id_viatic,
         'created_at' => \Carbon\Carbon::now(),
         // 'updated_at' => \Carbon\Carbon::now()
      ]);
    }
    $result = 1;
  }else {
    $result = 0;
  }
  return $result;
}
public function get_prvnext(Request $request)
{
  $user = Auth::user()->id;
  //$user = 11;
  $id_v = $request->id_viatic;
  $input_date_i = $request->date;
  $state = $request->state;
  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }
  $values = [];

  $res = DB::select('CALL px_viatic_next_prev(?,?,?,?)', array($id_v,$date,$state, $user));

  array_push($values, ['next' => $res[0]->next_id, 'prev' => $res[0]->prev_id]);

  return $values;
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
        //
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
