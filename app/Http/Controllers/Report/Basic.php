<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Hotel;
use App\Typereport;
use App\User;

class Basic extends Controller
{
  /**
   * Show the application View Reports
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user_id = Auth::user()->id;
    $user_role = User::find($user_id)->getRoleNames();

    //$hotels = DB::select('CALL px_sitiosXusuario_rol(?, ?)', array(26, 'itconcierge'));
    $hotels = DB::select('CALL px_sitiosXusuario_rol(?, ?)', array($user_id, $user_role[0].""));

    return view('permitted.report.view_reports', compact('hotels'));
  }
  public function typerep(Request $request)
  {
      $value= $request->numero;

      //$hotel = Hotel::select(['Nombre_hotel'])->find($value);
      $hotel = Hotel::find($value);

      $hotel->typereports->toJson();
      info($hotel);
      return $hotel;
      //$selectnivel= DB::table('NivelesReportes')->select('ReporteID','Nivel')->where('HotelID', '=', $value)->get();
      //$selectnivel= DB::table('tipos_reporte_new')->select('fk_tiporeportenew','Nombre')->where('fk_hotel', '=', $value)->get();
      //return json_encode($selectnivel);

  }

  public function test()
  {
    $result1 = DB::select('CALL report_venue_header (?, ?)', array(6, '2018-02-01'));
    // $result2 = DB::select('CALL GetWLAN (?, ?)', array(6, '2018-02-01'));
    // $result3 = DB::select('CALL GetWLAN_top5 (?, ?)', array(6, '2018-02-01'));
    $result4 = DB::select('CALL Get_User (?, ?)', array('2018-02-01', 6));
    $result5 = DB::select('CALL Get_GB (?, ?)', array('2018-02-01', 6));
    // $result6 = DB::select('CALL Get_MostAP_top5 (?, ?, ?)', array(7, 2018, 2));
    // $result7 = DB::select('CALL Comparative (?, ?)', array(7, '2018-2-01'));

    dd($result5);
  }

  public function report_header(Request $request)
  {
    $hotel = $request->data_one;
    $date = $request->data_two;

    $datemonthyear =  explode('-', $date);
    $dateyear= (int)$datemonthyear[0];
    $datemonth= (int)$datemonthyear[1];
    $datefull = $dateyear . '-' . $datemonth . '-01';

    $result1 = DB::select('CALL report_venue_header (?, ?)', array($hotel, $datefull));

    return json_encode($result1);
  }

  public function graph_client_wlan(Request $request)
  {
    $hotel = $request->data_one;
    $date = $request->data_two;

    $datemonthyear =  explode('-', $date);
    $dateyear= (int)$datemonthyear[0];
    $datemonth= (int)$datemonthyear[1];
    $datefull = $dateyear . '-' . $datemonth . '-01';

    $result1 = DB::select('CALL GetWLAN (?, ?)', array($hotel, $datefull));

    return json_encode($result1);
  }

  public function client_wlan_top(Request $request)
  {
    $hotel = $request->data_one;
    $date = $request->data_two;

    $datemonthyear =  explode('-', $date);
    $dateyear= (int)$datemonthyear[0];
    $datemonth= (int)$datemonthyear[1];
    $datefull = $dateyear . '-' . $datemonth . '-01';

    $result1 = DB::select('CALL GetWLAN_top5 (?, ?, ?)', array($hotel, $dateyear, $datemonth));

    return json_encode($result1);
  }

  public function user_month(Request $request)
  {
    $hotel = $request->data_one;
    $date = $request->data_two;

    $datemonthyear =  explode('-', $date);
    $dateyear= (int)$datemonthyear[0];
    $datemonth= (int)$datemonthyear[1];
    $datefull = $dateyear . '-' . $datemonth . '-01';

    $result1 = DB::select('CALL Get_User (?, ?)', array($datefull, $hotel));

    return json_encode($result1);
  }

  public function gb_month(Request $request)
  {
    $hotel = $request->data_one;
    $date = $request->data_two;

    $datemonthyear =  explode('-', $date);
    $dateyear= (int)$datemonthyear[0];
    $datemonth= (int)$datemonthyear[1];
    $datefull = $dateyear . '-' . $datemonth . '-01';

    $result1 = DB::select('CALL Get_GB (?, ?)', array($datefull, $hotel));

    return json_encode($result1);
  }

  public function mostAP_top5(Request $request)
  {
    $hotel = $request->data_one;
    $date = $request->data_two;

    $datemonthyear =  explode('-', $date);
    $dateyear= (int)$datemonthyear[0];
    $datemonth= (int)$datemonthyear[1];
    $datefull = $dateyear . '-' . $datemonth . '-01';

    $result1 = DB::select('CALL Get_MostAP_top5 (?, ?, ?)', array($hotel, $dateyear, $datemonth));

    return json_encode($result1);
  }

  public function tab_comparativa(Request $request)
  {
    $hotel = $request->data_one;
    $date = $request->data_two;

    $datemonthyear =  explode('-', $date);
    $dateyear= (int)$datemonthyear[0];
    $datemonth= (int)$datemonthyear[1];
    $datefull = $dateyear . '-' . $datemonth . '-01';

    $result1 = DB::select('CALL Comparative (?, ?)', array($hotel, $datefull));

    return json_encode($result1);
  }
  public function view_band(Request $request){
    $hotel = $request->data_one;
    $months = $request->data_two;
    $date = $months.'-01';
    $val_exist = '';
    $find = DB::table('report_hotel_bandas')->where([
          ['hotels_id', '=' , $hotel],
          ['type', '=' , '1'],
          ['Fecha', '=' , $date]
        ])->count();
    if ($find != '0') {
      $val_exist = DB::table('report_hotel_bandas')->select('img')
      ->where('hotels_id', '=', $hotel)
      ->where('type', '=', '1')
      ->where('Fecha', '=', $date)
      ->value('img');
    }
    return 'images/storage/'.$val_exist;
  }
  public function view_device(Request $request){
    $hotel = $request->data_one;
    $months = $request->data_two;
    $date = $months.'-01';
    $val_exist = '';
    $find = DB::table('report_hotel_bandas')->where([
          ['hotels_id', '=' , $hotel],
          ['type', '=' , '0'],
          ['Fecha', '=' , $date]
        ])->count();
    if ($find != '0') {
      $val_exist = DB::table('report_hotel_bandas')->select('img')
      ->where('hotels_id', '=', $hotel)
      ->where('type', '=', '0')
      ->where('Fecha', '=', $date)
      ->value('img');
    }
    return 'images/storage/'.$val_exist;
  }
}
