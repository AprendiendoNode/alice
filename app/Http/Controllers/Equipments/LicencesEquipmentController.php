<?php

namespace App\Http\Controllers\Equipments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hotel;
use Carbon\Carbon;
use DB;


class LicencesEquipmentController extends Controller
{
  public function index()
  {
        $hotels = Hotel::select('id', 'Nombre_hotel')->get();
        $estados = DB::table('estados')->select('id', 'Nombre_estado')->get();
        $groups = DB::table('groups')->select('id', 'name')->get();
        return view('permitted.equipment.licences_equipment',compact('hotels', 'estados', 'groups'));
  }

  public function licences(Request $request)
  {
    $filtro = $request->ident;
    $fecha1 = '1900-01-01';
    $fecha2 = '2900-01-01';

    if($filtro == 4) {
      $fecha2 = Carbon::now();
    } else if($filtro != 0) {
      $fecha1 = Carbon::now();
      $fecha2 = Carbon::now()->addMonths($filtro);
    }

    $result = DB::select('CALL detail_device_licences(?, ?)', array($fecha1, $fecha2));
    return json_encode($result);
  }

  public function licence_mac(Request $request)
  {
    $mac = $request->mac_input;
    $result = DB::select('CALL detail_device_mac_serie(?)', array($mac));
    return json_encode($result);
  }

  public function update_date(Request $request)
  {
    $valor = 'true';
    $fecha = $request->fecha;
    $equipos = json_decode($request->idents1);

    DB::table('equipos')->whereIn('id', $equipos)->update(['fecha_vencimiento' => $fecha,  'updated_at' => Carbon::now()]);

    return $valor;
  }

}
