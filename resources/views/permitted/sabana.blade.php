@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View drive') )
    <strong>Dashboard Clientes</strong>
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View drive') )

  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View drive') )
    Clientes
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View drive') )

      <div class="input-group mb-3">
        <label class="mr-1">Sitio:</label>
        <select id="cliente" class="form-control select2">
          <option value="" selected> Elija uno... </option>
          @forelse ($hotels as $hotel)
            <option value="{{ $hotel->id }}"> {{ $hotel->Nombre_hotel }} </option>
          @empty
          @endforelse
        </select>
      </div>
      <!--<div id="sabana" class="container card d-none">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#informacion"><i class="fas fa-user-circle"></i> Información</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#contrato"><i class="fas fa-file-contract"></i> Contrato</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#nps"><i class="fas fa-tachometer-alt"></i> NPS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#equipos"><i class="fas fa-box-open"></i> Equipos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tickets"><i class="fas fa-clipboard-list"></i> Tickets</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#presupuesto"><i class="fas fa-funnel-dollar"></i> Presupuesto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#gastos"><i class="fas fa-hand-holding-usd"></i></i> Gastos</a>
          </li>
        </ul>
        <div class="tab-content">
          <div id="informacion" class="container tab-pane active"><br>
            <h3 style="margin-left: 40%;">Información general</h3>
            <div class="row">
              <div class="card" style="width: 18rem;">
                <img id="imagenCliente" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 id="telefonoCliente" class="card-title"></h5>
                  <p id="direccionCliente" class="card-text"></p>
                  <a href="#" class="btn btn-primary">Más detalles</a>
                </div>
              </div>
            </div>
          </div>
          <div id="contrato" class="container tab-pane fade"><br>
            <h3>Contrato</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div>
          <div id="nps" class="container tab-pane fade"><br>
            <h3>NPS</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          </div>
          <div id="equipos" class="container tab-pane fade"><br>
            <h3>Equipos</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
          </div>
          <div id="tickets" class="container tab-pane fade"><br>
            <h3>Tickets</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
          </div>
          <div id="presupuesto" class="container tab-pane fade"><br>
            <h3>Presupuesto</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
          </div>
          <div id="gastos" class="container tab-pane fade"><br>
            <h3>Gastos</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
          </div>
        </div>
      </div>-->
      <!-- Modal -->
      <div class="modal fade" id="anexosModal" tabindex="-1" role="dialog" aria-labelledby="anexosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="anexosModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ...
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
              <li class="active"><i class="fas fa-user-circle"></i> Información</li>
              <li><i class="fas fa-file-contract"></i> Contratos</li>
              <li><i class="fas fa-tachometer-alt"></i> NPS</li>
              <li><i class="fas fa-box-open"></i> Equipos</li>
              <li><i class="fas fa-clipboard-list"></i> Tickets</li>
              <li><i class="fas fa-funnel-dollar"></i> Presupuesto</li>
              <li><i class="fas fa-hand-holding-usd"></i></i> Gastos</li>
          </ul>
          <div class="content_wrapper">
              <div class="tab_content active">
                  <h3 style="font-weight: bold; margin-left: 40%;">Información general</h3>
                  <div class="row">
                    <div class="card col-md-6" style="width: 18rem;">
                      <img id="imagenCliente" class="card-img-top" alt="...">
                      <div class="card-body text-center">
                        <a href="/viewreports" class="btn btn-primary">Más detalles</a>
                      </div>
                    </div>
                    <div class="card col-md-6" style="width: 18rem;">
                      <div class="card-body text-center">
                        <h5 class="card-title">ITC asignado:</h5>
                        <p id="itcCliente" class="card-text"></p>
                        <br>
                        <h5 class="card-title">Número de cuartos:</h5>
                        <p id="cuartosCliente" class="card-text"></p>
                        <br>
                        <h5 class="card-title">Teléfono de contacto:</h5>
                        <p id="telefonoCliente" class="card-text"></p>
                        <br>
                        <h5 class="card-title">Dirección:</h5>
                        <p id="direccionCliente" class="card-text"></p>
                        <br>
                        <h5 class="card-title">Correo:</h5>
                        <p id="correoCliente" class="card-text"></p>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="tab_content">
                  <h3 style="font-weight: bold; margin-left: 45%;">Maestros</h3>
                  <div class="table-responsive">
                    <table id="all_contracts" class="table table-bordered  table-striped table-hover display compact-tab" style="width: 100%">
                      <thead>
                        <tr style="background: #97bf36">
                          <th> <small>Id</small> </th>
                          <th> <small>Razón social</small> </th>
                          <th > <small>Nombre (cobranza)</small> </th>
                          <th > <small>Email</small> </th>
                          <th > <small>Teléfono</small> </th>
                          <th > <small>Resguarda</small> </th>
                          <th > <small>Estado</small> </th>
                          <th > <small>Ver</small> </th>
                          <th > <small>Anexos</small> </th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot >
                        <tr >
                          <th></th>
                          <th></th>
                          <th></th>
                          <th ></th>
                          <th></th>
                          <th></th>
                          <th ></th>
                          <th ></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
              </div>


              <div class="tab_content">
                <section>


                  <h3 style="font-weight: bold; margin-left: 47%;">NPS</h3>
                  <div class="row">
                    <div class="col-md-3">
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
                        <div class="col-md-12 mb-3">
                          <div class="card" id="box_sin_response" style="cursor: pointer;">
                            <div class="card-body">
                              <div class="ml-sm-3 ml-md-0 ml-xl-0 mt-2 mt-sm-0 mt-md-2 mt-xl-0 text-center">
                                <h4 id="unanswered" class="mb-2 text-danger font-weight-bold">84</h4>
                								<h6 class="mb-0">Sin respuesta</h6>
                							</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body .npscontainer container-fluid"  style="width: 100%;">
                          <h4 class="card-title">NPS chart</h4>
                          <div class="d-flex justify-content-center  border-bottom w-100">
                            <div id="main_nps_hotel" style="width: 100%; min-height: 320px; "></div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3">
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
                      </div>
                    </div>


                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <h3>Última encuesta</h3>
                      <table id="nps_comments" class="table table-bordered  table-striped table-hover display compact-tab" style="width: 100%">
                        <thead>
                          <tr class="bg-aqua text-center">
                            <th class="bg-aqua"> <small>Cliente</small> </th>
                            <th class="bg-aqua"> <small>Sitio</small> </th>
                            <th class="bg-aqua"> <small>Calificacion</small> </th>
                            <th class="bg-aqua"> <small>Itc</small> </th>
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
                  </section>
              </div>


              <div class="tab_content">
                  <h3>Todos los equipos del sitio</h3>
                  <div class="d-flex justify-content-center border-bottom w-100">
                    <div  id="graph_equipments" style="min-height: 300px;left: 0px;right: 0px;"> </div>
                  </div>

                  <div class="divEQ">
                  <table id="all_equipments" class="table table-bordered  table-striped table-hover display compact-tab" style="width: 100%">
                    <thead>
                      <tr class="bg-aqua">
                        <th class="bg-aqua"> <small>Tipo</small> </th>
                        <th class="bg-aqua"> <small>Modelo</small> </th>
                        <th class="bg-aqua"> <small>Mac</small> </th>
                        <th class="bg-aqua"> <small>Serie</small> </th>
                        <th class="bg-aqua"> <small>Descripción</small> </th>
                        <th class="bg-aqua"> <small>Estado</small> </th>
                        <th class="bg-aqua"> <small>Fecha Registro</small> </th>
                        <th class="bg-aqua"> <small>Fecha Baja</small> </th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot >
                      <tr >
                        <th></th>
                        <th></th>
                        <th ></th>
                        <th></th>
                        <th></th>
                        <th ></th>
                        <th ></th>
                      </tr>
                    </tfoot>
                  </table>
                  </div>
              </div>
              <div class="tab_content">
                  <h3>Tab content 5</h3>
                  <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
                      specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                      passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                      standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining
                      essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                  </p>
              </div>
              <div class="tab_content">
                <div class="row">
                  <div class="col-md-12">
                    <h3>Presupuesto anual del sitio</h3>
                    <table id="table_budget_site" name='table_budget_site' class="display nowrap table table-bordered table-hover compact-tab w-100" cellspacing="0">
                      <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
                      <thead>
                          <tr class="bg-aqua" style="color: white">
                              <!--<th> <small>Sitio</small> </th>-->
                              <th> <small>Anexo</small> </th>
                              <th> <small>ID ubicacion</small> </th>
                              <th> <small>Moneda</small> </th>
                              <th> <small>Equipo activo</small> </th>
                              <th> <small>Equipo no activo</small> </th>
                              <th> <small>Licencias</small> </th>
                              <th> <small>Mano de obra</small> </th>
                              <th> <small>Enlaces</small> </th>
                              <th> <small>Viáticos</small> </th>
                              <th> <small>Acciones</small> </th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab_content">
                  <h3>Tab content 7</h3>
                  <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage
                      of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator
                      on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition,
                      injected humour, or non-characteristic words etc. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look
                      even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined
                      chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The
                      generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
              </div>
          </div>
      </div>
      <div style="margin-left: 40%;">
        <img id="cargando" class="d-none" src="/images/cargando.gif" alt="...">
      </div>

    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View drive') )

    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/animate.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript" src="js/jquery.multipurpose_tabcontent.js"></script>
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/sabana/sabana.js')}}"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <style media="screen">
    .tableFixHead          { overflow-y: auto;overflow-x: hidden; height: 500px; }
    .tableFixHead thead th { position: sticky !important; top: 0; }
    .bg-aqua{
    background: #02948c;
    }
    .color-green{ color:#0fe81e;}
    .color-red{ color:#f0120a;}
    .color-yellow{ color:#f6a60a;}
    </style>
  @else
    <!--NO SCRIPTS-->
  @endif
@endpush
