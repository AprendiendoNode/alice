<?php

namespace App\Http\Controllers\Contracts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
class ContractCobController extends Controller
{
  public function index()
  {
    return view('permitted.contract.contract_cobrados');
  }
  public function tabla_cobs(Request $request)
  {
    // $datenow = date('Y-m-d');
    // $registro = DB::select('CALL px_contracts_charges_data_cobr (?)', array($datenow));
    $date_a = $request->date_start;
    $date_b = $request->date_end;
    $registro = DB::select('CALL px_contracts_charges_data_cobr (?, ?)', array($date_a, $date_b));
    return json_encode($registro);
    //return 'OK';
  }
  public function tabla_cobs_all(Request $request)
  {
    // $datenow = date('Y');
    // $registro = DB::select('CALL px_contracts_charges_data_cobr_all (?)', array($datenow));
    $date_a = $request->date_start;
    $date_b = $request->date_end;
    $registro = DB::select('CALL px_contracts_charges_data_cobr_all (?,?)', array($date_a, $date_b));
    return json_encode($registro);
  }
  public function tabla_cobs_date(Request $request)
  { //29-07-2019
    // $date_m = $request->date_to_search;
    // if ($date_m == '' ) {
    //   $datenow = date('Y-m-d');
    // }
    // else {
    //   $datenow = $date_m.'-01';
    // }
    $date_a = $request->date_start;
    $date_b = $request->date_end;
    $registro = DB::select('CALL px_contracts_charges_data_cobr (?, ?)', array($date_a, $date_b));
    return json_encode($registro);
  }
  public function monto_fact(Request $request)
  { //29-07-2019
    $date_a = $request->date_start;
    $date_b = $request->date_end;
    $registro = DB::select('CALL px_contract_charges_sum_monto_final_all (?,?,?)', array($date_a, $date_b, 2));
    return json_encode($registro);
  }
  public function monto_cob(Request $request)
  {
    $date_a = $request->date_start;
    $date_b = $request->date_end;
    $registro = DB::select('CALL px_contract_charges_sum_monto_final_all (?,?,?)', array($date_a, $date_b, 3));
    return json_encode($registro);
  }
}
