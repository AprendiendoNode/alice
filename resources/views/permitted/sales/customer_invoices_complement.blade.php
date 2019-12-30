@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View customers invoices show') )
    <!--{{ trans('invoicing.customers_invoices_show') }}-->
    Complementos de pago
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customers invoices show') )
    <!--{{ trans('invoicing.customers_invoices_show') }}-->
    Complementos de pago
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View customers invoices show') )
    <form id="form" name="form" enctype="multipart/form-data">
      {{ csrf_field() }}
    </form>

    <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive table-data table-dropdown">
            <table id="table_complements" name='table_filter_fact' class="table table-striped table-hover table-condensed">
              <thead>
                <tr class="mini text-center">
                    <th id="nocheck"class="text-center actions" width="5%">@lang('general.column_actions')</th>
                    <th class="text-center">
                      {{  __('customer_invoice.column_name')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_date')}}
                    </th>
                    <th class="text-center">
                        @lang('customer_invoice.column_uuid')
                    </th>
                    <th class="text-left">
                        {{__('customer_invoice.column_customer')}}
                    </th>
                    <!--<th class="text-left">
                        {{__('customer_invoice.column_salesperson')}}
                    </th>-->
                    <!--<th class="text-center">
                        {{__('customer_invoice.column_date_due')}}
                    </th>-->
                    <th class="text-center">
                        {{__('customer_invoice.column_currency')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_amount_total')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_balance')}}
                    </th>
                    <!--<th class="text-center">
                        {{__('customer_invoice.column_mail_sent')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_status')}}
                    </th> -->
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
<div class="modal fade" id="ModalDataOne" tabindex="-1" role="dialog" aria-labelledby="Title_Pago_one" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Title_Pago_one"> Pago en una sola exhibición</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ..
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalDataDif" tabindex="-1" role="dialog" aria-labelledby="Title_Pago_Dif" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="Title_Pago_Dif">Pago en parcialidades o diferido</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form id="form_c" name="form" enctype="multipart/form-data">
      {{ csrf_field() }}
    <div class="modal-body">
      <div class="row">
        <div class="col-md-1">
          <h5 class="mt-2">Rfc:</h5>
        </div>
        <div class="col-md-4">
          <input class="form-control input-sm" type="text" name="" value="{{ $companyname }}" readonly>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-1">
          <h5>Razón Social:</h5>
        </div>
        <div class="col-md-4">
          <input class="form-control input-sm" type="text" name="" value="{{ $companyrfc }}" readonly>
        </div>
      </div>
      <div class="col-md-1"></div>
      <div class="row mt-5">

        <div class="col-md-4 col-xs-12">
          <div class="form-group">
            <label for="branch_office_id" class="control-label">Sucursal:<span style="color: red;">*</span></label>
            <select id="branch_office_id" name="branch_office_id" class="form-control required" style="width:100%;">
              <option value="">{{ trans('message.selectopt') }}</option>
              @forelse ($sucursal as $sucursal_data)
                <option value="{{ $sucursal_data->id  }}">{{ $sucursal_data->name }}</option>
              @empty
              @endforelse
            </select>
          </div>
        </div>

        <div class="col-md-4 col-xs-12">
          <div class="form-group">
            <label for="date">Fecha actual:<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="date" name="date">
          </div>
        </div>

        <div class="col-md-4 col-xs-12">
          <div class="form-group">
            <label for="payment_way_id" class="control-label">Forma de pago:<span style="color: red;">*</span></label>
            <select id="payment_way_id" name="payment_way_id" class="form-control required" style="width:100%;">
              <option value="">{{ trans('message.selectopt') }}</option>
              @forelse ($payment_way as $payment_way_data)
              <option value="{{ $payment_way_data->id }}"> {{ $payment_way_data->name }} </option>
              @empty
              @endforelse
            </select>
          </div>
        </div>


      </div>
      <div class="row mt-5">
        <div class="col-md-4 col-xs-12">
          <div class="form-group">
            <label for="currency_id" class="control-label">Moneda:<span style="color: red;">*</span></label>
            <select id="currency_id" name="currency_id" class="form-control required" disabled style="width:100%;">
              <option value="">{{ trans('message.selectopt') }}</option>
              @forelse ($currency as $currency_data)
                <option value="{{ $currency_data->id  }}">{{ $currency_data->name }}</option>
              @empty
              @endforelse
            </select>
          </div>
        </div>
        <div class="col-md-4 col-xs-12">
          <div class="form-group">
            <label for="currency_value">TC:<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="currency_value" name="currency_value" disabled style="padding: 0.875rem 0.5rem;">
          </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="form-group row">
                <label for="cfdi_relation_id" class="control-label">Tipo de relación:<span style="color: red;">*</span></label>
                    <select id="cfdi_relation_id" name="cfdi_relation_id" class="form-control form-control-sm" style="width: 100%;">
                        <option value="">{{ trans('message.selectopt') }}</option>
                        @forelse ($cfdi_relations as $cfdi_relations_data)
                        <option value="{{ $cfdi_relations_data->id }}"> [{{ $cfdi_relations_data->code}}]{{ $cfdi_relations_data->name }} </option>
                        @empty
                        @endforelse
                    </select>

            </div>
        </div>


      </div>

      <div class="row mt-2">
        <div class="table-responsive table-data table-dropdown">
          <table id="table_selected_complements" name='table_filter_fact' class="table table-striped table-hover table-condensed">
            <thead class="">
              <tr class="mini text-center">
                  <th class="text-center" width="5%">@lang('general.column_actions')</th>
                  <th class="text-center">
                    {{  __('customer_invoice.column_name')}}
                  </th>
                  <th class="text-center">
                      {{__('customer_invoice.column_date')}}
                  </th>
                  <th class="text-center">
                      @lang('customer_invoice.column_uuid')
                  </th>
                  <th class="text-left">
                      {{__('customer_invoice.column_customer')}}
                  </th>
                  <!--<th class="text-left">
                      {{__('customer_invoice.column_salesperson')}}
                  </th>-->
                  <!--<th class="text-center">
                      {{__('customer_invoice.column_date_due')}}
                  </th>-->
                  <th class="text-center">
                      {{__('customer_invoice.column_currency')}}
                  </th>
                  <th class="text-center">
                      Total Factura
                  </th>
                  <th class="text-center">
                      {{__('customer_invoice.column_balance')}}
                  </th>
                  <th>Cantidad pagada</th>
                  <!--<th class="text-center">
                      {{__('customer_invoice.column_mail_sent')}}
                  </th>
                  <th class="text-center">
                      {{__('customer_invoice.column_status')}}
                  </th> -->
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <div class="row mt-2 md-2">
        <div class="col-md-4 col-xs-12">
          <div class="form-group">
            <label for="mount_total">Total:</label>
            <input type="text" class="form-control" id="mount_total" name="mount_total" style="padding: 0.875rem 0.5rem;" readonly>
          </div>
        </div>

        <div class="col-md-4 col-xs-12">
          <div class="form-group">
            <label for="mount_saldo">Saldo pendiente:</label>
            <input type="text" class="form-control" id="mount_saldo" name="mount_saldo" style="padding: 0.875rem 0.5rem;" readonly>
          </div>
        </div>

        <div class="col-md-4 col-xs-12">
          <div class="form-group">
            <label for="mount_pagado">Monto pagado:</label>
            <input type="text" class="form-control" id="mount_pagado" value="0" name="mount_pagado" style="padding: 0.875rem 0.5rem;" readonly>
          </div>
        </div>

      </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      <button id="send_complement"type="button" class="btn btn-primary">Guardar Cambios</button>
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
  @if( auth()->user()->can('View customers invoices show') )
  <style media="screen">

      input[type=number]::-webkit-inner-spin-button,
      input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      input[type=number] { -moz-appearance:textfield; }

     .editor-wrapper {
      min-height: 250px;
      background-color: #fff;
      border-collapse: separate;
      border: 1px solid #ccc;
      padding: 4px;
      box-sizing: content-box;
      box-shadow: rgba(0,0,0,.07451) 0 1px 1px 0 inset;
      overflow: scroll;
      outline: 0;
      border-radius: 3px;
     }
     .editor_quill {
      margin-bottom: 5rem !important;
     }

    .white {background-color: #ffffff;}
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
    th { font-size: 12px !important; }
    td { font-size: 10px !important; }

  </style>

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
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />

  <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
  <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>
  <!-- Main Quill library -->
  <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
  <!-- Theme included stylesheets -->
  <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <script src="{{ asset('js/admin/sales/complement.js?v=1.0.1')}}"></script>
  @else
  @endif
@endpush
