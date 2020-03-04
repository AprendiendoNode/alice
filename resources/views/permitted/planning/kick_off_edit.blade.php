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
      <!--  MODAL COMISIONES -->
<div id="modal_comision" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cálculo de comisión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section>
          <form id="form_validation" class="">
            {{ csrf_field() }}
          <div class="row" id="div_comisiones" name="div_comisiones">
            <div class="col-12">
              <div class="card">
                <div style="background: #3E3E42;" class="card-header text-white p-1">
                  <a class="btn btn-sm btn-default p-1" rol="button" data-toggle="collapse" href="#collapseContract" aria-expanded="false" aria-controls="collapseContract">
                    <i class="fas fa-angle-down text-white"></i>
                  </a>
                  Vincular comisiones de contrato a KICKOFF
                </div>
                <div class="collapse" id="collapseContract">
                  <div class="card-body">
                    <div class="form-inline d-flex justify-content-space-between align-items-center">
                      <label class="mr-sm-2">Cadena</label>
                      <select style="width:150px;" type="text" class="form-control form-control-sm mb-2 mr-sm-2" id="cadena" name="cadena">
                        <option value="">Elegir</option>
                        @foreach ($cadenas as $cadena)
                          <option value="{{$cadena->id}}">{{ $cadena->name }}</option>
                        @endforeach
                      </select>
                      <label class="mr-sm-2" for="">C. Maestro</label>
                      <select style="width:150px" type="text" class="form-control form-control-sm mb-2 mr-sm-2" id="sel_master_to_anexo" name="sel_master_to_anexo">
                        <option value="">Elegir</option>
                      </select>
                      <label class="mr-sm-2" for="">C. Anexo</label>
                      <select style="width:150px" type="text" class="form-control form-control-sm mb-2 mr-sm-2" id="sel_anexo" name="sel_anexo" value="">
                        <option value="">Elegir</option>
                      </select>
                      <input class="form-control form-control-sm" readonly type="text" name="id_ubicacion" id="id_ubicacion" value="">
                      <input class="form-control form-control-sm" readonly type="text" name="nombre_sitio" id="nombre_sitio" value="">
                      <input class="form-control form-control-sm" readonly type="hidden" name="id_hotel" id="id_hotel" value="">
                      <button type="button" id="match_contract_button"  class="btn btn-info btn-danger text-white ml-2"><span class="fas fa-exchange-alt"></span> Relacionar datos </button type="button">
                    </div>
                  </div>
                </div>
                </div>
              </div>
              <div class="col-md-12 col-xs-12 mb-3">
                <div class="table-responsive">
                  <table class="table table-items table-condensed table-hover table-bordered table-striped jambo_table table-sm" id="item_politica" style="min-width: 80px;">
                    <thead>
                      <tr class="bg-danger text-white">
                        <th class="text-center" colspan="7" style="font-size: 1rem;">Politica de comisión</th>
                      </tr>
                      <tr class="bg-secondary text-white">
                        <th class="text-center" style="padding: 1.25rem 0.9375rem !important;">Tipo de comisión</th>
                        <th class="text-center" colspan="8">
                          <select id="sel_type_comision" name="sel_type_comision" class="form-control form-control-sm required" style="width:100%;">
                            <option value="">{{ trans('pay.select_op') }}</option>
                            @if(count($comision_politica) > 0)
                              @forelse ($politica_comision as $politica_comision_data)
                                @if($politica_comision_data->id == $comision_politica[0]->politica_id)
                                  <option selected value="{{ $politica_comision_data->id }}"> {{ $politica_comision_data->politica }} </option>
                                @else
                                  <option value="{{ $politica_comision_data->id }}"> {{ $politica_comision_data->politica }} </option>
                                @endif
                                @empty
                              @endforelse
                            @else
                              @foreach ($politica_comision as $politica_comision_data)
                                <option value="{{ $politica_comision_data->id }}"> {{ $politica_comision_data->politica }} </option>
                              @endforeach
                            @endif

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
                            <input type="text" class="form-control form-control-sm input-sm text-right col-politica sinpadding" id="politica_name" name="politica_name" readonly />
                          </div>
                        </td>
                        <td>
                          <div class="form-group form-group-sm">
                            <input type="text" class="form-control form-control-sm input-sm text-right col-retencion" id="politica_retencion" name="politica_retencion" value="0" readonly />
                          </div>
                        </td>
                        <td>
                          <div class="form-group form-group-sm">
                            <input type="text" class="form-control form-control-sm input-sm text-right col-total" id="politica_asignado" name="politica_asignado" value="0" readonly />
                          </div>
                        </td>
                        <td>
                          <div class="form-group form-group-sm">
                            <input type="text" class="form-control form-control-sm input-sm text-right col-contacto" id="politica_contacto" name="politica_contacto" value="0" readonly />
                          </div>
                        </td>
                        <td>
                          <div class="form-group form-group-sm">
                            <input type="text" class="form-control form-control-sm input-sm text-right col-cierre" id="politica_cierre" name="politica_cierre" value="0" readonly />
                          </div>
                        </td>
                        <td>
                          <div class="form-group form-group-sm">
                            <input type="text" class="form-control form-control-sm input-sm text-right col-itc" id="politica_itc" name="politica_itc" value="0" readonly />
                          </div>
                        </td>
                        <td>
                          <div class="form-group form-group-sm">
                            <input type="text" class="form-control form-control-sm input-sm text-right col-insidesales" id="politica_insidesales" name="politica_insidesales" value="0" readonly />
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
                  </label>
                  <select id="sel_inside_sales" name="sel_inside_sales" class="form-control form-control-sm" name="location" style="width:100%;">
                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                    @if(count($comision_politica) > 0)
                      @foreach ($kickoff_inside_sales as $kickoff_inside_sales_data)
                        @if($comision_politica[0]->inside_sales != [] && $kickoff_inside_sales_data->user_id == $comision_politica[0]->inside_sales)
                          <option selected value="{{ $kickoff_inside_sales_data->user_id }}"> {{ $kickoff_inside_sales_data->user }} </option>
                        @else
                          <option value="{{ $kickoff_inside_sales_data->user_id }}"> {{ $kickoff_inside_sales_data->user }} </option>
                        @endif
                      @endforeach
                    @else
                      @foreach ($kickoff_inside_sales as $kickoff_inside_sales_data)
                        <option value="{{ $kickoff_inside_sales_data->user_id }}"> {{ $kickoff_inside_sales_data->user }} </option>
                      @endforeach
                    @endif

                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="sel_itconcierge_comision"> IT Concierge:
                  </label>
                  <select id="sel_itconcierge_comision" name="sel_itconcierge_comision" class="form-control form-control-sm" name="location" style="width:100%;">
                    <option value="" selected>{{ trans('pay.select_op') }}</option>
                    @if(count($comision_politica) > 0)
                      @foreach ($itconcierge as $itconcierge_data)
                        @if($itconcierge_data->id == $comision_politica[0]->itconcierge)
                          <option selected value="{{ $itconcierge_data->id }}"> {{ $itconcierge_data->nombre }} </option>
                        @else
                          <option value="{{ $itconcierge_data->id }}"> {{ $itconcierge_data->nombre }} </option>
                        @endif
                      @endforeach
                    @else
                      @foreach ($itconcierge as $itconcierge_data)
                        <option value="{{ $itconcierge_data->id }}"> {{ $itconcierge_data->nombre }} </option>
                      @endforeach
                    @endif

                  </select>
                </div>
              </div>

              <div class="col-md-12 col-xs-12">
                <div class="table-responsive">
                  <table class="table table-items table-condensed table-hover table-bordered table-striped jambo_table table-sm mt-4" id="item_contact" style="min-width: 80px;">
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
                          $item_relation_contact_row = $item_contact_row;
                        @endphp

                        @if(count($comision_contacto) > 0)
                          @foreach ($comision_contacto as $comision_contact_data)
                          <tr id="item_row_{{$item_relation_contact_row}}">

                            <td class="text-center" style="vertical-align: middle;">
                            <button type="button" onclick="$('#item_row_{{$item_relation_contact_row}}').remove();" class="btn btn-xs btn-danger" style="margin-bottom: 0; padding: 1px 3px;">
                            <i class="fa fa-trash" style="font-size: 1rem;"></i>
                            </button>
                            <input type="hidden" name="item[{{$item_relation_contact_row}}][id]" id="item_id_{{$item_relation_contact_row}}" value="{{$comision_contact_data->id}}" />
                            </td>

                            <td>
                            <div class="form-group form-group-sm">
                            <select class="form-control form-control-sm input-sm col-contact-int" name="item[{{$item_relation_contact_row}}][contactInt]" id="item_contactInt_{{$item_relation_contact_row}}" data-row="{{$item_relation_contact_row}}">
                            <option selected="selected" value="">@lang('message.selectopt')</option>
                              @forelse ($kickoff_colaboradores as $kickoff_colaboradores_data)
                                @if($kickoff_colaboradores_data->id == $comision_contact_data->user_id)
                                  <option selected value="{{ $kickoff_colaboradores_data->id  }}">{{ $kickoff_colaboradores_data->name }}</option>
                                @else
                                  <option value="{{ $kickoff_colaboradores_data->id  }}">{{ $kickoff_colaboradores_data->name }}</option>
                                @endif
                              @empty
                              @endforelse
                            </select>
                            </div>
                            </td>

                            <td>
                            <div class="form-group form-group-sm">
                            <input type="text" class="form-control form-control-sm input-sm text-right col-contact" name="item[{{$item_relation_contact_row}}][contact]" id="item_contact_{{$item_relation_contact_row}}" value="{{$comision_contact_data->nombre}}" step="any"/>
                            </div>
                            </td>

                            <td>
                            <div class="form-group form-group-sm">
                            <input type="text" class="form-control form-control-sm input-sm text-right col-porcentaje porcentajes_contacto" name="item[{{$item_relation_contact_row}}][porcentaje]" id="item_porcentaje_{{$item_relation_contact_row}}" required value="{{$comision_contact_data->valor_comision}}" step="any" maxlength="10" />
                            </div>
                            </td>

                            </tr>
                            @php
                              $item_relation_contact_row++;
                            @endphp
                          @endforeach
                        @endif
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
                  <table class="table table-items table-condensed table-hover table-bordered table-striped table-sm jambo_table mt-4" id="item_cierre" style="min-width: 80px;">
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
         </form>
        </section>
      </div>
      <div class="modal-footer">
          <button id="button_comision" type="button" onclick="save_comision();" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

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
      <!------------------------------------------------------------------------------------->
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

                    <br>
                  <!--INFO-->
                  <div class="col-12 mt-4">
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
                          <input required id="rfc" name="rfc" value="{{$kickoff_perfil_cliente->rfc}}" type="text" class="form-control form-control-sm input-admin">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Razón social</label>
                        </div>
                        <div class="col-8">
                          <input id="razon_social" name="razon_social" value="{{$kickoff_perfil_cliente->razon_social}}" type="text" class="form-control form-control-sm input-admin">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Edo/Municipio</label>
                        </div>
                        <div class="col-8">
                          <input id="edo_municipio" name="edo_municipio" value="{{$kickoff_perfil_cliente->edo_municipio}}" type="text" class="form-control form-control-sm input-admin">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Contácto</label>
                        </div>
                        <div class="col-8">
                          <input id="contacto" name="contacto" id="contacto" name="contacto" value="{{$kickoff_perfil_cliente->contacto}}" type="text" class="form-control form-control-sm input-admin">
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
                          <input id="email" name="email" value="{{$kickoff_perfil_cliente->email}}" type="text" class="form-control form-control-sm input-admin">
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
                              <input id="servicio" name="servicio" value="{{$kickoff_contrato->servicio}}" type="text" class="form-control form-control-sm input-comercial">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Autorización (Sitwifi)</label>
                            </div>
                            <div class="col-8">
                              <input id="autorizacion_sitwifi" name="autorizacion_sitwifi" value="{{$kickoff_contrato->autorizacion_sitwifi}}" type="text" class="form-control form-control-sm input-comercial">
                            </div>
                          </div>
                          <div class="form-row d-flex align-items-center mb-2">
                            <div class="col-4">
                              <label for="">Autorización (Cliente)</label>
                            </div>
                            <div class="col-8">
                              <input id="autorizacion_cliente" name="autorizacion_cliente" value="{{$kickoff_contrato->autorizacion_cliente}}" type="text" class="form-control form-control-sm input-comercial">
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
                            {{-- <div class="col-6">
                              <a href="/view_pdf_propuesta_comercial/{{$document[0]->id}}" target="_blank" class="btn btn-danger" rol="button"><i class="fas fa-file-pdf"></i> Ver propuesta comercial</a>
                            </div> --}}
                            <div class="col-12">
                              <button class="btn btn-success" onclick="show_comision();" type="button" name="button"><i class="fas fa-wallet"></i> Ver comisiónes</button>
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
                          <input id="fecha_inicio_instalacion" name="fecha_inicio_instalacion" value="{{$kickoff_instalaciones->fecha_inicio}}" type="date" class="form-control form-control-sm input-instalacion">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Fecha de término de instalación</label>
                        </div>
                        <div class="col-6">
                          <input id="fecha_termino_instalacion" name="fecha_termino_instalacion" value="{{$kickoff_instalaciones->fecha_termino}}" type="date" class="form-control form-control-sm input-instalacion">
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
                          <input id="licencias" name="licencias" value="{{$kickoff_soporte->licencias}}" type="text" class="form-control form-control-sm input-soporte">
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
                          <input id="fecha_mantenimiento_soporte" name="fecha_mantenimiento_soporte" value="{{$kickoff_soporte->fecha_mantenimiento}}" type="text" class="form-control form-control-sm input_soporte">
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
                          <input id="cantidad_equipos_monitoriados" name="cantidad_equipos_monitoriados" value="{{$kickoff_soporte->cantidad_equipos_monitoriados}}" type="text" class="form-control form-control-sm input-soporte">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-4">
                          <label for="">Nombre de TI del Cliente</label>
                        </div>
                        <div class="col-8">
                          <input id="nombre_ti_cliente" name="nombre_ti_cliente" value="{{$kickoff_soporte->nombre_ti_cliente}}" type="text" class="form-control form-control-sm input-soporte">
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
                          <input id="fecha_entrega_ea" name="fecha_entrega_ea" value="{{$kickoff_compras->fecha_entrega_ea}}" type="date" class="form-control form-control-sm input-compras">
                        </div>
                      </div>
                      <div class="form-row d-flex align-items-center mb-2">
                        <div class="col-6">
                          <label for="">Tiempo de Entrega de Equipo Activo</label>
                        </div>
                        <div  class="col-6">
                          <input id="fecha_entrega_ena" name="fecha_entrega_ena" value="{{$kickoff_compras->fecha_entrega_ena}}" type="date" class="form-control form-control-sm input-compras">
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
                            <input id="proveedor1" name="proveedor1" value="{{$kickoff_compras->proveedor1}}" type="text" class="form-control form-control-sm input-compras">
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
                          {{$document[0]->ITC}}
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
                            @if (auth()->user()->can('Aprobacion vendedor') && $kickoff_approvals->vendedor == 1)
                              <input id="check_vendedor" type="checkbox" class="form-check-input" disabled checked>
                            @elseif(auth()->user()->can('Aprobacion vendedor') && $kickoff_approvals->vendedor == 0)
                              <input id="check_vendedor" type="checkbox" class="form-check-input">
                            @else
                              <input id="check_vendedor" type="checkbox" class="form-check-input" disabled>
                            @endif
                            {{$document[0]->comercial}}
                            {{-- {{$document[0]->ITC}} --}}
                        </div>
                        <div class="text-center">
                          <p class="text-secondary ml-5">Vendedor</p>
                          @if ($kickoff_approvals->vendedor == 1)
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
                        <p class="text-secondary ml-5">Gerente de Compras</p>
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
						<div class="form-check form-check-flat form-check-success ml-5">
							<label class="form-check-label">
							@if (auth()->user()->can('Aprobacion investigacion y desarrollo') && $kickoff_approvals->investigacion_desarrollo == 1)
								<input id="check_investigacion_desarrollo" type="checkbox" class="form-check-input" disabled checked>
							@elseif(auth()->user()->can('Aprobacion investigacion y desarrollo') && $kickoff_approvals->investigacion_desarrollo == 0)
								<input id="check_investigacion_desarrollo" type="checkbox" class="form-check-input">
							@else
								<input id="check_investigacion_desarrollo" type="checkbox" class="form-check-input" disabled>
							@endif
							Javier Martínez
						</div>
						<div class="text-center">
							<p class="text-secondary ml-5">Investigación y desarrollo</p>
							@if ($kickoff_approvals->investigacion_desarrollo == 1)
							<span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
							@endif
						</div>
					</div>
                    <div class="d-block">
                      <div class="form-check form-check-flat form-check-success ml-5">
                        <label class="form-check-label">
                          @if (auth()->user()->can('Aprobacion administracion') && $approval_dir[0]->aprobado_direccion == 1)
                            <input id="check_administracion" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion administracion') && $kickoff_approvals->administracion == 1)
                            <input id="check_administracion" type="checkbox" class="form-check-input" disabled checked>
                          @elseif(auth()->user()->can('Aprobacion administracion') && $kickoff_approvals->administracion == 0)
                            <input id="check_administracion" type="checkbox" class="form-check-input">
                          @else
                            <input id="check_administracion" type="checkbox" class="form-check-input" disabled>
                          @endif
                          María  de Jesús Ortíz
                      </div>
                      <div class="text-center">
                        <p class="text-secondary ml-5">Administración y Finanzas</p>
                        @if ($kickoff_approvals->administracion == 1)
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
                        <p class="text-secondary ml-5">Director General</p>
                        @if ($kickoff_approvals->director_general == 1)
                          <span class="badge badge-success badge-pill text-white ml-5">Autorizado</span>
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
                        <p class="text-secondary ml-5">Director de Operaciones</p>
                        @if ($kickoff_approvals->director_operaciones == 1)
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
  <script type="text/javascript" src="{{asset('js/admin/quoting/kickoff.js?v?=3.0.0')}}"></script>
  <script type="text/javascript" src="{{asset('js/admin/quoting/modal_linea_base.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/admin/quoting/comision.js?v=2.0.0')}}"></script>
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
  <script type="text/javascript">
    var item_relation_contact_row = "{{ $item_contact_row }}"; //Valor incorrecto
    var item_relation_cierre_row = "{{ $item_cierre_row }}";

    $(function() {

      item_relation_contact_row = {{$item_relation_contact_row}}; //Valor correcto
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

      $('#comision').change(function() {
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

        $('#sel_type_comision').trigger('change');
        $('#sel_inside_sales').val('').trigger('change');
        $('#sel_itconcierge_comision').val('').trigger('change');
        $("#item_politica input[type=text]").val('');
        delete_row_table_a();
        delete_row_table_b();
        delete_row_table_c();
        delete_row_table_d();
      });
      $('#sel_type_comision').change(function(){
        var group = $(this).val();
        data_comision(group);
      });
      data_comision($('#sel_type_comision').val());
      var kickoff_id = '{{$kickoff_approvals->kickoff_id}}';
      var token = $('input[name="_token"]').val();
      kickoff_cierre(kickoff_id, token);
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
        html += '<select class="form-control form-control-sm input-sm col-contact-int" name="item[' + item_relation_contact_row + '][contactInt]" id="item_contactInt_' + item_relation_contact_row + '" data-row="' + item_relation_contact_row + '">'
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
        html += '<input type="text" class="form-control form-control-sm input-sm text-right col-contact" name="item[' + item_relation_contact_row + '][contact]" id="item_contact_' + item_relation_contact_row + '" step="any"/>';
        html += '</div>';
        html += '</td>';

        html += '<td>';
        html += '<div class="form-group form-group-sm">';
        html += '<input type="text" class="form-control form-control-sm input-sm text-right col-porcentaje porcentajes_contacto" name="item[' + item_relation_contact_row + '][porcentaje]" id="item_porcentaje_' + item_relation_contact_row + '" required step="any" maxlength="10" />';
        html += '</div>';
        html += '</td>';

        html += '</tr>';

        $("#item_contact tbody #add_item_contact").before(html);
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
        html += '<select class="form-control form-control-sm input-sm col-cierre-contact-int" name="item_cierre[' + item_relation_cierre_row + '][contactInt]" id="item_cierre_contactInt_' + item_relation_cierre_row + '" data-row="' + item_relation_cierre_row + '">'
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
        html += '<input type="text" class="form-control form-control-sm input-sm text-right col-cierre-contact" name="item_cierre[' + item_relation_cierre_row + '][contact]" id="item_cierre_contact_' + item_relation_cierre_row + '" step="any" />';
        html += '</div>';
        html += '</td>';

        html += '<td>';
        html += '<div class="form-group form-group-sm">';
        html += '<input type="text" class="form-control form-control-sm input-sm text-right col-cierre-porcentaje porcentajes_cierre" name="item_cierre[' + item_relation_cierre_row + '][porcentaje]" id="item_cierre_porcentaje_' + item_relation_cierre_row + '" required step="any" maxlength="10" />';
        html += '</div>';
        html += '</td>';

        html += '</tr>';
        $("#item_cierre tbody #add_item_cierre").before(html);
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
              html += '<input type="hidden" name="item_cierre[' + item_relation_cierre_row + '][id]" id="item_cierre_id_' + item_relation_cierre_row + '" value="' + key.id + '" /> ';
              html += '</td>';

              html += '<td>';
              html += '<div class="form-group form-group-sm">';
              html += '<select class="form-control form-control-sm input-sm col-cierre-contact-int" name="item_cierre[' + item_relation_cierre_row + '][contactInt]" id="item_cierre_contactInt_' + item_relation_cierre_row + '" data-row="' + item_relation_cierre_row + '">'
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
                html += '<input type="text" class="form-control form-control-sm input-sm text-right col-cierre-contact" name="item_cierre[' + item_relation_cierre_row + '][contact]" id="item_cierre_contact_' + item_relation_cierre_row + '" step="any" />';
              }
              else {
                html += '<input type="text" class="form-control form-control-sm input-sm text-right col-cierre-contact" name="item_cierre[' + item_relation_cierre_row + '][contact]" id="item_cierre_contact_' + item_relation_cierre_row + '" value="' + key.nombre + '" step="any" />';
              }
              html += '</div>';
              html += '</td>';

              html += '<td>';
              html += '<div class="form-group form-group-sm">';
              html += '<input type="text" class="form-control form-control-sm input-sm text-right col-cierre-porcentaje porcentajes_cierre" name="item_cierre[' + item_relation_cierre_row + '][porcentaje]" id="item_cierre_porcentaje_' + item_relation_cierre_row + '" value="' + (key.valor_comision == null ? "" : key.valor_comision) + '" required step="any" maxlength="10" />';
              html += '</div>';
              html += '</td>';

              html += '</tr>';
              $("#item_cierre tbody #add_item_cierre").before(html);
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

@endpush
