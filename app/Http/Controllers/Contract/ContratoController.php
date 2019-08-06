<?php
namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use File;
use Storage;

use App\User;
use App\Cadena;
use App\Vertical;
use Carbon\Carbon;


//use App\Cxclassification; Si se usa

/*use App\Cxservice; No se usan
use App\Cxconcept;
use App\Cxdescription;

use App\cxclassification_cxservice;
use App\cxconcept_cxservice;
use App\cxconcept_cxdescription;*/

//use App\Contrato; Si se usa

/*use App\Idproyect; No se usa
use App\hotel_idproyect;*/

//use App\Currency; Si se usa
//use App\Hotel; Si se usa
//use App\country; Si se usa

/*Si se usan
use App\Rz_type;
use App\Rz_nationality;
use App\Rz_concept_invoice;
use App\Rz_customer;
use App\Iva;
use App\Contract_status;*/

//use App\Contract_exchange_range; No se usa
//use App\Contract_master;//Creo que si se usa
//use App\Contract_annex; No se usa
//use App\Contract_payment; No se usa
//use App\Contract_site; //No se usa
//use App\idcontract_type;//No se usa
//use App\idcontract;//No se usa

class ContratoController extends Controller
{
  //Dashboard.....
  public function  index()
  {
      return view('permitted.contract.cont_dashboard', compact('lista'));
  }
  public function info_act_cont_master()
  {
      $result = DB::select('CALL px_contract_master_info ()', array());
      return json_encode($result);
  }
  public function info_act_cont_anexo()
  {
      $result = DB::select('CALL px_contract_annexes_info ()', array());
      return json_encode($result);
  }
  public function info_act_cont_master_now(Request $request)
  {
      $r_date = $request->date;
      $result = DB::select('CALL px_contract_masterXfecha (?)', array($r_date));
      return json_encode($result);
  }
  public function info_act_cont_anexo_now(Request $request)
  {
      $r_date = $request->date;
      $result = DB::select('CALL px_contract_annexesXfecha (?)', array($r_date));
      return json_encode($result);
  }
  public function info_exp_cont_master_now(Request $request)
  {
    $result = DB::select('CALL px_contract_master_terminado ()', array());
    return json_encode($result);
  }
  public function info_exp_cont_anexo_now(Request $request)
  {
    $result = DB::select('CALL px_contract_annexes_terminado ()', array());
    return json_encode($result);
  }

  public function info_expnov_cont_anexo_now(Request $request)
  {
    $result = DB::select('CALL px_contract_annexes_vencido_90dias ()', array());
    return json_encode($result);
  }

  public function info_expyear_cont_anexo_now(Request $request)
  {
    $result = DB::select('CALL px_contract_annexes_vencido_anio ()', array());
    return json_encode($result);
  }

  public function info_pause_cont_master(Request $request)
  {
    $result = DB::select('CALL px_contract_master_pausado ()', array());
    return json_encode($result);
  }
  public function info_pause_cont_anexo(Request $request)
  {
    $result = DB::select('CALL px_contract_annexes_pausado ()', array());
    return json_encode($result);
  }
  public function info_datavert_cont_master(Request $request)
  {
    $result = DB::select('CALL px_contratosXvertical_masters ()', array());
    return json_encode($result);
  }
  public function  info_datavert_cont_anexo(Request $request)
  {
    $result = DB::select('CALL px_contratosXvertical_annexes ()', array());
    return json_encode($result);
  }

  public function grap_ap_x_vertical(Request $request)
  {
    $result = DB::select('CALL px_APXvertical ()', array());
    return json_encode($result);
  }
  public function  table_ap_x_vertical(Request $request)
  {
    $result = DB::select('CALL px_APXvertical ()', array());
    return json_encode($result);
  }
  public function  fact_contrat_coin(Request $request)
  {
    $result = DB::select('CALL px_cadenas_contratos_mensualidad ()', array());
    return json_encode($result);
  }

