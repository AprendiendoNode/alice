<?php

namespace App\Http\Controllers\Catalogs;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
class EspecificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permitted.catalogs.especificacions');
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
      $status= !empty($request->status) ? 1 : 0;
      $result = DB::table('especificacions')
            ->select('name')
            ->where([
                ['name', '=', $name],
              ])->count();
      if($result == 0)
      {
        $newId = DB::table('especificacions')
        ->insertGetId(['name' => $name,
                   'status' => $status,
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
    public function store(Request $request)
    {
      $user_id= Auth::user()->id;
      $id_received= Crypt::decryptString($request->token_b);
      $name= $request->inputEditName;
      $status= !empty($request->editstatus) ? 1 : 0;
      $result = DB::table('especificacions')
                ->select('name')
                ->where([
                    ['name', '=', $name],
                    ['id', '!=', $id_received],
                  ])->count();
      if($result == 0)
      {
        $newId = DB::table('especificacions')
        ->where('id', '=',$id_received )
        ->update([     'name' => $name,
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
      $resultados = DB::select('CALL GetAllEspecificacionv2 ()', array());
      return json_encode($resultados);
    }
    public function show_active(Request $request)
    {
      $resultados = DB::select('CALL GetAllEspecificacionActivev2 ()', array());
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
      $resultados = DB::select('CALL GetEspecificacionsByIdv2 (?)', array($identificador));
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
