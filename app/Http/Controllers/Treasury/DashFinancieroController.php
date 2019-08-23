<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class DashFinancieroController extends Controller
{
    public function index()
    {
      $current_dollar=DB::table('exchange_rates')->select('current_rate')->orderBy('id','DESC')->limit(1)->get();
      //info(json_decode($current_dollar,TRUE)[0]['current_rate']);
      $dollar=json_decode($current_dollar,TRUE)[0]['current_rate'];
    	return view('permitted.treasury.dashboard_financiero',compact('dollar'));
    }
    public function get_bank_movements(Request $request)
    {
    	$date = $request->date;
    	$registro_4 = DB::connection('banks')->select('CALL px_bancos (?)', array($date));
    	return $registro_4;
    }
    public function get_table_banks_mx($date, $type)
    {
        // $current_date = date('Y-m-d');

        $data = DB::connection('banks')->select('CALL px_bancos1 (?)', array($date));

        return view('bank_mx', compact('data'));
    }
    public function get_bank_movements_mxn(Request $request)
    {
		$date = $request->date;
		$res = DB::connection('banks')->select('CALL px_bancos1 (?)', array($date));
		return $res;
    }
    public function get_bank_movements_usd(Request $request)
    {
		$date = $request->date;
		$res2 = DB::connection('banks')->select('CALL px_bancos2 (?)', array($date));
		return $res2;
    }
    public function get_bank_movements_ext(Request $request)
    {
		$date = $request->date;
		$res3 = DB::connection('banks')->select('CALL px_bancos3 (?)', array($date));
		return $res3;
    }
    public function get_top_banks(Request $request)
    {
      info($request);
    	$date = $request->date;
      $year =$request->year;
		$res = DB::connection('banks')->select('CALL px_bancos_resumen_top5 (?,?)', array($date,$year));
		return $res;
    }
    public function get_cxc_cxp(Request $request)
    {
    	$date = $request->date;
      $year = $request->year;
		$res = DB::select('CALL px_bancos_contable_top5 (?,?)', array($date,$year));
		return $res;
    }
    public function get_validaciones(Request $request)
    {
        $date = $request->date;
        $res = DB::connection('banks')->select('CALL px_bancos_validaciones (?)', array($date));
        return $res;
    }
    public function get_cxc_vencidas_306090(Request $request)
    {
      //info('llego');
      $res = DB::select('CALL px_facturas_306090()',array());
      info($res);
    return $res;
    }
    public function get_contract_comment(Request $request){
      $key=$request->key;
      $res=DB::Table('contracts_charges_comments')->select('comment')->where('key',$key)->get();
      info($res);
      return $res;
    }

    public function save_comment_by_contract(Request $request){
      //info($request);
      $user=auth()->user();
      $cadena_id=$request->cadena_id;
      $key=$request->key;
      $oldcomment=$request->oldcomment;
      $comment=$request->newcomment;
      $date=\Carbon\Carbon::now();
      $newcomment= $oldcomment."\n".$date." ".$comment." ".($user->name);
      //
      //info($newcomment);
      $query=DB::Table('contracts_charges_comments')->updateOrInsert(
        ['cadena_id'=>$cadena_id],
        ['cadena_id'=>$cadena_id,
        'key'=>$key,
        'comment'=>$newcomment]
      );
      return response()->json($query);
    }
}
