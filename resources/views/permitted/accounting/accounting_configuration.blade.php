@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('Create polizas') )
  Historial de polizas
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('Create polizas') )
    Historial de polizas
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('Create polizas') )
  <div class="row">
    <div class="col-md-12 grid-margin-onerem card">
      <div class="card-body">
        <div class="row">
          <h4 class="text-dark">Contabilidad | Administrador</h4>
        </div>
        <div class="row">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-md-2 mt-3" role="group" aria-label="Second group">
                    <button type="button" class="btn btn-success"><i class="fas fa-balance-scale"></i> Balance general</button>
                    <button type="button" class="btn btn-success"><i class="fas fa-file-invoice-dollar"></i> Estado de resultados</button>
                </div>
                <div class="btn-group mr-md-2 mt-3" role="group" aria-label="First group">
                    <button type="button" onclick="modal_periodo_actual();" class="btn btn-dark"><i class="far fa-calendar-alt"></i> Periodo actual</button>
                    <button type="button" class="btn btn-secondary"><i class="far fa-calendar-check"></i> Cierre mensual</button>
                    <button type="button" class="btn btn-danger"><i class="fas fa-exclamation-circle"></i> Cerrar periodo anual</button>
                </div>             
            </div>
        </div>
      </div>
    </div>
  </div>


  <!-----------------------Modal periodo actual------------------------>
  <div id="modal-periodo-actual" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="far fa-calendar-alt"></i> Periodo actual</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-periodo-actual">
            <div class="form-group row mt-2">
                <label class="col-12 col-sm-6" for="">Fecha inicial del ejercicio:</label>
                <div class="col-12 col-sm-6">
                    <input readonly id="fecha_inicio_periodo_actual" name="fecha_inicio_periodo_actual" class="form-control form-control-sm" value="">
                </div>          
            </div>
            <div class="form-group row mt-2">
                <label class="col-12 col-sm-6" for="">Fecha final del ejercicio:</label>
                <div class="col-12 col-sm-6">
                    <input readonly id="fecha_final_periodo_actual" name="fecha_final_periodo_actual" class="form-control form-control-sm" value="">
                </div>          
            </div>
            <div class="form-group row mt-2">
                <label class="col-12 col-sm-6" for="">Periodos en el ejercicio:</label>
                <div class="col-12 col-sm-6">
                    <input readonly id="fecha_final_periodo_actual" name="fecha_final_periodo_actual" class="form-control form-control-sm" value="">
                </div>          
            </div>
            <br>
            <hr>
            <div class="form-group row mt-2">
                <label class="col-12 col-sm-6" for="">Periodos actual:</label>
                <div class="col-12 col-sm-2">
                    <input readonly id="fecha_final_periodo_actual" name="fecha_final_periodo_actual" class="form-control form-control-sm" value="">
                </div>          
            </div>
            <div class="form-group row mt-2">
                <label class="col-12 col-sm-6" for="">Fecha inicio:</label>
                <div class="col-12 col-sm-6">
                    <input readonly id="fecha_final_periodo_actual" name="fecha_final_periodo_actual" class="form-control form-control-sm" value="">
                </div>          
            </div>
            <div class="form-group row mt-2">
                <label class="col-12 col-sm-6" for="">Fecha fin:</label>
                <div class="col-12 col-sm-6">
                    <input readonly id="fecha_final_periodo_actual" name="fecha_final_periodo_actual" class="form-control form-control-sm" value="">
                </div>          
            </div>
          </form>
        </div>
        <div class="modal-footer">   
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>


  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('Create polizas') )
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

  <!-- Theme included stylesheets -->
  <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <script src="{{ asset('js/admin/accounting/accounting_configuration.js?v=1.0')}}"></script>

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
    td { font-size: 12px !important; }

    #table_filter_fact tbody tr td {
      padding: 0.2rem 0.5rem;
      height: 38px !important;
    }

  </style>
  @else
  @endif
@endpush
