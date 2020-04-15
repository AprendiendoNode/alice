@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') )
    {{ trans('message.breadcrumb_document_create') }}
  @else
    {{ trans('message.denied') }}
  @endif --}}
  Historial de Documentos M
@endsection

@section('breadcrumb_title')
   @if( auth()->user()->can('View History Document M') )
    Historial de Documentos M
    @else
      {{ trans('message.denied') }}
    @endif
@endsection

@section('content')
  <form id="form_edit_docp" class="" action="/edit_cart" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id_docp" id="id_docp" value="">
  </form>
  <form id="form_edit_cotizador" class="" action="/edit_cart_quoting" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id_docp" id="id_docp_2" value="">
  </form>
  @include('permitted.documentp.modal_documentp')

  @if( auth()->user()->can('View level zero documentp notification') )
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
          <div class="row">
            <form id="search_info" name="search_info" class="form-inline" method="post">
              {{ csrf_field() }}
            </form>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
          <div class="table-responsive">
            <table id="table_documentp" class="table table-striped table-bordered table-hover table-condensed">
              <thead>
                <tr style="background: #088A68;">
                  <th> <small></small> </th>
                  <th> <small>Fecha de solicitud</small> </th>
                  <th> <small>Folio</small> </th>
                  <th> <small>Nombre del proyecto</small> </th>
                  <th> <small>$ EA USD</small> </th>
                  <th> <small>$ ENA USD</small> </th>
                  <th> <small>$ MO USD</small> </th>
                  <th> <small>ITC</small> </th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>V.</small> </th>
                  <th> <small>% Compra</small> </th>
                  <th> <small>Dias de compra</small> </th>
                  <th> <small>Doc.</small> </th>
                  <th> <small>Serv. mensual</small> </th>
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
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
  @elseif ( auth()->user()->can('View level one documentp notification') )
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
          <div class="row">
            <form id="search_info" name="search_info" class="form-inline" method="post">
              {{ csrf_field() }}
            </form>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
          <div class="table-responsive">
            <table  id="table_documentp" class="table table-striped table-bordered table-hover nowrap">
              <thead>
                <tr class="" style="background: #088A68;">
                  <th> <small></small> </th>
                  <th> <small>Fecha de solicitud</small> </th>
                  <th> <small>Folio</small> </th>
                  <th> <small>Nombre del proyecto</small> </th>
                  <th> <small>$ EA USD</small> </th>
                  <th> <small>$ ENA USD</small> </th>
                  <th> <small>$ MO USD</small> </th>
                  <th> <small>ITC</small> </th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>V.</small> </th>
                  <th> <small>% Compra</small> </th>
                  <th> <small>Dias de compra</small> </th>
                  <th> <small>Doc.</small> </th>
                  <th> <small>Prioridad</small> </th>
                  <th> <small>status</small> </th>
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
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>

  @elseif ( auth()->user()->can('View level two documentp notification') )
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
          <div class="row">
            <form id="search_info" name="search_info" class="form-inline" method="post">
              {{ csrf_field() }}
            </form>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
          <div class="table-responsive">
            <table id="table_documentp" class="table table-striped table-bordered table-hover table-condensed">
              <thead>
                <tr class="" style="background: #088A68;">
                  <th> <small></small> </th>
                  <th> <small></small> </th>
                  <th> <small>Fecha de solicitud</small> </th>
                  <th> <small>Folio</small> </th>
                  <th> <small>Nombre del proyecto</small> </th>
                  <th> <small>$ EA USD</small> </th>
                  <th> <small>$ ENA USD</small> </th>
                  <th> <small>$ MO USD</small> </th>
                  <th> <small>ITC</small> </th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>V.</small> </th>
                  <th> <small>% Compra</small> </th>
                  <th> <small>Dias de compra</small> </th>
                  <th> <small>Doc.</small> </th>
                  <th> <small>Prioridad</small> </th>
                  <th> <small>status</small> </th>
                  <th> <small>Cant Sug</small> </th>
                  <th> <small>Cant Req</small> </th>
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
  @elseif ( auth()->user()->can('View level three documentp notification') )
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
          <div class="row">
            <form id="search_info" name="search_info" class="form-inline" method="post">
              {{ csrf_field() }}
            </form>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
          <div class="table-responsive">
            <table id="table_documentp" class="table table-striped table-bordered table-hover table-condensed">
              <thead>
                <tr class="" style="background: #088A68;">
                  <th> <small></small> </th>
                  <th> <small></small> </th>
                  <th> <small>Fecha de solicitud</small> </th>
                  <th> <small>Folio</small> </th>
                  <th> <small>Nombre del proyecto</small> </th>
                  <th> <small>$ EA USD</small> </th>
                  <th> <small>$ ENA USD</small> </th>
                  <th> <small>$ MO USD</small> </th>
                  <th> <small>ITC</small> </th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>V.</small> </th>
                  <th> <small>% Compra</small> </th>
                  <th> <small>Dias de compra</small> </th>
                  <th> <small>Doc.</small> </th>
                  <th> <small>Prioridad</small> </th>
                  <th> <small>status</small> </th>
                  <th> <small>Cant Sug</small> </th>
                  <th> <small>Cant Req</small> </th>
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
  @else

    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View History Document M') )
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css?v=2.1')}}" >
    <link type="text/css" href="css/bootstrap-editable.css" rel="stylesheet" />
    <script src="{{ asset('js/bootstrap-editable.js')}}"></script>
    <style>

        .dataTables_wrapper .dataTable .btn{
          width: 50px !important;
        }

        .dropdown-menu {
          font-size: 0.8rem !important;
        }
    </style>
      @if( auth()->user()->can('View level zero documentp notification') )
        <script src="{{ asset('js/admin/documentp/requests_documentm_0.js?v=4.2')}}"></script>
        <script src="{{ asset('js/admin/documentp/request_modal_documentp.js?v=1.0.1')}}"></script>
      @elseif ( auth()->user()->can('View level one documentp notification') )
        <script src="{{ asset('js/admin/documentp/requests_documentm_1.js?v=4.2')}}"></script>
        <script src="{{ asset('js/admin/documentp/request_modal_documentp.js?v=1.0.1')}}"></script>
      @elseif ( auth()->user()->can('View level two documentp notification') )
        <script src="{{ asset('js/admin/documentp/requests_documentm_2.js?v=4.2')}}"></script>
        <script src="{{ asset('js/admin/documentp/request_modal_documentp.js?v=1.0.1')}}"></script>
      @elseif ( auth()->user()->can('View level three documentp notification') )
        <script src="{{ asset('js/admin/documentp/requests_documentm_3.js?v=4.4')}}"></script>
        <script src="{{ asset('js/admin/documentp/request_modal_documentp.js?v=5.0.1')}}"></script>
      @endif
  @else
    @include('default.denied')
  @endif
@endpush
