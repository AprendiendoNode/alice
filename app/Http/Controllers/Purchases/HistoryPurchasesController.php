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
use App\Mail\PurchaseMail;

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
    public function index_poliza()
    {
        // return view('permitted.purchases.purchases_history',compact('statuses'));
        $providers = DB::table('customers')->select('id', 'name')->where('provider', 1)->get();
        
        return view('permitted.purchases.purchases_polizas', compact('providers'));
    }
    public function search_poliza(Request $request)
    {
      $date_from  = $request->filter_date_from;
      $date_a  = $date_from.'-01';
      $cliente = !empty($request->filter_customer_id) ? $request->filter_customer_id : 0;
      $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
      $resultados = DB::select('CALL px_purchase_poliza_xfecha (?,?)',array($date_a, $cliente));
      return json_encode($resultados);
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
    public function modal_purchase(Request $request)
    {
        $purchase = $request->valor;

        $resultados = DB::select('CALL px_purchases_xid (?)',array($purchase));
        return $resultados;
    }
    public function modal_purchase_lines(Request $request)
    {
        $purchase = $request->valor;

        $resultados = DB::select('CALL px_purchases_lines_xid (?)',array($purchase));
        return $resultados;
    }
    public function get_purchase_mov_data(Request $request)
    {
      $tipos_poliza = DB::table('Contab.tipos_poliza')->select('id', 'clave', 'descripcion')->get();
      $date_req = $request->date;
      $date_rest = $date_req.'-01';
      $date = Carbon::now();

      $next_id_num = 0;
      $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');
      // $cuentas_devoluciones_descuentos = DB::select('CALL px_cuentas_contable_5001()');

      $facturas = json_decode($request->facturas);
      $asientos = array();
      for ($i=0; $i <= (count($facturas)-1); $i++)
      {
        $data = DB::select('CALL px_poliza_compras(?)', array($facturas[$i]));

        if(count($data) > 0)
        {
          for($j=0; $j <= (count($data)-1); $j++)
          {
            array_push($asientos, $data[$j]);
          }
        }
      }
      /*----------------------------------------------------------------------
      ----------------------------------------------------------------------*/
      return view('permitted.purchases.table_asientos_contables_compras_poliza',
      compact('asientos', 'cuentas_contables', 'tipos_poliza', 'next_id_num', 'date_rest', 'date'));
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

        // $correos = ['rgonzalez@sitwifi.com','jwalker@sitwifi.com', 'mmoreno@sitwifi.com'];

        for ($i=0; $i <= (count($solicitud_id)-1); $i++) {
            $data_purchase = DB::table('purchases')->where('id', $solicitud_id[$i])->first();
            $mail_sol = DB::table('users')->where('id', $data_purchase->created_uid)->value('email');

            $mail_data = new \stdClass;
            $mail_data->status = 2;
            $mail_data->status_name = DB::table('purchases_states')->where('id', 2)->value('name');
            $mail_data->folio = $data_purchase->name;
            $mail_data->date_fact = $data_purchase->date_fact;
            $mail_data->descripcion = $data_purchase->reference;
            $mail_data->user = \Auth::user()->name;
            $mail_data->url = action('Purchases\HistoryPurchasesController@index');

            Mail::to($mail_sol)->send(new PurchaseMail($mail_data));
        }

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


        for ($i=0; $i <= (count($solicitud_id)-1); $i++) {
            $data_purchase = DB::table('purchases')->where('id', $solicitud_id[$i])->first();
            $mail_sol = DB::table('users')->where('id', $data_purchase->created_uid)->value('email');

            $mail_data = new \stdClass;
            $mail_data->status = 3;
            $mail_data->status_name = DB::table('purchases_states')->where('id', 3)->value('name');
            $mail_data->folio = $data_purchase->name;
            $mail_data->date_fact = $data_purchase->date_fact;
            $mail_data->descripcion = $data_purchase->reference;
            $mail_data->user = \Auth::user()->name;
            $mail_data->url = action('Purchases\HistoryPurchasesController@index');

            Mail::to($mail_sol)->send(new PurchaseMail($mail_data));
        }

        return $valor;
    }
    public function deny_purchase_act (Request $request) {
        $user = Auth::user()->id;
        $purchase_id= $request->get('idents');
        $valor= 'false';
        $comment = $request->comm;

        if ( auth()->user()->can('View level one payment notification') || auth()->user()->can('View level two payment notification') ){
            $count_md = DB::table('purchases')->where('id', '=', $purchase_id)->where('status', '!=', '4')->count();
            if ($count_md != '0') {
                $sql = DB::table('purchases')->where('id', '=', $purchase_id)->update(['status' => '4', 'updated_at' => Carbon::now()]);
                DB::table('purchases_status_users')->insert([
                  'purchase_id'=>$purchase_id,
                  'user_id'=>$user,
                  'status_id'=>'4',
                  'created_at'=> Carbon::now(),
                ]);
                /*$new_reg_paym = new Pay_status_user;
                $new_reg_paym->payment_id = $purchase_id;
                $new_reg_paym->user_id = $user;
                $new_reg_paym->status_id = '4';
                $new_reg_paym->save();*/
                if($comment != " " && $comment != null){
                  DB::table('deny_purchase_comments')->insert([
                    'name'=>$comment,
                    'purchase_id'=>$purchase_id,
                    'user_id'=>$user,
                    'created_at'=> Carbon::now(),
                  ]);
                }
                $valor= 'true';
            }
        }

        return $valor;
    }


}
