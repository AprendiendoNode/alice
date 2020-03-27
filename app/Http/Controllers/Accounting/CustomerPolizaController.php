<?php

namespace App\Http\Controllers\Accounting;
use Auth;
use DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gerardojbaez\Money\Money;
use App\Exports\CustomerInvoicesExport;
use App\Models\Base\DocumentType;
use App\Models\Catalogs\CfdiRelation;
use App\Models\Catalogs\CfdiUse;
use App\Models\Sales\Customer;
use App\Models\Sales\CustomerInvoice;
use App\Models\Sales\CustomerInvoiceCfdi;
use App\Models\Sales\CustomerInvoiceLine;
use App\Models\Sales\CustomerInvoiceRelation;
use App\Models\Sales\CustomerInvoiceTax;
use App\Models\Sales\CustomerPayment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\ConvertNumberToLetters;
use Mail;
use App\Models\Purchases\Purchase;
class CustomerPolizaController extends Controller
{

    public function __construct()
    {
        $this->list_status = [
            CustomerInvoice::OPEN => __('customer_invoice.text_status_open'),
            CustomerInvoice::PAID => __('customer_invoice.text_status_paid'),
            CustomerInvoice::CANCEL => __('customer_invoice.text_status_cancel'),
            CustomerInvoice::CANCEL_PER_AUTHORIZED => __('customer_invoice.text_status_cancel_per_authorized'),
        ];
    }

    public function index()
    {
        $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');
        $tipos_poliza = DB::table('Contab.tipos_poliza')->select('id', 'clave', 'descripcion')->get();

        return view('permitted.accounting.create_polizas', compact('cuentas_contables', 'tipos_poliza'));
    }

    public function view_poliza_ingreso()
    {
        return view('permitted.accounting.polizas_ingresos');
    }

    public function facturas_contabilizadas_data(Request $request)
    {
        $date_from  = $request->filter_date_from;
		$date_to  = $request->filter_date_to;

		$date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
        $date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');
        
        $result = DB::select('CALL px_customer_polizas_filters_type_contabilizado(?,?,?)', array($date_a, $date_b, '1'));

        return $result;
    }

    public function view_cxc()
    {
        //px_customer_polizas_filters_type_contabilizado

        return view('permitted.accounting.cxc_history');
    }

    public function cxc_data(Request $request)
    {
        $date_from  = $request->filter_date_from;
		$date_to  = $request->filter_date_to;

		$date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
        $date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');
        
        $result = DB::select('CALL px_antiguedad_saldos()', array());

        return $result;
    }

	/**
	 * Muestra el apartado de todas las facturas
	*
	* @return \Illuminate\Http\Response
	*/
    public function show()
    {
        $customer = DB::select('CALL px_only_customer_data ()', array());

        return view('permitted.accounting.polizas_show',compact( 'customer'));
	}

	public function get_data_poliza(Request $request)
	{
		$id_invoice = $request->id_invoice;
		$result = DB::select('CALL px_poliza_xfactura(?)', array($id_invoice));

		return $result;
	}

	public function search(Request $request)
	{
		$folio = !empty($request->filter_name) ? $request->filter_name : '';
		$date_from  = $request->filter_date_from;
		$date_to  = $request->filter_date_to;

		$date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
		$date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');
		$resultados = DB::select('CALL px_customer_polizas_filters_type (?,?,?)',array($date_a, $date_b, '1'));

		return json_encode($resultados);
	}

