@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View trial balance') )
    Balance General 2019
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
       <div class="">
         <div class="card">
           <div class="card-body">
             <div class="row">
           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <div class="row">
                <form id="validation" name="validation" class="form-inline" method="post">
                  {{ csrf_field() }}
                  
                </form>
              </div>
           </div>

           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
             <div class="table-responsive">
               <table id="table_balance" class="table table-striped table-bordered table-hover compact-tab w-100">
                 <thead>
                   <tr class="bg-dark font-weight-bold" style="background: #088A68;">
                     <th colspan="2"> <small>miles de Pesos (MxN)</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>Ene</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>Feb</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>Mar</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>Abr</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>May</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>Jun</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>Jul</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>Ago</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>Sep</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>Oct</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>Nov</small> </th>
                     <th style="background-color:#34BFCC !important"> <small>Dic</small> </th>
                   </tr>
                   <tr>
                    <th class="bg-secondary" colspan="14">ACTIVO</th>
                   </tr>
                   <tr>
                    <th class="bg-warning" colspan="14">Circulante</th>
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
    
    
  @else
    <!--NO VER-->
  @endif
@endpush
