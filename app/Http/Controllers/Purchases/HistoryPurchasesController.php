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

use App\Models\Base\DocumentType;
use App\Models\Catalogs\PaymentTerm;
use App\Models\Purchases\Purchase;
use App\Models\Purchases\PurchaseLine;
use App\Models\Purchases\PurchaseTax;
use App\Models\Catalogs\Tax;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoryPurchasesController extends Controller
{
    // private $list_status = [];
    public function __construct()
    {
        /*$this->list_status = [
            1 => 'Activo',
            4 => 'Cancelado'
        ];*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = DB::table('purchases_states')->select('id','name')->get();
        return view('permitted.purchases.purchases_history',compact('statuses'));
    }
    public function search(Request $request)
    {
        $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
        $date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');
        $estatus = $request->filter_status;
        
        // $estatus = !empty($request->filter_status) ? $request->filter_status : '';

        $resultados = DB::select('CALL px_purchases_xrango (?,?,?)',array($date_a, $date_b, $estatus));
        return $resultados;
    }
    public function search_all(Request $request)
    {
        $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
        $date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');
        
        // $estatus = !empty($request->filter_status) ? $request->filter_status : '';

        $resultados = DB::select('CALL px_purchases_xrango (?,?,?)',array($date_a, $date_b, $estatus));
        return $resultados;
    }

    public function approval_one(Request $request)
    {
        // Pasar de 1 = Elaborado a 2 = Revisado.
        $solicitud_id = json_decode($request->idents);
        $user = Auth::user()->id;
        $valor= 'false';

        \DB::beginTransaction();

        for ($i=0; $i <= (count($solicitud_id)-1); $i++) {
          $sql = DB::table('purchases')->where('id', '=', $solicitud_id[$i])->update(['status' => '2', 'updated_at' => Carbon::now()]);
          DB::table('purchases_status_users')->insert([
            'purchase_id'=>$solicitud_id[$i],
            'user_id'=>$user,
            'status_id'=>'2',
            'created_at'=> Carbon::now()
            // 'updated_at'=>Carbon::now()
          ]);
          $valor= 'true';
        }

        DB::commit();
        return $valor;
    }
    public function approval_two(Request $request)
    {
        // Pasar de 1 = Elaborado a 2 = Revisado.
        $solicitud_id = json_decode($request->idents);
        $user = Auth::user()->id;
        $valor= 'false';

        \DB::beginTransaction();

        for ($i=0; $i <= (count($solicitud_id)-1); $i++) {
          $sql = DB::table('purchases')->where('id', '=', $solicitud_id[$i])->update(['status' => '3', 'updated_at' => Carbon::now()]);
          DB::table('purchases_status_users')->insert([
            'purchase_id'=>$solicitud_id[$i],
            'user_id'=>$user,
            'status_id'=>'3',
            'created_at'=> Carbon::now()
            // 'updated_at'=>Carbon::now()
          ]);
          $valor= 'true';
        }

        DB::commit();
        return $valor;
    }

}
