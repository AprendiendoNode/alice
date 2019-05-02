<?php

namespace App\Http\Controllers\Support;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use DateTime;
class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //Obtener Lista
      $selectDominios = DB::connection('zendesk')->table('ListarDominios')->get();
      return view('permitted.service.zendesk_dashboard', compact('selectDominios'));
    }
    //Grafica 1
    public function showTicketYearP(Request $request){
        $yearR = $request->input;
        $res = DB::connection('zendesk')->select('CALL px_ticketsxmes(?)', array($yearR));
      	return json_encode($res);
    }
    public function showTicketLastYearP(Request $request){
        $yearminusR = $request->input;
        $res = DB::connection('zendesk')->select('CALL px_ticketsxmes(?)', array($yearminusR));
      	return json_encode($res);
    }
    //Grafica 2
    public function showTicketAgente(Request $request)
    {
        $date_request = $request->input;
        $date = '01-'.$date_request;
        $date_format =  date("Y-m-d", strtotime($date));
        $result = DB::connection('zendesk')->select('CALL px_ticketsresueltosxagente (?)', array($date_format));
        return json_encode($result);
    }
    //Grafica 3
    public function showTiempoRespuesta2(Request $request)
    {
        $datepicker = $request->datepickerMonth2;
        $datemod = explode("-", $datepicker);
        $MesR = $datemod[0];
        $YearR = $datemod[1];
        $dateObj   = DateTime::createFromFormat('!m', $MesR);
        $monthname = $dateObj->format('m');
        $res = DB::connection('zendesk')->select('CALL px_tiemporespuestasolucion(?, ?)', array($YearR, $monthname));
        return json_encode($res);
    }
    public function history_averagetime(Request $request){
        $datepicker = $request->datepickerMonth2;
        $datemod = explode("-", $datepicker);
        $MesR = $datemod[0];
        $YearR = $datemod[1];
        $Order = $YearR.'-'.$MesR.'-01';
        $res = DB::connection('zendesk')->select('CALL px_tiempopromedio_respuestasolucion(?)', array($Order));
        return json_encode($res);
    }
    //Grafica 4
    public function showTiempoRespuestaMensual2(Request $request)
    {
        $year = $request->input;
        $result = DB::connection('zendesk')->select('CALL px_ticketsrespuestamensual (?)', array($year));
        return json_encode($result);
    }
    //Grafica 5
    public function showTiempoRespuestaSemanalP(Request $request)
    {
        $input1 = $request->datepickerWeek;
        $input2 = $request->datepickerWeek2;
        $fecha_inicio = "";
        $fecha_fin = "";
        if ($input1 < $input2) {
            $fecha_inicio = $input1;
            $fecha_fin = $input2;
        }else{
            $fecha_inicio = $input2;
            $fecha_fin = $input1;
        }
        $result = DB::connection('zendesk')->select('CALL BuscarPrimeraRespuestaTICKET(?, ?)', array($fecha_inicio, $fecha_fin));
        return json_encode($result);
    }
    // Grafica 6 & 7
    public function showTagsP(Request $request)
    {
        $datepicker = $request->datepickerMonth3;
        $datemod = explode("-", $datepicker);
        $MesR = $datemod[0];
        $YearR = $datemod[1];
        $result = DB::connection('zendesk')->select('CALL BuscarTags(?, ?)', array($MesR, $YearR));
        return json_encode($result);
    }
    // Grafica 8
    public function showDominios(Request $request)
    {
        $yearnow = date('Y-m-d');
        $monthnow = date('m');
        $domain = "palaceresorts.com";
        $datepicker = $request->datepickerMonth4;
        $datemod = explode("-", $datepicker);
        $MesR = $datemod[0];
        $YearR = $datemod[1];
        $result = DB::connection('zendesk')->select('CALL DominiosPorMes(?,?)', array($MesR, $YearR));
        return json_encode($result);
    }
    // Grafica 9
    public function getHorarioTicket(Request $request)
    {
        $finicio = $request->finicio;
        $ffinal = $request->ffin;
        $result = DB::connection('zendesk')->select('CALL GetHorariosTickets(?, ?)', array($finicio, $ffinal));
        return json_encode($result);
    }
    // Grafica 10
    public function getHorarioTicketRangeP(Request $request)
    {
        $input1 = $request->finicio;
        $input2 = $request->ffin;
        $result = DB::connection('zendesk')->select('CALL GetHorariosTickets_24HRS(?, ?)', array($input1, $input2));
        return json_encode($result);
    }
    // Grafica 11
    public function getDominioTagMesPost(Request $request)
    {
        $dominio = $request->select_two;
        $fecha = $request->datepickerMonth5;
        $datemod = explode("-", $fecha);
        $MesR = $datemod[0];
        $YearR = $datemod[1];
        $result = DB::connection('zendesk')->select('CALL BuscarDominioEtiqueta(?, ?, ?)', array($dominio, $YearR, $MesR));
        return json_encode($result);
    }
    // Grafica 12
    public function getDominioTagAnioPost(Request $request)
    {
        $dominio = $request->select_one;
        $fanio = $request->datepickerYear4;
        $result = DB::connection('zendesk')->select('CALL BuscarDominioEtiqueta_anio(?, ?)', array($dominio, $fanio));
        return json_encode($result);
    }
}
