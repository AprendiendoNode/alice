@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View assign report') )
    {{ trans('message.subtitle_customer_zend') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View assign report') )
    {{ trans('message.breadcrumb_customer_zend') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <!--Header------------------------------------------------------------------------->
              <div class="col-lg-3 col-md-3 col-sm-3">
                  <img class="logo-title mb-2" src="{{ asset('img/company/logo.svg') }}"/>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 text-center p-4">
                <h3 class="mb-4 ls-title"><strong> Reporte de atención al cliente</strong></h3>
                <strong class="ls-title font-italic">Información obtenida con el API zendesk</strong>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3">
                  <img class="logo-title mb-2" src="{{ asset('img/company/zendesk.svg') }}"/>
              </div>
            <!--End Header--------------------------------------------------------------------->
          </div>
          <div class="row">
            <!--Grafica 1------------------------------------------------------------------------->
            <div class="col-md-12 border-top border-bottom my-4">
              <h5 class="my-2 font-weight-bold text-center">{{ trans('customer.graph_t1') }}</h5>
            </div>
            <div class="col-md-12">
              <form class="form-inline">
                <div class="input-group mb-2 mr-sm-2">
                  <h5>Seleccione un rango de fechas.</h5>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="datepickerYear" name="datepickerYear">
                  <div class="input-group-prepend">
                    <span class="input-group-text">a</span>
                  </div>
                  <input type="text" class="form-control"id="datepickerYear3" name="datepickerYear3">
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button type="button" class="btn btn-outline-primary btn_graph1"> <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar</button>
                </div>
              </form>
              <div id="maingraphicTicketsR" class="mt-4" style="width: 100%; min-height: 300px;"></div>
            </div>
            <!--End Grafica 1--------------------------------------------------------------------->
          </div>
          <div class="row">
            <!--Grafica 2------------------------------------------------------------------------->
            <div class="col-md-12 border-top border-bottom my-4">
              <h5 class="my-2 font-weight-bold text-center">{{ trans('customer.graph_t2') }}</h5>
            </div>
            <div class="col-md-12">
              <form id="generate_graph2" name="generate_graph2" class="form-inline">
                <div class="input-group mb-2 mr-sm-2">
                  <h5>Periodo.</h5>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="datepickerMonth" name="datepickerMonth">
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button type="button" class="btn btn-outline-primary btn_graph2"> <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar</button>
                </div>
              </form>
              <div id="maingraphicTicketsAgent" class="mt-4" style="width: 100%; min-height: 300px;"></div>
            </div>
            <!--End Grafica 2--------------------------------------------------------------------->
          </div>
          <div class="row">
            <!--Grafica 3------------------------------------------------------------------------->
            <div class="col-md-12 border-top border-bottom my-4">
              <h5 class="my-2 font-weight-bold text-center">{{ trans('customer.graph_t3') }}</h5>
            </div>
            <div class="col-md-12">
              <form id="generate_graph3" name="generate_graph3" class="form-inline">
                {{ csrf_field() }}
                <div class="input-group mb-2 mr-sm-2">
                  <h5>Periodo.</h5>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="datepickerMonth2" name="datepickerMonth2">
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button type="button" class="btn btn-outline-primary btn_graph3"> <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar</button>
                </div>
              </form>
              <div id="maingraphicTicketsTiempos" class="mt-4" style="width: 100%; min-height: 300px;"></div>
              <div class="table-responsive">
                <table id="time_reps" name='time_reps' class="table">
                <thead>
                  <tr>
                    <th> <small>Mes</small> </th>
                    <th> <small>% Primera respuesta</small> </th>
                    <th> <small>% Tiempo de solución</small> </th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              </div>
            </div>
            <!--End Grafica 3--------------------------------------------------------------------->
          </div>
          <div class="row">
            <!--Grafica 4------------------------------------------------------------------------->
            <div class="col-md-12 border-top border-bottom my-4">
              <h5 class="my-2 font-weight-bold text-center">{{ trans('customer.graph_t4') }}</h5>
            </div>
            <div class="col-md-12">
              <form id="generate_graph4" name="generate_graph4" class="form-inline">
                <div class="input-group mb-2 mr-sm-2">
                  <h5>Periodo.</h5>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="datepickerYear2" name="datepickerYear2">
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button type="button" class="btn btn-outline-primary btn_graph4"> <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar</button>
                </div>
              </form>
              <div id="maingraphicTicketsTimeResp" class="mt-4" style="width: 100%; min-height: 400px;"></div>
            </div>
            <!--End Grafica 4--------------------------------------------------------------------->
          </div>
          <div class="row">
            <!--Grafica 5------------------------------------------------------------------------->
            <div class="col-md-12 border-top border-bottom my-4">
              <h5 class="my-2 font-weight-bold text-center">{{ trans('customer.graph_t5') }}</h5>
            </div>
            <div class="col-md-12">
              <form id="omega5" name="generate_graph5"  class="form-inline">
                {{ csrf_field() }}
                <div class="input-group mb-2 mr-sm-2">
                  <h5>Seleccione un rango de fechas</h5>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="datepickerWeek" name="datepickerWeek">
                  <div class="input-group-prepend">
                    <span class="input-group-text">a</span>
                  </div>
                  <input type="text" class="form-control"id="datepickerWeek2" name="datepickerWeek2">
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button type="button" class="btn btn-outline-primary btn_graph5"> <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar</button>
                </div>
              </form>
              <div id="maingraphicTicketsTimeRespWeek" class="mt-4" style="width: 100%; min-height: 300px;"></div>
            </div>
            <!--End Grafica 5--------------------------------------------------------------------->
          </div>
          <div class="row">
            <!--Grafica 6------------------------------------------------------------------------->
            <div class="col-md-12 border-top border-bottom my-4">
              <h5 class="my-2 font-weight-bold text-center">{{ trans('customer.graph_t6') }}</h5>
            </div>
            <div class="col-md-12">
              <form id="generate_graph6" name="generate_graph6" class="form-inline">
                {{ csrf_field() }}
                <div class="input-group mb-2 mr-sm-2">
                  <h5>Periodo.</h5>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="datepickerMonth3" name="datepickerMonth3">
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button type="button" class="btn btn-outline-primary btn_graph6"> <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar</button>
                </div>
              </form>
            </div>
            <div id="maingraphicTicketsTags" class="col-md-6 mt-4" style="width: 100%; min-height: 300px;"></div>
            <div id="maingraphicTicketsTags2" class="col-md-6 mt-4" style="width: 100%; min-height: 300px;"></div>
            <!--End Grafica 6--------------------------------------------------------------------->
          </div>
          <div class="row">
            <!--Grafica 7------------------------------------------------------------------------->
            <div class="col-md-12 border-top border-bottom my-4">
              <h5 class="my-2 font-weight-bold text-center">{{ trans('customer.graph_t7') }}</h5>
            </div>
            <div class="col-md-12">
              <form id="generate_graph7" name="generate_graph7" class="form-inline">
                {{ csrf_field() }}
                <div class="input-group mb-2 mr-sm-2">
                  <h5>Periodo.</h5>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="datepickerMonth4" name="datepickerMonth4">
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button type="button" class="btn btn-outline-primary btn_graph7"> <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar</button>
                </div>
              </form>
              <div id="maingraphicTicketsDominios" class="mt-4" style="width: 100%; min-height: 300px;"></div>
            </div>
            <!--End Grafica 7--------------------------------------------------------------------->
          </div>
          <div class="row">
            <!--Grafica 8------------------------------------------------------------------------->
            <div class="col-md-12 border-top border-bottom my-4">
              <h5 class="my-2 font-weight-bold text-center">{{ trans('customer.graph_t8') }}</h5>
            </div>
            <div class="col-md-12">
              <form id="omega5" name="generate_graph5"  class="form-inline">
                <div class="input-group mb-2 mr-sm-2">
                  <h5>Seleccione un rango de fechas</h5>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="datepickerWeek3" name="datepickerWeek3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">a</span>
                  </div>
                  <input type="text" class="form-control"id="datepickerWeek4" name="datepickerWeek4">
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button type="button" class="btn btn-outline-primary btn_graph8"> <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar</button>
                </div>
              </form>
            </div>
            <div id="maingraphicHorarioTickets" class="col-md-12 mt-4" style="width: 100%; min-height: 300px;"></div>
            <div id="maingraphicHorarioTickets2" class="col-md-12 mt-4" style="width: 100%; min-height: 300px;"></div>
            <!--End Grafica 8--------------------------------------------------------------------->
          </div>

          <div class="row">
            <!--Formularios------------------------------------------------------------------------->
            <div class="col-md-12 border-top border-bottom my-4">
              <h5 class="my-2 font-weight-bold text-center">{{ trans('customer.graph_t9') }}</h5>
            </div>
            <div id="divoption" class="col-md-12">
              <form class="form-inline">
                <div class="input-group mb-2 mr-sm-4 col-md-4">
                  <select class="form-control" id="select_three" name="select_three">
                    <option value="" selected>Elija una opción</option>
                    <option value="1">Gráfica por año</option>
                    <option value="2">Gráfica por mes</option>
                  </select>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button id="btnaplicar" name="btnaplicar" type="button" class="btn btn-outline-primary"> <i class="fas fa-eye" style="margin-right: 4px;"></i> Mostrar</button>
                </div>
              </form>
            </div>
            <div id="showornot1" class="col-md-12 oculto">
              <form id="omega9" class="form-inline">
                {{ csrf_field() }}
                <div class="input-group mb-2 mr-sm-4 col-md-4">
                  <select class="form-control" id="select_one" name="select_one" style="width: 100%;">
                    <option value="" selected>Elija una opción</option>
                    @foreach ($selectDominios as $dominios)
                      <option value="{{ $dominios->dominio }}"> {{ $dominios->dominio }} </option>
                    @endforeach
                  </select>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="datepickerYear4" name="datepickerYear4">
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button id="boton-aplica-filtro9" name="boton-aplica-filtro9" type="button" class="btn btn-outline-primary">
                     <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar
                  </button>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button id="btnacerrar1" name="btnacerrar1" type="button" class="btn btn-outline-danger">
                     <i class="fas fa-eye-slash" style="margin-right: 4px;"></i>  Cambiar Gráfica.
                  </button>
                </div>
              </form>
            </div>
            <div id="showornot2" class="col-md-12 oculto">
              <form id="omega10" class="form-inline">
                {{ csrf_field() }}
                <div class="input-group mb-2 mr-sm-4 col-md-4">
                  <select class="form-control" id="select_two" name="select_two" style="width: 100%;">
                    <option value="" selected>Elija una opción</option>
                    @foreach ($selectDominios as $dominios)
                      <option value="{{ $dominios->dominio }}"> {{ $dominios->dominio }} </option>
                    @endforeach
                  </select>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control" id="datepickerMonth5" name="datepickerMonth5">
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button id="boton-aplica-filtro10" name="boton-aplica-filtro10" type="button" class="btn btn-outline-primary">
                     <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar
                  </button>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <button id="btnacerrar2" name="btnacerrar2" type="button" class="btn btn-outline-danger">
                     <i class="fas fa-eye-slash" style="margin-right: 4px;"></i>  Cambiar Gráfica.
                  </button>
                </div>
              </form>
            </div>
            <!--End Formularios--------------------------------------------------------------------->
          <!--Grafica 9------------------------------------------------------------------------->
        </div>
        <div class="row oculto" id="graphicDominioTagMes">
          <div id="maingraphicDominioTagMes" class="col-md-6" style="height:300px; width: 50%; margin-right:0;padding-right:0;border-right-width:0;"></div>
          <div id="maingraphicDominioTagMes2" class="col-md-6" style="height:300px; width: 50%; margin-right:0;padding-right:0;border-right-width:0;"></div>
        </div>
        <div class="row oculto" id="graphicDominioTagAnio">
          <div id="maingraphicDominioTagAnio" class="col-md-6" style="height:300px; width: 50%; margin-right:0;padding-right:0;border-right-width:0;"></div>
          <div id="maingraphicDominioTagAnio2" class="col-md-6" style="height:300px; width: 50%; margin-right:0;padding-right:0;border-right-width:0;"></div>
        </div>
          <!--End Grafica 9--------------------------------------------------------------------->

            <!-------------------------------------------------------------------------->
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <style media="screen">
    .logo-title {
      width: 300px;
      height: 100px;
      float: right;
    }
    .ls-title{
      letter-spacing : 2pt;
    }
    .select2-selection__rendered {
      line-height: 44px !important;
      padding-left: 20px !important;
    }
    .select2-selection {
      height: 42px !important;
    }
    .select2-selection__arrow {
      height: 36px !important;
    }
    .div_hidden {
      display:none !important;
    }
  </style>
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
  <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/admin/zendesk/graph.js')}}" charset="utf-8"></script>
  <script src="{{ asset('js/admin/zendesk/dashboard3_dyn.js')}}"></script>
  <script src="{{ asset('js/admin/zendesk/tags_dominio.js')}}"></script>
@endpush
