@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View noc') )
    <strong>Dashboard de operaciones</strong>
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View noc') )

  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View noc') )
    NOC
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
            <div class="card-body">
              <div class="text-center">
                <h2>Dashboard de operaciones</h2>
                <br>

                <div class="row">

                  <div class="col-md-7">

                    <h4 style="text-align: left;">Reporte Mensual</h4>
                    <p style="font-size: 16px;">Respondieron encuesta<strong id="respondieron" style="margin-left: 10px;"></strong><span style="margin-left: 10px;">NPS</span><strong id="nps" style="margin-left: 10px;"></strong></p>

                    <table id="encuestas_results" class="table-responsive" style="text-align: center;">
                      <tr style="color: brown;">
                        <td></td>
                        <td class="mes1"></td>
                        <td class="mes2"></td>
                        <td></td>
                        <td class="ignore">% Respuestas</td>
                      </tr>
                      <tr>
                        <td style="color: green;">Promotores</td>
                        <td id="pro1"></td>
                        <td id="pro2"></td>
                        <td id="pro-icon"></td>
                        <td id="pro-res" class="ignore"></td>
                      </tr>
                      <tr>
                        <td style="color: orange;">Pasivos</td>
                        <td id="pas1"></td>
                        <td id="pas2"></td>
                        <td id="pas-icon"></td>
                        <td id="pas-res" class="ignore"></td>
                      </tr>
                      <tr>
                        <td style="color: red;">Detractores</td>
                        <td id="det1"></td>
                        <td id="det2"></td>
                        <td id="det-icon"></td>
                        <td id="det-res" class="ignore"></td>
                      </tr>
                    </table>

                  </div>

                  <div class="col-md-5">
                    <div style="text-align: left;">
                      <h4 style="display: inline-block;">Mes</h4>
                        <input id="mes" type="text" style="text-align: center; background-color: lightyellow; font-weight: bold; font-size: 18px; width: 50%;">
                      <p style="font-size: 16px; text-align: center;">Sitios Evaluados</p>
                    </div>
                    <table id="sitios_results" class="table-responsive" style="text-align: center;">
                      <tr style="color: brown;">
                        <td></td>
                        <td class="mes1"></td>
                        <td class="mes2"></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="color: green;">Total</td>
                        <td id="total1"></td>
                        <td id="total2"></td>
                        <td id="total-porcentaje"></td>
                        <td id="total-icon"></td>
                      </tr>
                      <tr>
                        <td style="color: orange;">Respondieron</td>
                        <td id="res1"></td>
                        <td id="res2"></td>
                        <td id="res-porcentaje"></td>
                        <td id="res-icon"></td>
                      </tr>
                      <tr>
                        <td style="color: red;">Sin respuesta</td>
                        <td id="sinres1"></td>
                        <td id="sinres2"></td>
                        <td id="sinres-porcentaje"></td>
                        <td id="sinres-icon"></td>
                      </tr>
                    </table>

                  </div>

                </div>

                <div class="row">

                  <div class="col-md-5">

                      <!--<div id="graph_nps"> </div>-->
                      <div id="fuel-gauge" style="margin: 20px auto;"></div>

                  </div>

                  <div class="col-md-7 mt-4">

                    <h4 style="text-align: left;">Detractores</h4>

                    <table id="detractores" class="table-responsive" style="text-align: center;">
                      <tr id="seek0" style="color: brown;">
                        <td class="mes1"></td>
                        <td>Status actual</td>
                        <td class="mes2"></td>
                      </tr>
                    </table>

                  </div>

                </div>

                <div class="row py-4">

                  <div class="col-md-7">

                    <h4 style="text-align: left;">Tickets</h4>

                    <table id="tiempos" class="table-responsive" style="text-align: center;">
                      <tbody style=" width: 100% !important;">
                      <tr style="color: blue;">
                        <td colspan="6">Tiempo Primer Respuesta</td>
                      </tr>
                      <tr style="color: brown;">
                        <td>Tiempo</td>
                        <td>Objetivo</td>
                        <td class="mes1"></td>
                        <td class="mes2"></td>
                        <td>%</td>
                        <td class="ignore">Objetivo</td>
                      </tr>
                      <tr>
                        <td>&#60;30</td>
                        <td>95%</td>
                        <td id="30_1"></td>
                        <td id="30_2"></td>
                        <td id="30_porc"></td>
                        <td id="30_color" class="ignore"></td>
                      </tr>
                      <tr>
                        <td>30&#60;240</td>
                        <td>3%</td>
                        <td id="30_240_1"></td>
                        <td id="30_240_2"></td>
                        <td id="30_240_porc"></td>
                        <td id="30_240_color" class="ignore"></td>
                      </tr>
                      <tr>
                        <td>&#62;240</td>
                        <td>2%</td>
                        <td id="240_1"></td>
                        <td id="240_2"></td>
                        <td id="240_porc"></td>
                        <td id="240_color" class="ignore"></td>
                      </tr>
                      <tr style="color: blue;">
                        <td colspan="6">Tiempo de solución</td>
                      </tr>
                      <tr style="color: brown;">
                        <td>Tiempo</td>
                        <td>Objetivo</td>
                        <td class="mes1"></td>
                        <td class="mes2"></td>
                        <td>%</td>
                        <td class="ignore">Objetivo</td>
                      </tr>
                      <tr>
                        <td>&#60; 2 hrs</td>
                        <td>90%</td>
                        <td id="2hrs_1"></td>
                        <td id="2hrs_2"></td>
                        <td id="2hrs_porc"></td>
                        <td id="2hrs_color" class="ignore"></td>
                      </tr>
                      <tr>
                        <td>&#60; 2 días</td>
                        <td>5%</td>
                        <td id="2dias_1"></td>
                        <td id="2dias_2"></td>
                        <td id="2dias_porc"></td>
                        <td id="2dias_color" class="ignore"></td>
                      </tr>
                      <tr>
                        <td>&#62; 2 días</td>
                        <td>5%</td>
                        <td id="M2dias_1"></td>
                        <td id="M2dias_2"></td>
                        <td id="M2dias_porc"></td>
                        <td id="M2dias_color" class="ignore"></td>
                      </tr>
                    </tbody>
                    </table>

                  </div>

                  <div class="col-md-5">

                    <div class="">
                      <div id="graph_tickets"> </div>
                    </div>

                  </div>

                </div>

                <div class="row">
                  <div class="col-md-12">
                    <h4 style="text-align: left;">Disponibilidad</h4>
                    <table id="disponibilidad" class="table-responsive" style="text-align: center;">
                      <tr style="color: brown;">
                        <td>Vertical</td>
                        <td>Sitio</td>
                        <td>Carrier</td>
                        <td># Sitios</td>
                        <td>SLA Contrato</td>
                        <td class="mes1"></td>
                        <td class="mes2"></td>
                        <td>SLA Sitwfi</td>
                        <td>%</td>
                        <td>SLA Promedio</td>
                      </tr>
                      <tr>
                        <td rowspan="5" style="border-right: 1px solid blue;">Transporte terrestre</td>
                        <td rowspan="2">ADO</td>
                        <td>TELMEX</td>
                        <td id="ado_telmex_sitios"></td>
                        <td>98%</td>
                        <td id="ado_telmex_disp1"></td>
                        <td id="ado_telmex_disp2"></td>
                        <td id="ado_telmex_ball"></td>
                        <td id="ado_telmex_arrow"></td>
                        <td id="sla_prom_1" rowspan="5" style="border-left: 1px solid blue;"></td>
                      </tr>
                      <tr>
                        <td>TOTALPLAY</td>
                        <td id="ado_totalplay_sitios"></td>
                        <td>98%</td>
                        <td id="ado_totalplay_disp1"></td>
                        <td id="ado_totalplay_disp2"></td>
                        <td id="ado_totalplay_ball"></td>
                        <td id="ado_totalplay_arrow"></td>
                      </tr>
                      <tr>
                        <td rowspan="2">METROBUS</td>
                        <td>BBS</td>
                        <td id="metrobus_bbs_sitios"></td>
                        <td>98%</td>
                        <td id="metrobus_bbs_disp1"></td>
                        <td id="metrobus_bbs_disp2"></td>
                        <td id="metrobus_bbs_ball"></td>
                        <td id="metrobus_bbs_arrow"></td>
                      </tr>
                      <tr>
                        <td>TOTALPLAY</td>
                        <td id="metrobus_totalplay_sitios"></td>
                        <td>98%</td>
                        <td id="metrobus_totalplay_disp1"></td>
                        <td id="metrobus_totalplay_disp2"></td>
                        <td id="metrobus_totalplay_ball"></td>
                        <td id="metrobus_totalplay_arrow"></td>
                      </tr>
                      <tr>
                        <td>METRORREY</td>
                        <td>TOTALPLAY</td>
                        <td id="metrorrey_totalplay_sitios"></td>
                        <td>98%</td>
                        <td id="metrorrey_totalplay_disp1"></td>
                        <td id="metrorrey_totalplay_disp2"></td>
                        <td id="metrorrey_totalplay_ball"></td>
                        <td id="metrorrey_totalplay_arrow"></td>
                      </tr>
                      <tr>
                        <td rowspan="5" style="border-right: 1px solid blue;">Aeropuerto</td>
                        <td rowspan="2">OMA</td>
                        <td>ALESTRA</td>
                        <td id="oma_alestra_sitios"></td>
                        <td>98%</td>
                        <td id="oma_alestra_disp1"></td>
                        <td id="oma_alestra_disp2"></td>
                        <td id="oma_alestra_ball"></td>
                        <td id="oma_alestra_arrow"></td>
                        <td id="sla_prom_2" rowspan="5" style="border-left: 1px solid blue;"></td>
                      </tr>
                      <tr>
                        <td>TELMEX</td>
                        <td id="oma_telmex_sitios"></td>
                        <td>98%</td>
                        <td id="oma_telmex_disp1"></td>
                        <td id="oma_telmex_disp2"></td>
                        <td id="oma_telmex_ball"></td>
                        <td id="oma_telmex_arrow"></td>
                      </tr>
                      <tr>
                        <td rowspan="3">ASUR</td>
                        <td>ALESTRA</td>
                        <td id="asur_alestra_sitios"></td>
                        <td>98%</td>
                        <td id="asur_alestra_disp1"></td>
                        <td id="asur_alestra_disp2"></td>
                        <td id="asur_alestra_ball"></td>
                        <td id="asur_alestra_arrow"></td>
                      </tr>
                      <tr>
                        <td>OTROS</td>
                        <td id="asur_otros_sitios"></td>
                        <td>98%</td>
                        <td id="asur_otros_disp1"></td>
                        <td id="asur_otros_disp2"></td>
                        <td id="asur_otros_ball"></td>
                        <td id="asur_otros_arrow"></td>
                      </tr>
                      <tr>
                        <td>TELMEX</td>
                        <td id="asur_telmex_sitios"></td>
                        <td>98%</td>
                        <td id="asur_telmex_disp1"></td>
                        <td id="asur_telmex_disp2"></td>
                        <td id="asur_telmex_ball"></td>
                        <td id="asur_telmex_arrow"></td>
                      </tr>
                      <tr>
                        <td rowspan="3" colspan="2">GALERÍAS</td>
                        <td>ALESTRA</td>
                        <td id="galerias_alestra_sitios"></td>
                        <td>98%</td>
                        <td id="galerias_alestra_disp1"></td>
                        <td id="galerias_alestra_disp2"></td>
                        <td id="galerias_alestra_ball"></td>
                        <td id="galerias_alestra_arrow"></td>
                        <td id="sla_prom_3" rowspan="3" style="border-left: 1px solid blue;"></td>
                      </tr>
                      <tr>
                        <td>TELMEX</td>
                        <td id="galerias_telmex_sitios"></td>
                        <td>98%</td>
                        <td id="galerias_telmex_disp1"></td>
                        <td id="galerias_telmex_disp2"></td>
                        <td id="galerias_telmex_ball"></td>
                        <td id="galerias_telmex_arrow"></td>
                      </tr>
                      <tr>
                        <td>TOTALPLAY</td>
                        <td id="galerias_totalplay_sitios"></td>
                        <td>98%</td>
                        <td id="galerias_totalplay_disp1"></td>
                        <td id="galerias_totalplay_disp2"></td>
                        <td id="galerias_totalplay_ball"></td>
                        <td id="galerias_totalplay_arrow"></td>
                      </tr>
                      <tr>
                        <td rowspan="4" colspan="2">HOSPITALIDAD</td>
                        <td>TELMEX</td>
                        <td id="hosp_telmex_sitios"></td>
                        <td>98%</td>
                        <td id="hosp_telmex_disp1"></td>
                        <td id="hosp_telmex_disp2"></td>
                        <td id="hosp_telmex_ball"></td>
                        <td id="hosp_telmex_arrow"></td>
                        <td id="sla_prom_4" rowspan="4" style="border-left: 1px solid blue;"></td>
                      </tr>
                      <tr>
                        <td>TOTALPLAY</td>
                        <td id="hosp_totalplay_sitios"></td>
                        <td>98%</td>
                        <td id="hosp_totalplay_disp1"></td>
                        <td id="hosp_totalplay_disp2"></td>
                        <td id="hosp_totalplay_ball"></td>
                        <td id="hosp_totalplay_arrow"></td>
                      </tr>
                      <tr>
                        <td>OTROS</td>
                        <td id="hosp_otros_sitios"></td>
                        <td>98%</td>
                        <td id="hosp_otros_disp1"></td>
                        <td id="hosp_otros_disp2"></td>
                        <td id="hosp_otros_ball"></td>
                        <td id="hosp_otros_arrow"></td>
                      </tr>
                      <tr>
                        <td>IZZI</td>
                        <td id="hosp_izzi_sitios"></td>
                        <td>98%</td>
                        <td id="hosp_izzi_disp1"></td>
                        <td id="hosp_izzi_disp2"></td>
                        <td id="hosp_izzi_ball"></td>
                        <td id="hosp_izzi_arrow"></td>
                      </tr>
                      <tr>
                        <td colspan="2">RETAIL</td>
                        <td>TELMEX</td>
                        <td id="retail_telmex_sitios"></td>
                        <td>98%</td>
                        <td id="retail_telmex_disp1"></td>
                        <td id="retail_telmex_disp2"></td>
                        <td id="retail_telmex_ball"></td>
                        <td id="retail_telmex_arrow"></td>
                        <td id="sla_prom_5" style="border-left: 1px solid blue;"></td>
                      </tr>
                      <tr>
                        <td rowspan="2" colspan="2">EDUCACIÓN</td>
                        <td>ALESTRA</td>
                        <td id="educacion_alestra_sitios"></td>
                        <td>98%</td>
                        <td id="educacion_alestra_disp1"></td>
                        <td id="educacion_alestra_disp2"></td>
                        <td id="educacion_alestra_ball"></td>
                        <td id="educacion_alestra_arrow"></td>
                        <td id="sla_prom_6" rowspan="2" style="border-left: 1px solid blue;"></td>
                      </tr>
                      <tr>
                        <td>TELMEX</td>
                        <td id="educacion_telmex_sitios"></td>
                        <td>98%</td>
                        <td id="educacion_telmex_disp1"></td>
                        <td id="educacion_telmex_disp2"></td>
                        <td id="educacion_telmex_ball"></td>
                        <td id="educacion_telmex_arrow"></td>
                      </tr>
                    </table>
                  </div>
                </div>

                <h4 style="text-align: left; margin-top: 15px;">Resumen enlaces</h4>
                <div class="row">
                  <div class="col-md-6">
                    <table id="resumen_sitwifi" class="table-responsive" style="text-align: center;">
                      <tr style="color: blue;">
                        <td colspan="3">Sitwifi</td>
                      </tr>
                      <tr style="color: brown;">
                        <td>Carrier</td>
                        <td>Cantidad</td>
                        <td>Disponibilidad</td>
                      </tr>
                      <tr>
                        <td>ALESTRA</td>
                        <td id="rs_alestra_cant"></td>
                        <td id="rs_alestra_disp"></td>
                      </tr>
                      <tr>
                        <td>BBS</td>
                        <td id="rs_bbs_cant"></td>
                        <td id="rs_bbs_disp"></td>
                      </tr>
                      <tr>
                        <td>OTROS</td>
                        <td id="rs_otros_cant"></td>
                        <td id="rs_otros_disp"></td>
                      </tr>
                      <tr>
                        <td>TELMEX</td>
                        <td id="rs_telmex_cant"></td>
                        <td id="rs_telmex_disp"></td>
                      </tr>
                      <tr>
                        <td>TOTALPLAY</td>
                        <td id="rs_totalplay_cant"></td>
                        <td id="rs_totalplay_disp"></td>
                      </tr>
                      <tr>
                        <td>Total general</td>
                        <td id="rs_total_cant"></td>
                        <td id="rs_total_disp"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <table id="resumen_cliente" class="table-responsive" style="text-align: center;">
                      <tr style="color: blue;">
                        <td colspan="3">Cliente</td>
                      </tr>
                      <tr style="color: brown;">
                        <td>Carrier</td>
                        <td>Cantidad</td>
                        <td>Disponibilidad</td>
                      </tr>
                      <tr>
                        <td>ALESTRA</td>
                        <td id="rc_alestra_cant"></td>
                        <td id="rc_alestra_disp"></td>
                      </tr>
                      <!--<tr>
                        <td>BBS</td>
                        <td id="rc_bbs_cant"></td>
                        <td id="rc_bbs_disp"></td>
                      </tr>-->
                      <tr>
                        <td>OTROS</td>
                        <td id="rc_otros_cant"></td>
                        <td id="rc_otros_disp"></td>
                      </tr>
                      <tr>
                        <td>TELMEX</td>
                        <td id="rc_telmex_cant"></td>
                        <td id="rc_telmex_disp"></td>
                      </tr>
                      <tr>
                        <td>IZZI</td>
                        <td id="rc_izzi_cant"></td>
                        <td id="rc_izzi_disp"></td>
                      </tr>
                      <tr>
                        <td>Total general</td>
                        <td id="rc_total_cant"></td>
                        <td id="rc_total_disp"></td>
                      </tr>
                    </table>
                  </div>
                </div>

                <div class="py-3">
                  <h4>Equipo activo Monitoreado</h4>
                  <br>
                  <div class="table-responsive">
                  <table id="table_EA" class="table table-striped table-bordered compact-tab table-hover">
                    <thead style="background-color:#3b3b3b !important;"class="text-center">
                      <tr >
                        <th >Equipo Activo.</th>
                        <th >Propietario</th>
                        <th >Hospitalidad</th>
                        <th >Educación</th>
                        <th >Aeropuertos y terminales</th>
                        <th >Transporte Terrestre</th>
                        <th >Corporativo</th>
                        <th >Retail</th>
                        <th >Galerías</th>
                        <th >Otros</th>
                      </tr>
                    </thead>
                    <tbody class="text-center"style="font-size: 11px;">
                      <tr style="color:#e6641a !important;">
                        <td rowspan="2">Antena</td>
                        <td>Cliente</td>
                        <td>2,307</td>
                        <td>79</td>
                        <td>553</td>
                        <td>0</td>
                        <td>0</td>
                        <td>46</td>
                        <td>281</td>
                        <td>3</td>
                      </tr>
                      <tr style="color:#23c1d6 !important;">
                        <td>Sitwifi</td>
                        <td>12,937</td>
                        <td>2,615</td>
                        <td>166</td>
                        <td>485</td>
                        <td>382</td>
                        <td>0</td>
                        <td>28</td>
                        <td>101</td>
                      </tr>
                      <tr style="color:#e6641a !important;">
                        <td rowspan="2">SW</td>
                        <td>Cliente</td>
                        <td>118</td>
                        <td>5</td>
                        <td>115</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>86</td>
                        <td>0</td>
                      </tr>
                      <tr style="color:#23c1d6 !important;">
                        <td>Sitwifi</td>
                        <td>828</td>
                        <td>333</td>
                        <td>24</td>
                        <td>81</td>
                        <td>10</td>
                        <td>0</td>
                        <td>4</td>
                        <td>47</td>
                      </tr>

                      <tr style="color:#e6641a !important;">
                        <td rowspan="2">SZ/ZD</td>
                        <td>Cliente</td>
                        <td>12</td>
                        <td>3</td>
                        <td>15</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>2</td>
                        <td>0</td>
                      </tr>
                      <tr style="color:#23c1d6 !important;">
                        <td>Sitwifi</td>
                        <td>69</td>
                        <td>76</td>
                        <td>0</td>
                        <td>3</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                      </tr>

                      <tr style="color:#e6641a !important;">
                        <td rowspan="2">Icomera/ZQ</td>
                        <td>Cliente</td>
                        <td>10</td>
                        <td>1</td>
                        <td>21</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>18</td>
                        <td>0</td>
                      </tr>
                      <tr style="color:#23c1d6 !important;">
                        <td>Sitwifi</td>
                        <td>35</td>
                        <td>68</td>
                        <td>1</td>
                        <td>196</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>0</td>
                      </tr>

                      <tr style="color:#e6641a !important;">
                        <td rowspan="2">Sonda</td>
                        <td>Cliente</td>
                        <td>6</td>
                        <td>3</td>
                        <td>20</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>23</td>
                        <td>0</td>
                      </tr>
                      <tr style="color:#23c1d6 !important;">
                        <td>Sitwifi</td>
                        <td>60</td>
                        <td>94</td>
                        <td>8</td>
                        <td>5</td>
                        <td>35</td>
                        <td>0</td>
                        <td>2</td>
                        <td>15</td>
                      </tr>

                      <tr style="color:#e6641a !important;">
                        <td rowspan="2">Sonic Wall</td>
                        <td>Cliente</td>
                        <td>0</td>
                        <td>3</td>
                        <td>33</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>25</td>
                        <td>0</td>
                      </tr>
                      <tr style="color:#23c1d6 !important;">
                        <td>Sitwifi</td>
                        <td>22</td>
                        <td>56</td>
                        <td>14</td>
                        <td>118</td>
                        <td>131</td>
                        <td>0</td>
                        <td>1</td>
                        <td>5</td>
                      </tr>

                    </tbody>
                  </table>
                  </div>
                  <br>
                  <h4>Total AP's instaladas</h4>
                  <table id="table_aps" class="table table-striped table-bordered compact-tab table-hover">
                    <thead class="text-center">
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="color:#3c3c3c !important;">
                        <td>Total</td>
                        <td>20,132</td>
                        <td>20,132</td>
                      </tr>
                      <tr style="color:#e6641a !important;">
                        <td>Cliente</td>
                        <td>3,323</td>
                        <td>3,323</td>
                      </tr>
                      <tr style="color:#23c1d6 !important;">
                        <td>Sitwifi</td>
                        <td>3,323</td>
                        <td>3,323</td>
                      </tr>
                    </tbody>

                  </table>

                  <br>
                  <div class="row">
                    <div class="col-md-6">

                      <h4>Equipos en garantía y bajas</h4>
                      <div class="table-responsive">
                      <table id="table_garantia" class="table table-striped table-bordered compact-tab table-hover w-100">
                        <thead style="background-color:#3b3b3b !important;" class="text-center">
                          <tr>
                            <th >Equipo</th>
                            <th >Acumulado enviados 2019</th>
                            <th >Acumulado garantia 2019</th>
                            <th colspan="2"> Acumulado Bajas</th>
                            <th > Promedio Mensual</th>
                            <th > %</th>
                            <th > Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr style="color:#168f9f !important;">
                            <td>Antena</td>
                            <td>180</td>
                            <td>180</td>
                            <td>15</td>
                            <td>15</td>
                            <td>10</td>
                            <td><span class="fas fa-arrow-right"></span></td>
                            <td align="center"> <div class="rounded-circle test"  ></div></td>
                          </tr>
                          <tr style="color:#168f9f !important;">
                            <td>Icomera Gateway</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td><span class="fas fa-arrow-right"></span></td>
                            <td align="center"> <div class="rounded-circle test"  ></div></td>
                          </tr>

                          <tr style="color:#168f9f !important;">
                            <td>Laptop</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td><span class="fas fa-arrow-right"></span></td>
                            <td align="center"> <div class="rounded-circle test"  ></div></td>
                          </tr>

                          <tr style="color:#168f9f !important;">
                            <td>Regulador</td>
                            <td>0</td>
                            <td>0</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td><span class="fas fa-arrow-right"></span></td>
                            <td align="center"> <div class="rounded-circle test"  ></div></td>
                          </tr>

                          <tr style="color:#168f9f !important;">
                            <td>Sonda</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td><span class="fas fa-arrow-right"></span></td>
                            <td align="center"> <div class="rounded-circle test"  ></div></td>
                          </tr>

                          <tr style="color:#168f9f !important;">
                            <td>Sonic Wall</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td><span class="fas fa-arrow-right"></span></td>
                            <td align="center"> <div class="rounded-circle test"  ></div></td>
                          </tr>

                          <tr style="color:#168f9f !important;">
                            <td>SW</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td><span class="fas fa-arrow-right"></span></td>
                            <td align="center"> <div class="rounded-circle test"  ></div></td>
                          </tr>

                          <tr style="color:#168f9f !important;">
                            <td>UPS</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td><span class="fas fa-arrow-right"></span></td>
                            <td align="center"> <div class="rounded-circle test"  ></div></td>
                          </tr>

                          <tr style="color:#168f9f !important;">
                            <td>Zequenze</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td><span class="fas fa-arrow-right"></span></td>
                            <td align="center"> <div class="rounded-circle test"  ></div></td>
                          </tr>

                        </tbody>

                      </table>
                    </div>
                    </div>
                    <div class="col-md-5">
                      <div id="graph_garantia"class=""></div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

    <link rel="stylesheet" href="{{ asset('bower_components/jquery.dynameter.css') }}">
    <script src="{{ asset('js/admin/noctools/jquery.dynameter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <script src="{{ asset('js/admin/noctools/dash_operaciones_1.js?v=1.0.4')}}"></script>
    <script src="{{ asset('js/admin/noctools/dash_operaciones_2.js')}}"></script>
    <style media="screen">
    .tableFixHead          { overflow-y: auto; height: 620px; }
    .tableFixHead thead th { position: sticky !important; top: 0; }
    .bg-aqua{
    background: #02948c;
    }

    #encuestas_results tbody,#sitios_results tbody,#detractores tbody,#tiempos tbody, #disponibilidad tbody, #resumen_sitwifi tbody, #resumen_cliente tbody {
      width: 100% !important;
      display: table;
    }
    #encuestas_results tr td:not(.ignore), #sitios_results tr td, #tiempos tr td:not(.ignore), #disponibilidad tr td, #resumen_sitwifi tr td, #resumen_cliente tr td {
      font-size: 16px;
      border-bottom: 1px solid blue;
    }
    .ignore {
      font-size: 16px;
    }
    #detractores tr td {
      border-bottom: 1px solid blue;
      /*font-size: 12px;*/
    }
    .green {
      height: 15px;
      width: 15px;
      background-color: green;
      border-radius: 50%;
      display: inline-block;
    }
    .red {
      height: 15px;
      width: 15px;
      background-color: red;
      border-radius: 50%;
      display: inline-block;
    }
    .test{
      width: 20px;
      height: 20px;
      background-color:orange;
    }
    </style>
@endpush
