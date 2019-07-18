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


class RequestViaticAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $cadenas = Cadena::select('id', 'name')->get();
      $concepts = Viatic_list_concept::select('id', 'name')->get();
      return view('permitted.viaticos.history_request_month', compact('cadenas', 'concepts'));
    }
    public function history_all (Request $request) {
  $result = array();
  $input_date_i= $request->get('date_to_search');
  if ($input_date_i != '') {
    $date = $input_date_i.'-01';
  }
  else {
    $date_current = date('Y-m');
    $date = $date_current.'-01';
  }
  if (auth()->user()->can('View history all viatic')){ /*Le muestro todas las solicitudes al usuario*/
      $result = DB::select('CALL history_viatic_month_year (?)', array($date));
      $count = count($result);
      for($i = 0; $i < $count; $i++)
      {
        $solicitado = $result[$i]->solicitado;
        $solicitado_format = '$' . number_format($solicitado, 2, '.', ',') . ' MXN';

        $aprobado = $result[$i]->aprobado;
        $aprobado_format = '$' . number_format($aprobado, 2, '.', ',') . ' MXN';

        $result[$i]->solicitado = $solicitado_format;
        $result[$i]->aprobado = $aprobado_format;
      }

  }
  return json_encode($result);
}

public function timeline(Request $request){
  $input_date_i= $request->get('viatic');
  $result = DB::select('CALL viatic_user_statuses_all	 (?)', array($input_date_i));
  return json_encode($result);
}
public function totales(Request $request){
  $input_id= $request->get('viatic');
  $result = DB::select('CALL viatic_concepts_status	 (?)', array($input_id));
  $count = count($result);
  for($i = 0; $i < $count; $i++)
  {
    $total = $result[$i]->suma;
    $total_format = '$' . number_format($total, 2, '.', ',') . ' MXN';

    $result[$i]->suma = $total_format;

  }
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
