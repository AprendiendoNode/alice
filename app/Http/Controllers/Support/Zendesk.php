<?php

namespace App\Http\Controllers\Support;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use HomeDesignShops\Zendesk\ZendeskClient;
use Zendesk\API\HttpClient;
class Zendesk extends Controller
{
    protected $zendeskClient;

    public function __construct(ZendeskClient $zendeskClient) {
        $this->zendeskClient = $zendeskClient;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $tickets = zendesk()->tickets()->findAll();
      $tickets2 = zendesk()->tickets()->findAll(['per_page' => 100000, 'page' => 1]);
      return response()->json($tickets); //SOLO PARA VER EN GET
    }
    public function index2()
    {
      $ruta_next=1; //Para saber cuantas next_page existen en total nos da cuantas paginas si tienen datos.
      for ($n=1; $ruta_next != null ; $n++) {
        $ticketsB=zendesk()->tickets()->findAll(['per_page' => 100000, 'page' => $n]);
        echo $ruta_next=  $ticketsB->next_page;
        echo '<br>';
      }
      echo 'Npage='.$n;
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
    public function show($id)
    {
        //
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
