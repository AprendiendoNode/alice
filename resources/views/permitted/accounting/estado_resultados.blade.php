@extends('layouts.admin')

@section('contentheader_title')
  Estado de resultados
@endsection

@section('contentheader_description')

@endsection

@section('breadcrumb_title')
  Estado de resultados
@endsection

@section('content')

  <div class="card mb-4">
      <div class="card-body">
        {{-- <h5 class="card-title"><ins>Nomina Mensual</ins></h5> --}}
        <form id="search" name="search" class="forms-sample" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-3">
              <div class="form-group mb-3">
                  <label>Elija el periodo</label>
                  <input type="text" class="input-sm form-control required" id="period_month" name="period_month" placeholder="Ingrese un periodo" />
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <div class="btn-group" role="group" aria-label="Basic example" style="margin-top: 1.8rem !important;">
                  <button type="submit" class="btn btn-primary default">Generar</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <div class="row my-4">
          <div class="col-lg-12 col-md-12 mb-4">
            <div class="table-responsive">
              <table id="all_month" class="table tablita stripe row-border order-column">
                <thead>
                  <tr>
                    <th>Cuenta Movimiento</th>
                    <th>Nombre</th>
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
                    <th>%</th>
                    <th class="text-left">Con CR y RD</th>
                    <th>%</th>
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
@endsection

@push('scripts')

  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
  <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>

  <script src="{{ asset('js/admin/accounting/estado_resultados.js')}}"></script>
  <style media="screen">
    .tablita{
      display: table;
      border-collapse: separate !important;
      border-spacing: 0 !important;
      /*Se deja en 0 para evitar tu problema de que se vean atras*/
      border-color: grey !important;
    }
    .azul {
      background-color: #0B93F6 !important;
      color: #fff !important;
    }
    .sumita {
      background: gray !important;
      /* background-color: red !important; */
      font-weight: bold !important;
      color: blue !important;
    }
    .red{
      font-weight: bold !important;
    }
    .negritas_font {
      font-weight: bold !important;
    }
    table.dataTable.table-striped.DTFC_Cloned tbody tr:nth-of-type(odd) {
          background-color: #F3F3F3 !important;
      }
      table.dataTable.table-striped.DTFC_Cloned tbody tr:nth-of-type(even) {
          background-color: white !important;
      }
  </style>
@endpush
