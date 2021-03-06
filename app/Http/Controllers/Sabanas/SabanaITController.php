<?php

namespace App\Http\Controllers\Sabanas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use App\User;
use DateTime;
use DB;
use Auth;
use Mail;
use App\Cadena;

class SabanaITController extends Controller
{
  public function index()
  {
    $user_id = Auth::user()->id;
    $cadena = Cadena::select('id', 'name')->get();
    $users = DB::select('CALL list_user_itc_by_id(?)', array($user_id));
    $facturacion = 0;
    if(empty($users)) {
      $users = DB::select('CALL list_user_itc()');
      //$facturacion = 1;
    }
    $status_compras = DB::select('CALL px_documentp_status_doctype()', array());
    return view('permitted.sabanas.sabana_itc', compact('users','cadena','status_compras','facturacion'));
  }
  public function informacionITC(Request $request)
  {
    $itc = $request->itc;
    $filtro = $request->filtro;
    $fecha = '';
    if($filtro <= 12) {
      $fecha = date('Y-m-d');
    } else {
      $fecha = $filtro.'-12-01';
    }
    $result = DB::select('CALL px_sitios_by_itc_12meses(?, ?)', array($itc, $fecha));
    return $result;
  }
  public function antenasITC(Request $request)
  {
    $itc = $request->itc;
    $result = DB::select('CALL px_cantidad_aps_xusuario(?)', array($itc));
    return $result;
  }
  public function tabla_antenas_ITC(Request $request)
  {
    $itc = $request->itc;
    $result = DB::select('CALL px_tabla_apsxusuario(?)', array($itc));
    return $result;
  }
  public function viaticos_x_mes(Request $request)
  {
    $itc = $request->itc;
    $filtro = $request->filtro;
    $fecha = '';
    if($filtro <= 12) {
      $fecha = date('Y-m-d');
    } else {
      $fecha = $filtro.'-12-01';
    }
    $result = DB::select('CALL px_viaticos_x_mes(?, ?)', array($itc, $fecha));
    return $result;
  }
  public function tabla_antenas_sitio(Request $request)
  {
    $sitio = $request->sitio;
    $itc = $request->itc;
    $result = DB::select('CALL px_tabla_apsxsitio(?, ?)', array($sitio, $itc));
    return $result;
  }
  public function get_table_equipments(Request $request){
    $id_hotel=$request->id;
    $result= DB::Select('CALL px_equipmentsxhotel(?)',array($id_hotel));
    return $result;
  }
  public function get_table_equipments_cadena(Request $request){
    $cadena=$request->id;
    $result= DB::Select('CALL px_equipmentsxcadena(?)',array($cadena));
    return datatables()->of($result)->make(true);
  }
  public function get_nps_itc(Request $request){
    $itc=$request->itc;
    $anio=$request->anio;

    if($anio == "") {
      $anio = date('Y');
    }
    $result = DB::select('CALL px_NPS_itc (?, ?)', array($itc, $anio));
    return $result;
  }
  public function get_nps_itc_mensual(Request $request){
    $itc=$request->itc;
    $anio=$request->anio;
    $mes=$request->mes;
    $fecha = "";

    if($anio == "") {
      $fecha = date('Y-m-d');
    } else {
      $fecha = $anio."-".$mes."-01";
    }
    $result = DB::select('CALL px_NPS_itc_mensual (?, ?)', array($itc, $fecha));
    return $result;
  }
  public function get_nps_cadena(Request $request){
    $id_cadena=$request->id;
    $anio=$request->anio;

    if($anio == "") {
      $anio = date('Y');
    }

    $result = DB::select('CALL px_NPS_cadena (?, ?)', array($id_cadena, $anio));
    return $result;
  }

  public function get_nps_comment_itc(Request $request){
    $itc=$request->itc;
    $result = DB::select('CALL px_get_results_nps_itc (?)', array($itc));
    return $result;
  }

  public function get_nps_comment_cadena(Request $request){
    $id_cadena=$request->id;
    $result = DB::select('CALL px_get_results_nps_cadena (?)', array($id_cadena));
    return $result;
  }

