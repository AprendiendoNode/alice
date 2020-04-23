<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\User;
use App\Models\Projects\Documentp;
use App\Models\Projects\Documentp_cart;
use App\Models\Projects\Documentp_status_user;
use App\Models\Projects\Deny_docpcomment;
use App\Models\Projects\Documentp_project;
use App\Mail\SolicitudCompraAprobada;
use App\Mail\DocumentopDenegado;
use App\ParametrosPresupuesto;
use Mail;
use Auth;
use DB;

class DocumentpHistoryController extends Controller
{
    public function index()
    {
        return view('permitted.documentp.history_documentm');
    }

    public function history_docp()
    {
        return view('permitted.documentp.history_documentp');
    }

    public function view_auth()
    {
        return view('permitted.documentp.history_documentp_auth');
    }

    public function view_delivery()
    {
        return view('permitted.documentp.history_documentp_delivery');
    }

    public function view_project_advance()
    {
        $user_id = Auth::user()->id;
        return view('permitted.documentp.history_documentp_advance',compact('user_id'));
    }

    public function view_project_advance_success()
    {
        return view('permitted.documentp.history_documentp_advance_success');
    }

    public function get_estimation_site($id_anexo, $tipo_cambio)
    {
        $current_date = date('Y-m-d');

        $data = DB::select('CALL px_proyectos_categorias(?,?,?)', array($id_anexo,'20.00', $current_date));

        return view('permitted.planning.estimation_site', compact('data'));
    }
    //Este es el bueno
    public function get_estimation_site_by_site($anexo)
    {
      $contract_annex = False;
      $cotizador = False;
      $inversion_instalacion =0;
      $mantenimiento = 0;
      $inversion_total = 0;
      $tir = 0.0;
      $utilidad_renta_anticipada = 0.0;

      $data = DB::select('CALL px_presupuesto_vs_ejercido(?)', array($anexo));

      $facturacion_mensual = DB::table('documentp')->select()->where('anexo_id', $anexo)
                              ->pluck('servicio_mensual')->first();

      $documentosPReal = $data[7]->total_usd + $data[8]->total_usd + $data[9]->total_usd + $data[10]->total_usd + $data[11]->total_usd + $data[12]->total_usd + $data[13]->total_usd;
      $documentosMReal = $data[21]->total_usd + $data[22]->total_usd + $data[23]->total_usd + $data[24]->total_usd + $data[25]->total_usd + $data[26]->total_usd + $data[27]->total_usd;

      if(ParametrosPresupuesto::getContracAnnex($anexo) != null){ $contract_annex = True; }
      if(count(ParametrosPresupuesto::getCotizador($anexo)) != 0){ $cotizador = True; }

      if(ParametrosPresupuesto::getContracAnnex($anexo) != null &&
        count(ParametrosPresupuesto::getCotizador($anexo)) != 0){
        $inversion_instalacion = ParametrosPresupuesto::getInversionInstalacion($anexo, $documentosPReal);
        $mantenimiento = ParametrosPresupuesto::getMantenimiento($anexo, $documentosMReal);
        $inversion_total = ParametrosPresupuesto::getInversionTotal($anexo, $documentosPReal);
        $tir = ParametrosPresupuesto::getTir($anexo, $documentosMReal);
        $utilidad_renta_anticipada = ParametrosPresupuesto::getUtilidadRenta($anexo);
      }

      return view('permitted.planning.estimation_site',
             compact('data', 'inversion_instalacion', 'mantenimiento', 'inversion_total', 'tir', 'utilidad_renta_anticipada', 'contract_annex', 'cotizador'));
    }

    /** Gastos del sitio recuperado de los diferentes modulos */
    public function get_estimation_site_by_site_data($anexo)
    {
      $data = DB::select('CALL px_presupuesto_vs_ejercido(?)', array($anexo));

      return $data;
    }


    public function get_budgettable_site($id_anexo, $tipo_cambio, $date)
    {
      if (empty($tipo_cambio)) {
        $tipo_cambio = '19.00';
      }
      $date = $date . '-01';
      $data = DB::select('CALL px_proyectos_categorias(?,?,?)', array($id_anexo, $tipo_cambio, $date));
      dd($data);
      return view('permitted.planning.estimation_site', compact('data'));
    }

