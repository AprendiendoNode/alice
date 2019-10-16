<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;
use App\Models\Projects\{Documentp, Kickoff_project};

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

  	if($cotizador_status != 4 && $cotizador_status != 5){
  		($documentp->objetivos_cotizador == 0 || $documentp->total_usd > 50000) ?  $documentp->cotizador_status_id = 2 : $documentp->cotizador_status_id = 4;
  		$documentp->save();
  	}

  }

}
