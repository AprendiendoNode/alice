<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Projects\Documentp_status_user;
use App\Models\Projects\{Documentp, Documentp_cart, In_Documentp_cart, Cotizador, Cotizador_gastos, Cotizador_inversion};
use App\Models\Projects\{Kickoff_approvals, Kickoff_compras, Kickoff_contrato, Kickoff_instalaciones, Kickoff_lineabase, Kickoff_perfil_cliente, Kickoff_project, Kickoff_soporte, Kickoff_comisiones};
use App\Mail\SolicitudCompra;
use App\Models\Base\Message;
use App\Notifications\MessageDocumentp;
use App\Mail\SolicitudCompraAprobada;
use App\User;
use App\Cadena;
use View;
use PDF;
use Mail;
use Auth;
use DB;

class KickoffController extends Controller
{
    public function index(Request $request)
    {
      $id = $request->id_doc_3;
      $document = DB::select('CALL px_documentop_data(?)', array($id));
      $documentP = Documentp::find($id);
      $id_document = $documentP->id;
      $in_document_cart = In_Documentp_cart::where('documentp_cart_id', $document[0]->documentp_cart_id)->first();
      //dd($document);
      $tipo_cambio = $in_document_cart->tipo_cambio;
      $installation = DB::table('documentp_installation')->select('id', 'name')->get();
      $adquisition = DB::table('documentp_adquisition')->select('id', 'name')->get();
      $payments = DB::table('payment_ways')->whereIn('id', [1, 3, 22])->get();
      $vendedores = DB::select(' CALL px_usersXdepto(?)', array(5));
      $inside_sales = DB::select(' CALL px_usersXdepto(?)', array(6));
      $colaboradores = DB::select(' CALL px_colaboradores()', array());

      $vtc = "Proyecto sin cotizador";
      $gasto_mtto_percent = 0;
      $gasto_mtto = 0;
      $comision = 0.0;
      $credito_mensual_percent = 0;
      $cotizador = DB::table('cotizador')->select('id', 'id_doc')->where('id_doc', $document[0]->id)->get();
      $real_ejercido = $this->get_presupuesto_ejercido($document[0]->id);
      $num_aps = $this->get_num_aps($document[0]->documentp_cart_id);

      if(count($cotizador) == 1) {
        $objetivos = DB::table('cotizador_objetivos')->select()->where('cotizador_id', $cotizador[0]->id)->get();
        $gastos_mensuales = Cotizador_gastos::findOrFail(['cotizador_id' => $cotizador[0]->id]);
        $inversion = Cotizador_inversion::findOrFail(['cotizador_id' => $cotizador[0]->id]);
        $comision = $inversion[0]->comision;
        $vtc = $objetivos[0]->vtc;
        $gasto_mtto = $gastos_mensuales[0]->mantto_seg_otro;
        $gasto_mtto_percent = $gastos_mensuales[0]->mantto_seg_otro_percent;
        $credito_mensual_percent = $gastos_mensuales[0]->credito_mensual_percent;
      }
      //KICKOFF DATA
      $kickoff = Kickoff_project::firstOrCreate(['id_doc' => $id_document]);
      $kickoff_approvals = Kickoff_approvals::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_compras = Kickoff_compras::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_contrato = Kickoff_contrato::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_instalaciones = Kickoff_instalaciones::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_lineabase = Kickoff_lineabase::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_perfil_cliente = Kickoff_perfil_cliente::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_soporte = Kickoff_soporte::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $kickoff_comisiones = Kickoff_comisiones::firstOrCreate(['kickoff_id' => $kickoff->id]);
      $approval_dir = DB::select('CALL px_valida_aprobado_direccion(?)', array($kickoff_approvals->id));

      $cadenas = DB::table('cadenas')->select('id', 'name')->orderBy('name')->get();

      return view('permitted.planning.kick_off_edit', compact('document', 'cadenas','installation','approval_dir' ,'adquisition','inside_sales' ,'vendedores', 'colaboradores','payments','tipo_cambio', 'vtc', 'num_aps' ,'kickoff_approvals',
                  'kickoff_contrato', 'kickoff_instalaciones','kickoff_compras' ,'kickoff_lineabase', 'kickoff_perfil_cliente', 'kickoff_soporte', 'kickoff_comisiones', 'gasto_mtto', 'comision','gasto_mtto_percent','credito_mensual_percent' ,'real_ejercido' ));
    }