 /*--------------------------------------------------------------*/
  public function index_add()
  {
    // $classifications = Cxclassification::select('id', 'name')->get();
    $verticals = Vertical::select('id', 'name')->get();
    $cadenas = Cadena::select('id', 'name')->get();
    $contratos = Contrato::select('id', 'id')->get();
    $sitio= Cxclassification::select('id', 'name')->get();
    $currency = Currency::select('id','name')->get();
    $hotels = Hotel::select('id', 'Nombre_hotel')->get();
    $country = country::select('id', 'name')->get();

    $classifications = DB::select('CALL px_cxclassifications ()', array(''));

    $rz_type = Rz_type::select('id', 'name')->get();
    $rz_nationality = Rz_nationality::select('id', 'name')->get();
    $rz_concept_invoice = Rz_concept_invoice::select('id', 'key', 'name')->get();
    $rz_customer = Rz_customer::select('id', 'name')->get();

    $iva = Iva::select('number')->get();

    $resguardo = DB::select('CALL px_resguardoXgrupo_users (?)', array('1'));
    $vendedores = DB::select('CALL px_resguardoXgrupo_users (?)', array('2'));
    $itconcierge= DB::select('CALL px_ITC_todos ()', array());

    $contract_status = Contract_status::select('id', 'name')->get();

    return view('permitted.contract.cont_create_cont', compact('classifications','verticals','cadenas', 'contratos', 'sitio','currency', 'hotels', 'country', 'rz_type', 'rz_nationality', 'rz_concept_invoice', 'contract_status', 'rz_customer', 'iva', 'resguardo','vendedores','itconcierge'));
  }

  public function create_group_by_contract (Request $request) {
    $r_name = $request->cadena_name;
    $r_key = $request->cadena_key;
    $r_vertical = $request->id_vertical;

    $newId = DB::table('cadenas')->insertGetId([ 'name' => $r_name, 'dirlogo1' => 'Default.svg', 'key' => $r_key, 'created_at' => \Carbon\Carbon::now() ]);
    $pivot_cadena_vertical= DB::table('cadena_verticals')->insert([ 'cadena_id' => $newId, 'vertical_id' => $r_vertical ]);

    if(empty($newId)){
      return '0'; // returns 1
    }
    else{
      return $newId; // returns 1
    }
  }
  public function find_cadena_by_contract (Request $request) {
    $palabra = $request->text;
    $result = DB::select('CALL px_cadena_existe (?)', array($palabra));
    $resultado= $result[0]->cantidad;
    return $resultado;
  }
  public function create_rzcliente_by_contract (Request $request) {
    $r_rfc = $request->n_rfc;
    $r_name = $request->rfc_name;

    $r_address_one = $request->rfc_dir1;

    if (isset($request->rfc_dir2)) {
      $r_address_two = $request->rfc_dir2;
    }
    else{
      $r_address_two = '';
    }
    $r_email = $request->email_fact;
    $r_cp = $request->rfc_cp;

    $r_type = $request->rfc_type;
    $r_nacionalidad = $request->rfc_nacionalidad;
    $r_conc_fact = $request->rfc_comp;

    $newId = DB::table('rz_customers')->insertGetId(
      [ 'rfc' => $r_rfc,
        'name' => $r_name,
        'address_one' => $r_address_one,
        'address_two' => $r_address_two,
        'email' => $r_email,
        'postcode' => $r_cp,
        'rz_type_id' => $r_type,
        'rz_nationality_id' => $r_nacionalidad,
        'rz_concept_invoice_id' => $r_conc_fact,
        'created_at' => \Carbon\Carbon::now()
      ]
    );
    if(empty($newId)){
      return '0'; // returns 1
    }
    else{
      return $newId; // returns 1
    }
  }
  public function find_rfc_by_contract (Request $request) {
    $palabra = $request->text;
    $result = DB::select('CALL px_rz_customers_existe_rfc (?)', array($palabra));
    $resultado= $result[0]->cantidad;
    return $resultado;
  }
  public function find_namerfc_by_contract (Request $request) {
    $palabra = $request->text;
    $result = DB::select('CALL px_rz_customers_existe_name (?)', array($palabra));
    $resultado= $result[0]->cantidad;
    return $resultado;
  }
  public function view_rzcliente_by_contract (Request $request) {
    $result = Rz_customer::select('id', 'name')->get();
    return json_encode($result);
  }

