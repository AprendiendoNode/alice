@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.customers_invoices') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.customers_invoices') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('content')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <form id="form" name="form" enctype="multipart/form-data">
            {{ csrf_field() }}

          {{-- <p class="mt-2 card-title">Nuevo.</p> --}}
          {{-- <div class="d-flex justify-content-center pt-3"></div> --}}
          <input type="hidden"
              id="amount_total_tmp"
              name="amount_total_tmp"
              value="{{ old('amount_total_tmp',0) }}">


          <div class="row">
            <div class="col-md-6 col-xs-12">
              <label for="inputGroupSelect04" class="control-label  my-2">Clientes:<span style="color: red;">*</span></label>
              <div class="input-group">
                <select class="custom-select" id="inputGroupSelect04">
                  <option selected>Choose...</option>
                  @forelse ($customer as $customer_data)
                    {{-- <option value="{{ $banks_data->id  }}">{{ $banks_data->name }}</option> --}}
                    <option value="{{ $customer_data->id  }}">{{ $customer_data->name }}</option>
                  @empty
                  @endforelse
                </select>
                <div class="input-group-append">
                  <button class="btn btn btn-outline-primary btn-sm" type="button"><i class="fas fa-search"></i></button>
                  <button class="btn btn-outline-info btn-sm" type="button"><i class="fas fa-plus-square"></i></button>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-xs-12">
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
          </div>
          <div class="row">
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="currency_value">TC:<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="currency_value" name="currency_value" style="padding: 0.875rem 0.5rem;">
              </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="date">Fecha actual:<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="date" name="date" value="@php $date = new DateTime("now", new DateTimeZone('America/Mexico_City'));echo $date->format('Y-m-d H:i:s');@endphp">
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
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="date_due">Fecha Vencimiento:<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="date_due" name="date_due" value="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="salesperson_id" class="control-label">Vendedor:<span style="color: red;">*</span></label>
                <select id="salesperson_id" name="salesperson_id" class="form-control required" style="width:100%;">
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
                <select id="payment_way_id" name="payment_way_id" class="form-control required" style="width:100%;">
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
                <select id="payment_method_id" name="payment_method_id" class="form-control required" style="width:100%;">
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
                <select id="cfdi_use_id" name="cfdi_use_id" class="form-control required" style="width:100%;">
                  <option value="">{{ trans('message.selectopt') }}</option>
                  @forelse ($cfdi_uses as $cfdi_uses_data)
                  <option value="{{ $cfdi_uses_data->id }}"> {{ $cfdi_uses_data->name }} </option>
                  @empty
                  @endforelse
                </select>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="reference">Referencia:<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="reference" name="reference" value="">
              </div>
            </div>
          </div>

          <!---------------------------------------------------------------------------------->
          <div class="row mt-5">
            <div class="col-md-12">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Productos</a>
                  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">CFDI</a>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                  <!-------------------------------------------------------------------------------->
                  <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="table-responsive" style="fontsize: 8px;">
                            <table class="table table-items table-condensed table-hover table-bordered table-striped jambo_table mt-5"
                                   id="items" style="min-width: 1800px;">
                                <thead>
                                <tr>
                                    <th width="5%"
                                        class="text-center">
                                        Opciones
                                    </th>
                                    <th width="12%"
                                        class="text-center">
                                        Producto
                                    </th>
                                    <th class="text-left">
                                      Descripción
                                      <span class="required text-danger">*</span>
                                    </th>
                                    <th width="10%" class="text-center">
                                      Unidad de medida
                                      <span class="required text-danger">*</span>
                                    </th>
                                    <th width="12%"
                                        class="text-center">
                                        Prod/Serv SAT
                                        <span class="required text-danger">*</span>
                                    </th>
                                    <th width="8%"
                                        class="text-center">
                                        Cantidad<span class="required text-danger">*</span>
                                    </th>
                                    <th width="8%"
                                        class="text-center">
                                        Precio
                                        <span class="required text-danger">*</span>
                                    </th>
                                    <th width="8%"
                                        class="text-center text-nowrap">
                                          Desc. %
                                    </th>
                                    <th width="8%"
                                        class="text-center">
                                        Moneda<span class="required text-danger">*</span>
                                    </th>
                                    <th width="11%"
                                        class="text-center">Impuestos
                                    </th>
                                    <th width="9%"
                                        class="text-right">
                                        Total
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                <!-- Items -->
                                @php
                                    $item_row = 0;
                                    $items = (empty(old('item')) ? [] : old('item'));
                                @endphp
                                @foreach ($items as $item_row => $item)
                                  @php
                                    $tmp_products = [];
                                  @endphp
                                  <tr id="item_row_{{ $item_row }}">
                                    <td class="text-center" style="vertical-align: middle;">
                                        <button type="button"
                                                onclick="$('#item_row_{{ $item_row }}').remove(); totalItem();"
                                                class="btn btn-xs btn-danger"
                                                style="margin-bottom: 0;">
                                                <i class="fa fa-trash-o"></i>
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
                                        id="item{{ $item_row.'['.$item.']'}}"
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
                                            <option value="{{ $unitmeasures_data->id  }}">{{ $unitmeasures_data->name }}</option>
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
                                            <option value="{{ $satproduct_data->id  }}">{{ $satproduct_data->name }}</option>
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
                                        name="item[{{ $item_row }}][discount]"
                                        value="{{old('item.' . $item_row . '.discount')}}"
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
                                    <td>
                                      <div class="form-group form-group-sm">
                                        <select class="form-control input-sm"  id="item{{ $item_row.'[taxes]'}}" name="item[{{ $item_row }}][taxes]" required>
                                          <option selected="selected" value="">{{ trans('message.selectopt') }}</option>
                                          @forelse ($impuestos as $impuestos_data)
                                            <option value="{{ $impuestos_data->id  }}">{{ $impuestos_data->name }}</option>
                                          @empty
                                          @endforelse
                                        </select>
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
                                <!-- Agregar nuevo item -->
                                <tr id="add_item">
                                    <td class="text-center">
                                        <button type="button" onclick="addItem();"
                                                class="btn btn-xs btn-primary"
                                                style="margin-bottom: 0;">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </td>
                                    <td class="text-right" colspan="9"></td>
                                </tr>
                                <!-- Totales -->
                                <tr>
                                    <td></td>
                                    <td class="text-right" colspan="7" rowspan="3"
                                        style="vertical-align: middle">
                                    </td>
                                    <td class="text-right">
                                        <strong>Subtotal</strong>
                                    </td>
                                    <td class="text-right"><span id="txt_amount_untaxed">0</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right">
                                        <strong>Impuesto</strong></td>
                                    <td class="text-right"><span id="txt_amount_tax">0</span></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right">
                                        <strong>Total</strong></td>
                                    <td class="text-right"><span id="txt_amount_total">0</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                        <!--------------------------------------------------------------------------------->

                        <!--------------------------------------------------------------------------------->
                    </div>
                  </div>
                  <!-------------------------------------------------------------------------------->
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                  <!-------------------------------------------------------------------------------->
                  <div class="row">
                    <div class="col-md-4 col-xs-12">
                      <div class="form-group row">
                        <label for="select_seven" class="col-md-12 col-form-label ml-0">Tipo de relación<span style="color: red;">*</span></label>
                        <div class="col-md-12 ml-0">
                          <select  id="select_seven" name="select_seven" class="form-control form-control-sm required"  style="width: 100%;">
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
                        <table class="table table-items table-condensed table-hover table-bordered table-striped"
                                id="items_relation">
                            <thead>
                            <tr>
                                <th width="5%"
                                    class="text-center">Opciones</th>
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
                            <!-- Items -->
                            @php
                                $item_relation_row = 0;
                                $items_relation = old('item_relation',[]);
                            @endphp
                            @foreach ($items_relation as $item_relation_row => $item)
                                @php
                                    $tmp_uuid = '';
                                    $tmp_customer_invoice_relations = [];
                                    if(!empty(old('item_relation.' . $item_relation_row . '.relation_id'))){
                                        $tmp = \App\Models\Sales\CustomerInvoice::find(old('item_relation.' . $item_relation_row . '.relation_id'));
                                        $tmp_customer_invoice_relations = $tmp->get()->pluck('text_select2','id');
                                        $tmp_uuid = !empty($tmp) ? $tmp->customerInvoiceCfdi->uuid : '';
                                    }
                                @endphp
                                <tr id="item_relation_row_{{ $item_relation_row }}">
                                    <td class="text-center"
                                        style="vertical-align: middle;">
                                        <button type="button"
                                                onclick="$('#item_relation_row_{{ $item_relation_row }}').remove();"
                                                class="btn btn-xs btn-danger"
                                                style="margin-bottom: 0;">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        <!-- input hidden -->
                                        <input type="hidden"
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
                  <!-------------------------------------------------------------------------------->
                </div>

              </div>
            </div>
          </div>

          <!---------------------------------------------------------------------------------->
          </form>
        </div>
      </div>
    </div>
  </div>



  {{-- @else --}}
  {{-- @endif --}}