    public function save_poliza_movs(Request $request)
    {
        
        try {

            DB::transaction(function () use($request){
                //Objeto de polizas
                $asientos = $request->movs_polizas;
                $asientos_data = json_decode($asientos);

                $tam_asientos = count($asientos_data);
                $flag = "false";
                
                $id_poliza = DB::table('polizas')->insertGetId([
                    'tipo_poliza_id' => $request->type_poliza,
                    'numero' => $request->num_poliza,
                    'fecha' => $request->date_invoice,
                    'descripcion' => $request->descripcion_poliza,
                    'total_cargos' => $request->total_cargos_format,
                    'total_abonos' => $request->total_abonos_format
                ]);
    
                //Insertando movimientos de las polizas
                for ($i=0; $i < $tam_asientos; $i++)
                {
                  if ( $asientos_data[$i]->cuenta_contable_id ) {
                    if ( $asientos_data[$i]->cargo == 0 && $asientos_data[$i]->abono == 0) {
                       /* NO_INSERTAR */
                    }
                    else{
                      /* INSERTAR */
    
                      //Acumulando saldos
                      $cc_array = DB::select('CALL Contab.px_busca_cuentas_xid(?)', array($asientos_data[$i]->cuenta_contable_id));
                      $this->add_balances_polizas_ingresos($cc_array, $request->date_invoice, $asientos_data[$i]->cargo, $asientos_data[$i]->abono);
    
                      $sql = DB::table('polizas_movtos')->insert([
                        'poliza_id' => $id_poliza,
                        'cuenta_contable_id' => $asientos_data[$i]->cuenta_contable_id,
                        'customer_invoice_id' => $asientos_data[$i]->factura_id,
                        'fecha' => $request->date_invoice,
                        'exchange_rate' => $asientos_data[$i]->tipo_cambio,
                        'descripcion' => $asientos_data[$i]->nombre,
                        'cargos' => $asientos_data[$i]->cargo,
                        'abonos' => $asientos_data[$i]->abono,
                        'referencia' => $asientos_data[$i]->referencia
                      ]);
                      //Marcando facturas a contabilizado
                      $customer_invoice = CustomerInvoice::findOrFail($asientos_data[$i]->factura_id);
                      $customer_invoice->contabilizado = 1;
                      $customer_invoice->save();
                      
                    }
                  }
                }
            });

            $flag = "true";


        } catch(\Exception $e){
            $error = $e->getMessage();
            dd($error);
        }

        return  $flag;

    }