  public function get_graph_equipments(Request $request){
    $id_hotel = $request->id;
    $result = DB::select('CALL px_equiposxtipo_hotel (?)',array($id_hotel));
    return $result;
  }

  public function get_graph_equipments_cadena(Request $request){
    $cadena = $request->id;
    $result = DB::select('CALL px_equiposxtipo_cadena (?)',array($cadena));
    return $result;
  }

  public function get_graph_equipments_status(Request $request){
    $id_hotel = $request->id;
    $result = DB::select('CALL px_equiposxstatus_hotel (?)',array($id_hotel));
    return $result;
  }

  public function get_graph_equipments_status_cadena(Request $request){
    $cadena = $request->id;
    $result = DB::select('CALL px_equiposxstatus_cadenas (?)',array($cadena));
    return $result;
  }
  public function get_budget_annual_hotel(Request $request){
    $id_hotel = $request->id;
    $date_current = $request->fecha;
    if($date_current==''){
    $date_current = date('Y');
    }
    $result = DB::select('CALL px_get_mount_PEjercidoxHotel(?,?)', array($id_hotel,$date_current));
    return $result;

  }

  public function get_budget_annual_cadena(Request $request){
    $cadena = $request->id;
    $date_current = $request->fecha;
    if($date_current==''){
    $date_current = date('Y');
    }
    $result = DB::select('CALL px_get_mount_PEjercidoxcadena(?,?)', array($cadena,$date_current));
    return $result;
  }

  public function get_payment_folios_gastos(Request $request)
  {
    $id = $request->id;
    $res =  DB::select('CALL payments_hotel_folio_gastos(?)', array($id));
    return $res;
  }

  public function get_payment_folios_gastos_cadena(Request $request)
  {
    $id_cadena = $request->id;
    $res =  DB::select('CALL px_payments_cadena_folio_gastos(?)', array($id_cadena));
    return $res;
  }

  public function get_viatics_gastos_itc(Request $request)
  {
    $id = $request->id;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $res =  DB::select('CALL px_history_viatics_itc(?, ?, ?)', array($id, $fecha1, $fecha2));
    return $res;
  }

  public function get_tickets_by_itc(Request $request){
    $itc_email=$request->itc_email;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $result = DB::connection('zendesk')->select('CALL px_ticketsxitc(?, ?, ?)', array($itc_email, $fecha1, $fecha2));
    return datatables()->of($result)->make(true);;
  }

  public function get_ticketsxtype_itc(Request $request ){
    $itc_email=$request->itc_email;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $result = DB::connection('zendesk')->select('CALL px_ticketsxtype_itc(?, ?, ?)', array($itc_email, $fecha1, $fecha2));
    return $result;
  }

  public function get_ticketsxstatus_itc(Request $request ){
    $itc_email=$request->itc_email;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $result = DB::connection('zendesk')->select('CALL px_ticketsxstatus_itc(?, ?, ?)', array($itc_email, $fecha1, $fecha2));
    return $result;
  }


  public function sabana_itc_modal_encuestas(Request $request ){
    $date= $request->anio;
    $encuestas= $request->encuestas;
    $itc= $request->itc;

    if ($date == '') {
      $date = date('Y-m-d');
    } else {
      $date = $date."-01-01";
    }

    if($encuestas == "box_promo") {
      $encuestas = 4;
    } else if($encuestas == "box_pas") {
      $encuestas = 5;
    } else {
      $encuestas = 6;
    }

    $result = DB::select('CALL status_nps_anio_itc (?, ?, ?)', array($date, $encuestas, $itc));
    return json_encode($result);
  }

  public function sabana_itc_modal_encuestas_hover(Request $request ){
    $date= $request->fecha;
    $hotel= $request->hotel;
    $itc= $request->itc;

    $result = DB::select('CALL status_nps_anio_itc_hover (?, ?, ?)', array($date, $hotel, $itc));
    return $result;
  }

  public function get_projects_itc(Request $request){
    $id = $request->itc_id;
    $result= DB::Select('CALL px_documentp_status_doctype_itc(?)',array($id));
    return $result;
  }

