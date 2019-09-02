@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View add multiple request of payment') )
    {{ trans('message.pay_add_request') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View add multiple request of payment') )
    {{ trans('message.subtitle_pay_add') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View add multiple request of payment') )
    {{ trans('message.breadcrumb_pay_add') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View add multiple request of payment') )
    <div class="modal modal-default fade" id="modal_bank" data-backdrop="static">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fas fa-university" style="margin-right: 4px;"></i>{{ trans('pay.data_bakl') }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="card table-responsive">
                <div class="card-body">
                  @if( auth()->user()->can('Create data bank by multiple payment') )
                      <form class="form-horizontal" id="data_account_bank" name="data_account_bank">
                        {{ csrf_field() }}
                        <div class="row form-group mb-2">
                          <label for="reg_provider" class="col-md-3 control-label">{{ trans('pay.proveedor') }}</label>
                          <input class="form-control col-md-9" type="text" name="reg_provider" id="reg_provider" value="" readonly>
                        </div>
                        <div class="row form-group my-2">
                          <label for="reg_bancos" class="col-md-3 control-label">{{ trans('pay.bank') }}</label>
                          <select id="reg_bancos" name="reg_bancos" class="col-md-9 form-control select2" style="width:100%;">
                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                            @forelse ($banquitos as $data_banquitos)
                              <option value="{{ $data_banquitos->id }}"> {{ $data_banquitos->nombre }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                        <div class="row form-group my-2">
                          <label for="reg_coins" class="col-md-3 control-label">{{ trans('pay.type_coins') }}</label>
                          <select id="reg_coins" name="reg_coins" class="col-md-9 form-control select2" style="width:100%;">
                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                            @forelse ($currency as $data_currency)
                              <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                        <div class="row form-group my-2">
                          <label for="reg_cuenta" class="col-md-3 control-label">{{ trans('pay.cuenta') }}</label>
                          <input class="col-md-9 form-control" type="text" name="reg_cuenta" id="reg_cuenta" value="">
                        </div>
                        <div class="row form-group my-2">
                          <label for="reg_clabe" class="col-md-3 control-label">{{ trans('pay.clabe') }}</label>
                          <input class="col-md-9 form-control" type="text" name="reg_clabe" id="reg_clabe" value="">
                        </div>
                        <div class="row form-group my-2">
                          <label for="reg_reference" class="col-md-3 control-label">{{ trans('pay.reference') }}</label>
                          <input class="col-md-9 form-control" type="text" name="reg_reference" id="reg_reference" value="">
                        </div>
                        <div class="row my-2">
                          @if( auth()->user()->can('Create data bank provider by multiple payment') )
                            <button type="submit" class="btn btn-secondary col-md-4 mr-3"><i class="fas fa-plus-square"></i>&nbsp;{{ trans('message.create') }}</button>
                            <!-- <button type="button" class="btn bg-navy create_provider"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button> -->
                          @endif
                          <button type="button" class="btn btn-danger delete_provider col-md-7" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;{{ trans('message.cancelar') }} & {{ trans('message.ccmodal') }}</button>
                        </div>
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
    <!-- jQuery Steps -->
    <div class="container card">
      <div class="row">
        <div class="col-sm-12">
          <div style="padding:10px; width: 100%">
            @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
            @endif

            <div id="exampleValidator" class="wizard">
              <ul class="wizard-steps" role="tablist">
                  <li class="active" role="tab">
                      <h4><span><i class="fa fa-address-card"></i></span>Requerimientos</h4>
                  </li>
                  <li role="tab">
                      <h4><span><i class="fa fa-list-ol"></i></span>Conceptos</h4>
                  </li>
                  <!-- <li role="tab">
                      <h4><span><i class="fa fa-save"></i></span>Password</h4> </li> -->
              </ul>
              <form id="validation" name="validation" class="form-horizontal" action="{{ url('create_pay') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="wizard-content">
                  <div class="wizard-pane active" role="tabpanel">

                    <div class="row">
                        <div class="col-md-6 form-group">
                          <label class="control-label">C.C.</label>
                          <input type="text" class="form-control" name="cc_key" id="cc_key" readonly />
                        </div>
                        <div class="col-md-6 form-group">
                          <label class="control-label">ID_Ubicación</label>
                          <input type="text" id="idUbication" class="form-control" name="idUbication" readonly>
                        </div>
                    </div>

                    <div class="row my-1">
                      <div class="col-md-6">&nbsp;</div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-xs-2 control-label">Prioridad:</label>
                          <div class="col-xs-10 selectContainer">
                            <select name="priority_id" class="form-control select2">
                              @forelse ($priority as $data_priority)
                                @if ($data_priority->id === 1)
                                @elseif ($data_priority->id === 2)
                                  <option value="{{ $data_priority->id }}" selected> {{ $data_priority->name }} </option>
                                @else
                                  <option value="{{ $data_priority->id }}"> {{ $data_priority->name }} </option>
                                @endif
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-6 col-md-6 col-xs-6">
                        <div class="form-group my-2">
                          <label for="classif_id" class="col-xs-2">Servicio:</label>
                          <div class="col-xs-10 selectContainer">
                            <select id="classif_id" name="classif_id" class="form-control select2">
                              <option value="">Elija...</option>
                                @forelse ($cxclassifications as $data_service)
                                  <option value="{{ $data_service->id }}"> {{ $data_service->name }} </option>
                                @empty
                                @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="form-group my-2">
                          <label class="col-xs-2">Nivel 1:</label>
                          <div class="col-xs-10 selectContainer">
                            <select name="dyn_field[0]" class="form-control select2 changeField0">
                              <option value="">Elija...</option>
                            </select>
                          </div>
                        </div>
                        <div class="hide my-2" id="template_cc">
                          <div class="form-group">
                            <label class="col-xs-2 change_label">xxxx_1.</label>
                            <div class="col-xs-10 selectContainer">
                              <select name="dyn_field" class="form-control select2">
                                <option value="">Elija...</option>
                              </select>
                            </div>
                          </div>
                        </div>

                      </div>

                      <div class="col-lg-6 col-md-6 col-xs-6">
                        <div class="form-group my-2">
                          <label for="date_limit" class="col-xs-2">Fecha limite:</label>
                          <div class="input-group col-xs-10">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar fa-2x"></i>
                            </div>
                            <input id="date_limit" name="date_limit" type="text" class="ml-1" style="border: 1px solid lightgray; width: 91%;" placeholder="2019-01-01">
                          </div>
                        </div>
                        <div class="form-group my-2">
                          <label for="cadena_id" class="col-xs-2">Cadena/Grupo:</label>
                          <div class="col-xs-10 selectContainer">
                            <select id="cadena_id" name="cadena_id" class="form-control select2">
                              <option value="">Elija...</option>
                                @forelse ($cadenas as $data_cadenas)
                                  <option value="{{ $data_cadenas->id }}">{{ $data_cadenas->name }}</option>
                                @empty
                                @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="form-group my-2">
                          <label for="sitio_id" class="col-xs-2">Nombre ubicación:</label>
                          <div class="col-xs-10 selectContainer">
                            <select id="sitio_id" name="sitio_id" class="form-control select2">
                              <option value="">Elija...</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-6 col-xs-6">

                      </div>

                      <div class="col-lg-6 col-xs-6">
                          <!--<label class="col-xs-2 control-label">ID_Ubicación</label>
                          <div class="col-xs-10">
                            <input type="text" id="idUbication" class="form-control" name="idUbication" readonly>
                          </div>

                          <div class="form-group pull-right">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" id="check_chain_anex" name="check_chain_anex" value="1">
                              Solo id_ubicación.
                            </label>
                          </div>
                        </div> -->
                      </div>

                    </div>
                    <!--<div class="row">

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="classif_id" class="col-xs-2">Servicio.</label>
                          <div class="col-xs-10 selectContainer">
                            <select id="classif_id" name="classif_id" class="form-control select2">
                              <option value="">Elija...</option>
                                @forelse ($cxclassifications as $data_service)
                                  <option value="{{ $data_service->id }}"> {{ $data_service->name }} </option>
                                @empty
                                @endforelse
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="date_limit" class="col-xs-2">Fecha limite:</label>
                          <div class="input-group col-xs-10">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input id="date_limit" name="date_limit" type="text" class="form-control">
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row" id="dyn_row_1">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-xs-2">Nivel 1.</label>
                          <div class="col-xs-10 selectContainer">
                            <select name="dyn_field[0]" class="form-control select2 changeField0">
                              <option value="">Elija...</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="cadena_id" class="col-xs-2">Cadena/Grupo</label>
                          <div class="col-xs-10 selectContainer">
                            <select id="cadena_id" name="cadena_id" class="form-control select2">
                              <option value="">Elija...</option>
                                @forelse ($cadenas as $data_cadenas)
                                  <option value="{{ $data_cadenas->id }}">{{ $data_cadenas->name }}</option>
                                @empty
                                @endforelse
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6"></div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sitio_id" class="col-xs-2">Anexo.</label>
                          <div class="col-xs-10 selectContainer">
                            <select id="sitio_id" name="sitio_id" class="form-control select2">
                              <option value="">Elija...</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row hide" id="template_cc">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-xs-2 change_label">xxxx_1.</label>
                          <div class="col-xs-10 selectContainer">
                            <select name="dyn_field" class="form-control select2">
                              <option value="">Elija...</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="cadena_id" class="col-xs-2">Cadena/Grupo</label>
                          <div class="col-xs-10 selectContainer">
                            <select id="cadena_id" name="cadena_id" class="form-control select2">
                              <option value="">Elija...</option>
                                @forelse ($cadenas as $data_cadenas)
                                  <option value="{{ $data_cadenas->id }}">{{ $data_cadenas->name }}</option>
                                @empty
                                @endforelse
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">

                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sitio_id" class="col-xs-2">Anexo.</label>
                          <div class="col-xs-10 selectContainer">
                            <select id="sitio_id" name="sitio_id" class="form-control select2">
                              <option value="">Elija...</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">

                        </div>
                      </div>
                    </div> -->

                  </div>

                  <div class="wizard-pane" id="validationW2" role="tabpanel">
                    <!-- CONTENIDO TAB 2. -->
                  <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                      <div class="row form-group my-2">
                        <input type="text" name="cc_key2" id="cc_key2" class="form-control col-md-6" disabled>
                        <input type="text" name="idProject2" id="idProject2" class="form-control col-md-6" disabled>
                      </div>
                      <div class="row form-group my-2">
                        <label for="provider" class="control-label col-md-2">{{ trans('pay.proveedor') }}:</label>
                        <select id="provider" name="provider" class="form-control select2 col-md-10">
                          <option value="" selected>{{ trans('pay.select_op') }}</option>
                          @forelse ($proveedor as $data_proveedor)
                            <option value="{{ $data_proveedor->id }}"> {{ $data_proveedor->name }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                      <div class="row form-group my-2">
                        <label for="purchase_order" class="control-label col-md-2">Orden de compra:</label>
                        <input type="text" class="form-control col-md-9" placeholder="..." name="purchase_order">
                      </div>

                      <!--  Inicio de parte dinamica de facturacion -->
                        <div class="row my-3">
                          <div class="col-xs-12">
                            <label for="" class="control-label pull-left"><i class="fas fa-cloud-upload-alt" aria-hidden="true"></i> Pago.</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-4">
                            <label for="ejemplo_email_3" class="control-label">{{ trans('pay.factura') }}:</label>
                            <input type="text" class="form-control" name="factura" id="factura" placeholder="#Factura"/>
                          </div>
                          <div class="col-md-1">&nbsp;</div>
                          <div class="form-group col-md-4">
                            <label for="ejemplo_email_3" class="control-label">FPAGO:</label>
                            <select name="methodpay" class="form-control">
                                @forelse ($way as $data_way)
                                  <option value="{{ $data_way->id }}"> {{ $data_way->name }} </option>
                                @empty
                                @endforelse
                            </select>
                          </div>
                        </div>

                        <div class="row my-3">
                          <div class="form-inline">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" id="check_factura_sin" name="check_factura_sin" value="1">
                                &nbsp;Sin Factura.
                              </label>
                            </div>
                            <div class="checkbox ml-3">
                              <label>
                                <input type="checkbox" id="check_factura_pend" name="check_factura_pend" value="1">
                                &nbsp;Factura pendiente.
                              </label>
                            </div>
                          </div>
                          <input type="hidden" id="bool_factura_s" name="bool_factura_s" value="false" readonly>
                          <input type="hidden" id="bool_factura_p" name="bool_factura_p" value="false" readonly>
                        </div>

                        <div class="row">
                          <label for="ejemplo_email_3" class="control-label">Concepto:</label><br>
                          <textarea style="resize:none;" class="form-control" name="description" placeholder="Descripción"></textarea>
                        </div>


                        <div class="row my-1">
                          <div class="col-md-5">
                            <div class="form-group">
                                <label for="ejemplo_email_3" class="control-label">PDF</label>
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-danger">
                                            <i class="fas fa-upload" aria-hidden="true"></i> PDF <input name="fileInput" type="file" style="display: none;">
                                        </span>
                                    </label>
                                    <input style="font-size:7px;" type="text" class="form-control" readonly>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-2">&nbsp;</div>

                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="ejemplo_email_3" class="control-label">XML</label>
                              <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary">
                                        <i class="fas fa-file-code" aria-hidden="true"></i> XML
                                        <input id="file_xml" name="file_xml" type="file" style="display: none;">
                                    </span>
                                  </label>
                                <input style="font-size:7px;" type="text" class="form-control" readonly>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">

                            <div class="col-md-3">
                              <div class="form-group">
                                <label class="control-label">Monto:</label>
                                <input type="text" class="form-control monto" name="price" id="price" onkeyup="sumar();" placeholder="Monto"/>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                <label class="control-label">IVA:</label>
                                <input type="text" class="form-control" name="iva_format" id="iva_format" readonly placeholder="IVA"/>
                                <input type="text" class="form-control" name="iva" id="iva" onkeyup="sumariva();" readonly placeholder="IVA"/>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label class="control-label">Total:</label>
                                <input type="text" class="form-control" id="totales_format" name="totales_format" readonly/>
                                <input type="text" class="form-control" id="totales" name="totales" readonly/>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label class="control-label">Moneda:</label>
                                <select id="coin" name="coin" class="form-control" readonly>
                                  <option  value="0" selected ="true">{{ trans('pay.select_op') }}</option>
                                  @forelse ($currency as $data_currency)
                                    <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                                  @empty
                                  @endforelse
                                </select>
                              </div>
                            </div>
                        </div>
                        <div class="row my-3" style="font-size: 14px;">
                          <label class="mr-5"><strong>El IVA se calcula al 16%</strong></label>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" id="check_otros" name="check_otros">
                              Otros impuestos.&nbsp;
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" id="check_isr" name="check_isr">
                              Retención ISR/IVA.&nbsp;
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" id="check_iva" name="check_iva">
                              No calcular IVA.&nbsp;
                            </label>
                          </div>
                        </div>
                        <br>
                      <!--  Fin de parte dinamica de facturacion -->
                      <!--  Inicio del parte dos de pago -->
                            <div class="row">
                              <div class="form-group">
                                <div class="col-xs-12">
                                  <label class="control-label pull-left">{{ trans('pay.data_bank') }}: </label>
                                </div>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="form-group col-md-6">
                                <label for="bank">{{ trans('pay.bank') }}:</label>
                                <select class="form-control select2" id="bank" name="bank">
                                  <option value="" selected>{{ trans('pay.select_op') }}</option>
                                </select>
                              </div>
                              <div class="form-group col-md-6">
                                <label for="account">{{ trans('pay.cuenta') }}:</label>
                                <select id="account" name="account" class="form-control">
                                  <option value="" selected>{{ trans('pay.select_op') }}</option>
                                </select>
                              </div>
                            </div>

                            <div class="row my-2">
                              <div class="form-group col-md-6">
                                <label for="clabe">{{ trans('pay.clabe') }}:</label>
                                <input type="text" class="form-control" id="clabe" name="clabe" data-currency="0" placeholder="{{ trans('pay.clabe_int') }}" disabled>
                              </div>
                              <div class="form-group col-md-6">
                                <label for="reference_banc">{{ trans('pay.reference') }}:</label>
                                <input type="text" class="form-control" id="reference_banc" name="reference_banc" placeholder="{{ trans('pay.reference_bank') }}" disabled>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">&nbsp;</div>
                              <div class="form-group col-md-6">
                                <a class="btn btn-block btn-social btn-google text-white databank"><i class="fa fa-plus-square"></i> Añadir datos bancarios</a>
                              </div>
                            </div>

                            <div class="row">
                              <div class="form-group col-md-12">
                                <label for="observaciones" class="control-label">{{ trans('pay.observation') }}:</label>
                                <textarea style="resize:none;" class="form-control" placeholder="..." id="observaciones" name="observaciones" rows="3" cols="40"></textarea>
                              </div>
                            </div>
                            <br><br><br>
                          <!--  Inicio de la session de firmas -->
                            <div class="row">
                              <div class="col-md-12">
                                <p><strong>{{ trans('pay.email_conf') }}:</strong></p>
                                <p>{{ Auth::user()->email}}</p>
                              </div>
                            </div>
                            <div class="row text-center">
                              <div class="col-md-2">&nbsp;</div>
                              <div class="col-md-3"><p>{{ Auth::user()->name}}</p><p>{{ trans('pay.elaboro') }}</p></div>
                              <div class="col-md-3 border-top"><p>René Gonzalez Sánchez</p><p>{{ trans('pay.reviso') }}</p></div>
                              <div class="col-md-3 border-top"><p>Alejandro Espejo Sokol</p><p>{{ trans('pay.autorizo') }}</p></div>
                            </div>
                          <!--  Fin de la session de firmas -->
                          </div>
                          <div class="col-lg-2"></div>

                        </div>

                  </div>

                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- End jQuery Steps -->
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View add multiple request of payment') )

    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/css/wizard.css')}}" >
    <!-- Form Wizard JavaScript -->
    <script src="{{ asset('plugins/jquery-wizard-master/dist/jquery-wizard.js')}}"></script>
    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>

    <!-- <script src="{{ asset('js/admin/payments/request_payment.js?v=2.0.0')}}"></script> -->
    <script src="{{ asset('js/admin/payments/payment_request.js?v=2.0.0')}}"></script>

    <script src="{{ asset('js/admin/payments/modal_bank.js')}}"></script>

    <style media="screen">
      .wizard-steps{display:table;width:100%}
      .wizard-steps>li{
        display:table-cell;
        padding:10px 20px;
        background:#f7fafc
      }
      .wizard-steps>li span{
        border-radius:100%;
        border:1px solid rgba(120,130,140,.13);
        width:40px;
        height:40px;
        display:inline-block;
        vertical-align:middle;
        padding-top:9px;
        margin-right:8px;
        text-align:center
      }
      .wizard-content{
        padding:25px;
        border-color:rgba(120,130,140,.13);
        margin-bottom:30px
      }
      .wizard-steps>li.current,.wizard-steps>li.done{
        background:#228AE6;
        color:#fff
       }
       .wizard-steps>li.current span,.wizard-steps>li.done span{
         border-color:#fff;color:#fff
       }
       .wizard-steps>li.current h4,.wizard-steps>li.done h4{
         color:#fff
       }
       .wizard-steps>li.done{
         background:#1ED760
       }
       .wizard-steps>li.error{
         background:#E73431
       }
    </style>


  @else
    <!--NO VER-->
  @endif
@endpush
<style>
  .logo-sit{
    margin-left: 0px;
  }

</style>
