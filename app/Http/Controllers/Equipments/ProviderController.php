<?php

namespace App\Http\Controllers\Equipments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Redirect;

class ProviderController extends Controller
{
  public function index()
  {
      return view('permitted.equipment.view_provider');
  }

  public function getTableProviders(Request $request)
  {
  	$res = DB::table('list_proveedores_table')->get();
  	return json_encode($res);
  }

  public function insertnewprovider(Request $request)
  {
  	$response = "0";
	$input1 = $request->provider_name;
	$input2 = $request->provider_rfc;
	$input3 = $request->provider_address;
	$input4 = $request->provider_tf;
	$input5 = $request->provider_municipality;
	$input6 = $request->provider_estate;
	$input7 = $request->provider_country;
	$input8 = $request->provider_postcode;
	$input9 = $request->provider_phone;
	$input10 = $request->provider_fax;
	$input11 = $request->provider_email;
	$input12 = $request->agent_name;
	$input13 = $request->agent_phone;

	$res = DB::table('proveedors')->insert([
	    'nombre' => $input1,
	    'rfc' => $input2,
	    'direccion' => $input3,
	    'regimen_Fiscal' => $input4,
	    'municipio' => $input5,
	    'estado' => $input6,
	    'pais' => $input7,
	    'cp' => $input8,
	    'telefono' => $input9,
	    'fax' => $input10,
	    'email' => $input11,
	    'agente_nombre' => $input12,
	    'agente_telefono' => $input13,
	    'updated_at' => \Carbon\Carbon::now()
	]);

	if ($res) {
		return $response = "1";
	}

  	return $response;

  	//notificationMsg('success', 'Operation complete!');
  	//return Redirect::back();
  }

  public function showUpdate(Request $request)
  {
  	$input0 = $request->rec_provider;

  	$res = DB::table('proveedors')->where('id', '=', $input0)->get();

  	return json_encode($res);
  }

  public function updateprov(Request $request)
  {
  	$input0 = $request->rec_provider;
	$input1 = $request->provider_name1;
	$input2 = $request->provider_rfc1;
	$input3 = $request->provider_address1;
	$input4 = $request->provider_tf1;
	$input5 = $request->provider_municipality1;
	$input6 = $request->provider_estate1;
	$input7 = $request->provider_country1;
	$input8 = $request->provider_postcode1;
	$input9 = $request->provider_phone1;
	$input10 = $request->provider_fax1;
	$input11 = $request->provider_email1;
	$input12 = $request->agent_name1;
	$input13 = $request->agent_phone1;

    $res = DB::table('proveedors')->where('id', '=', $input0)->update(
      [
	    'nombre' => $input1,
	    'rfc' => $input2,
	    'direccion' => $input3,
	    'regimen_Fiscal' => $input4,
	    'municipio' => $input5,
	    'estado' => $input6,
	    'pais' => $input7,
	    'cp' => $input8,
	    'telefono' => $input9,
	    'fax' => $input10,
	    'email' => $input11,
	    'agente_nombre' => $input12,
	    'agente_telefono' => $input13,
	    'updated_at' => \Carbon\Carbon::now()
      ]);

    return $res;
  }

  public function deleteprov(Request $request)
  {
  	$input0 = $request->recibidoconf;

  	$res = DB::table('proveedors')->where('id', $input0)->delete();

  	return $res;
  }

}
