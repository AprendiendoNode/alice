<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AccountingConfigurationController extends Controller
{
    public function index()
    {
        $ejercicios = DB::table('Contab.ejercicios')->select()
                        ->where('status_id', 1)->get();

    	return view('permitted.accounting.accounting_configuration', compact('ejercicios'));
    }

    public function get_periodo_actual()
    {
        $result = DB::table('Contab.ejercicios as A')
            ->select('A.id as id_ejercicio', 'A.fecha_inicio as fecha_inicio_ejercicio', 'A.fecha_final as fecha_final_ejercicio',
                     'B.periodo as periodo', 'B.fecha_inicio as fecha_inicio_periodo', 'B.fecha_final as fecha_final_periodo')
            ->join('Contab.periodos as B', 'B.ejercicio_id', '=', 'A.id')
            ->where('anio', 2020)
            ->where('periodo', 3)
            ->get();

        return $result;   
    }

    public function get_periodos_by_year()
    {
        $result = DB::table('Contab.ejercicios as A')
            ->select('A.id as id_ejercicio', 'A.fecha_inicio as fecha_inicio_ejercicio', 'A.fecha_final as fecha_final_ejercicio',
                     'B.periodo as periodo', 'B.fecha_inicio as fecha_inicio_periodo', 'B.fecha_final as fecha_final_periodo')
            ->join('Contab.periodos as B', 'B.ejercicio_id', '=', 'A.id')
            ->where('anio', 2020)
            ->get();

        return $result;   
    }

    public function get_periodo_month(Request $request)
    {
        $result = DB::table('Contab.ejercicios as A')
            ->select('A.id as id_ejercicio', 'A.fecha_inicio as fecha_inicio_ejercicio', 'A.fecha_final as fecha_final_ejercicio', 'C.name as status',
                     'B.periodo as periodo', 'B.fecha_inicio as fecha_inicio_periodo', 'B.fecha_final as fecha_final_periodo')
            ->join('Contab.periodos as B', 'B.ejercicio_id', '=', 'A.id')
            ->join('Contab.status_periodo as C', 'C.id', '=', 'A.status_id')
            ->where('anio', $request->anio)
            ->get(); 

        return $result;
    }

    public function cerrarPeriodoMensual(Request $request)
    {
        $qry = DB::table('Contab.ejercicios')->select('anio')
                ->where('id', $request->anio)->get();

        $anio = $qry[0]->anio;
        $periodo = $request->periodo;
        $periodo_next = $periodo++;

        $cuentas_contables = DB::table('Contab.cuentas_contables')->select('id', 'cuenta','nombre')->get();   

        foreach($cuentas_contables as $cuenta_contable)
        {   
            $balance_cc =  DB::table('Contab.balanza')->select('cuenta_contable_id','anio', 'mes', 'sdo_inicial', 'cargos','abonos','sdo_inicial', 'sdo_final')
                    ->where([ ['anio', $anio], ['mes', $periodo], ['cuenta_contable_id', $cuenta_contable->id] ])->get();

            if(count($balance_cc) > 0){
                DB::table('Contab.balanza')->insert([
                    'cuenta_contable_id' => $cuenta_contable->id,
                    'anio' => $anio,
                    'mes' => $periodo_next,
                    'sdo_inicial' => $balance_cc[0]->sdo_inicial,
                    'cargos' => $balance_cc[0]->cargos,
                    'abonos' => $balance_cc[0]->abonos,
                    'sdo_final' => $balance_cc[0]->sdo_final  
                ]);
            }else{
                DB::table('Contab.balanza')->insert([
                    'cuenta_contable_id' => $cuenta_contable->id,
                    'anio' => $ani0,
                    'mes' => $periodo_next,
                    'sdo_inicial' => 0.00,
                    'cargos' => 0.00,
                    'abonos' => 0.00,
                    'sdo_final' => 0.00  
                ]);
            }
                        
        }   
            
            

           
    }
   

}
