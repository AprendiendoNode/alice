@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View server review') )
    {{ trans('message.title_review') }} de servidores
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View server review') )
    {{ trans('message.breadcrumb_server_review') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View server review') )
    <section id='invoiceContep' name='invoiceContep' class="invoice card p-5">
      <div id="titulos" name="titulos" class="row">
          <div class="col-xs-12">
              <h3 class="page-header">
                  <i class="fa fa-desktop"></i> Diagnóstico para servidores.
                  <small class="pull-right"></small>
              </h3>
          </div>
      </div>
      <div class="row invoice-info">
        <div class="col-sm-2"></div>
          <div class="col-sm-8 invoice-col">
            <div class="form-group" align="center">
                <label>Seleccione el hotel para diagnosticar.</label>
                <select id="codigoHotel" name="clienteProyectos" class="form-control select2">
                    <option value="" selected>-----------------</option>
                    <option value="PL">Playacar Palace</option>
                    <option value="ZCJG">Jamaica Palace</option>
                    <option value="CZ">Cozumel Palace</option>
                </select>
                <hr>
                <label>Presione para verificar la disponibilidad del servidor RADIUS elegido.</label>
                <button id="btnDiagRAD" type="button" style="width: 200px" class="btn btn-block btn-primary">Diagnosticar</button>
            </div>
            <hr>
            <div class="form-group" align="center">
                <label>Presione para verificar la disponibilidad del WebService elegido.</label>
                <button id="btnDiagWB" type="button" style="width: 200px" class="btn btn-block btn-primary">Diagnosticar</button>
            </div>
          </div>
          <div class="col-sm-2"></div>
      </div>
   </section>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View server review') )
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('js/admin/tools/server.js')}}"></script>
  @else
  @endif
@endpush
