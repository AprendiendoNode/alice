@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View customers invoices') )
    {{ trans('invoicing.customers_invoices') }} Masiva
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customers invoices') )
    {{ trans('invoicing.customers_invoices') }} Masiva
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  <div id="modal-history" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalhistory" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalhistory">Historial de pagos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive table-data">
                <table id="payment_history_all" name="payment_history_all" class="table table-striped table-hover table-condensed">
                  <thead>
                    <tr>
                      <th>Contrato anexo</th>
                      <th>Hotel</th>
                      <th>Id ubicacion</th>
                      <th>Monto</th>
                      <th>Moneda</th>
                      <th>Valor TC</th>
                      <th>Iva general</th>
                      <th>Fecha real</th>
                      <th>Fecha inicio programada</th>
                      <th>Fecha fin programada</th>
                      <th>Numero de meses</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>


  @if( auth()->user()->can('View customers invoices') )

    <div class="row">
      <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Busqueda de contratos en base a su moneda</h5>
            <form id="search_info" name="search_info" method="post">
              {{ csrf_field() }}
              <div class="row">
                <div class="col">
                    <label for="currency_id" class="control-label">Moneda:<span style="color: red;">*</span></label>
                    <select id="currency_id" name="currency_id" class="form-control form-control-sm required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($currency as $currency_data)
                        <option value="{{ $currency_data->id  }}">{{ $currency_data->name }}</option>
                      @empty
                      @endforelse
                    </select>
                </div>
                <div class="col my-2">
                  <button type="submit" class="btn btn-danger mt-3">Generar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Datos requeridos para la facturacion masiva</h5>
            <form id="form" name="form" method="post">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="currency_value">TC:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="currency_value" name="currency_value" style="padding: 0.875rem 0.5rem;">
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="date">Fecha actual:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="date" name="date">
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="date_due">Fecha Vencimiento:</label>
                    <input type="text" class="form-control form-control-sm" id="date_due" name="date_due" value="">
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="payment_term_id" class="control-label">Termino de pago:<span style="color: red;">*</span></label>
                    <select id="payment_term_id" name="payment_term_id" class="form-control required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($payment_term as $payment_term_data)
                      <option value="{{ $payment_term_data->id }}"> {{ $payment_term_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="salesperson_id" class="control-label">Vendedor:<span style="color: red;">*</span></label>
                    <select id="salesperson_id" name="salesperson_id" class="form-control form-control-sm required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($salespersons as $salespersons_data)
                        <option value="{{ $salespersons_data->id  }}">{{ $salespersons_data->name }}</option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="payment_way_id" class="control-label">Forma de pago:<span style="color: red;">*</span></label>
                    <select id="payment_way_id" name="payment_way_id" class="form-control form-control-sm required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($payment_way as $payment_way_data)
                      <option value="{{ $payment_way_data->id }}"> {{ $payment_way_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="payment_method_id" class="control-label">Metodo de pago:<span style="color: red;">*</span></label>
                    <select id="payment_method_id" name="payment_method_id" class="form-control form-control-sm required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($payment_methods as $payment_methods_data)
                      <option value="{{ $payment_methods_data->id }}"> {{ $payment_methods_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="cfdi_use_id" class="control-label">Uso de cfdi:<span style="color: red;">*</span></label>
                    <select id="cfdi_use_id" name="cfdi_use_id" class="form-control form-control-sm required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($cfdi_uses as $cfdi_uses_data)
                      <option value="{{ $cfdi_uses_data->id }}"> {{ $cfdi_uses_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="branch_office_id" class="control-label">Sucursal:<span style="color: red;">*</span></label>
                    <select id="branch_office_id" name="branch_office_id" class="form-control form-control-sm required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($sucursal as $sucursal_data)
                        <option value="{{ $sucursal_data->id  }}">{{ $sucursal_data->name }}</option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-md-9 col-xs-12">
                  <div class="form-group">
                    <label for="reference">Referencia:</label>
                    <input type="text" class="form-control form-control-sm" id="reference" name="reference" value="">
                  </div>
                </div>
              </div>

              <div class="row my-4">
                <div class="col">
                  <div class="form-group">
                    <label for="total">Total seleccionado:</label>
                    <input type="text" class="form-control form-control-sm" name="total" id="total" readonly>
                  </div>
                  <div class="table-responsive">
                    <table id="table_contracts" class="table table-condensed table-hover table-bordered table-striped mt-5">
                      <thead style="background-color: #C5CFCF;">
                        <tr>
                          <th></th>
                          <th>Clasificacion</th>
                          <th>Vertical</th>
                          <th>Cadena</th>
                          <th>Contrato maestro</th>
                          <th>Monto</th>
                          <th>Cliente</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col my-2">
                  <button type="submit" class="btn btn-danger mt-3">Timbrar</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>



  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View customers invoices') )
  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
  <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
  <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>

  <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>

  <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>


  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>
  <link rel="stylesheet" href="{{ asset('css/bootstrap-editable.css') }}" type="text/css" />
  <script src="{{ asset('js/bootstrap-editable.js')}}"></script>
  {{-- <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script> --}}
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>

  

  <script src="{{ asset('js/admin/sales/fact_masiva.js')}}"></script>

  <style>
  .datepicker td, .datepicker th {
        width: 1.5em !important;
        height: 1.5em !important;
    }

    #items th, #items td {
		padding: .75rem 0.7375rem;
		vertical-align: top;
		border-top: 1px solid #f3f3f3;
	}
  </style>
  @else
  @endif
@endpush
