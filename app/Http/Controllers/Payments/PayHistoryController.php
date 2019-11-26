<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User; //Importar el modelo eloquent
use App\Proveedor;
use App\Vertical;
use App\Reference;
use App\Hotel;
use App\Cadena;
use App\Banco;
use App\Currency;
use App\Prov_bco_cta;
use App\Pay_status_user;
use App\Deny_paycomment;
use PDF;
use App\Payments_application;
use App\Payments_area;
use App\Payments_classification;
use App\Payments_comment;
use App\Payments_financing;
use App\Payments_project_options;
use App\Payments_states;
use App\Payments_verticals;
use App\Models\Catalogs\PaymentWay;
use App\Payments;
use Mail;
use File;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use App\Mail\SolicitudConP;
class PayHistoryController extends Controller
{
  public function index()
  {

    $cadena = Cadena::select('id', 'name')->get()->sortBy('name');
    $proveedor = DB::table('customers')->select('id', 'name')->get();
    $vertical = DB::table('verticals')->pluck('name', 'id')->all();
    $currency = Currency::select('id','name')->get();
    $way = PaymentWay::select('id','name')->get();
    $area = DB::table('payments_areas')->pluck('name', 'id')->all();
    $application = DB::table('payments_applications')->pluck('name', 'id')->all();
    $options = DB::table('payments_project_options')->pluck('name', 'id')->all();
    $classification =DB::table('payments_classifications')->select('id','name')->get();
    $financing = DB::table('payments_financings')->pluck('name', 'id')->all();

    return view('permitted.payments.history_requests_pay',compact('cadena','proveedor','vertical', 'currency', 'way', 'area', 'application', 'options', 'classification', 'financing'));

  }

  public function index2()
  {
    return view('permitted.payments.history_program_pay');
  }
  public function index3()
  {
    //return 'Confirm Pay';
    $bancos = DB::connection('banks')->select('select * from bancos');
    return view('permitted.payments.history_confirm_pay', compact('bancos'));
  }
  //edit_pay_ways
  public function edit_pay_ways(Request $request)
  {
    $way = PaymentWay::select('id','name')->get();
    return $way;
  }
  public function cc_account(Request $request)
  {
    $pay_id= $request->get('idpay');
    $result = DB::select('CALL px_pay_mov_keyname (?)',array($pay_id));
    return json_encode($result);
  }
  public function get_proveedor_banks(Request $request)
  {
    $pay_id = $request -> get('pay_id');
    $result = DB::select('CALL px_get_customer_bank (?)',array($pay_id));
    return $result;
  }
  public function program_payment(Request $request)
  {
    $user = Auth::user()->id;
    $email = Auth::user()->email;

    $input_date_i= $request->date_to_search;
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }
    $result = DB::select('CALL px_pay_mov_cc (?)', array($date));

