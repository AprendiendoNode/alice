<?php

namespace App\Http\Controllers\Sales;
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

	/**
	 * Muestra el apartado de todas las facturas
	*
	* @return \Illuminate\Http\Response
	*/
    public function show()
    {
        $customer = DB::select('CALL px_only_customer_data ()', array());

        return view('permitted.sales.polizas_show',compact( 'customer'));
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
		//$date_to  = $request->filter_date_to;
		$sucursal = !empty($request->filter_branch_office_id) ? $request->filter_branch_office_id : '';
		$cliente = !empty($request->filter_customer_id) ? $request->filter_customer_id : '';
		$estatus = !empty($request->filter_status) ? $request->filter_status : '';

		$date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
		//$date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');
		$resultados = DB::select('CALL px_customer_polizas_filters_type (?,?,?)',array($date_a, $folio, '1'));

		return json_encode($resultados);
	}

     //Cancela las polizas y las regresa en su historial de facturas
    public function cancel_poliza(Request $request)
    {
        $customer_invoice = CustomerInvoice::findOrFail($request->id_invoice);
        $customer_invoice->poliza = 0;
		$customer_invoice->save();
		 
		//Pendiente Cancelar movimientos
 
        return response()->json([
            'message' => " La poliza $customer_invoice->name se ha cancelado",
            'code' => 200
        ]);
 
    }

    public function save_poliza_movs(Request $request)
    {   
        $date = \Carbon\Carbon::now();
        $date = $date->format('Y-m-d');
        //Objeto de polizas
        $asientos = $request->movs_polizas;
        $asientos_data = json_decode($asientos);
        
        $tam_asientos = count($asientos_data);

        DB::beginTransaction();

        try {

            $id_poliza = DB::table('polizas')->insertGetId([
                'tipo_poliza_id' => $request->type_poliza,
                'numero' => $request->num_poliza,
                'fecha' => $date,
                'descripcion' => $request->descripcion_poliza,
                'total_cargos' => $request->total_cargos_format,
                'total_abonos' => $request->total_abonos_format
            ]);
                
            //Insertando movimientos de las polizas
            for ($i=0; $i < $tam_asientos; $i++)
            {
                $sql = DB::table('polizas_movtos')->insert([
                    'poliza_id' => $id_poliza,
                    'cuenta_contable_id' => $asientos_data[$i]->cuenta_contable_id,
                    'customer_invoice_id' => $asientos_data[$i]->factura_id,
                    'fecha' => $date, 
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

            DB::commit();

            $flag = "true";


        } catch(\Exception $e){
            $error = $e->getMessage();
            DB::rollback();
            dd($error);
        }

        return  $flag;

    }

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
        	
        return view('permitted.sales.table_asientos_contables', 
               compact('asientos', 'cuentas_contables', 'tipos_poliza', 'next_id_num'));	
    }

    public function get_movtos_by_poliza(Request $request)
    {
        $id_poliza = $request->id_poliza;
        $tipos_poliza = DB::table('Contab.tipos_poliza')->select('id', 'clave', 'descripcion')->get();
        $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');

        $data = DB::select('CALL px_polizas_movtos_xpoliza(?)', array($id_poliza));

        return $data;
    }


    public function delete_poliza(Request $request)
    {
        $id_poliza = json_encode($request->id_poliza);
        $flag = "false";
        
        if($id_poliza != null && $id_poliza != ''){

            DB::beginTransaction();

            try {      
                //Reestableciendo bandera de contabilizando a 0  de las facturas involucradas  
                $ids_customers = DB::table('polizas_movtos')->select()->where('poliza_id', '=', $id_poliza )->pluck('customer_invoice_id'); 
                $ids_customers_unique = $ids_customers->unique();
                $customer_invoice = CustomerInvoice::whereIn('id', $ids_customers_unique)->update(['contabilizado' => 0]);
                //Eliminando partidas dentro de la poliza
                DB::table('polizas_movtos')->where('poliza_id', '=', $id_poliza )->delete(); 
                //Eliminando poliza
                DB::table('polizas')->where('id', '=', $id_poliza)->delete();
                DB::commit();

                $flag = "true";

            } catch(\Exception $e){
                $error = $e->getMessage();
                DB::rollback();
                dd($error);
            }
        }

        return  $flag;
        

    }

    public function delete_partida_poliza(Request $request)
    {

       
    }
    
}