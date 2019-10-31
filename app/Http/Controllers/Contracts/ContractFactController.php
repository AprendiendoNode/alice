<?php

namespace App\Http\Controllers\Contracts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
class ContractFactController extends Controller
{
    public function index()
    {
      $bancos = DB::connection('banks')->select('select * from bancos');
      return view('permitted.contract.contract_facturados', compact('bancos'));
    }
    public function index_cxc()
    {
      $bancos = DB::connection('banks')->select('select * from bancos');
      return view('permitted.contract.contract_cxc', compact('bancos'));
    }
    public function tabla_facts(Request $request)
    {
      $datenow = date('Y-m-d');
      $registro = DB::select('CALL px_contracts_charges_data_fact (?)', array($datenow));
      return json_encode($registro);
      //return 'OK';
    }
    public function table_facts_all(Request $request)
    {
      $date_a = $request->date_start;
      $date_b = $request->date_end;
      $registro = DB::select('CALL px_contracts_charges_data_fact_all (?,?)', array($date_a, $date_b));
      return json_encode($registro);
    }
    public function table_facts_all_cxc(Request $request)
    {
      $date_a = $request->date_start;
      $date_b = $request->date_end;
      $registro = DB::select('CALL px_contracts_charges_data_fact_all_cxc (?,?)', array($date_a, $date_b));
      return json_encode($registro);
    }
    public function create_items_confirm(Request $request)
    {
      $ids_contracts = json_decode($request->idents);
      $date_current = date('Y-m');
      $date = $date_current.'-01';
      $user_actual = Auth::user()->id;
      $count_id = count($ids_contracts);
      $fecha_cobro = $request->fecha_cobro;
      $banco = $request->banco;
      $factura = $request->factura;

      $aux = explode("-",str_replace("/","-",$fecha_cobro));
      $fecha_ok = $aux[2]."-".$aux[0]."-".$aux[1];

      \DB::beginTransaction();

      for ($i=0; $i < $count_id; $i++) {
            $result = DB::table('contracts_charges')
                      ->where('id', $ids_contracts[$i])
                      // ->where('pay_date', $date)
                      ->update(['contract_charges_state_id' => 3,
                                'user_updated_id' => $user_actual,
                                'fecha_cobro_semana' => date("W", strtotime($fecha_ok)),
                                'fecha_cobro_date' => $fecha_ok,
                                'fecha_cobro' => \Carbon\Carbon::now(),
                                'factura' => $factura,
                                'fecha_mov' => \Carbon\Carbon::now(),
                                'banco_id' => $banco
                              ]);
            DB::table('contracts_charges_statuses')->insert([
                          'contract_charge_id' => $ids_contracts[$i],
                          'user_id' => $user_actual,
                          'contract_charges_state_id' => 3]);
      }
      // Commit the transaction
      DB::commit();
      return $result;
    }
    public function monto_fact(Request $request)
    {
      $date_a = $request->date_start;
      $date_b = $request->date_end;
      $registro = DB::select('CALL px_contract_charges_sum_monto_final_mes (?,?)', array($date_a, $date_b));
      return json_encode($registro);
    }
    public function monto_fact_all(Request $request)
    {
      $date_a = $request->date_start;
      $date_b = $request->date_end;
      $registro = DB::select('CALL px_contract_charges_sum_monto_final_all (?,?,?)', array($date_a, $date_b, 2));
      return json_encode($registro);
    }
    public function monto_fact_all_cxc(Request $request)
    {
      $date_a = $request->date_start;
      $date_b = $request->date_end;
      $registro = DB::select('CALL px_contract_charges_sum_monto_final_all_cxc (?,?)', array($date_a, $date_b));
      return json_encode($registro);
    }
}
