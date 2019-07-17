<?php

namespace App\Http\Controllers\Viatics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User; //Importar el modelo eloquent
use App\Cadena;
use App\Models\Viatics\Viatic_service;
use App\Department;
use App\Models\Viatics\Viatic_state;
use App\Models\Viatics\Viatic_list_concept;
use App\Jefedirecto;
use App\Hotel;
use App\Reference;
use App\Models\Viatics\Viatic;
use App\Models\Viatics\Concept;
use App\Models\Viatics\viatic_user_status;
use App\Models\Viatics\Viatic_state_concept;
use Mail;
use App\Mail\SolicitudesV;

class AddViaticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user_actual = Auth::user()->id;
      $cadena = Cadena::select('id', 'name')->orderBy('name')->get();
      $service = Viatic_service::select('id', 'name')->get();
      $beneficiary= Department::select('id', 'name')->get();
      $concept = Viatic_list_concept::select('id', 'name')->get();
      $jefe = Jefedirecto::select('id', 'Nombre')->get();
      $user = DB::table('sitwifi_email_view')->select('id', 'name')->get();
      $priority= DB::table('viatic_priorities')->select('id', 'name')->get();
      //select plantilla.
      //$plantilla = DB::table('plantillas')->select('id', 'name')->where('user_id', $user_actual)->get();
      $plantilla = Department::select('id', 'name')->get(); //NO USAR
      return view('permitted.viaticos.add_request2',compact('cadena', 'service', 'beneficiary', 'concept', 'jefe', 'user', 'priority', 'plantilla'));
    }

    public function find_hotel(Request $request)
    {
      $value= $request->numero;
      $hoteles = Hotel::where('cadena_id', $value)->get();
      return json_encode($hoteles);
    }

    public function find_user(Request $request)
    {
      $value= $request->numero;
      $result = DB::select('CALL get_user_department (?)', array($value));
      return json_encode($result);
    }

    public function find_concept(Request $request)
    {
      $value= $request->numero;
      // $result = Viatic_list_concept::select('activar_monto')->where('id', $value)->get();
      $result = DB::table('viatic_list_concepts')->where('id', $value)->value('activar_monto');
      return $result;
    }

    public function create_viatic(Request $request)
    {
      $user_actual = Auth::user()->id;
      //email usuario logeado.
      $email_actual = Auth::user()->email;
      $email_actual = trim($email_actual);
      $service = $request->service_id;
      $gerente = $request->gerente_id;
      $beneficiary = $request->beneficiario_id;
      $user = $request->user_id;
      $date_s_original = $request->startDate;
      $date_o_original = $request->endDate;
      $place_o = $request->place_o;
      $place_d = $request->place_d;
      $descript = $request->descripcion;
      //$obs_conc = $request->obs_conc;
      //email beneficiario
      $email_bene = DB::table('users')->select('email')->where('id', $user)->value('email');
      $email_bene = trim($email_bene);
      $bene_nombre = DB::table('users')->select('name')->where('id', $user)->value('name');

      $service_name = Viatic_service::select('name')->where('id', $service)->value('name');
      $gerente_name = Jefedirecto::select('Nombre')->where('id', $gerente)->value('Nombre');
      $gerente_email = Jefedirecto::select('email')->where('id', $gerente)->value('email');
      $beneficiary_name= Department::select('name')->where('id', $beneficiary)->value('name');


      //Formateo igual funciona
      // echo implode("-", array_reverse(explode("/", $date_s_original)));
      // echo implode("-", array_reverse(explode("/", $date_o_original)));

      //Formateo de fecha funciona igual q el anterior xD
      $date_conv1 = str_replace('/', '-', $date_s_original);
      $date_s = date('Y-m-d', strtotime($date_conv1));

      $date_conv2 = str_replace('/', '-', $date_o_original);
      $date_o =  date('Y-m-d', strtotime($date_conv2));

      $folio_new = $this->createFolio();
      if (isset($request->priority_id)) { $priority = $request->priority_id; }
      else { $priority ='2'; }
      //Cargo solicitud
      $new_viatic = new Viatic;
      $new_viatic->folio = $folio_new;
      $new_viatic->service_id = $service;
      $new_viatic->user_id = $user;
      $new_viatic->jefedirecto_id = $gerente;
      //$new_viatic->beneficiary_id = $beneficiary;
      $new_viatic->date_start = $date_s;
      $new_viatic->date_end = $date_o;
      $new_viatic->place_o = $place_o;
      $new_viatic->place_d = $place_d;
      $new_viatic->description = $descript;
      $new_viatic->state_id = '1';
      $new_viatic->priority_id = $priority;
      //$new_viatic->observacion = $obs_conc;
      $new_viatic->save();

      //
      $array_data1 = $request->c_venue;
      $array_data2 = $request->c_hotel;
      $array_data3 = $request->c_concept;
      $array_fechas = $request->c_date;
      $array_data4 = [];
      $array_data5 = [];
      $array_data6 = [];
      $array_data7 = $request->c_just;
      $tamanoGeneral = count($array_data1);
      $parametros2 = [];

          if (isset($request->c_cant)) { $array_data4 = $request->c_cant; }
      if (isset($request->c_priceuni)) { $array_data5 = $request->c_priceuni; }
         if (isset($request->c_price)) { $array_data6 = $request->c_price; }

      for ($i=0; $i < $tamanoGeneral; $i++) {

        $date_cool = str_replace('/', '-', $array_fechas[$i]);
        $date_cool = date('Y-m-d', strtotime($date_cool));

        ${"new_concept".$i} = new Concept;
        ${"new_concept".$i} ->cadena_id = $array_data1[$i];
        ${"new_concept".$i} ->hotels_id = $array_data2[$i];
        ${"new_concept".$i} ->list_concept_id = $array_data3[$i];
        ${"new_concept".$i} ->fecha_concept = $date_cool;
        ${"new_concept".$i} ->justificacion = $array_data7[$i];

        $cadena_nombre = DB::table('cadenas')->select('name')->where('id', $array_data1[$i])->value('name');
        $hotel_nombre = DB::table('hotels')->select('Nombre_hotel')->where('id', $array_data2[$i])->value('Nombre_hotel');
        $concepto_name = Viatic_list_concept::select('name')->where('id', $array_data3[$i])->value('name');

        array_push($parametros2, ['venue' => $cadena_nombre, 'hotel' => $hotel_nombre, 'concept' => $concepto_name]);

        if ( empty($array_data4[$i]) ) {
          ${"new_concept".$i} ->cantidad = 0;
          //array_add($parametros2, 'cantidad', 0);
          //array_push($parametros2, ['cantidad' => 0]);
          $parametros2[$i] += ['cantidad' => 0];
        }
        else {
          ${"new_concept".$i} ->cantidad = $array_data4[$i];
          //array_add($parametros2, 'cantidad', $array_data4[$i]);
          //array_push($parametros2, ['cantidad' => $array_data4[$i]]);
          $parametros2[$i] += ['cantidad' => $array_data4[$i]];
        }

        if ( empty($array_data5[$i]) ) {
          ${"new_concept".$i} ->amount = 0;
          //array_add($parametros2, 'costo', 0);
          //array_push($parametros2, ['costo' => 0]);
          $parametros2[$i] += ['costo' => 0];
        }
        else {
          ${"new_concept".$i} ->amount = $array_data5[$i];
          //array_add($parametros2, 'costo', $array_data5[$i]);
          //array_push($parametros2, ['costo' => $array_data5[$i]]);
          $parametros2[$i] += ['costo' => $array_data5[$i]];
        }
        if ( empty($array_data6[$i]) ) {
          ${"new_concept".$i} ->total = 0;
          //array_add($parametros2, 'total', 0);
          //array_push($parametros2, ['total' => 0]);
          $parametros2[$i] += ['total' => 0];
        }
        else {
          ${"new_concept".$i} ->total = $array_data6[$i];
          //array_add($parametros2, 'costo', $array_data6[$i]);
          //array_push($parametros2, ['total' => $array_data6[$i]]);
          $parametros2[$i] += ['total' => $array_data6[$i]];
        }

        ${"new_concept".$i} ->state_concept_id = 1;
        ${"new_concept".$i} ->save();

        $result_match = DB::table('concept_viatic')->insertGetId([
                          'concept_id' => ${"new_concept".$i}->id,
                           'viatic_id' => $new_viatic->id,
                           'created_at' => \Carbon\Carbon::now(),
                           'updated_at' => \Carbon\Carbon::now()
                        ]);
      }

      $new_reg_viatic = new viatic_user_status;
      $new_reg_viatic->viatic_id = $new_viatic->id;
      $new_reg_viatic->user_id = $user_actual;
      $new_reg_viatic->status_id = '1';
      $new_reg_viatic->save();


      $parametros1 = [
        'servicio' => $service_name,
        'folio' => $folio_new,
        'gerente' => $gerente_name,
        'beneficiario' => $beneficiary_name,
        'nombre_b' => $bene_nombre,
        'fecha_inicio' => $date_s_original,
        'fecha_fin' => $date_o_original,
        'lugar_o' => $place_o,
        'lugar_d' => $place_d,
        'descripcion' => $descript
      ];
      //Envío de correo con información.
      if ($email_actual === $email_bene) {
        //$email_actual = trim($email_actual);
        $gerente_email = trim($gerente_email);
        $copias = ['bdejesus@sitwifi.com', $gerente_email];
        Mail::to($email_actual)->cc($copias)->send(new SolicitudesV($parametros1, $parametros2));
        //Mail::to($email_actual)->send(new SolicitudesV($parametros1, $parametros2));
      }else{
        $emails = [$email_actual, $email_bene];
        //array_push($emails, [$email_actual, $email_bene]);
        $gerente_email = trim($gerente_email);
        $copias = ['bdejesus@sitwifi.com', $gerente_email];
        Mail::to($emails)->cc($copias)->send(new SolicitudesV($parametros1, $parametros2));
        //Mail::to($emails)->send(new SolicitudesV($parametros1, $parametros2));
      }


      $folioxd = 'Operation complete! - Folio: ' . $folio_new;
      return back()->with('status', $folioxd);
    }

    public function createFolio()
    {
      $nomenclatura = "SV-";
      $res = DB::table('viatics')->latest()->first();
      if (empty($res)) {
          $nomenclatura = $nomenclatura . "000001";
          return $nomenclatura;
      }else{
        $folio_latest = $res->folio;

        if (empty($folio_latest)) {
          $nomenclatura = $nomenclatura . "000001";
          return $nomenclatura;
        }else{
          $explode = explode('-', $folio_latest);
          $num_folio = (int)$explode[1];
          $num_folio = $num_folio + 1;
          $digits = strlen($num_folio);

          switch ($digits) {
            case 1:
              $num_folio = (string)$nomenclatura . "00000" . $num_folio;
              break;
            case 2:
              $num_folio = (string)$nomenclatura . "0000" . $num_folio;
              break;
            case 3:
              $num_folio = (string)$nomenclatura . "000" . $num_folio;
              break;
            case 4:
              $num_folio = (string)$nomenclatura . "00" . $num_folio;
              break;
            case 5:
              $num_folio = (string)$nomenclatura . "0" . $num_folio;
              break;
            default:
              $num_folio = (string)$nomenclatura . $num_folio;
              break;
          }
          return (string)$num_folio;
        }
      }
    }

}
