@extends('layouts.admin')
@section('contentheader_title')
@if( auth()->user()->can('View move equipment') )
{{ trans('message.title_equipment') }}
@else
{{ trans('message.title_equipment') }}
@endif
@endsection
@section('contentheader_description')
@if( auth()->user()->can('View move equipment') )
{{ trans('message.subtitle_move_equipment') }}
@else
{{ trans('message.denied') }}
@endif
@endsection
@section('breadcrumb_title')
@if( auth()->user()->can('View move equipment') )
{{ trans('message.breadcrumb_move_equipment') }}
@else
{{ trans('message.denied') }}
@endif
@endsection
@section('content')
@if( auth()->user()->can('View move equipment') )
<div class="container">
   <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mb-3">
         <div class="card">
            <div class="card-body">
               <div class="form-inline">
                  {{ csrf_field() }}
                  <div class="form-group">
                     <label for="select_one" class="control-label mr-1">{{ trans('message.hotel') }}: </label>
                     <select id="select_one" name="select_one"  class="form-control select2" style="width: 30vw" required>
                        <option value="" selected> Elija </option>
                        @forelse ($hotels as $data_hotel)
                        <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                        @empty
                        @endforelse
                     </select>
                     <label class="control-label ml-1 mr-1" for="mac_input1">Mac o serie:</label>
                     <div class="input-group ">
                        <input name="mac_input1" id="mac_input1" placeholder="Minimo 4 digitos." minlength="4" type="text" class="form-control" value="">
                     </div>
                     <button type="button" id="btn_search_mac1" class="btn btn-info ml-1">Buscar M/S</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
         <div class="hojitha" style="background-color: #fff; border:1px solid #ccc; border-bottom-style:hidden; padding:10px; width: 100%">
            <div class="row">
               <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                  <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                     Equipamiento - Actual
                  </h4>
               </div>
               <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                  <div>
                     <form id="table_check" method="POST">
                       <div class="table-responsive">
                        <table id="table_move" cellspacing="0" class="table table-striped table-bordered table-hover compact-tab w-100">
                           <thead>
                              <tr class="bg-primary" style="background: #088A68;">
                                 <th> <small>0</small> </th>
                                 <th> <small>Cliente.</small> </th>
                                 <th> <small>Equipo.</small> </th>
                                 <th> <small>Marca.</small> </th>
                                 <th> <small>Mac.</small> </th>
                                 <th> <small>Serie.</small> </th>
                                 <th> <small>Modelo.</small> </th>
                                 <th> <small>Estado.</small> </th>
                                 <th> <small>Fecha Alta.</small> </th>
                                 <th> <small>Acción</small> </th>
                              </tr>
                           </thead>
                           <tbody>
                           </tbody>
                           <tfoot id='tfoot_average'>
                              <tr>
                              </tr>
                           </tfoot>
                        </table>
                        </div>
                        <div class="row">
                           <div class="form-group col-md-6 col-lg-6">
                              <label for="select_two" class="control-label">{{ trans('general.hotel') }} Destino: </label>
                              <select id="select_two" name="select_two"  class="form-control select2" required>
                                 <option value="" selected> Elija </option>
                                 @forelse ($hotels as $data_hotel_two)
                                 <option value="{{ $data_hotel_two->id }}"> {{ $data_hotel_two->Nombre_hotel }} </option>
                                 @empty
                                 @endforelse
                              </select>
                           </div>
                           <div class="form-group col-md-4 col-lg-4">
                              <label for="select_three" class="control-label">Estatus: </label>
                              <select id="select_three" name="select_three"  class="form-control select2" required>
                                 <option value=""> Elija </option>
                                 <option value="999" selected> Conservar estados </option>
                                 @forelse ($estados as $data_estados)
                                 <option value="{{ $data_estados->id }}"> {{ $data_estados->Nombre_estado }} </option>
                                 @empty
                                 @endforelse
                              </select>
                           </div>
                           <div class="form-group col-md-2 col-lg-2">
                              <br>
                              <button type="button" class="btn btn-info btnconf">Mover</button>
                           </div>
                        </div>
                        <!-- <p><b>Selected rows data:</b></p>
                           <pre id="example-console-rows"></pre> -->
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <!--Modal confirmación-->
         <div class="modal modal-default fade" id="modal-confirmation" data-backdrop="static">
            <div class="modal-dialog" >
               <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-bookmark" style="margin-right: 4px;"></i>Confirmación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                     <div class="box-body">
                        <div class="row">
                           <div class="col-xs-12">
                              <h4 style="font-weight: bold;">¿Are you sure you want to continue?</h4>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-danger btn-conf-action"><i class="fa fa-trash" style="margin-right: 4px;"></i>Confirmar</button>
                     <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                  </div>
               </div>
            </div>
         </div>
         <!--Modal confirmación-->
         <!--Modal Descripción-->
         <div class="modal modal-default fade" id="modal-comments" data-backdrop="static">
            <div class="modal-dialog" >
               <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>Descripción</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  </div>
                  <div class="modal-body">
                     <div class="box-body table-responsive">
                        <div class="box-body">
                           <div class="row">
                              <div class="col-xs-12">
                                 <div class="form-group">
                                    <div class="col-sm-12">
                                       <input id="token_min" name="token_min" type="hidden" class="form-control" placeholder="">
                                       <textarea id="comment_a" name="comment_a"  class="form-control" style="min-width: 100%" maxlength="150"></textarea>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-success btn-update-descrip">Actualizar</button>
                     <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                  </div>
               </div>
            </div>
         </div>
         <!--Modal Descripción-->
      </div>
      <div>&nbsp;</div>
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
         <div class="hojitha" style="background-color: #fff; border:1px solid #ccc; border-bottom-style:hidden; padding:10px; width: 100%">
            <div class="row">
               <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                  <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                     Equipamiento - Importar
                  </h4>
                  <div style="text-align: center;">
                    <input style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0; margin: auto;" type="file" id="files" name="files"/>
                  </div>
                  <div style="text-align: center;">
                    <a href="formats/excel/EjemploMovimientoEquipos.xlsx" style="font-size: 18px;" download>Descargar excel de ejemplo</a>
                  </div>
               </div>
               <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                  <div>
                     <form id="table_check2" method="POST">
                       <div class="table-responsive">
                        <table id="table_move2" cellspacing="0" class="table table-striped table-bordered table-hover compact-tab">
                           <thead>
                              <tr class="bg-primary" style="background: #088A68;">
                                 <th> <small>Cliente.</small> </th>
                                 <th> <small>Equipo.</small> </th>
                                 <th> <small>Marca.</small> </th>
                                 <th> <small>Mac.</small> </th>
                                 <th> <small>Serie.</small> </th>
                                 <th> <small>Modelo.</small> </th>
                                 <th> <small>Estado.</small> </th>
                                 <th> <small>Fecha Alta.</small> </th>
                              </tr>
                           </thead>
                           <tbody>
                           </tbody>
                           <tfoot id='tfoot_average'>
                              <tr>
                              </tr>
                           </tfoot>
                        </table>
                        </div>
                        <div class="row">
                           <div class="form-group col-md-2 col-lg-2">
                              <label for="select_two2" class="control-label">{{ trans('general.hotel') }} Destino: </label>
                              <select id="select_two2" name="select_two"  class="form-control select2 w-10" required>
                                 <option value="" selected> Elija </option>
                                 @forelse ($hotels as $data_hotel_two)
                                 <option value="{{ $data_hotel_two->id }}"> {{ $data_hotel_two->Nombre_hotel }} </option>
                                 @empty
                                 @endforelse
                              </select>
                           </div>
                           <div class="form-group col-md-2 col-lg-2">
                              <label for="select_three2" class="control-label">Estatus: </label>
                              <select id="select_three2" name="select_three"  class="form-control select2" required>
                                 <option value=""> Elija </option>
                                 <option value="999" selected> Conservar estados </option>
                                 @forelse ($estados as $data_estados)
                                 <option value="{{ $data_estados->id }}"> {{ $data_estados->Nombre_estado }} </option>
                                 @empty
                                 @endforelse
                              </select>
                           </div>
                           <div class="form-group col-md-3 col-lg-3">
                             <label for="grupo" class="control-label">Grupo: </label>
                             <select class="form-control select2" id="grupo" name="grupo">
                               <option value="" selected> Elija </option>
                               @forelse ($groups as $data_groups)
                                 <option value="{{ $data_groups->id }}"> {{ $data_groups->name }} </option>
                               @empty
                               @endforelse
                             </select>
                           </div>
                           <div class="form-group col-md-3 col-lg-3">
                              <label for="description" class="control-label">Descripción: </label>
                              <textarea id="description" name="description" placeholder="Ninguna" class="form-control" style="min-width: 100%" maxlength="150"></textarea>
                           </div>
                           <div class="form-group col-md-2 col-lg-2">
                             <p>&nbsp;</p>
                              <button type="button" class="btn btn-info btnconf2">Mover</button>
                           </div>
                        </div>
                        <!-- <p><b>Selected rows data:</b></p>
                           <pre id="example-console-rows"></pre> -->
                     </form>
                  </div>
               </div>
            </div>
         </div>
   </div>
   </br>
   <!--Modal confirmación 2-->
   <div class="modal modal-default fade" id="modal-confirmation2" data-backdrop="static">
      <div class="modal-dialog" >
         <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fa fa-bookmark" style="margin-right: 4px;"></i>Confirmación</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
               <div class="box-body">
                  <div class="row">
                     <div class="col-xs-12">
                        <h4 style="font-weight: bold;">¿Are you sure you want to continue?</h4>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-conf-action2"><i class="fa fa-trash" style="margin-right: 4px;"></i>Confirmar</button>
               <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
            </div>
         </div>
      </div>
   </div>
   <!--Modal confirmación 2-->
   <!--
   <div class="row" style="display: none;">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
         <div class="box box-solid">
            <div class="box-body">
               <div class="form-horizontal">
                  {{ csrf_field() }}
                  <div class="form-group">
                     <label class="col-md-2 control-label" for="mac_input">Mac o serie: </label>
                     <div class="col-md-10">
                        <div class="input-group ">
                           <input name="mac_input" id="mac_input_blocked" placeholder="Minimo 4 digitos." minlength="4" type="text" class="form-control" value="">
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-2 text-right">
                        <button type="button" id="btn_search_mac_blocked" class="btn btn-info">Buscar Mac</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
         <div class="table-responsive">
            <table id="table_buscador_blocked" cellspacing="0" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr class="bg-primary" style="background: #088A68;">
                     <th> <small>Cliente.</small> </th>
                     <th> <small>Equipo.</small> </th>
                     <th> <small>Marca.</small> </th>
                     <th> <small>Mac.</small> </th>
                     <th> <small>Serie.</small> </th>
                     <th> <small>Modelo.</small> </th>
                     <th> <small>Estado.</small> </th>
                     <th> <small>Fecha Registro.</small> </th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
   </div>
   -->
</div>
</div>
@else
@include('default.denied')
@endif
@endsection
@push('scripts')
@if( auth()->user()->can('View move equipment') )
<!--Extra Datatable--->
<script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js') }}" type="text/javascript"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
<script src="{{ asset('js/admin/equipment/move_equipment.js?v=1.0.1')}}"></script>
@else
<!--NO VER-->
@endif
@endpush
