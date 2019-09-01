@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View cfdi exchange rate') )
    {{ trans('invoicing.exchange_rate') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View cfdi exchange rate') )
    {{ trans('invoicing.exchange_rate') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View cfdi exchange rate') )
  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <p class="mt-2 card-title">Historico de tipo de cambio de dólar(fix) obtenido desde la api de BANXICO.</p>
          <div class="d-flex justify-content-center pt-3"></div>

          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="exchange_rate" name='exchange_rate' class="table table-striped table-sm border" style="width:100%; font-size: 10px;">
                  <thead>
                    <tr>
                      <th>Fecha de actualización</th>
                      <th>T.D.C.</th>
                      <th>Moneda</th>
                      <th>Serie</th>
                      <th>T.D.C modificado</th>
                      <th>Modificó</th>
                      <th></th>
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
  </div>
  <!-- Editar tipo de cambio-->
  <div id="modal-Edit-Exchange" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditexchange" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaleditexchange">Editar tipo de cambio</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="editexchange" name="editexchange" class="forms-sample" action="">
                {{ csrf_field() }}
                <input class="form-control" type="hidden" placeholder="" id="id_exchange" name="id_exchange" value="">

                <div class="form-group row">
                  <label for="tipo_cambio" class="col-sm-4 col-form-label">Tipo de cambio<span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm required" id="tipo_cambio" name="tipo_cambio" placeholder="Tipo de cambo">
                  </div>
                </div>

                <button type="submit" class="btn btn-navy"><i class="fas fa-check" style="margin-right: 4px;"></i> {{ trans('message.editar') }}</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View cfdi exchange rate') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <script src="{{ asset('js/admin/base/exchange_rate.js')}}"></script>

    <style media="screen">
      .select2-selection__rendered {
        line-height: 44px !important;
        padding-left: 20px !important;
      }
      .select2-selection {
        height: 42px !important;
      }
      .select2-selection__arrow {
        height: 36px !important;
      }
      .toggle.btn {
        min-width: 5rem !important;
      }
    </style>
    @else
    @endif
@endpush
