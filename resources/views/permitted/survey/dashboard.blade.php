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


        <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-warning"><i class="mdi mdi-cellphone-link"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht">$2376</h3>
                                        <h5 class="text-muted m-b-0">Online Revenue</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>


      </div>
    </div>

    <div class="col-md-2">
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

    .widget-style-2 {
    padding-left: 30px;
}

.widget-panel {
    padding: 40px 20px;
    border-radius: 4px;
    color: #ffffff;
    position: relative;
    margin-bottom: 20px;
}
.bg-pink {
    background-color: #f24f7c !important;
}
.widget-style-2 i {
    font-size: 60px;
    float: right;
    padding: 25px 30px;
    margin-top: -40px;
    margin-right: -20px;
    color: #edf0f0;
    background: rgba(255, 255, 255, 0.2);
}
  </style>
  {{-- @if( auth()->user()->can('View cover') ) --}}
  {{-- @else --}}
  {{-- @endif  --}}
@endpush
