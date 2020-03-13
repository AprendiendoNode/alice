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
            <h4>Balanza de comprobación</h4>
             <div class="row">
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                  <div class="row">
                    <form id="form-balance" class="form-inline" method="post">
                      {{ csrf_field() }}
                      <div class="col-md-8 col-xs-12">
                        <div class="form-group" id="date_from">
                          <div class="form-group row">
                            <label for="date_month" class="col-sm-3 col-form-label"><span style="color: red;">*</span>Periodo: </label>
                            <div class="col-sm-9">
                              <input required type="text" class="form-control form-control-sm required datepickermonth" id="date_month" name="date_month">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-xs-12">
                        <button id=" mt-3" type="submit" class="btn btn-warning filtrarDashboard ml-2">
                           Buscar periodo
                        </button>
                      </div>
                    </form>
                  </div>
              </div>

           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10 mt-3">
             <div class="table-responsive">
               <table id="table_balance" class="table table-striped table-bordered table-hover">
                 <thead>
                   <tr class="bg-secondary" style="background: #088A68;">
                     <th> <small>CUENTA</small> </th>
                     <th> <small>NAT.</small> </th>
                     <th> <small>NOMBRE</small> </th>
                     <th> <small>SALDO INICIAL</small> </th>
                     <th> <small>CARGOS</small> </th>
                     <th> <small>ABONOS</small> </th>
                     <th> <small>SALDO FINAL</small> </th>
                   </tr>
                 </thead>
                 <tbody>
                 </tbody>
                 
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

       #table_balance tbody tr td {
        padding: 0.2rem 0.2rem;
        height: 30px !important;
      }

      #table_balance thead tr th{
          padding: 0.2rem 0.5rem;
          height: 38px !important;
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
    
    <script src="{{ asset('js/admin/accounting/trial_balance.js?v=1.0')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
