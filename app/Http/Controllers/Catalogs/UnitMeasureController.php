<?php

namespace App\Http\Controllers\Catalogs;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Catalogs\UnitMeasure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitMeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('permitted.catalogs.unit_measures');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $user_id= Auth::user()->id;
         $code= $request->inputCreatCode;
         $name= $request->inputCreatName;
        $orden= $request->inputCreatOrden;
       $status= !empty($request->status) ? 1 : 0;

       $result = DB::table('unit_measures')
                 ->select('code')
                 ->where([
                     ['code', '=', $code],
                   ])->count();
       if($result == 0)
       {
         $newId = DB::table('unit_measures')
         ->insertGetId(['code' => $code,
                        'name' => $name,
                  'sort_order' => $orden,
                      'status' => $status,
                 'created_uid' => $user_id,
                  'created_at' => \Carbon\Carbon::now()]);
         if(empty($newId)){
             return 'abort'; // returns 0
         }
         else{
             return $newId; // returns id
         }
       }
       else
       {
         return 'false';//Ya esta asociado
       }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $resultados = UnitMeasure::select('id','name', 'code', 'decimal_place', 'sort_order','status')->get();
      return json_encode($resultados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
