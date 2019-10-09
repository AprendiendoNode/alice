@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View requests via') )
    {{ trans('message.viaticos_history_request') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View requests via') )
    {{ trans('message.breadcrumb_viaticos_hist') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View requests via') )
      <div class="modal modal-default fade" id="modal-view-concept" data-backdrop="static">
        <div class="modal-dialog modal-lg"  style="width:45%" >
          <div class="modal-content">
            <div class="modal-header">

              <h4 class="modal-title"><i class="fas fa-id-card" style="margin-right: 4px;"></i>Lista de conceptos</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <div class="card-body table-responsive">
                <div class="card-body">
                  <div class="row">
                    <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                    <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                      <div class="hojitha"   style="background-color: #fff; /*border:1px solid #ccc;*/ border-bottom-style:hidden; padding:10px; padding-top: 0px; width: 95%">
                        <div class="row pad-top-botm ">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <h2> <small>Solicitud de viáticos</small></h2>
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
                    <!--        <br />
                            <strong>Beneficiario: </strong><small id="tipo_beneficiario"></small>-->
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
                              <table id="table_concept" class="table table-striped table-bordered table-hover">
                                <thead>
                                  <tr>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Estatus</th>
                                    <th>Sitio</th>
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
                              <img id="firma_1" name="firma_1" class="img-responsive" src="{{ asset('/images/hotel/Default.svg') }}"  width="70%" />
                              <hr>
                              <p id="timeline_a" >{{ trans('pay.no_data') }}</p>
                              <hr>
                              <p style="font-weight: bold;">{{ trans('viatic.aproba_a') }}</p>
                            </div>
                            <div class="col-md-3 col-xs-3 border-top margin-left-short">
                              <img id="firma_2" name="firma_2" class="img-responsive" src="{{ asset('/images/hotel/Default.svg') }}"  width="70%"/>
                              <hr>
                              <p id="timeline_b" >{{ trans('pay.no_data') }}</p>
                              <hr>
                              <p style="font-weight: bold;">{{ trans('viatic.aproba_b') }}</p>
                            </div>
                            <div class="col-md-3 col-xs-3 border-top margin-left-short">
                              <img id="firma_3" name="firma_2" class="img-responsive" src="{{ asset('/images/hotel/Default.svg') }}" width="70%" />
                              <hr>
                              <p id="timeline_c">{{ trans('pay.no_data') }}</p>
                              <hr>
                              <p style="font-weight: bold;">{{ trans('viatic.aproba_c') }}</p>
                            </div>
                            <div class="col-md-3 col-xs-3 border-top margin-left-short">
                              <img id="firma_3" name="firma_2" class="img-responsive" src="{{ asset('/images/hotel/Default.svg') }}"  width="70%"/>
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
            <div class="row" style="display: none;">
              <input id="id_viatic" name="id_viatic" value="">
            </div>
            <div class="modal-footer">
              <button type="button" id="dny_viatic" class="btn btn-danger"><i class="fa fa-ban"></i> Denegar</button>
              <button type="button" id="aprv_viatic" class="btn bg-navy"><i class="fa fa-check margin-r5"></i> Aprobar</button>

              <button type="button" id="prev_btn" class="btn bg-olive disabled"><i class="fa fa-arrow-left"></i> Previous</button>
              <button type="button" id="next_btn" class="btn bg-navy disabled"><i class="fa fa-arrow-right"></i> Next</button>

              <button type="button" class="btn btn-primary btn-export"><i class="fa fa-save"></i> Exportar PDF</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
            </div>
          </div>
        </div>
      </div>

      @if( auth()->user()->can('View level zero notifications') )
        <div class="container">
          <div class="card">
            <div class="card-body">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mb-2">
              <div class="row">
                <form id="search_info" name="search_info" class="form-inline" method="post">
                  {{ csrf_field() }}
                  <div class="col-md-4 col-sm-2">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="far fa-calendar-alt fa-3x"></i></span>
                      <input id="date_to_search" type="text" class="form-control" name="date_to_search" >
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-10">
                    <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                      <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
              <div class="table-responsive">
                <table id="table_viatics" class="table table-striped table-bordered table-hover compact-tab w-100">
                  <thead>
                    <tr class="bg-primary" >
                      <th> <small>Folio</small> </th>
                      <th> <small>Servicio</small> </th>
                      <th> <small>Fecha Inicio</small> </th>
                      <th> <small>Fecha Fin</small> </th>
                      <th> <small>Monto Solicitado</small> </th>
                      <th> <small>Monto Aprobado</small> </th>
                      <th> <small>Estatus</small> </th>
                      <th> <small>Prioridad</small> </th>
                      <th> <small>Conceptos</small> </th>
                    </tr>
                  </thead>
                  <tbody>
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
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
        </div>
      @elseif ( auth()->user()->can('View level one notifications') )
        <div class="modal modal-default fade" id="modal-view-concept-approve" data-backdrop="static">
            <div class="modal-dialog">
              <div class="modal-content" style="width: 70vw !important; margin-left: -15vw !important;">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-id-card" style="margin-right: 4px;"></i>Aprobar conceptos</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body table-responsive">
                  <div class="card-body">
                    <div class="card-body">
                      <div class="row">
                          <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                          <table id="tableconcept" class="table table-striped table-bordered table-hover compact-tab">
                            <thead class="bg-primary">
                              <tr style="background: #0A2B49;">
                                <th> <small>id</small> </th>
                                <th> <small>Cadena</small> </th>
                                <th> <small>Sitio</small> </th>
                                <th> <small>Concepto</small> </th>
                                <th> <small>Cantidad</small> </th>
                                <th> <small>V. Unitario</small> </th>
                                <th> <small>V. Solicitado</small> </th>
                                <th> <small>Estatus</small> </th>
                                <th> <small>Justificación</small> </th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot id='tfoot_average'>

                            </tfoot>
                          </table>
                          <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                      </div>
                      <!--  <div class="row">
                        <input id="id_viatic" type="hidden" name="id_viatic" value="">
                        <div class="form-group">
                          <label for="">Observaciones</label>
                          <textarea class="form-control" id="observation" name="observation" rows="4" disabled></textarea>
                        </div>
                      </div> -->
                    </div>
                  </div>
                </div>
                <div id="dyn_ids">

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary btn-save-concept"><i class="fa fa-save"></i> Guardar cambios</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </div>
              </div>
            </div>
        </div>
        <div class="modal modal-default fade" id="modal-view-deny" data-backdrop="static">
            <div class="modal-dialog" >
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-id-card" style="margin-right: 4px;"></i>DENEGAR SOLICITUD.</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="card-body table-responsive">
                <div class="card-body">
                  <div class="row">
                    <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                      <div class="row pad-top-botm client-info">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <p class="text-center" style="border: 1px solid #3D9970" >DENEGAR.</p>
                          <div class="clearfix">
                            <input id="hidden_viatic" hidden></input>
                            <textarea id="comment_deny" class="form-control" style="resize: vertical;" placeholder="Comentario."></textarea>
                          </div>
                        </div>
                      </div>
                      </div>
                  </div>
                </div>
              </div>
                <div class="modal-footer">
                  <!-- <button type="button" class="btn btn-primary btn-export"><i class="fa fa-save"></i> Exportar PDF</button> -->
                  <button type="button" class="btn btn-danger" id="deny_request_v"><i class="fa fa-trash" style="margin-right: 4px;"></i>Denegar</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </div>
              </div>
            </div>
        </div>

        <div class="container">
          <div class="card">
            <div class="card-body">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mb-2">
              <div class="row">
                <form id="search_info" name="search_info" class="form-inline" method="post">
                  {{ csrf_field() }}
                  <div class="col-md-4 col-sm-2">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="far fa-calendar-alt fa-3x"></i></span>
                      <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-10">
                    <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                      <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
              <div class="table-responsive">
                <table id="table_viatics" class="table table-striped table-bordered table-hover compact-tab"  style="width:100%">
                  <thead>
                    <tr class="bg-primary" >
                      <th> <small></small> </th>
                      <th> <small>Folio</small> </th>
                      <th> <small>Servicio</small> </th>
                      <th> <small>Fecha Inicio</small> </th>
                      <th> <small>Fecha Fin</small> </th>
                      <th> <small>Monto Solicitado</small> </th>
                      <th> <small>Monto Aprobado</small> </th>
                      <th> <small>Estatus</small> </th>
                      <th> <small>Prioridad</small> </th>
                      <th> <small>Usuario</small> </th>
                      <th> <small></small> </th>
                      <th> <small>status</small> </th>
                    </tr>
                  </thead>
                  <tbody>
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
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
        </div>
      @elseif ( auth()->user()->can('View level two notifications') )
        <div class="modal modal-default fade" id="modal-view-deny" data-backdrop="static">
            <div class="modal-dialog" >
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-id-card" style="margin-right: 4px;"></i>DENEGAR SOLICITUD.</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="card-body table-responsive">
                <div class="card-body">
                  <div class="row">
                    <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                      <div class="row pad-top-botm client-info">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <p class="text-center" style="border: 1px solid #3D9970" >DENEGAR.</p>
                          <div class="clearfix">
                            <input id="hidden_viatic" hidden></input>
                            <textarea id="comment_deny" class="form-control" style="resize: vertical;" placeholder="Comentario."></textarea>
                          </div>
                        </div>
                      </div>
                      </div>
                  </div>
                </div>
              </div>
                <div class="modal-footer">
                  <!-- <button type="button" class="btn btn-primary btn-export"><i class="fa fa-save"></i> Exportar PDF</button> -->
                  <button type="button" class="btn btn-danger" id="deny_request_v"><i class="fa fa-trash" style="margin-right: 4px;"></i>Denegar</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </div>
              </div>
            </div>
        </div>

        <div class="container">
          <div class="card">
            <div class="card-body">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mb-2">
              <div class="row">
                <form id="search_info" name="search_info" class="form-inline" method="post">
                  {{ csrf_field() }}
                  <div class=" col-md-4 col-sm-2">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="far fa-calendar-alt fa-3x"></i></span>
                      <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-10">
                    <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                      <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
              <div class="table-responsive">
                <table id="table_viatics" class="table table-striped table-bordered table-hover compact-tab" style="width:100%" >
                  <thead>
                    <tr class="bg-primary">
                      <th> <small></small> </th>
                      <th> <small>Folio</small> </th>
                      <th> <small>Servicio</small> </th>
                      <th> <small>Fecha Inicio</small> </th>
                      <th> <small>Fecha Fin</small> </th>
                      <th> <small>Monto Solicitado</small> </th>
                      <th> <small>Monto Aprobado</small> </th>
                      <th> <small>Estatus</small> </th>
                      <th> <small>Prioridad</small> </th>
                      <th> <small>Usuario</small> </th>
                      <th> <small></small> </th>
                      <th> <small>status</small> </th>
                    </tr>
                  </thead>
                  <tbody>
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
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
        </div>
      @elseif ( auth()->user()->can('View level three notifications') )
        <div class="modal modal-default fade" id="modal-view-deny" data-backdrop="static">
            <div class="modal-dialog" >
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-id-card" style="margin-right: 4px;"></i>DENEGAR SOLICITUD.</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="card-body table-responsive">
                <div class="card-body">
                  <div class="row">
                    <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                      <div class="row pad-top-botm client-info">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <p class="text-center" style="border: 1px solid #3D9970" >DENEGAR.</p>
                          <div class="clearfix">
                            <input id="hidden_viatic" hidden></input>
                            <textarea id="comment_deny" class="form-control" style="resize: vertical;" placeholder="Comentario."></textarea>
                          </div>
                        </div>
                      </div>
                      </div>
                  </div>
                </div>
              </div>
                <div class="modal-footer">
                  <!-- <button type="button" class="btn btn-primary btn-export"><i class="fa fa-save"></i> Exportar PDF</button> -->
                  <button type="button" class="btn btn-danger" id="deny_request_v"><i class="fa fa-trash" style="margin-right: 4px;"></i>Denegar</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </div>
              </div>
            </div>
        </div>

        <div class="container">
          <div class="card">
            <div class="card-body">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mb-2">
              <div class="row">
                <form id="search_info" name="search_info" class="form-inline" method="post">
                  {{ csrf_field() }}
                  <div class="col-md-4 col-sm-2">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="far fa-calendar-alt fa-3x"></i></span>
                      <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-10">
                    <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                      <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>

            <div class="row" >
            <div  class="container-fluid">
              <div class="table-responsive">
                <table id="table_viatics" class="table table-sm table-striped table-bordered table-hover compact-tab" style="width:100%">
                  <thead  >
                    <tr class="bg-primary" class="overflow-text" >
                      <th class="overflow-text"> <small></small> </th>
                      <th class="overflow-text"> <small>Folio</small> </th>
                      <th  class="overflow-text"> <small>Servicio</small> </th>
                      <th class="overflow-text"> <small>Fecha Inicio</small> </th>
                      <th class="overflow-text"> <small>Fecha Fin</small> </th>
                      <th class="overflow-text"> <small >Monto Solicitado</small> </th>
                      <th class="overflow-text"> <small>Monto Aprobado</small> </th>
                      <th class="overflow-text"> <small>Estatus</small> </th>
                      <th class="overflow-text"> <small>Prioridad</small> </th>
                      <th class="overflow-text"> <small>Usuario</small> </th>
                      <th class="overflow-text"> <small>Opciones</small> </th>
                      <th class="overflow-text"> <small>status</small> </th>
                    </tr>
                  </thead>
                  <tbody >
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
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
      @elseif ( auth()->user()->can('View level four notifications') )
        <div class="container">
          <div class="card">
            <div class="card-body">
          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mb-2">
              <div class="row">
                <form id="search_info" name="search_info" class="form-inline" method="post">
                  {{ csrf_field() }}
                  <div class="col-md-4 col-sm-2">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="far fa-calendar-alt fa-3x"></i></span>
                      <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-10">
                    <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                      <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <div class="row" >
            <div  class="container-fluid">
              <div class="table-responsive">
                <table id="table_viatics" class="table table-sm table-striped table-bordered table-hover w-100" style="width:100% !important;">
                  <thead  >
                    <tr class="bg-primary"class="overflow-text text-white" >
                      <th class="overflow-text text-white" > <small></small> </th>
                      <th class="overflow-text text-white"> <small>Folio</small> </th>
                      <th  class="overflow-text text-white"> <small>Servicio</small> </th>
                      <th class="overflow-text text-white" > <small>Fecha Inicio</small> </th>
                      <th class="overflow-text text-white"> <small>Fecha Fin</small> </th>
                      <th class="overflow-text text-white"> <small >Monto Solicitado</small> </th>
                      <th class="overflow-text text-white"> <small>Monto Aprobado</small> </th>
                      <th class="overflow-text text-white"> <small>Estatus</small> </th>
                      <th class="overflow-text text-white"> <small>Prioridad</small> </th>
                      <th class="overflow-text text-white"> <small>Usuario</small> </th>
                      <th class="overflow-text text-white"> <small>Opciones</small> </th>
                      <th class="overflow-text text-white"> <small>status</small> </th>
                    </tr>
                  </thead>
                  <tbody >
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
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
        </div>
      @endif
    @else
    @endif
@endsection

@push('scripts')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pdf2.css')}}" >
    <style media="screen">
      .pt-10 {
        padding-top: 10px;
      }
      .overflow-text{
        width: auto !important;
        white-space: pre-wrap !important;
      }
      #table_viatics tbody tr td{
        table-layout: fixed;
        width: auto !important;
        white-space: pre-wrap !important;
        padding:0; margin:0;
      }
      .fix-table tbody tr td{
        table-layout: fixed;
        width: auto !important;
        white-space: pre-wrap !important;
        padding:0; margin:0;
      }
      .fix-columns{
        padding:0; margin:0;
      }
      #table_concept tbody tr td{
        table-layout: fixed;
        width: auto !important;
        white-space: pre-wrap !important;
      }
      .col-med{
        max-width: 200px;
      }
      .modal-content{
        width: 120% !important;
        margin-left: -10% !important;
      }
    </style>
    @if( auth()->user()->can('View requests via') )
      <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
      <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
      <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
      <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
      <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
      <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
      <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>

      <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
      <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>


      @if( auth()->user()->can('View level zero notifications'))
      <script src="{{ asset('js/admin/viaticos/requests_viaticos_modal.js?v=2.0.0')}}"></script>
      <script src="{{ asset('js/admin/viaticos/requests_viaticos_0.js?v=2.0.0')}}"></script>
      @elseif(auth()->user()->can('View level one notifications'))
      <script src="{{ asset('js/admin/viaticos/requests_viaticos_modal_2.js?v=2.0.0')}}"></script>
      <script src="{{ asset('js/admin/viaticos/requests_viaticos_1.js?v=2.0.0')}}"></script>
      @elseif(auth()->user()->can('View level two notifications'))
      <script src="{{ asset('js/admin/viaticos/requests_viaticos_modal.js?v=2.0.0')}}"></script>
      <script src="{{ asset('js/admin/viaticos/requests_viaticos_2.js?v=2.0.0')}}"></script>
      @elseif(auth()->user()->can('View level three notifications'))
      <script src="{{ asset('js/admin/viaticos/requests_viaticos_modal.js?v=2.0.0')}}"></script>
      <script src="{{ asset('js/admin/viaticos/requests_viaticos_3.js?v=2.0.0')}}"></script>
      @elseif(auth()->user()->can('View level four notifications'))
      <script src="{{ asset('js/admin/viaticos/requests_viaticos_modal.js?v=2.0.0')}}"></script>
      <script src="{{ asset('js/admin/viaticos/requests_viaticos_4.js?v=2.0.0')}}"></script>
    @endif
    @else
      <!--NO VER -->
    @endif
@endpush
