<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\Workstation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
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
    public function edit(Request $request)
    {
      $identificador= $request->value;
      $resultados = DB::select('CALL GetWorkstationById (?)', array($identificador));
      foreach ($resultados as $key) {
        $key->id = Crypt::encryptString($key->id);
      }

      return $resultados;
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
        $id = Crypt::decryptString($request->token_b);
        $workstation = Workstation::findOrFail($id);
        $workstation->name = $request->inputEditName;
        $workstation->updated_at = \Carbon\Carbon::now();
        $workstation->save();

        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Workstation  $workstation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $id = $request->id;
      $workstation = Workstation::findOrFail($id);
      $workstation->delete();

      return response()->json(['status' => 200]);
    }

    public function edit_user(Request $request)
    {
      $result = DB::table('user_workstation')
                ->select('id', 'user_id', 'workstation_id', 'start_activities')
                ->where('id', '=', $request->value)->get();

      return response()->json([
        'id' => $result[0]->id,
        'workstation_id' => $result[0]->workstation_id,
        'start_activities' => $result[0]->start_activities,
        'user_id' => $result[0]->user_id
      ]);
    }

    public function update_user(Request $request)
    {
      $result = DB::table('user_workstation')
                    ->where('id', '=', $request->token_e)
                    ->update([
                      'user_id' => $request->selectuserpositionEdit,
                      'workstation_id' => $request->selectpositionEdit,
                      'start_activities' => $request->inputdatepositionEdit,
                      'updated_at' => \Carbon\Carbon::now()
                    ]);

      return response()->json(['status' => 200]);
    }

    public function destroy_user(Request $request)
    {
      $id = $request->id;

      DB::table('user_workstation')->where('id', '=', $id)->delete();

      return response()->json(['status' => 200]);
    }



}