    public function get_num_aps($cart_id)
    {
      $cart_products = DB::select('CALL px_docupentop_materialesXcarrito(?)' , array($cart_id));
      $collection_cart = collect($cart_products);
      $equipo_activo = $collection_cart->whereIn('categoria_id', [4, 6, 14]);
      $api = 0;
      $ape = 0;
      $aps = 0;
      foreach ($equipo_activo as $product)
      {
        if(substr($product->code, 0, 3) == "API"){
          $api+=$product->cantidad;
        }elseif (substr($product->code, 0, 3) == "APE") {
          $ape+=$product->cantidad;
        }
      }
      $aps = $api + $ape;
      $num_aps = array(
        'total' => $aps,
        'api' => $api,
        'ape' => $ape
      );

      return $num_aps;
    }

    public function setComision(Request $request)
    {
      $kickoff_comisiones = new Kickoff_comisiones();
      $comision = $kickoff_comisiones->calculateCommissionByDefault($request->id);
      $kickoff_comisiones->save_comision_default($request, $comision);

      return $comision;
    }

    public function get_presupuesto_ejercido($id_doc)
    {
      $document = Documentp::find($id_doc);
      $id_hotel = $document->anexo_id;
      $total_ea = 0.00;
      $total_ena = 0.00;
      $total_mo = 0.00;

      if($id_hotel != 7){
        $result = DB::select('CALL px_presupuesto_ejercido_docp(?)' , array($id_hotel));
        $total_ea = $result[0]->total_usd;
        $total_ena = $result[1]->total_usd;
        $total_mo= $result[2]->total_usd;
      }

      $ejercido = array(
        'total_ea' => $total_ea,
        'total_ena' => $total_ena,
        'total_mo' => $total_mo
      );

      return $ejercido;
    }

