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
          {{-- <p class="mt-2 card-title">Nuevo.</p> --}}
          {{-- <div class="d-flex justify-content-center pt-3"></div> --}}

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
                <label for="select_sucursal" class="control-label">Sucursal:<span style="color: red;">*</span></label>
                <select id="select_sucursal" name="select_sucursal" class="form-control required" style="width:100%;">
                  <option value="">{{ trans('message.selectopt') }}</option>
                </select>
              </div>
            </div>

            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="sel_modal_coin" class="control-label">Moneda:<span style="color: red;">*</span></label>
                <select id="sel_modal_coin" name="sel_modal_coin" class="form-control required" style="width:100%;">
                  <option value="">{{ trans('message.selectopt') }}</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="inputTC">TC:<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="inputTC" name="inputTC" style="padding: 0.875rem 0.5rem;">
              </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="inputDateNow">Fecha actual:<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="inputDateNow" name="inputDateNow" value="@php $date = new DateTime("now", new DateTimeZone('America/Mexico_City'));echo $date->format('Y-m-d H:i:s');@endphp">
              </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="select_term_pago" class="control-label">Termino de pago:<span style="color: red;">*</span></label>
                <select id="select_term_pago" name="select_term_pago" class="form-control required" style="width:100%;">
                  <option value="">{{ trans('message.selectopt') }}</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="inputDateEnd">Fecha Vencimiento:<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="inputDateEnd" name="inputDateEnd" value="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="select_vendedor" class="control-label">Vendedor:<span style="color: red;">*</span></label>
                <select id="select_vendedor" name="select_vendedor" class="form-control required" style="width:100%;">
                  <option value="">{{ trans('message.selectopt') }}</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="select_forma_pago" class="control-label">Forma de pago:<span style="color: red;">*</span></label>
                <select id="select_forma_pago" name="select_forma_pago" class="form-control required" style="width:100%;">
                  <option value="">{{ trans('message.selectopt') }}</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="select_met_pago" class="control-label">Metodo de pago:<span style="color: red;">*</span></label>
                <select id="select_met_pago" name="select_met_pago" class="form-control required" style="width:100%;">
                  <option value="">{{ trans('message.selectopt') }}</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group">
                <label for="select_use_cfdi" class="control-label">Uso de cfdi:<span style="color: red;">*</span></label>
                <select id="select_use_cfdi" name="select_use_cfdi" class="form-control required" style="width:100%;">
                  <option value="">{{ trans('message.selectopt') }}</option>
                </select>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="inputReferencia">Referencia:<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="inputReferencia" name="inputReferencia" value="">
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
                        <div class="table-responsive ">
                            <table class="table table-items table-condensed table-hover table-bordered table-striped jambo_table mt-5"
                                   id="items" style="min-width: 600px;">
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
                                    <th width="5%"
                                        class="text-center">
                                        Cantidad<span class="required text-danger">*</span>
                                    </th>
                                    <th width="7%"
                                        class="text-center">
                                        Precio
                                        <span class="required text-danger">*</span>
                                    </th>
                                    <th width="5%"
                                        class="text-center text-nowrap">
                                          Desc. %
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

                                <!-- /Items -->
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
                                    class="text-center">@lang('general.column_actions')</th>
                                <th width="25%"
                                    class="text-center">
                                    @lang('sales/customer_invoice.column_relation_relation_id')
                                </th>
                                <th width="65%"
                                    class="text-center">@lang('sales/customer_invoice.column_relation_uuid')</th>
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

        </div>
      </div>
    </div>
  </div>



  {{-- @else --}}
  {{-- @endif --}}
@endsection

@push('scripts')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <script src="{{ asset('js/admin/sales/customers_invoices.js')}}"></script>

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
  </style>
  {{-- @else --}}
  {{-- @endif  --}}
@endpush
