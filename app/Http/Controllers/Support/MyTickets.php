<?php

namespace App\Http\Controllers\Support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class MyTickets extends Controller
{
  private $update_ticket;

  public function index()
  {
    $sitios = DB::table('hotels')->select('id', 'Nombre_hotel')->get();
    $itconcierge = DB::select('CALL List_user_NPS (?)', array(7));
    return view('permitted.service.zendesk_table', compact('sitios', 'itconcierge'));
    // return view('permitted.service.zendesk_table', compact('sitios'));
    // Route::post('/search_data_traf_tickets', 'Support\MyTickets@showheader_mod');
    // Route::post('/get_table_ticket', 'Support\MyTickets@showtable_mod'); 
    // Route::post('/get_graph_time_ticket', 'Support\MyTickets@showgraph_mod');
  }
  public function index_all()
  {
    return view('permitted.service.zendesk_all');
  }
  public function showheader(Request $request)
  {
    $value= $request->datepickerMonthticket;
    $date_current=$value.'-01';
    $email_actual = Auth::user()->email;
    // $email_actual='helpdesk@sitwifi.com';
    $result = DB::connection('zendesk')->select('CALL px_ticketsXstatus(?, ?)', array($date_current, $email_actual));
    return $result;
  }
  public function showheader_mod(Request $request)
  {
    $input1 = $request->date_start;
    $input2 = $request->date_end;
    $email_actual = Auth::user()->email;
    // $email_actual='helpdesk@sitwifi.com';
    if (empty($input1) || empty($input2)) {
      $date_inicio = date('Y-m', strtotime("-2 months"));
      $date_inicio = $date_inicio . '-01';

      $date_fin = date('Y-m');
      $date_fin = $date_fin . '-01';
    }else{
      $date_inicio = "";
      $date_fin = "";
      if ($input1 < $input2) {
          $date_inicio = $input1 . '-01';
          $date_fin = $input2 . '-01';
      }else{
          $date_inicio = $input2 . '-01';
          $date_fin = $input1 . '-01';
      }
    }
    $result = DB::connection('zendesk')->select('CALL px_ticketsXstatus_period(?, ?, ?)', array($date_inicio, $date_fin, $email_actual));
    return $result;
  }
  public function showtable(Request $request)
  {
    $value= $request->datepickerMonthticket;
    $date_current=$value.'-01';
    $email_actual = Auth::user()->email;
    // $email_actual='helpdesk@sitwifi.com';
    $result = DB::connection('zendesk')->select('CALL px_ticketsXemail(?, ?)', array($date_current, $email_actual));
    return $result;
  }
  public function showtable_mod(Request $request)
  {
    $input1 = $request->date_start;
    $input2 = $request->date_end;
    $email_actual = Auth::user()->email;
    // $email_actual='helpdesk@sitwifi.com';
    if (empty($input1) || empty($input2)) {
      $date_inicio = date('Y-m', strtotime("-2 months"));
      $date_inicio = $date_inicio . '-01';

      $date_fin = date('Y-m');
      $date_fin = $date_fin . '-01';
    }else{
      $date_inicio = "";
      $date_fin = "";
      if ($input1 < $input2) {
          $date_inicio = $input1 . '-01';
          $date_fin = $input2 . '-01';
      }else{
          $date_inicio = $input2 . '-01';
          $date_fin = $input1 . '-01';
      }
    }
    $result = DB::connection('zendesk')->select('CALL px_ticketsXemail_period(?, ?, ?)', array($date_inicio, $date_fin, $email_actual));
    return $result;
  }
  public function showgraph(Request $request)
  {
    $value= $request->datepickerMonthticket;
    $date_current=$value.'-01';
    $email_actual = Auth::user()->email;
    // $email_actual='helpdesk@sitwifi.com';
    $result = DB::connection('zendesk')->select('CALL px_ticketsXdia(?, ?)', array($date_current, $email_actual));
    return $result;
  }
  public function showgraph_mod(Request $request)
  {
    $input1 = $request->date_start;
    $input2 = $request->date_end;
    $email_actual = Auth::user()->email;
    // $email_actual='helpdesk@sitwifi.com';
    if (empty($input1) || empty($input2)) {
      $date_inicio = date('Y-m', strtotime("-2 months"));
      $date_inicio = $date_inicio . '-01';

      $date_fin = date('Y-m');
      $date_fin = $date_fin . '-01';
    }else{
      $date_inicio = "";
      $date_fin = "";
      if ($input1 < $input2) {
          $date_inicio = $input1 . '-01';
          $date_fin = $input2 . '-01';
      }else{
          $date_inicio = $input2 . '-01';
          $date_fin = $input1 . '-01';
      }
    }
    $result = DB::connection('zendesk')->select('CALL px_ticketsXdia_period(?, ?, ?)', array($date_inicio, $date_fin, $email_actual));
    return $result;
  }
  public function index_admin()
  {
    return view('permitted.service.zendesk_statistics');
  }
  public function showtable_admin(Request $request)
  {
    $value= $request->datepickerMonthticket;
    $date_current=$value.'-01';
    $result = DB::connection('zendesk')->select('CALL px_ticketsXstatusXitc(?)', array($date_current));
    return json_encode($result);
  }
  public function showinfoticket(Request $request)
  {
    $value= $request->ticket;

    $url_get_ticket = 'https://sitwifi.zendesk.com/api/v2/tickets/' . $value . '.json';
    $url_get = 'https://sitwifi.zendesk.com/api/v2/tickets/' . $value . '/comments.json';

    //$result = DB::connection('zendesk')->select('CALL px_tickets_data(?)', array($value));

    //$res_curl = $this->curlZen($url_get_ticket, 'GET');
    $res_curl = json_encode($this->curlZen($url_get_ticket, 'GET'));
    $res_curl = json_decode($res_curl, true);

    if (array_key_exists('error', $res_curl)) {
      return '0';
    }
    $curl_res = $this->curlZen($url_get, 'GET');
    $curl_res = $this->check_agentID($curl_res);
    $curl_res = json_encode($curl_res);
    $curl_res = json_decode($curl_res, true);

    $res_sql = DB::connection('zendesk')->table('tickets')->select('id_sitio', 'itc')->where('id_ticket', $value)->get();
    $res_sql = json_decode($res_sql, true);
    //$res = json_encode(array_merge($curl_res, $result));
    $res = json_encode(array_merge($res_curl, $curl_res, $res_sql));
    //$type = gettype($res);
    return $res;
  }
  public function check_agentID($comments)
  {
    $size = count($comments->comments);
    for ($i=0; $i < $size; $i++) {
        $agent_name = DB::connection('zendesk')->table('agentes')->select('name')->where('id_user', $comments->comments[$i]->author_id)->value('name');
        $comments->comments[$i]->author_id = $agent_name;
    }
    return $comments;
  }
  public function update_ticket(Request $request)
  {
    // id ticket prueba: 36525
    // $typeof_update = $request->type_update;
    $email_actual = Auth::user()->email;
    $id_ticket = $request->id_ticket;
    $type_ticket = $request->select_type;
    $priority_ticket = $request->select_priority;
    $id_sitio = (int)$request->select_site;
    $tags = $request->select_tags;
    $itcasignado = $request->select_itc;
    $name_cliente = $request->nom_cliente;
    $empresa = $request->empresa;

    // return $name_cliente;

    $update_server = DB::connection('zendesk')->table('tickets')->where('id_ticket', $id_ticket)->update(
      [
        'id_sitio' => $id_sitio,
        'itc' => $itcasignado, //usar var itcasignado en produccion
        'updated_at' => \Carbon\Carbon::now()
      ]
    );

    $url_put = 'https://sitwifi.zendesk.com/api/v2/tickets/' . $id_ticket . '.json';
    $author_id = "1162634359"; //id helpdesk.
    $status = $request->select_status;
    $comment = $request->comment;

    if ($request->select_public === '1') {
      $public_b = true;
    }else{
      $public_b = false;
    }
    // id de campo custom: 22892328 ITC asignado.
    // custom_field: 22881472 Nombre del cliente. Requeridos para cerrar ticket.
    //               22881552 Empresa.
    //  'tags' => array('antena', 'test') sintaxis de tags.

    $array_algo = array('ticket' => array('type' => $type_ticket, 'priority' => $priority_ticket, 'custom_fields' => array(array('id' => 22892328, 'value' => $itcasignado),array('id' => 22881472, 'value' => $name_cliente),array('id' => 22881552, 'value' => $empresa)),'status' => $status, 'tags' => $tags,'comment' => array('body' => $comment, 'public' => $public_b ,'author_id' => $author_id)));
    $this->update_ticket = json_encode($array_algo);
    //llamar a funcion con request 'PUT'.
    $res = json_encode($this->curlZen($url_put, 'PUT'));
    // actualizar la base de datos. TAMBIEN.
    return $res;
  }
  public function curlZen($url, $method)
  {
    $ch = curl_init();
    //echo "Inicializa la funcion .. ";
    curl_setopt($ch, CURLOPT_TIMEOUT, 50);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false );
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, "jesquinca@sitwifi.com/token:f4qs3fDR9b9J635IcP6Ce5cGXxKx32ewexk3qmvz");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
    if ($method === 'PUT') {
      curl_setopt($ch, CURLOPT_POSTFIELDS, $this->update_ticket);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //echo ".. Termina la funcion ..";
    $output = curl_exec($ch);

    $curlerr = curl_error($ch);
    $curlerrno = curl_errno($ch);

    if ($curlerrno != 0) {
        // Retornar un num de error
        return 0;
    }
    curl_close($ch);
    $decoded = json_decode($output);
    return $decoded;
  }
}
