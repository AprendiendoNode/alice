<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Proveedor;
use DB;
use Auth;

class BankAccountsController extends Controller
{
  public function index()
  {
    $proveedor = DB::table('customers')->select('id', 'name')->get();
    return view('permitted.payments.accounts_pay',compact('proveedor'));
  }
  public function generate_table(Request $request)
  {
    $input_prov= $request->get('select_one');
    $result = DB::select('CALL px_prov_bcos_ctas (?)', array($input_prov));
    return $result;
  }
  public function set_bank(Request $request)
  { info($request);
    $id_reg= $request->get('ident');

    /* tablas antiguas
    $id_prov = DB::table('prov_bco_ctas') //1
    ->where('id', $id_reg)
    ->value('prov_id');

    $cant_reg = DB::table('prov_bco_ctas') //
      ->where('prov_id', '=', $id_prov)
      ->where('id', '!=', $id_reg)
      ->count();*/

      //Apuntamos a las tablas nuevas
      $id_prov = DB::table('customer_bank_accounts') //1
      ->where('id', $id_reg)
      ->value('customer_id');

      $cant_reg = DB::table('customer_bank_accounts') //
        ->where('customer_id', '=', $id_prov)
        ->where('id', '!=', $id_reg)
        ->count();


    if ($cant_reg > 0)
    {
      $actualizacion = DB::table('customer_bank_accounts')
        ->where('customer_id', '=', $id_prov)
        ->where('id', '!=', $id_reg)
        ->update(
        [
          'status_prov_id' => '2',
          'updated_at' => \Carbon\Carbon::now()
        ]);
      //$actualizacion2 
    }
    $res = DB::table('customer_bank_accounts')
      ->where('customer_id', '=', $id_prov)
      ->where('id', '=', $id_reg)
      ->update(
      [
        'status_prov_id' => '1',
        'updated_at' => \Carbon\Carbon::now()
      ]);

    return $res;
  }
  public function get_prov_bco_cta(Request $request)
  {
    $id_provbco = $request->id_provbco;
    // Edit data.
    $res = DB::select('CALL px_prov_bcos_ctas_xid(?)', array($id_provbco));

    return $res;
  }
  public function edit_prov_bco_cta(Request $request)
  {
    $id_provbco = $request->reg_id_prvcta;
    $cuenta = $request->reg_cuenta;
    $clabe = $request->reg_clabe;
    $referencia = $request->reg_reference;

    $res = DB::select('CALL px_prov_bcos_ctas_xid(?)', array($id_provbco));
    $pay_relate = DB::table('payments')->where('prov_bco_ctas_id', $id_provbco)->select()->get();
    //log old
      $log_data = [
        'prov_bco_ctas_id' => $id_provbco,
        'cuenta_A' => $res[0]->cuenta,
        'cuenta_N' => $cuenta,
        'clabe_A' => $res[0]->clabe,
        'clabe_N' => $clabe,
        'referencia_A' => $res[0]->referencia,
        'referencia_N' => $referencia,
        'username' => Auth::user()->name,
        'action' => 'update',
        'Database' => 'AliceDB'
      ];
    $res = DB::connection('alicelog')->table('prov_bco_ctas_log')->insert($log_data);
    //Edit
    $update = DB::table('prov_bco_ctas')->where('id', $id_provbco)->update(['cuenta' => $cuenta, 'clabe' => $clabe, 'referencia' => $referencia]);

    return (string)$update;
  }
}
