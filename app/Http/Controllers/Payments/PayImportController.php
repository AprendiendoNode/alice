<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use App\Banco;
use App\Cadena;
use App\Proveedor;
use App\Currency;
use App\Hotel;
use App\Pay_status_user;
use App\Pay_factura;
use App\Payments_venues;
use App\Payments_comment;
use App\Payments_states;
use App\Payments_priority;
use App\Payments_way_pay;
use App\Payments;
use App\Viatic_service;
use File;
use Storage;

use Excel;

class PayImportController extends Controller
{
	public function index()
	{
		$cadena = Cadena::select('id', 'name')->get()->sortBy('name');
		$proveedor = Proveedor::select('id', 'nombre')->get();
		$currency = Currency::select('id','name')->get();
		$priority = Payments_priority::select('id', 'name')->get();
		$banquitos = Banco::select('id', 'nombre')->get();
		$way = Payments_way_pay::select('id','name')->get();
	 	$services = Viatic_service::select('id','name')->get();
		$cxclassifications = DB::table('cxclassifications')->select('id', 'name')->get();

		return view('permitted.payments.pay_import',compact('cadena','proveedor', 'options', 'priority', 'banquitos','way','currency','services', 'cxclassifications'));

	}

	public function getIdGrupoAnexo()
	{
		//$cadena = Cadena::select('id', 'name')->get()->sortBy('name');
	}

	//cuenta contable
  public function get_classxservice(Request $request)
  {
    $id_search = $request->data_one;
    $res = DB::select('CALL px_cxclassification_cxservices(?)', array($id_search));
    return $res;
  }
  //cuenta contable
  public function get_cxconcepts(Request $request)
  {
    $id_search = $request->data_one;
    $res = DB::select('CALL px_cxconcept_cxservices(?)', array($id_search));
    return $res;
  }
  //cuenta contable
  public function get_cxdescriptions(Request $request)
  {
    $id_search = $request->data_one;
    $res = DB::select('CALL px_cxconcept_cxdescriptions(?)', array($id_search));
    return $res;
  }

  public function createFolio()
  {
	$nomenclatura = "SP-";
    $current_date = date('Y-m-d');
    date_default_timezone_set('America/Cancun');
    setlocale(LC_TIME, 'es_ES', 'esp_esp');
    $complemento= strtoupper(strftime("%b%y", strtotime($current_date)));

    $res = DB::table('payments')->latest()->first();

    if (empty($res)) {
      $nomenclatura = $nomenclatura.$complemento.'-'."000001";
      return $nomenclatura;
    }else{
      $folio_latest = $res->folio;
      if (empty($folio_latest)) {
        $nomenclatura = $nomenclatura.$complemento.'-'."000001";
        return $nomenclatura;
      }else{
        $explode = explode('-', $folio_latest);
        $num_folio = (int)$explode[2];

        $num_folio = $num_folio + 1;
        $digits = strlen($num_folio);

        switch ($digits) {
          case 1:
            $num_folio = (string)$nomenclatura .$complemento.'-'. "00000" . $num_folio;
            break;
          case 2:
            $num_folio = (string)$nomenclatura .$complemento.'-'. "0000" . $num_folio;
            break;
          case 3:
            $num_folio = (string)$nomenclatura .$complemento.'-'. "000" . $num_folio;
            break;
          case 4:
            $num_folio = (string)$nomenclatura .$complemento.'-'. "00" . $num_folio;
            break;
          case 5:
            $num_folio = (string)$nomenclatura .$complemento.'-'. "0" . $num_folio;
            break;
          default:
            $num_folio = (string)$nomenclatura .$complemento.'-'. $num_folio;
            break;
        }
        return (string)$num_folio;
      }
    }
  }