@endsection

@push('scripts')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  {{-- <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script> --}}
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
  {{-- <script src="{{ asset('js/admin/sales/customers_invoices.js')}}"></script> --}}

  <script type="text/javascript">
      var item_row = "{{ $item_row }}";
      var item_relation_row = "{{ $item_relation_row }}";
      function addItem() {
          var html = '';
          html += '<tr id="item_row_' + item_row + '">';
          html += '<td class="text-center" style="vertical-align: middle;">';
          html += '<button type="button" onclick="$(\'#item_row_' + item_row + '\').remove(); totalItem();" class="btn btn-xs btn-danger" style="margin-bottom: 0;">';
          html += '<i class="fa fa-trash"></i>';
          html += '</button>';
          html += '<input type="hidden" name="item[' + item_row + '][id]" id="item_id_' + item_row + '" /> ';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<div class="input-group input-group-sm">';
          html += '<select class="form-control input-sm col-product-id" name="item[' + item_row + '][product_id]" id="item_product_id_' + item_row + '" data-row="' + item_row + '">';
          html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
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
          html += '<textarea class="form-control input-sm col-name-id" name="item[' + item_row + '][name]" id="item_name_' + item_row + '" placeholder="" required rows="2" autocomplete="off" />';
          html += '</textarea>';
          html += '</div>';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<select class="form-control input-sm col-unit-measure-id" name="item[' + item_row + '][unit_measure_id]" id="item_unit_measure_id_' + item_row + '" required>';
          html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
          @forelse ($unitmeasures as $unitmeasures_data)
            html += '<option value="{{ $unitmeasures_data->id  }}">{{ $unitmeasures_data->name }}</option>';
          @empty
          @endforelse
          html += '</select>';
          html += '</div>';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<select class="form-control input-sm col-sat-product-id" name="item[' + item_row + '][sat_product_id]" id="item_sat_product_id_' + item_row + '" required>';
          html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
          @forelse ($satproduct as $satproduct_data)
            html += '<option value="{{ $satproduct_data->id  }}">{{ $satproduct_data->name }}</option>';
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
          html += '<input type="number" class="form-control input-sm text-center col-discount" name="item[' + item_row + '][discount]" id="item_discount_' + item_row + '" step="any" />';
          html += '</div>';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="number" class="form-control input-sm text-center col-current" name="item[' + item_row + '][current]" id="item_current_' + item_row + '" step="any" />';
          html += '</div>';
          html += '</td>';      

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<select class="form-control input-sm my-select2 col-taxes" name="item[' + item_row + '][taxes][]" id="item_taxes_' + item_row + '" multiple>';
          @forelse ($impuestos as $impuestos_data)
            html += '<option value="{{ $impuestos_data->id  }}">{{ $impuestos_data->name }}</option>';
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
          // totalItem();
          item_row++;
      }
      function initItem() {
        /*Para impuestos*/
        $("#form #items tbody .my-select2").select2({
          theme: 'bootstrap',
          placeholder: 'Elija',
          dropdownAutoWidth : true,
          width: 'auto'
        });
        $("#form #items tbody .col-product-id").select2();
      }
      /*Selecciona producto*/
            $(document).on('select2:select', '#form #items tbody .col-product-id', function (e) {
                let id = $(this).val();
                let row = $(this).attr('data-row');
                if (id) {
                    $.ajax({
                        url: "/sales/products/get-product",
                        type: "GET",
                        dataType: "JSON",
                        data: "id=" + id,
                        success: function (data) {
                            $("#form #item_name_" + row).val(data[0].description);
                            $("#form #item_unit_measure_id_" + row).val(data[0].unit_measure_id);
                            $("#form #item_sat_product_id_" + row).val(data[0].sat_product_id);
                            $("#form #item_price_unit_" + row).val(data[0].price);
                            initItem();
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
            $(document).on("change", "#form #items tbody .col-taxes", function () {
                totalItem();
            });
            $(document).on("keyup", "#form #items tbody .col-quantity,#form #items tbody .col-price-unit,#form #items tbody .col-discount", function () {
                totalItem();
            });
            function totalItem() {
            $.ajax({
                url: "/sales/customer-invoices/total-lines",
                type: "POST",
                dataType: "JSON",
                data: $("#form").serialize(),
                success: function (data) {
                    if (data) {
                        $.each(data.items, function (key, value) {
                            $("#item_txt_amount_untaxed_" + key).html(value);
                        });
                        $("#form #txt_amount_untaxed").html(data.amount_untaxed);
                        $("#form #txt_amount_tax").html(data.amount_tax);
                        $("#form #txt_amount_total").html(data.amount_total);
                        $("#form input[name='amount_total_tmp']").val(data.amount_total_tmp)
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

  <style media="screen">
    input {
      padding-left: 0px !important;
      padding-right: : 0px !important;

    }
    /* .select2-selection__rendered {
      line-height: 44px !important;
      padding-left: 20px !important;
    }
    .select2-selection {
      height: 42px !important;
    }
    .select2-selection__arrow {
      height: 36px !important;
    } */
  </style>
  {{-- @else --}}
  {{-- @endif  --}}
@endpush