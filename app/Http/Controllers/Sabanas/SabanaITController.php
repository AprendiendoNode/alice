<?php

namespace App\Http\Controllers\Sabanas;

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

class SabanaITController extends Controller
{
  public function index()
  {
    $user_id = Auth::user()->id;
    $cadena = Cadena::select('id', 'name')->get();
    $users = DB::select('CALL list_user_itc()');
    $status_compras = DB::select('CALL px_documentp_status_doctype()', array());
    if($user_id==16 || $user_id==432 || $user_id==440) {
      return view('permitted.sabanas.sabana_itc', compact('users','cadena','status_compras'));
    } else {
      return view('home');
    }
  }
  public function informacionITC(Request $request)
  {
    $itc = $request->itc;
    $filtro = $request->filtro;
    $fecha = '';
    if($filtro <= 12) {
      $fecha = date('Y-m-d');
    } else {
      $fecha = $filtro.'-12-01';
    }
    $result = DB::select('CALL px_sitios_by_itc_12meses(?, ?)', array($itc, $fecha));
    return $result;
  }
  public function antenasITC(Request $request)
  {
    $itc = $request->itc;
    $result = DB::select('CALL px_cantidad_aps_xusuario(?)', array($itc));
    return $result;
  }
  public function tabla_antenas_ITC(Request $request)
  {
    $itc = $request->itc;
    $result = DB::select('CALL px_tabla_apsxusuario(?)', array($itc));
    return $result;
  }
  public function viaticos_x_mes(Request $request)
  {
    $itc = $request->itc;
    $filtro = $request->filtro;
    $fecha = '';
    if($filtro <= 12) {
      $fecha = date('Y-m-d');
    } else {
      $fecha = $filtro.'-12-01';
    }
    $result = DB::select('CALL px_viaticos_x_mes(?, ?)', array($itc, $fecha));
    return $result;
  }
  public function tabla_antenas_sitio(Request $request)
  {
    $sitio = $request->sitio;
    $itc = $request->itc;
    $result = DB::select('CALL px_tabla_apsxsitio(?, ?)', array($sitio, $itc));
    return $result;
  }
  public function get_table_equipments(Request $request){
    $id_hotel=$request->id;
    $result= DB::Select('CALL px_equipmentsxhotel(?)',array($id_hotel));
    return $result;
  }
  public function get_table_equipments_cadena(Request $request){
    $cadena=$request->id;
    $result= DB::Select('CALL px_equipmentsxcadena(?)',array($cadena));
    return datatables()->of($result)->make(true);
  }
  public function get_nps_itc(Request $request){
    $itc=$request->itc;
    $anio=$request->anio;

    if($anio == "") {
      $anio = date('Y');
    }
    $result = DB::select('CALL px_NPS_itc (?, ?)', array($itc, $anio));
    return $result;
  }
  public function get_nps_itc_mensual(Request $request){
    $itc=$request->itc;
    $anio=$request->anio;
    $mes=$request->mes;
    $fecha = "";

    if($anio == "") {
      $fecha = date('Y-m-d');
    } else {
      $fecha = $anio."-".$mes."-01";
    }
    $result = DB::select('CALL px_NPS_itc_mensual (?, ?)', array($itc, $fecha));
    return $result;
  }
  public function get_nps_cadena(Request $request){
    $id_cadena=$request->id;
    $anio=$request->anio;

    if($anio == "") {
      $anio = date('Y');
    }

    $result = DB::select('CALL px_NPS_cadena (?, ?)', array($id_cadena, $anio));
    return $result;
  }

  public function get_nps_comment_itc(Request $request){
    $itc=$request->itc;
    $result = DB::select('CALL px_get_results_nps_itc (?)', array($itc));
    return $result;
  }

  public function get_nps_comment_cadena(Request $request){
    $id_cadena=$request->id;
    $result = DB::select('CALL px_get_results_nps_cadena (?)', array($id_cadena));
    return $result;
  }

  public function get_graph_equipments(Request $request){
    $id_hotel = $request->id;
    $result = DB::select('CALL px_equiposxtipo_hotel (?)',array($id_hotel));
    return $result;
  }