  public function create_contract_master (Request $request) {
    $text_1= $request->key_maestro_service;
    $text_2= $request->key_maestro_verticals;
    $text_3= $request->key_maestro_cadena;
    $text_4= $request->key_maestro_contrato;
    $text_5= $request->key_maestro_sitio;

    $id_contrato_maestro=$text_1.'-'.$text_2.'-'.$text_3.'-'.$text_4.'-'.$text_5;

    $id_servicio = $request->sel_master_service;
    $id_vertical = $request->sel_master_vertical;
    $id_cadena = $request->sel_master_cadenas;

    $name_cadena = DB::table('cadenas')->where('id', $id_cadena)->value('name');

    $id_razon = $request->sel_razon;

    $text_name = $request->contact_name;
    $text_email = $request->contact_email;
    $text_phone = $request->contact_telephone;
    $id_user = $request->user_resc;

    $file_pdf = $request->file('fileInput');
    $file_extension = $file_pdf->getClientOriginalExtension(); //** get filename extension
    $fileName = $id_contrato_maestro.'.'.$file_extension;
    $pdf= $request->file('fileInput')->storeAs('filestore/storage/Contrato/'.$name_cadena.'/'.'Maestro', $fileName);

    $id_status = $request->status_cont;

    $newContMaster = DB::table('contract_masters')->insertGetId(
      [
        'digit' => $text_4,
        'name' => $text_name,
        'email' => $text_email,
        'telephone' => $text_phone,
        'user_id' => $id_user,
        'file' => $pdf,
        'rz_customer_id' => $id_razon,
        'contract_status_id' => $id_status,
        'created_at' => \Carbon\Carbon::now()
      ]
    );

    if(empty($newContMaster)){
      return '0'; // returns 1 error al registrar
    }
    else{
      $newIdcontrato = DB::table('idcontracts')->insertGetId(
        [
          'cxclassification_id' => $id_servicio,
          'vertical_id' => $id_vertical,
          'cadena_id' => $id_cadena,
          'contrat_id' => $newContMaster,
          'digit' => $text_5,
          'key' => $id_contrato_maestro,
          'idcontract_type_id' => 1,
          'created_at' => \Carbon\Carbon::now()
        ]
      );
      return $newContMaster; // returns 1
    }
  }

//Anexo de contrato
  public function idproy_search_by_cadena (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_contractsMasterXCadena (?)', array($id));
    return json_encode($result);
  }
  public function search_n_master_cadena (Request $request) {
    $id = $request->valor; //SUSTITUIR PROCEDURE
    $result = DB::table('contract_masters')->where('id', $id)->value('digit');
    return json_encode($result);
  }
  public function count_anexo_by_cont_maestro (Request $request) {
    $id = $request->valor; //SUSTITUIR PROCEDURE
    $result = DB::select('CALL px_contractsAnexosXMaster (?)', array($id));
    $resultado= $result[0]->cantidad;
    return json_encode($result);
  }

