@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View level program payment notification') )
    Programar
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View level program payment notification') )
    Programar para pago
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
     @if( auth()->user()->can('View level program payment notification') )
     @include('permitted.payments.modal_payment')
        <div class="modal modal-default fade" id="modal-view-program" data-backdrop="static">
          <div class="modal-dialog" >
            <div class="modal-content resetear_style">
              <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-calendar-alt" style="margin-right: 4px;"></i>Programar pago.</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="box-body table-responsive">
                <div class="box-body">
                  <div class="row">
                    <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                      <div class="row pad-top-botm client-info">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <p class="text-center" style="border: 1px solid #3D9970">Fecha programada.</p>

                          <div class="clearfix">
                            <input type="text" id="programmed_date" name="programmed_date" class="form-control" readonly>
                          </div>

                          <div class="clearfix">
                            <input id="hidden_viatic" hidden></input>
                            <label>Programar Fecha:</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span><input type="text" class="form-control pickerTab" style="width: 100%;" id="schedule_date" name="schedule_date">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary btn-export"><i class="fa fa-save"></i> Exportar PDF</button> -->
                <button type="button" class="btn btn-warning" id="program_date_p"><i class="fa fa-calendar" style="margin-right: 4px;"></i>Programar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <div class="card">
            <div class="card-body">
           <div class="row">
             <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
               <div class="row h-30">
                 <form id="search_info" name="search_info" class="form-inline" method="post">
                   {{ csrf_field() }}
                   <!--<div class="col-sm-1">
                     <label class="pull-right">Estatus:</label>
                   </div>
                   <div class="col-sm-3">
                     <select id="estatus_s" name="estatus_s" style="width: 100%;" class="form-control select2">
                      <option value="1"></option>
                      <option value="2"></option>
                    </select>
                   </div> -->
                   <div class="col-sm-3">
                     <div class="input-group">
                       <div class="input-group-prepend bg-secondary">
                       </div>
                       <i class="fas fa-calendar-alt fa-3x"></i>
                       <input id="date_to_search" type="text" class="form-control input-sm "height="50" name="date_to_search">
                     </div>
                   </div>
                   <div class="col-sm-3">
                     <button id="boton-aplica-filtro" type="button" class="btn btn-sm btn-info filtrarDashboard">
                      <i class="fas fa-filter"></i> Filtrar
                     </button>
                   </div>

                   <div class="col-sm-3"><label for="date_to_program" class="control-label">Aplicar fecha a todos</label></div>
                   <div class="col-sm-3">
                     <div class="input-group">
                       <input id="date_to_program" type="text" class="form-control pickerTab" name="date_to_program">
                     </div>
                   </div>

                    <!--<div class="col-sm-4">
                     <button id="boton-aplica-program" type="button" class="btn btn-info filtrarDashboard2">
                       <i class="glyphicon glyphicon-filter" aria-hidden="true"></i>  Filtrar
                     </button>
                   </div> -->
                 </form>
               </div>
             </div>
             <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
               <div class="table-responsive">
                 <table id="table_program" class="table table-striped table-bordered table-hover compact-tab" style="width:100%">
                   <thead>
                     <tr class="bg-primary" style="background: #088A68;">
                      <th></th>
                       <th> <small>Poliza</small> </th>
                       <th> <small>Factura</small> </th>
                       <th> <small>Proveedor</small> </th>
                       <th> <small>Estatus</small> </th>
                       <th> <small>Elaboró</small> </th>
                       <th> <small>Autorizó</small> </th>
                       <th> <small>Fecha vencimiento</small> </th>
                       <th> <small>Tipo gasto</small> </th>
                       <th> <small>Tipo Proveedor</small> </th>
                       <th> <small>Total</small> </th>
                       <th> <small>Conceptos</small> </th>
                       <th> <small>Programar Fecha</small> </th>
                       <th><small></small></th>
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
      .pt-10 {
        padding-top: 10px;
      }

      .margin-top-short{
        margin-top: 7px;
      }

      .modal-content{
        width: 180%;
        margin-left: -40%;
      }
      .resetear_style{
        width: 80%;
        margin-left: 10%;
      }
      input:disabled,textarea:disabled {
           background: #ffffff !important;
           border-radius: 3px;
       }
    </style>
  @if( auth()->user()->can('View level program payment notification') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>

    <script src="{{ asset('js/admin/payments/request_modal_payment.js')}}"></script>
    <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
    <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>

    <script src="{{ asset('js/admin/payments/program_datepays.js?v=2.0.0')}}"></script>

  @else
    <!--NO VER-->
  @endif
@endpush
