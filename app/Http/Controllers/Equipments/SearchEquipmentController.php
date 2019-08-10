<?php

namespace App\Http\Controllers\Equipments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hotel;
use DB;
use Auth;
//use App\Estado;
use Carbon\Carbon;

class SearchEquipmentController extends Controller
{
  /**
   * Show the application search equipment
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $hotels = Hotel::select('id', 'Nombre_hotel')->get();
      $facturas= DB::select('CALL px_equipos_facturas ()', array());
      $modelos= DB::select('CALL px_modelos_todos ()', array());
      $estados = DB::table('estados')->select('id', 'Nombre_estado')->get();
      return view('permitted.equipment.search_equipment',compact('hotels', 'facturas', 'modelos', 'estados'));
  }
  public function search_range(Request $request)
  {
    $data_a = $request->inicio;
    $data_b = $request->fin;
    $estatus = $request->stat;
    $result = DB::select('CALL detail_device_baja (?, ?, ?)', array($data_a, $data_b, $estatus));
    return json_encode($result);
  }
  public function search_mac(Request $request)
  {
    $mac = $request->mac_input;
    $result = DB::select('CALL detail_device_mac_serie(?)', array($mac));
    return json_encode($result);
  }

  public function get_equip_departure(Request $request)
  {
    $data_a = $request->date_start;
    $data_b = $request->date_end;
    $result = DB::select('CALL px_equipos_sale_de_bodega (?, ?)', array($data_a, $data_b));

    return $result;
  }

  public function search_infoeq_fact(Request $request)
  {
    $id = $request->select_one_fact;
    $result = DB::select('CALL px_equipos_facturas_datos(?)', array($id));
    return json_encode($result);
  }
  public function search_infoeq_model(Request $request)
  {
    $id = $request->select_one_model;
    $result = DB::select('CALL px_equipos_facturas_modelo(?)', array($id));
    return json_encode($result);
  }

}
