<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Hotel;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class Capture extends Controller
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
        $hotels= DB::table('hotels')->select('id','Nombre_hotel')->where('filter', 1)->whereNull('deleted_at')->get();
      }
      else {
        $hotels = DB::select('CALL GetAllCadenaActiveByUserv2 (?)', array($user_id));
      }
      return view('permitted.report.individual',compact('hotels'));
    }
    public function get_zd_hotel(Request $request)
    {
      $select = $request->select;
      $res = DB::select('CALL get_zd_venue(?)', array($select));
      return $res;
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
