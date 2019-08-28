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

  public function get_headers_survey(Request $request)
  {
    $id = $request->id;
    $date = $request->date;

    if($date == null || $date == ''){
      $date = date('Y-m');
      $date = $date . '-01';
    }else{
      $date = $date . '-01';
    }

    $result = DB::select('CALL px_survey_counts(?,?)', array($id, $date));

    return $result;
  }

  public function create_hotel_survey(Request $request)
  {
    $survey_id = $request->survey_id;
    $hotel_id = $request->hotel_id;


    $result = DB::table('hotel_surveydinamic')->select('survey_id','hotel_id')
                                              ->where([
                                                  ['survey_id', '=', $survey_id],
                                                  ['hotel_id', '=', $hotel_id]
                                                ])->count();

    if($result == 0){
      DB::table('hotel_surveydinamic')->insert(['survey_id' => $survey_id,
                                                'hotel_id' => $hotel_id,
                                                'created_at' => \Carbon\Carbon::now()]);
    return 1; //Ok

    }else{
      return 2;//El hotel ya tiene la misma encuesta asociada
    }

  }

  public function show_summary_info_nps (Request $request)
  {
    $input_date_i= $request->get('date_to_search');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';

    }
    $result = DB::select('CALL NPS_MONTH (?)', array($date));
    return json_encode($result);
  }
  public function compare_year (Request $request)
  {
    $input_date_i= $request->get('date_to_search');
    if ($input_date_i != '') {
      $dateyearmonth =  explode('-', $input_date_i);
      $yearA= $dateyearmonth[0];
      $yearB = $yearA-1;

    }
    else {
      $date_current = date('Y');
      $sub_year = strtotime ( '-1 year' , strtotime ( $date_current ) ) ;
      $sub_year = date ( 'Y' , $sub_year );

      $yearA = $date_current;
      $yearB = $sub_year;

    }
    $result = DB::select('CALL NPS_YEAR  (?, ?)', array($yearA, $yearB));
    return json_encode($result);
  }
  public function percent_graph_nps (Request $request)
  {
    $input_date_i= $request->get('date_to_search');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';

    }
    $result = DB::select('CALL NPS_MONTH_GRAPH (?)', array($date));
    return json_encode($result);
  }
  public function cant_graph_ppd(Request $request)
  {
    $input_date_i= $request->get('date_to_search');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL PERCENT_MONTH (?)', array($date));
    return json_encode($result);
  }
  public function cant_graph_week(Request $request)
  {
    $input_date_i= $request->get('date_to_search');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL NPS_semanas (?)', array($date));
    return json_encode($result);
  }
  public function graph_uvsr(Request $request)
  {
    $input_date_i= $request->get('date_to_search');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL NPS_VS_REQUEST (?)', array($date));
    return json_encode($result);
  }
  public function graph_avgcal(Request $request)
  {
    $input_date_i= $request->get('date_to_search');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL AVG_YEAR_CALIFI_GRAPH (?)', array($date));
    return json_encode($result);
  }
  public function table_vert(Request $request)
  {
    $input_date_i= $request->get('date_to_search');
    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL NPS_Vertical (?)', array($date));
    return json_encode($result);
  }
  public function table_comments_nps(Request $request)
  {
    $input_date_i= $request->get('date_to_search');

    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL comments_table_nps (?,?)', array($date, 1));
    return json_encode($result);
  }

  public function table_commentsNPS_full(Request $request)
  {
    $input_date_i= $request->get('date_to_search');

    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL NPS_Comments (?)', array($date));
    return json_encode($result);

  }
  public function table_results_full(Request $request)
  {
    $input_date_i= $request->get('date_to_search');

    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL get_results_nps_full (?)', array($date));
    return json_encode($result);
  }
  public function box_total(Request $request)
  {
    $input_date_i= $request->get('date_to_search');

    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL statusx_nps (?)', array($date));
    return json_encode($result);
  }
  public function box_contestadas(Request $request)
  {
    $input_date_i= $request->get('date_to_search');

    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL status2_nps (?)', array($date));
    return json_encode($result);
  }
  public function box_sin_contestar(Request $request)
  {
    $input_date_i= $request->get('date_to_search');

    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL status1_nps (?)', array($date));
    return json_encode($result);
  }
  public function box_promotor(Request $request)
  {
    $input_date_i= $request->get('date_to_search');

    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL status_nps_pr (?)', array($date));
    return json_encode($result);
  }
  public function box_pasivo(Request $request)
  {
    $input_date_i= $request->get('date_to_search');

    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL status_nps_ps (?)', array($date));
    return json_encode($result);
  }
  public function box_detractor(Request $request)
  {
    $input_date_i= $request->get('date_to_search');

    if ($input_date_i != '') {
      $date = $input_date_i.'-01';
    }
    else {
      $date_current = date('Y-m');
      $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
      $sub_month = date ( 'Y-m' , $sub_month );
      $date = $sub_month.'-01';
    }
    $result = DB::select('CALL status_nps_d (?)', array($date));
    return json_encode($result);
  }

}
