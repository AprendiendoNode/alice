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
// use App\Helpers\BaseHelper;
use App\Helpers\Cfdi33Helper;
use App\Helpers\Helper;
use App\Helpers\PacHelper;
// use App\Mail\SendCustomerInvoice;
use App\Models\Base\BranchOffice;
use App\Models\Base\Company;
use App\Models\Base\Pac;
use App\Models\Base\DocumentType;
use App\Models\Catalogs\CfdiRelation;
use App\Models\Catalogs\State;
use App\Models\Catalogs\country;
use App\Models\Catalogs\CfdiUse;
use App\Models\Catalogs\Currency;
use App\Models\Catalogs\PaymentMethod;
use App\Models\Catalogs\PaymentTerm;
use App\Models\Catalogs\PaymentWay;
use App\Models\Catalogs\Product;
use App\Models\Catalogs\SatProduct;
use App\Models\Catalogs\Tax;
use App\Models\Catalogs\UnitMeasure;
use App\Models\Sales\Customer;
use App\Models\Sales\CustomerInvoice;
use App\Models\Sales\CustomerInvoiceCfdi;
use App\Models\Sales\CustomerInvoiceLine;
use App\Models\Sales\CustomerInvoiceRelation;
use App\Models\Sales\CustomerInvoiceTax;
use App\Models\Sales\CustomerPayment;
use App\Models\Sales\Salesperson;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Base\Setting;
use anlutro\LaravelSettings\SettingStore;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Schema;

use \CfdiUtils\XmlResolver\XmlResolver;
use \CfdiUtils\CadenaOrigen\DOMBuilder;
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
        $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
        $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
        $salespersons = DB::select('CALL GetAllSalespersonv2 ()', array());
        $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
        $list_status = $this->list_status;
        $bancos = DB::table('banks')->where('sitwifi', 1)->get();

        return view('permitted.sales.polizas_show',compact(
          'customer', 'sucursal', 'list_status', 'bancos'
        ));
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
		$sucursal = !empty($request->filter_branch_office_id) ? $request->filter_branch_office_id : '';
		$cliente = !empty($request->filter_customer_id) ? $request->filter_customer_id : '';
		$estatus = !empty($request->filter_status) ? $request->filter_status : '';

		$date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
		$date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');
		$resultados = DB::select('CALL px_customer_polizas_filters_type (?,?,?,?)',array($date_a, $date_b, $folio, '1'));

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
        //Objeto del carrito de compras (Pedido)
        $asientos = $request->movs_polizas;
        $asientos_data = json_decode($asientos);
        
        $tam_asientos = count($asientos_data);

        DB::beginTransaction();

        try {

            $sql_poliza = DB::table('polizas')->insertGetId([
                'tipo_poliza_id' => 1,
                'numero' => 1,
                'fecha' => $date,
                'descripcion' => $asientos_data[0]->nombre,
                'total_cargos' => $request->total_cargos_format,
                'total_abonos' => $request->total_abonos_format
            ]);
                
            //Insertando movimientos de las polizas
            for ($i=0; $i < $tam_asientos; $i++)
            {
                $sql = DB::table('polizas_movtos')->insert([
                    'poliza_id' => $sql_poliza,
                    'fecha' => $date,
                    'cuenta_contable_id' => $asientos_data[$i]->cuenta_contable_id,
                    'descripcion' => $asientos_data[$i]->nombre,
                    'cargos' => $asientos_data[$i]->cargo,
                    'abonos' => $asientos_data[$i]->abono,
                    'customer_invoice_id' => $asientos_data[$i]->factura_id
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

    public function get_facts_mov_data(Request $request)
    {
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
        //return $asientos;	
        return view('permitted.sales.table_asientos_contables', compact('asientos', 'cuentas_contables'));	
    }
    
}