  public function create_contract_annexes (Request $request) {
    $text_1= $request->key_anexo_service;
    $text_2= $request->key_anexo_verticals;
    $text_3= $request->key_anexo_cadena;
    $text_4= $request->key_anexo_contrato;
    $text_5= $request->key_anexo_sitio;

    $id_contrato_anexo=$text_1.'-'.$text_2.'-'.$text_3.'-'.$text_4.'-'.$text_5;

    $id_servicio = $request->sel_anexo_service;
    $id_vertical = $request->sel_anexo_vertical;
    $id_cadena = $request->sel_anexo_cadenas;
    $id_contract_master = $request->sel_master_to_anexo;

    $name_cadena = DB::table('cadenas')->where('id', $id_cadena)->value('name');

    $text_signature_date = $request->contract_signature_date;
    $text_start_cont = $request->date_start_cont;
    $text_no_month = $request->sel_no_month;
    $text_date_end_cont = $request->date_end_cont_sist;
    $text_date_real = $request->contract_signature_date;

    $id_ingeniero = $request->sel_itconcierge;
    $id_comercial= $request->sel_business_executive;
    $id_status = $request->sel_estatus_anexo;

    $plazo_vencto = $request->num_vto;

    $file_pdf = $request->file('fileInputAnexo');
    $file_extension = $file_pdf->getClientOriginalExtension(); //** get filename extension
    $fileName = $id_contrato_anexo.'.'.$file_extension;
    $pdf= $request->file('fileInputAnexo')->storeAs('filestore/storage/Contrato/'.$name_cadena.'/Anexo', $fileName);

    //Monedas
      $num_max_posiciones = $request->contador_max;
      $posiciones_omitidas = $request->contadores_elim;
      //Registro de input dinamicos
      $array_data_dinamic_1 = $request->c_price;
      $array_data_dinamic_2 = $request->c_coin;
      $array_data_dinamic_3 = $request->c_tcambopt;
      $array_data_dinamic_4 = $request->c_tcamb;
      $array_data_dinamic_5 = $request->c_valiva;

    //sitios
      $site_num_max_posiciones = $request->site_contador_max;
      $site_posiciones_omitidas = $request->site_contadores_elim;

      $array_data_dinamic_site_1 = $request->c_cadena_add;
      $array_data_dinamic_site_2 = $request->c_hotel_add;


    $newAnnexeContMaster = DB::table('contract_annexes')->insertGetId(
      [
        // 'digit' => $text_5,
        'date_signature' => $text_signature_date,
        'date_scheduled_start' => $text_start_cont,
        'number_months' => $text_no_month,
        'number_expiration' => $plazo_vencto,
        'date_scheduled_end' => $text_date_end_cont,
        'date_real' => $text_date_real,
        'itconcierge_id' => $id_ingeniero,
        'business_user_id' => $id_comercial,
        'file' => $pdf,
        'contract_master_id' => $id_contract_master,
        'contract_status_id' => $id_status,
        'created_at' => \Carbon\Carbon::now()
      ]
    );

    if(empty($newAnnexeContMaster)){
      return '0'; // returns 1 error al registrar
    }
    else{
      $newIdcontrato = DB::table('idcontracts')->insertGetId(
        [
          'cxclassification_id' => $id_servicio,
          'vertical_id' => $id_vertical,
          'cadena_id' => $id_cadena,
          'contrat_id' => $newAnnexeContMaster,
          'digit' => $text_5,
          'key' => $id_contrato_anexo,
          'idcontract_type_id' => 2,
          'created_at' => \Carbon\Carbon::now()
        ]
      );

      // -- Añadir monedas
      if (isset($posiciones_omitidas)) {
        $array_omitidos = explode(",", $posiciones_omitidas);
        $tamanoArrayOmitido = count($array_omitidos);

        for ($k=0; $k <= $num_max_posiciones; $k++) {
          if (in_array($k, $array_omitidos)) { /*Busco dentro del array si existe el identificador*/
            /**NO HACER NADA, SI EXISTE EN EL ARRAY OMITIDOS*/
          }
          else{
            $id_iva_x = DB::table('ivas')->where('number', $array_data_dinamic_5[$k])->value('id');
            $amount_sincomas = str_replace(',','',$array_data_dinamic_1[$k]);

            ${"n_payment".$k} = DB::table('contract_payments')->insertGetId(
              [
                'quantity' => $amount_sincomas,
                'currency_id' => $array_data_dinamic_2[$k],
                'exchange_range_id' => $array_data_dinamic_3[$k],
                'exchange_range_value' => $array_data_dinamic_4[$k],
                'iva_id' =>   $id_iva_x,
                'contract_annex_id' => $newAnnexeContMaster,
                'created_at' => \Carbon\Carbon::now()
              ]
            );
          }
        }
      }
      else {
        $posiciones_omitidas = array();
        for ($z=0; $z <= $num_max_posiciones; $z++) {

          $id_iva_y = DB::table('ivas')->where('number', $array_data_dinamic_5[$z])->value('id');
          $amount_sincomas_2 = str_replace(',','',$array_data_dinamic_1[$z]);

          ${"n_payment".$z} = DB::table('contract_payments')->insertGetId(
            [
              'quantity' => $amount_sincomas_2,
              'currency_id' => $array_data_dinamic_2[$z],
              'exchange_range_id' => $array_data_dinamic_3[$z],
              'exchange_range_value' => $array_data_dinamic_4[$z],
              'iva_id' =>   $id_iva_y,
              'contract_annex_id' => $newAnnexeContMaster,
              'created_at' => \Carbon\Carbon::now()
            ]
          );
        }
      }

      // -- Añadir sitios
      if (isset($site_posiciones_omitidas)) {
        $site_array_omitidos = explode(",", $site_posiciones_omitidas);
        $site_tamanoArrayOmitido = count($site_array_omitidos);

        for ($yu=0; $yu <= $site_num_max_posiciones; $yu++) {
          if (in_array($yu, $site_array_omitidos)) { /*Busco dentro del array si existe el identificador*/
            /**NO HACER NADA, SI EXISTE EN EL ARRAY OMITIDOS*/
          }
          else{
            ${"n_sites".$yu} = DB::table('contract_sites')->insertGetId(
              [
                'cadena_id' => $array_data_dinamic_site_1[$yu],
                'hotel_id' => $array_data_dinamic_site_2[$yu],
                'contract_annex_id' => $newAnnexeContMaster,
                'created_at' => \Carbon\Carbon::now()
              ]
            );
          }
        }
      }
      else {
        $site_posiciones_omitidas = array();
        for ($yi=0; $yi <= $site_num_max_posiciones; $yi++) {
          ${"n_sites".$yi} = DB::table('contract_sites')->insertGetId(
            [
              'cadena_id' => $array_data_dinamic_site_1[$yi],
              'hotel_id' => $array_data_dinamic_site_2[$yi],
              'contract_annex_id' => $newAnnexeContMaster,
              'created_at' => \Carbon\Carbon::now()
            ]
          );
        }
      }

      //
      return $newAnnexeContMaster; // returns 1

    }

  }

