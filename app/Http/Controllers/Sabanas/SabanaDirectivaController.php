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

class SabanaDirectivaController extends Controller
{

  public function index()
  {
    if(Auth::user()->id==16 || Auth::user()->id==432 || Auth::user()->id==440){
    return view('permitted.sabanas.sabana_directiva');
    }
    else{
      return view('home');
    }
  }

  public function getAllCadena(Request $request)
  {
    $anio=$request->anio;
    $result=DB::Select('CALL px_presupuesto_xcadenaV2(?)',array($anio));
    return $result;
  }


  public function getAllSites(Request $request)
  {
    $idcadena=$request->idcadena;
    $anio=$request->anio;
    $result = DB::Select('CALL px_presupuesto_xsitioV2(?)',array($anio));
    info($result);
    return $result;

  }

  public function getAllCadenaBudget(Request $request){
    $anio=$request->anio;
    $result=DB::Select('CALL px_presupuesto_xcadena_desglozado(?)',array($anio));
    return $result;
  }

  public function getBudgetSiteMonth(Request $request){
    $idcadena=$request->idcadena;
    $anio=$request->anio;
    $result=DB::Select('CALL px_presupuesto_xsitio_desglozado(?,?)',array($anio,$idcadena));
    return $result;
  }

}
