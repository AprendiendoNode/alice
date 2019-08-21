@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View level program payment notification') )
    Confirmar
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View level program payment notification') )
    Confirmar Pago
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
     @if( auth()->user()->can('View level three payment notification') )
       @include('permitted.payments.modal_payment')

       <div class="container">
         <div class="card">
           <div class="card-body">

         <div class="row">
           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <input type="text" id="aux_fact" name="aux_fact" style="display: none">
            <select id="aux" style="display: none">
              <option value="" selected> Elija </option>
              @forelse ($bancos as $banco)
                <option value="{{ $banco->id }}"> {{ $banco->banco }} </option>
              @empty
              @endforelse
            </select>
               <form id="search_info" name="search_info" class="form-inline" method="post">
                  {{ csrf_field() }}
                 <!--<div class="row">
                   <div class="col-sm-2">
                     <div class="input-group">
                       <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                       <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                     </div>
                   </div>
                   <div class="col-sm-4">
                     <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                       <i class="glyphicon glyphicon-filter" aria-hidden="true"></i>  Filtrar
                     </button>
                   </div>
                    <div class="col-sm-2"><label class="control-label">Aplicar fecha a todos</label></div>
                     <div class="col-sm-2">
                       <div class="input-group">
                         <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                         <input id="date_to_program" type="text" class="form-control pickerTab" name="date_to_program">
                       </div>
                   </div>
                 </div>-->
                 <br>
                 <div class="row">
                    <div class="form-group">
                      <label class="col-md-1 control-label" for="month_upload_band" style="padding-left: 15px;">Periodo: </label>
                      <div class="col-md-9">
                        <div class="input-group input-daterange">
                          <input id="date_start" name="date_start"  type="text" class="form-control" value="">
                          <div class="input-group-addon" style="padding:10px;">a</div>
                          <input id="date_end" name="date_end"  type="text" class="form-control" value="">
                        </div>
                      </div>
                      <div class="col-md-2">
                         <button id="boton-aplica-periodo" type="button" class="btn btn-info filtrarPeriodo">
                           <i class="fas fa-filter"></i> Filtrar
                         </button>
                      </div>
                    </div>
                 </div>
                 <br>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mt-20">
                          <div class="form-inline">
                            <label class="control-label">Total de MXN (Por pagar)</label>
                            <input id="total_pay_mxn" name="total_pay_mxn" type="text" class="form-control" readonly>
                            <label class="control-label">Total de USD (Por pagar)</label>
                            <input id="total_pay_usd" name="total_pay_usd" type="text" class="form-control" readonly>

                            <!-- <label class="control-label">Aplicar fecha a todos</label>
                            <div class="input-group">
                             <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                             <input id="date_to_program" type="text" class="form-control pickerTab" name="date_to_program">
                            </div> -->

                          </div>
                        </div>

                    </div>
                 <br>
               </form>
           </div>
           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
             <div class="table-responsive">
               <table id="table_program" class="table table-striped table-bordered table-hover compact-tab w-100">
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

  @if( auth()->user()->can('View confirm of payment') )
    @if( auth()->user()->can('View level three payment notification') )
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

    <script src="{{ asset('js/admin/payments/confirm_pays.js')}}"></script>
    @else
    <!--NO VER-->
    @endif
  @endif
@endpush
