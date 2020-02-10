<?php

namespace App\Http\Controllers\Purchases;
use Auth;
use DB;
use PDF;

use Carbon\Carbon;
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
use App\Models\Purchases\Purchase;
use App\Models\Purchases\Purchase as CustomerCreditNote;
use App\Models\Purchases\PurchaseLine as CustomerCreditNoteLine;
use App\Models\Purchases\PurchaseTax as CustomerCreditNoteTax;
use App\Models\Purchases\PurchaseReconciled as CustomerCreditNoteReconciled;
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

use App\ConvertNumberToLetters;
use Mail;
class CustomerCreditNoteController extends Controller
{
    private $list_status = [];
    private $document_type_code = 'customer.credit_note_two';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->list_status = [
            CustomerCreditNote::ELABORADO => __('purchase.text_status_elaborado'),
            CustomerCreditNote::REVISADO => __('purchase.text_status_revisado'),
            CustomerCreditNote::AUTORIZADO => __('purchase.text_status_autorizado'),
            CustomerCreditNote::CANCELADO => __('purchase.text_status_cancelado'),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = DB::table('customers')->select('id', 'name')->where('provider', 1)->get();
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

        $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');

        return view('permitted.purchases.customer_credit_notes',
        compact('providers', 'sucursal', 'currency', 'payment_term',
         'salespersons','payment_way', 'payment_term' ,'payment_methods',
        'cuentas_contables', 'cfdi_uses', 'product', 'unitmeasures',
        'satproduct', 'impuestos', 'cfdi_relations') );
    }
    /*
     * Filtra solo las compras de la misma moneda
     */
    public function balances(Request $request)
    {
      //Variables
      $customer_id = $request->customer_id;
      $filter_currency_id = $request->currency_id;
      //Logica
      if ($request->ajax() && !empty($customer_id)) {
        $resultados = DB::select('CALL px_purchase_authorized_data (?, ?)', array($customer_id, $filter_currency_id));
        foreach ($resultados as $key) {
          $valor = $key->balance;
          $key->balance = round($valor, 2);
        }
        return response()->json($resultados, 200);
      }
      return response()->json(['error' => __('general.error500')], 422);
    }
    //
    public function getproduct(Request $request)
    {
      $id = $request->id;
      //Logica
      if ($request->ajax() && !empty($id)) {
        $resultados = DB::select('CALL GetInfoProductById (?)', array($id));
        $cuentas = DB::select('CALL px_cuenta_contable_xproducto(?)', array($id));
        $result = array_merge($resultados, $cuentas);
        return response()->json($result, 200);
      }
      return response()->json(['error' => __('general.error500')], 422);
    }
    public function getAccountingAccountProduct(Request $request)
    {
      //Variables
      $id = $request->ident;
      //Logica
      $resultados = DB::select('CALL px_cuentacontable_xprod (?)', array($id));
      return json_encode($resultados);
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
            $json->amount_per_reconciled = round($amount_total - $amount_reconciled, 2);
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
      $currency_code = 'MXN';
      $tax_items = $request->iva;

      if ($request->ajax()) {
        //Datos de moneda
        if (empty($currency_id)) {
          $currency_id = 1;
          $currency_value = 1;
        }
        if ($currency_id === 1) {
          $currency_value = 1;
        }
        if (empty($currency_value)) {
          $current_select_rate = DB::table('currencies')->select('rate')->where('id', $currency_id)->first();
          $currency_value = $current_rate->rate;
        }
        $currency_code = DB::table('currencies')->select('code')->where('id', $currency_id)->value('code');
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
            $item_discount = 0;
            $item_price_reduce = ($item_price_unit * (100 - $item_discount) / 100); //Precio reducido
            $item_amount_untaxed = round($item_quantity * $item_price_reduce, 2);//libre de impuestos
            $item_amount_discount = round($item_quantity * $item_price_unit, 2) - $item_amount_untaxed;//descuento
            $item_amount_tax = 0;
            $item_amount_tax_ret = 0;
            if (!empty($tax_items)) {
              foreach ($tax_items as $tax_id) {
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
            //Subtotales por cada item
            $items[$key] = $item_amount_untaxed;
          }
        }
        //Respuesta
        $json->items = $items;
        $json->amount_discount = $amount_discount;
        $json->amount_untaxed = $amount_untaxed;
        $json->amount_tax = round($amount_tax + $amount_tax_ret, 2);
        $json->amount_total = round($amount_total, 2);
        $json->amount_total_tmp = $amount_total;
        return response()->json($json);
      }
      return response()->json(['error' => __('general.error_general')], 422);
    }
    public function store(Request $request)
    {
      // Begin a transaction
      \DB::beginTransaction();
      // Open a try/catch block
      try {
        //Logica
        $request->merge(['created_uid' => \Auth::user()->id]);
        $request->merge(['updated_uid' => \Auth::user()->id]);
        $request->merge(['status' => CustomerCreditNote::ELABORADO]);
        //Ajusta fecha y genera fecha de vencimiento
        $date = Helper::createDateTime($request->date);
        $request->merge(['date' => Helper::dateTimeToSql($date)]);
        $date_due = $date; //La fecha de vencimiento por default
        $request->merge(['date_due' => Helper::dateToSql($date_due)]);
        //Obtiene folio
        $document_type = Helper::getNextDocumentTypeByCode('customer.credit_note_two');
        $request->merge(['document_type_id' => $document_type['id']]);
        $request->merge(['name' => $document_type['name']]);
        $request->merge(['serie' => $document_type['serie']]);
        $request->merge(['folio' => $document_type['folio']]);
        //Guardar Registro principal
        $customer_credit_note = CustomerCreditNote::create($request->input());
        //Registro de lineas
        $tax_items = $request->iva;
        $amount_discount = 0; // Descuento por cantidad
        $amount_untaxed = 0;  // Cantidad libre de impuestos
        $amount_tax = 0;      // Cantidad de impuestos
        $amount_tax_ret = 0;  // Importe retiro de impuestos
        $amount_total = 0;    // Monto total
        $balance = 0;         // Balance
        $taxes = array();     // Impuestos

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
            if (!empty($tax_items)) {
              foreach ($tax_items as $tax_id) {
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
            //Sumatoria totales
            $amount_discount += $item_amount_discount;
            $amount_untaxed += $item_amount_untaxed;
            $amount_tax += $item_amount_tax;
            $amount_tax_ret += $item_amount_tax_ret;
            $amount_total += $item_amount_total;
            //Guardar linea
            $customer_credit_note_line = CustomerCreditNoteLine::create([
                'created_uid' => \Auth::user()->id,
                'updated_uid' => \Auth::user()->id,
                'purchase_id' => $customer_credit_note->id,
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
                'cuenta_contable_id' => !empty($item['cuentac']) ? $item['cuentac'] : null,
            ]);
            //Guardar impuestos por linea
            if (!empty($tax_items)) {
                $customer_credit_note_line->taxes()->sync($tax_items);
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
                'purchase_id' => $customer_credit_note->id,
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
                    $customer_invoice = Purchase::findOrFail($item_reconciled['id']);
                    //Guardar linea
                    $customer_credit_note_reconciled = CustomerCreditNoteReconciled::create([
                        'created_uid' => \Auth::user()->id,
                        'updated_uid' => \Auth::user()->id,
                        'purchase_id' => $customer_credit_note->id,
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
            $customer_credit_note->status = CustomerCreditNote::CONCILIADA;
        }
        $customer_credit_note->update();

        DB::commit();
        return 'success';
        // all good
      }
      catch (\Exception $e) {
        DB::rollback();
        return $e;
        // something went wrong
      }
    }
}
