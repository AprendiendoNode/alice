<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Mail;
use DateTime;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use App\Models\Survey\Surveydinamic_email;
use App\Models\Survey\Surveydinamic_user;
use App\Models\Survey\Surveydinamic;
use App\Models\Survey\Qualificationab;
use App\Models\Survey\Qualificationaa;
use App\Models\Survey\Questiondinamic;
use Faker\Factory as Faker;

// use App\Mail\SentsurveySitwifiMail2;

class QuestionaryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($data)
   {
     $fecha_cancun = Carbon::now('America/Cancun')->format('Y-m-d');
     $date_current = strtotime($fecha_cancun);

     $encriptado_data = $data;
     // return $encriptado_data;
     $survey_check_user = Surveydinamic_user::where('shell_data', $encriptado_data)->count();
     //return $survey_check_user;
     if ($survey_check_user == '1') {
       $verify_date_of_survey_completion_type_a = Surveydinamic_user::where('shell_data', $encriptado_data)->value('fecha_fin');
       $date_of_survey = strtotime($verify_date_of_survey_completion_type_a);

       if ($date_current >= $date_of_survey) {
         // Fecha actual es mayor o igual que fecha registrada. Encuesta terminada.
         $title = 'Encuesta';
         $message = 'Finalizada.';
         $nota = 'Se redireccionara a la pagina principal';
         $icon = 'far fa-thumbs-up';
         return view('permitted.questionnaire.answer', compact('title','message','nota', 'icon'));
       }
       else{
         $status_survey_check_email = Surveydinamic_user::where('shell_data', $encriptado_data)->value('estatus_id');
         // return $status_survey_check_email;
         if ($status_survey_check_email == '1') {
           $encrypted_user = Crypt::decryptString($encriptado_data); // user, id_encuesta, mes a evaluar, fecha_fin
           $array_encrypted_user = explode("/", $encrypted_user);

           $id_user = $array_encrypted_user[0];
           $id_survey = $array_encrypted_user[1];
           $date_active = $array_encrypted_user[2];
           $date_end = $array_encrypted_user[3];
           $id_status = $array_encrypted_user[4];

           $question = DB::select('CALL GetAllQuestionBySurvey (?)', array($id_survey));
           return view('permitted.questionnaire.quizA', compact('question','id_user','id_survey', 'date_active', 'date_end'));
         }
         else {
           $title = 'Encuesta';
           $message = 'Finalizada.';
           $nota = 'Se redireccionara a la pagina principal';
           $icon = 'far fa-thumbs-up';
           return view('permitted.questionnaire.answer', compact('title','message','nota', 'icon'));
         }
       }
     }
     else {
       $survey_check_email = Surveydinamic_email::where('shell_data', '=', $encriptado_data)->count();
       if ($survey_check_email == '1') {
         $verify_date_of_survey_completion_type_b = Surveydinamic_email::where('shell_data', $encriptado_data)->value('fecha_fin');
         $date_of_survey = strtotime($verify_date_of_survey_completion_type_b);
         if ($date_current >= $date_of_survey) {
           // Fecha actual es mayor o igual que fecha registrada. Encuesta terminada.
           $title = 'Encuesta';
           $message = 'Finalizada.';
           $nota = 'Se redireccionara a la pagina principal';
           $icon = 'far fa-thumbs-up';
           return view('permitted.questionnaire.answer', compact('title','message','nota', 'icon'));
         }
         else {
           $status_survey_check_email = Surveydinamic_email::where('shell_data', '=', $encriptado_data)->value('estatus_id');
           if ($status_survey_check_email == '1') {
             $encrypted_user = Crypt::decryptString($encriptado_data); // user, id_encuesta, mes a evaluar, fecha_fin
             $array_encrypted_user = explode("/", $encrypted_user);

             $id_user = $array_encrypted_user[0];
             $id_survey = $array_encrypted_user[1];
             $date_active = $array_encrypted_user[2];
             $date_end = $array_encrypted_user[3];
             $id_status = $array_encrypted_user[4];
             $question = DB::select('CALL GetAllQuestionBySurvey (?)', array($id_survey));
             return view('permitted.questionnaire.quizB', compact('question','id_user','id_survey', 'date_active', 'date_end'));
           }
           else {
             $title = 'Encuesta';
             $message = 'Finalizada.';
             $nota = 'Se redireccionara a la pagina principal';
             $icon = 'far fa-thumbs-up';
             return view('permitted.questionnaire.answer', compact('title','message','nota', 'icon'));
           }
         }
       }
       else {
         $title = 'La URL es incorrecta.!!';
         $message = 'Error encontrado';
         $nota = 'Se redireccionara a la pagina principal';
         $icon = 'fas fa-exclamation-triangle';
         return view('permitted.questionnaire.answer', compact('title','message','nota', 'icon'));
       }
     }
   }
   /**
    * Registrar encuesta A
    */
   public function create_now(Request $request)
   {
        //Datos encriptados
       $data_survey = Crypt::decryptString($request->ultimapreg);
       $order_of_questions = Crypt::decryptString($request->ordenpreg);
       //Datos desencriptados
       //$data_survey = $request->ultimapreg;
       $array_of_data_survey= explode (",", $data_survey);

       $number_of_records= $array_of_data_survey[0];
       $id_user= $array_of_data_survey[1];
       $id_survey= $array_of_data_survey[2];
       $date_active= $array_of_data_survey[3];

       $email_user = User::where('id', '=', $id_user)->value('email');

       //$order_of_questions= $request->ordenpreg;
       $array_of_questions= explode (",", $order_of_questions);

       $inserto= 0;
       $actualizo= 0;

       for ($i=1; $i <= $number_of_records; $i++) {
         if ( isset( $request->{"pregunta".$array_of_questions[$i-1]} ) ) {
           $type_question = Questiondinamic::where('id', '=', $array_of_questions[$i-1] )->value('type_id');
           if ($type_question == '1') {
             $new_reg_a = new Qualificationaa;
             $new_reg_a->email = $email_user;
             $new_reg_a->option_id = $request->{"pregunta".$array_of_questions[$i-1]};
             $new_reg_a->question_id = $array_of_questions[$i-1];
             $new_reg_a->save();
           }
           elseif ($type_question == '2') {
             $new_reg_b = new Qualificationab;
             $new_reg_b->name = $request->{"pregunta".$array_of_questions[$i-1]};
             $new_reg_b->email = $email_user;
             $new_reg_b->question_id = $array_of_questions[$i-1];
             $new_reg_b->save();
           }

           // echo '<br>posicion = '.$i.'<br>';
           // echo $request->{"pregunta".$array_of_questions[$i-1]};
           $inserto = 1;
         }
       }
       if ($inserto == 1) {
         $update_user_reg = DB::table('surveydinamic_users')
                            ->where('user_id', $id_user)
                            ->where('survey_id', $id_survey)
                            ->where('fecha_corresponde', $date_active)
                            ->update([
                              'estatus_id' => '2',
                              'estatus_res' => '2',
                              'updated_at' => \Carbon\Carbon::now(),
                            ]);
          $actualizo = $update_user_reg;
       }
       // return $actualizo; //0 no & 1 si
       return back();
   }

   /**
    * Registrar encuesta B
    */
   public function create_now_email(Request $request)
   {
     //Datos encriptados
     $data_survey = Crypt::decryptString($request->ultimapreg);
     $order_of_questions = Crypt::decryptString($request->ordenpreg);
     //Datos desencriptados
     //$data_survey = $request->ultimapreg;
     $array_of_data_survey= explode (",", $data_survey);

     $number_of_records= $array_of_data_survey[0];
     $email_user= $array_of_data_survey[1];
     $id_survey= $array_of_data_survey[2];
     $date_active= $array_of_data_survey[3];

     //$order_of_questions= $request->ordenpreg;
     $array_of_questions= explode (",", $order_of_questions);

     $inserto= 0;
     $actualizo= 0;

     for ($i=1; $i <= $number_of_records; $i++) {
       if ( isset( $request->{"pregunta".$array_of_questions[$i-1]} ) ) {
         $type_question = Questiondinamic::where('id', '=', $array_of_questions[$i-1] )->value('type_id');
         if ($type_question == '1') {
           $new_reg_a = new Qualificationaa;
           $new_reg_a->email = $email_user;
           $new_reg_a->option_id = $request->{"pregunta".$array_of_questions[$i-1]};
           $new_reg_a->question_id = $array_of_questions[$i-1];
           $new_reg_a->save();
         }
         elseif ($type_question == '2') {
           $new_reg_b = new Qualificationab;
           $new_reg_b->name = $request->{"pregunta".$array_of_questions[$i-1]};
           $new_reg_b->email = $email_user;
           $new_reg_b->question_id = $array_of_questions[$i-1];
           $new_reg_b->save();
         }
         // echo '<br>posicion = '.$i.'<br>';
         // echo $request->{"pregunta".$array_of_questions[$i-1]};
         $inserto = 1;
       }
     }
     if ($inserto == 1) {
       $update_user_reg = DB::table('surveydinamic_emails')
                          ->where('email', $email_user)
                          ->where('survey_id', $id_survey)
                          ->where('fecha_corresponde', $date_active)
                          ->update([
                            'estatus_id' => '2',
                            'estatus_res' => '2',
                            'updated_at' => \Carbon\Carbon::now(),
                          ]);
        $actualizo = $update_user_reg;
     }
     return back();
   }
   /**
    * Registrar componentes
    */
   public function component()
   {
    return view('permitted.questionnaire.component');
   }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
     $survey_name = Surveydinamic::where('id', 2)->value('name');
     $users_sit = User::find(109);
     $i=1;
       $name = $users_sit->name;
       $email = trim($users_sit->email);
       $id_user = $users_sit->id;
       $id_survey = 2;
       $id_status = 1;
       $id_status_rest = 1;
       $date_start = '2019-07-01';
       $date_active = '2019-07-01';
       $date_end = '2019-07-31';

       $nuevolink = $id_user.'/'.$id_survey.'/'.$date_active.'/'.$date_end.'/'.$id_status;
       $shell_data= Crypt::encryptString($nuevolink);

       ${"new_survey_type".$i} = new Surveydinamic_user;
       ${"new_survey_type".$i}->user_id=$id_user;
       ${"new_survey_type".$i}->survey_id=$id_survey;
       ${"new_survey_type".$i}->estatus_id=$id_status;
       ${"new_survey_type".$i}->estatus_res=$id_status_rest;
       ${"new_survey_type".$i}->fecha_inicial=$date_start;
       ${"new_survey_type".$i}->fecha_corresponde=$date_active;
       ${"new_survey_type".$i}->fecha_fin=$date_end;
       ${"new_survey_type".$i}->shell_data=$shell_data;
       ${"new_survey_type".$i}->shell_status='';
       ${"new_survey_type".$i}->save();

   }
   public function create12()
   {
      // DB::statement('SET FOREIGN_KEY_CHECKS=0;'); //Deshabilita la revision de foreign key
      //  Surveydinamic_user::truncate();
      // DB::statement('SET FOREIGN_KEY_CHECKS=1;'); //Habilita la revision de foreign key

      $input_domain = 'sitwifi.com';
      $users_sit = DB::select('CALL get_domain_user (?)', array($input_domain));

      $count_user = count($users_sit);
      $survey_name = Surveydinamic::where('id', 2)->value('name');

     for ($i=1; $i < $count_user; $i++) {
       $name = $users_sit[$i]->name;
       $email = trim($users_sit[$i]->email);
       $id_user = $users_sit[$i]->id;
       $id_survey = 2;
       $id_status = 1;
       $id_status_rest = 1;
       $date_start = '2019-08-01';
       $date_active = '2019-08-01';
       $date_end = '2019-08-31';

       $nuevolink = $id_user.'/'.$id_survey.'/'.$date_active.'/'.$date_end.'/'.$id_status;
       $shell_data= Crypt::encryptString($nuevolink);

       ${"new_survey_type".$i} = new Surveydinamic_user;
       ${"new_survey_type".$i}->user_id=$id_user;
       ${"new_survey_type".$i}->survey_id=$id_survey;
       ${"new_survey_type".$i}->estatus_id=$id_status;
       ${"new_survey_type".$i}->estatus_res=$id_status_rest;
       ${"new_survey_type".$i}->fecha_inicial=$date_start;
       ${"new_survey_type".$i}->fecha_corresponde=$date_active;
       ${"new_survey_type".$i}->fecha_fin=$date_end;
       ${"new_survey_type".$i}->shell_data=$shell_data;
       ${"new_survey_type".$i}->shell_status='';
       ${"new_survey_type".$i}->save();

       $datos = [
          'encuesta_name' => $survey_name,
          'nombre' => $name,
          'shell_data' => $shell_data
       ];
       // Mail::to($email)->queue(new SentsurveySitwifiMail2($datos));
     }
     return 'Encuestar creadas correctamente.';
   }
   public function create2()
   {
     // DB::statement('SET FOREIGN_KEY_CHECKS=0;'); //Deshabilita la revision de foreign key
     //   Surveydinamic_email::truncate();
     // DB::statement('SET FOREIGN_KEY_CHECKS=1;'); //Habilita la revision de foreign key

     for ($i=1; $i <= 3; $i++) {
       $faker = Faker::create();
       $id_user = $faker->email;
       $id_survey = 1;
       $id_status = 1;
       $id_status_rest = 1;
       $date_start = '2019-04-01';
       $date_active = '2019-04-01';
       $date_end = '2019-04-30';

       $nuevolink = $id_user.'/'.$id_survey.'/'.$date_active.'/'.$date_end.'/'.$id_status;
       $shell_data= Crypt::encryptString($nuevolink);

       ${"new_survey_type2".$i} = new Surveydinamic_email;
       ${"new_survey_type2".$i}->email=$id_user;
       ${"new_survey_type2".$i}->survey_id=$id_survey;
       ${"new_survey_type2".$i}->estatus_id=$id_status;
       ${"new_survey_type2".$i}->estatus_res=$id_status_rest;
       ${"new_survey_type2".$i}->fecha_inicial=$date_start;
       ${"new_survey_type2".$i}->fecha_corresponde=$date_active;
       ${"new_survey_type2".$i}->fecha_fin=$date_end;
       ${"new_survey_type2".$i}->shell_data=$shell_data;
       ${"new_survey_type2".$i}->shell_status='';
       ${"new_survey_type2".$i}->save();
     }
     return $i;
   }
}
