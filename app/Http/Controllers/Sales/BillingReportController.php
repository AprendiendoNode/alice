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
        return view('permitted.sales.billing_report');
    }

    public function get_billing_report(Request $request)
    {
        $result = DB::select('CALL ');

        return $result;
    }
   

}
