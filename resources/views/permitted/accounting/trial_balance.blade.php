@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View trial balance') )
    Balanza
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View trial balance') )
    <!-- <b>de comprobación</b> -->
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View trial balance') )
    Balanza de comprobación
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View trial balance') )
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
           </div>

           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
             <div class="table-responsive">
               <table id="table_balance" class="table table-striped table-bordered table-hover compact-tab w-100">
                 <thead>
                   <tr class="bg-primary" style="background: #088A68;">
                     <th> <small>cliente</small> </th>
                     <th> <small>taxid</small> </th>
                     <th> <small>numid</small> </th>
                     <th> <small>cc</small> </th>
                     <th> <small>currencies</small> </th>
                     <th> <small>customer_id</small> </th>
                     <th> <small>monto descuento</small> </th>
                     <th> <small>monto s/impuesto</small> </th>
                     <th> <small>monto impuesto</small> </th>
                     <th> <small>monto ret</small> </th>
                     <th> <small>subtotal</small> </th>
                     <th> <small>total</small> </th>
                   </tr>
                 </thead>
                 <tbody>
                 </tbody>
                 <tfoot id='tfoot_average'>
                   <tr>
                     <!-- <th></th> -->
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
      input:disabled,textarea:disabled {
           background: #ffffff !important;
           border-radius: 3px;
       }
    </style>
  @if( auth()->user()->can('View trial balance') )
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>

    <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
    <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
    
    <script src="{{ asset('js/admin/accounting/trial_balance.js?v=0.0.0')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
