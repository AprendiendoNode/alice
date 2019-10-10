<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cadena;
use App\Hotel;
use App\Proveedor;
use App\Reference;
use App\Banco;
use App\Currency;
use App\Prov_bco_cta;
use App\Pay_status_user;
use App\Payments_application;
use App\Payments_area;
use App\Payments_classification;
use App\Payments_comment;
use App\Payments_financing;
use App\Payments_project_options;
use App\Payments_states;
use App\Payments_verticals;
use App\Models\Catalogs\PaymentWay;//PaymentWays corregido
use App\Payments;
use DB;

class FilterPayController extends Controller
{
  public function index()
  {
      $cadena = DB::table('listarhoteles_noasignar')->select('id', 'hotel')->get();
      $folio = DB::table('payments')->select('id','folio')->get()->sortBy('folio');
      $proveedor = DB::table('customers')->select('id', 'name')->get();
      $cuentas = DB::select('CALL px_cc_pagos()');

      return view('permitted.payments.filter_proy_pay',compact('cadena','folio', 'proveedor', 'cuentas'));

  }

  public function get_proyecto(Request $request)
  {
    $id = $request->data_one;
    $proyecto = DB::select('CALL get_proyecto_hotel(?)', array($id));
    return json_encode($proyecto);
  }

  public function get_folios(Request $request)
  {
    $id = $request->id;
    $res =  DB::select('CALL payments_hotel_folio(?)', array($id));
    return json_encode($res);
  }
  public function get_payments_proveedor(Request $request)
  {
    $id = $request->id;
    $res =  DB::select('CALL payments_hotel_proveedor(?)', array($id));
    return $res;
  }
  public function get_payments_cuentacontable(Request $request)
  {
    $id = $request->id;
    $res =  DB::select('CALL payments_hotel_proveedor(?)', array($id));
  }
  public function autocomplete_folio(Request $request)
  {
      $term =$request->data_one;

      $results = array();
      $folioData = DB::select('CALL payments_filter_folio(?)', array($term));
      $queries = DB::table('payments')
        ->select('id','folio')
        ->where('folio', 'LIKE', '%'.$term.'%')
        ->take(5)->get();

      foreach ($queries as $query)
      {
          $results[] = [ 'id' => $query->id, 'folio' => $query->folio];
      }
      return json_encode(compact('results','folioData'));
  }

  public function get_payment_by_folio(Request $request)
  {
    $id = $request->data_one;
    $payment = DB::select('CALL payments_filter_id(?)', array($id));
    return json_encode($payment);
  }

  public function get_paymentId(Request $request)
  {
    $id = $request->data_one;
    $payment = DB::select('CALL payments_filter_id(?)', array($id));
    return json_encode($payment);
  }
}
