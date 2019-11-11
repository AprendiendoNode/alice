<?php

namespace App\Http\Controllers\Viatics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;
use Auth;
use DB;
class DashboardViaticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('permitted.viaticos.dashboard_viaticos');
    }

    public function info(Request $request)
    {
      $user = Auth::user()->id;
      $result = array();
      $input_date_i= $request->get('date_to_search');
      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
      }
      else {
        $date_current = date('Y-m');
        $date = $date_current.'-01';
      }

      if (auth()->user()->can('Travel allowance notification')) {
          $result = DB::select('CALL dashboardviaticos (?,?)', array($user, $date));
          return json_encode($result);
      }
      return json_encode($result);
    }
    public function index_gen()
    {
      return view('permitted.viaticos.dashboard_viaticos_gen');
    }
    public function info_gen(Request $request)
    {
      $user = Auth::user()->id;
      $result = array();
      $input_date_i= $request->get('date_to_search');
      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
      }
      else {
        $date_current = date('Y-m');
        $date = $date_current.'-01';
      }

      $result = DB::select('CALL px_dashboardviaticos_all (?)', array($date));
      return json_encode($result);
    }
    public function info_gen_sol(Request $request)
    {
      $user = Auth::user()->id;
      $result = array();
      $input_date_i= $request->get('date_to_search');
      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
      }
      else {
        $date_current = date('Y-m');
        $date = $date_current.'-01';
      }

      $result = DB::select('CALL px_dashboardviaticos_depto_all(?)', array($date));
      return json_encode($result);
    }
    public function info_gen_montos(Request $request)
    {
      $user = Auth::user()->id;
      $result = array();
      $input_date_i= $request->get('date_to_search');
      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
      }
      else {
        $date_current = date('Y-m');
        $date = $date_current.'-01';
      }

      $result = DB::select('CALL px_dashboardviaticos_concep_all(?)', array($date));
      return json_encode($result);
    }
}