  public function count_hotel_by_cadena (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_sitiosXcadena_cant (?)', array($id));
    return json_encode($result);
  }
  public function count_cont_by_cadena (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_count_contractsMasterXCadena (?)', array($id));
    return json_encode($result);
  }
  public function getcoinname (Request $request) {
    $id = $request->valor;
    $result = DB::table('currencies')
              ->select('id', 'name')
              ->where('id', '!=', $id)
              ->get();
    // $result = DB::select('CALL px_contratosXcadena_cant (?)', array($id));
    return json_encode($result);
  }
  public function search_idubicacion (Request $request) {
    $id = $request->valor; //SUSTITUIR PROCEDURE
    $result = DB::select('CALL px_id_ubicacionXsitio (?)', array($id));
    return json_encode($result);
  }
  public function get_bankdata_zipcode (Request $request) {
    $id = $request->valor;
    $result = DB::select('CALL px_datosXcodigopostal (?)', array($id));
    return json_encode($result);
  }

  public function index_edit()
  {
      $verticals = Vertical::select('id', 'name')->get();
      $cadenas = Cadena::select('id', 'name')->get();
      $contratos = Contrato::select('id', 'id')->get();
      $sitio= Cxclassification::select('id', 'name')->get();
      $currency = Currency::select('id','name')->get();
      $hotels = Hotel::select('id', 'Nombre_hotel')->get();
      $country = country::select('id', 'name')->get();
      $contract_status = Contract_status::select('id', 'name')->get();
      $resguardo = DB::select('CALL px_resguardoXgrupo_users (?)', array('1'));
      $rz_customer = Rz_customer::select('id', 'name')->get();
      $classifications = DB::select('CALL px_cxclassifications ()', array(''));
      $itconcierge = DB::select('CALL px_ITC_todos ()', array());
      $vendedores = DB::select('CALL px_resguardoXgrupo_users (?)', array('2'));

      $hoteles = DB::table('hotels')->select('id', 'Nombre_hotel')->get();
      $currency = Currency::select('id','name')->get();
      $iva = Iva::select('number')->get();


      return view('permitted.contract.cont_edit_cont', compact('iva','currency','hoteles','lista', 'classifications','verticals','cadenas', 'contratos', 'contract_status', 'resguardo', 'rz_customer' , 'sitio', 'itconcierge', 'vendedores'));
  }

