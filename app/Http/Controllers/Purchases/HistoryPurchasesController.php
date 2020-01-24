<?php

namespace App\Http\Controllers\Purchases;
use Auth;
use DB;
use PDF;
use Mail;
use Carbon\Carbon;
use Gerardojbaez\Money\Money;
use App\Helpers\Helper;
use App\Helpers\PacHelper;
use Jenssegers\Date\Date;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoryPurchasesController extends Controller
{
    private $list_status = [];
    public function __construct()
    {
        $this->list_status = [
            1 => 'Activo',
            0 => 'Cancelado'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $list_status = $this->list_status;
      return view('permitted.purchases.purchases_history',compact('list_status'));
    }
    public function search(Request $request)
    {
      $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
      $date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');
      $estatus = !empty($request->filter_status) ? $request->filter_status : '';
      $resultados = DB::select('CALL px_purcharses_xrango (?,?,?)',array($date_a, $date_b, $estatus));
      return json_encode($resultados);
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
    public function show(Request $request)
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
