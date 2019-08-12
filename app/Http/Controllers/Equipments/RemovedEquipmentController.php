<?php

namespace App\Http\Controllers\Equipments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hotel;
use DB;
use Auth;
use Carbon\Carbon;
use App\Mail\ConfirmacionBajaEquipo;
use Mail;

class RemovedEquipmentController extends Controller
{
  /**
   * Show the application removed equipment
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $hotels = Hotel::select('id', 'Nombre_hotel')->get();
    return view('permitted.equipment.removed_equipment',compact('hotels'));
  }

  public function show(Request $request)
  {
    $hotel = $request->ident;
    $result = DB::select('CALL detail_device_venue(?)', array($hotel));
    return json_encode($result);
  }

  public function show2(Request $request)
  {
    $macs = $request->ident1; //Recibo el arreglo de macs
    $series = $request->ident2; //Recibo el arreglo de series
    $result = "";
    if($macs != null) {
      for($i = 0 ; $i < count($macs) ; $i++) { //Formateo cada mac correctamente
        if(strlen($macs[$i]) < 17) { //Si la mac no está bien formateada
          $macs[$i] = $macs[$i][0].$macs[$i][1].":".$macs[$i][2].$macs[$i][3].":".$macs[$i][4].$macs[$i][5].":".$macs[$i][6].$macs[$i][7].":".$macs[$i][8].$macs[$i][9].":".$macs[$i][10].$macs[$i][11];
        }
      }
      $macs2 = implode( ",", $macs); //Convierto el arreglo en una cadena de texto
      $result = DB::select('CALL px_detail_device_macs(?, ?)', array($macs2, count($macs)));
    } else {
      $series2 = implode( ",", $series); //Convierto el arreglo en una cadena de texto
      $result = DB::select('CALL px_detail_device_series(?, ?)', array($series2, count($series)));
    }
    return json_encode($result);
  }

  public function edit(Request $request)
  {
    $equipos = json_decode($request->idents);
    $name_user = Auth::user()->name;
    $data_equipos = [];
    $parametros1 = [];

    $valor= 'false';
    for ($i=0; $i <= (count($equipos)-1); $i++)
    {
      $sql = DB::table('equipos')->where('id', '=', $equipos[$i])->update(['estados_id' => '2', 'Fecha_Baja' => date('Y-m-d'), 'updated_at' => Carbon::now()]);
      $result = DB::table('equipos')->select('MAC','Serie', 'Fecha_Registro', 'Fecha_Baja', 'modelos_id','especificacions_id', 'hotel_id')
                                    ->where('id', $equipos[$i])->get();

      $nombreModelo = DB::table('modelos')->select('ModeloNombre')->where('id', $result[0]->modelos_id)->get();
      $nombre_sitio = DB::table('hotels')->select('Nombre_hotel')->where('id', $result[0]->hotel_id)->get();
      $especificacion = DB::table('especificacions')->select('name')->where('id', $result[0]->especificacions_id)->get();


      array_push($data_equipos,['cliente' => $nombre_sitio[0]->Nombre_hotel,
                                'equipo' => $especificacion[0]->name,
                                'mac' => $result[0]->MAC,
                                'serie' => $result[0]->Serie,
                                'modelo' => $nombreModelo[0]->ModeloNombre,
                                'fecha_alta' => $result[0]->Fecha_Registro,
                                'fecha_baja' => $result[0]->Fecha_Baja
                              ]);

    }

    $parametros1 = [
      'User' => $name_user
    ];

    $valor= 'true';

      Mail::to('aperez@sitwifi.com', 'marthaisabel@sitwifi.com')->send(new ConfirmacionBajaEquipo($parametros1, $data_equipos));


    return $valor;
  }

}
