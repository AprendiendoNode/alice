<?php

namespace App\Http\Controllers\Integration;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
class GroupingCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permitted.integration.grouping_code');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $nivel = !empty($request->inputCreatNivel) ? $request->inputCreatNivel  : '';
      $code = $request->inputCreatCode;
      $desc = $request->inputCreatDesc;
      $result = DB::connection('contabilidad')
                ->table('codigo_agrupador')
                ->select('Codigo_agrupador')
                ->where([
                    ['Codigo_agrupador', '=', $code],
                  ])->count();
      if($result == 0)
      {
        $newId = DB::connection('contabilidad')
                  ->table('codigo_agrupador')
        ->insertGetId(['Nivel' => $nivel,
            'Codigo_agrupador' => $code,
                      'Nombre' => $desc,
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
       $nivel = !empty($request->inputEditNivel) ? $request->inputEditNivel  : '';
        $code = $request->inputEditCode;
        $desc = $request->inputEditDesc;
      $update = DB::connection('contabilidad')
                  ->table('codigo_agrupador')
                  ->where('id', '=', $id)
                  ->update([     'Nivel' => $nivel,
                      'Codigo_agrupador' => $code,
                                'Nombre' => $desc,
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
      $resultado = DB::select('CALL Contab.px_codigo_agrupador_all()');
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
      $resultados = DB::select('CALL Contab.px_codigo_agrupador_xid (?)', array($identificador));
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
