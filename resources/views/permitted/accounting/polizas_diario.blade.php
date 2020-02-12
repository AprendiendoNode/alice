@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View polizas diario') )
  Diario - Vista General
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View polizas diario') )
    Diario - Vista General
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View polizas diario') )
  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <form id="form" name="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <h4 class="">Polizas de diario</h4>
            <div class="row">             
              <div class="col-md-3 col-xs-12">
                <div class="form-group" id="date_from">
                  <label class="control-label" for="filter_date_from">
                    Fecha
                  </label>
                  <div class="input-group mb-3">
                    <input type="text"  datas="filter_date_from" id="filter_date_from" name="filter_date_from" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('first day of this month')) }}" required>
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


  <!------------------TABS POLIZAS DIARIO GENERAL / DETALLE---------------->

  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-poliza-general-tab" data-toggle="tab" href="#nav-poliza-general" role="tab" aria-controls="nav-home" aria-selected="true">General</a>
      <a class="nav-item nav-link" id="nav-poliza-detalle-tab" data-toggle="tab" href="#nav-poliza-detalle" role="tab" aria-controls="nav-profile" aria-selected="false">Detalle</a>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <!---------------------------------POLIZAS GENERAL---------------------------------->
    <div class="tab-pane fade show active" id="nav-poliza-general" role="tabpanel" aria-labelledby="nav-poliza-general-tab">
      <div class="row mt-5">
        <div class="col-12 table-responsive">
            <table id="tabla_diario_general" class="table table-sm">
              <thead class="bg-secondary text-white">
                <tr>
                  <th></th>
                  <th></th>
                  <th>Ejerc.</th>
                  <th>Mes</th>
                  <th>Tipo</th>
                  <th>Núm.</th>
                  <th>Día</th>
                  <th>Descripción gral.</th>
                  <th>Cargos</th>
                  <th>Abonos</th>
                  <th>Fecha de creación</th>
                  <th>Última modificación</th>
                </tr>
              </thead>
              <tbody>
                  
              </tbody>
            </table>    
        </div>
      </div>
    </div>
    <!---------------------------------POLIZAS DETALLE---------------------------------->
    <div class="tab-pane fade" id="nav-poliza-detalle" role="tabpanel" aria-labelledby="nav-poliza-detalle-tab">
      <div class="row mt-5">
        <div class="col-12 table-responsive">
            <table id="tabla_diario_detalle" class="table table-sm">
              <thead class="bg-secondary text-white">
                <tr>
                  <th></th>
                  <th></th>
                  <th>Mov.</th>
                  <th>Núm. cuenta</th>
                  <th>Nombre cuenta</th>
                  <th>Día</th>
                  <th>T.C.</th>
                  <th>Descripción</th>
                  <th>Cargos</th>
                  <th>Abonos</th>
                  <th>Conc.</th>
                  <th>Fecha de creación</th>
                  <th>Última modificación</th>
                </tr>
              </thead>
              <tbody>
                  
              </tbody>
            </table>    
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
        <form id="form_update_asientos_contables">
        <div class="modal-body">
          <!------TABLA DE PARTIDAS / ASIENTO CONTABLE------>
          <div class="row mt-2 mb-3">
            <div id="data_asientos" class="col-12 table-responsive">
              
            </div>
          </div>
          <!------------RESUMEN FACTURA--------->
          {{-- <div class="row mt-5">
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
          </div> --}}  
        </div>
        <div class="modal-footer">
          @if( auth()->user()->can('Polizas update') )
            <button type="submit" id="update_poliza_partida" type="button" class="btn btn-primary">Guardar</button>
          @endif
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </form> 
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
    td { font-size: 12px !important; }

    #tabla_diario_general tbody tr td {
      padding: 0.2rem 0.5rem;
      height: 38px !important;
    }

    #tabla_diario_general thead tr th{
        padding: 0.2rem 0.5rem;
        height: 38px !important;
    }

    #tabla_diario_detalle tbody tr td {
      padding: 0.2rem 0.5rem;
      height: 38px !important;
    }

    #tabla_diario_detalle thead tr th{
        padding: 0.2rem 0.5rem;
        height: 38px !important;
    }

  </style>
  <script src="{{ asset('js/admin/accounting/poliza_diario.js')}}"></script>
  @else
  @endif
@endpush
