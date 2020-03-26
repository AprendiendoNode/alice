@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View customer payments') )
    Complemento de pago
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customer payments') )
    Complemento de pago
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View customer payments') )
    <div class="row">
      <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
          <div class="card-body">
            <form id="form" name="form" enctype="multipart/form-data">
              {{ csrf_field() }}
              <!-- input hidden -->
              <input type="hidden"
                  id="amount_reconciled"
                  name="amount_reconciled"
                  value="{{ old('amount_reconciled',0) }}">
              <!-- input hidden -->
              <div class="row">
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="date">Fecha actual:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="date" name="date">
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="date_payment">Fecha de cobro:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="date_payment" name="date_payment">
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
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="reference">Número de operación</label>
                    <input type="text" class="form-control form-control-sm" id="reference" name="reference" value="">
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="payment_way_id" class="control-label">Forma de pago:<span style="color: red;">*</span></label>
                    <select id="payment_way_id" name="payment_way_id" class="form-control form-control-sm required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($payment_way as $payment_way_data)
                      <option value="{{ $payment_way_data->id }}"> [{{ $payment_way_data->code }}] {{ $payment_way_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <label for="sel_estatus"> Clientes:
                      <span style="color: red;">*</span>
                    </label>
                    <div id="cont_customer_id" class="input-group mb-3">
                      <select datas="customer_id" id="customer_id" name="customer_id" class="form-control form-control-sm required">
                        <option value="" selected>{{ trans('message.selectopt') }}</option>
                        @forelse ($customer as $customer_data)
                          <option value="{{ $customer_data->id  }}">{{ $customer_data->name }}</option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                </div>

                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="company_bank_account_id" class="control-label">Cuenta beneficiaria:</label>
                    <select id="company_bank_account_id" name="company_bank_account_id" class="form-control form-control-sm" style="width:100%;" disabled>
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($company_bank_accounts as $company_bank_accounts_data)
                        <option value="{{ $company_bank_accounts_data->id  }}">{{$company_bank_accounts_data->banco}} [{{ $company_bank_accounts_data->account_number }}] {{$company_bank_accounts_data->nombre_cuenta}} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="customer_bank_account_id" class="control-label">Cuenta ordenante/cliente:</label>
                    <select id="customer_bank_account_id" name="customer_bank_account_id" class="form-control form-control-sm" style="width:100%;" disabled>
                      <option value="">{{ trans('message.selectopt') }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="currency_id" class="control-label">Moneda:<span style="color: red;">*</span></label>
                    <select id="currency_id" name="currency_id" class="form-control form-control-sm required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($currency as $currency_data)
                        <option value="{{ $currency_data->id  }}">{{ $currency_data->name }}</option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="currency_value">TC:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="currency_value" name="currency_value" required>
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="amount">Monto:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="amount" name="amount" required>
                  </div>
                </div>

              </div>
              <!----------------------------------------------------------->
              <div class="row mt-5">
                <div class="col-md-12">
                  <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-product-tab" data-toggle="tab" href="#nav-product" role="tab" aria-controls="nav-product" aria-selected="true">Aplicar a facturas</a>
                      <a class="nav-item nav-link" id="nav-facturas-na-tab" data-toggle="tab" href="#nav-facturas-na" role="tab" aria-controls="nav-facturas-na" aria-selected="false">Facturas sin registro</a>
                      <a class="nav-item nav-link" id="nav-spei-tab" data-toggle="tab" href="#nav-spei" role="tab" aria-controls="nav-spei" aria-selected="false">SPEI</a>
                      <a class="nav-item nav-link" id="nav-cfdi-tab" data-toggle="tab" href="#nav-cfdi" role="tab" aria-controls="nav-cfdi" aria-selected="false">CFDI's Relacionados</a>
                    </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                    <!-------------------------------------------------------------------------->
                    <div class="tab-pane fade show active" id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab">
                      <div class="row">
                        <div class="col-md-12 col-xs-12">
                          <div class="card card-body bg-light my-4" style="margin: 10px 0 20px 0; padding: 5px 19px;">
                            <p class="text-center" style="margin: 0;">
                              @lang('customer_payment.entry_amount'): <span id="reconciled_txt_amount">$0.00</span>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              @lang('customer_payment.text_reconciled'): <span id="reconciled_txt_amount_reconciled">$0.00</span>
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              @lang('customer_payment.text_per_reconciled'): <span id="reconciled_txt_amount_per_reconciled">$0.00</span>
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 col-xs-12">
                          <div class="table-responsive">
                            <table class="table table-items table-condensed table-hover table-bordered table-striped jambo_table"
                            id="items_reconciled" style="min-width: 100px;">
                              <thead>
                                <tr>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_name')</th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_date')</th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_date_due')</th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_currency')</th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_amount_total')</th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_balance')
                                    <span id="info_reconciled_balance_currency"></span>
                                  </th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_currency_value')</th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_amount_reconciled')</th>
                                </tr>
                              </thead>
                              <tbody>
                              <!-- Items -->
                              @php
                                $item_reconciled_row = 0;
                                $items_reconciled = (empty(old('item_reconciled')) ? [] : old('item_reconciled'));
                              @endphp
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------->
                    <div class="tab-pane fade show" id="nav-facturas-na" role="tabpanel" aria-labelledby="nav-facturas-na-tab">
                      <div class="row">
                        <div class="col-md-12 col-xs-12">
                          <div class="table-responsive">
                            <table class="table table-items table-condensed table-hover table-bordered table-striped jambo_table mt-4"
                             id="items_manual_reconciled" style="min-width: 100px;">
                              <thead>
                                <tr>
                                  <th class="text-center">@lang('general.column_actions')</th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_uuid')<span class="required text-danger">*</span></th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_serie')</th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_folio')</th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_currency')<span class="required text-danger">*</span></th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_currency_value')<span class="required text-danger">*</span></th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_payment_method')<span class="required text-danger">*</span></th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_number_of_payment')<span class="required text-danger">*</span></th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_last_balance')<span class="required text-danger">*</span></th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_amount_reconciled2')<span class="required text-danger">*</span></th>
                                  <th class="text-center">@lang('customer_payment.column_reconciled_currenct_balance')<span class="required text-danger">*</span></th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                    $item_manual_reconciled_row = 1;
                                    $items_manual_reconciled = (empty(old('item_manual_reconciled')) ? [] : old('item_manual_reconciled'));
                                @endphp
                                <tr id="add_item_manual_reconciled">
                                    <td class="text-center">
                                        <button type="button" onclick="addItemManualReconciled();"
                                                class="btn btn-xs btn-primary"
                                                style="margin-bottom: 0; padding: 1px 3px;">
                                            <i class="fa fa-plus" style="font-size: 1rem;"></i>
                                        </button>
                                    </td>
                                    <td class="text-right" colspan="10"></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------->
                    <div class="tab-pane fade show" id="nav-spei" role="tabpanel" aria-labelledby="nav-spei-tab">
                      <div class="row mt-4">
                        <div class="col-md-4 col-xs-12">
                          <div class="form-group">
                            <label for="tipo_cadena_pago" class="control-label">Tipo cadena de pago:</label>
                            <select id="tipo_cadena_pago" name="tipo_cadena_pago" class="form-control" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($tipo_cadena_pagos as $key => $value)
                                <option value="{{ $key }}"> {{ $value }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group form-group-sm">
                              <label for="certificado_pago" class="control-label">{{__('customer_payment.entry_certificado_pago')}}</label>
                            </div>
                            <textarea name="certificado_pago" id="certificado_pago" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group form-group-sm">
                              <label for="cadena_pago" class="control-label">{{__('customer_payment.entry_cadena_pago')}}</label>
                            </div>
                            <textarea name="cadena_pago" id="cadena_pago" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group form-group-sm">
                              <label for="sello_pago" class="control-label">{{__('customer_payment.entry_sello_pago')}}</label>
                            </div>
                            <textarea name="sello_pago" id="sello_pago" class="form-control" rows="5"></textarea>
                        </div>

                      </div>
                      <div class="row">
                        <div class="col-md-12 col-xs-12">
                          <div class="card card-body bg-light my-4" style="margin: 10px 0 20px 0; padding: 5px 19px;">
                            <p class="text-center" style="margin: 0;">
                              Se usa cuando la forma de pago es Transferencia electrónica de fondos.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------->
                    <div class="tab-pane fade show" id="nav-cfdi" role="tabpanel" aria-labelledby="nav-cfdi-tab">
                      <div class="row mt-4">
                        <div class="col-md-8 col-xs-12">
                          <div class="form-group">
                            <label for="cfdi_relation_id" class="control-label">{{__('customer_payment.entry_cfdi_relation_id')}}:</label>
                            <select id="cfdi_relation_id" name="cfdi_relation_id" class="form-control required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($cfdi_relations as $cfdi_relation_data)
                                <option value="{{ $cfdi_relation_data->id  }}"> [{{ $cfdi_relation_data->code }}] {{ $cfdi_relation_data->name }}</option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                          <div class="table-responsive">
                            <table class="table table-items table-condensed table-hover table-bordered table-striped mt-3" id="items_relation">
                              <thead>
                                <tr>
                                  <th width="5%"
                                      class="text-center">
                                      @lang('general.column_actions')
                                  </th>
                                  <th width="25%"
                                      class="text-center">
                                      @lang('customer_payment.column_relation_relation_id')
                                  </th>
                                  <th width="65%"
                                      class="text-center">
                                      @lang('customer_payment.column_relation_uuid')
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                  $item_relation_row = 0;
                                  $items_relation = old('item_relation',[]);
                                @endphp
                                <tr id="add_item_relation">
                                  <td class="text-center">
                                    <button type="button"
                                            onclick="addItemCfdiRelation();"
                                            class="btn btn-xs btn-primary"
                                            style="margin-bottom: 0; padding: 1px 3px;">
                                    <i class="fa fa-plus" style="font-size: 1rem;"></i>
                                    </button>
                                  </td>
                                  <td class="text-right" colspan="2"></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>

                      </div>
                      <div class="row">
                        <div class="col-md-12 col-xs-12">
                          <div class="card card-body bg-light my-4" style="margin: 10px 0 20px 0; padding: 5px 19px;">
                            <p class="text-center" style="margin: 0;">
                              Usarlo cuando se sustituye un CFDI Cancelado.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------->
                  </div>
                </div>
              </div>
              <div class="ln_solid mt-5"></div>
              <div class="row">
                <div class="col-md-12 col-xs-12 text-right footer-form">
                  <button type="submit" class="btn btn-outline-primary">@lang('general.button_save')</button>
                  &nbsp;&nbsp;&nbsp;
                  <button type="button" class="btn btn-outline-danger">@lang('general.button_discard')</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card card-body bg-light">
          <p class="text-center" style="margin: 0;"><strong>Notas</strong></p><hr>
          <p>
            <strong>Cuenta Beneficiaria:</strong>
            <span>Son las cuentas de banco donde se refleja el monto (Apartado Empresa).</span>
          </p>
          <p>
            <strong>Cuenta ordenante/cliente:</strong>
            <span>Son las cuentas de banco del cliente (Apartado C/B clientes).</span>
          </p>

          <p><strong>Serie:</strong><span>Abreviatura de la factura. Ejemplo: Fasa</span></p>
          <p><strong>Folio:</strong><span>Número de folio. Ejemplo: 101</span></p>
          <p><strong>Parcialidad:</strong><span>Número de parcialidad que pagara. Ejemplo: 1</span></p>
          <p><strong>Saldo anterior:</strong><span>Saldo de la factura. Ejemplo: 200.00</span></p>
          <p><strong>Importe pagado:</strong><span>Cantidad a pagar. Ejemplo: 150.00</span></p>
          <p><strong>Saldo insoluto:</strong><span>Cantidad sobrante. Ejemplo: 50.00</span></p>

          <p><strong>Advertencia 1. </strong></p>
          <p><strong>Cuenta Beneficiaria & Cuenta ordenante/cliente:</strong> Solo se usa en Transferencia electrónica de fondos, Cheque nominal, Tarjeta de crédito, Tarjeta de débito.</p>
        </div>
      </div>
    </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View customer payments') )
    <style media="screen">
      th { font-size: 12px !important; }
      td { font-size: 10px !important; }
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
    </style>

    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
    <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

    <script type="text/javascript">
        var item_reconciled_row = "{{ $item_reconciled_row }}";
        var item_manual_reconciled_row = "{{ $item_manual_reconciled_row }}";
        var item_relation_row = "{{ $item_relation_row }}";

        function totalItemReconciled() {
          $.ajax({
            url: "/sales/customer-payments/total-reconciled-lines",
            type: "POST",
            dataType: "JSON",
            data: $("#form").serialize(),
            success: function (data) {
              // console.log(data);
              if (data) {
                $.each(data.items_reconciled, function (key, value) {
                  $("#form #item_reconciled_txt_balance_" + key).html(value);
                });
                $.each(data.monto_conciliado, function (key, value) {
                  $("#items #item_reconciled_amount_reconciled_" + key).val(value);
                });
                $("#form #reconciled_txt_amount").html(data.amount);
                $("#form #reconciled_txt_amount_reconciled").html(data.amount_reconciled);
                $("#form #reconciled_txt_amount_per_reconciled").html(data.amount_per_reconciled);
              }
            },
            error: function (error, textStatus, errorThrown) {
              if (error.status == 422) {
                var message = error.responseJSON.error;
                Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: message,
                });
              }
              else {
                alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
              }
            }
          });
        }
        function addItemManualReconciled() {
          var html = '';
          html += '<tr id="item_manual_reconciled_row_' + item_manual_reconciled_row + '">';
          html += '<td class="text-center" style="vertical-align: middle;">';
          html += '<button type="button" onclick="$(\'#item_manual_reconciled_row_' + item_manual_reconciled_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0;">';
          html += '<i class="fa fa-trash"></i>';
          html += '</button>';
          html += '<input type="hidden" name="item_manual_reconciled[' + item_manual_reconciled_row + '][id]" id="item_manual_reconciled_id_' + item_manual_reconciled_row + '" /> ';
          html += '</td>';
          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="text" class="form-control input-sm text-center col-uuid-related" name="item_manual_reconciled[' + item_manual_reconciled_row + '][uuid_related]" id="item_manual_reconciled_uuid_related_' + item_manual_reconciled_row + '" required />';
          html += '</div>';
          html += '</td>';
          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="text" class="form-control input-sm text-center col-serie-related" name="item_manual_reconciled[' + item_manual_reconciled_row + '][serie_related]" id="item_manual_reconciled_serie_related_' + item_manual_reconciled_row + '" />';
          html += '</div>';
          html += '</td>';
          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="text" class="form-control input-sm text-center col-folio-related" name="item_manual_reconciled[' + item_manual_reconciled_row + '][folio_related]" id="item_manual_reconciled_folio_related_' + item_manual_reconciled_row + '" />';
          html += '</div>';
          html += '</td>';
          html += '<td class="text-center align-middle">';
          html += '<div class="form-group form-group-sm">';
          html += '<select class="form-control input-sm col-currency-code-related" name="item_manual_reconciled[' + item_manual_reconciled_row + '][currency_code_related]" id="item_manual_reconciled_currency_code_related_' + item_manual_reconciled_row + '" required>';
          html += '<option selected="selected" value="">@lang('general.text_select')</option>';
          @forelse ($currency as $currency_data)
            html += '<option value="{{ $currency_data->id  }}">{{ $currency_data->name }}</option>';
          @empty
          @endforelse
          html += '</select>';
          html += '</div>';
          html += '</td>';
          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="number" class="form-control input-sm text-center col-currency-value" name="item_manual_reconciled[' + item_manual_reconciled_row + '][currency_value]" id="item_manual_reconciled_currency_value_' + item_manual_reconciled_row + '" step="any" />';
          html += '</div>';
          html += '</td>';
          html += '<td class="text-center align-middle">';
          html += '<div class="form-group form-group-sm">';
          html += '<select class="form-control input-sm col-payment-method-code-related" name="item_manual_reconciled[' + item_manual_reconciled_row + '][payment_method_code_related]" id="item_manual_reconciled_payment_method_code_related_' + item_manual_reconciled_row + '" required>';
          html += '<option selected="selected" value="">@lang('general.text_select')</option>';
          @forelse ($payment_methods as $payment_methods_data)
            html += '<option value="{{ $payment_methods_data->id  }}">{{ $payment_methods_data->name }}</option>';
          @empty
          @endforelse
              html += '</select>';
          html += '</div>';
          html += '</td>';
          html += '</td>';
          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="number" class="form-control input-sm text-center col-number-of-payment" name="item_manual_reconciled[' + item_manual_reconciled_row + '][number_of_payment]" id="item_manual_reconciled_number_of_payment_' + item_manual_reconciled_row + '" required step="any" />';
          html += '</div>';
          html += '</td>';
          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="number" class="form-control input-sm text-right col-last-balance" name="item_manual_reconciled[' + item_manual_reconciled_row + '][last_balance]" id="item_manual_reconciled_last_balance_' + item_manual_reconciled_row + '" required step="any" />';
          html += '</div>';
          html += '</td>';
          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="number" class="form-control input-sm text-right col-amount-reconciled" name="item_manual_reconciled[' + item_manual_reconciled_row + '][amount_reconciled]" id="item_manual_reconciled_amount_reconciled_' + item_manual_reconciled_row + '" required step="any" />';
          html += '</div>';
          html += '</td>';
          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="number" class="form-control input-sm text-right col-current-balance" name="item_manual_reconciled[' + item_manual_reconciled_row + '][current_balance]" id="item_manual_reconciled_current_balance_' + item_manual_reconciled_row + '" required step="any" readonly="readonly" />';
          html += '</div>';
          html += '</td>';
          html += '</tr>';

          $("#form #items_manual_reconciled tbody #add_item_manual_reconciled").before(html);
          item_manual_reconciled_row++;
        }

        function addItemCfdiRelation() {
          let client = $("#form select[name='customer_id']").val();
          if (client != '') {
            var html = '';

            html += '<tr id="item_relation_row_' + item_relation_row + '">';
            html += '<td class="text-center" style="vertical-align: middle;">';
            html += '<button type="button" onclick="$(\'#item_relation_row_' + item_relation_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
            html += '<i class="fa fa-trash" style="font-size: 1rem;"></i>';
            html += '</button>';
            html += '<input type="hidden" name="item_relation[' + item_relation_row + '][id]" id="item_relation_id_' + item_relation_row + '" /> ';
            html += '</td>';
            html += '<td class="text-center align-middle">';
            html += '<div class="form-group form-group-sm">';
            html += '<select class="form-control input-sm col-relation-id" name="item_relation[' + item_relation_row + '][relation_id]" id="item_relation_relation_id_' + item_relation_row + '" data-row="' + item_relation_row + '" required>';
            html += '<option selected="selected" value="">@lang('general.text_select')</option>';
            html += '</select>';
            html += '</div>';
            html += '</td>';
            html += '<td class="text-center align-middle">';
            html += '<span id="item_relation_uuid_' + item_relation_row + '"></span>';
            html += '</td>';
            html += '</tr>';

            $("#form #items_relation tbody #add_item_relation").before(html);
            /* Configura select2 */
            initItemCfdiRelation();

            item_relation_row++;

            if ( !$("#form select[name='cfdi_relation_id']").hasClass('required')){
              $("#form select[name='cfdi_relation_id']").addClass("required");
            }
          }
          else {
            Swal.fire({
               type: 'error',
               title: 'Oops...',
               text: 'Selecciona un cliente primero',
             });
          }
        }
        function initItemCfdiRelation() {
          /*Busqueda de facturas*/
          $("#form #items_relation tbody .col-relation-id").select2({
              ajax: {
                  url: "/sales/customer-payments/autocomplete-cfdi",
                  dataType: "JSON",
                  delay: 250,
                  data: function (params) {
                      return {
                          term: $.trim(params.term),
                          customer_id: $("#form select[name='customer_id']").val(),
                      };
                  },
                  processResults: function (data, page) {
                      return {
                          results: data
                      };
                  },
                  cache: true
              },
              placeholder: "Selecciona",
              theme: "bootstrap",
              width: "auto",
              dropdownAutoWidth: true,
              minimumInputLength: 2
          });
        }
        //Obtener cuentas bancarias
        function getCustomerBankAccount(id){
          if (id) {
            let customer_bank_account_id = $("#form select[name='customer_bank_account_id']");
            let tmp = customer_bank_account_id.val();
            $.ajax({
                url: "/sales/customers/get-customer-bank-accounts",
                type: "GET",
                dataType: "JSON",
                data: "id=" + id + "&customer_bank_account_id=" + tmp + "",
                success: function (data) {
                  $("#customer_bank_account_id option[value!='']").remove();
                  if (typeof data !== 'undefined' && data.length > 0) {
                    $.each(data, function(i, item) {
                        $("#customer_bank_account_id").append('<option value="'+item.id+'">'+'No.Cuenta: '+ item.account_number +'- Clabe: '+ item.clabe +'</option>');
                    });
                  }
                },
                error: function (error, textStatus, errorThrown) {
                    if (error.status == 422) {
                        var message = error.responseJSON.error;
                        // $("#general_messages").html(alertMessage("danger", message));
                        Swal.fire({
                           type: 'error',
                           title: 'Oops...',
                           text: message,
                         });
                    } else if (error.status == 403 || error.status == 401) {
                        // location.href = "{{ route('login') }}";
                    } else {
                        alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                    }
                }
            });
          }
        }
        //Filtra solo facturas de la misma moneda
        function getCustomerInvoiceBalances(){
          let customer_id = $("#form select[name='customer_id']").val();
          let currency_id = $("#form select[name='currency_id']").val();
          let currency_value = $("#form input[name='currency_value']").val();
          let filter_currency_id = 0; //Filtra solo facturas de la misma moneda
          let token = $('input[name="_token"]').val();
          $("#form #items_reconciled tbody").html('');

          if(customer_id && currency_id){
            $.ajax({
              url: "/sales/customer-payments/balances",
              type: "GET",
              dataType: "JSON",
              data: "customer_id=" + customer_id + "&currency_id=" + currency_id + "&currency_value=" + currency_value + "&filter_currency_id=" + filter_currency_id + "",
              success: function (data) {
                // $("#form #items_reconciled tbody").html('');

                if (data != '[]') {
                  item_row = 0;
                  var html = '';
                  let tc_date_payment = $('#currency_value').val();
                  data.forEach(function(key,i) {
                    html += '<tr>';

                    html += '<td class="text-right" style="padding-top: 11px;">';
                    html += '<input type="hidden" name="item_reconciled[' + item_row + '][reconciled_id]" id="item_reconciled_reconciled_id_' + item_row + '" value="' + key.id + '" /> ';
                    html += '<input type="hidden" name="item_reconciled[' + item_row + '][name]" id="item_reconciled_name_' + item_row + '" value="' + key.name + '" /> ';
                    html += '<input type="hidden" name="item_reconciled[' + item_row + '][balance]" id="item_reconciled_balance_' + item_row + '" value="' + key.balance + '" /> ';
                    html += '<input type="hidden" name="item_reconciled[' + item_row + '][currency_code]" id="item_reconciled_currency_code_' + item_row + '" value="' + key.currency_id + '" /> ';

                    html += '<span>' + key.name + '</span>';
                    html += '</td>';

                    html += '<td class="text-right" style="padding-top: 11px;">';
                    html += '<span>' + key.date + '</span>';
                    html += '</td>';

                    html += '<td class="text-right" style="padding-top: 11px;">';
                    html += '<span>' + key.date_due + '</span>';
                    html += '</td>';

                    html += '<td class="text-right" style="padding-top: 11px;">';
                    html += '<span>' + key.currencie + '</span>';
                    html += '</td>';

                    html += '<td class="text-right" style="padding-top: 11px;">';
                    html += '<span>' + key.amount_total + '</span>';
                    html += '</td>';

                    var saldox = parseFloat(key.amount_total.replace(/,/g, '')) - parseFloat(key.amount_reconciled.replace(/,/g, ''));

                    html += '<td class="text-right" style="padding-top: 11px;">';
                    html += '<span id="item_reconciled_txt_balance_' + i + '">' + /*saldox*/key.balance + '</span>';
                    html += '</td>';

                    if (key.currency_id != 1) {
                      html += '<td class="text-right" style="padding-top: 11px;">';
                      html += '<input type="number" class="form-control form-control-sm text-right col-currency-value" value="' + tc_date_payment + '"  name="item_reconciled[' + item_row + '][currency_value]" id="item_reconciled_currency_value_' + item_row + '" required step="any" />';
                      html += '</td>';
                    }
                    else {
                        html += '<td class="text-right" style="padding-top: 11px;">';
                        html += '</td>';
                    }
                    html += '<td class="text-right" style="padding-top: 11px;">';
                    html += '<input type="number" class="form-control form-control-sm text-right col-amount-reconciled" value="' + 0 + '"  name="item_reconciled[' + item_row + '][amount_reconciled]" id="item_reconciled_amount_reconciled_' + item_row + '" required step="any" />';
                    html += '</td>';
                    html += '</tr>';
                    $("#form #items_reconciled tbody").html(html);
                    item_row++;
                  });
                }
                //$("#form #items tbody").html(data.html);
              },
              error: function (error, textStatus, errorThrown) {
                if (error.status == 422) {
                  var message = error.responseJSON.error;
                  // $("#general_messages").html(alertMessage("danger", message));
                  Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: message,
                  });
                } else {
                    alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                }
              }
            });
          }
          else {
              console.log('Necesita seleccionar el cliente & la moneda');
          }
        }

        function totalItemManualReconciled() {
          $.ajax({
            url: "/sales/customer-payments/total-item-manual-reconciled",
            type: "POST",
            dataType: "JSON",
            data: $("#form").serialize(),
            success: function (data) {
              if (data) {
                $.each(data.items_manual_reconciled, function (key, value) {
                  $("#item_manual_reconciled_current_balance_" + key).val(value);
                });
              }
            },
            error: function (error, textStatus, errorThrown) {
              if (error.status == 422) {
                var message = error.responseJSON.error;
                $("#general_messages").html(alertMessage("danger", message));
              } else if (error.status == 403 || error.status == 401) {
                location.href = "{{ route('login') }}";
              } else {
                alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
              }
            }
          });
        }

        $(function () {
          $("#customer_id").select2().on("change", function(){
            let id = $(this).val();
            //console.log(id);
            //Obtener cuentas bancarias
            getCustomerBankAccount(id);
            //Obtener facturas con saldos
            getCustomerInvoiceBalances(); //AQUI
          });
          //-----------------------------------------------------------
          $("#form").validate({
            errorClass: "text-danger",
            successClass: "text-success",
            errorPlacement: function (error, element) {
              var attr = $('[name="'+element[0].name+'"]').attr('datas');
              if (element[0].id === 'fileInput') {
                error.insertAfter($('#cont_file'));
              }
              else {
                if(attr == 'sel_estatus'){
                  error.insertAfter($('#cont_estatus'));
                }
                else if(attr == 'customer_id'){
                  error.insertAfter($('#cont_customer_id'));
                }
                else {
                  error.insertAfter(element);
                }
              }
            },
            rules: {
            },
            messages: {
            },
            submitHandler: function(e){
              var form = $('#form')[0];
              var formData = new FormData(form);
              $.ajax({
                type: "POST",
                url: "/sales/customer-payments/customer-payments-store",
                data: formData,
                contentType: false,
                processData: false,
                success: function (data){
                  if (data == 'error1') {
                    // return  __('customer_payment.error_currency_id_company_bank_account_id')
                    Swal.fire({
                      type: 'error',
                     title: 'Error encontrado..',
                      text: 'La moneda de la cuenta debe ser igual a la de pago',
                    });
                  }
                  else if (data == 'error2') {
                    // return __('customer_payment.error_pattern_account_company_bank_account_id');
                    Swal.fire({
                      type: 'error',
                     title: 'Error encontrado..',
                      text: 'El patrón de la cuenta beneficiaria es incorrecta para el método de pago',
                    });
                  }
                  else if (data == 'error3') {
                    // return __('customer_payment.error_currency_id_customer_bank_account_id');
                    Swal.fire({
                      type: 'error',
                     title: 'Error encontrado..',
                      text: 'La moneda de la cuenta debe ser igual a la de pago',
                    });
                  }
                  else if (data == 'error4') {
                    // return __('customer_payment.error_pattern_account_customer_bank_account_id');
                    Swal.fire({
                      type: 'error',
                     title: 'Error encontrado..',
                      text: 'El patrón de la cuenta ordenante es incorrecta para el método de pago',
                    });
                  }
                  else if (data == 'error5') {
                    // return __('customer_payment.error_reconciled_amount_reconciled_customer_invoice_balance');
                    Swal.fire({
                      type: 'error',
                     title: 'Error encontrado..',
                      text: 'El monto supera el saldo de la factura',
                    });
                  }
                  else if (data == 'error6') {
                    // return  __('customer_payment.error_amount_amount_reconciled');
                    Swal.fire({
                      type: 'error',
                     title: 'Error encontrado..',
                      text: 'El monto conciliado supera el monto de pago',
                    });
                  }
                  else if (data == 'success') {
                    let timerInterval;
                    Swal.fire({
                      type: 'success',
                      title: 'El complemento de pago, se ha generado con éxito!',
                      html: 'Se estan aplicando los cambios.',
                      timer: 2500,
                      onBeforeOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                          Swal.getContent().querySelector('strong')
                        }, 100)
                      },
                      onClose: () => {
                        clearInterval(timerInterval)
                      }
                    }).then((result) => {
                      if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.timer
                      ) {
                        // window.location.href = "/sales/customer-payments";
                      }
                    });
                  }
                  else if (data == 'false') {
                    Swal.fire({
                      type: 'error',
                      title: 'Error encontrado..',
                      text: 'Error al crear el complemento de pago!',
                    });
                  }
                  else {
                    Swal.fire({
                      type: 'error',
                      title: 'Error encontrado..',
                      text: data,
                    });
                  }
                },
                error: function (err) {
                  Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: err.statusText,
                  });
                }
              });
            }
          });
          //-----------------------------------------------------------
          moment.locale('es');
          /*Fecha actual*/
          $("#form input[name='date']").daterangepicker({
              singleDatePicker: true,
              timePicker: true,
              timePicker24Hour: true,
              showDropdowns: true,
              locale: {
                  format: "DD-MM-YYYY HH:mm:ss"
              },
              autoUpdateInput: true
          }, function (chosen_date) {
              $("#form input[name='date']").val(chosen_date.format("DD-MM-YYYY HH:mm:ss"));
          });
          /*Fecha pago*/
          $("#form input[name='date_payment']").datepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY'
            },
            autoUpdateInput: false
          }, function (chosen_date) {
              $("#form input[name='date_payment']").val(chosen_date.format('DD-MM-YYYY'));
          });
          /*Forma de pago*/
          $('#payment_way_id').on('change', function(){
            if ( $(this).val() == 2 || $(this).val() == 3 || $(this).val() == 4 || $(this).val() == 18 ) {
              $('#company_bank_account_id').prop("disabled", false);
              $('#customer_bank_account_id').prop("disabled", false);
            }else{
              $('#company_bank_account_id').prop("disabled", true).val('');
              $('#customer_bank_account_id').prop("disabled", true).val('');
            }
          });
          /* Eventos en items_reconciled */
          $(document).on("keyup", "#form #items_reconciled tbody .col-amount-reconciled,#form #items_reconciled tbody .col-currency-value", function () {
              totalItemReconciled();
          });
          /* Eventos en items cfdi relation */
          /*Selecciona factura*/
          $(document).on('select2:select', '#form #items_relation tbody .col-relation-id', function (e) {
              let id = $(this).val();
              let row = $(this).attr('data-row');
              if (id) {
                  $.ajax({
                      url: "/sales/customer-payments/get-customer-payment",
                      type: "GET",
                      dataType: "JSON",
                      data: "id=" + id,
                      success: function (data) {
                          $("#form #item_relation_uuid_" + row).html(data.uuid);
                      },
                      error: function (error, textStatus, errorThrown) {
                          if (error.status == 422) {
                              var message = error.responseJSON.error;
                              $("#general_messages").html(alertMessage("danger", message));
                          } else if (error.status == 403 || error.status == 401) {
                              location.href = "/login";
                          } else {
                              alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                          }
                      }
                  });
              }
          });
          /* Eventos en items_manual_reconciled */
          $(document).on("keyup", "#form #items_manual_reconciled tbody .col-last-balance, #form #items_manual_reconciled tbody .col-amount-reconciled", function () {
              totalItemManualReconciled();
          });
          //-----------------------------------------------------------
        });

        $('#date_payment').on('blur', function(){
          let date_payment = $(this).val();
          var token = $('input[name="_token"]').val();
          console.log(date_payment);
          $.ajax({
              url: "/sales/get_exchange_rate_by_date",
              type: "POST",
              dataType: "JSON",
              data: { _token : token, date_payment: date_payment },
              success: function (data) {
                  if(data.length != 0){
                    $("#currency_value").val(data[0].current_rate);
                  }else{
                    $("#currency_value").val('');
                  }
              },
              error: function (error, textStatus, errorThrown) {
                  console.log(error);
              }
          });
        })

        /* Selecciona moneda */
        $("#form select[name='currency_id']").on("change", function () {
          let id = $(this).val();
          var token = $('input[name="_token"]').val();
          $('#currency_value').val('');
          if (id) {
            if (id == 1) {
              $('#currency_value').val('1');
              //Obtener facturas con saldos
              getCustomerInvoiceBalances();
            }
            else {
              $.ajax({
                url: "/sales/customer-invoices/currency_now",
                type: "POST",
                data: { _token : token, id_currency: id },
                success: function (data) {
                  $('#currency_value').val(data);
                  //Obtener facturas con saldos
                  getCustomerInvoiceBalances(); //AQUI
                },
                error: function (error, textStatus, errorThrown) {
                  if (error.status == 422) {
                    var message = error.responseJSON.error;
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: message,
                    });
                  }
                  else {
                    alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                  }
                }
              });
            }
          }
        });
        /* Actualiza facturas para el tipo de cambio */
        $("#form select[name='currency_value']").on("change", function () {
          //Obtener facturas con saldos
          getCustomerInvoiceBalances();
        });
        $("#form input[name='amount']").on("change", function () {
          totalItemReconciled();
        });

    </script>
  @else
  @endif
@endpush
