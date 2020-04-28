<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use \Carbon\Carbon;
use DB;
use Auth;
use PDF;
use Illuminate\Support\Collection as Collection;
class EntryLetterController extends Controller
{
    public function index()
    {
      $user_id = Auth::user()->id;
      if (auth()->user()->hasanyrole('SuperAdmin|Admin')) {
        $hotels= DB::table('hotels')->select('id','Nombre_hotel')->where('filter', 1)->whereNull('deleted_at')->get();
      }
      else {
        $hotels = DB::select('CALL GetAllCadenaActiveByUserv2 (?)', array($user_id));
      }
      return view('permitted.inventory.det_cover',compact('hotels'));
    }
    public function search_cover(Request $request)
    {
      $hotel = $request->token_b;
      $result = DB::select('CALL cover_info_top (?)', array($hotel));
      return json_encode($result);
    }
    public function pdf_cover(Request $request)
    {
      $hotel = 12;
      $encabezado = DB::select('CALL cover_info_top (?)', array($hotel));
      $resumen = DB::select('CALL cover_resumen_equipos (?)', array($hotel));
      $desglose = DB::select('CALL cover_desglose_equipos (?)', array($hotel));
      $pdf = PDF::loadView('permitted.inventory.pdf_carta_entrega',compact('encabezado','resumen', 'desglose'))->setPaper('letter');
      return $pdf->stream();
    }

    public function resumen_equipos(Request $request)
    {
      $hotel = $request->data_one;
      $result = DB::select('CALL cover_resumen_equipos (?)', array($hotel));
      return json_encode($result);
    }
    public function desglose_equipos(Request $request)
    {
      $hotel = $request->data_one;
      $result = DB::select('CALL cover_desglose_equipos (?)', array($hotel));
      return json_encode($result);
    }
    public function update_data_cover(Request $request)
    {
              $id_hotel = $request->token_d;
      $info_responsable = $request->update_cliente_responsable;
         $info_telefono = $request->update_cliente_tel;
           $info_correo = $request->update_cliente_email;
           $info_ciudad = $request->update_city;
            $info_fecha = $request->update_date_time;
        $info_ubicacion = $request->update_ubicacion;

        $fecha = explode(' ', $info_fecha);
        $fecha1 = $fecha[0];
        $fecha2 = $fecha[1].' '.$fecha[2];

        $reorden_fecha = explode('-', $fecha1);
        $fecha_dia = $reorden_fecha[0];
        $fecha_mes = $reorden_fecha[1];
        $fecha_year= $reorden_fecha[2];
        $nombre_meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $mesnombre = $nombre_meses[((int)$fecha_mes)-1];

    }

    public function update(Request $request)
    {
        //
    }

}
