<?php

namespace App\Http\Controllers\Equipments;
use App\Http\Controllers\Controller;
set_time_limit(0);//Necesario para insertar equipos masivo sin interrumpir la conexion
use Illuminate\Http\Request;
use App\Hotel;
use App\Proveedor;
use App\Modelo;
use App\Mail\ConfirmacionAltaEquipo;
use DB;
use Auth;
use Carbon\Carbon;
use App\Currency;
use Mail;
//use App\Services\PayUService\Exception;
use Exception;
//use App\Exceptions\Handler;
class AddEquipmentController extends Controller
{
  /**
   * Show the application add equipment
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $list_moneda = DB::table('currencies')->select('name')->pluck('name')->all();
    $list_marca = DB::table('marcas')->select('Nombre_marca')->pluck('Nombre_marca')->all();
    $list_espec = DB::table('especificacions')->select('name')->where([['status', '=', 1],])->pluck('name')->all();

    $hotels = Hotel::select('id', 'Nombre_hotel')->get();
    $modelos = DB::table('modelos')->select('id', 'ModeloNombre')->orderBy('ModeloNombre', 'asc')->get();
    $marcas = DB::table('marcas')->select('id', 'Nombre_marca')->orderBy('Nombre_marca', 'asc')->get();
    $estados = DB::table('get_estados_devices')->select('id', 'Nombre_estado')->get();
    $proveedores = DB::table('list_proveedores')->select('id', 'nombre')->get();
    $especificaciones = DB::table('especificacions')->select('id', 'name')->get();
    $groups = DB::table('groups')->select('id', 'name')->get();
    $currency = DB::Table('currencies')->select('id', 'name')->get();
    return view('permitted.equipment.add_equipment', compact('hotels', 'estados', 'proveedores', 'especificaciones', 'groups', 'marcas', 'currency','list_moneda','list_marca','list_espec'));
  }
  public function search(Request $request)
  {
    $considencia = $request->key;
    $result = DB::select('CALL get_grupo_rlike (?)', array($considencia));
    return json_encode($result);
  }
  public function search_provider(Request $request)
  {
    $result = DB::table('list_proveedores')->orderBy('nombre', 'asc')->get();
    return json_encode($result);
  }
  public function create_Model(Request $request)
  {
    $user_id= Auth::user()->id;
    $name = $request->add_modelitho;
    $marca_modl = $request->marcas_current;
    $costo= $request->inputCreatCosto;
    $moneda= $request->select_onemoneda;
    $espec= $request->select_oneespec;
    $orden= $request->inputCreatOrden;
    $status= !empty($request->status) ? 1 : 0;
    $monedaId = DB::table('currencies')
                ->where([
                    ['name', '=', $moneda],
                  ])->value('id');
    $especId = DB::table('especificacions')
                ->where([
                    ['name', '=', $espec],
                  ])->value('id');

    $flag = 0;
    $count_md = DB::table('modelos')->where('ModeloNombre', $name)->where('marca_id', $marca_modl)->count();
    if ($count_md == '0') {
      $result = DB::table('modelos')->insertGetId(['ModeloNombre' => $name,
                                                    'Costo' => $costo,
                                                    'currency_id' => $monedaId,
                                                    'marca_id' => $marca_modl,
                                                    'especification_id' => $especId,
                                                    'sort_order' => $orden,
                                                    'status' => $status,
                                                    'created_uid' => $user_id,
                                                    'created_at' => \Carbon\Carbon::now()
                                                 ]);
      if ($result != '0') {
        $flag = 1;
      }
    }
    return $flag;
  }

  public function search_modelo(Request $request)
  {
    $name = $request->numero;
    $result = DB::select('CALL get_model (?)', array($name));
    return json_encode($result);
  }
  public function create_marca(Request $request)
  {

    $dist = $request->add_distribuidor;
    $type = $request->modelitho_current;
    $flag = 0;
    if ($request->marcas_select == '') {
      $name = $request->add_marquitha;
      $result = DB::table('marcas')->insertGetId(['Nombre_marca' => $name, 'Distribuidor' => $dist]);
      $eq_prt = DB::table('especification_marcas')->insertGetId([
        'especification_id' => $type,
        'marca_id' => $result,
        'created_at' => \Carbon\Carbon::now(),
      ]);
      if ($result != '0') {
        $flag = 1;
      }
    } else {
      $marca_id = $request->marcas_select;
      $eq_prt = DB::table('especification_marcas')->insertGetId([
        'especification_id' => $type,
        'marca_id' => $marca_id,
        'created_at' => \Carbon\Carbon::now(),
      ]);

      $flag = 1;
    }

    return $flag;
  }
  public function search_marca(Request $request)
  {
    $name = $request->numero;
    $result = DB::select('CALL get_brand (?)', array($name));
    return json_encode($result);
  }
  public function create_group(Request $request)
  {
    $name = $request->add_grupitho;
    $flag = 0;
    $count_md = DB::table('groups')->where('name', $name)->count();
    if ($count_md == '0') {
      $eq_prt = DB::table('groups')->insertGetId([
        'name' => $name,
        'created' => \Carbon\Carbon::now(),
      ]);
      if ($eq_prt != '0') {
        $flag = 1;
      }
    }
    return $flag;
  }
  public function search_grupo(Request $request)
  {
    $result = DB::table('groups')->select('id', 'name')->get();
    return json_encode($result);
  }

  public function search_marca_all(Request $request)
  {
    $result = DB::table('marcas')->select('id', 'Nombre_marca')->orderBy('Nombre_marca', 'asc')->get();
    return json_encode($result);
  }
  public function create_equipament_n(Request $request)
  {
    $masivo= $request->masivo;
    $eq_mac = "";
    $eq_serie = "";
    $eq_grup = "";
    $eq_descrip = "";
    $eq_type = "";
    $eq_marca = "";
    $eq_modelo = "";
    $eq_estado = "";
    $eq_venue = "";
    $excel_data=[];
//campos de la factura
    $eq_nfactura = "";
    $eq_date_fact = "";
    $eq_nproveedor = "";
    $orden_compra = "";

    $valor_moneda = "";
    $id_moneda = "";
    $registros_exitosos=0;
    $name_user = Auth::user()->name;
    if($masivo==0){

    $eq_mac = $request->add_mac_eq;
    $eq_serie = $request->add_num_se;
    $eq_grup = $request->grupitho;
    $eq_descrip = $request->add_descrip;
    $eq_type = $request->type_equipment;
    $eq_marca = $request->Marcas;
    $eq_modelo = $request->mmodelo;
    $eq_estado = $request->add_estado;
    $eq_venue = $request->venue;
    //datos de la factura
    $eq_nfactura = $request->nfactura;
    $eq_date_fact = $request->date_fact;
    $eq_nproveedor = $request->select_one;
    $orden_compra = $request->order;

    $valor_moneda = $request->precio;
    $id_moneda = $request->coinmonto;

    $elementoequipo=['mac'=>$eq_mac,'serie'=>$eq_serie];
    array_push($excel_data,$elementoequipo);
    //info($request);
    }
    else{
    //  $excel_data=str_split(substr($request->data_excel,1,strlen($request->data_excel)-1),",");
      //$excel_data = $request->data_excel;
      $excel_data=$request->data_excel;
      //info( $request);

      $data_object=explode("&",$request->objData);
      $eq_grup = explode("=",$data_object[1])[1];
      //$eq_descrip = explode("=",$data_object[2])[1];
      $eq_descrip= $request->add_descrip;
      $eq_type = explode("=",$data_object[3])[1];
      $eq_marca = explode("=",$data_object[4])[1];
      $eq_modelo = explode("=",$data_object[5])[1];
      $eq_estado = explode("=",$data_object[6])[1];
      $eq_venue = explode("=",$data_object[7])[1];
      //datos de la factura
      $eq_nfactura = $request->nfactura_masiva;
      $eq_date_fact = $request->date_fact_masiva;
      $eq_nproveedor = $request->select_one_massive;
      $orden_compra = $request->order_massive;

      $valor_moneda =  explode("=",$data_object[8])[1];
      $id_moneda = explode("=",$data_object[9])[1];
    }
      $flag = 0;//Estado inicial
    foreach($excel_data as $elemento){
      if(count($elemento)==3){
        $eq_descrip=$elemento['descripcion'];
        //info($eq_descrip);
      }

      //info($elemento['serie']);
      $count_m0 = DB::table('equipos')->where('MAC', $elemento['mac'])->count();
      if ($count_m0 != '0') {
        $flag = 2;
        continue;
      }

      $count_m1 = DB::table('equipos')->where('Serie',  $elemento['serie'])->count();
      if ($count_m1 != '0') {
        $flag = 3;
        continue;
      }

      $count_md = DB::table('equipos')->where('MAC', $elemento['mac'])->where('Serie',  $elemento['serie'])->count();
      if ($count_md == '0') {
        $flag = 1;
        if ($eq_grup !="") {
          $insert_eq = DB::table('equipos')->insertGetId([
            'MAC' => $elemento['mac'],
            'Serie' => $elemento['serie'],
            'Fecha_Registro' => date('Y-m-d'),
            'Descripcion' => $eq_descrip,
            'modelos_id' => $eq_modelo,
            'estados_id' => $eq_estado,
            'check_it_id' => '2',
            'orden_compra' => $orden_compra,
            'hotel_id' => $eq_venue,
            'costo' => $valor_moneda,
            'moneda_id' => $id_moneda,
            'especificacions_id' => $eq_type,
            'created_at' => \Carbon\Carbon::now(),
                    ]);

          $result_match = DB::table('devices_groups')->insertGetId(['id_equipo' => $insert_eq, 'id_grupo' => $eq_grup]);
          $registros_exitosos+=1;
        } else {
          $insert_eq = DB::table('equipos')->insertGetId([
            'MAC' => $elemento['mac'],
            'Serie' =>$elemento['serie'],
            'Fecha_Registro' => date('Y-m-d'),
            'Descripcion' => $eq_descrip,
            'modelos_id' => $eq_modelo,
            'estados_id' => $eq_estado,
            'check_it_id' => '2',
            'orden_compra' => $orden_compra,
            'hotel_id' => $eq_venue,
            'costo' => $valor_moneda,
            'moneda_id' => $id_moneda,
            'especificacions_id' => $eq_type,
            'created_at' => \Carbon\Carbon::now(),
                    ]);
        $registros_exitosos+=1;
        }
        if (!is_null($insert_eq)) {
        $eq_prt = DB::table('equipo_proveedor')->insertGetId([
          'proveedor_id' => $eq_nproveedor,
          'equipo_id' => $insert_eq,
          'No_Fact_Compra' => $eq_nfactura,
          'Fecha_factura' => $eq_date_fact,
          'created_at' => \Carbon\Carbon::now(),
        ]);
      }
      }

      $nombreModelo = DB::table('modelos')->select('ModeloNombre')->where('id', $eq_modelo)->get();
      $nombreEstado = DB::table('estados')->select('Nombre_estado')->where('id', $eq_estado)->get();
      $nombre_sitio = DB::table('hotels')->select('Nombre_hotel')->where('id', $eq_venue)->get();
      $especificacion = DB::table('especificacions')->select('name')->where('id', $eq_type)->get();

      $parametros1 = [
        'MAC' => $elemento['mac'],
        'Serie' =>$elemento['serie'],
        'Fecha_registro' => date('Y-m-d'),
        'Descripcion' => $eq_descrip,
        'Modelo' => $nombreModelo[0]->ModeloNombre,
        'Estado' => $nombreEstado[0]->Nombre_estado,
        'Hotel' => $nombre_sitio[0]->Nombre_hotel,
        'Especificacion' => $especificacion[0]->name,
        'User' => $name_user
      ];

      //Envio de mails

      $itc_mail = DB::select('CALL px_sitio_itc_email (?)', array($eq_venue));

      $mails = [];

      if ($itc_mail != null) {

        for ($i = 0; $i < count($itc_mail); $i++) {
          array_push($mails, $itc_mail[$i]->email);
        }
        //si se inserto
        Mail::to('marthaisabel@sitwifi.com')->cc($mails)->send(new ConfirmacionAltaEquipo($parametros1));

        continue;
      } else {
        //El sitio no tiene ITC asignado
        Mail::to('marthaisabel@sitwifi.com')->send(new ConfirmacionAltaEquipo($parametros1));
        continue;
      }

    }//Final del for
    if($registros_exitosos!=0){
      $flag=5;
    }
    return $flag;
  }

  public function create_equipament_nd(Request $request)
  {
    $masivo= $request->masivo;
    $eq_mac = "";
    $eq_serie = "";
    $eq_grup = "";
    $eq_descrip = "";
    $eq_type = "";
    $eq_marca = "";
    $eq_modelo = "";
    $eq_estado = "";
    $eq_venue = "";
    $excel_data=[];
    $registros_exitosos=0;
    $name_user = Auth::user()->name;
    if($masivo==0){

    $eq_mac = $request->add_mac_eq;
    $eq_serie = $request->add_num_se;
    $eq_grup = $request->grupitho;
    $eq_descrip = urldecode($request->add_descrip);
    $eq_type = $request->type_equipment;
    $eq_marca = $request->Marcas;
    $eq_modelo = $request->mmodelo;
    $eq_estado = $request->add_estado;
    $eq_venue = $request->venue;
    $elementoequipo=['mac'=>$eq_mac,'serie'=>$eq_serie];
    array_push($excel_data,$elementoequipo);
    //info($request);
    }
    else{
    //  $excel_data=str_split(substr($request->data_excel,1,strlen($request->data_excel)-1),",");
      //$excel_data = $request->data_excel;
      $excel_data=$request->data_excel;
      //info( $request);

      $data_object=explode("&",$request->objData);
      $eq_grup = explode("=",$data_object[1])[1];
      $eq_descrip= urldecode($request->add_descrip);
      //$eq_descrip = urldecode(explode("=",$data_object[2])[1]);
      $eq_type = explode("=",$data_object[3])[1];
      $eq_marca = explode("=",$data_object[4])[1];
      $eq_modelo = explode("=",$data_object[5])[1];
      $eq_estado = explode("=",$data_object[6])[1];
      $eq_venue = explode("=",$data_object[7])[1];
    }
      $flag = 0;//Estado inicial
    foreach($excel_data as $elemento){
      if(count($elemento)==3){
        $eq_descrip=$elemento['descripcion'];
        //info($eq_descrip);
      }

      //info($elemento['serie']);
      $count_m0 = DB::table('equipos')->where('MAC', $elemento['mac'])->count();
      if ($count_m0 != '0') {
        $flag = 2;
        continue;
      }

      $count_m1 = DB::table('equipos')->where('Serie',  $elemento['serie'])->count();
      if ($count_m1 != '0') {
        $flag = 3;
        continue;
      }

      $count_md = DB::table('equipos')->where('MAC', $elemento['mac'])->where('Serie',  $elemento['serie'])->count();
      if ($count_md == '0') {
        $flag = 1;
        if ($eq_grup !="") {
          $insert_eq = DB::table('equipos')->insertGetId([
            'MAC' => $elemento['mac'],
            'Serie' => $elemento['serie'],
            'Fecha_Registro' => date('Y-m-d'),
            'Descripcion' => $eq_descrip,
            'modelos_id' => $eq_modelo,
            'estados_id' => $eq_estado,
            'check_it_id' => '2',
            'hotel_id' => $eq_venue,
            'especificacions_id' => $eq_type,
            'created_at' => \Carbon\Carbon::now(),
          ]);
          $result_match = DB::table('devices_groups')->insertGetId(['id_equipo' => $insert_eq, 'id_grupo' => $eq_grup]);
          $registros_exitosos+=1;
        } else {
          $insert_eq = DB::table('equipos')->insertGetId([
            'MAC' => $elemento['mac'],
            'Serie' =>$elemento['serie'],
            'Fecha_Registro' => date('Y-m-d'),
            'Descripcion' => $eq_descrip,
            'modelos_id' => $eq_modelo,
            'estados_id' => $eq_estado,
            'check_it_id' => '2',
            'hotel_id' => $eq_venue,
            'especificacions_id' => $eq_type,
            'created_at' => \Carbon\Carbon::now(),
          ]);
          $registros_exitosos+=1;
        }
      }

      $nombreModelo = DB::table('modelos')->select('ModeloNombre')->where('id', $eq_modelo)->get();
      $nombreEstado = DB::table('estados')->select('Nombre_estado')->where('id', $eq_estado)->get();
      $nombre_sitio = DB::table('hotels')->select('Nombre_hotel')->where('id', $eq_venue)->get();
      $especificacion = DB::table('especificacions')->select('name')->where('id', $eq_type)->get();

      $parametros1 = [
        'MAC' => $elemento['mac'],
        'Serie' =>$elemento['serie'],
        'Fecha_registro' => date('Y-m-d'),
        'Descripcion' => $eq_descrip,
        'Modelo' => $nombreModelo[0]->ModeloNombre,
        'Estado' => $nombreEstado[0]->Nombre_estado,
        'Hotel' => $nombre_sitio[0]->Nombre_hotel,
        'Especificacion' => $especificacion[0]->name,
        'User' => $name_user
      ];

      //Envio de mails

      $itc_mail = DB::select('CALL px_sitio_itc_email (?)', array($eq_venue));

      $mails = [];

      if ($itc_mail != null) {

        for ($i = 0; $i < count($itc_mail); $i++) {
          array_push($mails, $itc_mail[$i]->email);
        }
        //si se inserto
      Mail::to('marthaisabel@sitwifi.com')->cc($mails)->send(new ConfirmacionAltaEquipo($parametros1));

        continue;
      } else {
        //El sitio no tiene ITC asignado
      Mail::to('marthaisabel@sitwifi.com')->send(new ConfirmacionAltaEquipo($parametros1));
        continue;
      }

    }//Final del for
    if($registros_exitosos!=0){
      $flag=5;
    }
  //  info($registros_exitosos);
    return $flag;
  }

}
