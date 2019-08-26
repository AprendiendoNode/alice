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
use App\Mail\SendEmailSurvey;
class ConfigurationITController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('permitted.survey.configurationitc');
  }

  /** Actual month first day **/
  function _data_first_month_day() {
      $month = date('m');
      $year = date('Y');
      // return date('Y-m-d', mktime(0,0,0, $month, 1, $year));

      $fecha = date('Y-m-d', mktime(0,0,0, $month, 1, $year));

      $nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
      $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
      return $nuevafecha;
  }
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show(Request $request)
   {

     $fecha= $this->_data_first_month_day();
     $user_id = Auth::user()->id;
     $resultados = DB::select('CALL px_survey_xusers (?, ?)', array($user_id, $fecha));

     // $fecha= $this->_data_first_month_day();
     // $resultados = DB::select('CALL px_surveydinamic_users_data (?)', array($fecha));
     return json_encode($resultados);
   }
   public function search_hotel_user(Request $request)
   {
     $resultados = DB::select('CALL buscar_venue_user (?)', array($request->token_b));
     return json_encode($resultados);
   }
   function is_valid_email($str)
    {
      $matches = null;
      return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $str, $matches));
    }
   public function send_surveyitc(Request $request)
   {
     $id_registro = $request->tken_b;
     $sql =  DB::select('CALL px_surveydinamic_users_data_xid (?)', array($id_registro));
     $mail = $sql[0]->email;
     $message = [
                  'nombre' => $sql[0]->user,
                  'shell_data' => $sql[0]->shell_data,
                  'shell_status' => $sql[0]->shell_status
                ];

     #valido primero los correos a copiar
     $pila_cc = array();
     $pila_mal = array();
     if (!empty($request->attach)) {
       foreach ($request->attach as $key => $item) {
         if($this->is_valid_email($item) == 1) {
           array_push($pila_cc, $item);
         }
         else {
           array_push($pila_mal, $item);
         }
       }
     }
     #si existen realizo lo siguiente
     try{
       if (!empty($pila_cc)) {
         Mail::to($mail)->cc($pila_cc)->send(new SendEmailSurvey($message));
       }
       else {
         Mail::to($mail)->send(new SendEmailSurvey($message));
       }
       #Estructura del mensaje
       $string_mail_a = implode(",", $pila_cc);
       $string_mail_b = implode(",", $pila_mal);

       $text_ini = 'Se envio a : '.$mail;
       $text_cc= !empty($pila_cc) ? 'Con copia a: '.$string_mail_a : '';
       $text_exception =  !empty($pila_mal) ? 'Con excepción a: '.$string_mail_b : '';
       $message_end = $text_ini.' '.$text_cc.' '.$text_exception;

       #Si no se inserto un correo sin el formato de mail
       if (empty($pila_mal)) {
         return response()->json(['success' => $message_end], 200);
       }
       else{
         return response()->json(['error' => $message_end], 422);
       }
      }
      catch(\Swift_RfcComplianceException $e){
        // return $e;
        return response()->json(['error' => 'Address in mailbox given does not comply with RFC 2822, 3.6.2.'], 422);
        echo("swift exception: " . $e);
      }
   }
}