  public function get_digit_contract_master(Request $request)
  {
    $service = $request->id_service;
    $vertical = $request->id_vertical;
    $cadena = $request->id_cadena;
    $data_contracts = [];

    $contract_masters = DB::select('CALL px_contrac_master_ids (?,?,?)', array($service,$vertical, $cadena));

    $tamanodata = count($contract_masters);

    for($i = 0;$i < $tamanodata; $i++)
    {
        array_push($data_contracts, ['digit' => $i + 1, 'id_contract' => $contract_masters[$i]->contrat_id ]);
    }

     return $data_contracts;
  }

  public function get_ids_contract_anexo(Request $request)
  {
    $service = $request->id_service;
    $vertical = $request->id_vertical;
    $cadena = $request->id_cadena;
    $key = $request->key;

    $data_contracts_anexos = [];

    $contract_anexos = DB::select('CALL px_idcontractsXkey (?,?,?,?)', array($service,$vertical, $cadena, $key));

    $tamanodata = count($contract_anexos);

    for($i = 0;$i < $tamanodata; $i++)
    {
        array_push($data_contracts_anexos, ['contrat_id' => $contract_anexos[$i]->contrat_id , 'key' => $contract_anexos[$i]->key ]);
    }

     return $data_contracts_anexos;
  }

  public function get_data_contract_master(Request $request)
  {
    $id_contract = $request->id_contract;

    $result = DB::select('CALL px_contrac_master_data(?)', array($id_contract));

    return $result;
  }

  public function get_data_anexos(Request $request)
  {
      $id_contract = $request->id_contract;

      $result = DB::select('CALL px_contrac_annexes_data(?)', array($id_contract));

      return $result;
  }

