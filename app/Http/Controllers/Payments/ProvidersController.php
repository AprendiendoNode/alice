<?php

namespace App\Http\Controllers\Payments;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\Sales\Customer;
class ProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $payment_term = DB::select('CALL GetAllPaymentTermsv2 ()', array());
      $payment_way = DB::select('CALL GetAllPaymentWayv2 ()', array());
      $payment_methods = DB::select('CALL GetAllPaymentMethodsv2 ()', array());
      $cfdi_uses = DB::select('CALL GetAllCfdiUsev2 ()', array());
      $salespersons = DB::select('CALL GetAllSalespersonv2 ()', array());
      $countries = DB::select('CALL GetAllCountryActivev2 ()', array());
      $states = DB::select('CALL GetAllStateActivev2 ()', array());
      $cities = DB::select('CALL GetAllCitiesv2 ()', array());
      $cuentas_contables = DB::select('CALL Contab.px_catalogo_cuentas_contables()');

      return view('permitted.payments.providers',compact(
      'payment_term', 'payment_way', 'payment_methods',
      'cfdi_uses', 'salespersons', 'countries', 'states', 'cities', 'cuentas_contables'
      ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id= Auth::user()->id;
        $name= $request->inputCreatName;
        $taxid= $request->inputCreatTaxid;
        $numid= $request->inputCreatNumid;
        $email= $request->inputCreatEmail;
        $phone= !empty($request->inputCreatPhone) ? $request->inputCreatPhone : '';
        $mobile= !empty($request->inputCreatMobile) ? $request->inputCreatMobile : '';
        $direccion= $request->inputCreatAddress_1;

        $numExt= !empty($request->inputCreatAddress_2) ? $request->inputCreatAddress_2 : '';
        $numInt= !empty($request->inputCreatAddress_3) ? $request->inputCreatAddress_3 : '';
        $colonia= !empty($request->inputCreatAddress_4) ? $request->inputCreatAddress_4 : '';
        $localidad= !empty($request->inputCreatAddress_5) ? $request->inputCreatAddress_5 : '';
        $referencia= !empty($request->inputCreatAddress_6) ? $request->inputCreatAddress_6 : '';

        $paises= $request->select_six;
        $estados= $request->select_seven;
        $ciudades= $request->select_eight;
        $postcode= $request->inputCreatPostCode;
        $comment= !empty($request->inputCreatComment) ? $request->inputCreatComment : '';
        $orden= $request->inputCreatOrden;
        $status= !empty($request->status) ? 1 : 0;

        $result = DB::table('customers')
                    ->select('taxid')
                    ->where([
                        ['taxid', '=', $taxid],
                        ])->count();

         if($result == 0)
            {
            $newId = DB::table('customers')
            ->insertGetId([
                            'name' => $name,
                            'taxid' => $taxid,
                            'numid' => $numid,
                            'email' => $email,
                            'phone' => $phone,
                    'phone_mobile' => $mobile,
                        'address_1' => $direccion,
                        'address_2' => $numExt,
                        'address_3' => $numInt,
                        'address_4' => $colonia,
                        'address_5' => $localidad,
                        'address_6' => $referencia,
                        'country_id' => $paises,
                        'state_id' => $estados,
                        'city_id' => $ciudades,
                        'postcode' => $postcode,
                        'comment' => $comment,
                        'sort_order' => $orden,
                            'status' => $status,
                            'provider' => 1,
                    'created_uid' => $user_id,
                        'created_at' => \Carbon\Carbon::now()]);
            if(empty($newId)){
                return 'abort'; // returns 0
            }
            else{
                return $newId; // returns id
            }
            }
            else
            {
            return 'false';//Ya esta asociado
            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user_id= Auth::user()->id;
        $id_received= Crypt::decryptString($request->token_b);
        $name= $request->inputEditName;
        $taxid= $request->inputEditTaxid;
        $numid= $request->inputEditNumid;
        $email= $request->inputEditEmail;
        $phone= !empty($request->inputEditPhone) ? $request->inputEditPhone : '';
        $mobile= !empty($request->inputEditMobile) ? $request->inputEditMobile : '';
        $direccion= $request->editCreatAddress_1;

        $numExt= !empty($request->editCreatAddress_2) ? $request->editCreatAddress_2 : '';
        $numInt= !empty($request->editCreatAddress_3) ? $request->editCreatAddress_3 : '';
        $colonia= !empty($request->editCreatAddress_4) ? $request->editCreatAddress_4 : '';
        $localidad= !empty($request->editCreatAddress_5) ? $request->editCreatAddress_5 : '';
        $referencia= !empty($request->editCreatAddress_6) ? $request->editCreatAddress_6 : '';

        $paises= $request->edit_select_six;
        $estados= $request->edit_select_seven;
        $ciudades= $request->edit_select_eight;
        $postcode= $request->editCreatPostCode;
        $comment= !empty($request->editCreatComment) ? $request->editCreatComment : '';
        $orden= $request->inputEditOrden;
        $status= !empty($request->editstatus) ? 1 : 0;
        $result = DB::table('customers')
                 ->select('id')
                 ->where([
                     ['taxid', '=', $taxid],
                     ['id', '!=', $id_received],
                   ])->count();
        if($result == 0)
        {
            $newId = DB::table('customers')
            ->where('id', '=',$id_received )
            ->update([    'name' => $name,
                        'taxid' => $taxid,
                        'numid' => $numid,
                        'email' => $email,
                        'phone' => $phone,
                'phone_mobile' => $mobile,
                    'address_1' => $direccion,
                    'address_2' => $numExt,
                    'address_3' => $numInt,
                    'address_4' => $colonia,
                    'address_5' => $localidad,
                    'address_6' => $referencia,
                    'country_id' => $paises,
                    'state_id' => $estados,
                        'city_id' => $ciudades,
                    'postcode' => $postcode,
                        'comment' => $comment,
                    'sort_order' => $orden,
                        'status' => $status,
                    'updated_uid' => $user_id,
                    'updated_at' => \Carbon\Carbon::now()]);
            if($newId == '0' ){
                return 'abort'; // returns 0
            }
            else{
                return $newId; // returns id
            }
        }
        else
        {
            return 'false';//Ya esta asociado
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $resultados = DB::select('CALL GetCustomersv2(?)', array(1));
      return json_encode($resultados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
      $identificador= $request->value;
      $resultados = DB::select('CALL GetCustomersByIdv2 (?)', array($identificador));
      foreach ($resultados as $key) {
        $key->id = Crypt::encryptString($key->id);
      }
      return $resultados;
    }

    public function save_integration_cc_customer_provider(Request $request)
    {

    $sql = DB::table('integracion_contable')->updateOrInsert(
        ['id_cliente_prov' => $request->id_customer_cc],
        ['id_cuenta_contable' => $request->cuenta_contable,
        'id_cuenta_compl' => $request->cuenta_complementaria,
        'id_cuenta_anticipo' => $request->cuenta_anticipo,
        'provider' => 1
    ]);     
    
    }

 
}
