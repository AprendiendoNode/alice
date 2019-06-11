<?php

namespace App\Http\Controllers\Catalogs;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Catalogs\Tax;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class TaxController extends Controller
{
    private $list_factor = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->list_factor = [
            Tax::TASA => __('invoicing.text_factor_tasa'),
            Tax::CUOTA => __('invoicing.text_factor_cuota'),
            Tax::EXENTO => __('invoicing.text_factor_exento')
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $list_factor = $this->list_factor;
      return view('permitted.catalogs.taxes',compact('list_factor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $user_id= Auth::user()->id;
      $code= $request->inputCreatCode;
      $name= $request->inputCreatName;
      $rate = $request->inputCreatRate;
      $factor = $request->select_one;
      $orden= $request->inputCreatOrden;
      $status= !empty($request->status) ? 1 : 0;
      $result = DB::table('taxes')
                ->select('id')
                ->where([
                    ['code', '=', $code],
                  ])->count();
      if($result == 0)
      {
        $newId = DB::table('taxes')
        ->insertGetId(['name' => $name,
                       'code' => $code,
                       'rate' => $rate,
                     'factor' => $factor,
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
    public function store(Request $request)
    {
            $user_id= Auth::user()->id;
        $id_received= Crypt::decryptString($request->token_b);
               $code= $request->inputEditCode;
               $name= $request->inputEditName;
              $rate = $request->inputEditRate;
            $factor = $request->editposition;
              $orden= $request->inputEditOrden;
             $status= !empty($request->editstatus) ? 1 : 0;

             $result = DB::table('taxes')
                       ->select('id')
                       ->where([
                           ['code', '=', $code],
                           ['id', '!=', $id_received],
                         ])->count();
         if($result == 0)
         {
           $newId = DB::table('taxes')
           ->where('id', '=',$id_received )
           ->update([     'name' => $name,
                         'code' => $code,
                         'rate' => $rate,
                       'factor' => $factor,
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
      $resultados = DB::select('CALL GetAllTaxesv2 ()', array());
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
      $resultados = DB::select('CALL GetTaxesByIdv2 (?)', array($identificador));
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
