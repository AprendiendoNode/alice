<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\User; //Importar el modelo eloquent
use App\Currency;
use App\Models\Catalogs\PaymentWay;
use App\Payments;

class PayHistoryAllController extends Controller
{
  public function index()
  {

    $proveedor = DB::table('customers')->select('id', 'name')->get();
    $vertical = DB::table('verticals')->pluck('name', 'id')->all();
    $currency = Currency::select('id','name')->get();
    $way = PaymentWay::select('id','name')->get();
    $area = DB::table('payments_areas')->pluck('name', 'id')->all();
    $application = DB::table('payments_applications')->pluck('name', 'id')->all();
    $options = DB::table('payments_project_options')->pluck('name', 'id')->all();
    $classification =DB::table('payments_classifications')->select('id','name')->get();
    $financing = DB::table('payments_financings')->pluck('name', 'id')->all();

      return view('permitted.payments.history_all_requests_pay',compact('proveedor','vertical', 'currency', 'way', 'area', 'application', 'options', 'classification', 'financing'));
  }
  public function index_paycc()
  {
    $cuentas = DB::select('CALL px_cc_pagos()');

    return view('permitted.payments.pay_cc_edit', compact('cuentas'));
  }
  public function send_items_editcc(Request $request)
  {
    $solicitud_id = json_decode($request->idents);
    $cc_nk = $request->key_name;
    $user = Auth::user()->id;
    $valor= 'false';
    
    $result = explode('|', $cc_nk);
    $key_new = trim($result[0]);
    $name_cc_new = trim($result[1]);

    for ($i=0; $i <= (count($solicitud_id)-1); $i++) {
      $sql = DB::table('pay_mov_cc')->select('id', 'key_cc','name_cc')->where('payments_id', $solicitud_id[$i])->first();
      DB::connection('alicelog')->table('pay_mov_cc_log')->insert([
        'pay_mov_cc_id' => $sql->id,
        'payments_id' => $solicitud_id[$i],
        'key_cc_old' => $sql->key_cc,
        'key_cc_new' => $key_new,
        'name_cc_old' => $sql->name_cc,
        'name_cc_new' => $name_cc_new,
      ]);
      DB::table('pay_mov_cc')->where('payments_id', $solicitud_id[$i])->update(['key_cc' => $key_new, 'name_cc' => $name_cc_new]);
      $valor= 'true';
    }
    return $valor;
  }
  public function solicitudes_historic(Request $request)
  {
    $input1 = $request->startDate;
    $input2 = $request->endDate;

    if (empty($input1) || empty($input2)) {
    	$date_fin = date('Y-m');
    	$date_fin = $date_fin . '-01';

      $date_inicio = date('Y-m', strtotime("-1 months"));

    	$date_inicio = $date_inicio . '-01';

    	//$res = DB::select('CALL payments_fechasolicitud(?, ?)', array($date_inicio, $date_fin));
      $res = DB::select('CALL payments_fechasolicitud_copy(?, ?)', array($date_inicio, $date_fin));
    	return json_encode($res);
    }else{
  		$fecha_inicio = "";
  		$fecha_fin = "";

  		if ($input1 < $input2) {
  		    $fecha_inicio = $input1;
  		    $fecha_fin = $input2;
  		}else{
  		    $fecha_inicio = $input2;
  		    $fecha_fin = $input1;
  		}
  		//$res = DB::select('CALL payments_fechasolicitud(?, ?)', array($fecha_inicio, $fecha_fin));
      $res = DB::select('CALL payments_fechasolicitud_copy(?, ?)', array($fecha_inicio, $fecha_fin));

  		return json_encode($res);
    }
  }

}
