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
        
        $cuentas_contables = DB::table('Contab.cuentas_contables')
                                ->select('id', 'cuenta','nombre')
                                ->where('cuenta', 'like', '%3104-001-%')->get();
        
        return view('permitted.accounting.accounting_configuration', compact('ejercicios', 'cuentas_contables'));
    }

    public function get_periodo_actual(Request $request)
    {
        $result = DB::table('Contab.ejercicios as A')
            ->select('A.id as id_ejercicio', 'A.fecha_inicio as fecha_inicio_ejercicio', 'A.fecha_final as fecha_final_ejercicio',
                     'B.periodo as periodo', 'B.fecha_inicio as fecha_inicio_periodo', 'B.fecha_final as fecha_final_periodo')
            ->join('Contab.periodos as B', 'B.ejercicio_id', '=', 'A.id')
            ->where('anio', 2020)
            ->where('periodo', 4)
            ->get();

        return $result;   
    }

    public function get_periodos_by_year(Request $request)
    {
        $result = DB::table('Contab.ejercicios as A')
            ->select('A.id as id_ejercicio', 'A.fecha_inicio as fecha_inicio_ejercicio', 'A.fecha_final as fecha_final_ejercicio',
                     'B.periodo as periodo', 'B.fecha_inicio as fecha_inicio_periodo', 'B.fecha_final as fecha_final_periodo')
            ->join('Contab.periodos as B', 'B.ejercicio_id', '=', 'A.id')
            ->where([ ['anio', $request->ejercicio], ['B.status_id', 1] ])
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
            ->where('A.anio', $request->anio)
            ->where('B.periodo', $request->periodo)
            ->get(); 

        return $result;
    }

    public function cerrarPeriodoMensual(Request $request)
    {
        $flag = 2;
        $qry = DB::table('Contab.ejercicios')->select('anio','id')
                ->where('anio', $request->ejercicio)->get();
        
        $ejercicio_id = $qry[0]->id;
        $anio = $qry[0]->anio;
        $periodo = $request->periodo;
        $periodo_next = $periodo + 1;
        
        $cuentas_contables = DB::table('Contab.cuentas_contables')->select('id', 'cuenta','nombre')->get();   
        //Vaciando saldos del periodo que se esta cerrando al siguiente mes
        foreach($cuentas_contables as $cuenta_contable)
        {   
            $balance_cc =  DB::table('Contab.balanza')->select('cuenta_contable_id','anio', 'mes', 'sdo_inicial', 'cargos','abonos','sdo_inicial', 'sdo_final')
                    ->where([ ['anio', $anio], ['mes', $periodo], ['cuenta_contable_id', $cuenta_contable->id] ])->get();
            //Actualiza los saldos en el siguiente mes por cuenta contable, si la cuenta no existe, crea el registro en la balanza
            if(count($balance_cc) > 0){
                DB::table('Contab.balanza')
                    ->where([ ['anio', $anio], ['mes', $periodo_next], ['cuenta_contable_id', $cuenta_contable->id] ])
                    ->update([
                        'cuenta_contable_id' => $cuenta_contable->id,
                        'anio' => $anio,
                        'sdo_inicial' => $balance_cc[0]->sdo_inicial,
                        'cargos' => $balance_cc[0]->cargos,
                        'abonos' => $balance_cc[0]->abonos,
                        'sdo_final' => $balance_cc[0]->sdo_final  
                    ]);
            }else{
                DB::table('Contab.balanza')
                    ->insert([
                        'cuenta_contable_id' => $cuenta_contable->id,
                        'anio' => $ani0,
                        'sdo_inicial' => 0.00,
                        'cargos' => 0.00,
                        'abonos' => 0.00,
                        'sdo_final' => 0.00  
                    ]);
            }
                        
        }   
        
        //Marcando el periodo a cerrrado
        DB::table('Contab.periodos')
            ->where([ ['ejercicio_id', $ejercicio_id], ['periodo', $periodo] ])
            ->update(['status_id' => 2]);  
            
        //Habilitando el periodo siguiente
        DB::table('Contab.periodos')
            ->where([ ['ejercicio_id', $ejercicio_id], ['periodo', $periodo_next] ])
            ->update(['status_id' => 1]);

         $flag = 1;  

         return $flag;
    }

    public function cerrar_ejercicio(Request $request)
    {
        $flag = 2;
        $ultimo_ejercicio = $request->ejercicio_cierre_anual;
        $periodo = $request->periodo_cierre_anual;
        
        //Marcando el ejercicio a cerrrado
        DB::table('Contab.ejercicios')
            ->where('anio', $ultimo_ejercicio)
            ->update(['status_id' => 2]); 
    
        //$this->save_poliza_termino($ejercicio, $periodo);
        $this->createBalanceEjercicio($ultimo_ejercicio);
        $flag = 1;

        return $flag;
 
    }

    /**
     * Funcion para sacar la diferencia de las cuentas  4000 y 5000 y guardar 
     * el resultado en una poliza de diario
     * 
     * @ejercicio : valor de 4 digitos | 2019
     * @ejercicio : ultimo mes del ejercicio | 12
    **/

    public function save_poliza_termino($ejercicio, $periodo)
    {
        /*$id_poliza = DB::table('polizas')->insertGetId([
            'tipo_poliza_id' => $request->type_poliza,
            'numero' => $request->num_poliza,
            'fecha' => $request->date_invoice,
            'descripcion' => $request->descripcion_poliza,
            'total_cargos' => $request->total_cargos_format,
            'total_abonos' => $request->total_abonos_format
        ]);

        $sql = DB::table('polizas_movtos')->insert([
            'poliza_id' => $id_poliza,
            'cuenta_contable_id' => $asientos_data[$i]->cuenta_contable_id,
            'customer_invoice_id' => $asientos_data[$i]->factura_id,
            'fecha' => $request->date_invoice,
            'exchange_rate' => $asientos_data[$i]->tipo_cambio,
            'descripcion' => $asientos_data[$i]->nombre,
            'cargos' => $asientos_data[$i]->cargo,
            'abonos' => $asientos_data[$i]->abono,
            'referencia' => $asientos_data[$i]->referencia
          ]);*/
    }

    /**
     * @ultimo_ejercicio : valor de 4 digitos | 2019
    **/

    public function createBalanceEjercicio($ultimo_ejercicio)
    {
        $id_new_ejercicio = $this->crear_ejercicio($ultimo_ejercicio);
        $this->crear_periodos($id_new_ejercicio);
           
        $nuevo_ejercicio = DB::table('Contab.ejercicios')->select('anio','id')
            ->where('id', $id_new_ejercicio)->get();
 
        $new_ejercicio_id = $nuevo_ejercicio[0]->id;
        $new_ejercicio_anio = $nuevo_ejercicio[0]->anio; 

        $this->saldos_iniciales($ultimo_ejercicio, $new_ejercicio_anio); // Saldos iniciales de Enero
        //De febrero a diciembre se insertan saldos en 0
        $cuentas_contables = DB::table('Contab.cuentas_contables')->select('id', 'cuenta','nombre')->get();
        for($periodo = 2; $periodo <= 12; $periodo++)
        {
            foreach($cuentas_contables as $cuenta_contable)
            {            
                DB::table('Contab.balanza')->insert([
                    'cuenta_contable_id' => $cuenta_contable->id,
                    'anio' => $new_ejercicio_anio ,
                    'mes' => $periodo,
                    'sdo_inicial' => 0.00,
                    'cargos' => 0.00,
                    'abonos' => 0.00,
                    'sdo_final' => 0.00  
                ]);                
            }   
        }

    }


    public function update_saldos_balanza($anio,$periodo, $cuentas_contables)
    {
        foreach($cuentas_contables as $cuenta_contable)
        {   
            $balance_cc =  DB::table('Contab.balanza')->select('cuenta_contable_id','anio', 'mes', 'sdo_inicial', 'cargos','abonos','sdo_inicial', 'sdo_final')
                    ->where([ ['anio', $anio], ['mes', $periodo], ['cuenta_contable_id', $cuenta_contable->id] ])->get();
            //Actualiza los saldos en el siguiente mes por cuenta contable, si la cuenta no existe, crea el registro en la balanza
            if(count($balance_cc) > 0){
                DB::table('Contab.balanza')
                    ->where([ ['anio', $anio], ['mes', $periodo_next], ['cuenta_contable_id', $cuenta_contable->id] ])
                    ->update([
                        'cuenta_contable_id' => $cuenta_contable->id,
                        'anio' => $anio,
                        'sdo_inicial' => $balance_cc[0]->sdo_inicial,
                        'cargos' => $balance_cc[0]->cargos,
                        'abonos' => $balance_cc[0]->abonos,
                        'sdo_final' => $balance_cc[0]->sdo_final  
                    ]);
            }else{
                DB::table('Contab.balanza')
                    ->insert([
                        'cuenta_contable_id' => $cuenta_contable->id,
                        'anio' => $ani0,
                        'sdo_inicial' => 0.00,
                        'cargos' => 0.00,
                        'abonos' => 0.00,
                        'sdo_final' => 0.00  
                    ]);
            }
                        
        }
    }

    /**
     * @ultimo_ejercicio : valor de 4 digitos | 2019
    **/

    public function crear_ejercicio($ultimo_ejercicio)
    {
        
        $nuevo_ejercicio = $ultimo_ejercicio + 1;
        
        $dt = \Carbon\Carbon::createFromFormat('Y-m', $nuevo_ejercicio . '-' . '01');
        $dt->firstOfMonth();
        $first_day = $dt->format('Y-m-d');

        $dt = \Carbon\Carbon::createFromFormat('Y-m', $nuevo_ejercicio . '-' . '12');
        $dt->endOfMonth();
        $last_day = $dt->format('Y-m-d');

        $id_new_ejercicio = DB::table('Contab.ejercicios')->insertGetId(
            ['anio' => $nuevo_ejercicio, 
            'fecha_inicio' => $first_day,
            'fecha_final' => $last_day,
            'status_id' => 1
        ]);

        return $id_new_ejercicio;
    }

    public function crear_periodos($ejercicio_id)
    {
        $qry = DB::table('Contab.ejercicios')->select('anio')
                ->where('id', $ejercicio_id)->get();

        $anio = $qry[0]->anio;

        for($periodo = 1; $periodo <= 12; $periodo++)
        {
           
            $dt = \Carbon\Carbon::createFromFormat('Y-m', $anio . '-' . $periodo);
            $dt->firstOfMonth();
            $first_day_month = $dt->format('Y-m-d');

            $dt = \Carbon\Carbon::createFromFormat('Y-m', $anio . '-' . $periodo);
            $dt->endOfMonth();
            $last_day_month = $dt->format('Y-m-d');       

            if($periodo == 1){
                DB::table('Contab.periodos')->insert([
                    'ejercicio_id' => $ejercicio_id,
                    'periodo' => $periodo,
                    'fecha_inicio' => $first_day_month,
                    'fecha_final' => $last_day_month,
                    'status_id' => 1 //Abierto
                ]);
            }else{
                DB::table('Contab.periodos')->insert([
                    'ejercicio_id' => $ejercicio_id,
                    'periodo' => $periodo,
                    'fecha_inicio' => $first_day_month,
                    'fecha_final' => $last_day_month,
                    'status_id' => 3 //Inactivo
                ]);
            }
        }
    }

    /**
     * @ultimo_ejercicio : valor de 4 digitos | 2019
    **/

    public function saldos_iniciales($ultimo_ejercicio, $new_ejercicio_anio)
    {
        $cuentas_contables_0000_3999 = DB::table('Contab.cuentas_contables')
                                            ->select('id', 'nivel1','cuenta','nombre')
                                            ->whereBetween('nivel1', [0, 3999])->get();

        $cuentas_contables_4000_5999 = DB::table('Contab.cuentas_contables')
                                            ->select('id', 'nivel1','cuenta','nombre')
                                            ->whereBetween('nivel1', [4000, 5999])->get();

        $cuentas_contables_6000_9999 = DB::table('Contab.cuentas_contables')
                                            ->select('id', 'nivel1','cuenta','nombre')
                                            ->whereBetween('nivel1', [6000, 9999])->get();
        //En el mes de enero se pasan los saldos finales del ultimo periodo del ejercicio anterior como saldos iniciales;
        foreach($cuentas_contables_0000_3999 as $cuenta_contable1)
        {   
            $balance_cc =  DB::table('Contab.balanza')->select('cuenta_contable_id','anio', 'mes','sdo_final')
                ->where([ ['anio', $ultimo_ejercicio], ['mes', 12], ['cuenta_contable_id', $cuenta_contable1->id] ])->get();
                
                if(count($balance_cc) > 0){
                    DB::table('Contab.balanza')->insert([
                        'cuenta_contable_id' => $cuenta_contable1->id,
                        'anio' => $new_ejercicio_anio,
                        'mes' => 1,// Mes de Enero
                        'sdo_inicial' => $balance_cc[0]->sdo_final,
                        'cargos' => 0,                        
                        'abonos' => 0,
                        'sdo_final' => $balance_cc[0]->sdo_final  
                    ]);
                }else{
                    DB::table('Contab.balanza')->insert([
                        'cuenta_contable_id' => $cuenta_contable1->id,
                        'anio' => $new_ejercicio_anio,
                        'mes' => 1,// Mes de Enero
                        'sdo_inicial' => 0.00,
                        'cargos' => 0.00,
                        'abonos' => 0.00,
                        'sdo_final' => 0.00  
                    ]);
                }                         
        }

        /**
         * Las cuentas de resultados 4000 | 5000 se saldan en el primer periodo del siguiente ejercicio
        */
        foreach($cuentas_contables_4000_5999 as $cuenta_contable2)
        {   
       
            DB::table('Contab.balanza')->insert([
                'cuenta_contable_id' => $cuenta_contable2->id,
                'anio' => $new_ejercicio_anio,
                'mes' => 1,// Mes de Enero
                'sdo_inicial' => 0.00,
                'cargos' => 0.00,
                'abonos' => 0.00,
                'sdo_final' => 0.00  
            ]);
                              
        }
        /****************************************************************************************/
        foreach($cuentas_contables_6000_9999 as $cuenta_contable3)
        {   
            $balance_cc =  DB::table('Contab.balanza')->select('cuenta_contable_id','anio', 'mes','sdo_final')
                ->where([ ['anio', $ultimo_ejercicio], ['mes', 12], ['cuenta_contable_id', $cuenta_contable3->id] ])->get();
                
                if(count($balance_cc) > 0){
                    DB::table('Contab.balanza')->insert([
                        'cuenta_contable_id' => $cuenta_contable3->id,
                        'anio' => $new_ejercicio_anio,
                        'mes' => 1,// Mes de Enero
                        'sdo_inicial' => $balance_cc[0]->sdo_final,
                        'cargos' => 0,
                        'abonos' => 0,
                        'sdo_final' => $balance_cc[0]->sdo_final  
                    ]);
                }else{
                    DB::table('Contab.balanza')->insert([
                        'cuenta_contable_id' => $cuenta_contable3->id,
                        'anio' => $new_ejercicio_anio,
                        'mes' => 1,// Mes de Enero
                        'sdo_inicial' => 0.00,
                        'cargos' => 0.00,
                        'abonos' => 0.00,
                        'sdo_final' => 0.00  
                    ]);
                }                         
        }
    }

   

}
