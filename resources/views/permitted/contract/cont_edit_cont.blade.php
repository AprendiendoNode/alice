@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View edit contract') )
    {{ trans('message.contrat_edit') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View edit contract') )
    {{ trans('message.breadcrumb_contrat_edit') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View edit contract') )

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
              <div class="col-sm-12">
                <div class="white-box contrato_a">
                    <div class="wizard-content">
                        <h4 class="">Editar contrato maestro</h4>
                        <!-- <h6 class="card-subtitle"></h6> -->
                        <div class="row">
                          <div class="col-md-10">
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
                            <h6>Paso 1 - Buscar contrato maestro</h6>
                            <section>
                              <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                  <div class="form-group">
                                    <label for="sel_master_service"> Selecciona el servicio:
                                      <span style="color:red;">*</span>
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
                                      <span style="color:red;">*</span>
                                    </label>
                                    <select class="form-control required" id="sel_master_vertical" name="sel_master_vertical" style="width:100%;">
                                      <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-8 col-md-offset-2">
                                  <label for="sel_master_cadenas"> Selecciona el grupo:
                                    <span style="color:red;">*</span>
                                  </label>
                                  <div class="form-group">
                                    <select id="sel_master_cadenas" name="sel_master_cadenas" class="form-control required" style="width:100%;">
                                      <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    </select>
                                  </div>
                                </div>

                              <div class="col-md-8 col-md-offset-2">
                                    <label for="sel_master_cadenas"> Selecciona el número de contrato:
                                      <span style="color:red;">*</span>
                                    </label>
                                    <div class="form-group">
                                      <select id="sel_master_digit" name="sel_master_digit" class="form-control required" style="width:100%;">
                                        <option value="" selected>{{ trans('pay.select_op') }}</option>
                                      </select>
                                    </div>
                              </div>
                            </div>
                              <div class="clearfix mt-20"></div>
                            </section>
                            <!-- Step 2 -->
                            <h6>Paso 2 - RFC & Datos Informativos</h6>
                            <section>
                              <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                  <div class="form-group">
                                    <label for="sel_razon"> Selecciona la razon social: </label>
                                    <div class="form-group">
                                      <select id="sel_razon" name="sel_razon" class="form-control required" data_row="0">
                                        <option value="" selected>{{ trans('pay.select_op') }}</option>
                                        @forelse ($rz_customer as $data_rz_customer)
                                        <option value="{{ $data_rz_customer->id }}"> {{ $data_rz_customer->name }} </option>
                                        @empty
                                        @endforelse
                                      </select>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-8 col-md-offset-2">
                                  <!--<u> Datos de cobranza</u>-->
                                  <div class="form-group">
                                    <label for="contact_name" class="control-label">RFC</label>
                                    <input type="text" class="form-control " id="contact_taxid" name="contact_name" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="contact_name" class="control-label">Razón social</label>
                                    <input type="text" class="form-control" id="contact_numid" name="contact_name" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="contact_email" class="control-label">Email:</label>
                                    <input type="text" class="form-control" id="contact_email" name="contact_email" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="contact_telephone" class="control-label">Telefono:</label>
                                    <input type="text" class="form-control " id="contact_telephone" name="contact_telephone" maxlength="10" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="contact_telephone" class="control-label">Celular:</label>
                                    <input type="text" class="form-control " id="contact_cellphone" name="contact_telephone" maxlength="10" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="contact_telephone" class="control-label">Dirección:</label>
                                    <input type="text" class="form-control " id="contact_address" name="contact_telephone" maxlength="10" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="contact_telephone" class="control-label">Código Postal:</label>
                                    <input type="text" class="form-control " id="contact_postcode" name="contact_telephone" maxlength="10" readonly>
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
                                                  Contrato (PDF) <input id="fileInput" name="fileInput" type="file" style="display: none;" class="">
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
              <!-- FIN FORMULARIO CONTRATO MAESTRO-->
              <div class="col-sm-12">
                <div class="white-box contrato_b">
                  <div class="wizard-content">
                    <h4 class="">Editar anexo de contrato</h4>
                    <div class="row">
                      <div class="col-md-10">
                        <h5 class="mb-3">Id del anexo de contrato:</h5>
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
                    </div>
                    <br><br>
                    <form id="validation_anexo" name="validation_anexo" enctype="multipart/form-data" class="validation-wizard-anexo wizard-circle m-t-40">
                      {{ csrf_field() }}
                      <h6>Paso 1 - Buscar Contrato Anexo</h6>
                      <section>
                        <div class="row">
                          <div class="col-7">
                            <div class="row">
                              <div class="col-md-10 col-md-offset-2">
                                <div class="form-group">
                                  <label for="sel_anexo_service"> Selecciona el servicio:
                                  </label>
                                  <select id="sel_anexo_service" name="sel_anexo_service" class="form-control form-control-sm required" name="location" style="width:100%;">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                    @forelse ($classifications as $data_classifications)
                                    <option value="{{ $data_classifications->id }}"> {{ $data_classifications->name }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-10 col-md-offset-2">
                                <div class="form-group">
                                  <label for="sel_anexo_vertical"> Selecciona la vertical:
                                  </label>
                                  <select class="form-control form-control-sm required" id="sel_anexo_vertical" name="sel_anexo_vertical" style="width:100%;">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-10 col-md-offset-2">
                                <label for="sel_anexo_cadenas"> Selecciona el grupo:
                                </label>
                                <select id="sel_anexo_cadenas" name="sel_anexo_cadenas" class="form-control form-control-sm required" style="width:100%;">
                                  <option value="" selected>{{ trans('pay.select_op') }}</option>
                                </select>
                              </div>
                              <div class="col-md-10 col-md-offset-2">
                                <div class="form-group">
                                  <label for="sel_master_to_anexo"> Selecciona el contrato maestro:
                                  </label>
                                  <select class="form-control form-control-sm required" id="sel_master_to_anexo" name="sel_master_to_anexo" style="width:100%;">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-10 col-md-offset-2">
                                <div class="form-group">
                                  <label for="sel_master_to_anexo"> Selecciona el contrato anexo:
                                  </label>
                                  <select class="form-control form-control-sm required" id="sel_anexo" name="sel_anexo" style="width:100%;">
                                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                                  </select>
                                </div>
                              </div>
                              <div class="clearfix mt-20"></div>
                            </div>
						  </div>
						  <!-------->
						  <div class="col-md-5">
							<h5 class="text-dark">Resumen del anexo</h5>
							<p><strong>Razón social: <span id="rz_annexo"></span></strong></p>
							<p><strong>RFC: <span id="rfc_annexo"></span></strong></p>
							<p><strong>Sitios: </strong></p>
							<ul id="sitios_anexos">
								
							</ul>
						  </div>
                        </div>
                      </section>
                      <!-- Step 2 -->
                      <h6>Información</h6>
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
                                @for ($i = 1; $i <= 72; $i++)
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
                              <label for="contract_real_date" class="control-label">Fecha inicio real:</label>
                              <input type="text" class="form-control datepickercomplete required" id="contract_real_date" name="contract_real_date">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="fileInputAnexo"> Cargar anexo del contrato:</label>
                              <div id="cont_file_anexo" class="">
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary">
                                            Contrato (PDF Max 20MB) <input id="fileInputAnexo" name="fileInputAnexo" type="file" style="display: none;" class="">
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
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="payment_term_id" class="control-label">Término de pago (Días) (Para facturación):</label>
                              <select class="form-control required" id="payment_term_id" name="payment_term_id" style="width:100%;">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                                @forelse ($payment_term as $payment_term_data)
                                  <option value="{{ $payment_term_data->id  }}">{{ $payment_term_data->name }}</option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                          <!-- <div class="col-md-4">
                            <div class="form-group">
                              <label for="edit_num_vto" class="control-label">Plazo de vencimiento (Dias):</label>
                              <input class="form-control required" id="edit_num_vto" name="edit_num_vto" type="number" min="0" max="99" maxlength="2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                          </div> -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="sel_unitmeasure">  Unidad de medida (Para facturación):
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
                              <label for="sel_satproduct">  Prod/Serv SAT (Para facturación):
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
                          <!-- Nuevo. -->
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="payment_way_id">  Forma de pago (Para facturación):
                                </label>
                                <select class="form-control required" id="payment_way_id" name="payment_way_id" style="width:100%;">
                                  <option value="" selected>{{ trans('pay.select_op') }}</option>
                                  @forelse ($payment_way as $payment_way_data)
                                    <option value="{{ $payment_way_data->id  }}">[{{ $payment_way_data->code }}] {{ $payment_way_data->name }}</option>
                                  @empty
                                  @endforelse
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="payment_method_id">  Método de pago (Para facturación):
                                </label>
                                <select class="form-control required" id="payment_method_id" name="payment_method_id" style="width:100%;">
                                  <option value="" selected>{{ trans('pay.select_op') }}</option>
                                  @forelse ($payment_methods as $payment_methods_data)
                                    <option value="{{ $payment_methods_data->id  }}">[{{ $payment_methods_data->code }}] {{ $payment_methods_data->name }}</option>
                                  @empty
                                  @endforelse
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="cfdi_use_id">  Uso de cfdi (Para facturación):
                                </label>
                                <select class="form-control required" id="cfdi_use_id" name="cfdi_use_id" style="width:100%;">
                                  <option value="" selected>{{ trans('pay.select_op') }}</option>
                                  @forelse ($cfdi_uses as $cfdi_uses_data)
                                    <option value="{{ $cfdi_uses_data->id  }}">[{{ $cfdi_uses_data->code }}] {{ $cfdi_uses_data->name }}</option>
                                  @empty
                                  @endforelse
                                </select>
                              </div>
                            </div>
                          <!-- End nuevo -->
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="description_fact" class="control-label">Descripcion (Para facturación):</label>
                              <input class="form-control required" id="description_fact" name="description_fact" type="text">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                        <div class="pt-3 col-md-3">
                            <p>Contemplar para VTC</p>
                            <input type="checkbox" id="cont_vtc" class="js-switch" name="">
                        </div>
                        <div class="pt-3 col-md-3">
                            <p>Contemplar para venue</p>
                            <input type="checkbox" id="cont_venue" class="js-switch" name="">
                        </div>
                        <div class="pt-3 col-md-3">
                            <p>Compartir ingreso</p>
                            <input type="checkbox" id="comp_ingreso" class="js-switch" name="">
                        </div>

                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <h5><strong>Sitios</strong></h5>
                            <div class="table-responsive">
                              <table id="table_site" name='table_site' class="display nowrap table table-bordered table-hover" width="100%" cellspacing="0">
                                <thead>
                                  <tr class="bg-default" style="font-size: 11.5px; ">
                                    <th> <small>id</small> </th>
                                    <th> <small>Cadena</small> </th>
                                    <th> <small>Hotel</small> </th>
                                    <th> <small>Id ubicacion</small> </th>
                                    <th> <small>Opciones</small> </th>
                                  </tr>
                                </thead>
                                <tbody style="background: #FFFFFF; font-size: 11.5px; ">
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <h5><strong>Moneda</strong></h5>
                            <div class="table-responsive">
                              <table id="table_coin" name='table_coin' class="display nowrap table table-bordered table-hover" width="100%" cellspacing="0">
                                <thead>
                                  <tr class="bg-default" style="font-size: 11.5px; ">
                                    <th> <small>id</small> </th>
                                    <th> <small>Monto</small> </th>
                                    <th> <small>Moneda</small> </th>
                                    <th> <small>TC</small> </th>
                                    <th> <small>Valor TC</small> </th>
                                    <th> <small>Iva</small> </th>
                                    <th> <small>Descuento</small> </th>
                                    <th> <small>Opciones</small> </th>
                                  </tr>
                                </thead>
                                <tbody style="background: #FFFFFF; font-size: 11.5px; ">
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </section>

                    </form>
                  </div>
                </div>
              </div>

            </div>
        </div>
    </div>

    <div class="modal modal-default fade" id="modal-Creatsite" data-backdrop="static">
        <div class="modal-dialog" >
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>Añadir</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="card table-responsive">
                <div class="card-body">
                  <div class="row">
                    <div class="col-xs-12">
                      <form class="form-horizontal" id="Creatnewsite" name="Creatnewsite">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <label for="cadena_add" class="col-xs-2 control-label">Seleccione la cadena:</label>
                          <div class="col-xs-10">
                            <select id="cadena_add" name="cadena_add" class="form-control select2 required" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($cadenas as $data_cadenas)
                                <option value="{{ $data_cadenas->id }}"> {{ $data_cadenas->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="site_add" class="col-xs-2 control-label">Seleccione el sitio:</label>
                          <div class="col-xs-10">
                            <select id="site_add" name="site_add" class="form-control select2 required" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="id_ubicacion_add" class="col-md-2 control-label">ID de ubicación:</label>
                          <div class="col-md-10">
                            <input class="form-control" type="text" name="id_ubicacion_add" id="id_ubicacion_add" readonly>
                          </div>
                        </div>
                        <button type="submit" class="btn bg-navy"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>Actualizar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }} & {{ trans('message.ccmodal') }}</button>
                      </form>
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
    <!---MODAL ADD COIN--->
    <div class="modal modal-default fade" id="modal-Creatcoin" data-backdrop="static">
        <div class="modal-dialog" >
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>Añadir</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="card table-responsive">
                <div class="card-body">
                  <div class="row">
                    <div class="col-xs-12">
                      <form class="form-horizontal" id="Creatnewcoin" name="Creatnewcoin">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <label for="mensualidad_add" class="col-md-4 control-label">Mensualidad:</label>
                          <div class="col-md-8">
                            <input class="form-control required" type="text" name="mensualidad_add" id="mensualidad_add" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="moneda_add" class="col-xs-4 control-label">Elija la moneda:</label>
                          <div class="col-xs-8">
                            <select id="moneda_add" name="moneda_add" class="form-control select2 required" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($currency as $data_currency)
                                <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-xs-4 text-right">
                            <label for="formatcoption" class="control-label text-right">Tipo de cambio:</label>
                          </div>
                          <div class="col-xs-8">
                            <div id="cont_tp" class="input-group">
                              <span class="input-group-btn">
                                <select datas="tp_forma" class="form-control required" id="formatcoption" name="formatcoption">
                                  <option value="" selected>{{ trans('pay.select_op') }}</option>
                                  <option value="1"> Fijo</option>
                                  <option value="2"> Al dia</option>
                                </select>
                              </span>
                              <span class="input-group-btn">
                                <input datas="tp_valor" type="text" class="form-control" id="formatcvalue" name="formatcvalue" placeholder="TC" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly/>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="iva_add" class="col-xs-4 control-label">IVA%:</label>
                          <div class="col-xs-8">
                            <select id="iva_add" name="iva_add" class="form-control select2 required" style="width:100%;">
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
                        </div>

                        <div class="form-group">
                          <label for="mensconiva_add" class="col-md-4 control-label">Mensualidad c/iva:</label>
                          <div class="col-md-8">
                            <input class="form-control" type="text" name="mensconiva_add" id="mensconiva_add" readonly>
                          </div> 
                        </div>
                        <div class="form-group">
                          <label for="descuento_add" class="col-md-4 control-label">Descuento %:</label>
                          <div class="col-md-8">
                            <input class="form-control" value="0" type="text" name="descuento_add" id="descuento_add">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="monto_descuento_add" class="col-md-4 control-label">Monto descuento :</label>
                          <div class="col-md-8">
                            <input class="form-control" type="text" name="monto_descuento_add" id="monto_descuento_add">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="monto_sin_descuento_add" class="col-md-4 control-label">Monto sin descuento :</label>
                          <div class="col-md-8">
                            <input class="form-control" type="text" name="monto_sin_descuento_add" id="monto_sin_descuento_add">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-12 text-right">
                            <br><p><strong>Nota:</strong> Solo se puede dar de alta una moneda de cada tipo.</p>
                          </div>
                        </div>
                        
                        <button type="submit" class="btn bg-navy"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>Actualizar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }} & {{ trans('message.ccmodal') }}</button>
                      </form>
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
  <!----EDIT COIN MODAL------->
    <div class="modal modal-default fade" id="modal-Editcoin" data-backdrop="static">
        <div class="modal-dialog" >
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>Editar</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="card table-responsive">
                <div class="card-body">
                  <div class="row">
                    <div class="col-xs-12">
                      <form class="form-horizontal" id="Editnewcoin" name="Editnewcoin">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <label for="mensualidad_edit" class="col-md-4 control-label">Mensualidad:</label>
                          <div class="col-md-8">
                            <input class="form-control required" type="text" name="mensualidad_edit" id="mensualidad_edit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="moneda_edit" class="col-xs-4 control-label">Elija la moneda:</label>
                          <div class="col-xs-8">
                            <select id="moneda_edit" name="moneda_edit" class="form-control select2 required" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($currency as $data_currency)
                                <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-xs-4 text-right">
                            <label for="formatcoption" class="control-label text-right">Tipo de cambio:</label>
                          </div>
                          <div class="col-xs-8">
                            <div id="cont_tp_edit" class="input-group">
                              <span class="input-group-btn">
                                <select datas="tp_forma" class="form-control required" id="formatcoption_edit" name="formatcoption_edit">
                                  <option value="" selected>{{ trans('pay.select_op') }}</option>
                                  <option value="1"> Fijo</option>
                                  <option value="2"> Al dia</option>
                                </select>
                              </span>
                              <span class="input-group-btn">
                                <input datas="tp_valor" type="text" class="form-control" id="formatcvalue_edit" name="formatcvalue_edit" placeholder="TC" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly/>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="iva_add" class="col-xs-4 control-label">IVA%:</label>
                          <div class="col-xs-8">
                            <select id="iva_edit" name="iva_edit" class="form-control select2 required" style="width:100%;">
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
                        </div>

                        <div class="form-group">
                          <label for="mensconiva_edit" class="col-md-4 control-label">Mensualidad c/iva:</label>
                          <div class="col-md-8">
                            <input class="form-control" type="text" name="mensconiva_edit" id="mensconiva_edit" readonly>
                          </div> 
                        </div>
                        <div class="form-group">
                          <label for="descuento_edit" class="col-md-4 control-label">Descuento %:</label>
                          <div class="col-md-8">
                            <input class="form-control" value="0" type="text" name="descuento_edit" id="descuento_edit">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="monto_descuento_edit" class="col-md-4 control-label">Monto descuento :</label>
                          <div class="col-md-8">
                            <input class="form-control" type="text" name="monto_descuento_edit" id="monto_descuento_edit">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="monto_sin_descuento_edit" class="col-md-4 control-label">Monto sin descuento :</label>
                          <div class="col-md-8">
                            <input class="form-control" type="text" name="monto_sin_descuento_edit" id="monto_sin_descuento_edit">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-12 text-right">
                            <br><p><strong>Nota:</strong> Solo se puede dar de alta una moneda de cada tipo.</p>
                          </div>
                        </div>
                        
                        <button type="submit" class="btn bg-navy"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>Actualizar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }} & {{ trans('message.ccmodal') }}</button>
                      </form>
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
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View edit contract') )
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('/plugins/momentupdate/moment-with-locales.js')}}"></script>
    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.steps.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>


    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
      <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master-two/steps.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>


    <script src="{{ asset('js/admin/contract/contract_master_edit.js?v1.0')}}"></script>
    <script src="{{ asset('js/admin/contract/contract_anexo_edit.js?v1.0')}}"></script>

    <link href="{{ asset('bower_components/switchery-master/dist/switchery.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/switchery-master/dist/switchery.js')}}" charset="utf-8"></script>
    <style media="screen">
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
    <script type="text/javascript">
    /*switch contemplar vtc*/

    function setSwitchery(switchElement, checkedBool) {
        if((checkedBool && !switchElement.isChecked()) || (!checkedBool && switchElement.isChecked())) {
            switchElement.setPosition(true);
            switchElement.handleOnchange(true);
        }
    }

    var defaults = {
    color : '#15d640',
    secondaryColor : '#fa3232',
    jackColor : '#fff',
    jackSecondaryColor: null,
    className : 'switchery',
    disabledOpacity : 0.5,
    speed : '0.1s',
    size : 'default',
    }

    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    var switchery=[];
    var i=0;
    elems.forEach(function(html) {
    switchery[i] = new Switchery(html, defaults);
    i++;
    });

    var cont_vtc = 0;
    var cont_venue = 0;
    var  comp_ingreso = 0;

      $('#cont_vtc').on('change',function(){
        if($('#cont_vtc').prop('checked')==true){
          cont_vtc = 1;
          //console.log(cont_vtc);
        }else {
          cont_vtc = 0;
          //console.log(cont_vtc);
        }
      });
      $('#cont_venue').on('change',function(){
        if($('#cont_venue').prop('checked')==true){
          cont_venue = 1;
        }
        else{
          cont_venue = 0;
        }
      });
      $('#comp_ingreso').on('change',function(){
        if($('#comp_ingreso').prop('checked')==true){
          comp_ingreso = 1;
        }else{
          comp_ingreso = 0;
        }
      });

    $(function() {
      $('#select_one').val('').trigger('change');

      $('.btngeneral').on('click', function(e){

        var id= $('select[name="select_one"]').val();
        var _token = $('input[name="_token"]').val();
        if (id == ''){
          $('.contrato_a').hide(); //muestro mediante clase
          $('.contrato_b').hide(); //muestro mediante clase
        }
        if (id == '1'){
          $('.contrato_a').show(); //muestro mediante clase
          $('.contrato_b').hide(); //muestro mediante clase

        }
        if (id == '2'){
          $('.contrato_a').hide(); //muestro mediante clase
          $('.contrato_b').show(); //muestro mediante clase
        }

        $('input[name="key_maestro_service"]').val('');
        $('input[name="key_maestro_verticals"]').val('');
        $('input[name="key_maestro_cadena"]').val('');
        $('input[name="key_maestro_contrato"]').val('');
        $('input[name="key_maestro_sitio"]').val('');


        $("#validation_anexo")[0].reset();


        $('input[name="key_anexo_service"]').val('');
        $('input[name="key_anexo_verticals"]').val('');
        $('input[name="key_anexo_cadena"]').val('');
        $('input[name="key_anexo_contrato"]').val('');
        $('input[name="key_anexo_sitio"]').val('');
      });

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
    </script>
  @else
  @endif
@endpush
