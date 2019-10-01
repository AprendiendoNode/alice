@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View equipment group') )
    {{ trans('message.title_equipment') }}
  @else
    {{ trans('message.title_equipment') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View equipment group') )
    {{ trans('message.subtitle_group_equipment') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View equipment group') )
    {{ trans('message.breadcrumb_group_equipment') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View equipment group') )
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="card">

          <div class="card-body">
              <div class="row form-inline">
                <label for="" class="control-label col-md-2">{{ trans('message.gruponew') }}: </label>
                <input type="text" id="new_group" class="col-md-3" name="new_group" minlength="4" placeholder="Min 4 caracteres."></input>
                <button type="button" id="btn_create_group" class="btn btn-info btncreate col-md-2 ml-3"><i class="fa fa-bullseye margin-r5"></i> {{ trans('message.create') }}</button>
              </div>
              <div class="row form-inline pt-3">
                {{ csrf_field() }}
                <label for="select_one" class="control-label col-md-2">{{ trans('message.grupoex') }}: </label>
                <select id="select_one" name="select_one"  class="form-control select2  col-md-4" required>
                  <option value="" selected> Elija </option>
                  @forelse ($grupos as $data_grupos)
                    <option value="{{ $data_grupos->id }}">{{ $data_grupos->name }}</option>
                  @empty
                  @endforelse
                </select>
                <label for="mac_input" class="control-label col-md-1 ml-3 mr-3">MAC/Serie:</label>
                <input type="text" id="mac_input" class="col-md-2" name="mac_input" minlength="10" maxlength="40" placeholder="Mínimo 10 caracteres."></input>
                <button type="button" id="btn_update_group" class="btn btn-info btngeneral col-md-2 ml-3"><i class="fa fa-bullseye margin-r5"></i> {{ trans('message.aplicar') }}</button>
              </div>

            <div class=" table-responsive pt-3">
              <table id="table_group" class="table compact-tab table-striped table-bordered table-hover w-100">
                <thead class="bg-primary">
                  <tr>
                  <th>Equipo.</th>
                  <th>MAC</th>
                  <th>Serie.</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>


            <!-- Vista para el movimiento de grupos a hoteles. -->
            <div class="pt-3">
              <h5><strong>Mover grupos enteros.</strong></h5>
              <div class="row form-inline">
                <label for="select_hotels" class="control-label col-md-1">{{ trans('message.hotel') }}: </label>
                <select id="select_hotels" name="select_hotels"  class="form-control select2 col-md-4">
                  <option value="" selected> Elija </option>
                  @forelse ($hotels as $data_hotels)
                    <option value="{{ $data_hotels->id }}">{{ $data_hotels->Nombre_hotel }}</option>
                  @empty
                  @endforelse
                </select>

                <label for="select_estados" class="control-label col-md-1">{{ trans('message.estatus') }}: </label>
                <select id="select_estados" name="select_estados"  class="form-control select2 col-md-3">
                  <option value="" selected> Elija </option>
                  @forelse ($estados as $data_estados)
                    <option value="{{ $data_estados->id }}">{{ $data_estados->Nombre_estado }}</option>
                  @empty
                  @endforelse
                </select>

                <button type="button" id="btn_change_group" class="btn btn-info btngeneral col-md-2 ml-3"><i class="fa fa-bullseye margin-r5"></i> {{ trans('message.aplicar') }}</button>

              </div>

            </div>

          </div>

          <!--Modal confirmación-->
            <div class="modal modal-default fade" id="modal-confirmation" data-backdrop="static">
             <div class="modal-dialog" >
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title"><i class="fa fa-bookmark" style="margin-right: 4px;"></i>Confirmación</h4>
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
                   <button type="button" class="btn btn-success btn-conf-action"><i class="fa fa-check" style="margin-right: 4px;"></i>Confirmar</button>
                   <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                 </div>
               </div>
             </div>
            </div>
          <!--Modal confirmación-->

        </div>
      </div>
    </div>
  </div>

  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View equipment group') )
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/equipment/group_equipment.js')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
