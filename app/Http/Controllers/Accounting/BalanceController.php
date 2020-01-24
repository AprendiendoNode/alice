<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class BalanceController extends Controller
{
    public function index()
    {
    	return view('permitted.accounting.trial_balance');
    	// return 'vista en proceso';
    }
    public function get_balance(Request $request)
    {
	    $input1 = $request->startDate;
	    $input2 = $request->endDate;

	    if (empty($input1) || empty($input2)) {
	    	$date_fin = date('Y-m');
	    	$date_fin = $date_fin . '-01';

	      	$date_inicio = date('Y-m', strtotime("-1 months"));
	    	$date_inicio = $date_inicio . '-01';
	   
	      	$res = DB::select('CALL px_balance_cc_clientes(?,?)', array($date_inicio, $date_fin));
	    	return $res;
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
	      	$res = DB::select('CALL px_balance_cc_clientes(?,?)', array($fecha_inicio, $fecha_fin));
	  		return $res;
	    }

		return $request;
	}
	
	public function view_balance_general_mayor()
	{
		return view('permitted.accounting.balance_general_mayor');
	}

	public function view_balance_general_mayor_filter()
	{
		return view('permitted.accounting.balance_general_filter');
	}

	public function get_balance_general_mayor()
	{
		$result = DB::select('CALL px_balance_general_nivel1()', array());

		return $result;
	}

}
