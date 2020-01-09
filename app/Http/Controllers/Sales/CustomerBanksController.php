<?php

namespace App\Http\Controllers\Sales;
use DB;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Helper;
use App\Models\Sales\Customer;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
class CustomerBanksController extends Controller
{

  public function index()
  {

    $customers=Customer::Select('id','name')->get();
    $banks = DB::select('CALL GetAllBankActive ()', array());
    $currencies = DB::select('CALL GetAllCurrencyActivev2 ()', array());
    return view('permitted.sales.customer_banks',compact('customers','banks','currencies'));
  }

  public function load_data_customer(Request $request){
    $id=$request->customer_id;    
    $rows_data= DB::select('CALL GetDataCustomerBanks (?)', array($id));
    return $rows_data;
    }


}
