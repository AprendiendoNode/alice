<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projects\Documentp;
use App\Models\Projects\{Cotizador, Cotizador_gastos};

class ParametrosPresupuesto extends Model
{

    public static function getInversionInstalacion($anexo_id, $documentosPReal)
    {
        $facturacion_mensual = ParametrosPresupuesto::getServicioMensualContract($anexo_id);

        if($documentosPReal < 1){ $documentosPReal = 1; }
        if($facturacion_mensual == null){ $facturacion_mensual = 0.00; }

        $inversion_instalacion = $facturacion_mensual / $documentosPReal;

        return $inversion_instalacion;
    }

    public static function getMantenimiento($anexo_id, $documentosMReal)
    {
        $meses_cobrados = ParametrosPresupuesto::getMesesCobrados($anexo_id);
        $gasto_mensual_mantto = ParametrosPresupuesto::getGastoMensual($anexo_id);

        if($documentosMReal < 1){ $documentosMReal = 1; }

        $mantenimiento = ($documentosMReal / $meses_cobrados) / $gasto_mensual_mantto;

        return $mantenimiento;
    }

    public static function getInversionTotal($anexo_id, $docp_id)
    {

        $meses_cobrados = ParametrosPresupuesto::getMesesCobrados($anexo_id);
        $gasto_mensual_mantto = ParametrosPresupuesto::getGastoMensual($anexo_id);
        $inversion_total = 35000;
        $inversion_cotizador = 2500;


        $inversion_total = ($inversion_total / $inversion_cotizador) + ($gasto_mensual_mantto * $meses_cobrados);

        return $inversion_total;
    }
    
    public static function getTir($anexo_id)
    { 
        $renta = ParametrosPresupuesto::getServicioMensualContract($anexo_id);
        $mantenimiento = ParametrosPresupuesto::getMantenimiento($anexo_id, $documentosMReal);
        $plazo = 36; // meses del contrato
        $total_inversion = 1000;
        $comision  = 100.00;
        $total_inversion = $total_inversion - $comision;
        
        $mantenimiento = 200.00;
        $flujo_neto = $renta - $mantenimiento;
        $suma_total = $total_inversion;
        $vpc = 0.0;
        $tir =  .000000;
        $tir_anualizado = 0.00;
        
        while ($suma_total >= 1) {
            $tir+= .000001;
            $suma_total= 0.0;
            for ($i = 1; $i <= $plazo; $i++) {
            //$vpc = $flujo_neto /   Math.pow(1 + $tir, $i);
            $suma_total+= $vpc;
            }
            $suma_total-= $total_inversion;
        }
        
        $tir_anualizado = $tir * 100 * 12;
        
        return $tir_anualizado; 
    }

    public static function getServicioMensualContract($anexo_id)
    {
        
        /*
        * Buscar en contract_sites->contract_annexes->contract_payments
        * Convertir el monto a dolares si esta en pesos
        */
        $contract_annex = DB::table('contract_sites as A')
                            ->select('B.number_months', 'B.date_scheduled_start', 'C.quantity', 'C.currency_id','D.id_ubicacion','D.servicios_id')
                            ->join('contract_annexes as B', 'A.contract_annex_id', '=', 'B.id')
                            ->join('contract_payments as C', 'A.contract_annex_id', '=', 'B.id')
                            ->join('hotels as D', 'hotel_id', '=', 'D.id')
                            ->where('A.hotel_id', $anexo_id)
                            //->where('C.servicios_id', 1) //arrrendamiento | servicio administrado
                            ->first();
        
        $servicio_mensual = $contract_annex->quantity;
        $currency = $contract_annex->currency_id;
        
        if($currency == 1){
            $servicio_mensual = $servicio_mensual  / 19.5;
        }

        $servicio_mensual = number_format($servicio_mensual, 2, '.', '');
        
        return $servicio_mensual;
    }

    public static function getMesesCobrados($anexo_id)
    {
        //Buscar los meses del contrato y la fecha de inicio de facturacion en:
        //contract_sites->contract_annexes
        $contract_annex = DB::table('contract_sites as A')
                            ->select('B.number_months', 'B.date_scheduled_start', 'C.id_ubicacion','C.servicios_id')
                            ->join('contract_annexes as B', 'A.contract_annex_id', '=', 'B.id')
                            ->join('hotels as C', 'hotel_id', '=', 'C.id')
                            ->where('A.hotel_id', $anexo_id)
                            //->where('C.servicios_id', 1) //arrrendamiento | servicio administrado
                            ->first(); 
             
        $fecha_inicio_contrato = $contract_annex->date_scheduled_start;

        $now = \Carbon\Carbon::now();
        $now_format = $now->format('Y-m-d');

        $fecha_inicio = date_create($fecha_inicio_contrato); 
        $fecha_fin = date_create($now_format); 
        
        $interval = date_diff($fecha_inicio, $fecha_fin);
        $meses = $interval->format('%m');
        
        return $meses;
    }

    public static function getGastoMensual($anexo_id)
    {
        $cotizador = ParametrosPresupuesto::getCotizador($anexo_id);

        $cotizador_gastos = Cotizador_gastos::where('cotizador_id', $cotizador[0]->id)->get();
        $gasto_mensual = $cotizador_gastos[0]->total_gasto_mensual;
        
        return $gasto_mensual;
    }

    public static function getContracAnnex($anexo_id)
    {
        $contract_annex = DB::table('contract_sites as A')
                            ->select('B.number_months', 'B.date_scheduled_start', 'C.id_ubicacion','C.servicios_id')
                            ->join('contract_annexes as B', 'A.contract_annex_id', '=', 'B.id')
                            ->join('hotels as C', 'hotel_id', '=', 'C.id')
                            ->where('A.hotel_id', $anexo_id)
                            //->where('C.servicios_id', 1) //arrrendamiento | servicio administrado
                            ->first();

        return $contract_annex; 
    }

    public static function getCotizador($anexo_id)
    {
        $documentp = DB::table('documentp')
                ->where('anexo_id', $anexo_id)
                ->whereIn('status_id', [3,5])
                ->pluck('id')->first();

        $cotizador = Cotizador::where('id_doc', $documentp)->get();
        
        return $cotizador;
        
    }

}
