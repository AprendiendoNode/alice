<?php

namespace App\Http\Controllers\Contracts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use App\Cadena;
use App\Vertical;

use Carbon\Carbon;

use App\Cxclassification;
use App\Cxservice;
use App\Cxconcept;
use App\Cxdescription;

use App\cxclassification_cxservice;
use App\cxconcept_cxservice;
use App\cxconcept_cxdescription;

use App\Contrato;
use App\Idproyect;
use App\hotel_idproyect;

class IdProyectoController extends Controller
{
  public function index()
  {
      $classifications = DB::Table('cxclassification')->select('id', 'name')->get();
      $verticals = Vertical::select('id', 'name')->get();
      $cadenas = Cadena::select('id', 'name')->get();
      $contratos = Contrato::select('id', 'name')->get();
      $sitio= DB::Table('cxclassification')->select('id', 'name')->get();
      return view('permitted.contract.cont_create_idp', compact('classifications','verticals','cadenas', 'contratos', 'sitio'));
  }
  public function search_key_one (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_cxclassifications_letter (?)', array($id));
    return json_encode($result);
  }
  public function vertical_by_class (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_cxclassification_verticals (?)', array($id));
    return json_encode($result);
  }
  public function search_key_two (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_verticals_key (?)', array($id));
    return json_encode($result);
  }
  public function cadena_by_vert (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_cadenasXvertical (?)', array($id));
    return json_encode($result);
  }
  public function search_key_three (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_cadenas_key (?)', array($id));
    return json_encode($result);
  }
  public function hotel_by_cadena (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_sitiosXcadena (?)', array($id));
    return json_encode($result);
  }
  public function search_key_four (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_contratos_key (?)', array($id));
    return json_encode($result);
  }
  public function search_key_five (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_hotels_key (?)', array($id));
    return json_encode($result);
  }
  public function search_idproyect (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_idproyectoXsitio (?)', array($id));
    return json_encode($result);
  }

  public function verf_idproyect (Request $request) {
    $id_1 = $request->sel_service;
    $id_2 = $request->sel_vertical;
    $id_3 = $request->sel_cadenas;
    $id_4 = $request->sel_contratos;
    $id_5 = $request->sel_sitio;
    $id_6 = $request->text;

    $result = DB::select('CALL px_idproyecto_exist (?,?,?,?,?)', array($id_1,$id_2,$id_3,$id_4,$id_5));
    $respuesta_exit = $result[0]->exist;
    if ($respuesta_exit=='1'){
      return 'no'; //NO SE REGISTRA PORQ EXISTE
    }
    else{
      $new_idproyect = new Idproyect;
      $new_idproyect->cxclassification_id=$id_1;
      $new_idproyect->vertical_id=$id_2;
      $new_idproyect->cadena_id= $id_3;
      $new_idproyect->contrato_id=$id_4;
      $new_idproyect->hotel_id=$id_5;
      $new_idproyect->key=$id_6;
      $new_idproyect->save();

      $new_hotel_idproyect = new hotel_idproyect;
      $new_hotel_idproyect->idproyect_id= $new_idproyect->id;
      $new_hotel_idproyect->hotel_id=$id_5;
      $new_hotel_idproyect->estatus='1';
      $new_hotel_idproyect->save();

      $cant_reg = DB::table('hotel_idproyects')
        ->where('hotel_id', '=', $id_5)
        ->where('idproyect_id', '!=', $new_idproyect->id)
        ->count();

      if ($cant_reg > 0)
      {
          $actualizacion = DB::table('hotel_idproyects')
            ->where('hotel_id', '=', $id_5)
            ->where('idproyect_id', '!=', $new_idproyect->id)
            ->update(
            [
              'estatus' => '0',
              'updated_at' => \Carbon\Carbon::now()
            ]);
      }
      return 'si'; //SI SE REGISTRA PORQ NO EXISTE
    }
  }

}
