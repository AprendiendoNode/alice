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
      $date_a  = $date_from.'-01';
      $cliente = !empty($request->filter_customer_id) ? $request->filter_customer_id : 0;
      $date_a = Carbon::parse($request->filter_date_from)->format('Y-m-d');
      $resultados = DB::select('CALL px_purchase_xfecha (?,?)',array($date_a, $cliente));
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
    public function get_note_cred_mov_data(Request $request) {
      $tipos_poliza = DB::table('Contab.tipos_poliza')->select('id', 'clave', 'descripcion')->get();
      $date_req = $request->date;
      $date_rest = $date_req.'-01';
      $date = \Carbon\Carbon::now();

      $next_id_num = 0;
      $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');
      $facturas = json_decode($request->facturas);
      $asientos = array();
      return view('permitted.purchases.table_asientos_contables_nota',
      compact('asientos', 'cuentas_contables', 'tipos_poliza', 'next_id_num', 'date_rest', 'date'));
    }
    public function GetNextContador(Request $request)
    {
      $document_type = Helper::getNextDocumentTypePolicy(1);
      return $document_type['folio'];
    }
    public function get_note_cred_mov_data_dev_desc(Request $request)
    {
      $tipos_poliza = DB::table('Contab.tipos_poliza')->select('id', 'clave', 'descripcion')->get();
      $date_req = $request->date;
      $date_rest = $date_req.'-01';
      $date = \Carbon\Carbon::now();

      $next_id_num = 0;
      $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');
      $cuentas_devoluciones_descuentos = DB::select('CALL px_cuentas_contable_5001()');

      $facturas = json_decode($request->facturas);
      $asientos = array();
      for ($i=0; $i <= (count($facturas)-1); $i++)
      {
        $data = DB::select('CALL px_poliza_notas_credito_compras(?)', array($facturas[$i]));

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
      return view('permitted.purchases.table_asientos_contables_nota_credito_poliza',
      compact('asientos', 'cuentas_contables', 'tipos_poliza', 'next_id_num', 'date_rest', 'date', 'cuentas_devoluciones_descuentos'));
    }
    public function customer_polizas_movs_save(Request $request)
    {
      // return $request;
      $flag = "false";
      try {
        DB::transaction(function () use($request){
          //Objeto de polizas
          $asientos = $request->movs_polizas;
          $asientos_data = json_decode($asientos);
          $fecha_general = $request->date_resive;
          $tam_asientos = count($asientos_data);
          $flag = "false";
          //Inserto a poliza
          $id_poliza = DB::table('polizas')->insertGetId([
            'tipo_poliza_id' => $request->type_poliza,
            'numero' => $request->num_poliza,
            'fecha' => $request->date_resive,
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
                //Acumulando saldos
                $cc_array = DB::select('CALL Contab.px_busca_cuentas_xid(?)', array($asientos_data[$i]->cuenta_contable_id));
                $this->add_balances_polizas_ingresos($cc_array, $fecha_general, $asientos_data[$i]->cargo, $asientos_data[$i]->abono);
                /* SE INSERTAR */
                $sql = DB::table('polizas_movtos')->insert([
                  'poliza_id' => $id_poliza,
                  'cuenta_contable_id' => $asientos_data[$i]->cuenta_contable_id,
                  'purchase_id' => $asientos_data[$i]->factura_id,
                  'fecha' => $asientos_data[$i]->fecha,
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
        $result = DB::table('Contab.balanza')->select('cargos', 'abonos', 'sdo_inicial', 'sdo_final')
        ->where('anio', $anio)
        ->where('mes', $mes)
        ->where('cuenta_contable_id', $cc->cuenta_contable_id)
        ->get();
        $saldo_inicial = $result[0]->sdo_inicial; # 1362512.38
        $saldo_final = $result[0]->sdo_final;
        //Sumo totales de la poliza con el acumulado en la balanza
        $total_cargos = $result[0]->cargos + $cargo;
        $total_abonos = $result[0]->abonos + $abono;
        //Calculo el saldo final de la cuenta contable dependiendo su naturaleza
        // if($cc->naturaleza == 'A'){
        //     $saldo_final = $saldo_inicial + $total_abonos - $total_cargos;
        // }else if($cc->naturaleza == 'D'){
        //     $saldo_final = $saldo_inicial + $total_cargos - $total_abonos;
        // }
        $saldo_final = $saldo_inicial  +  $total_cargos - $total_abonos;
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
}
