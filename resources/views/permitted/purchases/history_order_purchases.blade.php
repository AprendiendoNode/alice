@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View customers invoices') )
    Compras
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customers invoices') )
    Compras
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View customers invoices') )
  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="mt-4 text-dark">Historial de ordenes de compra</h4>
          <form id="form" name="form" enctype="multipart/form-data">
            {{ csrf_field() }}                     
            <div class="row">
                <div class="col-md-12 grid-margin-onerem  stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <form id="form" name="form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">             
                          <div class="col-md-3 col-xs-12">
                            <div class="form-group" id="date_from">
                              <label class="control-label" for="filter_date_from">
                                Fecha inicial
                              </label>
                              <div class="input-group mb-3">
                                <input type="text"  datas="date" id="date" name="date" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('first day of this month')) }}" required>
                                <div class="input-group-append">
                                  <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 col-xs-12">
                            <div class="form-group" id="filter_date_to">
                              <label class="control-label" for="filter_date_to">
                                Fecha final
                              </label>
                              <div class="input-group mb-3">
                                <input type="text"  datas="filter_date_to" id="filter_date_to" name="filter_date_to" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('last day of this month')) }}" required>
                                <div class="input-group-append">
                                  <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 col-xs-12 pt-4">
                            <button type="submit"
                                    onclick=""
                                    class="btn btn-xs btn-info "
                                    style="margin-top: 8px">
                                <i class="fa fa-filter"> {{__('general.button_search')}}</i>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>        
          </form>
            <!---------------------------------------------------------------------------------->
            <div class="row mt-5">
                <div class="table-responsive">
                    <table id="tabla_productos" class="table table-condensed table-sm">
                      <thead>
                        <tr style="background: #496E7D;color:white;font-size:10px;">
                          <th></th>
                          <th></th>
                          <th>Fecha</th>
                          <th class="text-center"># Orden</th>
                          <th>Proveedor</th>
                          <th>Total</th>                         
                          <th>Estatus</th>
                          <th>Fecha de entrega</th>
                          <th>Direccion de entrega</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                </div>
            </div>
            <!---------------------------------------------------------------------------------->
        </div>
      </div>
    </div>
  </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View customers invoices') )
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
  <script src="{{ asset('js/admin/purchases/history_purchases_orders.js')}}"></script>

  <style media="screen">

    .btn-xs {
      padding: .35rem .4rem .25rem !important;
    }
    input {
      padding-left: 0px !important;
      padding-right: : 0px !important;
    }
    .datepicker td, .datepicker th {
        width: 1.5em !important;
        height: 1.5em !important;
    }

    #tabla_productos tbody tr td {
      padding: 0.2rem 0.5rem;
      height: 38px !important;
    }

    #tabla_productos thead tr th{
        padding: 0.2rem 0.5rem;
        height: 38px !important;
    }
    
  </style>
  @else
  @endif
@endpush
