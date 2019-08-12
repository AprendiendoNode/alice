@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View search equipment') )
    {{ trans('message.title_equipment') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View search equipment') )
    {{ trans('message.breadcrumb_search_equipment') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View search equipment') )
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pb-3">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Reporte por periodo</h3>
            </div>
            <div class="card-body">
              <div class="form-horizontal pb-3">
                  {{ csrf_field() }}


                    <div class="form-group row">
                        <div class="input-group input-daterange">
                          <div class="col-md-1">
                              <label class=" control-label" for="month_upload_band">Periodo: </label>
                          </div>
                          <div class="col-md-3">
                              <input name="date_start"  type="text" class="form-control" value="" placeholder="AAAA-MM-DD">
                          </div>
                          <div class="col-md-1">
                              <div class="input-group-addon">to</div>
                          </div>
                          <div class="col-md-3">
                              <input name="date_end"  type="text" class="form-control" value="" placeholder="AAAA-MM-DD">
                          </div>
                          <div class="col-md-1">
                            <label class="control-label">Estatus: </label>
                          </div>
                          <div class="col-md-2">
                            <select id="select_status" name="select_status"  class="form-control select2">
                              <option value="">Elija...</option>
                              <option value="0">Todos</option>
                              @forelse ($estados as $data_estados)
                                <option value="{{ $data_estados->id }}"> {{ $data_estados->Nombre_estado }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                          <div class="col-md-1" >
                            <button type="button" class="btn btn-sm btn-info btn-search-range" >Buscar</button>
                          </div>
                        </div>
                    </div>
              </div>
              <div class=" pb-3">
                <div class="table-responsive">
                     <table id="table_equipament" cellspacing="0" class="table table-striped table-bordered table-hover compact-tab">
                       <thead>
                         <tr class="bg-primary" style="background: #088A68;">
                           <th> <small>Cliente.</small> </th>
                           <th> <small>Equipo.</small> </th>
                           <th> <small>Marca.</small> </th>
                           <th> <small>Mac.</small> </th>
                           <th> <small>Serie.</small> </th>
                           <th> <small>Modelo.</small> </th>
                           <th> <small>Estado.</small> </th>
                           <th> <small>Fecha Baja.</small> </th>
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
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pb-3">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Reporte individual</h3>
            </div>
            <div class="card-body">
              <div class="form-horizontal pb-3">
                  {{ csrf_field() }}
                 <div class="form-group row">
                   <div class="col-md-3">
                     <label class=" control-label" for="mac_input">Mac o serie: </label>
                   </div>
                     <div class="col-md-4">
                      <div class="input-group ">
                        <input name="mac_input" id="mac_input" placeholder="Minimo 4 digitos." minlength="4" type="text" class="form-control" value="">
                      </div>
                     </div>
                     <div class="col-md-2 text-right">
                       <button type="button" id="btn_search_mac" class="btn btn-sm btn-info">Buscar Mac</button>
                     </div>
                </div>
              </div>
              <div class="pb-3">
                <div class="table-responsive">
                     <table id="table_buscador" cellspacing="0" class="table table-striped table-bordered table-hover compact-tab">
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
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pb-3">
          <div class="card">
            <div class="card-header">
            <h3 class="card-title">Reporte de salidas de bodega</h3>
            </div>
            <div class="card-body">
              <div class="form-horizontal pb-3">
                  {{ csrf_field() }}
                  <div class="form-group row">
                       <div class="input-group input-daterange">
                         <div class="col-md-1">
                           <label class="control-label" for="month_upload_band">Periodo: </label>
                         </div>
                         <div class="col-md-2">
                        <input id="date_start_salida" name="date_start_salida"  type="text" class="form-control" value="">
                         </div>
                         <div class="col-md-1">
                        <div class="input-group-addon">to</div>
                         </div>
                         <div class="col-md-2">
                        <input id="date_end_salida" name="date_end_salida"  type="text" class="form-control" value="">
                         </div>
                         <div class="col-md-2">
                           <button type="button" id="btn_search_equip_departures" class="btn btn-sm btn-info">Buscar equipos</button>
                         </div>
                       </div>
                 </div>
              </div>
              <div class="pb-3">
                <div class="table-responsive">
                     <table id="tabla_departures" cellspacing="0" class="table table-striped table-bordered table-hover compact-tab">
                       <thead>
                         <tr class="bg-primary" style="background: #088A68;">
                           <th> <small>Fecha.</small> </th>
                           <th> <small>Origen</small> </th>
                           <th> <small>Destino</small> </th>
                           <th> <small>Equipo</small> </th>
                           <th> <small>Mac</small> </th>
                           <th> <small>Serie</small> </th>
                           <th> <small>Modelo</small> </th>
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
      </div>

      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pb-3">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Reporte por factura.</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
                  <form id="rep_fact" name="rep_fact" class="form-inline">
                    {{ csrf_field() }}
                    <div class="col-md-8 form-group">
                      <label for="select_one_fact" class="control-label col-md-2">No. Factura: </label>
                      <div class="col-md-10">
                        <select id="select_one_fact" name="select_one_fact"  class="form-control select2" required>
                          <option value="" selected> Elija </option>
                          @forelse ($facturas as $data_facturas)
                            <option value="{{ $data_facturas->No_Fact_Compra }}"> {{ $data_facturas->No_Fact_Compra }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>
                    <div class="col-md-1 form-group">
                        <button type="button" class="btn btn-sm btn-info search_fact"><i class="fa fa-bullseye d-inline"></i>Buscar:</button>
                    </div>
                  </form>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
                  <div class="table-responsive pt-20">
                    <table id="table_report_fact" cellspacing="0" class="table table-striped table-bordered table-hover compact-tab">
                      <thead>
                        <tr class="bg-primary" style="background: #3D71E9;">
                          <th> <small>Cliente.</small> </th>
                          <th> <small>Mac.</small> </th>
                          <th> <small>Serie.</small> </th>
                          <th> <small>Modelo.</small> </th>
                          <th> <small>Costo.</small> </th>
                          <th> <small>Estado.</small> </th>
                          <th> <small>Descripcion.</small> </th>
                          <th> <small>Fecha Registro.</small> </th>
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
        </div>

        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Reporte por modelo de equipo.</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
                  <form id="rep_model" name="rep_model"  class="form-inline">
                    {{ csrf_field() }}
                    <div class="col-md-8 form-group">
                      <label for="select_one_model" class="control-label col-md-1">Modelo: </label>
                      <div class="col-md-11">
                        <select id="select_one_model" name="select_one_model"  class="form-control select2" required>
                          <option value="" selected> Elija </option>
                          @forelse ($modelos as $data_modelos)
                            <option value="{{ $data_modelos->modelo }}"> {{ $data_modelos->modelo }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>
                    <div class="col-md-1 form-group">
                        <button type="button" class="btn btn-sm btn-info search_model"><i class="fa fa-bullseye d-inline"></i> Buscar</button>
                    </div>
                  </form>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
                  <div class="table-responsive">
                    <table id="table_report_model" cellspacing="0" class="table table-striped table-bordered table-hover compact-tab">
                      <thead>
                        <tr class="bg-primary" style="background: #403580;">
                          <th> <small>Cliente.</small> </th>
                          <th> <small>Mac.</small> </th>
                          <th> <small>Serie.</small> </th>
                          <th> <small>Modelo.</small> </th>
                          <th> <small>Costo.</small> </th>
                          <th> <small>Estado.</small> </th>
                          <th> <small>Descripcion.</small> </th>
                          <th> <small>Fecha Registro.</small> </th>
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
        </div>
      </div>


    </div>


    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View search equipment') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extras-margins-padding.css')}}" >
    <script src="{{ asset('js/admin/equipment/new_req_fac_mod.js')}}"></script>
    <script src="{{ asset('js/admin/equipment/search_equipment.js')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
