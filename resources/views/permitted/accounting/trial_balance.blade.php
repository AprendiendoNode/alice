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
                    <form id="validation" name="validation" class="form-inline" method="post">
                      {{ csrf_field() }}
                      <div class="col-md-3 col-xs-12">
                        <div class="form-group" id="date_from">
                          <label class="control-label" for="filter_date_from">
                            Fecha inicial:
                          </label>
                          <div class="input-group mb-3">
                            <input type="text"  datas="filter_date_from" id="filter_date_from" name="filter_date_from" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('first day of this month')) }}" required>
                            <div class="input-group-append">
                              <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 col-xs-12">
                        <div class="form-group" id="date_from">
                          <label class="control-label" for="filter_date_to">
                            Fecha final:
                          </label>
                          <div class="input-group mb-3">
                            <input type="text"  datas="filter_date_to" id="filter_date_to" name="filter_date_to" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('last day of this month')) }}" required>
                            <div class="input-group-append">
                              <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <button id="boton-aplica-filtro mt-3" type="button" class="btn btn-warning filtrarDashboard ml-2">
                        <i class="fas fa-search-dollar"></i>  Buscar periodo
                      </button>
                    </form>
                  </div>
              </div>

           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
             <div class="table-responsive">
               <table id="table_balance" class="table table-striped table-bordered table-hover compact-tab w-100">
                 <thead>
                   <tr class="bg-secondary" style="background: #088A68;">
                     <th> <small>Cuenta</small> </th>
                     <th> <small>Nat.</small> </th>
                     <th> <small>Nombre</small> </th>
                     <th> <small>Saldo inicial</small> </th>
                     <th> <small>Cargos</small> </th>
                     <th> <small>Abonos</small> </th>
                     <th> <small>Saldo final</small> </th>
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

       #table_balance tbody tr td {
        padding: 0.2rem 0.5rem;
        height: 38px !important;
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
    
    <script src="{{ asset('js/admin/accounting/trial_balance.js?v=0.0.0')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
