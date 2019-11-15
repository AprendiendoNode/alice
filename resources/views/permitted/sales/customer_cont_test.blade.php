@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View customers invoices') )
    {{ trans('invoicing.customers_invoices') }} Contratos
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customers invoices') )
    {{ trans('invoicing.customers_invoices') }} Contratos
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View customers invoices') )
  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
            <form>
              {{ csrf_field() }}
              <div class="row">
                <div class="col">  
                  <label for="date_due">Fecha:</label>
                  <input type="text" class="form-control form-control-sm" id="date" name="date" value="">      
                </div>
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
                <div class="col">
                    <label for="currency_value">TC:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="currency_value" name="currency_value" style="padding: 0.875rem 0.5rem;">    
                </div>
                <div class="col">
                  <button class="btn btn-danger mt-3">Generar</button>
                </div>
                     
              </div>
              <div class="row mt-3">
                <div class="col">
                    <label for="branch_office_id" class="control-label">Sucursal:<span style="color: red;">*</span></label>
                    <select id="branch_office_id" name="branch_office_id" class="form-control form-control-sm required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($sucursal as $sucursal_data)
                        <option value="{{ $sucursal_data->id  }}">{{ $sucursal_data->name }}</option>
                      @empty
                      @endforelse
                    </select>     
                </div> 
                  <div class="col">
                      <label for="date_now">Fecha de actual:</label>
                      <input type="text" class="form-control form-control-sm" id="date_now" name="date_now" value="">       
                  </div>
                  <div class="col">
                      <label for="date_due">Fecha de vencimiento:</label>
                      <input type="text" class="form-control form-control-sm" id="date_due" name="date_due" value="">       
                  </div>
                  <div class="col">
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
            </form>
        </div>
      </div>
    </div>
  </div>

  <!-----------------TABLA------------------->
  <div class="row">
    <div class="col">
      <div class="card">
        <table id="table_contracts" class="table table-condensed table-hover table-bordered table-striped mt-5">
          <thead style="background-color: #C5CFCF;">
            <tr>
                <th></th>
                <th>Cadena</th>
                <th>Contrato maestro</th>
                <th>Monto</th>
                <th>Cliente</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
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

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>

  <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

  {{-- <link href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"> --}}
  {{-- <script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script> --}}
  {{-- <script src="{{ asset('js/admin/sales/customers_invoices.js')}}"></script> --}}
  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

  
  <script type="text/javascript">
      $(function(){
        moment.locale('es');
      })
  </script>

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
