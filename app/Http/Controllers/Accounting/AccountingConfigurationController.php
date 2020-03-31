<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AccountingConfigurationController extends Controller
{
    public function index()
    {
    	return view('permitted.accounting.accounting_configuration');
    }

    public function get_periodo_actual()
    {
        $result = DB::table('Contab.ejercicios as A')
            ->select('A.id id_ejercicio', '', 'A.fecha_inicio fecha_inicio_ejercicio', 'A.fecha_final fecha_final_ejercicio',
                     'B.periodo fecha_final_ejercicio', 'B.fecha_inicio fecha_inicio_periodo', 'B.fecha_final fecha_final_periodo')
            ->join('periodos B', 'B.ejercicio_id', '=', 'A.id')
            ->where('anio', 2020)
            ->get();

        return $result;
        
    }

    
   

}
