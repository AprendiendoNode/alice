<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\ExchangeRate;
use Auth;
use DB;

class ExchangeRateController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('permitted.base.exchange_rates');
    }

    public function show()
    {
      $result = DB::select('CALL px_exchange_rates_data');
      return $result;
    }

    public function edit(Request $request)
    {
        $result = DB::table('exchange_rates')
                  ->select()
                  ->where('id', '=', $request->value)->get();

        return $result;
    }

    public function update(Request $request)
    {
      $user_id = Auth::id();
      $result = DB::table('exchange_rates')
                ->where('id', '=', $request->id_exchange)
                ->update([
                  'modified_rate' => $request->tipo_cambio,
                  'updated_uid' => $user_id,
                  'updated_at' => \Carbon\Carbon::now()
                ]);

        return response()->json(['status' => 200]);
    }

}