    return $result;
  }
  public function confirm_payment_table(Request $request)
  {
    $user = Auth::user()->id;
    $email = Auth::user()->email;

    $input_date_i= $request->date_to_search;

    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }
    $result = DB::select('CALL px_pay_conf_cc (?)', array($date));

    return $result;
  }
  public function confirm_payment_table_period(Request $request)
  {
    $date_a = $request->date_start;
    $date_b = $request->date_end;
    $result = DB::select('CALL px_pay_conf_cc_periodo (?, ?)', array($date_a, $date_b));
    return $result;
  }
  public function confirm_pay_sums(Request $request)
  {
    $operacion = $request->operation;
    if ($operacion == 1) { // Por mes
      $input_date_i= $request->get('date_to_search');
      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
        $date_end = date('Y-m-t', strtotime($date));
      }
      else {
        $date_current = date('Y-m');
        $date = $date_current.'-01';
        $date_end = date('Y-m-t');
      }
      $result = DB::select('CALL px_pay_conf_cc_sumas (?, ?)', array($date, $date_end));
      return $result;
    }else{ // Por periodo
      $date_a = $request->date_start;
      $date_b = $request->date_end;
      $result = DB::select('CALL px_pay_conf_cc_sumas (?, ?)', array($date_a, $date_b));
      return $result;
    }
  }
  public function get_date_pay_program(Request $request){
    $solicitud_id = $request->id_payment;

    $result = DB::table('payments')->select('id', 'date_scheduled_pay')->where('id', '=', $solicitud_id)->get();

    return $result;
  }
  public function approval_program(Request $request)
  {
    $solicitud_id = $request->idents;
    $date_schedule = $request->schedule;
    $user = Auth::user()->id;
    $valor= 'false';
    $result = DB::table('payments')->select('id', 'payments_states_id')->where('id', '=', $solicitud_id)->get();
    if($result[0]->payments_states_id == 6){
      $sql = DB::table('payments')->where('id','=',$solicitud_id)->update(['date_scheduled_pay' => $date_schedule, 'updated_at' => Carbon::now()]);
    }else{
      $sql = DB::table('payments')->where('id','=',$solicitud_id)->update(['payments_states_id' => '6', 'date_scheduled_pay' => $date_schedule, 'updated_at' => Carbon::now()]);
        DB::table('pay_status_users')->insert([
          'payment_id'=>$solicitud_id,
          'user_id'=>$user,
          'status_id'=>'6',
          'created_at'=> Carbon::now(),
          'updated_at'=>Carbon::now()
        ]);
        /*$new_reg_paym = new Pay_status_user;
        $new_reg_paym->payment_id = $solicitud_id;
        $new_reg_paym->user_id = $user;
        $new_reg_paym->status_id = '6';
        $new_reg_paym->save();*/
    }
    $valor = "true";

    return $valor;
  }
  public function approval_program_all(Request $request){
    $payments_id = [];
    $payments_id = $request->idents;
    $date_schedule = $request->date_s;
    $user = Auth::user()->id;
    $valor = "false";

    $tam = count($payments_id);

    for($i = 0; $i < $tam; $i++){
      $result = DB::table('payments')->select('id', 'payments_states_id')->where('id', '=', $payments_id[$i])->get();
      if($result[0]->payments_states_id == 6){
        $sql = DB::table('payments')->where('id','=', $payments_id[$i])->update(['date_scheduled_pay' => $date_schedule, 'updated_at' => Carbon::now()]);
      }else{
        $sql = DB::table('payments')->where('id','=',$payments_id[$i])->update(['payments_states_id' => '6', 'date_scheduled_pay' => $date_schedule, 'updated_at' => Carbon::now()]);
        DB::table('pay_status_users')->insert([
          'payment_id'=>$payments_id[$i],
          'user_id'=>$user,
          'status_id'=>'6',
          'created_at'=> Carbon::now(),
          'updated_at'=>Carbon::now()
        ]);
        /*  $new_reg_paym = new Pay_status_user;
          $new_reg_paym->payment_id = $payments_id[$i];
          $new_reg_paym->user_id = $user;
          $new_reg_paym->status_id = '6';
          $new_reg_paym->save();*/
      }
    }
    $valor = "true";

    return $valor;
  }

  public function history_zero (Request $request) {
    $user = Auth::user()->id;
    $email = Auth::user()->email;
    $result = array();
    $input_date_i= $request->get('date_to_search');

    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $date = $date_current.'-01';
    }
    if (auth()->user()->can('View history of payment')) {
      if (auth()->user()->can('View level zero payment notification')){ /*Notificaciones del usuario, con estatus nuevo*/
        $result = DB::select('CALL  get_payments_mes (?)', array($date));
      }
      if (auth()->user()->can('View level one payment notification')){ /*Notificaciones del usuario, con estatus nuevo*/
        $result = DB::select('CALL  get_payments_mes (?)', array($date));
      }
      if (auth()->user()->can('View level two payment notification')){ /*Notificaciones del usuario, con estatus nuevo*/
        $result = DB::select('CALL  get_payments_mes (?)', array($date));
      }
      if (auth()->user()->can('View level three payment notification')){ /*Notificaciones del usuario, con estatus nuevo*/
        $result = DB::select('CALL  get_payments_mes (?)', array($date));
      }
    }
    return json_encode($result);
  }
  public function approval_one(Request $request) {
    $solicitud_id = json_decode($request->idents);
    $user = Auth::user()->id;
    $valor= 'false';
    for ($i=0; $i <= (count($solicitud_id)-1); $i++) {
      $sql = DB::table('payments')->where('id', '=', $solicitud_id[$i])->update(['payments_states_id' => '2', 'updated_at' => Carbon::now()]);
      DB::table('pay_status_users')->insert([
        'payment_id'=>$solicitud_id[$i],
        'user_id'=>$user,
        'status_id'=>'2',
        'created_at'=> Carbon::now(),
        'updated_at'=>Carbon::now()
      ]);
      $valor= 'true';
    }
    return $valor;
  }
  public function approval_two(Request $request) {
    $solicitud_id = json_decode($request->idents);
    $user = Auth::user()->id;
    $valor= 'false';
    for ($i=0; $i <= (count($solicitud_id)-1); $i++) {
      $sql = DB::table('payments')->where('id', '=', $solicitud_id[$i])->update(['payments_states_id' => '3', 'updated_at' => Carbon::now()]);
      DB::table('pay_status_users')->insert([
        'payment_id'=>$solicitud_id[$i],
        'user_id'=>$user,
        'status_id'=>'3',
        'created_at'=> Carbon::now(),
        'updated_at'=>Carbon::now()
      ]);
      $valor= 'true';
    }
    return $valor;
  }
  public function approval_three (Request $request) {
    $solicitud_id = json_decode($request->idents);

    $user = Auth::user()->id;
    $valor= 'false';

    $banco = $request->banco;
    $fecha_cobro = $request->fecha_cobro;
    $operacion = $request->operacion;

    if ($operacion == 0) {
      // Multiples pagos/facturas
      for ($i=0; $i <= (count($solicitud_id)-1); $i++) {
        $sql = DB::table('payments')->where('id', '=', $solicitud_id[$i])->update(
          [
            'payments_states_id' => '4',
            'date_pay' => $fecha_cobro,
            'date_pay_auto' => Carbon::now(),
            // 'factura' => $factura,
            'banco_pay_id' => $banco,
            'updated_at' => Carbon::now()
          ]);
        $user_sol = DB::table('pay_status_users')->select('user_id')->where([['payment_id', '=', $solicitud_id[$i]],['status_id', '=', 1]])->value('user_id');

        $user_email = DB::table('users')->select('email')->where('id', $user_sol)->value('email');
        $user_email = trim($user_email);
        $result = DB::select('CALL px_payments_data (?)', array($solicitud_id[$i]));

        $tamanoGeneral = count($result);
        $parametros2 = [];
        DB::table('pay_status_users')->insert([
          'payment_id'=>$solicitud_id[$i],
          'user_id'=>$user,
          'status_id'=>'4',
          'created_at'=> Carbon::now(),
          'updated_at'=>Carbon::now()
        ]);/*
        $new_reg_paym = new Pay_status_user;
        $new_reg_paym->payment_id = $solicitud_id[$i];
        $new_reg_paym->user_id = $user;
        $new_reg_paym->status_id = '4';
        $new_reg_paym->save();*/
        $valor= 'true';
        //  $parametros1 = [
        //    'folio' => $result[0]->folio,
        //    'elaboro' => $result[0]->elaboro,
        //    'proveedor' => $result[0]->proveedor,
        //    'monto_total' => $result[0]->monto_total,
        //    'data_montos' => $result,
        //    'moneda' => $result[0]->moneda,
        //    'concepto' => $result[0]->concepto_pago,
        //    'forma_pago' => $result[0]->forma_pago,
        //    'banco' => $result[0]->banco,
        //    'observaciones' => $result[0]->observaciones,
        //    'fecha_elaboro' => $result[0]->fecha_elaboro,
        // ];
        // for ($i=0; $i < $tamanoGeneral; $i++) {
        //   array_push($parametros2, ['grupo' => $result[$i]->cadena,
        //                             'anexo' => $result[$i]->Sitio,
        //                             'id_proyecto' => $result[$i]->id_proyecto,
        //                             'monto' => $result[$i]->monto,
        //                             'iva' => $result[$i]->iva,
        //                             'monto_iva' => $result[$i]->monto_iva
        //                           ]);
        // }
        // Mail::to($user_email)->send(new SolicitudConP($parametros1,$parametros2));
      }
    }else{
      // Solo un registro.
      $factura = $request->factura;
      for ($i=0; $i <= (count($solicitud_id)-1); $i++) {
        $sql = DB::table('payments')->where('id', '=', $solicitud_id[$i])->update(
          [
            'payments_states_id' => '4',
            'date_pay' => $fecha_cobro,
            'date_pay_auto' => Carbon::now(),
            'factura' => $factura,
            'banco_pay_id' => $banco,
            'updated_at' => Carbon::now()
          ]);
        $user_sol = DB::table('pay_status_users')->select('user_id')->where([['payment_id', '=', $solicitud_id[$i]],['status_id', '=', 1]])->value('user_id');

        $user_email = DB::table('users')->select('email')->where('id', $user_sol)->value('email');
        $user_email = trim($user_email);
        $result = DB::select('CALL px_payments_data (?)', array($solicitud_id[$i]));

        $tamanoGeneral = count($result);
        $parametros2 = [];
        DB::table('pay_status_users')->insert([
          'payment_id'=>$solicitud_id[$i],
          'user_id'=>$user,
          'status_id'=>'4',
          'created_at'=> Carbon::now(),
          'updated_at'=>Carbon::now()
        ]);/*
        $new_reg_paym = new Pay_status_user;
        $new_reg_paym->payment_id = $solicitud_id[$i];
        $new_reg_paym->user_id = $user;
        $new_reg_paym->status_id = '4';
        $new_reg_paym->save();*/
        $valor= 'true';

        //  $parametros1 = [
        //    'folio' => $result[0]->folio,
        //    'elaboro' => $result[0]->elaboro,
        //    'proveedor' => $result[0]->proveedor,
        //    'monto_total' => $result[0]->monto_total,
        //    'data_montos' => $result,
        //    'moneda' => $result[0]->moneda,
        //    'concepto' => $result[0]->concepto_pago,
        //    'forma_pago' => $result[0]->forma_pago,
        //    'banco' => $result[0]->banco,
        //    'observaciones' => $result[0]->observaciones,
        //    'fecha_elaboro' => $result[0]->fecha_elaboro,
        // ];
        // for ($i=0; $i < $tamanoGeneral; $i++) {
        //   array_push($parametros2, ['grupo' => $result[$i]->cadena,
        //                             'anexo' => $result[$i]->Sitio,
        //                             'id_proyecto' => $result[$i]->id_proyecto,
        //                             'monto' => $result[$i]->monto,
        //                             'iva' => $result[$i]->iva,
        //                             'monto_iva' => $result[$i]->monto_iva
        //                           ]);
        // }
        // Mail::to($user_email)->send(new SolicitudConP($parametros1,$parametros2));
      }
    }
    return $valor;
  }
  public function get_fact_name(Request $request)
  {
    $pay_id = $request->id_payment;
    $name_factura = DB::table('payments')->select('factura', 'pay_status_fact_id')->where('id', $pay_id)->get();
    return $name_factura;
  }
  public function approval_three_ind (Request $request) {
    $user = Auth::user()->id;
    $valor= '0';
    $solicitud_id = $request->idents;
    $result_exist = DB::select('CALL px_pay_status_user_4o3 (?)', array($solicitud_id));
    if ($result_exist[0]->resp === '0'){
      $valor= $result_exist[0]->resp;
    }
    if ($result_exist[0]->resp === '1'){
      $valor= $result_exist[0]->resp;
      $sql = DB::table('payments')->where('id', '=', $solicitud_id)->update(['payments_states_id' => '4', 'updated_at' => Carbon::now()]);

      $user_sol = DB::table('pay_status_users')->select('user_id')->where([['payment_id', '=', $solicitud_id],['status_id', '=', 1]])->value('user_id');

      $user_email = DB::table('users')->select('email')->where('id', $user_sol)->value('email');
      $user_email = trim($user_email);
      $result = DB::select('CALL px_payments_data (?)', array($solicitud_id));
      DB::table('pay_status_users')->insert([
        'payment_id'=>$solicitud_id,
        'user_id'=>$user,
        'status_id'=>'4',
        'created_at'=> Carbon::now(),
        'updated_at'=>Carbon::now()
      ]);/*
      $new_reg_paym = new Pay_status_user;
      $new_reg_paym->payment_id = $solicitud_id;
      $new_reg_paym->user_id = $user;
      $new_reg_paym->status_id = '4';
      $new_reg_paym->save();*/

     //  $parametros1 = [
     //    'folio' => $result[0]->folio,
     //    'elaboro' => $result[0]->elaboro,
     //    'proveedor' => $result[0]->proveedor,
     //    'monto_total' => $result[0]->monto_total,
     //    'data_montos' => $result,
     //    'moneda' => $result[0]->moneda,
     //    'concepto' => $result[0]->concepto_pago,
     //    'forma_pago' => $result[0]->forma_pago,
     //    'banco' => $result[0]->banco,
     //    'observaciones' => $result[0]->observaciones,
     //    'fecha_elaboro' => $result[0]->fecha_elaboro,
     // ];
     //
     // for ($i=0; $i < $tamanoGeneral; $i++) {
     //   array_push($parametros2, ['grupo' => $result[$i]->Sitio,
     //                             'anexo' => $result[$i]->Sitio,
     //                             'id_proyecto' => $result[$i]->id_proyecto,
     //                             'monto' => $result[$i]->monto,
     //                             'iva' => 0,
     //                             'monto_iva' => $result[$i]->monto_iva
     //                           ]);
     // }

     //Mail::to($user_email)->send(new SolicitudConP($parametros1,$parametros2));
    }

    if ($result_exist[0]->resp === '2'){
      $valor= $result_exist[0]->resp;
    }
    return $valor;
  }

  public function data_basic (Request $request) {
    $pay_id= $request->get('pay');
    $result = DB::select('CALL payments_data (?)', array($pay_id));

    return $result;
  }

  public function get_coins (Request $request) {
    $result = Currency::select('id','name')->get();
    return $result;
  }

  public function data_basic_comments (Request $request) {
    $pay_id= $request->get('pay');
    $result = DB::select('CALL payments_comments (?)',array($pay_id));
    return json_encode($result);
  }
  public function data_basic_venues (Request $request) {
    $pay_id= $request->get('pay');
    $result = DB::select('CALL px_paymentes_movs (?)', array($pay_id));
    return json_encode($result);
  }
  public function data_basic_facts (Request $request) {
    $pay_id= $request->get('pay');
    $result = DB::select('CALL px_pay_view_fact (?)', array($pay_id));
    return json_encode($result);
  }
  public function data_basic_firmas (Request $request) {
    $pay_id= $request->get('pay');
    $result = DB::select('CALL payments_user_statuses_all (?)',array($pay_id));
    return json_encode($result);
  }
  public function data_basic_bank (Request $request) {
    $pay_id= $request->get('pay');
    $result = DB::select('CALL payments_ctabco_data (?)',array($pay_id));
    return json_encode($result);
  }
  public function deny_payment_act (Request $request) {

     $user = Auth::user()->id;
     $pay_id= $request->get('idents');
     $valor= 'false';
     $comment = $request->comm;

    if (auth()->user()->can('View level one payment notification')){
      $count_md = DB::table('payments')->where('id', '=', $pay_id)->where('payments_states_id', '!=', '5')->where('payments_states_id', '!=', '4')->count();
      if ($count_md != '0') {
        $sql = DB::table('payments')->where('id', '=', $pay_id)->update(['payments_states_id' => '5', 'updated_at' => Carbon::now()]);
        DB::table('pay_status_users')->insert([
          'payment_id'=>$pay_id,
          'user_id'=>$user,
          'status_id'=>'5',
          'created_at'=> Carbon::now(),
          'updated_at'=>Carbon::now()
        ]);
        /*$new_reg_paym = new Pay_status_user;
        $new_reg_paym->payment_id = $pay_id;
        $new_reg_paym->user_id = $user;
        $new_reg_paym->status_id = '5';
        $new_reg_paym->save();*/
        if($comment != " " && $comment != null){
          DB::table('deny_paycomments')->insert([
            'name'=>$comment,
            'payment_id'=>$pay_id,
            'user_id'=>$user,
            'created_at'=> Carbon::now(),
            'updated_at'=>Carbon::now()
          ]);

        /*  $new_reg_denypay_comm = new Deny_paycomment;
          $new_reg_denypay_comm->name = $comment;
          $new_reg_denypay_comm->payment_id = $pay_id;
          $new_reg_denypay_comm->user_id = $user;
          $new_reg_denypay_comm->save();*/
        }
        $valor= 'true';
      }
    }
    if (auth()->user()->can('View level two payment notification')){
      $count_md = DB::table('payments')->where('id', '=', $pay_id)->where('payments_states_id', '!=', '5')->where('payments_states_id', '!=', '4')->count();
      if ($count_md != '0') {
        $sql = DB::table('payments')->where('id', '=', $pay_id)->update(['payments_states_id' => '5', 'updated_at' => Carbon::now()]);
        DB::table('pay_status_users')->insert([
          'payment_id'=>$pay_id,
          'user_id'=>$user,
          'status_id'=>'5',
          'created_at'=> Carbon::now(),
          'updated_at'=>Carbon::now()
        ]);
        /*$new_reg_paym = new Pay_status_user;
        $new_reg_paym->payment_id = $pay_id;
        $new_reg_paym->user_id = $user;
        $new_reg_paym->status_id = '5';
        $new_reg_paym->save();*/
        if($comment != " " && $comment != null){
          DB::table('deny_paycomments')->insert([
            'name'=>$comment,
            'payment_id'=>$pay_id,
            'user_id'=>$user,
            'created_at'=> Carbon::now(),
            'updated_at'=>Carbon::now()
          ]);/*
          $new_reg_denypay_comm = new Deny_paycomment;
          $new_reg_denypay_comm->name = $comment;
          $new_reg_denypay_comm->payment_id = $pay_id;
          $new_reg_denypay_comm->user_id = $user;
          $new_reg_denypay_comm->save();*/
        }
        $valor= 'true';
      }
     }

    return $valor;
  }

  public function getInvoice(Request $request)
  {
    $id = $request->id_fact;
    $count = DB::table('pay_facturas')->select('name')->where('payment_id',$id)->count();

    if($count != 0)
    {
      $sql = DB::table('pay_facturas')->select('name')->where('payment_id',$id)->get();
      // Si solo hay una factura se envia el data del pdf directamente
      if($count == 1){
        $file = $sql[0]->name;

        $path = public_path('/images/storage/'.$file);
        if(File::exists($path)){
          return response()->download($path);
        }
        // Si hay mas de una factura se procede a enviar los pdf en un .zip
      }else{
        $sql = DB::table('pay_facturas')->select('name')->where('payment_id',$id)->get();
        $fac_sql = DB::table('payments')->select('factura')->where('id',$id)->get();

        $fact_name = $fac_sql[0]->factura;

        $zip = new ZipArchive;
        $res = $zip->open(public_path('/images/storage/uploads/'.$fact_name.'.zip'), ZipArchive::CREATE);

        if ($res == TRUE)
        {
          for($i = 0; $i < $count; $i++){

            $file = $sql[$i]->name;
            $new_name = substr($file, 34, 100);
            $file_name = $new_name;
            $path = public_path('images/storage/'.$file);

            // Si el archivo existe se añade en el zip
            if(File::exists($path)){
              $zip->addFile($path, $file_name);
            }

          }

          $zip->close();

          $path_zip = public_path('/images/storage/uploads/'.$fact_name.'.zip');
          if(File::exists($path_zip)){
            return response()->download($path_zip);
          }

        }

    }
    // Si no existen facturas no se devuelve algun valor

  }

}


