<?php

namespace App\Http\Controllers\Purchases;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Base\DocumentType;

class PurchasesController extends Controller
{
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

      $document_type = DocumentType::where('cfdi_type_id', 1)->get();// Solo documentos de ingresos

      $cxclassifications = DB::table('cxclassifications')->select('id', 'name')->get();

        return view('permitted.purchases.purchase_view', compact(
        'customer','sucursal','currency',
        'salespersons','payment_way','payment_term',
        'payment_methods', 'cfdi_uses', 'cfdi_relations',
        'product', 'unitmeasures', 'satproduct', 'impuestos', 'cxclassifications', 'document_type'
      ));

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
