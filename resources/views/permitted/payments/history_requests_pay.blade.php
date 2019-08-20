@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View history of payment') )
    {{ trans('message.pay_hist_request') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View history of payment') )
    {{ trans('message.subtitle_pay_hist') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View history of payment') )
    {{ trans('message.breadcrumb_pay_hist') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View history of payment') )
      @include('permitted.payments.modal_payment')


     @if( auth()->user()->can('View level zero payment notification') )
       <div class="container">
         <div class="card">
           <div class="card-body">
             <div class="row">
           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
             <div class="row">
               <form id="search_info" name="search_info" class="form-inline" method="post">
                 {{ csrf_field() }}
                 <div class="col-md-8">
                   <div class="input-group">
                     <span class="input-group-addon"><i class="fas fa-calendar-alt fa-3x"></i></span>
                     <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                   </div>
                 </div>
                 <div class="col-md-4">
                   <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                     <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                   </button>
                 </div>
               </form>
             </div>
           </div>
           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
             <div class="table-responsive">
               <table id="table_pays" class="table table-striped table-bordered table-hover compact-tab w-100">
                 <thead>
                   <tr class="bg-primary" style="background: #088A68;">
                     <th> <small>Factura</small> </th>
                     <th> <small>Proveedor</small> </th>
                     <th> <small>Estatus</small> </th>
                     <th> <small>Elaboró</small> </th>
                     <th> <small>Monto</small> </th>
                     <th> <small>Fecha de solicitud</small> </th>
                     <th> <small>Fecha límite de pago</small> </th>
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
                   </tr>
                 </tfoot>
               </table>
             </div>
           </div>
         </div>
           </div>
         </div>
       </div>
     @elseif ( auth()->user()->can('View level one payment notification') )
       <div class="container">
         <div class="card">
           <div class="card-body">
             <div class="row">
           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
             <div class="row">
               <form id="search_info" name="search_info" class="form-inline" method="post">
                 {{ csrf_field() }}
                 <div class="col-md-8">
                   <div class="input-group">
                     <span class="input-group-addon"><i class="fas fa-calendar-alt fa-3x"></i></span>
                     <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                   </div>
                 </div>
                 <div class="col-md-4">
                   <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                     <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                   </button>
                 </div>
               </form>
             </div>
           </div>

           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
             <div class="table-responsive">
               <table id="table_pays" class="table table-striped table-bordered table-hover compact-tab w-100">
                 <thead>
                   <tr class="bg-primary" style="background: #088A68;">
                     <th> <small></small> </th>
                     <th> <small>Factura</small> </th>
                     <th> <small>Proveedor</small> </th>
                     <th> <small>Estatus</small> </th>
                     <th> <small>Elaboró</small> </th>
                     <th> <small>Monto</small> </th>
                     <th> <small>Fecha de solicitud</small> </th>
                     <th> <small>Fecha límite de pago</small> </th>
                     <th> <small>Conceptos</small> </th>
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
           </div>
         </div>
       </div>
     @elseif ( auth()->user()->can('View level two payment notification') )
       <div class="container">
         <div class="card">
           <div class="card-body">
             <div class="row">
           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
             <div class="row">
               <form id="search_info" name="search_info" class="form-inline" method="post">
                 {{ csrf_field() }}
                 <div class="col-md-8">
                   <div class="input-group">
                     <span class="input-group-addon"><i class="fas fa-calendar-alt fa-3x"></i></span>
                     <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                   </div>
                 </div>
                 <div class="col-md-4">
                   <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                     <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                   </button>
                 </div>
               </form>
             </div>
           </div>

           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
             <div class="table-responsive">
               <table id="table_pays" class="table table-striped table-bordered table-hover compact-tab w-100">
                 <thead>
                   <tr class="bg-primary" style="background: #088A68;">
                     <th> <small></small> </th>
                     <th> <small>Factura</small> </th>
                     <th> <small>Proveedor</small> </th>
                     <th> <small>Estatus</small> </th>
                     <th> <small>Monto</small> </th>
                     <th> <small>Elaboró</small> </th>
                     <th> <small>Fecha de solicitud</small> </th>
                     <th> <small>Fecha límite de pago</small> </th>
                     <th> <small>Conceptos</small> </th>
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
           </div>
         </div>
       </div>
     @elseif ( auth()->user()->can('View level three payment notification') )
        <h3>Para confirmar pago diríjase al siguiente  <a href="{{ url('/confirm_pay')}}">módulo.</a></h3>
        <!-- <div class="container">
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

           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
             <div class="table-responsive">
               <table id="table_pays" class="table table-striped table-bordered table-hover">
                 <thead>
                   <tr class="bg-primary" style="background: #088A68;">
                     <th> <small></small> </th>
                     <th> <small>Factura</small> </th>
                     <th> <small>Proveedor</small> </th>
                     <th> <small>Estatus</small> </th>
                     <th> <small>Elaboró</small> </th>
                     <th> <small>Monto</small> </th>
                     <th> <small>Fecha de solicitud</small> </th>
                     <th> <small>Fecha límite de pago</small> </th>
                     <th> <small>Conceptos</small> </th>
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
        </div> -->
     @endif
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
      input:disabled,textarea:disabled {
           background: #ffffff !important;
           border-radius: 3px;
       }
    </style>
  @if( auth()->user()->can('View history of payment') )
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
    @if( auth()->user()->can('View level zero payment notification') )
    <script src="{{ asset('js/admin/payments/request_payment_0.js')}}"></script>
    @elseif ( auth()->user()->can('View level one payment notification') )
    <script src="{{ asset('js/admin/payments/request_payment_1.js')}}"></script>
    @elseif ( auth()->user()->can('View level two payment notification') )
    <script type="text/javascript">

        var user_id = {!! json_encode(Auth::user()->id) !!};

    </script>
    <script src="{{ asset('js/admin/payments/request_payment_2.js')}}"></script>
    @elseif ( auth()->user()->can('View level three payment notification') )
    <script src="{{ asset('js/admin/payments/request_payment_3.js')}}"></script>
    @endif
  @else
    <!--NO VER-->
  @endif
@endpush
