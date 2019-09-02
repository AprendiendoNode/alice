<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;
use Faker\Factory as Faker;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function welcome()
    {
	     return View::make('auth.login');
    }
    function array_push_assoc(array &$arrayDatos, array $values){
        $arrayDatos = array_merge($arrayDatos, $values);
    }
    public function show_payment()
    {
      $myArray = array();
      $estatus = array("Elaboro", "Reviso", "Autorizo", "Pagado", "Denegado", "Programado", 'Otro');
      for ($i=1; $i <= 10; $i++) {
        $cla = array_rand($estatus, 1);
        $faker = Faker::create();
        $year = rand(2009, 2016);
        $month = rand(1, 12);
        $day = rand(1, 28);
        $date = Carbon::create($year,$month ,$day , 0, 0, 0);
        array_push($myArray,
          array(
                "factura" => $faker->phoneNumber,
                "proveedor" => $faker->firstNameMale,
                "estatus" =>ucfirst($estatus[$cla]),
                "realizo" => $faker->unique()->email,
                "monto" => $faker->numberBetween(199,499),
                "monto_str" => "Pesos Mexicanos",
                "fecha" => $date->format('Y-m-d H:i:s'),
                "folio" => $faker->unique()->randomDigit,
                "elaboro" => $faker->name,
                "concepto" => $faker->realText(180),
                "fecha_elaboro" =>  $date->addWeeks(rand(1, 52))->format('Y-m-d H:i:s'),
              ));
      }
      return json_encode($myArray);
      // return response()->json($myArray); SOLO PARA VER EN GET

      //Codigo bien
      // $fecha = $request->date;
      // $result = DB::select('CALL px_payments_fechasolicitud_pagado_xfecha(?)', array($fecha));
      // return json_encode($result);
    }
    public function show_summary_info_nps (Request $request)
    {
      //FAKER
      /*$myArray = array();
      array_push($myArray,array("Concepto" => "Promotores","Count" => 165,));
      array_push($myArray,array("Concepto" => "Pasivos","Count" => 33,));
      array_push($myArray,array("Concepto" => "Detractores","Count" => 3,));
      array_push($myArray,array("Concepto" => "NPS","Count" => 81,));
      array_push($myArray,array("Concepto" => "Abstenidos","Count" => 60,));
      array_push($myArray,array("Concepto" => "Respondieron","Count" => 140,));
      array_push($myArray,array("Concepto" => "Encuestas Enviada","Count" => 200,));
      array_push($myArray,array("Concepto" => "Sitios","Count" => 201,));
      return json_encode($myArray);*/

       // codigo bien
      $input_date_i= $request->get('date_to_search');
      if ($input_date_i != '') {
        $date = $input_date_i.'-01';
      }
      else {
        $date_current = date('Y-m');
        $sub_month = strtotime ( '-1 month' , strtotime ( $date_current ) ) ;
        $sub_month = date ( 'Y-m' , $sub_month );
        $date = $sub_month.'-01';

      }
      $result = DB::select('CALL NPS_MONTH (?)', array($date));
      return json_encode($result);
      
    }
    public function show_apps (Request $request)
    {
      //FAKER
      $myArray = array();
      array_push($myArray,array("pais" => "Costa Rica","antenas" => 2,));
      array_push($myArray,array("pais" => "Guatemala","antenas" => 1));
      array_push($myArray,array("pais" => "Jamaica","antenas" => 452));
      array_push($myArray,array("pais" => "Mexico","antenas" => 19257));
      array_push($myArray,array("pais" => "Republica Dominicana","antenas" => 1828));
      return json_encode($myArray);

      /* codigo bien
      $result = DB::select('CALL px_antenasXpais ()', array());
      return json_encode($result);
      */
    }

    //Funcion para redirigir a la documentacion
    public function getDocumentation(Request $request){
      $url=$request->url;
      info($url);
      $result = DB::select('CALL get_documentation_url (?)', array($url));
      info(json_encode($result));
      return json_encode($result);
    }

}
