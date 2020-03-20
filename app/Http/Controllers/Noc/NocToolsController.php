<?php

namespace App\Http\Controllers\Noc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use App\User;
use DateTime;
use DB;
use Auth;
use Mail;
use App\Cadena;

class NocToolsController extends Controller
{

  public function index(){
    return view('permitted.noc.noc_tools');
  }

  public function cl_diario(){
    $cl_diario=DB::Table('cl_diario')->get();
    return view('permitted.noc.cl_diario',compact('cl_diario'));
  }

  public function get_cl_diario(Request $request){
    $date=$request->date;
    $result=DB::Select('CALL px_get_cl_diario(?)',array($date));
    return $result;
  }

  public function get_cl_5_dia(Request $request){
    $date=$request->date;
    $result=DB::Select('CALL px_get_cl_5_dia(?)',array($date));
    return $result;
  }
  public function get_cl_20_dia(Request $request){
    $date=$request->date;
    $result=DB::Select('CALL px_get_cl_20_dia(?)',array($date));
    return $result;
  }

  public function dash_operacion(){
    return view('permitted.noc.dash_operacion');
  }

  public function dash_operacion_nps(Request $request) {
    $fecha = $request->fecha;
    $aux = explode("-", $fecha);
    $meses = array(
      "01" => "Enero",
      "02" => "Febrero",
      "03" => "Marzo",
      "04" => "Abril",
      "05" => "Mayo",
      "06" => "Junio",
      "07" => "Julio",
      "08" => "Agosto",
      "09" => "Septiembre",
      "10" => "Octubre",
      "11" => "Noviembre",
      "12" => "Diciembre"
    );
    $mes_number = array_search($aux[0], $meses);
    $anio_number = $aux[1];
    $date = $anio_number."-".$mes_number."-01";
    $result2 = DB::select('CALL NPS_MONTH (?)', array($date));
    $result4 = substr($meses[$mes_number], 0, 3);
    $result5 = DB::select('CALL px_detractores_xfecha(?)', array($date));
    $mes_number--;
    if($mes_number == 0) {
      $mes_number = "12";
      $anio_number--;
    }
    if($mes_number < 10) {
      $mes_number = "0".$mes_number;
    }
    $date = $anio_number."-".$mes_number."-01";
    $result1 = DB::select('CALL NPS_MONTH (?)', array($date));
    $result3 = substr($meses[$mes_number], 0, 3);
    return array($result1, $result2, $result3, $result4, $result5);
  }

  public function dash_operacion_tickets(Request $request) {
    $fecha = $request->fecha;
    $aux = explode("-", $fecha);
    $meses = array(
      "01" => "Enero",
      "02" => "Febrero",
      "03" => "Marzo",
      "04" => "Abril",
      "05" => "Mayo",
      "06" => "Junio",
      "07" => "Julio",
      "08" => "Agosto",
      "09" => "Septiembre",
      "10" => "Octubre",
      "11" => "Noviembre",
      "12" => "Diciembre"
    );
    $mes_number = array_search($aux[0], $meses);
    $anio_number = $aux[1];
    $date = $anio_number."-".$mes_number."-01";
    $result = DB::connection('zendesk')->select('CALL px_all_answers_solution_times(?)', array($date));
    return array($result);
  }

  public function graph_operacion_tickets(Request $request) {
    $fecha = $request->fecha;
    $aux = explode("-", $fecha);
    $year = $aux[1];
    $result = DB::connection('zendesk')->select('CALL px_all_answers_ticketsxmes(?)', array($year));
    return $result;
  }

}
