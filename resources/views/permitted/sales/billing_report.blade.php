@extends('layouts.admin')

@section('contentheader_title')
 Reporte de facturacion
@endsection

@section('breadcrumb_title')
  
@endsection

@section('content')

    <div class="container">
     <div class="card">
       <div class="card-body">
         <div class="row">
       <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
         <div class="row">
           <form id="search_info" name="search_info" class="form-inline" method="post">
             {{ csrf_field() }}
             <div class="col-md-5">
               <div class="input-group">
                 <span class="input-group-addon"><i class="fas fa-calendar-alt fa-2x"></i></span>
                 <input id="date_to_search" type="text" class="form-control form-control-sm required" name="date_to_search">
               </div>
             </div>
             <div class="col-md-5">
                <div class="input-group">
                    <label for="currency_id" class="control-label">Moneda:<span style="color: red;">*</span></label>
                    <select id="currency_id" name="currency_id" class="form-control form-control-sm required">
                        <option value="">{{ trans('message.selectopt') }}</option>
                        @forelse ($currency as $currency_data)
                          <option value="{{ $currency_data->id  }}">{{ $currency_data->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
             </div>
             <div class="col-md-2">
               <button id="boton-aplica-filtro" type="submit" class="btn btn-sm btn-info filtrarDashboard">
                 <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
               </button>
             </div>
           </form>
         </div>
       </div>
       
       <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
         <br>
         <div class="table-responsive">
           <table id="table_billing" class="table table-striped table-bordered table-hover compact-tab w-100">
             <thead>
               <tr class="bg-primary" style="background: #088A68;">
                    <th><small>Moneda</small></th>
                    <th><small>Tipo</small></th>
                    <th><small>Numero</small></th>
                    <th><small>Cliente</small></th>
                    <th><small>Nombre del cliente</small></th>
                    <th><small>Estatus</small></th>
                    <th><small>N</small></th>
                    <th><small>Subtotal</small></th>
                    <th><small>Descuento</small></th>
                    <th><small>Imp. IVA</small></th>
                    <th><small>Imp. Ref. IVA</small></th>
                    <th><small>Imp. Ref. ISR</small></th>
                    <th><small>Imp. Total</small></th>
                    <th><small>Tipo Cambio</small></th>
                    <th><small>UUID</small></th>
                    <th><small>Dato 1</small></th>
                    <th><small>Dato 2</small></th>
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
               </tr>
             </tfoot>
           </table>
         </div>
       </div>
     </div>
       </div>
     </div>
    </div>

@endsection

@push('scripts')
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

    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>



    <script src="{{ asset('js/admin/sales/billing_report.js')}}"></script>

@endpush
