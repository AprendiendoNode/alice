<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Hotel;
use App\Cadena;
use App\Reference;
class Concatenated extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user_id = Auth::user()->id;
      if (auth()->user()->hasanyrole('SuperAdmin|Admin')) {
        $cadena = Cadena::select('id', 'name')->get();
        error_log($cadena);
      }
      else {
        $cadena = DB::select('CALL GetAllCadenaActiveByUserv2 (?)', array($user_id));
      }
      return view('permitted.report.view_reports_cont',compact('cadena'));

    }

    public function table_gb(Request $request)
  {
    $hotel = $request->data_one;
    $date = $request->data_two;

    $datemonthyear =  explode('-', $date);
    $dateyear= (int)$datemonthyear[0];
    $datemonth= (int)$datemonthyear[1];
    $datefull = $dateyear . '-' . $datemonth . '-01';

    $result1 = DB::select('CALL  summary_chain_gb (?, ?)', array($datefull,$hotel));

    return json_encode($result1);
  }

  public function table_user(Request $request)
  {
    $hotel = $request->data_one;
    $date = $request->data_two;

    $datemonthyear =  explode('-', $date);
    $dateyear= (int)$datemonthyear[0];
    $datemonth= (int)$datemonthyear[1];
    $datefull = $dateyear . '-' . $datemonth . '-01';

    $result1 = DB::select('CALL summary_chain_user (?, ?)', array($datefull,$hotel));

    return json_encode($result1);
  }
  public function table_device(Request $request)
  {
    $hotel = $request->data_one;
    $date = $request->data_two;

    $datemonthyear =  explode('-', $date);
    $dateyear= (int)$datemonthyear[0];
    $datemonth= (int)$datemonthyear[1];
    $datefull = $dateyear . '-' . $datemonth . '-01';

    $result1 = DB::select('CALL summary_chain_devices (?, ?)', array($datefull,$hotel));

    return json_encode($result1);
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
