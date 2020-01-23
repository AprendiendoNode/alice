<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Models\Projects\Documentp;
use App\Models\Projects\Documentp_cart;
use App\Models\Projects\In_Documentp_cart;
use Carbon\Carbon;
use Auth;
use DB;

class EditDocumentPController extends Controller
{
  public function index(Request $request)
  {
    $id = $request->id_docp;
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
    $tipo_cambio = 19.5;
    $in_document_cart = In_Documentp_cart::where('documentp_cart_id', $cart)->first();
    if($in_document_cart != null){
      $tipo_cambio = $in_document_cart->tipo_cambio;
    }
    
    $info = '';
    $product_sw = DB::select('CALL px_products_swiches');
    $product_ap = DB::select('CALL px_products_antenas');
    $product_fw = DB::select('CALL px_products_firewalls');
    $products_gabinetes = DB::table('products')->where('name', 'LIKE', '%gabinete%')->get();
    $materiales = DB::table('product_material')->get();
    $medidas = DB::table('product_measure')->get();
    //Data formulario
    $grupos = DB::table('cadenas')->select('id', 'name')->orderBy('name')->get();
    $anexos = DB::table('hotels')->select('id', 'Nombre_hotel')->orderBy('Nombre_hotel')->get();
    $categories = DB::table('products_categories')->select('id', 'name')->get();
    $verticals = DB::table('verticals')->select('id','name')->get();
    $itc = DB::select('CALL px_ITC_todos_V2');
    $comerciales = DB::select('CALL px_resguardoXgrupo_users(?)', array(2));
    $type_service = DB::table('documentp_type')->select('id', 'name')->get();
    $installation = DB::table('documentp_installation')->select('id', 'name')->get();
    $priorities = DB::table('documentp_priorities')->select('id', 'name')->get();
    $viewPermitted = view('permitted.documentp.show' ,compact('id_document', 'hour_created','grupos', 'anexos','data_header', 'tipo_cambio', 'categories', 'itc', 'verticals', 'comerciales', 
    'type_service', 'priorities', 'installation','products_gabinetes', 'materiales', 'medidas','product_ap', 'product_sw', 'product_fw'));
    $viewBlock = view('permitted.documentp.edit_documentp_block', compact('folio', 'hour_created'));
    //dd($this->validateHourEdit($hour_created, $num_edit));
    if($this->check_user_permission() == 0 || $this->check_user_permission() == 1){
        //Se revisa si el documento no ha sido aprobado
      if($this->check_status_document($id_document)){
          // Se verifica que el usuario que solicito editar sea el que elaboro o el itc asignado
        if($this->check_user_can_edit($itc_id, $user_elaboro)){
          // Se verifica si no ha superado las ediciones permitidas
          ($this->check_num_edit($num_edit)) ?  $view = $viewPermitted : $view = $viewBlock;
            return $view;
        }else{
          return $viewBlock;
        }
      }else {
        //El carrito ya se aprobo, se procede a revisar si esta dentro de las 4 horas permitidas despues de aprobacion
        ($this->validateHourEdit($hour_created, $num_edit, $id_document)) ? $view = $viewPermitted  : $view = $viewBlock;
          return $view;
      }
    }else {
      //Es un usuario con mayor permiso que un itc, se revisa que el carrito no haya sido entregado

      ($this->check_status_cart($cart))  ? $view = $viewPermitted  : $view = $viewBlock;
        return $view;
    }

  }

  public function edit_project()
  {
    $projects = Documentp::where('doc_type', 1)->where('status_id', '<>', 4)->orderBy('nombre_proyecto','ASC')->get();
    $grupos = DB::table('cadenas')->select('id', 'name')->orderBy('name','ASC')->get();
    $itcs = DB::select('CALL px_ITC_todos_v2');

    return view('permitted.documentp.edit_project_doc', compact('projects', 'grupos','itcs'));
  }

  public function get_data_project(Request $request)
  {
    $id = $request->id;
    $docp = DB::table('documentp')->select('id', 'folio', 'total_usd', 'itc_id', 'grupo_id', 'anexo_id', 'renta_mensual')
                                  ->where('id',$id)->get();
    return $docp;
  }

