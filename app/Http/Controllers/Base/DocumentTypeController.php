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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
       return json_encode($resultados);
     }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
