<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $qry = DB::table('Contab.ejercicios')->select('anio')
                ->where('id', 1)->get();

        $anio = $qry[0]->anio;

        $cuentas_contables = DB::table('Contab.cuentas_contables')->select('id', 'cuenta','nombre')->get();


        //$balance_last_year_period = DB::table('Contab.balanza')->select('cuenta_contable_id','anio', 'mes', 'sdo_inicial', 'cargos','abonos','sdo_inicial', 'sdo_final')
         //                                   ->where([ ['anio', 2019], ['mes', 12] ])->get();

        //$balance_cc =  DB::table('Contab.balanza')->select('cuenta_contable_id','anio', 'mes', 'sdo_inicial', 'cargos','abonos','sdo_inicial', 'sdo_final')
        //->where([ ['anio', 2019], ['mes', 12], ['cuenta_contable_id', 5] ])->get();
        
        //dd($balance_last_year_period);
     
        for($periodo = 1; $periodo <= 12; $periodo++)
        {
            foreach($cuentas_contables as $cuenta_contable)
            {     
                if($periodo == 1){

                    $balance_cc =  DB::table('Contab.balanza')->select('cuenta_contable_id','anio', 'mes', 'sdo_inicial', 'cargos','abonos','sdo_inicial', 'sdo_final')
                    ->where([ ['anio', 2019], ['mes', 12], ['cuenta_contable_id', $cuenta_contable->id] ])->get();
                    if(count($balance_cc) > 0){
                        DB::table('Contab.balanza')->insert([
                            'cuenta_contable_id' => $cuenta_contable->id,
                            'anio' => 2020,
                            'mes' => $periodo,
                            'sdo_inicial' => $balance_cc[0]->sdo_inicial,
                            'cargos' => $balance_cc[0]->cargos,
                            'abonos' => $balance_cc[0]->abonos,
                            'sdo_final' => $balance_cc[0]->sdo_final  
                        ]);
                    }else{
                        DB::table('Contab.balanza')->insert([
                            'cuenta_contable_id' => $cuenta_contable->id,
                            'anio' => 2020,
                            'mes' => $periodo,
                            'sdo_inicial' => 0.00,
                            'cargos' => 0.00,
                            'abonos' => 0.00,
                            'sdo_final' => 0.00  
                        ]);
                    }
                    
                }else{
                    DB::table('Contab.balanza')->insert([
                        'cuenta_contable_id' => $cuenta_contable->id,
                        'anio' => 2020,
                        'mes' => $periodo,
                        'sdo_inicial' => 0.00,
                        'cargos' => 0.00,
                        'abonos' => 0.00,
                        'sdo_final' => 0.00  
                    ]);
                }
            }   
            
        }       

           
    }
}
