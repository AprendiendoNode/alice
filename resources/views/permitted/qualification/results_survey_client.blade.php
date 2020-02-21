@extends('layouts.admin')

@section('contentheader_title')
{{-- @if( auth()->user()->can('View Document P') )
    {{ trans('message.breadcrumb_document_create') }}
@else
{{ trans('message.denied') }}
@endif --}}
@endsection

@section('breadcrumb_title')
{{-- @if( auth()->user()->can('View Document P') )
    {{ trans('message.document_create') }}
@else
{{ trans('message.denied') }}
@endif --}}
@endsection

@section('content')
@if( auth()->user()->can('View results survey') )

  <!-- Modal -->
  <div class="modal fade" id="ModalMail" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="ModalLabel">Seguimiento de encuestas</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form id="form_modal"name="datamodal" enctype="multipart/form-data" class="form-inline" method="post">
                    {{ csrf_field() }}
                    <div class="row w-100">
                      <div class="col-md-6 col-lg-6 pl-4">
                        <div class="row">
                          <div class="form-group input-group">
                            <label for="Cliente">Cliente</label>
                            <input type="text" class="form-control" id="Cliente"  aria-describedby="inputGroupPrepend2"  readonly required>
                          </div>
                        </div>
                        <div class="row pt-2">
                          <div class="form-group input-group">
                            <label for="Correo">Correo</label>
                            <input type="text" class="form-control" id="Correo"  aria-describedby="inputGroupPrepend2" readonly required>
                          </div>
                        </div>
                        <div class="form-group row pt-2">
                          <label for="Comentario_actual">Comentario</label>
                          <div class="pl-3" id="mes_2"></div>
                          <div class="pl-3" id="calif_2"></div>
                        </div>
                        <div class="form-group row">
                          <div class="form-group w-100">
                            <textarea class="form-control " style="min-width:100%" id="Comentario_anterior" readonly ></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-6 pl-4">
                        <div class="row">
                          <div class="form-group input-group">
                            <label for="Fecha">Fecha</label>
                            <input type="text" class="form-control" id="Fecha"  aria-describedby="inputGroupPrepend2"  required>
                          </div>
                        </div>
                        <div class="row pt-2">
                          <div class="form-group input-group ">
                            <label for="ITC">ITC asignado</label>
                            <input type="text" class="form-control" id="ITC"  aria-describedby="inputGroupPrepend2"  readonly required>
                          </div>
                        </div>
                        <div class="form-group row pt-2">
                          <label for="Comentario_anterior">Comentario</label>
                          <div class="pl-3" id="mes_1"></div>
                          <div class="pl-3"  id="calif_1"></div>
                        </div>
                        <div class="row">
                          <div class="form-group w-100">
                            <textarea class="form-control " style="min-width:90%" id="Comentario_actual" readonly ></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row w-100 pt-2 pl-4">
                      Comentario Nuevo
                    </div>
                    <div class="row w-100 pt-2 pl-4">
                      <div class="form-group w-100">
                        <textarea class="form-control " style="min-width:90%" id="Comentario_correo" ></textarea>
                      </div>
                    </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="button" id="sent" class="btn btn-primary" data-dismiss="modal">Enviar Correo</button>
              </div>
          </div>
      </div>
  </div>


<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <form id="search_info" name="search_info" class="form-inline" method="post">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-md-5 col-xs-12">
                                <div class="form-group" id="date_from">
                                    <label class="control-label" for="date_to_search">
                                        Fecha
                                    </label>
                                    <div class="input-group mb-3">
                                        <input type="text" datas="filter_date_from" id="date_to_search" name="date_to_search" class="form-control form-control-sm" placeholder="" value="" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12 pt-4 mt-2">
                              <button id="boton-aplica-filtro" type="button" class="btn  btn-primary filtrarDashboard" name="button">
                                Aplicar filtro
                              </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
                <div class="table-responsive" style="background: #ffffff;">
                    <table id="table_results_full" class="table table-striped compact-tab table-bordered table-hover">
                        <thead class="bg-dark">
                            <tr>
                                <th>Sitio</th>
                                <th>Cliente</th>
                                <!--<th>Comentario</th>-->
                                <th>Calificación</th>
                                <th>Ing. asignado</th>
                                <th class="text-center">Opciones</th>
                                <th class="text-center">Seguimiento</th>
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
@if( auth()->user()->can('View results survey') )
<script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
<script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/filter.css')}}">
<script src="{{ asset('js/admin/qualification/resultssurvey_client.js')}}"></script>
<style media="screen">
    .pt-10 {
        padding-top: 10px;
    }

    #table_qualification thead th {
        width: 100%;
        padding: 0.2rem 0.2rem;
        color: white;
        white-space: pre-line;
    }

    #table_qualification td,
    #table_qualification th {
        vertical-align: middle;
    }

    #table_qualification td {
        vertical-align: middle;
    }
</style>
@else
<!--NO VER-->
@endif
@endpush
