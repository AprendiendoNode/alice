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
      $month = $request->period_month;
      // $resultados = DB::select('CALL get_contadores_vendedor (?)', array($month));
      // return json_encode($resultados);
      $resultados = array();
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

      return json_encode($resultados);
  }
}
