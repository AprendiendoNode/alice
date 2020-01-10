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

  public function edit_data_customer(Request $request){
    $user_id = Auth::user()->id;

    //Guarda
    if (!empty($request->item_bank_account)) {
       foreach ($request->item_bank_account as $key => $result) {
         $status = 0;
         if(!empty($result['status'])) {
           $status = 1;
         }
         //Valida si es registro nuevo o actualizacion
         if (!empty($result['id'])) {
           DB::table('customer_bank_accounts')
           ->where('id', '=', $result['id'])
           ->update([
             'name' => $result['name'],
             'account_number' => $result['account_number'],
             'bank_id' => $result['bank_id'],
             'currency_id' => $result['currency_id'],
             'sort_order' => $key,
             'status' => $status,
             'updated_uid' => $user_id,
             'updated_at' => \Carbon\Carbon::now()
           ]);
         }
         else {
             $newId_account = DB::table('customer_bank_accounts')
             ->insertGetId([
               'customer_id' => $request->customer,
               'name' => $result['name'],
               'account_number' => $result['account_number'],
               'bank_id' => $result['bank_id'],
               'currency_id' => $result['currency_id'],
               'sort_order' => $key,
               'status' => $status,
               'created_uid' => $user_id,
               'created_at' => \Carbon\Carbon::now()
             ]);
         }
       }
    }

    return "OK";
    }

}
