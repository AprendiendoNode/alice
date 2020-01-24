@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View create contract') )
    {{ trans('message.contrat') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View create contract') )
    {{ trans('message.breadcrumb_contrat') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View create contract') )
    <div class="modal modal-default fade" id="modal_razon" data-backdrop="static">
        <div class="modal-dialog" >
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fa fa-align-justify" style="margin-right: 4px;"></i>Agregar Razón Social</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="box-body table-responsive">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      @if( auth()->user()->can('View create group by contract') )
                        <!--------------------------------------------------------------------------->
                        <form id="validate_d" name="validate_d" class="validation-razon" action="" method="POST">
                          {{ csrf_field() }}
                          <div class="form-group row">
                            <label for="inputCreatName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputCreatTaxid" class="col-sm-3 col-form-label">RFC <span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm required" id="inputCreatTaxid" name="inputCreatTaxid" placeholder="RFC" maxlength="30">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputCreatNumid" class="col-sm-3 col-form-label">Razón social <span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm required" id="inputCreatNumid" name="inputCreatNumid" placeholder="Reg. identidad fiscal" maxlength="300">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputCreatEmail" class="col-sm-3 col-form-label">Correo electrónico <span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <input type="email" class="form-control form-control-sm required" id="inputCreatEmail" name="inputCreatEmail" placeholder="Correo electrónico" maxlength="100">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputCreatPhone" class="col-sm-3 col-form-label">Telefono</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm onlynumber" id="inputCreatPhone" name="inputCreatPhone" placeholder="" maxlength="12">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputCreatMobile" class="col-sm-3 col-form-label">Telefono movil</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm onlynumber" id="inputCreatMobile" name="inputCreatMobile" placeholder="" maxlength="12">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="select_one_mdal" class="col-sm-3 col-form-label">Término de pago <span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <select  id="select_one_mdal" name="select_one_mdal" class="form-control form-control-sm required"  style="width: 100%;">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                                @forelse ($payment_term as $payment_term_data)
                                <option value="{{ $payment_term_data->id }}"> {{ $payment_term_data->name }} </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="select_two_mdal" class="col-sm-3 col-form-label">Formas de pago<span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <select  id="select_two_mdal" name="select_two_mdal" class="form-control form-control-sm required"  style="width: 100%;">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                                @forelse ($payment_way as $payment_way_data)
                                <option value="{{ $payment_way_data->id }}"> {{ $payment_way_data->name }} </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="select_three_mdal" class="col-sm-3 col-form-label">Metodo de pago<span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <select  id="select_three_mdal" name="select_three_mdal" class="form-control form-control-sm required"  style="width: 100%;">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                                @forelse ($payment_methods as $payment_methods_data)
                                <option value="{{ $payment_methods_data->id }}"> {{ $payment_methods_data->name }} </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div><div class="form-group row">
                            <label for="select_four_mdal" class="col-sm-3 col-form-label">Usos de CFDI<span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <select  id="select_four_mdal" name="select_four_mdal" class="form-control form-control-sm required"  style="width: 100%;">
                                <option value="">{{ trans('message.selectopt') }}</option>
                                @forelse ($cfdi_uses as $cfdi_uses_data)
                                <option value="{{ $cfdi_uses_data->id }}"> {{ $cfdi_uses_data->name }} </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputCreatAddress_1" class="col-sm-3 col-form-label">Direccion<span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm required" id="inputCreatAddress_1" name="inputCreatAddress_1" placeholder="Direccion" maxlength="100">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="select_six_mdal" class="col-sm-3 col-form-label">Paises<span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <select  id="select_six_mdal" name="select_six_mdal" class="form-control form-control-sm required"  style="width: 100%;">
                                <option value="">{{ trans('message.selectopt') }}</option>
                                @forelse ($countries as $countries_data)
                                <option value="{{ $countries_data->id }}"> {{ $countries_data->name }} </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="select_seven_mdal" class="col-sm-3 col-form-label">Estados<span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <select  id="select_seven_mdal" name="select_seven_mdal" class="form-control form-control-sm required"  style="width: 100%;">
                                <option value="">{{ trans('message.selectopt') }}</option>
                                @forelse ($states as $states_data)
                                <option value="{{ $states_data->id }}"> {{ $states_data->name }} </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="select_eight_mdal" class="col-sm-3 col-form-label">Ciudades<span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <select  id="select_eight_mdal" name="select_eight_mdal" class="form-control form-control-sm required"  style="width: 100%;">
                                <option value="">{{ trans('message.selectopt') }}</option>
                                @forelse ($cities as $cities_data)
                                <option value="{{ $cities_data->id }}"> {{ $cities_data->name }} </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputCreatPostCode" class="col-sm-3 col-form-label">Codigo Postal<span style="color: red;">*</span></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm onlynumber required" id="inputCreatPostCode" name="inputCreatPostCode" placeholder="" maxlength="10">
                            </div>
                          </div>


                          <div class="row">
                            <div class="col-md-12">
                              <button type="submit" class="btn btn-primary adddatarazon"><i class="fa fa-plus"></i> Guardar</button>
                            </div>
                          </div>
                        </form>
                        <!--------------------------------------------------------------------------->
                      @else
                        @include('default.denied')
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
    </div>

    <div class="modal modal-default fade" id="modal_cadena" data-backdrop="static">
        <div class="modal-dialog" >
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fa fa-align-justify" style="margin-right: 4px;"></i>Agregar Grupo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="box-body table-responsive">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      @if( auth()->user()->can('View create rz by contract') )
                        <!--------------------------------------------------------------------------->
                        <form id="validate_grup" name="validate_grup" class="validation-razon" >
                          {{ csrf_field() }}
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control required" id="cadena_name" name="cadena_name" maxlength="100">
                              </div>

                              <div class="form-group">
                                <label>Clave</label>
                                <input type="text" class="form-control required" id="cadena_key" name="cadena_key" maxlength="5">
                              </div>
                            </div>

                            <div class="col-md-12">
                              <button type="submit" class="btn btn-primary adddatacadena"><i class="fa fa-plus"></i> Guardar</button>
                            </div>
                          </div>
                        </form>
                        <!--------------------------------------------------------------------------->
                      @else
                        @include('default.denied')
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
    </div>

    <div class="container">
      <!-- Validation wizard -->
        <div class="row" id="validation">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <div class="box box-solid">
                <div class="box-body">
                  <div class="form-inline">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label for="select_one" class="control-label">Seleccione el tipo de contrato: </label>
                        <select id="select_one" name="select_one"  class="form-control select2" required>
                          <option value="" selected> Elija el tipo de contrato </option>
                          <option value="1"> Contrato Maestro </option>
                          <option value="2"> Anexo a contrato </option>
                        </select>
                      </div>
                      <div class="form-group">
                          <button type="button" class="btn btn-info btngeneral"><i class="fa fa-bullseye margin-r5"></i> {{ trans('message.generate') }}</button>
                      </div>
                  </div>
                 </div>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="white-box contrato_a">
                  <div class="wizard-content">
                      <h4 class="">Crear un contrato maestro</h4>
                      <!-- <h6 class="card-subtitle"></h6> -->
                      <div class="row">
                        <div class="col-md-8">
                          <h5 class="mb-3">Su id de contrato maestro, seria:</h5>
                          <div class="input-group inputids">
                            <input type="text" class="form-control" name="key_maestro_service" readonly>
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button">-</button>
                            </span>
                            <input type="text" class="form-control" name="key_maestro_verticals" readonly>
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button">-</button>
                            </span>
                            <input type="text" class="form-control" name="key_maestro_cadena" readonly>
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button">-</button>
                            </span>
                            <input type="text" class="form-control" name="key_maestro_contrato" readonly>
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button">-</button>
                            </span>
                            <input type="text" class="form-control" name="key_maestro_sitio" readonly>
                          </div>
                        </div>
                      </div>

                      <form id="validation_master" name="validation_master" enctype="multipart/form-data" class="validation-wizard-master wizard-circle m-t-40">
                          {{ csrf_field() }}
                          <!-- Step 1 -->
                          <h6>Paso 1 - Destino</h6>
                          <section>
                            <div class="row">
                              <div class="col-md-8 col-md-offset-2">
                                <div class="form-group">
                                  <label for="sel_master_service"> Selecciona el servicio:
                                    <span class="danger">*</span>
                                  </label>
                                  <select id="sel_master_service" name="sel_master_service" class="form-control required" name="location" style="width:100%;">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    @forelse ($classifications as $data_classifications)
                                    <option value="{{ $data_classifications->id }}"> {{ $data_classifications->name }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-8 col-md-offset-2">
                                <div class="form-group">
                                  <label for="sel_master_vertical"> Selecciona la vertical:
                                    <span class="danger">*</span>
                                  </label>
                                  <select class="form-control required" id="sel_master_vertical" name="sel_master_vertical" style="width:100%;">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-8 col-md-offset-2">
                                <label for="sel_master_cadenas"> Selecciona el grupo:
                                  <span class="danger">*</span>
                                </label>
                                <div class="input-group">
                                  <select id="sel_master_cadenas" name="sel_master_cadenas" class="form-control required" style="width:100%;">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                  </select>
                                  <span class="input-group-btn">
                                    <button class="btn btn-primary addcadenamaster" type="button"><i class="fa fa-plus"></i></button>
                                  </span>
                                </div>
                              </div>
                              <div class="clearfix mt-20"></div>
                            </div>
                          </section>
                          <!-- Step 2 -->
                          <h6>Paso 2 - RFC & Datos Informativos</h6>
                          <section>
                            <div class="row">
                              <div class="col-md-8 col-md-offset-2">
                                <div class="form-group">
                                  <label for="sel_razon"> Selecciona la razon social: </label>
                                  <div class="input-group">
                                    <select name="sel_razon" class="form-control required" data_row="0">
                                      <option value="" selected>{{ trans('pay.select_op') }}</option>
                                      @forelse ($rz_customer as $data_rz_customer)
                                      <option value="{{ $data_rz_customer->id }}"> {{ $data_rz_customer->name }} </option>
                                      @empty
                                      @endforelse
                                    </select>
                                    <span class="input-group-btn">
                                      <button class="btn btn-primary addButtonrazonmaster" type="button"><i class="fa fa-plus"></i></button>
                                    </span>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-8 col-md-offset-2">
                                <u> Datos de cobranza</u>

                                <div class="form-group">
                                  <label for="user_resc" class="control-label"> Persona que resguarda el contrato:</label>
                                  <select class="form-control required" name="user_resc" id="user_resc">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    @forelse ($resguardo as $data_resguardo)
                                    <option value="{{ $data_resguardo->id }}"> {{ $data_resguardo->nombre }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                                </div>

                                <div class="form-group">
                                  <div id="cont_file" class="">
                                    <div class="input-group">
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary">
                                                Contrato (PDF) <input id="fileInput" name="fileInput" type="file" style="display: none;" class="required">
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label for="status_cont" class="control-label"> Estatus del contrato:</label>
                                  <select class="form-control required" name="status_cont" id="status_cont">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    @forelse ($contract_status as $data_contract_status)
                                    <option value="{{ $data_contract_status->id }}"> {{ $data_contract_status->name }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                                </div>

                              </div>

                            </div>
                          </section>

                      </form>
                  </div>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="white-box contrato_b">
                <div class="wizard-content">
                  <h4 class="">Crear un anexo de contrato</h4>
                  <div class="row">
                    <div class="col-md-8">
                      <h5 class="mb-3">Su id del anexo contrato, seria:</h5>
                      <div class="input-group inputids">
                        <input type="text" class="form-control" name="key_anexo_service" readonly>
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button">-</button>
                        </span>
                        <input type="text" class="form-control" name="key_anexo_verticals" readonly>
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button">-</button>
                        </span>
                        <input type="text" class="form-control" name="key_anexo_cadena" readonly>
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button">-</button>
                        </span>
                        <input type="text" class="form-control" name="key_anexo_contrato" readonly>
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button">-</button>
                        </span>
                        <input type="text" class="form-control" name="key_anexo_sitio" readonly>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div  class="row pad-top-botm client-info pt-10">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                          <p class="text-center" style="border: 1px solid #FF851B" >Contacto</p>
                          <strong><i class="fa fa-user"></i> Nombre: </strong> <p id="datainfo_name_cont" class="sameline"></p>
                          <br />
                          <strong><i class="fa fa-envelope"></i> Email:</strong> <p id="datainfo_email_cont" class="sameline"></p>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3">
                          <p class="text-center" style="border: 1px solid #007bff" >Contrato Maestro</p>
                          <strong><i class="fa fa-user-secret"></i>  Resguardo: </strong> <p id="datainfo_resg_cont" class="sameline"></p>
                          <br />
                          <strong><i class="fa fa-superpowers"></i> Estatus:</strong> <p id="datainfo_status_cont" class="sameline"></p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                          <p class="text-center" style="border: 1px solid #3D9970" >Razón Social</p>
                            <div class="row">
                              <div class="col-lg-6 col-md-6 col-sm-6">
                                <strong> RFC: </strong> <p id="datainfo_rfc_cont" class="sameline"> </p>
                                <br />
                                <strong> Razón Social:</strong> <p id="datainfo_rfcname_cont" class="sameline">  </p>
                                <br />
                                <strong> Dirección:</strong> <p id="datainfo_address_cont" class="sameline">  </p>
                                <br />
                              </div>
                              <div class="col-lg-6 col-md-6 col-sm-6">
                                <strong> Codigo Postal: </strong> <p id="datainfo_postal_cont" class="sameline"> </p>
                                <br />
                                <strong> Nacionalidad:</strong> <p id="datainfo_nat_cont" class="sameline"> </p>
                                <br />
                                <strong> Tipo:</strong> <p id="datainfo_type_cont" class="sameline"> </p>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <form id="validation_anexo" name="validation_anexo" enctype="multipart/form-data" class="validation-wizard-anexo wizard-circle m-t-40">
                    {{ csrf_field() }}
                    <!-- Step 4 -->
                    <h6>Paso 4 - Comisiones</h6>
                    <section>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group row">
                            <label for="kick_off_exit" class="col-sm-3 control-label">¿Tiene Kick Off?</label>
                            <div class="col-sm-9">
                              <input id="kick_off_exit" name="kick_off_exit" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1"
                              data-on="Si" data-off="No">
                            </div>
                          </div>
                        </div>
                      </div>

                      <div id="kickoff_info_div" name="kickoff_info_div" class="row my-4">
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="label-control col-sm-12" for="select_kick_off">Elija el Kick Off:</label>
                            <div class="col-sm-12">
                              <select class="form-control form-control-sm" id="select_kick_off" name="select_kick_off" style="width: 100%;">
                                <option value="" selected>Elija</option>
                                @forelse ($kickoff_info as $data_kickoff_info)
                                <option value="{{ $data_kickoff_info->id }}"> {{ $data_kickoff_info->folio }}  </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <input type="hidden" class="form-control" id="kick_off_id" name="kick_off_id" maxlength="100" readonly>
                            <label>Nombre del proyecto</label>
                            <input type="text" class="form-control" id="kick_off_proyecto" name="kick_off_proyecto" maxlength="100" readonly>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Nombre del sitio</label>
                            <input type="text" class="form-control" id="kick_off_sitio" name="kick_off_sitio" maxlength="100" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="row my-2" id="div_comisiones" name="div_comisiones">
                        <div class="col-md-12 col-xs-12 mb-3">
                          <div class="table-responsive">
                            <table class="table table-items table-condensed table-hover table-bordered table-striped jambo_table" id="item_politica" style="min-width: 80px;">
                              <thead>
                                <tr class="bg-danger text-white">
                                  <th class="text-center" colspan="7" style="font-size: 1rem;">Politica de comisión</th>
                                </tr>
                                <tr class="bg-secondary text-white">
                                  <th class="text-center" style="padding: 1.25rem 0.9375rem !important;">Tipo de comisión</th>
                                  <th class="text-center" colspan="8">
                                    <select id="sel_type_comision" name="sel_type_comision" class="form-control required" style="width:100%;">
                                      <option value="" selected>{{ trans('pay.select_op') }}</option>
                                      @forelse ($politica_comision as $politica_comision_data)
                                        <option value="{{ $politica_comision_data->id }}"> {{ $politica_comision_data->politica }} </option>
                                      @empty
                                      @endforelse
                                    </select>
                                  </th>
                                </tr>
                                <tr class="bg-danger text-white">
                                  <th class="text-center">Politica</th>
                                  <th class="text-center">Retención</th>
                                  <th class="text-center">Total comisión %</th>
                                  <th class="text-center">Contacto %</th>
                                  <th class="text-center">Cierre %</th>
                                  <th class="text-center">ITC %</th>
                                  <th class="text-center">Venta Internas %</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr class="bg-secondary">
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <input type="text" class="form-control input-sm text-right col-politica sinpadding" id="politica_name" name="politica_name" readonly />
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <input type="text" class="form-control input-sm text-right col-retencion" id="politica_retencion" name="politica_retencion" value="0" readonly />
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <input type="text" class="form-control input-sm text-right col-total" id="politica_asignado" name="politica_asignado" value="0" readonly />
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <input type="text" class="form-control input-sm text-right col-contacto" id="politica_contacto" name="politica_contacto" value="0" readonly />
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <input type="text" class="form-control input-sm text-right col-cierre" id="politica_cierre" name="politica_cierre" value="0" readonly />
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <input type="text" class="form-control input-sm text-right col-itc" id="politica_itc" name="politica_itc" value="0" readonly />
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group form-group-sm">
                                      <input type="text" class="form-control input-sm text-right col-insidesales" id="politica_insidesales" name="politica_insidesales" value="0" readonly />
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="sel_inside_sales"> Inside Sales:
                              <span class="text-danger">*</span>
                            </label>
                            <select id="sel_inside_sales" name="sel_inside_sales" class="form-control" name="location" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($kickoff_inside_sales as $kickoff_inside_sales_data)
                                <option value="{{ $kickoff_inside_sales_data->user_id }}"> {{ $kickoff_inside_sales_data->user }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="sel_itconcierge_comision"> IT Concierge:
                              <span class="text-danger">*</span>
                            </label>
                            <select id="sel_itconcierge_comision" name="sel_itconcierge_comision" class="form-control" name="location" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($itconcierge as $itconcierge_data)
                                <option value="{{ $itconcierge_data->id }}"> {{ $itconcierge_data->nombre }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>

                        <div class="col-md-12 col-xs-12">
                          <div class="table-responsive">
                            <table class="table table-items table-condensed table-hover table-bordered table-striped jambo_table mt-4" id="item_contact" style="min-width: 80px;">
                              <thead>
                                <tr class="bg-dark text-white">
                                  <th class="text-center" colspan="4" style="font-size: 1rem;">Contácto</th>
                                </tr>
                                <tr>
                                  <th class="text-center">@lang('general.column_actions')</th>
                                  <th class="text-center">Contácto (Interno)</th>
                                  <th class="text-center">Contácto (Externo)</th>
                                  <th class="text-center">Porcentaje %<span class="required text-danger">*</span></th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                  $item_contact_row= 0;
                                  $item_contact=old('item_contact',[]);
                                @endphp
                                <tr id="add_item_contact">
                                  <td class="text-center">
                                    <button type="button" onclick="addItemCont();"
                                    class="btn btn-xs btn-primary"
                                    style="margin-bottom: 0; padding: 1px 3px;">
                                    <i class="fa fa-plus" style="font-size: 1rem;"></i>
                                    </button>
                                  </td>
                                  <td class="text-right" colspan="3"></td>
                                </tr>
                                <tr>
                                  <td class="text-left" colspan="3"></td>
                                  <td class="text-center">
                                    <span id="item_contact_note" style="color: red; font-weight: bold; font-size: 0.8rem;"></span>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>

                        <div class="col-md-12 col-xs-12">
                          <div class="table-responsive">
                            <table class="table table-items table-condensed table-hover table-bordered table-striped jambo_table mt-4" id="item_cierre" style="min-width: 80px;">
                              <thead>
                                <tr class="bg-dark text-white">
                                  <th class="text-center" colspan="4" style="font-size: 1rem;">Cierre</th>
                                </tr>
                                <tr>
                                  <th class="text-center">@lang('general.column_actions')</th>
                                  <th class="text-center">Contácto (Interno)</th>
                                  <th class="text-center">Contácto (Externo)</th>
                                  <th class="text-center">Porcentaje %<span class="required text-danger">*</span></th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                  $item_cierre_row= 0;
                                  $item_cierre=old('item_cierre',[]);
                                @endphp
                                <tr id="add_item_cierre">
                                  <td class="text-center">
                                    <button type="button" onclick="addItemCierre();"
                                    class="btn btn-xs btn-primary"
                                    style="margin-bottom: 0; padding: 1px 3px;">
                                    <i class="fa fa-plus" style="font-size: 1rem;"></i>
                                    </button>
                                  </td>
                                  <td class="text-right" colspan="3"></td>
                                </tr>
                                <tr>
                                  <td class="text-left" colspan="3"></td>
                                  <td class="text-center">
                                    <span id="item_cierre_note" style="color: red; font-weight: bold; font-size: 0.8rem;"></span>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </section>
                    <!-- Step 1 -->
                    <h6>Paso 1 - Destino</h6>
                    <section>
                      <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                          <div class="form-group">
                            <label for="sel_anexo_service"> Selecciona el servicio:
                            </label>
                            <select id="sel_anexo_service" name="sel_anexo_service" class="form-control required" name="location" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($classifications as $data_classifications)
                              <option value="{{ $data_classifications->id }}"> {{ $data_classifications->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="col-md-8 col-md-offset-2">
                          <div class="form-group">
                            <label for="sel_anexo_vertical"> Selecciona la vertical:
                            </label>
                            <select class="form-control required" id="sel_anexo_vertical" name="sel_anexo_vertical" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-8 col-md-offset-2">
                          <label for="sel_anexo_cadenas"> Selecciona el grupo:
                          </label>
                          <select id="sel_anexo_cadenas" name="sel_anexo_cadenas" class="form-control required" style="width:100%;">
                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                          </select>
                        </div>
                        <div class="col-md-8 col-md-offset-2">
                          <div class="form-group">
                            <label for="sel_master_to_anexo"> Selecciona el contrato maestro:
                            </label>
                            <select class="form-control required" id="sel_master_to_anexo" name="sel_master_to_anexo" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="clearfix mt-20"></div>
                      </div>
                    </section>
                    <!-- Step 2 -->
                    <h6>Paso 2 - Informativo</h6>
                    <section>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="contract_signature_date" class="control-label">Fecha Firma de contrato:</label>
                            <input type="text" class="form-control datepickercomplete required" id="contract_signature_date" name="contract_signature_date">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="date_start_cont" class="control-label">Fecha Inicio de contrato(Programada):</label>
                            <input type="text" class="form-control datepickercomplete required" id="date_start_cont" name="date_start_cont">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="sel_no_month"> Selecciona el numero meses:
                            </label>
                            <select class="form-control required" id="sel_no_month" name="sel_no_month" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @for ($i = 1; $i <= 120; $i++)
                                <option value="{{ $i }}"> {{ $i }} </option>
                              @endfor
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="date_end_cont_sist" class="control-label">Fecha Fin de contrato (Calculado):</label>
                            <input type="text" class="form-control" id="date_end_cont_sist" name="date_end_cont_sist" readonly>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="contract_signature_date" class="control-label">Fecha inicio real:</label>
                            <input type="text" class="form-control datepickercomplete required" id="contract_signature_date" name="contract_signature_date">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="fileInputAnexo"> Cargar anexo del contrato:</label>
                            <div id="cont_file_anexo" class="">
                              <div class="input-group">
                                <label class="input-group-btn">
                                  <span class="btn btn-primary">
                                    Contrato (PDF Max 20MB) <input id="fileInputAnexo" name="fileInputAnexo" type="file" style="display: none;" class="required">
                                  </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="sel_itconcierge"> Selecciona el ITConcierge:
                            </label>
                            <select class="form-control required" id="sel_itconcierge" name="sel_itconcierge" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>

                              @forelse ($itconcierge as $data_itconcierge)
                                <option value="{{ $data_itconcierge->id }}"> {{ $data_itconcierge->nombre }} </option>
                              @empty
                              @endforelse

                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="sel_business_executive"> Selecciona el ejecutivo comercial:
                            </label>
                            <select class="form-control required" id="sel_business_executive" name="sel_business_executive" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($vendedores as $data_vendedores)
                                <option value="{{ $data_vendedores->id }}"> {{ $data_vendedores->nombre }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="sel_estatus_anexo"> Estatus del contrato:
                            </label>
                            <select class="form-control required" id="sel_estatus_anexo" name="sel_estatus_anexo" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($contract_status as $data_contract_status)
                                <option value="{{ $data_contract_status->id }}"> {{ $data_contract_status->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 my-4" style="margin-bottom: 0px !important;">
                          <h5>Datos de facturación</h5><hr>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="num_vto"> Termino de pago (Dias de vencimiento):
                            </label>
                            <select class="form-control required" id="num_vto" name="num_vto" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($payment_term_act as $payment_term_data)
                                <option value="{{ $payment_term_data->id  }}">[{{ $payment_term_data->days }}] - {{ $payment_term_data->payment_terms }}</option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="payment_way_id"> Forma de pago:
                            </label>
                            <select class="form-control required" id="payment_way_id" name="payment_way_id" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($payment_way as $payment_way_data)
                                <option value="{{ $payment_way_data->id }}"> {{ $payment_way_data->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="payment_method_id"> Metodo de pago:
                            </label>
                            <select class="form-control required" id="payment_method_id" name="payment_method_id" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($payment_methods as $payment_methods_data)
                                <option value="{{ $payment_methods_data->id }}"> {{ $payment_methods_data->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="cfdi_use_id"> Uso de cfdi:
                            </label>
                            <select class="form-control required" id="cfdi_use_id" name="cfdi_use_id" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($cfdi_uses as $cfdi_uses_data)
                                <option value="{{ $cfdi_uses_data->id }}"> {{ $cfdi_uses_data->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="sel_unitmeasure"> Unidad de medida (Para facturación):
                            </label>
                            <select class="form-control required" id="sel_unitmeasure" name="sel_unitmeasure" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($unitmeasures as $unitmeasures_data)
                                <option value="{{ $unitmeasures_data->id  }}">[{{ $unitmeasures_data->code }}]{{ $unitmeasures_data->name }}</option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="sel_satproduct"> Prod/Serv SAT (Para facturación):
                            </label>
                            <select class="form-control required" id="sel_satproduct" name="sel_satproduct" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($satproduct as $satproduct_data)
                                <option value="{{ $satproduct_data->id  }}">[{{ $satproduct_data->code }}] {{ $satproduct_data->name }}</option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="description_fact" class="control-label">Descripcion (Para facturación):</label>
                            <input class="form-control required" id="description_fact" name="description_fact" type="text" >
                          </div>
                        </div>
                      </div>
                      <div class="row pt-3">
                        <div class="row">
                          <div class="col-xs-1" style="width: 12.499999995%">
                            <label for="c_price[0].price" class="col-xs-12">Mensualidad:</label>
                            <input  maxlength="10" type="text" class="form-control xf moneditas required" name="c_price[0].price" placeholder="Monto Mensual" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" data_row="0"/>
                          </div>
                          <div class="col-xs-1" style="width: 12.499999995%">
                            <label for="c_coin[0].coin" class="control-label">Moneda:</label>
                            <select name="c_coin[0].coin" class="form-control coin required" style="padding-left: 4px;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($currency as $data_currency)
                                <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                          <div class="col-xs-1" style="width: 17%">
                            <div class="form-group">
                              <label for="c_tcambopt[0].tcambopt" class="control-label">Tipo de cambio:</label>
                              <div id="cont_tp" class="input-group">
                                <span class="input-group-btn">
                                  <select datas="tp_forma" class="form-control required" id="c_tcambopt[0].tcambopt" name="c_tcambopt[0].tcambopt" >
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    <option value="1"> Fijo</option>
                                    <option value="2"> Al dia</option>
                                  </select>
                                </span>
                                <span class="input-group-btn" style="width: 53%">
                                  <input datas="tp_valor" type="text" class="form-control" name="c_tcamb[0].tcamb" placeholder="TC" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly />
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-1" style="width: 8%">
                            <label for="c_valiva[0].valiva" class="control-label">IVA%:</label>
                            <select name="c_valiva[0].valiva" class="form-control required" style="padding-left: 4px;">
                              @forelse ($iva as $data_iva)
                                @if ( $data_iva->number == 16)
                                  <option value="{{ $data_iva->number }}" selected> {{ $data_iva->number }} </option>
                                @else
                                  <option value="{{ $data_iva->number }}"> {{ $data_iva->number }} </option>
                                @endif
                              @empty
                              @endforelse
                            </select>
                          </div>
                          <div class="col-xs-1" style="width: 8%">
                            <label for="c_descuento[0].descuento" class="control-label" style="font-size:12px">Descuento:</label>
                            <input type="text" class="form-control required" name="c_descuento[0].descuento" placeholder="% Descuento"/>
                          </div>
                          <div class="col-xs-1" style="width: 12.499999995%">
                            <label for="c_montoiva[0].montoiva" class="control-label" style="font-size:12px">Mensualidad c/iva:</label>
                            <input type="text" class="form-control required" name="c_montoiva[0].montoiva" placeholder="Total" readonly/>
                          </div>
                          <div class="col-xs-1" style="width: 12.499999995%">
                            <label for="c_vtcreal[0].vtcreal" class="control-label">VTC S/IVA:</label>
                            <input type="text" class="form-control totalmoneda required" name="c_vtcreal[0].vtcreal" placeholder="Total" readonly/>
                          </div>
                          <div class="col-xs-1" style="width: 12.499999995%">
                            <label for="c_vtcdinamic[0].vtcdinamic" class="control-label">VTC Dinamico:</label>
                            <input type="text" class="form-control totalmoneda required" name="c_vtcdinamic[0].vtcdinamic" placeholder="Total" readonly/>
                          </div>
                          <div class="col-xs-1 ">
                            <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                          </div>
                          <div class="col-xs-3 col-md-offset-9">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" id="c_checkiva[0].checkiva" name="c_checkiva[0].checkiva">
                                No calcular IVA.
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="row clone hide" id="optionTemplateAnexo">
                          <div class="col-xs-1" style="width: 12.499999995%">
                            <input maxlength="10" type="text" class="form-control" name="price" placeholder="Monto Mensual" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" data_row="0"/>
                          </div>
                          <div class="col-xs-1" style="width: 12.499999995%">
                            <select name="coin" class="form-control"  style="padding-left: 4px;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($currency as $data_currency)
                                <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                          <div class="col-xs-2" style="width: 17%">
                            <div class="form-group">
                              <div id="cont_tp" class="input-group">
                                <span class="input-group-btn">
                                  <select datas="tp_forma" class="form-control" id="tcambopt" name="tcambopt">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    <option value="1"> Fijo</option>
                                    <option value="2"> Al dia</option>
                                  </select>
                                </span>
                                <span class="input-group-btn" style="width: 53%">
                                  <input datas="tp_valor" type="text" class="form-control" name="tcamb" placeholder="TC" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly/>
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-xs-1"  style="width: 8%">
                            <select name="valiva" class="form-control" style="padding-left: 4px;">
                              <option value="0">0</option>
                              <option value="16" selected>16</option>
                              @forelse ($iva as $data_iva)
                                @if ( $data_iva->number == 16)
                                  <option value="{{ $data_iva->number }}" selected> {{ $data_iva->number }} </option>
                                @else
                                  <option value="{{ $data_iva->number }}"> {{ $data_iva->number }} </option>
                                @endif
                              @empty
                              @endforelse
                            </select>
                          </div>
                          <div class="col-xs-1" style="width: 8%">
                            <input type="text" class="form-control" name="descuento" placeholder="% Descuento"/>
                          </div>
                          <div class="col-xs-1" style="width: 12.499999995%">
                            <input type="text" class="form-control" name="montoiva" placeholder="Total" readonly/>
                          </div>
                          <div class="col-xs-1" style="width: 12.499999995%">
                            <input type="text" class="form-control" name="vtcreal" placeholder="Total" readonly/>
                          </div>
                          <div class="col-xs-1" style="width: 12.499999995%">
                            <input type="text" class="form-control" name="vtcdinamic" placeholder="Total" readonly/>
                          </div>
                          <div class="col-xs-1">
                            <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                          </div>
                          <div class="col-xs-3 col-md-offset-9">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" id="checkiva" name="checkiva">
                                No calcular IVA.
                              </label>
                            </div>
                          </div>


                        </div>

                      </div>
                    </section>
                    <!-- Step 3 -->
                    <h6>Paso 3 - Sitio (S)</h6>
                    <section>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group row">
                            <label for="cont_vtc" class="col-sm-12 control-label">Contemplar para VTC</label>
                            <div class="col-md-9 mb-3">
                              <input id="cont_vtc" name="cont_vtc" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="0">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group row">
                            <label for="cont_venue" class="col-sm-12 control-label">Contemplar para venue</label>
                            <div class="col-md-9 mb-3">
                              <input id="cont_venue" name="cont_venue" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="0">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group row">
                            <label for="comp_ingreso" class="col-sm-12 control-label">Compartir ingreso</label>
                            <div class="col-md-9 mb-3">
                              <input id="comp_ingreso" name="comp_ingreso" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="0">
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-4">
                          <label for="c_cadena_add[0].cadena_add" class="control-label">Seleccione el grupo:</label>
                          <select name="c_cadena_add[0].cadena_add" class="form-control required" data_row="0">
                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                            @forelse ($cadenas as $data_cadenas)
                              <option value="{{ $data_cadenas->id }}"> {{ $data_cadenas->name }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                        <div class="col-xs-4">
                          <label for="c_hotel_add[0].hotel_add" class="control-label">Seleccione el sitio:</label>
                          <select name="c_hotel_add[0].hotel_add" class="form-control required" data_row="0">
                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                          </select>
                        </div>
                        <div class="col-xs-2">
                          <label for="c_idubicacion[0].idubicacion" class="control-label">ID de ubicación:</label>
                          <input type="text" class="form-control " name="c_idubicacion[0].idubicacion" placeholder="ID ubicación" readonly/>
                        </div>
                        <div class="col-xs-2 mt-25">
                          <button type="button" class="btn btn-default addButtonsitiobeta"><i class="fa fa-plus"></i></button>
                        </div>
                      </div>

                      <div class="row clone hide" id="optionTemplateSitioAnexo">
                        <div class="col-xs-4">
                          <select name="cadena_add" class="form-control" data_row="0">
                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                            @forelse ($cadenas as $data_cadenas)
                              <option value="{{ $data_cadenas->id }}"> {{ $data_cadenas->name }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>

                        <div class="col-xs-4">
                          <select name="hotel_add" class="form-control" data_row="0">
                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                          </select>
                        </div>

                        <div class="col-xs-2">
                          <input type="text" class="form-control " name="idubicacion" placeholder="ID ubicación" readonly/>
                        </div>

                        <div class="col-xs-2">
                          <button type="button" class="btn btn-default removeButtonsitiobeta"><i class="fa fa-minus"></i></button>
                        </div>
                      </div>
                    </section>
                  </form>
                </div>
              </div>
            </div>
        </div>
      <!-- vertical wizard -->
    </div>
    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View create contract') )
    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master-two/steps.css')}}" >
    <link href="{{ asset('bower_components/switchery-master/dist/switchery.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/switchery-master/dist/switchery.js')}}" charset="utf-8"></script>
    <style media="screen">
      .toggle.btn {
        min-width: 5rem !important;
      }
      .sinpadding {
        padding-left: 0px !important;
        padding-right: 0px!important;
      }
      .col-politica {
        font-size: 12px !important;
        width: 100px !important;
      }
      th { font-size: 12px !important; }
      td { font-size: 10px !important; }
      .table th, .table td {
        padding: 0.3rem 0.9375rem !important;
      }
      .sameline {
        display: inline-block;
      }
      .contrato_a{
         display:none;
      }
      .contrato_b{
         display:none;
      }
      input::-webkit-input-placeholder {
          font-size: 12px;
          line-height: 3;
      }
      .text-danger {
          color: #f62d51;;
      }
      .white-box {
       background:#ffffff;
       padding:25px;
       margin-bottom:10px;
       border-color: rgba(120,130,140,.13);
       border: 1px solid #aaa;
      }
      .white-box .box-title {
       margin:0px 0px 12px;
       font-weight:500;
       text-transform:uppercase;
       font-size:16px
      }
      .wizard-steps {
       display:table;
       width:100%
      }
      .wizard-steps>li {
       display:table-cell;
       padding:10px 20px;
       background:#f7fafc
      }
      .wizard-steps>li span {
       border-radius:100%;
       border:1px solid rgba(120, 130, 140, 0.13);
       width:40px;
       height:40px;
       display:inline-block;
       vertical-align:middle;
       padding-top:9px;
       margin-right:8px;
       text-align:center
      }
      .wizard-content {
       padding:5px;
       border-color:rgba(120, 130, 140, 0.13);
       margin-bottom:10px
      }
      .wizard-steps>li.current,.wizard-steps>li.done {
       background:#2cabe3;
       color:#ffffff
      }
      .wizard-steps>li.current span,.wizard-steps>li.done span {
       border-color:#ffffff;
       color:#ffffff
      }
      .wizard-steps>li.current h4,.wizard-steps>li.done h4 {
       color:#ffffff
      }
      .wizard-steps>li.done {
       background:#53e69d
      }
      .wizard-steps>li.error {
       background:#ff7676
      }
      .wiz-aco .pager {
       margin:0px
      }
      .wizard-content .wizard>.actions{
        margin-top: 10px
      }
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
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>

    <script src="{{ asset('/plugins/momentupdate/moment-with-locales.js')}}"></script>

    <script src="{{ asset('js/admin/contract/c_mdrz2.js?v1.0')}}"></script>
    <script src="{{ asset('js/admin/contract/c_mdgrup.js?v1.0')}}"></script>

    <script src="{{ asset('js/admin/contract/c_contrato_general.js?v1.0')}}"></script>

    <script src="{{ asset('js/admin/contract/c_contrato_master.js?v1.0')}}"></script>
    <script src="{{ asset('js/admin/contract/c_contrato_anexo_s1.js?v1.0')}}"></script>
    <script src="{{ asset('js/admin/contract/c_contrato_anexo_s2.js?v1.0')}}"></script>
    <script src="{{ asset('js/admin/contract/c_contrato_anexo_s3.js?v1.0')}}"></script>
    <script src="{{ asset('js/admin/contract/c_contrato_anexo_s4.js?v1.0')}}"></script>

    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.steps.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

    <script src="{{ asset('js/admin/contract/c_table_porcentaje.js?v1.0')}}"></script>

    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
      var item_relation_contact_row = "{{ $item_contact_row }}";
      var item_relation_cierre_row = "{{ $item_cierre_row }}";
      $(function() {
        $("#select_kick_off").select2();
        $("#sel_anexo_service2").select2();
        $('#cont_vtc').bootstrapToggle('off');
        $('#cont_venue').bootstrapToggle('off');
        $('#comp_ingreso').bootstrapToggle('off');

        $('#kickoff_info_div').show();
        $('#div_comisiones').hide();
        item_relation_contact_row = 0;
        item_relation_cierre_row = 0;

        $('#cont_vtc').change(function() {
          if ($(this).prop('checked') == true) {  $('#cont_vtc').val(1);  }
          else {  $('#cont_vtc').val(0);  }
        });
        $('#cont_venue').change(function() {
          if ($(this).prop('checked') == true) {  $('#cont_venue').val(1);  }
          else {  $('#cont_venue').val(0);  }
        });
        $('#comp_ingreso').change(function() {
          if ($(this).prop('checked') == true) {  $('#comp_ingreso').val(1);  }
          else {  $('#comp_ingreso').val(0);  }
        });
        function reset_comision(){
          $('#sel_type_comision').val('').trigger('change');
          $('#sel_inside_sales').val('').trigger('change');
          $('#sel_itconcierge_comision').val('').trigger('change');
          $("#item_politica input[type=text]").val('');
          delete_row_table_a();
          delete_row_table_b();
          delete_row_table_c();
          delete_row_table_d();
        }
        $('#comision22').change(function() {
          if ($(this).prop('checked') == true) {
            cont_vtc = 1;
            $('#div_comisiones').show();
            $("#sel_inside_sales").prop('required',true);
            $("#sel_itconcierge_comision").prop('required',true);
            $('#comision').val(cont_vtc);
          }
          else {
            cont_vtc = 0;
            $('#comision').val(cont_vtc);
            $('#div_comisiones').hide();
            $("#sel_inside_sales").prop('required',false);
            $("#sel_itconcierge_comision").prop('required',false);
          }
          reset_comision();
        });
        $('#sel_type_comision').on('change', function(e){
          var group = $(this).val();
          data_comision(group);
        });

        $('#kick_off_exit').bootstrapToggle('on');
        $('#kick_off_exit').change(function() {
          if ($(this).prop('checked') == true) {
            $('#kick_off_exit').val(1);
            $('#kickoff_info_div').show();
            $('#div_comisiones').hide();
            $("#sel_inside_sales").prop('required',true);
            $("#sel_itconcierge_comision").prop('required',true);
            //Reset
            $('#select_kick_off').val('').trigger('change');
            $('#kick_off_id').val('');
            $('#kick_off_proyecto').val('');
            $('#kick_off_sitio').val('');
          }
          else {
            $('#kick_off_exit').val(0);
            $('#kickoff_info_div').hide();
            $('#div_comisiones').show();
            $("#sel_inside_sales").prop('required',false);
            $("#sel_itconcierge_comision").prop('required',false);
            //Reset
            $('#select_kick_off').val('').trigger('change');
            $('#kick_off_id').val('');
            $('#kick_off_proyecto').val('');
            $('#kick_off_sitio').val('');
          }
          reset_comision();
        });

        $('#select_kick_off').on("change", function(){
          var id = $(this).val();
          var token = $('input[name="_token"]').val();
          if (id) {
            $.ajax({
                url: "/info_kickoff",
                type: "POST",
                data: { _token : token, ident: id },
                success: function (data) {
                  $('#div_comisiones').show();
                  reset_comision();

                  if (typeof data !== 'undefined' && data.length > 0) {
                    datos = JSON.parse(data);
                    $('#kick_off_id').val(datos[0].id);
                    $('#kick_off_proyecto').val(datos[0].nombre_proyecto);
                    $('#kick_off_sitio').val(datos[0].Sitio);
                    kickoff_comision(datos[0].id, token);
                    kickoff_contact(datos[0].id, token);
                    kickoff_cierre(datos[0].id, token);
                  }
                  else{
                    $('#div_comisiones').hide();
                    $('#kick_off_id').val('');
                    $('#kick_off_proyecto').val('');
                    $('#kick_off_sitio').val('');
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
                        alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                    }
                }
            });
          }
          else {
            $('#kick_off_id').val('');
            $('#kick_off_proyecto').val('');
            $('#kick_off_sitio').val('');
            reset_comision();
          }
        });
      });

      function addItemCont() {
        let politica = $("select[name='sel_type_comision']").val();
        if (politica != '') {
          var html = '';
          html += '<tr id="item_row_' + item_relation_contact_row + '">';

          html += '<td class="text-center" style="vertical-align: middle;">';
          html += '<button type="button" onclick="$(\'#item_row_' + item_relation_contact_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
          html += '<i class="fa fa-trash" style="font-size: 1rem;"></i>';
          html += '</button>';
          html += '<input type="hidden" name="item[' + item_relation_contact_row + '][id]" id="item_id_' + item_relation_contact_row + '" /> ';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<select class="form-control input-sm col-contact-int" name="item[' + item_relation_contact_row + '][contactInt]" id="item_contactInt_' + item_relation_contact_row + '" data-row="' + item_relation_contact_row + '">'
          html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
          @forelse ($kickoff_colaboradores as $kickoff_colaboradores_data)
          html += '<option value="{{ $kickoff_colaboradores_data->id  }}">{{ $kickoff_colaboradores_data->name }}</option>';
          @empty
          @endforelse
          html += '</select>';
          html += '</div>';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="text" class="form-control input-sm text-right col-contact" name="item[' + item_relation_contact_row + '][contact]" id="item_contact_' + item_relation_contact_row + '" step="any"/>';
          html += '</div>';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="text" class="form-control input-sm text-right col-porcentaje" name="item[' + item_relation_contact_row + '][porcentaje]" id="item_porcentaje_' + item_relation_contact_row + '" required step="any" maxlength="10" />';
          html += '</div>';
          html += '</td>';

          html += '</tr>';

          $("#validation_anexo #item_contact tbody #add_item_contact").before(html);
          item_relation_contact_row++;
        }
        else {
          $('#sel_inside_sales').val('').trigger('change');
          $('#sel_itconcierge_comision').val('').trigger('change');
          Swal.fire({
             type: 'error',
             title: 'Oops...',
             text: 'Selecciona la politica de comisión',
           });
        }
      }
      function addItemCierre() {
        let politica = $("select[name='sel_type_comision']").val();
        if (politica != '') {
          var html = '';
          html += '<tr id="item_cierre_row_' + item_relation_cierre_row + '">';

          html += '<td class="text-center" style="vertical-align: middle;">';
          html += '<button type="button" onclick="$(\'#item_cierre_row_' + item_relation_cierre_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
          html += '<i class="fa fa-trash" style="font-size: 1rem;"></i>';
          html += '</button>';
          html += '<input type="hidden" name="item_cierre[' + item_relation_cierre_row + '][id]" id="item_cierre_id_' + item_relation_cierre_row + '" /> ';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<select class="form-control input-sm col-cierre-contact-int" name="item_cierre[' + item_relation_cierre_row + '][contactInt]" id="item_cierre_contactInt_' + item_relation_cierre_row + '" data-row="' + item_relation_cierre_row + '">'
          html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
          @forelse ($kickoff_colaboradores as $kickoff_colaboradores_data)
          html += '<option value="{{ $kickoff_colaboradores_data->id  }}">{{ $kickoff_colaboradores_data->name }}</option>';
          @empty
          @endforelse
          html += '</select>';
          html += '</div>';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="text" class="form-control input-sm text-right col-cierre-contact" name="item_cierre[' + item_relation_cierre_row + '][contact]" id="item_cierre_contact_' + item_relation_cierre_row + '" step="any" />';
          html += '</div>';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="text" class="form-control input-sm text-right col-cierre-porcentaje" name="item_cierre[' + item_relation_cierre_row + '][porcentaje]" id="item_cierre_porcentaje_' + item_relation_cierre_row + '" required step="any" maxlength="10" />';
          html += '</div>';
          html += '</td>';

          html += '</tr>';
          $("#validation_anexo #item_cierre tbody #add_item_cierre").before(html);
          item_relation_cierre_row++;
        }
        else {
          $('#sel_inside_sales').val('').trigger('change');
          $('#sel_itconcierge_comision').val('').trigger('change');
          Swal.fire({
             type: 'error',
             title: 'Oops...',
             text: 'Selecciona la politica de comisión',
           });
        }
      }
      function data_comision(identX){
        var id = identX;
        var _token = $('input[name="_token"]').val();
        $.ajax({
          type: "POST",
          url: "/search_politica",
          data: { _token : _token,  text: id},
          success: function (data){
            count_data = data.length;
            if (count_data > 2) {
              datax = JSON.parse(data);
              $('input[name="politica_name"]').val(datax[0].politica.toUpperCase());
              $('input[name="politica_retencion"]').val(datax[0].retenciones);
              $('input[name="politica_asignado"]').val(datax[0].monto_asignado);
              $('input[name="politica_contacto"]').val(datax[0].contacto);
              $('input[name="politica_cierre"]').val(datax[0].cierre);
              $('input[name="politica_itc"]').val(datax[0].itc);
              $('input[name="politica_insidesales"]').val(datax[0].inside_sales);
            }
            else {
              $('input[name="politica_name"]').val('');
              $('input[name="politica_retencion"]').val('0');
              $('input[name="politica_asignado"]').val('0');
              $('input[name="politica_contacto"]').val('0');
              $('input[name="politica_cierre"]').val('0');
              $('input[name="politica_itc"]').val('0');
              $('input[name="politica_insidesales"]').val('0');
            }
          },
          error: function (error, textStatus, errorThrown) {
              if (error.status == 422) {
                  var message = error.responseJSON.error;
                  // $("#general_messages").html(alertMessage("danger", message));
                  Swal.fire("Operación abortada", message, "error");
              }
              else {
                  alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
              }
          }
        });
      }
      function kickoff_comision(ix, token) {
        $.ajax({
            url: "/info_kickoff_comision",
            type: "POST",
            data: { _token : token, ident: ix },
            success: function (data) {
              if (JSON.stringify(data) != '"[]"') {
                datos = JSON.parse(data);
                $('#sel_type_comision').val(datos[0].politica_id).trigger('change');
                $('#sel_inside_sales').val(datos[0].inside_sales).trigger('change');
                $('#sel_itconcierge_comision').val(datos[0].itconcierge).trigger('change');
              }
              else{
                $('#sel_type_comision').val('').trigger('change');
                $('#sel_inside_sales').val('').trigger('change');
                $('#sel_itconcierge_comision').val('').trigger('change');
                $("#item_politica input[type=text]").val('');
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
                    alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                }
            }
        });
      }
      function kickoff_contact(ix, token) {
        $.ajax({
            url: "/info_kickoff_contact",
            type: "POST",
            data: { _token : token, ident: ix },
            success: function (data) {
              data.forEach(function(key,i) {
                var html = '';
                html += '<tr id="item_row_' + item_relation_contact_row + '">';

                html += '<td class="text-center" style="vertical-align: middle;">';
                html += '<button type="button" onclick="$(\'#item_row_' + item_relation_contact_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
                html += '<i class="fa fa-trash" style="font-size: 1rem;"></i>';
                html += '</button>';
                html += '<input type="hidden" name="item[' + item_relation_contact_row + '][id]" id="item_id_' + item_relation_contact_row + '" /> ';
                html += '</td>';

                html += '<td>';
                html += '<div class="form-group form-group-sm">';
                html += '<select class="form-control input-sm col-contact-int" name="item[' + item_relation_contact_row + '][contactInt]" id="item_contactInt_' + item_relation_contact_row + '" data-row="' + item_relation_contact_row + '">'
                html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
                @forelse ($kickoff_colaboradores as $kickoff_colaboradores_data)
                  if ( key.user_id == {{ $kickoff_colaboradores_data->id  }} ) {
                    html += '<option value="{{ $kickoff_colaboradores_data->id  }}" selected>{{ $kickoff_colaboradores_data->name }}</option>';
                  }
                  else {
                    html += '<option value="{{ $kickoff_colaboradores_data->id  }}">{{ $kickoff_colaboradores_data->name }}</option>';
                  }
                @empty
                @endforelse
                html += '</select>';
                html += '</div>';
                html += '</td>';

                html += '<td>';
                html += '<div class="form-group form-group-sm">';
                if ( key.nombre == null ||  key.nombre == '' ) {
                  html += '<input type="text" class="form-control input-sm text-right col-contact" name="item[' + item_relation_contact_row + '][contact]" id="item_contact_' + item_relation_contact_row + '" value="" step="any"/>';
                }
                else {
                  html += '<input type="text" class="form-control input-sm text-right col-contact" name="item[' + item_relation_contact_row + '][contact]" id="item_contact_' + item_relation_contact_row + '" value="' + key.nombre + '" step="any"/>';
                }
                html += '</div>';
                html += '</td>';

                html += '<td>';
                html += '<div class="form-group form-group-sm">';
                html += '<input type="text" class="form-control input-sm text-right col-porcentaje" name="item[' + item_relation_contact_row + '][porcentaje]" id="item_porcentaje_' + item_relation_contact_row + '" value="' + key.valor_comision + '" required step="any" maxlength="10" />';
                html += '</div>';
                html += '</td>';

                html += '</tr>';

                $("#validation_anexo #item_contact tbody #add_item_contact").before(html);
                item_relation_contact_row++;
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
                } else {
                    alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                }
            }
        });
      }
      function kickoff_cierre(ix, token) {
        $.ajax({
            url: "/info_kickoff_cierre",
            type: "POST",
            data: { _token : token, ident: ix },
            success: function (data) {
              data.forEach(function(key,i) {
                var html = '';
                html += '<tr id="item_cierre_row_' + item_relation_cierre_row + '">';

                html += '<td class="text-center" style="vertical-align: middle;">';
                html += '<button type="button" onclick="$(\'#item_cierre_row_' + item_relation_cierre_row + '\').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
                html += '<i class="fa fa-trash" style="font-size: 1rem;"></i>';
                html += '</button>';
                html += '<input type="hidden" name="item_cierre[' + item_relation_cierre_row + '][id]" id="item_cierre_id_' + item_relation_cierre_row + '" /> ';
                html += '</td>';

                html += '<td>';
                html += '<div class="form-group form-group-sm">';
                html += '<select class="form-control input-sm col-cierre-contact-int" name="item_cierre[' + item_relation_cierre_row + '][contactInt]" id="item_cierre_contactInt_' + item_relation_cierre_row + '" data-row="' + item_relation_cierre_row + '">'
                html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
                @forelse ($kickoff_colaboradores as $kickoff_colaboradores_data)
                if ( key.user_id == {{ $kickoff_colaboradores_data->id  }} ) {
                  html += '<option value="{{ $kickoff_colaboradores_data->id  }}" selected>{{ $kickoff_colaboradores_data->name }}</option>';
                }
                else {
                  html += '<option value="{{ $kickoff_colaboradores_data->id  }}">{{ $kickoff_colaboradores_data->name }}</option>';
                }
                @empty
                @endforelse
                html += '</select>';
                html += '</div>';
                html += '</td>';

                html += '<td>';
                html += '<div class="form-group form-group-sm">';
                if ( key.nombre == null ||  key.nombre == '' ) {
                  html += '<input type="text" class="form-control input-sm text-right col-cierre-contact" name="item_cierre[' + item_relation_cierre_row + '][contact]" id="item_cierre_contact_' + item_relation_cierre_row + '" step="any" />';
                }
                else {
                  html += '<input type="text" class="form-control input-sm text-right col-cierre-contact" name="item_cierre[' + item_relation_cierre_row + '][contact]" id="item_cierre_contact_' + item_relation_cierre_row + '" value="' + key.nombre + '" step="any" />';
                }
                html += '</div>';
                html += '</td>';

                html += '<td>';
                html += '<div class="form-group form-group-sm">';
                html += '<input type="text" class="form-control input-sm text-right col-cierre-porcentaje" name="item_cierre[' + item_relation_cierre_row + '][porcentaje]" id="item_cierre_porcentaje_' + item_relation_cierre_row + '" value="' + key.valor_comision + '" required step="any" maxlength="10" />';
                html += '</div>';
                html += '</td>';

                html += '</tr>';
                $("#validation_anexo #item_cierre tbody #add_item_cierre").before(html);
                item_relation_cierre_row++;
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
                } else {
                    alert(errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText);
                }
            }
        });
      }

    </script>
    <script>
      $(function() {
        $('#select_one').val('').trigger('change');
        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function() {
          var input = $(this),
              numFiles = input.get(0).files ? input.get(0).files.length : 1,
              label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
          input.trigger('fileselect', [numFiles, label]);
        });
        // We can watch for our custom `fileselect` event like this
        $(document).ready( function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });
        });
      });
      $.validator.addMethod('filesize', function(value, element, param) {
          // param = size (in bytes)
          // element = element to validate (<input>)
          // value = value of the element (file name)
          return this.optional(element) || (element.files[0].size <= param)
      });
      //Contrato Maestro
      var form_master = $(".validation-wizard-master").show();
      $(".validation-wizard-master").steps({
          headerTag: "h6",
          bodyTag: "section",
          transitionEffect: "fade",
          titleTemplate: '<span class="step">#index#</span> #title#',
          labels: {
              finish: "Submit"
          },
          onStepChanging: function (event, currentIndex, newIndex) {
              return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form_master.find(".body:eq(" + newIndex + ") label.error").remove(), form_master.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form_master.validate().settings.ignore = ":disabled,:hidden", form_master.valid())
          },
          onFinishing: function (event, currentIndex) {
              return form_master.validate().settings.ignore = ":disabled", form_master.valid()
          },
          onFinished: function (event, currentIndex) {
            event.preventDefault();
              // swal("form_master Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
            /************************************************************************************/
            Swal.fire({
              title: "Estás seguro?",
              text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              showLoaderOnConfirm: true,
            }).then((result) => {
              if (result.value) {

              var form = $('#validation_master')[0];
              var formData = new FormData(form);

              formData.append('key_maestro_service', $('input[name="key_maestro_service"]').val() );
              formData.append('key_maestro_verticals', $('input[name="key_maestro_verticals"]').val() );
              formData.append('key_maestro_cadena', $('input[name="key_maestro_cadena"]').val() );
              formData.append('key_maestro_contrato', $('input[name="key_maestro_contrato"]').val() );
              formData.append('key_maestro_sitio', $('input[name="key_maestro_sitio"]').val() );

              $.ajax({
                      type: "POST",
                      url: "/create_contract_master",
                      data: formData,
                      contentType: false,
                      processData: false,
                      success: function (data){
                      datax = data;
                      if (datax != '0') {
                              Swal.fire("Operación Completada!", ":)", "success");
                              }
                      else {
                              $('#modal_cadena').modal('toggle');
                              Swal.fire("Operación abortada", "Error al registrar intente otra vez :(", "error");
                            }
                              $("#validation_master")[0].reset();
                              var validator = $( "#validation_master" ).validate();
                              validator.resetForm();
                              $("#validation_master-t-0").get(0).click();

                              $('input[name="key_maestro_service"]').val('');
                              $('input[name="key_maestro_verticals"]').val('');
                              $('input[name="key_maestro_cadena"]').val('');
                              $('input[name="key_maestro_contrato"]').val('');
                              $('input[name="key_maestro_sitio"]').val('');

                                    },
                              error: function (data) {
                              console.log('Error:', data);
                              Swal.close();
                                    }
                                  })//Fin ajax

              }//Fin if result.value
              else {
               Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
             }
            })
            /************************************************************************************/
          }
      }), $(".validation-wizard-master").validate({
          ignore: "input[type=hidden]",
          errorClass: "text-danger",
          successClass: "text-success",
          highlight: function (element, errorClass) {
              $(element).removeClass(errorClass)
          },
          unhighlight: function (element, errorClass) {
              $(element).removeClass(errorClass)
          },
          errorPlacement: function (error, element) {
              // error.insertAfter(element);
              if (element[0].id === 'fileInput') {
                error.insertAfter($('#cont_file'));
              }
              else {
                error.insertAfter(element);
              }
          },
          rules: {
              contact_email: {
                email: true
              },
              fileInput: {
                extension: 'pdf',
                filesize: 20000000
              },
              contact_telephone: {
                required: true,
                number: true,
                minlength: 7,
                maxlength: 10
              },
          },
          messages: {
                  fileInput:{
                      filesize:" file size must be less than 20 MB.",
                      accept:"Please upload .pdf file of notice.",
                      required:"Please upload file."
                  }
              },
      })

      //Anexo Contrato Maestro
      var form_anexo = $(".validation-wizard-anexo").show();
      $(".validation-wizard-anexo").steps({
          headerTag: "h6",
          bodyTag: "section",
          transitionEffect: "fade",
          titleTemplate: '<span class="step">#index#</span> #title#',
          labels: {
              finish: "Submit"
          },
          onStepChanging: function (event, currentIndex, newIndex) {
              return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form_anexo.find(".body:eq(" + newIndex + ") label.error").remove(), form_anexo.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form_anexo.validate().settings.ignore = ":disabled,:hidden", form_anexo.valid())
          },
          onFinishing: function (event, currentIndex) {
              return form_anexo.validate().settings.ignore = ":disabled", form_anexo.valid()
          },
          onFinished: function (event, currentIndex) {
            event.preventDefault();
              // swal("form_master Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
            /************************************************************************************/
            Swal.fire({
              title: "Estás seguro?",
              text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              showLoaderOnConfirm: true,
            }).then((result) => {
              if (result.value) {
                var form = $('#validation_anexo')[0];
                var formData = new FormData(form);

                formData.append('key_anexo_service', $('input[name="key_anexo_service"]').val() );
                formData.append('key_anexo_verticals', $('input[name="key_anexo_verticals"]').val() );
                formData.append('key_anexo_cadena', $('input[name="key_anexo_cadena"]').val() );
                formData.append('key_anexo_contrato', $('input[name="key_anexo_contrato"]').val() );
                formData.append('key_anexo_sitio', $('input[name="key_anexo_sitio"]').val() );

                formData.append('contador_max', conceptIndex);
                formData.append('contadores_elim', constante_eliminar);

                formData.append('site_contador_max', conceptIndexSiteAnexo);
                formData.append('site_contadores_elim', constante_eliminar_site_anexo);
                formData.append('cont_vtc', $('#cont_vtc').val());
                formData.append('cont_venue', $('#cont_venue').val());
                formData.append('comp_ingreso', $('#comp_ingreso').val());

                $.ajax({
                  type: "POST",
                  url: "/create_contract_annexes",
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function (data){
                    datax = data;
                    if (datax != '0') {
                      Swal.fire("Operación Completada!", ":)", "success");
                    }
                    else {
                      $('#modal_cadena').modal('toggle');
                      Swal.fire("Operación abortada", "Error al registrar intente otra vez :(", "error");
                    }
                    $("#validation_anexo")[0].reset();
                    var validator = $( "#validation_anexo" ).validate();
                    validator.resetForm();
                    $("#validation_anexo-t-0").get(0).click();
                    $('input[name="key_anexo_service"]').val('');
                    $('input[name="key_anexo_verticals"]').val('');
                    $('input[name="key_anexo_cadena"]').val('');
                    $('input[name="key_anexo_contrato"]').val('');
                    $('input[name="key_anexo_sitio"]').val('');
                    delete_row_table_a();
                    delete_row_table_b();
                    delete_row_table_c();
                    delete_row_table_d();
                    $('#comision').bootstrapToggle('off');
                    $('#cont_vtc').bootstrapToggle('off');
                    $('#cont_venue').bootstrapToggle('off');
                    $('#comp_ingreso').bootstrapToggle('off');

                    $('#comision').val(0);
                    $('#cont_vtc').val(0);
                    $('#cont_venue').val(0);
                    $('#comp_ingreso').val(0);
                    $('#div_comisiones').hide();
                  },
                  error: function (data) {
                    console.log('Error:', data);
                    Swal.close();
                  }
                })//Fin ajax
              }//Fin if result.value
              else {
                Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
              }
            })//Fin then
            /************************************************************************************/
          }
      }), $(".validation-wizard-anexo").validate({
          ignore: "input[type=hidden]",
          errorClass: "text-danger",
          successClass: "text-success",
          highlight: function (element, errorClass) {
              $(element).removeClass(errorClass)
          },
          unhighlight: function (element, errorClass) {
              $(element).removeClass(errorClass)
          },
          errorPlacement: function (error, element) {
              var attr = $('[name="'+element[0].name+'"]').attr('datas');
              if (element[0].id === 'fileInputAnexo') {
                error.insertAfter($('#cont_file_anexo'));
              }
              else {
                if(attr == 'tp_forma'){
                  error.insertAfter($('#cont_tp'));
                }
                else if(attr == 'tp_valor'){
                  error.insertAfter($('#cont_tp'));
                }
                else {
                  error.insertAfter(element);
                }
              }
          },
          rules: {
              contact_email: {
                email: true
              },
              fileInputAnexo: {
                extension: 'pdf',
                filesize: 20000000
              },
              contact_telephone: {
                required: true,
                number: true,
                minlength: 7,
                maxlength: 10
              },
          },
          messages: {
                  fileInput:{
                      filesize:" file size must be less than 20 MB.",
                      accept:"Please upload .pdf file of notice.",
                      required:"Please upload file."
                  }
          },
      })
    </script>
  @else

  @endif
@endpush
