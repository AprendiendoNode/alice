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



}
