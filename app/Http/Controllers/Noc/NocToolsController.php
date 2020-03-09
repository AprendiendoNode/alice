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

  public function get_cl_diario(){
    $result=DB::Select('CALL px_get_cl_diario()',array());
    return $result;
  }

  public function get_cl_5_dia(){
    $result=DB::Select('CALL px_get_cl_5_dia()',array());
    return $result;
  }
  public function get_cl_20_dia(){
    $result=DB::Select('CALL px_get_cl_20_dia()',array());
    return $result;
  }

  public function dash_operacion(){
    return view('permitted.noc.dash_operacion');
  }


}
