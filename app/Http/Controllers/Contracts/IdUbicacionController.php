<?php

namespace App\Http\Controllers\Contracts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use App\Cadena;
use App\Vertical;
use App\Servicio;
use Carbon\Carbon;

class IdUbicacionController extends Controller
{
  public function index()
  {
    $verticals = Vertical::select('id', 'name')->get();
    $servicios = Servicio::select('id', 'Nombre_servicio')->get();
    $cadenas = Cadena::select('id', 'name')->orderBy('name','ASC')->get();
    return view('permitted.location.loc_create_idubic', compact('verticals','cadenas', 'servicios'));
  }

  public function find_new_idubication(Request $request)
  {
    $value= $request->valor;
    $result = DB::select('CALL px_cadena_key_sig (?)', array($value));
    return json_encode($result);
  }
  public function search_info_site_idubicacion(Request $request)
  {
    $value= $request->valor;
    $result = DB::select('CALL px_sitio_datos (?)', array($value));
    return json_encode($result);
  }

  public function cont_create_newidubic(Request $request)
  {
    $name= $request->hotel_name;
    $address= $request->hotel_address;
    $telephone= $request->hotel_telephone;
    $id_grupo= $request->sel_master_grupo;

    if (isset($request->id_generate)) {
      $id_generado = $request->id_generate;
    }
    else{
      $id_generado = '';
    }

    if (isset($request->hotel_street)) {
      $data_street = $request->hotel_street;
    }
    else{
      $data_street = '';
    }

    if (isset($request->hotel_noext)) {
      $datanoext = $request->hotel_noext;
    }
    else{
      $datanoext = '';
    }

    if (isset($request->hotel_noint)) {
      $datanoint = $request->hotel_noint;
    }
    else{
      $datanoint = '';
    }

    if (isset($request->hotel_cp)) {
      $datacp = $request->hotel_cp;
    }
    else{
      $datacp = '';
    }

    $latitud= $request->latitud;
    $longitud= $request->longitud;

    $result_sql = DB::select('CALL px_sitiosXcadena_cant (?)', array($id_grupo));
    $result = ($result_sql[0]->cantidad) + 1;

    $newId = DB::table('hotels')->insertGetId(
      [ 'Nombre_hotel' => $name,
        'Direccion' => $address,
        'Telefono' => $telephone,
        'dirlogo1' => 'Default.svg',
        'cadena_id' => $id_grupo,
        'Latitude' => $latitud,
        'Longitude' => $longitud,
        'key' => $result,
        'id_ubicacion' => $id_generado,
        'calle' => $data_street,
        'num_ext' => $datanoext,
        'num_int' => $datanoint,
        'codigopostal' => $datacp,
        'servicios_id' => $request->sel_service,
        'vertical_id' => $request->sel_vertical,
        'created_at' => \Carbon\Carbon::now()
      ]
    );
    if(empty($newId)){
      return '0'; // returns 1
    }
    else{
      return $newId; // returns 1
    }
  }


  public function cont_edit_idubic(Request $request)
  {
    $id_cadena= $request->sel_edit_cadena;
    $id_sitio= $request->sel_edit_sitio;

    $name= $request->edit_hotel_name;
    $address= $request->edit_hotel_address;
    $telephone= $request->edit_hotel_telephone;
    $id_grupo= $request->sel_master_grupo;

    $dig_cadena= $request->key_edit_cadena;
    $dig_sitio= $request->key_edit_sitio;

    $latitud= $request->latitud;
    $longitud= $request->longitud;

    if (isset($request->edit_hotel_street)) {
      $data_street = $request->edit_hotel_street;
    }
    else{
      $data_street = '';
    }

    if (isset($request->edit_hotel_noext)) {
      $datanoext = $request->edit_hotel_noext;
    }
    else{
      $datanoext = '';
    }

    if (isset($request->edit_hotel_noint)) {
      $datanoint = $request->edit_hotel_noint;
    }
    else{
      $datanoint = '';
    }

    if (isset($request->edit_hotel_cp)) {
      $datacp = $request->edit_hotel_cp;
    }
    else{
      $datacp = '';
    }


    $newId=DB::table('hotels')
            ->where('id', $id_sitio)
            ->update([
              'Nombre_hotel' => $name,
              'Direccion' => $address,
              'Telefono' => $telephone,
              'key' => $dig_sitio,
              'id_ubicacion' => $dig_cadena.'-'.$dig_sitio,
              'calle' => $data_street,
              'Latitude' => $latitud,
              'Longitude' => $longitud,
              'num_ext' => $datanoext,
              'num_int' => $datanoint,
              'codigopostal' => $datacp,
              'servicios_id' => $request->sel_service_edit,
              'vertical_id' => $request->sel_vertical_edit,
              'updated_at' => \Carbon\Carbon::now()
            ]);

      return $newId; // returns 1 se cambio
                     // returns 0 no se cambio
  }

}
