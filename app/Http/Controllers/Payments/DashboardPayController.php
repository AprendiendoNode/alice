<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class DashboardPayController extends Controller
{
  public function index()
  {
      return view('permitted.payments.dashboard_pay');
  }
  public function data_header(Request $request)
  {
    $result = array();
    $input_date_i= $request->get('date');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }

    if (auth()->user()->can('View dashboard payment notification')) {
        $result = DB::select('CALL payments_statuses (?)', array($date));
        return json_encode($result);
    }
    return json_encode($result);
  }
  public function data_application(Request $request)
  {
    $result = array();
    $input_date_i= $request->get('date');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }

    if (auth()->user()->can('View dashboard payment notification')) {
      $result = DB::select('CALL payments_applications (?)', array($date));
    }
    return json_encode($result);
  }
  public function data_waypay(Request $request)
  {
    $result = array();
    $input_date_i= $request->get('date');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }

    if (auth()->user()->can('View dashboard payment notification')) {
      $result = DB::select('CALL payments_waypays (?)', array($date));
    }
    return json_encode($result);
  }
  public function data_current(Request $request)
  {
    $result = array();
    $input_date_i= $request->get('date');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }

    if (auth()->user()->can('View dashboard payment notification')) {
      $result = DB::select('CALL payments_currencies (?)', array($date));
    }
    return json_encode($result);
  }
  public function data_classifications(Request $request)
  {
    $result = array();
    $input_date_i= $request->get('date');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }

    if (auth()->user()->can('View dashboard payment notification')) {
      $result = DB::select('CALL payments_classifications (?)', array($date));
    }
    return json_encode($result);
  }
  public function data_options(Request $request)
  {
    $result = array();
    $input_date_i= $request->get('date');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }

    if (auth()->user()->can('View dashboard payment notification')) {
      $result = DB::select('CALL payments_options (?)', array($date));
    }
    return json_encode($result);
  }
  public function data_month(Request $request)
  {
    $result = array();
    $input_date_i= $request->get('date');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }

    if (auth()->user()->can('View dashboard payment notification')) {
      $result = DB::select('CALL payments_currencies_6month (?)', array($date));
    }
    return json_encode($result);
  }

  // data_month

}
