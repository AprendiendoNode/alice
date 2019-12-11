<?php

namespace App\Http\Controllers\Payments;
use App\Cadena;
use App\Proveedor;
use App\Vertical;
use App\Reference;
use App\Hotel;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Banco;
use App\Currency;
use App\Prov_bco_cta;
use App\Pay_status_user;
use App\Pay_factura;
use App\Payments_venues;
use App\Payments_application;
use App\Payments_area;
use App\Payments_classification;
use App\Payments_comment;
use App\Payments_financing;
use App\Payments_project_options;
use App\Payments_states;
use App\Payments_verticals;
use App\Models\Catalogs\PaymentWay;
use App\Payments_priority;
use App\Payments;
use Auth;
use Mail;
use App\Mail\SolicitudesP;
use App\Mail\CambioCuentaPago;
use File;
use Storage;

use App\Payments_venue;
class PayAddController extends Controller
{
  public function index()
  {
      $cadena = Cadena::select('id', 'name')->get()->sortBy('name');
      $proveedor = DB::Table('customers')->select('id', 'name')->get();//Proveedor::select('id', 'nombre')->get();
      $vertical = Payments_verticals::pluck('name', 'id');
      $currency = Currency::select('id','name')->get();
      $way = Payments_way_pay::select('id','name')->get();
      $area = Payments_area::pluck('name', 'id');
      $application = Payments_application::pluck('name', 'id');
      $options = Payments_project_options::pluck('name', 'id');
      $classification =Payments_classification::select('id','name')->get();
      $financing = Payments_financing::pluck('name', 'id');
      $priority = Payments_priority::select('id', 'name')->get();
      $banquitos = Banco::select('id', 'nombre')->get();
       return view('permitted.payments.add_request_pay',compact('cadena','proveedor','vertical', 'currency', 'way', 'area', 'application', 'options', 'classification', 'financing', 'priority', 'banquitos'));
      //return view('permitted.payments.add_request_test',compact('cadena','proveedor','vertical', 'currency', 'way', 'area', 'application', 'options', 'classification', 'financing', 'priority', 'banquitos'));
  }
  public function index2()
  {
      $cadena = Cadena::select('id', 'name')->get()->sortBy('name');
      $proveedor = DB::Table('customers')->select('id', 'name')->get();//Proveedor::select('id', 'nombre')->get();
      $vertical = Payments_verticals::pluck('name', 'id');
      $currency = Currency::select('id','name')->get();
      $way = Payments_way_pay::select('id','name')->get();
      $area = Payments_area::pluck('name', 'id');
      $application = Payments_application::pluck('name', 'id');
      $options = Payments_project_options::pluck('name', 'id');
      $classification =Payments_classification::select('id','name')->get();
      $financing = Payments_financing::pluck('name', 'id');
      $priority = Payments_priority::select('id', 'name')->get();
      $banquitos = Banco::select('id', 'nombre')->get();
      return view('permitted.payments.add_request_pay_mult',compact('cadena','proveedor','vertical', 'currency', 'way', 'area', 'application', 'options', 'classification', 'financing', 'priority', 'banquitos'));
  }
  public function index3()
  {
    $proveedor = DB::table('customers')->select('id', 'name')->get();
    $cxclassifications = DB::table('cxclassifications')->select('id', 'name')->get();
    $cxservices = DB::table('cxservices')->select('id', 'name')->get();
    // $cxconcepts = DB::table('cxconcepts')->select('id', 'name')->get();
    // $cxdescriptions = DB::table('cxdescriptions')->select('id', 'name')->get();
    $verticals = DB::table('verticals')->select('id', 'name')->get();
    $cadenas = DB::table('cadenas')->select('id', 'name')->get();
    $currency = Currency::select('id','name')->get();
    $banquitos = DB::table('bancos')->select('id', 'nombre')->get();
    $way = PaymentWay::select('id','name')->get();
    $priority = DB::table('payments_priorities')->select('id', 'name')->get();
    return view('permitted.payments.add_request_test', compact('proveedor', 'cxclassifications', 'cxservices', 'verticals', 'cadenas', 'banquitos', 'currency', 'way', 'priority'));
  }
  //cuenta contable
  public function get_classxservice(Request $request)
  {
    $id_search = $request->data_one;
    $res = DB::select('CALL px_cxclassification_cxservices(?)', array($id_search));
    return $res;
  }
  //cuenta contable
  public function get_cxconcepts(Request $request)
  {
    $id_search = $request->data_one;
    $res = DB::select('CALL px_cxconcept_cxservices(?)', array($id_search));
    return $res;
  }
  //cuenta contable
  public function get_cxdescriptions(Request $request)
  {
    $id_search = $request->data_one;
    $res = DB::select('CALL px_cxconcept_cxdescriptions(?)', array($id_search));
    return $res;
  }
  //cuenta contable (get chain en base al servicio(classif))
  public function classif_vertical_chain(Request $request)
  {
    $id_search = $request->data_one;
    $res = DB::select('CALL px_cadenasXclasifications(?)', array($id_search));
    return $res;
  }
  public function hotel_cadena(Request $request)
  {
      $id = $request->data_one;
      //$hotel = DB::table('hotels')->select('id', 'Nombre_hotel')->where('cadena_id', $id)->get();
      $hotel = DB::select('CALL px_get_hotel_cadena(?)', array($id));
      return json_encode($hotel);
  }
  public function get_proyecto(Request $request)
  {
    $id = $request->data_one;
    $proyecto = DB::select('CALL get_proyecto_hotel(?)', array($id));
    return json_encode($proyecto);
  }
  public function get_bank(Request $request)
  {
    $id_customer = $request->data_one;
    $id_prov = $request->data_two;
    $data_bank = DB::select('CALL get_banco_prov(?)', array($id_prov));
    return json_encode($data_bank);
  }
  public function get_proveedor(Request $request)
  {
    $id_customer = $request->data_one;
    $proveedor = DB::select('CALL get_proveedor_hotel(?)', array($id_customer));
    return json_encode($proveedor);
  }
  public function get_data_account(Request $request)
  {
    $id_proveedor = $request->data_one;
    $id_bank = $request->data_two;
    $proveedor = DB::select('CALL get_ctabco_prov(?,?)', array($id_proveedor,$id_bank));
    return json_encode($proveedor);
  }
  public function info_account(Request $request)
  {
    $id_account = $request->data_one;
    $result = DB::select('CALL get_ctabco_data(?)', array($id_account));
    return json_encode($result);
  }
  public function set_data_bank(Request $request)
  {
    $id_proveedor = $request->identificador;
    $id_bank = $request->reg_bancos;
    $id_coin = $request->reg_coins;
    $cuenta = $request->reg_cuenta;
    $clabe = $request->reg_clabe;
    $referencia = $request->reg_reference;
    $flag = 0;
    if (empty($referencia)){
      $referencia= '';
    }
    //Pregunto si existe proveedor y banco en prov_bco_ctas
    $count_bk = DB::table('prov_bco_ctas')->where('prov_id', $id_proveedor)->count();
    // $count_bk = DB::select('CALL px_prov_bco_ctas_exist(?,?)', array($id_proveedor,$id_bank));

    //Datos para correo.
    $proveedor_n = DB::table('customers')->select('name')->where('id', $id_proveedor)->value('name');
    $banco_n = DB::table('bancos')->select('nombre')->where('id', $id_bank)->value('nombre');
    $moneda_n = DB::table('currencies')->select('name')->where('id', $id_coin)->value('name');

    $data = [
      'proveedor' => $proveedor_n,
      'banco' => $banco_n,
      'moneda' => $moneda_n,
      'cuenta' => $cuenta,
      'clabe' => $clabe,
      'referencia' => $referencia
    ];

    // if($count_bk[0]->existe == '1'){
    if($count_bk == '1') {

      DB::table('customer_bank_accounts')->insert([
        'customer_id' => $id_proveedor,
        'bank_id' => $id_bank,
        'name' => '-',
        'account_number' => $cuenta,
        'clabe' => $clabe,
        'referencia' => $referencia,
        'currency_id' => $id_coin,
        'status_prov_id' =>  '2'
      ]);

      //Mail::to(['mortiz@sitwifi.com','elopez@sitwifi.com'])->send(new CambioCuentaPago($data));

      $flag = 1;
    }
    else {

      DB::table('customer_bank_accounts')->insert([
        'customer_id' => $id_proveedor,
        'bank_id' => $id_bank,
        'name' => '-',
        'account_number' => $cuenta,
        'clabe' => $clabe,
        'referencia' => $referencia,
        'currency_id' => $id_coin,
        'status_prov_id' =>  '1'
      ]);

      //Mail::to(['mortiz@sitwifi.com','elopez@sitwifi.com'])->send(new CambioCuentaPago($data));

      $flag = 1;
    }
    return $flag;

  }
  public function getStateFactura(Request $request)
  {
    $factura = $request->factura;
    $proveedor_id = $request->proveedor;
    $count = DB::table('payments')->select('factura','payments_states_id','proveedor_id')->where('factura', $factura)->count();
    $flag = 0;
    if($count > 0){
      for($i = 0; $i < $count; $i++)
      {
        $result = DB::table('payments')->select('factura','payments_states_id','proveedor_id')->where('factura', $factura)->get();

        if($result[$i]->payments_states_id == 4 && $result[$i]->proveedor_id == $proveedor_id){
           $flag = 1; // La factura ya esta pagada
        }

      }
   }
    return $flag;
  }
  public function sitio_ubication(Request $request)
  {
    $id = $request->data_one;
    $hotel = DB::table('hotels')->where('id', $id)->value('id_ubicacion');
    return $hotel;
  }
  public function create_pay_test(Request $request)
  {
    $id_priority = $request->priority_id;
    //CuentaContable.
    $cc_key = $request->cc_key;
    $date_limit = $request->date_limit;
    $cadena_id = $request->cadena_id;
    $sitio_id = $request->sitio_id;
    $id_proyecto = $request->project;
    $id_sitio = $request->customer;
    $purchase = $request->purchase_order;
    $id_proveedor = $request->provider;
    $monto = (float)$request->price;
    $iva = (float)$request->iva;
    $totales = (float)$request->totales;
    $moneda = $request->coin;
    $orden_compra = $request->purchase_order;
    $concepto_pago = $request->description;
    $forma_pago = $request->methodpay;
    $factura = $request->factura;
    $observacion = $request->observaciones;
    $banco = $request->bank;
    $account = $request->account;
    $referencia = $request->reference_banc;
    $tasa = 16;
    $real_cc = "";
    $name_cc = "";
    $array_cc = explode('|', $cc_key);
    $real_cc = $array_cc[0];
    $name_cc = $array_cc[1];
    $real_cc = trim($real_cc);
    $name_cc = trim($name_cc);
    $date_lim_f = str_replace('/', '-', $date_limit);
    $date_lim_f = date('Y-m-d', strtotime($date_lim_f));

    $result = DB::table('customer_bank_accounts')->select('referencia')->where('id', $account)->first();

    $nueva_referencia = "default";

    if($referencia != ($result->referencia)) {

      $nueva_referencia = $referencia;
      
    }

    /*if ($iva == 0) {
      //iva = parseFloat((subtotal * tasa)/100); 39.2
      $iva = (float)($monto * $tasa)/100;
      $iva = round($iva, 2);

      $monto = (float)($monto - $iva);
      $monto = round($monto, 2);

      $totales = (float)($monto + $iva);
      $totales = round($totales, 2);
    }
    return 'subtotal: ' . $monto . ' | iva: ' . $iva . ' | totales: ' . $totales;*/
    $folio_new = $this->createFolio();
    $check_fact = 3;

    if (isset($request->check_factura_sin)) {
      //$check_factura_sin = (bool)$request->check_factura_sin;
      $check_fact = 1;
    }else if (isset($request->check_factura_pend)) {
      $check_fact = 2;
    }else if (0 == filesize($request->file('fileInput'))) {
      $check_fact = 2;
    }
    else{
      $check_fact = 3;
    }
    //return $check_fact;

    //Ultimo id registrado de payments
    $id_payment = DB::table('payments')->insertGetId([
      'folio' => $folio_new,
      'proveedor_id' => $id_proveedor,
      'payments_states_id' => '1',
      'date_solicitude' => date('Y-m-d'),
      'purchase_order' => $purchase,
      'date_limit' => $date_lim_f,
      'factura' => $factura,
      'purchase_order' => $orden_compra,
      'amount' => $totales,
      'prov_bco_ctas_id' => $account,
      'way_pay_id' => $forma_pago,
      'currency_id' => $moneda,
      'concept_pay' => $concepto_pago,
      'name' => $observacion,
      'priority_id' => $id_priority,
      'pay_status_fact_id' => $check_fact,
      'referencia' => $nueva_referencia,
      'created_at' => \Carbon\Carbon::now()
    ]);

    //  Comentarios
    DB::table('payments_comments')->insert([
      'name' => $observacion,
      'payment_id' => $id_payment
    ]);

    // //Factura PDF
    if($request->file('fileInput') != null )
    {
      $file_pdf = $request->file('fileInput');
      $file_extension = $file_pdf->getClientOriginalExtension(); //** get filename extension
      $fileName = $factura.'_'.date("Y-m-d H:i:s").'.'.$file_extension;
      $pdf= $request->file('fileInput')->storeAs('filestore/storage/factura/'.date('Y-m'), $fileName);
      DB::table('pay_facturas')->insert([
        'name' => $pdf,
        'payment_id' => $id_payment
      ]);
    }
    //Factura XML
    if($request->file('file_xml') != null )
    {
      $file_xml = $request->file('file_xml');
      $fileName = $file_xml->getClientOriginalName();
      $xml= $request->file('file_xml')->storeAs('filestore/storage/factura/'.date('Y-m'), $fileName);
      DB::table('pay_facturas')->insert([
        'name' => $xml,
        'payment_id' => $id_payment
      ]);
    }

    $id_venue = DB::table('payments_venues')->insertGetId([
      'cadena_id' => $cadena_id,
      'hotel_id' => $sitio_id,
      'payments_id' => $id_payment,
      'created_at' => \Carbon\Carbon::now()
    ]);

    //Montos
    DB::table('payments_montos')->insert(
        ['payments_venue_id' => $id_venue,
         'amount' => $monto,
         'IVA' => $tasa,
         'amount_iva' => $iva,
         'payments_id' => $id_payment,
         'created_at' => \Carbon\Carbon::now()]
    );

    //Estatus de la solicitud
    $user_actual = Auth::user()->id;
    $data_rest = DB::table('pay_status_users')->insertGetId([
                       'payment_id' => $id_payment,
                       'user_id' => $user_actual,
                       'status_id' => '1',
                       'created_at' => \Carbon\Carbon::now(),
                       'updated_at' => \Carbon\Carbon::now()
                    ]);
    $data_cc = DB::table('pay_mov_cc')->insertGetId([
                       'payments_id' => $id_payment,
                       'key_cc' => $real_cc,
                       'name_cc' => $name_cc,
                       'created_at' => \Carbon\Carbon::now(),
                       'updated_at' => \Carbon\Carbon::now()
                    ]);

    return json_encode($folio_new);
  }
  public function create_payment_from_excel(Request $request)
  {
    $id_priority = $request->priority_viat;
    $id_proyecto = $request->project;
    $id_sitio = $request->customer;
    $id_proveedor = $request->provider;
    $monto = $request->amount;
    $moneda = $request->coin;
    $observacion = $request->observaciones;
    $banco = $request->bank;
    $account = $request->account;
    $factura = $request->factura;
    // Archivo excel de multiples pagos a sitios
    $archivo = $request->file('file_excel');

     $folio_new = $this->createFolio();


    Excel::load($archivo, function($hoja) use($id_payment){
      $results = $hoja->get();

      $hoja1 = $results[0]->all();

      $rowNum1 = count($hoja1);

      $parametros2 = [];
      //---Obtencion de datos HOJA
      for ($i=0; $i < $rowNum1; $i++) {
        $grupo_id= trim($hoja1[$i]->grupo_id);
        $anexo_id = trim($hoja1[$i]->anexo_id);
        $amount = trim($hoja1[$i]->amount);
        $iva = trim($hoja1[$i]->iva);
        $amount_iva = trim($hoja1[$i]->amount_iva);
        $currency_id = trim($hoja1[$i]->currency_id);
        $concepto_pago = trim($hoja1[$i]->concept_pay);
        $way_pay_id = trim($hoja1[$i]->way_pay_id);
        $fecha_limite_pago = trim($hoja1[$i]->fecha_limite_pago);

        //Sitios
        $new_reg_pay_venue = new Payments_venues;
        $new_reg_pay_venue->cadena_id = (int)$grupo_id;
        $new_reg_pay_venue->hotel_id = (int)$anexo_id;
        $new_reg_pay_venue->payments_id = $id_payment;
        $new_reg_pay_venue->created_at = \Carbon\Carbon::now();
        $new_reg_pay_venue->save();

        //Montos
        DB::table('payments_montos')->insert(
            ['payments_venue_id' => $new_reg_pay_venue->id,
             'concept_pay' => $concepto_pago,
             'amount' => $amount,
             'IVA' => $iva,
             'amount_iva' => $amount_iva,
             'currency_id' => $currency_id,
             'payments_id' => $id_payment,
             'way_pay_id' => $way_pay_id,
             'created_at' => \Carbon\Carbon::now()]
        );

      } //for


     }); // Funcion excel

     /* Estatus de la solicitud */
    $user_actual = Auth::user()->id;
    $data_rest = DB::table('pay_status_users')->insertGetId([
                       'payment_id' => $new_reg_pay->id,
                       'user_id' => $user_actual,
                       'status_id' => '1',
                       'created_at' => \Carbon\Carbon::now(),
                       'updated_at' => \Carbon\Carbon::now()
                    ]);

    return json_encode($folio_new);
  }
  public function create(Request $request)
  {
    $id_priority = $request->priority_viat;
    $id_proyecto = $request->project;
    $id_sitio = $request->customer;
    $id_proveedor = $request->provider;
    $monto = $request->amount;
    $moneda = $request->coin;
    $concepto_pago = $request->description;
    $forma_pago = $request->methodPay;
    $id_application = $request->opt_application;
    $id_instalacion = $request->installation;
    $clasification = $request->classification_pay;
    $name_proyect = $request->projectName;
    $observacion = $request->observaciones;
    $banco = $request->bank;
    $account = $request->account;

    $email_actual = Auth::user()->email;
    $email_actual = trim($email_actual);
    $proyecto_n = DB::table('cadenas')->select('name')->where('id', $id_proyecto)->value('name');
    $sitio_n = DB::table('hotels')->select('Nombre_hotel')->where('id', $id_sitio)->value('Nombre_hotel');
    $proveedor_n = DB::table('customers')->select('name')->where('id', $id_proveedor)->value('name');
    $moneda_n = DB::table('currencies')->select('name')->where('id', $moneda)->value('name');
    $forma_pago_n = DB::table('payments_way_pays')->select('name')->where('id', $forma_pago)->value('name');
    $application_n = DB::table('payments_applications')->select('name')->where('id', $id_application)->value('name');
    $installation_n = DB::table('payments_project_options')->select('name')->where('id', $id_instalacion)->value('name');
    $classification_n = DB::table('payments_classifications')->select('name')->where('id', $clasification)->value('name');
    $banco_n = DB::table('bancos')->select('nombre')->where('id', $banco)->value('nombre');

    //Comprobar factura
    $factura = $request->factura;
    $exist_fact = DB::select('CALL px_payments_fact_exist(?)', array($factura));
    if($exist_fact[0]->resp == '1'){
      $folioxdX= 'La factura '.$factura.', ya se encuentra registrada';
      return back()->with('abort', $folioxdX);
    }
    else{
      $array_data1 = $request->areas;
      $array_data2 = $request->verticals;
      $array_data3 = $request->financings;
      $tamanodata1 = count($array_data1);
      $tamanodata2 = count($array_data2);
      $tamanodata3 = count($array_data3);

       $folio_new = $this->createFolio();

      $new_reg_pay = new Payments;
      $new_reg_pay->folio = $folio_new;
      $new_reg_pay->cadena_id = $id_proyecto;
      $new_reg_pay->hotel_id = $id_sitio;
      $new_reg_pay->proveedor_id = $id_proveedor;
      $new_reg_pay->amount = $monto;
      $new_reg_pay->currency_id = $moneda;
      $new_reg_pay->concept_pay = $concepto_pago;
      $new_reg_pay->way_pay_id = $forma_pago;
      $new_reg_pay->applications_id = $id_application;
      $new_reg_pay->options_id = $id_instalacion;
      $new_reg_pay->classification_id = $clasification;
      $new_reg_pay->name = $name_proyect;
      $new_reg_pay->payments_states_id = '1';
      $new_reg_pay->date_solicitude = date('Y-m-d');
      $new_reg_pay->factura =$factura;
      $new_reg_pay->prov_bco_ctas_id =$account;
      $new_reg_pay->priority_id =$id_priority;
      $new_reg_pay->save();

      $new_reg_pay_comment = new Payments_comment;
      $new_reg_pay_comment->name = $observacion;
      $new_reg_pay_comment->payment_id = $new_reg_pay->id;
      $new_reg_pay_comment->save();
      //Factura pdf
      if($request->file('fileInput') != null )
      {
        $pdf= $request->file('fileInput')->store('factura/'.date('Y-m'));
        $new_reg_pay_pdf_fact= new Pay_factura;
        $new_reg_pay_pdf_fact->payment_id = $new_reg_pay->id;
        $new_reg_pay_pdf_fact->name = $pdf;
        $new_reg_pay_pdf_fact->save();
      }
      if($request->file('fileInput2') != null )
      {
        $pdf= $request->file('fileInput2')->store('factura/'.date('Y-m'));
        $new_reg_pay_pdf_fact= new Pay_factura;
        $new_reg_pay_pdf_fact->payment_id = $new_reg_pay->id;
        $new_reg_pay_pdf_fact->name = $pdf;
        $new_reg_pay_pdf_fact->save();
      }
      if($request->file('fileInput3') != null )
      {
        $pdf= $request->file('fileInput3')->store('factura/'.date('Y-m'));
        $new_reg_pay_pdf_fact= new Pay_factura;
        $new_reg_pay_pdf_fact->payment_id = $new_reg_pay->id;
        $new_reg_pay_pdf_fact->name = $pdf;
        $new_reg_pay_pdf_fact->save();
      }

      $parametros2 = [];
      $data1 = [];
      $data2 = [];
      $data3 = [];

      for ($i=0; $i < $tamanodata1; $i++) {
        ${"rest_area".$i} = DB::table('pay_areas')->insertGetId([
                           'area_id' => $array_data1[$i],
                           'payment_id' => $new_reg_pay->id,
                           'created_at' => \Carbon\Carbon::now(),
                           'updated_at' => \Carbon\Carbon::now()
                        ]);
        $area_name = DB::table('payments_areas')->select('name')->where('id', $array_data1[$i])->value('name');
        array_push($data1, $area_name);
      }
      for ($j=0; $j < $tamanodata2; $j++) {
        ${"rest_verticals".$j} = DB::table('pay_projects')->insertGetId([
                           'verticals_id' => $array_data2[$j],
                           'payment_id' => $new_reg_pay->id,
                           'created_at' => \Carbon\Carbon::now(),
                           'updated_at' => \Carbon\Carbon::now()
                        ]);
        $project_name = DB::table('payments_verticals')->select('name')->where('id', $array_data2[$j])->value('name');
        array_push($data2, $project_name);
      }
      for ($k=0; $k < $tamanodata3; $k++) {
        ${"rest_financing".$k} = DB::table('pay_financings')->insertGetId([
                           'financings_id' => $array_data3[$k],
                           'payment_id' => $new_reg_pay->id,
                           'created_at' => \Carbon\Carbon::now(),
                           'updated_at' => \Carbon\Carbon::now()
                        ]);
        $finance_name = DB::table('payments_financings')->select('name')->where('id', $array_data3[$k])->value('name');
        array_push($data3, $finance_name);
      }
      $user_actual = Auth::user()->id;
      $data_rest = DB::table('pay_status_users')->insertGetId([
                         'payment_id' => $new_reg_pay->id,
                         'user_id' => $user_actual,
                         'status_id' => '1',
                         'created_at' => \Carbon\Carbon::now(),
                         'updated_at' => \Carbon\Carbon::now()
                      ]);
      $parametros1 = [
        'folio' => $folio_new,
        'proyecto' => $proyecto_n,
        'sitio' => $sitio_n,
        'proveedor' => $proveedor_n,
        'monto' => $monto,
        'moneda' => $moneda_n,
        'concepto' => $concepto_pago,
        'forma_pago' => $forma_pago_n,
        'aplicacion' => $application_n,
        'instalacion' => $installation_n,
        'clasificacion' => $classification_n,
        'proyecto_nombre' => $name_proyect,
        'observaciones' => $observacion,
        'banco' => $banco_n
      ];
      array_push($parametros2, $data1);
      array_push($parametros2, $data2);
      array_push($parametros2, $data3);

      //Mail::to($email_actual)->send(new SolicitudesP($parametros1, $parametros2));
      $folioxd = 'Operation complete! - Folio: '. $folio_new;


       return back()->with('status', $folioxd);
    //
    }
  }
  public function create2(Request $request)
  {
    $id_priority = $request->priority_viat;
    $id_proyecto = $request->project;
    $id_sitio = $request->customer;
    $id_proveedor = $request->provider;
    $monto = $request->amount;
    $moneda = $request->coin;
    $factura = $request->factura;
    $concepto_pago = $request->description;
    $forma_pago = $request->methodPay;
    $id_application = $request->opt_application;
    $id_instalacion = $request->installation;
    $clasification = $request->classification_pay;
    $name_proyect = $request->projectName;
    $observacion = $request->observaciones;
    $banco = $request->bank;
    $account = $request->account;

    $email_actual = Auth::user()->email;
    $email_actual = trim($email_actual);
    $proyecto_n = DB::table('cadenas')->select('name')->where('id', $id_proyecto)->value('name');
    $sitio_n = DB::table('hotels')->select('Nombre_hotel')->where('id', $id_sitio)->value('Nombre_hotel');
    $proveedor_n = DB::table('customers')->select('name')->where('id', $id_proveedor)->value('name');
    $moneda_n = DB::table('currencies')->select('name')->where('id', $moneda)->value('name');
    $forma_pago_n = DB::table('payments_way_pays')->select('name')->where('id', $forma_pago)->value('name');
    $application_n = DB::table('payments_applications')->select('name')->where('id', $id_application)->value('name');
    $installation_n = DB::table('payments_project_options')->select('name')->where('id', $id_instalacion)->value('name');
    $classification_n = DB::table('payments_classifications')->select('name')->where('id', $clasification)->value('name');
    $banco_n = DB::table('bancos')->select('nombre')->where('id', $banco)->value('nombre');


    $array_data1 = $request->areas;
    $array_data2 = $request->verticals;
    $array_data3 = $request->financings;
    $tamanodata1 = count($array_data1);
    $tamanodata2 = count($array_data2);
    $tamanodata3 = count($array_data3);

    $folio_new = $this->createFolio();

    $new_reg_pay = new Payments;
    $new_reg_pay->folio = $folio_new;
    $new_reg_pay->cadena_id = $id_proyecto;
    $new_reg_pay->hotel_id = $id_sitio;
    $new_reg_pay->proveedor_id = $id_proveedor;
    $new_reg_pay->amount = $monto;
    $new_reg_pay->currency_id = $moneda;
    $new_reg_pay->concept_pay = $concepto_pago;
    $new_reg_pay->way_pay_id = $forma_pago;
    $new_reg_pay->applications_id = $id_application;
    $new_reg_pay->options_id = $id_instalacion;
    $new_reg_pay->classification_id = $clasification;
    $new_reg_pay->name = $name_proyect;
    $new_reg_pay->payments_states_id = '1';
    $new_reg_pay->date_solicitude = date('Y-m-d');
    $new_reg_pay->factura =$factura;
    $new_reg_pay->prov_bco_ctas_id =$account;
    $new_reg_pay->priority_id =$id_priority;
    $new_reg_pay->save();

    $new_reg_pay_comment = new Payments_comment;
    $new_reg_pay_comment->name = $observacion;
    $new_reg_pay_comment->payment_id = $new_reg_pay->id;
    $new_reg_pay_comment->save();

    $parametros2 = [];
    $data1 = [];
    $data2 = [];
    $data3 = [];
    // array_push($parametros2, $array_data1);
    // array_push($parametros2, $array_data2);
    // array_push($parametros2, $array_data3);


    for ($i=0; $i < $tamanodata1; $i++) {
      ${"rest_area".$i} = DB::table('pay_areas')->insertGetId([
                         'area_id' => $array_data1[$i],
                         'payment_id' => $new_reg_pay->id,
                         'created_at' => \Carbon\Carbon::now(),
                         'updated_at' => \Carbon\Carbon::now()
                      ]);
      $area_name = DB::table('payments_areas')->select('name')->where('id', $array_data1[$i])->value('name');
      array_push($data1, $area_name);
    }
    for ($j=0; $j < $tamanodata2; $j++) {
      ${"rest_verticals".$j} = DB::table('pay_projects')->insertGetId([
                         'verticals_id' => $array_data2[$j],
                         'payment_id' => $new_reg_pay->id,
                         'created_at' => \Carbon\Carbon::now(),
                         'updated_at' => \Carbon\Carbon::now()
                      ]);
      $project_name = DB::table('payments_verticals')->select('name')->where('id', $array_data2[$j])->value('name');
      array_push($data2, $project_name);
    }
    for ($k=0; $k < $tamanodata3; $k++) {
      ${"rest_financing".$k} = DB::table('pay_financings')->insertGetId([
                         'financings_id' => $array_data3[$k],
                         'payment_id' => $new_reg_pay->id,
                         'created_at' => \Carbon\Carbon::now(),
                         'updated_at' => \Carbon\Carbon::now()
                      ]);
      $finance_name = DB::table('payments_financings')->select('name')->where('id', $array_data3[$k])->value('name');
      array_push($data3, $finance_name);
    }
    $user_actual = Auth::user()->id;
    $data_rest = DB::table('pay_status_users')->insertGetId([
                       'payment_id' => $new_reg_pay->id,
                       'user_id' => $user_actual,
                       'status_id' => '1',
                       'created_at' => \Carbon\Carbon::now(),
                       'updated_at' => \Carbon\Carbon::now()
                    ]);
    $parametros1 = [
      'folio' => $folio_new,
      'proyecto' => $proyecto_n,
      'sitio' => $sitio_n,
      'proveedor' => $proveedor_n,
      'monto' => $monto,
      'moneda' => $moneda_n,
      'concepto' => $concepto_pago,
      'forma_pago' => $forma_pago_n,
      'aplicacion' => $application_n,
      'instalacion' => $installation_n,
      'clasificacion' => $classification_n,
      'proyecto_nombre' => $name_proyect,
      'observaciones' => $observacion,
      'banco' => $banco_n
    ];
    array_push($parametros2, $data1);
    array_push($parametros2, $data2);
    array_push($parametros2, $data3);

    //Mail::to($email_actual)->send(new SolicitudesP($parametros1, $parametros2));
    $folioxd = 'Operation complete! - Folio: '. $folio_new;
    return back()->with('status', $folioxd);
  }
  public function createFolio()
  {
    $nomenclatura = "SP-";
    $current_date = date('Y-m-d');
    date_default_timezone_set('America/Cancun');
    setlocale(LC_TIME, 'es_ES', 'esp_esp');
    $complemento= strtoupper(strftime("%b%y", strtotime($current_date)));

    $res = DB::table('payments')->latest()->first();
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
  public function test()
  {
    $algo = $this->createFolio();
    dd($algo);
  }
  /* PAGOS MULTIPLES */
  public function create_multi(Request $request){
    $id_priority = $request->priority_viat;
    $id_proveedor = $request->provider;
    $monto = $request->amount;
    $moneda = $request->coin;

    /*Datos factura*/
    $concepto_pago = $request->description;
    $forma_pago = $request->methodPay;

    /*Datos bancarios del beneficiario*/
    $banco = $request->bank;
    $account = $request->account;

    /*Datos del proyecto*/
    $id_application = $request->opt_application;
    $name_proyect = $request->projectName;
    $id_instalacion = $request->installation;

    $clasification = $request->classification_pay;
    $observacion = $request->observaciones;

    $email_actual = Auth::user()->email;
    $email_actual = trim($email_actual);

    //Comprobar factura
    $factura = $request->factura;
    $exist_fact = DB::select('CALL px_payments_fact_exist(?)', array($factura));
    if($exist_fact[0]->resp == '1'){
      $folioxdX= 'La factura '.$factura.', ya se encuentra registrada';

      return json_encode('1');
    }
    else{
      $folio_new = $this->createFolio();

      $new_reg_pay = new Payments;
      $new_reg_pay->folio = $folio_new;
      $new_reg_pay->applications_id = $id_application;
      $new_reg_pay->options_id = $id_instalacion;
      $new_reg_pay->classification_id = $clasification;
      $new_reg_pay->proveedor_id = $id_proveedor;
      $new_reg_pay->name = $name_proyect;
      $new_reg_pay->payments_states_id = '1';
      $new_reg_pay->date_solicitude = date('Y-m-d');
      $new_reg_pay->prov_bco_ctas_id =$account;
      $new_reg_pay->priority_id =$id_priority;
      $new_reg_pay->save();

      //Registro de comentarios
      $new_reg_pay_comment = new Payments_comment;
      $new_reg_pay_comment->name = $observacion;
      $new_reg_pay_comment->payment_id = $new_reg_pay->id;
      $new_reg_pay_comment->save();

      //Registro de areas
      $array_data1 = $request->areas;
      $tamanodata1 = count($array_data1);
      //CICLO PARA AREAS
      for ($i=0; $i < $tamanodata1; $i++) {
        ${"rest_area".$i} = DB::table('pay_areas')->insertGetId([
          'area_id' => $array_data1[$i],
          'payment_id' => $new_reg_pay->id,
          'created_at' => \Carbon\Carbon::now(),
          'updated_at' => \Carbon\Carbon::now()
        ]);
        $area_name = DB::table('payments_areas')->select('name')->where('id', $array_data1[$i])->value('name');
      }

      //Registro de verticales
      $array_data2 = $request->verticals;
      $tamanodata2 = count($array_data2);
      //CICLO PARA VERTICALES
      for ($j=0; $j < $tamanodata2; $j++) {
        ${"rest_verticals".$j} = DB::table('pay_projects')->insertGetId([
          'verticals_id' => $array_data2[$j],
          'payment_id' => $new_reg_pay->id,
          'created_at' => \Carbon\Carbon::now(),
          'updated_at' => \Carbon\Carbon::now()
        ]);
        $project_name = DB::table('payments_verticals')->select('name')->where('id', $array_data2[$j])->value('name');
      }

      //Subir archivo
      $file = $request->file('fileInput');
      $file_extension = $file->getClientOriginalExtension(); //** get filename extension
      $fileName = $factura.'_'.date("Y-m-d H:i:s").'.'.$file_extension;
      $pdf= $request->file('fileInput')->storeAs('factura/'.date('Y-m'), $fileName);

      $new_reg_pay_pdf_fact= new Pay_factura;
      $new_reg_pay_pdf_fact->payment_id = $new_reg_pay->id;
      $new_reg_pay_pdf_fact->name = $pdf;
      $new_reg_pay_pdf_fact->factura =$factura;
      $new_reg_pay_pdf_fact->concept_pay = $concepto_pago;
      $new_reg_pay_pdf_fact->amount = $monto;
      $new_reg_pay_pdf_fact->currency_id = $moneda;
      $new_reg_pay_pdf_fact->way_pay_id = $forma_pago;
      $new_reg_pay_pdf_fact->save();

      //Registro de input dinamicos
      $array_data_dinamic_1 = $request->c_venue;
      $array_data_dinamic_2 = $request->c_hotel;
      $array_data_dinamic_3 = $request->c_price;

       $num_max_posiciones = $request->contador_max;
       $posiciones_omitidas = $request->contadores_elim;

       if (isset($posiciones_omitidas)) {
         $array_omitidos = explode(",", $posiciones_omitidas);
         $tamanoArrayOmitido = count($array_omitidos);

         for ($k=0; $k <= $num_max_posiciones; $k++) {
           if (in_array($k, $array_omitidos)) { /*Busco dentro del array si existe el identificador*/
             /**NO HACER NADA, SI EXISTE EN EL ARRAY OMITIDOS*/
           }
           else{
             ${"nsitios".$k} = new Payments_venue;
             ${"nsitios".$k} ->cadena_id = $array_data_dinamic_1[$k]; //valor 1 venue
             ${"nsitios".$k} ->hotel_id = $array_data_dinamic_2[$k]; //valor 1 hotel
             ${"nsitios".$k} ->quantity = $array_data_dinamic_3[$k]; //valor 1 monto
             ${"nsitios".$k} ->currency_id = $moneda;
             ${"nsitios".$k} ->payments_id = $new_reg_pay->id;
             ${"nsitios".$k}->save();
           }
         }
       }
       else{
          $posiciones_omitidas = array();
          for ($z=0; $z <= $num_max_posiciones; $z++) {
            ${"nsitios".$z} = new Payments_venue;
            ${"nsitios".$z} ->cadena_id = $array_data_dinamic_1[$z]; //valor 1 venue
            ${"nsitios".$z} ->hotel_id = $array_data_dinamic_2[$z]; //valor 1 hotel
            ${"nsitios".$z} ->quantity = $array_data_dinamic_3[$z]; //valor 1 monto
            ${"nsitios".$z} ->currency_id = $moneda;
            ${"nsitios".$z} ->payments_id = $new_reg_pay->id;
            ${"nsitios".$z}->save();
          }
       }
       /* Estatus de la solicitud */
       $user_actual = Auth::user()->id;
       $data_rest = DB::table('pay_status_users')->insertGetId([
                          'payment_id' => $new_reg_pay->id,
                          'user_id' => $user_actual,
                          'status_id' => '1',
                          'created_at' => \Carbon\Carbon::now(),
                          'updated_at' => \Carbon\Carbon::now()
                       ]);
      //CICLO PARA CAMPOS DINAMICOS
      return json_encode($folio_new);
    }
  }
  /* PAGOS CON MULTIPLES FACTURAS*/
  public function create_multi_fact(Request $request){
    $id_proyecto = $request->project;
    $id_sitio = $request->customer;
    /*Datos del proyecto*/
    $id_application = $request->opt_application;
    $id_instalacion = $request->installation;
    $clasification = $request->classification_pay;
    $id_proveedor = $request->provider;
    $name_proyect = $request->projectName;
    /*Datos bancarios del beneficiario*/
    $account = $request->account;
    /*Prioridad*/
    $id_priority = $request->priority_viat;
    $observacion = $request->observaciones;
    /*Datos usuario*/
    $email_actual = Auth::user()->email;
    $email_actual = trim($email_actual);
    /*
    * Pagos a multiples facturas
    * Registro de input dinamicos
    */
    $array_data_dinamic_1 = $request->c_factura;
    $array_data_dinamic_2 = $request->c_description;
    $array_data_dinamic_3 = $request->c_methodPay;
    $array_data_dinamic_4 = $request->c_price;
    $array_data_dinamic_5 = $request->c_coin;
    $array_data_dinamic_6 = $request->c_fileInput;

    $num_max_posiciones = $request->contador_max;
    $posiciones_omitidas = $request->contadores_elim;
    $facturas_existentes = array();
    $retorno_array= array();

    if (isset($posiciones_omitidas)) {
       $array_omitidos = explode(",", $posiciones_omitidas);
       for ($k=0; $k <= $num_max_posiciones; $k++) {
         if (in_array($k, $array_omitidos)) { /*Busco dentro del array si existe el identificador*/
           /**NO HACER NADA, SI EXISTE EN EL ARRAY OMITIDOS*/
         }
         else{
          /*.Preguntaremos si alguna factura existe.*/
          $exist_fact = DB::select('CALL px_payments_fact_exist(?)', array($array_data_dinamic_1[$k]));
          if($exist_fact[0]->resp == '1'){
            array_push($facturas_existentes, $array_data_dinamic_1[$k]);
          }
          /*........................................*/
         }
       }
       /*
          Vamos a retornar las facturas existentes,
          En caso si encontramos. Si no registramos todo
       */
        if(empty($facturas_existentes)) {
          //Está vació -- Nuevo ciclo
          $folio_new = $this->createFolio();

          $new_reg_pay = new Payments;
          $new_reg_pay->folio = $folio_new;
          $new_reg_pay->applications_id = $id_application;
          $new_reg_pay->options_id = $id_instalacion;
          $new_reg_pay->classification_id = $clasification;
          $new_reg_pay->proveedor_id = $id_proveedor;
          $new_reg_pay->name = $name_proyect;
          $new_reg_pay->payments_states_id = '1';
          $new_reg_pay->date_solicitude = date('Y-m-d');
          $new_reg_pay->prov_bco_ctas_id =$account;
          $new_reg_pay->priority_id =$id_priority;
          $new_reg_pay->save();

          //Registro de comentarios
          $new_reg_pay_comment = new Payments_comment;
          $new_reg_pay_comment->name = $observacion;
          $new_reg_pay_comment->payment_id = $new_reg_pay->id;
          $new_reg_pay_comment->save();

          //Registro de areas
          $array_data1 = $request->areas;
          $tamanodata1 = count($array_data1);
          //CICLO PARA AREAS
          for ($i=0; $i < $tamanodata1; $i++) {
            ${"rest_area".$i} = DB::table('pay_areas')->insertGetId([
                               'area_id' => $array_data1[$i],
                               'payment_id' => $new_reg_pay->id,
                               'created_at' => \Carbon\Carbon::now(),
                               'updated_at' => \Carbon\Carbon::now()
                            ]);
            $area_name = DB::table('payments_areas')->select('name')->where('id', $array_data1[$i])->value('name');
          }
          //Registro de verticales
          $array_data2 = $request->verticals;
          $tamanodata2 = count($array_data2);
          //CICLO PARA VERTICALES
          for ($j=0; $j < $tamanodata2; $j++) {
            ${"rest_verticals".$j} = DB::table('pay_projects')->insertGetId([
                               'verticals_id' => $array_data2[$j],
                               'payment_id' => $new_reg_pay->id,
                               'created_at' => \Carbon\Carbon::now(),
                               'updated_at' => \Carbon\Carbon::now()
                            ]);
            $project_name = DB::table('payments_verticals')->select('name')->where('id', $array_data2[$j])->value('name');
          }
          //CICLO DE CAPTURA POSICIONES CON POSICIONES OMITIDAS
          for ($m=0; $m <= $num_max_posiciones; $m++) {
            if (!(in_array($m, $array_omitidos))) {
              ${"new_venue".$m} = new Payments_venue;
              ${"new_venue".$m} ->cadena_id = $id_proyecto; //valor 1 venue
              ${"new_venue".$m} ->hotel_id = $id_sitio; //valor 1 hotel
              ${"new_venue".$m} ->quantity = $array_data_dinamic_4[$m]; //valor 1 monto
              ${"new_venue".$m} ->currency_id = $array_data_dinamic_5[$m]; //valor 1 moneda
              ${"new_venue".$m} ->payments_id = $new_reg_pay->id;
              ${"new_venue".$m} ->save();

              ${"file".$m}= $request->file('c_fileInput.'.$m);
              ${"file_extension".$m}= ${"file".$m}->getClientOriginalExtension(); //** get filename extension
              ${"fileName".$m}= $array_data_dinamic_1[$m].'_'.date("Y-m-d H:i:s").'.'.${"file_extension".$m};
              ${"new_pdf".$m}= $request->file('c_fileInput.'.$m)->storeAs( 'factura/'.date('Y-m'), ${"fileName".$m} );

              ${"new_fact".$m} = new Pay_factura;
              ${"new_fact".$m} ->payment_id = $new_reg_pay->id;
              ${"new_fact".$m} ->name = ${"new_pdf".$m};
              ${"new_fact".$m} ->factura = $array_data_dinamic_1[$m];
              ${"new_fact".$m} ->concept_pay = $array_data_dinamic_2[$m];
              ${"new_fact".$m} ->amount = $array_data_dinamic_4[$m];
              ${"new_fact".$m} ->currency_id = $array_data_dinamic_5[$m];
              ${"new_fact".$m} ->way_pay_id = $array_data_dinamic_3[$m];
              ${"new_fact".$m} ->save();
            }
          }
          /* Estatus de la solicitud */
          $user_actual = Auth::user()->id;
          $data_rest = DB::table('pay_status_users')->insertGetId([
                             'payment_id' => $new_reg_pay->id,
                             'user_id' => $user_actual,
                             'status_id' => '1',
                             'created_at' => \Carbon\Carbon::now(),
                             'updated_at' => \Carbon\Carbon::now()
                          ]);

          array_push($retorno_array, ['dato1'=>'ok', 'dato2'=>$folio_new]);
          return json_encode($retorno_array);
        }
        else {
         //Retorno facturas sin registrar.
         $cadena_fact_con_comas = implode(", ", $facturas_existentes);
         array_push($retorno_array, ['dato1'=>'false', 'dato2'=>$cadena_fact_con_comas]);
         return json_encode($retorno_array);
        }
    }

    else {
        $posiciones_omitidas = array();
        for ($y=0; $y <= $num_max_posiciones; $y++) {
          /*.Preguntaremos si alguna factura existe.*/
          $exist_fact = DB::select('CALL px_payments_fact_exist(?)', array($array_data_dinamic_1[$y]));
          if($exist_fact[0]->resp == '1'){
            array_push($facturas_existentes, $array_data_dinamic_1[$y]);
          }
        }
        /*
           Vamos a retornar las facturas existentes,
           En caso si encontramos. Si no registramos todo
        */
        if(empty($facturas_existentes)) {
          //Está vació -- Nuevo ciclo
          $folio_new = $this->createFolio();

          $new_reg_pay = new Payments;
          $new_reg_pay->folio = $folio_new;
          $new_reg_pay->applications_id = $id_application;
          $new_reg_pay->options_id = $id_instalacion;
          $new_reg_pay->classification_id = $clasification;
          $new_reg_pay->proveedor_id = $id_proveedor;
          $new_reg_pay->name = $name_proyect;
          $new_reg_pay->payments_states_id = '1';
          $new_reg_pay->date_solicitude = date('Y-m-d');
          $new_reg_pay->prov_bco_ctas_id =$account;
          $new_reg_pay->priority_id =$id_priority;
          $new_reg_pay->save();

          //Registro de comenta------------------------------------------------------------------------------------------------------------------rios
          $new_reg_pay_comment = new Payments_comment;
          $new_reg_pay_comment->name = $observacion;
          $new_reg_pay_comment->payment_id = $new_reg_pay->id;
          $new_reg_pay_comment->save();

          //Registro de areas
          $array_data1 = $request->areas;
          $tamanodata1 = count($array_data1);
          //CICLO PARA AREAS
          for ($i=0; $i < $tamanodata1; $i++) {
            ${"rest_area".$i} = DB::table('pay_areas')->insertGetId([
                               'area_id' => $array_data1[$i],
                               'payment_id' => $new_reg_pay->id,
                               'created_at' => \Carbon\Carbon::now(),
                               'updated_at' => \Carbon\Carbon::now()
                            ]);
            $area_name = DB::table('payments_areas')->select('name')->where('id', $array_data1[$i])->value('name');
          }
          //Registro de verticales
          $array_data2 = $request->verticals;
          $tamanodata2 = count($array_data2);
          //CICLO PARA VERTICALES
          for ($j=0; $j < $tamanodata2; $j++) {
            ${"rest_verticals".$j} = DB::table('pay_projects')->insertGetId([
                               'verticals_id' => $array_data2[$j],
                               'payment_id' => $new_reg_pay->id,
                               'created_at' => \Carbon\Carbon::now(),
                               'updated_at' => \Carbon\Carbon::now()
                            ]);
            $project_name = DB::table('payments_verticals')->select('name')->where('id', $array_data2[$j])->value('name');
          }

          for ($m=0; $m <= $num_max_posiciones; $m++) {
            ${"new_venue".$m} = new Payments_venue;
            ${"new_venue".$m} ->cadena_id = $id_proyecto; //valor 1 venue
            ${"new_venue".$m} ->hotel_id = $id_sitio; //valor 1 hotel
            ${"new_venue".$m} ->quantity = $array_data_dinamic_4[$m]; //valor 1 monto
            ${"new_venue".$m} ->currency_id = $array_data_dinamic_5[$m]; //valor 1 moneda
            ${"new_venue".$m} ->payments_id = $new_reg_pay->id;
            ${"new_venue".$m} ->save();

            ${"file".$m}= $request->file('c_fileInput.'.$m);
            ${"file_extension".$m}= ${"file".$m}->getClientOriginalExtension(); //** get filename extension
            ${"fileName".$m}= $array_data_dinamic_1[$m].'_'.date("Y-m-d H:i:s").'.'.${"file_extension".$m};
            ${"new_pdf".$m}= $request->file('c_fileInput.'.$m)->storeAs( 'factura/'.date('Y-m'), ${"fileName".$m} );

            ${"new_fact".$m} = new Pay_factura;
            ${"new_fact".$m} ->payment_id = $new_reg_pay->id;
            ${"new_fact".$m} ->name = ${"new_pdf".$m};
            ${"new_fact".$m} ->factura = $array_data_dinamic_1[$m];
            ${"new_fact".$m} ->concept_pay = $array_data_dinamic_2[$m];
            ${"new_fact".$m} ->amount = $array_data_dinamic_4[$m];
            ${"new_fact".$m} ->currency_id = $array_data_dinamic_5[$m];
            ${"new_fact".$m} ->way_pay_id = $array_data_dinamic_3[$m];
            ${"new_fact".$m} ->save();
          }

          /* Estatus de la solicitud */
          $user_actual = Auth::user()->id;
          $data_rest = DB::table('pay_status_users')->insertGetId([
                             'payment_id' => $new_reg_pay->id,
                             'user_id' => $user_actual,
                             'status_id' => '1',
                             'created_at' => \Carbon\Carbon::now(),
                             'updated_at' => \Carbon\Carbon::now()
                          ]);
          array_push($retorno_array, ['dato1'=>'ok', 'dato2'=>$folio_new]);
          return json_encode($retorno_array);
         }
         else {
          //Retorno facturas sin registrar.
          $cadena_fact_con_comas = implode(", ", $facturas_existentes);
          array_push($retorno_array, ['dato1'=>'false', 'dato2'=>$cadena_fact_con_comas]);
          return json_encode($retorno_array);
         }
    }
  }
}
