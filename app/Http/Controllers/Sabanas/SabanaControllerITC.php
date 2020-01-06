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

class SabanaControllerITC extends Controller
{
  public function index()
  {
    $user_id = Auth::user()->id;
    $cadena = Cadena::select('id', 'name')->get();
    $users = DB::select('CALL list_user_itc()');
    return view('permitted.sabanas.sabana_itc', compact('users','cadena'));
  }
  public function informacionCliente(Request $request)
  {
    $hotel = $request->cliente;
    $result1 = DB::table('hotels')->where("id",$hotel)->get();
    $itc = DB::select('CALL setemailsnmp(?)', array($hotel));
    $email = DB::table('hotels')->join("sucursals", "hotels.sucursal_id", "=", "sucursals.id")->select("sucursals.correo")->where("hotels.id",$hotel)->get();
    return array_merge(json_decode($result1),$itc,json_decode($email));
  }

  public function informacionCadena(Request $request)
  {
    $cadena = $request->cadena;
    //$result1 = DB::table('hotels')->where("cadena_id",$cadena)->get();
    $result = DB::select('CALL px_setemailsnmp_cadena(?)', array($cadena));
    //$email = DB::table('hotels')->join("sucursals", "hotels.sucursal_id", "=", "sucursals.id")->select("sucursals.correo")->where("hotels.id",$hotel)->get();
    return $result;
  }

  public function get_all_contracts_by_hotel(Request $request)
  {
    $hotel = $request->id;
    $maestro = DB::select('CALL px_contrac_master_data_site(?)', array($hotel));
    return $maestro;
  }

  public function get_all_contracts_by_cadena(Request $request){
    $cadena = $request->id;
    $maestro = DB::select('CALL px_contrac_master_data_cadena(?)', array($cadena));
    return $maestro;
  }

  public function get_all_annexes_by_master(Request $request)
  {
    $master = $request->id;
    $anexos = DB::select('CALL px_anexos_masters(?)', array($master));
    return $anexos;
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
  public function get_nps_hotel(Request $request){
    $id_hotel=$request->id;
    $anio=$request->anio;

    if($anio == "") {
      $anio = date('Y');
    }

    $result = DB::select('CALL px_NPS_sitio (?, ?)', array($id_hotel, $anio));
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

  public function get_nps_comment_hotel(Request $request){
    $id_hotel=$request->id;
    $result = DB::select('CALL px_get_results_nps_sitio (?)', array($id_hotel));
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

  public function get_viatics_gastos(Request $request)
  {
    $id = $request->id;
    $res =  DB::select('CALL px_history_viatics_sitio(?)', array($id));
    return $res;
  }


  public function get_viatics_gastos_cadena(Request $request)
  {
    $cadena = $request->id;
    $res =  DB::select('CALL px_history_viatics_cadena(?)', array($cadena));
    return $res;
  }

  public function get_tickets_by_itc(Request $request){
    $itc_email=$request->itc_email;
    $result = DB::connection('zendesk')->select('CALL px_ticketsxitc(?)', array($itc_email));
    return $result;
  }

  public function get_ticketsxtype_itc(Request $request ){
    $itc_email=$request->itc_email;
    $result = DB::connection('zendesk')->select('CALL px_ticketsxtype_itc(?)', array($itc_email));
    return $result;
  }

  public function get_ticketsxstatus_itc(Request $request ){
    $itc_email=$request->itc_email;
    $result = DB::connection('zendesk')->select('CALL px_ticketsxstatus_itc(?)', array($itc_email));
    return $result;
  }


  public function sabana_modal_encuestas(Request $request ){
    $date= $request->anio;
    $encuestas= $request->encuestas;
    $hotel= $request->hotel;

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

    $result = DB::select('CALL status_nps_anio (?, ?, ?)', array($date, $encuestas, $hotel));
    return json_encode($result);
  }

  public function sabana_modal_encuestas_cadena(Request $request ){
    $date= $request->anio;
    $encuestas= $request->encuestas;
    $cadena= $request->cadena;

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
info($date."-".$encuestas."-".$cadena);
    $result = DB::select('CALL px_status_nps_cadena_anio (?, ?, ?)', array($date, $encuestas, $cadena));
    return json_encode($result);
  }

}
