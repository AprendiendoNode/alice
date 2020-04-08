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
      $periodInit = $request->period_month.'-01';
      $periodEnd = $request->period_month_end.'-01';
      $response = [];
      $resultados = DB::select('CALL Contab.px_estado_resultados_xperiodo(?,?)', [ $periodInit, $periodEnd ]);
      $columns = array_keys(((array)$resultados[0]));
      array_push($columns,'total','%');
      $totalResultados = 0;
      foreach($resultados as $resultado) {
        $total = 0;
        foreach($resultado as &$registro) {
          if( $registro!=null ) {
            if( is_numeric(str_replace(',','',$registro)) ) {
              $total += $this->sumaItems( $registro );
            }
          }
          $registro = $registro!=null?$registro:'S/N';
        }
        $totalResultados += $total;
        $resultado->total = $total;
        $resultado->porcentaje = "0";
      }
      foreach( $resultados as &$cuenta ) {
        if( $totalResultados != 0 ) {
          $cuenta->porcentaje = round($cuenta->total / $totalResultados*100).'%'; 
        } else {
          $cuenta->porcentaje = '0%';
        }
        $cuenta->total = number_format($cuenta->total, 2, '.', ',');
      };
      $response = [
        'columnas' => $columns,
        'datos' => $resultados
      ];
      return response()->json( $response );
      
  }
  
  public function balance_general_search(Request $request) {
    $periodInit = $request->period_month.'-01';
      $periodEnd = $request->period_month_end.'-01';
      $response = [];
      $resultados = DB::select('CALL Contab.px_balance_general_xperiodo(?,?)', [ $periodInit, $periodEnd ]);
      $columns = array_keys(((array)$resultados[0]));
      $response = [
        'columnas' => $columns,
        'datos' => $resultados
      ];
      return response()->json( $response );
  }

  private function sumaItems( ...$items ) {
    $total = 0;
    foreach( $items as $item ) {
      $item = str_replace(',','',$item);
      $total+= intval($item);
    }
    return $total;
  }

}
