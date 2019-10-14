<?php

namespace App\Http\Controllers\Contracts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Crypt;
use Mail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Catalogs\Currency;
use Jenssegers\Date\Date;

class PruebasController extends Controller
{
    public function index_pagos()
    {
      $currency = Currency::select('id','name')->get();
      $classifications = DB::select('CALL px_cxclassifications ()', array(''));
      //$contract_state = DB::table('contracts_charges_state')->select(DB::raw('id as value'), DB::raw('name as text'))->get();
      $conceptos_sat = DB::table('conceptos_sat')->select(DB::raw('id as value'), DB::raw('producto as text'))->get();
      return view('permitted.contract.prueba',compact('classifications','currency', 'conceptos_sat'));
    }
    public function record_a (Request $request)
    {
      $datenow = date('Y-m-d');
      $datenow = '2019-09-01';
      $registro = DB::select('CALL px_contracts_charges_data (?)', array($datenow));
      // $registro = DB::select('CALL px_contracts_charges_data_hist ()');
      return json_encode($registro);
    }
    public function creat_payauto (Request $request)
    {
      $dato_service = $request->sel_anexo_service;
      $dato_vertical = $request->sel_anexo_vertical;
      $dato_cadena = $request->sel_anexo_cadenas;
      $dato_contract = $request->sel_to_anexo;
      $dato_key_contract = $request->key_cont;
      $dato_concept = $request->concept;
      $dato_monto = $request->monto;
      $data_currency = $request->currency;
      $dato_iva = $request->iva;
      $dato_descuento = $request->descuento;
      $dato_tc = $request->tc;
      $user_actual = Auth::user()->id;

      $subtotal= $dato_monto-$dato_descuento;

      $date_current = date('Y-m');
      $date = $date_current.'-01';

      $dato_miva = $request->mens_iva;
      $dato_mfinal = $request->mfinal;

      $result = DB::table('contracts_charges')
              ->insertGetId([
                  'cxclassification_id' => $dato_service,
                  'vertical_id' => $dato_vertical,
                  'cadena_id' => $dato_cadena,
                  'contract_id' => $dato_contract,
                  'key' => $dato_key_contract,
                  'concepto' => $dato_concept,

                  'currency_id' => $data_currency,
                  'monto' => $dato_monto,
                  'descuento' => $dato_descuento,
                  'iva_id' => '1',
                  'iva_value' => $dato_iva,
                  'exchange_range_id' => '1',
                  'exchange_range_value' => $dato_tc,
                  'mensualidad_civa'=> $dato_miva,
                  'monto_final'=> $dato_mfinal,
                  'subtotal'=>$subtotal,

                  'estado_insercion' => '1',
                  'contract_charges_state_id' => '1',
                  'pay_date' => $date,
                  'user_created_id' => $user_actual,
                ]);
      if($result != '0'){
          $flag =1;
      }
      return $flag;
    }
    public function delete_payauto (Request $request)
    {
      $id_reg = $request->val;
      $result = DB::table('contracts_charges')
                ->where('id', $id_reg)
                ->delete();
      return $result;
    }
    public function creat_tc_general (Request $request)
    {
      $dato_tipc = (float)$request->tpgeneral;
      $dato_coin = $request->updcurrency;
      $date_current = date('Y-m');
      $date = $date_current.'-01';
      $user_actual = Auth::user()->id;

      if ($dato_tipc <= 0) {
        $date_operacion = 1;
      }else{
        $date_operacion = $dato_tipc;
      }

      $count_pay = DB::table('contracts_charges')
                   ->where('currency_id', $dato_coin)
                   ->where('pay_date', $date)
                   ->get();
      $size_count_pay = count($count_pay);
      for ($j=0; $j < $size_count_pay; $j++) {
        $monto = DB::table('contracts_charges')->select('mensualidad_civa')->where('id', $count_pay[$j]->id)->value('mensualidad_civa');
        $monto_final = ($monto * $date_operacion);
        $result = DB::table('contracts_charges')
                  ->where('id', $count_pay[$j]->id)
                  ->where('currency_id', $dato_coin)
                  ->where('pay_date', $date)
                  ->update(['exchange_range_value' => $dato_tipc,
                            'monto_final' => $monto_final,
                            'user_updated_id' => $user_actual,
                            'updated_at' =>  \Carbon\Carbon::now()]);
      }
      return $result;
    }
    public function create_iva_general(Request $request)
    {
      $dato_iva = $request->iva_general;

      $date_current = date('Y-m');
      $date = $date_current.'-01';
      $user_actual = Auth::user()->id;

      if ($dato_iva < 0) {
        $date_operacion = 0;
      }else{
        $date_operacion = $dato_iva;
      }

      $count_pay = DB::table('contracts_charges')
             ->where('pay_date', $date)
             ->get();
      $size_count_pay = count($count_pay);
      for ($j=0; $j < $size_count_pay; $j++) {

        $subtotal = DB::table('contracts_charges')->select('subtotal')->where('id', $count_pay[$j]->id)->value('subtotal');
        $tc_value =DB::table('contracts_charges')->select('exchange_range_value')->where('id', $count_pay[$j]->id)->value('exchange_range_value');
        if ($tc_value <= 0) {
          $date_operacion_tc = 1;
        }else{
          $date_operacion_tc = $tc_value;
        }
        $iva = ($date_operacion * 0.01);
        $iva = ($subtotal * $iva);
        $monto_civa = ($subtotal + $iva);

        $monto_final = ($monto_civa * $date_operacion_tc);
        $result = DB::table('contracts_charges')
                  ->where('id', $count_pay[$j]->id)
                  ->where('pay_date', $date)
                  ->update(['iva_value' => $dato_iva,
                            'mensualidad_civa' => $monto_civa,
                            'monto_final' => $monto_final,
                            'user_updated_id' => $user_actual]);
      }
      return $result;
    }
    public function create_fc_payauto(Request $request)
    {
      $date_fecha_com = $request->date_compromise;
      $date_fecha_fact = $request->date_factura;
      $date_current = date('Y-m');
      $date = $date_current.'-01';
      $user_actual = Auth::user()->id;

      if (empty($date_fecha_com)) {
        if (empty($date_fecha_fact)) {
          return '0';
        }else{
          // Fecha Factura
          $count_pay = DB::table('contracts_charges')
                       ->where('pay_date', $date)
                       ->get();
          $size_count_pay = count($count_pay);

          for ($i=0; $i < $size_count_pay; $i++) {
            $result = DB::table('contracts_charges')
                      ->where('id', $count_pay[$i]->id)
                      ->where('pay_date', $date)
                      ->update(['fecha_factura' => $date_fecha_fact,
                                'user_updated_id' => $user_actual,
                                'updated_at' =>  \Carbon\Carbon::now()]);
          }
          return $result;
        }
      }elseif (empty($date_fecha_fact)) {
        if (empty($date_fecha_com)) {
          return '0';
        }else{
          //fecha compromiso.
          $count_pay = DB::table('contracts_charges')
                       ->where('pay_date', $date)
                       ->get();
          $size_count_pay = count($count_pay);

          for ($i=0; $i < $size_count_pay; $i++) {
            $result = DB::table('contracts_charges')
                      ->where('id', $count_pay[$i]->id)
                      ->where('pay_date', $date)
                      ->update(['fecha_compromiso' => $date_fecha_com,
                                'user_updated_id' => $user_actual,
                                'updated_at' =>  \Carbon\Carbon::now()]);
          }
          return $result;
        }
      }else{
        // Meter Ambos.
        $count_pay = DB::table('contracts_charges')
                     ->where('pay_date', $date)
                     ->get();
        $size_count_pay = count($count_pay);

        for ($i=0; $i < $size_count_pay; $i++) {
          $result = DB::table('contracts_charges')
                    ->where('id', $count_pay[$i]->id)
                    ->where('pay_date', $date)
                    ->update(['fecha_compromiso' => $date_fecha_com,
                              'fecha_factura' => $date_fecha_fact,
                              'user_updated_id' => $user_actual,
                              'updated_at' =>  \Carbon\Carbon::now()]);
        }
        return $result;
      }
      return '0';
    }
    public function create_fc_payauto_dt(Request $request)
    {
      $ids_contracts = json_decode($request->idents);
      $date_fecha_com = $request->date_compromise;
      $date_fecha_fact = $request->date_factura;
      $date_current = date('Y-m');
      $date = $date_current.'-01';
      $user_actual = Auth::user()->id;

      if (empty($date_fecha_com)) {
        if (empty($date_fecha_fact)) {
          return '0';
        }else{
          // Fecha Factura
          $size_count_pay = count($ids_contracts);

          for ($i=0; $i < $size_count_pay; $i++) {
            $result = DB::table('contracts_charges')
                      ->where('id', $ids_contracts[$i])
                      ->where('pay_date', $date)
                      ->update(['fecha_factura' => $date_fecha_fact,
                                'user_updated_id' => $user_actual,
                                'updated_at' =>  \Carbon\Carbon::now()]);
          }
          return $result;
        }
      }elseif (empty($date_fecha_fact)) {
        if (empty($date_fecha_com)) {
          return '0';
        }else{
          //fecha compromiso.
          $size_count_pay = count($ids_contracts);

          for ($i=0; $i < $size_count_pay; $i++) {
            $result = DB::table('contracts_charges')
                      ->where('id', $ids_contracts[$i])
                      ->where('pay_date', $date)
                      ->update(['fecha_compromiso' => $date_fecha_com,
                                'user_updated_id' => $user_actual,
                                'updated_at' =>  \Carbon\Carbon::now()]);
          }
          return $result;
        }
      }else{
        // Meter Ambos.
        $size_count_pay = count($ids_contracts);

        for ($i=0; $i < $size_count_pay; $i++) {
          $result = DB::table('contracts_charges')
                    ->where('id', $ids_contracts[$i])
                    ->where('pay_date', $date)
                    ->update(['fecha_compromiso' => $date_fecha_com,
                              'fecha_factura' => $date_fecha_fact,
                              'user_updated_id' => $user_actual,
                              'updated_at' =>  \Carbon\Carbon::now()]);
        }
        return $result;
      }
      return '0';
    }
    public function create_items_fact(Request $request)
    {
      $ids_contracts = json_decode($request->idents);
      $date_current = date('Y-m');
      $date = $date_current.'-01';
      $user_actual = Auth::user()->id;
      $count_id = count($ids_contracts);

      for ($i=0; $i < $count_id; $i++) {
            $result = DB::table('contracts_charges')
                      ->where('id', $ids_contracts[$i])
                      ->where('pay_date', $date)
                      ->update(['contract_charges_state_id' => 2,
                                'user_updated_id' => $user_actual,
                                'updated_at' =>  \Carbon\Carbon::now()]);
      }

      return $result;
    }
    public function get_status_contracts(Request $request)
    {
      $result = DB::table('contracts_charges_state')->select('id', 'name')->get();

      return $result;
    }
    public function update_monthly (Request $request)
    {
      $dato_0 = $request->v_data;
      $dato_1 = $request->v_monto;
      $dato_2 = $request->v_desct;
      $dato_3 = $request->v_subtt;
      $dato_4 = $request->v_iva;
      $dato_5 = $request->v_ms_iva;
      $dato_6 = $request->v_typecb;
      $dato_7 = $request->v_mens_t;

      $user_actual = Auth::user()->id;
      $result = DB::table('contracts_charges')
                ->where('id', $dato_0)
                ->update([
                    'monto' => $dato_1,
                    'descuento' => $dato_2,
                    'subtotal' => $dato_3,
                    'iva_value' => $dato_4,
                    'mensualidad_civa' => $dato_5,
                    'exchange_range_value' => $dato_6,
                    'monto_final' => $dato_7,
                    'user_updated_id' => $user_actual,
                    'updated_at' =>  \Carbon\Carbon::now()]);
      return $result;
    }

