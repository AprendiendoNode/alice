<?php

namespace App\Http\Controllers\Contracts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use App\User;
use DateTime;
use DB;
use Auth;
use Mail;

class CFilemanagerController extends Controller
{
  public function index()
  {
      return view('permitted.contract.cont_filemanager');
  }
  public function find_fact_pend(Request $request)
  {
    $result = DB::select('CALL px_pay_status_fact_pend ()', array());
    return json_encode($result);
  }
  public function get_data_fact_by_drive(Request $request)
  {
    $valor = $request->data_one;
    $result = DB::select('CALL px_payments_data2 (?)', array($valor));
    return json_encode($result);
  }
  public function add_fact_pend_by_drive(Request $request)
  {
    $id_pay = $request->info_fact_pend;
    $no_fac = $request->info_nofact;
    $fichero = 'false';

    if($request->file('file_pdf') != null ){
      $file_pdf_fact = $request->file('file_pdf');
      $file_pdf_extension_fact = $file_pdf_fact->getClientOriginalExtension(); //** get filename extension
      $fileName_pdf = $no_fac.'_'.date("Y-m-d H:i:s").'.'.$file_pdf_extension_fact;
      $pdf_save= $request->file('file_pdf')->storeAs('filestore/storage/factura/'.date('Y-m'), $fileName_pdf);
      $newpdf = DB::table('pay_facturas')->insertGetId(        [
          'payment_id' => $id_pay,
          'name' => $pdf_save,
          'created_at' => \Carbon\Carbon::now()
        ]
      );
      $fichero = 'true';
    }

    if($request->file('file_xml') != null ){
      $file_xml_fact = $request->file('file_xml');
      $file_xml_extension_fact = $file_xml_fact->getClientOriginalExtension(); //** get filename extension
      $fileName_xml = $no_fac.'_'.date("Y-m-d H:i:s").'.'.$file_xml_extension_fact;
      $xml_save= $request->file('file_xml')->storeAs('filestore/storage/factura/'.date('Y-m'), $fileName_xml);
      $newxml = DB::table('pay_facturas')->insertGetId(        [
          'payment_id' => $id_pay,
          'name' => $xml_save,
          'created_at' => \Carbon\Carbon::now()
        ]
      );
      $fichero = 'true';
    }

    if($no_fac == "factura_pendiente") $no_fac = "Factura";

    if ($fichero == 'true') {
      $update_pay=DB::table('payments')
      ->where('id', $id_pay)
      ->update([
        'factura' => $no_fac,
        'pay_status_fact_id' => '3',
        'updated_at' => \Carbon\Carbon::now()
      ]);

      DB::connection('alicelog')->table('edit_payments_log')->insert([
        'payment_id' => $id_pay,
        'orden_compra' => "Sin cambios",
        'concepto' => "Sin cambios",
        'forma_pago' => "Sin cambios",
        'cuenta' => "Sin cambios",
        'clabe' => "Sin cambios",
        'observacion' => "Sin cambios",
        'monto' => "Sin cambios",
        'tasa' => "Sin cambios",
        'monto_iva' => "Sin cambios",
        'total' => "Sin cambios",
        'currency' => "Sin cambios",
        'user' => Auth::user()->name,
        'user_id' => Auth::user()->id,
        'action' => "Nueva factura: ".$no_fac,
        'db' => DB::connection()->getDatabaseName(),
        'created_at' => \Carbon\Carbon::now()
      ]);

      return $update_pay; // returns 1
                          // returns 0 no se cambio
    }

  }


}
