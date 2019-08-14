<?php

namespace App\Http\Controllers\Projects;

use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Pagination\Paginator;
use \Illuminate\Support\Collection;
use \Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Projects\{Documentp, Documentp_cart, In_Documentp_cart, Documentp_project};
use App\Models\Projects\{Cotizador, Cotizador_gastos, Cotizador_inversion, Cotizador_modelo, Cotizador_objetivos, Cotizador_opciones, Cotizador_srvadm};

class QuotingEditController extends Controller
{
  public function index(Request $request)
  {

    try{
      $id = $request->id_docp2;
      $documentP = Documentp::find($id);
      $id_document = $documentP->id;
      $itc_id = $documentP->itc_id;
      $user_elaboro = $documentP->user_id;
      $hour_created = $documentP->updated_at;
      $hour_created =  \Carbon\Carbon::parse($hour_created);
      $data_header = DB::select('CALL px_documentop_data(?)', array($documentP->id));
      $folio = $documentP->folio;
      $num_edit = $documentP->num_edit;
      $cart = $documentP->documentp_cart_id;
      $document_cart = Documentp_cart::find($cart);
      $in_document_cart = In_Documentp_cart::where('documentp_cart_id', $cart)->first();
      $tipo_cambio = $in_document_cart->tipo_cambio;
      $info = '';
      //Datos cotizador_id
      $cotizador = Cotizador::firstOrCreate(['id_doc' => $id_document]);
      $cotizador_opciones = Cotizador_opciones::firstOrCreate(['cotizador_id' => $cotizador->id]);
      $cotizador_gastos_mensuales = Cotizador_gastos::firstOrCreate(['cotizador_id' => $cotizador->id]);
      $cotizador_inversion = Cotizador_inversion::firstOrCreate(['cotizador_id' => $cotizador->id]);
      $cotizador_modelo = Cotizador_modelo::firstOrCreate(['cotizador_id' => $cotizador->id]);
      $cotizador_objetivos = Cotizador_objetivos::firstOrCreate(['cotizador_id' => $cotizador->id]);
      $cotizador_servadm = Cotizador_srvadm::firstOrCreate(['cotizador_id' => $cotizador->id]);

      //Data formulario
      $grupos = DB::table('cadenas')->select('id', 'name')->orderBy('name')->get();
      $anexos = DB::table('hotels')->select('id', 'Nombre_hotel')->orderBy('Nombre_hotel')->get();
      $categories = DB::table('categories')->select('id', 'name')->get();
      $verticals = DB::table('verticals')->select('id','name')->get();
      $itc = DB::select('CALL px_ITC_todos');
      $comerciales = DB::select('CALL px_resguardoXgrupo_users(?)', array(2));
      $type_service = DB::table('documentp_type')->select('id', 'name')->get();
      $installation = DB::table('documentp_installation')->select('id', 'name')->get();
      $priorities = DB::table('documentp_priorities')->select('id', 'name')->get();
      $viewPermitted = view('permitted.quoting.show' ,compact('id_document', 'hour_created','grupos', 'anexos','data_header', 'tipo_cambio',
                            'categories', 'itc', 'verticals', 'comerciales', 'type_service', 'priorities', 'installation', 'cotizador_opciones', 'cotizador_gastos_mensuales'));
      $viewBlock = view('permitted.documentp.edit_documentp_block', compact('folio', 'hour_created'));

      return $viewPermitted;

    }catch(\ErrorException $e) {
      $id = null;
      $msg = $e->getMessage();

      return abort(404);
    }

  }

  public function getShoppingCart($id)
  {
    $documentP = Documentp::find($id);
    $cart = $documentP->documentp_cart_id;
    $in_document_cart = DB::select('CALL px_docupentop_materialesXcarrito(?)' , array($cart));

    return $in_document_cart;
  }

