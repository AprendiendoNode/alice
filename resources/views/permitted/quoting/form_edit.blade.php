<form id="validation_master" name="validation_master" class="form-horizontal validation-wizard-master wizard-circle m-t-40">
    {{ csrf_field() }}
    <!-- Step 1 -->
    <input type="hidden" name="key_doc" id="key_doc" value="{{$data_header[0]->doc_type}}">
    <input type="hidden" name="objetivos_cotizador" id="objetivos_cotizador" value="{{$data_header[0]->objetivos_cotizador}}">
    <h5>Paso 1 - Información del proyecto </h5>
    <section>
      <div class="row">
        <h5 class="col-12 text-dark">* Datos del  sitio</h5>
        <br>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="form-group">
            <label for="doc_type" class="">Tipo Documento</label>
              <select class="form-control form-control-sm" name="doc_type" id="doc_type">
                <option value="1">Documento P</option>
                <option value="3">Documento C</option>
                {{-- <option value="3">Cotización</option> --}}
              </select>
          </div>
          <div class="form-group fields_docp">
            <label for="proyecto" class="">Nombre de oportunidad (Proyecto)</label>
            <input type="text" class="form-control" id="proyecto" name="proyecto" value="{{$data_header[0]->nombre_proyecto}}" placeholder="">
          </div>
          <div class="form-group fields_docm">
            <label for="grupo_id" class="">Grupo</label>
              <select type="text" class="form-control form-control-sm select2" id="grupo_id" name="grupo_id" placeholder="">
                <option value="0">Elegir</option>
                @foreach ($grupos as $grupo_data)
                  @if($grupo_data->id == $data_header[0]->grupo_id)
                    <option selected value="{{$grupo_data->id}}">{{$grupo_data->name}}</option>
                  @else
                    <option value="{{$grupo_data->id}}">{{$grupo_data->name}}</option>
                  @endif
                @endforeach
              </select>
          </div>

          <div class="form-group fields_docp">
            <label for="sites" class="">Num. sitios</label>
            <input type="number" class="form-control form-control-sm" id="sites" name="sites" placeholder="">
          </div>
        </div>
        <!-------------------------------------------------------------------->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="form-group">
            <label for="vertical" class="">Vertical</label>
              <select class="form-control form-control-sm" id="vertical" name="vertical">
                <option value="0">Elegir...</option>
                @foreach ($verticals as $vertical_data)
                  @if($vertical_data->id == $data_header[0]->vertical_id)
                    <option selected value="{{$vertical_data->id}}">{{$vertical_data->name}}</option>
                  @else
                    <option value="{{$vertical_data->id}}">{{$vertical_data->name}}</option>
                  @endif
                @endforeach
              </select>
          </div>
          <div id="" class="form-group fields_docp">
            <label for="grupo" class="">Nombre de la cuenta (Cadena)</label>
              <input type="text" class="form-control" id="grupo" name="grupo" value="{{$data_header[0]->nombre_grupo}}" placeholder="">
          </div>
          <div id="" class="form-group fields_docm">
            <label for="grupo" class="">Anexo</label>
              <select type="text" class="form-control form-control-sm select2" id="anexo_id" name="anexo_id">
                <option value=""></option>
              </select>
          </div>
          <div class="form-group fields_docp">
            <label for="oportunity" class="">Num. oportunidad</label>
              <input type="text" class="form-control" id="oportunity" name="oportunity" value="{{$data_header[0]->num_oportunidad}}" placeholder="">
          </div>
        </div>
        <!-------------------------------------------------------------------->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="form-group fields_docp">
            <label for="fecha" class="">Densidad</label>
              <input type="number" class="form-control" id="densidad" name="densidad" value="{{$data_header[0]->densidad}}">
          </div>
          <div class="form-group">
            <label for="fecha" class="">IT Concierge</label>
              <select class="form-control form-control-sm select2" name="itc" id="itc">
                <option value="">Elegir...</option>
                @foreach ($itc as $itc_data)
                  @if($itc_data->id == $data_header[0]->itc_id)
                    <option selected value="{{$itc_data->id}}">{{$itc_data->nombre}}</option>
                  @else
                    <option value="{{$itc_data->id}}">{{$itc_data->nombre}}</option>
                  @endif
                @endforeach
                @if($data_header[0]->itc_id == "310")
                  <option selected value="310">Roberto Carlos Gomez Martinez</option>
                @endif
              </select>
          </div>
          <div class="form-group">
            <label for="fecha" class="">Propietario de la oportunidad (Vendedor)</label>
              <select class="form-control form-control-sm" name="comercial" id="comercial">
                <option value="">Elegir...</option>
                @foreach ($comerciales as $comercial_data)
                  @if($comercial_data->id == $data_header[0]->comercial_id)
                    <option selected value="{{$comercial_data->id}}">{{$comercial_data->nombre}}</option>
                  @else
                    <option value="{{$comercial_data->id}}">{{$comercial_data->nombre}}</option>
                  @endif
                @endforeach
              </select>
          </div>
        </div>
        <!-------------------------------------------------------------------->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="form-group">
            <label for="type_service" class="">Tipo de servicio</label>
              <select class="form-control form-control-sm" id="type_service" name="type_service">
                <option value="">Elegir...</option>
                @foreach ($type_service as $type_service_data)
                  @if($type_service_data->id == $data_header[0]->tipo_servicio_id)
                    <option selected value="{{$type_service_data->id}}">{{$type_service_data->name}}</option>
                  @elseif($type_service_data->id != 4)
                    <option value="{{$type_service_data->id}}">{{$type_service_data->name}}</option>
                  @endif
                @endforeach
              </select>
          </div>
          <div class="form-group">
            <label for="fecha" class="">Lugar de la instalación</label>
              <select class="form-control form-control-sm" id="lugar_instalacion" name="lugar_instalacion">
                <option value="">Elegir</option>
                @foreach ($installation as $installation_data)
                  @if($installation_data->id == $data_header[0]->lugar_instalacion_id)
                    <option selected value="{{$installation_data->id}}">{{$installation_data->name}}</option>
                  @else
                    <option value="{{$installation_data->id}}">{{$installation_data->name}}</option>
                  @endif
                @endforeach
              </select>
          </div>
          <div class="form-group">
            <label for="fecha" class="">Tipo de cambio</label>
                <input type="number" class="form-control" onblur="exchange_rate()" id="tipo_cambio" name="tipo_cambio" value="{{$tipo_cambio}}">
          </div>
        </div>
      </div><!---row -->

      <div class="row">
        <h5 class="col-12 text-dark">* Datos financieros</h5>
        <br>
        <div class="col-md-3">
          <div class="form-group">
            <label for="doc_type" class="control-label">Vigencia (Plazo)</label>
            <input type="text" class="form-control form-control-sm" id="plazo" name="plazo" value="{{ $data_header[0]->plazo }}">
          </div>
          <div class="form-group">
            <label for="instalaciones" class="control-label">Instalaciones (%)</label>
            <input type="text" class="form-control form-control-sm" id="instalaciones" name="instalaciones" value="{{ $data_header[0]->instalaciones }}" max="100" min="0">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="doc_type" class="control-label">Servicio Mensual USD</label>
            <input type="text" class="form-control form-control-sm" id="servicio" name="servicio" value="{{ $data_header[0]->servicio_mensual }}">
          </div>
          <div class="form-group fields_docp">
            <label for="proyecto" class="control-label">Depósito en garantía</label>
            <input type="number" class="form-control form-control-sm" id="deposito" name="deposito" value="{{ $data_header[0]->deposito_garantia }}">
          </div>

        </div>
        <div class="col-md-2">

          <div class="form-group fields_docp">
            <label for="proyecto" class="control-label">Renta anticipada</label>
            <input type="number" class="form-control form-control-sm" id="renta" name="renta" value="{{ $data_header[0]->renta_anticipada }}">
          </div>
          <div class="form-group">
            <label for="utilidad" class="control-label">Utilidad venta EA (%)</label>
            <input type="number" class="form-control form-control-sm" id="utilidad" name="utilidad" value="{{ $data_header[0]->utilidad_venta_ea }}" max="100" min="0">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="type_service" class="control-label">Enlace (USD)</label>
            <input type="number" class="form-control form-control-sm" id="enlace" name="enlace" value="{{ $data_header[0]->enlace }}">
          </div>
          <div class="form-group fields_docp">
            <label for="indirectos" class="control-label">Indirectos (%)</label>
            <input type="number" class="form-control form-control-sm" id="indirectos" name="indirectos" value="{{ $data_header[0]->indirectos }}" max="100" min="0">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="capex" class="control-label">CAPEX</label>
            <input type="number" class="form-control form-control-sm" id="capex" name="capex" value="{{ $data_header[0]->capex }}">
          </div>
        </div>
      </div>
      <!---row--->
      <div class="row mt-3">
        <div class="col-md-3">
          <button disabled="true" id="servicioMensualButton" type="button" onclick="calcularServicioMensual();" class="btn btn-danger"> Calcular servicio mensual</button>
        </div>
      </div>
      <!---row--->
      <br>
      <div class="row">
        <h4 class="col-12 text-danger">Métricas</h4>

        <div class="col-12 col-md-6">
          <table id="tabla_rubros" class="table table-striped table-condensed">
            <thead class="bg-dark text-white">
              <tr>
                <th>INVERSIÓN</th>
                <th>USD</th>
                <th>%</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <td>Equipo Activo</td>
                  <td>$ <span id="rubro_ea">0.0</span> </td>
                  <td><span id="rubro_ea_percent">0</span>%</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Equipo No Activo</td>
                  <td>$ <span id="rubro_ena">0.0</span></td>
                  <td><span id="rubro_ena_percent">0</span>%</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Mano de obra</td>
                  <td>$ <span id="rubro_mo">0.0</span> </td>
                  <td><span id="rubro_mo_percent">0</span>%</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Viaticos</td>
                  <td>$ <span id="rubro_viaticos">0.0</span> </td>
                  <td><span id="rubro_viaticos_percent">0</span>%</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Comisión</td>
                  <td>$ <span id="rubro_comision">0.0</span> </td>
                  <td><span id="rubro_comision_percent">0</span>%</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Indirectos</td>
                  <td>$ <span id="rubro_indirectos">0.0</span> </td>
                  <td><span id="rubro_indirectos_percent">0</span>%</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Total</td>
                  <td>$ <span id="total_rubros">0.0</span> </td>
                  <td></td>
                  <td></td>
                </tr>
            </tbody>
          </table>
        </div>
        <div class="col-12 col-md-6">
          <table id="tabla_gastos_mensuales" class="table table-striped table-condensed">
            <thead class="bg-dark text-white">
              <tr>
                <th>GASTOS MENSUALES</th>
                <th class="text-center">USD</th>
                <th class="text-center">%</th>
              </tr>
              <tbody>
                <tr>
                  <td>Crédito Mensual</td>
                  <td>$ <span id="credito_mensual">0.0</span> </td>
                  <td>
                    <input id="credito_mensual_percent" style="width:60px; padding:0.2rem;" class="form-control form-control-sm" type="number" name="credito_mensual_percent" value="{{ $cotizador_gastos_mensuales->credito_mensual_percent }}" min="0" max="100">
                  </td>
                </tr>
                <tr>
                  <td>Manto/Seguros/Otros</td>
                  <td>$ <span id="gasto_mtto">0.0</span> </td>
                  <td>
                    <input id="gasto_mtto_percent" style="width:60px; padding:0.2rem;" class="form-control form-control-sm" type="number" name="gasto_mtto_percent" value="{{ $cotizador_gastos_mensuales->mantto_seg_otro_percent }}" min="0.0" max="100">
                  </td>
                </tr>
                <tr>
                  <td>Enlace USD</td>
                  <td>$ <span id="gasto_enlace">0.0</span> </td>
                  <td></td>
                </tr>
                <tr>
                  <td>Gasto mensual</td>
                  <td>$ <span id="total_gastos">0.0</span> </td>
                  <td></td>
                </tr>
              </tbody>
            </thead>
          </table>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-12 col-md-6">
          <table id="tabla_modelo_negocio" class="table table-striped table-condensed">
            <thead class="bg-dark text-white">
              <tr>
                <th colspan="2">MODELO DE NEGOCIO</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Servicio Mensual</td>
                <td>$ <span id="modelo_serv_mens">0.0</span> </td>
              </tr>
              <tr>
                <td>Enlace</td>
                <td>$ <span id="modelo_enlace">0.0</span> </td>
              </tr>
              <tr>
                <td>Mensual por habitación</td>
                <td>$ <span id="modelo_mensual_hab">0.0</span> </td>
              </tr>
              <tr>
                <td>Por habitación + Enlace</td>
                <td>$ <span id="modelo_hab_enlace">0.0</span> </td>
              </tr>
              <tr>
                <td>Antenas</td>
                <td> <span id="modelo_antenas">0</span> </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-12 col-md-6">
          <table id="tabla_opcionalmente" class="table table-striped table-condensed">
            <thead class="bg-dark text-white">
              <tr>
                <th>OPCIONALMENTE</th>
                <th>USD</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Costo de Póliza</td>
                <td><input id="opcional_poliza" style="width:90px" class="form-control form-control-sm" type="number" name="opcional_poliza" value="0"></td>
              </tr>
              <tr>
                <td>Utilidad de la póliza</td>
                <td><input id="utilidad_poliza" style="width:90px" class="form-control form-control-sm" type="number" name="utilidad_poliza" value="0"></td>
              </tr>
              <tr>
                <td>Comisión de póliza</td>
                <td><input id="comision_poliza" style="width:90px" class="form-control form-control-sm" type="number" name="comision_poliza" value="0"></td>
              </tr>
              <tr>
                <td>Precio de venta de la póliza</td>
                <td><input id="precio_poliza" style="width:90px" class="form-control form-control-sm" type="number" name="precio_poliza" value="0"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-12 col-md-5">
          <table id="tabla_serv_adm" class="table table-striped table-condensed">
            <thead class="bg-dark text-white">
              <tr>
                <th>SERVICIO ADMINISTRADO</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Renta + Enlace</td>
                <td>$ <span id="renta_enlace">0.0</span> </td>
              </tr>
              <tr>
                <td>CAPEX</td>
                <td>$ <span id="serv_capex">0.0</span> </td>
              </tr>
              <tr>
                <td>Renta Anticipada</td>
                <td>$ <span id="serv_renta">0.0</span> </td>
              </tr>
              <tr>
                <td>Plazo</td>
                <td> <span id="serv_plazo">0</span> </td>
              </tr>
              <tr>
                <td>Habitaciones X Antena</td>
                <td> <span id="serv_hab_antenas">0</span> </td>
              </tr>
              <tr>
                <td>Servicio Administrado por habitación</td>
                <td>$ <span id="serv_adm_habitacion">0.0</span> </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-12 col-md-7">
          <table id="tabla_objetivos" class="table table-striped table-condensed">
            <thead class="bg-dark text-white">
              <tr>
                <th colspan="2">OBJETIVOS DEL PROYECTO</th>
                <th>%</th>
                <th></th>
              </tr>
              <tbody>
                <tr>
                  <td>Utilidad Mensual</td>
                  <td>$ <span id="utilidad_mensual">0.0</span> </td>
                  <td> <span id="utilidad_mensual_percent">0</span>%</td>
                  <td></td>
                </tr>
                <tr class="text-primary">
                  <td>Utilidad Proyecto!!</td>
                  <td>$ <span id="utilidad_proyecto">0.0</span> </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr class="text-primary">
                  <td>VTC!!</td>
                  <td>$ <span id="vtc">0.0</span> </td>
                  <td><span id="vtc_percent">0</span>% </td>
                  <td></td>
                </tr>
                <tr>
                  <td>Renta Mensual / Inversión</td>
                  <td></td>
                  <td><span id="renta_mensual_inversion">0</span>%</td>
                  <td id="renta_mensual_inversion_icon"></td>
                </tr>
                <tr>
                  <td>% Utilidad / Inversión</td>
                  <td></td>
                  <td> <span id="utilidad_inversion">0</span>% </td>
                  <td id="utilidad_inversion_icon"></td>
                </tr>
                <tr>
                  <td>% Utilidad / Renta</td>
                  <td></td>
                  <td> <span id="utilidad_renta">0</span>% </td>
                  <td id="utilidad_renta_icon"></td>
                </tr>
                <tr>
                  <td>TIR</td>
                  <td></td>
                  <td><span id="tir">0.0</span>%</td>
                  <td id="tir_icon"></td>
                </tr>
                <tr>
                  <td>Utilidad a 3 años</td>
                  <td>$ <span id="utilidad_3_anios">0.0</span> </td>
                  <td> <span id="utilidad_3_anios_percent">0</span> (MIN)</td>
                  <td id="utilidad_3_anios_percent_icon"></td>
                </tr>
                <tr>
                  <td>Tiempo de retorno</td>
                  <td><span id="tiempo_retorno">0.0</span> </td>
                  <td> </td>
                  <td id="tiempo_retorno_icon"></td>
                </tr>
                <tr>
                  <td>Costo MO por AP</td>
                  <td>$ <span id="costo_mo_ap">0.0</span> </td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Servicio por AP</td>
                  <td>$ <span id="serv_ap">0.0</span> </td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </thead>
          </table>
        </div>
      </div>
      <br>
      <div class="row">

      </div>
    </section>
    <!--     Step 2  ----------------------------->
    <h5>Paso 2 - Agregar materiales</h5>
    <section>
        <div class="row">
            <div class="col-md-4 fields_docp">
              <div class="row mb-2">
                <div class="col-md-8">
                  <h4 class="text-center text-primary">AP'S</h4>
                </div>
                <div class="col-md-2">
                  <button class="btn btn-sm btn-dark p-1 addButtonAP" type="button"><i class="fa fa-plus"></i></button>
                </div>
              </div>
    
              <div class="row mb-2">
                <div class="form-row">
                  <div class="col-6">
                    <select class="form-control form-control-sm aps_modelo" name="aps_modelo[0]">
                      <option value="0">Elija ...</option>
                      @foreach ($product_ap as $product_ap_data)
                        <option data-key="{{$product_ap_data->clave}}" value="{{$product_ap_data->id}}">{{$product_ap_data->equipo}}</option>
                      @endforeach
                      <option data-key="APE" value="1075">Nodos extra (Voz y datos) no para antenas</option>
                    </select>
                  </div>
                  <div class="col-4">
                    <input class="form-control form-control-sm aps_cant" min="0" type="number" value="0" name="aps_cant[0]" placeholder="Cantidad">
                  </div>
                  <div class="col-2"></div>
                </div>
              </div>
              <div class="row clone d-none" id="optionTemplateAP">
                <div class="form-row">
                  <div class="col-6">
                    <select class="form-control form-control-sm aps_modelo" name="aps_modelo">
                      <option value="0"> Elija ...</option>
                      @foreach ($product_ap as $product_ap_data)
                        <option data-key="{{$product_ap_data->clave}}" value="{{$product_ap_data->id}}">{{$product_ap_data->equipo}}</option>
                      @endforeach
                      <option data-key="APE" value="1075">Nodos extra (Voz y datos) no para antenas</option>
                    </select>
                  </div>
                  <div class="col-4">
                    <input class="form-control form-control-sm aps_cant" value="0" min="0" type="number" name="aps_cant" placeholder="Cantidad">
                  </div>
                  <button type="button" class="col-1 btn removeButtonAP"><i class="fa fa-minus text-danger"></i></button>
                </div>
              </div>
            </div><!--row antenas--->
    
            <div class="col-md-4 fields_docp">
              <div class="row mb-2">
                <div class="col-md-8">
                  <h4 class="text-center text-primary">FIREWALL</h4>
                </div>
                <div class="col-md-2">
                  <button class="btn btn-sm btn-dark p-1 addButtonFW" type="button" name="button"> <i class="fa fa-plus"></i></button>
                </div>
              </div>
              <div class="row mb-2">
                <div class="form-row">
                  <div class="col-6">
                    <select class="form-control form-control-sm firewall_modelo" name="firew_mod[0]">
                      <option value="0">Elija ...</option>
                      @foreach ($product_fw as $product_fw_data)
                        <option value="{{$product_fw_data->id}}">{{$product_fw_data->equipo}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-4">
                    <input class="form-control form-control-sm firewall_cant" value="0" min="0" type="number" name="firew_cant[0]" placeholder="Cantidad">
                  </div>
                  <div class="col-2"></div>
                </div>
              </div>
              <div class="row clone d-none" id="optionTemplateFIRE">
                <div class="form-row">
                  <div class="col-6">
                    <select class="form-control form-control-sm firewall_modelo" name="firew_mod">
                      <option value="0">Elija ...</option>
                      @foreach ($product_fw as $product_fw_data)
                        <option value="{{$product_fw_data->id}}">{{$product_fw_data->equipo}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-4">
                    <input class="form-control form-control-sm firewall_cant" value="0" value="0" min="0" type="number" name="firew_cant" placeholder="Cantidad">
                  </div>
                  <button type="button" class="col-1 btn removeButtonFW"><i class="fa fa-minus text-danger"></i></button>
                </div>
              </div>
            </div><!--row firewall--->
    
            <div class="col-md-4 fields_docp">
              <div class="row mb-2">
                <div class="col-8">
                  <h4 class="text-center text-primary">SWITCHES</h4>
                </div>
                <div class="col-2">
                  <button class="btn btn-sm btn-dark p-1 addButtonSW" type="button" name="button"> <i class="fa fa-plus"></i></button>
                </div>
              </div>
    
              <div class="row mb-2">
                <div class="form-row">
                  <div class="col-6">
                    <select class="form-control form-control-sm switch_modelo" name="switches_mod[0]">
                      <option value="0">Elija ...</option>
                      @foreach ($product_sw as $product_sw_data)
                        <option value="{{$product_sw_data->id}}">{{$product_sw_data->equipo}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-4">
                    <input class="form-control form-control-sm switch_cant" value="0" min="0" type="number" name="switches_cant[0]" placeholder="Cantidad">
                  </div>
                  <div class="col-1"></div>
                </div>
              </div>
    
              <div class="row clone d-none" id="optionTemplateSW">
                <div class="form-row">
                  <div class="col-6">
                    <select class="form-control form-control-sm switch_modelo" name="switches_mod">
                      <option value="0">Elija ...</option>
                      @foreach ($product_sw as $product_sw_data)
                        <option value="{{$product_sw_data->id}}">{{$product_sw_data->equipo}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-4">
                    <input class="form-control form-control-sm switch_cant" value="0" min="0" type="number" name="switches_cant" placeholder="Cantidad">
                  </div>
                  <button type="button" class="col-1 btn removeButtonSW"><i class="fa fa-minus text-danger"></i></button>
                  </div>
                </div>
              </div><!--row switches--->
          </div><!---row-->
      <br>
      <div class="row">
      
          <div class="col-md-4 fields_docp">
            <div class="row mb-2">
              <div class="col-8">
                <h4 class="text-center text-success">Gabinetes</h4>
              </div>
              <div class="col-2">
                <button class="btn btn-sm btn-dark p-1 addButtonGabinetes" type="button" name="button"> <i class="fa fa-plus"></i></button>
              </div>
            </div>
  
            <div class="row mb-2">
              <div class="form-row">
                <div class="col-6">
                  <select class="form-control form-control-sm gabinetes_select" name="gabinetes_select[0]">
                    <option value="0">Elija ...</option>
                    @foreach ($products_gabinetes as $gabinetes)
                      <option value="{{$gabinetes->id}}">{{$gabinetes->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4">
                  <input class="form-control form-control-sm gabinetes_cant" value="0" min="0" type="number" name="gabinetes_cant[0]" placeholder="Cantidad">
                </div>
                <div class="col-1"></div>
              </div>
            </div>
            <div class="row clone d-none" id="optionTemplateGabinetes">
              <div class="form-row">
                <div class="col-6">
                  <select class="form-control form-control-sm gabinetes_select" name="gabinetes_select">
                    <option value="0">Elija ...</option>
                    @foreach ($products_gabinetes as $gabinetes)
                      <option value="{{$gabinetes->id}}">{{$gabinetes->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4">
                  <input class="form-control form-control-sm gabinetes_cant" value="0" min="0" type="number" name="gabinetes_cant" placeholder="Cantidad">
                </div>
                <button type="button" class="col-1 btn removeButtonGabinetes"><i class="fa fa-minus text-danger"></i></button>
                </div>
              </div>
            </div><!--row gabinetes--->

          <div class="col-md-2 fields_docp">
            <div class="row mb-2">
              <div class="col-12">
                <h4 class="text-center text-success">Material</h4>
              </div>
            </div>
            <div class="row mb-2 d-flex justify-content-center">
              <div class="form-row">
                <div class="col-12">
                  <select class="form-control form-control-sm material_select" name="material_select[0]">
                    @foreach ($materiales as $material)
                      <option value="{{$material->id}}">{{$material->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>  
          </div><!--material--->
          <div class="col-md-2 fields_docp">
            <div class="row mb-2">
              <div class="col-12">
                <h4 class="text-center text-success">Medidas</h4>
              </div>
            </div>
            <div class="row mb-2 d-flex justify-content-center">
              <div class="form-row">
                <div class="col-12">
                  <select class="form-control form-control-sm medida_select" name="medida_select[0]">
                    @foreach ($medidas as $medida)
                      <option value="{{$medida->id}}">{{$medida->unit}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>  
          </div><!--Medidas--->
          <div class="col-md-4 fields_docp">
              <button type="button" id="add_shopping_cart" class="btn btn-sm btn-success m-2"> <i class="fas fa-cart-plus"></i> Agregar </button>
              @if($data_header[0]->status_id != 3 &&
              $data_header[0]->status_id != 5 &&
              $data_header[0]->cotizador_status_id != 6)
            <button type="button" id="delete_cart" class="btn btn-sm btn-danger m-2"> <i class="fas fa-trash-alt"></i> Vaciar carrito</button>
          @endif
          </div><!----->
      </div>
      <div class="row fields_docp">
          <h4 class="text-danger">Equipo activo</h4>
        </div>
        <div class="row fields_docp">
          <div class="col-md-4">
            <div class="form-group">
                <a href="#" class="btn btn-dark ml-20" id="get_equipo_button" name=""><i class="fas fa-hdd mr-2"></i> Equipo activo sugerido</a>
            </div>
          </div>
        </div>
        <div  class="row fields_docp">
          <section class="col-12" id="products-grid" class="products-grid">
  
          </section>
        </div>
        <br>
        <div class="row fields_docp">
          <h4 class="text-danger">Materiales</h4>
        </div>
        <div class="row fields_docp">
          <div class="col-md-4">
            <div class="form-group">
                <a href="#" class="btn btn-dark ml-20" id="get_materiales_button" name=""><i class="fas fa-tools mr-2"></i> Materiales sugeridos</a>
            </div>
          </div>
        </div>
        <div  class="row fields_docp">
          <section class="col-12" id="products-grid-materiales" class="products-grid-materiales">
          </section>
        </div>
        <br>
  
        <br>
        <div class="row fields_docp">
          <h4 class="text-danger">Mano de obra</h4>
        </div>
         <div class="row fields_docp">
          <div class="col-md-4">
            <div class="form-group">
                <a href="#" class="btn btn-danger" id="get_mo_button" name=""><i class="fas fa-people-carry mr-2"></i> Agregar Mano de obra</a>
            </div>
          </div>
        </div>
        <br>
        <div  class="row fields_docp">
          <section id="products-grid-mo" class="products-grid-mo">
          </section>
        </div>
        <br>
        <!--------VIATICOS---------->
        <div id="div_button_viatic" class="">
          <div class="row fields_docp">
            <h4 class="text-danger">Viaticos</h4>
          </div>
          <div class="row fields_docp">
            <div class="col-md-4">
              <div class="form-group">
                  <button type="button" class="btn btn-success ml-20" id="get_viatics_button" name=""><i class="fas fa-utensils mr-2"></i></i><i class="fas fa-suitcase-rolling mr-1"></i> Agregar Viaticos</button>
              </div>
            </div>
          </div>
        </div>
      <br>
      <div class="row">
        <h4 class="text-danger col-12">Agregar material extra</h4>
      </div>
        <br>
        <div class="row">
          <div class="col-3 p-3">
            <div class="form-group">
              <h4 class="col text-dark"><b>Filtrar por:</b></h4>
              <label for="">Categoría:</label>
              <select class="col form-control form-control-sm" id="categoria" name="categoria">
                <option value="0">Elegir...</option>
                @foreach ($categories as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="">Descripción:</label>
              <input id="description" class="col form-control form-control-sm" placeholder=" Mínimo 4 letras"/>
            </div>
            <div id="div_tuberia" class="d-none">
              <div class="form-group">
                <label for="">Material:</label><br>
                <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-dark">
                    <input type="radio" name="optionsMaterial" id="option1" value="1"> Galvanizado
                  </label>
                  <label class="btn btn-dark">
                    <input type="radio" name="optionsMaterial" id="option2" value="2"> PVC
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label for="">Tipo:</label>
                <select class="col form-control form-control-sm" id="tipo_material" name="tipo_material">
                  <option value="0">Elegir...</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Medida:</label>
                <div class="btn-group btn-group-sm btn-group-toggle d-flex justify-content-center" data-toggle="buttons">
                  <label class="btn btn-danger active">
                    <input type="radio" name="optionsMedida" id="option1" value="1" checked> 1"
                  </label>
                  <label class="btn btn-danger">
                    <input type="radio" name="optionsMedida" id="option2" value="2"> 1/2"
                  </label>
                  <label class="btn btn-danger">
                    <input type="radio" name="optionsMedida" id="option3" value="3"> 3/4"
                  </label>
                  <label class="btn btn-danger">
                    <input type="radio" name="optionsMedida" id="option3" value="4"> 2"
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <button id="get_categorias_button" type="button" class="col btn btn-dark mt-3"><i class="fas fa-search"></i> Buscar</button>
            </div>
          </div>

          <div class="col-9">
            <section id="products-grid-categorias" class="products-grid-categorias">
            </section>
          </div>
        </div>
    </section>
    <!-- Step 3 -------------------------------------------------------------->
    <h5>Paso 3 - Resumen de cotización</h5>
    <section>
      <div class="row">
        <div class="col-md-12">
          <h4 class="text-danger">* Resumen de su cotización</h4>
              <div class="table-responsive">
                <table id="tabla_productos" class="table table-condensed">
                  <thead class="bg-dark">
                    <tr style="color:white;">
                      <th  class="text-center"style="width:20px !important;">Cant. Sug.</th>
                      <th class="text-center">Cant. Req.</th>
                      <th width="250px">Descripción</th>
                      <th>Tipo</th>
                      <th width="100px">Código</th>
                      <th>Proveedor</th>
                      <th>Num. de parte</th>
                      <th>% Descuento</th>
                      <th>Precio Unitario</th>
                      <th>Moneda</th>
                      <th>Total</th>
                      <th>Total (USD)</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot class="text-right" style="font-size:18px;border-color:transparent">
                    <tr>
                      <td colspan="2"></td> <td style="font-weight:bold;border-color:transparent" colspan="3">Total Equipo Activo:</td>
                      <td  style="font-weight:bold;" colspan="3">$ <span id="total_eqactivo_footer">0.00</span> USD</td>
                    </tr>
                    <tr>
                      <td colspan="2"></td> <td style="font-weight:bold;" colspan="3">Total Materiales:</td>
                      <td  style="font-weight:bold;" colspan="3">$ <span id="total_materiales_footer">0.00</span> USD</td>
                    </tr>
                    <tr>
                      <td colspan="2"></td> <td style="font-weight:bold;" colspan="3">Total Mano de Obra:</td>
                      <td  style="font-weight:bold;" colspan="3">$ <span id="total_sitwifi_footer">0.00</span> USD</td>
                    </tr>
                    <tr>
                      <td colspan="2"></td> <td style="font-weight:bold;" colspan="3">Total Viaticos:</td>
                      <td  style="font-weight:bold;" colspan="3">$ <span id="total_viaticos_footer">0.00</span> USD</td>
                    </tr>
                    <tr>
                      <td colspan="2"></td> <td style="font-weight:bold;" colspan="3">Total:</td>
                      <td  class="text-danger" style="font-weight:bold;" colspan="3">$<span id="total_global">0.00</span> USD</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
          </div>
        </div>
    </section>
</form>
