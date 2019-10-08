@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View equipment licences') )
    Licencias
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View equipment licences') )
    Licencias
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View equipment licences') )
  <div class="container">
     <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mb-3">
           <div class="card">
              <div class="card-body">
                 <div class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group">
                       <label for="select_one" class="control-label mr-1">Vencimiento: </label>
                       <select id="select_one" name="select_one"  class="form-control select2" style="width: 30vw" required>
                          <option value="0" selected> Cualquiera </option>
                          <option value="1"> En menos de 1 mes </option>
                          <option value="2"> En menos de 2 meses </option>
                          <option value="3"> En menos de 3 meses  </option>
                          <option value="4"> Vencidas </option>
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
                       Equipamiento
                    </h4>
                 </div>
                 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div>
                       <form id="table_check" method="POST">
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
                                   <th> <small>Fecha Venc.</small> </th>
                                </tr>
                             </thead>
                             <tbody>
                             </tbody>
                             <tfoot id='tfoot_average'>
                                <tr>
                                </tr>
                             </tfoot>
                          </table>
                          <div class="row form-group mt-2">
                            <div class="form-inline col-md-2 col-lg-2">&nbsp;</div>
                             <div class="form-inline col-md-2 col-lg-2">
                                Nueva fecha:
                             </div>
                             <div class="form-inline col-md-4 col-lg-4 mr-4">
                                <input class="datepicker form-control" data-date-format="yyyy/mm/dd" placeholder="2021/01/01">
                             </div>
                             <div class="form-inline col-md-2 col-lg-2 ml-4">
                                <button type="button" class="btn btn-info btnconf">Actualizar</button>
                             </div>
                          </div>
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
        </div>
      </div>
  </div>

      @else
        @include('default.denied')
      @endif
@endsection

@push('scripts')
    @if( auth()->user()->can('View equipment licences') )
<script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js') }}" type="text/javascript"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
<script src="{{ asset('js/admin/equipment/licences_equipment.js')}}"></script>

  @else
    <!--NO VER-->
  @endif
@endpush
