@extends('layouts.admin')

@section('contentheader_title')
@endsection

@section('contentheader_description')
@endsection

@section('breadcrumb_title')
@endsection

@section('content')
@if( auth()->user()->can('View Reg. Mensual CXC Aprob') )

      <div class="container white-box">
        <!-- Validation wizard -->
        <div class="row" id="validation">
          <div class="col-xs-12">
            <h4 class="">Mensualidades</h4>
          </div>
          <select id="aux" style="display: none">
            <option value="" selected> Elija </option>
            @forelse ($bancos as $banco)
              <option value="{{ $banco->id }}"> {{ $banco->banco }} </option>
            @empty
            @endforelse
          </select>
          <div class="col-sm-12">
            <div class="row">
              <form id="search_info" name="search_info" method="post" style="margin-top: 25px;">
                {{ csrf_field() }}
                  <div class="col-md-12">
                    <div class="form-group row">
                      <label class="col-md-1 control-label" for="month_upload_band" style="padding-left: 0px;">Periodo: </label>
                      <div class="col-md-8">
                        <div class="input-group input-daterange">
                          <input id="date_start" name="date_start"  type="text" class="form-control" value="">
                          <div class="input-group-addon">al</div>
                          <input id="date_end" name="date_end"  type="text" class="form-control" value="">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard pull-left">
                          <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                        </button>
                      </div>
                    </div>
                  </div>
              </form>
            </div>
          </div>
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mt-20">
            <div class="row form-inline">
              <label class="control-label col-md-3">Total MXN (Facturados)</label>
              <input id="total_mxn" name="total_mxn" type="text" class="form-control col-md-2" readonly>
              <label class="control-label col-md-3">Total USD (Facturados)</label>
              <input id="total_usd" name="total_usd" type="text" class="form-control col-md-2" readonly>
            </div>
          </div>
        </div>


    <div class="table-responsive no-padding mt-20">
      <table id="mens_table" name="mens_table" class="table table-hover compact-tab">
        <thead>
          <tr class="bg-primary" style="background: #3D82C2">
            <th>ID</th>
            <th>Clasificación</th>
            <th>Vertical</th>
            <th>Cadena</th>
            <th>ID_Contrato</th>
            <th>Concepto</th>
            <th>No. Mensualidad<br>Actual</th>
            <th>No. Mensualidades<br>Faltantes</th>
            <th>Meses<br>Totales</th>
            <th>Fecha_real</th>
            <th>Fecha_fin</th>
            <th>Fecha_cobro</th>
            <th>Fecha_vence</th>
            <th>Fecha_comp</th>
            <th>Fecha_fact</th>
            <th>Moneda</th>
            <!-- <th>Monto</th> -->
            <!-- <th>Descuento</th> -->
            <!-- <th>Subtotal</th> -->
            <!-- <th>IVA</th> -->
            <th>Mensualidad c/iva:</th>
            <!-- <th>TC</th> -->
            <th>Total MXN</th>
          </tr>
        </thead>
        <tbody style="background: #fff">
        </tbody>
      </table>
    </div>

    </div>


@else
  @include('default.denied')
@endif

@endsection

@push('scripts')
  @if( auth()->user()->can('View Reg. Mensual CXC Aprob') )
  <style media="screen">
    .swal-wide {
      max-height: 95vh;
      overflow: auto !important;
    }
    .compact-tab thead tr th{
     table-layout: fixed !important;
     width: 80px !important;
     white-space: pre-wrap !important;
     padding:5px !important;
     margin:0 !important;
     font-size: 14px !important;
     color:white;
    }
    .compact-tab tbody tr td{
     table-layout: fixed !important;
     width: 80px !important;
     white-space: pre-wrap !important;
     padding:10px !important;
     margin:0 !important;
     font-size: 14px !important;
    }
    .aux {
      font-size: 13px !important;
      padding: 0px 5px !important;
      white-space: nowrap !important;
      height: 30px !important;
    }
  </style>
  <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
  <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>

  <script src="{{ asset('/plugins/momentupdate/moment-with-locales.js')}}"></script>
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js') }}" type="text/javascript"></script>

  <!-- FormValidation -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extras-margins-padding.css')}}" >
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
  <script type="text/javascript" src="{{asset('js/admin/contract/contract_fact.js')}}"></script>
  @else
    @include('default.denied')
  @endif
@endpush
