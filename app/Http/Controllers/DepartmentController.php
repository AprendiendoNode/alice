<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
class DepartmentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $get_name = $request->inputnamedepartament;
      $newId = DB::table('departments')->insertGetId([
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
      $departament_id = $request->selectdepartament;
      $user_id = $request->selectuserdepartament;

      $result = DB::table('department_user')
                ->select('user_id','department_id')
                ->where([
                    ['user_id', '=', $user_id],
                    ['department_id', '=', $departament_id]
                  ])->count();
      if($result == 0)
      {
        $newId = DB::table('department_user')
        ->insertGetId(['user_id' => $user_id,
                  'department_id' => $departament_id,
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
    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
     public function show(Request $request)
     {
       $resultados = Department::select('id','name', 'deleted_at')->get();
       return json_encode($resultados);
     }
     public function show_user(Request $request)
     {
       $resultados = DB::select('CALL GetDepartmentUserv2 ()', array());
       return json_encode($resultados);
     }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
      $id = $request->value;
      $department = Department::findOrFail($id);

      return $department;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
      $id = $request->token_c;
      $department = Department::findOrFail($id);
      $department->name = $request->inputEditNameDep;
      $department->updated_at = \Carbon\Carbon::now();
      $department->save();

      return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
     public function destroy_user(Request $request)
     {
       $id = $request->id;

       DB::table('department_user')->where('id', '=', $id)->delete();

       return response()->json(['status' => 200]);
     }

}
