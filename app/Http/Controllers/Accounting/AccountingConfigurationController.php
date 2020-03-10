<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AccountingConfigurationController extends Controller
{
    public function index()
    {
    	return view('permitted.accounting.accounting_configuration');
    }

    
   

}
