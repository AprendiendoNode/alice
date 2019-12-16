<?php

namespace App\Http\Controllers\Sales;
use Auth;
use DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gerardojbaez\Money\Money;
use App\Exports\CustomerInvoicesExport;
// use App\Helpers\BaseHelper;
use App\Helpers\Cfdi33Helper;
use App\Helpers\Helper;
use App\Helpers\PacHelper;
// use App\Mail\SendCustomerInvoice;
use App\Models\Base\BranchOffice;
use App\Models\Base\Company;
use App\Models\Base\Pac;
use App\Models\Catalogs\CfdiRelation;
use App\Models\Catalogs\CfdiUse;
use App\Models\Catalogs\Currency;
use App\Models\Catalogs\PaymentMethod;
use App\Models\Catalogs\PaymentTerm;
use App\Models\Catalogs\PaymentWay;
use App\Models\Catalogs\Product;
use App\Models\Catalogs\SatProduct;
use App\Models\Catalogs\Tax;
use App\Models\Catalogs\UnitMeasure;
use App\Models\Sales\Customer;
use App\Models\Sales\CustomerInvoice;
use App\Models\Sales\CustomerInvoiceCfdi;
use App\Models\Sales\CustomerInvoiceLine;
use App\Models\Sales\CustomerInvoiceRelation;
use App\Models\Sales\CustomerInvoiceTax;
use App\Models\Sales\CustomerPayment;
use App\Models\Sales\Salesperson;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Base\Setting;
use anlutro\LaravelSettings\SettingStore;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Schema;

use \CfdiUtils\XmlResolver\XmlResolver;
use \CfdiUtils\CadenaOrigen\DOMBuilder;
use App\ConvertNumberToLetters;

