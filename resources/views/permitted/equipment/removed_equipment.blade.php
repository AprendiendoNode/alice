@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View removed equipment') )
    {{ trans('message.title_equipment') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View removed equipment') )
    {{ trans('message.breadcrumb_removed_equipment') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View removed equipment') )
    <div class="container">
      <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pb-3">
            <div class="card">
              <div class="card-body">
                <div class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="select_one" class="control-label">{{ trans('message.hotel') }}: </label>
                      <select id="select_one" name="select_one"  class="form-control select2" required>
                        <option value="" selected> Elija </option>
                        @forelse ($hotels as $data_cadena)
                          <option value="{{ $data_cadena->id }}"> {{ $data_cadena->Nombre_hotel }} </option>
                        @empty
                        @endforelse
                      </select>
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
                 <div class="">
                   <form id="table_check" method="POST">
                      <table id="table_qualification" cellspacing="0" class="table table-striped table-bordered table-hover text-white compact-tab" style="width:100%">
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
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot id='tfoot_average'>
                          <tr>
                          </tr>
                        </tfoot>
                      </table>
                      <p><button type="button" class="btn btn-danger darbajas">Bajas</button></p>
                      <!-- <p><b>Selected rows data:</b></p>
                      <pre id="example-console-rows"></pre> -->
                   </form>
                 </div>
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
                <div class="card-body">
                  <div class="row">
                    <div class="col-xs-12">
                      <h4 style="font-weight: bold;">¿Estas seguro que quieres continuar?</h4>
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
    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View removed equipment') )
  <!--Extra Datatable--->
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
  <script src="{{ asset('js/admin/equipment/removed_equipment.js')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
