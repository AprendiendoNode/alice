@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View Document P') )
    Documento A
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View Document P') )
    Documento A
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View history quoting') )
      <!-- Validation wizard -->
      <form id="form_edit_cotizador" class="" action="/edit_cart_quoting" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id_docp2" id="id_docp2" value="{{$document[0]->id}}">
      </form>
      <!--MODAL LINEA BASE-->
      <div id="modal_linea_base" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <div class="form-row">
                <select id="select_totales" class="form-control form-control-sm" name="">
                  <option value="1">Linea Base</option>
                  <option value="2">Real invetido (Pagos)</option>
                </select>
              </div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-12 col-md-5">
                  <input id="deposito" type="hidden" name="deposito" value="{{$document[0]->deposito_garantia}}">
                  <input id="plazo" type="hidden"  class="form-control form-control-sm" value="{{$document[0]->plazo}}">
                  <input id="gasto_mtto_percent" type="hidden" name="gasto_mtto_percent" value="{{$gasto_mtto_percent}}">
                  <input id="gasto_mtto" type="hidden" name="gasto_mtto" value="{{$gasto_mtto}}">
                  <input id="credito_mensual_percent" type="hidden" name="credito_mensual_percent" value="{{$credito_mensual_percent}}">
                  <input id="total_ea_base" type="hidden" class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($kickoff_lineabase->total_ea, 2, '.', ',')}}">
                  <input id="total_ena_base" type="hidden" class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($kickoff_lineabase->total_ena, 2, '.', ',')}}">
                  <input id="total_mo_base" type="hidden" class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($kickoff_lineabase->total_mo, 2, '.', ',')}}">
                  <input id="total_usd_base" type="hidden" readonly class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($kickoff_lineabase->total_usd, 2, '.', ',')}}">
                  <!-------------------->
                  <div class="form-row d-flex align-items-center mb-2">
                    <div class="col-6">
                      <label class="text-dark font-weight-bold" for="">Equipo Activo</label>
                    </div>
                    <div class="col-6">
                      <input id="total_ea_objetivo" name="" readonly type="text" class="form-control form-control-sm text-right font-weight-bold" value="0.00">
                    </div>
                  </div>
                  <div class="form-row d-flex align-items-center mb-2">
                    <div class="col-6">
                      <label class="text-dark font-weight-bold" for="">Equipo No Activo</label>
                    </div>
                    <div class="col-6">
                      <input id="total_ena_objetivo" name="" readonly type="text" class="form-control form-control-sm text-right font-weight-bold" value="0.00">
                    </div>
                  </div>
                  <div class="form-row d-flex align-items-center mb-2">
                    <div class="col-6">
                      <label class="text-dark font-weight-bold" for="">Mano de obra</label>
                    </div>
                    <div class="col-6">
                      <input id="total_mo_objetivo" type="text" readonly class="form-control form-control-sm text-right font-weight-bold" value="0.00">
                    </div>
                  </div>
                  <div class="form-row d-flex align-items-center mb-2">
                    <div class="col-6">
                      <label class="text-dark font-weight-bold" for="">Total</label>
                    </div>
                    <div class="col-6">
                      <input id="total_usd_objetivo" type="text" readonly class="form-control form-control-sm text-right font-weight-bold" value="0.00">
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-7">
                  <table id="tabla_objetivos" class="table table-striped table-condensed">
                    <thead class="bg-dark text-white">
                      <tr>
                        <th colspan="2">OBJETIVOS DEL PROYECTO (USD)</th>
                        <th>%</th>
                        <th></th>
                      </tr>
                      <tbody>
                        <tr>
                          <td>Utilidad Mensual</td>
                          <td><span id="utilidad_mensual">0.0</span> </td>
                          <td> <span id="utilidad_mensual_percent">0</span>%</td>
                          <td></td>
                        </tr>
                        <tr class="text-primary">
                          <td>Utilidad Proyecto!!</td>
                          <td><span id="utilidad_proyecto">0.0</span> </td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr class="text-primary">
                          <td>VTC!!</td>
                          <td><span id="vtc">0.0</span> </td>
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
                          <td><span id="utilidad_3_anios">0.0</span> </td>
                          <td><span id="utilidad_3_anios_percent">0</span> (MIN)</td>
                          <td id="utilidad_3_anios_percent_icon"></td>
                        </tr>
                        <tr>
                          <td>Tiempo de retorno</td>
                          <td><span id="tiempo_retorno">0.0</span> </td>
                          <td> </td>
                          <td id="tiempo_retorno_icon"></td>
                        </tr>
                      </tbody>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row" id="validation">
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="m-0">DOCUMENTO A (KICK-OFF)</h5>
                <h5 class="m-0"> PROYECTO: {{$document[0]->nombre_proyecto}}</h5>
              </div>
              <div class="card-body">
                <form id="form_kickoff" method="post">
                  <input type="hidden" name="id" id="id" value="{{$document[0]->id}}">
                  <div class="row">
                  <!--INFO-->
                  <div class="col-12">
                    <div class="form-inline d-flex justify-content-space-between align-items-center">
                      <label class="mr-sm-2">ID Proyecto (Almacén)</label>
                      <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" id="id_proyecto_almacen" value="{{$document[0]->id_proyecto_almacen}}" name="id_proyecto_almacen">
                      <label class="mr-sm-2" for="">No. Oportunidad</label>
                      <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" id="num_oportunidad" name="num_oportunidad" value="{{$document[0]->num_oportunidad}}">
                      <label class="mr-sm-2" for="">Sitios</label>
                      <input style="width:70px" type="text" class="form-control form-control-sm mb-2 mr-sm-2" id="sitios" name="sitios" value="{{$document[0]->sitios}}">
                      <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Cotizador" onclick="editar_cotizador(this)" data-id="{{$document[0]->id}}"  value="{{$document[0]->id}}" class="btn btn-info btn-dark text-white"><span class="fa fa-calculator"></span> Ir a cotizador</a>
                    </div>
                  </div>
                  <!--ADMINISTRACION-->
                  <div class="col-12 col-md-4 p-2">
                    <div class="row">
                      <div class="col-12">
                        <h4 class="text-danger text-center">Administración</h4>
                      </div>
                    </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col text-center bg-blue">
                          <label class="m-0" for="">Perfil del cliente</label>
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Vertical</label>
                        </div>
                        <div class="col-8">
                          <input id="vertical" name="vertical" disabled type="text" class="form-control form-control-sm" value="{{$document[0]->vertical}}">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Grupo</label>
                        </div>
                        <div class="col-8">
                          <input id="nombre_grupo" name="nombre_grupo" disabled type="text" class="form-control form-control-sm" value="{{$document[0]->nombre_grupo}}">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">R.F.C.</label>
                        </div>
                        <div class="col-8">
                          <input required id="rfc" name="rfc" value="{{$kickoff_perfil_cliente->rfc}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Razón social</label>
                        </div>
                        <div class="col-8">
                          <input id="razon_social" name="razon_social" value="{{$kickoff_perfil_cliente->razon_social}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Edo/Municipio</label>
                        </div>
                        <div class="col-8">
                          <input id="edo_municipio" name="edo_municipio" value="{{$kickoff_perfil_cliente->edo_municipio}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Contácto</label>
                        </div>
                        <div class="col-8">
                          <input id="contacto" name="contacto" id="contacto" name="contacto" value="{{$kickoff_perfil_cliente->contacto}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Puesto</label>
                        </div>
                        <div class="col-8">
                          <input id="puesto" name="puesto" value="{{$kickoff_perfil_cliente->puesto}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Teléfono</label>
                        </div>
                        <div class="col-8">
                          <input id="telefono" name="telefono" value="{{$kickoff_perfil_cliente->telefono}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Email</label>
                        </div>
                        <div class="col-8">
                          <input id="email" name="email" value="{{$kickoff_perfil_cliente->email}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Dirección</label>
                        </div>
                        <div class="col-8">
                          <input id="direccion" name="direccion" value="{{$kickoff_perfil_cliente->direccion}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                  </div>
                  <!--COMERCIAL-->
                  <div class="col-12 col-md-8 p-2">
                    <div class="row">
                      <div class="col-12">
                        <h4 class="text-danger text-center">Comercial</h4>
                      </div>
                    </div>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col text-center bg-blue">
                              <label for="">Datos del contrato</label>
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">No. De contrato/PO</label>
                            </div>
                            <div class="col-8">
                              <input id="num_contrato" name="num_contrato" value="{{$kickoff_contrato->num_contrato}}" type="text" class="form-control form-control-sm">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Fecha de Inicio</label>
                            </div>
                            <div class="col-8">
                              <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{$kickoff_contrato->fecha_inicio}}" class="form-control form-control-sm">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Fecha de término</label>
                            </div>
                            <div class="col-8">
                              <input id="fecha_termino" name="fecha_termino" value="{{$kickoff_contrato->fecha_termino}}" type="date" class="form-control form-control-sm">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Vigencia</label>
                            </div>
                            <div class="col-8">
                              <input type="text" disabled class="form-control form-control-sm" value="{{$document[0]->plazo}} meses">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Fecha de entrega</label>
                            </div>
                            <div class="col-8">
                              <input id="fecha_entrega" name="fecha_entrega" value="{{$kickoff_contrato->fecha_entrega}}" type="date" class="form-control form-control-sm">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">VTC (USD)</label>
                            </div>
                            <div class="col-8">
                              <input id="vtc_cotizador" name="vtc_cotizador" disabled type="text" class="form-control form-control-sm" value="{{$vtc}}">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Servicio</label>
                            </div>
                            <div class="col-8">
                              <input id="servicio" name="servicio" value="{{$kickoff_contrato->servicio}}" type="text" class="form-control form-control-sm">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Autorización (Sitwifi)</label>
                            </div>
                            <div class="col-8">
                              <input id="autorizacion_sitwifi" name="autorizacion_sitwifi" value="{{$kickoff_contrato->autorizacion_sitwifi}}" type="text" class="form-control form-control-sm">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Autorización (Cliente)</label>
                            </div>
                            <div class="col-8">
                              <input id="autorizacion_cliente" name="autorizacion_cliente" value="{{$kickoff_contrato->autorizacion_cliente}}" type="text" class="form-control form-control-sm">
                            </div>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col text-center bg-blue">
                              <label for="">Condiciones comerciales</label>
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Renta mensual</label>
                            </div>
                            <div class="col-8">
                              <input id="servicio_mensual" name="servicio_mensual" disabled type="text" class="form-control form-control-sm" value="{{$document[0]->servicio_mensual}}">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Tipo de cambio</label>
                            </div>
                            <div class="col-8">
                              <input id="tipo_cambio" name="tipo_cambio" disabled type="text" class="form-control form-control-sm" value="{{$tipo_cambio}}">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Capex</label>
                            </div>
                            <div class="col-8">
                              <input id="capex" name="capex" type="text" disabled class="form-control form-control-sm" value="{{$document[0]->capex}}">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Deposito de garantía</label>
                            </div>
                            <div class="col-8">
                              <input id="deposito_garantia" name="deposito_garantia" type="text" disabled class="form-control form-control-sm" value="{{$document[0]->deposito_garantia}}">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Mantenimiento por vigencia</label>
                            </div>
                            <div class="col-8">
                              <input id="mantenimiento_vigencia" name="mantenimiento_vigencia" value="{{$kickoff_contrato->mantenimiento_vigencia}}" type="number" class="form-control form-control-sm">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Tipo de adquisición</label>
                            </div>
                            <div class="col-8">
                              <select id="tipo_adquisicion" name="tipo_adquisicion" type="text" class="form-control form-control-sm">
                                @foreach ($adquisition as $adquisition_data)
                                  @if($adquisition_data->id == $kickoff_contrato->tipo_adquisicion)
                                    <option selected value="{{$adquisition_data->id}}">{{$adquisition_data->name}}</option>
                                  @else
                                    <option value="{{$adquisition_data->id}}">{{$adquisition_data->name}}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label  for="">Tipo de pago</label>
                            </div>
                            <div class="col-8">
                              <select id="tipo_pago" name="tipo_pago" type="text" class="form-control form-control-sm">
                                @foreach ($payments as $payments_data)
                                  @if($payments_data->id == $kickoff_contrato->tipo_pago)
                                    <option selected value="{{$payments_data->id}}">{{$payments_data->name}}</option>
                                  @else
                                    <option value="{{$payments_data->id}}">{{$payments_data->name}}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col text-center bg-blue">
                              <label for="">Comisión</label>
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">IT Concierge</label>
                            </div>
                            <div class="col-8">
                              <input id="itconciergecomision" name="itconciergecomision" disabled type="text" class="form-control form-control-sm" value="{{$document[0]->ITC}}">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label  for="">Vendedor</label>
                            </div>
                            <div class="col-8">
                              <select id="vendedor" name="vendedor" type="text" class="form-control form-control-sm">
                                @if($kickoff_contrato->vendedor == 4)
                                  <option selected value="4">Sin asignar</option>
                                @else
                                  <option value="4">Sin asignar</option>
                                @endif
                                @foreach ($vendedores as $vendedor)
                                  @if($vendedor->user_id == $kickoff_contrato->vendedor)
                                    <option selected value="{{$vendedor->user_id}}">{{$vendedor->user}}</option>
                                  @else
                                    <option value="{{$vendedor->user_id}}">{{$vendedor->user}}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label  for="">Inside Sales</label>
                            </div>
                            <div class="col-8">
                              <select id="inside_sales" name="inside_sales" type="text" class="form-control form-control-sm">
                                @if($kickoff_contrato->inside_sales == 4)
                                  <option selected value="4">Sin asignar</option>
                                @else
                                  <option value="4">Sin asignar</option>
                                @endif
                                @foreach ($inside_sales as $inside_sales_data)
                                  @if($inside_sales_data->user_id == $kickoff_contrato->inside_sales)
                                    <option selected value="{{$inside_sales_data->user_id}}">{{$inside_sales_data->user}}</option>
                                  @else
                                    <option value="{{$inside_sales_data->user_id}}">{{$inside_sales_data->user}}</option>
                                  @endif
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label  for="">Contácto</label>
                            </div>
                            <div class="col-8">
                              <input id="contacto_comercial" name="contacto_comercial" value="{{ $kickoff_contrato->contacto }}" type="text" class="form-control form-control-sm">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label  for="">Cierre</label>
                            </div>
                            <div class="col-8">
                              <input id="cierre" name="cierre" value="{{ $kickoff_contrato->cierre }}" type="text" class="form-control form-control-sm">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label  for="">Externo</label>
                            </div>
                            <div class="col-8">
                              <input id="comision_externo" name="comision_externo" value="{{ $kickoff_contrato->externo1 }}" type="text" class="form-control form-control-sm">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label  for="">Externo 2</label>
                            </div>
                            <div class="col-8">
                              <input id="comision_externo_2" name="comision_externo_2" value="{{ $kickoff_contrato->externo2}}" type="text" class="form-control form-control-sm">
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <!--INSTALACIONES-->
                  <div class="col-12 col-md-6 p-2">
                    <div class="row">
                      <div class="col-12">
                        <h4 class="text-danger text-center">Instalaciones</h4>
                      </div>
                    </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Fecha de inicio de instalación</label>
                        </div>
                        <div class="col-6">
                          <input id="fecha_inicio_instalacion" name="fecha_inicio_instalacion" value="{{$kickoff_instalaciones->fecha_inicio}}" type="date" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Fecha de término de instalación</label>
                        </div>
                        <div class="col-6">
                          <input id="fecha_termino_instalacion" name="fecha_termino_instalacion" value="{{$kickoff_instalaciones->fecha_termino}}" type="date" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Cantidad de Antenas</label>
                        </div>
                        <div class="col-6">
                          <input readonly type="text" class="form-control form-control-sm" value="{{$num_aps["total"]}}">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Internas</label>
                        </div>
                        <div class="col-6">
                          <input readonly type="text" class="form-control form-control-sm" value="{{$num_aps["api"]}}">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label readonly for="">Externas</label>
                        </div>
                        <div class="col-6">
                          <input readonly type="text" class="form-control form-control-sm" value="{{$num_aps["ape"]}}">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Viaticos / Pago a Proveedor</label>
                        </div>
                        <div class="col-6">
                          <input id="viaticos_proveedor" name="viaticos_proveedor" value="{{$kickoff_instalaciones->viaticos_proveedor}}" type="number" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Calidad de contratista</label>
                        </div>
                        <div class="col-6">
                          <input id="calidad_contratista" name="calidad_contratista" value="{{$kickoff_instalaciones->calidad_contratista}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Fecha de Mantenimiento / Garantia</label>
                        </div>
                        <div class="col-6">
                          <input id="fecha_mantenimiento" name="fecha_mantenimiento" value="{{$kickoff_instalaciones->fecha_mantenimiento}}" type="date" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Fecha de Acta de Entrega de la Instalación</label>
                        </div>
                        <div class="col-6">
                          <input id="fecha_acta_entrega" name="fecha_acta_entrega" value="{{$kickoff_instalaciones->fecha_acta_entrega}}" type="date" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Fecha de entrega de Memoria Técnica</label>
                        </div>
                        <div class="col-6">
                          <input id="fecha_entrega_memoria_tecnica" name="fecha_entrega_memoria_tecnica" value="{{$kickoff_instalaciones->fecha_entrega_memoria_tecnica}}" type="date" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Lugar de instalación: (locál / Foranea)</label>
                        </div>
                        <div class="col-6">
                          <select class="form-control form-control-sm" id="lugar_instalacion" name="lugar_instalacion">
                            @foreach ($installation as $installation_data)
                              @if($installation_data->id == $document[0]->lugar_instalacion_id)
                                <option selected value="{{$installation_data->id}}">{{$installation_data->name}}</option>
                              @else
                                <option value="{{$installation_data->id}}">{{$installation_data->name}}</option>
                              @endif
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Observaciones</label>
                        </div>
                        <div class="col-6">
                          <input id="observaciones" name="observaciones" value="{{$kickoff_instalaciones->observaciones}}"  type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                  </div>
                  <!--SOPORTE-->
                  <div class="col-12 col-md-6 p-2">
                    <div class="row">
                      <div class="col-12">
                        <h4 class="text-danger text-center">Soporte</h4>
                      </div>
                    </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Licencias</label>
                        </div>
                        <div class="col-8">
                          <input id="licencias" name="licencias" value="{{$kickoff_soporte->licencias}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Proveedor Enlace SITWIFI (Operador)</label>
                        </div>
                        <div class="col-8">
                          <input id="proveedor_enlace" name="proveedor_enlace" value="{{$kickoff_soporte->proveedor_enlace}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Importe de Enlace</label>
                        </div>
                        <div class="col-8">
                          <input id="enlace" name="enlace" disabled type="number" class="form-control form-control-sm" value="{{$document[0]->enlace}}">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Plazo del Enlace</label>
                        </div>
                        <div class="col-8">
                          <input id="plazo_enlace" name="plazo_enlace" value="{{$kickoff_soporte->plazo_enlace}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Fecha de Mantenimiento / Visitas</label>
                        </div>
                        <div class="col-8">
                          <input id="fecha_mantenimiento_soporte" name="fecha_mantenimiento_soporte" value="{{$kickoff_soporte->fecha_mantenimiento}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">IT Concierge asignado</label>
                        </div>
                        <div class="col-8">
                          <input id="itconcierge" name="itconcierge" disabled type="text" class="form-control form-control-sm" value="{{$document[0]->ITC}}">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Cantidad de equipos monitoreados</label>
                        </div>
                        <div class="col-8">
                          <input id="cantidad_equipos_monitoriados" name="cantidad_equipos_monitoriados" value="{{$kickoff_soporte->cantidad_equipos_monitoriados}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Nombre de TI del Cliente</label>
                        </div>
                        <div class="col-8">
                          <input id="nombre_ti_cliente" name="nombre_ti_cliente" value="{{$kickoff_soporte->nombre_ti_cliente}}" type="text" class="form-control form-control-sm">
                        </div>
                      </div>
                      <!--COMPRAS-->
                      <div class="col-12">
                        <h4 class="text-danger text-center">Compras</h4>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Fecha de entrega de Equipo Activo</label>
                        </div>
                        <div class="col-6">
                          <input id="fecha_entrega_ea" name="fecha_entrega_ea" value="{{$kickoff_compras->fecha_entrega_ea}}" type="date" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Tiempo de Entrega de Equipo Activo</label>
                        </div>
                        <div  class="col-6">
                          <input id="fecha_entrega_ena" name="fecha_entrega_ena" value="{{$kickoff_compras->fecha_entrega_ena}}" type="date" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Fecha de operación (Enlace)</label>
                        </div>
                        <div class="col-6">
                          <input id="fecha_entrega_operacion_enlace" name="fecha_entrega_operacion_enlace" value="{{$kickoff_compras->fecha_operacion_enlace}}" type="date" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Fecha de contratación (Enlace)</label>
                        </div>
                        <div class="col-6">
                          <input id="fecha_contratacion_enlace" name="fecha_contratacion_enlace" value="{{$kickoff_compras->fecha_contratacion_enlace}}" type="date" class="form-control form-control-sm">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-12 d-flex justify-content-end">
                          <button class="btn btn-dark mt-3" type="submit" name="button"> Guardar</button>
                        </div>
                      </div>
                    </div>
                  </div><!--row-->
                  <!--PROVEDDORES/INVERSION-->
                  <div class="row">
                    <div class="col-12 col-md-4 p-2">
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col text-center bg-blue">
                            <label class="m-0" for="">Proveedores</label>
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-4">
                            <label for="">Proveedor 1</label>
                          </div>
                          <div class="col-8">
                            <input id="proveedor1" name="proveedor1" value="{{$kickoff_compras->proveedor1}}" type="text" class="form-control form-control-sm">
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-4">
                            <label for="">Proveedor 2</label>
                          </div>
                          <div class="col-8">
                            <input id="proveedor2" name="proveedor2" value="{{$kickoff_compras->proveedor2}}" type="text" class="form-control form-control-sm">
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-4">
                            <label for="">Proveedor 3</label>
                          </div>
                          <div class="col-8">
                            <input id="proveedor3" name="proveedor3" value="{{$kickoff_compras->proveedor3}}" type="text" class="form-control form-control-sm">
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-4">
                            <label for="">Proveedor 4</label>
                          </div>
                          <div class="col-8">
                            <input id="proveedor4" name="proveedor4" value="{{$kickoff_compras->proveedor4}}" type="text" class="form-control form-control-sm">
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-4">
                            <label for="">Proveedor 5</label>
                          </div>
                          <div class="col-8">
                            <input id="proveedor5" name="proveedor5" value="{{$kickoff_compras->proveedor5}}" type="text" class="form-control form-control-sm">
                          </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 p-2">
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col text-center bg-blue">
                            <label class="m-0" for="">Inversión inicial del contrato USD</label>
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-6">
                            <label for="">Equipo Activo</label>
                          </div>
                          <div class="col-6">
                            <input id="" name="" readonly type="text" class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($document[0]->total_ea, 2, '.', ',')}}">
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-6">
                            <label for="">Equipo No Activo</label>
                          </div>
                          <div class="col-6">
                            <input id="" name="" readonly type="text" class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($document[0]->total_ena, 2, '.', ',')}}">
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-6">
                            <label for="">Mano de obra</label>
                          </div>
                          <div class="col-6">
                            <input type="text" readonly class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($document[0]->total_mo, 2, '.', ',')}}">
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-6">
                            <label for="">Total</label>
                          </div>
                          <div class="col-6">
                            <input type="text" readonly class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($document[0]->total_usd, 2, '.', ',')}}">
                          </div>
                        </div>
                        <div class="form-row d-flex">
                          <div class="col-12">
                            <button onclick="show_linea_base()" class="btn btn-danger btn-block" type="button" name="button"> <i class="fas fa-chart-line"></i> Ver Linea Base</button>
                          </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 p-2">
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col text-center bg-blue">
                            <label class="m-0" for="">Real Invertido USD</label>
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-6">
                            <label for="">Equipo Activo</label>
                          </div>
                          <div class="col-6">
                            <input id="total_ea_invertido" name="" readonly type="text" class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($real_ejercido['total_ea'], 2, '.', ',')}}">
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-6">
                            <label for="">Equipo No Activo</label>
                          </div>
                          <div class="col-6">
                            <input id="total_ena_invertido" name="" readonly type="text" class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($real_ejercido['total_ena'], 2, '.', ',')}}">
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-6">
                            <label for="">Mano de obra</label>
                          </div>
                          <div class="col-6">
                            <input type="text" readonly id="total_mo_invertido" class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($real_ejercido['total_mo'], 2, '.', ',')}}">
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-6">
                            <label for="">Total</label>
                          </div>
                          <div class="col-6">
                            <input type="text" id="total_usd_invertido" readonly class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($real_ejercido['total_ea'] + $real_ejercido['total_ena'] + $real_ejercido['total_mo'], 2, '.', ',')}}">
                          </div>
                        </div>
                        <div class="form-row d-flex align-items-center mb-2">
                          <div class="col-6">
                            <label for="">Diferencia</label>
                          </div>
                          <div class="col-6">
                            <input type="text" readonly class="form-control form-control-sm text-right font-weight-bold" value="{{number_format($document[0]->total_usd - ($real_ejercido['total_ea'] + $real_ejercido['total_ena'] + $real_ejercido['total_mo']) , 2, '.', ',')}}">
                          </div>
                        </div>
                    </div>
                  </div>
                  <!--Firmas-->
                  <div class="row mt-3">
                    <h5 class="text-dark"><i class="fas fa-exclamation-triangle"></i> Para que el Documento A sea aprobado, deberá ser autorizado por todos los departamentos y al menos 2 directivos</h5>
                    <br>
                    <h5 class="text-dark">*</i> Una vez que el proyecto sea aprobado se convertirá en Documento P</h5>
                  </div>
                  <div class="row d-flex justify-content-center">
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-5">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion itconcierge') && $kickoff_approvals->itconcierge == 1)
                            <input id="check_itconcierge" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion itconcierge') && $kickoff_approvals->itconcierge == 0)
                            <input id="check_itconcierge" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_itconcierge" type="checkbox" class="form-check-input" disabled>
                          @endif
                          {{-- {{$document[0]->ITC}} --}}
                      </div>
                      <div class="text-center">
                        <p class="text-secondary ml-5">IT Concierge</p>
                        @if ($kickoff_approvals->itconcierge == 1)
                          <span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
                        @endif
                      </div>
                    </div>
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-5">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion proyectos') && $kickoff_approvals->proyectos == 1)
                            <input id="check_proyectos" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion proyectos') && $kickoff_approvals->proyectos == 0)
                            <input id="check_proyectos" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_proyectos" type="checkbox" class="form-check-input" disabled>
                          @endif
                          Aaron Arciga
                      </div>
                      <div class="text-center">
                        <p class="text-secondary ml-5">Gerente Proyectos</p>
                        @if ($kickoff_approvals->proyectos == 1)
                          <span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
                        @endif
                      </div>
                    </div>
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-5">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion soporte') && $kickoff_approvals->soporte == 1)
                            <input id="check_soporte" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion soporte') && $kickoff_approvals->soporte == 0)
                            <input id="check_soporte" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_soporte" type="checkbox" class="form-check-input" disabled>
                          @endif
                          Ricardo Delgado
                      </div>
                      <div class="text-center">
                        <p class="text-secondary ml-5">Gerente Soporte</p>
                        @if ($kickoff_approvals->soporte == 1)
                          <span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
                        @endif
                      </div>
                    </div>
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-5">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion planeacion') && $kickoff_approvals->planeacion == 1)
                            <input id="check_planeacion" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion planeacion') && $kickoff_approvals->planeacion == 0)
                            <input id="check_planeacion" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_planeacion" type="checkbox" class="form-check-input" disabled>
                          @endif
                          Manuel F. Moreno
                      </div>
                      <div class="text-center">
                        <p class="text-secondary ml-5">Compras</p>
                        @if ($kickoff_approvals->planeacion == 1)
                          <span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
                        @endif
                      </div>
                    </div>
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-5">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion servicio cliente') && $kickoff_approvals->servicio_cliente == 1)
                            <input id="check_servicio_cliente" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion servicio cliente') && $kickoff_approvals->servicio_cliente == 0)
                            <input id="check_servicio_cliente" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_servicio_cliente" type="checkbox" class="form-check-input" disabled>
                          @endif
                          Carlos Rangel
                      </div>
                      <div class="text-center">
                        <p class="text-secondary ml-5">Servicio al cliente</p>
                        @if ($kickoff_approvals->servicio_cliente == 1)
                          <span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
                        @endif
                      </div>
                    </div>
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-5">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion facturacion') && $kickoff_approvals->facturacion == 1)
                            <input id="check_facturacion" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion facturacion') && $kickoff_approvals->facturacion == 0)
                            <input id="check_facturacion" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_facturacion" type="checkbox" class="form-check-input" disabled>
                          @endif
                        Sandra Cruz
                      </div>
                      <div class="text-center">
                        <p class="text-secondary ml-5">Facturación</p>
                        @if ($kickoff_approvals->facturacion == 1)
                          <span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
                        @endif
                      </div>
                    </div>
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-5">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion legal') && $kickoff_approvals->legal == 1)
                            <input id="check_legal" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion legal') && $kickoff_approvals->legal == 0)
                            <input id="check_legal" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_legal" type="checkbox" class="form-check-input" disabled>
                          @endif
                          Mariana Flores
                      </div>
                      <div class="text-center">
                        <p class="text-secondary ml-5">Legal</p>
                        @if ($kickoff_approvals->legal == 1)
                          <span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
                        @endif
                      </div>
                    </div>
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-3">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion administracion') && $kickoff_approvals->administracion == 1)
                            <input id="check_administracion" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion administracion') && $kickoff_approvals->administracion == 0)
                            <input id="check_administracion" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_administracion" type="checkbox" class="form-check-input" disabled>
                          @endif
                          María  de Jesús Ortíz
                      </div>
                      <div class="text-center">
                        <p class="text-secondary">Administración y Finanzas</p>
                        @if ($kickoff_approvals->administracion == 1)
                          <span class="badge badge-success badge-pill text-white">Autorizado</span>
                        @endif
                      </div>
                    </div>
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-5">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion director comercial') && $approval_dir[0]->aprobado_direccion == 1)
                            <input id="check_comercial" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion director comercial') && $kickoff_approvals->director_comercial == 1)
                            <input id="check_comercial" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion director comercial') && $kickoff_approvals->director_comercial == 0)
                            <input id="check_comercial" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_comercial" type="checkbox" class="form-check-input" disabled>
                          @endif
                          John Walker
                      </div>
                      <div class="text-center">
                        <p class="text-secondary ml-5">Director Comercial</p>
                        @if ($kickoff_approvals->director_comercial == 1)
                          <span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
                        @endif
                      </div>
                    </div>
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-5">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion director operaciones') && $approval_dir[0]->aprobado_direccion == 1)
                            <input id="check_director_operaciones" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion director operaciones') && $kickoff_approvals->director_operaciones == 1)
                            <input id="check_director_operaciones" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion director operaciones') && $kickoff_approvals->director_operaciones == 0)
                            <input id="check_director_operaciones" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_director_operaciones" type="checkbox" class="form-check-input" disabled>
                          @endif
                          René González
                      </div>
                      <div class="text-center">
                        <p class="text-secondary ml-5">Director operaciones</p>
                        @if ($kickoff_approvals->director_operaciones == 1)
                          <span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
                        @endif
                      </div>
                    </div>
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-5">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion director general') && $approval_dir[0]->aprobado_direccion == 1)
                            <input id="check_director_general" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion director general') && $kickoff_approvals->director_general == 1)
                            <input id="check_director_general" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion director general') && $kickoff_approvals->director_general == 0)
                            <input id="check_director_general" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_director_general" type="checkbox" class="form-check-input" disabled>
                          @endif
                          Alejandro Espejo
                      </div>
                      <div class="text-center">
                        <p class="text-secondary ml-5">Director general</p>
                        @if ($kickoff_approvals->director_general == 1)
                          <span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
                        @endif
                      </div>
                    </div>

                  </div>

                </form>
              </div>
            </div>
          </div>
      </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View history quoting') )
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('/plugins/momentupdate/moment-with-locales.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>
    <link type="text/css" href="css/bootstrap-editable.css" rel="stylesheet" />
    <script src="{{ asset('js/bootstrap-editable.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >

  @else
    @include('default.denied')
  @endif
  <script type="text/javascript" src="{{asset('js/admin/quoting/kickoff.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/admin/quoting/modal_linea_base.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/admin/documentp/request_modal_documentp.js')}}"></script>
  <style media="screen">

  input[type="checkbox"]:disabled {
      color: green !important;
      cursor: none;
  }


    form label{
      margin-bottom: 0 !important;
      font-size: 0.85rem;
    }

    select{
      color: #535352 !important;
    }

    .form-control-sm{
      height: 2rem !important;
    }

    .bg-blue{
      background: #0686CC;
      color: white;
      font-weight: bold;
    }

    #tabla_objetivos th, #tabla_objetivos td{
      padding: 0.2rem 1.2rem;
    }
  </style>
@endpush
