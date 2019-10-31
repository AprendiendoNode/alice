<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class checkxpaymentsmonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checará mensualmente los pagos que se deben realizar mes a mes.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // fecha compromiso, o no aplica. nueva vista con menos columnas, plazo de vencimiento(numero día).
        // Dashboard contratos, distribución.s
        
        $fecha_ini = date('Y-m-01');
        // $fecha_fin = date('Y-m-t');
        // $fecha_cur = date('Y-m-d');
        // $fecha_ini = date('2019-11-01');
        
        $contracts = DB::select('CALL px_contracts_active_data(?)', array($fecha_ini));
        //$contracts = DB::select('CALL px_contracts_active_data(?)', array('2019-01-01'));
        $count = count($contracts);

        $contract_charges_state_id = 1;
        $estado_insercion = 0;
        
        \DB::beginTransaction();
        for ($i=0; $i < $count; $i++) {
            $this->line('Current Iteration: '. $i);
            $monto = $contracts[$i]->quantity;
            $monto_final_f = 0.00;
            $monto_final_iva = 0.00;
            $monto_final_iva_tc = 0.00;
            $iva = $contracts[$i]->iva;


            if ($contracts[$i]->iva_id === 1) {
                $monto_final_iva = $monto;
            }else{
                $iva = ($iva * 0.01);
                $monto_mod = ($monto * $iva);
                $monto_final_iva = ($monto + $monto_mod);
            }
            // if ($contracts[$i]->exchange_range_id === 2) {
            //     $monto_final_iva_tc = $monto;
            // }else{
            //     $tipo_cambio = ($monto * $contracts[$i]->exchange_range_value);
            //     $monto_final_iva_tc = tipo_cambio;
            // }

            $data_insert = [
                'contract_id' => $contracts[$i]->id,
                'num_mes_actual' => $contracts[$i]->meses_para_cobrar,
                'num_mes_saldo' => $contracts[$i]->mesFaltante,
                'num_mes_total' => $contracts[$i]->number_months,
                'monto' => $contracts[$i]->quantity,
                'currency_id' => $contracts[$i]->currency_id,
                'exchange_range_id' => $contracts[$i]->exchange_range_id,
                'exchange_range_value' => $contracts[$i]->exchange_range_value,
                'iva_id' => $contracts[$i]->iva_id,
                'iva_value' => $contracts[$i]->iva,
                'date_real' => $contracts[$i]->date_real,
                'date_final' => $contracts[$i]->FFin_real,
                'pay_date' => $fecha_ini,
                'cxclassification_id' => $contracts[$i]->cxclassification_id,
                'vertical_id' => $contracts[$i]->vertical_id,
                'cadena_id' => $contracts[$i]->cadena_id,
                'key' => $contracts[$i]->key,
                'contract_charges_state_id' => $contract_charges_state_id,
                'concepto' => 0,
                'estado_insercion' => $estado_insercion,
                'mensualidad_civa' => $monto_final_iva,
                'monto_final' => $monto_final_iva,
                'subtotal' => $contracts[$i]->quantity
            ];

            $sql_insert = DB::table('contracts_charges')->insertGetId($data_insert);
            
            $data_insert_statuses = DB::table('contracts_charges_statuses')->insert([
                          'contract_charge_id' => $sql_insert,
                          'user_id' => 1,
                          'contract_charges_state_id' => $contract_charges_state_id]);

            if ($data_insert_statuses) {
                $this->line('Datos Insertados.');
            }else{
                $this->error('no se insertaron datos.');
            }
        }
        // Commit the transaction
        DB::commit();
        
        $this->info('Command Completed.');
    }
}