  public function update_form_project(Request $request)
  {
    $flag = 0;//error
    $set_documentp = Documentp::findOrFail($request->id);
    $set_documentp->itc_id = $request->itc_id;
    $set_documentp->grupo_id = $request->grupo_id;
    $set_documentp->anexo_id = $request->anexo_id;
    $set_documentp->renta_mensual = $request->renta_mensual;
    $set_documentp->save();
    $flag = 1;//ok
    return $flag;
  }

  public function check_user_permission()
  {
    if(auth()->user()->can('View level zero documentp notification')){
      return 0;
    }else if(auth()->user()->can('View level one documentp notification')){
      return 1;
    }
    else if(auth()->user()->can('View level two documentp notification')){
      return 2;
    }
    else if(auth()->user()->can('View level three documentp notification')){
      return 3;
    }
  }

  public function check_user_can_edit($itc_id, $user_elaboro)
  {
    $id_user = Auth::user()->id;
    if($id_user == $itc_id || $id_user == $user_elaboro){
      return true;
    }else{
      return false;
    }
  }

  public function check_status_cart($id_cart)
  {
    $document = Documentp_cart::find($id_cart);
    if($document->status_id == 1){
      return true;
    }else{
      return false; //Poner en true para  quitar candado de edicion de documentos 
      
    }
  }

  public function check_status_document($id_doc)
  {
    $doc = Documentp::find($id_doc);
    $status = $doc->status_id;
    //Si es menor a 3 el documento aun no ha sido autorizado
    ($status < 3) ? $result = true : $result = false;
    return $result;
  }

  public function check_num_edit($num_edit)
  {
    ($num_edit < 3) ? $result = true : $result = false;
    return $result;
  }

  public function check_totales($totalUsdOld , $totalUsdNew)
  {
    $autorizar = true;
    $percent_3 = $totalUsdOld * .03;
    $suma = $totalUsdOld + $percent_3;
    if($totalUsdNew > $suma){
      return true;
    }else{
      return false;
    }

  }

  public function validateHourEdit($hour_approved, $num_edit, $id_doc)
  {
    $documentP = Documentp::find($id_doc);
    if($documentP->status_id == 5){
      return false;
    }
     if($num_edit == 2){
       $hour_now = \Carbon\Carbon::now();
       $hour_now = \Carbon\Carbon::parse($hour_now);
       $diff = $hour_approved->diff($hour_now);
       //Si se cumple está dentro del tiempo de 4 horas permitido
       if($diff->d == 0 && $diff->h <= 3 && $diff->i <= 59){
           return true;
         }else{
           return false;
         }
     }else if($num_edit == 3){
       return false;
     }else{
       return true;
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
    $grupo_id = 23;  // sin asignar
    $anexo_id = 7; // sin asignar
    $documentp = Documentp::find($id);
    $id_document = $documentp->id;
    $totalUsdOld = $documentp->total_usd;
    $hour_created = $documentp->updated_at;
    $hour_created =  \Carbon\Carbon::parse($hour_created);
    $num_edit = $documentp->num_edit;

    if($this->check_user_permission() == 0){
      if($this->validateHourEdit($hour_created, $num_edit,$documentp->id)){
        if($documentp->status_id == 3){
          $num_edit++;
        }
      }else{
        return $flag;
      }
    }

    if($request->key_doc == 2){
      //Es un documento M
      $grupo_id = $request->grupo_id;
      ($request->anexo_id != '' && $request->anexo_id != null) ? $anexo_id = $request->anexo_id : $anexo_id = 7;
    }else if($request->type_service != 1 && $request->grupo_id != null
              && $request->anexo_id != null){
      // Es un documento p
      $grupo_id = $request->grupo_id;
      $anexo_id = $request->anexo_id;
    }

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
      $documentp->total_viaticos = $request->total_viaticos;
      $documentp->total_usd = $request->total;
      $documentp->num_edit = $num_edit;
      $documentp->itc_id = $request->itc;
      $documentp->doc_type = $request->doc_type;
      $documentp->vertical_id = $request->vertical;
      $documentp->tipo_servicio_id = $request->type_service;
      $documentp->grupo_id = $grupo_id;
      $documentp->anexo_id = $anexo_id;
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

          $this->save_price_old($set_in_documentp_cart->precio, $set_in_documentp_cart->precio = $shopping_cart_data[$i]['precio'], $set_in_documentp_cart->id);
          $this->update_percent_progress($set_in_documentp_cart->cantidad, $shopping_cart_data[$i]['cant_req'], $set_in_documentp_cart->id);

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

      DB::commit();
      $flag  = "true";

    } catch(\Exception $e){
      $e->getMessage();
      DB::rollback();
      return $e;
    }

    return $flag;
  }

