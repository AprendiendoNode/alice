<?php

namespace App\Http\Controllers\Purchases;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use File;
use Storage;
use App\Models\Base\DocumentType;
use App\Helpers\Helper;

use Carbon\Carbon;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = DB::table('customers')->select('id', 'name')->where('provider', 1)->get();
        // $customer = DB::select('CALL px_only_customer_data ()', array());
        $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
        $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
        // $salespersons = DB::select('CALL GetAllSalespersonv2 ()', array());
        $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
        $payment_term = DB::select('CALL GetAllPaymentTermsv2 ()', array());
        $payment_methods = DB::select('CALL GetAllPaymentMethodsv2 ()', array());
        $cfdi_uses = DB::select('CALL GetAllCfdiUsev2 ()', array());
        $cfdi_relations = DB::select('CALL GetAllCfdiRelationsv2 ()', array());

        $product =  DB::select('CALL GetAllProductActivev2 ()', array());
        $unitmeasures = DB::select('CALL GetUnitMeasuresActivev2 ()', array());
        $satproduct = DB::select('CALL GetSatProductActivev2 ()', array());
        $impuestos =  DB::select('CALL GetAllTaxesActivev2 ()', array());

        $document_type = DocumentType::where('cfdi_type_id', 1)->get();// Solo documentos de ingresos

        $cxclassifications = DB::table('cxclassifications')->select('id', 'name')->get();

        return view('permitted.purchases.purchase_view', compact('providers','sucursal','currency','payment_way','payment_term', 'payment_methods', 'cfdi_uses', 'cfdi_relations', 'product', 'unitmeasures', 'satproduct', 'impuestos', 'cxclassifications', 'document_type'));
    }

    public function get_currency(Request $request)
    {

        $currency = $request->id_currency;
        $date = Carbon::parse($request->date)->format('Y-m-d');
        // $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
        // Carbon::now()

        if ($request->id_currency == 2) {
            $current_rate = DB::table('exchange_rates')->select('current_rate')->where('current_date', $date)->first();
            // $current_rate = DB::table('exchange_rates')->select('current_rate')->latest()->first();
            if (empty($current_rate)) {
              return response()->json(['error' => __('general.error_general')], 422);
            }
            else{
              return $current_rate->current_rate;
            }
        }
        else {
            $item_currency_code = DB::table('currencies')->select('rate')
            ->where('id', $currency)->value('rate');
            return $item_currency_code;
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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

        $provider = $request->customer_id;
        $currency = $request->currency_id;
        $currency_value = $request->currency_value;
        $date_actual = $request->date;
        $date_fact = $request->date_fact;
        $payment_term = $request->payment_term_id;
        $date_end = $request->date_due;
        $payment_way = $request->payment_way_id;
        $payment_method = $request->payment_method_id;
        $cfdi_use = $request->cfdi_use_id;
        $document_type = $request->document_type;
        $iva = $request->iva_general;
        $iva_ret = $request->iva_retencion;
        $pdf_fact = $request->file('file_pdf');
        $xml_fact = $request->file('file_xml');
        
        
        return (string)filesize($request->file('file_pdf'));

        //Factura PDF y XML
        /*if($pdf_fact != null )
        {
            $file_extension = $file_pdf->getClientOriginalExtension(); //** get filename extension
            $fileName = $factura.'_'.date("Y-m-d H:i:s").'.'.$file_extension;
            $pdf= $request->file('fileInput')->storeAs('filestore/storage/factura/'.date('Y-m'), $fileName);
            DB::table('pay_facturas')->insert([
                'name' => $pdf,
                'payment_id' => $id_payment
            ]);
        }
        if($xml_fact != null )
        {
            $file_extension = $xml_fact->getClientOriginalExtension(); //** get filename extension
            $fileName = $factura.'_'.date("Y-m-d H:i:s").'.'.$file_extension;
            $pdf= $request->file('fileInput')->storeAs('filestore/storage/factura/'.date('Y-m'), $fileName);
            DB::table('pay_facturas')->insert([
                'name' => $pdf,
                'payment_id' => $id_payment
            ]);
        }*/



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
