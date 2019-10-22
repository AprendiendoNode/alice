@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View history all payments status paid') )
    {{ trans('message.pay_hist_request') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View history all payments status paid') )
    {{ trans('message.breadcrumb_status_paid') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @include('permitted.payments.modal_payment')

    @if( auth()->user()->can('View history all payments status paid') )
    <div class="container">
      <div class="card">
        <div class="card-body">
       <div class="row">
         <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

           <div class="row">
             <form id="search_info" name="search_info" class="form-inline" method="post">
               {{ csrf_field() }}
               <div class="col-md-2">
                 <div class="input-group">
                   <span class="input-group-addon"><i class="fas fa-calendar-alt fa-3x"></i></span>
                   <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                 </div>
               </div>
               <div class="col-md-2">
                 <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                   <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                 </button>
               </div>

                  <label class="col-md-1 control-label" for="month_upload_band" style="padding-left: 0px;">Periodo: </label>
                  <div class="col-md-5">
                    <div class="input-group input-daterange">
                      <input id="date_start" name="date_start"  type="text" class="form-control" value="">
                      <div class="input-group-addon" style="padding:10px;">a</div>
                      <input id="date_end" name="date_end"  type="text" class="form-control" value="">
                    </div>
                  </div>
                  <div class="col-md-2">
                     <button id="boton-aplica-periodo" type="button" class="btn btn-info filtrarPeriodo">
                       <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                     </button>
                  </div>

             </form>
           </div>

          <br>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mt-20">
                  <div class="form-inline">
                    <label class="control-label" style="padding:10px;">Total de MXN (Pagados)</label>
                    <input id="total_pay_mxn" name="total_pay_mxn" type="text" class="form-control" readonly>
                    <label class="control-label" style="padding:10px;">Total de USD (Pagados)</label>
                    <input id="total_pay_usd" name="total_pay_usd" type="text" class="form-control " readonly>
                  </div>
                </div>
            </div>

          <br>
         </div>
         <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
           <div class="table-responsive">
             <table id="table_pays" class="table table-striped table-bordered table-hover compact-tab" style="width:100%">
               <thead>
                 <tr class="bg-primary" style="background: #088A68;">
                   <th> <small>Factura</small> </th>
                   <th> <small>Proveedor</small> </th>
                   <th> <small>Estatus</small> </th>
                   <th> <small>Elaboró</small> </th>
                   <th> <small>Monto</small> </th>
                   <th> <small>Fecha límite</small> </th>
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
  input:disabled,textarea:disabled {
       background: #ffffff !important;
       border-radius: 3px;
   }
  </style>
  @if( auth()->user()->can('View history all payments status paid') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
    <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    
    <script src="{{ asset('js/admin/payments/status_paid.js')}}"></script>
    <script src="{{ asset('js/admin/payments/request_modal_payment.js')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
