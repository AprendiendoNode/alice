<?php

namespace App\Http\Controllers\Purchases;
use Auth;
use DB;
use PDF;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Helpers\PacHelper;

use App\Models\Base\BranchOffice;
use App\Models\Base\Company;
use App\Models\Base\Pac;
use App\Models\Catalogs\CfdiRelation;
use App\Models\Catalogs\CfdiUse;
use App\Models\Catalogs\Currency;
use App\Models\Catalogs\PaymentMethod;
use App\Models\Catalogs\PaymentTerm;
use App\Models\Catalogs\PaymentWay;
use App\Models\Catalogs\SatProduct;
use App\Models\Catalogs\Tax;
use App\Models\Catalogs\UnitMeasure;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

use App\Models\Sales\Customer;
use App\Models\Purchases\Purchase;
use App\Models\Purchases\Purchase as CustomerCreditNote;
use App\Models\Purchases\PurchaseLine as CustomerCreditNoteLine;
use App\Models\Purchases\PurchaseTax as CustomerCreditNoteTax;
use App\Models\Sales\Salesperson;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Base\Setting;
use anlutro\LaravelSettings\SettingStore;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Schema;

use App\ConvertNumberToLetters;
use Mail;
class CustomerCreditNoteController extends Controller
{
    private $list_status = [];
    private $document_type_code = 'customer.credit_note_two';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->list_status = [
            CustomerCreditNote::ELABORADO => __('purchase.text_status_elaborado'),
            CustomerCreditNote::REVISADO => __('purchase.text_status_revisado'),
            CustomerCreditNote::AUTORIZADO => __('purchase.text_status_autorizado'),
            CustomerCreditNote::CANCELADO => __('purchase.text_status_cancelado'),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = DB::table('customers')->select('id', 'name')->where('provider', 1)->get();
        $sucursal = DB::select('CALL GetSucursalsActivev2 ()', array());
        $currency = DB::select('CALL GetAllCurrencyActivev2 ()', array());
        $salespersons = DB::select('CALL GetAllSalespersonv2 ()', array());
        $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
        $payment_term = DB::select('CALL GetAllPaymentTermsv2 ()', array());
        $payment_methods = DB::select('CALL GetAllPaymentMethodsv2 ()', array());
        $cfdi_uses = DB::select('CALL GetAllCfdiUsev2 ()', array());
        $cfdi_relations = DB::select('CALL GetAllCfdiRelationsv2 ()', array());

        $product =  DB::select('CALL GetAllProductActivev2 ()', array());
        $unitmeasures = DB::select('CALL GetUnitMeasuresActivev2 ()', array());
        $satproduct = DB::select('CALL GetSatProductActivev2 ()', array());
        $impuestos =  DB::select('CALL GetAllTaxesActivev2 ()', array());

        $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');

        return view('permitted.purchases.customer_credit_notes',
        compact('providers', 'sucursal', 'currency', 'payment_term',
         'salespersons','payment_way', 'payment_term' ,'payment_methods',
        'cuentas_contables', 'cfdi_uses', 'product', 'unitmeasures',
        'satproduct', 'impuestos', 'cfdi_relations') );
    }
    /*
     * Filtra solo las compras de la misma moneda
     */
    public function balances(Request $request)
    {
      //Variables
      $customer_id = $request->customer_id;
      $filter_currency_id = $request->currency_id;
      //Logica
      if ($request->ajax() && !empty($customer_id)) {
        
        return response()->json($resultados, 200);
      }
      return response()->json(['error' => __('general.error500')], 422);
    }
}
