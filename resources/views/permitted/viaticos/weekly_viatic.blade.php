@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View weekly viatic') )
    {{ trans('message.report_weekly') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View weekly viatic') )
    {{ trans('message.report_weekly') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View weekly viatic') )
      <div class="modal modal-default fade" id="modal-view-concept" data-backdrop="static">
    <div class="modal-dialog modal-lg" style="width:45%" >
      <div class="modal-content">
        <div class="modal-header">

          <h4 class="modal-title"><i class="fas fa-id-card" style="margin-right: 4px;"></i>Lista de conceptos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <div class="card-body ">
            <div class="card-body">
              <div class="row">
                <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
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
                  <!--  <br />
                        <strong>Beneficiario: </strong><small id="tipo_beneficiario"></small>
                        <br /> -->
                        <br/>
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
                        <div  style="clear: both;" width=20%>
                          <table id="table_concept" class="table table-striped table-bordered table-hover" >
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
                          <div id="comentarios" style="width: 100%; min-height: 80px; border:1px solid #ccc;padding:10px;">Observaciones o comentarios:
                            <small id="observaciones_a"></small>
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
                          <img id="firma_3" name="firma_2" class="img-responsive" src="{{ asset('/images/hotel/Default.svg') }}" width="70%" />
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
          <button type="button" class="btn btn-primary btn-export"><i class="fa fa-save"></i> Exportar PDF</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
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
            <div class="row">
              <div class="form-group">
                 <label class="col-xs-4 control-label">Fecha Inicio</label>
                 <div class="col-xs-8 dateContainer">
                     <div class="input-group input-append date" id="startDatePicker" name="startDatePicker">
                       <input type="text" class="form-control" id="startDate" name="startDate" required=true/>
                       <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                     </div>
                 </div>
              </div>
              <div class="form-group">
                <label class="col-xs-3 control-label">Fecha Fin</label>
                <div class="col-xs-8 dateContainer">
                    <div class="input-group input-append date" id="endDatePicker" name="endDatePicker">
                      <input type="text" class="form-control" id="endDate" name="endDate" required="true" />
                      <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
              </div>
              <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
              </button>
            </div>
            <br>

              <div class=" col-md-5">
                <div class="form-group">
                  <label class="col-md-3 control-label">Filtrar por:</label>
                  <div class="col-md-5">
                      <select class="form-control" name="filterOption" id="filterOption">
                        <option value="0" selected>Todos</option>
                        <option value="1">Categoria</option>
                        <option value="2">Grupo</option>
                        <option value="3">Proyecto</option>
                        <option value="4">Persona</option>
                      </select>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <select style="display:none;width:150px" class="form-control col-md-4" name="service" id="service">
                        <option value="0" selected>Elegir</option>
                        @forelse ($services as $data_service)
                          <option value="{{ $data_service->id }}"> {{ $data_service->name }} </option>
                        @empty
                        @endforelse
                  </select>
                  <select style="display:none;width:150px"  class="form-control col-md-4" name="group" id="group">
                        <option value="0" selected>Elegir</option>
                        @forelse ($cadenas as $data_cadena)
                          <option value="{{ $data_cadena->id }}"> {{ $data_cadena->name }} </option>
                        @empty
                        @endforelse
                  </select>
                  <select style="display:none;width:150px" class="form-control col-md-4" name="sitio" id="sitio">
                        <option value="0" selected>Elegir</option>
                        @forelse ($sitios as $data_proyect)
                          <option value="{{ $data_proyect->id }}"> {{ $data_proyect->Nombre_hotel }} </option>
                        @empty
                        @endforelse
                  </select>
                  <select style="display:none;width:150px" class="form-control col-md-4" name="users" id="users">
                        <option value="0" selected>Elegir</option>
                        @forelse ($users as $data_user)
                          <option value="{{ $data_user->id }}"> {{ $data_user->name }} </option>
                        @empty
                        @endforelse
                  </select>
                </div>
              </div>
            <br>

    </form>
      <br><br>
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
        <div class="table-responsive">
          <table id="table_viatics" class="table table-striped table-bordered table-hover compact-tab w-100" style=" padding:0; margin:0;">
            <thead>
              <tr class="bg-primary" >
                <th> <small>Folio</small> </th>
                <th> <small>Sitio</small> </th>
                <th> <small>Fecha Inicio</small> </th>
                <th> <small>Fecha Fin</small> </th>
                <th > <small>Transportación áerea</small> </th>
                <th> <small>Transportación Terrestre</small> </th>
                <th> <small>Hospedaje</small> </th>
                <th> <small>Alimentación</small> </th>
                <th> <small>Diversos</small> </th>
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
</div>

    @else
      @include('default.denied')
    @endif
@endsection
<style media="screen">
  .modal-content{
    width: 120% !important;
    margin-left: -10% !important;
  }
  #table_viatics tbody tr td{
    table-layout: fixed;
    width: auto !important;
    white-space: pre-wrap !important;
     padding:0; margin:0;
  }
  #table_concept tbody tr td{
    table-layout: fixed;
    width: auto !important;
    white-space: pre-wrap !important;
  }
  .col-md-viatic{
max-width: 130px;
white-space: pre-wrap !important;
  }
  .col-sm-viatic{
max-width: 120px;
white-space: pre-wrap !important;
  }
</style>
@push('scripts')
    @if( auth()->user()->can('View weekly viatic') )

      <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
      <script src="{{ asset('js/admin/viaticos/requests_viaticos_modal.js')}}"></script>
      <link rel="stylesheet" type="text/css" href="{{ asset('css/pdf2.css')}}" >
      <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
      <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
      <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
      <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
      <script src="{{ asset('js/admin/viaticos/filter_weekly.js')}}"></script>
    @else
    @endif
@endpush
