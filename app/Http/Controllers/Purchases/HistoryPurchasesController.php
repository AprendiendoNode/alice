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
    public function index_poliza_pay()
    {
      $tipos_poliza = DB::table('Contab.tipos_poliza')->select('id', 'clave', 'descripcion')->get();
      $providers = DB::table('customers')->select('id', 'name')->where('provider', 1)->get();
      return view('permitted.purchases.purchases_polizas_pay', compact('providers', 'tipos_poliza'));
    }
    public function search_poliza_pay(Request $request)
    {
      $date_from  = $request->filter_date_from;
      $date_a  = $date_from.'-01';
      $cliente = !empty($request->filter_customer_id) ? $request->filter_customer_id : 0;
      $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
      $resultados = DB::select('CALL px_purchase_con_polizadiario_xfecha (?,?)',array($date_a, $cliente));
      return json_encode($resultados);
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
    public function get_purchase_mov_pay_data(Request $request)
    {
      $tipo_poliza = $request->tipo_poliza;
      $nombre_poliza = DB::table('Contab.tipos_poliza')->select('descripcion')->where('id', $tipo_poliza)->value('descripcion');
      // $next_id_num = 0;
      $next_id_num = $this->getNextDocumentType($tipo_poliza);
      $date_req = $request->date;
      $date_rest = $date_req.'-01';
      $date = Carbon::now();
      //date de test.
      $date_pay = '20200330';
      //$date_pay = date('Y-m-d');

      $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');
      // $cuentas_devoluciones_descuentos = DB::select('CALL px_cuentas_contable_5001()');

      $facturas = json_decode($request->facturas);
      $asientos = array();
      for ($i=0; $i <= (count($facturas)-1); $i++)
      {
        // Procedure recibe (id_purchase, tipo_poliza, fecha_pago);
        $data = DB::select('CALL px_poliza_mov_egresos(?,?,?)', array($facturas[$i], $tipo_poliza, $date_pay));

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
      return view('permitted.purchases.table_asientos_contables_compras_pay_poliza',
      compact('asientos', 'cuentas_contables', 'nombre_poliza','tipo_poliza', 'next_id_num', 'date_rest', 'date'));

    }
    public function getNextDocumentType($value)
    {
      try {
          $data = [];

          $document_type = DB::connection('contabilidad')
                        ->table('tipos_poliza')
                        ->where('id', '=', $value)
                        ->select('id','clave', 'descripcion', 'contador')
                        ->get();
          if (!empty($document_type)) {
            $document_type[0]->contador += 1;
            $data['folio'] = $document_type[0]->contador;
            $data['name'] = $document_type[0]->clave;
            $data['id'] = $document_type[0]->id;
          } else {
              throw new \Exception(__('document_type.error_next_document_type'));
          }
          if (empty($data['id']) || empty($data['name'])) {
              throw new \Exception(__('document_type.error_next_document_type'));
          }
          return $data['folio'];
      } catch (\Exception $e) {
          throw $e;
      }
    }
    public static function GetNextContador(Request $request)
    {
       try {
           $data = [];

           $document_type = DB::connection('contabilidad')
                         ->table('tipos_poliza')
                         ->where('id', '=', $request->document_type)
                         ->select('id','clave', 'descripcion', 'contador')
                         ->get();
           if (!empty($document_type)) {
             $document_type[0]->contador += 1;
             $data['folio'] = $document_type[0]->contador;
             $data['name'] = $document_type[0]->clave;
             $data['id'] = $document_type[0]->id;
           } else {
               throw new \Exception(__('document_type.error_next_document_type'));
           }
           if (empty($data['id']) || empty($data['name'])) {
               throw new \Exception(__('document_type.error_next_document_type'));
           }
           return $data['folio'];
       } catch (\Exception $e) {
           throw $e;
       }
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

    public function purchase_polizas_movs_save(Request $request)
    {
      //Objeto de polizas
      $asientos = $request->movs_polizas;
      $asientos_data = json_decode($asientos);
      $tam_asientos = count($asientos_data);

      $flag = "false";
      //return $request;
      //return $asientos_data;
      DB::beginTransaction();
      try {
        $id_poliza = DB::table('polizas')->insertGetId([
            'tipo_poliza_id' => $request->type_poliza,
            'numero' => $request->num_poliza,
            'fecha' => $request->date_resive,
            'descripcion' => $request->descripcion_poliza,
            'total_cargos' => $request->total_cargos_format,
            'total_abonos' => $request->total_abonos_format
        ]);
        // Probar esta mierda en la nube...
        $success_var = DB::select('CALL Contab.px_actualiza_contador_xbanco(?, ?)', array($request->type_poliza, $request->num_poliza));
        //Insertando movimientos de las polizas
        for ($i=0; $i < $tam_asientos; $i++)
        {
          if ( $asientos_data[$i]->cuenta_contable_id ) {
            if ( $asientos_data[$i]->cargo == 0 && $asientos_data[$i]->abono == 0) {
               /* NO_INSERTAR */
            }
            else{
              /* SE INSERTAR */
              // Obtener fecha factura para balanza
              $fecha_fact = DB::table('purchases')->select('date_fact')->where('id', $asientos_data[$i]->factura_id)->value('date_fact');
              //return $fecha_fact;
              // Se aculuman saldos en la balanza aqui!
              // Tira error de undefined offset...
              $cc_array = DB::select('CALL Contab.px_busca_cuentas_xid(?)', array($asientos_data[$i]->cuenta_contable_id));
              $res = $this->add_balances_polizas_ingresos($cc_array, $fecha_fact, $asientos_data[$i]->cargo, $asientos_data[$i]->abono);
              //
              $sql = DB::table('polizas_movtos')->insert([
                'poliza_id' => $id_poliza,
                'cuenta_contable_id' => $asientos_data[$i]->cuenta_contable_id,
                'purchase_id' => $asientos_data[$i]->factura_id,
                'fecha' => $request->date_resive,
                'exchange_rate' => $asientos_data[$i]->tipo_cambio,
                'descripcion' => $asientos_data[$i]->nombre,
                'cargos' => $asientos_data[$i]->cargo,
                'abonos' => $asientos_data[$i]->abono,
                'referencia' => $asientos_data[$i]->referencia
              ]);
              //Marcando facturas a contabilizado
              $customer_invoice = Purchase::findOrFail($asientos_data[$i]->factura_id);
              $customer_invoice->contabilizado = 1;
              $customer_invoice->save();



            }
          }
        }
        DB::commit();
        $flag = "true";
      } catch(\Exception $e){
          $error = $e->getMessage();
          DB::rollback();
          return $error;
      }
      return  $flag;
    }

    public function purchase_polizas_movs_save_pay(Request $request){
      //Objeto de polizas
      $asientos = $request->movs_polizas;
      $asientos_data = json_decode($asientos);
      $tam_asientos = count($asientos_data);

      $flag = "false";
      //return $request;
      //return $asientos_data;
      DB::beginTransaction();
      try {
        $id_poliza = DB::table('polizas')->insertGetId([
            'tipo_poliza_id' => $request->type_poliza,
            'numero' => $request->num_poliza,
            'fecha' => $request->date_resive,
            'descripcion' => $request->descripcion_poliza,
            'total_cargos' => $request->total_cargos_format,
            'total_abonos' => $request->total_abonos_format
        ]);
        // Probar esta mierda en la nube...
        $success_var = DB::select('CALL Contab.px_actualiza_contador_xbanco(?, ?)', array($request->type_poliza, $request->num_poliza));
        //Insertando movimientos de las polizas
        for ($i=0; $i < $tam_asientos; $i++)
        {
          if ( $asientos_data[$i]->cuenta_contable_id ) {
            if ( $asientos_data[$i]->cargo == 0 && $asientos_data[$i]->abono == 0) {
               /* NO_INSERTAR */
            }
            else{
              /* SE INSERTAR */
              // Obtener fecha factura para balanza
              $fecha_fact = DB::table('purchases')->select('date_fact')->where('id', $asientos_data[$i]->factura_id)->value('date_fact');
              //return $fecha_fact;
              // Se aculuman saldos en la balanza aqui!
              // Tira error de undefined offset...
              $cc_array = DB::select('CALL Contab.px_busca_cuentas_xid(?)', array($asientos_data[$i]->cuenta_contable_id));
              $res = $this->add_balances_polizas_ingresos($cc_array, $fecha_fact, $asientos_data[$i]->cargo, $asientos_data[$i]->abono);
              //
              $sql = DB::table('polizas_movtos')->insert([
                'poliza_id' => $id_poliza,
                'cuenta_contable_id' => $asientos_data[$i]->cuenta_contable_id,
                'purchase_id' => $asientos_data[$i]->factura_id,
                'fecha' => $request->date_resive,
                'exchange_rate' => $asientos_data[$i]->tipo_cambio,
                'descripcion' => $asientos_data[$i]->nombre,
                'cargos' => $asientos_data[$i]->cargo,
                'abonos' => $asientos_data[$i]->abono,
                'referencia' => $asientos_data[$i]->referencia
              ]);
              //Marcando facturas a contabilizado
              $customer_invoice = Purchase::findOrFail($asientos_data[$i]->factura_id);
              $customer_invoice->pagado = 1;
              $customer_invoice->save();



            }
          }
        }
        DB::commit();
        $flag = "true";
      } catch(\Exception $e){
          $error = $e->getMessage();
          DB::rollback();
          return $error;
      }
      return  $flag;
    }
    public function add_balances_polizas_ingresos($cc_array, $periodo, $cargo, $abono)
    {
        $explode = explode('-', $periodo);
        $anio = $explode[0];
        $mes = $explode[1];
        $mes = 01;

        foreach($cc_array as $cc)
        {
            //Obtengo saldos de la cuenta contable en la balanza en el periodo requerido
            $result = DB::table('Contab.balanza')->select('cargos', 'abonos', 'sdo_inicial', 'sdo_final')
            ->where('anio', $anio)
            ->where('mes', $mes)
            ->where('cuenta_contable_id', $cc->cuenta_contable_id)
            ->get();
            //return $result;
            $saldo_inicial = $result[0]->sdo_inicial;
            $saldo_final = $result[0]->sdo_final;
            //Sumo totales de la poliza con el acumulado en la balanza
            $total_cargos = $result[0]->cargos + $cargo;
            $total_abonos = $result[0]->abonos + $abono;
            //Calculo el saldo final de la cuenta contable dependiendo su naturaleza
            //if($cc->naturaleza == 'A'){
                //$saldo_final = $saldo_inicial + $total_abonos - $total_cargos;
            //}else if($cc->naturaleza == 'D'){
                $saldo_final = $saldo_inicial + $total_cargos - $total_abonos;
            //}
            //Actualizo la balanza de la cuenta contable en el periodo que le corresponde
            DB::table('Contab.balanza')
                ->where('anio', $anio)
                ->where('mes', $mes)
                ->where('cuenta_contable_id', $cc->cuenta_contable_id)
                ->update([
                    'cargos' => $total_cargos,
                    'abonos' => $total_abonos,
                    'sdo_final' => $saldo_final
                ]);
        }
    }

    public function history_purchases(){
      return view('permitted.purchases.new_history_purchases');
    }

    public function search_history(Request $request)
    {
        $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
        $date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');

        $resultados = DB::select('CALL px_purchases_xrango_hist (?,?)',array($date_a, $date_b));
        return $resultados;
    }

}
