<?php

namespace App\Http\Controllers\Integration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use View;
use Faker\Factory as Faker;
use \Carbon\Carbon;
use App\Models\Base\DocumentType;
use Illuminate\Support\Facades\Crypt;

class AccountingAccountController extends Controller
{
    // public function __construct()
    // {
    //     $this->list_nature = [
    //         1 => 'Deudora',
    //         2 => 'Acreedora'
    //     ];
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_nature = DB::connection('contabilidad')
                      ->table('naturaleza_cuentas')
                      ->select('id','NA', 'naturaleza')
                      ->get();

         $list_rubro = DB::connection('contabilidad')
                      ->table('rubros_contables')
                      ->select('id','clave', 'descripcion')
                      ->get();

    $list_code_agrup = DB::connection('contabilidad')
                      ->table('codigo_agrupador')
                      ->select('id','Nivel', 'Codigo_agrupador', 'Nombre')
                      ->get();

        // $list_nature = $this->list_nature;
        // $list_rubro = DB::select('CALL GetAllCfdiTypeActivev2 ()', array());
        // $list_code_agrup = DB::select('CALL GetAllCfdiTypeActivev2 ()', array());

        return view('permitted.integration.accounting_account',
               compact('list_nature', 'list_rubro', 'list_code_agrup')
               );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
          $clave = $request->inputCreatCode;
         $cuenta = $request->inputCreatName;
      $agrupador = !empty($request->select_one) ? $request->select_one  : '';
     $naturaleza = $request->select_two;
          $rubro = $request->select_three;
    $ultimonivel = !empty($request->last_level) ? 1 : 0;
         $status = !empty($request->status) ? 1 : 0;

         $result = DB::connection('contabilidad')
                   ->table('cuentas_contables')
                   ->select('cuenta')
                   ->where([
                       ['cuenta', '=', $cuenta],
                   ])->count();
      if($result == 0)
      {
        $newId = DB::connection('contabilidad')
                 ->table('cuentas_contables')
        ->insertGetId([
                          'UN' => $ultimonivel,
               'naturaleza_id' => $naturaleza,
                      'cuenta' => $clave,
                      'nombre' => $cuenta,
         'codigo_agrupador_id' => $agrupador,
           'rubro_contable_id' => $rubro,
                      'status' => $status,
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
    public function store(Request $request)
    {
          $id = Crypt::decryptString($request->token_b);
          $clave = $request->inputEditCode;
          $cuenta = $request->inputEditName;
       $agrupador = !empty($request->edit_select_one) ? $request->edit_select_one  : '';
      $naturaleza = $request->edit_select_two;
           $rubro = $request->edit_select_three;
     $ultimonivel = !empty($request->edit_last_level) ? 1 : 0;
          $status = !empty($request->edit_status) ? 1 : 0;

          $update = DB::connection('contabilidad')
                    ->table('cuentas_contables')
                    ->where('id', '=', $id)
                    ->update([
                                  'UN' => $ultimonivel,
                       'naturaleza_id' => $naturaleza,
                              'cuenta' => $clave,
                              'nombre' => $cuenta,
                 'codigo_agrupador_id' => $agrupador,
                   'rubro_contable_id' => $rubro,
                              'status' => $status,
                          'updated_at' => \Carbon\Carbon::now()]);
          if($update == '0' ){
            return 'abort'; // returns 0
          }
          else{
            return $update; // returns id
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
      $resultado = DB::select('CALL Contab.px_codigo_contable_all()');
      return json_encode($resultado);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
      $identificador= $request->token_b;
      $resultados = DB::select('CALL Contab.px_codigo_contable_xid (?)', array($identificador));
      foreach ($resultados as $key) {
        $key->id = Crypt::encryptString($key->id);
      }
      return $resultados;
    }
    public function open(Request $request)
    {
      $id= $request->token_b;
      $update = DB::connection('contabilidad')
                ->table('cuentas_contables')
                ->where('id', '=', $id)
                ->update([ 'status' => 1,
                       'updated_at' => \Carbon\Carbon::now()]);
      if ($update == '0'){
        return response()->json(['status' => 304]);
      }
      else {
        return response()->json(['status' => 200]);
      }
    }
    public function closed(Request $request)
    {
      $id= $request->token_b;
      $update = DB::connection('contabilidad')
                ->table('cuentas_contables')
                ->where('id', '=', $id)
                ->update([ 'status' => 0,
                       'updated_at' => \Carbon\Carbon::now()]);
      if ($update == '0'){
        return response()->json(['status' => 304]);
      }
      else {
        return response()->json(['status' => 200]);
      }
    }




    public function show2(Request $request)
    {
        //FAKER
        $myArray = array();
        $naturaleza_type= array("Deudora", "Acreedora");
        $rubro_type= array("1", "2", "3", "4", "5");
        $code_agrup_type= array("1", "2", "3", "4", "5");

        $estatus_type= array("0", "1");

        for ($i=1; $i <= 10; $i++) {
          $naturaleza = array_rand($naturaleza_type, 1);
          $rubro = array_rand($rubro_type, 1);
          $code_agrup = array_rand($code_agrup_type, 1);
          $estatus = array_rand($estatus_type, 1);

          $faker = Faker::create();
          $nivel1 = rand(0000, 6000);
          $nivel2 = rand(000, 999);
          $nivel3 = rand(000, 999);
          $nivel4 = rand(000, 999);
          $nivel5 = rand(000, 999);
          $nivel6 = rand(000, 999);
          $cuenta = $nivel1.'-'.$nivel2.'-'.$nivel3.'-'.$nivel4.'-'.$nivel5.'-'.$nivel6;
          array_push(
            $myArray,
            array(
              "id" => $faker->numberBetween(1,100),
              "cuenta" => $cuenta,
              "nombre" => $faker->firstNameMale,
              "naturaleza" => ucfirst($naturaleza_type[$naturaleza]),
              "rubro" => ucfirst($rubro_type[$rubro]),
              "codigo_agrupador" => ucfirst($code_agrup_type[$code_agrup]),
              "estatus" => ucfirst($estatus_type[$estatus]),
            )
          );
        }
        return json_encode($myArray);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
