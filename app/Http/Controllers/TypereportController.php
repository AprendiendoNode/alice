<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Typereport;
use App\Cadena;
use App\Hotel;
use DB;
use Auth;
use Carbon\Carbon;
class TypereportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = DB::table('hotels')->select('id','Nombre_hotel')->where('filter', 1)->whereNull('deleted_at')->get();
        $types = Typereport::all();
        return view('permitted.report.assign_report',compact('hotels', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $hotels= $request->select_one;
      $type= $request->select_two;

      $count_md = DB::table('hotel_typereport')->where('hotel_id', $hotels)->where('typereport_id', $type)->count();
      if ($count_md == '0') {
        $newId = DB::table('hotel_typereport')
        ->insertGetId([
          'hotel_id' => $hotels,
          'typereport_id' => $type,
          'created_at' => \Carbon\Carbon::now() ]);
        if(empty($newId)){
          return '0'; // returns 1
        }
        else{
          return $newId; // returns 1
        }
      }
      else {
        return 'abort';
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
     * @param  \App\Typereport  $typereport
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
      $result = DB::select('CALL GetAllReportHotelv2 ()', array());
      return json_encode($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Typereport  $typereport
     * @return \Illuminate\Http\Response
     */
    public function edit(Typereport $typereport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Typereport  $typereport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Typereport $typereport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Typereport  $typereport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $id= $request->send;
      $result = DB::table('hotel_typereport')->where('id', '=', $id)->delete();
      return $result;
    }
}
