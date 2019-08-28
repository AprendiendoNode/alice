@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  Dashboard encuestas
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  Dashboard encuestas
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('content')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <form id="search_info" name="search_info" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="survey_main">Seleccionar encuesta:</label>
                  <select class="form-control form-control-sm" id="survey_main" id="survey_main">
                    <option value="" selected>Elija...</option>
                    @foreach ($encuestas as $encuesta)
                      @if ($encuesta->id === 2)
                          <option value="{{$encuesta->id}}" selected>{{$encuesta->name}}</option>
                      @else
                          <option value="{{$encuesta->id}}">{{$encuesta->name}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3 col-xs-12">
                <div class="form-group" id="date_from">
                  <label class="control-label" for="date_to_search">
                    {{ __('general.date_from') }}
                  </label>
                  <div class="input-group mb-3">
                    <input type="text"  datas="filter_date_from" id="date_to_search" name="date_to_search" class="form-control form-control-sm" placeholder="" value="" required>
                    <div class="input-group-append">
                      <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-3 col-xs-12 pt-4">
                <button id="boton-aplica-filtro" name="boton-aplica-filtro" type="submit"
                        class="btn btn-xs btn-info filtrarDashboard"
                        style="margin-top: 4px">
                    <i class="fa fa-filter"> Filtrar</i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <section id="nps_survey" class="d-none">
    <div class="row">
      <div class="col-md-2">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card" id="box_total_survey">
              <div class="card-body">
                <div class="ml-sm-3 ml-md-0 ml-xl-0 mt-2 mt-sm-0 mt-md-2 mt-xl-0 text-center">
                  <h4 class="mb-2 text-primary font-weight-bold">194</h4>
  								<h6 class="mb-0">Total de encuestas</h6>
  							</div>
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="card" id="box_response" >
              <div class="card-body">
                <div class="ml-sm-3 ml-md-0 ml-xl-0 mt-2 mt-sm-0 mt-md-2 mt-xl-0 text-center">
                  <h4 class="mb-2 text-success font-weight-bold">110</h4>
  								<h6 class="mb-0">Respondieron</h6>
  							</div>
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="card" id="box_sin_response">
              <div class="card-body">
                <div class="ml-sm-3 ml-md-0 ml-xl-0 mt-2 mt-sm-0 mt-md-2 mt-xl-0 text-center">
                  <h4 class="mb-2 text-danger font-weight-bold">84</h4>
  								<h6 class="mb-0">Sin respuesta</h6>
  							</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">NPS chart</h4>
            <canvas id="lineChart" width="437" height="218" class="chartjs-render-monitor" style="display: block; width: 437px; height: 218px;"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-2">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="d-xl-flex  align-items-center justify-content-center p-0 item">
                  <i class="mdi mdi-emoticon icon-lg mr-3 text-success"></i>
                  <div class="d-flex flex-column justify-content-around">
                    <small class="mb-1 text-muted font-weight-bold">Promotores</small>
                    <h6 class="mr-2 mb-0">0</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="d-xl-flex  align-items-center justify-content-center p-0 item">
                  <i class="mdi mdi-emoticon-neutral icon-lg mr-3 text-warning"></i>
                  <div class="d-flex flex-column justify-content-around">
                    <small class="mb-1 text-muted font-weight-bold">Pasivos</small>
                    <h6 class="mr-2 mb-0">0</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="d-xl-flex align-items-center justify-content-center p-0 item">
                  <i class="mdi mdi-emoticon-sad icon-lg mr-3 text-danger"></i>
                  <div class="d-flex flex-column justify-content-around">
                    <small class="mb-1 text-muted font-weight-bold">Detractores</small>
                    <h6 class="mr-2 mb-0">0</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-2">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <h6 style="background-color:#f7f7f7; text-align: center; padding: 7px 10px; margin-top: 0;">Comparación Anual</h6>
              <div class="card-body padding-none">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>
                          Año
                        </th>
                        <th>
                          NPS
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                         2019
                        </td>
                        <td>
                          83
                        </tr>
                        <tr>

                          <td>
                          2018
                          </td>
                          <td>
                          63
                          </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-12 mb-3">
            <div class="card" id="box_sin_response">
              <div class="card-body">
                <div class="ml-sm-3 ml-md-0 ml-xl-0 mt-2 mt-sm-0 mt-md-2 mt-xl-0 text-center">
                  <h4 class="mb-2 text-primary font-weight-bold">84</h4>
  								<h6 class="mb-0">Sitios evaluados</h6>
  							</div>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-12 mb-3">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Encuesta semanal</h4>
            <div id="sparkline-composite-chart" class="sparkline-demo-chart">
              <canvas width="955" height="200" style="display: inline-block; width: 955.75px; height: 200px; vertical-align: top;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6 grid-margin stretch-card mb-3">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Grafica NPS</h4>
            <div id="sparkline-pie-chart" class="sparkline-demo-chart"><canvas width="436" height="218" style="display: inline-block; width: 436.875px; height: 218.438px; vertical-align: top;"></canvas></div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 grid-margin stretch-card mb-3">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Grafica mensual</h4>
            <div id="sparkline-bullet-chart" class="sparkline-demo-chart"><canvas width="436" height="238" style="display: inline-block; width: 436.875px; height: 238px; vertical-align: top;"></canvas></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="dinamic_survey" class="d-none">
    <div class="row">
      <div class="col-md-12">
        <!-- Box Comment -->
        <div class="card">
          <div class="card-title">
            <div class="mt-3 ml-3">
              <img class="rounded-circle" src="images/questionnaire/128x128sitwifi.jpg" alt="User Image" style="width:75px;border:1px solid #ccc;"  >
              <span class="username"><a >Encuesta clima laboral.</a></span>
              <span class="description">Corresponde - Abril 2019</span>
            </div>

          </div>
          <!-- /.box-header -->
          <div class="card-body">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="clearfix" style="background: #ffffff;">
                    <div id="main_grap_nps_week" style="width: 100%; min-height: 300px; border:1px solid #ccc;padding:10px;"></div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="clearfix" style="background: #ffffff;">
                    <div id="main_grap_nps_week" style="width: 100%; min-height: 300px; padding:10px;">
                      <h4 class="text-justify" style="line-height:50px;">
                        De las <span class="n_all">0</span> encuestas que fueron
                        enviadas, <span class="n_ans">0</span> encuestados
                        contestaron la encuesta y <span class="n_dnot_ans">0</span>
                        encuestados decidieron no
                        contestarla.
                      </h4>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="media">
                        <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                          Pregunta - Abierta
                        </h4>
                        <div>
                          <table id="table_results_a_question" class="table table-striped table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Pregunta</th>
                                <th>Respuesta</th>
                                <!-- <th>Email</th> -->
                                <!-- <th>Fecha corresponde</th> -->
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                      </div>
                     </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="media">
                        <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                          Pregunta - Opción multiple
                        </h4>
                        <div>
                          <table id="table_results_b_question" class="table table-striped table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Pregunta </th>
                                <th>Opción A</th>
                                <th>Opción B</th>
                                <th>Opción C</th>
                                <th>Opción D</th>
                                <th>Opción E</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                      </div>
                     </div>
                  </div>
                </div>
              </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>
  </section>
  {{-- @else --}}
  {{-- @endif --}}
@endsection

@push('scripts')
  <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
  <script type="text/javascript" src="{{ asset('js/admin/surveys/dashboard_survey.js')}}"></script>
  <style media="screen">
    h6 {
      font-size: 14px;
    }
    .padding-none {
      padding-top: 0 !important;
      padding-right: 0 !important;
      padding-bottom: 0 !important;
      padding-left: 0 !important;
    }
  </style>
  {{-- @if( auth()->user()->can('View cover') ) --}}
  {{-- @else --}}
  {{-- @endif  --}}
@endpush
