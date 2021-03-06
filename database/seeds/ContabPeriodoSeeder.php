<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContabPeriodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $ejercicio_id = 2;
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
