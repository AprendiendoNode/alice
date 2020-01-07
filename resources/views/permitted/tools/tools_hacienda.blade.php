@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View guest review') )
    {{ trans('message.title_paquetes') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View detailed for hotel') )
    {{ trans('message.breadcrumb_paquetes') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View guest review') )
      <div class="row">
        <div class="col-md-12 grid-margin-onerem  stretch-card">
          <div class="card">
            <div class="card-body">
              <p class="mt-2 card-title">Paquetes comprados en hacienda/Marina.</p>
              <div class="d-flex justify-content-center pt-3"></div>
              
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="row">
                  <form id="search_info" name="search_info" class="form-inline" method="post">
                   {{ csrf_field() }}
                   <div class="col-md-8">
                     <div class="input-group">
                       <span class="input-group-addon"><i class="fas fa-calendar-alt fa-2x"></i></span>
                       <input id="date_to_search" type="text" class="form-control form-control-sm" name="date_to_search">
                     </div>
                   </div>
                   <div class="col-md-4">
                     <button id="boton-aplica-filtro" type="button" class="btn btn-sm btn-info filtroMonth">
                       <i class="fas fa-filter" aria-hidden="true"></i>  Filtrar
                     </button>
                   </div>
                  </form>
                </div>
              </div>
              <br>
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="row">
                  <div class="col-md-4">
                     <button id="boton-aplica-filtro_todos" type="button" class="btn btn-sm btn-info filtroAll">
                       <i class="fas fa-filter" aria-hidden="true"></i>  Todos
                     </button>
                   </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="table_paquetes" name='table_paquetes' class="table table-striped border display nowrap compact-tab" style="width:100%; font-size: 10px;">
                      <thead class="bg-primary">
                        <tr>
                          <th>Paquete</th>
                          <th>Nombre</th>
                          <th>Apellido</th>
                          <th>Wificode</th>
                          <th>Reservación</th>
                          <th>Owner</th>
                          <th>Sitio</th>
                          <th>Precio</th>
                          <th>Creación</th>
                          <th>expiration</th>
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
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View detailed for hotel') )
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('js/admin/tools/paquetes_tools.js')}}"></script>
  @else
  @endif
@endpush
