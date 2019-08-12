<?php

namespace App\Http\Controllers\Equipments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hotel;
//use App\Estado;
use DB;
use Carbon\Carbon;

class GroupEquipmentController extends Controller
{
  /**
   * Show the application group equipment
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $grupos = DB::table('listar_grupos')->get();
    $hotels = Hotel::select('id', 'Nombre_hotel')->get();
    //$estados = Estado::select('id', 'Nombre_estado')->get();
    $estados = DB::table('estados')->select('id', 'Nombre_estado')->get();
    return view('permitted.equipment.group_equipment', compact('grupos', 'hotels', 'estados'));
  }

  public function update_group(Request $request)
  {
    $operacion = 0;
    $group_selected = $request->select1;
    $mac_input = $request->mac;
    $id_equipo = DB::select('CALL recover_id_device(?)', array($mac_input));
    //test mac 2C:5D:93:3A:1F:E0 grupo real: Antenas retiradas del Nivel 12, 10 y 9 de Seadust

    //2C:5D:93:3A:1F:E0 - Hotel Seadust.
    // CALL A verify_group_exist.

    //insercion si existe...
    $res = DB::select('CALL verify_group_exist(?, ?)', array($mac_input, $group_selected));

    // if ($res[0]->valor === 1) {
    //   return (string)$operacion = 1;
    // }else{
    //   return (string)$operacion;
    // }
    // $res = DB::table('devices_groups')->insert([
    //   ['id_equipo' => $id_equipo],
    //   ['id_grupo' => $group_selected],
    //   ['updated_at' => \Carbon\Carbon::now()]
    // ]);

    return $res;
  }

  public function test(Request $request)
  {
    $collection = DB::select('CALL get_device_venue_with_group(?)', array(598));

    if ($collection != []) {
      $count = count($collection);
      dd($collection);
    }else{
      return 'VACIO';
    }

  }

  public function update_move_group(Request $request)
  {
    $operacion = 0;
    $group = $request->group;

    $hotel = $request->hotel;
    $status = $request->status;
    //get_device_venue_with_group.

    $collection = DB::select('CALL get_device_venue_with_group(?)', array($group));

    $count = count($collection);

    if ($collection != []) {

      for ($i=0; $i < $count; $i++) {
        DB::table('equipos')->where('id', $collection[$i]->id_device)->update(
          [
            'estados_id' => $status,
            'hotel_id' => $hotel
          ]
        );

      }
      return (string)$operacion = 1;

    }else{
      return (string)$operacion;
    }


    return (string)$operacion;
  }

  public function table_group(Request $request)
  {
    $group_selected = $request->select1;
    $res = DB::select('CALL get_devices_group(?)', array($group_selected));
    return json_encode($res);
  }

  public function update_select(Request $request)
  {
    $grupos = DB::table('listar_grupos')->get();
    return json_encode($grupos);
  }

  public function insertNewGroup(Request $request)
  {
    $grouptext = $request->text;
    $res = DB::table('groups')->insert(['name' => $grouptext, 'updated' => \Carbon\Carbon::now()]);
    return (string)$res;
  }

}