class CustomerInvoiceController extends Controller
{
    private $list_status = [];
    private $document_type_code = 'customer.invoice';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->list_status = [
            CustomerInvoice::OPEN => __('customer_invoice.text_status_open'),
            CustomerInvoice::PAID => __('customer_invoice.text_status_paid'),
            CustomerInvoice::CANCEL => __('customer_invoice.text_status_cancel'),
            CustomerInvoice::CANCEL_PER_AUTHORIZED => __('customer_invoice.text_status_cancel_per_authorized'),
        ];
    }

    public function generate_invoice($id)
    {

      $customer_invoice = CustomerInvoice::findOrFail($id);
      $companies = DB::select('CALL px_companies_data ()', array());
      //Si tiene CFDI obtiene la informacion de los nodos
      if(!empty($customer_invoice->customerInvoiceCfdi->file_xml_pac) && !empty($customer_invoice->customerInvoiceCfdi->uuid)){
        $path_xml = Helper::setDirectory(CustomerInvoice::PATH_XML_FILES_CI) . '/';
          $file_xml_pac = $path_xml . $customer_invoice->customerInvoiceCfdi->file_xml_pac;

          //Valida que el archivo exista
          if(\Storage::exists($file_xml_pac)) {
              $cfdi = \CfdiUtils\Cfdi::newFromString(\Storage::get($file_xml_pac));
              $data = Cfdi33Helper::getQuickArrayCfdi($cfdi);

              //Genera codigo QR
              $image = QrCode::format('png')->size(150)->margin(0)->generate($data['qr_cadena']);
              $data['qr'] = 'data:image/png;base64,' . base64_encode($image);
          }
      }
      $format = new ConvertNumberToLetters();
      $ammount_letter = $format->convertir($customer_invoice->amount_total);

      // Enviando datos a la vista de la factura
      $pdf = PDF::loadView('permitted.invoicing.invoice_sitwifi',compact('companies', 'customer_invoice', 'data', 'ammount_letter'));
      return $pdf->stream();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $customer = DB::select('CALL GetCustomersActivev2 ()', array());
      $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
      $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
      $salespersons = DB::select('CALL GetAllSalespersonv2 ()', array());
      $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
      $payment_term = DB::select('CALL GetAllPaymentTermsv2 ()', array());
      $payment_methods = DB::select('CALL GetAllPaymentMethodsv2 ()', array());
      $cfdi_uses = DB::select('CALL GetAllCfdiUsev2 ()', array());
      $cfdi_relations = DB::select('CALL GetAllCfdiRelationsv2 ()', array());


      $product =  DB::select('CALL GetAllProductActivev2 ()', array());
      $unitmeasures = DB::select('CALL GetUnitMeasuresActivev2 ()', array());
      $satproduct = DB::select('CALL GetSatProductActivev2 ()', array());
      $impuestos =  DB::select('CALL GetAllTaxesActivev2 ()', array());

      $cxclassifications = DB::table('cxclassifications')->select('id', 'name')->get();

      return view('permitted.sales.customer_invoices',compact(
        'customer','sucursal','currency',
        'salespersons','payment_way','payment_term',
        'payment_methods', 'cfdi_uses', 'cfdi_relations',
        'product', 'unitmeasures', 'satproduct', 'impuestos', 'cxclassifications'
      ));
    }
    public function view_contracts()
    {
        $customer = DB::select('CALL GetCustomersActivev2 ()', array());
        $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
        $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
        $salespersons = DB::select('CALL GetAllSalespersonv2 ()', array());
        $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
        $payment_term = DB::select('CALL GetAllPaymentTermsv2 ()', array());
        $payment_methods = DB::select('CALL GetAllPaymentMethodsv2 ()', array());
        $cfdi_uses = DB::select('CALL GetAllCfdiUsev2 ()', array());
        $cfdi_relations = DB::select('CALL GetAllCfdiRelationsv2 ()', array());

        return view('permitted.sales.customer_cont_test2', compact(
          'customer','sucursal','currency',
          'salespersons','payment_way','payment_term',
          'payment_methods', 'cfdi_uses', 'cfdi_relations'
        ));
    }
    public function view_contracts2()
    {
        $customer = DB::select('CALL GetCustomersActivev2 ()', array());
        $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
        $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
        $salespersons = DB::select('CALL GetAllSalespersonv2 ()', array());
        $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
        $payment_term = DB::select('CALL GetAllPaymentTermsv2 ()', array());
        $payment_methods = DB::select('CALL GetAllPaymentMethodsv2 ()', array());
        $cfdi_uses = DB::select('CALL GetAllCfdiUsev2 ()', array());
        $cfdi_relations = DB::select('CALL GetAllCfdiRelationsv2 ()', array());

        return view('permitted.sales.customer_cont_test', compact(
          'customer','sucursal','currency',
          'salespersons','payment_way','payment_term',
          'payment_methods', 'cfdi_uses', 'cfdi_relations'
        ));
    }
    public function search_view_contracts(Request $request)
    {
        $moneda = $request->currency_id;
        $result = DB::select('CALL px_contract_annexes_quantity (?)', array($moneda));
        return json_encode($result);
    }
    public function view_contracts_info(Request $request)
    {
      $identificador = $request->id;
      $result = DB::select('CALL px_contract_annexes_xmaster (?)', array($identificador));
      return json_encode($result);
    }


    public function getProduct(Request $request)
    {
        //Variables
        $id = $request->id;
        //Logica
        if ($request->ajax() && !empty($id)) {
          $resultados = DB::select('CALL GetInfoProductById (?)', array($id));
          return response()->json($resultados, 200);
        }
        return response()->json(['error' => __('general.error500')], 422);
    }
    /**
   * Calcula el total de las lineas
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
   public function totalLines(Request $request)
   {
       //Variables
       $json = new \stdClass;
       $input_items = $request->item;
       $currency_id = $request->currency_id; //Guardo la moneda seleccionada
       $currency_value = $request->currency_value;
       $resp_currency_value = $request->currency_value;
       // $texto = "";
       if (empty($currency_id)) {
         $currency_id = 1;
       }
       if ($currency_id === 1) {
         $currency_value = 1;
       }
       if (empty($currency_value)) {
         $current_select_rate = DB::table('currencies')->select('rate')->where('id', $currency_id)->first();
         $currency_value = $current_rate->rate;
       }

       $currency_code = 'MXN'; //En caso que no haya moneda le digo por defecto es pesos mexicanos

       if ($request->ajax()) {
           //Variables de totales
           $amount_subtotal = 0;
           $amount_discount = 0;
           $amount_untaxed = 0;
           $amount_tax = 0;
           $amount_tax_ret = 0;
           $amount_total = 0;
           $balance = 0;
           $items = [];
           $items_tc = [];
           if (!empty($input_items)) {
             foreach ($input_items as $key => $item) {
               //Logica
               $item_quantity = (double)$item['quantity'];
               $item_price_unit = (double)$item['price_unit'];
               $item_discount = (double)$item['discount'];

               $item_subtotal_quantity = round($item_price_unit * $item_quantity, 2);

               $item_price_reduce = ($item_price_unit * (100 - $item_discount) / 100); //precio del artículo reducido
               $item_amount_untaxed = round($item_quantity * $item_price_reduce, 2); //cantidad del artículo sin impuestos
               $item_amount_discount = round($item_quantity * $item_price_unit, 2) - $item_amount_untaxed; //descuento del importe del artículo
               $item_amount_tax = 0; //cantidad de impuestos
               $item_amount_tax_ret = 0; //importe del artículo reducción de impuestos


               if (!empty($item['taxes'])) {
                   foreach ($item['taxes'] as $tax_id) {
                       if (!empty($tax_id)) {
                           $tax = Tax::findOrFail($tax_id);
                           $tmp = 0;
                           if ($tax->factor == 'Tasa') {
                               $tmp = $item_amount_untaxed * $tax->rate / 100;
                           } elseif ($tax->factor == 'Cuota') {
                               $tmp = $tax->rate;
                           }
                           $tmp = round($tmp, 2);
                           if ($tmp < 0) { //Retenciones
                               $item_amount_tax_ret += $tmp;
                           } else { //Traslados
                               $item_amount_tax += $tmp;
                           }
                       }
                   }
               }

               $item_amount_total = $item_amount_untaxed + $item_amount_tax + $item_amount_tax_ret;
               $item_subtotal_clean = $item_subtotal_quantity;
               $item_discount_clean = $item_amount_discount;
               $item_subtotal = $item_amount_untaxed ;
               //Tipo cambio
               if ($item['current'] === $currency_id) {
                   // $item_amount_total = $item_amount_total * $currency_value;
                   $items_tc [$key] =$resp_currency_value;//ALMACENO TIPO CAMBIO
               }
               elseif ( $item['current'] != $currency_id) {
                 if ( $item['current'] === '2') { //ES DOLAR
                   $current_select_rate = DB::table('exchange_rates')->select('current_rate')->latest()->first();
                   $currency_value = $current_select_rate->current_rate;
                   $currency_code = DB::table('currencies')->select('code_banxico')->where('id', $currency_id)->value('code_banxico');
                   $item_amount_tax = $item_amount_tax * $currency_value;
                   $item_amount_tax_ret = $item_amount_tax_ret * $currency_value;
                   $item_amount_total = $item_amount_total * $currency_value;
                   $item_subtotal = $item_subtotal * $currency_value;

                   $item_subtotal_clean = $item_subtotal_clean * $currency_value;
                   $item_discount_clean = $item_discount_clean * $currency_value;

                   $items_tc [$key] =$currency_value;//ALMACENO TIPO CAMBIO
                 }
                 else { //moneda distinta
                   $currency_value = DB::table('currencies')->select('rate')->where('id', $item['current'])->value('rate');
                   $currency_code = DB::table('currencies')->select('code_banxico')->where('id', $item['current'])->value('code_banxico');
                   if ($currency_id === '2') { //SI LA MONEDA SELECCIONADA ES DOLAR
                      $item_amount_total = $item_amount_total/$resp_currency_value;
                      $item_amount_tax = $item_amount_tax / $resp_currency_value;
                      $item_amount_tax_ret = $item_amount_tax_ret / $resp_currency_value;
                      $item_subtotal = $item_subtotal / $resp_currency_value;

                      $item_subtotal_clean = $item_subtotal_clean / $resp_currency_value;
                      $item_discount_clean = $item_discount_clean / $resp_currency_value;


                      $items_tc [$key] =$resp_currency_value;//ALMACENO TIPO CAMBIO
                   }
                   else {
                     $item_amount_total = $item_amount_total*$currency_value;
                     $items_tc [$key] =$currency_value;//ALMACENO TIPO CAMBIO
                   }
                 }
               }

               $item_amount_untaxed = round($item_quantity * $item_amount_total, 2); //cantidad del artículo sin impuestos

               //Sumatoria totales
               $amount_subtotal += $item_subtotal_clean;

               $amount_discount += $item_discount_clean;
               $amount_untaxed += $item_subtotal;
               $amount_tax += $item_amount_tax;
               $amount_tax_ret += $item_amount_tax_ret;
               $amount_total += $item_amount_total;

               //Subtotales por cada item
               // $items[$key] = $currency_id;
               // $items[$key] = $item_amount_total;
               // $items[$key] = moneyFormat($item_amount_total, $currency_code);
               $items[$key] = $item_amount_total;
             }
           }
           //Respuesta
           $json->text = $currency_value;
           $json->items = $items;
           $json->amount_subtotal = $amount_subtotal;
           $json->amount_discount = $amount_discount;
           $json->amount_untaxed = $amount_untaxed;
           $json->amount_tax = $amount_tax + $amount_tax_ret;
           $json->amount_total = $amount_total;
           $json->amount_total_tmp = $amount_total;
           $json->tc_used = $items_tc;
           return response()->json($json);
       }
       return response()->json(['error' => __('general.error_general')], 422);
   }
   public function totalLines_original(Request $request)
   {
      //Variables
      $json = new \stdClass;
      $input_items = $request->item;
      $currency_id = $request->currency_id; //Guardo la moneda seleccionada
      $currency_value = $request->currency_value;
      // $texto = "";
      if (empty($currency_id)) {
        $currency_id = 1;
      }
      if ($currency_id === 1) {
        $currency_value = 1;
      }
      if (empty($currency_value)) {
        $currency_value = 1;
      }

      $currency_code = 'MXN'; //En caso que no haya moneda le digo por defecto es pesos mexicanos

      if ($request->ajax()) {
          //Datos de moneda - Obtengo moneda seleccionada al principio
          /*if (!empty($currency_id)) {
              $currency = Currency::findOrFail($currency_id);
              $currency_code = $currency->code;
          }*/
          /*if ($currency_id != 1) {
            $texto = 'entre al primero';
            if ($currency_value === 1 || empty($currency_value)) {
              $current_rate = DB::table('exchange_rates')->select('current_rate')->latest()->first();
              $currency_value = $current_rate->current_rate;
              $texto = 'entre';
            }else{
              $currency_value = $currency_value;
              $texto = 'no entre';
            }
          }*/

          //Variables de totales
          $amount_discount = 0;
          $amount_untaxed = 0;
          $amount_tax = 0;
          $amount_tax_ret = 0;
          $amount_total = 0;
          $balance = 0;
          $items = [];
          if (!empty($input_items)) {
            foreach ($input_items as $key => $item) {
              //Logica
              $item_quantity = (double)$item['quantity'];
              $item_price_unit = (double)$item['price_unit'];
              $item_discount = (double)$item['discount'];
              $item_price_reduce = ($item_price_unit * (100 - $item_discount) / 100); //precio del artículo reducido
              $item_amount_untaxed = round($item_quantity * $item_price_reduce, 2); //cantidad del artículo sin impuestos
              $item_amount_discount = round($item_quantity * $item_price_unit, 2) - $item_amount_untaxed; //descuento del importe del artículo
              $item_amount_tax = 0; //cantidad de impuestos
              $item_amount_tax_ret = 0; //importe del artículo reducción de impuestos
              if (!empty($item['taxes'])) {
                  foreach ($item['taxes'] as $tax_id) {
                      if (!empty($tax_id)) {
                          $tax = Tax::findOrFail($tax_id);
                          $tmp = 0;
                          if ($tax->factor == 'Tasa') {
                              $tmp = $item_amount_untaxed * $tax->rate / 100;
                          } elseif ($tax->factor == 'Cuota') {
                              $tmp = $tax->rate;
                          }
                          $tmp = round($tmp, 2);
                          if ($tmp < 0) { //Retenciones
                              $item_amount_tax_ret += $tmp;
                          } else { //Traslados
                              $item_amount_tax += $tmp;
                          }
                      }
                  }
              }
              $item_amount_total = $item_amount_untaxed + $item_amount_tax + $item_amount_tax_ret;
              //Sumatoria totales
              $amount_discount += $item_amount_discount;
              $amount_untaxed += $item_amount_untaxed;
              $amount_tax += $item_amount_tax;
              $amount_tax_ret += $item_amount_tax_ret;
              $amount_total += $item_amount_total;
              //Tipo cambio
              if ($item['current'] === $currency_id) {
                $current_rate = DB::table('exchange_rates')->select('current_rate')->latest()->first();
                if($currency_value != $current_rate->current_rate){
                  $item_amount_total = $item_amount_total * $currency_value;
                }else{
                  $item_amount_total = $item_amount_total * $current_rate->current_rate;
                }
              }
              elseif ( $item['current'] != $currency_id && !empty($item['current']) ) {
                $current_rate = DB::table('exchange_rates')->select('current_rate') ->where('currency_id', $item['current'])->latest()->first();
                $item_amount_total = $item_amount_total * $current_rate->current_rate;
              }

              //Subtotales por cada item
              // $items[$key] = $currency_id;
              // $items[$key] = $item_amount_total;
              $items[$key] = moneyFormat($item_amount_total, $currency_code);
            }
          }
          //Respuesta

          $json->text = $currency_value;
          $json->items = $items;
          $json->amount_discount = $amount_discount;
          $json->amount_untaxed = $amount_untaxed;
          $json->amount_tax = $amount_tax + $amount_tax_ret;
          $json->amount_total = $amount_total;
          $json->amount_total_tmp = $amount_total;
          return response()->json($json);
      }
      return response()->json(['error' => __('general.error_general')], 422);
   }
   public function get_currency(Request $request)
   {
      $current_rate = DB::table('exchange_rates')->select('current_rate')->latest()->first();
      if (empty($current_rate)) {
        return response()->json(['error' => __('general.error_general')], 422);
      }else{
        return $current_rate->current_rate;
      }
   }

    /**
     * Autoacompletar select2 de facturas solo activas del SAT
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
     public function autocompleteCfdi(Request $request)
     {
      $customer_id = !empty($request->customer_id) ? $request->customer_id : ''; //Filtra las facturas por cliente
      //Logica
      if ($request->ajax()) {
        $default_fact_id= DB::table('document_types')->where('code', $this->document_type_code)->value('id');
        $tmp = CustomerInvoice::where([
              ['document_type_id', '=', $default_fact_id],
              ['customer_id', '=', $customer_id],
          ])->orderBy('date')->get();
        $results = [];
        if ($tmp->isNotEmpty()) {
            foreach ($tmp as $result) {
                $results[] = [
                    'id' => $result->id,
                    'text' => $result->name,
                    'description' => $result->name
                ];
            }
        }
        return response()->json($results, 200);
      }
      return response()->json(['error' => 'Error'], 422);
     }

    /**
      * Obtener registro
      *
      * @param Request $request
      * @return \Illuminate\Http\JsonResponse
      */
     public function getCustomerInvoice(Request $request)
     {
        //Variables
        $id = $request->id;
        //Logica
        if ($request->ajax() && !empty($id)) {
            $customer_invoice = CustomerInvoice::findOrFail($id);
            $customer_invoice->uuid = $customer_invoice->customerInvoiceCfdi->uuid ?? '';
            return response()->json($customer_invoice, 200);
        }
        return response()->json(['error' => 'Error'], 422);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
        //
     }
    /**
     * Nos crea el setting por default.
     *
     * @return \Illuminate\Http\Response
     */
     public function store_reset(Request $request)
     {
       Schema::disableForeignKeyConstraints();

       Pac::truncate();
       Pac::flushEventListeners();
       factory(\App\Models\Base\Pac::class, 1)->create([
          'name' => 'PAC Pruebas',
          'code' => 'pacTest',
          'test' => TRUE,
       ]);
       factory(\App\Models\Base\Pac::class, 1)->create([
          'name' => 'Edicom Pruebas',
          'code' => 'edicomTest',
          'ws_url' => 'https://cfdiws.sedeb2b.com/EdiwinWS/services/CFDi?wsdl',
          'ws_url_cancel' => 'https://cfdiws.sedeb2b.com/EdiwinWS/services/CFDi?wsdl',
          'test' => TRUE,
       ]);
       factory(\App\Models\Base\Pac::class, 1)->create([
          'name' => 'Finkok Pruebas',
          'code' => 'finkokTest',
          'ws_url' => 'http://demo-facturacion.finkok.com/servicios/soap/stamp.wsdl',
          'ws_url_cancel' => 'http://demo-facturacion.finkok.com/servicios/soap/cancel.wsdl',
          'test' => TRUE,
       ]);
       factory(\App\Models\Base\Pac::class, 1)->create([
          'name' => 'Edicom Producción',
          'code' => 'edicom',
          'ws_url' => 'https://cfdiws.sedeb2b.com/EdiwinWS/services/CFDi?wsdl',
          'ws_url_cancel' => 'https://cfdiws.sedeb2b.com/EdiwinWS/services/CFDi?wsdl',
          'test' => FALSE,
       ]);
       factory(\App\Models\Base\Pac::class, 1)->create([
          'name' => 'Finkok Producción',
          'code' => 'finkok',
          'ws_url' => 'https://facturacion.finkok.com/servicios/soap/stamp.wsdl',
          'ws_url_cancel' => 'https://facturacion.finkok.com/servicios/soap/cancel.wsdl',
          'test' => FALSE,
       ]);
       //Elimina tablas
        Setting::truncate();
       //En caso de haber un listener en los modelos para evitar problemas con acciones predefinidas
        Setting::flushEventListeners();
        Setting::create([
            'key' => 'cfdi_version',
            'value' => 'cfdi33',
        ]);
        //Default PAC
        Setting::create([
            'key' => 'default_pac_id',
            'value' => \App\Models\Base\Pac::where('code','=','pacTest')->get()->random()->id,
        ]);
       echo 'yes';
     }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
      // Begin a transaction
      \DB::beginTransaction();

      // Open a try/catch block
      try {

info($request);
throw new \Exception(__('general.error_cfdi_version'));

          //Logica
          $request->merge(['created_uid' => \Auth::user()->id]);
          $request->merge(['updated_uid' => \Auth::user()->id]);
          $request->merge(['status' => CustomerInvoice::OPEN]);
          //Ajusta fecha y genera fecha de vencimiento
          $date = Helper::createDateTime($request->date);
          $request->merge(['date' => Helper::dateTimeToSql($date)]);
          $date_due = $date; //La fecha de vencimiento por default
          $date_due_fix = $request->date_due;//Fix valida si la fecha de vencimiento esta vacia en caso de error
          if (!empty($request->date_due)) {
              $date_due = Helper::createDate($request->date_due);
          } else {
              $payment_term = PaymentTerm::findOrFail($request->payment_term_id);
              $date_due = $payment_term->days > 0 ? $date->copy()->addDays($payment_term->days) : $date->copy();
          }
          $request->merge(['date_due' => Helper::dateToSql($date_due)]);

          //Obtiene folio
          $document_type = Helper::getNextDocumentTypeByCode($this->document_type_code);
          $request->merge(['document_type_id' => $document_type['id']]);
          $request->merge(['name' => $document_type['name']]);
          $request->merge(['serie' => $document_type['serie']]);
          $request->merge(['folio' => $document_type['folio']]);

          //Guardar Registro principal
          $customer_invoice = CustomerInvoice::create($request->input());
          //Registro de lineas
          $amount_subtotal = 0;
          $amount_discount = 0;  //Descuento de cantidad
          $amount_untaxed = 0;   //Cantidad sin impuestos
          $amount_tax = 0;       //Importe impuesto
          $amount_tax_ret = 0;   //Importe impuesto ret
          $amount_total = 0;     //Cantidad total
          $balance = 0;          //Balance
          $taxes = array();      //Impuestos

          $currency_pral_id = $request->currency_id;      //Moneda principal
          $currency_pral_value = $request->currency_value;//Valor o TC de la moneda principal

          //Lineas
          if (!empty($request->item)) {
              foreach ($request->item as $key => $item) {
                  //Logica
                  $item_quantity = (double)$item['quantity'];  //cantidad de artículo
                  $item_price_unit = (double)$item['price_unit']; //unidad de precio del artículo
                  $item_discount = (double)$item['discount']; //descuento del artículo

                  $item_subtotal_quantity = round($item_price_unit * $item_quantity, 2);

                  $item_price_reduce = ($item_price_unit * (100 - $item_discount) / 100); //Precio reducido
                  $item_amount_untaxed = round($item_quantity * $item_price_reduce, 2); //libre de impuestos
                  $item_amount_discount = round($item_quantity * $item_price_unit, 2) - $item_amount_untaxed;//descuento
                  $item_amount_tax = 0;//impuesto a la cantidad del artículo
                  $item_amount_tax_ret = 0;// cantidad de artículo retiro de impuestos
                  //Impuestos por cada producto
                  if (!empty($item['taxes'])) {
                      foreach ($item['taxes'] as $tax_id) {
                          if (!empty($tax_id)) {
                              $tax = Tax::findOrFail($tax_id);
                              $tmp = 0;
                              if ($tax->factor == 'Tasa') {
                                  $tmp = $item_amount_untaxed * $tax->rate / 100;
                              } elseif ($tax->factor == 'Cuota') {
                                  $tmp = $tax->rate;
                              }
                              $tmp = round($tmp, 2);
                              if ($tmp < 0) { //Retenciones
                                  $item_amount_tax_ret += $tmp;
                              } else { //Traslados
                                  $item_amount_tax += $tmp;
                              }
                              //Sumatoria de impuestos
                              $taxes[$tax_id] = array(
                                  'amount_base' => $item_amount_untaxed + (isset($taxes[$tax_id]['amount_base']) ? $taxes[$tax_id]['amount_base'] : 0),
                                  'amount_tax' => $tmp + (isset($taxes[$tax_id]['amount_tax']) ? $taxes[$tax_id]['amount_tax'] : 0),
                              );
                          }
                      }
                  }
                  $item_subtotal_clean = $item_subtotal_quantity;
                  $item_discount_clean = $item_amount_discount;
                  $item_amount_total = $item_amount_untaxed + $item_amount_tax + $item_amount_tax_ret;
                  $item_subtotal = $item_amount_untaxed; //libre de impuestos

                  //Tipo de cambio
                  $item_currency_id = $item['current'];
                  $item_currency_code = DB::table('currencies')->select('code_banxico')->where('id', $item_currency_id)->value('code_banxico');
                  $item_currency_value = $currency_pral_value;

                  //--------------------------------------------------------------------------------------------------------------------------//
                  //Moneda principal es dolar
                  if ($currency_pral_id == '2') {
                    if ($item_currency_id == '2') {
                      $item_currency_value = $currency_pral_value; //Tipo de cambio a usar
                    }
                    else {
                      $item_currency_value = $currency_pral_value; //Tipo de cambio a usar
                      //Tranformamos a dolar
                      $item_amount_tax = $item_amount_tax / $item_currency_value;
                      $item_amount_tax_ret = $item_amount_tax_ret / $item_currency_value;
                      $item_amount_total = $item_amount_total / $item_currency_value;
                      $item_subtotal = $item_subtotal / $item_currency_value;
                      $item_subtotal_clean = $item_subtotal_clean / $item_currency_value;
                      $item_discount_clean = $item_discount_clean / $item_currency_value;
                      foreach ($taxes as $tax_id => $result) {
                        $taxes[$tax_id]['amount_base'] = $result['amount_base'] / $item_currency_value;
                        $taxes[$tax_id]['amount_tax'] = $result['amount_tax'] / $item_currency_value;
                      }
                    }
                  }
                  //Moneda distinta
                  else {
                    if ($item_currency_id == '2') { //bien
                      $exchange_rates = DB::table('exchange_rates')->select('current_rate')->latest()->first();
                      $item_currency_value = $exchange_rates->current_rate; //Tipo de cambio a usar
                      //Tranformamos a dolar
                      $item_amount_tax = $item_amount_tax * $item_currency_value;
                      $item_amount_tax_ret = $item_amount_tax_ret * $item_currency_value;
                      $item_amount_total = $item_amount_total * $item_currency_value;
                      $item_subtotal = $item_subtotal * $item_currency_value;
                      $item_subtotal_clean = $item_subtotal_clean * $item_currency_value;
                      $item_discount_clean = $item_discount_clean * $item_currency_value;
                      foreach ($taxes as $tax_id => $result) {
                        $taxes[$tax_id]['amount_base'] = $result['amount_base'] * $item_currency_value;
                        $taxes[$tax_id]['amount_tax'] = $result['amount_tax'] * $item_currency_value;
                      }
                    }
                    else {
                      $item_currency_value = DB::table('currencies')->select('rate')->where('id', $item_currency_id)->value('rate');
                      //Tranformamos al valor de la moneda seleccionada
                      $item_amount_tax = $item_amount_tax * $item_currency_value;
                      $item_amount_tax_ret = $item_amount_tax_ret * $item_currency_value;
                      $item_amount_total = $item_amount_total * $item_currency_value;
                      $item_subtotal = $item_subtotal * $item_currency_value;
                      $item_subtotal_clean = $item_subtotal_clean * $item_currency_value;
                      $item_discount_clean = $item_discount_clean * $item_currency_value;
                      foreach ($taxes as $tax_id => $result) {
                        $taxes[$tax_id]['amount_base'] = $result['amount_base'] * $item_currency_value;
                        $taxes[$tax_id]['amount_tax'] = $result['amount_tax'] * $item_currency_value;
                      }
                    }
                  }
                  //--------------------------------------------------------------------------------------------------------------------------//
                  //Sumatoria totales
                  $amount_subtotal += $item_subtotal_clean;
                  $amount_discount += $item_discount_clean;
                  $amount_untaxed += $item_subtotal; //Original -> $amount_untaxed += $item_amount_untaxed;
                  $amount_tax += $item_amount_tax;
                  $amount_tax_ret += $item_amount_tax_ret;
                  $amount_total += $item_amount_total;

                  //Guardar linea
                  $customer_invoice_line = CustomerInvoiceLine::create([
                      'created_uid' => \Auth::user()->id,
                      'updated_uid' => \Auth::user()->id,
                      'customer_invoice_id' => $customer_invoice->id,
                      'name' => $item['name'],
                      'product_id' => $item['product_id'],
                      'sat_product_id' => $item['sat_product_id'],
                      'unit_measure_id' => $item['unit_measure_id'],
                      'quantity' => $item_quantity,
                      'price_unit' => $item_price_unit,
                      'discount' => $item_discount,
                      'price_reduce' => $item_price_reduce,
                      'amount_discount' => $item_discount_clean,
                      // 'amount_discount' => $item_amount_discount,
                      'amount_untaxed' => $item_subtotal_clean,
                      // 'amount_untaxed' => $item_amount_untaxed,
                      'amount_tax' => $item_amount_tax,
                      'amount_tax_ret' => $item_amount_tax_ret,
                      'amount_total' => $item_amount_total,
                      'sort_order' => $key,
                      'status' => 1,
                      'currency_id' => $item['current'],
                      'currency_value' => $item_currency_value,
                  ]);

                  //Guardar impuestos por linea
                  if (!empty($item['taxes'])) {
                      $customer_invoice_line->taxes()->sync($item['taxes']);
                  } else {
                      $customer_invoice_line->taxes()->sync([]);
                  }
              }
          }

          //Resumen de impuestos
          if (!empty($taxes)) {
              $i = 0;
              foreach ($taxes as $tax_id => $result) {
                  $tax = Tax::findOrFail($tax_id);
                  $customer_invoice_tax = CustomerInvoiceTax::create([
                      'created_uid' => \Auth::user()->id,
                      'updated_uid' => \Auth::user()->id,
                      'customer_invoice_id' => $customer_invoice->id,
                      'name' => $tax->name,
                      'tax_id' => $tax_id,
                      'amount_base' => $result['amount_base'],
                      'amount_tax' => $result['amount_tax'],
                      'sort_order' => $i,
                      'status' => 1,
                  ]);
                  $i++;
              }
          }

          //Cfdi relacionados
          if (!empty($request->item_relation)) {
              foreach ($request->item_relation as $key => $result) {
                  //Guardar
                  $customer_invoice_relation = CustomerInvoiceRelation::create([
                      'created_uid' => \Auth::user()->id,
                      'updated_uid' => \Auth::user()->id,
                      'customer_invoice_id' => $customer_invoice->id,
                      'relation_id' => $result['relation_id'],
                      'sort_order' => $key,
                      'status' => 1,
                  ]);
              }
          }

          //Registros de cfdi
          $customer_invoice_cfdi = CustomerInvoiceCfdi::create([
              'created_uid' => \Auth::user()->id,
              'updated_uid' => \Auth::user()->id,
              'customer_invoice_id' => $customer_invoice->id,
              'name' => $customer_invoice->name,
              'status' => 1,
          ]);

          //Actualiza registro principal con totales
          $customer_invoice->amount_discount = $amount_discount;
          $customer_invoice->amount_untaxed = $amount_subtotal;
          $customer_invoice->amount_tax = $amount_tax;
          $customer_invoice->amount_tax_ret = $amount_tax_ret;
          $customer_invoice->amount_total = $amount_total;
          $customer_invoice->balance = $amount_total;
          $customer_invoice->update();

          $class_cfdi = setting('cfdi_version');
          // dd(method_exists($this, $class_cfdi));
          if (empty($class_cfdi) || $class_cfdi === '0') {
              throw new \Exception(__('general.error_cfdi_version'));
          }
          if (!method_exists($this, $class_cfdi)) {
              throw new \Exception(__('general.error_cfdi_class_exists'));
          }
          //Valida Empresa y PAC para timbrado
          PacHelper::validateSatActions();

          //Crear XML y timbra
          $tmp = $this->$class_cfdi($customer_invoice);
          //Guardar registros de CFDI
          $customer_invoice_cfdi->fill(array_only($tmp,[
              'pac_id',
              'cfdi_version',
              'uuid',
              'date',
              'file_xml',
              'file_xml_pac',
          ]));
          $customer_invoice_cfdi->save();
          // Commit the transaction
          DB::commit();
          return 'success';
          // return __('general.text_success_customer_invoice_cfdi');
      } catch (\Exception $e) {
          $request->merge([
                'date' => Helper::convertSqlToDateTime($request->date),
          ]);
          if (!empty($date_due_fix)) {
                $request->merge([
                    'date_due' => Helper::convertSqlToDate($request->date_due),
                ]);
          }else{
                $request->merge([
                    'date_due' => '',
                ]);
          }
          // An error occured; cancel the transaction...
          DB::rollback();

          // and throw the error again.
          // throw $e;
          return $e;
          // return __('general.error_cfdi_pac');
      }
     }

     public function store_cont(Request $request)
     {
       // Begin a transaction
       \DB::beginTransaction();

       // Open a try/catch block
       try {
         //Logica
         $request->merge(['created_uid' => \Auth::user()->id]);
         $request->merge(['updated_uid' => \Auth::user()->id]);
         $request->merge(['status' => CustomerInvoice::OPEN]);
         //Ajusta fecha y genera fecha de vencimiento
         $date = Helper::createDateTime($request->date);
         $request->merge(['date' => Helper::dateTimeToSql($date)]);
         $date_due = $date;
         $date_due_fix = $request->date_due;//Fix valida si la fecha de vencimiento esta vacia en caso de error
         if (!empty($request->date_due)) {
             $date_due = Helper::createDate($request->date_due);
         } else {
             $payment_term = PaymentTerm::findOrFail($request->payment_term_id);
             $date_due = $payment_term->days > 0 ? $date->copy()->addDays($payment_term->days) : $date->copy();
         }
         $request->merge(['date_due' => Helper::dateToSql($date_due)]);
         //Obtiene folio
         $document_type = Helper::getNextDocumentTypeByCode($this->document_type_code);
         $request->merge(['document_type_id' => $document_type['id']]);
         $request->merge(['name' => $document_type['name']]);
         $request->merge(['serie' => $document_type['serie']]);
         $request->merge(['folio' => $document_type['folio']]);
         //Guardar Registro principal
         $customer_invoice = CustomerInvoice::create($request->input());
         //Registro de lineas
         $amount_subtotal = 0;
         $amount_discount = 0;  //Descuento de cantidad
         $amount_untaxed = 0;   //Cantidad sin impuestos
         $amount_tax = 0;       //Importe impuesto
         $amount_tax_ret = 0;   //Importe impuesto ret
         $amount_total = 0;     //Cantidad total
         $balance = 0;          //Balance
         $taxes = array();      //Impuestos

         $currency_pral_id = $request->currency_id;      //Moneda principal
         $currency_pral_value = $request->currency_value;//Valor o TC de la moneda principal
         //Lineas
         if (!empty($request->item)) {
             foreach ($request->item as $key => $item) {
                 //Logica
                 $item_quantity = (double)$item['quantity']; //cantidad de artículo
                 $item_price_unit = (double)$item['price_unit']; //unidad de precio del artículo
                 $item_discount = (double)$item['discount']; //descuento del artículo

                 $item_subtotal_quantity = round($item_price_unit * $item_quantity, 2);


                 $item_price_reduce = ($item_price_unit * (100 - $item_discount) / 100); //Precio reducido
                 $item_amount_untaxed = round($item_quantity * $item_price_reduce, 2); //libre de impuestos
                 $item_amount_discount = round($item_quantity * $item_price_unit, 2) - $item_amount_untaxed;//descuento
                 $item_amount_tax = 0; //impuesto a la cantidad del artículo
                 $item_amount_tax_ret = 0; // cantidad de artículo retiro de impuestos
                //Impuestos por cada producto
                 if (!empty($item['taxes'])) {
                     foreach ($item['taxes'] as $tax_id) {
                         if (!empty($tax_id)) {
                             $tax = Tax::findOrFail($tax_id);
                             $tmp = 0;
                             if ($tax->factor == 'Tasa') {
                                 $tmp = $item_amount_untaxed * $tax->rate / 100;
                             } elseif ($tax->factor == 'Cuota') {
                                 $tmp = $tax->rate;
                             }
                             $tmp = round($tmp, 2);
                             if ($tmp < 0) { //Retenciones
                                 $item_amount_tax_ret += $tmp;
                             } else { //Traslados
                                 $item_amount_tax += $tmp;
                             }
                             //Sumatoria de impuestos
                             $taxes[$tax_id] = array(
                                 'amount_base' => $item_amount_untaxed + (isset($taxes[$tax_id]['amount_base']) ? $taxes[$tax_id]['amount_base'] : 0),
                                 'amount_tax' => $tmp + (isset($taxes[$tax_id]['amount_tax']) ? $taxes[$tax_id]['amount_tax'] : 0),
                             );
                         }
                     }
                 }
                 $item_subtotal_clean = $item_subtotal_quantity;
                 $item_discount_clean = $item_amount_discount;
                 $item_amount_total = $item_amount_untaxed + $item_amount_tax + $item_amount_tax_ret;// cantidad total del artículo = Cantidad del artículo libre de impuestos + impuesto a la cantidad del artículo + cantidad de artículo retiro de impuestos
                 $item_subtotal = $item_amount_untaxed; //libre de impuestos
                 //Tipo de cambio
                 $item_currency_id = $item['current'];
                 $item_currency_code = DB::table('currencies')->select('code_banxico')->where('id', $item_currency_id)->value('code_banxico');
                 $item_currency_value = $currency_pral_value;
                 //--------------------------------------------------------------------------------------------------------------------------//
                 //Moneda principal es dolar
                 if ($currency_pral_id == '2') {
                   if ($item_currency_id == '2') {
                     $item_currency_value = $currency_pral_value; //Tipo de cambio a usar
                   }
                   else {
                     $item_currency_value = $currency_pral_value; //Tipo de cambio a usar
                     //Tranformamos a dolar
                     $item_amount_tax = $item_amount_tax / $item_currency_value;
                     $item_amount_total = $item_amount_total / $item_currency_value;
                     $item_subtotal = $item_subtotal / $item_currency_value;
                      $item_subtotal_clean = $item_subtotal_clean / $item_currency_value;
                      $item_discount_clean = $item_discount_clean / $item_currency_value;
                      foreach ($taxes as $tax_id => $result) {
                        $taxes[$tax_id]['amount_base'] = $result['amount_base'] / $item_currency_value;
                        $taxes[$tax_id]['amount_tax'] = $result['amount_tax'] / $item_currency_value;
                      }
                   }
                 }
                 //Moneda distinta
                 else {
                   if ($item_currency_id == '2') { //bien
                     $exchange_rates = DB::table('exchange_rates')->select('current_rate')->latest()->first();
                     $item_currency_value = $exchange_rates->current_rate; //Tipo de cambio a usar
                     //Tranformamos a dolar
                     $item_amount_tax = $item_amount_tax * $item_currency_value;
                     $item_amount_total = $item_amount_total * $item_currency_value;
                     $item_subtotal = $item_subtotal * $item_currency_value;
                      $item_subtotal_clean = $item_subtotal_clean * $item_currency_value;
                      $item_discount_clean = $item_discount_clean * $item_currency_value;
                      foreach ($taxes as $tax_id => $result) {
                        $taxes[$tax_id]['amount_base'] = $result['amount_base'] * $item_currency_value;
                        $taxes[$tax_id]['amount_tax'] = $result['amount_tax'] * $item_currency_value;
                      }

                   }
                   else {
                     $item_currency_value = DB::table('currencies')->select('rate')->where('id', $item_currency_id)->value('rate');
                     //Tranformamos al valor de la moneda seleccionada
                     $item_amount_tax = $item_amount_tax * $item_currency_value;
                     $item_amount_total = $item_amount_total * $item_currency_value;
                     $item_subtotal = $item_subtotal * $item_currency_value;
                      $item_subtotal_clean = $item_subtotal_clean * $item_currency_value;
                      $item_discount_clean = $item_discount_clean * $item_currency_value;
                      foreach ($taxes as $tax_id => $result) {
                        $taxes[$tax_id]['amount_base'] = $result['amount_base'] * $item_currency_value;
                        $taxes[$tax_id]['amount_tax'] = $result['amount_tax'] * $item_currency_value;
                      }

                   }
                 }
                 //--------------------------------------------------------------------------------------------------------------------------//

                 //Sumatoria totales
                 $amount_subtotal += $item_subtotal_clean;
                 $amount_discount += $item_discount_clean;
                 $amount_untaxed += $item_subtotal; //Original -> $amount_untaxed += $item_amount_untaxed;
                 $amount_tax += $item_amount_tax;
                 $amount_tax_ret += $item_amount_tax_ret;
                 $amount_total += $item_amount_total;

                 //Guardar linea
                 $customer_invoice_line = CustomerInvoiceLine::create([
                     'created_uid' => \Auth::user()->id,
                     'updated_uid' => \Auth::user()->id,
                     'customer_invoice_id' => $customer_invoice->id,
                     'name' => $item['name'],
                     'sat_product_id' => $item['sat_product_id'],
                     'unit_measure_id' => $item['unit_measure_id'],
                     'quantity' => $item_quantity,
                     'price_unit' => $item_price_unit,
                     'discount' => $item_discount,
                     'price_reduce' => $item_price_reduce,
                     'amount_discount' => $item_discount_clean,
                     // 'amount_discount' => $item_amount_discount,
                     'amount_untaxed' => $item_subtotal_clean,
                     // 'amount_untaxed' => $item_amount_untaxed,
                     'amount_tax' => $item_amount_tax,
                     'amount_tax_ret' => $item_amount_tax_ret,
                     'amount_total' => $item_amount_total,
                     'sort_order' => $key,
                     'status' => 1,
                     'contract_annex_id' => $item['id_cont'],
                     'currency_id' => $item['current'],
                     'currency_value' => $item_currency_value,
                     'group_sites' => $request->group_sites
                 ]);

                 //Guardar impuestos por linea
                 if (!empty($item['taxes'])) {
                     $customer_invoice_line->taxes()->sync($item['taxes']);
                 } else {
                     $customer_invoice_line->taxes()->sync([]);
                 }
             }
         }

         //Resumen de impuestos
         if (!empty($taxes)) {
             $i = 0;
             foreach ($taxes as $tax_id => $result) {
                 $tax = Tax::findOrFail($tax_id);
                 $customer_invoice_tax = CustomerInvoiceTax::create([
                     'created_uid' => \Auth::user()->id,
                     'updated_uid' => \Auth::user()->id,
                     'customer_invoice_id' => $customer_invoice->id,
                     'name' => $tax->name,
                     'tax_id' => $tax_id,
                     'amount_base' => $result['amount_base'],
                     'amount_tax' => $result['amount_tax'],
                     'sort_order' => $i,
                     'status' => 1,
                 ]);
                 $i++;
             }
         }

         //Cfdi relacionados
         if (!empty($request->item_relation)) {
             foreach ($request->item_relation as $key => $result) {
                 //Guardar
                 $customer_invoice_relation = CustomerInvoiceRelation::create([
                     'created_uid' => \Auth::user()->id,
                     'updated_uid' => \Auth::user()->id,
                     'customer_invoice_id' => $customer_invoice->id,
                     'relation_id' => $result['relation_id'],
                     'sort_order' => $key,
                     'status' => 1,
                 ]);
             }
         }

         //Registros de cfdi
         $customer_invoice_cfdi = CustomerInvoiceCfdi::create([
             'created_uid' => \Auth::user()->id,
             'updated_uid' => \Auth::user()->id,
             'customer_invoice_id' => $customer_invoice->id,
             'name' => $customer_invoice->name,
             'status' => 1,
         ]);

         //Actualiza registro principal con totales
         $customer_invoice->amount_discount = $amount_discount;
         $customer_invoice->amount_untaxed = $amount_subtotal;
         $customer_invoice->amount_tax = $amount_tax;
         $customer_invoice->amount_tax_ret = $amount_tax_ret;
         $customer_invoice->amount_total = $amount_total;
         $customer_invoice->balance = $amount_total;
         $customer_invoice->update();

         $class_cfdi = setting('cfdi_version');
         // dd(method_exists($this, $class_cfdi));
         if (empty($class_cfdi) || $class_cfdi === '0') {
             throw new \Exception(__('general.error_cfdi_version'));
         }
         if (!method_exists($this, $class_cfdi)) {
             throw new \Exception(__('general.error_cfdi_class_exists'));
         }

         if($request->group_sites == 1){
            $this->insert_sites_annexes_lines($request, $customer_invoice);
         }

         //Valida Empresa y PAC para timbrado
         PacHelper::validateSatActions();

         //Crear XML y timbra
         $tmp = $this->$class_cfdi($customer_invoice);
         //Guardar registros de CFDI
         $customer_invoice_cfdi->fill(array_only($tmp,[
             'pac_id',
             'cfdi_version',
             'uuid',
             'date',
             'file_xml',
             'file_xml_pac',
         ]));
         $customer_invoice_cfdi->save();
         // Commit the transaction
         DB::commit();
         return 'success';
         // return __('general.text_success_customer_invoice_cfdi');
       } catch (\Exception $e) {
           $request->merge([
                 'date' => Helper::convertSqlToDateTime($request->date),
           ]);
           if (!empty($date_due_fix)) {
                 $request->merge([
                     'date_due' => Helper::convertSqlToDate($request->date_due),
                 ]);
           }else{
                 $request->merge([
                     'date_due' => '',
                 ]);
           }
           // An error occured; cancel the transaction...
           DB::rollback();

           // and throw the error again.
           // throw $e;
           return $e;
           // return __('general.error_cfdi_pac');
       }
     }


     //Inserta sitios agrupados a CustomerInvoiceLines

     public function insert_sites_annexes_lines(Request $request, $customer_invoice)
     {
        $cadena_id = $request->cadena_id;
        $contract_master_id = $request->cont_maestro_id;

        $sites = DB::select('CALL px_annexesXcadena_data(?, ?)', array($cadena_id, $contract_master_id));
        $num_sites = count($sites);

        if (!empty($request->item)) {

                //--------------------------------------------------------------------------------------------------------------------------//

            /***GUARDANDO ANEXOS CON SUS MONTOS UNICOS****/
            foreach ($sites as $key => $site) {
                //dd($site);
                $item = $request->item;
                //Logica
                $item_quantity = (double)$item[0]['quantity']; //cantidad de artículo
                $item_price_unit = (double)$site->monto; //unidad de precio del artículo
                $item_discount = (double)$item[0]['discount']; //descuento del artículo

                $item_subtotal_quantity = round($item_price_unit * $item_quantity, 2);


                $item_price_reduce = ($item_price_unit * (100 - $item_discount) / 100); //Precio reducido
                $item_amount_untaxed = round($item_quantity * $item_price_reduce, 2); //libre de impuestos
                $item_amount_discount = round($item_quantity * $item_price_unit, 2) - $item_amount_untaxed;//descuento
                $item_amount_tax = 0; //impuesto a la cantidad del artículo
                $item_amount_tax_ret = 0; // cantidad de artículo retiro de impuestos
               //Impuestos por cada producto
                if (!empty($item[0]['taxes'])) {
                    foreach ($item[0]['taxes'] as $tax_id) {
                        if (!empty($tax_id)) {
                            $tax = Tax::findOrFail($tax_id);
                            $tmp = 0;
                            if ($tax->factor == 'Tasa') {
                                $tmp = $item_amount_untaxed * $tax->rate / 100;
                            } elseif ($tax->factor == 'Cuota') {
                                $tmp = $tax->rate;
                            }
                            $tmp = round($tmp, 2);
                            if ($tmp < 0) { //Retenciones
                                $item_amount_tax_ret += $tmp;
                            } else { //Traslados
                                $item_amount_tax += $tmp;
                            }
                            //Sumatoria de impuestos
                            $taxes[$tax_id] = array(
                                'amount_base' => $item_amount_untaxed + (isset($taxes[$tax_id]['amount_base']) ? $taxes[$tax_id]['amount_base'] : 0),
                                'amount_tax' => $tmp + (isset($taxes[$tax_id]['amount_tax']) ? $taxes[$tax_id]['amount_tax'] : 0),
                            );
                        }
                    }
                }

                $item_subtotal_clean = $item_subtotal_quantity;
                $item_discount_clean = $item_amount_discount;
                $item_amount_total = $item_amount_untaxed + $item_amount_tax + $item_amount_tax_ret;// cantidad total del artículo = Cantidad del artículo libre de impuestos + impuesto a la cantidad del artículo + cantidad de artículo retiro de impuestos
                $item_subtotal = $item_amount_untaxed; //libre de impuestos
                $currency_pral_id = $request->currency_id;      //Moneda principal
                $currency_pral_value = $request->currency_value;//Valor o TC de la moneda principal
                //Tipo de cambio
                $item_currency_id = $item[0]['current'];
                $item_currency_code = DB::table('currencies')->select('code_banxico')->where('id', $item_currency_id)->value('code_banxico');
                $item_currency_value = $currency_pral_value;
                //--------------------------------------------------------------------------------------------------------------------------//
                //Moneda principal es dolar
                if ($currency_pral_id == '2') {
                  if ($item_currency_id == '2') {
                    $item_currency_value = $currency_pral_value; //Tipo de cambio a usar
                  }
                  else {
                    $item_currency_value = $currency_pral_value; //Tipo de cambio a usar
                    //Tranformamos a dolar
                    $item_amount_tax = $item_amount_tax / $item_currency_value;
                    $item_amount_total = $item_amount_total / $item_currency_value;
                    $item_subtotal = $item_subtotal / $item_currency_value;
                     $item_subtotal_clean = $item_subtotal_clean / $item_currency_value;
                     $item_discount_clean = $item_discount_clean / $item_currency_value;
                  }
                }
                //Moneda distinta
                else {
                  if ($item_currency_id == '2') { //bien
                    $exchange_rates = DB::table('exchange_rates')->select('current_rate')->latest()->first();
                    $item_currency_value = $exchange_rates->current_rate; //Tipo de cambio a usar
                    //Tranformamos a dolar
                    $item_amount_tax = $item_amount_tax * $item_currency_value;
                    $item_amount_total = $item_amount_total * $item_currency_value;
                    $item_subtotal = $item_subtotal * $item_currency_value;
                     $item_subtotal_clean = $item_subtotal_clean * $item_currency_value;
                     $item_discount_clean = $item_discount_clean * $item_currency_value;

                  }
                  else {
                    $item_currency_value = DB::table('currencies')->select('rate')->where('id', $item_currency_id)->value('rate');
                    //Tranformamos al valor de la moneda seleccionada
                    $item_amount_tax = $item_amount_tax * $item_currency_value;
                    $item_amount_total = $item_amount_total * $item_currency_value;
                    $item_subtotal = $item_subtotal * $item_currency_value;
                     $item_subtotal_clean = $item_subtotal_clean * $item_currency_value;
                     $item_discount_clean = $item_discount_clean * $item_currency_value;

                  }
                }

                $customer_invoice_line = CustomerInvoiceLine::create([
                    'created_uid' => \Auth::user()->id,
                    'updated_uid' => \Auth::user()->id,
                    'customer_invoice_id' => $customer_invoice->id,
                    'name' => $item[0]['name'],
                    'sat_product_id' => $item[0]['sat_product_id'],
                    'unit_measure_id' => $item[0]['unit_measure_id'],
                    'quantity' => $item_quantity,
                    'price_unit' => $item_price_unit,
                    'discount' => $item_discount,
                    'price_reduce' => $item_price_reduce,
                    'amount_discount' => $item_discount_clean,
                    'amount_untaxed' => $item_subtotal_clean,
                    'amount_tax' => $item_amount_tax,
                    'amount_tax_ret' => $item_amount_tax_ret,
                    'amount_total' => $item_amount_total,
                    'sort_order' => $key,
                    'status' => 1,
                    'contract_annex_id' => $site->contract_annex_id,
                    'currency_id' => $item[0]['current'],
                    'currency_value' => $item_currency_value,
                    'group_sites' => 1
                ]);
                  //dd($item[0]['taxes']);
                //Guardar impuestos por linea
                if (!empty($item[0]['taxes'])) {
                    $customer_invoice_line->taxes()->sync($item[0]['taxes']);
                } else {
                    $customer_invoice_line->taxes()->sync([]);
                }
            } //FIN FOREACH
        }

     }

     /**
      * Crear XML y enviar a timbrar CFDI 3.3
      *
      * @param CustomerInvoice $customer_invoice
      * @return array|\CfdiUtils\Elements\Cfdi33\Concepto|float|int
      * @throws \Exception
      */
     private function cfdi33(CustomerInvoice $customer_invoice)
     {

         try {
             //Logica
             $company = Helper::defaultCompany(); //Empresa
             $pac = Pac::findOrFail(setting('default_pac_id')); //PAC

             //Arreglo CFDI 3.3
             $cfdi33 = [];
             if (!empty($customer_invoice->serie)) {
                 $cfdi33['Serie'] = $customer_invoice->serie;
             }
             $cfdi33['Folio'] = $customer_invoice->folio;
             $cfdi33['Fecha'] = \Date::parse($customer_invoice->date)->format('Y-m-d\TH:i:s');
             //$cfdi33['Sello']
             $cfdi33['FormaPago'] = $customer_invoice->paymentWay->code;
             $cfdi33['NoCertificado'] = $company->certificate_number;
             //$cfdi33['Certificado']
             $cfdi33['CondicionesDePago'] = $customer_invoice->paymentTerm->name;
             $cfdi33['SubTotal'] = Helper::numberFormat($customer_invoice->amount_untaxed + $customer_invoice->amount_discount,
                 $customer_invoice->currency->decimal_place, false);
             if($customer_invoice->amount_discount>0) {
                 $cfdi33['Descuento'] = Helper::numberFormat($customer_invoice->amount_discount,
                     $customer_invoice->currency->decimal_place, false);
             }
             $cfdi33['Moneda'] = $customer_invoice->currency->code;
             if ($customer_invoice->currency->code != 'MXN') {
                 $cfdi33['TipoCambio'] = Helper::numberFormat($customer_invoice->currency_value, 4, false);
             }
             $cfdi33['Total'] = Helper::numberFormat($customer_invoice->amount_total,
                 $customer_invoice->currency->decimal_place, false);
             $cfdi33['TipoDeComprobante'] = $customer_invoice->documentType->cfdiType->code;
             $cfdi33['MetodoPago'] = $customer_invoice->paymentMethod->code;
             $cfdi33['LugarExpedicion'] = $customer_invoice->branchOffice->postcode;
             if (!empty($customer_invoice->confirmacion)) {
                 $cfdi33['Confirmacion'] = $customer_invoice->confirmacion;
             }
             //---Cfdi Relacionados
             $cfdi33_relacionados = [];
             $cfdi33_relacionado = [];
             if (!empty($customer_invoice->cfdi_relation_id)) {
                 $cfdi33_relacionados['TipoRelacion'] = $customer_invoice->cfdiRelation->code;
                 if ($customer_invoice->customerInvoiceRelations->isNotEmpty()) {
                     foreach ($customer_invoice->customerInvoiceRelations as $key => $result) {
                         $cfdi33_relacionado[$key] = [];
                         $cfdi33_relacionado[$key]['UUID'] = $result->relation->customerInvoiceCfdi->uuid;
                     }
                 }
             }
             //---Emisor
             $cfdi33_emisor = [];
             $cfdi33_emisor['Rfc'] = $company->taxid;
             $cfdi33_emisor['Nombre'] = trim($company->name);
             $cfdi33_emisor['RegimenFiscal'] = $company->taxRegimen->code;
             //---Receptor
             $cfdi33_receptor = [];
             $cfdi33_receptor['Rfc'] = $customer_invoice->customer->taxid;
             $cfdi33_receptor['Nombre'] = trim($customer_invoice->customer->name);
             if ($customer_invoice->customer->taxid == 'XEXX010101000') {
                 $cfdi33_receptor['ResidenciaFiscal'] = $customer_invoice->customer->country->code;
                 $cfdi33_receptor['NumRegIdTrib'] = $customer_invoice->customer->numid;
             }
             $cfdi33_receptor['UsoCFDI'] = $customer_invoice->cfdiUse->code;
             //---Conceptos
             $cfdi33_conceptos = [];
             $cfdi33_conceptos_traslados = [];
             $cfdi33_conceptos_retenciones = [];
             foreach ($customer_invoice->customerInvoiceLines as $key => $result) {
                 $cfdi33_conceptos [$key]['ClaveProdServ'] = $result->satProduct->code;
                 if (!empty($result->product->code)) {
                     $cfdi33_conceptos [$key]['NoIdentificacion'] = trim($result->product->code);
                 }
                 $cfdi33_conceptos [$key]['Cantidad'] = Helper::numberFormat($result->quantity, 6, false);
                 $cfdi33_conceptos [$key]['ClaveUnidad'] = trim($result->unitMeasure->code);
                 $cfdi33_conceptos [$key]['Unidad'] = str_limit(trim($result->unitMeasure->name),20,'');
                 $cfdi33_conceptos [$key]['Descripcion'] = trim($result->name);
                 $cfdi33_conceptos [$key]['ValorUnitario'] = Helper::numberFormat($result->price_unit, 6, false);
                 $cfdi33_conceptos [$key]['Importe'] = Helper::numberFormat($result->amount_untaxed + $result->amount_discount,
                     2, false);
                 if($result->amount_discount>0) {
                     $cfdi33_conceptos [$key]['Descuento'] = Helper::numberFormat($result->amount_discount, 2, false);
                 }
                 //['InformacionAduanera']
                 //['CuentaPredial']
                 //['ComplementoConcepto']
                 //['Parte']
                 //Complemento

                 //Impuestos por concepto
                 $cfdi33_conceptos_traslados[$key] = [];
                 $cfdi33_conceptos_retenciones[$key] = [];
                 if ($result->taxes) {
                     foreach ($result->taxes as $key2 => $result2) {
                         $tmp = 0;
                         $rate = $result2->rate;
                         if ($result2->factor == 'Tasa') {
                             $rate /= 100;
                             $tmp = $result->amount_untaxed * $rate;
                         } elseif ($result2->factor == 'Cuota') {
                             $tmp = $rate;
                         }
                         $tmp = round($tmp, 2);
                         if ($tmp < 0) { //Retenciones
                             $cfdi33_conceptos_retenciones[$key][$key2] = [];
                             $cfdi33_conceptos_retenciones[$key][$key2]['Base'] = Helper::numberFormat($result->amount_untaxed,
                                 2, false);
                             $cfdi33_conceptos_retenciones[$key][$key2]['Impuesto'] = $result2->code;
                             $cfdi33_conceptos_retenciones[$key][$key2]['TipoFactor'] = $result2->factor; //Para retenciones no hay excento
                             $cfdi33_conceptos_retenciones[$key][$key2]['TasaOCuota'] = Helper::numberFormat(abs($rate),
                                 6, false);
                             $cfdi33_conceptos_retenciones[$key][$key2]['Importe'] = Helper::numberFormat(abs($tmp), 2,
                                 false);
                         } else { //Traslados
                             $cfdi33_conceptos_traslados[$key][$key2] = [];
                             $cfdi33_conceptos_traslados[$key][$key2]['Base'] = Helper::numberFormat($result->amount_untaxed,
                                 2, false);
                             $cfdi33_conceptos_traslados[$key][$key2]['Impuesto'] = $result2->code;
                             $cfdi33_conceptos_traslados[$key][$key2]['TipoFactor'] = $result2->factor; //Para retenciones no hay excento
                             if ($result2->factor != 'Exento') {
                                 $cfdi33_conceptos_traslados[$key][$key2]['TasaOCuota'] = Helper::numberFormat(abs($rate),
                                     6, false);
                                 $cfdi33_conceptos_traslados[$key][$key2]['Importe'] = Helper::numberFormat(abs($tmp), 2,
                                     false);
                             }
                         }
                     }
                 }
             }
             //Impuestos
             $cfdi33_retenciones = [];
             $cfdi33_traslados = [];
             if ($customer_invoice->customerInvoiceTaxes->isNotEmpty()) {
                 foreach ($customer_invoice->customerInvoiceTaxes as $key => $result) {
                     $tmp = $result->amount_tax;
                     $rate = $result->tax->rate;
                     if ($result->tax->factor == 'Tasa') {
                         $rate /= 100;
                     }
                     if ($tmp < 0) { //Retenciones
                         $cfdi33_retenciones[$key] = [];
                         $cfdi33_retenciones[$key]['Impuesto'] = $result->tax->code;
                         $cfdi33_retenciones[$key]['Importe'] = Helper::numberFormat(abs($tmp), $customer_invoice->currency->decimal_place, false);
                     } else { //Traslados
                         if ($result->tax->factor != 'Exento') {
                             $cfdi33_traslados[$key] = [];
                             $cfdi33_traslados[$key]['Impuesto'] = $result->tax->code;
                             $cfdi33_traslados[$key]['TipoFactor'] = $result->tax->factor;
                             $cfdi33_traslados[$key]['TasaOCuota'] = Helper::numberFormat(abs($rate), 6, false);
                             $cfdi33_traslados[$key]['Importe'] = Helper::numberFormat(abs($tmp), 2, false);
                         }
                     }
                 }
             }
             $cfdi33_impuestos = [];
             if (abs($customer_invoice->amount_tax_ret) > 0 || !empty($cfdi33_retenciones)) {
                 $cfdi33_impuestos['TotalImpuestosRetenidos'] = Helper::numberFormat(abs($customer_invoice->amount_tax_ret),
                     $customer_invoice->currency->decimal_place, false);
             }
             if (abs($customer_invoice->amount_tax) > 0 || !empty($cfdi33_traslados)) {
                 $cfdi33_impuestos['TotalImpuestosTrasladados'] = Helper::numberFormat(abs($customer_invoice->amount_tax),
                     $customer_invoice->currency->decimal_place, false);
             }

             //Genera XML
             $certificado = new \CfdiUtils\Certificado\Certificado(\Storage::path($company->pathFileCer()));
             $creator = new \CfdiUtils\CfdiCreator33($cfdi33, $certificado);
             $creator->setXmlResolver(PacHelper::resourcePathCfdiUtils()); //Almacenamiento local
             $comprobante = $creator->comprobante();
             if (!empty($cfdi33_relacionados)) {
                 $comprobante->addCfdiRelacionados($cfdi33_relacionados);
             }
             if (!empty($cfdi33_relacionado)) {
                 foreach ($cfdi33_relacionado as $key => $result) {
                     $comprobante->addCfdiRelacionado($result);
                 }
             }
             $comprobante->addEmisor($cfdi33_emisor);
             $comprobante->addReceptor($cfdi33_receptor);
             //Conceptos
             foreach ($cfdi33_conceptos as $key => $result) {
                 $concepto = $comprobante->addConcepto($result);
                 if (!empty($cfdi33_conceptos_traslados[$key])) {
                     foreach ($cfdi33_conceptos_traslados[$key] as $result2) {
                         $concepto->multiTraslado($result2);
                     }
                 }
                 if (!empty($cfdi33_conceptos_retenciones[$key])) {
                     foreach ($cfdi33_conceptos_retenciones[$key] as $result2) {
                         $concepto->multiRetencion($result2);
                     }
                 }
             }
             //Impuestos
             if(!empty($cfdi33_impuestos)) {
                 $comprobante->addImpuestos($cfdi33_impuestos);
                 if (!empty($cfdi33_retenciones)) {
                     foreach ($cfdi33_retenciones as $result2) {
                         $comprobante->multiRetencion($result2);
                     }
                 }
                 if (!empty($cfdi33_traslados)) {
                     foreach ($cfdi33_traslados as $result2) {
                         $comprobante->multiTraslado($result2);
                     }
                 }
             }
             //Método de ayuda para establecer las sumas del comprobante e impuestos con base en la suma de los conceptos y la agrupación de sus impuestos
             //$creator->addSumasConceptos(null, 2);
             //Método de ayuda para generar el sello (obtener la cadena de origen y firmar con la llave privada)
             $creator->addSello('file://' . \Storage::path($company->pathFileKeyPassPem()), Crypt::decryptString($company->password_key));
             //Valida la estructura
             //$creator->validate();

             //Guarda XML
             //dd($creator->asXml());
             $path_xml = Helper::setDirectory(CustomerInvoice::PATH_XML_FILES_CI) . '/';
             $file_xml = Helper::makeDirectoryCfdi($path_xml) . '/' . Str::random(40) . '.xml';
             $creator->saveXml(\Storage::path($path_xml . $file_xml));


             //Arreglo temporal para actualizar Customer Invoice CFDI
             $tmp = [
                 'pac_id' => $pac->id,
                 'cfdi_version' => setting('cfdi_version'),
                 'uuid' => '',
                 'date' => '',
                 'path_xml' => $path_xml,
                 'file_xml' => $file_xml,
                 'file_xml_pac' => '',
                 'pac' => $pac,
             ];

             //Timbrado de XML
             $class_pac = $pac->code;
             $tmp = PacHelper::$class_pac($tmp, $creator);

             return $tmp;
         } catch (\Exception $e) {
             throw $e;
         }
     }

     /**
      * Muestra el apartado de todas las facturas
      *
      * @return \Illuminate\Http\Response
      */
      public function show()
      {

        $customer = DB::select('CALL GetCustomersActivev2 ()', array());
        $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
        $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
        $salespersons = DB::select('CALL GetAllSalespersonv2 ()', array());
        $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
        $list_status = $this->list_status;

        return view('permitted.sales.customer_invoices_show',compact(
          'customer', 'sucursal', 'list_status'
        ));
      }
      public function search(Request $request)
      {
        $folio = !empty($request->filter_name) ? $request->filter_name : '';
        $date_from  = $request->filter_date_from;
        $date_to  = $request->filter_date_to;
        $sucursal = !empty($request->filter_branch_office_id) ? $request->filter_branch_office_id : '';
        $cliente = !empty($request->filter_customer_id) ? $request->filter_customer_id : '';
        $estatus = !empty($request->filter_status) ? $request->filter_status : '';

        $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
        $date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');

        $resultados = DB::select('CALL px_customer_invoices_filters (?,?,?,?,?,?)', array($date_a, $date_b, $folio, $sucursal, $cliente, $estatus));

        return json_encode($resultados);
      }

      /**
       * Cambiar estatus a enviada
       *
       * @param CustomerInvoice $customer_invoice
       * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
       */
      public function markSent(Request $request)
      {
          $id = $request->token_b;
          $customer_invoice = CustomerInvoice::findOrFail($id);
          //Logica
          if ((int)$customer_invoice->mail_sent != 1) {
            $customer_invoice->updated_uid = \Auth::user()->id;
            $customer_invoice->mail_sent = 1;
            $customer_invoice->save();
            return response()->json(['status' => 200]);
          }
          else{
            return response()->json(['status' => 304]);
          }
      }
      /**
       * Cambiar estatus a pagada
       *
       * @param CustomerInvoice $customer_invoice
       * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
       */
      public function markPaid(Request $request)
      {
        $id = $request->token_b;
        $customer_invoice = CustomerInvoice::findOrFail($id);

        if ((int)$customer_invoice->status == CustomerInvoice::OPEN) {
          $customer_invoice->updated_uid = \Auth::user()->id;
          $customer_invoice->status = CustomerInvoice::PAID;
          $customer_invoice->save();
          return response()->json(['status' => 200]);
        }
        else {
          return response()->json(['status' => 304]);
        }
      }
      /**
       * Modal para historial de pagos
       *
       * @param Request $request
       * @param CustomerInvoice $customer_invoice
       * @return \Illuminate\Http\JsonResponse
       * @throws \Throwable
       */
       public function modalPaymentHistoryhead(Request $request)
       {
           //Variables
           $id = $request->token_b;
           $resultados = DB::select('CALL px_customer_invoices_xid (?)', array($id));
           return json_encode($resultados);
       }
      public function modalPaymentHistory(Request $request)
      {
          //Variables
          $id = $request->token_b;
          $resultados = DB::select('CALL px_customer_payment_reconcileds_xid (?)', array($id));
          return json_encode($resultados);
      }
      /**
       * Modal para estatus de CFDI
       *
       * @param Request $request
       * @param CustomerInvoice $customer_invoice
       * @return \Illuminate\Http\JsonResponse
       * @throws \Throwable
       */
       public function modalStatusSat(Request $request)
       {
         //Variables
         $id = $request->token_b;
         $company = Helper::defaultCompany(); //Empresa
         $customer_invoice = CustomerInvoice::findOrFail($id);
         //Logica
         if ($request->ajax() && !empty($id)) {
           //Obtener informacion de estatus
           $data_status_sat = [
               'cancelable' => 1,
               'pac_is_cancelable' => ''
           ];
           if (!empty($customer_invoice->customerInvoiceCfdi->cfdi_version) && !empty($customer_invoice->customerInvoiceCfdi->uuid)) {
               $tmp = [
                   'rfcR' => $customer_invoice->customer->taxid,
                   'uuid' => $customer_invoice->customerInvoiceCfdi->uuid,
                   'total' => Helper::numberFormat($customer_invoice->amount_total, $customer_invoice->currency->decimal_place, false),
               ];
               $class_pac = $customer_invoice->customerInvoiceCfdi->pac->code . 'Status';
               $data_status_sat = PacHelper::$class_pac($tmp,$customer_invoice->customerInvoiceCfdi->pac);
           }
           $is_cancelable = true;
           if($data_status_sat['cancelable'] == 3){
               $is_cancelable = false;
           }

           $data_result = [
               'uuid' => $customer_invoice->customerInvoiceCfdi->uuid,
               'rfcE' => $company->taxid,
               'rfcR' => $customer_invoice->customer->taxid,
               'amount_total' => $customer_invoice->amount_total,
               'customer_invoice' => $customer_invoice,
               'company' => $company,
               'text_is_cancelable_cfdi' => $data_status_sat['pac_is_cancelable'],
               'text_status_cfdi' => $data_status_sat['pac_status']
           ];
           return $data_result;
         }
       }
       /**
         * Modal para cancelar factura
         * Mostrar infor en el swal alert
         *
         * @param Request $request
         * @param CustomerInvoice $customer_invoice
         * @return \Illuminate\Http\JsonResponse
         * @throws \Throwable
       */
      public function modalCancel(Request $request)
      {
            //Variables
            $id = $request->token_b;
            $company = Helper::defaultCompany(); //Empresa
            $customer_invoice = CustomerInvoice::findOrFail($id);

            //Logica
            if ($request->ajax() && !empty($id)) {
                //Obtener informacion de estatus
                $data_status_sat = [
                    'cancelable' => 1,
                    'pac_is_cancelable' => ''
                ];
                if (!empty($customer_invoice->customerInvoiceCfdi->cfdi_version) && !empty($customer_invoice->customerInvoiceCfdi->uuid)) {
                    $tmp = [
                        'rfcR' => $customer_invoice->customer->taxid,
                        'uuid' => $customer_invoice->customerInvoiceCfdi->uuid,
                        'total' => Helper::numberFormat($customer_invoice->amount_total, $customer_invoice->currency->decimal_place, false),
                    ];
                    $class_pac = $customer_invoice->customerInvoiceCfdi->pac->code . 'Status';
                    $data_status_sat = PacHelper::$class_pac($tmp,$customer_invoice->customerInvoiceCfdi->pac);
                }
                $is_cancelable = true;
                if($data_status_sat['cancelable'] == 3){
                    $is_cancelable = false;
                }
                $data_result = [
                    'customer_invoice' => $customer_invoice,
                    'company' => $company,
                    'data_status_sat' => $data_status_sat,
                    'is_cancelable' => $is_cancelable,
                    'text_is_cancelable_cfdi' => $data_status_sat['cancelable'],
                    'text_status_cfdi' => $data_status_sat['pac_is_cancelable'],
                    'pac_status' => $data_status_sat['pac_status']
                ];
                return $data_result;
            }
      }
      /**
       * Remove the specified resource from storage.
       * Cancelar el cfdi y eliminar el recurso
       *
       * @param  \App\Models\Sales\CustomerInvoice $customer_invoice
       * @return \Illuminate\Http\Response
      */
      public function destroy(Request $request, CustomerInvoice $customer_invoice)
      {
          \DB::beginTransaction();
          try {
              $id = $request->token_b;
              $customer_invoice = CustomerInvoice::findOrFail($id);
              //Logica
              if ((int)$customer_invoice->status != CustomerInvoice::CANCEL && $customer_invoice->balance >= $customer_invoice->amount_total) {
                  //Actualiza status
                  $customer_invoice->updated_uid = \Auth::user()->id;
                  $customer_invoice->status = CustomerInvoice::CANCEL;
                  //Por autorizar cuando se manda la autorizacion al buzon tributario del SAT
                  if($request->cancelable == 2){
                      $customer_invoice->status = CustomerInvoice::CANCEL_PER_AUTHORIZED;
                  }
                  $customer_invoice->save();

                  //Actualiza status CFDI
                  $customer_invoice->customerInvoiceCfdi->status = 0;
                  $customer_invoice->customerInvoiceCfdi->save();

                  //Cancelacion del timbre fiscal
                  if (!empty($customer_invoice->customerInvoiceCfdi->cfdi_version) && !empty($customer_invoice->customerInvoiceCfdi->uuid)) {
                      //Valida Empresa y PAC para cancelar timbrado
                      PacHelper::validateSatCancelActions($customer_invoice->customerInvoiceCfdi->pac);

                      //Arreglo temporal para actualizar Customer Invoice CFDI
                      $tmp = [
                          'cancel_date' => Helper::dateTimeToSql(\Date::now()),
                          'cancel_response' => '',
                          'cancel_state' => $request->cancel_state,
                          'rfcR' => $customer_invoice->customer->taxid,
                          'uuid' => $customer_invoice->customerInvoiceCfdi->uuid,
                          'total' => Helper::numberFormat($customer_invoice->amount_total,
                              $customer_invoice->currency->decimal_place, false),
                      ];

                      //Cancelar Timbrado de XML
                      $class_pac = $customer_invoice->customerInvoiceCfdi->pac->code . 'Cancel';
                      $tmp = PacHelper::$class_pac($tmp,$customer_invoice->customerInvoiceCfdi->pac);

                      //Guardar registros de CFDI
                      $customer_invoice->customerInvoiceCfdi->fill(array_only($tmp,[
                          'cancel_date',
                          'cancel_response',
                          'cancel_state',
                      ]));
                      $customer_invoice->customerInvoiceCfdi->save();

                  }
                  return response()->json(['status' => 200]);
              }
              else {
                return response()->json(['error' => 304]);
              }
              \DB::commit();

              //Mensaje

          } catch (\Exception $e) {
              \DB::rollback();
              return response()->json(['error' => $e]);
          }
      }

      /**
       * Descarga de archivo XML
       *
       * @param Request $request
       * @param CustomerInvoice $customer_invoice
       * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\BinaryFileResponse
      * public function downloadXml(Request $request, CustomerInvoice $customer_invoice)
      */
      public function downloadXml($id)
      {
          $customer_invoice = CustomerInvoice::findOrFail($id);
          //Ruta y validacion del XML
          $path_xml = Helper::setDirectory(CustomerInvoice::PATH_XML_FILES_CI) . '/';
          $file_xml_pac = $path_xml . $customer_invoice->customerInvoiceCfdi->file_xml_pac;
          if (!empty($file_xml_pac)) {
              if (\Storage::exists($file_xml_pac)) {
                  return response()->download(\Storage::path($file_xml_pac), $customer_invoice->name . '.xml');
              }
          }
      }


    /**
     * Modal para envio de correo de factura
     *
     * @param Request $request
     * @param CustomerInvoice $customer_invoice
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function modalSendMail(Request $request)
    {
        //Variables
        $id = $request->token_b;
        $company = Helper::defaultCompany(); //Empresa
        $customer_invoice = CustomerInvoice::findOrFail($id);

        //Logica
        if ($request->ajax() && !empty($id)) {
            //Correo default del cliente
            $to = [];
            $to_selected = [];
            if (!empty($customer_invoice->customer->email)) {
                $email = $customer_invoice->customer->email;
                $to[$email] = $email;
                $to_selected [] = $email;
            }
            //Etiquetas solo son demostrativas
            $files = [
                'pdf' => $customer_invoice->name . '.pdf',
                'xml' => $customer_invoice->name . '.xml'
            ];
            $files_selected = array_keys($files);

            //modal de mensaje
            /*
            $html = view('layouts.partials.customer_invoices.modal_send_mail',
                compact('customer_invoice', 'company', 'to', 'to_selected', 'files', 'files_selected'))->render();

            //Mensaje predefinido
            $custom_message = view('layouts.partials.customer_invoices.message_send_mail',
                compact('customer_invoice'))->render();

            return response()->json(['html' => $html, 'custom_message' => $custom_message]);
            */

            $a3 = '<b>Le remitimos adjunta la siguiente factura:</b>'.'<br>';
            $a2 = $customer_invoice->name;
            $a1 = Helper::convertSqlToDateTime($customer_invoice->date);
            $a0 = '<br>';


            $data_result = [
                'customer_invoice' => $customer_invoice,
                'company' => $company,
                'to' => $to,
                'to_selected' => $to_selected,
                'files' => $files,
                'files_selected' => $files_selected,
                'custom_message' => $a1.$a0.$a2.$a0.$a3
            ];
            return $data_result;

        }
        return response()->json(['error' => __('general.error_general')], 422);
    }
    /**
     * Envio de factura por correo
     *
     * @param Request $request
     * @param CustomerInvoice $customer_invoice
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendMail(Request $request, CustomerInvoice $customer_invoice)
    {
        //Validaciones
        $validator = \Validator::make($request->all(), [
            'subject' => 'required',
            'to' => 'required',
            'to.*' => 'email',
            'message' => 'required'
        ], [
            'subject.*' => __('general.error_mail_subject'),
            'to.required' => __('general.error_mail_to'),
            'to.*.email' => __('general.error_mail_to_format'),
            'message.*' => __('general.error_mail_message'),
        ]);
        if ($validator->fails()) {
            $errors = '<ul>';
            foreach ($validator->errors()->all() as $message) {
                $errors .= '<li>'.$message . '</li>';
            }
            $errors .= '</ul>';
            return response()->json(['error' => $errors], 422);
        }

        //Creamos PDF en stream
        $pdf = $this->print($customer_invoice);
        //Ruta del XML
        $path_xml = Helper::setDirectory(CustomerInvoice::PATH_XML_FILES_CI) . '/';
        $file_xml_pac = $path_xml . $customer_invoice->customerInvoiceCfdi->file_xml_pac;

        //Envio de correo
        $to = $request->to;
        \Mail::to($to)->send(new SendCustomerInvoice($customer_invoice, $request->subject, $request->message, $pdf,
            $file_xml_pac));

        //Actualiza campo de enviado
        $customer_invoice->updated_uid = \Auth::user()->id;
        $customer_invoice->mail_sent = 1;
        $customer_invoice->save();

        //Mensaje
        return response()->json([
            'success' => sprintf(__('sales/customer_invoice.text_success_send_mail'), $customer_invoice->name)
        ]);
    }

    public function verfact(Request $request)
    {
      $customer_invoice = CustomerInvoice::findOrFail(1);
      $companies = DB::select('CALL px_companies_data ()', array());
      //Si tiene CFDI obtiene la informacion de los nodos
      if(!empty($customer_invoice->customerInvoiceCfdi->file_xml_pac) && !empty($customer_invoice->customerInvoiceCfdi->uuid)){
        $path_xml = Helper::setDirectory(CustomerInvoice::PATH_XML_FILES_CI) . '/';
          $file_xml_pac = $path_xml . $customer_invoice->customerInvoiceCfdi->file_xml_pac;

          //Valida que el archivo exista
          if(\Storage::exists($file_xml_pac)) {
              $cfdi = \CfdiUtils\Cfdi::newFromString(\Storage::get($file_xml_pac));
              $data = Cfdi33Helper::getQuickArrayCfdi($cfdi);

              //Genera codigo QR
              $image = QrCode::format('png')->size(150)->margin(0)->generate($data['qr_cadena']);
              $data['qr'] = 'data:image/png;base64,' . base64_encode($image);
          }
      }
      return view('permitted.sales.customer_invdos', compact('companies', 'customer_invoice', 'data'));
    }

    public function index2()
    {
      $customer = DB::select('CALL GetCustomersActivev2 ()', array());
      $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
      $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
      $salespersons = DB::select('CALL GetAllSalespersonv2 ()', array());
      $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
      $payment_term = DB::select('CALL GetAllPaymentTermsv2 ()', array());
      $payment_methods = DB::select('CALL GetAllPaymentMethodsv2 ()', array());
      $cfdi_uses = DB::select('CALL GetAllCfdiUsev2 ()', array());
      $cfdi_relations = DB::select('CALL GetAllCfdiRelationsv2 ()', array());


      $product =  DB::select('CALL GetAllProductActivev2 ()', array());
      $unitmeasures = DB::select('CALL GetUnitMeasuresActivev2 ()', array());
      $satproduct = DB::select('CALL GetSatProductActivev2 ()', array());
      $impuestos =  DB::select('CALL GetAllTaxesActivev2 ()', array());

      $cadenas =  DB::select('CALL px_cadenas ()', array());
      $cxclassifications = DB::table('cxclassifications')->select('id', 'name')->get();

      return view('permitted.sales.customer_invoices_cont',compact(
        'cadenas',
        'customer','sucursal','currency',
        'salespersons','payment_way','payment_term',
        'payment_methods', 'cfdi_uses', 'cfdi_relations',
        'product', 'unitmeasures', 'satproduct', 'impuestos', 'cxclassifications'
      ));
    }
    public function search_cont(Request $request)
    {
      $folio = !empty($request->id_search) ? $request->id_search : '';

      $resultados = DB::select('CALL px_contract_master_Xcadena (?)', array($folio));

      return json_encode($resultados);
    }

    public function getDataContractAnnexes(Request $request)
    {
      $cadena_id = $request->cadena_id;
      $contract_master_id = $request->contract_master_id;

      $result = DB::select('CALL px_annexesXcadena_data(?, ?)', array($cadena_id, $contract_master_id));

      return $result;
    }
    public function balances(Request $request)
    {
      //Variables
      $customer_id = $request->customer_id;
      $filter_currency_id = $request->currency_id;
      //Logica
      if ($request->ajax() && !empty($customer_id)) {
        $resultados = DB::select('CALL px_customer_invoices_open_data (?, ?)', array($customer_id, $filter_currency_id));
        return response()->json($resultados, 200);
      }
      return response()->json(['error' => __('general.error500')], 422);
    }

    public function search_currency_contract(Request $request)
    {
      $customer_id = $request->currency_id;
      if ($customer_id == 2) {
        $resultados = DB::select('CALL px_tipocambio_ultimo ()', array());
        return json_encode($resultados);
      }
      else {
        $resultados = DB::select('CALL px_currency_data (?)', array($customer_id));
        return json_encode($resultados);
      }
    }
    public function view_contracts_create(Request $request)
    {
      $facturar_salesperson = $request->salesperson_id;
      $facturar_brand_office = $request->branch_office_id;
      $facturar_refence = !empty($request->reference) ? $request->reference : '';
      $facturar_description = $request->description;
      $facturar_desc_month = $request->description_month;
      $facturar_desc_all = $facturar_description.' '.$facturar_desc_month;

      $facturar_currency = $request->currency_id;
      $facturar_value_tc = $request->currency_value;

      $user = Auth::user()->id;
      //Formatos de fechas
      $date = Helper::createDateTime($request->date);
      $date_format = Helper::dateTimeToSql($date);

      \DB::beginTransaction();
      // Open a try/catch block
      try {
          // Begin a transaction
          $contract_id = json_decode($request->idents);
          $order = 1;
          for ($i=0; $i <= (count($contract_id)-1); $i++) {
            $all_information_anexos = DB::select('CALL px_contract_annexes_data (?)', array($contract_id[$i]));
            $facturar_pay_term = $all_information_anexos[0]->payment_term_id;
            $facturar_pay_way = $all_information_anexos[0]->payment_way_id;
            $facturar_pay_met = $all_information_anexos[0]->payment_method_id;
            $facturar_cfdi_use = $all_information_anexos[0]->cfdi_user_id;

            //Fix valida si la fecha de vencimiento esta vacia en caso de error
            $payment_term = PaymentTerm::findOrFail($all_information_anexos[0]->payment_term_id);
            $date_due = $payment_term->days > 0 ? $date->copy()->addDays($payment_term->days) : $date->copy();
            $date_due_format = Helper::dateToSql($date_due);

            //Logica
            $request->merge(['created_uid' => \Auth::user()->id]);
            $request->merge(['updated_uid' => \Auth::user()->id]);
            $request->merge(['status' => CustomerInvoice::OPEN]);
            //Ajusta fecha y genera fecha de vencimiento
            $request->merge(['date' => $date_format ]);
            $request->merge(['date_due' => $date_due_format]);
            //Obtiene folio
            $document_type = Helper::getNextDocumentTypeByCode($this->document_type_code);
            $request->merge(['document_type_id' => $document_type['id']]);
            $request->merge(['name' => $document_type['name']]);
            $request->merge(['serie' => $document_type['serie']]);
            $request->merge(['folio' => $document_type['folio']]);
            //Guardar Registro principal
            $customer_invoice = CustomerInvoice::create($request->input());
            //Registro de lineas
            $amount_subtotal = 0;
            $amount_discount = 0;  //Descuento de cantidad
            $amount_untaxed = 0;   //Cantidad sin impuestos
            $amount_tax = 0;       //Importe impuesto
            $amount_tax_ret = 0;   //Importe impuesto ret
            $amount_total = 0;     //Cantidad total
            $balance = 0;          //Balance
            $taxes = array();      //Impuestos
            $currency_pral_id = $request->currency_id;      //Moneda principal
            $currency_pral_value = $request->currency_value;//Valor o TC de la moneda principal

            $item_quantity = 1;  //cantidad de artículo - default 1 un contrato anexo
            $item_price_unit= $all_information_anexos[0]->quantity; //monto contrato
            $customer_general= $all_information_anexos[0]->rz_customer_id; //cliente id
            $item_discount = 0; //descuento del artículo  - default 0 - NOTA: Aun no fijo el descuento

            $item_subtotal_quantity = round($item_price_unit * $item_quantity, 2);

            $item_price_reduce = ($item_price_unit * (100 - $item_discount) / 100); //Precio reducido
            $item_amount_untaxed = round($item_quantity * $item_price_reduce, 2); //libre de impuestos
            $item_amount_discount = round($item_quantity * $item_price_unit, 2) - $item_amount_untaxed;//descuento
            $item_amount_tax = 0;//impuesto a la cantidad del artículo
            $item_amount_tax_ret = 0;// cantidad de artículo retiro de impuestos

            //Tipo de cambio
            $item_currency_id = !empty($request->currency_id) ? $request->currency_id : 1;
            $item_currency_code = DB::table('currencies')->select('code_banxico')->where('id', $item_currency_id)->value('code_banxico');
            $item_currency_value = !empty($request->currency_value) ? $request->currency_value : 1;

            $item_subtotal_clean = $item_subtotal_quantity;
            $item_discount_clean = $item_amount_discount;
            $item_amount_total = $item_amount_untaxed + $item_amount_tax + $item_amount_tax_ret;// cantidad total del artículo = Cantidad del artículo libre de impuestos + impuesto a la cantidad del artículo + cantidad de artículo retiro de impuestos
            $item_subtotal = $item_amount_untaxed; //libre de impuestos

            //Sumatoria totales
            $amount_subtotal += $item_subtotal_clean;
            $amount_discount += $item_discount_clean;
            $amount_untaxed += $item_subtotal;
            $amount_tax += $item_amount_tax;
            $amount_tax_ret += $item_amount_tax_ret;
            $amount_total += $item_amount_total;

            //Guardar linea -- Por cada anexo de contrato
            $customer_invoice_line = CustomerInvoiceLine::create([
                'created_uid' => \Auth::user()->id,
                'updated_uid' => \Auth::user()->id,
                'customer_invoice_id' => $customer_invoice->id,
                'name' => $facturar_desc_all,
                'contract_annex_id' => $all_information_anexos[0]->id,
                'sat_product_id' => $all_information_anexos[0]->sat_product_id,
                'unit_measure_id' => $all_information_anexos[0]->unit_measure_id,
                'quantity' => $item_quantity,
                'price_unit' => $item_price_unit,
                'discount' => $item_discount,
                'price_reduce' => $item_price_reduce,
                'amount_discount' => $item_amount_discount,
                'amount_untaxed' => $item_amount_untaxed,
                'amount_tax' => $item_amount_tax,
                'amount_tax_ret' => $item_amount_tax_ret,
                'amount_total' => $item_amount_total,
                'sort_order' => $order,
                'status' => 1,
                'currency_id' => $item_currency_id,
                'currency_value' => $item_currency_value,
            ]);
            //Registros de cfdi
            $customer_invoice_cfdi = CustomerInvoiceCfdi::create([
                'created_uid' => \Auth::user()->id,
                'updated_uid' => \Auth::user()->id,
                'customer_invoice_id' => $customer_invoice->id,
                'name' => $customer_invoice->name,
                'status' => 1,
            ]);
            //Actualiza registro principal con totales
            $customer_invoice->customer_id = $customer_general;
            $customer_invoice->amount_discount = $amount_discount;
            $customer_invoice->amount_untaxed = $amount_subtotal;
            $customer_invoice->amount_tax = $amount_tax;
            $customer_invoice->amount_tax_ret = $amount_tax_ret;
            $customer_invoice->amount_total = $amount_total;
            $customer_invoice->balance = $amount_total;
            $customer_invoice->update();

            $class_cfdi = setting('cfdi_version');
            if (empty($class_cfdi) || $class_cfdi === '0') {
                throw new \Exception(__('general.error_cfdi_version'));
            }
            if (!method_exists($this, $class_cfdi)) {
                throw new \Exception(__('general.error_cfdi_class_exists'));
            }
            //Valida Empresa y PAC para timbrado
            PacHelper::validateSatActions();
            //Crear XML y timbra
            $tmp = $this->$class_cfdi($customer_invoice);
            //Guardar registros de CFDI
            $customer_invoice_cfdi->fill(array_only($tmp,[
                'pac_id',
                'cfdi_version',
                'uuid',
                'date',
                'file_xml',
                'file_xml_pac',
            ]));
            $customer_invoice_cfdi->save();
          }
          DB::commit();
          return 'success';
      }
      catch (\Exception $e) {
          // An error occured; cancel the transaction...
          DB::rollback();
          // and throw the error again.
          // throw $e;
          return $e;
      }
    }    
    public function view_contracts_create_backup(Request $request)
    {
        $facturar_salesperson = $request->salesperson_id;
        $facturar_pay_way = $request->payment_way_id;
        $facturar_pay_met = $request->payment_method_id;
        $facturar_cfdi_use = $request->cfdi_use_id;
        $facturar_brand_office = $request->branch_office_id;
        $facturar_refence = !empty($request->reference) ? $request->reference : '';
        $facturar_currency = $request->currency_id;
        $facturar_value_tc = $request->currency_value;
        $facturar_description = $request->description;
        $facturar_desc_month = $request->description_month;
        $facturar_desc_all = $facturar_description.' '.$facturar_desc_month;
        $user = Auth::user()->id;
        //Formatos de fechas
        $date = Helper::createDateTime($request->date);
        $date_format = Helper::dateTimeToSql($date);
        //Fix valida si la fecha de vencimiento esta vacia en caso de error
        if (!empty($request->date_due)) {
            $date_due = Helper::createDate($request->date_due);
        }
        else {
            $payment_term = PaymentTerm::findOrFail($request->payment_term_id);
            $date_due = $payment_term->days > 0 ? $date->copy()->addDays($payment_term->days) : $date->copy();
        }
        $date_due_format = Helper::dateToSql($date_due);

        \DB::beginTransaction();
        // Open a try/catch block
        try {
            // Begin a transaction
            $contract_id = json_decode($request->idents);
            for ($i=0; $i <= (count($contract_id)-1); $i++) {
              //Logica
              $request->merge(['created_uid' => \Auth::user()->id]);
              $request->merge(['updated_uid' => \Auth::user()->id]);
              $request->merge(['status' => CustomerInvoice::OPEN]);
              //Ajusta fecha y genera fecha de vencimiento
              // $date = Helper::createDateTime($request->date);
              $request->merge(['date' => $date_format ]);
              $request->merge(['date_due' => $date_due_format]);
              //Obtiene folio
              $document_type = Helper::getNextDocumentTypeByCode($this->document_type_code);
              $request->merge(['document_type_id' => $document_type['id']]);
              $request->merge(['name' => $document_type['name']]);
              $request->merge(['serie' => $document_type['serie']]);
              $request->merge(['folio' => $document_type['folio']]);
              //Guardar Registro principal
              $customer_invoice = CustomerInvoice::create($request->input());
              //Registro de lineas
              $amount_subtotal = 0;
              $amount_discount = 0;  //Descuento de cantidad
              $amount_untaxed = 0;   //Cantidad sin impuestos
              $amount_tax = 0;       //Importe impuesto
              $amount_tax_ret = 0;   //Importe impuesto ret
              $amount_total = 0;     //Cantidad total
              $balance = 0;          //Balance
              $taxes = array();      //Impuestos
              $currency_pral_id = $request->currency_id;      //Moneda principal
              $currency_pral_value = $request->currency_value;//Valor o TC de la moneda principal
              //Buscamos los contratos anexos
              $resultados_anexos = DB::select('CALL px_annexesXmaster_data (?, ?)', array($contract_id[$i], $facturar_currency));
              $order = 1;
              $customer_general = "";
              foreach ($resultados_anexos as $key) {
                  $item_quantity = 1;  //cantidad de artículo - default 1 un contrato anexo
                $item_price_unit = $key->monto; //unidad de precio del artículo
                $customer_general= $key->rz_customer_id; //cliente id
                  $item_discount = 0; //descuento del artículo  - default 0 - NOTA: Aun no fijo el descuento

                  $item_subtotal_quantity = round($item_price_unit * $item_quantity, 2);

                  $item_price_reduce = ($item_price_unit * (100 - $item_discount) / 100); //Precio reducido
                  $item_amount_untaxed = round($item_quantity * $item_price_reduce, 2); //libre de impuestos
                  $item_amount_discount = round($item_quantity * $item_price_unit, 2) - $item_amount_untaxed;//descuento
                  $item_amount_tax = 0;//impuesto a la cantidad del artículo
                  $item_amount_tax_ret = 0;// cantidad de artículo retiro de impuestos

                  //Tipo de cambio
                  $item_currency_id = !empty($request->currency_id) ? $request->currency_id : 1;
                  $item_currency_code = DB::table('currencies')->select('code_banxico')->where('id', $item_currency_id)->value('code_banxico');
                  $item_currency_value = !empty($request->currency_value) ? $request->currency_value : 1;

                  $item_subtotal_clean = $item_subtotal_quantity;
                  $item_discount_clean = $item_amount_discount;
                  $item_amount_total = $item_amount_untaxed + $item_amount_tax + $item_amount_tax_ret;// cantidad total del artículo = Cantidad del artículo libre de impuestos + impuesto a la cantidad del artículo + cantidad de artículo retiro de impuestos
                  $item_subtotal = $item_amount_untaxed; //libre de impuestos

                  //Sumatoria totales
                  $amount_subtotal += $item_subtotal_clean;
                  $amount_discount += $item_discount_clean;
                  $amount_untaxed += $item_subtotal;
                  $amount_tax += $item_amount_tax;
                  $amount_tax_ret += $item_amount_tax_ret;
                  $amount_total += $item_amount_total;

                  //Guardar linea -- Por cada anexo de contrato
                  $customer_invoice_line = CustomerInvoiceLine::create([
                      'created_uid' => \Auth::user()->id,
                      'updated_uid' => \Auth::user()->id,
                      'customer_invoice_id' => $customer_invoice->id,
                      'name' => $facturar_desc_all,
                      'contract_annex_id' => $key->contract_annex_id,
                      'sat_product_id' => $key->sat_product_id,
                      'unit_measure_id' => $key->unit_measure_id,
                      'quantity' => $item_quantity,
                      'price_unit' => $item_price_unit,
                      'discount' => $item_discount,
                      'price_reduce' => $item_price_reduce,
                      'amount_discount' => $item_amount_discount,
                      'amount_untaxed' => $item_amount_untaxed,
                      'amount_tax' => $item_amount_tax,
                      'amount_tax_ret' => $item_amount_tax_ret,
                      'amount_total' => $item_amount_total,
                      'sort_order' => $order,
                      'status' => 1,
                      'currency_id' => $item_currency_id,
                      'currency_value' => $item_currency_value,
                  ]);

                  $order++;
              }
              //Registros de cfdi
              $customer_invoice_cfdi = CustomerInvoiceCfdi::create([
                  'created_uid' => \Auth::user()->id,
                  'updated_uid' => \Auth::user()->id,
                  'customer_invoice_id' => $customer_invoice->id,
                  'name' => $customer_invoice->name,
                  'status' => 1,
              ]);
              //Actualiza registro principal con totales
              $customer_invoice->customer_id = $customer_general;
              $customer_invoice->amount_discount = $amount_discount;
              $customer_invoice->amount_untaxed = $amount_subtotal;
              $customer_invoice->amount_tax = $amount_tax;
              $customer_invoice->amount_tax_ret = $amount_tax_ret;
              $customer_invoice->amount_total = $amount_total;
              $customer_invoice->balance = $amount_total;
              $customer_invoice->update();

              $class_cfdi = setting('cfdi_version');
              if (empty($class_cfdi) || $class_cfdi === '0') {
                  throw new \Exception(__('general.error_cfdi_version'));
              }
              if (!method_exists($this, $class_cfdi)) {
                  throw new \Exception(__('general.error_cfdi_class_exists'));
              }
              //Valida Empresa y PAC para timbrado
              PacHelper::validateSatActions();
              //Crear XML y timbra
              $tmp = $this->$class_cfdi($customer_invoice);
              //Guardar registros de CFDI
              $customer_invoice_cfdi->fill(array_only($tmp,[
                  'pac_id',
                  'cfdi_version',
                  'uuid',
                  'date',
                  'file_xml',
                  'file_xml_pac',
              ]));
              $customer_invoice_cfdi->save();
            }
            // Commit the transaction
            DB::commit();
            return 'success';
        }
        catch (\Exception $e) {
            // An error occured; cancel the transaction...
            DB::rollback();
            // and throw the error again.
            // throw $e;
            return $e;
        }
    }
    public function set_cliente_contrato(Request $request)
    {
      $user_id= Auth::user()->id;
      $id_contrato= $request->id_contract;
      $id_cliente= $request->id_rz;

      $newId = DB::table('contract_masters')
      ->where('id', '=', $id_contrato )
      ->update([
           'rz_customer_id' => $id_cliente,
               'updated_at' => \Carbon\Carbon::now()]);
      if($newId == '0' ){
          return 'abort'; // returns 0
      }
      else {
          return $newId; // returns id
      }
    }
    public function test(Request $request)
    {
      $resultados_anexos = DB::select('CALL px_annexesXmaster_data (?, ?)', array(12, 1));
      $facturar_desc_all = $facturar_description.' '.$facturar_desc_month;
      $order = 1;
      foreach ($resultados_anexos as $key) {
          $item_quantity = 1;  //cantidad de artículo - default 1 un contrato anexo
        $item_price_unit = $key->monto; //unidad de precio del artículo
          $item_discount = 0; //descuento del artículo  - default 0 - NOTA: Aun no fijo el descuento

          $item_subtotal_quantity = round($item_price_unit * $item_quantity, 2);

          $item_price_reduce = ($item_price_unit * (100 - $item_discount) / 100); //Precio reducido
          $item_amount_untaxed = round($item_quantity * $item_price_reduce, 2); //libre de impuestos
          $item_amount_discount = round($item_quantity * $item_price_unit, 2) - $item_amount_untaxed;//descuento
          $item_amount_tax = 0;//impuesto a la cantidad del artículo
          $item_amount_tax_ret = 0;// cantidad de artículo retiro de impuestos

          //Tipo de cambio
          $item_currency_id = !empty($request->currency_id) ? $request->currency_id : 1;
          $item_currency_code = DB::table('currencies')->select('code_banxico')->where('id', $item_currency_id)->value('code_banxico');
          $item_currency_value = !empty($request->currency_value) ? $request->currency_value : 1;

          $item_subtotal_clean = $item_subtotal_quantity;
          $item_discount_clean = $item_amount_discount;
          $item_amount_total = $item_amount_untaxed + $item_amount_tax + $item_amount_tax_ret;// cantidad total del artículo = Cantidad del artículo libre de impuestos + impuesto a la cantidad del artículo + cantidad de artículo retiro de impuestos
          $item_subtotal = $item_amount_untaxed; //libre de impuestos

          //Sumatoria totales
          $amount_subtotal += $item_subtotal_clean;
          $amount_discount += $item_discount_clean;
          $amount_untaxed += $item_subtotal;
          $amount_tax += $item_amount_tax;
          $amount_tax_ret += $item_amount_tax_ret;
          $amount_total += $item_amount_total;

          //Guardar linea -- Por cada anexo de contrato
          $customer_invoice_line = CustomerInvoiceLine::create([
              'created_uid' => \Auth::user()->id,
              'updated_uid' => \Auth::user()->id,
              'customer_invoice_id' => $customer_invoice->id,
              'name' => $facturar_desc_all,
              'contract_annex_id' => $key->contract_annex_id,
              'sat_product_id' => $key->sat_product_id,
              'unit_measure_id' => $key->unit_measure_id,
              'quantity' => $item_quantity,
              'price_unit' => $item_price_unit,
              'discount' => $item_discount,
              'price_reduce' => $item_price_reduce,
              'amount_discount' => $item_amount_discount,
              'amount_untaxed' => $item_amount_untaxed,
              'amount_tax' => $item_amount_tax,
              'amount_tax_ret' => $item_amount_tax_ret,
              'amount_total' => $item_amount_total,
              'sort_order' => $order,
              'status' => 1,
              'currency_id' => $item_currency_id,
              'currency_value' => $item_currency_value,
          ]);

          $order++;
      }
      //Registros de cfdi
      $customer_invoice_cfdi = CustomerInvoiceCfdi::create([
          'created_uid' => \Auth::user()->id,
          'updated_uid' => \Auth::user()->id,
          'customer_invoice_id' => $customer_invoice->id,
          'name' => $customer_invoice->name,
          'status' => 1,
      ]);

      //Actualiza registro principal con totales
      $customer_invoice->amount_discount = $amount_discount;
      $customer_invoice->amount_untaxed = $amount_subtotal;
      $customer_invoice->amount_tax = $amount_tax;
      $customer_invoice->amount_tax_ret = $amount_tax_ret;
      $customer_invoice->amount_total = $amount_total;
      $customer_invoice->balance = $amount_total;
      $customer_invoice->update();

      $class_cfdi = setting('cfdi_version');
      if (empty($class_cfdi) || $class_cfdi === '0') {
          throw new \Exception(__('general.error_cfdi_version'));
      }
      if (!method_exists($this, $class_cfdi)) {
          throw new \Exception(__('general.error_cfdi_class_exists'));
      }
      //Valida Empresa y PAC para timbrado
      PacHelper::validateSatActions();
      //Crear XML y timbra
      $tmp = $this->$class_cfdi($customer_invoice);
      //Guardar registros de CFDI
      $customer_invoice_cfdi->fill(array_only($tmp,[
          'pac_id',
          'cfdi_version',
          'uuid',
          'date',
          'file_xml',
          'file_xml_pac',
      ]));
      $customer_invoice_cfdi->save();
      // Commit the transaction
      DB::commit();
      return 'success';
    }

    public function complement(){
      $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
      $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
      $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
      $cfdi_relations = DB::select('CALL GetAllCfdiRelationsv2 ()', array());
      $companies = DB::select('CALL px_companies_data ()', array());
      $companyname = $companies[0]->name;
      $companyrfc = $companies[0]->taxid;
      return view('permitted.sales.customer_invoices_complement',
      compact('sucursal','payment_way','currency','cfdi_relations','companyname','companyrfc'));
    }

    public function get_complement(){
      $complements = DB::select('CALL px_customer_invoices_data_saldo ()', array());
      //info($complements);
      return $complements;
    }
    public function store_complement(Request $request){
      //Logic
      info($request);

      try {
        //Logica
        $request->merge(['created_uid' => \Auth::user()->id]);
        $request->merge(['updated_uid' => \Auth::user()->id]);
        $request->merge(['status' => CustomerInvoice::OPEN]);
        //Ajusta fecha y genera fecha de vencimiento
        $date = Helper::createDateTime($request->date);
        $request->merge(['date' => Helper::dateTimeToSql($date)]);
        $date_due = $date; //La fecha de vencimiento por default
        $date_due_fix = $request->date_due;//Fix valida si la fecha de vencimiento esta vacia en caso de error
        if (!empty($request->date_due)) {
            $date_due = Helper::createDate($request->date_due);
        } else {
            $payment_term = PaymentTerm::findOrFail($request->payment_term_id);
            $date_due = $payment_term->days > 0 ? $date->copy()->addDays($payment_term->days) : $date->copy();
        }
        $request->merge(['date_due' => Helper::dateToSql($date_due)]);

        //Obtiene folio
        $document_type = Helper::getNextDocumentTypeByCode($this->document_type_code);
        $request->merge(['document_type_id' => $document_type['id']]);
        $request->merge(['name' => $document_type['name']]);
        $request->merge(['serie' => $document_type['serie']]);
        $request->merge(['folio' => $document_type['folio']]);

        //Guardar Registro principal
        $customer_invoice = CustomerInvoice::create($request->input());

        //ERASED...

        //Cfdi relacionados
        if (!empty($request->item_relation)) {
            foreach ($request->item_relation as $key => $result) {
                //Guardar
                $customer_invoice_relation = CustomerInvoiceRelation::create([
                    'created_uid' => \Auth::user()->id,
                    'updated_uid' => \Auth::user()->id,
                    'customer_invoice_id' => $customer_invoice->id,
                    'relation_id' => $result['relation_id'],
                    'sort_order' => $key,
                    'status' => 1,
                ]);
            }
        }

        //Registros de cfdi
        $customer_invoice_cfdi = CustomerInvoiceCfdi::create([
            'created_uid' => \Auth::user()->id,
            'updated_uid' => \Auth::user()->id,
            'customer_invoice_id' => $customer_invoice->id,
            'name' => $customer_invoice->name,
            'status' => 1,
        ]);

      } catch(\Exception $e) {
        $request->merge([
              'date' => Helper::convertSqlToDateTime($request->date),
        ]);
        if (!empty($date_due_fix)) {
              $request->merge([
                  'date_due' => Helper::convertSqlToDate($request->date_due),
              ]);
        }else{
              $request->merge([
                  'date_due' => '',
              ]);
        }
        // An error occured; cancel the transaction...
        DB::rollback();

        // and throw the error again.
        // throw $e;
        return $e;
        // return __('general.error_cfdi_pac');
      }

      return "success";
    }

    public function tes()
    {
        $contract_id = 1;
        $all_information_anexos = DB::select('CALL px_contract_annexes_data (?)', array($contract_id));
        $facturar_pay_way = $all_information_anexos[0]->payment_term_id;
        $facturar_pay_way = $all_information_anexos[0]->payment_way_id;
        $facturar_pay_met = $all_information_anexos[0]->payment_method_id;
        $facturar_cfdi_use = $all_information_anexos[0]->cfdi_user_id;
    }

}
