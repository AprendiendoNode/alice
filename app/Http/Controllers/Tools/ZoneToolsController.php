<?php

namespace App\Http\Controllers\Tools;
use App\Hotel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SNMP;
use DB;

class ZoneToolsController extends Controller
{
  /**
   * Show the application zone tools
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (auth()->user()->hasanyrole('SuperAdmin|Admin')) {
		$hotels = Hotel::select('id', 'Nombre_hotel')->get();
		return view('permitted.tools.zone_tools', compact('hotels'));
    }
    else {
		$hotels = auth()->user()->hotels;
		return view('permitted.tools.zone_tools', compact('hotels'));
    }
  }

  public function getInfo(Request $request)
  {
    $select = $request->select;

    $res = DB::select('CALL get_ip_zd_venue(?)', array($select));

    return $res;
  }
  public function testRequest(Request $request)
  {
      $dir_ip = $request->num_dir;
      $dir_puert = $request->num_port;
      $nueva_dir =$dir_ip.':'.$dir_puert;
      $boolean = 0;

      $session = new SNMP(SNMP::VERSION_2C, $nueva_dir, "public");
      try {
        //$res = $session->walk("1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.2");
        $res = $session->walk('1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.4'); //Model name
      } catch (\Exception $e) {
        //$boolean = $session->getErrno() == SNMP::ERRNO_TIMEOUT;
        $boolean = 1;
        return $boolean;
      }
      $session->close();
      return $boolean;
  }


}
