@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View customer credit notes') )
    {{ trans('invoicing.customers_credit_notes') }} - CFDI Egreso
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customer credit notes') )
    {{ trans('invoicing.customers_credit_notes') }} - CFDI Egreso
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View customer credit notes') )
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
                <label for="customer_id" class="control-label  my-2">Clientes:<span style="color: red;">*</span></label>
                <div class="input-group">
                  <select class="custom-select" id="customer_id" name="customer_id">
                    <option value="" selected>Selecciona...</option>
                    @forelse ($customer as $customer_data)
                      <option value="{{ $customer_data->id  }}">{{ $customer_data->name }}</option>
                    @empty
                    @endforelse
                  </select>
                  {{-- <div class="input-group-append">
                    <button class="btn btn-outline-info btn-xs" type="button"><i class="fas fa-plus-square"></i></button>
                  </div> --}}
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
              <!--
              <div class="col-md-3 col-xs-12">
                <div class="form-group">
                  <label for="branch_office_id" class="control-label">Sucursal:<span style="color: red;">*</span></label>
                  <select id="branch_office_id" name="branch_office_id" class="form-control" style="width:100%;">
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
                  <label for="salesperson_id" class="control-label">Vendedor:<span style="color: red;">*</span></label>
                  <select id="salesperson_id" name="salesperson_id" class="form-control" style="width:100%;">
                    <option value="">{{ trans('message.selectopt') }}</option>
                    @forelse ($salespersons as $salespersons_data)
                      <option value="{{ $salespersons_data->id  }}">{{ $salespersons_data->name }}</option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>
              -->
            </div>
            <!-------------------------------------------------------------------------->
            <div class="row mt-5">
              <div class="col-md-12">
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-product-tab" data-toggle="tab" href="#nav-product" role="tab" aria-controls="nav-product" aria-selected="true">Productos</a>
                    <a class="nav-item nav-link" id="nav-facturas-tab" data-toggle="tab" href="#nav-facturas" role="tab" aria-controls="nav-facturas" aria-selected="false">Facturas</a>
                    <a class="nav-item nav-link" id="nav-cfdi-tab" data-toggle="tab" href="#nav-cfdi" role="tab" aria-controls="nav-cfdi" aria-selected="false">CFDI's Relacionados</a>
                  </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                  <!-------------------------------------------------------------------------->
                  <div class="tab-pane fade show active" id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab">
                    <div class="row">
                      <div class="col-md-12 col-xs-12 mt-5">
                        <div class="card card-body bg-light">
                          <p class="text-center" style="margin: 0;">
                              Paso seguir:
                              &nbsp;&nbsp;&nbsp;
                              1) Elija
                              2) Elija
                              3) Elija
                          </p>
                        </div>
                      </div>
                      <div class="col-md-12 col-xs-12">
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
                              @php
                                  $item_row = 0;
                                  $items = (empty(old('item')) ? [] : old('item'));
                              @endphp
                              @foreach ($items as $item_row => $item)
                                <tr id="item_row_{{ $item_row }}">
                                  <td class="text-center" style="vertical-align: middle;">
                                      <button type="button"
                                              onclick="$('#item_row_{{ $item_row }}').remove(); totalItem();"
                                              class="btn btn-xs btn-danger"
                                              style="margin-bottom: 0; padding: 1px 3px;">
                                          <i class="fa fa-trash-o" style="font-size: 1rem;"></i>
                                      </button>
                                      <!-- input hidden -->
                                      <input type="hidden" id="item_id_{{ $item_row }}"
                                             name="item[{{ $item_row }}][id]"
                                             value="{{ old('item.' . $item_row . '.id') }}">
                                      <!-- /.input hidden -->
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <select class="form-control input-sm"  id="item{{ $item_row.'[product_id]'}}" name="item[{{ $item_row }}][product_id]" required>
                                        <option selected="selected" value="">{{ trans('message.selectopt') }}</option>
                                        @forelse ($product as $product_data)
                                          <option value="{{ $product_data->id  }}">{{ $product_data->name }}</option>
                                        @empty
                                        @endforelse
                                      </select>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <input type="text" class="form-control input-sm text-center"
                                      id="item_name_{{ $item_row.'['.$item.']'}}"
                                      name="item[{{ $item_row }}][name]"
                                      value="{{old('item.' . $item_row . '.name')}}"
                                      required />
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <select class="form-control input-sm"  id="item{{ $item_row.'[unit_measure_id]'}}" name="item[{{ $item_row }}][unit_measure_id]" required>
                                        <option selected="selected" value="">{{ trans('message.selectopt') }}</option>
                                        @forelse ($unitmeasures as $unitmeasures_data)
                                          <option value="{{ $unitmeasures_data->id  }}">[{{ $unitmeasures_data->code }}]{{ $unitmeasures_data->name }}</option>
                                        @empty
                                        @endforelse
                                      </select>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <select class="form-control input-sm"  id="item{{ $item_row.'[sat_product_id]'}}" name="item[{{ $item_row }}][sat_product_id]" required>
                                        <option selected="selected" value="">{{ trans('message.selectopt') }}</option>
                                        @forelse ($satproduct as $satproduct_data)
                                          <option value="{{ $satproduct_data->id  }}">[{{ $satproduct_data->code }}] {{ $satproduct_data->name }}</option>
                                        @empty
                                        @endforelse
                                      </select>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <input type="text" class="form-control input-sm text-center"
                                      id="item{{ $item_row.'['.$item.']'}}"
                                      name="item[{{ $item_row }}][quantity]"
                                      value="{{old('item.' . $item_row . '.quantity')}}"
                                      required />
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <input type="text" class="form-control input-sm text-center"
                                      id="item{{ $item_row.'['.$item.']'}}"
                                      name="item[{{ $item_row }}][price_unit]"
                                      value="{{old('item.' . $item_row . '.price_unit')}}"
                                      required />
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <input type="text" class="form-control input-sm text-center"
                                      id="item{{ $item_row.'['.$item.']'}}"
                                      name="item[{{ $item_row }}][current]"
                                      value="{{old('item.' . $item_row . '.current')}}"
                                      required />
                                    </div>
                                  </td>
                                  <td class="text-right" style="padding-top: 11px;">
                                    <span id="item_txt_amount_untaxed_{{ $item_row }}">0</span>
                                  </td>
                                </tr>
                              @endforeach
                              @php
                                  $item_row++;
                              @endphp
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
                                      @lang('customer_payment.column_reconciled_name')
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
                                <!-- Items -->
                                @php
                                    $item_reconciled_row = 0;
                                    $items_reconciled = (empty(old('item_reconciled')) ? [] : old('item_reconciled'));
                                @endphp
                                @foreach ($items_reconciled as $item_reconciled_row => $item)
                                  @php
                                    $tmp_name = '';
                                    $tmp_date = '';
                                    $tmp_date_due = '';
                                    $tmp_currency_code = '';
                                    $tmp_amount_total = '';
                                    $tmp_balance = '';
                                    if(!empty(old('item_reconciled.' . $item_reconciled_row . '.reconciled_id'))){
                                        $tmp_currency = \App\Models\Catalogs\Currency::find(old('currency_id'));
                                        $tmp = \App\Models\Sales\CustomerInvoice::find(old('item_reconciled.' . $item_reconciled_row . '.reconciled_id'));
                                        $tmp_name =!empty($tmp) ? $tmp->name : '';
                                        $tmp_date = !empty($tmp) ? \App\Helpers\Helper::convertSqlToDateTime($tmp->date) : '';
                                        $tmp_date_due = !empty($tmp) ? \App\Helpers\Helper::convertSqlToDate($tmp->date_due) : '';
                                        $tmp_currency_code = !empty($tmp) ? $tmp->currency->code : '';
                                        $tmp_amount_total = !empty($tmp) ? money($tmp->amount_total,$tmp->currency->code,true) : '';
                                        $tmp_balance = '<span id="item_reconciled_txt_balance_'. $item_reconciled_row .'">'. money(\App\Helpers\Helper::convertBalanceCurrency($tmp_currency,$tmp->balance,$tmp->currency->code,old('item_reconciled.' . $item_reconciled_row . '.currency_value')),$tmp->currency->code,true).'</span>';
                                    }
                                  @endphp
                                  <tr id="item_reconciled_row_{{ $item_reconciled_row }}">
                                      <td class="text-center align-middle"
                                          style="vertical-align: middle;">
                                          <!-- input hidden -->
                                          <input type="hidden"
                                                 id="item_reconciled_id_{{ $item_reconciled_row }}"
                                                 name="item_reconciled[{{ $item_reconciled_row }}][id]"
                                                 value="{{ old('item_reconciled.' . $item_reconciled_row . '.id') }}">
                                          <input type="hidden"
                                                 id="item_reconciled_reconciled_id_{{ $item_reconciled_row }}"
                                                 name="item_reconciled[{{ $item_reconciled_row }}][reconciled_id]"
                                                 value="{{ old('item_reconciled.' . $item_reconciled_row . '.reconciled_id') }}">
                                          <input type="hidden"
                                                 id="item_reconciled_name_{{ $item_reconciled_row }}"
                                                 name="item_reconciled[{{ $item_reconciled_row }}][name]"
                                                 value="{{ old('item_reconciled.' . $item_reconciled_row . '.name') }}">
                                          <input type="hidden"
                                                 id="item_reconciled_balance_{{ $item_reconciled_row }}"
                                                 name="item_reconciled[{{ $item_reconciled_row }}][balance]"
                                                 value="{{ old('item_reconciled.' . $item_reconciled_row . '.balance') }}">
                                          <input type="hidden"
                                                 id="item_reconciled_currency_code_{{ $item_reconciled_row }}"
                                                 name="item_reconciled[{{ $item_reconciled_row }}][currency_code]"
                                                 value="{{ old('item_reconciled.' . $item_reconciled_row . '.currency_code') }}">
                                          <!-- /.input hidden -->
                                          {{$tmp_name}}
                                      </td>
                                      <td class="text-center align-middle">{{$tmp_date}}</td>
                                      <td class="text-center align-middle">{{$tmp_date_due}}</td>
                                      <td class="text-center align-middle">{{$tmp_currency_code}}</td>
                                      <td class="text-right align-middle">{{$tmp_amount_total}}</td>
                                      <td class="text-right align-middle">{!!$tmp_balance!!}</td>
                                      <td class="text-right align-middle">
                                        <div class="form-group form-group-sm{{ $errors->has('item_reconciled.'.$item_reconciled_row.'.amount_reconciled') ? ' has-error' : '' }}">
                                          <input type="number"
                                            id="item_reconciled_amount_reconciled_{{$item_reconciled_row}}"
                                            name="item_reconciled[{{$item_reconciled_row }}][amount_reconciled]"
                                            value="{{ old('item_reconciled.' . $item_reconciled_row . '.amount_reconciled') }}"
                                            class="form-control input-sm text-right col-amount-reconciled">
                                            @if ($errors->has('item_reconciled.'.$item_reconciled_row.'.amount_reconciled'))
                                                <span class="help-block"><small>{{ $errors->first('item_reconciled.'.$item_reconciled_row.'.amount_reconciled') }}</small></span>
                                            @endif
                                        </div>
                                      </td>
                                  </tr>
                                @endforeach
                                @php
                                    $item_reconciled_row++;
                                @endphp
                                <!-- /Items -->
                                <!-- Agregar nuevo item -->
                                <!-- Totales -->
                              </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-------------------------------------------------------------------------->
                  <div class="tab-pane fade" id="nav-cfdi" role="tabpanel" aria-labelledby="nav-cfdi-tab">
                    <div class="row">
                      <div class="col-md-12 col-xs-12">
                        <div class="form-group row">
                          <label for="cfdi_relation_id" class="col-md-12 col-form-label ml-0">Tipo de relación<span style="color: red;">*</span></label>
                          <div class="col-md-12 ml-0">
                            <select  id="cfdi_relation_id" name="cfdi_relation_id" class="form-control form-control-sm"  style="width: 100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($cfdi_relations as $cfdi_relations_data)
                              <option value="{{ $cfdi_relations_data->id }}"> [{{ $cfdi_relations_data->code}}]{{ $cfdi_relations_data->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 col-xs-12">
                        <div class="table-responsive">
                          <table class="table table-items table-condensed table-hover table-bordered table-striped mt-5"
                                  id="items_relation">
                              <thead>
                              <tr>
                                <th width="5%"
                                    class="text-center">
                                    Opciones
                                </th>
                                <th width="25%"
                                    class="text-center">
                                    CFDI
                                </th>
                                <th width="65%"
                                    class="text-center">
                                    UUID
                                </th>
                              </tr>
                              </thead>
                              <tbody>
                                @php
                                    $item_relation_row = 0;
                                    $items_relation = old('item_relation',[]);
                                @endphp
                                @foreach ($items_relation as $item_relation_row => $item)
                                    @php
                                    $tmp_uuid = '';
                                    $tmp_customer_invoice_relations = [];
                                    @endphp
                                    <tr id="item_relation_row_{{ $item_relation_row }}">
                                        <td class="text-center"
                                            style="vertical-align: middle;">
                                            <button type="button"
                                                    onclick="$('#item_relation_row_{{ $item_relation_row }}').remove();"
                                                    class="btn btn-xs btn-danger"
                                                    style="margin-bottom: 0; padding: 1px 3px;">
                                                <i class="fa fa-trash-o" style="font-size: 1rem;"></i>
                                            </button>
                                            <!-- input hidden -->
                                            <input type="text"
                                                    id="item_relation_id_{{ $item_relation_row }}"
                                                    name="item_relation[{{ $item_relation_row }}][id]"
                                                    value="{{ old('item_relation.' . $item_relation_row . '.id') }}">
                                            <!-- /.input hidden -->
                                        </td>
                                        <td class="text-center align-middle">

                                          <select class="form-control input-sm"  id="'item_relation_relation_id_' . $item_relation_row" name="old('item_relation.' . $item_relation_row . '.relation_id')" required>
                                            <option selected="selected" value="">{{ trans('message.selectopt') }}</option>

                                          </select>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span id="item_relation_uuid_{{ $item_relation_row }}">{{$tmp_uuid}}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                @php
                                    $item_relation_row++;
                                @endphp
                                <!-- /Items -->
                                <!-- Agregar nuevo item -->
                                <tr id="add_item_relation">
                                    <td class="text-center">
                                        <button type="button"
                                                onclick="addItemCfdiRelation();"
                                                class="btn btn-xs btn-primary"
                                                style="margin-bottom: 0;">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </td>
                                    <td class="text-right" colspan="2"></td>
                                </tr>
                              </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
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
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View customer credit notes') )
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

  <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
  <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

  <style media="screen">
    th { font-size: 12px !important; }
    td { font-size: 10px !important; }
    .btn-xs {
      padding: .35rem .4rem .25rem !important;
    }
    input {
      padding-left: 0px !important;
      padding-right: : 0px !important;
    }
    .datepicker td, .datepicker th {
        width: 1.5em !important;
        height: 1.5em !important;
    }
    .select2-container--bootstrap .select2-selection--multiple .select2-search--inline .select2-search__field {
      height: 48px !important;
    }
  </style>
  <script type="text/javascript">
    var item_row = "{{ $item_row }}";
    var item_reconciled_row = "{{ $item_reconciled_row }}";
    var item_relation_row = "{{ $item_relation_row }}";
    $(function() {
      //-----------------------------------------------------------
      $("#iva").select2({
        theme: 'bootstrap',
        placeholder: 'Elije...',
        dropdownAutoWidth : true,
        width: 'auto',
        width: "100%",
        height: "110%"
      });
      //-----------------------------------------------------------
    });
    function addItem() {
      let customer_id = $("#form select[name='customer_id']").val();
      let currency_id = $("#form select[name='currency_id']").val();
      if (customer_id  && currency_id) {
        var html = '';

        html += '<tr id="item_row_' + item_row + '">';

        html += '<td class="text-center" style="vertical-align: middle;">';
        html += '<button type="button" onclick="$(\'#item_row_' + item_row + '\').remove(); totalItem();" class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
        html += '<i class="fa fa-trash" style="font-size: 1rem;"></i>';
        html += '</button>';
        html += '<input type="hidden" name="item[' + item_row + '][id]" id="item_id_' + item_row + '" /> ';
        html += '</td>';

        html += '<td>';
        html += '<div class="form-group form-group-sm">';
        html += '<div class="input-group input-group-sm">';
        html += '<select class="form-control input-sm col-product-id" name="item[' + item_row + '][product_id]" id="item_product_id_' + item_row + '" data-row="' + item_row + '">';
        html += '<option selected="selected" value="">@lang('general.text_select')</option>';
        @forelse ($product as $product_data)
        html += '<option value="{{ $product_data->id  }}">{{ $product_data->name }}</option>';
        @empty
        @endforelse
        html += '</select>';
        html += '</div>';
        html += '</div>';
        html += '</td>';

        html += '<td>';
        html += '<div class="form-group form-group-sm">';
        html += '<textarea class="form-control input-sm col-name-id" name="item[' + item_row + '][name]" id="item_name_' + item_row + '" required rows="5" autocomplete="off" />';
        html += '</textarea>';
        html += '</div>';
        html += '</td>';

        html += '<td>';
        html += '<div class="form-group form-group-sm">';
        html += '<select class="form-control input-sm col-unit-measure-id" name="item[' + item_row + '][unit_measure_id]" id="item_unit_measure_id_' + item_row + '" required>';
        html += '<option selected="selected" value="">@lang('general.text_select')</option>';
        @forelse ($unitmeasures as $unitmeasures_data)
          html += '<option value="{{ $unitmeasures_data->id  }}">[{{ $unitmeasures_data->code }}]{{ $unitmeasures_data->name }}</option>';
        @empty
        @endforelse
        html += '</select>';
        html += '</div>';
        html += '</td>';

        html += '<td>';
        html += '<div class="form-group form-group-sm">';
        html += '<select class="form-control input-sm col-sat-product-id" name="item[' + item_row + '][sat_product_id]" id="item_sat_product_id_' + item_row + '" required>';
        html += '<option selected="selected" value="">@lang('general.text_select')</option>';
        @forelse ($satproduct as $satproduct_data)
          html += '<option value="{{ $satproduct_data->id  }}">[{{ $satproduct_data->code }}]{{ $satproduct_data->name }}</option>';
        @empty
        @endforelse
        html += '</select>';
        html += '</div>';
        html += '</td>';

        html += '<td>';
        html += '<div class="form-group form-group-sm">';
        html += '<input type="number" class="form-control input-sm text-right col-quantity" name="item[' + item_row + '][quantity]" id="item_quantity_' + item_row + '" required step="any" />';
        html += '</div>';
        html += '</td>';

        html += '<td>';
        html += '<div class="form-group form-group-sm">';
        html += '<input type="number" class="form-control input-sm text-right col-price-unit" name="item[' + item_row + '][price_unit]" id="item_price_unit_' + item_row + '" required step="any" />';
        html += '</div>';
        html += '</td>';

        html += '<td>';
        html += '<div class="form-group form-group-sm">';
        html += '<select class="form-control input-sm col-cuentac" name="item[' + item_row + '][cuentac]" id="item_cuentac_' + item_row + '" >';
        html += '<option selected="selected" value="">@lang('general.text_select')</option>';
        @forelse ($cuentas_contables as $cuentas_contables_data)
          html += '<option value="{{ $cuentas_contables_data->id  }}">{{ $cuentas_contables_data->cuenta }} {{ $cuentas_contables_data->nombre }}</option>';
        @empty
        @endforelse
        html += '</select>';
        html += '</div>';
        html += '</td>';

        html += '<td class="text-right" style="padding-top: 11px;">';
        html += '<span id="item_txt_amount_untaxed_' + item_row + '">0</span>';
        html += '</td>';


        html += '</tr>';

        $("#form #items tbody #add_item").before(html);

        /* Configura lineas*/
        initItem();
        //
        // totalItem();
        item_row++;
      }
      else {
        Swal.fire({
           type: 'error',
           title: 'Oops...',
           text: 'Selecciona un cliente y moneda',
         });
      }
    }

    function initItem() {
      $("#form .my-select2").select2({
        placeholder: 'Elija',
        theme: "bootstrap",
        dropdownAutoWidth: true,
      });
      $("#form #items tbody .my-select2").select2({
        placeholder: 'Elija',
        theme: "bootstrap",
        dropdownAutoWidth: true,
      });
      $("#form #items tbody .col-product-id").select2({
        theme: "bootstrap",
        placeholder: "Selecciona",
        dropdownAutoWidth : true,
        width: "100%",
        height: "110%"
      });
      $("#form #items tbody .col-cuentac").select2({
        theme: "bootstrap",
        placeholder: "Selecciona",
        dropdownAutoWidth : true,
        width: "100%",
        height: "110%"
      });
      /*Selecciona producto*/
      $(document).on('select2:select', '#form #items tbody .col-product-id', function (e) {
          let id = $(this).val();
          let row = $(this).attr('data-row');
          if (id) {
            $.ajax({
                url: "/sales/customer-credit-notes/get-product",
                type: "GET",
                dataType: "JSON",
                data: "id=" + id,
                success: function (data) {
                      $("#form #item_id_" + row).val(data[0].id);
                      $("#form #item_name_" + row).val(data[0].descripcion);
                      $("#form #item_unit_measure_id_" + row).val(data[0].unit_measure_id);
                      $("#form #item_sat_product_id_" + row).val(data[0].sat_product_id);
                      $("#form #item_price_unit_" + row).val(data[0].price);
                      addAccountingAccounts(id,row);
                      // $("#form #item_cuentac_" + row).val(data[0].currency_id);
                      // initItem();
                      // totalItem();
                },
                error: function (error, textStatus, errorThrown) {
                    if (error.status == 422) {
                        var message = error.responseJSON.error;
                        $("#general_messages").html(alertMessage("danger", message));
                    } else {
                        alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                    }
                }
            });
          }
      });
    }
    //Añadir cuentas contables
    function addAccountingAccounts(id, fila){
      let ident = id;
      let row = fila;
      var token = $('input[name="_token"]').val();
      $.ajax({
        type: "POST",
        url: "/sales/customer-credit-notes/get-accounting-account-product",
        data: { _token : token, ident: ident },
        success: function (data){
          $("#form #item_cuentac_"+row+" option[value!='']").remove();
          $("#form #item_cuentac_"+row).val('').trigger('change');
          $.each(JSON.parse(data),function(index, objdata){
            $("#form #item_cuentac_"+row).append('<option value="'+objdata.id+'">'+ objdata.cuenta +' '+ objdata.nombre +'</option>');
          });
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
    //Total de lineas
    function totalItem() {
        $.ajax({
            url: "/sales/customer-credit-notes/total-lines",
            type: "POST",
            dataType: "JSON",
            data: $("#form").serialize(),
            success: function (data) {
                console.log(data);

                if (data) {
                    $.each(data.items, function (key, value) {
                        $("#item_txt_amount_untaxed_" + key).html(value);
                    });
                    $("#form #txt_amount_untaxed").html(data.amount_untaxed);
                    $("#form #txt_amount_tax").html(data.amount_tax);
                    $("#form #txt_amount_total").html(data.amount_total);
                    $("#form input[name='amount_total_tmp']").val(data.amount_total_tmp);

                    totalItemReconciled(); //Calcula los datos conciliados
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
                } else {
                  Swal.fire({
                   type: 'error',
                   title: 'Oops2...',
                   text: errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText,
                  });
                    // alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                }
            }
        });
    }
    /*Seleccionar el tipo de cambio con fix*/
    $('#currency_id').on("change", function(){
      var valor = $(this).val();
      var token = $('input[name="_token"]').val();
      if (valor === '1') {
        $('#currency_value').val('1');
        getCustomerInvoiceBalances(); //AQUI
        totalItem();//Reestructura los totales
      }else{
        $.ajax({
          url: "/sales/customer-invoices/currency_now",
          type: "POST",
          data: { _token : token, id_currency: valor },
          success: function (data) {
              $('#currency_value').val(data);
              //Obtener facturas con saldos
              getCustomerInvoiceBalances(); //AQUI
              //Reestructura los totales
              totalItem();
          },
          error: function (error, textStatus, errorThrown) {
              if (error.status == 422) {
                  var message = error.responseJSON.error;
                  $("#general_messages").html(alertMessage("danger", message));
              } else {
                  alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
              }
          }
        });
      }
    });

    $(function () {
      //-----------------------------------------------------------
      $("#form").validate({
        ignore: "input[type=hidden]",
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
              if(attr == 'iva'){
                error.insertAfter($('#cont_iva'));
              }
              else {
                error.insertAfter(element);
              }
            }
          },
          rules: {
            cfdi_relation_id: {
              required: function(element) {
                // console.log($(".verCfdiRelation").toArray().length);
                  if ($(".verCfdiRelation").toArray().length === 0) {
                    if ( $("#form select[name='cfdi_relation_id']").hasClass('required')){
                      $("#form select[name='cfdi_relation_id']").removeClass("required");
                      $("#form select[name='cfdi_relation_id']").removeClass("text-danger");
                      // console.log('false');
                      return false;
                    }
                  }
                  else {
                    $("#form select[name='cfdi_relation_id']").addClass("required");
                    // console.log('true');
                    return true;
                  }
              },
            }
          },
          messages: {
          },
          // debug: true,
          // errorElement: "label",
          submitHandler: function(e){
            var form = $('#form')[0];
            var formData = new FormData(form);
            $.ajax({
              type: "POST",
              url: "/sales/customer-credit-notes-store",
              data: formData,
              contentType: false,
              processData: false,
              success: function (data){
                if (data == 'success') {
                  let timerInterval;
                  Swal.fire({
                    type: 'success',
                    title: 'La factura de egresos se ha generado con éxito!',
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
                      window.location.href = "/sales/customer-credit-notes";
                    }
                  });
                }
                if (data == 'false') {
                  Swal.fire({
                      type: 'error',
                      title: 'Error encontrado..',
                      text: 'Error al crear el CFDI - Egreso!',
                    });
                }
                // console.log(data);
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
      /*Configurar el formato para la fecha*/
      $("#form input[name='date']").daterangepicker({
          singleDatePicker: true,
          timePicker: true,
          timePicker24Hour: true,
          showDropdowns: true,
          minDate: moment(),
          maxDate : moment().add(3, 'days'),
          locale: {
              format: "DD-MM-YYYY HH:mm:ss"
          },
          autoUpdateInput: true
          }, function (chosen_date) {
              $("#form input[name='date']").val(chosen_date.format("DD-MM-YYYY HH:mm:ss"));
      });
      /* Configura select2 para buscar cliente*/
      $("#form select[name='customer_id']").select2({
          theme: "bootstrap",
          placeholder: "Selecciona",
          dropdownAutoWidth : true,
          width: "100%",
          height: "110%"
          // allowClear: true,
        }).on("change", function () {
        let id = $(this).val();
        if (id) {
            //Si cambia de cliente necesito reiniciar la pestaña de cfdi, dado que solo las facturas del cliente mismo cliente se pueden enlazar
            for (var i = 1; i <= item_relation_row; i++) {
              if ($('#item_relation_row_'+i).length){
                $('#item_relation_row_'+i).remove();
              }
            }
            item_relation_row = 1 ;

            $.ajax({
                url: "{{ route('customers/get-customer') }}",
                type: "GET",
                dataType: "JSON",
                data: "id=" + id,
                success: function (data) {
                    $("#form select[name='salesperson_id']").val(data.salesperson_id);
                    $("#form select[name='payment_term_id']").val(data.payment_term_id);
                    $("#form select[name='payment_way_id']").val(data.payment_way_id);
                    $("#form select[name='payment_method_id']").val(data.payment_method_id);
                    $("#form select[name='cfdi_use_id']").val(data.cfdi_use_id);

                    //Obtener facturas con saldos
                    getCustomerInvoiceBalances(); //AQUI
                },
                error: function (error, textStatus, errorThrown) {
                    if (error.status == 422) {
                        var message = error.responseJSON.error;
                        $("#general_messages").html(alertMessage("danger", message));
                    } else {
                        alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                    }
                }
            });
        }
      });
      //Eventos
      $(document).on("change", "#form .col-taxes", function () {
        totalItem();
      });
      $(document).on("keyup", "#form #items tbody .col-quantity,#form #items tbody .col-price-unit", function () {
        totalItem();
      });
      /* Eventos en items_reconciled */
      $(document).on("keyup", "#form #items_reconciled tbody .col-amount-reconciled", function () {
        totalItemReconciled();
      });
      /* Eventos en items cfdi relation */
      /*Selecciona factura*/
      $(document).on('select2:select', '#form #items_relation tbody .col-relation-id', function (e) {
          let id = $(this).val();
          let row = $(this).attr('data-row');
          if (id) {
              $.ajax({
                  url: "customer-credit-notes/get-customer-credit-note",
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
                      } else {
                          alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                      }
                  }
              });
          }
      });
    });
    function addItemCfdiRelation() {
        let client = $("#form select[name='customer_id']").val();
        if (client != '') {
          var html = '';

          html += '<tr id="item_relation_row_' + item_relation_row + '">';
          html += '<td class="text-center" style="vertical-align: middle;">';
          html += '<button type="button" onclick="$(\'#item_relation_row_' + item_relation_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0;">';
          html += '<i class="fa fa-trash"></i>';
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
              url: "/sales/customer-invoices/autocomplete-cfdi",
              dataType: "JSON",
              delay: 250,
              data: function (params) {
                  return {
                      // term: $.trim(params.term),//LA PALABRA A BUSCAR
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
      });
    }
    function getCustomerInvoiceBalances() {
        let customer_id = $("#form select[name='customer_id']").val();
        let currency_id = $("#form select[name='currency_id']").val();
        let currency_value = $("#form input[name='currency_value']").val();
        let filter_currency_id = 1; //Filtra solo facturas de la misma moneda
        // $("#form #items_reconciled tbody").html('');
        if (customer_id != '' && currency_id != '') {
            $.ajax({
                url: "/sales/customer-invoices/balances",
                type: "GET",
                dataType: "JSON",
                data: "customer_id=" + customer_id + "&currency_id=" + currency_id + "&currency_value=" + currency_value + "&filter_currency_id=" + filter_currency_id + "",
                success: function (data) {
                  if (data != '[]') {
                    item_row = 0;
                    var html = '';
                    data.forEach(function(key,i) {
                        html += '<tr>';

                        html += '<td class="text-right" style="padding-top: 11px;">';

                        html += '<input type="hidden" id="item_reconciled_id_' + item_row + '" name="item_reconciled[' + item_row + '][id]" value="' + key.id + '"/> ';
                        html += '<input type="hidden" id="item_reconciled_reconciled_id_' + item_row + '" name="item_reconciled[' + item_row + '][reconciled_id]" value="' + key.reconciled_id + '" /> ';
                        html += '<input type="hidden" id="item_reconciled_name_' + item_row + '" name="item_reconciled[' + item_row + '][name]"  value="' + key.name + '" /> ';
                        html += '<input type="hidden" id="item_reconciled_balance_' + item_row + '" name="item_reconciled[' + item_row + '][balance]" value="' + key.balance + '" /> ';
                        html += '<input type="hidden" id="item_reconciled_currency_code_' + item_row + '" name="item_reconciled[' + item_row + '][currency_code]" value="' + key.currencie + '" /> ';

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
                        html += '<span id="item_reconciled_txt_balance_' + i + '">' + saldox + '</span>';
                        html += '</td>';

                        html += '<td class="text-right" style="padding-top: 11px;">';
                        html += '<input type="number" class="form-control form-control-sm text-right col-amount-reconciled" value="' + 0 + '"  name="item_reconciled[' + item_row + '][amount_reconciled]" id="item_reconciled_amount_reconciled_' + item_row + '" required step="any" />';
                        html += '</td>';

                        html += '</tr>';
                        $("#form #items_reconciled tbody").html(html);
                        item_row++;
                    })
                    totalItemReconciled();
                  }
                    // if (data.html) {
                    //     $("#form #items_reconciled tbody").html(data.html);
                    // }
                },
                error: function (error, textStatus, errorThrown) {
                    if (error.status == 422) {
                        var message = error.responseJSON.error;
                        $("#general_messages").html(alertMessage("danger", message));
                    } else {
                        alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                    }
                }
            });
        }
    }
    //Calcular los datos conciliados
    function totalItemReconciled() {
        $.ajax({
            url: "/sales/customer-credit-notes/total-reconciled-lines",
            type: "POST",
            dataType: "JSON",
            data: $("#form").serialize(),
            success: function (data) {
                if (data) {
                    // $.each(data.items_reconciled, function (key, value) {
                    //     $("#form #item_reconciled_txt_balance_" + key).html(value);
                    // });
                    $("#form #reconciled_txt_amount_total").html(data.amount_total);
                    $("#form #reconciled_txt_amount_reconciled").html(data.amount_reconciled);
                    $("#form #reconciled_txt_amount_per_reconciled").html(data.amount_per_reconciled);
                }
            },
            error: function (error, textStatus, errorThrown) {
                if (error.status == 422) {
                    var message = error.responseJSON.error;
                    $("#general_messages").html(alertMessage("danger", message));
                } else {
                    alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                }
            }
        });
    }


  </script>
  @else
  @endif
@endpush