  public function update_contract_master(Request $request)
  {
    $service = $request->sel_master_service;
    $vertical = $request->sel_master_vertical;
    $cadena = $request->sel_master_cadenas;
    $digit = $request->digit;
    $rz = $request->sel_razon;
    $nombre  = $request->contact_name;
    $email = $request->contact_email;
    $telefono = $request->contact_telephone;
    $status = $request->status_cont;
    $user_resc = $request->user_resc;
    $flag = "false";

    $contract_masters = DB::table('idcontracts')->select('contrat_id','key')->where('cxclassification_id', $service)
                                                                      ->where('vertical_id', $vertical)
                                                                      ->where('cadena_id', $cadena)->get();
    $tamanodata = count($contract_masters);

    for($i = 0;$i < $tamanodata; $i++)
    {
      $result = DB::table('contract_masters')->select('id', 'digit')->where('id', $contract_masters[$i]->contrat_id)
                                                                    ->where('digit', $digit)->get();
      if(count($result) != 0){
        $id_contract = $result[0]->id;

        $sql = DB::table('contract_masters')->where('id', $id_contract)->update(['name' => $nombre,
                                                     'email' => $email ,
                                                     'telephone' => $telefono,
                                                     'user_id' => $user_resc,
                                                     'rz_customer_id' => $rz,
                                                     'contract_status_id' => $status,
                                                     'updated_at' =>  \Carbon\Carbon::now()]);

          //Remplazando pdf si se subio
          if($request->file('fileInput') != null )
          {
            $name_cadena = DB::table('cadenas')->where('id', $cadena)->value('name');
            $fileName = $contract_masters[$i]->key.  '.' .'pdf';
            $pdf = $request->file('fileInput')->storeAs('filestore/storage/Contrato/'.$name_cadena.'/'.'Maestro', $fileName);

            $sql2 = DB::table('contract_masters')->where('id', $id_contract)->update(['file' => $pdf ]);
          }
        break;
      }

    }

    $flag = "true";

    return $flag;

  }

  public function update_contract_anexo(Request $request)
  {
    $service = $request->sel_anexo_service;
    $vertical = $request->sel_anexo_vertical;
    $cadena = $request->sel_anexo_cadenas;
    $id_contrat_anexo = $request->digit;
    $id_master_to_anexo = $request->sel_master_to_anexo;
    $contract_signature_date = $request->contract_signature_date;
    $date_start_cont  = $request->date_start_cont;
    $date_end_cont_sist = $request->date_end_cont_sist;
    $contract_real_date = $request->contract_real_date;
    $status = $request->sel_estatus_anexo;
    $itconcierge = $request->sel_itconcierge;
    $no_month = $request->sel_no_month;
    $business_executive = $request->sel_business_executive;
    $flag = "false";
    $plazo_vencto = $request->edit_num_vto;


    $contract_masters = DB::table('idcontracts')->select('contrat_id','key')->where('cxclassification_id', $service)
                                                                            ->where('vertical_id', $vertical)
                                                                            ->where('cadena_id', $cadena)
                                                                            ->where('contrat_id', $id_contrat_anexo)->get();

    $sql = DB::table('contract_annexes')->where('id', $id_contrat_anexo)
                                        ->update(['date_signature' => $contract_signature_date,
                                                 'date_scheduled_start' => $date_start_cont ,
                                                 'number_months' => $no_month,
                                                 'number_expiration' => $plazo_vencto,
                                                 'date_scheduled_end' => $date_end_cont_sist,
                                                 'date_real' => $contract_real_date,
                                                 'business_user_id' => $business_executive,
                                                 'itconcierge_id' => $itconcierge,
                                                 'contract_status_id' => $status,
                                                 'updated_at' =>  \Carbon\Carbon::now()]);

      //Remplazando pdf si se subio
      if($request->file('fileInputAnexo') != null )
      {
        $name_cadena = DB::table('cadenas')->where('id', $cadena)->value('name');
        $fileName = $contract_masters[0]->key.  '.' .'pdf';
        $pdf= $request->file('fileInputAnexo')->storeAs('filestore/storage/Contrato/'.$name_cadena.'/Anexo', $fileName);

        $sql2 = DB::table('contract_annexes')->where('id', $id_contrat_anexo)->update(['file' => $pdf ]);
      }

    $flag = "true";

    return $flag;

  }

  public function index_pay()
  {
      return view('permitted.contract.cont_regpay_cont', compact('lista'));
  }
  public function index_hist()
  {
      return view('permitted.contract.cont_hist_cont', compact('lista'));
  }

  public function show_dashboard_states(Request $request)
  {
    $date = $request->date;

    $result = DB::select('CALL px_contratosXestado (?)', array($date));

    return $result;
  }

