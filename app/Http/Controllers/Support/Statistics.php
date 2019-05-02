<?php

namespace App\Http\Controllers\Support;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Statistics extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
       return view('permitted.service.zendesk_statistics');
     }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $value= $request->datepickerMonthticket;
      $date_current=$value.'-01';
      $result = DB::connection('zendesk')->select('CALL px_ticketsXstatusXitc(?)', array($date_current));
      return json_encode($result);
    }
}
