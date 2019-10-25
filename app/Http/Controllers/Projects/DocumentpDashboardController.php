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
      $status_cotizador = DB::select('CALL px_cotizador_status()', array());
      
      return view('permitted.documentp.dashboard_project', compact('status_projects', 'status_compras', 'status_cotizador' ,'status_projects_instalado'));
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

    public function get_delay_projects_ejecucion()
    {
      $result = DB::select('CALL px_documentp_atrasoXservicio_ejecucion()', array());

      return $result;
    }

    public function get_delay_projects_instalado()
    {
      $result = DB::select('CALL px_documentp_atrasoXservicio_instalado()', array());

      return $result;
    }

    public function get_delay_motives_ejecucion()
    {
      $result = DB::select('CALL px_documentp_atrasoXmotivo_ejecucion()', array());

      return $result;
    }

    public function get_delay_motives_instalado()
    {
      $result = DB::select('CALL px_documentp_atrasoXmotivo_instalados()', array());

      return $result;
    }

    public function get_rentas_perdidas()
    {
      $result = DB::select('CALL px_documentp_servicioXrentaperdida_ejecucion()', array());

      return $result;
    }

    public function get_rentas_perdidas_instalado()
    {
      $result = DB::select('CALL px_documentp_servicioXrentaperdida_instalados()', array());

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

    public function get_table_atraso_filterby_servicio_instalado($tipo_servicio, $atraso)
    {
      $result = DB::select('CALL px_documentp_atraso_filtroXservicio_instalado(?, ?)', array($tipo_servicio, $atraso));

      return $result;
    }

    public function get_table_atraso_filterby_motivo($id)
    {
      $result = DB::select('CALL px_documentp_atraso_filtroXmotivo(?)', array($id));

      return $result;
    }

    public function get_table_atraso_filterby_motivo_instalado($id)
    {
      $result = DB::select('CALL px_documentp_atraso_filtroXmotivo_instalado(?)', array($id));

      return $result;
    }

}
