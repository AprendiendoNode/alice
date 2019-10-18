<?php

namespace App\Http\Controllers\Sales;
use Auth;
use DB;
use PDF;
use Carbon\Carbon;

use App\Helpers\Cfdi33Helper;
use App\Helpers\Helper;
use App\Helpers\PacHelper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

use App\Models\Sales\Customer;
use App\Models\Catalogs\Currency;
use App\Models\Catalogs\Tax;
use App\Models\Sales\CustomerInvoice as CustomerCreditNote;
use App\Models\Sales\CustomerInvoiceCfdi as CustomerCreditNoteCfdi;
use App\Models\Sales\CustomerInvoiceLine as CustomerCreditNoteLine;
use App\Models\Sales\CustomerInvoiceRelation as CustomerCreditNoteRelation;
use App\Models\Sales\CustomerInvoiceTax as CustomerCreditNoteTax;
use App\Models\Sales\CustomerInvoiceReconciled as CustomerCreditNoteReconciled;

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
            CustomerCreditNote::OPEN => __('sales/customer_credit_note.text_status_open'),
            CustomerCreditNote::RECONCILED => __('sales/customer_credit_note.text_status_reconciled'),
            CustomerCreditNote::CANCEL => __('sales/customer_credit_note.text_status_cancel'),
        ];
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
        $amount_discount = 0;
        $amount_untaxed = 0;
        $amount_tax = 0;
        $amount_tax_ret = 0;
        $amount_total = 0;
        $balance = 0;
        $taxes = array();

        $currency_id = $request->currency_value; //MONEDA ORIGINAL
        $currency_value = $request->currency_value; //TIPO DE CAMBIO ORIGINAL
        $resp_currency_value = $request->currency_value;
        $tipo_cambio_product = 1; //TIPO DE CAMBIO A ALMACENAR
        //Lineas
        if (!empty($request->item)) {
          foreach ($request->item as $key => $item) {
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
                  //Sumatoria de impuestos
                  $taxes[$tax_id] = array(
                      'amount_base' => $item_amount_untaxed + (isset($taxes[$tax_id]['amount_base']) ? $taxes[$tax_id]['amount_base'] : 0),
                      'amount_tax' => $tmp + (isset($taxes[$tax_id]['amount_tax']) ? $taxes[$tax_id]['amount_tax'] : 0),
                  );
                }
              }
            }
            $moneda_id = $item['current']; //ID MONEDA PRODUCTO
            $item_amount_total = $item_amount_untaxed + $item_amount_tax + $item_amount_tax_ret;
            $item_subtotal = $item_amount_untaxed;

            if ($item['current'] != $currency_id) {
              // code...
              if ( $item['current'] === '2') { //ES DOLAR
                $current_select_rate = DB::table('exchange_rates')->select('current_rate')->latest()->first();
                $currency_value = $current_select_rate->current_rate;
                $currency_code = DB::table('currencies')->select('code_banxico')->where('id', $currency_id)->value('code_banxico');
                $item_amount_tax = $item_amount_tax * $currency_value;
                $item_amount_total = $item_amount_total * $currency_value;
                $item_subtotal = $item_subtotal * $currency_value;
                $tipo_cambio_product =$currency_value;//ALMACENO TIPO CAMBIO
              }
              else { //moneda distinta
                $currency_value = DB::table('currencies')->select('rate')->where('id', $item['current'])->value('rate');
                $currency_code = DB::table('currencies')->select('code_banxico')->where('id', $item['current'])->value('code_banxico');
                if ($currency_id === '2') { //SI LA MONEDA SELECCIONADA ES DOLAR
                   $item_amount_total = $item_amount_total/$resp_currency_value;
                   $item_amount_tax = $item_amount_tax / $resp_currency_value;
                   $item_subtotal = $item_subtotal / $resp_currency_value;
                   $tipo_cambio_product =$resp_currency_value;//ALMACENO TIPO CAMBIO
                }
                else {
                  $item_amount_total = $item_amount_total*$currency_value;
                  $tipo_cambio_product =$currency_value;//ALMACENO TIPO CAMBIO
                }
              }
            }
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
                'currency_value' => $tipo_cambio_product,
            ]);

            //Guardar impuestos por linea
            if (!empty($item['taxes'])) {
                $customer_credit_note_line->taxes()->sync($item['taxes']);
            } else {
                $customer_credit_note_line->taxes()->sync([]);
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
                      $customer_invoice = CustomerInvoice::findOrFail($item_reconciled['reconciled_id']);

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
          ///*PENDIENT*/
        }

        DB::commit();
        // all good
      } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage()->error();
        // something went wrong
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