    public function get_history_documentp(Request $request)
    {

      $id_user = Auth::user()->id;
      $input_date_i= $request->get('date_to_search');

      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
      }
      else {
        $date_current = date('Y-m');
        $date = $date_current.'-01';
      }

      if(auth()->user()->can('View level zero documentp notification')){
        //$result = DB::select('CALL px_documentop_mensual_all(?)' , array($date));
        $result = DB::select('CALL px_documentop_mensual(?,?)' , array($date, $id_user));
      }else {
         $result = DB::select('CALL px_documentop_mensual_all(?)' , array($date));
      }

      return $result;
    }

    public function get_history_auth_documentp(Request $request)
    {
      $input_date_i= $request->get('date_to_search');

      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
      }
      else {
        $date_current = date('Y-m');
        $date = $date_current.'-01';
      }

      $result = DB::select('CALL px_documentop_mensual_autorizados(?)' , array($date));

      return $result;
    }

    public function get_history_delivery_documentp(Request $request)
    {
      $input_date_i= $request->get('date_to_search');

      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
      }
      else {
        $date_current = date('Y-m');
        $date = null;
      }

      $result = DB::select('CALL px_documentop_mensual_all(?)' , array($date));

      return $result;
    }

    public function get_header($id)
    {
      $id_doc = $id;
      $result= DB::select('CALL px_documentop_data(?)', array($id_doc));

      return $result;
    }

    public function get_table_products($id_documentp, $id_cart)
    {
      $id_doc = $id_documentp;
      $cart = $id_cart;
      $status = [];

      $data = DB::select('CALL px_docupentop_materialesXcarrito(?)' , array($cart));
      if($data == []){
        return view('permitted.documentp.empty_cart');
      }
      $tipo_cambio = $data[0]->tipo_cambio;
      $collection = collect($data);
      $select_status = DB::table('orders_products')->select('id','name')->get();
      //dd($select_status);
      $users_compras = [11,45];
      $users_delivery = [258,78,40];
      // if(in_array(Auth::user()->id, $users_compras)){
      //   $select_status = DB::table('orders_products')->select('id','name')->whereIn('id', [1,2,3,4])->get();
      // }else if(in_array(Auth::user()->id, $users_delivery)){
      //   $select_status = DB::table('orders_products')->select('id','name')->whereIn('id', [5,6,7,8,9])->get();
      // }else{
      //
      // }
      for($i=0;$i < count($select_status); $i++){
        array_push($status, [
					'value' => $select_status[$i]->id,
					'text' => $select_status[$i]->name,
				]);
      }
      $status = json_encode($status);
      // Filtrando categorias de los productos
      $equipo_activo = $collection->whereIn('categoria_id', [4, 6, 14]);
      $materiales = $collection->whereNotIn('categoria_id', [4, 6, 7, 14, 15]);
      $mano_obra = $collection->where('categoria_id', 7);
      $viaticos = $collection->where('categoria_id', 15);

      foreach ($equipo_activo as $ea) {
          $ea->cantidad = floor($ea->cantidad);
          $ea->cantidad_sugerida = floor($ea->cantidad_sugerida);
          $ea->porcentaje_compra = floor($ea->porcentaje_compra);
      }
      foreach ($materiales as $m) {
          $m->cantidad = floor($m->cantidad);
          $m->cantidad_sugerida = floor($m->cantidad_sugerida);
          $m->porcentaje_compra = floor($m->porcentaje_compra);
      }
      foreach ($mano_obra as $mo) {
          $mo->cantidad = floor($mo->cantidad);
          $mo->cantidad_sugerida = floor($mo->cantidad_sugerida);
          $mo->porcentaje_compra = floor($mo->porcentaje_compra);
      }
      foreach ($viaticos as $v) {
        $v->cantidad = floor($v->cantidad);
        $v->cantidad_sugerida = floor($v->cantidad_sugerida);
        $v->porcentaje_compra = floor($v->porcentaje_compra);
      }

      if (auth()->user()->can('Edit bill of materials')) {
        return view('permitted.documentp.table_products_modal_compras', compact('equipo_activo', 'materiales', 'mano_obra', 'viaticos','status', 'tipo_cambio'))->render();
      }else {
        return view('permitted.documentp.table_products_modal_itc', compact('equipo_activo', 'materiales', 'mano_obra', 'viaticos','status', 'tipo_cambio'))->render();
      }

    }

    public function get_table_project_advance($id_documentp)
    {
      $id_doc = $id_documentp;
      $motives = [];
      $select_motives = DB::table('documentp_motives')->select('id','name')->get();
      for($i=0;$i < count($select_motives); $i++){
        array_push($motives, [
					'value' => $select_motives[$i]->id,
					'text' => $select_motives[$i]->name,
				]);
      }
      $motives = json_encode($motives);

      if($this->check_document_type($id_doc) == 1){

        $docp_advance = Documentp_project::firstOrCreate(
            ['id_doc' => $id_doc],
            ['id_motivo' => 7]
        );

        $motivo = DB::table('documentp_project_advance')
            ->join('documentp_motives', 'id_motivo', '=', 'documentp_motives.id')
            ->select('documentp_motives.name')->where('id_doc', $id_doc)->get();

        $motivo_name = $motivo[0]->name;

        $docp_advance->instalacion_total = floor($docp_advance->instalacion_total);
        $docp_advance->configuracion_total = floor($docp_advance->configuracion_total);
        $docp_advance->test_total = floor($docp_advance->test_total);
        $docp_advance->total_global = floor($docp_advance->total_global);

        if (auth()->user()->can('View level zero documentp notification')) {
          return view('permitted.documentp.table_project_advance_itc', compact('docp_advance', 'motives', 'id_doc'))->render();
        }else {
          return view('permitted.documentp.table_project_advance_compras', compact('docp_advance', 'motives', 'motivo_name', 'id_doc'))->render();
        }

      }

    }

    public function update_project_advance(Request $request)
    {
      $flag = "false";
      $project = Documentp_project::find($request->id);
      $project->tuberias = $request->tuberias;
      $project->cableado = $request->cableado;
      $project->org_cableado = $request->org_cableado;
      $project->ponchado_cables = $request->ponchado_cables;
      $project->identificacion = $request->identificacion;
      $project->instalacion_antenas = $request->instalacion_antenas;
      $project->instalacion_switches = $request->instalacion_switches;
      $project->config_site = $request->config_site;
      $project->config_zone_director = $request->config_zone_director;
      $project->infraestructura_test = $request->infraestructura_test;
      $project->test_general = $request->test_general;
      $project->recorrido = $request->recorrido;
      $project->firma_acta = $request->firma_acta;
      $project->instalacion_total = $request->instalacion_total;
      $project->configuracion_total = $request->configuracion_total;
      $project->test_total = $request->test_total;
      $project->total_global = $request->total_global;
      $project->comentario = $request->comentario;
      $project->fecha_inicio = $request->date_start;
      $project->fecha_final = $request->date_end;
      $project->fecha_firma = $request->date_signature;
      $project->updated_at = \Carbon\Carbon::now();
      $project->save();

      $user_name = Auth::user()->name;

      DB::table('documentp_project_advance_logs')->insert(
          ['name' => $user_name,
          'id_doc' => $project->id_doc,
          'created_at' => \Carbon\Carbon::now()]
      );

      $flag = "true";

      return $flag;
    }

    public function get_comment_project($id)
    {
      $result = Documentp_project::where('id_doc', $id)->get();

      return $result;
    }

    public function update_comment_project(Request $request)
    {
      $project = Documentp_project::where('id_doc', $request->id_doc)
                ->update(['comentario_manager' => $request->comment]);

      return "true";
    }

    public function update_comment_project_deny(Request $request)
    {
      //info($request);
      $update= DB::Table('documentp')->where('id', $request->id_doc_deny)->update(['status_id' => 4]);//Status 4 = Denegado
      $project= DB::Table('documentp_project_advance')->where('id_doc', $request->id_doc_deny)->update(['comentario_deny' => $request->comment]);

      $query=DB::Table('documentp as A')->join('users as B','A.itc_id','=','B.id')->where('A.id',$request->id_doc_deny)->select('A.folio','A.nombre_proyecto','B.name','B.email')->get();//Status 4 = Denegado
      $param = [
        'folio' => $query[0]->folio,
        'name'=>$query[0]->nombre_proyecto,
        'user'=>$query[0]->name,
      ];
      Mail::to($query[0]->email)->send(new DocumentopDenegado($param));
      //Mail::to('jcanul@sitwifi.com')->send(new DocumentopDenegado($param));
      return "true";
    }

    public function set_comment_compras_documentp(Request $request)
    {
      $documentp = Documentp::findOrFail($request->id_doc);
      $documentp->comentario_compras = $request->comentario_compras;
      $documentp->save();

      return "true";
    }

    public function check_document_type($id_doc)
    {
      $doc = Documentp::find($id_doc);
      $doc_type = $doc->doc_type;
      return $doc_type;
    }

    public function get_history_logs($id_documentp)
    {
      $result = DB::select('call px_documentp_logs_data(?)', array($id_documentp));

      return $result;
    }

    public function get_history_logs_project_advance($id_documentp)
    {
      $result = DB::select('call px_documentp_logs_advance_project_data(?)', array($id_documentp));

      return $result;
    }
    //Estatus->Revisado
    public function approval_one(Request $request)
    {
      $doc_id = json_decode($request->idents);
      $user = Auth::user()->id;
      $valor= 'false';

      for ($i=0; $i <= (count($doc_id)-1); $i++) {
        $sql = DB::table('documentp')
                    ->where('id', '=', $doc_id[$i])
                    ->update(['status_id' => '2', 'updated_at' => Carbon::now()]);
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $doc_id[$i];
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '2';
        $new_doc_state->save();
        $valor= 'true';
      }
      return $valor;
    }
    //Estatus->Autorizado
    public function approval_two(Request $request)
    {
      $doc_id = $request->idents;
      $user = Auth::user()->id;
      $valor= 'false';

      for ($i=0; $i <= (count($doc_id)-1); $i++) {
        $sql = DB::table('documentp')
                    ->where('id', '=', $doc_id[$i])
                    ->update(['status_id' => '3', 'updated_at' => Carbon::now()]);
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $doc_id[$i];
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '3';
        $new_doc_state->save();

        $document = Documentp::find($doc_id[$i]);
        $document->fecha_aprobacion = \Carbon\Carbon::now();
        $document->save();

        $this->send_mail_aproved($doc_id[$i]);

        $valor= 'true';
      }
      return $valor;
    }
    //Estatus->Entregado
    public function delivery_doc(Request $request)
    {
      $doc_id = json_decode($request->idents);
      $user = Auth::user()->id;
      $valor= 'false';

      for ($i=0; $i <= (count($doc_id)-1); $i++) {
        $sql = DB::table('documentp')
                    ->where('id', '=', $doc_id[$i])
                    ->update(['status_id' => '5', 'updated_at' => Carbon::now()]);
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $doc_id[$i];
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '5';
        $new_doc_state->save();

        $document = Documentp::find($doc_id[$i]);
        $document->fecha_entrega = \Carbon\Carbon::now();
        $document->save();
        // Status de carrito a bloqueado
        $document_cart = Documentp_cart::find($document->documentp_cart_id);
        $document_cart->status_id = 2;
        $document_cart->save();

        $valor= 'true';
      }
      return $valor;
    }

    public function get_history_project_advance(Request $request)
    {
      $input_date_i= $request->date_to_search;

      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
      }
      else {
        $date_current = date('Y-m');
        $date = $date_current.'-01';
      }

      $result = DB::select('CALL px_documentop_mensual_advance(?)' , array($date));

      return $result;
    }

    public function deny_docp(Request $request)
    {
       $user = Auth::user()->id;
       $doc_id= $request->get('idents');
       $valor= 'false';
       $comment = $request->comm;

      if (auth()->user()->can('View level two documentp notification')){
        $count_md = DB::table('documentp')->where('id', '=', $doc_id)->where('status_id', '!=', '4')->count();
        if ($count_md != '0') {
          $sql = DB::table('documentp')->where('id', '=', $doc_id)->update(['status_id' => '4', 'updated_at' => Carbon::now()]);
          $new_reg_status = new Documentp_status_user;
          $new_reg_status->documentp_id = $doc_id;
          $new_reg_status->user_id = $user;
          $new_reg_status->status_id = '4';
          $new_reg_status->save();
          if($comment != " " && $comment != null){
            $new_reg_denydoc_comm = new Deny_docpcomment;
            $new_reg_denydoc_comm->description = $comment;
            $new_reg_denydoc_comm->documentp_id = $doc_id;
            $new_reg_denydoc_comm->user_id = $user;
            $new_reg_denydoc_comm->save();
          }
          $valor= 'true';
        }
      }
      if (auth()->user()->can('View level three documentp notification')){
        $count_md = DB::table('documentp')->where('id', '=', $doc_id)->where('status_id', '!=', '4')->count();
        if ($count_md != '0') {
          $sql = DB::table('documentp')->where('id', '=', $doc_id)->update(['status_id' => '4', 'updated_at' => Carbon::now()]);
          $new_reg_status = new Documentp_status_user;
          $new_reg_status->documentp_id = $doc_id;
          $new_reg_status->user_id = $user;
          $new_reg_status->status_id = '4';
          $new_reg_status->save();
          if($comment != " " && $comment != null){
            $new_reg_denydoc_comm = new Deny_docpcomment;
            $new_reg_denydoc_comm->description = $comment;
            $new_reg_denydoc_comm->documentp_id = $doc_id;
            $new_reg_denydoc_comm->user_id = $user;
            $new_reg_denydoc_comm->save();
          }
          $valor= 'true';
        }
       }

      return $valor;
    }

    public function get_deny_comment($id)
    {
      $result = DB::table('deny_docp_comment')->join('users', 'user_id', '=' ,'users.id')
                    ->select('deny_docp_comment.description', 'deny_docp_comment.created_at', 'users.name')
                    ->where('documentp_id', $id)->get();
      return $result;
    }

    public function get_status_user($id)
    {
      $result = DB::table('documentp_status_users')
                    ->join('users', 'user_id', '=' ,'users.id')
                    ->join('documentp_status', 'status_id', '=' ,'documentp_status.id')
                    ->select('documentp_status_users.*', 'users.name', 'users.name', 'documentp_status.name AS name_status')
                    ->where('documentp_id', $id)->get();
      return $result;
    }

    public function send_mail_aproved($id_doc)
    {
      $doc = Documentp::findOrFail($id_doc);
      $folio = $doc->folio;
      $fecha_aprobacion = $doc->fecha_aprobacion;
      $doc_type = $doc->doc_type;
      $total_ea = $doc->total_ea;
      $total_ena = $doc->total_ena;
      $total_mo = $doc->total_mo;
      $total = $doc->total_usd;
      $user = User::findOrFail($doc->itc_id);
      $itc = $user->name;
      $itc_email = $user->email;

      $name_project = "";

      if($doc->nombre_proyecto == null || $doc->nombre_proyecto == ''){
        $sql = DB::table('hotels')->select('id','Nombre_hotel')->where('id', $doc->anexo_id)->get();
        $name_project = $sql[0]->Nombre_hotel;
      }else{
        $name_project = $doc->nombre_proyecto;
      }

      $parametros1 = [
        'fecha_aprobacion' => $fecha_aprobacion,
        'folio' => $folio,
        'doc_type' => $doc_type,
        'nombre_proyecto' => $name_project,
        'itc' => $itc,
        'total_ea' => $total_ea,
        'total_ena' => $total_ena,
        'total_mo' => $total_mo,
        'total' => $total
      ];

      $copias = ['aguevara@sitwifi.com', 'mdeoca@sitwifi.com', 'mmoreno@sitwifi.com'];
      Mail::to($itc_email)->cc($copias)->send(new SolicitudCompraAprobada($parametros1));
      //Mail::to('rkuman@sitwifi.com')->send(new SolicitudCompraAprobada($parametros1));
    }

}
