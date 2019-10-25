@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View history quoting') )
    Cotizaciones por autorizar
  @else
    {{ trans('message.denied') }}
  @endif

@endsection

@section('breadcrumb_title')
   @if( auth()->user()->can('View history quoting') )
    Cotizaciones por autorizar
    @else
      {{ trans('message.denied') }}
    @endif
@endsection

@section('content')
  <form id="form_edit_docp" class="" action="/edit_cart_quoting" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id_docp2" id="id_docp2" value="">
  </form>
  <form id="form_edit_kickoff" class="" action="/edit_kickoff" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id_doc_3" id="id_doc_3" value="">
  </form>
  @include('permitted.quoting.modal_quoting')
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
      @if( auth()->user()->can('View level zero documentp notification') )
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
          <div class="table-responsive">
            <table id="table_quoting" class="table table-striped table-bordered table-hover table-condensed mt-3">
              <thead>
                <tr style="background: #0E2A38;color: white;">
                  <th> <small>Fecha de solicitud</small> </th>
                  <th> <small>Nombre del proyecto</small> </th>
                  <th> <small>$ EA USD</small> </th>
                  <th> <small>$ ENA USD</small> </th>
                  <th> <small>$ MO USD</small> </th>
                  <th> <small>Solicitó</small> </th>
                  <th> <small>Estatus</small> </th>
                  <th> <small><i class="fas fa-check-double"></i></small> </th>
                  <th> <small>Doc.</small> </th>
                  <th> <small></small> </th>
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
    @elseif ( auth()->user()->can('View level one documentp notification') ||
              auth()->user()->can('View level two documentp notification') ||
              auth()->user()->can('View level three documentp notification'))
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
            <div class="table-responsive">
              <table id="table_quoting" class="table table-striped table-bordered table-hover table-condensed mt-3">
                <thead>
                  <tr style="background: #0E2A38;color: white;">
                    <th> <small></th>
                    <th> <small>Fecha de solicitud</small> </th>
                    <th> <small>Nombre del proyecto</small> </th>
                    <th> <small>$ EA USD</small> </th>
                    <th> <small>$ ENA USD</small> </th>
                    <th> <small>$ MO USD</small> </th>
                    <th> <small>Solicitó</small> </th>
                    <th> <small>Estatus</small> </th>
                    <th> <small><i class="fas fa-check-double"></i></small> </th>
                    <th> <small>Doc.</small> </th>
                    <th> <small></small> </th>
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
      @else
        @include('default.denied')
      @endif
@endsection

@push('scripts')
  <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >
  <style>
    .dataTables_wrapper .dataTable .btn{
      width: 50px !important;
    }
    .dropdown-menu {
      font-size: 0.8rem !important;
    }
  </style>
  @if( auth()->user()->can('View level zero documentp notification') )
    <script src="{{ asset('js/admin/quoting/requests_quoting_review_0.js?v=4.0.0')}}"></script>
    <script src="{{ asset('js/admin/quoting/request_modal_quoting.js?v=4.0.0')}}"></script>
  @elseif ( auth()->user()->can('View level one documentp notification') ||
            auth()->user()->can('View level two documentp notification') ||
            auth()->user()->can('View level three documentp notification'))
    <script src="{{ asset('js/admin/quoting/requests_quoting_review_all.js?v=4.0.0')}}"></script>
    <script src="{{ asset('js/admin/quoting/request_modal_quoting.js?v=4.0.0')}}"></script>
  @endif
@endpush
