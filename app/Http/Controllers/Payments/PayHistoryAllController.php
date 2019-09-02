<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User; //Importar el modelo eloquent
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
