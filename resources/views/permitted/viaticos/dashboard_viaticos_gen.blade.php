@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View dashboard travel general') )
    {{ trans('message.viaticos_dashboard_request') }} General
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View dashboard travel general') )
    {{ trans('message.breadcrumb_dashboard_request') }} General
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View dashboard travel general') )
      {{-- <div class="container"> --}}
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
              <form id="search_info" name="search_info" class="form-inline" method="post">
                {{ csrf_field() }}
                <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="far fa-calendar-alt fa-3x"></i>&nbsp;&nbsp;</span>
                    <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                  </div>
                </div>
                <div class="col-sm-6">
                  <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                    <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
            <!------------------------------------------------------------------------>
            <div class="row">
              <div class="col-md-3">
                <div class="row">
                  <div class="col-sm-12 col-xs-12">
                    <div class="card">
                      <div class="card-body text-center">
                        <h3 id="new_answers" class="text-primary">0</h3>
                        <b><span class="card-text">Solicitudes nuevas</span></b>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-12 col-xs-12">
                    <div class="card">
                      <div class="card-body text-center">
                        <h3 id="approved_response" class="text-success">0</h3>
                        <b><span class="card-text">Solicitudes aprobadas</span></b>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-12 col-xs-12">
                    <div class="card">
                      <div class="card-body text-center">
                        <h3 id="answer_pending" class="text-warning">0</h3>
                        <b><span class="card-text">Solicitudes pendientes</span></b>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
              </div>

              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-8">
                    <div class="clearfix" style="background: #ffffff;">
                      <div id="main_venue" style="width: 100%; min-height: 300px; border:1px solid #ccc;"></div>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-sm-12 col-xs-12">
                        <div class="card">
                          <div class="card-body text-center">
                            <h3 id="denied_response" class="text-alert">0</h3>
                            <b><span class="card-text">Solicitudes denegadas</span></b>
                          </div>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-12 col-xs-12">
                        <div class="card">
                          <div class="card-body text-center">
                            <h3 id="verified_answers" class="text-success">0</h3>
                            <b><span class="card-text">Solicitudes Verificadas</span></b>
                          </div>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-12 col-xs-12">
                        <div class="card">
                          <div class="card-body text-center">
                            <h3 id="paid_answers" class="text-warning">0</h3>
                            <b><span class="card-text">Solicitudes Pagadas</span></b>
                          </div>
                        </div>
                      </div>
                      <!-- /.col -->
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
              </div>

              <div class="col-md-12 py-3">
                <div class="table-responsive">
                  <table id="table_expense" class="table table-striped table-bordered table-hover">
                    <thead style="background: #ffffff;">
                      <tr>
                        <th>Tpte. aerea</th>
                        <th>Tpte. Terrestre</th>
                        <th>Hospedaje</th>
                        <th>Alimentación</th>
                        <th>Renta auto</th>
                        <th>Tpte. Menores</th>
                        <th>Gasolina</th>
                        <th>Otros</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="col-md-12 py-3">
                <div class="table-responsive">
                  <table id="table_solic" class="table table-striped table-bordered table-hover">
                    <thead style="background: #ffffff;">
                      <tr>
                        <th>Departamento</th>
                        <th>Solicitud nuevas</th>
                        <th>Solicitud aprobadas</th>
                        <th>Solicitud pendientes</th>
                        <th>Solicitud denegadas</th>
                        <th>Solicitud Verificadas</th>
                        <th>Solicitud Pagadas</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="col-md-12 py-3">
                <div class="table-responsive">
                  <table id="table_depart" class="table table-striped table-bordered table-hover">
                    <thead style="background: #ffffff;">
                      <tr>
                        <th>Departamento</th>
                        <th>Tpte. aerea</th>
                        <th>Tpte. Terrestre</th>
                        <th>Hospedaje</th>
                        <th>Alimentación</th>
                        <th>Renta auto</th>
                        <th>Tpte. Menores</th>
                        <th>Gasolina</th>
                        <th>Otros</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>



            </div>
            <!------------------------------------------------------------------------>
          </div>
        </div>
      {{-- </div> --}}
    @else
      <!--NO VER-->
    @endif
@endsection

@push('scripts')
    @if( auth()->user()->can('View dashboard travel general') )
      <link rel="stylesheet" type="text/css" href="{{ asset('css/pdf2.css')}}" >
      <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
      <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
      <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
      <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
      <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
      <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
      <style media="screen">
        .pt-10 {
          padding-top: 10px;
        }
        th { font-size: 11px !important; }
      </style>
      <script src="{{ asset('js/admin/viaticos/dash_viaticos_general.js')}}"></script>
    @else
      <!--NO VER-->
    @endif
@endpush
