<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;
use App\Models\Projects\{Documentp, Kickoff_project,Cotizador_approval_propuesta};

class Cotizador extends Model
{
  protected $table = 'cotizador';
  protected $fillable = ['id_doc'];

  public static function set_objetivos_cotizador($id_documentp, $objetivos_cotizador)
  {
  	$documentp = Documentp::findOrFail($id_documentp);
  	$documentp->objetivos_cotizador = $objetivos_cotizador;
  	$documentp->save();
  }

  public static function set_status_cotizador($id_documentp)
  {
  	$documentp = Documentp::findOrFail($id_documentp);
  	$cotizador_status = $documentp->cotizador_status_id;
	//Diferente de estatus en KICKOFF
  	if($cotizador_status != 5){
		//Fuera de parametros
  		if($documentp->objetivos_cotizador == 0 || $documentp->total_usd > 50000){
			$documentp->cotizador_status_id = 2;
			$documentp->save();
			$cotizador = Cotizador::where('id_doc', $documentp->id)->first();
			$aprovals_propuesta = Cotizador_approval_propuesta::firstOrCreate(['cotizador_id' => $cotizador->id]);
			$aprovals_propuesta->administracion = 0;
			$aprovals_propuesta->director_comercial = 0;
			$aprovals_propuesta->director_operaciones = 0;
			$aprovals_propuesta->director_general = 0;
			$aprovals_propuesta->save();
		}else{
		//Autorizado
			$documentp->cotizador_status_id = 4;
			$documentp->save();
		}   
  	}

  }

}
