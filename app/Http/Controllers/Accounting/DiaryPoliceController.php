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
class DiaryPoliceController extends Controller
{
    

	public function view_diary_general()
	{
		$tipos_poliza = DB::table('Contab.tipos_poliza')->select('id', 'clave', 'descripcion')->get();

		return view('permitted.accounting.polizas_diario', compact('tipos_poliza'));
	}

	public function get_diary_general_data(Request $request)
	{
		$date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
		$date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');

		$result = DB::select('CALL px_polizas_xmes(?,?,?)', array($date_a, $date_b, $request->type_poliza));

		return $result;
	}

	public function get_diary_detail_data(Request $request)
	{
        $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
		$date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');

		$result = DB::select('CALL px_polizas_movtos_xmes(?,?,?)', array($date_a, $date_b, $request->type_poliza));

		return $result;
	}

}