  public function show_table_news_contracts(Request $request)
  {
    $date = $request->date;

    $result = "datos";

    return $result;
  }

  public function show_table_active_contracts(Request $request)
  {
    $date = $request->date;

    $result = "datos";

    return $result;
  }

  public function show_table_expired_contracts(Request $request)
  {
    $date = $request->date;

    $result = "datos";

    return $result;
  }

  public function getInvoiceContract(Request $request)
 {
   $file = $request->file;

   $path = public_path('/images/storage/'.$file);

   if(File::exists($path)){
       return response()->download($path);
   }

 }
 public function get_data_info_master_anexo (Request $request) {
   $id = $request->valor;
   $result = DB::select('CALL px_contract_customer (?)', array($id));
   return json_encode($result);
 }
 public function all_site_anexo(Request $request)
 {
      $id = $request->id_contract;
      $result = DB::select('CALL px_contract_annex_cadena_hotel (?)', array($id));
      return json_encode($result);
 }
 public function edit_site_anexo(Request $request)
 {
      $id = $request->id;
      $result = DB::select('CALL px_contract_sites_cadena_hotel (?)', array($id));
      return json_encode($result);
 }
 public function add_site_anexo(Request $request)
 {
   $cadena = $request->cadena_add;
   $site = $request->site_add;
   $anexo = $request->id_anexo;
   $newId = DB::table('contract_sites')->insertGetId([
     'cadena_id' => $cadena,
     'hotel_id' => $site,
     'contract_annex_id' => $anexo,
     'created_at' => \Carbon\Carbon::now() ]);
   if(empty($newId)){
      return '0'; // returns 0
   }
   else{
      return $newId; // returns id reg
   }
 }
 public function delete_site_anexo(Request $request)
 {
   $name_user = Auth::user()->name;
   $id = $request->valor;
   $result = DB::select('CALL px_contract_sites_log_del (?,?)', array($id, $name_user));
   return json_encode($result);
 }
 public function all_coin_anexo(Request $request)
 {
      $id = $request->id_contract;
      $result = DB::select('CALL px_contract_payments_data (?)', array($id));
      return json_encode($result);
 }
 public function add_new_coin_anexo(Request $request)
 {
      $mensualidad = $request->mensualidad_add;
      $moneda = $request->moneda_add;
      $tcoption = $request->formatcoption;
      $tcvalue = $request->formatcvalue;
      $iva = $request->iva_add;
      $idubicacion = $request->id_anexo;
      $mensiva = $request->mensconiva_add;
      $mensualidad_str = str_replace(',', '', $mensualidad);
      $mensualidad_str = (float)$mensualidad_str;

      $validacion= 0;
      $existe = DB::table('contract_payments')
                ->where('contract_annex_id', $idubicacion)
                ->where('currency_id', $moneda)
                ->count();
     $id_iva = DB::table('ivas')->where('number', $iva)->value('id');

      if ($request->formatcvalue == '') { $tcvalue = 0; }

      if ($existe > 0) {
        return $validacion;
      }
      else{
        $newId = DB::table('contract_payments')->insertGetId([
          'quantity' => $mensualidad_str,
          'currency_id' => $moneda,
          'exchange_range_id' => $tcoption,
          'exchange_range_value' => $tcvalue,
          'iva_id' => $id_iva,
          'contract_annex_id' => $idubicacion,
          'created_at' => \Carbon\Carbon::now() ]);
        if(empty($newId)){
           return $validacion; // returns 0
        }
        else{
           return $newId; // returns id reg
        }
      }
 }
 public function delete_coin_anexo(Request $request)
 {
   $name_user = Auth::user()->name;
   $id = $request->valor;
   $result = DB::select('CALL px_contract_payments_log_del (?,?)', array($id, $name_user));
   return json_encode($result);
 }

}
