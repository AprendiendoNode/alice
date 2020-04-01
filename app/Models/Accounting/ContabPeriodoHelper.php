<?php

namespace App\Models\Accounting;
use DB;

class ContabPeriodoHelper
{
    public static function validar_ejercicio($anio)
    {
        $flag = False;
        $ejercicio = DB::table('Contab.ejercicios')->select('anio', 'fecha_inicio', 'fecha_final', 'status_id')
            ->where('anio', $anio)->get();
        //Si se cumple, el ejercicio esta abierto
        if(count($ejercicio) != 0){
            ($ejercicio[0]->status_id == 1) ? $flag = True : $flag = False;
        }

        return $flag;
    }

    public static function validar_periodo($anio, $mes)
    {
        $flag = False;
        $ejercicio = DB::table('Contab.periodos as A')->select('A.periodo','A.status_id as periodo_status', 'B.anio', 'B.status_id as ejercicio_status')
            ->join('Contab.ejercicios as B', 'A.ejercicio_id', '=', 'B.id')    
            ->where('A.periodo', $mes)
            ->where('B.anio', $anio)
            ->get();

        //Si se cumple, el ejercicio y el periodo esta abierto
        if(count($ejercicio) != 0){       
            ($ejercicio[0]->ejercicio_status == 1 && $ejercicio[0]->periodo_status == 1) ? $flag = True : $flag = False;
        }
        
        return $flag;
    }

}