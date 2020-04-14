<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Currency;
use Carbon\Carbon;

class BudgetController extends Controller
{
    public function index()
    {
    	$currency = Currency::select('id','name')->get();
    	return view('permitted.planning.budget');
    }
    public function index_budget_report()
    {
    	$currency = Currency::select('id','name')->get();
    	return view('permitted.planning.budget_report', compact('currency'));
    }
    public function get_annual_budget(Request $request)
  	{
  		$input_date_i = $request->date;
  		if (empty($input_date_i)) {
  			$date_current = date('Y-m');
  			$date = $date_current.'-01';
  		}
  		else {
  			$date = $input_date_i.'-01';
  		}
  		$sql = DB::select('CALL px_annual_budgets(?)', array($date));

  		return $sql;
  	}
    public function get_annual_budget_directiva(Request $request)
  	{
  		$date = $request->date;
  		$tipo = $request->tipo;
  		$id = $request->id;
  		$sql = DB::select('CALL px_annual_budgets_directiva(?,?,?)', array($date, $tipo, $id));
  		return $sql;
  	}
    // Revisar
    public function get_annual_budget_by_id(Request $request)
    {
       $id_budget = $request->$id_budget;
        $sql = DB::select('CALL px_annual_budgets_idx(?)', array($id_budget));
        return $sql;
    }
    // --
	public function update_budget(Request $request)
  	{
  		$id_annualbudget = $request->v_data;
  		$monto = $request->v_monto;
  		$operation = $request->v_type;
  		$id_user = Auth::id();

  		switch ($operation) {
  			case 1:
  		    	$sql = DB::table('annual_budgets')->where('id', $id_annualbudget)->update([
  		    		'equipo_activo_monto' => $monto,
  		    		'user_id' => $id_user]);
  				break;
  			case 2:
  		    	$sql = DB::table('annual_budgets')->where('id', $id_annualbudget)->update([
  		    		'equipo_no_activo_monto' => $monto,
  		    		'user_id' => $id_user,]);
  				break;
  			case 3:
  		    	$sql = DB::table('annual_budgets')->where('id', $id_annualbudget)->update([
  	    			'licencias_monto' => $monto,
  	    			'user_id' => $id_user,]);
  				break;
  			case 4:
  		    	$sql = DB::table('annual_budgets')->where('id', $id_annualbudget)->update([
  	    			'mano_obra_monto' => $monto,
  	    			'user_id' => $id_user,]);
  				break;
  			case 5:
  		    	$sql = DB::table('annual_budgets')->where('id', $id_annualbudget)->update([
  	    			'enlaces_monto' => $monto,
  	    			'user_id' => $id_user,]);
  				break;
  			case 6:
  		    	$sql = DB::table('annual_budgets')->where('id', $id_annualbudget)->update([
  	    			'viaticos_monto' => $monto,
  	    			'user_id' => $id_user,]);
  				break;
  			default:
  				return '0';
  				break;
  		}

  		return (string)$sql;
  	}
    public function refresh_budget_sites(Request $request)
    {
    	DB::select('CALL px_crea_nuevos_budgets()');
    	DB::select('CALL px_borra_budgets()');

    	return 'OK';
    }
  	public function get_budget_report(Request $request)
  	{
  	    $tipo_cambio = $request->tpgeneral;
  		if (empty($tipo_cambio)) {
  			$tipo_cambio = '20.00';
  	    }
  		$input_date_i = $request->date;
  		if (empty($input_date_i)) {
  			$date_current = date('Y-m');
  			$date = $date_current.'-01';
  		}
  		else {
  			$date = $input_date_i.'-01';
  		}
  		$res = DB::select('CALL px_proyects_renta_presupuesto(?,?)', array($tipo_cambio,$date));
  		return $res;
  	}
  	public function get_desglose_payments(Request $request)
  	{
  		$sitio =$request->site_id;
  		$tipo_cambio = $request->tipo_c;
  		if (empty($tipo_cambio)) {
  			$tipo_cambio = '19.5';
  	    }
  		$input_date_i = $request->date;
  		if (empty($input_date_i)) {
  			$date_current = date('Y-m');
  			$date = $date_current.'-01';
  		}
  		else {
  			$date = $input_date_i.'-01';
  		}
  		$result = DB::select('CALL px_desglose_ejercido(?,?,?)', array($sitio,$tipo_cambio,$date));

  		// if (empty($result)) {
  		// 	return "0";
  		// }
  		return $result;
  	}
    // se esta usando get_budgettable_site de DocumentHistoryController
    /*public function get_estimation_site($id_anexo, $tipo_cambio)
    {
        $data = DB::select('CALL px_proyectos_categorias(?,?,?)', array($id_anexo,'20.00','2019-03-19'));
        //dd($data);
        return view('permitted.planning.estimation_site', compact('data'));
    }*/
}
