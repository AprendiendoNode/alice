<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use PDF;

class BalanceController extends Controller
{
    public function index()
    {
    	return view('permitted.accounting.trial_balance');
    	// return 'vista en proceso';
	}
	
	public function getBalanceByMonth(Request $request)
    { 
		$periodo = $request->date_month;
		$explode = explode('-', $periodo);
		$anio = $explode[0];
		$mes = $explode[1];

		$result = DB::select('CALL Contab.px_balanza_xperiodo(?,?)',array($anio, $mes));

        return $result;
    }

	public function generate_balace_pdf($periodo)
	{
		if($periodo != '' && $periodo != null){
			$explode = explode('-', $periodo);
			$anio = $explode[0];
			$mes = $explode[1];

			$dt = \Carbon\Carbon::createFromFormat('m', $mes);
			$dt->firstOfMonth();
			$first_day_month = $dt->format('d/m/Y');

			$dt = \Carbon\Carbon::createFromFormat('m', $mes);
			$dt->endOfMonth();
			$last_day_month = $dt->format('d/m/Y');

			$data = DB::select('CALL Contab.px_balanza_xperiodo(?,?)',array($anio, $mes));

			$pdf = PDF::loadView('permitted.accounting.balance_general_pdf', compact('data', 'first_day_month', 'last_day_month'));
			
			return $pdf->download('balanza_comprobacion_'. $periodo .'.pdf');
		}
		
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