	public function getDataExcel(Request $request)
	{

		try{
			$data_excel = $request->data_excel;

			$data_format = [];
			$tamanodata = count($data_excel);

			for($i = 0; $i < $tamanodata; $i++)
			{
				$id_cadena =	$data_excel[$i]['grupo_id'];
				$id_hotel =	$data_excel[$i]['anexo_id'];
				if($id_cadena != null && $id_hotel != null){

					$grupo = DB::table('cadenas')->select('id','name')->where('id', $id_cadena)->get();

					$count_anexo = DB::table('hotels')->select('id','Nombre_hotel')->where([
																																			['id', '=' ,$id_hotel],
																																			['cadena_id', '=' ,$id_cadena],])->count();

						if($count_anexo != 0){
							$anexo = DB::table('hotels')->select('id','Nombre_hotel')->where('id', $id_hotel)->get();
							$id_proyecto = DB::table('hotels')->select('id_proyecto')->where('id', $id_hotel)->get();
						}else{

							return 1; // No se encontro un anexo con el id especificado
						}

				}else{
					break;  //Ya no existen mas datos por leer en el excel
				}


				// $monto =  $data_excel[$i]['amount'];
				// $monto_iva = $monto + ($monto * .16);

				array_push($data_format, [
					'grupo' => $grupo,
					'anexo' => $anexo,
					'id_proyecto' => $id_proyecto,
					'cantidad' => $data_excel[$i]['amount'],
				]);
			}

			return $data_format;

		}catch(\ErrorException $e){
			return 0; // El excel subido no tiene los atributos correctos .- Plantilla incorrecta
		}

	}

	public function getStateFactura(Request $request)
	{
		$factura = $request->factura;
		$proveedor_id = $request->proveedor;
		$count = DB::table('payments')->select('factura','payments_states_id','proveedor_id')->where('factura', $factura)->count();
		$flag = 0;
		if($count > 0){
			for($i = 0; $i < $count; $i++)
			{
				$result = DB::table('payments')->select('factura','payments_states_id','proveedor_id')->where('factura', $factura)->get();

				if($result[$i]->payments_states_id == 4 && $result[$i]->proveedor_id == $proveedor_id){
					 $flag = 1; // La factura ya esta pagada
				}

			}
   }
		return $flag;

	}

