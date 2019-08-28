<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('permitted.survey.create_survey');
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
      $name = !empty($request->title) ? $request->title : '';
      $description = !empty($request->description) ? $request->description : '';
      $input_items = $request->item;
      if (!empty($input_items)) {
        foreach ($input_items as $key => $item) {

           $id = $item['id']; //ID PREGUNTA
           $title = $item['question']; //TITULO PREGUNTA
           $answer_type = $item['answertype']; //TIPO DE PREGUNTA

           echo '/'.$id.'/'.$title.'/';

           if ($answer_type == 1) { //Abierta
             // code...
           }
           elseif ($answer_type == 2) { //Opción multiple
             // code...
             //${"snmp_aps_a".$i}
             $input_items_option = $request->input('item_'.$id);
             if (!empty($input_items_option)) {
               foreach ($input_items_option as $key => $item_option) {
                 echo '/';
                 echo $item_option['answer'];
                 echo '/';
               }
             }
             // code...
           }
        }
      }
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
