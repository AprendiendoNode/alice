@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('Contract expiration') )
    Vencimiento de contratos
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('Contract expiration') )
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
@endsection

@section('content')
  <div id="modal-Edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;"> <!-- change -->
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaledit">Historial de anexos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="table-anex" style="fontsize: 8px;">
                <table id="all_anexos" class="display" style="width:100%">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>ID Contrato Anexo</th>
                      <th>F.Firma de contrato</th>
                      <th>F.Inicio de contrato (Programada)</th>
                      <th>F.Fin de contrato (Calculado)</th>
                      <th>F.inicio real</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  @if( auth()->user()->can('Contract expiration') )
    <div class="card mb-4">
      <div class="card-body">
        <!--<form id="search" name="search" class="forms-sample" enctype="multipart/form-data">--> <!-- change -->
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-3">
              <div class="form-group mb-3">
                  <label>Periodo</label>
                  <div class="input-daterange input-group">
                      <input type="text" class="input-sm form-control" id="start" name="start"
                          placeholder="Fecha Inicial" />
                      <!--<input type="text" class="input-sm form-control required" id="end" name="end"
                          placeholder="Fecha Final" />-->
                  </div>
              </div>
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-primary default mb-1 btnGenerar" style="margin-top: 1.8rem !important;">Generar</button>
            </div>
          </div>
        <!--</form>-->
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body dashboard-tabs2 ">
            <ul class="nav nav-tabs px-4 not_borde" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Contratos</a>
              </li>
              <!--<li class="nav-item">
                <a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Venues</a>
              </li>-->
            </ul>
            <div class="tab-content">
            <div class="row">
              <div class="col-md-1"></div>
                <div class="d-flex justify-content-center border-bottom w-100 col-sm-5 col-md-5">
                  <div  id="graph_vigentes" style="min-height: 300px;left: 0px;right: 0px;"> </div>
                </div>
                <div class="d-flex justify-content-center border-bottom w-100 col-sm-5 col-md-5">
                  <div  id="graph_vencidos" style="min-height: 300px;left: 0px;right: 0px;"> </div>
                </div>
                <div class="col-md-1"></div>
            </div>

              <div class="tab-pane fade active show" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                <div class="card">
                  <div class="card-body">
                    <div class="row py-2">
                      <div class="col-md-12 col-xs-12 text-center">
                        <h3 class="pb-2">Contratos vigentes</h3>
                        <div class="table-responsive" style="fontsize: 8px;">
                          <table id="all_notvenue" class="table compact-tab">
                            <thead style="background: rgb(25, 50, 87);">
                              <tr>
                                <th>Estado</th>
                                <th>Cliente</th>
                                <th>Vertical</th>
                                <th>Clasificacion</th>
                                <th>ID Contrato</th>
                                <!--<th>ID Contrato Maestro</th>-->
                                <th>ITC</th>
                                <th>Vencimiento</th>
                                <th>Meses restantes</th>
                                <!--<th>-</th>-->
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

              <div class="" id="overview_2" role="tabpanel" aria-labelledby="overview-tab">
                <div class="card">
                  <div class="card-body">
                    <div class="row py-2">
                      <div class="col-md-12 col-xs-12 text-center">
                        <h3 class="pb-2">Contratos vencidos</h3>
                        <div class="table-responsive" style="fontsize: 8px;">
                          <table id="all_notvenue_vencidos" class="table compact-tab">
                            <thead style="background: rgb(25, 50, 87);">
                              <tr>
                                <th>Estado</th>
                                <th>Cliente</th>
                                <th>Vertical</th>
                                <th>Clasificacion</th>
                                <th>ID Contrato</th>
                                <!--<th>ID Contrato Maestro</th>-->
                                <th>ITC</th>
                                <th>Vencimiento</th>
                                <th>Meses vencido</th>
                                <!--<th>-</th>-->
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

              <!--<div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">
                <div class="card">
                  <div class="card-body">
                    <div class="row py-2">
                      <div class="col-md-12 col-xs-12">
                        <div class="table-responsive" style="fontsize: 8px;">
                          <table id="all_venue" class="table">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>ID Contrato Anexo</th>
                                <th>Clasificacion</th>
                                <th>Vertical</th>
                                <th>Cadena</th>
                                <th>ID Contrato Maestro</th>
                                <th>ITC</th>
                                <th>Vencimiento</th>
                                <th>-</th>
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
              </div>-->

            </div>

          </div>
        </div>
      </div>
    </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('Contract expiration') )
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
    <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

    <script src="{{ asset('js/admin/contract/contract_expiration.js?v3.0.1')}}"></script>
    <style media="screen">
      .not_borde {
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
      }
      .table-anex.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }
    </style>
  @else
    @include('default.denied')
  @endif
@endpush
