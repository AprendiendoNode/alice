@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View history all payment notification') )
    {{ trans('message.pay_cc_edit') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View history all payment notification') )
    {{ trans('message.subtitle_pay_cc') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View history all payment notification') )
    {{ trans('message.breadcrumb_pay_cc') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View history all payment notification') )
      @include('permitted.payments.modal_payment')

    <div class="container">
      <div class="card">
        <div class="card-body">
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
          <div class="row">
            <form id="validation" name="validation" class="form-inline" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                 <label class="col-xs-4 control-label mr-2">Fecha Inicio</label>
                 <div class="col-xs-8 dateContainer">
                     <div class="input-group input-append date" id="startDatePicker" name="startDatePicker">
                       <input type="text" class="form-control" id="startDate" name="startDate" />
                       <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                 </div>
              </div>
              <div class="form-group">
                <label class="col-xs-4 control-label mx-2">Fecha Fin</label>
                <div class="col-xs-8 dateContainer">
                    <div class="input-group input-append date" id="endDatePicker" name="endDatePicker">
                      <input type="text" class="form-control" id="endDate" name="endDate" />
                      <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
              </div>
              <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard ml-2">
                <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
              </button>
            </form>
          </div>
          <hr>
          <!--Cuenta contable-->
            <div class="row">
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                  <form class="form-inline" method="post">
                    <div class="form-group">
                      <div class="col-md-6">
                        <label for="" class="control-label">Cuenta contable a cambiar: </label>
                      </div>
                      <div class="col-md-6">
                        <select class="form-control select2 pl-2" id="select_cc" name="select_cc">
                          <option value="">Elegir</option>
                          @forelse ($cuentas as $data_contable )
                          <option value="{{ $data_contable->cuenta_contable . ' | ' . $data_contable->cuenta_contable_name}}"> {{ $data_contable->cuenta_contable . ' | ' . $data_contable->cuenta_contable_name }} </option>
                          @empty

                          @endforelse
                        </select>
                      </div>
                    </div>
                  </form>
              </div>
            </div>
            <br>
          <!--CC END-->
        </div>

        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10 margin-top-short">
          <div class="table-responsive">
            <table id="table_history_all" class="table table-striped table-bordered table-hover compact-tab w-100">
              <thead>
                <tr class="bg-primary" style="background: #088A68;">
                  <th> <small></small> </th>
                  <th> <small>Factura</small> </th>
                  <th> <small>Proveedor</small> </th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>Monto</small> </th>
                  <th> <small>Tipo cambio</small> </th>
                  <th> <small>Elaboró</small> </th>
                  <th> <small>Fecha de solicitud</small> </th>
                  <!-- <th> <small>Fecha límite de pago</small> </th> -->
                  <th> <small>Fecha pago</small> </th>
                  <th> <small>Cuenta contable</small> </th>
                  <th> <small>Conceptos</small> </th>
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
                  <!-- <th></th> -->
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
  </div>
    </div>



    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  <style media="screen">
    .margin-top-short{
      margin-top: 7px;
    }

    .modal-content{
      width: 180%;
      margin-left: -40%;
    }

    input:disabled,textarea:disabled {
         background: #ffffff !important;
         border-radius: 3px;
     }
  </style>
  @if( auth()->user()->can('View history all payment notification') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
    <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

    <!-- <script src="{{ asset('js/admin/payments/history_all_pay.js?v=2.0.0')}}"></script> -->
    <script src="{{ asset('js/admin/payments/edit_pay_cc.js') }}"></script>
    <script src="{{ asset('js/admin/payments/request_modal_payment.js?v=2.0.0')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