  public function get_graph_equipments_cadena(Request $request){
    $cadena = $request->id;
    $result = DB::select('CALL px_equiposxtipo_cadena (?)',array($cadena));
    return $result;
  }

  public function get_graph_equipments_status(Request $request){
    $id_hotel = $request->id;
    $result = DB::select('CALL px_equiposxstatus_hotel (?)',array($id_hotel));
    return $result;
  }

  public function get_graph_equipments_status_cadena(Request $request){
    $cadena = $request->id;
    $result = DB::select('CALL px_equiposxstatus_cadenas (?)',array($cadena));
    return $result;
  }
  public function get_budget_annual_hotel(Request $request){
    $id_hotel = $request->id;
    $date_current = $request->fecha;
    if($date_current==''){
    $date_current = date('Y');
    }
    $result = DB::select('CALL px_get_mount_PEjercidoxHotel(?,?)', array($id_hotel,$date_current));
    return $result;

  }

  public function get_budget_annual_cadena(Request $request){
    $cadena = $request->id;
    $date_current = $request->fecha;
    if($date_current==''){
    $date_current = date('Y');
    }
    $result = DB::select('CALL px_get_mount_PEjercidoxcadena(?,?)', array($cadena,$date_current));
    return $result;
  }

  public function get_payment_folios_gastos(Request $request)
  {
    $id = $request->id;
    $res =  DB::select('CALL payments_hotel_folio_gastos(?)', array($id));
    return $res;
  }

  public function get_payment_folios_gastos_cadena(Request $request)
  {
    $id_cadena = $request->id;
    $res =  DB::select('CALL px_payments_cadena_folio_gastos(?)', array($id_cadena));
    return $res;
  }

  public function get_viatics_gastos_itc(Request $request)
  {
    $id = $request->id;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $res =  DB::select('CALL px_history_viatics_itc(?, ?, ?)', array($id, $fecha1, $fecha2));
    return $res;
  }

  public function get_tickets_by_itc(Request $request){
    $itc_email=$request->itc_email;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $result = DB::connection('zendesk')->select('CALL px_ticketsxitc(?, ?, ?)', array($itc_email, $fecha1, $fecha2));
    return datatables()->of($result)->make(true);;
  }

  public function get_ticketsxtype_itc(Request $request ){
    $itc_email=$request->itc_email;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $result = DB::connection('zendesk')->select('CALL px_ticketsxtype_itc(?, ?, ?)', array($itc_email, $fecha1, $fecha2));
    return $result;
  }

  public function get_ticketsxstatus_itc(Request $request ){
    $itc_email=$request->itc_email;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $result = DB::connection('zendesk')->select('CALL px_ticketsxstatus_itc(?, ?, ?)', array($itc_email, $fecha1, $fecha2));
    return $result;
  }


  public function sabana_itc_modal_encuestas(Request $request ){
    $date= $request->anio;
    $encuestas= $request->encuestas;
    $itc= $request->itc;

    if ($date == '') {
      $date = date('Y-m-d');
    } else {
      $date = $date."-01-01";
    }

    if($encuestas == "box_promo") {
      $encuestas = 4;
    } else if($encuestas == "box_pas") {
      $encuestas = 5;
    } else {
      $encuestas = 6;
    }

    $result = DB::select('CALL status_nps_anio_itc (?, ?, ?)', array($date, $encuestas, $itc));
    return json_encode($result);
  }

  public function get_projects_itc(Request $request){
    $id = $request->itc_id;
    $result= DB::Select('CALL px_documentp_status_doctype_itc(?)',array($id));
    return $result;
  }

  public function docs_x(Request $request){
    $itc_id = $request->itc_id;
    $tipo_doc = $request->tipo_doc;
    $filtro = $request->filtro;
    $fecha = '';
    if($filtro <= 12) {
      $fecha = date('Y-m-d');
    } else {
      $fecha = $filtro.'-12-01';
    }
    $result=DB::Select('CALL px_documentxtype_itc_v2(?,?,?)',array($itc_id, $fecha, $tipo_doc));
    return $result;
  }

}
