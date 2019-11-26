<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Pagination\Paginator;
use \Illuminate\Support\Collection;
use \Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Projects\{Documentp, Documentp_cart, In_Documentp_cart, Cotizador};
use App\Models\Projects\{Cotizador_status_user, Cotizador_approvals, Cotizador_approval_propuesta};
use App\Mail\SolicitudCompra;
use App\User;
use Carbon\Carbon;
use View;
use PDF;
use Mail;
use Auth;
use DB;

class QuotingController extends Controller
{
    public function index(Request $request)
    {
      $categories = DB::table('products_categories')->select('id', 'name')->get();
      $grupos = DB::table('cadenas')->select('id', 'name')->orderBy('name')->get();
      $verticals = DB::table('verticals')->select('id','name')->get();
      $itc = DB::select('CALL px_ITC_todos_V2');
      $comerciales = DB::select('CALL px_resguardoXgrupo_users(?)', array(2));
      $type_service = DB::table('documentp_type')->select('id', 'name')->get();
      $installation = DB::table('documentp_installation')->select('id', 'name')->get();
      $product_sw = DB::select('CALL px_products_swiches');
      $product_ap = DB::select('CALL px_products_antenas');
      $product_fw = DB::select('CALL px_products_firewalls');

      return view('permitted.quoting.quoting', compact('categories', 'itc', 'verticals', 'comerciales', 'type_service',
                  'grupos','installation' ,'product_sw', 'product_ap', 'product_fw'));
    }

    public function index_history()
    {
        return view('permitted.quoting.quote_history');
    }

    public function get_history_quoting_out_parameters()
    {
        return view('permitted.quoting.quote_history_out_parameters');
    }

    public function get_history_quoting_kickoff()
    {
        return view('permitted.quoting.quote_history_kickoff');
    }

    public function get_history_signature_kickoff()
    {
        return view('permitted.quoting.quote_history_signature');
    }

    public function view_auth()
    {
        return view('permitted.quoting.history_quoting_auth');
    }

    public function view_review()
    {
        return view('permitted.quoting.quote_history_review');
    }

