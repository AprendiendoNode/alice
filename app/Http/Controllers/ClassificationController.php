<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Hotel;
use App\Cadena;
use App\Workstation;
use App\Department;
use Carbon\Carbon;
class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $input_domain = 'sitwifi.com';
      $user = DB::select('CALL get_domain_user (?)', array($input_domain));//Pending: Update PROCEDURE to whereNull deleted_at of table user
      $workstations = Workstation::select('id','name')->get();
      $departments = Department::select('id','name')->get();
      $cadena = Cadena::select('id','name')->get();
      $hotel= DB::table('hotels')->select('id','Nombre_hotel')->whereNull('deleted_at')->get();
      return view('permitted.classification.classification',compact('user', 'workstations','departments','cadena','hotel'));
    }

    public function create_master(Request $request)
    {
      $cadena_id = $request->selectcadena;
      $user_id = $request->selectusermaster;

      $result = DB::table('cadena_user')
                ->select('user_id','cadena_id')
                ->where([
                    ['active', '=',true],
                    ['cadena_id', '=', $cadena_id]
                  ])->count();
      if($result == 0)
      {
        $newId = DB::table('cadena_user')
        ->insertGetId(['user_id' => $user_id,
                  'cadena_id' => $cadena_id,
                  'active' => true,
                  'created_at' => \Carbon\Carbon::now()]);
        if(empty($newId)){
            return 'abort'; // returns 0
        }
        else{
            return $newId; // returns id category
        }
      }
      else
      {
        return 'false';//El hotel ya tiene la misma encuesta asociada
      }

    }
    public function show_master(Request $request)
    {
      $result = DB::select('CALL GetCadenaUserv2 ()', array());
      return json_encode($result);
    }
    public function create_junior(Request $request)
    {
      $hotel_id = $request->selecthotel;
      $user_id = $request->selectuserjunior;

      $result = DB::table('hotel_user')
                ->select('user_id','hotel_id')
                ->where([
                    ['user_id', '=', $user_id],
                    ['hotel_id', '=', $hotel_id]
                  ])->count();
      if($result == 0)
      {
        $newId = DB::table('hotel_user')
        ->insertGetId(['user_id' => $user_id,
                  'hotel_id' => $hotel_id,
                  'active' => true,
                  'created_at' => \Carbon\Carbon::now()]);
        if(empty($newId)){
            return 'abort'; // returns 0
        }
        else{
            return $newId; // returns id category
        }
      }
      else
      {
        return 'false';//El hotel ya tiene la misma encuesta asociada
      }
    }
    public function show_junior(Request $request)
    {
      $result = DB::select('CALL GetHotelUserv2 ()', array());
      return json_encode($result);
    }





}
