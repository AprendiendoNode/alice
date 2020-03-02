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
    return view('permitted.noc.cl_diario');
  }

  public function dash_operacion(){
    return view('permitted.noc.dash_operacion');
  }


}
