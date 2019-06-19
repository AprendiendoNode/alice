<?php

namespace App\Http\Controllers\Base;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
class PacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permitted.base.pac');
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
   $url_timbre= $request->entry_ws_url;
   $url_cancel= !empty($request->entry_ws_url_cancel) ? $request->entry_ws_url_cancel : '';
   $entry_comment= !empty($request->entry_comment) ? $request->entry_comment : '';
     $username= $request->entry_username;
     $userpass= $request->entry_password;
        $orden= $request->inputCreatOrden;
         $test= !empty($request->test) ? 1 : 0;
       $status= !empty($request->status) ? 1 : 0;
       $result= DB::table('pacs')
                 ->select('code')
                 ->where([
                     ['code', '=', $code],
                   ])->count();
       if($result == 0)
       {
         $newId = DB::table('pacs')
         ->insertGetId([
                    'name' => $name,
                    'code' => $code,
                    'ws_url' => $url_timbre,
                    'ws_url_cancel' => $url_cancel,
                    'username' => $username,
                    'password' => $userpass,
                    'test' => $test,
                    'comment' => $entry_comment,
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
                 $name= $request->inputEditName;
                 $code= $request->inputEditCode;
           $url_timbre= $request->edit_entry_ws_url;
           $url_cancel= !empty($request->edit_entry_ws_url_cancel) ? $request->edit_entry_ws_url_cancel : '';
        $entry_comment= !empty($request->edit_entry_comment) ? $request->edit_entry_comment : '';
             $username= $request->edit_entry_username;
             $userpass= $request->edit_entry_password;
                $orden= $request->inputEditOrden;
                 $test= !empty($request->edit_test) ? 1 : 0;
               $status= !empty($request->editstatus) ? 1 : 0;

         $result = DB::table('pacs')
                   ->select('code')
                   ->where([
                       ['code', '=', $code],
                       ['id', '!=', $id_received],
                     ])->count();
         if($result == 0)
         {
           $newId = DB::table('pacs')
           ->where('id', '=',$id_received )
           ->update([    'name' => $name,
                         'code' => $code,
                       'ws_url' => $url_timbre,
                'ws_url_cancel' => $url_cancel,
                     'username' => $username,
                     'password' => $userpass,
                         'test' => $test,
                      'comment' => $entry_comment,
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
       $resultados = DB::select('CALL GetAllPacv2 ()', array());
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
       $resultados = DB::select('CALL GetPacByIdv2 (?)', array($identificador));
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
