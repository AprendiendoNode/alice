<?php

namespace App\Http\Controllers\Sockets;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use App\User;
//use DateTime;
use DB;
use Auth;
//use Mail;
//use App\Cadena;

class SiteController extends Controller
{

  public function index()
  {
    return view('permitted.sockets.site_view');
  }

  public function informacionCliente(Request $request)
  {
    /*$hotel = $request->cliente;
    $result1 = DB::table('hotels')->where("id",$hotel)->get();
    $itc = DB::select('CALL setemailsnmp(?)', array($hotel));
    $email = DB::table('hotels')->join("sucursals", "hotels.sucursal_id", "=", "sucursals.id")->select("sucursals.correo")->where("hotels.id",$hotel)->get();
    return array_merge(json_decode($result1),$itc,json_decode($email));*/
  }

}
