@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View history all viatic') )
    {{ trans('message.history') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View history all viatic') )
    {{ trans('message.breadcrumb_history_viat_month') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View history all viatic') )
      <div class="modal modal-default fade" id="modal-view-concept" data-backdrop="static"  tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" style="width:45%" >
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
                          <table id="table_concept" class="table table-striped table-bordered table-hover">
                            <thead>
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
          <button type="button" class="btn btn-warning btn-sit"><i class="far fa-edit"></i> Editar conceptos</button>
          @endif
          <button type="button" class="btn btn-primary btn-export"><i class="fa fa-save"></i> Exportar PDF</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal modal-default fade" id="modal-view-concept-approve2" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>Aprobar concepto</h4>
            <button type="button" class="close btn-all" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card-body">
              <div class="card-body">
                <div class="row">
                  <!-- <select class="form-control" name="select_concept_cadena" id="select_concept_cadena">
                    <option value="">Elija...</option>
                    @foreach ($cadenas as $cadena)
                    <option value="{{$cadena->id}}">{{$cadena->name}}</option>
                    @endforeach
                  </select>
                  <select class="form-control" name="select_concept_concepts" id="select_concept_concepts">
                    <option value="">Elija...</option>
                    @foreach ($concepts as $concept)
                    <option value="{{$concept->id}}">{{$concept->name}}</option>
                    @endforeach
                  </select> -->
                  <button type="button" class="btn btn-default addButton pull-right">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
                <div class="row">
                  <input id="obj_cob" name="obj_cob" class="form-control hidden" required readonly type="text" value=""style="display:none; visibility:hidden;">
                  <input type="text" id="new_data" name="new_data" class="form-control hidden" readonly style="display:none; visibility:hidden;">
                  <!-- Tabla de conceptos -->
                  <div class="table-responsive">
                    <table id="tableconcept2" name='tableconcept2' class="display nowrap table table-bordered table-hover" width="100%" cellspacing="0">
                      <thead>
                          <tr class="bg-white" style="background: #789F8A; font-size: 11.5px; ">
                            <th> <small>id</small> </th>
                            <th> <small>Cadena</small> </th>
                            <th> <small>Sitio</small> </th>
                            <th> <small>Concepto</small> </th>
                            <th> <small>Cantidad</small> </th>
                            <th> <small>V. Unitario</small> </th>
                            <th> <small>V. Solicitado</small> </th>
                            <th> <small>Justificación</small> </th>
                          </tr>
                      </thead>
                      <tbody style="background: #FFFFFF; font-size: 11.5px; ">
                      </tbody>
                    </table>
                  </div>
                  <!-- Fin de tabla conceptos. -->
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-save-conceptnew"><i class="fa fa-save"></i> Guardar</button>
            <button type="button" class="btn btn-danger btn-all"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
          </div>
        </div>
      </div>
  </div>



  <div class="container">
    <div class="card">
      <div class="card-body">
    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
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
        <form id="egef" name="egef" enctype="multipart/form-data" >
          <div class="">
            <table id="table_viatics" class="table table-striped table-bordered table-hover compact-tab w-100">
              <thead>
                <tr class="bg-primary">
                  <th> <small>Folio</small> </th>
                  <th> <small>Servicio</small> </th>
                  <th> <small>Fecha Inicio</small> </th>
                  <th> <small>Fecha Fin</small> </th>
                  <th> <small>Monto Solicitado</small> </th>
                  <th> <small>Monto Aprobado</small> </th>
                  <th> <small>Estatus</small> </th>
                  <th> <small>Usuario</small> </th>
                  <th> <small></small> </th>
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
                </tr>
              </tfoot>
            </table>
          </div>
        </form>
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
    @if( auth()->user()->can('View history all viatic') )
      <!-- <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" /> -->
<!-- <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script> -->
<script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
<link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
<script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>

<script type="text/javascript">
  var cadenas = {!! json_encode($cadenas) !!};
  var concepts = {!! json_encode($concepts) !!};
</script>
<script src="{{ asset('js/admin/viaticos/requests_viaticos_modal2.js')}}"></script>
<script src="{{ asset('js/admin/viaticos/requests_viaticos_modal.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/pdf2.css')}}" >
<script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
<script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
<script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
<style media="screen">
  .pt-10 {
    padding-top: 10px;
  }
  #table_viatics tbody tr td{
    table-layout: fixed;
    width: auto !important;
    white-space: pre-wrap !important;
  }
  #table_concept tbody tr td{
    table-layout: fixed;
    width: auto !important;
    white-space: pre-wrap !important;
  }
  .modal-content{
    width: 120% !important;
    margin-left: -10% !important;
  }
</style>
<script src="{{ asset('js/admin/viaticos/requests_viaticos_all.js')}}"></script>
    @else
    @endif
@endpush
