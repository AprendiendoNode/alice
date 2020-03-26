<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use \Carbon\Carbon;
use Auth;
use DB;
use Faker\Factory as Faker;
use Illuminate\Support\Collection as Collection;

class EstadoResultadoController extends Controller
{
  public function index()
  {
    return view('permitted.accounting.estado_resultados');
  }
  public function estado_resultados_search(Request $request)
  {
      $month = $request->period_month.'-01';
      $period = explode('-', $request->period_month);
      $resultados = DB::select('CALL Contab.px_estado_resultados_xanio (?)', [intval($period[0])]);
      foreach( $resultados as &$resultado ) {
        $resultado->cuenta = $resultado->cuenta!=null?$resultado->cuenta:'S/N';
        $resultado->nombre = $resultado->nombre!=null?$resultado->nombre:'S/N';
        $resultado->Ene = $resultado->Ene!=null?$resultado->Ene:0;
        $resultado->Feb = $resultado->Feb!=null?$resultado->Feb:0;
        $resultado->Mar = $resultado->Mar!=null?$resultado->Mar:0;
        $resultado->Abr = $resultado->Abr!=null?$resultado->Abr:0;
        $resultado->May = $resultado->May!=null?$resultado->May:0;
        $resultado->Jun = $resultado->Jun!=null?$resultado->Jun:0;
        $resultado->Jul = $resultado->Jul!=null?$resultado->Jul:0;
        $resultado->Ago = $resultado->Ago!=null?$resultado->Ago:0;
        $resultado->Sep = $resultado->Sep!=null?$resultado->Sep:0;
        $resultado->Oct = $resultado->Oct!=null?$resultado->Oct:0;
        $resultado->Nov = $resultado->Nov!=null?$resultado->Nov:0;
        $resultado->Dic = $resultado->Dic!=null?$resultado->Dic:0;
        //$resultado->total = intval($resultado->Ene)+intval($resultado->Feb)+intval($resultado->Mar)+intval($resultado->Abr)+intval($resultado->May)+intval($resultado->Jun)+intval($resultado->Jul)+intval($resultado->Ago)+intval($resultado->Sep)+intval($resultado->Oct)+intval($resultado->Nov)+intval($resultado->Dic);
        $resultado->total = $this->sumaItems( $resultado->Ene, $resultado->Feb, $resultado->Mar, $resultado->Abr, $resultado->May, $resultado->Jun, $resultado->Jul, $resultado->Ago, $resultado->Sep, $resultado->Oct, $resultado->Nov, $resultado->Dic );
        $resultado->porcentaje = 0;
        $resultado->cr_rd = 0;
        $resultado->porcentaje_cr_rd = 0;
      }
      return response()->json( $resultados );


      //$resultados = array();
      /*for ($i=1; $i <= 4; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }
      array_push($resultados,
        array(
          "cuenta" => 'SUMA',
          "nombre" =>  'TOTAL INGRESOS',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      for ($i=1; $i <= 4; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }


      array_push($resultados,
        array(
          "cuenta" => 'SUMA',
          "nombre" =>  'TOTAL COSTO',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      array_push($resultados,
        array(
          "cuenta" => '',
          "nombre" =>  'RESULTADO BRUTO',
          "n01" => 1001,
          "n02" => 1002,
          "n03" => 1003,
          "n04" => 1004,
          "n05" => 1005,
          "n06" => 1006,
          "n07" => 1007,
          "n08" => 1008,
          "n09" => 1009,
          "n10" => 1010,
          "n11" => 1011,
          "n12" => 1012,
          "porcentaje" => '30'.'%',
          "cr_rd" => '30',
          "porcentaje_cr_rd" => '200'
        )
      );

      for ($i=1; $i <= 4; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }

      array_push($resultados,
        array(
          "cuenta" => 'SUMA',
          "nombre" =>  'EBITDA',
          "n01" => 1001,
          "n02" => 1002,
          "n03" => 1003,
          "n04" => 1004,
          "n05" => 1005,
          "n06" => 1006,
          "n07" => 1007,
          "n08" => 1008,
          "n09" => 1009,
          "n10" => 1010,
          "n11" => 1011,
          "n12" => 1012,
          "porcentaje" => '30'.'%',
          "cr_rd" => '30',
          "porcentaje_cr_rd" => '200'
        )
      );
      for ($i=1; $i <= 2; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }
      array_push($resultados,
        array(
          "cuenta" => 'SUMA',
          "nombre" =>  'COSTO SERVS ADMINISTRADOS',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      for ($i=1; $i <= 2; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }
      array_push($resultados,
        array(
          "cuenta" => '',
          "nombre" =>  'IMPORTACIONES',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      array_push($resultados,
        array(
          "cuenta" => '',
          "nombre" =>  'FELTES Y ENVÍOS',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      for ($i=1; $i <= 2; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }
      array_push($resultados,
        array(
          "cuenta" => 'SUMA',
          "nombre" => 'TOTAL COSTO',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      array_push($resultados,
        array(
          "cuenta" => 'RESTA',
          "nombre" => 'RESULTADO BRUTO',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      for ($i=1; $i <= 2; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }
      array_push($resultados,
        array(
          "cuenta" => 'SUMA',
          "nombre" => 'GASTOS DE OPERACION',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      for ($i=1; $i <= 2; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }
      array_push($resultados,
        array(
          "cuenta" => '',
          "nombre" => 'COMPLEMENTO DE SUELDO',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      array_push($resultados,
        array(
          "cuenta" => 'SUMA',
          "nombre" => 'GASTOS DE COMERCIALIZACIÓN',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      for ($i=1; $i <= 2; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }
      array_push($resultados,
        array(
          "cuenta" => 'RESTA',
          "nombre" => 'EBITDA',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      for ($i=1; $i <= 2; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }
      array_push($resultados,
        array(
          "cuenta" => 'RESTA',
          "nombre" => 'EBIT',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      for ($i=1; $i <= 2; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }
      array_push($resultados,
        array(
          "cuenta" => 'SUMA',
          "nombre" => 'GASTOS FINANCIEROS',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      array_push($resultados,
        array(
          "cuenta" => 'SUMA',
          "nombre" => 'PRODUCTOS FINANCIEROS',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      for ($i=1; $i <= 2; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }
      array_push($resultados,
        array(
          "cuenta" => 'RESTA',
          "nombre" => 'COSTO INTEGRAL DE FINANCIAMIENTO',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      for ($i=1; $i <= 2; $i++) {
        $faker = Faker::create();
        $ranmdon = rand(1000, 12000);
        array_push($resultados,
          array(
            "cuenta" => $faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999).'-'.$faker->numberBetween(1000, 9999),
            "nombre" =>  $faker->firstNameMale,
            "n01" => $faker->numberBetween(800, 10000),
            "n02" => $faker->numberBetween(800, 10000),
            "n03" => $faker->numberBetween(800, 10000),
            "n04" => $faker->numberBetween(800, 10000),
            "n05" => $faker->numberBetween(800, 10000),
            "n06" => $faker->numberBetween(800, 10000),
            "n07" => $faker->numberBetween(800, 10000),
            "n08" => $faker->numberBetween(800, 10000),
            "n09" => $faker->numberBetween(800, 10000),
            "n10" => $faker->numberBetween(800, 10000),
            "n11" => $faker->numberBetween(800, 10000),
            "n12" => $faker->numberBetween(800, 10000),
            "porcentaje" => $faker->numberBetween(1, 100).'%',
            "cr_rd" => $faker->numberBetween(800, 10000),
            "porcentaje_cr_rd" => $faker->numberBetween(800, 10000)
          )
        );
      }
      array_push($resultados,
        array(
          "cuenta" => 'RESTA',
          "nombre" => 'RESULTADO DEL EJERCICIO ANTES IMPTOS',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      array_push($resultados,
        array(
          "cuenta" => '6000',
          "nombre" => 'ISR',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      array_push($resultados,
        array(
          "cuenta" => '6001',
          "nombre" => 'PTU',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );
      array_push($resultados,
        array(
          "cuenta" => 'RESTA',
          "nombre" => 'RESULTADO DEL EJERCICIO NETO IMPTOS',
          "n01" => 11001,
          "n02" => 11002,
          "n03" => 11003,
          "n04" => 11004,
          "n05" => 11005,
          "n06" => 11006,
          "n07" => 11007,
          "n08" => 11008,
          "n09" => 11009,
          "n10" => 11010,
          "n11" => 11011,
          "n12" => 11012,
          "porcentaje" => '10'.'%',
          "cr_rd" => '10',
          "porcentaje_cr_rd" => '1200'
        )
      );

      return json_encode($resultados);*/
  }

  private function sumaItems( ...$items ) {
    $total = 0;
    foreach( $items as $item ) {
      $item = str_replace(',','',$item);
      $total+= intval($item);
    }
    return number_format($total, 2, '.', ',');
  }

}
