<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
class DashboardSurveyController extends Controller
{
  public function index()
  {
      $encuestas= DB::table('surveydinamics')->select('id', 'name')->get();
      $hoteles= DB::table('hotels')->select('id', 'Nombre_hotel')->orderBy('Nombre_hotel', 'ASC')->get();
      return view('permitted.survey.dashboard', compact('encuestas', 'hoteles'));
  }
}
