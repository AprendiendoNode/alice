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
use App\Models\Catalogs\State;
use App\Models\Catalogs\country as Country;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

use App\Models\Sales\Customer;
use App\Models\Purchases\Purchase;
use App\Models\Purchases\Purchase as CustomerCreditNote;
use App\Models\Purchases\PurchaseLine as CustomerCreditNoteLine;
use App\Models\Purchases\PurchaseTax as CustomerCreditNoteTax;
use App\Models\Purchases\PurchaseReconciled as CustomerCreditNoteReconciled;
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

class HistoryCreditNoteController extends Controller
{
    private $list_status = [];

    public function __construct()
    {
        $this->list_status = [
            CustomerCreditNote::ELABORADO => 'ELABORADO',
            CustomerCreditNote::REVISADO => 'REVISADO',
            CustomerCreditNote::AUTORIZADO => 'AUTORIZADO',
            CustomerCreditNote::CANCELADO => 'CANCELADO',
            CustomerCreditNote::CONCILIADA => 'CONCILIADA',
        ];
    }


    public function index()
    {
        $providers = DB::table('customers')->select('id', 'name')->where('provider', 1)->get();
        $list_status = $this->list_status;
        return view('permitted.purchases.history_credit_notes', compact('providers', 'list_status') );
    }
    public function search(Request $request)
    {
      $date_from  = $request->filter_date_from;
      $date_to  = $request->filter_date_to;
      $cliente = !empty($request->filter_customer_id) ? $request->filter_customer_id : NULL;
      $estatus = !empty($request->filter_status) ? $request->filter_status : '';

      $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
      $date_b = Carbon::parse($request->filter_date_to)->format('Y-m-d');
      $resultados = DB::select('CALL px_purchase_xrango (?,?,?)',array($date_a, $date_b,  $cliente));
      return json_encode($resultados);
    }
    public function generate_invoice_pdfs($id)
    {
      $companies = DB::select('CALL px_companies_data ()', array());
      $customer_credit_note = Purchase::findOrFail($id);
      $estado = State::findOrFail($customer_credit_note->customer->state_id)->name;
      $pais = Country::findOrFail($customer_credit_note->customer->country_id)->name;
      $format = new ConvertNumberToLetters();
      $ammount_letter = $format->convertir($customer_credit_note->amount_total);
      // Enviando datos a la vista de la factura
      $pdf = PDF::loadView('permitted.invoicing.invoice_ntc',compact('companies', 'customer_credit_note', 'ammount_letter','estado', 'pais'));
      return $pdf->stream();
    }
    public function modalSendMail(Request $request)
    {
        $id = $request->token_b;
        $company = Helper::defaultCompany(); //Empresa
        $customer_credit_note = Purchase::findOrFail($id);
        //Logica
        if ($request->ajax() && !empty($id)) {
            //Correo default del cliente
            $to = [];
            $to_selected = [];
            if (!empty($customer_credit_note->customer->email)) {
                $email = $customer_credit_note->customer->email;
                $email = explode(";", $email);

                $to_selected [] = $email;
            }
            //Etiquetas solo son demostrativas
            $files = [
                'pdf' => $customer_credit_note->name . '.pdf',
            ];
            $files_selected = array_keys($files);


            $a3 = '<b>Le remitimos adjunta la siguiente factura:</b>'.'<br>';
            $a2 = $customer_credit_note->name;
            $a1 = Helper::convertSqlToDateTime($customer_credit_note->date);
            $a0 = '<br>';


            $data_result = [
                'customer_invoice' => $customer_credit_note,
                'company' => $company,
                'to' => $to,
                'to_selected' => $to_selected,
                'files' => $files,
                'files_selected' => $files_selected,
                'custom_message' => $a1.$a0.$a2.$a0.$a3
            ];
            return $data_result;

        }
        return response()->json(['error' => __('general.error_general')], 422);
    }
    public function get_pdf_xml_files($id)
    {
      $customer_credit_note = Purchase::findOrFail($id);
      $companies = DB::select('CALL px_companies_data ()', array());
      $data = [];
      $estado = State::findOrFail($customer_credit_note->customer->state_id)->name;
      $pais = Country::findOrFail($customer_credit_note->customer->country_id)->name;
      $format = new ConvertNumberToLetters();
      $ammount_letter = $format->convertir($customer_credit_note->amount_total);
      // Enviando datos a la vista de la factura
      $pdf = PDF::loadView('permitted.invoicing.invoice_ntc',compact('companies', 'customer_credit_note', 'ammount_letter','estado', 'pais'));
      $files = array(
        "pdf" => $pdf,
      );
      return $files;
    }
    public function sendmail_facts_customers(Request $request)
    {
        $files = $this->get_pdf_xml_files($request->customer_invoice_id);
        $pdf = $files['pdf'];
        $data = [
            'factura' => $request->fact_name,
            'cliente' => $request->cliente_name,
        ];
        try{
            Mail::send('mail.facturacion.nota', ['data' => $data],function ($message) use ($request, $pdf){
                $message->subject($request->subject);
                $message->from('desarrollo@sitwifi.com', 'Nota de credito compra');
                $message->to($request->to);
                $message->attachData($pdf->output(), $request->fact_name . '.pdf');
            });
            $purchase_note = Purchase::findOrFail($request->customer_invoice_id);
            $purchase_note->updated_uid = \Auth::user()->id;
            $purchase_note->mail_sent = 1;
            $purchase_note->save();
            return response()->json([
                'message' => 'Factura enviada',
                'code' => 200,
            ]);

        }
        catch(\Swift_RfcComplianceException $e){
            return response()->json([
                'message' => 'Error al intentar enviar la factura, revise que los correos sean validos',
                'code' => 500
            ]);
        }
    }
    public function markSent(Request $request) {
      //30-01-2020 Update
      $id = $request->token_b;
      $customer_credit_note = Purchase::findOrFail($id);
      //Logica
      $customer_credit_note->updated_uid = \Auth::user()->id;
      $customer_credit_note->mail_sent = 1;
      $customer_credit_note->save();
      return response()->json(['status' => 200]);
    }
    public function destroy(Request $request) {
      //30-01-2020 Update
      $id = $request->token_b;
      $customer_credit_note = Purchase::findOrFail($id);
      $customer_credit_note->updated_uid = \Auth::user()->id;
      $customer_credit_note->status = 4;
      $customer_credit_note->save();
      return response()->json(['status' => 200]);
    }
    public function poliza(Request $request) {
    }
}
