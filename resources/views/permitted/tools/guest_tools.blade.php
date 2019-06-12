@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View guest review') )
    {{ trans('message.title_review') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View detailed for hotel') )
    {{ trans('message.breadcrumb_guest_review') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View guest review') )
    <section id='invoiceContep' name='invoiceContep' class="invoice card p-5">
    <div id="titulos" name="titulos" class="row">
        <div class="col-xs-12">
            <h3 class="page-header">
              <i class="fa fa-desktop"></i> Diagnóstico para usuarios.
              <small class="pull-right"></small>
            </h3>
        </div>
    </div>

    <div class="row invoice-info">
        <div class="col-sm-2"></div>
          <div class="col-sm-8 invoice-col">
            {{ csrf_field() }}
            <div class="form-group">
              <label>Seleccione el hotel para diagnosticar.</label>
              <select id="codigoHotel" name="clienteProyectos" class="form-control select2">
              <option value="" selected>-----------------</option>
              <option value="PL">Playacar Palace</option>
              <option value="ZCJG">Jamaica Palace</option>
              <option value="CZ">Cozumel Palace</option>
            </select>
          </div>
          <div class="form-group">
            <label>Número de Habitación.</label>
            <input id="numeroHab" type="number" class="form-control" style="text-align: center;">
          </div>
          <div class="form-group m-4" align="center">
            <button id="btnDiag" type="button" style="width: 200px" class="btn btn-block btn-primary">Diagnosticar</button>
          </div>
          <div class="form-group m-4" id="fila-p">
            <textarea id="results" style="height: 150px" class="form-control" readonly></textarea>
          </div>
          <div class="form-group m-4" id="fila-p2">
            <textarea id="results2" style="height: 150px" class="form-control" readonly></textarea>
          </div>

        </div>


        <div class="col-sm-2"></div>
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mt-3">
            <h4>Radius Palace.</h4>
            <div class="table-responsive">
                 <table id="table_guests" cellspacing="0" class="table table-striped table-bordered table-hover ">
                   <thead>
                     <tr class="bg-dark" style="color: #fff;">
                       <th> <small>Usuario.</small> </th>
                       <th> <small>Nombre.</small> </th>
                       <th> <small>Expiración.</small> </th>
                       <th> <small>Fecha de creación.</small> </th>
                       <th> <small>Descripción.</small> </th>
                     </tr>
                   </thead>
                   <tbody>
                   </tbody>
                   <tfoot id='tfoot_average'>
                     <tr>
                     </tr>
                   </tfoot>
                 </table>
            </div>
          </div>

          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mt-5">
            <h4>Palace Webservice.</h4>
            <div class="table-responsive">
                 <table id="table_palace" cellspacing="0" class="table table-striped table-bordered table-hover">
                   <thead>
                     <tr class="bg-dark" style="color: #fff;">
                       <th> <small>Apellido.</small> </th>
                       <th> <small>Nombre.</small> </th>
                       <th> <small>Noches(estancia).</small> </th>
                       <th> <small>País</small> </th>
                       <th> <small>Errors.</small> </th>
                     </tr>
                   </thead>
                   <tbody>
                   </tbody>
                   <tfoot id='tfoot_average'>
                     <tr></tr>
                   </tfoot>
                 </table>
            </div>
          </div>
  </div>
</section>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View detailed for hotel') )
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('js/admin/tools/guestDiag.js')}}"></script>
  @else
  @endif
@endpush
