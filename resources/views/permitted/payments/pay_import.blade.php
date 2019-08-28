@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View manage bank account') )
    {{ trans('message.manage') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View manage bank account') )
    {{ 'Plantilla de importación' }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View manage bank account') )
    {{ trans('message.breadcrumb_manage_account') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  <div class="modal modal-default fade" id="modal_bank" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fas fa-university" style="margin-right: 4px;"></i>{{ trans('pay.data_bakl') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card table-responsive">
              <div class="card-body">
                @if( auth()->user()->can('Create data bank') )
                    <form class="form-horizontal" id="data_account_bank" name="data_account_bank">
                      {{ csrf_field() }}
                      <div class="row form-group">
                        <label for="reg_provider" class="control-label">{{ trans('pay.proveedor') }}:</label>
                        <input class="form-control" type="text" name="reg_provider" id="reg_provider" value="" readonly>
                      </div>
                      <div class="row py-2 form-group">
                        <label for="reg_bancos" class="control-label">{{ trans('pay.bank') }}:</label>
                        <select id="reg_bancos" name="reg_bancos" class="form-control select2">
                          <option value="" selected>{{ trans('pay.select_op') }}</option>
                          @forelse ($banquitos as $data_banquitos)
                            <option value="{{ $data_banquitos->id }}"> {{ $data_banquitos->nombre }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                      <div class="row form-group">
                        <label for="reg_coins" class="control-label">{{ trans('pay.type_coins') }}:</label>
                        <select id="reg_coins" name="reg_coins" class="form-control select2">
                          <option value="" selected>{{ trans('pay.select_op') }}</option>
                          @forelse ($currency as $data_currency)
                            <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                      <div class="row py-2 form-group">
                        <label for="reg_cuenta" class="control-label">{{ trans('pay.cuenta') }}:</label>
                        <input class="form-control" type="text" name="reg_cuenta" id="reg_cuenta" value="">
                      </div>
                      <div class="row form-group">
                        <label for="reg_clabe" class="control-label">{{ trans('pay.clabe') }}:</label>
                        <input class="form-control" type="text" name="reg_clabe" id="reg_clabe" value="">
                      </div>
                      <div class="row py-2 form-group">
                        <label for="reg_reference" class="control-label">{{ trans('pay.reference') }}:</label>
                        <input class="form-control" type="text" name="reg_reference" id="reg_reference" value="">
                      </div>
                      @if( auth()->user()->can('Create data bank provider') )
                        <button type="submit" class="btn btn-secondary"><i class="fas fa-plus-square" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button>
                        <!-- <button type="button" class="btn bg-navy create_provider"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button> -->
                      @endif
                      <button type="button" class="btn btn-danger delete_provider" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }} & {{ trans('message.ccmodal') }}</button>

                    </form>
                @else
                  <div class="col-xs-12">
                    @include('default.deniedmodule')
                  </div>
                @endif
              </div>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
  </div>

  <div id="ajax-alert" class="alert" style="display:none">
    <h4 id='title-alert'></h4>
    <strong id='texto-alert'></strong>
  </div>
    @if( auth()->user()->can('View add request of payment') )
      <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-title">
                  <h3 class="card-title"></h3>
                  <!--  Inicio del header de pago -->
                    <div class="row d-flex justify-content-space-around align-items-center">
                      <div class="col-md-2">
                        <img class="logo-sit mr-3" src="{{ asset('/images/users/logo.svg') }}" style="padding-bottom:20px;width:100px" />
                      </div>
                      <div class="col-md-6 text-center">
                        <h4 class="pt-20">{{ trans('pay.titlemulti') }}</h4>
                      </div>
                      <div style="padding-top:1em;" class="col-md-4">
                        <p class="text-right mr-2">
                          <strong>{{ trans('pay.date_solicitude') }}:
                              @php
                               $mytime = Carbon\Carbon::now();
                               echo $mytime->toDateTimeString();
                              @endphp
                          </strong>
                        </p>
                      </div>
                    </div>
                  <div class="box-tools pull-right"></div>
                </div>
                <!-- /.box-header -->
                <div class="card-body">

                      <form id="validation" name="validation" class="form-horizontal" method="POST">
                        {{ csrf_field() }}
                        <div class="row pb-2">
                            <div class="form-group col-md-6">
                              <label class="control-label">C.C.</label>
                              <input type="text" class="form-control form-control-sm" name="cc_key" id="cc_key" readonly />
                            </div>
                        </div>

                          <div class="row py-2">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="classif_id">Servicio:</label>
                                <div class="col-xs-10 selectContainer">
                                  <select id="classif_id" name="classif_id" class="form-control form-control-sm select2">
                                    <option value="">Elija...</option>
                                      @forelse ($cxclassifications as $data_service)
                                        <option value="{{ $data_service->id }}"> {{ $data_service->name }} </option>
                                      @empty
                                      @endforelse
                                  </select>
                                </div>
                              </div>

                              <div class="form-group py-2">
                                <label for="dyn_field[0]">Nivel 1:</label>
                                <div class="col-xs-10 selectContainer">
                                  <select name="dyn_field[0]" class="form-control form-control-sm select2 changeField0">
                                    <option value="">Elija...</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group py-2 hide" id="template_cc">
                                <label for="dyn_field" class="change_label">xxxx_1:</label>
                                <div class="col-xs-9 selectContainer">
                                  <select name="dyn_field" class="form-control form-control-sm select2">
                                    <option value="">Elija...</option>
                                  </select>
                                </div>
                              </div>
                                <div class="form-group py-2">
                                  <label for="" class="control-label">Orden de compra:</label>
                                  <div>
                                    <input class="form-control form-control-sm" type="text" id="purchase_order" name="purchase_order" value="" placeholder="Required">
                                  </div>
                                </div>
                                <div class="form-group has-feedback py-2">
                                  <label class="control-label">Fecha limite de pago:</label>
                                  <div class="dateContainer">
                                      <div class="input-group input-append date" id="limitDatePicker" name="limitDatePicker">
                                          <span class="input-group-addon add-on"><span class="fas fa-calendar-alt fa-2x"></span></span>
                                          <input type="text" class="form-control form-control-sm" name="date_limit" placeholder="01/01/2019">
                                      </div>
                                   </div>
                                </div>
                                <div class="form-group py-2">
                                  <label for="priority_viat" class="control-label">{{ trans('pay.prioridad') }}: </label>
                                  <div class="">
                                    <select id="priority_viat" name="priority_viat" class="form-control form-control-sm">
                                      @forelse ($priority as $data_priority)
                                        @if ($data_priority->id === 2)
                                          <option value="{{ $data_priority->id }}" selected> {{ $data_priority->name }} </option>
                                        @else
                                          <option value="{{ $data_priority->id }}"> {{ $data_priority->name }} </option>
                                        @endif
                                      @empty
                                      @endforelse
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group py-2">
                                  <label for="" class="control-label"> Forma de pago:</label>
                                  <div class="">
                                    <select name="methodpay" class="form-control form-control-sm">
                                        @forelse ($way as $data_way)
                                          <option value="{{ $data_way->id }}"> {{ $data_way->name }} </option>
                                        @empty
                                        @endforelse
                                    </select>
                                  </div>
                                </div>

                            </div>
                            <!--- Datos pago--->
                            <div class="col-md-6">
                              <div class="form-group py-2">
                                <label for="provider" class="control-label">{{ trans('pay.proveedor') }}:</label>
                                <div class="">
                                  <select id="provider" name="provider" class="form-control form-control-sm select2">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    @forelse ($proveedor as $data_proveedor)
                                      <option value="{{ $data_proveedor->id }}"> {{ $data_proveedor->nombre }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                                </div>
                              </div>

                              <div class="form-group py-2">
                                <label for="" class="control-label">No. Factura:</label>
                                <div class="">
                                  <input class="form-control form-control-sm" type="text" id="factura" placeholder="Required" name="factura" value="">
                                </div>
                              </div>
                              <div class="form-group py-2">
                                <label for="" class="control-label">Monto Total: </label>
                                <div class="">
                                  <input class="form-control form-control-sm monto" value="0" type="text" id="amount" name="amount" value="">
                                </div>
                              </div>
                              <div class="form-group py-2">
                                <label for="" class="control-label">Moneda: </label>
                                <div class="">
                                  <select id="coin" name="coin" class="form-control form-control-sm" readonly>
                                    <option value="0" selected ="true">{{ trans('pay.select_op') }}</option>
                                    @forelse ($currency as $data_currency)
                                      <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                                </div>
                              </div>
                                <div class="form-inline py-2">
                                    <label class="control-label" style="width: 20%;" for="">IVA:</label>
                                    <input id="iva_format" class="form-control form-control-sm" style="width: 30%;" required readonly type="text" name="iva_format" value="">
                                    <input id="iva" class="form-control" required readonly type="hidden" name="iva" value="">
                                    <label class="control-label" style="width: 20%;" for="">Total:</label>
                                    <input id="totales_format" name="totales_format" style="width: 30%;" class="form-control form-control-sm" required readonly type="text" name="" value="">
                                    <input type="hidden" class="form-control" id="totales" name="totales" readonly/>
                                </div>
                            <div class="row">
                              <div class="form-group">
                                <label for="" class="col-md-3 control-label"></label>
                                <div class="col-md-8" id="amount_info">

                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="">
                                <div class="checkbox pl-5">
                                  <label>
                                    <input type="checkbox" id="check_iva" name="check_iva">
                                    No calcular IVA.
                                  </label>
                                </div>

                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="form-inline">
                                <div class="col-md-3">
                                  <!--<button class="btn btn-primary" type="button" name="button">Ver ID'S</button>-->
                                </div>
                                <div class="col-md-9">
                                  <div class="input-group" id="file_upload_excel">
                                      <label class="input-group-btn">
                                          <span class="btn btn-success">
                                              <i class="far fa-file-excel"></i>  Subir plantilla Excel
                                              <input id="file_excel" name="file_excel" type="file" style="display: none;">
                                          </span>
                                        </label>
                                      <input type="text" class="form-control" readonly>
                                    </div>
                                  </div>
                              </div>
                            </div>
                            </div>
                          </div>
                          <!---->

                        <!--Visualización tabla-->
                        <div class="row">
                          <div class="form-group m-auto">
                            <div style="display:none;" id="img-loading" class="col-md-12 text-center">
                                <img width="150" src="{{ asset('images/users/data-loading.gif')}}" alt="">
                            </div>
                            <div class="col-12">
                              <table class="table" id=preview_excel>
                                <thead>
                                  <tr>
                                    <th>Id grupo</th>
                                    <th>Grupo</th>
                                    <th>Id anexo</th>
                                    <th>Anexo</th>
                                    <th>Ubicación_id</th>
                                    <th>Monto</th>
                                    <th class="iva">IVA</th>
                                    <th class="monto_iva">Monto IVA</th>
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th>Totales:</th>
                                  <th id="subtotal_excel">0.00</th>
                                  <th></th>
                                  <th id="iva_total_excel">0.00</th>
                                  <th style="font-size:16px !important;" id="total_excel">0.00</th>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                              <label class="control-label" for="">Concepto de pago:</label>
                              <textarea id="concept_pay" class="form-control form-control-sm" rows="3" cols="1000" type="text" name="concept_pay" placeholder="Required" value=""></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-md-6">

                              <div class="form-inline">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" id="check_factura_sin" name="check_factura_sin" value="1">
                                    &nbsp;Sin Factura.&nbsp;
                                  </label>
                                </div>
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" id="check_factura_pend" name="check_factura_pend" value="1">
                                    &nbsp;Factura pendiente.
                                  </label>
                                </div>
                              </div>
                              <input type="hidden" id="bool_factura_s" name="bool_factura_s" value="false" readonly>
                              <input type="hidden" id="bool_factura_p" name="bool_factura_p" value="false" readonly>

                          </div>
                        </div>
                      <div class="row py-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <!--   Facturas -->
                                  <label for="" class="col-md-12 control-label text-primary"><i class="fas fa-cloud-upload-alt" aria-hidden="true"></i>  Subir facturas</label>
                                <br>
                                <div class="input-group" style="width: 80%;">
                                    <label class="input-group-btn">
                                        <span class="btn btn-danger">
                                            <i class="far fa-file-pdf"></i>  PDF
                                            <input id="file_pdf" name="file_pdf" class="form-control form-control-sm" type="file" style="display: none;">
                                        </span>
                                      </label>
                                    <input type="text" class="form-control" readonly>
                                  </div>
                            </div>
                            <div class="form-group" style="width: 80%;">
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary">
                                            <i class="far fa-file-code"></i> XML
                                            <input id="file_xml" name="file_xml" class="form-control form-control-sm" type="file" style="display: none;">
                                        </span>
                                      </label>
                                    <input type="text" class="form-control" readonly>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <!--  Datos bancarios  -->
                              <div class="form-group">
                                <label for="" class="control-label text-primary"> <i class="fas fa-exchange-alt"></i> {{ trans('pay.data_bank') }}</label>
                              </div>
                              <div class="form-group pb-2">
                                <label for="bank" class="control-label">{{ trans('pay.bank') }}:</label>
                                <select class="form-control form-control-sm" id="bank" name="bank">
                                  <option value="" selected>{{ trans('pay.select_op') }}</option>
                                </select>
                              </div>
                              <div class="form-group py-2">
                                <label for="account" class="control-label">{{ trans('pay.cuenta') }}:</label>
                                <select id="account" name="account" class="form-control form-control-sm">
                                  <option value="" selected>{{ trans('pay.select_op') }}</option>
                                </select>
                              </div>
                              <div class="form-group py-2">
                                <label for="clabe" class="control-label">{{ trans('pay.clabe') }}:</label>
                                <input type="text" class="form-control form-control-sm" data-currency="0" id="clabe" name="clabe" placeholder="{{ trans('pay.clabe_int') }}" disabled>
                              </div>
                              <div class="form-group py-2">
                                <label for="reference_banc" class="control-label">{{ trans('pay.reference') }}:</label>
                                <input type="text" class="form-control form-control-sm" id="reference_banc" name="reference_banc" placeholder="{{ trans('pay.reference_bank') }}" disabled>
                              </div>
                              <div class="form-group py-2" style="color: white;">
                                  <a class="btn btn-block btn-social btn-google databank"><i class="fa fa-plus-square"></i> Añadir datos bancarios</a>
                              </div>
                        </div>
                      </div>

                        <div class="row">
                          <div class="form-group">
                            <label for="observaciones" class="control-label">{{ trans('pay.observation') }}:</label>
                            <textarea style="resize:none;" class="form-control form-control-sm" id="observaciones" name="observaciones" placeholder="Required" rows="3" cols="1000"></textarea>
                          </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                          <div class="form-group col-md-6">
                            <button id="savePay" class="btn btn-primary"  type="submit" name="button"> <i class="fa fa-save"></i> Guardar</button>
                          </div>
                        </div>
                      </form>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <!-- The footer of the box -->
                </div>

              </div>
            </div>
        </div>
      </div>
    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View add request of payment') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>
    <script src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="{{ asset('js/admin/payments/pay_import.js')}}"></script>
    <script src="{{ asset('js/admin/payments/modal_bank.js')}}"></script>
    <style media="screen">
      .form-control{
        color:  #535352 !important;
      }
    </style>

  @else
    <!--NO VER-->
  @endif
@endpush
