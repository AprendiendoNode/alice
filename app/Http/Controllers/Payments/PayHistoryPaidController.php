<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

use App\Proveedor;
use App\Vertical;
use App\Reference;
use App\Hotel;
use App\Cadena;
use App\Banco;
use App\Currency;
use App\Prov_bco_cta;
use App\Pay_status_user;

use App\Payments_application;
use App\Payments_area;
use App\Payments_classification;
use App\Payments_comment;
use App\Payments_financing;
use App\Payments_project_options;
use App\Payments_states;
use App\Payments_verticals;
use App\Models\Catalogs\PaymentWay;//PaymentWays corregido
use App\Payments;

class PayHistoryPaidController extends Controller
{
  public function index() {
    $cadena = Cadena::select('id', 'name')->get()->sortBy('name');
    $proveedor = DB::table('customers')->select('id', 'name')->get();
    $vertical = DB::table('verticals')->pluck('name', 'id')->all();
    $currency = Currency::select('id','name')->get();
    $way = PaymentWay::select('id','name')->get();
    $area = DB::table('payments_areas')->pluck('name', 'id')->all();
    $application = DB::table('payments_applications')->pluck('name', 'id')->all();
    $options = DB::table('payments_project_options')->pluck('name', 'id')->all();
    $classification =DB::table('payments_classifications')->select('id','name')->get();
    $financing = DB::table('payments_financings')->pluck('name', 'id')->all();
    return view('permitted.payments.status_paid',compact('cadena','proveedor','vertical', 'currency', 'way', 'area', 'application', 'options', 'classification', 'financing'));
  }
  public function payments_paid (Request $request) {
    $user = Auth::user()->id;
    $email = Auth::user()->email;
    $input_date_i= $request->get('date_to_search');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }
    if (auth()->user()->can('View history all payments status paid')) {
      $result = DB::select('CALL  get_payments_mes_pagado (?)', array($date));
    }
    return $result;
  }

  public function payments_paid_period(Request $request)
  {
    $date_a = $request->date_start;
    $date_b = $request->date_end;
    $result = DB::select('CALL get_payments_pagado_periodo (?, ?)', array($date_a, $date_b));
    return $result;
  }

  public function payments_paid_sums(Request $request)
  {
    $operacion = $request->operation;
    if ($operacion == 1) { // Por mes
      $input_date_i= $request->get('date_to_search');
      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
        $date_end = date('Y-m-t', strtotime($date));
      }
      else {
        $date_current = date('Y-m');
        $date = $date_current.'-01';
        $date_end = date('Y-m-t');
      }
      $result = DB::select('CALL get_payments_pagado_sumas (?, ?)', array($date, $date_end));
      return $result;
    }else{ // Por periodo
      $date_a = $request->date_start;
      $date_b = $request->date_end;
      $result = DB::select('CALL get_payments_pagado_sumas (?, ?)', array($date_a, $date_b));
      return $result;
    }
  }
}
