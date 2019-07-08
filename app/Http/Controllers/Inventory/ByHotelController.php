<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Cadena;
use App\Reference;
use App\Hotel;

class ByHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
       $user_id = Auth::user()->id;

       if (auth()->user()->hasanyrole('SuperAdmin')) {
         $cadena = Cadena::select('id', 'name')->get();
       }
       else if (auth()->user()->hasanyrole('Admin')) {
         $cadena= DB::table('cadenas')->select('id','name')->where('filter', 1)->whereNull('deleted_at')->get();
       }
       else {
         $cadena = DB::select('CALL GetAllCadenaActiveByUserv2 (?)', array($user_id));
       }
       return view('permitted.inventory.det_hotel',compact('cadena'));
     }

       public function hotel_cadena(Request $request)
  {
    $value= $request->numero;
    //$cadena = 44;
    $hoteles = Hotel::where('cadena_id', $value)->get();

    return $hoteles;
    //dd($hoteles);

  }

  public function acm1pt()
  {

    $result1 = DB::select('CALL GetStatusAP_Venue (?)', array(9));
    $result2 = DB::select('CALL GetStatusSW_Venue (?)', array(9));
    $result3 = DB::select('CALL GetStatusZD_Venue (?)', array(9));
    //Call para tabla
    $result4 = DB::select('CALL GetDetail_Disp_Venue(?)', array(9));
    //Modelos y unidades
    $result5 = DB::select('CALL GetStatusAll_Disp_Model_Venue (?)', array(9));
    //Equipos status para Graph Pie
    $result6 = DB::select('CALL GetStatusAll_Disp_Status_Venue(?)', array(9));
    // Distribucion 1er barra
    $result7 = DB::select('CALL GetStatusAll_Disp_Venue (?)', array(9));
    // Header
    $result8 = DB::select('CALL GetHeader_Venue (?)', array(9));

    dd($result8);

  }

  public function getHeader(Request $request)
  {
    $hotel = $request->data_one;
    $result = DB::select('CALL delivery_letter_venue_header (?)', array($hotel));

    return json_encode($result);
  }

  public function getSummary(Request $request)
  {
    $hotel = $request->data_two;
    if (auth()->user()->hasanyrole('SuperAdmin')) {
      $result = DB::select('CALL GetStatusAP_Venue (?)', array($hotel));
    }
    else{
      $result = DB::select('CALL GetStatusAP_Venue2 (?)', array($hotel));
    }
    return json_encode($result);
  }

  public function getSwitch(Request $request)
  {
    $hotel = $request->data_two;
    if (auth()->user()->hasanyrole('SuperAdmin')) {
      $result = DB::select('CALL GetStatusSW_Venue (?)', array($hotel));
    }
    else{
      $result = DB::select('CALL GetStatusSW_Venue2 (?)', array($hotel));
    }
    return json_encode($result);
  }

  public function getZone(Request $request)
  {
    $hotel = $request->data_two;
    if (auth()->user()->hasanyrole('SuperAdmin')) {
      $result = DB::select('CALL GetStatusZD_Venue (?)', array($hotel));
    }
    else{
      $result = DB::select('CALL GetStatusZD_Venue2 (?)', array($hotel));
    }
    return json_encode($result);

  }

  public function getSummaryPie(Request $request)
  {
    $hotel = $request->data_two;
    if (auth()->user()->hasanyrole('SuperAdmin')) {
      $result = DB::select('CALL GetStatusAll_Disp_Status_Venue(?)', array($hotel));
    }
    else{
      $result = DB::select('CALL GetStatusAll_Disp_Status_Venue2(?)', array($hotel));
    }
    return json_encode($result);
  }

  //Quantitys
  public function getDristributionQuantitys(Request $request)
  {
    $hotel = $request->data_two;
    if (auth()->user()->hasanyrole('SuperAdmin')) {
      $result = DB::select('CALL GetStatusAll_Disp_Venue (?)', array($hotel));
    }
    else{
      $result = DB::select('CALL GetStatusAll_Disp_Venue2 (?)', array($hotel));
    }
    return json_encode($result);

  }

  public function getEquipmentModels(Request $request)
  {
    $hotel = $request->data_two;
    if (auth()->user()->hasanyrole('SuperAdmin')) {
      $result = DB::select('CALL GetStatusAll_Disp_Model_Venue (?)', array($hotel));
    }
    else{
      $result = DB::select('CALL GetStatusAll_Disp_Model_Venue2 (?)', array($hotel));
    }
    return json_encode($result);

  }

  public function getDetailedEquipment(Request $request)
  {
    $hotel = $request->data_two;
    if (auth()->user()->hasanyrole('SuperAdmin')) {
      $result = DB::select('CALL GetDetail_Disp_Venue (?)', array($hotel));
    }
    else{
      $result = DB::select('CALL GetDetail_Disp_Venue2 (?)', array($hotel));
    }
    return json_encode($result);
  }

  public function update_reference_by_cover(Request $request)
  {
    $hotel = $request->id_site;
    $name = $request->update_cliente_responsable;


    $pregunta = DB::select('CALL px_reference_hotel_existe (?)', array($hotel));
    if ($pregunta[0]->existe == '0') {

      if (isset($request->update_cliente_tel)) {  $client_telf = $request->update_cliente_tel;  }
      else{ $client_telf = '';  }

      if (isset($request->update_cliente_email)) {  $client_email = $request->update_cliente_email;  }
      else{ $client_email = '';  }

      $crear_referencia = DB::table('references')
      ->insertGetId(['responsable' => $name,
                     'telefono' => $client_telf,
                     'correo' => $client_email,
                     'created_at' =>  \Carbon\Carbon::now()
                    ]);
      if($crear_referencia != '0'){
        $pivot_new = DB::table('reference_hotel')
        ->insertGetId([
          'hotel_id' => $hotel,
          'reference_id' => $crear_referencia,
          'created_at' => \Carbon\Carbon::now(),
        ]);
        return $pivot_new;
      }
      else {
        return 0;
      }
    }
    else {
      $id_reference = DB::table('reference_hotel')
                      ->select('reference_id')
                      ->where('hotel_id', '=', $hotel)
                      ->value('reference_id');

      if (isset($request->update_cliente_tel)) {
            $client_telf = $request->update_cliente_tel;
            $ver_client_telf = 'si';
      }
      else{ $ver_client_telf = 'no';  }

      if (isset($request->update_cliente_email)) {
            $client_email = $request->update_cliente_email;
            $ver_client_email = 'si';
      }
      else{  $ver_client_email = 'no'; }

      if ($ver_client_telf == 'si' & $ver_client_email == 'si') {
        // code...
        $sql_reference = DB::table('references')
                        ->where('id', $id_reference)
                        ->update(['responsable' => $name,
                                  'telefono' => $client_telf,
                                  'correo' => $client_email,
                                  'updated_at' =>  \Carbon\Carbon::now()]);
      }
      if ($ver_client_telf == 'no' & $ver_client_email == 'si') {
        // code...
        $sql_reference = DB::table('references')
                        ->where('id', $id_reference)
                        ->update(['responsable' => $name,
                                  'correo' => $client_email ,
                                  'updated_at' =>  \Carbon\Carbon::now()]);
      }
      if ($ver_client_telf == 'si' & $ver_client_email == 'no') {
        // code...
        $sql_reference = DB::table('references')
                        ->where('id', $id_reference)
                        ->update(['responsable' => $name,
                                  'telefono' => $client_telf,
                                  'updated_at' =>  \Carbon\Carbon::now()]);
      }
      if ($ver_client_telf == 'no' & $ver_client_email == 'no') {
        // code...
        $sql_reference = DB::table('references')
                        ->where('id', $id_reference)
                        ->update(['responsable' => $name,
                                  'updated_at' =>  \Carbon\Carbon::now()]);
      }

      return $sql_reference; // returns 1 se cambio
                             // returns 0 no se cambio
    }
  }

  public function getCoverDistEquipos(Request $request)
  {
    $hotel = $request->data_one;
    if (auth()->user()->hasanyrole('SuperAdmin')) {
      $result1 = DB::select('CALL delivery_letter_venue_disp (?)', array($hotel));
    }
    else{
      $result1 = DB::select('CALL delivery_letter_venue_disp2 (?)', array($hotel));
    }
    return json_encode($result1);
  }

  public function getCoverDistModelos(Request $request)
  {
    $hotel = $request->data_one;
    if (auth()->user()->hasanyrole('SuperAdmin')) {
      $result1 = DB::select('CALL delivery_letter_venue_models (?)', array($hotel));
    }
    else{
      $result1 = DB::select('CALL delivery_letter_venue_models2 (?)', array($hotel));
    }
    return json_encode($result1);
  }

}
