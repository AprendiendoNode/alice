@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View polizas') )
  Historial de polizas
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View polizas') )
    Historial de polizas
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View polizas') )
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
                    {{ __('general.date_from') }}
                  </label>
                  <div class="input-group mb-3">
                    <input type="text"  datas="filter_date_from" id="filter_date_from" name="filter_date_from" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('first day of this month')) }}" required>
                    <div class="input-group-append">
                      <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-xs-12">
                <div class="form-group" id=date_to>
                  <label class="control-label" for="filter_date_to">
                    {{ __('general.date_to') }}
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
                        style="margin-top: 4px">
                    <i class="fa fa-filter"> {{__('general.button_search')}}</i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive table-data table-dropdown">
            <table id="table_filter_fact" name='table_filter_fact' class="table table-striped table-hover table-condensed">
              <thead>
                <tr class="mini">
                    <th></th>
                    <th class="text-center" width="5%">@lang('general.column_actions')</th>
                    <th class="text-center">
                      {{  __('customer_invoice.column_name')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_date')}}
                    </th>
                    <th class="text-center">
                        @lang('customer_invoice.column_uuid')
                    </th>
                    <th class="text-left">
                        {{__('customer_invoice.column_customer')}}
                    </th>
                    
                    <th class="text-center">
                        {{__('customer_invoice.column_date_due')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_currency')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_amount_total')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_balance')}}
                    </th>
                    
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!----------------------MODAL POLIZA MOVIMIENTOS--------------------------->
  <div id="modal_view_poliza" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Póliza</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <form class="">
              <div class="row">
                <div class="form-group col-md-3">
                  <label class="" for="type_poliza">Tipo:</label>
                  <select class="form-control form-control-sm mb-2 mr-sm-2" id="type_poliza" placeholder="">
                    <option value="1">Diario</option>
                    <option value="2">Ingreso</option>
                    <option value="3">Egreso</option>
                  </select>
                </div>
              
                <div class="form-group col-md-2">
                  <label class="" for="">Número:</label>
                  <input type="number" class="form-control form-control-sm mb-2 mr-sm-2" id="" placeholder="">
                </div>

                <div class="form-group col-md-2">
                  <label class="" for="day_poliza">Día:</label>
                  <input type="number" class="form-control form-control-sm mb-2 mr-sm-2" name="day_poliza" id="day_poliza" placeholder="">
                </div>
                <div class="form-group col-md-3">
                  <label class="" for="mes_poliza">Mes:</label>
                  <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="mes_poliza" id="mes_poliza">
                </div>
              </div>
            </form>
          </div>
          <!------TABLA DE PARTIDAS / ASIENTO CONTABLE------>
          <div class="row mt-2 mb-3">
            <div class="col-12 table-responsive">
              <table id="tabla_asiento_contable" class="table table-sm">
                <thead class="bg-secondary text-white">
                  <tr>
                    <th>Mov.</th>
                    <th>Cuenta</th>
                    <th>Dia</th>
                    <th>T.C.</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Abono</th>
                    <th>Referencia</th>
                  </tr>
                </thead>
                <tbody>       
                </tbody>
              </table>
            </div>
          </div>
          <!------------RESUMEN FACTURA--------->
          <div class="row mt-5">
            <div class="col-12 table-responsive">
              <table class="table table-sm">
                <thead class="bg-secondary text-white">
                  <tr>
                    <th>Org.</th>
                    <th>Partida</th>
                    <th>Dia</th>
                    <th>No.</th>
                    <th>Tipo</th>
                    <th>UUID / Folio</th>
                    <th>Beneficiario</th>
                    <th>Importe</th>
                  </tr>
                </thead>
                <tbody>       
                </tbody>
              </table>
            </div>
          </div>
          <!--------------TOTALES----------->
          <div class="row mt-5">
            <div class="form-inline col-md-8">
              
            </div>
            <div class="form-inline col-md-4">
              <label class="" for="">Totales: </label>
              <input style="width:130px;" readonly type="text" class="form-control form-control-sm mb-2 mr-sm-2 text-right font-weight-bold" name="total_cargos" id="total_cargos" >
              <input style="width:130px;" readonly type="text" class="form-control form-control-sm mb-2 mr-sm-2 text-right font-weight-bold" name="total_abonos" id="total_abonos" >
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="save_poliza_partida" type="button" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
 <!----------------------------- FIN MODAL POLIZA MOVIMIENTOS--------------------------------->
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View polizas') )
  <style media="screen">
    .editor-wrapper {
      min-height: 250px;
      background-color: #fff;
      border-collapse: separate;
      border: 1px solid #ccc;
      padding: 4px;
      box-sizing: content-box;
      box-shadow: rgba(0,0,0,.07451) 0 1px 1px 0 inset;
      overflow: scroll;
      outline: 0;
      border-radius: 3px;
    }
    .editor_quill {
      margin-bottom: 5rem !important;
    }
  </style>

  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
  <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>


  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  
  <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
  <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>

  <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  

  <!-- Main Quill library -->
  <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
  {{-- <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script> --}}

  <!-- Theme included stylesheets -->
  <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <style media="screen">
    .white {background-color: #ffffff;}
    
    .select2-selection__rendered {
      line-height: 36px !important;
      padding-left: 15px !important;
    }
    .select2-selection {
      height: 34px !important;
    }
    .select2-selection__arrow {
      height: 28px !important;
    }
    
    th { font-size: 12px !important; }
    td { font-size: 10px !important; }


  </style>
  <script type="text/javascript">
      var quill;
      var OPEN = "{{ \App\Models\Sales\CustomerInvoice::OPEN }}";
      var PAID = "{{ \App\Models\Sales\CustomerInvoice::PAID }}";
      var CANCEL = "{{ \App\Models\Sales\CustomerInvoice::CANCEL }}";
      var RECONCILED = "{{ \App\Models\Sales\CustomerInvoice::RECONCILED }}";
      var CANCEL_PER_AUTHORIZED = "{{ \App\Models\Sales\CustomerInvoice::CANCEL_PER_AUTHORIZED }}";
  
  </script>
  <script src="{{ asset('js/admin/sales/polizas.js')}}"></script>
  @else
  @endif
@endpush