    public function record_anex_cont(Request $request)
    {
      $data = $request->valor;
      $registro = DB::select('CALL px_contract_master_annexes_key (?)', array($data));
      return json_encode($registro);
    }
    public function upd_multiple_conceptsat(Request $request)
    {
      $ids_contracts = json_decode($request->idents);
      $concept = $request->concept;
      $date_current = date('Y-m');
      $date = $date_current.'-01';
      $user_actual = Auth::user()->id;
      $count_id = count($ids_contracts);

      for ($i=0; $i < $count_id; $i++) {
            $result = DB::table('contracts_charges')
                      ->where('id', $ids_contracts[$i])
                      ->update(['concepto' => $concept,
                                'user_updated_id' => $user_actual,
                                'updated_at' =>  \Carbon\Carbon::now()]);
      }
      return $result;
      //return $concept;
    }
    public function upd_conceptsat(Request $request)
    {
      $dato_0 = $request->v_data;
      $dato_1 = $request->v_reg;
      $user_actual = Auth::user()->id;
      $result = DB::table('contracts_charges')
                ->where('id', $dato_0)
                ->update([
                    'concepto' => $dato_1,
                    'user_updated_id' => $user_actual,
                    'updated_at' =>  \Carbon\Carbon::now()]);
      return $result;
    }
    public function idproyanexo_search_by_cadena(Request $request)
    {
      $id = $request->valor;
      $result = DB::select('CALL px_idcontract_cadena_key (?)', array($id));
      return json_encode($result);
    }
}