    public function add_balances_polizas_ingresos($cc_array, $periodo, $cargo, $abono)
    {
        $explode = explode('-', $periodo);
        $anio = $explode[0];
        $mes = $explode[1];

        foreach($cc_array as $cc)
        {
            //Obtengo saldos de la cuenta contable en la balanza en el periodo requerido
            $result = DB::table('Contab.balanza')->select('id','cargos', 'abonos', 'sdo_inicial', 'sdo_final')
                ->where('anio', $anio)
                ->where('mes', $mes)
                ->where('cuenta_contable_id', $cc->cuenta_contable_id)
                ->get();
            
            $saldo_inicial = $result[0]->sdo_inicial;
            $saldo_final = $result[0]->sdo_final;
            //Sumo totales de la poliza con el acumulado en la balanza
            $total_cargos = $result[0]->cargos + $cargo;
            $total_abonos = $result[0]->abonos + $abono;
            $saldo_final = $saldo_inicial + $total_cargos - $total_abonos;          
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

    public function cancel_balances_polizas_ingresos($cc_array, $periodo, $cargo, $abono)  
    {
        $explode = explode('-', $periodo);
        $anio = $explode[0];
        $mes = $explode[1];
       
        foreach($cc_array as $cc)
        {
            $explode = explode('-', $periodo);
            $anio = $explode[0];
            $mes = $explode[1];   
            //Obtengo saldos de la cuenta contable en la balanza en el periodo requerido
            $result = DB::table('Contab.balanza')->select('id','cargos', 'abonos', 'sdo_inicial', 'sdo_final')
            ->where('anio', $anio)
            ->where('mes', $mes)
            ->where('cuenta_contable_id', $cc->cuenta_contable_id)
            ->get();
            
            $saldo_inicial = $result[0]->sdo_inicial;
            $saldo_final = $result[0]->sdo_final;
            //Resto totales de la balanza para cancelar el saldo de la poliza
            $total_cargos = $result[0]->cargos - $cargo;
            $total_abonos = $result[0]->abonos - $abono;   
            $saldo_final = $saldo_inicial + $total_cargos - $total_abonos; 
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

    public function update_poliza_movs(Request $request)
    {
        $date = \Carbon\Carbon::now();
        //Objeto de polizas
        $asientos = $request->movs_polizas;
        $asientos_data = json_decode($asientos);

        DB::beginTransaction();

        try {

            DB::table('polizas')
                ->where('id' ,$request->poliza_id)
                ->update([
                'tipo_poliza_id' => $request->type_poliza,
                'numero' => $request->num_poliza,
                'descripcion' => $request->descripcion_poliza,
                'total_cargos' => $request->total_cargos_format,
                'total_abonos' => $request->total_abonos_format,
                'updated_at' => $date
            ]);

            $asientos_contables_poliza = DB::table('polizas_movtos')->select('cuenta_contable_id', 'cargos', 'abonos','fecha')->where('poliza_id', '=', $request->poliza_id)->get();
                    
            foreach($asientos_contables_poliza as $asiento)
            {                                                                                                                                            
                //Deshaciendo saldos  en balanza￼￼ con totales
                $cc_array = DB::select('CALL Contab.px_busca_cuentas_xid(?)', array($asiento->cuenta_contable_id));
                $this->cancel_balances_polizas_ingresos($cc_array, $asiento->fecha, $asiento->cargos, $asiento->abonos);        
            }

            //actualizando movimientos de las polizas
            foreach ($asientos_data as $asientos_new)
            {         
                //Actualizando saldos
                $cc_array2 = DB::select('CALL Contab.px_busca_cuentas_xid(?)', array($asientos_new->cuenta_contable_id));           
                $this->add_balances_polizas_ingresos($cc_array2, $request->date_invoice, $asientos_new->cargo, $asientos_new->abono);

                $sql = DB::table('polizas_movtos')
                    ->where('id' ,$asientos_new->id)
                    ->update([
                    'cuenta_contable_id' => $asientos_new->cuenta_contable_id,
                    'customer_invoice_id' => $asientos_new->factura_id,
                    'fecha' => $request->date_invoice,
                    'exchange_rate' => $asientos_new->tipo_cambio,
                    'descripcion' => $asientos_new->nombre,
                    'cargos' => $asientos_new->cargo,
                    'abonos' => $asientos_new->abono,
                    'referencia' => $asientos_new->referencia,
                    'updated_at' => $date
                ]);
            }

            DB::commit();

            $flag = "true";

        } catch(\Exception $e){
            $error = $e->getMessage();
            DB::rollback();
            dd($error);
        }

        return  $flag;

    }

    //MOVIMIENTOS DE POLIZA DE DIARIO
    public function get_facts_mov_data(Request $request)
    {
        $tipos_poliza = DB::table('Contab.tipos_poliza')->select('id', 'clave', 'descripcion')->get();
        $next_id_num = DB::table('polizas')->max('numero') + 1;
        $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');
        $facturas = json_decode($request->facturas);
        $asientos = array();
        for ($i=0; $i <= (count($facturas)-1); $i++)
        {
            $data = DB::select('CALL px_poliza_xfactura_cc(?)', array($facturas[$i]));

            if(count($data) > 0)
            {
                for($j=0; $j <= (count($data)-1); $j++)
                {
                    array_push($asientos, $data[$j]);
                }
            }
        }

        return view('permitted.accounting.table_asientos_contables',
               compact('asientos', 'cuentas_contables', 'tipos_poliza', 'next_id_num'));
    }

    //MOVIMIENTOS DE POLIZA DE INGRESOS
    public function get_facts_poliza_ingreso_mov_data(Request $request)
    {
        $tipos_poliza = DB::table('Contab.tipos_poliza')->select('id', 'clave', 'descripcion')->get();
        $next_id_num = DB::table('polizas')->max('numero') + 1;
        $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');
        $facturas = json_decode($request->facturas);
        $asientos = array();
        for ($i=0; $i <= (count($facturas)-1); $i++)
        {
            $data = DB::select('CALL px_poliza_xfactura_cc(?)', array($facturas[$i]));

            if(count($data) > 0)
            {
                for($j=0; $j <= (count($data)-1); $j++)
                {
                    array_push($asientos, $data[$j]);
                }
            }
        }

        return view('permitted.accounting.table_asientos_contables',
               compact('asientos', 'cuentas_contables', 'tipos_poliza', 'next_id_num'));
    }

    public function get_movtos_by_poliza(Request $request)
    {
        $id_poliza = $request->poliza_id;
        $tipos_poliza = DB::table('Contab.tipos_poliza')->select('id', 'clave', 'descripcion')->get();
        $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');
        $poliza_header = DB::select('CALL px_enc_poliza_xid(?)', array($id_poliza));

        $asientos = DB::select('CALL px_polizas_movtos_xpoliza(?)', array($id_poliza));

        if(auth()->user()->can('Polizas readonly')){
            return view('permitted.accounting.table_poliza_movs_readonly',
               compact('asientos', 'cuentas_contables', 'tipos_poliza', 'poliza_header'));
        }else{
            return view('permitted.accounting.table_poliza_movs_edit',
               compact('asientos', 'cuentas_contables', 'tipos_poliza', 'poliza_header'));
        }

    }


    public function delete_poliza(Request $request)
    {
        if(auth()->user()->can('Polizas delete')) {
            $id_poliza = json_encode($request->id_poliza);
            $flag = "3";

            if($id_poliza != null && $id_poliza != ''){

                DB::beginTransaction();

                try {                  
                    //Reestableciendo bandera de contabilizando a 0  de las facturas involucradas
                    $ids_customers = DB::table('polizas_movtos')->select()->where('poliza_id', '=', $id_poliza )->pluck('customer_invoice_id');
                    $ids_customers_unique = $ids_customers->unique();
                    if (empty($ids_customers_unique[0])) {
                      /*COMPRAS*/
                      $ids_customers = DB::table('polizas_movtos')->select()->where('poliza_id', '=', $id_poliza )->pluck('purchase_id');
                      $ids_customers_unique = $ids_customers->unique();
                      $customer_invoice = Purchase::whereIn('id', $ids_customers_unique)->update(['contabilizado' => 0]);
                    }
                    else {
                        //Deshaciendo saldos  en balanza￼￼        
                        $asientos_contables = DB::table('polizas_movtos')->select('cuenta_contable_id', 'cargos', 'abonos','fecha')->where('poliza_id', '=', $id_poliza )->get();
                        
                        foreach($asientos_contables as $asiento)
                        {
                            $cc_array = DB::select('CALL Contab.px_busca_cuentas_xid(?)', array($asiento->cuenta_contable_id));
                            $this->cancel_balances_polizas_ingresos($cc_array, $asiento->fecha, $asiento->cargos, $asiento->abonos);
                        }

                        $customer_invoice = CustomerInvoice::whereIn('id', $ids_customers_unique)->update(['contabilizado' => 0]);
                    }
                    
                     //Eliminando partidas dentro de la poliza
                    DB::table('polizas_movtos')->where('poliza_id', '=', $id_poliza )->delete();
                    //Eliminando poliza
                    DB::table('polizas')->where('id', '=', $id_poliza)->delete();
                    DB::commit();

                    $flag = "1";

                } catch(\Exception $e){
                    $error = $e->getMessage();
                    DB::rollback();
                    dd($error);
                }
            }
        }else {
            $flag = "2";
        }

        return  $flag;
    }

    public function create_poliza_without_invoice(Request $request)
    {
        //Objeto de polizas
        $asientos = $request->movs_polizas;
        $asientos_data = json_decode($asientos);

        $tam_asientos = count($asientos_data);
        $flag = "false";

        DB::beginTransaction();

        try {

            $id_poliza = DB::table('polizas')->insertGetId([
                'tipo_poliza_id' => $request->type_poliza,
                'numero' => $request->num_poliza,
                'fecha' => $request->date_invoice,
                'descripcion' => $request->descripcion_poliza,
                'total_cargos' => $request->total_cargos_format,
                'total_abonos' => $request->total_abonos_format
            ]);

            //Insertando movimientos de las polizas
            for ($i=0; $i < $tam_asientos; $i++)
            {
              if ( $asientos_data[$i]->cuenta_contable_id ) {
                if ( $asientos_data[$i]->cargo == 0 && $asientos_data[$i]->abono == 0) {
                   /* NO_INSERTAR */
                }
                else{
                  /* SE INSERTAR */
                  $sql = DB::table('polizas_movtos')->insert([
                    'poliza_id' => $id_poliza,
                    'cuenta_contable_id' => $asientos_data[$i]->cuenta_contable_id,
                    'fecha' => $request->date_invoice,
                    'exchange_rate' => $asientos_data[$i]->tipo_cambio,
                    'descripcion' => $asientos_data[$i]->nombre,
                    'cargos' => $asientos_data[$i]->cargo,
                    'abonos' => $asientos_data[$i]->abono,
                    'referencia' => $asientos_data[$i]->referencia
                  ]);
                }
              }
            }

            DB::commit();

            $flag = "true";


        } catch(\Exception $e){
            $error = $e->getMessage();
            DB::rollback();
            dd($error);
        }

        return  $flag;
    }

}