    public function get_history_quoting(Request $request)
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
         $result = DB::select('CALL px_quoting_mensual(?,?)' , array($date, $id_user));
      }else{
         $result = DB::select('CALL px_quoting_mensual_all(?)' , array($date));
      }

      return $result;
    }

    public function get_history_auth_quoting(Request $request)
    {
      $input_date_i= $request->get('date_to_search');

      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
      }
      else {
        $date_current = date('Y-m');
        $date = $date_current.'-01';
      }

      $result = DB::select('CALL px_quoting_autorizados(?)' , array($date));

      return $result;
    }

    public function store(Request $request)
    {
      $id_user = Auth::user()->id;
      $fecha = $request->date;
      $nombre_proyecto = $request->proyecto;
      $num_sitios = $request->sites;
      $total_usd = $request->total;
      $lugar_instalacion = $request->lugar_instalacion;
      $num_oportunidad = $request->oportunity;
      $type_service = $request->type_service;
      $priority = 2; // Prioridad normal
      $itc_id = $request->itc;
      $grupo = $request->grupo;
      $comercial_id = $request->comercial;
      $densidad = $request->densidad;
      $vertical_id = $request->vertical;
      $total_ea = $request->total_ea;
      $total_ena = $request->total_ena;
      $total_mo = $request->total_mo;
      $total = $request->total;
      $grupo_id = 23;  // sin asignar
      $anexo_id = 7; // sin asignar
      $folio_new = $this->createFolio();
      $itc = User::find($itc_id);
      $itc_name = $itc->name;
      $flag  = "false";

      //Objeto del carrito de compras (Pedido)
      $shopping_cart = $request->shopping_cart;
      $shopping_cart_data = json_decode($shopping_cart, true);
      $tam_shopping_cart = count($shopping_cart_data);

      DB::beginTransaction();

      try {
        //Creando carrito
        $new_documentp_cart = new Documentp_cart;
        $new_documentp_cart->status_id = 1;
        $new_documentp_cart->created_at = \Carbon\Carbon::now();
        $new_documentp_cart->save();
        //Insertando productos del carrito
        for ($i=0; $i < $tam_shopping_cart; $i++)
        {
          $new_in_documentp_cart = new In_Documentp_cart;
          $new_in_documentp_cart->cantidad = $shopping_cart_data[$i]['cant_req'];
          $new_in_documentp_cart->cantidad_sugerida = $shopping_cart_data[$i]['cant_sug'];
          $new_in_documentp_cart->precio = $shopping_cart_data[$i]['precio'];
          $new_in_documentp_cart->descuento = $shopping_cart_data[$i]['descuento'];
          $new_in_documentp_cart->total = $shopping_cart_data[$i]['precio_total'];
          $new_in_documentp_cart->total_usd = $shopping_cart_data[$i]['precio_total_usd'];
          $new_in_documentp_cart->tipo_cambio = $request->tipo_cambio;
          $new_in_documentp_cart->purchase_order = 'N/A';
          $new_in_documentp_cart->documentp_cart_id = $new_documentp_cart->id;
          $new_in_documentp_cart->product_id = $shopping_cart_data[$i]['id'];
          $new_in_documentp_cart->created_at = \Carbon\Carbon::now();
          $new_in_documentp_cart->save();
        }

          $new_documentp = new Documentp;
          //Datos del proyecto
          $new_documentp->doc_type = $request->doc_type;
          $new_documentp->folio = $folio_new;
          $new_documentp->fecha = date('Y-m-d');
          $new_documentp->nombre_proyecto = $nombre_proyecto;
          $new_documentp->num_sitios = $num_sitios;
          $new_documentp->densidad = $densidad;
          $new_documentp->num_oportunidad = $num_oportunidad;
          $new_documentp->nombre_grupo = $grupo;
          $new_documentp->lugar_instalacion_id = $lugar_instalacion;
          $new_documentp->itc_id = $itc_id;
          $new_documentp->user_id = $id_user;
          $new_documentp->comercial_id = $comercial_id;
          $new_documentp->total_usd = $total;
          $new_documentp->total_ea = $total_ea;
          $new_documentp->total_ena = $total_ena;
          $new_documentp->total_mo = $total_mo;
          $new_documentp->total_viaticos = $request->total_viaticos;
          $new_documentp->vertical_id = $vertical_id;
          $new_documentp->tipo_servicio_id = $type_service;
          $new_documentp->status_id = 1;
          $new_documentp->grupo_id = $grupo_id;
          $new_documentp->anexo_id = $anexo_id;
          //financieros
          $new_documentp->plazo = $request->plazo;
          $new_documentp->renta_anticipada = $request->renta;
          $new_documentp->enlace = $request->enlace;
          $new_documentp->servicio_mensual = $request->servicio;
          $new_documentp->deposito_garantia = $request->deposito;
          $new_documentp->capex = $request->capex;
          $new_documentp->instalaciones = $request->instalaciones;
          $new_documentp->indirectos = $request->indirectos;
          $new_documentp->utilidad_venta_ea = $request->utilidad;

          $new_documentp->priority_id = $priority;
          $new_documentp->num_edit = 0;
          $new_documentp->documentp_cart_id = $new_documentp_cart->id;
          $new_documentp->created_at = \Carbon\Carbon::now();
          $new_documentp->updated_at = \Carbon\Carbon::now();
          $new_documentp->save();

          //Cotizador
          $new_cotizador = new Cotizador;
          $new_cotizador->id_doc = $new_documentp->id;
          $new_cotizador->created_at = \Carbon\Carbon::now();
          $new_cotizador->save();
          //Inversion
          DB::table('cotizador_inversion')->insert([
              ['cotizador_id' => $new_cotizador->id,
               'inversion_ea' => $request->total_ea,
               'inversion_ena' => $request->total_ena,
               'inversion_ea_percent' => $request->rubro_ea_percent,
               'inversion_ena_percent' => $request->rubro_ena_percent,
               'mano_obra' => $request->total_mo,
               'mano_obra_percent' => $request->rubro_mo_percent,
               'indirectos' => $request->rubro_indirectos,
               'indirectos_percent' => $request->rubro_indirectos_percent,
               'comision' => $request->rubro_comision,
               'comision_percent' => $request->rubro_comision_percent,
               'inversion_real' => $request->total_rubros,
               'created_at' => \Carbon\Carbon::now()
              ]
          ]);
          //Gastos
          DB::table('cotizador_gastos_mensuales')->insert([
              ['cotizador_id' => $new_cotizador->id,
               'credito_mensual' => $request->credito_mensual,
               'credito_mensual_percent' => $request->credito_mensual_percent,
               'mantto_seg_otro' => $request->gasto_mtto,
               'mantto_seg_otro_percent' => $request->gasto_mtto_percent,
               'enlace' => $request->gasto_enlace,
               'total_gasto_mensual' => $request->total_gastos,
               'created_at' => \Carbon\Carbon::now()
              ]
          ]);
          //Modelo de negocios
          DB::table('cotizador_modelo_negocio')->insert([
              ['cotizador_id' => $new_cotizador->id,
               'enlace' => $request->modelo_enlace,
               'mensual_habitacion' => $request->modelo_mensual_hab,
               'serv_mensual' => $request->modelo_serv_mens,
               'antenas' => $request->modelo_antenas,
               'habitacion_enlace' => $request->modelo_hab_enlace,
               'created_at' => \Carbon\Carbon::now()
              ]
          ]);
          //Opcionalmente
          DB::table('cotizador_opciones')->insert([
              ['cotizador_id' => $new_cotizador->id,
               'costo_poliza' => $request->opcional_poliza,
               'utilidad_poliza' => $request->utilidad_poliza,
               'comision_poliza' => $request->comision_poliza,
               'precio_poliza' => $request->precio_poliza,
               'created_at' => \Carbon\Carbon::now()
              ]
          ]);
          //Servicio administrado
          DB::table('cotizador_servadm_usd')->insert([
              ['cotizador_id' => $new_cotizador->id,
               'renta_mas_enlace' => $request->renta_enlace,
               'capex' => $request->serv_capex,
               'renta_anticipada' => $request->serv_renta,
               'plazo' => $request->serv_plazo,
               'hab_por_antena' => $request->serv_hab_antenas,
               'servadm_por_habitacion' => $request->serv_adm_habitacion,
               'created_at' => \Carbon\Carbon::now()
              ]
          ]);
          //Objetivos
          DB::table('cotizador_objetivos')->insert([
              ['cotizador_id' => $new_cotizador->id,
               'utilidad_mensual' => $request->utilidad_mensual,
               'utilidad_mensual_percent' => 0,
               'utilidad_proyecto' => $request->utilidad_proyecto,
               'utilidad_proyecto_percent' => 0,
               'vtc' => $request->vtc,
               'renta_mensual_inversion' => $request->renta_mensual_inversion,
               'utilidad_inversion' => $request->utilidad_inversion,
               'utilidad_renta_percent' => $request->utilidad_renta,
               'costo_por_ap' => $request->costo_mo_ap,
               'tir' => $request->tir,
               'tiempo_retorno' => $request->tiempo_retorno,
               'utilidad_3_anios' => $request->utilidad_3_anios,
               'utilidad_3_anios_min' => $request->utilidad_3_anios_percent,
               'servicio_por_ap' => $request->serv_ap,
               'created_at' => \Carbon\Carbon::now()
              ]
          ]);

          $update_cotizador = new Cotizador();
          $update_cotizador->set_objetivos_cotizador($new_documentp->id, $request->objetivos_cotizador);
          $update_cotizador->set_status_cotizador($new_documentp->id);

          DB::commit();

          $name_project = "";

          if($new_documentp->nombre_proyecto == null || $new_documentp->nombre_proyecto == ''){
            $sql = DB::table('hotels')->select('id','Nombre_hotel')->where('id', $new_documentp->anexo_id)->get();
            $name_project = $sql[0]->Nombre_hotel;
          }else{
            $name_project = $new_documentp->nombre_proyecto;
          }

          $parametros1 = [
            'fecha' => $new_documentp->created_at,
            'folio' => $folio_new,
            'doc_type' => $new_documentp->doc_type,
            'nombre_proyecto' => $name_project,
            'itc' => $itc_name,
            'total_ea' => $total_ea,
            'total_ena' => $total_ena,
            'total_mo' => $total_mo,
            'total_viaticos' => $request->total_viaticos,
            'total' => $total
          ];

          //Mail::to('rdelgado@sitwifi.com')->cc('aarciga@sitwifi.com')->send(new SolicitudCompra($parametros1));
          Mail::to('rkuman@sitwifi.com')->send(new SolicitudCompra($parametros1));

          $flag = "true";

      } catch(\Exception $e){
          $error = $e->getMessage();
        	DB::rollback();
          dd($error);
      }

      return  $flag;

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
      }else{
         $result = DB::select('CALL px_cotizador_mensual_all(?)' , array($date));
      }

      return $result;
    }

    public function export_invoice($id_documentp,$id_cart)
    {
      $id_doc = $id_documentp;
      $cart = $id_cart;
      $data = DB::select('CALL px_docupentop_materialesXcarrito(?)' , array($cart));

      if($data == []){
        return view('permitted.documentp.empty_cart');
      }

      $data_header = DB::select('CALL px_documentop_data(?)', array($id_doc));
      $collection = collect($data);
      // Filtrando categorias de los productos
      $equipo_activo = $collection->whereIn('categoria_id', [4, 6, 14]);
      $materiales = $collection->whereNotIn('categoria_id', [4, 6, 7, 14, 15]);
      $mano_obra = $collection->where('categoria_id', 7);
      $viatico = $collection->where('categoria_id', 15);

      $folio = $data_header[0]->folio;
      $fecha = $data_header[0]->fecha;
      $itc = $data_header[0]->ITC;
      $comercial = $data_header[0]->comercial;
      $vertical = $data_header[0]->vertical;
      $tipo_cambio = $data[0]->tipo_cambio;
      ($data_header[0]->nombre_proyecto == null) ? $nombre_proyecto = $data_header[0]->anexo : $nombre_proyecto = $data_header[0]->nombre_proyecto;
      $status = $data_header[0]->status_id;
      $doc_type = $data_header[0]->doc_type;

      // Enviando datos a la vista de la factura
      $pdf = PDF::loadView('permitted.quoting.invoice_customer',
      compact('equipo_activo', 'materiales', 'mano_obra', 'viatico','fecha', 'folio','tipo_cambio', 'itc',
              'nombre_proyecto', 'comercial', 'vertical', 'status', 'doc_type'));

      return $pdf->stream();
    }

    public function get_table_products($id_documentp, $id_cart)
    {
      $id_doc = $id_documentp;
      $cart = $id_cart;
      $data = DB::select('CALL px_docupentop_materialesXcarrito(?)' , array($cart));

      if($data == []){
        return view('permitted.documentp.empty_cart');
      }

      $tipo_cambio = $data[0]->tipo_cambio;
      $collection = collect($data);
      // Filtrando categorias de los productos
      $equipo_activo = $collection->whereIn('categoria_id', [4, 6, 14]);
      $materiales = $collection->whereNotIn('categoria_id', [4, 6, 7, 14, 15]);
      $mano_obra = $collection->where('categoria_id', 7);
      $viatico = $collection->where('categoria_id', 15);

      if (auth()->user()->can('View level zero documentp notification')) {
        return view('permitted.quoting.table_products_modal_itc', compact('equipo_activo', 'materiales', 'mano_obra', 'viatico','tipo_cambio'))->render();
      }else{
        return view('permitted.quoting.table_products_modal_compras', compact('equipo_activo', 'materiales', 'mano_obra', 'viatico','tipo_cambio'))->render();
      }

    }

    public function set_status_quoting(Request $request)
    {
      $doc_id = json_decode($request->idents);
      $status = $request->status_cotizador;
      $user = Auth::user()->id;
      $valor= 'false';

      for ($i=0; $i <= (count($doc_id)-1); $i++) {
        $sql = DB::table('documentp')
                    ->where('id', '=', $doc_id[$i])
                    ->update(['cotizador_status_id' => $status, 'updated_at' => Carbon::now()]);
        $new_doc_state = new Cotizador_status_user;
        $new_doc_state->documentp_id = $doc_id[$i];
        $new_doc_state->user_id = $user;
        $new_doc_state->cotizador_status_id = $status;
        $new_doc_state->save();

        $document = Documentp::find($doc_id[$i]);
        $document->fecha_aprobacion = \Carbon\Carbon::now();
        $document->save();

        $valor= 'true';
      }
      return $valor;
    }

    public function quoting_approval_directive(Request $request)
    {
      $doc_id = json_decode($request->idents);
      $status = $request->status_cotizador;
      $user = Auth::user()->id;
      $valor= 'false';

      for ($i=0; $i <= (count($doc_id)-1); $i++) {
        $sql = DB::table('documentp')
                    ->where('id', '=', $doc_id[$i])
                    ->update(['cotizador_status_id' => $status, 'updated_at' => Carbon::now()]);
        $new_doc_state = new Cotizador_status_user;
        $new_doc_state->documentp_id = $doc_id[$i];
        $new_doc_state->user_id = $user;
        $new_doc_state->cotizador_status_id = $status;
        $new_doc_state->save();

        $document = Documentp::find($doc_id[$i]);
        $document->fecha_aprobacion = \Carbon\Carbon::now();
        $document->save();

        $valor= 'true';
      }
      return $valor;
    }

    public function get_approvals_propuesta_comercial($id_doc)
    {
      $documentp = DB::select('CALL px_documentop_data(?)', array($id_doc));
      $cotizador = Cotizador::where('id_doc', $id_doc)->first();
      $aprovals_propuesta = Cotizador_approval_propuesta::firstOrCreate(['cotizador_id' => $cotizador->id]);
      $check_approvals = DB::select('CALL px_valida_aprobado_propuesta_comercial(?)', array($cotizador->id));
      
      return view('permitted.quoting.approvals_propuesta_comercial', compact('documentp', 'aprovals_propuesta', 'check_approvals'))->render();
    }

    public function approval_directives_propuesta_comercial(Request $request)
    {
       
      $cotizador = Cotizador::where('id_doc', $request->id)->first();
      $aprovals_propuesta = Cotizador_approval_propuesta::firstOrCreate(['cotizador_id' => $cotizador->id]);
      $aprovals_propuesta->administracion = $request->administracion;
      $aprovals_propuesta->director_comercial = $request->director_comercial;
      $aprovals_propuesta->director_operaciones = $request->director_operaciones;
      $aprovals_propuesta->director_general = $request->director_general;
      $aprovals_propuesta->save();
    
      $check_approvals = DB::select('CALL px_valida_aprobado_propuesta_comercial(?)', array($cotizador->id));
        
      if($check_approvals[0]->aprobado_direccion == 1){
        $documentp = Documentp::find($request->id);
        $documentp->cotizador_status_id = 4; // Se autoriza cotizador para propuesta
        $documentp->save();
      }    

      return response()->json(['status' => true]);
    }

    public function get_quoting_objetives($id_doc)
    {
      $result = DB::select(' CALL px_objetivos_cotizador_by_doc(?)', array($id_doc));

      return $result;
    }
    
    public function createFolio()
    {
      $nomenclatura = "DOC-";
      $current_date = date('Y-m-d');
      date_default_timezone_set('America/Cancun');
      setlocale(LC_TIME, 'es_ES', 'esp_esp');
      $complemento= strtoupper(strftime("%b%y", strtotime($current_date)));

      $res = DB::table('documentp')->latest()->first();
      if (empty($res)) {
        $nomenclatura = $nomenclatura.$complemento.'-'."000001";
        return $nomenclatura;
      }else{
        $folio_latest = $res->folio;

        if (empty($folio_latest)) {
          $nomenclatura = $nomenclatura.$complemento.'-'."000001";
          return $nomenclatura;
        }else{
          $explode = explode('-', $folio_latest);
          $num_folio = (int)$explode[2];
          $num_folio = $num_folio + 1;
          $digits = strlen($num_folio);

          switch ($digits) {
            case 1:
              $num_folio = (string)$nomenclatura .$complemento.'-'. "00000" . $num_folio;
              break;
            case 2:
              $num_folio = (string)$nomenclatura .$complemento.'-'. "0000" . $num_folio;
              break;
            case 3:
              $num_folio = (string)$nomenclatura .$complemento.'-'. "000" . $num_folio;
              break;
            case 4:
              $num_folio = (string)$nomenclatura .$complemento.'-'. "00" . $num_folio;
              break;
            case 5:
              $num_folio = (string)$nomenclatura .$complemento.'-'. "0" . $num_folio;
              break;
            default:
              $num_folio = (string)$nomenclatura .$complemento.'-'. $num_folio;
              break;
          }
          return (string)$num_folio;
        }
      }
    }


}
