<?php

namespace App\Http\Controllers\Sales;
use Auth;
use DB;
use PDF;
use Carbon\Carbon;

use App\Helpers\Cfdi33Helper;
use App\Helpers\Helper;
use App\Helpers\PacHelper;

use App\Models\Base\BranchOffice;
use App\Models\Base\Company;
use App\Models\Base\Pac;
use App\Models\Catalogs\CfdiRelation;
use App\Models\Catalogs\CfdiUse;
use App\Models\Catalogs\Currency;
use App\Models\Catalogs\PaymentMethod;
use App\Models\Catalogs\PaymentTerm;
use App\Models\Catalogs\PaymentWay;
use App\Models\Catalogs\SatProduct;
use App\Models\Catalogs\Tax;
use App\Models\Catalogs\UnitMeasure;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

use App\Models\Sales\Customer;
use App\Models\Sales\CustomerInvoice;
use App\Models\Sales\CustomerInvoice as CustomerCreditNote;
use App\Models\Sales\CustomerInvoiceCfdi as CustomerCreditNoteCfdi;
use App\Models\Sales\CustomerInvoiceLine as CustomerCreditNoteLine;
use App\Models\Sales\CustomerInvoiceRelation as CustomerCreditNoteRelation;
use App\Models\Sales\CustomerInvoiceTax as CustomerCreditNoteTax;
use App\Models\Sales\CustomerInvoiceReconciled as CustomerCreditNoteReconciled;
use App\Models\Sales\Salesperson;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
use Mail;

class CustomerCreditNoteController extends Controller
{
    private $list_status = [];
    private $document_type_code = 'customer.credit_note';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->list_status = [
            CustomerCreditNote::OPEN => __('customer_credit_note.text_status_open'),
            CustomerCreditNote::RECONCILED => __('customer_credit_note.text_status_reconciled'),
            CustomerCreditNote::CANCEL => __('customer_credit_note.text_status_cancel'),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $customer = DB::select('CALL px_only_customer_data ()', array());
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

      return view( 'permitted.sales.customer_credit_notes',compact('customer', 'sucursal', 'currency', 'payment_term', 'salespersons',
      'payment_way', 'payment_term' ,'payment_methods',
      'cfdi_uses', 'product', 'unitmeasures', 'satproduct', 'impuestos', 'cfdi_relations') );
    }

