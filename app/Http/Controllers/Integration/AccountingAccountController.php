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
    public function __construct()
    {
        $this->list_nature = [
            1 => 'Deudora',
            2 => 'Acreedora'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_nature = $this->list_nature;
        $list_rubro = DB::select('CALL GetAllCfdiTypeActivev2 ()', array());
        $list_code_agrup = DB::select('CALL GetAllCfdiTypeActivev2 ()', array());
        return view('permitted.integration.accounting_account',
               compact('list_nature', 'list_rubro', 'list_code_agrup')
               );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    
    public function open(Request $request)
    {
        //
    }
    public function closed(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
