<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Cadena;
use App\Hotel;
use App\Reference;
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user_id = Auth::user()->id;

      if (auth()->user()->hasanyrole('SuperAdmin')) {
        $cadena = Cadena::select('id', 'name')->get();
      }
      else if (auth()->user()->hasanyrole('Admin')) {
        $cadena= DB::table('cadenas')->select('id','name')->where('filter', 1)->whereNull('deleted_at')->orderBy('name','ASC')->get();
      }
      else {
        $cadena = DB::select('CALL GetAllCadenaActiveByUserv2 (?)', array($user_id));
      }
      return view('permitted.inventory.det_project',compact('cadena'));
    }



}
