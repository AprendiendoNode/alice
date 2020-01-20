<?php

namespace App\Http\Controllers\Sales;
use Auth;
use DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use App\ConvertNumberToLetters;
use App\Models\Sales\CustomerInvoice;
use App\Models\Sales\CustomerInvoiceCfdi;
use App\Models\Sales\CustomerInvoiceLine;
use App\Models\Sales\CustomerInvoiceRelation;
use App\Models\Sales\CustomerInvoiceTax;
use Mail;

class BillingReportController extends Controller
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
           
    }
    
    public function index(Request $request)
    {
        $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());

        return view('permitted.sales.billing_report', compact('currency'));
    }

    public function get_billing_report(Request $request)
    {
        // `px_reporte_facturacion`(IN fechax date, currency_idx int)
        $input_date_i = $request->date_to_search;
        $currency = $request->currency_id;

        if ($input_date_i != '') {
            $date = $input_date_i.'-01';
        }
        else {
            $date_current = date('Y-m');
            $date = $date_current.'-01';
        }

        if ($currency == '') {
            $currency = 1;
        }
        // return $date;
        $result = DB::select('CALL px_reporte_facturacion(?,?) ', array($date, $currency));

        return $result;
    }
   

}
