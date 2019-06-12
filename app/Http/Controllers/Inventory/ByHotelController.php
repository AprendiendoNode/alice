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

  public function getHeaders(Request $request)
  {
    $hotel = $request->data_two;
    $result = DB::select('CALL GetHeader_Venue (?)', array($hotel));

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


}
