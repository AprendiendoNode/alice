<?php

namespace App\Http\Controllers\Sales;
use Auth;
use DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Cfdi33Helper;
use App\Helpers\Helper;
use App\Helpers\PacHelper;

use App\Models\Base\BranchOffice;
use App\Models\Base\Company;
use App\Models\Base\CompanyBankAccount;
use App\Models\Base\Pac;
use App\Models\Catalogs\CfdiRelation;
use App\Models\Catalogs\Currency;
use App\Models\Catalogs\PaymentWay;
use App\Models\Sales\CustomerBankAccount;
use App\Models\Sales\CustomerPayment;
use App\Models\Sales\CustomerPaymentCfdi;
use App\Models\Sales\CustomerPaymentReconciled;
use App\Models\Sales\CustomerPaymentRelation;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use App\Models\Base\Setting;
use Jenssegers\Date\Date;
use Faker\Factory as Faker;

use anlutro\LaravelSettings\SettingStore;
use Illuminate\Support\Facades\Schema;

use \CfdiUtils\XmlResolver\XmlResolver;
use \CfdiUtils\CadenaOrigen\DOMBuilder;

use App\ConvertNumberToLetters;
use App\Models\Sales\CustomerInvoice;
use App\Models\Sales\CustomerInvoiceCfdi;
use App\Models\Sales\CustomerInvoiceLine;
use App\Models\Sales\CustomerInvoiceRelation;
use App\Models\Sales\CustomerInvoiceTax;
use Mail;

class CustomerPaymentController extends Controller
{
    private $list_status = [];
    private $tipo_cadena_pagos = [];
    private $document_type_code = 'customer.payment';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->list_status = [
            CustomerPayment::OPEN => __('customer_payment.text_status_open'),
            CustomerPayment::RECONCILED => __('customer_payment.text_status_reconciled'),
            CustomerPayment::CANCEL => __('customer_payment.text_status_cancel'),
        ];
        $this->tipo_cadena_pagos = ['01'=>'SPEI'];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
        $customer = DB::select('CALL px_only_customer_data ()', array());
        $company_bank_accounts =  DB::select('CALL px_accounts_banks_company ()', array());
       
        $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
        $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
        $list_status = $this->list_status;
        $tipo_cadena_pagos = $this->tipo_cadena_pagos;
        $cfdi_relations = DB::select('CALL GetAllCfdiRelationsv2 ()', array());
        $payment_methods = DB::select('CALL GetAllPaymentMethodsv2 ()', array());          

