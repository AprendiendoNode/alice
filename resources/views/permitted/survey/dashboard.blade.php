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
                  <select class="form-control" id="survey_main" id="survey_main">
                    <option value="" selected>Elija...</option>
                    @foreach ($encuestas as $encuesta)
                      @if ($encuesta->id === 1)
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
                    <input type="text"  datas="filter_date_from" id="date_to_search" name="date_to_search" class="form-control" placeholder="" value="" required>
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

  <div class="row">
    <div class="col-md-2">
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="card" id="box_total_survey">
            <div class="card-body">
              <div class="ml-sm-3 ml-md-0 ml-xl-0 mt-2 mt-sm-0 mt-md-2 mt-xl-0 text-center">
                <h4 class="mb-2 text-primary font-weight-bold">194</h4>
								<h8 class="mb-0">Total de encuestas</h8>
							</div>
            </div>
          </div>
        </div>
        <div class="col-md-12 mb-3">
          <div class="card" id="box_response" >
            <div class="card-body">
              <div class="ml-sm-3 ml-md-0 ml-xl-0 mt-2 mt-sm-0 mt-md-2 mt-xl-0 text-center">
                <h4 class="mb-2 text-success font-weight-bold">110</h4>
								<h8 class="mb-0">Respondieron</h8>
							</div>
            </div>
          </div>
        </div>
        <div class="col-md-12 mb-3">
          <div class="card" id="box_sin_response">
            <div class="card-body">
              <div class="ml-sm-3 ml-md-0 ml-xl-0 mt-2 mt-sm-0 mt-md-2 mt-xl-0 text-center">
                <h4 class="mb-2 text-danger font-weight-bold">84</h4>
								<h8 class="mb-0">Sin respuesta</h8>
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
                <i class="mdi  mdi-emoticon icon-lg mr-3 text-success"></i>
                <div class="d-flex flex-column justify-content-around">
                  <small class="mb-1 text-muted font-weight-bold">Promotores</small>
                  <h8 class="mr-2 mb-0">0</h8>
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
                  <h8 class="mr-2 mb-0">0</h8>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-xl-flex  align-items-center justify-content-center p-0 item">
                <i class="mdi mdi-emoticon-sad icon-lg mr-3 text-danger"></i>
                <div class="d-flex flex-column justify-content-around">
                  <small class="mb-1 text-muted font-weight-bold">Detractores</small>
                  <h8 class="mr-2 mb-0">0</h8>
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
            <H8 style="background-color:#f7f7f7; text-align: center; padding: 7px 10px; margin-top: 0;">Comparación Anual</H8>
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
								<h8 class="mb-0">Sitios evaluados</h8>
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
  {{-- @else --}}
  {{-- @endif --}}
@endsection

@push('scripts')
  <style media="screen">
    h8 {
      font-size: 12px;
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