public function getInvoicePdf(Request $request)
{
  $id = $request->id_fact;
  $count = DB::table('pay_facturas')->select('name')->where('payment_id',$id)->count();

  if($count != 0)
  {
    $sql = DB::table('pay_facturas')->select('name')->where('payment_id',$id)->get();
    // Si solo hay una factura se envia el data del pdf directamente
    if($count == 1){
      $file = $sql[0]->name;
      $path = public_path('/images/storage/'.$file);
      if(File::exists($path)){
        return response()->download($path);
      }
      // Si hay mas de una factura se procede a verificar cual es el pdf para descargarla
    }else{
      for($i = 0; $i < $count; $i++){

        $file = $sql[$i]->name;
        $new_name = substr($file, 34, 100);
        $ext = substr($file, -3);


        $file_name = $new_name;
        $path = public_path('images/storage/'.$file);

        // Si el archivo existe se añade en el zip
        if(File::exists($path) && trim($ext) == 'pdf'){
          return response()->download($path);
        }

      }

    }

  }

}

public function update_pay (Request $request) {

  $ordenDeCompra = $request -> get('ordenDeCompra');
  $concepto = $request -> get('concepto');
  $formaDePago = $request -> get('formaDePago');
  $banco = $request -> get('banco'); //
  $cuenta = $request -> get('cuenta'); //
  $clabe = $request -> get('clabe'); //
  //$referencia = $request -> get('referencia'); //
  $observacion = $request -> get('observacion'); //
  $monto = $request -> get('monto'); //
  $tasa = $request -> get('tasa'); //
  $montoIVA = $request -> get('montoIVA'); //
  $total = $request -> get('total'); //
  $currency = $request -> get('currency');

  $payment = $request -> get('payment');

  //Checar cambios
  $payments_montos_table = DB::table('payments_montos')->select('*')->where('payments_id', $payment)->get();
  $payments_table = DB::table('payments')->select('*')->where('id', $payment)->get();
  $payments_comments_table = DB::table('payments_comments')->select('*')->where('payment_id', $payment)->get();

  //SÓLO FUNCIONA CORRECTAMENTE EN PAGOS QUE NO SEAN MÚLTIPLES
  DB::table('payments_montos')->where('payments_id', $payment)->update([
    'amount' => $monto,
    'IVA' => $tasa,
    'amount_iva' => $montoIVA,
    'updated_at' => \Carbon\Carbon::now()
  ]);

  DB::table('payments')->where('id', $payment)->update([
    'purchase_order' => $ordenDeCompra,
    'concept_pay' => $concepto,
    'way_pay_id' => $formaDePago,
    'amount' => $total,
    'prov_bco_ctas_id' => $cuenta,
    'currency_id' => $currency,
    'name' => $observacion,
    'updated_at' => \Carbon\Carbon::now()
  ]);

  DB::table('payments_comments')->where('payment_id', $payment)->update([
    'name' => $observacion,
    'updated_at' => \Carbon\Carbon::now()
  ]);

  //Save logs
  DB::connection('alicelog')->table('edit_payments_log')->insert([
    'payment_id' => $payment,
    'orden_compra' => $payments_table[0]->purchase_order." -> ".$ordenDeCompra,
    'concepto' => $payments_table[0]->concept_pay." -> ".$concepto ,
    'forma_pago' => $payments_table[0]->way_pay_id." -> ".$formaDePago,
    'cuenta' => $payments_table[0]->prov_bco_ctas_id." -> ".$cuenta,
    'clabe' => $clabe,
    'observacion' => $payments_comments_table[0]->name." -> ".$observacion,
    'monto' => $payments_montos_table[0]->amount." -> ".$monto,
    'tasa' => $payments_montos_table[0]->IVA." -> ".$tasa,
    'monto_iva' => $payments_montos_table[0]->amount_iva." -> ".$montoIVA,
    'total' => $payments_table[0]->amount." -> ".$total,
    'currency' => $payments_table[0]->currency_id." -> ".$currency,
    'user' => Auth::user()->name,
    'user_id' => Auth::user()->id,
    'action' => "Updated",
    'db' => DB::connection()->getDatabaseName(),
    'created_at' => \Carbon\Carbon::now()
  ]);

  return "OK";
}

  public function export_pay(Request $request)
  {

    $cc = ($request -> get('prints'))[0];
    $fecha_de_solicitud = ($request -> get('prints'))[1];
    $fecha_de_pago = ($request -> get('prints'))[2];
    $num_factura = ($request -> get('prints'))[3];
    $orden_de_compra = ($request -> get('prints'))[4];
    $prioridad = ($request -> get('prints'))[5];
    $folio = ($request -> get('prints'))[6];
    $proveedor = ($request -> get('prints'))[7];
    $monto = ($request -> get('prints'))[8];
    $monto_texto = ($request -> get('prints'))[9];
    $valores_tabla = array_chunk(($request -> get('tabla')), 7);
    $concepto_de_pago = ($request -> get('prints'))[10];
    $forma_de_pago = ($request -> get('prints'))[11];
    $banco = ($request -> get('prints'))[12];
    $cuenta = ($request -> get('prints'))[13];
    $clabe = ($request -> get('prints'))[14];
    $referencia = ($request -> get('prints'))[15];

    if($referencia == null) $referencia = "Referencia bancaria";

    $observaciones = ($request -> get('prints'))[16];
    $subtotal = ($request -> get('prints'))[17];
    $iva = ($request -> get('prints'))[18];
    $total = ($request -> get('prints'))[19];

    $pdf = PDF::loadView('permitted.payments.pdf_pay',
                compact('cc', 'fecha_de_solicitud', 'fecha_de_pago', 'num_factura','orden_de_compra', 'prioridad','folio', 'proveedor', 'monto', 'monto_texto',
                'valores_tabla', 'concepto_de_pago', 'forma_de_pago', 'banco', 'cuenta', 'clabe', 'referencia', 'observaciones', 'subtotal', 'iva', 'total'));

    return base64_encode($pdf->stream());
  }

}