  public function docs_x(Request $request){
    $itc_id = $request->itc_id;
    $tipo_doc = $request->tipo_doc;
    $filtro = $request->filtro;
    $fecha = '';
    if($filtro <= 12) {
      $fecha = date('Y-m-d');
    } else {
      $fecha = $filtro.'-12-01';
    }
    $result=DB::Select('CALL px_documentxtype_itc_v2(?,?,?)',array($itc_id, $fecha, $tipo_doc));
    return $result;
  }
  public function cl_diario_itc(Request $request){
    //info($request);
    $fecha=$request->fecha;
    $itc_id= $request->itc_id;
    $newdate=Carbon::parse($fecha);
    $newdate->format('Y/m/d');
    DB::table('cl_diario')
    ->updateOrInsert(
        ['fecha' => $fecha,'itc_id' => $itc_id],
        ['calendario_hoy' => $request->calendario_hoy,
         'documentacion_tickets'=>$request->documentacion_tickets,
         'uniforme'=>$request->uniforme,
         'llave_uniforme'=>$request->llave_uniforme,
         'gym'=>$request->gym,
         'mantener_orden'=>$request->mantener_orden,
         'trato_cordial'=>$request->trato_cordial,
         'calendario_2dias'=>$request->calendario_2dias,
         'diagnosticar_equipos'=>$request->diagnosticar_equipos,
         'fecha'=>$newdate,
         'itc_id'=>$itc_id
        ]
    );

    return "ok";
  }


  public function cl_act_prin(Request $request){

    //Si es nulo el check estaba desmarcado y no se envio, de lo contrario estaba marcado.
    $request->ck_correos==NULL? $ck_correos=0:$ck_correos=1;
    $request->ck_tickets==NULL? $ck_tickets=0:$ck_tickets=1;
    $request->ck_visita==NULL? $ck_visita=0:$ck_visita=1;
    $request->ck_encuestas==NULL? $ck_encuestas=0:$ck_encuestas=1;
    $request->ck_seguimiento_instalaciones==NULL? $ck_seguimiento_instalaciones=0:$ck_seguimiento_instalaciones=1;
    $request->ck_levantamiento==NULL? $ck_levantamiento=0:$ck_levantamiento=1;
    $request->ck_mantto==NULL? $ck_mantto=0:$ck_mantto=1;
    $request->ck_llamadas==NULL? $ck_llamadas=0:$ck_llamadas=1;
    $request->txtOtros==NULL? $txtOtros='': $txtOtros=$request->txtOtros;
    $itc_id=$request->itc;
    $fecha = date('Y-m-d');
    //info($request);


    DB::table('cl_act_prin')
    ->updateOrInsert(
        ['fecha' => $fecha,'itc_id' => $itc_id],
        ['correos' => $ck_correos,
         'tickets'=>$ck_tickets,
         'visita'=>$ck_visita,
         'encuestas'=>$ck_encuestas,
         'seguimiento_inst'=>$ck_seguimiento_instalaciones,
         'levantamiento'=>$ck_levantamiento,
         'mantto'=>$ck_mantto,
         'llamadas'=>$ck_llamadas,
         'Otros'=>$txtOtros,
         'fecha'=>$fecha,
         'itc_id'=>$itc_id
        ]
    );

    return "ok";

  }


  public function search_client_itc(Request $request){
    //info($request);
    $id_itc=$request->id_itc;
    $result=DB::Select('CALL px_sitios_by_itc(?)',array($id_itc));
    return $result;
  }
  public function cl_5dia_itc(Request $request){
    //info($request);

    $fecha=$request->fecha;
    $itc_id= $request->itc_id;
    $sitio= $request->sitio;
    $newdate=Carbon::parse($fecha);
    $newdate->format('Y/m/d');

    DB::table('cl_5_dia')
    ->updateOrInsert(
        ['fecha' => $fecha,'itc_id' => $itc_id,'id_hotel'=>$sitio],
        ['reporte' => $request->reporte,
         'nps'=>$request->nps,
         'factura_cliente'=>$request->factura_cliente,
         'memoria_tecnica'=>$request->memoria_tecnica,
         'inventario_actualizado'=>$request->inventario_actualizado,
         'itc_id'=>$itc_id,
         'fecha'=>$newdate,
         'id_hotel'=>$sitio,
        ]
    );
    return "ok";
  }