  public function save_price_old($old_price, $new_price, $id_product_cart)
  {
    $new_price = number_format($new_price, 2, '.', '');

    if ($old_price != $new_price){
      $set_in_documentp_cart = In_Documentp_cart::find($id_product_cart);
      $set_in_documentp_cart->precio_anterior = $old_price;
      $set_in_documentp_cart->save();
    }

  }

  public function update_percent_progress($cant_old, $cant_new, $id_product_cart)
  {
    if($cant_old != $cant_new){
      $set_in_documentp_product = In_Documentp_cart::find($id_product_cart);
      $cant_req = $cant_new;
      $cantidad_recibida = $set_in_documentp_product->cantidad_recibida;
      $percent_sale = 0;

      if($cant_req != 0){
        $percent_sale = $cantidad_recibida * 100 / $cant_req;
      }

      $percent_sale = number_format($percent_sale, 2, '.', '');
      $status = 3; // En transito
      if($percent_sale > '100.00'){
        $percent_sale = 100.00;
        $cantidad_recibida = $cant_req;
        $set_in_documentp_product->cantidad_recibida = $cantidad_recibida;
        $status = 4; // status completado
      }else if($percent_sale == '100.00'){
        $status = 1; // status en espera
      }else if($percent_sale == '0.00'){
        $status = 1; // status en espera
      }

      $set_in_documentp_product->porcentaje_compra = $percent_sale;
      $set_in_documentp_product->order_status_id = $status;
      $set_in_documentp_product->save();
    }

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

  public function update_priority(Request $request)
  {
    $flag = "false";
    $id_doc = $request->id_doc;
    $id_prioridad = $request->id_prioridad;
    $set_doc = Documentp::find($id_doc);
    $set_doc->priority_id = $id_prioridad;
    $set_doc->save();
    $flag = "true";

    return $flag;
  }

  public function update_servicio_mensual(Request $request)
  {
    $doc = Documentp::findOrFail($request->id);
    $doc->servicio_mensual = $request->servicio_mensual;
    $doc->save();

    return response()->json(['status' => 200]);
  }

  public function update_alert(Request $request)
  {
    $flag = "false";
    $id_doc = $request->id_doc;

    if($request->id_alert == 4){
      $date = \Carbon\Carbon::now();
      $date = $date->format('d-m-Y');
      $date = date("Y-m-d", strtotime($date));

      DB::table('documentp_project_advance')->where('id_doc', $id_doc)->update([
        'alert' => $request->id_alert,
        'fecha_terminacion_real' => $date
      ]);

    }else{
      DB::table('documentp_project_advance')->where('id_doc', $id_doc)->update([
        'alert' => $request->id_alert
      ]);
    }

    $flag = "true";

    return $flag;
  }

  public function update_status_fact(Request $request)
  {
    $flag = "false";
    $id_doc = $request->id_doc;
    DB::table('documentp_project_advance')->where('id_doc', $id_doc)->update([
      'facturando' => $request->id_status
    ]);

    $flag = "true";

    return $flag;
  }

  public function update_comment_manager(Request $request)
  {
    $flag = "false";
    $id_doc = $request->id_doc;
    DB::table('documentp_project_advance')->where('id_doc', $id_doc)->update([
      'comentario_manager' => $request->comentario
    ]);

    $flag = "true";

    return $flag;
  }


}
