<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use App\User;

use App\Models\Survey\Surveydinamic_email;
use App\Models\Survey\Surveydinamic_user;

// use App\Surveydinamic;
use Illuminate\Support\Facades\Crypt;

class ConfigurationSurveyController extends Controller
{
    public function index()
    {
		$encuestas= DB::table('surveydinamics')->select('id', 'name')->get();
  		$hotels= DB::table('hotels')->select('id', 'Nombre_hotel')->orderBy('Nombre_hotel', 'ASC')->get();
  		$users = User::role('Surveyed')->get();

    	return view('permitted.survey.survey_configuration', compact('users','hotels'));
    	// return view('', compact());
    }
	public function create_client_nps(Request $request)
	{

		$name= $request->inputCreatName;
		$email= $request->inputCreatEmail;
		$email = trim($email);
		$city= $request->inputCreatLocation;
		$role= '6';

		if (User::where('email', '=', $email)->exists()) {
			return 'abort'; // returns error
		}
		else {
			$new_user = new User;
			$new_user->name=$name;
			$new_user->email=$email;
			$new_user->password= bcrypt('123456');
			$new_user->city=$city;
			$new_user->save();
			$new_user->assignRole($role);
			
			return '1';
		}
	}
	public function creat_assign_client_ht(Request $request)
	{
		$client= $request->select_clients;
		$hotels= $request->select_hotels;
		$size_hotels = count($hotels);

		$status = 0;
		// return $request;
		// echo $size_hotels.'<br>';

		for ($i=0; $i < $size_hotels; $i++) {
			$count_h_x_u = DB::select('CALL Comprobacion (?)', array($hotels[$i]));
			// $count_h_x_u = DB::table('hotel_user')->where('user_id', $client)->where('hotel_id', $hotels[$i])->count();
			if ($count_h_x_u[0]->valor == '0') {
				DB::table('hotel_user')->insertGetId(['user_id' => $client, 'hotel_id' => $hotels[$i]]);
				$status = 1;
			}
		}
		if ($status == '1') {
			// notificationMsg('success', 'Operation complete!');
			// return Redirect::back();
			return '1';
		}
		if ($status == '0') {
			// notificationMsg('danger', 'Operation Abort!- Motivo sitio asignado a otro cliente');
			// return Redirect::back();
			return 'abort';
		}
	}
	public function show_assign_client_nps(Request $request)
	{
		$resultado = DB::select('CALL px_venue_user_surveyed()');
		// $resultado= DB::table('venue_user_surveyed')->orderBy('nombre', 'asc')->get();
		return $resultado;
	}
	public function delete_assign_client_nps(Request $request){
		$hu= $request->uh;
		DB::table('hotel_user')->where('id', '=', $hu)->delete();
		return '1';
	}
	public function delete_client_nps(Request $request)
	{
		// if (auth()->user()->can('Delete user cliente')) {
		// return $request;

		if (auth()->user()->id == $request->delete_clients) {
			return 'abort';
			// notificationMsg('danger', 'Operation Abort!');
			// return Redirect::back();
		}
		else{
			$id_user = $request->delete_clients;
			$user = User::find($id_user);
			$delete_clients = DB::table('hotel_user')->where('user_id', '=', $id_user)->delete();
			$user->menus()->detach(); //Method of eloquent remove all
			$user->delete(); //Method of eloquent remove user

			return '1';
			// notificationMsg('success', 'Operation complete!');
			// return Redirect::back();
		}
	}
	public function show_nps(Request $request)
	{
		$input_vertical= $request->get('iv');
		$result = DB::select('CALL Get_Cliente_Vertical (?)', array($input_vertical));
		return $result;
	}

