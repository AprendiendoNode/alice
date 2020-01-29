<?php

namespace App\Http\Controllers\Integration;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
class RubrosController extends Controller
{
    public function __construct()
    {
      $this->list_rubro = [
        'Activo' => 'Activo',
        'Capital' => 'Capital',
        'Orden' => 'Orden',
        'Pasivo' => 'Pasivo',
        'Resultados' => 'Resultados',
      ];
      $this->list_grup = [
        'A' => 'A',
        'B' => 'B',
        'C' => 'C',
        'D' => 'D',
        'E' => 'E',
      ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $list_rubro = $this->list_rubro;
      $list_grup = $this->list_grup;
      return view('permitted.integration.rubros',
             compact('list_rubro', 'list_grup')
             );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $code = $request->inputCreatCode;
      $desc = $request->inputCreatDesc;
     $rubro = $request->inputCreatRubro;
     $grupo = !empty($request->inputCreatGrup) ? $request->inputCreatGrup  : '';
     $lugar = $request->inputCreatLugar;
     $result = DB::connection('contabilidad')
               ->table('rubros_contables')
               ->select('clave')
               ->where([
                   ['clave', '=', $code],
                 ])->count();
      if($result == 0)
      {
        $newId = DB::connection('contabilidad')
                 ->table('rubros_contables')
        ->insertGetId(['clave' => $code,
                 'descripcion' => $desc,
                       'rubro' => $rubro,
                       'grupo' => $grupo,
                       'lugar' => $lugar,
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
        $code = $request->inputEditCode;
        $desc = $request->inputEditDesc;
       $rubro = $request->inputEditRubro;
       $grupo = !empty($request->inputEditGrup) ? $request->inputEditGrup  : '';
       $lugar = $request->inputEditLugar;

       $update = DB::connection('contabilidad')
                 ->table('rubros_contables')
                 ->where('id', '=', $id)
                 ->update([     'clave' => $code,
                          'descripcion' => $desc,
                                'rubro' => $rubro,
                                'grupo' => $grupo,
                                'lugar' => $lugar,
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
      $resultado = DB::select('CALL Contab.px_rubros_contables_all()');
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
      $resultados = DB::select('CALL Contab.px_rubros_contables_xid (?)', array($identificador));
      foreach ($resultados as $key) {
        $key->id = Crypt::encryptString($key->id);
      }
      return $resultados;
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