  public function cl_20dia_itc(Request $request){
    //info($request);

    $fecha=$request->fecha;
    $itc_id= $request->itc_id;
    $sitio= $request->sitio;
    $newdate=Carbon::parse($fecha);
    $newdate->format('Y/m/d');

    DB::table('cl_20_dia')
    ->updateOrInsert(
        ['fecha' => $fecha,'itc_id' => $itc_id,'id_hotel'=>$sitio],
        ['visita_cliente' => $request->visita_cliente,
         'revisar_disp'=>$request->revisar_disp,
         'detectar_oportunidad'=>$request->detectar_oportunidad,
         'revisar_informacion'=>$request->revisar_informacion,
         'detecta_nuevas_oportunidades'=>$request->detecta_nuevas_oportunidades,
         'mantto'=>$request->mantto,
         'backup'=>$request->backup,
         'revisar_renovar'=>$request->revisar_renovar,
          'cliente_pago'=>$request->cliente_pago,
         'itc_id'=>$itc_id,
         'fecha'=>$newdate,
         'id_hotel'=>$sitio,
        ]
    );
    return "ok";
  }


  public function cl_oportunidades(Request $request){

    $oportunidad_cobertura=$request->oportunidad_cobertura;
    $oportunidad_enlaces=$request->oportunidad_enlaces;
    $oportunidad_cctv=$request->oportunidad_cctv;
    $deteccion_propiedades=$request->deteccion_propiedades;
    $deteccion_soporte=$request->deteccion_soporte;
    $itc_id=$request->itc;
    $fecha = date('Y-m-d');
    //info($request);

    DB::table('cl_oportunidades')
    ->updateOrInsert(
        ['fecha' => $fecha,'itc_id' => $itc_id],
        ['oportunidad_cobertura' => $oportunidad_cobertura,
         'oportunidad_enlaces'=>$oportunidad_enlaces,
         'oportunidad_cctv'=>$oportunidad_cctv,
         'deteccion_propiedades'=>$deteccion_propiedades,
         'deteccion_soporte'=>$deteccion_soporte,
         'fecha'=>$fecha,
         'itc_id'=>$itc_id
        ]
    );

    return "ok";

  }

  public function ck_inst_add(Request $request) {
    $opciones = $request->clInstOp;
    $idHotel = $request->clientID;
    $idITC = $request->itc;
    DB::beginTransaction();

    try {
      $idCheck = DB::table('cl_instalaciones')->insertGetId([
        'levantamiento' => $opciones[0],
        'horario_inicio' => $opciones[1],
        'cotizacion_alcances' => $opciones[2],
        'documento_p' => $opciones[3],
        'documento_kickoff' => $opciones[4],
        'junta_operativa' => $opciones[5],
        'planos_inmueble' => $opciones[6],
        'diagramas_red_sembrado' => $opciones[7],
        'realizo_entrega_proyecto' => $opciones[8],
        'entrega_materiales' => $opciones[9],
        'equipo_activo' => $opciones[10],
        'rack_tierra_fisica' => $opciones[11],
        'rack_corriente_regulada' => $opciones[12],
        'contratista_UTP_FO' => $opciones[13],
        'antenas_ruckus' => $opciones[14],
        'revisar_equipo' => $opciones[15],
        'puebas_funcionamiento' => $opciones[16],
        'revision_enlace' => $opciones[17],
        'revision_enlace_conf' => $opciones[18],
        'actualizar_proyecto_alice' => $opciones[19],
        'bitacora_cierre' => $opciones[20],
        'memoria_tecnica' => $opciones[21],
        'memoria_foto' => $opciones[22],
        'carta_entrega' => $opciones[23],
        'itc_id' => $idITC,
        'hotel_id' => $idHotel
      ]);
      DB::commit();
    } catch(\Exception $e) {
      DB::rollback();
    }
    return response()->json($idCheck);
  }

}
