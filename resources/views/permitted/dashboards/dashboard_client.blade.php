@extends('layouts.admin')

@section('contentheader_title')
@if( auth()->user()->can('View banks') )
DASHBOARD POR CLIENTE MACHEO
@else
{{ trans('message.denied') }}
@endif
@endsection

@section('breadcrumb_title')
@if( auth()->user()->can('View banks') )
DASHBOARD POR CLIENTE MACHEO
@else
{{ trans('message.denied') }}
@endif
@endsection

@section('content')
  @if( auth()->user()->can('View banks') )
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tipo: </label>
                  <div class="col-sm-10">
                    <select id="SelectTipo" name="SelectTipo" class="form-control form-control-sm required" style="width: 100%;">
                      <option value="" selected> Elija </option>
                      <option value="cadena"> Por cadena </option>
                      <option value="sitio"> Por sitio </option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row row_cadena">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Cadenas</label>
                  <div class="col-sm-10">
                    <select id="InputCadena" name="InputCadena" class="form-control form-control-sm" style="width: 100%;">
                      <option value="" selected> Elija </option>
                      <option value="cadena1"> cadena1 </option>
                    </select>
                  </div>
                </div>
              </div>
              <!--
              <div class="col-md-6">
                <div class="form-group row">
                  <button type="submit" class="btn btn-outline-primary"> Generar </button>
                  &nbsp;&nbsp;&nbsp;
                  <button type="button" class="btn btn-outline-danger"> Cancelar</button>
                </div>
              </div>
              -->
            </div>
            <div class="row row_hotel">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Hotel</label>
                  <div class="col-sm-10">
                    <select id="InputHotel" name="InputHotel" class="form-control form-control-sm" style="width: 100%;">
                      <option value="" selected> Elija </option>
                      <option value="hotel1"> hotel1 </option>
                    </select>
                  </div>
                </div>
              </div>
              <!--
              <div class="col-md-6">
                <div class="form-group row">
                  <button type="submit" class="btn btn-outline-primary"> Generar </button>
                  &nbsp;&nbsp;&nbsp;
                  <button type="button" class="btn btn-outline-danger"> Cancelar</button>
                </div>
              </div>
              -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">

            <h4 class="card-title">Vencimiento de contratos</h4>
            <div class="row">
              <input type="hidden" id="data_c" name="data_c" value="">
              <input type="hidden" id="data_h" name="data_h" value="">

              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label text-uppercase font-weight-bold">#Num. Min</label>
                  <div class="col-sm-6">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" id="InputNumMinMeses" name="InputNumMinMeses" readonly>
                      <div class="input-group-append">
                        <button class="btn btn-danger min_meses" type="button"><i class="fas fa-eye"></i> </button>
                      </div>
                    </div>
                  </div>
                  <label class="col-sm-3 col-form-label text-uppercase font-weight-bold">de meses.</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label text-uppercase font-weight-bold">#Num. Max</label>
                  <div class="col-sm-6">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" id="InputNumMaxMeses" name="InputNumMaxMeses" readonly>
                      <div class="input-group-append">
                        <button class="btn btn-danger max_meses" type="button"><i class="fas fa-eye"></i> </button>
                      </div>
                    </div>
                  </div>
                  <label class="col-sm-3 col-form-label text-uppercase font-weight-bold">de meses.</label>
                </div>
              </div>

              <div class="col-md-12">
                <table class="mt-2 mb-4 collapse_style table table-items table-condensed table-hover table-bordered table-striped jambo_table" id="items_reconciled" style="min-width: 100px;">
                  <thead>
                    <tr>
                      <th class="text-left">ID Contrato</th>
                      <th class="text-left">Clasificación</th>
                      <th class="text-left">Vertical</th>
                      <th class="text-left">Cadena</th>
                      <th class="text-left">No.Meses</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!--
                    <tr>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                    </tr>
                    <tr>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                      <td class="tg-0lax">DATA</td>
                    </tr>
                    -->
                  </tbody>
                </table>
              </div>

            </div>

            <h4 class="card-title">Facturación</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-uppercase font-weight-bold"> MXN</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="InputFactMxn" name="InputFactMxn" readonly>
                  </div>
                  <label class="col-sm-3 col-form-label text-uppercase font-weight-bold"></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-uppercase font-weight-bold"> USD</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="InputFactUsd" name="InputFactUsd" readonly>
                  </div>
                  <label class="col-sm-3 col-form-label text-uppercase font-weight-bold"></label>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  @else
  @endif
@endsection

@push('scripts')
@if( auth()->user()->can('View banks') )
  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
  <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

  <script src="{{ asset('js/admin/dashboards/dashboard_client.js')}}"></script>

  <style media="screen">
    .collapse_style {
        border-collapse: collapse !important;
    }
    .collapse_style thead th {
      padding: 0.8rem 0.9rem !important;
    }
    .collapse_style td {
      padding: 0.8rem 0.9rem !important;
    }
    .select2-container--bootstrap .select2-selection--single {
      height: 42px !important;
      line-height: 42px !important;
      padding: 2px 24px 8px 12px !important;
    }
  </style>
@else
@endif
@endpush
