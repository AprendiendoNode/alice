<?php

namespace App\Http\Controllers\Base;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalogs\CfdiType;
use App\Models\Base\DocumentType;
use Illuminate\Support\Facades\Crypt;
class DocumentTypeController extends Controller
{
    public function __construct()
    {
        $this->list_nature = [
            DocumentType::NO_NATURE => 'Sin naturaleza',
            DocumentType::DEBIT => 'Cargo',
            DocumentType::CREDIT => 'Abono',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_nature = $this->list_nature;
        $cfditypes = DB::select('CALL GetAllCfdiTypeActivev2 ()', array());
        return view('permitted.base.document_types',compact('list_nature', 'cfditypes'));
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
           $prefix= $request->inputCreatPrefix;
         $currency= $request->inputCreatCurrency;
        $increment= $request->inputCreatIncrement;
       $naturaleza= $request->select_one;
 $tipo_comprobante= $request->select_two;
            $orden= $request->inputCreatOrden;
            $status= !empty($request->status) ? 1 : 0;
            $result= DB::table('document_types')
                      ->select('code')
                      ->where([
                          ['prefix', '=', $prefix],
                        ])->count();
            if($result == 0)
            {
              $newId = DB::table('document_types')
              ->insertGetId([
                         'name' => $name,
                         'code' => $code,
                         'prefix' => $prefix,
                         'current_number' => $currency,
                         'increment_number' => $increment,
                         'nature' => $naturaleza,
                         'cfdi_type_id' => $tipo_comprobante,
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
           $prefix= $request->inputEditPrefix;
         $currency= $request->inputEditCurrency;
        $increment= $request->inputEditIncrement;
       $naturaleza= $request->edit_select_one;
 $tipo_comprobante= $request->edit_select_two;
            $orden= $request->inputEditOrden;
            $status= !empty($request->editstatus) ? 1 : 0;

         $result = DB::table('document_types')
                   ->select('code')
                   ->where([
                       ['prefix', '=', $prefix],
                       ['id', '!=', $id_received],
                     ])->count();
         if($result == 0)
         {
           $newId = DB::table('document_types')
           ->where('id', '=',$id_received )
           ->update([     'name' => $name,
                          'code' => $code,
                        'prefix' => $prefix,
                'current_number' => $currency,
              'increment_number' => $increment,
                        'nature' => $naturaleza,
                  'cfdi_type_id' => $tipo_comprobante,
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
       $resultados = DB::select('CALL GetAllDocTypev2 ()', array());
       $list_nature = $this->list_nature;

       foreach ($resultados as $key) {
          $valor = $key->nature;
           if (array_key_exists( ($valor), $list_nature)) {
                $key->nature = $list_nature[$valor];
            }
       }
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
      $resultados = DB::select('CALL GetAllDocTypeByIdv2 (?)', array($identificador));
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
