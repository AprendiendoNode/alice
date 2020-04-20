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
	//Diferente de estatus "Firma de contrato" y " EN KICKOFF"
  	if($cotizador_status != 5 && $cotizador_status != 6){
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

  public function createFullProject($request)
  {

	$id_user = 4;
	$fecha = $request->date;
	$nombre_proyecto = $request->proyecto;
	$num_sitios = $request->sites;
	$total_usd = $request->total;
	$lugar_instalacion = $request->lugar_instalacion;
	$num_oportunidad = $request->oportunity;
	$type_service = $request->type_service;
	$priority = 2; // Prioridad normal
	$itc_id = $request->itc;
	$grupo = $request->grupo;
	$comercial_id = $request->comercial;
	$densidad = $request->densidad;
	$vertical_id = $request->vertical;
	$total_ea = $request->total_ea;
	$total_ena = $request->total_ena;
	$total_mo = $request->total_mo;
	$total = $request->total;
	$grupo_id = 23;  // sin asignar
	$anexo_id = 7; // sin asignar
	$folio_new = $this->createFolio();
	$itc_name = $itc->name;
	$flag  = "false";

	DB::beginTransaction();

	try {
	  	//Creando carrito
		$new_documentp_cart = new Documentp_cart;
		$new_documentp_cart->status_id = 1;
		$new_documentp_cart->created_at = \Carbon\Carbon::now();
		$new_documentp_cart->save();

		$new_documentp = new Documentp;
		//Datos del proyecto
		$new_documentp->doc_type = $request->doc_type;
		$new_documentp->folio = $folio_new;
		$new_documentp->fecha = date('Y-m-d');
		$new_documentp->nombre_proyecto = $nombre_proyecto;
		$new_documentp->num_sitios = $num_sitios;
		$new_documentp->densidad = $densidad;
		$new_documentp->num_oportunidad = $num_oportunidad;
		$new_documentp->nombre_grupo = $grupo;
		$new_documentp->lugar_instalacion_id = $lugar_instalacion;
		$new_documentp->itc_id = $itc_id;
		$new_documentp->user_id = $id_user;
		$new_documentp->comercial_id = $comercial_id;
		$new_documentp->total_usd = $total;
		$new_documentp->total_ea = $total_ea;
		$new_documentp->total_ena = $total_ena;
		$new_documentp->total_mo = $total_mo;
		$new_documentp->total_viaticos = $request->total_viaticos;
		$new_documentp->vertical_id = $vertical_id;
		$new_documentp->tipo_servicio_id = $type_service;
		$new_documentp->status_id = 1;
		$new_documentp->grupo_id = $grupo_id;
		$new_documentp->anexo_id = $anexo_id;
		//financieros
		$new_documentp->plazo = $request->plazo;
		$new_documentp->renta_anticipada = $request->renta;
		$new_documentp->enlace = $request->enlace;
		$new_documentp->servicio_mensual = $request->servicio;
		$new_documentp->deposito_garantia = $request->deposito;
		$new_documentp->capex = $request->capex;
		$new_documentp->instalaciones = $request->instalaciones;
		$new_documentp->indirectos = $request->indirectos;
		$new_documentp->utilidad_venta_ea = $request->utilidad;

		$new_documentp->priority_id = 2;
		$new_documentp->num_edit = 0;
		$new_documentp->documentp_cart_id = $new_documentp_cart->id;
		$new_documentp->created_at = \Carbon\Carbon::now();
		$new_documentp->updated_at = \Carbon\Carbon::now();
		$new_documentp->save();

		$new_documentp_project = new Documentp_project;
		$new_documentp_project->id_motivo = 7; //NA
		$new_documentp_project-> tuberias = 100;
		$new_documentp_project->cableado = 100;
		$new_documentp_project->org_cableado = 100;
		$new_documentp_project->ponchado_cables = 100;
		$new_documentp_project->identificacion = 100;
		$new_documentp_project->instalacion_antenas = 100;
		$new_documentp_project->instalacion_switches = 100;
		$new_documentp_project->config_site = 100;
		$new_documentp_project->config_zone_director = 100;
		$new_documentp_project->infraestructura_test = 100;
		$new_documentp_project->test_general = 100;
		$new_documentp_project->recorrido = 100;
		$new_documentp_project->firma_acta = 100;
		$new_documentp_project->instalacion_total = 100;
		$new_documentp_project->configuracion_total = 100;
		$new_documentp_project->test_total = 100;
		$new_documentp_project->total_global = 100;
		$new_documentp_project->id_doc = $new_documentp->id;
		$new_documentp_project->save();

		//Cotizador
		$new_cotizador = new Cotizador;
		$new_cotizador->id_doc = $new_documentp->id;
		$new_cotizador->created_at = \Carbon\Carbon::now();
		$new_cotizador->save();
		//Inversion
		DB::table('cotizador_inversion')->insert([
			['cotizador_id' => $new_cotizador->id,
			 'inversion_ea' => $request->total_ea,
			 'inversion_ena' => $request->total_ena,
			 'inversion_ea_percent' => $request->rubro_ea_percent,
			 'inversion_ena_percent' => $request->rubro_ena_percent,
			 'mano_obra' => $request->total_mo,
			 'viaticos' => $request->total_viaticos,
			 'mano_obra_percent' => $request->rubro_mo_percent,
			 'viaticos_percent' => $request->rubro_viaticos_percent,
			 'indirectos' => $request->rubro_indirectos,
			 'indirectos_percent' => $request->rubro_indirectos_percent,
			 'comision' => $request->rubro_comision,
			 'comision_percent' => $request->rubro_comision_percent,
			 'inversion_real' => $request->total_rubros,
			 'created_at' => \Carbon\Carbon::now()
			]
		]);
		//Gastos
		DB::table('cotizador_gastos_mensuales')->insert([
			['cotizador_id' => $new_cotizador->id,
			 'credito_mensual' => $request->credito_mensual,
			 'credito_mensual_percent' => $request->credito_mensual_percent,
			 'mantto_seg_otro' => $request->gasto_mtto,
			 'mantto_seg_otro_percent' => $request->gasto_mtto_percent,
			 'enlace' => $request->gasto_enlace,
			 'total_gasto_mensual' => $request->total_gastos,
			 'created_at' => \Carbon\Carbon::now()
			]
		]);
		//Modelo de negocios
		DB::table('cotizador_modelo_negocio')->insert([
			['cotizador_id' => $new_cotizador->id,
			 'enlace' => $request->modelo_enlace,
			 'mensual_habitacion' => $request->modelo_mensual_hab,
			 'serv_mensual' => $request->modelo_serv_mens,
			 'antenas' => $request->modelo_antenas,
			 'habitacion_enlace' => $request->modelo_hab_enlace,
			 'created_at' => \Carbon\Carbon::now()
			]
		]);
		//Opcionalmente
		DB::table('cotizador_opciones')->insert([
			['cotizador_id' => $new_cotizador->id,
			 'created_at' => \Carbon\Carbon::now()
			]
		]);
		//Servicio administrado
		DB::table('cotizador_servadm_usd')->insert([
			['cotizador_id' => $new_cotizador->id,
			 'renta_mas_enlace' => $request->renta_enlace,
			 'capex' => $request->serv_capex,
			 'renta_anticipada' => $request->serv_renta,
			 'plazo' => $request->serv_plazo,
			 'hab_por_antena' => $request->serv_hab_antenas,
			 'servadm_por_habitacion' => $request->serv_adm_habitacion,
			 'created_at' => \Carbon\Carbon::now()
			]
		]);
		//Objetivos
		DB::table('cotizador_objetivos')->insert([
			['cotizador_id' => $new_cotizador->id,
			 'utilidad_mensual' => $request->utilidad_mensual,
			 'utilidad_mensual_percent' => 0,
			 'utilidad_proyecto' => $request->utilidad_proyecto,
			 'utilidad_proyecto_percent' => 0,
			 'vtc' => $request->vtc,
			 'renta_mensual_inversion' => $request->renta_mensual_inversion,
			 'utilidad_inversion' => $request->utilidad_inversion,
			 'utilidad_renta_percent' => $request->utilidad_renta,
			 'costo_por_ap' => $request->costo_mo_ap,
			 'tir' => $request->tir,
			 'tiempo_retorno' => $request->tiempo_retorno,
			 'utilidad_3_anios' => $request->utilidad_3_anios,
			 'utilidad_3_anios_min' => $request->utilidad_3_anios_percent,
			 'servicio_por_ap' => $request->serv_ap,
			 'created_at' => \Carbon\Carbon::now()
			]
		]);

		$update_cotizador = new Cotizador();
		$update_cotizador->set_objetivos_cotizador($new_documentp->id, $request->objetivos_cotizador);
		$update_cotizador->set_status_cotizador($new_documentp->id);

		DB::commit();

		$name_project = "";

		if($new_documentp->nombre_proyecto == null || $new_documentp->nombre_proyecto == ''){
		  $sql = DB::table('hotels')->select('id','Nombre_hotel')->where('id', $new_documentp->anexo_id)->get();
		  $name_project = $sql[0]->Nombre_hotel;
		}else{
		  $name_project = $new_documentp->nombre_proyecto;
		}

		$parametros1 = [
		  'fecha' => $new_documentp->created_at,
		  'folio' => $folio_new,
		  'doc_type' => $new_documentp->doc_type,
		  'nombre_proyecto' => $name_project,
		  'itc' => $itc_name,
		  'total_ea' => $total_ea,
		  'total_ena' => $total_ena,
		  'total_mo' => $total_mo,
		  'total_viaticos' => $request->total_viaticos,
		  'total' => $total
		];

		//Mail::to('rdelgado@sitwifi.com')->cc('aarciga@sitwifi.com')->send(new SolicitudCompra($parametros1));
		//Mail::to('rkuman@sitwifi.com')->send(new SolicitudCompra($parametros1));

		$flag = "true";

	} catch(\Exception $e){
		$error = $e->getMessage();
		  DB::rollback();
		dd($error);
	}

  }

}
