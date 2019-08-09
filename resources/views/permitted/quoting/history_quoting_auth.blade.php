@extends('layouts.app')

@section('contentheader_title')
  @if( auth()->user()->can('View auth history quoting') )
    {{ trans('message.hist_quoting_auth') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')


@endsection

@section('breadcrumb_ubication')
  @if( auth()->user()->can('View auth history quoting') )
    {{ trans('message.breadcrumb_hist_quoting_auth') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  <form id="form_edit_docp" class="" action="/edit_cart_quoting" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id_docp" id="id_docp" value="">
  </form>
  @include('permitted.documentp.modal_documentp')

  @if( auth()->user()->can('View auth history quoting') )
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
            <table id="table_quoting" class="table table-striped table-bordered table-hover table-condensed">
              <thead>
                <tr class="bg-primary" style="background: #0E2A38;">
                  <th> <small>Fecha de solicitud</small> </th>
                  <th> <small>Nombre del proyecto</small> </th>
                  <th> <small>$ EA USD</small> </th>
                  <th> <small>$ ENA USD</small> </th>
                  <th> <small>$ MO USD</small> </th>
                  <th> <small>Solicitó</small> </th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>Versión</small> </th>
                  <th> <small>Tipo Doc.</small> </th>
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
  @if( auth()->user()->can('View auth history quoting') )
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >
    <style>
      .actions a{
        padding: 3px 6px !important;
        margin-left: 3px;
      }
    </style>
      @if( auth()->user()->can('View auth history quoting') )
        <script src="{{ asset('js/admin/quoting/requests_quoting_auth.js')}}"></script>
        <script src="{{ asset('js/admin/quoting/request_modal_quoting.js')}}"></script>
      @endif
  @else
    @include('default.denied')
  @endif
@endpush
