@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View projects docp') )
    Avance de proyectos
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
   @if( auth()->user()->can('View projects docp') )
    Avance de proyectos
    @else
      {{ trans('message.denied') }}
    @endif
@endsection

@section('content')
  <form id="form_edit_docp" class="" action="/edit_cart" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id_docp" id="id_docp" value="">
  </form>
  @include('permitted.documentp.modal_documentp')

  <!-- MODAL COMENTARIO-->
  <div id="modal-add-comment" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Añadir comentario | Gerencia Instalaciones </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form id="form_add_comment">

            <textarea class="form-control" id="comment" name="comment" rows="8" placeholder="Escriba un comentario"></textarea>
          </form>
        </div>
        <div class="modal-footer">
          <button id="addComment" type="button" class="btn btn-primary">Guardar comentario</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
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
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-12">
          <div class="table-responsive">
            <table id="table_documentp" class="table table-striped table-bordered table-condensed" style="width:100%">
              <thead>
                <tr style="background: #088A68;">
                  <th> <small>Nombre del proyecto</small> </th>
                  <th> <small>Avance instalai</small> </th>
                  <th> <small>Presupuesto $</small> </th>
                  <th> <small>Presupuesto ejercido %</small> </th>
                  <th> <small>Entrega compromiso</small> </th>
                  <th> <small>Entrega estimada</small> </th>
                  <th> <small>Dias de compra</small> </th>
                  <th> <small>Motivos</small> </th>
                  <th> <small>Fecha firma</small> </th>
                  <th> <small>Atraso de proyecto</small> </th>
                  <th> <small>Tipo de servicio</small> </th>
                  <th> <small>Renta mensual</small> </th>
                  <th> <small>IT Concierge</small> </th>
                  <th> <small></small> </th>
                  <th> <small>Última actualización</small> </th>
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
      <br>
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
      <div class="">
        <div class="">
          <div class="table-responsive">
            <table id="table_documentp" class="table table-striped table-bordered table-condensed" style="width:100%">
              <thead>
                <tr style="background: #088A68;">
                  <th></th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>Proyecto</small> </th>
                  <th> <small>Avance instalación</small> </th>
                  <th> <small>Entrega compromiso</small> </th>
                  <th> <small>Entrega estimada</small> </th>
                  <!--<th> <small>Entrega compromiso</small> </th>-->
                  <th> <small>Presupuesto USD</small> </th>
                  <th> <small>Presupuesto ejercido %</small> </th>
                  <th> <small>Entrega compromiso</small> </th>
                  <th> <small>Atraso compra </small> </th>
                  <th> <small>Motivos</small> </th>
                  <!--<th> <small>Fecha firma</small> </th>-->
                  <th> <small>Atraso instalación</small> </th>
                  <th> <small>Tipo de servicio</small> </th>
                  <th> <small>Renta mensual</small> </th>
                  <th> <small>IT Concierge</small> </th>
                  <th> <small>Facturando</small> </th>
                  <!--<th> <small>Última actualización</small> </th>-->
                  <th> <small>Estatus</small> </th>
                  <th> <small>Comentario</small> </th>
                  <th> <small>Renta mensual</small> </th>
                  <th> <small>Facturando</small> </th>
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
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <br>
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
      <div class="">
        <div class="">
          <div class="table-responsive">
            <table id="table_documentp" class="table table-striped table-bordered table-condensed" style="width:100%">
              <thead>
                <tr style="background: #088A68;">
                  <th> <small>Estatus</small> </th>
                  <th> <small>Proyecto</small> </th>
                  <th> <small>Avance instalación</small> </th>
                  <th> <small>Presupuesto USD</small> </th>
                  <th> <small>Presupuesto ejercido %</small> </th>
                  <th> <small>Entrega compromiso</small> </th>
                  <th> <small>Entrega estimada</small> </th>
                  <th> <small>Atraso compra </small> </th>
                  <th> <small>Motivos</small> </th>
                  <th> <small>Fecha firma</small> </th>
                  <th> <small>Atraso instalación</small> </th>
                  <th> <small>Tipo de servicio</small> </th>
                  <th> <small>Renta mensual</small> </th>
                  <th> <small>IT Concierge</small> </th>
                  <th> <small>Facturando</small> </th>
                  <th> <small>Última actualización</small> </th>
                  <th></th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>Comentario</small> </th>
                  <th> <small>Renta mensual</small> </th>
                  <th> <small>Facturando</small> </th>
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
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <br>
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
      <div class="">
        <div class="">
          <div class="table-responsive">
            <table id="table_documentp" class="table table-striped table-bordered table-condensed" style="width:100%">
              <thead>
                <tr style="background: #088A68;">
                  <th> <small>Estatus</small> </th>
                  <th> <small>Proyecto</small> </th>
                  <th> <small>Avance instalación</small> </th>
                  <th> <small>Presupuesto USD</small> </th>
                  <th> <small>Presupuesto ejercido %</small> </th>
                  <th> <small>Entrega compromiso</small> </th>
                  <th> <small>Entrega estimada</small> </th>
                  <th> <small>Atraso compra </small> </th>
                  <th> <small>Motivos</small> </th>
                  <th> <small>Fecha firma</small> </th>
                  <th> <small>Atraso instalación</small> </th>
                  <th> <small>Tipo de servicio</small> </th>
                  <th> <small>Renta mensual</small> </th>
                  <th> <small>IT Concierge</small> </th>
                  <th> <small>Facturando</small> </th>
                  <th> <small>Última actualización</small> </th>
                  <th></th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>Comentario</small> </th>
                  <th> <small>Renta mensual</small> </th>
                  <th> <small>Facturando</small> </th>
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
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <br>
    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View projects docp') )
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <link type="text/css" href="css/bootstrap-editable.css" rel="stylesheet" />
    <script src="{{ asset('js/bootstrap-editable.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >
    <style>
      #table_documentp td, #table_documentp th{
        vertical-align: middle;
      }

      #table_documentp  td a.set-alert{
        border-radius: 15px;
        padding: 3px 7px;
        color: transparent;
        border-bottom: none;
      }

      .dataTables_wrapper .dataTable .btn{
        width: 50px !important;
      }

      .dropdown-menu {
        font-size: 0.8rem !important;
      }

       /* select option{
        color: transparent;
      } */

      .set-alert  select option:nth-child(1){
        background-color: red !important;
      }

      .set-alert  select option:nth-child(2){
        background-color: yellow !important;
      }

      .set-alert  select option:nth-child(3){
        background-color: green !important;
      }

      .set-alert  select option:nth-child(4){
        background-color: blue !important;
      }

      .editable-popup{
        left: 0px !important;
      }


    </style>
    <script type="text/javascript">
    var user_id = {!! json_encode($user_id) !!};
    </script>
    @if( auth()->user()->can('View level zero documentp notification') )
      <script src="{{ asset('js/admin/documentp/requests_documentp_advance_0.js?v=2.0.6')}}"></script>
      <script src="{{ asset('js/admin/documentp/request_modal_documentp.js?v=4.0.0')}}"></script>
    @elseif ( auth()->user()->can('View level one documentp notification') )
      <script src="{{ asset('js/admin/documentp/requests_documentp_advance_1.js?v=2.0.6')}}"></script>
      <script src="{{ asset('js/admin/documentp/request_modal_documentp.js?v=4.0.0')}}"></script>
    @elseif ( auth()->user()->can('View level two documentp notification') )
      <script src="{{ asset('js/admin/documentp/requests_documentp_advance_1.js?v=2.0.6')}}"></script>
      <script src="{{ asset('js/admin/documentp/request_modal_documentp.js?v=4.0.0')}}"></script>
    @elseif ( auth()->user()->can('View level three documentp notification') )
      <script src="{{ asset('js/admin/documentp/requests_documentp_advance_1.js?v=2.0.6')}}"></script>
      <script src="{{ asset('js/admin/documentp/request_modal_documentp.js?v=5.0.0')}}"></script>
    @endif

@else
  @include('default.denied')
@endif
@endpush
