<?php

namespace App\Http\Controllers;

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

class SabanaController extends Controller
{
  public function index()
  {
    $user_id = Auth::user()->id;
    $hotels = DB::select('CALL px_sitiosXusuario_rol(?, ?)', array($user_id, "SuperAdmin"));
    return view('permitted.sabana', compact('hotels'));
  }
  public function informacionCliente(Request $request)
  {
    $hotel = $request->cliente;
    $result1 = DB::table('hotels')->where("id",$hotel)->get();
    $itc = DB::select('CALL setemailsnmp(?)', array($hotel));
    $email = DB::table('hotels')->join("sucursals", "hotels.sucursal_id", "=", "sucursals.id")->select("sucursals.correo")->where("hotels.id",$hotel)->get();
    return array_merge(json_decode($result1),$itc,json_decode($email));
  }
  public function get_all_contracts_by_hotel(Request $request)
  {
    $hotel = $request->id;
    $maestro = DB::select('CALL px_contrac_master_data_site(?)', array($hotel));
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
  public function get_nps_hotel(Request $request){
    $id_hotel=$request->id;
    $result = DB::select('CALL px_NPS_sitio (?)', array($id_hotel));
    return $result;
  }

  public function get_nps_comment_hotel(Request $request){
    $id_hotel=$request->id;
    $result = DB::select('CALL px_get_results_nps_sitio (?)', array($id_hotel));
    return $result;
  }

  public function get_graph_equipments(Request $request){
    $id_hotel = $request->id;
    $result = DB::select('CALL px_equiposxtipo_hotel (?)',array($id_hotel));
    return $result;
  }
  public function get_graph_equipments_status(Request $request){
    $id_hotel = $request->id;
    $result = DB::select('CALL px_equiposxstatus_hotel (?)',array($id_hotel));
    return $result;
  }
  public function get_budget_annual_hotel(Request $request){
    $id_hotel = $request->id;
    $date_current = date('Y-m');
    $date = $date_current.'-01';
    /*$input_date_i = $request->date;
    if (empty($input_date_i)) {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }
    else {
      $date = $input_date_i.'-01';
    } */
    $result = DB::select('CALL px_annual_budgets_site(?,?)', array($date,$id_hotel));
    return $result;

  }

  public function get_payment_folios_gastos(Request $request)
  {
    $id = $request->id;
    $res =  DB::select('CALL payments_hotel_folio_gastos(?)', array($id));
    return $res;
  }

  public function get_viatics_gastos(Request $request)
  {
    $id = $request->id;
    $res =  DB::select('CALL px_history_viatics_sitio(?)', array($id));
    return $res;
  }

  public function get_tickets_by_hotel(Request $request){
    $id_hotel=$request->id;

    $result = DB::connection('zendesk')->select('CALL px_ticketsxhotel(?)', array($id_hotel));
    return $result;
  }

  public function get_ticketsxtype_hotel(Request $request ){
    $id_hotel=$request->id;
    $result = DB::connection('zendesk')->select('CALL px_ticketsxtype_hotel(?)', array($id_hotel));
    return $result;
  }


  public function get_ticketsxstatus_hotel(Request $request ){
    $id_hotel=$request->id;
    $result = DB::connection('zendesk')->select('CALL px_ticketsxstatus_hotel(?)', array($id_hotel));
    return $result;
  }

}
