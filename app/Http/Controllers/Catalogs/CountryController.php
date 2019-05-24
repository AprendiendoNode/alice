<?php

namespace App\Http\Controllers\Catalogs;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Catalogs\country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('permitted.catalogs.countries');
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
        $orden= $request->inputCreatOrden;
       $status= !empty($request->status) ? 1 : 0;
       $result = DB::table('countries')
                 ->select('code')
                 ->where([
                     ['code', '=', $code],
                   ])->count();
       if($result == 0)
       {
         $newId = DB::table('countries')
         ->insertGetId(['code' => $code,
                        'name' => $name,
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
            $orden= $request->inputEditOrden;
           $status= !empty($request->editstatus) ? 1 : 0;
           $result = DB::table('countries')
                     ->select('code')
                     ->where([
                         ['code', '=', $code],
                         ['id', '!=', $id_received],
                       ])->count();
           if($result == 0)
           {
             $newId = DB::table('countries')
             ->where('id', '=',$id_received )
             ->update([     'code' => $code,
                            'name' => $name,
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
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(country $country)
    {
      $resultados = country::select('id','name', 'code', 'sort_order','status')->get();
      return json_encode($resultados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
      $identificador= $request->value;
      $resultados = DB::select('CALL GetCountryByIdv2 (?)', array($identificador));
      foreach ($resultados as $key) {
        $key->id = Crypt::encryptString($key->id);
      }
      return $resultados;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(country $country)
    {
        //
    }
}
