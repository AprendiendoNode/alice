@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') )
    {{ trans('message.breadcrumb_document_create') }}
  @else
    {{ trans('message.denied') }}
  @endif --}}
  Documentos autorizados
@endsection

@section('breadcrumb_title')
  Documentos autorizados
  {{-- @if( auth()->user()->can('View Document P') )
    {{ trans('message.document_create') }}
  @else
    {{ trans('message.denied') }}
  @endif --}}
@endsection


@section('content')
  <form id="form_edit_docp" class="" action="/edit_cart" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id_docp" id="id_docp" value="">
  </form>
  {{-- @include('permitted.documentp.modal_documentp') --}}

  @if( auth()->user()->can('View History Auth Document P') )
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
          <div class="row">
            <form id="search_info" name="search_info" class="form-inline" method="post">
              {{ csrf_field() }}
              <div class="col-sm-2">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                </div>
              </div>
              <div class="col-sm-10">
                <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                  <i class="glyphicon glyphicon-filter" aria-hidden="true"></i>  Filtrar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
          <div class="table-responsive">
            <table id="table_documentp" class="table table-striped table-bordered table-hover">
              <thead>
                <tr class="" style="background: #088A68;">
                  <th> <small></small> </th>
                  <th> <small>Fecha de solicitud</small> </th>
                  <th> <small>Nombre del proyecto</small> </th>
                  <th> <small>$ EA USD</small> </th>
                  <th> <small>$ ENA USD</small> </th>
                  <th> <small>$ MO USD</small> </th>
                  <th> <small>Solicito</small> </th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>Versión</small> </th>
                  <th> <small>% Compra</small> </th>
                  <th> <small>Dias de atraso</small> </th>
                  <th> <small>Doc</small> </th>
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
  @if( auth()->user()->can('View History Auth Document P') )
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <link type="text/css" href="css/bootstrap-editable.css" rel="stylesheet" />
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('js/admin/documentp/requests_documentp_auth.js')}}"></script>
    <script type="text/javascript">
      $(document).on({
        'show.bs.modal': function() {
          var zIndex = 1040 + (10 * $('.modal:visible').length);
          $(this).css('z-index', zIndex);
          setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
          }, 0);
        },
        'hidden.bs.modal': function() {
          if ($('.modal:visible').length > 0) {
            // restore the modal-open class to the body element, so that scrolling works
            // properly after de-stacking a modal.
            setTimeout(function() {
              $(document.body).addClass('modal-open');
            }, 0);
          }
        }
      }, '.modal');
    </script>
    <style>
    .actions a{
      padding: 2px 4px !important;
      margin-left: 3px;
    }

    #table_documentp thead th{
      width: 100%;
      padding: 0.2rem 0.2rem;
      color: white;
      white-space: pre-line;
    }

    #table_documentp td, #table_documentp th{
      vertical-align: middle;
    }

    #table_documentp td, #table_documentp th{
      vertical-align: middle;
    }

    #table_documentp tbody tr td{
      padding: 0.2rem 0.5rem;
      width: auto !important;
      height: 35px !important;
      white-space: pre-line;
    }

    .actions-button{
      max-width: 170px !important;
    }

    .actions-button a{
      margin-left: .2rem;
      padding: 0rem 0rem;
    }

    .actions-button .btn span{
      font-size: 0.7rem;
    }

    .cell-name{
       max-width: 130px !important;
    }

    .cell-price{
      max-width: 80px !important;
    }

    .cell-short{
      max-width: 80px;
    }

    .dataTables_wrapper .dataTable .btn{
      width: 30px;
      padding: 0 0;
    }

    .dataTable tr.selected{
      background-color: #0C74E8 !important;
      color: #fff !important;
    }

    .editableform .form-control{
      height: 1.8rem;
    }

    .editable-submit, .editable-cancel{
      width: 30px;
      font-size: 0.7rem;
    }
    </style>
      @if( auth()->user()->can('View History Auth Document P') )
        <script src="{{ asset('js/admin/documentp/requests_documentp_auth.js?v=1.0.1')}}"></script>
        <script src="{{ asset('js/admin/documentp/request_modal_documentp.js')}}"></script>

      @endif
  @else
    @include('default.denied')
  @endif
@endpush
