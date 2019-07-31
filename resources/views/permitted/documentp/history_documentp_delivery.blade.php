@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View Document P') )
    Documentos entregados
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
   @if( auth()->user()->can('View Document P') )
    Documentos entregados
    @else
      {{ trans('message.denied') }}
    @endif
@endsection

@section('content')
  @include('permitted.documentp.modal_documentp')

  @if( auth()->user()->can('View delivery documents') )
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
          <div class="row">
            <form id="search_info" name="search_info" class="form-inline" method="post">
              {{ csrf_field() }}
              {{-- <div class="col-sm-2">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                </div>
              </div>
              <div class="col-sm-10">
                <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                  <i class="glyphicon glyphicon-filter" aria-hidden="true"></i>  Filtrar
                </button>
              </div> --}}
            </form>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
          <div class="table-responsive">
            <table id="table_documentp" class="table table-striped table-bordered table-hover nowrap">
              <thead>
                <tr class="" style="background: #088A68;">
                  <th> <small>Fecha de solicitud</small> </th>
                  <th> <small>Nombre del proyecto</small> </th>
                  <th> <small>$ EA USD</small> </th>
                  <th> <small>$ ENA USD</small> </th>
                  <th> <small>$ MO USD</small> </th>
                  <th> <small>Solicitó</small> </th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>V.</small> </th>
                  <th> <small>% Compra</small> </th>
                  <th> <small>Dias de atraso</small> </th>
                  <th> <small>Doc</small> </th>
                  <th> <small></small> </th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot id='tfoot_average'>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>

  @else
    @include('default.denied')
  @endif

@endsection

@push('scripts')
  @if( auth()->user()->can('View delivery documents') )
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
    <link type="text/css" href="css/bootstrap-editable.css" rel="stylesheet" />
    <script src="{{ asset('js/bootstrap-editable.js')}}"></script>
    <script src="{{ asset('js/admin/documentp/requests_delivery.js?v=1.0.0')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >
    <script src="{{ asset('js/admin/documentp/request_modal_documentp.js')}}"></script>
    <style>
      .actions a{
        padding: 3px 6px !important;
        margin-left: 3px;
      }
    </style>

  @else
    @include('default.denied')
  @endif
@endpush
