<?php

namespace App\Http\Controllers\Viatics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Carbon\Carbon;
use App\User; //Importar el modelo eloquent
use App\Cadena;
use App\Jefedirecto;
use App\Hotel;

use App\Models\Viatics\Viatic_service;
//use App\Models\Viatics\Vitic_beneficiary;
use App\Models\Viatics\Viatic_state;
use App\Models\Viatics\Viatic_list_concept;
use App\Models\Viatics\Viatic;
use App\Models\Viatics\Concept;
use App\Models\Viatics\viatic_user_status;
use App\Models\Viatics\Viatic_state_concept;


class ViaticWeeklyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $services = DB::table('viatic_services')->select('id', 'name')->get();
      $cadenas = DB::table('cadenas')->select('id', 'name')->orderBy('name')->get();
      $sitios = DB::table('hotels')->select('id', 'Nombre_hotel')->orderBy('Nombre_hotel')->get();
      $users = DB::table('users')->select('id', 'name')->orderBy('name')->get();
      return view('permitted.viaticos.weekly_viatic', compact('services', 'cadenas', 'sitios', 'users'));
    }
    public function viatic_historic_weekly(Request $request)
{   info($request);
  $input1 = $request->startDate;
  $input2 = $request->endDate;
  $filterOption = $request->filterOption;
  $id = $request->id;

    $fecha_inicio = $input1;
    $fecha_fin = $input2;

    if ($input1 < $input2) {
        $fecha_inicio = $input1;
        $fecha_fin = $input2;
    }else{
        $fecha_inicio = $input2;
        $fecha_fin = $input1;
    }

    $result = DB::select('CALL history_viatic_weekly(?, ?, ?, ?)', array($fecha_inicio, $fecha_fin, $filterOption, $id));

    return json_encode($result);


}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show($id)
    {
        //
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
