@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View info my ticket') )
    {{ trans('message.title_myticket') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View info my ticket') )
    {{ trans('message.title_myticket') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    <div class="modal modal-default fade" id="modal-view-info-ticket" data-backdrop="static">
      <div class="modal-dialog" style="max-width: 55%!important;">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-envelope" style="margin-right: 4px;"></i>Read Ticket</h4>
            <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="box-body table-responsive">
              <div class="box-body">
                <div class="row">
                  <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                  <div class="col-md-12">
                      <!-- /.box-header -->
                      <div class="box-body no-padding">
                        <form class="form-horizontal" id="update_myticket" name="update_myticket" >
                          {{ csrf_field() }}
                          <div class="row">
                            <input type="hidden" id="id_ticket" name="id_ticket">
                            <h4 style="padding-left: 10px;"><strong id="title_ticket">Message Subject Is Placed Here</strong>
                              <span id="hora_levantamiento" class="mailbox-read-time pull-right">15 Feb. 2016 11:03 PM</span>
                            </h4>
                            <div class="col-md-6">
                                <h5><strong>From: </strong><ins id="email_ticket">help@example.com</ins></h5>

                                  <div class="form-group">
                                    <label for="nom_cliente" class="control-label col-sm-5">Nombre cliente:</label>
                                    <div class="col-sm-7">
                                      <input class="form-control" type="text" name="nom_cliente" id="nom_cliente">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label col-md-5" for="select_type">Tipo: </label>
                                    <div class="col-md-7">
                                      <select id="select_type" name="select_type" class="form-control select2">
                                        <!-- open, pending, hold, solved or closed -->
                                        <option value="" selected>Elija...</option>
                                        <option value="question">Pregunta</option>
                                        <option value="incident">Incidente</option>
                                        <option value="problem">Problema</option>
                                        <option value="task">Tarea</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="select_site" class="control-label col-md-5">Sitio:</label>
                                    <div class="col-md-7">
                                      <select id="select_site" name="select_site" style="width: 80%" class="form-control select2 pull-right">
                                        <option value="">Elija...</option>
                                        @forelse ($sitios as $sitios_name)
                                          <option value="{{ $sitios_name->id }}"> {{ $sitios_name->Nombre_hotel }} </option>
                                        @empty
                                        @endforelse
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="select_itc" class="col-md-5 control-label">ITC(asignar):</label>
                                    <div class="col-md-7">
                                      <select style="width:100% !important;" id="select_itc" name="select_itc" class="form-control select2">
                                        <option value="">Elija...</option>
                                        <!-- Agregar cuentas de helpdesk. estaticamente. -->
                                          <option value="helpdesk@sitwifi.com"> Helpdesk</option>
                                          <option value="emiranda@sitwifi.com"> Edgar Miranda</option>
                                          <option value="mcardenas@sitwifi.com"> Mauricio Cárdenas</option>
                                          <option value="marthaisabel@sitwifi.com"> Martha Uh</option>
                                          <option value="helpdesksureste@sitwifi.com"> Helpdesk Sureste</option>
                                          <option value="nocmexico@sitwifi.com"> NOC México</option>
                                          <option value="crangel@sitwifi.com"> Carlos Rangel </option>
                                          <option value="jesquinca@sitwifi.com"> José Antonio Esquinca</option>
                                        @forelse ($itconcierge as $itc)
                                          <option value="{{ $itc->email }}"> {{ $itc->name }} </option>
                                        @empty
                                        @endforelse
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-5 control-label" for="select_status">Estatus: </label>
                                    <div class="col-md-7">
                                      <select id="select_status" name="select_status" class="form-control select2">
                                        <!-- open, pending, hold, solved or closed -->
                                        <option value="" selected>Elija...</option>
                                        <option value="open">Abierto</option>
                                        <option value="pending">Pendiente</option>
                                        <option value="hold">En espera</option>
                                        <option value="solved">Resuelto</option>
                                        <!-- <option value="closed">Cerrado</option> -->
                                        <!-- <option disabled="disabled" value="solved">Resuelto</option>
                                        <option disabled="disabled" value="closed">Cerrado</option> -->
                                      </select>
                                    </div>
                                  </div>

                              </div>

                            <!---------->
                            <div class="col-md-6">
                              <h5><strong>Remitente: </strong><ins id="remitente_ticket">help</ins></h5>
                              <div class="form-group">
                                <label class="col-md-8"><strong>Via de levantamiento: </strong><ins id="levantamiento_ticket">Email</ins></label>
                              </div>
                              <div class="form-group">
                                <label for="empresa" class="col-md-4">Empresa:</label>
                                <div class="col-md-8">
                                  <input class="form-control" type="text" name="empresa" id="empresa" >
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-4" for="select_priority">Prioridad: </label>
                                <div class="col-md-8">
                                  <select id="select_priority" name="select_priority" class="form-control select2">
                                    <!-- open, pending, hold, solved or closed -->
                                    <option value="" selected>Elija...</option>
                                    <option value="urgent">Urgente</option>
                                    <option value="high">Alta</option>
                                    <option value="normal">Normal</option>
                                    <option value="low">Baja</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-4" for="select_tags">tags: </label>
                                <div class="col-md-8">
                                  <input id="select_tags" name="select_tags" class="form-control tagEdit"/>
                                </div>
                              </div>

                            </div>

                            <div class="col-xs-6">
                              <button id="update_status" type="button" class="btn btn-info"><i class="fa fa-bullseye margin-r5"></i> Actualizar estatus</button>
                            </div>
                          </div>
                            <!-- /.mailbox-read-info -->
                            <!-- /.mailbox-controls -->
                          <div id="comment_section">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="comment">Comment:</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label for="select_public">Tipo de Respuesta: </label>
                              <div class="form-inline pull-right">
                                <select id="select_public" name="select_public" class="form-group">
                                  <!-- open, pending, hold, solved or closed -->
                                  <option value="1" selected="">Publica</option>
                                  <option value="0">Interna</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <textarea class="form-control" rows="4" id="comment" name="comment" placeholder="Respuesta al cliente."></textarea>
                            </div>
                            <div class="form-group">
                              <button id="submit_ticket" type="button" class="btn btn-info"><i class="fa fa-bullseye margin-r5"></i> Comentar ticket</button>
                            </div>
                          </div>
                        </form>

                        <div class="mailbox-read-message">
                          <p id="descripcion_ticket" hidden>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>


                          <p class="text-info hidden"><i class="fa fa-history"></i> Historia de comentarios <strong>* Tiempo real</strong>.</p>

                          <div id="cont_global">
                            <div id="global_mensajes">
                              <div class="coment_texto">Mensaje 1</div>
                              <div class="coment_texto">Mensaje 2</div>
                              <div class="coment_texto">Mensaje 3</div>
                              <div class="coment_texto">Mensaje 4</div>
                              <div class="coment_texto">Mensaje 5</div>
                              <div class="coment_texto">Mensaje 6</div>
                              <div class="coment_texto">Mensaje 7</div>
                              <div class="coment_texto">Mensaje 8</div>
                              <div class="coment_texto">Mensaje 9</div>
                              <div class="coment_texto">Mensaje 10</div>
                              <div class="coment_texto">Mensaje 11</div>
                              <div class="coment_texto">Mensaje 12</div>
                              <div class="coment_texto">Mensaje 13</div>
                              <div class="coment_texto">Mensaje 14</div>
                              <div class="coment_texto">Mensaje 15</div>
                            </div>
                          </div>

                          <br>


                        </div>
                        <!-- /.mailbox-read-message -->
                      </div>
                    </div>

                  <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="close_modal" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
          </div>
        </div>
      </div>
    </div>
  @if( auth()->user()->can('View info my ticket') )
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">

            <div class="row">
              <div class="col-md-12">
                <form id="generate_myticket2" name="generate_myticket2"  class="form-inline">
                <span class="direct-chat-timestamp pull-right">Última actualización - <span id="ticket_act_time"></span></span>
                {{ csrf_field() }}
                <div class="form-group col-md-12">
                  <label class="col-md-1 control-label" for="month_upload_band">Período:</label>
                  <div class="col-md-8">
                    <div class="input-group input-daterange">
                        <input name="date_start" id="date_start" type="text" class="form-control" value="">
                        <div class="input-group-addon">a</div>
                        <input name="date_end" id="date_end" type="text" class="form-control" value="">
                    </div>
                  </div>
                  <button type="button" class="btn btn-info btn_search2"><i class="fa fa-bullseye margin-r5"></i> {{ trans('message.generate') }}</button>
                </div>
              </form>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <center class="mt-5 mb-4">
                  <ul class="side-icon-text">
                    <h4>Estadísticas</h4>
                    <h1 class=""><small id="tickets_all">0</small></h1>
                    <h5 class="">Total de tickets asignados</h5>
                  </ul>
                </center>
                <!-------------------------------------------------------------------------->
                <div class="d-flex flex-wrap justify-content-xl-between">
                  <div class="d-none d-xl-flex border-md-left  border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <i class="fas fa-lock-open mr-3 icon-lg text-success"></i>
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Abiertos</small>
                      <h5 class="mr-2 mb-0" id="tickets_a">0</h5>
                    </div>
                  </div>

                  <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <i class="far fa-comment-dots mr-3 icon-lg text-danger"></i>
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Pendientes</small>
                      <h5 class="mr-2 mb-0" id="tickets_b">0</h5>
                    </div>
                  </div>

                  <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <i class="fas fa-file-import mr-3 icon-lg text-primary"></i>
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">En espera</small>
                      <h5 class="mr-2 mb-0" id="tickets_c">0</h5>
                    </div>
                  </div>
                </div>
                <div class="d-flex flex-wrap justify-content-xl-between">
                  <div class="d-none d-xl-flex border-md-left border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <i class="mdi mdi-file-check mr-3 icon-lg text-success"></i>
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Resueltos</small>
                      <h5 class="mr-2 mb-0" id="tickets_d">0</h5>
                    </div>
                  </div>

                  <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                    <i class="fas fa-lock mr-3 icon-lg text-danger"></i>
                    <div class="d-flex flex-column justify-content-around">
                      <small class="mb-1 text-muted">Cerrado</small>
                      <h5 class="mr-2 mb-0" id="tickets_e">0</h5>
                    </div>
                  </div>
                </div>
                <!-------------------------------------------------------------------------->
              </div>
              <div class="col-md-6">
                <div id="maingraphicTicketsR" class="mt-4" style="width: 100%; min-height: 400px;"></div>
              </div>
            </div>
            <div class="table-responsive">
                <table id="table_tickets" name='table_tickets' class="table">
                <thead>
                  <tr>
                    <th> <small>ID</small> </th>
                    <th> <small>Asunto</small> </th>
                    <th> <small>Solicitante</small> </th>
                    <th> <small>Prioridad</small> </th>
                    <th> <small>Estatus</small> </th>
                    <th> <small>Conceptos</small> </th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View info my ticket') )
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
  <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
  <!-- <link href="{{ asset('/plugins/tagEditor/jquery.tag-editor.css') }}'" rel="stylesheet" type="text/css" />
  <script src="{{ asset('/plugins/tagEditor/jquery.tag-editor.min.js') }}"></script>
  <script src="{{ asset('/plugins/tagEditor/jquery.caret.min.js') }}"></script> -->
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
  <link href="/plugins/tagEditor/jquery.tag-editor.css" rel="stylesheet" type="text/css" />
  <script src="/plugins/tagEditor/jquery.tag-editor.min.js"></script>
  <script src="/plugins/tagEditor/jquery.caret.min.js"></script>  <script src="{{ asset('js/admin/zendesk/infotickets.js') }}" charset="utf-8"></script>
    <script type="text/javascript">
      var auth_name = {!! json_encode(Auth::user()->name) !!};
    </script>
    <style media="screen">
      .select2{
        width: 100% !important;
      }

      textarea {
          height: 100%;
          resize: none;
      }
      #cont_global {
        height: auto;
        width: 100%;
        border: 1px solid #ddd;
        background: #f1f1f1;
      }
      #global_mensajes {
        height: auto;
        background: white;
      }
      .coment_texto {
        padding:4px;
        background:#fff;
      }

      .zd-comment{
        margin-left: 5%;
        margin-top: 10px;
        width: 90%;
        border-bottom: 1px solid #D9D9D9;
        margin-bottom: 10px;
        padding: 5px;
        color: #4B565E;
      }

      .zd-comment:last-child{
        border-bottom:none;
      }

      .zd-comment img {
        width: 100% !important;
        margin: 15px;
      }

      .interno{
        background-color: rgba(211,204,81, .4);
        border: 1px solid #BDB748;
      }

      .modal-content{
        width: 120%;
        margin-left: -10%;
      }
    </style>
  @else
  @endif
@endpush