        return view('permitted.sales.customer_payments',
        compact('customer', 'payment_way', 'company_bank_accounts', 'payment_methods',
        'currency', 'sucursal', 'tipo_cadena_pagos', 'cfdi_relations', 'list_status'));
    }

    public function search(Request $request)
    {
      $input_date_from= !empty($request->filter_date_from) ? $request->filter_date_from : Helper::date(\Date::parse('first day of this month'));
      $input_date_to= !empty($request->filter_date_to) ? $request->filter_date_to : Helper::date(\Date::parse('last day of this month'));

      $input_pay_way = !empty($request->filter_payment_way_id) ? $request->filter_payment_way_id : 0;
      $input_customer = !empty($request->customer_id) ? $request->customer_id  : 0;
      $input_brand_office = !empty($request->filter_branch_office_id) ? $request->filter_branch_office_id : 0;
      $input_filter = !empty($request->filter_status) ? $request->filter_status : 0;
      $input_folio = !empty($request->filter_name) ? $request->filter_name : '';

      $resultados = array();
      $estatus = array("2", "3", "4");
      $monedatxt = array("MXN - Peso Mexicano", "USD - US Dollar", "DOP - Peso dominicano", "CRC - Colon Costarricense");
      $paymentwaytxt = array("Efectivo", "Transferencia electrónica de fondos", "Tarjeta de crédito", "Por definir");
      /*
      for ($i=1; $i <= 5; $i++) {
        $estado = array_rand($estatus, 1);
        $moneda = array_rand($monedatxt, 1);
        $paymentway = array_rand($paymentwaytxt, 1);

        $faker = Faker::create();
        $iteracion_random = rand(1, 3);
        $mail_estado = rand(0, 1);
        $numfolio = rand(100, 200);

        $year = rand(2019, 2020);
        $month = rand(1, 12);
        $day = rand(1, 28);
        $date_one = Carbon::create($year,$month ,$day , 0, 0, 0);

        array_push($resultados,
          array(
            "id" => $faker->numberBetween(1,100),
            "folio" => 'fasa-'.$numfolio,
            "date" => $date_one,
            "date_payment" => now(),
            "amount" => $faker->numberBetween(1000,20000),
            "balance" => $faker->numberBetween(100,20000),
            "status" => $estatus[$estado],
            "mail_sent" => $mail_estado,
            "uuid" => $faker->numberBetween(10000,20000).'-'.$faker->numberBetween(20000,30000).'-'.$faker->numberBetween(30000,40000).'-'.$faker->numberBetween(40000,50000),
            "customer" => $faker->firstNameMale,
            "payment_way" => ucfirst($paymentwaytxt[$paymentway]),
            "currency" => ucfirst($monedatxt[$moneda]),
          )
        );
      }
      return json_encode($resultados);
      */

      $date_a = Carbon::parse($input_date_from)->format('Y-m-d');
      $date_b = Carbon::parse($input_date_to)->format('Y-m-d');

      $result = DB::select('CALL px_customer_payments_filters (?,?,?,?,?,?,?)',
       array($date_a, $date_b, $input_folio, $input_pay_way, $input_customer, $input_brand_office, $input_filter) );
      return json_encode($result);
    }
    /**
     * Cambiar estatus a enviada
     *
     * @param CustomerPayment $customer_payment
     *
     */
    public function markSent(Request $request)
    {
      $id = $request->token_b;
      $customer_payment = CustomerPayment::findOrFail($id);
      //Logica
      if ((int)$customer_payment->mail_sent != 1) {
        $customer_payment->updated_uid = \Auth::user()->id;
        $customer_payment->mail_sent = 1;
        $customer_payment->save();
        return response()->json(['status' => 200]);
      }
      else {
        return response()->json(['status' => 304]);
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
        $customer_payment = CustomerPayment::findOrFail($id);
        //Logica
        if ($request->ajax() && !empty($id)) {
            //Correo default del cliente
            $to = [];
            $to_selected = [];
            if (!empty($customer_payment->customer->email)) {
                $email = $customer_payment->customer->email;
                $email = explode(";", $email);

                $to_selected [] = $email;
            }
            //Etiquetas solo son demostrativas
            $files = [
                'pdf' => $customer_payment->name . '.pdf',
                'xml' => $customer_payment->name . '.xml'
            ];
            $files_selected = array_keys($files);


            $a3 = '<b>Le remitimos adjunta la siguiente factura:</b>'.'<br>';
            $a2 = $customer_payment->name;
            $a1 = Helper::convertSqlToDateTime($customer_payment->date);
            $a0 = '<br>';


            $data_result = [
                'customer_invoice' => $customer_payment,
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
     * Cambiar estatus a abierta
     *
     * @param CustomerPayment $customer_payment
     *
     */
    public function markOpen(Request $request)
    {
      $id = $request->token_b;
      $customer_payment = CustomerPayment::findOrFail($id);
      //Logica.
      if ((int)$customer_payment->status == CustomerPayment::RECONCILED) {
        $customer_payment->updated_uid = \Auth::user()->id;
        $customer_payment->status = CustomerPayment::OPEN;
        $customer_payment->save();
        return response()->json(['status' => 200]);
      }
      else {
        return response()->json(['status' => 304]);
      }
    }

    /**
     * Cambiar estatus a reconciliada
     *
     * @param CustomerPayment $customer_payment
     *
     */
    public function markReconciled(Request $request)
    {
      $id = $request->token_b;
      $customer_payment = CustomerPayment::findOrFail($id);
      if ((int)$customer_payment->status == CustomerPayment::OPEN) {
        $customer_payment->updated_uid = \Auth::user()->id;
        $customer_payment->status = CustomerPayment::RECONCILED;
        $customer_payment->save();
        return response()->json(['status' => 200]);
      }
      else {
        return response()->json(['status' => 304]);
      }
    }

    /**
     * Modal para estatus de CFDI
     *
     */
    public function modalStatusSat(Request $request)
    {
      //Variables
      $id = $request->token_b;
      $company = Helper::defaultCompany(); //Empresa
      /* PRUEBAS
        ------------------------------------------------------------------------
        $data_result = [
          'folio' => 'fasa-146',
          'uuid' => '13990-27244-31721-43378',
          'is_cancelable_cfdi' => 'Pruebas',
          'status_cfdi' => 'Pruebas',
        ];
        return $data_result;
        ------------------------------------------------------------------------
      */
      $customer_payment = CustomerPayment::findOrFail($id);
      //Logica
      if ($request->ajax() && !empty($id)) {
        //Obtener informacion de estatus
        $data_status_sat = [
          'cancelable' => 1,
          'pac_is_cancelable' => ''
        ];
        if (!empty($customer_payment->customerPaymentCfdi->cfdi_version) && !empty($customer_payment->customerPaymentCfdi->uuid)) {
          $tmp = [
              'rfcR' => $customer_payment->customer->taxid,
              'uuid' => $customer_payment->customerPaymentCfdi->uuid,
              'total' => Helper::numberFormat($customer_payment->amount_total, $customer_payment->currency->decimal_place, false),
          ];
          $class_pac = $customer_payment->customerPaymentCfdi->pac->code . 'Status';
          $data_status_sat = PacHelper::$class_pac($tmp,$customer_payment->customerPaymentCfdi->pac);
        }
        $is_cancelable = true;
        if($data_status_sat['cancelable'] == 3){
            $is_cancelable = false;
        }
        //modal de visualizar estatus en el SAT
        $data_result = [
          'folio' => $customer_payment->folio,
          'uuid' => $customer_payment->customerPaymentCfdi->uuid,
          'is_cancelable_cfdi' => $data_status_sat,
          'status_cfdi' => $is_cancelable,
          'text_is_cancelable_cfdi' => !empty($data_status_sat['pac_is_cancelable']) ? $data_status_sat['pac_is_cancelable'] : '&nbsp;',
          'text_status_cfdi' => !empty($data_status_sat['pac_status']) ? $data_status_sat['pac_status'] : '&nbsp;'
        ];
        return $data_result;
      }
    }

    /**
     *
     * Modal para cancelar pago
     *
     */
    public function destroy(Request $request)
    {
      \DB::beginTransaction();
      try {
        $id = $request->token_b;
        $customer_payment = CustomerPayment::findOrFail($id);
        //Logica
        if ((int)$customer_payment->status != CustomerPayment::CANCEL) {
            //Actualiza status
            $customer_payment->updated_uid = \Auth::user()->id;
            $customer_payment->status = CustomerPayment::CANCEL;
            $customer_payment->save();
            //Actualiza saldos de facturas
            if($customer_payment->customerPaymentReconcileds->isNotEmpty()){
                foreach($customer_payment->customerPaymentReconcileds as $result){
                    //Datos de factura
                    $customer_invoice = CustomerInvoice::findOrFail($result->reconciled_id);
                    //Actualiza el saldo de la factura relacionada
                    $customer_invoice->balance += round(Helper::invertBalanceCurrency($customer_payment->currency,$result->amount_reconciled,$customer_invoice->currency->code,$result->currency_value),2);
                    if($customer_invoice->balance > 0){
                        $customer_invoice->status = CustomerInvoice::OPEN;
                    }
                    $customer_invoice->save();
                }
            }
            //Actualiza status CFDI
            $customer_payment->customerPaymentCfdi->status = 0;
            $customer_payment->customerPaymentCfdi->save();
            //Cancelacion del timbre fiscal
            if (!empty($customer_payment->customerPaymentCfdi->cfdi_version) && !empty($customer_payment->customerPaymentCfdi->uuid)) {
                //Valida Empresa y PAC para cancelar timbrado
                PacHelper::validateSatCancelActions($customer_payment->customerPaymentCfdi->pac);
                //Arreglo temporal para actualizar Customer Invoice CFDI
                $tmp = [
                    'cancel_date' => Helper::dateTimeToSql(\Date::now()),
                    'cancel_response' => '',
                    'cancel_state' => '',
                    'rfcR' => $customer_payment->customer->taxid,
                    'uuid' => $customer_payment->customerPaymentCfdi->uuid,
                    'total' => Helper::numberFormat($customer_payment->amount,
                        $customer_payment->currency->decimal_place, false),
                ];
                //Cancelar Timbrado de XML
                $class_pac = $customer_payment->customerPaymentCfdi->pac->code . 'Cancel';
                $tmp = PacHelper::$class_pac($tmp,$customer_payment->customerPaymentCfdi->pac);
                //Guardar registros de CFDI
                $customer_payment->customerPaymentCfdi->fill(array_only($tmp,[
                    'cancel_date',
                    'cancel_response',
                    'cancel_state',
                ]));
                $customer_payment->customerPaymentCfdi->save();
            }
        }
        \DB::commit();
        return response()->json(['status' => 200]);
      }
      catch (\Exception $e) {
        DB::rollback();
        return response()->json(['error' => $e]);
      }
    }
    /**
     * Descarga de archivo XML
     *
     * @param Request $request
     * @param CustomerPayment $customer_payment
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadXml(Request $request)
    {
        $customer_payment = CustomerPayment::findOrFail($id);
        //Ruta y validacion del XML
        $path_xml = Helper::setDirectory(CustomerPayment::PATH_XML_FILES) . '/';
        $file_xml_pac = $path_xml . $customer_payment->customerPaymentCfdi->file_xml_pac;
        if (!empty($file_xml_pac)) {
            if (\Storage::exists($file_xml_pac)) {
                return response()->download(\Storage::path($file_xml_pac), $customer_payment->name . '.xml');
            }
        }
    }
    /**
     * Descarga de archivo XML
     *
     * @param Request $request
     * @param CustomerPayment $customer_payment
     *
     */
    public function generatePdf($id)
    {
      $customer_payment = CustomerPayment::findOrFail($id);
      $companies = DB::select('CALL px_companies_data ()', array());
      $data = [];
      //Si tiene CFDI obtiene la informacion de los nodos
      if(!empty($customer_payment->customerPaymentCfdi->file_xml_pac) && !empty($customer_payment->customerPaymentCfdi->uuid)){
        $path_xml = Helper::setDirectory(CustomerPayment::PATH_XML_FILES) . '/';
        $file_xml_pac = $path_xml . $customer_payment->customerPaymentCfdi->file_xml_pac;
        //Valida que el archivo exista
        if(\Storage::exists($file_xml_pac)) {
            $cfdi = \CfdiUtils\Cfdi::newFromString(\Storage::get($file_xml_pac));
            $data = Cfdi33Helper::getQuickArrayCfdi($cfdi);
            //Genera codigo QR
            $image = QrCode::format('png')->size(150)->margin(0)->generate($data['qr_cadena']);
            $data['qr'] = 'data:image/png;base64,' . base64_encode($image);
        }
      }
      // Enviando datos a la vista de la factura
      $pdf = PDF::loadView('permitted.invoicing.invoice_sitwifi_compPago',compact('companies', 'customer_payment', 'data'));
      return $pdf->stream();
    }

    public function get_pdf_xml_files($id)
    {
      $customer_payment = CustomerPayment::findOrFail($id);
      $companies = DB::select('CALL px_companies_data ()', array());
      $data = [];
      //Si tiene CFDI obtiene la informacion de los nodos
      if(!empty($customer_payment->customerPaymentCfdi->file_xml_pac) && !empty($customer_payment->customerPaymentCfdi->uuid)){
        $path_xml = Helper::setDirectory(CustomerPayment::PATH_XML_FILES) . '/';
        $file_xml_pac = $path_xml . $customer_payment->customerPaymentCfdi->file_xml_pac;
        //Valida que el archivo exista
        if(\Storage::exists($file_xml_pac)) {
            $cfdi = \CfdiUtils\Cfdi::newFromString(\Storage::get($file_xml_pac));
            $data = Cfdi33Helper::getQuickArrayCfdi($cfdi);
            //Genera codigo QR
            $image = QrCode::format('png')->size(150)->margin(0)->generate($data['qr_cadena']);
            $data['qr'] = 'data:image/png;base64,' . base64_encode($image);
        }
      }
      // Enviando datos a la vista de la factura
      $pdf = PDF::loadView('permitted.invoicing.invoice_sitwifi_compPago',compact('companies', 'customer_payment', 'data'));

      $xml = Storage::get($file_xml_pac);

      $files = array(
        "pdf" => $pdf,
        "xml" => $xml,
      );

      return $files;

    }
    /**
     * Autoacompletar select2 de facturas solo activas del SAT
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function autocompleteCfdi(Request $request)
    {
        //Variables
        $term = !empty($request->term) ? $request->term : '';
        $customer_id = !empty($request->customer_id) ? $request->customer_id : '111111111111'; //Filtra las facturas por cliente
        //Logica
        if ($request->ajax()) {
            $tmp = CustomerPayment::filter([
                'filter_search_cfdi_select2' => $term,
                'filter_customer_id' => $customer_id
            ])->orderBy('date')->get();
            //->sortable('date')->limit(16)->get();
            $results = [];
            if ($tmp->isNotEmpty()) {
                foreach ($tmp as $result) {
                    $results[] = [
                        'id' => $result->id,
                        'text' => $result->name,
                        'description' => $result->description_select2
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
    public function getCustomerPayment(Request $request)
    {
        //Variables
        $id = $request->id;

        //Logica
        if ($request->ajax() && !empty($id)) {
            $customer_payment = CustomerPayment::findOrFail($id);
            $customer_payment->uuid = $customer_payment->customerPaymentCfdi->uuid ?? '';
            return response()->json($customer_payment, 200);
        }
        return response()->json(['error' => 'Error'], 422);
    }

    /**
     * Calcula el total de las lineas
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function totalReconciledLines(Request $request)
    {
      //Variables
      $json = new \stdClass;
      $input_items_reconciled = $request->item_reconciled;
      $currency_code = 'MXN';
      if ($request->ajax()) {
        //Datos de moneda
        if (!empty($request->currency_id)) {
          $currency = Currency::findOrFail($request->currency_id);
          $currency_code = $currency->code;
        }
        //Variables de totales
        $amount = (double)$request->amount;
        $amount_reconciled = !empty($request->amount_reconciled) ? (double)$request->amount_reconciled : 0;
        $amount_per_reconciled = 0;
        $items_reconciled = [];
        $monto_conciliado = [];
        $flag_concepts = [];

        if (!empty($input_items_reconciled)) {
          foreach ($input_items_reconciled as $key => $item_reconciled) {
            //Logica
            $item_reconciled_balance = (double)$item_reconciled['balance'];
            $item_reconciled_currency_value = !empty($item_reconciled['currency_value']) ? round((double)$item_reconciled['currency_value'],4) : null;
            $items_reconciled[$key] = Helper::convertBalanceCurrency($currency,$item_reconciled_balance,$item_reconciled['currency_code'],$item_reconciled_currency_value);

            if ((double)$item_reconciled['amount_reconciled'] > $items_reconciled[$key]) {
              $amount_reconciled += (double)$item_reconciled['balance'];

              // $item_reconciled_balance = (double)$item_reconciled['balance'];
              // $item_reconciled_currency_value = !empty($item_reconciled['currency_value']) ? round((double)$item_reconciled['currency_value'],4) : null;
              // $items_reconciled[$key] = Helper::convertBalanceCurrency($currency,$item_reconciled_balance,$item_reconciled['currency_code'],$item_reconciled_currency_value);

              $monto_conciliado[$key] = (double)$item_reconciled['balance'];
              $flag_concepts[$key] = 0;
            }else{
              $amount_reconciled += (double)$item_reconciled['amount_reconciled'];

              if ($amount_reconciled > $amount) {
                $amount_reconciled -= (double)$item_reconciled['amount_reconciled'];
                $monto_conciliado[$key] = 0;
              }else{
                $monto_conciliado[$key] = (double)$item_reconciled['amount_reconciled'];
              }
              $flag_concepts[$key] = 1;

              // $item_reconciled_balance = (double)$item_reconciled['balance'];
              // $item_reconciled_currency_value = !empty($item_reconciled['currency_value']) ? round((double)$item_reconciled['currency_value'],4) : null;
              // $items_reconciled[$key] = Helper::convertBalanceCurrency($currency,$item_reconciled_balance,$item_reconciled['currency_code'],$item_reconciled_currency_value);
            }
          }
        }
        //Respuesta
        $json->monto_conciliado = $monto_conciliado;
        $json->flag_concepts = $flag_concepts;
        $json->items_reconciled = $items_reconciled;
        $json->amount = $amount;
        $json->amount_reconciled = $amount_reconciled;
        $json->amount_per_reconciled = $amount - $amount_reconciled;
        return response()->json($json);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_validation(Request $request)
    {
       //Busco la moneda
       $currency = Currency::findOrFail($request->currency_id);
       //Valida que la moneda de la cuenta bancaria sea igual a la de pago
       if(!empty($request->company_bank_account_id)) {
           $company_bank_account = CompanyBankAccount::findOrFail($request->company_bank_account_id);
           if ($company_bank_account->currency->code != $currency->code) {
             return 'error1';
             // return  __('customer_payment.error_currency_id_company_bank_account_id')
           }
           //Valida que el patron de la cuenta beneficiaria coincida con el patron de la forma de pago solo para CFDI
           $payment_way = PaymentWay::findOrFail($request->payment_way_id);
           if(!empty($payment_way->patron_cuenta_beneficiaria)){
             if(!preg_match('/^('.$payment_way->patron_cuenta_beneficiaria.')$/',$company_bank_account->account_number)){
               return 'error2';
               // return __('customer_payment.error_pattern_account_company_bank_account_id');
             }
           }
       }
       //Valida que la moneda de la cuenta bancaria sea igual a la de pago
       if(!empty($request->customer_bank_account_id)) {
           $customer_bank_account = CustomerBankAccount::findOrFail($request->customer_bank_account_id);
           if ($customer_bank_account->currency->code != $currency->code) {
             return 'error3';
             // return __('customer_payment.error_currency_id_customer_bank_account_id');
           }
           //Valida que el patron de la cuenta beneficiaria coincida con el patron de la forma de pago solo para CFDI
           $payment_way = PaymentWay::findOrFail($request->payment_way_id);
           if(!empty($payment_way->patron_cuenta_ordenante)){
             if(!preg_match('/^('.$payment_way->patron_cuenta_ordenante.')$/',$customer_bank_account->account_number)){
               return 'error4';
               // return __('customer_payment.error_pattern_account_customer_bank_account_id');
             }
           }
       }
       //Valida que el monto total de las lineas no supere al pago
       $amount = (double)$request->amount;
       $amount_reconciled = 0;
       if (!empty($request->item_reconciled)) {
        foreach ($request->item_reconciled as $key => $item_reconciled) {
          if (!empty($item_reconciled['amount_reconciled'])) {
            $item_reconciled_amount_reconciled = round((double)$item_reconciled['amount_reconciled'],2);
            $item_reconciled_currency_value = !empty($item_reconciled['currency_value']) ? round((double)$item_reconciled['currency_value'],4) : null;
            $amount_reconciled += $item_reconciled_amount_reconciled;
            //Valida que el monto conciliado no supere el saldo de la factura
            $currency = Currency::findOrFail($request->currency_id);
            $customer_invoice = CustomerInvoice::findOrFail($item_reconciled['reconciled_id']);
            $tmp = round(Helper::invertBalanceCurrency($currency,$item_reconciled_amount_reconciled,$customer_invoice->currency->code,$item_reconciled_currency_value),2);
            if($tmp > $customer_invoice->balance){
              return 'error5';
              // return __('customer_payment.error_reconciled_amount_reconciled_customer_invoice_balance');
            }
          }
        }
       }
       $manual_amount_reconciled = 0;
       //Validacion de las facturas sin registro
       if (!empty($request->item_manual_reconciled)) {
         foreach ($request->item_manual_reconciled as $key => $item) {
           if (!empty($item['amount_reconciled'])) {
             $item_amount_reconciled = round((double)$item['amount_reconciled'],2);
             $manual_amount_reconciled += $item_amount_reconciled;
           }
         }
       }
       $amount_all = $amount_reconciled+$manual_amount_reconciled;
       //Valida que el monto conciliado no supere el monto del pago
       if($amount_all > $amount){
         return 'error6';
         // return  __('customer_payment.error_amount_amount_reconciled');
       }

    }
    public function store(Request $request)
    {
      //Validacion
      $cfdi = !empty($request->cfdi) ? 1 : 1;

      \DB::beginTransaction();
      try {
        //Validaciones--------------
        //Busco la moneda
        $currency = Currency::findOrFail($request->currency_id);
        //Valida que la moneda de la cuenta bancaria sea igual a la de pago
        if(!empty($request->company_bank_account_id)) {
            $company_bank_account = CompanyBankAccount::findOrFail($request->company_bank_account_id);
            if ($company_bank_account->currency->code != $currency->code) {
              return 'error1';
              // return  __('customer_payment.error_currency_id_company_bank_account_id')
            }
            //Valida que el patron de la cuenta beneficiaria coincida con el patron de la forma de pago solo para CFDI
            $payment_way = PaymentWay::findOrFail($request->payment_way_id);
            if(!empty($payment_way->patron_cuenta_beneficiaria)){
              if(!preg_match('/^('.$payment_way->patron_cuenta_beneficiaria.')$/',$company_bank_account->account_number)){
                return 'error2';
                // return __('customer_payment.error_pattern_account_company_bank_account_id');
              }
            }
        }
        //Valida que la moneda de la cuenta bancaria sea igual a la de pago
        if(!empty($request->customer_bank_account_id)) {
            $customer_bank_account = CustomerBankAccount::findOrFail($request->customer_bank_account_id);
            if ($customer_bank_account->currency->code != $currency->code) {
              return 'error3';
              // return __('customer_payment.error_currency_id_customer_bank_account_id');
            }
            //Valida que el patron de la cuenta beneficiaria coincida con el patron de la forma de pago solo para CFDI
            $payment_way = PaymentWay::findOrFail($request->payment_way_id);
            if(!empty($payment_way->patron_cuenta_ordenante)){
              if(!preg_match('/^('.$payment_way->patron_cuenta_ordenante.')$/',$customer_bank_account->account_number)){
                return 'error4';
                // return __('customer_payment.error_pattern_account_customer_bank_account_id');
              }
            }
        }
        //Valida que el monto total de las lineas no supere al pago
        $amount = (double)$request->amount;
        $amount_reconciled = 0;
        if (!empty($request->item_reconciled)) {
         foreach ($request->item_reconciled as $key => $item_reconciled) {
           if (!empty($item_reconciled['amount_reconciled'])) {
             $item_reconciled_amount_reconciled = round((double)$item_reconciled['amount_reconciled'],2);
             $item_reconciled_currency_value = !empty($item_reconciled['currency_value']) ? round((double)$item_reconciled['currency_value'],4) : null;
             $amount_reconciled += $item_reconciled_amount_reconciled;
             //Valida que el monto conciliado no supere el saldo de la factura
             $currency = Currency::findOrFail($request->currency_id);
             $customer_invoice = CustomerInvoice::findOrFail($item_reconciled['reconciled_id']);
             $tmp = round(Helper::invertBalanceCurrency($currency,$item_reconciled_amount_reconciled,$customer_invoice->currency->code,$item_reconciled_currency_value),2);
             if($tmp > $customer_invoice->balance){
               return 'error5';
               // return __('customer_payment.error_reconciled_amount_reconciled_customer_invoice_balance');
             }
           }
         }
        }
        $manual_amount_reconciled = 0;
        //Validacion de las facturas sin registro
        if (!empty($request->item_manual_reconciled)) {
          foreach ($request->item_manual_reconciled as $key => $item) {
            if (!empty($item['amount_reconciled'])) {
              $item_amount_reconciled = round((double)$item['amount_reconciled'],2);
              $manual_amount_reconciled += $item_amount_reconciled;
            }
          }
        }
        $amount_all = $amount_reconciled+$manual_amount_reconciled;
        //Valida que el monto conciliado no supere el monto del pago
        if($amount_all > $amount){
          return 'error6';
          // return  __('customer_payment.error_amount_amount_reconciled');
        }
        //Logica
        $request->merge(['created_uid' => \Auth::user()->id]);
        $request->merge(['updated_uid' => \Auth::user()->id]);
        $request->merge(['status' => CustomerPayment::OPEN]);
        $request->merge(['cfdi' =>  $cfdi]);
        //Ajusta fecha y genera fecha de vencimiento
        $date = Helper::createDateTime($request->date);
        $request->merge(['date' => Helper::dateTimeToSql($date)]);
        if (!empty($request->date_payment)) {
          $date_payment = Helper::createDateTime($request->date_payment);
          $request->merge(['date_payment' => Helper::dateTimeToSql($date_payment)]);
        }
        //Obtiene folio
        $document_type = Helper::getNextDocumentTypeByCode('customer.payment');
        $request->merge(['document_type_id' => $document_type['id']]);
        $request->merge(['name' => $document_type['name']]);
        $request->merge(['serie' => $document_type['serie']]);
        $request->merge(['folio' => $document_type['folio']]);
        //Guardar
        //Registro principal
        $customer_payment = CustomerPayment::create($request->input());
        //Facturas conciliadas
        $amount = (double)$request->amount;
        $amount_reconciled = 0;
        $count = 1; //Contador de lineas
        //Lineas
        if (!empty($request->item_reconciled)) {
          foreach ($request->item_reconciled as $key => $item_reconciled) {
            if(!empty($item_reconciled['amount_reconciled'])) {
              //Datos de factura
              $customer_invoice = CustomerInvoice::findOrFail($item_reconciled['reconciled_id']);
              //Logica
              $item_reconciled_amount_reconciled = round((double)$item_reconciled['amount_reconciled'],2);
              $amount_reconciled += $item_reconciled_amount_reconciled;
              $item_reconciled_currency_value = !empty($item_reconciled['currency_value']) ? round((double)$item_reconciled['currency_value'],4) : null;
              //Convertimos el monto aplicado si la moneda del documento es diferente a la de pago
              $item_reconciled_amount_reconciled = round(Helper::invertBalanceCurrency($customer_payment->currency,$item_reconciled_amount_reconciled,$customer_invoice->currency->code,$item_reconciled_currency_value),2);

              $se_timbra = DB::table('payment_ways')->where('id', $customer_invoice->payment_way_id)->value('timbrado');

              if ($se_timbra != 1 ) {
                throw new \Exception("Este documento no se puede timbrar por la forma de pago.");
              }
              //Guardar linea
              $customer_payment_reconciled = CustomerPaymentReconciled::create([
                'created_uid' => \Auth::user()->id,
                'updated_uid' => \Auth::user()->id,
                'customer_payment_id' => $customer_payment->id,
                'name' => $customer_invoice->name,
                'reconciled_id' => $customer_invoice->id,
                'currency_value' => $item_reconciled_currency_value,
                'amount_reconciled' => $item_reconciled_amount_reconciled,
                'last_balance' => $customer_invoice->balance,
                'sort_order' => $count,
                'status' => 1,
                'uuid_related' => $customer_invoice->customerInvoiceCfdi->uuid,
                'serie_related' => $customer_invoice->serie,
                'folio_related' => $customer_invoice->folio,
                'currency_code_related' => $customer_invoice->currency->code,
                'payment_method_code_related' => $customer_invoice->paymentMethod->code,
                'current_balance' => $customer_invoice->balance - $item_reconciled_amount_reconciled,
              ]);

              $tmp_customer_payment_reconciled = CustomerPaymentReconciled::where('status', '=', '1')
                  ->where('reconciled_id', '=', $customer_invoice->id)
                  ->where(function ($query) {
                      $query->WhereHas('customerPayment', function ($q) {
                          $q->whereIn('customer_payments.status',
                              [CustomerPayment::OPEN, CustomerPayment::RECONCILED]);
                      });
                  });
              $customer_payment_reconciled->number_of_payment = $tmp_customer_payment_reconciled->count(); //Guarda el numero de parcialidad
              $customer_payment_reconciled->save();
              //Actualiza el saldo de la factura relacionada
              $customer_invoice->balance -= $item_reconciled_amount_reconciled;
              if($customer_invoice->balance <= 0){
                  $customer_invoice->status = CustomerInvoice::PAID;
              }
              $customer_invoice->save();
            }
          }
        }
        //Facturas manuales
        //Lineas
        if (!empty($request->item_manual_reconciled)) {
          foreach ($request->item_manual_reconciled as $key => $item_reconciled) {
            if(!empty($item_reconciled['amount_reconciled'])) {
              //Logica
              $item_reconciled_amount_reconciled = round((double)$item_reconciled['amount_reconciled'],2);
              $item_reconciled_currency_value = !empty($item_reconciled['currency_value']) ? round((double)$item_reconciled['currency_value'],4) : null;
              if(!empty($item_reconciled_currency_value)){
                  $amount_reconciled += $item_reconciled_amount_reconciled * $item_reconciled_currency_value;
              }else{
                  $amount_reconciled += $item_reconciled_amount_reconciled;
              }
              //Guardar linea
              $customer_payment_reconciled = CustomerPaymentReconciled::create([
                  'created_uid' => \Auth::user()->id,
                  'updated_uid' => \Auth::user()->id,
                  'customer_payment_id' => $customer_payment->id,
                  'name' => $item_reconciled['serie_related'].$item_reconciled['folio_related'],
                  'reconciled_id' => null,
                  'currency_value' => $item_reconciled_currency_value,
                  'amount_reconciled' => $item_reconciled_amount_reconciled,
                  'number_of_payment' => $item_reconciled['number_of_payment'],
                  'last_balance' => $item_reconciled['last_balance'],
                  'sort_order' => $count,
                  'status' => 1,
                  'uuid_related' => $item_reconciled['uuid_related'],
                  'serie_related' => $item_reconciled['serie_related'],
                  'folio_related' => $item_reconciled['folio_related'],
                  'currency_code_related' => DB::table('currencies')->where('id', $item_reconciled['currency_code_related'])->value('code'),
                  'payment_method_code_related' => DB::table('payment_methods')->where('id', $item_reconciled['payment_method_code_related'])->value('code'),
                  'current_balance' => $item_reconciled['current_balance'],
              ]);
              $count++;
            }
          }
        }
        //Cfdi relacionados
        if (!empty($request->item_relation)) {
          foreach ($request->item_relation as $key => $result) {
            $customer_payment_cfdi_relation = CustomerPaymentCfdi::where('customer_payment_id','=',$result['relation_id'])->first();

            //Guardar
            $customer_payment_relation = CustomerPaymentRelation::create([
              'created_uid' => \Auth::user()->id,
              'updated_uid' => \Auth::user()->id,
              'customer_payment_id' => $customer_payment->id,
              'relation_id' => $result['relation_id'],
              'sort_order' => $key,
              'status' => 1,
              'uuid_related' => !empty($customer_payment_cfdi_relation) ? $customer_payment_cfdi_relation->uuid : '',
            ]);
          }
        }
        //Registros de cfdi
        $customer_payment_cfdi = CustomerPaymentCfdi::create([
          'created_uid' => \Auth::user()->id,
          'updated_uid' => \Auth::user()->id,
          'customer_payment_id' => $customer_payment->id,
          'name' => $customer_payment->name,
          'status' => 1,
        ]);

        //Actualiza estatus de acuerdo al monto conciliado
        $customer_payment->balance = $amount - $amount_reconciled;
        if($customer_payment->balance <= 0 || !empty($request->cfdi)){ //Si es un CFDI lo marca como conciliado
           $customer_payment->status = CustomerPayment::RECONCILED;
        }
        $customer_payment->update();
        //Crear el CFDI si marcaron la opcion
        if(!empty($cfdi)){
          //Crear CFDI
          $class_cfdi = setting('cfdi_version');
          if (empty($class_cfdi)) {
              throw new \Exception(__('general.error_cfdi_version'));
          }
          if (!method_exists($this, $class_cfdi)) {
              throw new \Exception(__('general.error_cfdi_class_exists'));
          }
          //Valida Empresa y PAC para timbrado
          PacHelper::validateSatActions();
          //Crear XML y timbra
          $tmp = $this->$class_cfdi($customer_payment);
          //Guardar registros de CFDI
          $customer_payment_cfdi->fill(array_only($tmp,[
              'pac_id',
              'cfdi_version',
              'uuid',
              'date',
              'file_xml',
              'file_xml_pac',
          ]));
          $customer_payment_cfdi->save();
          // return 'cfdi success';
        }
        else {
          // return 'cfdi error';
        }
        \DB::commit();
        return 'success';
      }
      catch (\Exception $e) {
        //Fix fechas
        $request->merge([
          'date' => Helper::convertSqlToDateTime($request->date),
        ]);
        if (!empty($request->date_payment)) {
          $request->merge([
            'date_payment' => Helper::convertSqlToDateTime($request->date_payment),
          ]);
        }
        \DB::rollback();
        return $e->getMessage();
      }
    }
    /**
     * Crear XML y enviar a timbrar CFDI 3.3
     *
     * @param CustomerPayment $customer_payment
     * @return array|\CfdiUtils\Elements\Cfdi33\Concepto|float|int
     * @throws \Exception
     */
     private function cfdi33(CustomerPayment $customer_payment)
     {

         try {
             //Logica
             $company = Helper::defaultCompany(); //Empresa
             $pac = Pac::findOrFail(setting('default_pac_id')); //PAC

             //Arreglo CFDI 3.3
             $cfdi33 = [];
             if (!empty($customer_payment->serie)) {
                 $cfdi33['Serie'] = $customer_payment->serie;
             }
             $cfdi33['Folio'] = $customer_payment->folio;
             $cfdi33['Fecha'] = \Date::parse($customer_payment->date)->format('Y-m-d\TH:i:s');
             //$cfdi33['Sello']
             //$cfdi33['FormaPago'] No debe existir
             $cfdi33['NoCertificado'] = $company->certificate_number;
             //$cfdi33['Certificado']
             //$cfdi33['CondicionesDePago'] No debe existir
             $cfdi33['SubTotal'] = Helper::numberFormat(0, 0, false);
             //$cfdi33['Descuento'] No debe existir
             $cfdi33['Moneda'] = 'XXX';
             //$cfdi33['TipoCambio'] No debe existir
             $cfdi33['Total'] = Helper::numberFormat(0, 0, false);
             $cfdi33['TipoDeComprobante'] = $customer_payment->documentType->cfdiType->code;
             //$cfdi33['MetodoPago'] No debe existir
             $cfdi33['LugarExpedicion'] = $customer_payment->branchOffice->postcode;
             if (!empty($customer_payment->confirmacion)) {
                 $cfdi33['Confirmacion'] = $customer_payment->confirmacion;
             }
             //---Cfdi Relacionados
             $cfdi33_relacionados = [];
             $cfdi33_relacionado = [];
             if (!empty($customer_payment->cfdi_relation_id)) {
                 $cfdi33_relacionados['TipoRelacion'] = $customer_payment->cfdiRelation->code;
                 if ($customer_payment->customerPaymentRelations->isNotEmpty()) {
                     foreach ($customer_payment->customerPaymentRelations as $key => $result) {
                         $cfdi33_relacionado[$key] = [];
                         $cfdi33_relacionado[$key]['UUID'] = $result->uuid_related;
                         // $cfdi33_relacionado[$key]['UUID'] = $result->relation->customerPaymentCfdi->uuid;
                     }
                 }
             }
             //---Emisor
             $cfdi33_emisor = [];
             $cfdi33_emisor['Rfc'] = $company->taxid;
             $cfdi33_emisor['Nombre'] = $company->name;
             $cfdi33_emisor['RegimenFiscal'] = $company->taxRegimen->code;
             //---Receptor
             $cfdi33_receptor = [];
             $cfdi33_receptor['Rfc'] = $customer_payment->customer->taxid;
             $cfdi33_receptor['Nombre'] = $customer_payment->customer->name;
             if ($customer_payment->customer->taxid == 'XEXX010101000') {
                 $cfdi33_receptor['ResidenciaFiscal'] = $customer_payment->customer->country->code;
                 $cfdi33_receptor['NumRegIdTrib'] = $customer_payment->customer->numid;
             }
             $cfdi33_receptor['UsoCFDI'] = 'P01';
             //---Conceptos
             $cfdi33_conceptos = [];
             $cfdi33_conceptos_traslados = [];
             $cfdi33_conceptos_retenciones = [];
             $key = 0;
             $cfdi33_conceptos [$key]['ClaveProdServ'] = '84111506';
             //$cfdi33_conceptos[$key]['NoIdentificacion'] No debe existir
             $cfdi33_conceptos [$key]['Cantidad'] = Helper::numberFormat(1, 0, false);
             $cfdi33_conceptos [$key]['ClaveUnidad'] = 'ACT';
             //$cfdi33_conceptos[$key]['Unidad'] No debe existir
             $cfdi33_conceptos [$key]['Descripcion'] = 'Pago';
             $cfdi33_conceptos [$key]['ValorUnitario'] = Helper::numberFormat(0, 0, false);
             $cfdi33_conceptos [$key]['Importe'] = Helper::numberFormat(0, 0, false);
             //$cfdi33_conceptos[$key]['Descuento'] No debe existir
             //['InformacionAduanera']
             //['CuentaPredial']
             //['ComplementoConcepto']
             //['Parte']

             //Impuestos por concepto
             //No debe existir

             //Impuestos
             //No debe existir

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
                 //Impuestos
                 //No debe existir
             }
             //Impuestos
             //No debe existir

             //Complemento de pago
             $pagos10 = [];
             $pagos10['FechaPago'] = \Date::parse($customer_payment->date_payment)->format('Y-m-d\TH:i:s');
             $pagos10['FormaDePagoP'] = $customer_payment->paymentWay->code;
             $pagos10['MonedaP'] = $customer_payment->currency->code;
             if ($customer_payment->currency->code != 'MXN') {
                 $pagos10['TipoCambioP'] = Helper::numberFormat($customer_payment->currency_value, 4, false);
             }
             $pagos10['Monto'] = Helper::numberFormat($customer_payment->amount,
                 $customer_payment->currency->decimal_place, false);
             if (!empty($customer_payment->reference)) {
                 $pagos10['NumOperacion'] = $customer_payment->reference;
             }
             if (!empty($customer_payment->customerBankAccount)) {
                 if(!empty($customer_payment->customerBankAccount->bank->taxid)){
                     $pagos10['RfcEmisorCtaOrd'] = $customer_payment->customerBankAccount->bank->taxid;
                     //Solo extranjeros
                     if($customer_payment->customerBankAccount->bank->taxid == 'XEXX010101000'){
                         $pagos10['NomBancoOrdExt'] = $customer_payment->customerBankAccount->bank->name;
                     }
                 }
                 $pagos10['CtaOrdenante'] = $customer_payment->customerBankAccount->account_number;
             }
             if (!empty($customer_payment->companyBankAccount)) {
                 if(!empty($customer_payment->companyBankAccount->bank->taxid)){
                     $pagos10['RfcEmisorCtaBen'] = $customer_payment->companyBankAccount->bank->taxid;
                 }
                 $pagos10['CtaBeneficiario'] = $customer_payment->companyBankAccount->account_number;
             }
             if (!empty($customer_payment->tipo_cadena_pago)) {
                 $pagos10['TipoCadPago'] = $customer_payment->tipo_cadena_pago;
                 $pagos10['CertPago'] = $customer_payment->certificado_pago;
                 $pagos10['CadPago'] = $customer_payment->cadena_pago;
                 $pagos10['SelloPago'] = $customer_payment->sello_pago;
             }
             $pagos10_doc_relacionados = [];
             if ($customer_payment->customerPaymentReconcileds->isNotEmpty()) {
                 foreach ($customer_payment->customerPaymentReconcileds as $key => $result) {
                     /*$customer_invoice = $result->reconciled;
                     $tmp_id = $customer_invoice->id;
                     //Cuando se hace un pago en MXN para facturas en USD
                     $tmp = Helper::invertBalanceCurrency($customer_payment->currency,$result->amount_reconciled,$customer_invoice->currency->code,$result->currency_value);
                     $saldo_insoluto = $result->last_balance - $tmp;
                     //Numero de pagos realizados que no esten cancelados
                     $tmp_customer_payment_reconciled = CustomerPaymentReconciled::where('status','=','1')
                         ->where('reconciled_id', '=', $tmp_id)
                         ->where(function ($query) {
                             $query->WhereHas('customerPayment', function ($q) {
                                 $q->whereIn('customer_payments.status',[CustomerPayment::OPEN,CustomerPayment::RECONCILED]);
                             });
                         });
                     $result->number_of_payment = $tmp_customer_payment_reconciled->count(); //Guarda el numero de parcialidad
                     $result->save();*/
                     //
                     $pagos10_doc_relacionados [$key]['IdDocumento'] = $result->uuid_related;
                     $pagos10_doc_relacionados [$key]['Serie'] = $result->serie_related;
                     $pagos10_doc_relacionados [$key]['Folio'] = $result->folio_related;
                     $pagos10_doc_relacionados [$key]['MonedaDR'] = $result->currency_code_related;
                     if($customer_payment->currency->code != $result->currency_code_related) {
                         $pagos10_doc_relacionados [$key]['TipoCambioDR'] = Helper::numberFormat($customer_payment->currency_value/$result->currency_value + 0.000001, 4, false);
                     }
                     $pagos10_doc_relacionados [$key]['MetodoDePagoDR'] = $result->payment_method_code_related;
                     $pagos10_doc_relacionados [$key]['NumParcialidad'] = $result->number_of_payment;
                     $pagos10_doc_relacionados [$key]['ImpSaldoAnt'] = Helper::numberFormat($result->last_balance,$customer_payment->currency->decimal_place, false);
                     $pagos10_doc_relacionados [$key]['ImpPagado'] = Helper::numberFormat($result->amount_reconciled,$customer_payment->currency->decimal_place, false);
                     $pagos10_doc_relacionados [$key]['ImpSaldoInsoluto'] = Helper::numberFormat($result->current_balance,$customer_payment->currency->decimal_place, false);
                 }
             }

             $pagos = new \CfdiUtils\Elements\Pagos10\Pagos();
             $pago = $pagos->addPago($pagos10);
             if(!empty($pagos10_doc_relacionados)) {
                 foreach($pagos10_doc_relacionados as $key => $result) {
                     $tmp = $pago->addDoctoRelacionado($result);
                 }
             }
             $comprobante->addComplemento($pagos);

             //Método de ayuda para establecer las sumas del comprobante e impuestos con base en la suma de los conceptos y la agrupación de sus impuestos
             //$creator->addSumasConceptos(null, 2);
             //Método de ayuda para generar el sello (obtener la cadena de origen y firmar con la llave privada)
             $creator->addSello('file://' . \Storage::path($company->pathFileKeyPassPem()), Crypt::decryptString($company->password_key));
             //Valida la estructura
             //$creator->validate();

             //Guarda XML
             //dd($creator->asXml());
             $path_xml = Helper::setDirectory(CustomerPayment::PATH_XML_FILES) . '/';
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
        $customer = DB::select('CALL px_only_customer_data ()', array());
        $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
        $list_status = $this->list_status;
        return view('permitted.sales.customer_payments_show',
        compact('customer', 'sucursal', 'payment_way', 'tipo_cadena_pagos', 'list_status'));
    }

    /*
     * Se mostrara todas las facturas
     */
    public function balances(Request $request)
    {
      //Variables
      $customer_id = $request->customer_id;
      $filter_currency_id = $request->currency_id;
      //Logica
      if ($request->ajax() && !empty($customer_id)) {
        //Solo pagos en MXN se pueden aplicar a otras monedas
        $resultados = DB::select('CALL px_customer_invoices_open_data2 (?, ?)', array($customer_id, $filter_currency_id));
        return response()->json($resultados, 200);
      }
      return response()->json(['error' => __('general.error500')], 422);
    }

    /*
     *  Recupera archivos PDF y XMl de la factura y las
     *  envia al array de emails proporcionado
     */
    public function sendmail_facts_customers(Request $request)
    {
        $files = $this->get_pdf_xml_files($request->customer_invoice_id);
        $pdf = $files['pdf'];
        $xml = $files['xml'];

        $data = [
            'factura' => $request->fact_name,
            'cliente' => $request->cliente_name,
        ];

        try{

            Mail::send('mail.facturacion.facturas', ['data' => $data],function ($message) use ($request, $pdf, $xml){
                $message->subject($request->subject);
                $message->from('desarrollo@sitwifi.com', 'Factura sitwifi');
                $message->to($request->to);
                $message->attachData($pdf->output(), $request->fact_name . '.pdf');
                $message->attachData($xml, $request->fact_name .'.xml', ['mime'=>'application/xml']);
            });

            return response()->json([
                'message' => 'Factura enviada',
                'code' => 200
            ]);

        }catch(\Swift_RfcComplianceException $e){
            return response()->json([
                'message' => 'Error al intentar enviar la factura, revise que los correos sean validos',
                'code' => 500
            ]);
        }

    }

    public function check_currency_bank(Request $request)
    {
      $moneda = (int)$request->moneda;
      $customer_bank = (int)$request->customer_bank;

      $res = DB::table('company_bank_accounts')->select('currency_id')->where('id', $customer_bank)->value('currency_id');

      if ($moneda == $res) {
        return '1';
      }else{
        return '0';
      }
    }
    public function getCuentasOrdenantes(Request $request)
    {
      $customer_id = $request->customer_id;

      $result = DB::select('CALL GetDataCustomerBanks (?)', array($customer_id));

      return $result;
    }
    /**
     * Calcula el total de las lineas
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function totalItemManualReconciled(Request $request)
    {
      //Variables
      $json = new \stdClass;
      $input_items_manual_reconciled = $request->item_manual_reconciled;
      $currency_id = $request->currency_id;
      $currency_code = 'MXN';
      if ($request->ajax()) {
        //Datos de moneda
        if (!empty($currency_id)) {
          $currency = Currency::findOrFail($currency_id);
          $currency_code = $currency->code;
        }
        //Variables de totales
        $items_manual_reconciled = [];
        if (!empty($input_items_manual_reconciled)) {
          foreach ($input_items_manual_reconciled as $key => $item) {
            //Logica
            $item_last_balance = (double)$item['last_balance'];
            $item_amount_reconciled = (double)$item['amount_reconciled'];
            //Subtotales por cada item
            $items_manual_reconciled[$key] = Helper::numberFormat($item_last_balance-$item_amount_reconciled,2, false);
          }
        }
        //Respuesta
        $json->items_manual_reconciled = $items_manual_reconciled;
        return response()->json($json);
      }
      return response()->json(['error' => __('general.error_general')], 422);
    }

    public function get_exchange_rate_by_date(Request $request)
    {
      $date_payment = Carbon::parse($request->date_payment)->format('Y-m-d');
      
      $result = DB::table('exchange_rates')->select('current_date','current_rate_fix', 'current_rate_dof','current_rate')
                    ->where('current_date', $date_payment)->get();
      
      return $result;
    }

    //MOVIMIENTOS DE POLIZA DE INGRESO
    public function get_facts_mov_data(Request $request)
    {
        $tipos_poliza = DB::table('Contab.tipos_poliza')->select('id', 'clave', 'descripcion')->get();
        $next_id_num = DB::table('polizas')->max('numero') + 1;
        $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');
        $facturas = json_decode($request->facturas);
        $asientos = array();
        for ($i=0; $i <= (count($facturas)-1); $i++)
        {
          $data = DB::select('CALL poliza_mov_ingresos(?)', array($facturas[$i]));
          //dd($data);
          if(count($data) > 0)
          {
            for($j=0; $j <= (count($data)-1); $j++)
            {
              array_push($asientos, $data[$j]);
            }
          }
        }

        return view('permitted.accounting.tabla_asientos_contables_ingresos',
               compact('asientos', 'cuentas_contables', 'tipos_poliza', 'next_id_num'));
    }

    public function save_poliza_ingreso_movs(Request $request)
    {
        
        try {

            DB::transaction(function () use($request){
                //Objeto de polizas
                $asientos = $request->movs_polizas;
                $asientos_data = json_decode($asientos);

                $tam_asientos = count($asientos_data);
                $flag = "false";
                
                $id_poliza = DB::table('polizas')->insertGetId([
                    'tipo_poliza_id' => $request->type_poliza,
                    'numero' => $request->num_poliza,
                    'fecha' => $request->date_invoice,
                    'descripcion' => $request->descripcion_poliza,
                    'total_cargos' => $request->total_cargos_format,
                    'total_abonos' => $request->total_abonos_format
                ]);
    
                //Insertando movimientos de las polizas
                for ($i=0; $i < $tam_asientos; $i++)
                {
                  if ( $asientos_data[$i]->cuenta_contable_id ) {
                    if ( $asientos_data[$i]->cargo == 0 && $asientos_data[$i]->abono == 0) {
                       /* NO_INSERTAR */
                    }
                    else{
                      /* SE INSERTAR */
    
                      //Acumulando saldos
                      $cc_array = DB::select('CALL Contab.px_busca_cuentas_xid(?)', array($asientos_data[$i]->cuenta_contable_id));
                      $this->add_balances_polizas_ingresos($cc_array, $request->date_invoice, $asientos_data[$i]->cargo, $asientos_data[$i]->abono);
    
                      $sql = DB::table('polizas_movtos')->insert([
                        'poliza_id' => $id_poliza,
                        'cuenta_contable_id' => $asientos_data[$i]->cuenta_contable_id,
                        'customer_payment_id' => $asientos_data[$i]->factura_id,
                        'fecha' => $request->date_invoice,
                        'exchange_rate' => $asientos_data[$i]->tipo_cambio,
                        'descripcion' => $asientos_data[$i]->nombre,
                        'cargos' => $asientos_data[$i]->cargo,
                        'abonos' => $asientos_data[$i]->abono,
                        'referencia' => $asientos_data[$i]->referencia
                      ]);
                      //Marcando complementos de pago a contabilizado
                      $customer_payment = CustomerPayment::findOrFail($asientos_data[$i]->complemento_pago_id);
                      $customer_payment->contabilizado = 1;
                      $customer_payment->save();
                      
                    }
                  }
                }
            });

            $flag = "true";


        } catch(\Exception $e){
            $error = $e->getMessage();
            dd($error);
        }

        return  $flag;

    }

    public function add_balances_complemento_pago($cc_array, $periodo, $cargo, $abono)
    {
        $explode = explode('-', $periodo);
        $anio = $explode[0];
        $mes = $explode[1];

        foreach($cc_array as $cc)
        {
            //Obtengo saldos de la cuenta contable en la balanza en el periodo requerido
            $result = DB::table('Contab.balanza')->select('cargos', 'abonos', 'sdo_inicial', 'sdo_final')
            ->where('anio', $anio)
            ->where('mes', $mes)
            ->where('cuenta_contable_id', $cc->cuenta_contable_id)
            ->get();

            $saldo_inicial = $result[0]->sdo_inicial;
            $saldo_final = $result[0]->sdo_final;
            //Sumo totales de la poliza con el acumulado en la balanza
            $total_cargos = $result[0]->cargos + $cargo;
            $total_abonos = $result[0]->abonos + $abono;
            //Calculo el saldo final de la cuenta contable dependiendo su naturaleza
            if($cc->naturaleza == 'A'){
                $saldo_final = $saldo_inicial + $total_abonos - $total_cargos; 
            }else if($cc->naturaleza == 'D'){
                $saldo_final = $saldo_inicial + $total_cargos - $total_abonos; 
            }   
            //Actualizo la balanza de la cuenta contable en el periodo que le corresponde
            DB::table('Contab.balanza')
                ->where('anio', $anio)
                ->where('mes', $mes)
                ->where('cuenta_contable_id', $cc->cuenta_contable_id)
                ->update([
                    'cargos' => $total_cargos,
                    'abonos' => $total_abonos,
                    'sdo_final' => $saldo_final
                ]);
        }
    }

    public function cancel_balances_complemento_pago($cc_array, $periodo, $cargo, $abono)  
    {
        $explode = explode('-', $periodo);
        $anio = $explode[0];
        $mes = $explode[1];
       
        foreach($cc_array as $cc)
        {
          $explode = explode('-', $periodo);
          $anio = $explode[0];
          $mes = $explode[1];         
          //Obtengo saldos de la cuenta contable en la balanza en el periodo requerido
          $result = DB::table('Contab.balanza')->select('id','cargos', 'abonos', 'sdo_inicial', 'sdo_final')
          ->where('anio', $anio)
          ->where('mes', $mes)
          ->where('cuenta_contable_id', $cc->cuenta_contable_id)
          ->get();
          
          $saldo_inicial = $result[0]->sdo_inicial;
          $saldo_final = $result[0]->sdo_final;
          //Resto totales de la balanza para cancelar el saldo de la poliza
          $total_cargos = $result[0]->cargos - $cargo;
          $total_abonos = $result[0]->abonos - $abono;
          
          //Recalculo el saldo final de la cuenta contable dependiendo su naturaleza
          if($cc->naturaleza == 'A'){
              $saldo_final = $saldo_inicial + $total_abonos - $total_cargos; 
          }else if($cc->naturaleza == 'D'){
              $saldo_final = $saldo_inicial + $total_cargos - $total_abonos; 
          }   
          //Actualizo la balanza de la cuenta contable en el periodo que le corresponde
          DB::table('Contab.balanza')
            ->where('anio', $anio)
            ->where('mes', $mes)
            ->where('cuenta_contable_id', $cc->cuenta_contable_id)
            ->update([
                'cargos' => $total_cargos,
                'abonos' => $total_abonos,
                'sdo_final' => $saldo_final
          ]);
            
        }

    }

}
