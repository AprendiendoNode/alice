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
  <div id="modal-view-info-ticket" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaltickets" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaltickets">Read Ticket</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                    <div class="card-body">
                      <form id="update_myticket" name="update_myticket" >
                        {{ csrf_field() }}
                        <div class="form-group">
                          <input type="hidden" id="id_ticket">
                          <h4><strong id="title_ticket">Message Subject Is Placed Here</strong></h4>
                          <h5><strong>From: </strong><ins id="email_ticket">help@example.com</ins>
                          <h5><strong>Remitente: </strong><ins id="remitente_ticket">help</ins>
                          <span id="hora_levantamiento" class="mailbox-read-time pull-right">15 Feb. 2016 11:03 PM</span>
                          </h5>
                          <h5><strong>Via de levantamiento: </strong><ins id="levantamiento_ticket">Email</ins></h5>
                          <div class="row mt-2">
                            <div class="col-md-6">
                              <label for="select_type">Tipo: </label>
                              <select id="select_type" class="form-group select2" style="width: 80%;">
                                <!-- open, pending, hold, solved or closed -->
                                <option value="" selected>Elija...</option>
                                <option value="question">Pregunta</option>
                                <option value="incident">Incidente</option>
                                <option value="problem">Problema</option>
                                <option value="task">Tarea</option>
                              </select>
                            </div>
                            <div class="col-md-6">
                              <label for="select_site" class="">Sitio:</label>
                              <select id="select_site" style="width: 80%" class="form-group select2 pull-right">
                                <option value="">Elija...</option>
                                @forelse ($sitios as $sitios_name)
                                  <option value="{{ $sitios_name->id }}"> {{ $sitios_name->Nombre_hotel }} </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-6">
                              <label for="select_priority">Prioridad: </label>
                              <select id="select_priority" class="form-group select2" style="width: 65%;">
                                <!-- open, pending, hold, solved or closed -->
                                <option value="" selected>Elija...</option>
                                <option value="urgent">Urgente</option>
                                <option value="high">Alta</option>
                                <option value="normal">Normal</option>
                                <option value="low">Baja</option>
                              </select>
                            </div>
                            <div class="col-md-6">
                              <label for="select_status">Estatus: </label>
                              <select id="select_status" class="form-group select2" style="width: 70%;">
                                <!-- open, pending, hold, solved or closed -->
                                <option value="" selected>Elija...</option>
                                <option value="open">Abierto</option>
                                <option value="pending">Pendiente</option>
                                <option value="hold">En espera</option>
                                <option disabled="disabled" value="solved">Resuelto</option>
                                <option disabled="disabled" value="closed">Cerrado</option>
                              </select>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-sm-12">
                              <button id="update_status" type="button" class="btn btn-block btn btn-primary"><i class="fas fa-bullseye mr-1"></i>Actualizar estatus</button>
                            </div>
                          </div>
                        </div>
                      <!-- /.mailbox-read-info -->
                      <!-- /.mailbox-controls -->
                        <div id="comment_section">
                          <div class="row mt-4">
                            <div class="col-md-12">
                              <label for="select_public">Tipo de Respuesta: </label>
                              <div class="form-inline pull-right">
                                <select id="select_public" class="form-group select2" style="width: 80%;">
                                  <!-- open, pending, hold, solved or closed -->
                                  <option value="1" selected="">Publica</option>
                                  <option value="0">Interna</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-12 mt-2">
                              <div class="form-group">
                                <label for="comment">Comentario:</label>
                                <textarea class="form-control" rows="4" id="comment" placeholder="Respuesta al cliente."></textarea>
                              </div>
                            </div>
                            <div class="col-md-12 mt-2">
                              <div class="form-group">
                                <button id="submit_ticket" type="button" class="btn btn-block btn btn-info"><i class="fas fa-bullseye mr-1"></i> Comentar ticket</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      <div class="row mt-4">
                        <div class="col-md-12">
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
                          </div>
                        </div>
                      </div>
                    </div>
              <!------------------------------------------------------------------------------------------------------------------------------------------------------->
            </div>
          </div>
        </div>
        <div class="modal-footer">
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
                <form id="generate_myticket" name="generate_myticket" class="form-inline">
                  {{ csrf_field() }}
                  <div class="input-group mb-2 mr-sm-2">
                    <h5>{{ trans('customer.periodo') }}:</h5>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                    <input type="text" class="form-control" id="datepickerMonthticket" name="datepickerMonthticket">
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                    <button type="button" class="btn btn-outline-primary btn_search"> <i class="fas fa-filter" style="margin-right: 4px;"></i> Filtrar</button>
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
  <script src="{{ asset('js/admin/zendesk/infotickets.js')}}" charset="utf-8"></script>
  <style media="screen">
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
