<?php

namespace App\Http\Controllers\Sales;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\Catalogs\Currency;
use App\Models\Catalogs\Tax;
use PDF;
use Gerardojbaez\Money\Money;

class CustomerInvoiceController extends Controller
{

    public function generate_invoice()
    {

      // Enviando datos a la vista de la factura
      $pdf = PDF::loadView('permitted.invoicing.invoice_sitwifi');
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

      return view('permitted.sales.customer_invoices',compact(
        'customer','sucursal','currency',
        'salespersons','payment_way','payment_term',
        'payment_methods', 'cfdi_uses', 'cfdi_relations',
        'product', 'unitmeasures', 'satproduct', 'impuestos'
      ));
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
      $currency_code = 'MXN'; //En caso que no haya moneda le digo por defecto es pesos mexicanos

      if ($request->ajax()) {
          //Datos de moneda - Obtengo moneda seleccionada al principio
          if (!empty($currency_id)) {
              $currency = Currency::findOrFail($currency_id);
              $currency_code = $currency->code;
          }

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
              //Subtotales por cada item
              // $items[$key] = money($item_amount_untaxed, $currency_code, true)->format();
            }
          }
          //Respuesta
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
