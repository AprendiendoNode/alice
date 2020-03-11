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

                  <div class="col-md-7">

                      <!--<div id="graph_nps"> </div>-->
                      <div id="fuel-gauge" style="margin: 20px auto;"></div>

                  </div>

                  <div class="col-md-5 mt-4">

                    <h4 style="text-align: left;">Detractores</h4>

                    <table id="detractores" class="table-responsive" style="text-align: center;">
                      <tr style="color: brown;">
                        <td class="mes1"></td>
                        <td>Status actual</td>
                        <td class="mes2"></td>
                      </tr>
                      <tr>
                        <td>Palace Grande</td>
                        <td>Sin calificación</td>
                        <td>California Playa maroma</td>
                      </tr>
                      <tr>
                        <td>Colegio La Florida</td>
                        <td style="color: green;">Promotor</td>
                        <td>Galerías Polanco</td>
                      </tr>
                      <tr>
                        <td>Iberostar Cancún</td>
                        <td style="color: green;">Promotor</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Galerias San Juan del Río</td>
                        <td>Sin calificación</td>
                        <td></td>
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
                        <td>52%</td>
                        <td>31%</td>
                        <td><i class="fas fa-arrow-circle-down"></i></td>
                        <td class="ignore"><span class="red"></span></td>
                      </tr>
                      <tr>
                        <td>30&#60;240</td>
                        <td>3%</td>
                        <td>23%</td>
                        <td>36%</td>
                        <td><i class="fas fa-arrow-circle-up"></i></td>
                        <td class="ignore"><span class="red"></span></td>
                      </tr>
                      <tr>
                        <td>&#62;240</td>
                        <td>2%</td>
                        <td>25%</td>
                        <td>33%</td>
                        <td><i class="fas fa-arrow-circle-up"></i></td>
                        <td class="ignore"><span class="red"></span></td>
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
                        <td>93%</td>
                        <td>86%</td>
                        <td><i class="fas fa-arrow-circle-down"></i></td>
                        <td class="ignore"><span class="red"></span></td>
                      </tr>
                      <tr>
                        <td>&#60; 2 días</td>
                        <td>5%</td>
                        <td>7%</td>
                        <td>3%</td>
                        <td><i class="fas fa-arrow-circle-down"></i></td>
                        <td class="ignore"><span class="green"></span></td>
                      </tr>
                      <tr>
                        <td>&#62; 2 días</td>
                        <td>5%</td>
                        <td>0%</td>
                        <td>0%</td>
                        <td><i class="fas fa-arrow-circle-up"></i></td>
                        <td class="ignore"><span class="green"></span></td>
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

                <div class="">
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
    <script src="{{ asset('js/admin/noctools/dash_operaciones_1.js')}}"></script>
    <script src="{{ asset('js/admin/noctools/dash_operaciones_2.js')}}"></script>
    <style media="screen">
    .tableFixHead          { overflow-y: auto; height: 620px; }
    .tableFixHead thead th { position: sticky !important; top: 0; }
    .bg-aqua{
    background: #02948c;
    }

    #encuestas_results tbody,#sitios_results tbody,#detractores tbody,#tiempos tbody {
      width: 100% !important;
      display: table;
    }

    #encuestas_results tr td:not(.ignore), #sitios_results tr td, #tiempos tr td:not(.ignore) {
      font-size: 16px;
      border-bottom: 1px solid blue;
    }
    .ignore {
      font-size: 16px;
    }
    #detractores tr td {
      border-bottom: 1px solid blue;
      font-size: 12px;
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
