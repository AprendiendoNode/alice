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
                          <label for="monto_con_descuento_add" class="col-md-4 control-label">Monto sin descuento :</label>
                          <div class="col-md-8">
                            <input class="form-control" type="text" name="monto_con_descuento_add" id="monto_con_descuento_add">
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
                        <input name="contract_payment_id" id="contract_payment_id" type="hidden" value="">
                        <div class="form-group">
                          <label for="mensualidad_edit" class="col-md-4 control-label">Mensualidad:</label>
                          <div class="col-md-8">
                            <input class="form-control required" type="text" name="mensualidad_edit" id="mensualidad_edit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="moneda_edit" class="col-xs-4 control-label">Elija la moneda:</label>
                          <div class="col-xs-8">
                            <select disabled id="moneda_edit" name="moneda_edit" class="form-control select2 required" style="width:100%;">
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
                            <label for="formatcoption_edit" class="control-label text-right">Tipo de cambio:</label>
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
                          <label for="iva_edit" class="col-xs-4 control-label">IVA%:</label>
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
                            <input readonly class="form-control" type="text" name="monto_descuento_edit" id="monto_descuento_edit">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="monto_con_descuento_edit" class="col-md-4 control-label">Monto con descuento :</label>
                          <div class="col-md-8">
                            <input readonly class="form-control" type="text" name="monto_con_descuento_edit" id="monto_con_descuento_edit">
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
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
      <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master-two/steps.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>


    <script src="{{ asset('js/admin/contract/contract_master_edit.js?v=2.0')}}"></script>
    <script src="{{ asset('js/admin/contract/contract_anexo_edit.js?v=2.0')}}"></script>
    <script src="{{ asset('js/admin/contract/c_table_porcentaje.js?v1.0')}}"></script>
    <link href="{{ asset('bower_components/switchery-master/dist/switchery.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/switchery-master/dist/switchery.js')}}" charset="utf-8"></script>
    <style media="screen">
    .toggle.btn {
      min-width: 5rem !important;
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
    <script type="text/javascript">
    var item_relation_contact_row = "{{ $item_contact_row }}";
    var item_relation_cierre_row = "{{ $item_cierre_row }}";
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


      $("#select_kick_off").select2();
            function addItemCont() {
              //console.log(item_relation_contact_row);
              let politica = $("select[name='sel_type_comision']").val();
              if (politica != '') {
                var html = '';
                html += '<tr id="item_row_' + item_relation_contact_row + '" >';

                html += '<td class="text-center" style="vertical-align: middle;">';
                html += '<button type="button" onclick="$(\'#item_row_' + item_relation_contact_row + '\').remove(); " class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
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
                html += '<input type="text" class="form-control input-sm text-right col-porcentaje" name="item[' + item_relation_contact_row + '][porcentaje]" id="item_porcentaje_' + item_relation_contact_row + '" required step="any" maxlength="10" max="'+$('#politica_contacto').val()+'" />';
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
              console.log(item_relation_cierre_row);
              let politica = $("select[name='sel_type_comision']").val();
              if (politica != '') {
                var html = '';
                html += '<tr id="item_cierre_row_' + item_relation_cierre_row + '">';

                html += '<td class="text-center" style="vertical-align: middle;">';
                html += '<button type="button" onclick="$(\'#item_cierre_row_' + item_relation_cierre_row + '\').remove(); " class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">';
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
                html += '<input type="text" class="form-control input-sm text-right col-cierre-porcentaje" name="item_cierre[' + item_relation_cierre_row + '][porcentaje]" id="item_cierre_porcentaje_' + item_relation_cierre_row + '" required step="any" maxlength="10" max="'+$('#politica_cierre').val()+'"/>';
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
      var maxval=0;
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
              //maxval=datax[0].contacto;
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

      //Carga los datos si existe alguna comision
      function getCommission(id_contract){
        //console.log(id_contract);
      //Obtener comision
      $.ajax({
      type:"POST",
      url:"get_commission_anexo",
      data: { id_contract : id_contract , _token : _token},
      success:function(data){
        $('#kick_off_exit').bootstrapToggle('off');
        //console.log(data[0]['kickoff_id']);
        if(Array.isArray(data) && data.length)
        {

          if(data[0]['kickoff_id'])
          {
            $('#kick_off_exit').prop('checked',true).trigger('change');
            $('#kick_off_exit').val(1);
            $("#select_kick_off").val(data[0]['kickoff_id']).trigger('change');

          }else{
            $('#kick_off_exit').prop('checked',false).trigger('change');
            $('#kick_off_exit').val(0);

            item_relation_contact_row = 0;
            item_relation_cierre_row = 0;

            var comision_select = document.getElementById("sel_type_comision");
            var option_comision_select;

            var insidesales_select = document.getElementById("sel_inside_sales");
            var option_insidesales_select;

            var itconcierge_comision_select = document.getElementById("sel_itconcierge_comision");
            var option_itconcierge_comision_select;

            // Setting commission
            for (var i=0; i < comision_select.options.length; i++) {
                option_comision_select = comision_select.options[i];
                if (option_comision_select.value == data[0]['politica_id']) {
                    option_comision_select.setAttribute('selected', true);
                    data_comision(option_comision_select.value);
                }else{
                    option_comision_select.removeAttribute('selected');
                }
            }

            // Setting inside sales
            for (var i=0; i < insidesales_select.options.length; i++) {
                option_insidesales_select = insidesales_select.options[i];
                if (option_insidesales_select.value == data[0]['inside_sales']) {
                    option_insidesales_select.setAttribute('selected', true);
                }else{
                    option_insidesales_select.removeAttribute('selected');
                }
            }

            // Setting itconcierge
            for (var i=0; i < itconcierge_comision_select.options.length; i++) {
                option_itconcierge_comision_select = itconcierge_comision_select.options[i];
                if (option_itconcierge_comision_select.value == data[0]['itconcierge']) {
                    option_itconcierge_comision_select.setAttribute('selected', true);
                }else{
                    option_itconcierge_comision_select.removeAttribute('selected');
                }
            }


        //Obtener contacto anexo
        $.ajax({
        type:"POST",
        url:"get_contact_commission_anexo",
        data:{id_contract:id_contract, _token : _token},
        success:function(data){
        //console.log('contacto: '+data[0]['nombre']);
        data.forEach(contacto => {

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
          html += '<select class="form-control input-sm col-contact-int" name="item[' + item_relation_contact_row + '][contactInt]" id="item_contactInt_' + item_relation_contact_row + '" data-row="' + item_relation_contact_row + '" required >'
          html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
          @forelse ($kickoff_colaboradores as $kickoff_colaboradores_data)

          if(contacto.user_id=={{ $kickoff_colaboradores_data->id  }}){
          html+='<option value="{{ $kickoff_colaboradores_data->id }}" selected> {{ $kickoff_colaboradores_data->name }} </option>';
          }else{
          html+='<option value="{{ $kickoff_colaboradores_data->id }}"> {{ $kickoff_colaboradores_data->name }} </option>';
          }
          @empty
          @endforelse
          html += '</select>';
          html += '</div>';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="text" value="'+contacto.nombre+'" class="form-control input-sm text-right col-contact" name="item[' + item_relation_contact_row + '][contact]" id="item_contact_' + item_relation_contact_row + '" step="any"/>';
          html += '</div>';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="text" value="'+contacto.valor_comision+'" class="form-control input-sm text-right col-porcentaje" name="item[' + item_relation_contact_row + '][porcentaje]" id="item_porcentaje_' + item_relation_contact_row + '" required step="any" maxlength="10" max="'+$('#politica_contacto').val()+'" />';
          html += '</div>';
          html += '</td>';

          html += '</tr>';

          $("#validation_anexo #item_contact tbody #add_item_contact").before(html);
          item_relation_contact_row++;

          });


        },
        error:function(data){
        console.log(data);
        }
        });

        //Obtener cierre anexo
        $.ajax({
        type:"POST" ,
        url:"get_cierre_commission_anexo",
        data:{id_contract:id_contract, _token : _token},
        success:function(data){

        data.forEach(cierre=>{
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
          html += '<select class="form-control input-sm col-cierre-contact-int" name="item_cierre[' + item_relation_cierre_row + '][contactInt]" id="item_cierre_contactInt_' + item_relation_cierre_row + '" data-row="' + item_relation_cierre_row + '" required >'
          html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
          @forelse ($kickoff_colaboradores as $kickoff_colaboradores_data)
            if(cierre.user_id=={{ $kickoff_colaboradores_data->id  }}){
            html+='<option value="{{ $kickoff_colaboradores_data->id }}" selected> {{ $kickoff_colaboradores_data->name }} </option>';
            }else{
            html+='<option value="{{ $kickoff_colaboradores_data->id }}"> {{ $kickoff_colaboradores_data->name }} </option>';
            }
          @empty
          @endforelse
          html += '</select>';
          html += '</div>';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="text"  value="'+cierre.nombre+'"  class="form-control input-sm text-right col-cierre-contact" name="item_cierre[' + item_relation_cierre_row + '][contact]" id="item_cierre_contact_' + item_relation_cierre_row + '" step="any" />';
          html += '</div>';
          html += '</td>';

          html += '<td>';
          html += '<div class="form-group form-group-sm">';
          html += '<input type="text"  value="'+cierre.valor_comision+'"  class="form-control input-sm text-right col-cierre-porcentaje" name="item_cierre[' + item_relation_cierre_row + '][porcentaje]" id="item_cierre_porcentaje_' + item_relation_cierre_row + '" required step="any" maxlength="10" max="'+$('#politica_cierre').val()+'" />';
          html += '</div>';
          html += '</td>';

          html += '</tr>';
          $("#validation_anexo #item_cierre tbody #add_item_cierre").before(html);
          item_relation_cierre_row++;


        });

        },
        error:function(data){
        console.log(data);
        }
        });

          }//End else comision


      }//end if data>0
      //else {}
    },
      error:function(data){
        console.log(data);
      }
      });
}
$('#sel_type_comision').on('change', function(e){
  var group = $(this).val();
  data_comision(group);
});


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
          data_comision(datos[0].politica_id);
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
          html += '<select class="form-control input-sm col-contact-int" name="item[' + item_relation_contact_row + '][contactInt]" id="item_contactInt_' + item_relation_contact_row + '" data-row="' + item_relation_contact_row + '" required >'
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
          html += '<input type="text" class="form-control input-sm text-right col-porcentaje" name="item[' + item_relation_contact_row + '][porcentaje]" id="item_porcentaje_' + item_relation_contact_row + '" value="' + key.valor_comision + '" required step="any" maxlength="10" max="'+$('#politica_contacto').val()+'" />';
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
          html += '<select class="form-control input-sm col-cierre-contact-int" name="item_cierre[' + item_relation_cierre_row + '][contactInt]" id="item_cierre_contactInt_' + item_relation_cierre_row + '" data-row="' + item_relation_cierre_row + '" required >'
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
          html += '<input type="text" class="form-control input-sm text-right col-cierre-porcentaje" name="item_cierre[' + item_relation_cierre_row + '][porcentaje]" id="item_cierre_porcentaje_' + item_relation_cierre_row + '" value="' + key.valor_comision + '" required step="any" maxlength="10" max="'+$('#politica_cierre').val()+'"/>';
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
        //reset_comision();
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
