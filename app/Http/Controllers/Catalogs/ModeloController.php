<?php

namespace App\Http\Controllers\Catalogs;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
class ModeloController extends Controller
{
  private $list_moneda = [];
  private $list_marca = [];
  private $list_espec = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->list_moneda = DB::table('currencies')->select('name')->pluck('name')->all();
        $this->list_marca = DB::table('marcas')->select('Nombre_marca')->pluck('Nombre_marca')->all();
        $this->list_espec = DB::table('especificacions')->select('name')->where([['status', '=', 1],])->pluck('name')->all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $list_moneda = $this->list_moneda;
      $list_marca = $this->list_marca;
      $list_espec = $this->list_espec;
      
      return view('permitted.catalogs.models',compact('list_moneda', 'list_marca', 'list_espec'));
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
         $costo= $request->inputCreatCosto;
         $moneda= $request->select_onemoneda;
         $marca= $request->select_onemarca;
         $espec= $request->select_oneespec;
        $orden= $request->inputCreatOrden;
       $status= !empty($request->status) ? 1 : 0;
       $result = DB::table('modelos')
                 ->select('ModeloNombre')
                 ->where([
                     ['ModeloNombre', '=', $name],
                   ])->count();
       if($result == 0)
       {
         $monedaId = DB::table('currencies')
                     ->where([
                         ['name', '=', $moneda],
                       ])->value('id');
         $marcaId = DB::table('marcas')
                     ->where([
                         ['Nombre_marca', '=', $marca],
                       ])->value('id');
         $especId = DB::table('especificacions')
                     ->where([
                         ['name', '=', $espec],
                       ])->value('id');
         $newId = DB::table('modelos')
         ->insertGetId(['ModeloNombre' => $name,
                       'Costo' => $costo,
                       'currency_id' => $monedaId,
                       'marca_id' => $marcaId,
                       'especification_id' => $especId,
                  'sort_order' => $orden,
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
    public function store(Request $request) //FALTÓ ESTO!!!!!
    {
      $user_id= Auth::user()->id;
      $id_received= Crypt::decryptString($request->token_b);
             $name= $request->inputEditName;
             $costo= $request->inputEditCosto;
             $moneda= $request->editpositionmoneda;
             $marca= $request->editpositionmarca;
             $espec= $request->editpositionespec;
            $orden= $request->inputEditOrden;
           $status= !empty($request->editstatus) ? 1 : 0;
           $result = DB::table('modelos')
                     ->select('ModeloNombre')
                     ->where([
                         ['ModeloNombre', '=', $name],
                         ['id', '!=', $id_received],
                       ])->count();
           if($result == 0)
           {
            $monedaId = DB::table('currencies')
            ->where([
                ['name', '=', $moneda],
              ])->value('id');
            $marcaId = DB::table('marcas')
            ->where([
                ['Nombre_marca', '=', $marca],
              ])->value('id');
            $especId = DB::table('especificacions')
            ->where([
                ['name', '=', $espec],
              ])->value('id');
             $newId = DB::table('modelos')
             ->where('id', '=',$id_received )
             ->update([     'ModeloNombre' => $name,
                      'Costo' => $costo,
                    'currency_id' => $monedaId,
                    'marca_id' => $marcaId,
                    'especification_id' => $especId,
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
      $resultados = DB::select('CALL GetAllModelsv2 ()', array());
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
      $resultados = DB::select('CALL GetModelByIdv2 (?)', array($identificador));
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
