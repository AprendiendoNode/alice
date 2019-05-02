<?php

namespace App\Http\Controllers\Support;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyTickets extends Controller
{
    private $update_ticket;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $sitios= DB::table('hotels')->select('id','Nombre_hotel')->where('filter', 1)->whereNull('deleted_at')->get();
      return view('permitted.service.zendesk_table', compact('sitios'));
    }
    public function showheader(Request $request)
    {
        $value= $request->datepickerMonthticket;
        $date_current=$value.'-01';
        $email_actual = Auth::user()->email;
        $result = DB::connection('zendesk')->select('CALL px_ticketsXstatus(?, ?)', array($date_current, $email_actual));
        return json_encode($result);
    }
    public function showtable(Request $request)
    {
        $value= $request->datepickerMonthticket;
        $date_current=$value.'-01';
        $email_actual = Auth::user()->email;
        $result = DB::connection('zendesk')->select('CALL px_ticketsXemail(?, ?)', array($date_current, $email_actual));
        return json_encode($result);
    }
    public function showgraph(Request $request)
    {
        $value= $request->datepickerMonthticket;
        $date_current=$value.'-01';
        $email_actual = Auth::user()->email;
        // $email_actual='helpdesk@sitwifi.com';
        $result = DB::connection('zendesk')->select('CALL px_ticketsXdia(?, ?)', array($date_current, $email_actual));
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

        $res_sql = DB::connection('zendesk')->table('tickets')->select('id_sitio')->where('id_ticket', $value)->get();
        $res_sql = json_decode($res_sql, true);
        //$res = json_encode(array_merge($curl_res, $result));
        $res = json_encode(array_merge($res_curl, $curl_res, $res_sql));
        //$type = gettype($res);
        return $res;
    }
    public function update_ticket(Request $request)
    {
      $typeof_update = $request->type_update;
      $email_actual = Auth::user()->email;
      $id_ticket = $request->id_ticket;

      $type_ticket = $request->type;
      $priority_ticket = $request->priority;
      $id_sitio = (int)$request->sitio;

      $update_server = DB::connection('zendesk')->table('tickets')->where('id_ticket', $id_ticket)->update(
        [
          'id_sitio' => $id_sitio,
          'updated_at' => \Carbon\Carbon::now()
        ]
      );

      $url_put = 'https://sitwifi.zendesk.com/api/v2/tickets/' . $id_ticket . '.json';
      $author_id = "1162634359"; //id helpdesk.
      $status = $request->status;
      $comment = $request->comment;
      if ($request->public === '1') {
        $public_b = true;
      }else{
        $public_b = false;
      }
      //estructura del json.
      // id de campo custom: 22892328
      $array_algo = array('ticket' => array('type' => $type_ticket, 'priority' => $priority_ticket, 'custom_fields' => array('id' => 22892328, 'value' => $email_actual),'status' => $status, 'comment' => array('body' => $comment, 'public' => $public_b ,'author_id' => $author_id)));
      $this->update_ticket = json_encode($array_algo);
      //llamar a funcion con request 'PUT'.
      $res = json_encode($this->curlZen($url_put, 'PUT'));
      // actualizar la base de datos. TAMBIEN.
      return $res;
    }
    public function curlZen($url, $method)
    {

      if($method === 'GET'){
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

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
      }else{
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->update_ticket);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        //echo ".. Termina la funcion ..";
        $output = curl_exec($ch);

        $curlerr = curl_error($ch);
        $curlerrno = curl_errno($ch);

        if ($curlerrno != 0) {
            // Retornar un num de error
            return 0;
        }
        curl_close($ch);
        $decoded = json_decode($output, true);
        return $decoded;
      }
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

}