    public function update(Request $request)
    {
      $flag  = "false";
      $id = $request->id;

      DB::beginTransaction();
      try {
        //DOCUMENTO P
        $documentp = Documentp::find($id);
        $documentp->num_oportunidad = $request->num_oportunidad;
        $documentp->num_sitios = $request->sitios;
        $documentp->lugar_instalacion_id = $request->lugar_instalacion;
        $documentp->updated_at = \Carbon\Carbon::now();
        $documentp->save();

        $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();
        //PERFIL CLIENTE
        DB::table('kickoff_perfil_cliente')->where('kickoff_id', $kickoff->id)->update([
           'rfc' => $request->rfc,
           'razon_social' => $request->razon_social,
           'edo_municipio' => $request->edo_municipio,
           'contacto' => $request->contacto,
           'puesto' => $request->puesto,
           'telefono' => $request->telefono,
           'email' => $request->email,
           'direccion' => $request->direccion,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //CONTRATO
        DB::table('kickoff_contrato')->where('kickoff_id', $kickoff->id)->update([
           'num_contrato' => $request->num_contrato,
           'fecha_inicio' => $request->fecha_inicio,
           'fecha_termino' => $request->fecha_termino,
           'fecha_entrega' => $request->fecha_entrega,
           'servicio' => $request->servicio,
           'autorizacion_sitwifi' => $request->autorizacion_sitwifi,
           'autorizacion_cliente' => $request->autorizacion_cliente,
           'mantenimiento_vigencia' => $request->mantenimiento_vigencia,
           'tipo_adquisicion' => $request->tipo_adquisicion,
           'tipo_pago' => $request->tipo_pago,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //INSTALACIONES
        DB::table('kickoff_instalaciones')->where('kickoff_id', $kickoff->id)->update([
           'fecha_inicio' => $request->fecha_inicio_instalacion,
           'fecha_termino' => $request->fecha_termino_instalacion,
           'viaticos_proveedor' => $request->viaticos_proveedor,
           'calidad_contratista' => $request->calidad_contratista,
           'fecha_mantenimiento' => $request->fecha_mantenimiento,
           'fecha_acta_entrega' => $request->fecha_acta_entrega,
           'fecha_entrega_memoria_tecnica' => $request->fecha_entrega_memoria_tecnica,
           'observaciones' => $request->observaciones,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //SOPORTE
        DB::table('kickoff_soporte')->where('kickoff_id', $kickoff->id)->update([
           'licencias' => $request->licencias,
           'proveedor_enlace' => $request->proveedor_enlace,
           'plazo_enlace' => $request->plazo_enlace,
           'fecha_mantenimiento' => $request->fecha_mantenimiento_soporte,
           'cantidad_equipos_monitoriados' => $request->cantidad_equipos_monitoriados,
           'nombre_ti_cliente' => $request->nombre_ti_cliente,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //COMPRAS
        DB::table('kickoff_compras')->where('kickoff_id', $kickoff->id)->update([
           'fecha_entrega_ea' => $request->fecha_entrega_ea,
           'fecha_entrega_ena' => $request->fecha_entrega_ena,
           'fecha_operacion_enlace' => $request->fecha_entrega_operacion_enlace,
           'fecha_contratacion_enlace' => $request->fecha_contratacion_enlace,
           'proveedor1' => $request->proveedor1,
           'proveedor2' => $request->proveedor2,
           'proveedor3' => $request->proveedor3,
           'proveedor4' => $request->proveedor4,
           'proveedor5' => $request->proveedor5,
           'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::commit();
        $flag  = "true";

      } catch(\Exception $e){
        $e->getMessage();
        DB::rollback();
        //dd($e);
        return $e;
      }

      return $flag;
    }

    public function approval_administracion($id)
    {
      $flag = "0";
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

        DB::beginTransaction();
        try {
          DB::table('kickoff_approvals')->where('kickoff_id', $kickoff->id)->update([
             'administracion' => 1,
             'updated_at' => \Carbon\Carbon::now()
          ]);
          //Cambiando status de documento a "EN REVISIÓN"
          $documentp->status_id = 2;
          $documentp->save();

          $user = Auth::user()->id;
          $new_doc_state = new Documentp_status_user;
          $new_doc_state->documentp_id = $documentp->id;
          $new_doc_state->user_id = $user;
          $new_doc_state->status_id = '2';
          $new_doc_state->save();

          if(!$this->check_approvals($documentp->id)){
            $flag = "1";
          }else{
            $flag = "2";
          }
          DB::commit();

      } catch(\Exception $e){
        $e->getMessage();
        DB::rollback();
        return $e;
      }

      return $flag;
    }

    public function approval_comercial($id)
    {
      $flag = "0";
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

      DB::beginTransaction();
      try {
        DB::table('kickoff_approvals')->where('kickoff_id', $kickoff->id)->update([
           'director_comercial' => 1,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //Cambiando status de documento a "EN REVISIÓN"
        $documentp->status_id = 2;
        $documentp->save();

        $user = Auth::user()->id;
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $documentp->id;
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '2';
        $new_doc_state->save();

        if(!$this->check_approvals($documentp->id)){
          $flag = "1";
        }else{
          $flag = "2";
        }
        DB::commit();

    } catch(\Exception $e){
      $e->getMessage();
      DB::rollback();
      return $e;
    }

      return $flag;
    }

    public function approval_proyectos($id)
    {
      $flag = "0";
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

      DB::beginTransaction();
      try {
        DB::table('kickoff_approvals')->where('kickoff_id', $kickoff->id)->update([
           'proyectos' => 1,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //Cambiando status de documento a "EN REVISIÓN"
        $documentp->status_id = 2;
        $documentp->save();

        $user = Auth::user()->id;
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $documentp->id;
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '2';
        $new_doc_state->save();

        if(!$this->check_approvals($documentp->id)){
          $flag = "1";
        }else{
          $flag = "2";
        }
        DB::commit();

    } catch(\Exception $e){
      $e->getMessage();
      DB::rollback();
      return $e;
    }

      return $flag;
    }

    public function approval_soporte($id)
    {
      $flag = "0";
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

      DB::beginTransaction();
      try {
        DB::table('kickoff_approvals')->where('kickoff_id', $kickoff->id)->update([
           'soporte' => 1,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //Cambiando status de documento a "EN REVISIÓN"
        $documentp->status_id = 2;
        $documentp->save();

        $user = Auth::user()->id;
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $documentp->id;
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '2';
        $new_doc_state->save();

        if(!$this->check_approvals($documentp->id)){
          $flag = "1";
        }else{
          $flag = "2";
        }
        DB::commit();

    } catch(\Exception $e){
      $e->getMessage();
      DB::rollback();
      return $e;
    }

      return $flag;
    }

    public function approval_planeacion($id)
    {
      $flag = "0";
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

      DB::beginTransaction();
      try {
        DB::table('kickoff_approvals')->where('kickoff_id', $kickoff->id)->update([
           'planeacion' => 1,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //Cambiando status de documento a "EN REVISIÓN"
        $documentp->status_id = 2;
        $documentp->save();

        $user = Auth::user()->id;
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $documentp->id;
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '2';
        $new_doc_state->save();

        if(!$this->check_approvals($documentp->id)){
          $flag = "1";
        }else{
          $flag = "2";
        }
        DB::commit();

    } catch(\Exception $e){
      $e->getMessage();
      DB::rollback();
      return $e;
    }

      return $flag;
    }

    public function approval_itconcierge($id)
    {
      $flag = "0";
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

      DB::beginTransaction();
      try {
        DB::table('kickoff_approvals')->where('kickoff_id', $kickoff->id)->update([
           'itconcierge' => 1,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //Cambiando status de documento a "EN REVISIÓN"
        $documentp->status_id = 2;
        $documentp->save();

        $user = Auth::user()->id;
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $documentp->id;
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '2';
        $new_doc_state->save();

        if(!$this->check_approvals($documentp->id)){
          $flag = "1";
        }else{
          $flag = "2";
        }
        DB::commit();

    } catch(\Exception $e){
      $e->getMessage();
      DB::rollback();
      return $e;
    }

      return $flag;
    }

    public function approval_legal($id)
    {
      $flag = "0";
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

      DB::beginTransaction();
      try {
        DB::table('kickoff_approvals')->where('kickoff_id', $kickoff->id)->update([
           'legal' => 1,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //Cambiando status de documento a "EN REVISIÓN"
        $documentp->status_id = 2;
        $documentp->save();

        $user = Auth::user()->id;
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $documentp->id;
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '2';
        $new_doc_state->save();

        if(!$this->check_approvals($documentp->id)){
          $flag = "1";
        }else{
          $flag = "2";
        }
        DB::commit();

    } catch(\Exception $e){
      $e->getMessage();
      DB::rollback();
      return $e;
    }

      return $flag;
    }

    public function approval_facturacion($id)
    {
      $flag = "0";
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

      DB::beginTransaction();
      try {
        DB::table('kickoff_approvals')->where('kickoff_id', $kickoff->id)->update([
           'facturacion' => 1,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //Cambiando status de documento a "EN REVISIÓN"
        $documentp->status_id = 2;
        $documentp->save();

        $user = Auth::user()->id;
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $documentp->id;
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '2';
        $new_doc_state->save();

        if(!$this->check_approvals($documentp->id)){
          $flag = "1";
        }else{
          $flag = "2";
        }
        DB::commit();

    } catch(\Exception $e){
      $e->getMessage();
      DB::rollback();
      return $e;
    }

      return $flag;
    }

    public function approval_servicio_cliente($id)
    {
      $flag = "0";
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

      DB::beginTransaction();
      try {
        DB::table('kickoff_approvals')->where('kickoff_id', $kickoff->id)->update([
           'servicio_cliente' => 1,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //Cambiando status de documento a "EN REVISIÓN"
        $documentp->status_id = 2;
        $documentp->save();

        $user = Auth::user()->id;
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $documentp->id;
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '2';
        $new_doc_state->save();

        if(!$this->check_approvals($documentp->id)){
          $flag = "1";
        }else{
          $flag = "2";
        }
        DB::commit();

    } catch(\Exception $e){
      $e->getMessage();
      DB::rollback();
      return $e;
    }

      return $flag;
    }

    public function approval_director_operaciones($id)
    {
      $flag = "0";
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

      DB::beginTransaction();
      try {
        DB::table('kickoff_approvals')->where('kickoff_id', $kickoff->id)->update([
           'director_operaciones' => 1,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //Cambiando status de documento a "EN REVISIÓN"
        $documentp->status_id = 2;
        $documentp->save();

        $user = Auth::user()->id;
        $new_doc_state = new Documentp_status_user;
        $new_doc_state->documentp_id = $documentp->id;
        $new_doc_state->user_id = $user;
        $new_doc_state->status_id = '2';
        $new_doc_state->save();

        if(!$this->check_approvals($documentp->id)){
          $flag = "1";
        }else{
          $flag = "2";
        }
        DB::commit();

    } catch(\Exception $e){
      $e->getMessage();
      DB::rollback();
      return $e;
    }

      return $flag;
    }

    public function approval_director_general($id)
    {
      $flag = "0";
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

      DB::beginTransaction();

        try {
          DB::table('kickoff_approvals')->where('kickoff_id', $kickoff->id)->update([
            'director_general' => 1,
            'updated_at' => \Carbon\Carbon::now()
          ]);
          //Cambiando status de documento a "EN REVISIÓN"
          $documentp->status_id = 2;
          $documentp->save();

          $user = Auth::user()->id;
          $new_doc_state = new Documentp_status_user;
          $new_doc_state->documentp_id = $documentp->id;
          $new_doc_state->user_id = $user;
          $new_doc_state->status_id = '2';
          $new_doc_state->save();

          if(!$this->check_approvals($documentp->id)){
            $flag = "1";
          }else{
            $flag = "2";
          }
          DB::commit();

      } catch(\Exception $e){
        $e->getMessage();
        DB::rollback();
        
        return $e;
      }

      return $flag;
    }
    //Revisa que todos los departamentos hayan aprobado el kickoff
    public function check_approvals($id_doc)
    {
      $documentp = Documentp::findOrFail($id_doc);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();
      $kickoff_approvals = Kickoff_approvals::where('kickoff_id', $kickoff->id)->first();
      $approval_dir = DB::select('CALL px_valida_aprobado_direccion(?)', array($kickoff_approvals->id));
      //Revisando si todos los departamentos ya revisaron el documento
      if( $kickoff_approvals->proyectos == 1 &&
          $kickoff_approvals->soporte == 1 && $kickoff_approvals->planeacion == 1 && $kickoff_approvals->servicio_cliente &&
          $kickoff_approvals->itconcierge && $kickoff_approvals->legal && $kickoff_approvals->facturacion &&
          $approval_dir[0]->aprobado_direccion == 1){
          $kickoff_approvals->fecha_aprobacion_all = \Carbon\Carbon::now();
          $kickoff_approvals->save();
          //Cambiando status de documento  a "AUTORIZADO"
          $documentp->status_id = 3;
          $documentp->doc_type = 1;//Cambiando a "DOCUMENTO P"
          $documentp->fecha_aprobacion = \Carbon\Carbon::now();
          $documentp->save();
          $this->update_linea_base($documentp->id);
          $this->sendNotifications($documentp->id);
          return true;
      }else{
        return false;
      }

    }

    public function update_linea_base($id_doc)
    {
      $documentp = Documentp::findOrFail($id_doc);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();
      $lineaBase = Kickoff_lineabase::where('kickoff_id', $kickoff->id)->first();
      $lineaBase->total_ea = $documentp->total_ea;
      $lineaBase->total_ena = $documentp->total_ena;
      $lineaBase->total_mo = $documentp->total_mo;
      $lineaBase->total_usd = $documentp->total_usd;
      $lineaBase->save();
    }

    public function update_kickoff_contract(Request $request)
    {
      $flag  = "false";

      $id = $request->id;

      DB::beginTransaction();
      try {
        //DOCUMENTO P
        $documentp = Documentp::find($id);
        $documentp->grupo_id = $request->cadena;
        $documentp->anexo_id = $request->hotel_id;
        $documentp->save();

        $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();
        //PERFIL CLIENTE
        DB::table('kickoff_perfil_cliente')->where('kickoff_id', $kickoff->id)->update([
           'rfc' => $request->rfc,
           'razon_social' => $request->razon_social,
           'contacto' => $request->contacto,
           'telefono' => $request->telefono,
           'email' => $request->email,
           'direccion' => $request->direccion,
           'updated_at' => \Carbon\Carbon::now()
        ]);
        //CONTRATO
        DB::table('kickoff_contrato')->where('kickoff_id', $kickoff->id)->update([
           'fecha_inicio' => $request->fecha_inicio,
           'fecha_termino' => $request->fecha_termino,
           'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::commit();
        $flag  = "true";

      } catch(\Exception $e){
        $e->getMessage();
        DB::rollback();
        //dd($e);
        return $e;
      }

      return $flag;
    }

    public function update_kickoff_comision(Request $request)
    {
      $id = $request->id;
      $documentp = Documentp::find($id);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();

      DB::table('kickoff_comisiones')->where('kickoff_id', $kickoff->id)->update([
         'itconcierge' => $request->itconciergecomision,
         'vendedor' => $request->vendedor,
         'inside_sales' => $request->inside_sales,
         'colaborador' => $request->colaborador,
         'contacto' => $request->contacto_comercial,
         'cierre' => $request->cierre,
         'externo1' => $request->comision_externo,
         'externo2' => $request->comision_externo_2,
         'amount_itc' => $request->amount_comision_itc,
         'amount_vendedor' => $request->amount_comision_vendedor,
         'amount_inside_sales' => $request->amount_inside_sales,
         'amount_colaborador' => $request->amount_colaborador,
         'amount_contacto' => $request->amount_contacto,
         'amount_cierre' => $request->amount_cierre,
         'amount_externo1' => $request->amount_externo1,
         'amount_externo2' => $request->amount_externo2,
         'percent_itc' => $request->percent_comission_itc,
         'percent_vendedor' => $request->percent_comision_vendedor,
         'percent_inside_sales' => $request->percent_inside_sales,
         'percent_colaborador' => $request->percent_colaborador,
         'percent_contacto' => $request->percent_contacto,
         'percent_cierre' => $request->percent_cierre,
         'percent_externo1' => $request->percent_externo1,
         'percent_externo2' => $request->percent_externo2,
         'updated_at' => \Carbon\Carbon::now()
      ]);

    }

    public function sendNotifications($id_doc)
    {
      $documentp = Documentp::findOrFail($id_doc);
      $kickoff = Kickoff_project::where('id_doc', $documentp->id)->first();
      $kickoff_contrato = Kickoff_contrato::where('kickoff_id', $kickoff->id)->first();
      //Extrayendo usuarios
      $itc = $documentp->itc_id;
      $vendedor = $kickoff_contrato->vendedor;
      $inside_sales = $kickoff_contrato->inside_sales;

      $recipient_users = json_decode(User::find([258,11, 13, 14,16, 17, 18, 20, 21,406, 36, 87, 332, 333, $itc, $vendedor, $inside_sales])); //Todos los usuarios nivel 1
      array_push($recipient_users, (object) array('id' => Auth::user()->id)); //Creador de la notificación

      $recipients = [];

      foreach($recipient_users as $user) { array_push($recipients, $user->id); }

      $recipients = array_unique($recipients);

      foreach($recipients as $recipient_id) {

        $message = Message::create([
          'sender_id' => auth()->id(),
          'recipient_id' => $recipient_id,
          'body' =>  'Proyecto aprobado',
          'folio' => $documentp->folio,
          'proyecto' => $documentp->nombre_proyecto,
          'status' => 'Autorizado',
          'date' => \Carbon\Carbon::now(),
          'link' => route('view_history_documentp')
        ]);

        $recipient = User::find($recipient_id);
        $recipient->notify(new MessageDocumentp($message));
      }

    }

    public function generate_pdf_propuesta($id_doc)
    {
      $documentp = Documentp::findOrFail($id_doc);
      $servicios = DB::table('servicios_propuesta')->get();
      $condiciones = DB::table('condiciones_comerciales')->get();
      $user_email = Auth::user()->email;
      $data_cart = DB::select('CALL px_docupentop_materialesXcarrito(?)' , array($documentp->documentp_cart_id));
        
      $collection = collect($data_cart);
      // Filtrando equipo activo
      $equipo_activo = $collection->whereIn('categoria_id', [4, 6, 14]);
      // Enviando datos a la vista de la factura
      $pdf = PDF::loadView('permitted.planning.propuesta_comercial_pdf', compact('documentp', 'equipo_activo', 'servicios', 'condiciones'));
      
      return $pdf->stream();
    }

    public function send_mail_pdf_propuesta(Request $request)
    {
      $documentp = Documentp::findOrFail($request->id);
      $servicios = DB::table('servicios_propuesta')->get();
      $condiciones = DB::table('condiciones_comerciales')->get();
      $user_email = Auth::user()->email;
      $data_cart = DB::select('CALL px_docupentop_materialesXcarrito(?)' , array($documentp->documentp_cart_id));
      
      $collection = collect($data_cart);
      // Filtrando equipo activo
      $equipo_activo = $collection->whereIn('categoria_id', [4, 6, 14]);
      
      $pdf = PDF::loadView('permitted.planning.propuesta_comercial_pdf', compact('documentp', 'equipo_activo', 'servicios', 'condiciones'));

      $data = [
        'fecha_aprobacion' => 'test',
        'folio' => '0000', 
      ];

      Mail::send('mail.propuestaComercial', $data,function ($message) use ($pdf, $documentp, $user_email){
          $message->subject('Propuesta Comercial ' . $documentp->nombre_proyecto);
          $message->from('desarrollo@sitwifi.com', 'Propuesta comercial');
          $message->to($user_email);
          $message->attachData($pdf->output(), 'Propuesta_'. $documentp->nombre_proyecto. '.pdf');
      });

      return response()->json([
          'email' => $user_email
      ]);

    }


}
