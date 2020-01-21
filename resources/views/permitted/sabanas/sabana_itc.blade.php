@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View dash sabana') )
    <strong>Dashboard General Por ITC</strong>
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View dash sabana') )

  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View dash sabana') )
    ITC
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View dash sabana') )

      <div class="input-group mb-3">
        <label class="mr-1">ITC:</label>
        <select id="select_itc" class="form-control select2">
          <option value="" selected> Elija uno... </option>
          @forelse ($users as $user)
            <option value="{{ $user->id }}" data-name="{{$user->name}}" data-email="{{$user->email}}" data-avatar="{{$user->avatar}}" data-city="{{$user->city}}"> {{ $user->name }} </option>
          @empty
          @endforelse
        </select>
      </div>

      <div class="modal modal-default fade" id="modal-view-ppd" data-backdrop="static">
          <div class="modal-dialog" >
            <div class="modal-content" style="width: 70vw; margin-left: -15vw;">
              <div class="modal-header">
                <h4 class="modal-title"><i class="far fa-address-card" style="margin-right: 4px;"></i>Calificaciones.</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="box-body table-responsive">
              <div class="box-body">
                <div class="row">
                  <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="row pad-top-botm client-info">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <p class="text-center" style="border: 1px solid #3D9970" >Calificaciones.</p>
                        <div class="clearfix">
                          <table id="table_boxes_ppd" class="table table-striped table-bordered compact-tab table-hover">
                            <thead class="bg-aqua text-center">
                              <tr>
                                <th>Cliente</th>
                                <th>Sitio</th>
                                <th>Ing. Asignado</th>
                                <th>Fecha de registro</th>
                                <th>Comentario</th>
                                <th>Calificación</th>
                              </tr>
                            </thead>
                            <tbody class="text-center"style="font-size: 11px;">

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    </div>
                </div>
              </div>
            </div>
              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary btn-export"><i class="fa fa-save"></i> Exportar PDF</button> -->
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </div>
            </div>
          </div>
      </div>

      <div class="modal modal-default fade" id="modal-view-viatics" data-backdrop="static"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" style="width:50%" >
          <div class="modal-content">
            <div class="modal-header">

              <h4 class="modal-title"><i class="fas fa-id-card" style="margin-right: 4px;"></i>Lista de conceptos</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="card table-responsive">
                <div class="card-body">
                  <div class="row">
                    <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                    <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                      <input id="obj" name="obj" class="form-control hidden" required readonly type="text" value="" style="display:none; visibility:hidden;">

                      <div class="hojitha"   style="background-color: #fff; /*border:1px solid #ccc;*/ border-bottom-style:hidden; padding:10px; padding-top: 0px; width: 95%">
                        <div class="row pad-top-botm ">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <h2> <small>Solicitud de viaticos</small></h2>
                          </div>
                        </div>

                        <div class="row text-center contact-info">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <hr />
                            <span>
                              <strong>Fecha de solicitud: </strong><small id="fecha_sol"></small>
                            </span>
                            <hr />
                          </div>
                        </div>

                        <div  class="row pad-top-botm client-info">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <p class="text-center" style="border: 1px solid #FF851B" >Solicitante</p>
                            <strong>Nombre: </strong><small id="name_user"></small>
                            <br />
                            <strong>Correo: </strong><small id="correo_user"></small>
                            <br />
                            <strong>Beneficiario: </strong><small id="tipo_beneficiario"></small>
                            <br />
                            <strong>Gerente aprobar: </strong><small id="responsable"></small>
                            <br />
                            <strong>Folio del viaticos: </strong><small id="folio_solicitud"></small>
                            <br />
                            <strong>Estatus de Solicitud: </strong><small id="status_solicitud"></small>
                            <br />
                            <strong>Prioridad de Solicitud: </strong><small id="status_prioridad"></small>
                            <br />
                          </div>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <p class="text-center" style="border: 1px solid #007bff" >Periodo</p>
                            <strong>Fecha de inicio: </strong><small id="fecha_ini"></small>
                            <br />
                            <strong>Fecha de termino:</strong><small id="fecha_fin"></small>
                            <br />
                          </div>
                        </div>

                        <div class="row pad-top-botm client-info">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <p class="text-center" style="border: 1px solid #3D9970" >Conceptos</p>
                            <div class="clearfix">
                              <table id="table_concept" class="table compact-tab table-striped table-bordered table-hover">
                                <thead class="bg-primary">
                                  <tr>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Estatus</th>
                                    <th>Hotel</th>
                                    <th>Justificacion</th>
                                  </tr>
                                </thead>
                                <tbody style="font-size: 10px;">

                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>

                        <div  class="row pad-top-botm client-info">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <strong>Total aprobado: </strong><small id="total_aprob"></small>
                            <br />
                            <strong>Total cargo directo: </strong><small id="total_direct"></small>
                            <br />
                            <strong>Total denegado: </strong><small id="total_denegado"></small>
                            <br />
                          </div>
                        </div>

                        <div class="row pad-top-botm client-info pt-10">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="clearfix">
                              <div id="comentarios" style="width: 100%; min-height: 80px; border:1px solid #ccc;padding:10px;">Descripción:
                                <small id="observaciones_a"></small>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row pad-top-botm client-info pt-10">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="clearfix">
                              <div id="observaciones" style="width: 100%; min-height: 80px; border:1px solid #ccc;padding:10px;">Observaciones o comentarios:
                                <small id="observaciones_b"></small>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row margin-top-large text-center pt-10">
                            <div class="col-md-3 col-xs-3 border-top margin-left-short">
                              <img id="firma_1" name="firma_1" class="img-responsive" src="{{ asset('/images/hotel/Default.svg') }}" width="70%" />
                              <hr>
                              <p id="timeline_a" >{{ trans('pay.no_data') }}</p>
                              <hr>
                              <p style="font-weight: bold;">{{ trans('viatic.aproba_a') }}</p>
                            </div>
                            <div class="col-md-3 col-xs-3 border-top margin-left-short">
                              <img id="firma_2" name="firma_2" class="img-responsive" src="{{ asset('/images/hotel/Default.svg') }}" width="70%"/>
                              <hr>
                              <p id="timeline_b" >{{ trans('pay.no_data') }}</p>
                              <hr>
                              <p style="font-weight: bold;">{{ trans('viatic.aproba_b') }}</p>
                            </div>
                            <div class="col-md-3 col-xs-3 border-top margin-left-short">
                              <img id="firma_3" name="firma_2" class="img-responsive" src="{{ asset('/images/hotel/Default.svg') }}" width="70%"/>
                              <hr>
                              <p id="timeline_c">{{ trans('pay.no_data') }}</p>
                              <hr>
                              <p style="font-weight: bold;">{{ trans('viatic.aproba_c') }}</p>
                            </div>
                            <div class="col-md-3 col-xs-3 border-top margin-left-short">
                              <img id="firma_3" name="firma_2" class="img-responsive" src="{{ asset('/images/hotel/Default.svg') }}" width="70%"/>
                              <hr>
                              <p id="timeline_d">{{ trans('pay.no_data') }}</p>
                              <hr>
                              <p style="font-weight: bold;">{{ trans('viatic.aproba_d') }}</p>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <p><strong>{{ trans('pay.confpay') }}: </strong> <small id="timeline_f">{{ trans('pay.no_data') }}</small></p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <p><strong>{{ trans('viatic.denegada') }}: </strong> <small id="timeline_e">{{ trans('pay.no_data') }}</small></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              @if( auth()->user()->can('Update of concepts assigned to travel expenses') )
              <button type="button" class="no_aprobar_en_gastos btn btn-warning btn-sit"><i class="far fa-edit"></i> Editar conceptos</button>
              @endif
              <button type="button" class="no_aprobar_en_gastos btn btn-primary btn-export"><i class="fa fa-save"></i> Exportar PDF</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="modal-antenas-sitio" tabindex="-1" role="dialog" aria-labelledby="modal-antenas-sitioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="modal-antenas-sitioLabel"></h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                <table id="tabla_antenas" class="table table-bordered  table-striped table-hover display compact-tab" style="width: 100%">
                  <thead>
                    <tr class="bg-aqua text-center">
                      <th> <small>Modelo</small> </th>
                      <th> <small>Mac</small> </th>
                      <th > <small>Serie</small> </th>
                      <th > <small>Estado</small> </th>
                      <th > <small>Fecha Registro</small> </th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                  </tbody>
                  <tfoot >
                    <tr >
                      <th></th>
                      <th></th>
                      <th></th>
                      <th ></th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="text-center">
                <label id="label_totales" style="font-weight: bold;"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- EndModal -->

      <div class="modal fade" id="modal-view-presupuesto">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <!-- Contenido de modal. -->
              <input type="hidden" id="id_annex" name="id_annex">

                <div class="table-responsive">
                  <div class="row fields_docm">
                    <div class="col-md-12">
                      <div class="form-group">
                        <h4 class="text-center text-danger">Presupuesto Anual</h4>
                        <h5 class="text-center text-default">* Montos en USD</h5>
                        <br>
                        <div id="presupuesto_anual">

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

            </div>
            <div class="modal-footer">
              <div class="row ">
                <div class="col-sm-12">
                  <button type="button" class="btn btn-default closeModal pull-right" data-dismiss="modal">Close</button>
                </div>
                <!-- <div class="col-sm-3">
                  <button type="submit" class="btn btn-warning pull-right">Save changes</button>
                </div> -->
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="tab_wrapper first_tab d-none">
          <ul class="tab_list">
              <li class="active"><i class="fas fa-user-circle"></i> General</li>
              <!--<li><i class="fas fa-file-contract"></i> Contratos</li>-->
              <li><i class="fas fa-tachometer-alt"></i> NPS</li>
              <!--<li><i class="fas fa-box-open"></i> Equipos</li>-->
              <li><i class="fas fa-clipboard-list"></i> Tickets</li>
              <!--<li><i class="fas fa-funnel-dollar"></i> Presupuesto</li>-->
              <li><i class="fas fa-hand-holding-usd"></i></i> Viáticos</li>
              <li><i class="fas fa-file-contract"></i></i> Proyectos</li>
              <!--<li id="tab_consumo"><i class="fas fa-chart-bar"></i></i> Estadísticas de consumo</li>-->
          </ul>
          <div class="content_wrapper">
              <div class="tab_content active">
                  <div class="row">
                    <div class="d-inline text-center col-xl-1 mb-1">
                      <img id="imagenCliente" style="width: 70px; height: 100px; border: 1px solid black;" alt="Sin foto">
                    </div>
                    <div class="d-inline text-center table-responsive col-xl-8 my-auto">
                      <table border="1" cellpadding="3" style="text-align: center; display: inline;">
                        <thead class="bg-dark text-white">
                          <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Sitios</th>
                            <th>AP's</th>
                            <th>Facturación</th>
                            <th>NPS Promedio</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th><span id="nombreITC">XXX</span></th>
                            <th><span id="correoITC">XXX</span></th>
                            <th><span id="total_sitios">0</span></th>
                            <th><a href="javascript:void(0);" id="total_antenas">0</a></th>
                            <th><span id="total_faturacion">0</span></th>
                            <th><span id="npsPromedio">0</span></th>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="d-inline text-center col-xl-3 w-100 my-auto">
                      <select class="form-control w-100" style="color: black; font-weight: bold; border: 1px solid lightgray;">
                        <option value="12">Últimos 12 meses</option>
                        <option value="6">Últimos 6 meses</option>
                        <option value="3">Últimos 3 meses</option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                      </select>
                    </div>
                  </div>
                  <div id="gral_sitios" class="row">
                    <div class="table-responsive">
                      <table id="info_sitios" class="table table-bordered  table-striped table-hover display compact-tab" style="width: 100%;">
                        <thead>
                          <tr class="bg-secondary text-center">
                            <th>Sitios</th>
                            <th>Antenas</th>
                            <th>Facturación</th>
                            <th id="NPS1">1</th>
                            <th id="NPS2">2</th>
                            <th id="NPS3">3</th>
                            <th id="NPS4">4</th>
                            <th id="NPS5">5</th>
                            <th id="NPS6">6</th>
                            <th id="NPS7">7</th>
                            <th id="NPS8">8</th>
                            <th id="NPS9">9</th>
                            <th id="NPS10">10</th>
                            <th id="NPS11">11</th>
                            <th id="NPS12">12</th>
                            <th>Prom.</th>
                          </tr>
                        </thead>
                        <tbody class="text-center" style="font-weight: bold;">
                        </tbody>
                        <tfoot class="text-center">
                          <tr>
                            <td><span id="footer_total_sitios">0</span></td>
                            <td><a href="javascript:void(0);" id="footer_total_antenas">0</a></td>
                            <td><span id="footer_total_facturacion">0</span></td>
                            <td id="MES1"></td>
                            <td id="MES2"></td>
                            <td id="MES3"></td>
                            <td id="MES4"></td>
                            <td id="MES5"></td>
                            <td id="MES6"></td>
                            <td id="MES7"></td>
                            <td id="MES8"></td>
                            <td id="MES9"></td>
                            <td id="MES10"></td>
                            <td id="MES11"></td>
                            <td id="MES12"></td>
                            <td><span id="footer_npsPromedio">0</span></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                  <div class="row">
                      <div class="d-flex justify-content-center w-100 col-sm-6 col-md-6">
                        <div id="graph_calificaciones_x_mes"> </div>
                      </div>
                      <div class="d-flex justify-content-center w-100 col-sm-6 col-md-6">
                        <div id="graph_viaticos_x_mes"> </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="d-flex justify-content-center w-100 col-sm-6 col-md-6">
                        <div id="graph_doc_p"> </div>
                      </div>
                      <div class="d-flex justify-content-center w-100 col-sm-6 col-md-6">
                        <div id="graph_doc_m"> </div>
                      </div>
                  </div>
              </div>
              <div class="tab_content">
                <section>
                <div class="row">
                  <div class="col-md-12">
                    <div class="w-100 text-center">
                      <h3 style="font-weight: bold;">NPS Anual</h3>
                    </div>
                  </div>
                </div>

                  <div class="row">
                    <div class="col-md-4 col-xs-12"></div>
                  <div class="col-md-4 col-xs-12 mb-3">
                    <div class="input-group  flex-nowrap">
                      <div class="input-group-prepend">
                        <span class="input-group-text fa fa-calendar" id="addon-wrapping"></span>
                      </div>
                      <input id="date_to_search" type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2">
                      <div class="input-group-append">
                        <button class="btn btn-outline-info filtrarDashboard" type="button" id="boton-aplica-filtro">Filtrar</button>
                      </div>
                    </div>
                </div>
                </div>
                  <div class="row">
                    <!--<div class="col-md-3">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="card" id="box_total_survey" style="cursor: pointer;">
                            <div class="card-body">
                              <div class="ml-sm-3 ml-md-0 ml-xl-0 mt-2 mt-sm-0 mt-md-2 mt-xl-0 text-center">
                                <h4 id="total_survey" class="mb-2 text-primary font-weight-bold">194</h4>
                								<h6 class="mb-0">Total de encuestas</h6>
                							</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="card" id="box_response" style="cursor: pointer;">
                            <div class="card-body">
                              <div class="ml-sm-3 ml-md-0 ml-xl-0 mt-2 mt-sm-0 mt-md-2 mt-xl-0 text-center">
                                <h4 id="answered" class="mb-2 text-success font-weight-bold">110</h4>
                								<h6 class="mb-0">Respondieron</h6>
                							</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>-->

                    <div class="col-md-8 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body .npscontainer container-fluid"  style="width: 100%;">
                          <h4 class="card-title">NPS chart</h4>
                          <div class="d-flex justify-content-center  border-bottom w-100">
                            <div id="main_nps_hotel" style="width: 100%; min-height: 320px; "></div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="card" id="box_promotores" style="cursor: pointer;">
                            <div class="card-body">
                              <div class="d-xl-flex  align-items-center justify-content-center p-0 item">
                                <i class="mdi mdi-emoticon icon-lg mr-3 color-green"></i>
                                <div class="d-flex flex-column justify-content-around">
                                  <small class="mb-1 text-muted font-weight-bold">Promotores</small>
                                  <h6 id="total_promotores" class="mr-2 mb-0">0</h6>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="card" id="box_pasivos" style="cursor: pointer;">
                            <div class="card-body">
                              <div class="d-xl-flex  align-items-center justify-content-center p-0 item">
                                <i class="mdi mdi-emoticon-neutral icon-lg mr-3 color-yellow"></i>
                                <div class="d-flex flex-column justify-content-around">
                                  <small class="mb-1 text-muted font-weight-bold">Pasivos</small>
                                  <h6 id="total_pasivos" class="mr-2 mb-0">0</h6>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="card" id="box_detractores" style="cursor: pointer;">
                            <div class="card-body">
                              <div class="d-xl-flex align-items-center justify-content-center p-0 item">
                                <i class="mdi mdi-emoticon-sad icon-lg mr-3 color-red"></i>
                                <div class="d-flex flex-column justify-content-around">
                                  <small class="mb-1 text-muted font-weight-bold">Detractores</small>
                                  <h6 id="total_detractores" class="mr-2 mb-0">0</h6>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="card" id="box_sin_response" style="cursor: pointer;">
                            <div class="card-body">
                              <div class="ml-sm-3 ml-md-0 ml-xl-0 mt-2 mt-sm-0 mt-md-2 mt-xl-0 text-center">
                                <h4 id="unanswered" class="mb-2 text-danger font-weight-bold">0</h4>
                                <h6 class="mb-0">Sin respuesta</h6>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>


                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <h3>Última encuesta</h3>
                      <div class="table-responsive">
                      <table id="nps_comments" class="table table-bordered  table-striped table-hover display compact-tab" style="width: 100%">
                        <thead>
                          <tr class="bg-aqua text-center">
                            <th class="bg-aqua"> <small>Itc</small> </th>
                            <th class="bg-aqua"> <small>Sitio</small> </th>
                            <th class="bg-aqua"> <small>Calificacion</small> </th>
                            <th class="bg-aqua"> <small>Cliente</small> </th>
                            <th class="bg-aqua"> <small>Comentario</small> </th>
                            <th class="bg-aqua"> <small>Fecha</small> </th>
                          </tr>
                        </thead>
                        <tbody class="text-center">
                        </tbody>
                        <tfoot >
                          <tr >
                            <th></th>
                            <th></th>
                            <th ></th>
                            <th></th>
                            <th></th>
                            <th ></th>
                          </tr>
                        </tfoot>
                      </table>
                      </div>
                    </div>
                  </div>
                  </section>
              </div>

              <div class="tab_content">
                <div class="text-center">
                  <h3 style="font-weight:bold;" >Todos los tickets </h3>
                </div>
                <div class="row">
                  <div class="col-sm-1 col-md-1"></div>
                <div class="d-flex justify-content-center border-bottom w-100 col-sm-5 col-md-5">
                  <div  id="graph_type_tickets" style="min-height: 300px;left: 0px;right: 0px;"> </div>
                </div>
                <div class="d-flex justify-content-center border-bottom w-40 col-sm-5 col-md-5">
                  <div id="graph_status_tickets"class=""></div>
                </div>
                <div class="col-sm-1 col-md-1"></div>
                </div>
                <div class="row mt-1">
                  <div class="col-md-12 table-responsive divEQ">
                  <table id="table_tickets_itc" name='table_tickets_itc' class="display nowrap table table-bordered table-hover compact-tab w-100" cellspacing="0">
                    <thead>
                        <tr class="bg-aqua text-center" style="color: white">
                            <!--<th> <small>Sitio</small> </th>-->
                            <th class="bg-aqua"> <small>No.Ticket</small> </th>
                            <th class="bg-aqua"> <small>Tipo</small> </th>
                            <th class="bg-aqua"> <small>Asunto</small> </th>
                            <!--<th> <small>Descripcion</small> </th>-->
                            <th class="bg-aqua"> <small>Estatus</small> </th>
                            <th class="bg-aqua"> <small>Prioridad</small> </th>
                            <th class="bg-aqua"> <small>Canal</small> </th>
                            <th id="#tickets_satisfac"class="bg-aqua"> <small>Nivel de satisfacción</small> </th>
                            <th class="bg-aqua"> <small>Cliente</small> </th>
                            <th class="bg-aqua"> <small>Fecha Solicitud</small> </th>
                            <th class="bg-aqua"> <small>Atendió</small> </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>
              <div class="tab_content">
                  <!--<h3 style="font-weight: bold; margin-left: 45%;">Pagos</h3>
                  <div class="row">
                    <div class="col-md-1"></div>
                    <div class="d-flex justify-content-center border-bottom w-100 col-md-5">
                      <div id="graph_payments1" style="min-height: 300px;left: 0px;right: 0px;"> </div>
                    </div>
                    <div class="d-flex justify-content-center border-bottom w-100 col-md-5">
                      <div id="graph_payments2" style="min-height: 300px;left: 0px;right: 0px;"> </div>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
                  <div class="table-responsive">
                    <table id="table_pays" class="table table-striped table-bordered table-hover text-white compact-tab" style="width:100%">
                      <thead>
                        <tr class="bg-aqua text-center" style="background: #088A68;">
                          <th class="bg-aqua"> <small>Factura</small> </th>
                          <th class="bg-aqua"> <small>Proveedor</small> </th>
                          <th class="bg-aqua"> <small>Estatus</small> </th>
                          <th class="bg-aqua"> <small>Monto</small> </th>
                          <th class="bg-aqua"> <small>Elaboró</small> </th>
                          <th class="bg-aqua"> <small>Fecha solicitud</small> </th>
                          <th class="bg-aqua"> <small>Fecha límite pago</small> </th>
                          <th class="bg-aqua"> <small>Cuenta</small> </th>
                          <th class="bg-aqua"> <small>Nombre cuenta</small> </th>
                          <th class="bg-aqua"> <small>Conceptos</small> </th>
                        </tr>
                      </thead>
                      <tbody class="text-center">
                      </tbody>
                      <tfoot id='tfoot_average'>
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </tfoot>
                    </table>
                </div>
                <br>-->
                <div class="text-center">
                  <h3 style="font-weight:bold;" >Todos los viáticos </h3>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="badge rounded badge-dark text-white font-weight-bold w-80" style="font-size: 1.2em;">
                      Total: <span id="total_viatic" class="badge rounded badge-light font-weight-bolder" style="font-size: 0.9em;">0</span>
                    </div>
                  </div>
                  <div class="col-md-9">

                  </div>
                </div>
                <div class="d-flex justify-content-center border-bottom w-100">
                  <div id="graph_viatics" style="min-height: 300px;left: 0px;right: 0px;"> </div>
                </div>
                <div class="table-responsive">
                  <table id="table_viatics" class="table table-striped table-bordered table-hover compact-tab w-100">
                    <thead>
                      <tr class="bg-aqua text-center">
                        <th class="bg-aqua"> <small>Folio</small> </th>
                        <th class="bg-aqua"> <small>Servicio</small> </th>
                        <th class="bg-aqua"> <small>Fecha Inicio</small> </th>
                        <th class="bg-aqua"> <small>Fecha Fin</small> </th>
                        <th class="bg-aqua"> <small>Monto Solicitado</small> </th>
                        <th class="bg-aqua"> <small>Monto Aprobado</small> </th>
                        <th class="bg-aqua"> <small>Estatus</small> </th>
                        <th class="bg-aqua"> <small>Usuario</small> </th>
                        <th class="bg-aqua"> <small></small> </th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                    <tfoot id='tfoot_average'>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
  <div class="tab_content">
    <div class="text-center">
      <h3 style="font-weight:bold;" >Todos los documentos</h3>
    </div>
    <hr>
    <div class="row">
        <!--<div class="col-md-2 mb-3">
            <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Doc P</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Doc M</a>
                </li>
                <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
          </li>-
            </ul>
        </div>-->
        <!-- /.col-md-4 -->
        <div class="col-md-12">
            <div class="tab-content" id="myTabContent">
              <div class="row"></div>
                <div class="" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h2>Documento P</h2>
                    <div class="row">
                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fa fa-usd text-success" aria-hidden="true"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default">Total Autorizado USD</p>
                                <h4><strong>$<span id="total_auth_p"></span></strong></h4>
                            </div>
                        </div>

                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fa fa-hashtag text-danger" aria-hidden="true"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default">Total</p>
                                <h4><strong><span id="total_sol_p"></span></strong></h4>
                            </div>
                        </div>

                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fas fa-check-square text-success"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default">Autorizado</p>
                                <h4><strong><span id="autorizado_p"></span></strong></h4>
                            </div>
                        </div>

                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fa fa-paper-plane text-primary" aria-hidden="true"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default">Entregado</p>
                                <h4><strong><span id="entregado_p"></span></strong></h4>
                            </div>
                        </div>
                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fa fa-eye text-warning" aria-hidden="true"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default">Revisado</p>
                                <h4><strong><span id="revisado_p"></span></strong></h4>
                            </div>
                        </div>

                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fa fa-plus-square text-info" aria-hidden="true"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default"> Nuevos </p>
                                <h4><strong><span id="nuevo_p"></span></strong></h4>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="d-flex justify-content-center border-bottom w-40 col-sm-5 col-md-5">

                </div>
                <hr>
                <div class="" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h2>Documento M</h2>
                    <div class="row">
                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fa fa-usd text-success" aria-hidden="true"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default">Total Autorizado USD</p>
                                <h4><strong>$<span id="total_auth_m"></span></strong></h4>
                            </div>
                        </div>

                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fa fa-hashtag text-danger" aria-hidden="true"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default">Total</p>
                                <h4><strong><span id="total_sol_m"></span></strong></h4>
                            </div>
                        </div>

                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fas fa-check-square text-success"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default">Autorizado</p>
                                <h4><strong><span id="autorizado_m"></span></strong></h4>
                            </div>
                        </div>

                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fa fa-paper-plane text-primary" aria-hidden="true"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default">Entregado</p>
                                <h4><strong><span id="entregado_m"></span></strong></h4>
                            </div>
                        </div>
                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fa fa-eye text-warning" aria-hidden="true"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default">Revisado</p>
                                <h4><strong><span id="revisado_m"></span></strong></h4>
                            </div>
                        </div>

                        <div class="container-box col-md-2">
                            <div class="icon_head_dash">
                                <i class="fa fa-plus-square text-info" aria-hidden="true"></i>
                            </div>
                            <div class="info_head_dash">
                                <p class="text-default"> Nuevos </p>
                                <h4><strong><span id="nuevo_m"></span></strong></h4>
                            </div>
                        </div>

                    </div>
                </div>
                <!--<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
  <h2>Contact</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>

  </div>-->
            </div>
        </div>
        <!-- /.col-md-8 -->
    </div>

              </div>
          </div>
      </div>
      <div style="margin-left: 40%;">
        <img id="cargando" class="d-none" src="/images/loading.gif" alt="...">
      </div>

      @include('permitted.payments.modal_payment')

    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View dash sabana') )

    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript" src="js/jquery.multipurpose_tabcontent.js"></script>
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    <script src="{{ asset('js/admin/viaticos/requests_viaticos_modal.js?v=2.0.0')}}"></script>
    <script src="{{ asset('js/admin/payments/request_modal_payment.js')}}"></script>
    <script src="{{ asset('bower_components/highcharts/highcharts.js')}}"></script>
    <script src="{{ asset('bower_components/highcharts/series-label.js')}}"></script>
    <script src="{{ asset('bower_components/highcharts/exporting.js')}}"></script>
    <script src="{{ asset('js/admin/sabana/sabana_itc.js?v=4.3.6')}}"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <style media="screen">
    .tableFixHead          { overflow-y: auto; height: 620px; }
    .tableFixHead thead th { position: sticky !important; top: 0; }
    .bg-aqua{
    background: #1776D2;
    }
    .color-green{ color:#0fe81e;}
    .color-red{ color:#f0120a;}
    .color-yellow{ color:#f6a60a;}

    .icon_head_dash i{
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 5px;
      font-size: 2em;
    }

    .info_head_dash{
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 5px;
      text-align: center;
    }

    .container-box div{
      display: inline-block;
    }

    .container-box{
      margin-top: 1em;
      display: flex;
      justify-content: center;
      align-items: center;
      border-right: 1px solid #eee;
    }
    </style>
  @else
    <!--NO SCRIPTS-->
  @endif
@endpush
