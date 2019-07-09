<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Cadena;
use App\Hotel;
use App\Reference;
class ProjectController extends Controller
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
        $cadena= DB::table('cadenas')->select('id','name')->where('filter', 1)->whereNull('deleted_at')->orderBy('name','ASC')->get();
      }
      else {
        $cadena = DB::select('CALL GetAllCadenaActiveByUserv2 (?)', array($user_id));
      }
      return view('permitted.inventory.det_project',compact('cadena'));
    }


      public function test()
      {
        $result1 = DB::select('CALL GetHeader_Proyect (?)', array(10));
        $result2 = DB::select('CALL GetStatusAP_Proyect (?)', array(10));
        $result3 = DB::select('CALL GetStatusSW_Proyect (?)', array(10));
        $result4 = DB::select('CALL GetStatusAll_Disp_Proyect (?)', array(10));
        $result5 = DB::select('CALL GetStatusAll_Disp_Model_Proyect (?)', array(10));
        $result6 = DB::select('CALL GetStatusAll_Proyect_Table (?, ?)', array(10 ,1));
        $result7 = DB::select('CALL Get_Status_Proyect (?)', array(10));

        dd($result6);
      }

      public function getHeaderProject(Request $request)
      {
        $hotel = $request->data_one;
        $result = DB::select('CALL GetHeader_Proyect (?)', array($hotel));

        return json_encode($result);
      }

      public function getStatusProject(Request $request)
      {
        $cadena = $request->numero;
        $result = DB::select('CALL Get_Status_Proyect (?)', array($cadena));

        return json_encode($result);
      }

      public function getGraphAPS(Request $request)
      {
        $hotel = $request->data_one;
        if (auth()->user()->hasanyrole('SuperAdmin')) {
          $result = DB::select('CALL GetStatusAP_Proyect (?)', array($hotel));
        }
        else{
          $result = DB::select('CALL GetStatusAP_Proyect2 (?)', array($hotel));
        }
        return json_encode($result);
      }

      public function getGraphSWS(Request $request)
      {
        $hotel = $request->data_one;
        if (auth()->user()->hasanyrole('SuperAdmin')) {
          $result = DB::select('CALL GetStatusSW_Proyect (?)', array($hotel));
        }
        else{
          $result = DB::select('CALL GetStatusSW_Proyect2 (?)', array($hotel));
        }
        return json_encode($result);
      }

      public function getDispProject(Request $request)
      {
        $hotel = $request->data_one;
        if (auth()->user()->hasanyrole('SuperAdmin')) {
          $result = DB::select('CALL GetStatusAll_Disp_Proyect (?)', array($hotel));
        }
        else{
          $result = DB::select('CALL GetStatusAll_Disp_Proyect2 (?)', array($hotel));
        }
        return json_encode($result);
      }

      public function getModelProject(Request $request)
      {
        $hotel = $request->data_one;
        if (auth()->user()->hasanyrole('SuperAdmin')) {
          $result = DB::select('CALL GetStatusAll_Disp_Model_Proyect (?)', array($hotel));
        }
        else{
          $result = DB::select('CALL GetStatusAll_Disp_Model_Proyect2 (?)', array($hotel));
        }
        return json_encode($result);
      }

      public function getProjectTable(Request $request)
      {
        $cadena = $request->cadena;
        $stat = $request->status;

        $result = DB::select('CALL GetStatusAll_Proyect_Table (?, ?)', array($cadena , $stat));

        return json_encode($result);
      }
      public function getProjectTableGen(Request $request)
      {
        $cadena = $request->cadena;
        $result = DB::select('CALL GetStatusAll_Proyect_Table_all (?)', array($cadena));
        return json_encode($result);
      }

}
