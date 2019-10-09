<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;
use DB;

class Kickoff_project extends Model
{
  protected $table = 'kickoff_project';
  protected $fillable = ['id_doc'];

  public static function getConditionsByDocumentp($id_doc)
  {
  	$condiciones = DB::table('documentp_condiciones')
				  	->join('condiciones_comerciales', 'documentp_condiciones.id_condicion_comercial', '=', 'condiciones_comerciales.id')
				  	->where('id_doc', $id_doc)
				  	->where('active', 1)->get();

	return $condiciones;
  }

  public static function createConditionsByDocumentp($id_doc)
  {
  	$condiciones = DB::table('condiciones_comerciales')->get();
  	
  	foreach ($condiciones as $condicion) {
  		DB::table('documentp_condiciones')->insert(
		    ['id_doc' => $id_doc, 'id_condicion_comercial' => $condicion->id]
		);
  	}
  	
  }

}