  public function edit(Request $request)
  {
    $flag  = "false";
    $id = $request->id;

    DB::beginTransaction();
    try {
      $documentp = Documentp::find($id);
      $documentp->nombre_proyecto = $request->proyecto;
      $documentp->num_sitios = $request->sites;
      $documentp->densidad = $request->densidad;
      $documentp->num_oportunidad = $request->oportunity;
      $documentp->nombre_grupo = $request->grupo;
      $documentp->lugar_instalacion_id = $request->lugar_instalacion;
      $documentp->comercial_id = $request->comercial;
      $documentp->total_ea = $request->total_ea;
      $documentp->total_ena = $request->total_ena;
      $documentp->total_mo = $request->total_mo;
      $documentp->total_usd = $request->total;
      $documentp->itc_id = $request->itc;
      $documentp->vertical_id = $request->vertical;
      $documentp->tipo_servicio_id = $request->type_service;
      $documentp->plazo = $request->plazo;
      $documentp->renta_anticipada = $request->renta;
      $documentp->enlace = $request->enlace;
      $documentp->servicio_mensual = $request->servicio;
      $documentp->deposito_garantia = $request->deposito;
      $documentp->capex = $request->capex;
      $documentp->instalaciones = $request->instalaciones;
      $documentp->indirectos = $request->indirectos;
      $documentp->utilidad_venta_ea = $request->utilidad;
      $documentp->doc_type = $request->doc_type;
      $documentp->updated_at = \Carbon\Carbon::now();
      $documentp->save();

      $cart = $documentp->documentp_cart_id;

      $shopping_cart = $request->shopping_cart;
      $shopping_cart_data = json_decode($shopping_cart, true);
      $tam_shopping_cart = count($shopping_cart_data);
      //LLamando a funcion para borrar productos
      //delete_products(new_data, old_data);
      $this->delete_products($shopping_cart_data, $this->getShoppingCart($id));

      for ($i=0; $i < $tam_shopping_cart; $i++)
      {
        if($shopping_cart_data[$i]['id_key'] == 0){
          //Añadiendo nuevos productos al carrito
          $new_in_documentp_cart = new  In_Documentp_cart;
          $new_in_documentp_cart->cantidad = $shopping_cart_data[$i]['cant_req'];
          $new_in_documentp_cart->cantidad_sugerida = $shopping_cart_data[$i]['cant_sug'];
          $new_in_documentp_cart->precio = $shopping_cart_data[$i]['precio'];
          $new_in_documentp_cart->descuento = $shopping_cart_data[$i]['descuento'];
          $new_in_documentp_cart->total = $shopping_cart_data[$i]['precio_total'];
          $new_in_documentp_cart->total_usd = $shopping_cart_data[$i]['precio_total_usd'];
          $new_in_documentp_cart->tipo_cambio = $request->tipo_cambio;
          $new_in_documentp_cart->documentp_cart_id = $cart;
          $new_in_documentp_cart->product_id = $shopping_cart_data[$i]['id'];
          $new_in_documentp_cart->created_at = \Carbon\Carbon::now();
          $new_in_documentp_cart->save();
        }else{
          //Actualizando productos existentes
          $set_in_documentp_cart = In_Documentp_cart::find($shopping_cart_data[$i]['id_key']);
          $set_in_documentp_cart->cantidad = $shopping_cart_data[$i]['cant_req'];
          $set_in_documentp_cart->cantidad_sugerida = $shopping_cart_data[$i]['cant_sug'];
          $set_in_documentp_cart->precio = $shopping_cart_data[$i]['precio'];
          $set_in_documentp_cart->descuento = $shopping_cart_data[$i]['descuento'];
          $set_in_documentp_cart->total = $shopping_cart_data[$i]['precio_total'];
          $set_in_documentp_cart->total_usd = $shopping_cart_data[$i]['precio_total_usd'];
          $set_in_documentp_cart->tipo_cambio = $request->tipo_cambio;
          $set_in_documentp_cart->updated_at = \Carbon\Carbon::now();
          $set_in_documentp_cart->save();
        }

      }

      $productos_log = $request->productos_log;

      if(is_null($productos_log)){

      }else{
        $this->save_log_document($id, $productos_log);
      }

      //Actualizando métricas del cotizador
      $cotizador = Cotizador::where('id_doc', $documentp->id)->first();
      //Inversion
      DB::table('cotizador_inversion')->where('cotizador_id', $cotizador->id)->update([
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
         'updated_at' => \Carbon\Carbon::now()
      ]);
      //Gastos
      DB::table('cotizador_gastos_mensuales')->where('cotizador_id', $cotizador->id)->update([
        'credito_mensual' => $request->credito_mensual,
        'credito_mensual_percent' => $request->credito_mensual_percent,
        'mantto_seg_otro' => $request->gasto_mtto,
        'mantto_seg_otro_percent' => $request->gasto_mtto_percent,
        'enlace' => $request->gasto_enlace,
        'total_gasto_mensual' => $request->total_gastos,
        'updated_at' => \Carbon\Carbon::now()
      ]);
      //Modelo de negocio
      DB::table('cotizador_modelo_negocio')->where('cotizador_id', $cotizador->id)->update([
        'enlace' => $request->modelo_enlace,
        'mensual_habitacion' => $request->modelo_mensual_hab,
        'serv_mensual' => $request->modelo_serv_mens,
        'antenas' => $request->modelo_antenas,
        'habitacion_enlace' => $request->modelo_hab_enlace,
        'updated_at' => \Carbon\Carbon::now()
      ]);
      //Opcionalmente
      DB::table('cotizador_opciones')->where('cotizador_id', $cotizador->id)->update([
        'costo_poliza' => $request->opcional_poliza,
        'utilidad_poliza' => $request->utilidad_poliza,
        'comision_poliza' => $request->comision_poliza,
        'precio_poliza' => $request->precio_poliza,
        'updated_at' => \Carbon\Carbon::now()
      ]);
      //Servicio administrado
      DB::table('cotizador_servadm_usd')->where('cotizador_id', $cotizador->id)->update([
        'renta_mas_enlace' => $request->renta_enlace,
        'capex' => $request->serv_capex,
        'renta_anticipada' => $request->serv_renta,
        'plazo' => $request->serv_plazo,
        'hab_por_antena' => $request->serv_hab_antenas,
        'servadm_por_habitacion' => $request->serv_adm_habitacion,
        'updated_at' => \Carbon\Carbon::now()
      ]);
      //Objetivos
      DB::table('cotizador_objetivos')->where('cotizador_id', $cotizador->id)->update([
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
      ]);

      if($request->doc_type == 1){
        $docp_advance = Documentp_project::firstOrCreate(
            ['id_doc' => $documentp->id],
            ['id_motivo' => 1]
        );
      }

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

  public function delete_products($new_shopping_cart, $old_shopping_cart)
  {
    $keys_new_shopping_cart = [];
    $keys_deleted = [];

    for($i = 0;$i < count($new_shopping_cart); $i++)
    {
      array_push($keys_new_shopping_cart, $new_shopping_cart[$i]['id_key']);
    }

    for($i = 0;$i < count($old_shopping_cart); $i++)
    {
      $id_product_cart = $old_shopping_cart[$i]->id;
      if (in_array($id_product_cart, $keys_new_shopping_cart)) {
         /*Busco dentro del array si existe el producto*/
      }else{
        array_push($keys_deleted, $id_product_cart);
      }
    }

    if(count($keys_deleted) > 0 && $keys_deleted != []){
      In_Documentp_cart::destroy($keys_deleted);
    }

  }

  public function save_log_document($id_doc,$productos)
  {
    $user = Auth::user()->name;
    $productos_data = json_decode($productos, true);
    if(is_null($productos_data)){

    }else{
      $tam_productos = count($productos_data);

      for ($i=0; $i < $tam_productos; $i++)
      {

        DB::table('documentp_logs')->insert(
            ['folio' => $id_doc,
             'descripcion' => $productos_data[$i]['descripcion'],
             'precio' => $productos_data[$i]['precio'],
             'cantidad_anterior' => $productos_data[$i]['cant_anterior'],
             'cantidad_actual' => $productos_data[$i]['cant_actual'],
             'accion' =>  $productos_data[$i]['accion'],
             'usuario' => $user,
             'id_docp' => $id_doc,
             'created_at' => \Carbon\Carbon::now()]
        );
      }
    }

  }


}
