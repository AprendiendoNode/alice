<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Projects\Documentp;
use App\Models\Projects\Documentp_cart;
use App\Models\Projects\Documentp_status_user;
use App\Models\Projects\Deny_docpcomment;
use App\Models\Projects\Documentp_project;
use App\Models\Projects\In_Documentp_cart;
use View;
use PDF;
use Auth;
use DB;
use Mail;
use App\Mail\SolicitudCompra;

class DocumentpController extends Controller
{

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

        if($request->doc_type == 2){
          //Es un documento M
          $grupo_id = $request->grupo_id;
          ($request->anexo_id != '' && $request->anexo_id != null) ? $anexo_id = $request->anexo_id : $anexo_id = 7;
        }else if($request->type_service != 1 && $request->grupo_id != null
                  && $request->anexo_id != null){
          // Es un documento p
          $grupo_id = $request->grupo_id;
          $anexo_id = $request->anexo_id;
        }

        //Datos del Documento
        $new_documentp = new Documentp;
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
        $new_documentp->num_edit = 0;
        $new_documentp->vertical_id = $vertical_id;
        $new_documentp->tipo_servicio_id = $type_service;
        $new_documentp->status_id = 1;
        $new_documentp->priority_id = $priority;
        $new_documentp->documentp_cart_id = $new_documentp_cart->id;
        $new_documentp->grupo_id = $grupo_id;
        $new_documentp->anexo_id = $anexo_id;
        $new_documentp->created_at = \Carbon\Carbon::now();
        $new_documentp->updated_at = \Carbon\Carbon::now();
        $new_documentp->save();

        if($new_documentp->doc_type == 1){
          $new_documentp_project = new Documentp_project;
          $new_documentp_project->id_motivo = 1; //Motivo cliente por default
          $new_documentp_project->id_doc = $new_documentp->id;
          $new_documentp_project->save();
        }

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
          'total' => $total
        ];

        Mail::to('rdelgado@sitwifi.com')->cc('aarciga@sitwifi.com')->send(new SolicitudCompra($parametros1));
        //Mail::to('rkuman@sitwifi.com')->send(new SolicitudCompra($parametros1));
        $flag = "true";

    } catch(\Exception $e){
        $error = $e->getMessage();
      	DB::rollback();
        dd($error);
    }

    return  $flag;

  }

  /*
  **  Exportación de facturas PDF con los productos del carrito de compras
  **  del Documento P
  */

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
    $materiales = $collection->whereNotIn('categoria_id', [4, 6, 7, 14]);
    $mano_obra = $collection->where('categoria_id', 7);

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
    $pdf = PDF::loadView('permitted.documentp.invoice',
    compact('equipo_activo', 'materiales', 'mano_obra', 'fecha', 'folio','tipo_cambio', 'itc',
            'nombre_proyecto', 'comercial', 'vertical', 'status', 'doc_type'));

    return $pdf->stream();
  }

  public function update_cantidad_recibida($id, $cant, $porcentaje_compra)
  {
    $id_in_document_cart = $id;
    $new_cant = $cant;
    $percent = $porcentaje_compra;
    $status = 3; // status pendiente
    if($percent == '100.00'){
      $status = 4; // status completado
    }else if($percent == '0.00'){
      $status = 1; // status en espera
    }

    $in_document_cart = In_Documentp_cart::find($id_in_document_cart);
    $in_document_cart->cantidad_recibida = $new_cant;
    $in_document_cart->order_status_id = $status;
    $in_document_cart->porcentaje_compra = $percent;
    $in_document_cart->save();
  }

  public function update_fecha_entrega($id, $date)
  {

    $newDate = date("Y-m-d", strtotime($date));
    //dd($newDate);
    $flag = "false";
    $in_document_cart = In_Documentp_cart::find($id);
    $in_document_cart->fecha_entrega = $newDate;
    $in_document_cart->save();
    $flag = "true";

    return $flag;
  }

  public function update_status_product($id, $status)
  {
    $id_in_document_cart = $id;
    $new_status = $status;
    $flag = false;

    $in_document_cart = In_Documentp_cart::find($id_in_document_cart);
    $in_document_cart->order_status_id = $new_status;
    $in_document_cart->save();

    $flag = true;
  }

  public function update_purchase_order($id, $order)
  {
      $in_document_cart = In_Documentp_cart::find($id);
      $in_document_cart->purchase_order = $order;
      $in_document_cart->save();
  }

  public function update_motive_project($id, $motive)
  {
    $flag = false;

    $project = Documentp_project::find($id);
    $project->id_motivo = $motive;
    $project->save();

    $flag = true;
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

  public function hotel_cadena(Request $request)
  {
      $id = $request->data_one;
      //$hotel = DB::table('hotels')->select('id', 'Nombre_hotel')->where('cadena_id', $id)->get();
      $hotel = DB::select('CALL get_hotel_cadena(?)', array($id));
      return json_encode($hotel);
  }

  public function get_vertical_anexo($id)
  {
      $vertical_id = DB::table('hotels')->select('vertical_id')->where('id', $id)->get();
      return $vertical_id;
  }


}
