<?php
namespace App\Http\Controllers\Contracts;

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

//use App\Currency; Si se usa cambiado por query builder
//use App\Hotel; Si se usa cambiado por query builder
//use App\country; Si se usa cambiado por query builder

/*Si se usan
use App\Rz_type; cambiado por query builder
use App\Rz_nationality; cambiado por query builder
use App\Rz_concept_invoice; cambiado por query builder
use App\Rz_customer; cambiado por query builder
use App\Iva; cambiado por query builder
use App\Contract_status; cambiado por query builder*/

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
      return view('permitted.contract.cont_dashboard');
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
    //$contratos = Contrato::select('id', 'id')->get();
    $sitio= DB::Table('cxclassifications')->select('id', 'name')->get();
    $currency = DB::Table('currencies')->select('id','name')->get();
    $hotels = DB::Table('hotels')->select('id', 'Nombre_hotel')->get();
    $country = DB::Table('countries')->select('id', 'name')->get();

    $classifications = DB::select('CALL px_cxclassifications ()', array(''));

    $rz_type = DB::Table('rz_types')->select('id', 'name')->get();
    $rz_nationality = DB::Table('rz_nationalities')->select('id', 'name')->get();
    $rz_concept_invoice = DB::Table('rz_concept_invoices')->select('id', 'key', 'name')->get();
    // $rz_customer = DB::Table('rz_customers')->select('id', 'name')->get();
    $rz_customer = DB::select('CALL px_customers_data_list ()', array());

    $iva = DB::Table('ivas')->select('number')->get();

    $resguardo = DB::select('CALL px_resguardoXgrupo_users (?)', array('1'));
    $vendedores = DB::select('CALL px_resguardoXgrupo_users (?)', array('2'));
    $itconcierge= DB::select('CALL px_ITC_todos ()', array());

    $contract_status = DB::Table('contract_statuses')->select('id', 'name')->get();

    $unitmeasures = DB::select('CALL GetUnitMeasuresActivev2 ()', array());
    $satproduct = DB::select('CALL GetSatProductActivev2 ()', array());


    $payment_term = DB::select('CALL GetAllPaymentTermsv2 ()', array());
    $payment_term_act = DB::select('CALL px_payment_terms_data ()', array());

    $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
    $payment_methods = DB::select('CALL GetAllPaymentMethodsv2 ()', array());
    $cfdi_uses = DB::select('CALL GetAllCfdiUsev2 ()', array());
    $countries = DB::select('CALL GetAllCountryActivev2 ()', array());
    $states = DB::select('CALL GetAllStateActivev2 ()', array());
    $cities = DB::select('CALL GetAllCitiesv2 ()', array());
    $payment = DB::select('CALL GetAllCitiesv2 ()', array());


    return view('permitted.contract.cont_create_cont', compact(
      'unitmeasures','satproduct','classifications','verticals',
      'cadenas', 'sitio','currency', 'hotels', 'country', 'rz_type',
      'rz_nationality', 'rz_concept_invoice', 'contract_status', 'rz_customer',
      'iva', 'resguardo','vendedores','itconcierge',
      'payment_term','payment_way','payment_methods','cfdi_uses','countries','states','cities', 'payment_term_act'
    ));
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

    // $text_name = $request->contact_name;
    // $text_email = $request->contact_email;
    // $text_phone = $request->contact_telephone;
    $id_user = $request->user_resc;

    $file_pdf = $request->file('fileInput');
    $file_extension = $file_pdf->getClientOriginalExtension(); //** get filename extension
    $fileName = $id_contrato_maestro.'.'.$file_extension;
    $pdf= $request->file('fileInput')->storeAs('filestore/storage/Contrato/'.$name_cadena.'/'.'Maestro', $fileName);

    $id_status = $request->status_cont;

    $newContMaster = DB::table('contract_masters')->insertGetId(
      [
        'digit' => $text_4,
        // 'name' => $text_name,
        // 'email' => $text_email,
        // 'telephone' => $text_phone,
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

      //Datos para facturacion
      $fact_descrip_fact= !empty($request->description_fact) ? $request->description_fact : '';
      $fact_unidad_medida = $request->sel_unitmeasure;
      $fact_sat_product = $request->sel_satproduct;

      $fact_plazo_vencto = $request->num_vto;
      $fact_forma_pago = $request->payment_way_id;
      $fact_metodo_pago = $request->payment_method_id;
      $fact_uso_cfdi = $request->cfdi_use_id;

      //banderas vtc, venue,compartir ingreso
      $cont_vtc=$request->cont_vtc;
      $cont_venue=$request->cont_venue;
      $comp_ingreso=$request->comp_ingreso;
      //info($request);
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
        'description_fact' => $fact_descrip_fact,
        'unit_measure_id' => $fact_unidad_medida,
        'sat_product_id' => $fact_sat_product,
        'vtc'=>$cont_vtc,
        'venue'=>$cont_venue,
        'compartir_ingreso'=>$comp_ingreso,
        'payment_term_id'=>$fact_plazo_vencto,
        'payment_way_id'=>$fact_forma_pago,
        'payment_method_id'=>$fact_metodo_pago,
        'cfdi_user_id'=>$fact_uso_cfdi,
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
      //$contratos = Contrato::select('id', 'id')->get();
      $sitio= DB::Table('cxclassifications')->select('id', 'name')->get();
      $currency = DB::Table('currencies')->select('id','name')->get();
      $hotels = DB::Table('hotels')->select('id', 'Nombre_hotel')->get();
      $country = DB::Table('countries')->select('id', 'name')->get();
      $contract_status = DB::Table('contract_statuses')->select('id', 'name')->get();
      $resguardo = DB::select('CALL px_resguardoXgrupo_users (?)', array('1'));
      $rz_customer = DB::Table('customers')->select('id', 'name')->get();
      $classifications = DB::select('CALL px_cxclassifications ()', array(''));
      $itconcierge = DB::select('CALL px_ITC_todos ()', array());
      $vendedores = DB::select('CALL px_resguardoXgrupo_users (?)', array('2'));
      $iva = DB::Table('ivas')->select('number')->get();
      $unitmeasures = DB::select('CALL GetUnitMeasuresActivev2 ()', array()); 
      $satproduct = DB::select('CALL GetSatProductActivev2 ()', array()); 

      $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
      $payment_methods = DB::select('CALL GetAllPaymentMethodsv2 ()', array());
      $cfdi_uses = DB::select('CALL GetAllCfdiUsev2 ()', array());
      $payment_term = DB::select('CALL GetAllPaymentTermsv2 ()', array());
      
      return view('permitted.contract.cont_edit_cont', compact('unitmeasures', 'satproduct', 'iva','currency','hotels', 'classifications','verticals','cadenas', 'contract_status', 'resguardo', 'rz_customer' , 'sitio', 'itconcierge', 'vendedores', 'payment_way', 'payment_methods', 'cfdi_uses', 'payment_term'));
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

  public function get_ids_contract_anexo_v2(Request $request)
  {
    $cadena = $request->id_cadena;
    $key = $request->key;

    $data_contracts_anexos = [];

    $contract_anexos = DB::select('CALL px_idcontractsXkeyV2 (?,?)', array($cadena, $key));

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
  public function get_data_rz_selected(Request $request){
    $id_razon = $request->razon;
    $result = DB::select('CALL px_customers_data(?)', array($id_razon));
    return $result;
  }

  public function get_data_anexos(Request $request)
  {
      $id_contract = $request->id_contract;

      $result = DB::select('CALL px_contrac_annexes_data(?)', array($id_contract));

      return $result;
  }

  public function get_data_master_anexo(Request $request)
  {
      $id_anexo = $request->id_contract;

      $result = DB::select('CALL px_anexo_contrato_data(?)', array($id_anexo));

      return $result;
  }

  public function update_contract_master(Request $request)
  {
    $service = $request->sel_master_service;
    $vertical = $request->sel_master_vertical;
    $cadena = $request->sel_master_cadenas;
    $digit = $request->digit;
    $rz = $request->sel_razon;
    //$nombre  = $request->contact_name;
    //$email = $request->contact_email;
    //$telefono = $request->contact_telephone;
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

        $sql = DB::table('contract_masters')->where('id', $id_contract)->update(['user_id' => $user_resc,
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
    // $plazo_vencto = $request->edit_num_vto; //se va eliminar cambiar a payment_term_id
    $termino_pago = $request->payment_term_id; // nuevo valor de facturacion.
    $unitmeasures = $request->sel_unitmeasure;
    $satproduct = $request->sel_satproduct;
    // Nuevos 3 valores para facturacion.
    $forma_pago = $request->payment_way_id;
    $metodo_pago = $request->payment_method_id;
    $uso_cfdi = $request->cfdi_use_id;
    
    $description_fact= $request->description_fact;

    $cont_vtc=$request->cont_vtc;
    $cont_venue=$request->cont_venue;
    $comp_ingreso=$request->comp_ingreso;

    $contract_masters = DB::table('idcontracts')->select('contrat_id','key')->where('cxclassification_id', $service)
                                                                            ->where('vertical_id', $vertical)
                                                                            ->where('cadena_id', $cadena)
                                                                            ->where('contrat_id', $id_contrat_anexo)->get();

    $sql = DB::table('contract_annexes')->where('id', $id_contrat_anexo)
                                        ->update(['date_signature' => $contract_signature_date,
                                                 'date_scheduled_start' => $date_start_cont ,
                                                 'number_months' => $no_month,
                                                 // 'number_expiration' => $plazo_vencto, // ya no se usara?
                                                 'date_scheduled_end' => $date_end_cont_sist,
                                                 'date_real' => $contract_real_date,
                                                 'business_user_id' => $business_executive,
                                                 'description_fact' => $description_fact,
                                                 'unit_measure_id' => $unitmeasures,
                                                 'sat_product_id' => $satproduct,
                                                 'vtc'=>$cont_vtc,
                                                 'venue'=>$cont_venue,
                                                 'compartir_ingreso'=>$comp_ingreso,
                                                 'itconcierge_id' => $itconcierge,
                                                 'contract_status_id' => $status,
                                                 'payment_term_id' => $termino_pago,
                                                 'payment_way_id' => $forma_pago,
                                                 'payment_method_id' => $metodo_pago,
                                                 'cfdi_user_id' => $uso_cfdi,
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
      //info($id);
      $result = DB::select('CALL px_contract_annex_cadena_hotel (?)', array($id));

      $cont_vtc = DB::Table('contract_annexes')->select('vtc')->where('id',$id)->get();
      $cont_venue= DB::Table('contract_annexes')->select('venue')->where('id',$id)->get();
      $comp_ingreso = DB::Table('contract_annexes')->select('compartir_ingreso')->where('id',$id)->get();
      /*Agregamos los estados del switch*/
      $result[0]->vtc=$cont_vtc[0]->vtc;
      $result[0]->venue=$cont_venue[0]->venue;
      $result[0]->compartir_ingreso=$comp_ingreso[0]->compartir_ingreso;
      //info($result);
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
 public static function dateTimeToSql($date)
  {
      $date_orden = str_replace('/', '-', $date );
      return date('Y-m-d', strtotime($date_orden));
  }
 public function index_contract_expiration(Request $request)
 {
   return view('permitted.contract.contract_expiration');
 }
 public function contract_expiration_notvenue(Request $request)
 {
   $date_start = $this->dateTimeToSql($request->start);
   $date_end = $this->dateTimeToSql($request->end);
   $resultados = DB::select('CALL px_contract_annexes_vencido_serv_adm (?,?)', array($date_start, $date_end ));
   return json_encode($resultados);
 }
 public function contract_expiration_venue(Request $request)
 {
   $date_start = $this->dateTimeToSql($request->start);
   $date_end = $this->dateTimeToSql($request->end);
   $resultados = DB::select('CALL px_contract_annexes_vencido_venue (?,?)', array($date_start, $date_end ));
   return json_encode($resultados);
 }
 public function contract_expiration_info(Request $request)
 {
   $id_maestro = $request->value;
   $result = DB::select('CALL px_anexos_fechas (?)', array($id_maestro));
   return json_encode($result);

 }


 public function create_rza_by_contract (Request $request) {

     $name = $request->inputCreatName;
     $rfc = $request->inputCreatTaxid;
     $n_rfc = $request->inputCreatNumid;
     $email = $request->inputCreatEmail;
     $phone = !empty($request->inputCreatPhone) ? $request->inputCreatPhone : '';
     $movil = !empty($request->inputCreatMobile) ? $request->inputCreatMobile : '';

     $term = $request->select_one_mdal;
     $form = $request->select_two_mdal;
     $metd = $request->select_three_mdal;
     $cfi = $request->select_four_mdal;
     $address = $request->inputCreatAddress_1;
     $pais = $request->select_six_mdal;
     $estado = $request->select_seven_mdal;
     $ciudad = $request->select_eight_mdal;
     $code = $request->inputCreatPostCode;

   $newId = DB::table('customers')->insertGetId(
     [
       'name' => $name,
       'taxid' => $rfc,
       'numid' => $n_rfc,
       'email' => $email,
       'phone' => $phone,
       'phone_mobile' => $movil,
       'payment_term_id' => $term,
       'payment_way_id' => $form,
       'payment_method_id' => $metd,
       'cfdi_use_id' => $cfi,
       'salesperson_id' => 1,
       'address_1' => $address,
       'country_id' => $pais,
       'state_id' => $estado,
       'city_id' => $ciudad,
       'postcode' => $code,
       'sort_order' => 0,
       'status' => 1,
       'provider' => 0,
       'created_at' => \Carbon\Carbon::now(),
       'created_uid' => \Auth::user()->id,
       'updated_uid' => \Auth::user()->id,
     ]
   );
   if(empty($newId)){
     return '0'; // returns 1
   }
   else{
     return $newId; // returns 1
   }
 }
 public function reset_rza_by_contract (Request $request) {
   $result = DB::select('CALL px_customers_data_list ()', array());
   return json_encode($result);
 }
 public function search_client_contract (Request $request) {
   $result = DB::select('CALL px_customers_data_list2 ()', array());
   return json_encode($result);
 }

}
