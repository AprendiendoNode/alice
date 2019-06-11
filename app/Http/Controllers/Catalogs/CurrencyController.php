<?php

namespace App\Http\Controllers\Catalogs;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
class CurrencyController extends Controller
{
    private $list_symbol_position = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->list_symbol_position = ['L' => __('message.text_left'), 'R' => __('message.text_right')];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $list_symbol_position = $this->list_symbol_position;
      // dd($list_symbol_position);
      return view('permitted.catalogs.currencies',compact('list_symbol_position'));
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
       $code= $request->inputCreatCode;
       $rate = $request->inputCreatRate;
       $decimal_place = $request->inputCreatDecimal;
       $symbol = $request->inputCreatSymbol;
       $symbol_position = $request->select_one;
       $decimal_mark = $request->inputCreatMark;
       $thousands_separator = $request->inputCreatThousands;
       $orden= $request->inputCreatOrden;
       $status= !empty($request->status) ? 1 : 0;

       $result = DB::table('currencies')
                 ->select('id')
                 ->where([
                     ['code', '=', $code],
                   ])->count();
       if($result == 0)
       {
         $newId = DB::table('currencies')
         ->insertGetId(['name' => $name,
                        'code' => $code,
                        'rate' => $rate,
               'decimal_place' => $decimal_place,
                      'symbol' => $symbol,
             'symbol_position' => $symbol_position,
                'decimal_mark' => $decimal_mark,
         'thousands_separator' => $thousands_separator,
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
       $decimal_place = $request->inputEditDecimal;
              $symbol = $request->inputEditSymbol;
      $symbol_position= $request->editposition;
        $decimal_mark = $request->inputEditMark;
 $thousands_separator = $request->inputEditThousands;
                $orden= $request->inputEditOrden;
               $status= !empty($request->editstatus) ? 1 : 0;

           $result = DB::table('currencies')
                     ->select('id')
                     ->where([
                         ['code', '=', $code],
                         ['id', '!=', $id_received],
                       ])->count();
       if($result == 0)
       {
         $newId = DB::table('currencies')
         ->where('id', '=',$id_received )
         ->update([     'name' => $name,
                       'code' => $code,
                       'rate' => $rate,
              'decimal_place' => $decimal_place,
                     'symbol' => $symbol,
            'symbol_position' => $symbol_position,
               'decimal_mark' => $decimal_mark,
        'thousands_separator' => $thousands_separator,
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
      $resultados = DB::select('CALL GetAllCurrencyv2 ()', array());
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
       $resultados = DB::select('CALL GetTakesByIdv2 (?)', array($identificador));
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
