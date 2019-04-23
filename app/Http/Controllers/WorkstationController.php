<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\Workstation;
use Illuminate\Http\Request;
use Carbon\Carbon;
class WorkstationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $get_name = $request->inputnameposition;
      $newId = DB::table('workstations')->insertGetId([
      'name' => $get_name,
      'created_at' => \Carbon\Carbon::now() ]);
      if(empty($newId)){
         return 'abort'; // returns 0
      }
      else{
         return $newId; // returns id category
      }
    }
    public function create_user(Request $request)
    {
      $workstation_id = $request->selectposition;
      $user_id = $request->selectuserposition;
      $date = $request->inputdateposition;

      $result = DB::table('user_workstation')
                ->select('user_id','workstation_id')
                ->where([
                    ['active', '=',true],
                    ['workstation_id', '=', $workstation_id]
                  ])->count();
      if($result == 0)
      {
        $newId = DB::table('user_workstation')
        ->insertGetId(['user_id' => $user_id,
                  'workstation_id' => $workstation_id,
                  'start_activities' => $date,
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
        return 'false';//El puesto ya tiene usuario asignado
      }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Workstation  $workstation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $resultados = Workstation::select('id','name', 'deleted_at')->get();
      return json_encode($resultados);
    }
    public function show_user(Request $request)
    {
      $resultados = DB::select('CALL GetWorkstationUserv2 ()', array());
      return json_encode($resultados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Workstation  $workstation
     * @return \Illuminate\Http\Response
     */
    public function edit(Workstation $workstation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Workstation  $workstation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workstation $workstation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Workstation  $workstation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workstation $workstation)
    {
        //
    }
}
