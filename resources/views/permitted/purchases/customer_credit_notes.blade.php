@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View account to pay') )
    Nota de crédito - Compras
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customer credit notes purchases') )
    Nota de crédito - Compras
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View customer credit notes purchases') )
    <div class="row">
      <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
          <div class="card-body">
            <form id="form" name="form" enctype="multipart/form-data">
              {{ csrf_field() }}
              <!-- input hidden -->
              <input type="hidden"
                  id="amount_total_tmp"
                  name="amount_total_tmp"
                  value="{{ old('amount_total_tmp',0) }}">
              <!-- input hidden -->
              <div class="row">
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="currency_id" class="control-label">Moneda:<span style="color: red;">*</span></label>
                    <select id="currency_id" name="currency_id" class="form-control required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($currency as $currency_data)
                        <option value="{{ $currency_data->id  }}">{{ $currency_data->name }}</option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-md-2 col-xs-12">
                  <div class="form-group">
                    <label for="currency_value">TC:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="currency_value" name="currency_value" style="padding: 0.875rem 0.5rem;" required>
                  </div>
                </div>
                <div class="col-md-7 col-xs-12">
                  <label for="customer_id" class="control-label  my-2">Proveedor:<span style="color: red;">*</span></label>
                  <div class="input-group">
                    <select class="custom-select" id="customer_id" name="customer_id">
                      <option value="" selected>Selecciona...</option>
                      @forelse ($providers as $provider_data)
                        <option value="{{ $provider_data->id  }}">{{ $provider_data->name }}</option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="date">Fecha:<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="date" name="date">
                  </div>
                </div>
                <div class="col-md-4 col-xs-12">
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
                <div class="col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="payment_way_id" class="control-label">Forma de pago:<span style="color: red;">*</span></label>
                    <select id="payment_way_id" name="payment_way_id" class="form-control required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($payment_way as $payment_way_data)
                      <option value="{{ $payment_way_data->id }}"> [{{ $payment_way_data->code }}] {{ $payment_way_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="payment_method_id" class="control-label">Metodo de pago:<span style="color: red;">*</span></label>
                    <select id="payment_method_id" name="payment_method_id" class="form-control required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($payment_methods as $payment_methods_data)
                      <option value="{{ $payment_methods_data->id }}"> [{{ $payment_methods_data->code }}] {{ $payment_methods_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="cfdi_use_id" class="control-label">Uso de cfdi:<span style="color: red;">*</span></label>
                    <select id="cfdi_use_id" name="cfdi_use_id" class="form-control required" style="width:100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($cfdi_uses as $cfdi_uses_data)
                      <option value="{{ $cfdi_uses_data->id }}">[{{ $cfdi_uses_data->code }}] {{ $cfdi_uses_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>

                <div class="col-md-3 col-xs-12">
                  <label for="iva"> IVA:</label>
                  <div id="cont_iva" class="input-group">
                    <select datas="iva" class= "form-control input-sm col-taxes required" name="iva[]" id="iva" style="width:100%;" multiple>
                      @forelse ($impuestos as $impuestos_data)
                        <option value="{{ $impuestos_data->id  }}">{{ $impuestos_data->name }}</option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 col-xs-12">
                  <div class="form-group">
                    <label for="reference">Referencia:</label>
                    <input type="text" class="form-control" id="reference" name="reference" value="">
                  </div>
                </div>
              </div>
              <!-------------------------------------------------------------------------->
              <div class="row mt-5">
                <div class="col-md-12">
                  <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-product-tab" data-toggle="tab" href="#nav-product" role="tab" aria-controls="nav-product" aria-selected="true">Productos</a>
                      <a class="nav-item nav-link" id="nav-facturas-tab" data-toggle="tab" href="#nav-facturas" role="tab" aria-controls="nav-facturas" aria-selected="false">Compras</a>
                    </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                    <!-------------------------------------------------------------------------->
                    <div class="tab-pane fade show active" id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab">
                      <div class="row">
                        <div class="col-md-12 col-xs-12 mt-2">
                          <div class="table-responsive" style="fontsize: 8px;">
                            <table class="table table-items table-condensed table-hover table-bordered table-striped jambo_table mt-5" id="items" style="min-width: 1000px;">
                              <thead>
                                <tr>
                                  <th width="5%" class="text-center">@lang('general.column_actions')</th>
                                  <th width="12%" class="text-center"> @lang('customer_credit_note.column_line_product_id')</th>
                                  <th width="12%" class="text-left"> @lang('customer_credit_note.column_line_name')<span class="required text-danger">*</span></th>
                                  <th width="12%" class="text-center"> @lang('customer_credit_note.column_line_unit_measure_id')<span class="required text-danger">*</span></th>
                                  <th width="12%" class="text-center">@lang('customer_credit_note.column_line_sat_product_id')<span class="required text-danger">*</span></th>
                                  <th width="8%" class="text-center">@lang('customer_credit_note.column_line_quantity')<span class="required text-danger">*</span></th>
                                  <th width="10%" class="text-center">@lang('customer_credit_note.column_line_price_unit')<span class="required text-danger">*</span></th>
                                  <th width="12%" class="text-center">Cuenta contable</th>
                                  <th width="12%" class="text-right">@lang('customer_credit_note.column_line_amount_untaxed')</th>
                                </tr>
                              </thead>
                              <tbody>
                                <!-- Items -->
                                <!-- /Items -->
                                <!-- Agregar nuevo item -->
                                <tr id="add_item">
                                    <td class="text-center">
                                        <button type="button" onclick="addItem();"
                                                class="btn btn-xs btn-primary"
                                                style="margin-bottom: 0; padding: 1px 3px;">
                                            <i class="fa fa-plus" style="font-size: 1rem;"></i>
                                        </button>
                                    </td>
                                    <td class="text-right" colspan="8"></td>
                                </tr>
                                <!-- Totales -->
                                <tr>
                                    <td></td>
                                    <td class="text-right" colspan="6" rowspan="3"
                                        style="vertical-align: middle">
                                        <textarea class="form-control input-sm col-name-id" name="comment" id="comment" placeholder="@lang('customer_credit_note.entry_comment')" rows="3" autocomplete="off" /></textarea>
                                    </td>
                                    <td class="text-right">
                                        <strong>@lang('general.text_amount_untaxed')</strong>
                                    </td>
                                    <td class="text-right">
                                      <span id="txt_amount_untaxed">0</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right">
                                        <strong>@lang('general.text_amount_tax')</strong></td>
                                    <td class="text-right"><span id="txt_amount_tax">0</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right">
                                        <strong>@lang('general.text_amount_total')</strong></td>
                                    <td class="text-right"><span id="txt_amount_total">0</span>
                                    </td>
                                </tr>
                                <!-- Totales -->
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------->
                    <div class="tab-pane fade" id="nav-facturas" role="tabpanel" aria-labelledby="nav-facturas-tab">
                      <div class="row">
                        <div class="col-md-12 col-xs-12 mt-5">
                          <div class="card card-body bg-light">
                            <p class="text-center" style="margin: 0;">
                                @lang('customer_credit_note.entry_amount_total')(Productos):
                                <span id="reconciled_txt_amount_total"></span>
                                &nbsp;&nbsp;&nbsp;
                                @lang('customer_credit_note.text_reconciled'):
                                <span id="reconciled_txt_amount_reconciled"></span>
                                &nbsp;&nbsp;&nbsp;
                                @lang('customer_credit_note.text_per_reconciled'):
                                <span id="reconciled_txt_amount_per_reconciled"></span>
                            </p>
                          </div>
                        </div>
                        <div class="col-md-12 col-xs-12 mt-4">
                          <div class="table-responsive">
                            <table class="table table-items table-condensed table-hover table-bordered table-striped"
                                id="items_reconciled">
                                <thead>
                                  <tr>
                                      <th class="text-center">
                                        Compra
                                      </th>
                                      <th width="15%" class="text-center">
                                        @lang('customer_payment.column_reconciled_date')
                                      </th>
                                      <th width="17%" class="text-center">
                                        @lang('customer_payment.column_reconciled_date_due')
                                      </th>
                                      <th width="20%" class="text-center">
                                        @lang('customer_payment.column_reconciled_currency')
                                      </th>
                                      <th width="20%" class="text-center">
                                        @lang('customer_payment.column_reconciled_amount_total')
                                      </th>
                                      <th width="15%" class="text-center">
                                        @lang('customer_payment.column_reconciled_balance')
                                        <span id="info_reconciled_balance_currency"></span>
                                      </th>
                                      <th width="15%" class="text-center">
                                        @lang('customer_payment.column_reconciled_amount_reconciled')
                                      </th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------->

                    <!-------------------------------------------------------------------------->
                  </div>
                </div>
              </div>
              <!-------------------------------------------------------------------------->
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
  @else
    @include('default.denied')
  @endif
@endsection
@push('scripts')
  @if( auth()->user()->can('View customer credit notes purchases') )
  @else
  @endif
@endpush
