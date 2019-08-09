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
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>RFC</label>
                                <input type="text" class="form-control required" id="n_rfc" name="n_rfc">
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Razon Social</label>
                                <input type="text" class="form-control required" id="rfc_name" name="rfc_name">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="rfc_type" class="control-label">Tipo</label>
                                  <select id="rfc_type" name="rfc_type" class="form-control select2" style="width:100%;">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    @forelse ($rz_type as $data_rz_type)
                                    <option value="{{ $data_rz_type->id }}"> {{ $data_rz_type->name }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="rfc_nacionalidad" class="control-label">Nacionalidad</label>
                                  <select id="rfc_nacionalidad" name="rfc_nacionalidad" class="form-control select2" style="width:100%;">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    @forelse ($rz_nationality as $data_rz_nationality)
                                    <option value="{{ $data_rz_nationality->id }}"> {{ $data_rz_nationality->name }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Dirección 1</label>
                                <input type="text" class="form-control required" id="rfc_dir1" name="rfc_dir1">
                              </div>

                              <div class="form-group">
                                <label>Dirección 2</label>
                                <input type="text" class="form-control" id="rfc_dir2" name="rfc_dir2">
                              </div>

                              <div class="form-group">
                                <label>Email para la facturación:</label>
                                <input type="text" class="form-control required" id="email_fact" name="email_fact">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="rfc_comp" class="control-label">Concepto de facturación</label>
                                  <select id="rfc_comp" name="rfc_comp" class="form-control select2" style="width:100%;">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    @forelse ($rz_concept_invoice as $data_z_concept_invoice)
                                    <option value="{{ $data_z_concept_invoice->id }}"> {{ $data_z_concept_invoice->key }} {{ $data_z_concept_invoice->name }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group">
                                <label >Codigo Postal</label>
                                <input type="text" class="form-control required" id="rfc_cp" name="rfc_cp">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Pais</label>
                                <input type="text" class="form-control required" id="rfc_pais" name="rfc_pais" readonly>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Estado</label>
                                <input type="text" class="form-control required" id="rfc_estado" name="rfc_estado" readonly>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group">
                                <label >Municipio</label>
                                <input type="text" class="form-control required" id="rfc_municipio" name="rfc_municipio" readonly>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Localidad</label>
                                <input type="text" class="form-control required" id="rfc_localidad" name="rfc_localidad" readonly>
                              </div>
                            </div>

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
                                  <label for="contact_name" class="control-label">Nombre:</label>
                                  <input type="text" class="form-control required" id="contact_name" name="contact_name">
                                </div>

                                <div class="form-group">
                                  <label for="contact_email" class="control-label">Email:</label>
                                  <input type="text" class="form-control required" id="contact_email" name="contact_email">
                                </div>

                                <div class="form-group">
                                  <label for="contact_telephone" class="control-label">Telefono:</label>
                                  <input type="text" class="form-control required" id="contact_telephone" name="contact_telephone" maxlength="10">
                                </div>
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
                              <option value="5">Angel Gabriel</option>
                              <option value="4">Angel Lopez</option>
                              <option value="3">Jose Luis</option>

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
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="num_vto" class="control-label">Plazo de vencimiento (Dias):</label>
                            <input class="form-control required" id="num_vto" name="num_vto" type="number" min="0" max="99" maxlength="2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
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
                      <div class="col-xs-1">
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
                            <span class="input-group-btn ">
                              <input datas="tp_valor" type="text" class="form-control" name="c_tcamb[0].tcamb" placeholder="TC" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly />
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-1">
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
                      <div class="col-xs-2">
                        <div class="form-group">
                          <div id="cont_tp" class="input-group">
                            <span class="input-group-btn">
                              <select datas="tp_forma" class="form-control" id="tcambopt" name="tcambopt">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                                <option value="1"> Fijo</option>
                                <option value="2"> Al dia</option>
                              </select>
                            </span>
                            <span class="input-group-btn">
                              <input datas="tp_valor" type="text" class="form-control" name="tcamb" placeholder="TC" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly/>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-1">
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
                        <div class="col-md-12">
                          <div class="form-group">
                            <p class="text-success text-right">
                              <button type="button" class="btn btn-info" title="Recargar"><i class="fa fa-refresh" aria-hidden="true"></i> Recargar y Resetear</button>
                            </p>
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
<!--  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-3-right-offset.css')}}" >
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extras-margins-padding.css')}}" >-->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master-two/steps.css')}}" >
  <style>

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
  </style>
  <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
  <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>

  <script src="{{ asset('/plugins/momentupdate/moment-with-locales.js')}}"></script>

  <script src="{{ asset('js/admin/contract/c_mdrz.js')}}"></script>
  <script src="{{ asset('js/admin/contract/c_mdgrup.js')}}"></script>

  <script src="{{ asset('js/admin/contract/c_contrato_general.js')}}"></script>

  <script src="{{ asset('js/admin/contract/c_contrato_master.js')}}"></script>
  <script src="{{ asset('js/admin/contract/c_contrato_anexo_s1.js')}}"></script>
  <script src="{{ asset('js/admin/contract/c_contrato_anexo_s2.js')}}"></script>
  <script src="{{ asset('js/admin/contract/c_contrato_anexo_s3.js')}}"></script>

  <!-- <script src="{{ asset('js/admin/contract/c_contrato2.js')}}"></script> -->
  <!-- <script src="{{ asset('js/admin/contract/c_contrato.js')}}"></script> -->

  <!-- FormValidation plugin and the class supports validating Bootstrap form -->
  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.steps.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>


  <!-- FormValidation -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <!-- FormValidation plugin and the class supports validating Bootstrap form -->
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

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
            swal({
              title: "Estás seguro?",
              text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              closeOnConfirm: false,
              closeOnCancel: false,
              showLoaderOnConfirm: true,
            },
            function(isConfirm) {
              if (isConfirm) {

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
                        swal("Operación Completada!", ":)", "success");
                      }
                      else {
                        $('#modal_cadena').modal('toggle');
                        swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
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
                      swal.close();
                    }
                  })

              } else {
                swal("Operación abortada", "Ningúna operación afectuada :)", "error");
              }
            });
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
            swal({
              title: "Estás seguro?",
              text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              closeOnConfirm: false,
              closeOnCancel: false,
              showLoaderOnConfirm: true,
            },
            function(isConfirm) {
              if (isConfirm) {

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

                  $.ajax({
                    type: "POST",
                    url: "/create_contract_annexes",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data){
                      datax = data;
                      if (datax != '0') {
                        swal("Operación Completada!", ":)", "success");
                      }
                      else {
                        $('#modal_cadena').modal('toggle');
                        swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
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
                    },
                    error: function (data) {
                      console.log('Error:', data);
                      swal.close();
                    }
                  })

              } else {
                swal("Operación abortada", "Ningúna operación afectuada :)", "error");
              }
            });
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
            // console.log(element[0].name);
            // console.log(attr);
            // console.log($('[name="'+element[0].name+'"]'));

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