    public function totalReconciledLines(Request $request)
    {
        //Variables
        $json = new \stdClass;
        $input_items_reconciled = $request->item_reconciled;
        $currency_code = 'MXN';
        //Añadir
        $add_balance = 0;

        if ($request->ajax()) {
            //Datos de moneda
            if (!empty($request->currency_id)) {
                $currency = Currency::findOrFail($request->currency_id);
                $currency_code = $currency->code;
            }
            //Variables de totales
            $amount_total = (double)$request->amount_total_tmp; //Total de la nota de credito
            $amount_reconciled = !empty($request->amount_reconciled) ? (double)$request->amount_reconciled : 0;
            $amount_per_reconciled = 0;
            $items_reconciled = [];
            if (!empty($input_items_reconciled)) {
                foreach ($input_items_reconciled as $key => $item_reconciled) {
                    //Logica
                    $add_balance += (double)$item_reconciled['balance'];//Suma total de cantidades

                    $item_reconciled_balance = (double)$item_reconciled['balance'];
                    $item_reconciled_currency_value = !empty($item_reconciled['currency_value']) ? round((double)$item_reconciled['currency_value'],4) : null;
                    $amount_reconciled += (double)$item_reconciled['amount_reconciled'];
                    $items_reconciled[$key] = Helper::convertBalanceCurrency($currency,$item_reconciled_balance,$item_reconciled['currency_code'],$item_reconciled_currency_value);
                    // $items_reconciled[$key] = money(Helper::convertBalanceCurrency($currency,$item_reconciled_balance,$item_reconciled['currency_code'],$item_reconciled_currency_value), $currency_code, true)->format();
                }
            }
            // return $add_balance;
            //Respuesta
            $json->items_reconciled = $items_reconciled;
            $json->amount_total = $amount_total;
            $json->amount_reconciled = $amount_reconciled;
            $json->amount_per_reconciled = $amount_total - $amount_reconciled;
            return response()->json($json);
        }

        return response()->json(['error' => __('general.error_general')], 422);
    }
    public function totalLines(Request $request)
    {
      //Variables
      $json = new \stdClass;
      $input_items = $request->item;
      $currency_id = $request->currency_id;
      $currency_value = $request->currency_value;
      $resp_currency_value = $request->currency_value;

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
      $currency_code = 'MXN';

      if ($request->ajax()) {
        //Variables de totales
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
            $item_discount = 0;
            $item_price_reduce = ($item_price_unit * (100 - $item_discount) / 100); //Precio reducido
            $item_amount_untaxed = round($item_quantity * $item_price_reduce, 2);//libre de impuestos
            $item_amount_discount = round($item_quantity * $item_price_unit, 2) - $item_amount_untaxed;//descuento
            $item_amount_tax = 0;
            $item_amount_tax_ret = 0;
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
            $item_subtotal = $item_amount_untaxed;
            //Tipo cambio
            if ($item['current'] === $currency_id) {
              // code...
              $items_tc [$key] =$resp_currency_value;//ALMACENO TIPO CAMBIO
            }
            elseif ($item['current'] != $currency_id) {
              // code...
              if ( $item['current'] === '2') { //ES DOLAR
                $current_select_rate = DB::table('exchange_rates')->select('current_rate')->latest()->first();
                $currency_value = $current_select_rate->current_rate;
                $currency_code = DB::table('currencies')->select('code_banxico')->where('id', $currency_id)->value('code_banxico');
                $item_amount_tax = $item_amount_tax * $currency_value;
                $item_amount_total = $item_amount_total * $currency_value;
                $item_subtotal = $item_subtotal * $currency_value;
                $items_tc [$key] =$currency_value;//ALMACENO TIPO CAMBIO
              }
              else { //moneda distinta
                $currency_value = DB::table('currencies')->select('rate')->where('id', $item['current'])->value('rate');
                $currency_code = DB::table('currencies')->select('code_banxico')->where('id', $item['current'])->value('code_banxico');
                if ($currency_id === '2') { //SI LA MONEDA SELECCIONADA ES DOLAR
                   $item_amount_total = $item_amount_total/$resp_currency_value;
                   $item_amount_tax = $item_amount_tax / $resp_currency_value;
                   $item_subtotal = $item_subtotal / $resp_currency_value;
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
            $amount_discount += $item_amount_discount;
            $amount_untaxed += $item_subtotal;
            $amount_tax += $item_amount_tax;
            $amount_tax_ret += $item_amount_tax_ret;
            $amount_total += $item_amount_total;
            //Subtotales por cada item
            $items[$key] = $item_amount_total;
          }
        }
        //Respuesta
        $json->items = $items;
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
    public function getCustomerCreditNote(Request $request)
    {
        //Variables
        $id = $request->id;

        //Logica
        if ($request->ajax() && !empty($id)) {
            $customer_credit_note = CustomerCreditNote::findOrFail($id);
            $customer_credit_note->uuid = $customer_credit_note->customerInvoiceCfdi->uuid ?? '';
            return response()->json($customer_credit_note, 200);
        }

        return response()->json(['error' => __('general.error_general')], 422);
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
        //Logica
        $request->merge(['created_uid' => \Auth::user()->id]);
        $request->merge(['updated_uid' => \Auth::user()->id]);
        $request->merge(['status' => CustomerCreditNote::OPEN]);
        //Ajusta fecha y genera fecha de vencimiento
        $date = Helper::createDateTime($request->date);
        $request->merge(['date' => Helper::dateTimeToSql($date)]);
        $date_due = $date; //La fecha de vencimiento por default
        $request->merge(['date_due' => Helper::dateToSql($date_due)]);
        //Obtiene folio
        $document_type = Helper::getNextDocumentTypeByCode('customer.credit_note');
        $request->merge(['document_type_id' => $document_type['id']]);
        $request->merge(['name' => $document_type['name']]);
        $request->merge(['serie' => $document_type['serie']]);
        $request->merge(['folio' => $document_type['folio']]);
        //Guardar Registro principal
        $customer_credit_note = CustomerCreditNote::create($request->input());
        //Registro de lineas
        $amount_discount = 0; // Descuento por cantidad
        $amount_untaxed = 0;  // Cantidad libre de impuestos
        $amount_tax = 0;      // Cantidad de impuestos
        $amount_tax_ret = 0;  // Importe retiro de impuestos
        $amount_total = 0;    // Monto total
        $balance = 0;         // Balance
        $taxes = array();     // Impuestos

        $currency_pral_id = $request->currency_id;      //Moneda principal
        $currency_pral_value = $request->currency_value;//Valor o TC de la moneda principal

        //Lineas
        if (!empty($request->item)) {
          foreach ($request->item as $key => $item) {
            //Logica
            $item_quantity = (double)$item['quantity']; //cantidad de artículo
            $item_price_unit = (double)$item['price_unit']; //unidad de precio del artículo
            $item_discount = 0; //descuento del artículo
            $item_price_reduce = ($item_price_unit * (100 - $item_discount) / 100); //Precio reducido
            $item_amount_untaxed = round($item_quantity * $item_price_reduce, 2);//libre de impuestos
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
              }
              else {
                $item_currency_value = DB::table('currencies')->select('rate')->where('id', $item_currency_id)->value('rate');
                //Tranformamos al valor de la moneda seleccionada
                $item_amount_tax = $item_amount_tax * $item_currency_value;
                $item_amount_total = $item_amount_total * $item_currency_value;
                $item_subtotal = $item_subtotal * $item_currency_value;
              }
            }
            //--------------------------------------------------------------------------------------------------------------------------//
            //Sumatoria totales
            $amount_discount += $item_amount_discount;
            $amount_untaxed += $item_subtotal;
            $amount_tax += $item_amount_tax;
            $amount_tax_ret += $item_amount_tax_ret;
            $amount_total += $item_amount_total;

            //Guardar linea
            $customer_credit_note_line = CustomerCreditNoteLine::create([
                'created_uid' => \Auth::user()->id,
                'updated_uid' => \Auth::user()->id,
                'customer_invoice_id' => $customer_credit_note->id,
                'name' => $item['name'],
                'product_id' => $item['product_id'],
                'sat_product_id' => $item['sat_product_id'],
                'unit_measure_id' => $item['unit_measure_id'],
                'quantity' => $item_quantity,
                'price_unit' => $item_price_unit,
                'discount' => $item_discount,
                'price_reduce' => $item_price_reduce,
                'amount_discount' => $item_amount_discount,
                'amount_untaxed' => $item_amount_untaxed,
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
                $customer_credit_note_line->taxes()->sync($item['taxes']);
            } else {
                $customer_credit_note_line->taxes()->sync([]);
            }
          }
        }
        //Resumen de impuestos
        if (!empty($taxes)) {
          $i = 0;
          foreach ($taxes as $tax_id => $result) {
            $tax = Tax::findOrFail($tax_id);
            $customer_credit_note_tax = CustomerCreditNoteTax::create([
              'created_uid' => \Auth::user()->id,
              'updated_uid' => \Auth::user()->id,
              'customer_invoice_id' => $customer_credit_note->id,
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

        //Facturas conciliadas
        $amount_reconciled = 0;
        //Lineas
        if (!empty($request->item_reconciled)) {
            foreach ($request->item_reconciled as $key => $item_reconciled) {
                if(!empty($item_reconciled['amount_reconciled'])) {
                    //Logica
                    $item_reconciled_amount_reconciled = round((double)$item_reconciled['amount_reconciled'],2);
                    $item_reconciled_currency_value = !empty($item_reconciled['currency_value']) ? round((double)$item_reconciled['currency_value'],4) : null;
                    $amount_reconciled += $item_reconciled_amount_reconciled;
                    //Datos de factura
                    $customer_invoice = CustomerInvoice::findOrFail($item_reconciled['id']);
                    // $customer_invoice = CustomerInvoice::findOrFail($item_reconciled['reconciled_id']);
                    //Guardar linea
                    $customer_credit_note_reconciled = CustomerCreditNoteReconciled::create([
                        'created_uid' => \Auth::user()->id,
                        'updated_uid' => \Auth::user()->id,
                        'customer_invoice_id' => $customer_credit_note->id,
                        'name' => $customer_invoice->name,
                        'reconciled_id' => $customer_invoice->id,
                        'currency_value' => $item_reconciled_currency_value,
                        'amount_reconciled' => $item_reconciled_amount_reconciled,
                        'last_balance' => $customer_invoice->balance,
                        'sort_order' => $key,
                        'status' => 1,
                    ]);
                    //Actualiza el saldo de la factura relacionada
                    $customer_invoice->balance -= round(Helper::invertBalanceCurrency($customer_credit_note->currency,$item_reconciled_amount_reconciled,$customer_invoice->currency->code,$item_reconciled_currency_value),2);
                    if($customer_invoice->balance <= 0){
                        $customer_invoice->status = CustomerInvoice::PAID;
                    }
                    $customer_invoice->save();
                }
            }
        }
        //Cfdi relacionados
        if (!empty($request->item_relation)) {
            foreach ($request->item_relation as $key => $result) {
                //Guardar
                $customer_credit_note_relation = CustomerCreditNoteRelation::create([
                    'created_uid' => \Auth::user()->id,
                    'updated_uid' => \Auth::user()->id,
                    'customer_invoice_id' => $customer_credit_note->id,
                    'relation_id' => $result['relation_id'],
                    'sort_order' => $key,
                    'status' => 1,
                ]);
            }
        }
        //Registros de cfdi
        $customer_credit_note_cfdi = CustomerCreditNoteCfdi::create([
            'created_uid' => \Auth::user()->id,
            'updated_uid' => \Auth::user()->id,
            'customer_invoice_id' => $customer_credit_note->id,
            'name' => $customer_credit_note->name,
            'status' => 1,
        ]);
        //Actualiza registro principal con totales
        $customer_credit_note->amount_discount = $amount_discount;
        $customer_credit_note->amount_untaxed = $amount_untaxed;
        $customer_credit_note->amount_tax = $amount_tax;
        $customer_credit_note->amount_tax_ret = $amount_tax_ret;
        $customer_credit_note->amount_total = $amount_total;
        $customer_credit_note->balance = $amount_total;
        $customer_credit_note->update();
        //Actualiza estatus de acuerdo al monto conciliado
        $customer_credit_note->balance = $amount_total - $amount_reconciled;
        if($customer_credit_note->balance <= 0){
            $customer_credit_note->status = CustomerCreditNote::RECONCILED;
        }
        $customer_credit_note->update();
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
        $tmp = $this->$class_cfdi($customer_credit_note);
        //Guardar registros de CFDI
        $customer_credit_note_cfdi->fill(array_only($tmp,[
            'pac_id',
            'cfdi_version',
            'uuid',
            'date',
            'file_xml',
            'file_xml_pac',
        ]));
        $customer_credit_note_cfdi->save();

        DB::commit();
        return 'success';
        // all good
      } catch (\Exception $e) {
        DB::rollback();
        return $e;
        // something went wrong
      }
    }

    /**
     * Crear XML y enviar a timbrar CFDI 3.3
     *
     * @param CustomerCreditNote $customer_credit_note
     * @return array|\CfdiUtils\Elements\Cfdi33\Concepto|float|int
     * @throws \Exception
     */
     private function cfdi33(CustomerCreditNote $customer_credit_note)
     {

         try {
             //Logica
             $company = Helper::defaultCompany(); //Empresa
             $pac = Pac::findOrFail(setting('default_pac_id')); //PAC

             //Arreglo CFDI 3.3
             $cfdi33 = [];
             if (!empty($customer_credit_note->serie)) {
                 $cfdi33['Serie'] = $customer_credit_note->serie;
             }
             $cfdi33['Folio'] = $customer_credit_note->folio;
             $cfdi33['Fecha'] = \Date::parse($customer_credit_note->date)->format('Y-m-d\TH:i:s');
             //$cfdi33['Sello']
             $cfdi33['FormaPago'] = $customer_credit_note->paymentWay->code;
             $cfdi33['NoCertificado'] = $company->certificate_number;
             //$cfdi33['Certificado']
             $cfdi33['CondicionesDePago'] = $customer_credit_note->paymentTerm->name;
             $cfdi33['SubTotal'] = Helper::numberFormat($customer_credit_note->amount_untaxed + $customer_credit_note->amount_discount,
                 $customer_credit_note->currency->decimal_place, false);
             $cfdi33['Descuento'] = Helper::numberFormat($customer_credit_note->amount_discount,
                 $customer_credit_note->currency->decimal_place, false);
             $cfdi33['Moneda'] = $customer_credit_note->currency->code;
             if ($customer_credit_note->currency->code != 'MXN') {
                 $cfdi33['TipoCambio'] = Helper::numberFormat($customer_credit_note->currency_value, 4, false);
             }
             $cfdi33['Total'] = Helper::numberFormat($customer_credit_note->amount_total,
                 $customer_credit_note->currency->decimal_place, false);
             $cfdi33['TipoDeComprobante'] = $customer_credit_note->documentType->cfdiType->code;
             $cfdi33['MetodoPago'] = $customer_credit_note->paymentMethod->code;
             $cfdi33['LugarExpedicion'] = $customer_credit_note->branchOffice->postcode;
             if (!empty($customer_credit_note->confirmacion)) {
                 $cfdi33['Confirmacion'] = $customer_credit_note->confirmacion;
             }
             //---Cfdi Relacionados
             $cfdi33_relacionados = [];
             $cfdi33_relacionado = [];
             if (!empty($customer_credit_note->cfdi_relation_id)) {
                 $cfdi33_relacionados['TipoRelacion'] = $customer_credit_note->cfdiRelation->code;
                 if ($customer_credit_note->customerInvoiceRelations->isNotEmpty()) {
                     foreach ($customer_credit_note->customerInvoiceRelations as $key => $result) {
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
             $cfdi33_receptor['Rfc'] = $customer_credit_note->customer->taxid;
             $cfdi33_receptor['Nombre'] = trim($customer_credit_note->customer->name);
             if ($customer_credit_note->customer->taxid == 'XEXX010101000') {
                 $cfdi33_receptor['ResidenciaFiscal'] = $customer_credit_note->customer->country->cod;
                 $cfdi33_receptor['NumRegIdTrib'] = $customer_credit_note->customer->numid;
             }
             $cfdi33_receptor['UsoCFDI'] = $customer_credit_note->cfdiUse->code;
             //---Conceptos
             $cfdi33_conceptos = [];
             $cfdi33_conceptos_traslados = [];
             $cfdi33_conceptos_retenciones = [];
             foreach ($customer_credit_note->customerInvoiceLines as $key => $result) {
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
                 $cfdi33_conceptos [$key]['Descuento'] = Helper::numberFormat($result->amount_discount, 2, false);
                 //['InformacionAduanera']
                 //['CuentaPredial']
                 //['ComplementoConcepto']
                 //['Parte']

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
             if ($customer_credit_note->customerInvoiceTaxes->isNotEmpty()) {
                 foreach ($customer_credit_note->customerInvoiceTaxes as $key => $result) {
                     $tmp = $result->amount_tax;
                     $rate = $result->tax->rate;
                     if ($result->tax->factor == 'Tasa') {
                         $rate /= 100;
                     }
                     if ($tmp < 0) { //Retenciones
                         $cfdi33_retenciones[$key] = [];
                         $cfdi33_retenciones[$key]['Impuesto'] = $result->tax->code;
                         $cfdi33_retenciones[$key]['Importe'] = Helper::numberFormat(abs($tmp),
                             $customer_credit_note->currency->decimal_place, false);
                     } else { //Traslados
                         if ($result->tax->factor != 'Exento') {
                             $cfdi33_traslados[$key] = [];
                             $cfdi33_traslados[$key]['Impuesto'] = $result->tax->code;
                             $cfdi33_traslados[$key]['TipoFactor'] = $result->tax->factor; //Para retenciones no hay excento
                             $cfdi33_traslados[$key]['TasaOCuota'] = Helper::numberFormat(abs($rate), 6, false);
                             $cfdi33_traslados[$key]['Importe'] = Helper::numberFormat(abs($tmp), 2, false);
                         }
                     }
                 }
             }
             $cfdi33_impuestos = [];
             if (abs($customer_credit_note->amount_tax_ret) > 0 || !empty($cfdi33_retenciones)) {
                 $cfdi33_impuestos['TotalImpuestosRetenidos'] = Helper::numberFormat(abs($customer_credit_note->amount_tax_ret),
                     $customer_credit_note->currency->decimal_place, false);
             }
             if (abs($customer_credit_note->amount_tax) > 0 || !empty($cfdi33_traslados)) {
                 $cfdi33_impuestos['TotalImpuestosTrasladados'] = Helper::numberFormat(abs($customer_credit_note->amount_tax),
                     $customer_credit_note->currency->decimal_place, false);
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
             //Método de ayuda para establecer las sumas del comprobante e impuestos con base en la suma de los conceptos y la agrupación de sus impuestos
             //$creator->addSumasConceptos(null, 2);
             //Método de ayuda para generar el sello (obtener la cadena de origen y firmar con la llave privada)
             $creator->addSello('file://' . \Storage::path($company->pathFileKeyPassPem()), Crypt::decryptString($company->password_key));
             //Valida la estructura
             //$creator->validate();

             //Guarda XML
             //dd($creator->asXml());
             $path_xml = Helper::setDirectory(CustomerCreditNote::PATH_XML_FILES_CCN) . '/';
             $file_xml = Helper::makeDirectoryCfdi($path_xml) . '/' . Str::random(40) . '.xml';
             $creator->saveXml(\Storage::path($path_xml . $file_xml));

             //Arreglo temporal para actualizar Customer Credit Note CFDI
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

     public function view_egresos()
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

        return view('permitted.sales.customer_credit_notes_history', compact('customer', 'sucursal', 'salespersons'));
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

        $resultados = DB::select('CALL px_customer_note_credits_filters (?,?,?,?,?,?)', array($date_a, $date_b, $folio, $sucursal, $cliente, $estatus));

        return json_encode($resultados);
      }
      public function show(Request $request)
      {
        $customer = DB::select('CALL px_only_customer_data ()', array());
        $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
        $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
        $salespersons = DB::select('CALL GetAllSalespersonv2 ()', array());
        $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
        $list_status = $this->list_status;
        return view('permitted.sales.customer_credit_notes_show',compact('customer', 'sucursal', 'list_status'));
      }
      public function searchfilter(Request $request)
      {
        $folio = !empty($request->filter_name) ? $request->filter_name : '';
        $date_from = $request->filter_date_from;
        $date_to = $request->filter_date_to;
        $sucursal = !empty($request->filter_branch_office_id) ? $request->filter_branch_office_id : '';
        $cliente = !empty($request->filter_customer_id) ? $request->filter_customer_id : '';
        $estatus = !empty($request->filter_status) ? $request->filter_status : '';

        $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
        $date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');

        $resultados = DB::select('CALL px_customer_invoices_filters_type (?,?,?,?,?,?,?)',array($date_a, $date_b, $folio, $sucursal, $cliente, $estatus, '2'));
        return json_encode($resultados);
      }
      /**
       * Descarga de archivo XML
       *
       * @param Request $request
       * @param CustomerCreditNote $customer_credit_note
       * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\BinaryFileResponse
       */
      public function downloadXml($id)
      {
        $customer_credit_note = CustomerInvoice::findOrFail($id);
        //Ruta y validacion del XML
        $path_xml = Helper::setDirectory(CustomerCreditNote::PATH_XML_FILES_CCN) . '/';
        $file_xml_pac = $path_xml . $customer_credit_note->customerInvoiceCfdi->file_xml_pac;
        if (!empty($file_xml_pac)) {
            if (\Storage::exists($file_xml_pac)) {
                return response()->download(\Storage::path($file_xml_pac), $customer_credit_note->name . '.xml');
            }
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
        $customer_credit_note = CustomerCreditNote::findOrFail($id);
        //Logica
        if ($request->ajax()) {
          //Obtener informacion de estatus
          $data_status_sat = [
            'cancelable' => 1,
            'pac_is_cancelable' => ''
          ];
          if (!empty($customer_credit_note->customerInvoiceCfdi->cfdi_version) && !empty($customer_credit_note->customerInvoiceCfdi->uuid)) {
                $tmp = [
                    'rfcR' => $customer_credit_note->customer->taxid,
                    'uuid' => $customer_credit_note->customerInvoiceCfdi->uuid,
                    'total' => Helper::numberFormat($customer_credit_note->amount_total, $customer_credit_note->currency->decimal_place, false),
                ];
                $class_pac = $customer_credit_note->customerInvoiceCfdi->pac->code . 'Status';
                $data_status_sat = PacHelper::$class_pac($tmp,$customer_credit_note->customerInvoiceCfdi->pac);
            }
          $is_cancelable = true;
          if($data_status_sat['cancelable'] == 3){
              $is_cancelable = false;
          }
          //modal de visualizar estatus en el SAT
          $data_result = [
            'folio' => $customer_credit_note->name,
            'uuid' => $customer_credit_note->customerInvoiceCfdi->uuid,
            'data_status_sat' => $data_status_sat,
            'is_cancelable' => $is_cancelable,
            'text_is_cancelable_cfdi' => !empty($data_status_sat['pac_is_cancelable']) ? $data_status_sat['pac_is_cancelable'] : '&nbsp;',
            'text_status_cfdi' => !empty($data_status_sat['pac_status']) ? $data_status_sat['pac_status'] : '&nbsp;'
          ];
          return $data_result;
        }
      }
      public function markOpen(Request $request)
      {
        $id = $request->token_b;
        $customer_credit_note = CustomerCreditNote::findOrFail($id);
        //Logica.
        if ((int)$customer_credit_note->status == CustomerCreditNote::RECONCILED) {
          $customer_credit_note->updated_uid = \Auth::user()->id;
          $customer_credit_note->status = CustomerCreditNote::OPEN;
          $customer_credit_note->save();
          return response()->json(['status' => 200]);
        }
        else{
          return response()->json(['status' => 304]);
        }
      }
      public function markSent(Request $request)
      {
        $id = $request->token_b;
        $customer_credit_note = CustomerCreditNote::findOrFail($id);
        //Logica
        if ((int)$customer_credit_note->mail_sent != 1) {
          $customer_credit_note->updated_uid = \Auth::user()->id;
          $customer_credit_note->mail_sent = 1;
          $customer_credit_note->save();
          return response()->json(['status' => 200]);
        }
        else{
          return response()->json(['status' => 304]);
        }
      }

      public function modalSendMail(Request $request)
      {
          
          $id = $request->token_b;
          $company = Helper::defaultCompany(); //Empresa
          $customer_credit_note = CustomerCreditNote::findOrFail($id);
          //Logica
          if ($request->ajax() && !empty($id)) {
              //Correo default del cliente
              $to = [];
              $to_selected = [];
              if (!empty($customer_credit_note->customer->email)) {
                  $email = $customer_credit_note->customer->email;
                  $email = explode(";", $email);

                  $to_selected [] = $email;
              }
              //Etiquetas solo son demostrativas
              $files = [
                  'pdf' => $customer_credit_note->name . '.pdf',
                  'xml' => $customer_credit_note->name . '.xml'
              ];
              $files_selected = array_keys($files);


              $a3 = '<b>Le remitimos adjunta la siguiente factura:</b>'.'<br>';
              $a2 = $customer_credit_note->name;
              $a1 = Helper::convertSqlToDateTime($customer_credit_note->date);
              $a0 = '<br>';


              $data_result = [
                  'customer_invoice' => $customer_credit_note,
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

      public function markReconciled(Request $request)
      {
        $id = $request->token_b;
        $customer_credit_note = CustomerCreditNote::findOrFail($id);
        if ((int)$customer_credit_note->status == CustomerCreditNote::OPEN) {
          $customer_credit_note->updated_uid = \Auth::user()->id;
          $customer_credit_note->status = CustomerCreditNote::RECONCILED;
          $customer_credit_note->save();
          return response()->json(['status' => 200]);
        }
        else {
          return response()->json(['status' => 304]);
        }
      }
      /**
       * Envio de factura por correo
       *
       * @param Request $request
       * @param CustomerInvoice $customer_invoice
       * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
       */
      public function sendMail(Request $request)
      {

      }
      /**
       * Remove the specified resource from storage.
       *
       * @param  \App\Models\Sales\CustomerInvoice as CustomerCreditNote  $customer_credit_note
       * @return \Illuminate\Http\Response
      */
      public function destroy(Request $request)
      {
        \DB::beginTransaction();
        try {
          $id = $request->token_b;
          $customer_credit_note = CustomerCreditNote::findOrFail($id);
          //Logica
          if ((int)$customer_credit_note->status != CustomerCreditNote::CANCEL) {
            //Actualiza status
            $customer_credit_note->updated_uid = \Auth::user()->id;
            $customer_credit_note->status = CustomerCreditNote::CANCEL;
            $customer_credit_note->save();
            //Actualiza saldos de facturas
            if($customer_credit_note->customerInvoiceReconcileds->isNotEmpty()){
              foreach($customer_credit_note->customerInvoiceReconcileds as $result){
                //Datos de factura
                $customer_invoice = CustomerInvoice::findOrFail($result->reconciled_id);
                //Actualiza el saldo de la factura relacionada
                $customer_invoice->balance += round(Helper::invertBalanceCurrency($customer_credit_note->currency,$result->amount_reconciled,$customer_invoice->currency->code,$result->currency_value),2);
                if($customer_invoice->balance > 0){
                    $customer_invoice->status = CustomerInvoice::OPEN;
                }
                $customer_invoice->save();
              }
            }
            //Actualiza status CFDI
            $customer_credit_note->customerInvoiceCfdi->status = 0;
            $customer_credit_note->customerInvoiceCfdi->save();
            //Cancelacion del timbre fiscal
            if (!empty($customer_credit_note->customerInvoiceCfdi->cfdi_version) && !empty($customer_credit_note->customerInvoiceCfdi->uuid)) {
              //Valida Empresa y PAC para cancelar timbrado
              PacHelper::validateSatCancelActions($customer_credit_note->customerInvoiceCfdi->pac);
              //Arreglo temporal para actualizar Customer Credit Note CFDI
              $tmp = [
                  'cancel_date' => Helper::dateTimeToSql(\Date::now()),
                  'cancel_response' => '',
                  'cancel_state' => '',
                  'rfcR' => $customer_credit_note->customer->taxid,
                  'uuid' => $customer_credit_note->customerInvoiceCfdi->uuid,
                  'total' => Helper::numberFormat($customer_credit_note->amount_total,
                      $customer_credit_note->currency->decimal_place, false),
              ];
              //Cancelar Timbrado de XML
              $class_pac = $customer_credit_note->customerInvoiceCfdi->pac->code . 'Cancel';
              $tmp = PacHelper::$class_pac($tmp,$customer_credit_note->customerInvoiceCfdi->pac);
              //Guardar registros de CFDI
              $customer_credit_note->customerInvoiceCfdi->fill(array_only($tmp,[
                'cancel_date',
                'cancel_response',
                'cancel_state',
              ]));
              $customer_credit_note->customerInvoiceCfdi->save();
            }
          }
          \DB::commit();
          return response()->json(['status' => 200]);
        }
        catch (\Exception $e) {
          DB::rollback();
          return response()->json(['error' => $e->getMessage()]);
        }
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
}