	public function capture_individual(Request $request)
	{
		$vertical= $request->select_ind_one;
		$clientes= $request->select_ind_two;
		$date_i= $request->date_start;
		$date_e= $request->date_end;
		$date_m= $request->month_evaluate;
		$operacion='0';
		$month=$date_m.'-01';

		for ($i=0; $i < count($clientes); $i++) {
			$pregunto_a = DB::table('surveydinamic_users')
			                      ->where('user_id', $clientes[$i])
			                      ->where('survey_id', '2') // id encuesta
			                      ->where('estatus_id', '1') //Activa
			                      ->where('estatus_res', '1') //NO CONTESTADA
			                      ->where('fecha_corresponde', $month)
			                      ->count();

			if ($pregunto_a == '0') {
			  //Pregunto b- Puede existir pero estar deshabilitada
			  $pregunto_b = DB::table('surveydinamic_users')
			                        ->where('user_id', $clientes[$i])
			                        ->where('survey_id', '2') // id encuesta
			                        ->where('estatus_id', '2') //deshabilitada
			                        ->where('estatus_res', '2') //CONTESTADA
			                        ->where('fecha_corresponde', $month)
			                        ->count();
			  if ($pregunto_b == '0') {
			    #ENTONCES VOLVEMOS A PREGUNTAR
			    $pregunto_c = DB::table('surveydinamic_users')
			                          ->where('user_id', $clientes[$i])
			                          ->where('survey_id', '2') // id encuesta
			                          ->where('estatus_id', '2') //deshabilitada
			                          ->where('estatus_res', '1') //NO CONTESTADA
			                          ->where('fecha_corresponde', $month)
			                          ->count();
			    if ($pregunto_c == '1') {
			      #ESTA DESHABILITADA PERO NO SE CONTESTO EN ESE PERIODO REGISTRO DE NUEVO
			      $nuevolink = $clientes[$i].'/'.'2'.'/'.$month.'/'.$date_e.'/'.'1';
			      $encriptodata= Crypt::encryptString($nuevolink);
			      $encriptostatus= Crypt::encryptString('1');

			      $new_survey_individual = new Surveydinamic_user;
			      $new_survey_individual->user_id=$clientes[$i];
			      $new_survey_individual->survey_id='2';
			      $new_survey_individual->estatus_id='1';
			      $new_survey_individual->estatus_res='1';
			      $new_survey_individual->fecha_inicial=$date_i;
			      $new_survey_individual->fecha_corresponde=$month;
			      $new_survey_individual->fecha_fin=$date_e;
			      $new_survey_individual->shell_data=$encriptodata;
			      $new_survey_individual->shell_status=$encriptostatus;
			      $new_survey_individual->save();

			      $sql = DB::table('users')->select('email', 'name')->where('id', $input_emails[$i])->get();

			      $datos = [
			         'nombre' => $sql[0]->name,
			         'shell_data' => $encriptodata,
			         'shell_status' => $encriptostatus
			      ];
			      return $datos;
			      // $this->sentSurveyEmail($sql[0]->email, $datos);
			      $operacion='1';
			    }
			    else{
			      #De plano no existe
			      $nuevolink = $clientes[$i].'/'.'2'.'/'.$month.'/'.$date_e.'/'.'1';
			      $encriptodata= Crypt::encryptString($nuevolink);
			      $encriptostatus= Crypt::encryptString('1');

			      $new_survey_individual = new Surveydinamic_user;
			      $new_survey_individual->user_id=$clientes[$i];
			      $new_survey_individual->survey_id='2';
			      $new_survey_individual->estatus_id='1';
			      $new_survey_individual->estatus_res='1';
			      $new_survey_individual->fecha_inicial=$date_i;
			      $new_survey_individual->fecha_corresponde=$month;
			      $new_survey_individual->fecha_fin=$date_e;
			      $new_survey_individual->shell_data=$encriptodata;
			      $new_survey_individual->shell_status=$encriptostatus;
			      $new_survey_individual->save();
			      $sql = DB::table('users')->select('email', 'name')->where('id', $clientes[$i])->get();
			      $datos = [
			         'nombre' => $sql[0]->name,
			         'shell_data' => $encriptodata,
			         'shell_status' => $encriptostatus
			      ];
			      // $this->sentSurveyEmail($sql[0]->email, $datos);
			      $operacion='1';
			    }
			  }
			  else {
			    #OPERACION ABORTADA POR QUE SE CONTESTO ESTE MES
			    $operacion='3';
			  }
			}
			else {
			  //Existe enlace -> Reenvio el link
			  $sql_data_user = DB::table('users')->select('email', 'name')->where('id', $clientes[$i])->get();
			  $data_pregunta = DB::table('surveydinamic_users')
			                        ->where('user_id', $clientes[$i])
			                        ->where('survey_id', '2') // id encuesta
			                        ->where('estatus_id', '1') //Activa
			                        ->where('estatus_res', '1') //NO CONTESTADA
			                        ->where('fecha_corresponde', $month)
			                        ->get();
			  $datos = [
			     'nombre' => $sql_data_user[0]->name,
			     'shell_data' => $data_pregunta[0]->shell_data,
			     'shell_status' => $data_pregunta[0]->shell_status
			  ];
			  // $this->sentSurveyEmail($sql_data_user[0]->email, $datos);
			  $operacion='2';
			}
		}//end del for

		return $operacion;
		/*if ($operacion == '4') {
		    notificationMsg('danger', 'Favor de llenar todos los campos!');
		    return Redirect::back();
		}
		if ($operacion == '3') {
		    notificationMsg('danger', 'Mes, ya evaluado!');
		    return Redirect::back();
		}
		if ($operacion == '2') {
		    notificationMsg('success', 'Se reenvio el enlace activo!');
		    return Redirect::back();
		}
		if ($operacion == '1') {
		  notificationMsg('success', 'Operation complete!');
		  return Redirect::back();
		}
		if ($operacion == '0') {
		  notificationMsg('danger', 'Operation Abort!');
		  return Redirect::back();
		}*/
	}
	public function show_table_resend(Request $request)
	{

	    $input_date_i= $request->get('data_one');
	    if ($input_date_i != '') {
	      $date_current = $input_date_i.'-01';
	    }
	    else {
			$fecha_cur = date('Y-m');
			$date_current = strtotime ( '-1 month' , strtotime ( $fecha_cur ) ) ;
			$date_current = date ( 'Y-m-01' , $date_current );
	    }
	    
		$resultados = DB::select('CALL px_surveydinamic_users_data (?)', array($date_current));
		return $resultados;
	}
}
