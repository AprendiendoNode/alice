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
    return $result1;
  }
}