	public function create_payment_from_excel(Request $request)
	{
		$id_priority = $request->priority_viat;
    $id_proyecto = $request->project;
    $id_sitio = $request->customer;
    $id_proveedor = $request->provider;
    $monto = (float)$request->totales;
    $moneda = $request->coin;
		$date_limit = $request->date_limit;
		$purchase_order = $request->purchase_order;
    $observacion = $request->observaciones;
    $banco = $request->bank;
    $account = $request->account;
		$factura = $request->factura;
		$concept_pay = $request->concept_pay;
		$way_pay_id = $request->methodpay;
		$coin = $request->coin;
		$cc_key = $request->cc_key;
		$monto_iva = $request->monto_iva;
		$iva_precent = $request->iva_percent;
		$sites = $request->data_sites;
		$sites_data = json_decode($sites, true);
    $tam_sites = count($sites_data);
		$cc_name = "";
		$real_cc = "";

		$array_cc = explode('|', $cc_key);
		$real_cc = $array_cc[0];
		$cc_name = $array_cc[1];
		$real_cc = trim($real_cc);
		//dd($real_cc);
		// Archivo excel de multiples pagos a sitios
		$archivo = $request->file('file_excel');
		$date_limit_format = str_replace('/', '-', $date_limit);
		$folio_new = $this->createFolio();

		$check_fact = 3;

    if (isset($request->check_factura_sin)) {
      //$check_factura_sin = (bool)$request->check_factura_sin;
      $check_fact = 1;
    }else if (isset($request->check_factura_pend)) {
      $check_fact = 2;
    }else if (0 == filesize($request->file('file_pdf'))) {
      $check_fact = 2;
    }
    else{
      $check_fact = 3;
    }

		//
		$new_reg_pay = new Payments;
		$new_reg_pay->folio = $folio_new;
		$new_reg_pay->proveedor_id = $id_proveedor;
		$new_reg_pay->payments_states_id = '1';
		$new_reg_pay->date_solicitude = date('Y-m-d');
		$new_reg_pay->date_pay = date('Y-m-d');
		$new_reg_pay->date_limit = date('Y-m-d', strtotime($date_limit_format));
		$new_reg_pay->purchase_order = $purchase_order;
		$new_reg_pay->factura =$factura;
		$new_reg_pay->amount = $monto;
		$new_reg_pay->name = $observacion;
		$new_reg_pay->concept_pay = $concept_pay;
		$new_reg_pay->way_pay_id = $way_pay_id;
		$new_reg_pay->currency_id = $coin;
		$new_reg_pay->prov_bco_ctas_id =$account;
		$new_reg_pay->priority_id =$id_priority;
		$new_reg_pay->pay_status_fact_id =$check_fact;
		$new_reg_pay->created_at = \Carbon\Carbon::now();
		$new_reg_pay->save();
		//Ultimo id registrado de payments
		$id_payment =  $new_reg_pay->id;
		//  Comentarios
		$new_reg_pay_comment = new Payments_comment;
		$new_reg_pay_comment->name = $observacion;
		$new_reg_pay_comment->payment_id = $new_reg_pay->id;
		$new_reg_pay_comment->save();
		// //Factura PDF
		if($request->file('file_pdf') != null )
		{
			$file_pdf = $request->file('file_pdf');
			$file_extension = $file_pdf->getClientOriginalExtension(); //** get filename extension
			$fileName = $factura.'_'.date("Y-m-d H:i:s").'.'.$file_extension;
			$pdf= $request->file('file_pdf')->storeAs('filestore/storage/factura/'.date('Y-m'), $fileName); ;
			$new_reg_pay_pdf_fact= new Pay_factura;
			$new_reg_pay_pdf_fact->payment_id = $new_reg_pay->id;
			$new_reg_pay_pdf_fact->name = $pdf;
			$new_reg_pay_pdf_fact->save();
		}
		//Factura XML
		if($request->file('file_xml') != null )
		{
			$file_xml = $request->file('file_xml');
			$fileName = $file_xml->getClientOriginalName();
			$xml= $request->file('file_xml')->storeAs('filestore/storage/factura/'.date('Y-m'), $fileName); ;
			$new_reg_pay_pdf_fact= new Pay_factura;
			$new_reg_pay_pdf_fact->payment_id = $new_reg_pay->id;
			$new_reg_pay_pdf_fact->name = $xml;
			$new_reg_pay_pdf_fact->save();
		}

		for ($i=0; $i < $tam_sites; $i++)
		{
			$amount = trim($sites_data[$i]['amount']);
			$amount_iva = $monto_iva[$i];
			//Sitios
			$new_reg_pay_venue = new Payments_venues;
			$new_reg_pay_venue->cadena_id = (int)$sites_data[$i]['grupo_id'];
			$new_reg_pay_venue->hotel_id = (int)$sites_data[$i]['anexo_id'];
			$new_reg_pay_venue->payments_id = $id_payment;
			$new_reg_pay_venue->created_at = \Carbon\Carbon::now();
			$new_reg_pay_venue->save();

			//Montos
			DB::table('payments_montos')->insert(
					['payments_venue_id' => $new_reg_pay_venue->id,
					 'amount' => $amount,
					 'IVA' => $iva_precent,
					 'amount_iva' => $amount_iva,
					 'payments_id' => $id_payment,
					 'created_at' => \Carbon\Carbon::now()]
			);


		}

		 /* Estatus de la solicitud */
		$user_actual = Auth::user()->id;
		$data_rest = DB::table('pay_status_users')->insertGetId([
											 'payment_id' => $id_payment,
											 'user_id' => $user_actual,
											 'status_id' => '1',
											 'created_at' => \Carbon\Carbon::now(),
											 'updated_at' => \Carbon\Carbon::now()
										]);
		$data_cc = DB::table('pay_mov_cc')->insertGetId([
											 'payments_id' => $new_reg_pay->id,
											 'key_cc' => $real_cc,
											 'name_cc' => $cc_name,
											 'created_at' => \Carbon\Carbon::now(),
											 'updated_at' => \Carbon\Carbon::now()
										]);


		return json_encode($folio_new);

	}

}
