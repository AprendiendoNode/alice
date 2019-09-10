<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class DocumentpDashboardController extends Controller
{
    public function index()
    {
      $status_projects = DB::select('CALL px_tipo_servicio_acumulado_ejecucion()', array());
      $status_projects_instalado = DB::select('CALL px_tipo_servicio_acumulado_instalado()', array());
      $status_compras = DB::select('CALL px_documentp_status_doctype()', array());
      //dd($status_projects_instalado);
      return view('permitted.documentp.dashboard_project', compact('status_projects', 'status_compras', 'status_projects_instalado'));
    }

    public function get_count_all_doctype()
    {
      $result = DB::select('CALL get_num_doctype_all()', array());

      return $result;
    }

    public function get_status_project()
    {
      $result = DB::select('CALL px_tipo_servicio_acumulado()', array());

      return $result;
    }

    public function get_delay_projects()
    {
      $result = DB::select('CALL px_documentp_atrasoXservicio()', array());

      return $result;
    }

    public function get_delay_motives()
    {
      $result = DB::select('CALL px_documentp_atrasoXmotivo()', array());

      return $result;
    }

    public function get_rentas_perdidas()
    {
      $result = DB::select('CALL px_documentp_servicioXrentaperdida()', array());

      return $result;
    }

    public function get_presupuesto_ejercido_prom()
    {
      $result = DB::select('CALL px_documentp_servicioXpresup_prom()', array());

      return $result;
    }

    public function get_table_atraso_filterby_servicio($tipo_servicio, $atraso)
    {
      $result = DB::select('CALL px_documentp_atraso_filtroXservicio(?, ?)', array($tipo_servicio, $atraso));

      return $result;
    }

    public function get_table_atraso_filterby_motivo($id)
    {
      $result = DB::select('CALL px_documentp_atraso_filtroXmotivo(?)', array($id));

      return $result;
    }

}
