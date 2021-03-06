@extends('layouts.admin')

@section('contentheader_description')
  @if( auth()->user()->can('View dash sabana') )

  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View dash sabana') )

<div class="card px-3 py-2">
  <div class="row row-select">
    <select id="select_sitios" class="form-control select2 col-md-12" style="width: 100%;">
      <option value="" selected> Todos los sitios</option>
      @forelse ($hotels as $data_hotel)
        <option value="{{ $data_hotel->id }}"> {{ $data_hotel->nombre }} </option>
      @empty
      @endforelse
    </select>
  </div>
  <div class="row row-buttons d-none py-1">
    <button type="button" id="agregarHabitacion" class="mr-1 btn btn-sm btn-outline-primary font-weight-bold d-none" data-toggle="modal" data-target="#AgregarArea"><i class="fas fa-plus-square"></i> Nueva habitación</button>
    <button type="button" id="BtnGeneral" class="mr-1 mx-auto btn btn-sm btn-outline-info font-weight-bold" data-toggle="modal" data-target="#VistaGeneral"><i class="fas fa-th-list"></i> Vista general</button>
    <button type="button" id="agregarSitio" class="btn btn-sm btn-outline-secondary font-weight-bold d-none" data-toggle="modal" data-target="#modalañadir"><i class="fas fa-cogs"></i> Ajustes</button>
    <div class="mx-auto">
      <button type="button" id="leftPiso" class="btn btn-sm btn-outline-link font-weight-bold"><i class="fas fa-caret-square-left"></i></i></button>
      <button type="button" id="piso" class="btn btn-sm btn-outline-dark font-weight-bold" data-toggle="modal" data-target="#ElegirPiso">Cargando</button>
      <button type="button" id="rightPiso" class="btn btn-sm btn-outline-link font-weight-bold"><i class="fas fa-caret-square-right"></i></i></button>
    </div>
    <button type="button" id="descartarMovimientos" class="mr-1 btn btn-sm btn-danger font-weight-bold d-none"><i class="fas fa-compress-arrows-alt"></i> Descartar</button>
    <button type="button" id="salvarMovimientos" class="btn btn-sm btn-success font-weight-bold text-dark d-none"><i class="fas fa-expand-arrows-alt"></i> Sincronizar</button>
  </div>
  <div class="row">
    <div id="blob-containment-wrapper" class="d-none"></div>
    <div id="containment-wrapper" class="d-none" style="width: 100%; height: 85vh; min-height: 400px;">
      <div id="mapa" style="border-radius: 10px;">

      </div>
    </div>
  </div>
<!----->
<div id="modalañadir"class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><i class="fas fa-map-marked"></i>&nbsp; Añadir un nuevo sitio</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form id="form_site" enctype="multipart/form-data" method="POST" action="" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Nombre:</span>
        </div>
        <input id="nombreSitio" name="nombreSitio"type="text" class="form-control" placeholder="Nombre del sitio" aria-label="Nombre del área" required>
      </div>
      <div class="mb-3">
        <label id="lblogo" for="LogoFile" class="file-upload btn btn-warning btn-block rounded-pill shadow"><span id="txtLogo"><i class="fa fa-upload mr-2"></i>Seleccione el logo..</span>
            <input id="LogoFile" name="LogoFile" type="file" >
        </label>
      </div>
      <hr class="separator">
      <div class="input-group mb-3">
        <label id="lbmap" for="MapFile" class="file-upload btn btn-primary btn-block rounded-pill shadow"> <span id="txtMap"><i class="fa fa-upload mr-2"></i>Seleccionar el mapa...</span>
            <input id="MapFile" name="MapFile" type="file" >
        </label>

      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancelar</button>
      <button type="submit" id="submit_site" class="btn btn-primary" data-dismiss="modal" name="button">Guardar</button>
    </div>
    </form>
  </div>
</div>
</div>

  <!-- AgregarArea -->
  <div class="modal fade" id="AgregarArea" tabindex="-1" role="dialog" aria-labelledby="AgregarAreaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="AgregarAreaLabel"><i class="fas fa-plus-square"></i> Nueva habitación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Nombre:</span>
            </div>
            <input id="nombreArea" type="text" class="form-control" placeholder="Nombre o número de la habitación" aria-label="Nombre o número de la habitación">
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Ubicación (Nombre o número del piso):</span>
            </div>
            <select id="pisoAgregarArea" class="form-control" style="width: 100%;">

            </select>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Estado actual:</span>
            </div>
            <select id="estado" class="form-control">
              <option value="1">Disponible</option>
              <option value="2">Ocupada</option>
              <option value="0" selected>No disponible</option>
            </select>
          </div>
          <!--<div class="input-group mb-3">
  		  <div class="input-group-prepend">
  			<span class="input-group-text">Equipos activos en la habitación:</span>
  		  </div>
  		  <select id="equipos" class="form-control" style="width: 100%;" multiple="multiple">
  		    <option>Antena número 1</option>
  		    <option>Switch Cisco 2660</option>
  		    <option>Antena de largo alcance</option>
  		  </select>
  		</div>-->
          <div class="descartar d-none text-danger text-center">*No has sincronizado tus movimientos en el mapa*</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button id="AgregarAreaButton" type="button" class="btn btn-primary">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- ElegirPiso -->
  <div class="modal fade" id="ElegirPiso" tabindex="-1" role="dialog" aria-labelledby="ElegirPisoLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ElegirPisoLabel"><i class="fas fa-clone"></i> Elegir piso</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="input-group mb-3">
            <select id="cambiarPiso" class="form-control" style="width: 100%;">

            </select>
          </div>
          <div class="descartar d-none text-danger text-center">*No has sincronizado tus movimientos en el mapa*</div>
        </div>
      </div>
    </div>
  </div>
  <!-- CambiarNombre -->
  <div class="modal fade" id="CambiarNombre" tabindex="-1" role="dialog" aria-labelledby="CambiarNombreLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="CambiarNombreLabel"><i class="fas fa-edit"></i> Cambiar nombre</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Nuevo nombre:</span>
            </div>
            <input id="nuevoNombre" type="text" class="form-control" aria-label="Nombre o número de la habitación">
          </div>
          <div class="descartar d-none text-danger text-center">*No has sincronizado tus movimientos en el mapa*</div>
          <!--<input type="hidden" id="selected_area" name="" value="">-->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button id="CambiarNombreButton" type="button" class="btn btn-primary">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- CambiarEstado -->
  <div class="modal fade" id="CambiarEstado" tabindex="-1" role="dialog" aria-labelledby="CambiarEstadoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="CambiarEstadoLabel"><i class="fas fa-sync-alt"></i> Cambiar estado</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Nuevo estado:</span>
            </div>
            <select id="nuevoEstado" class="form-control">
              <option value="1" selected>Disponible</option>
              <option value="2">Ocupada</option>
              <option value="0">No disponible</option>
            </select>
          </div>
          <div class="descartar d-none text-danger text-center">*No has sincronizado tus movimientos en el mapa*</div>
          <!--<input type="hidden" id="selected_area" name="" value="">-->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button id="CambiarEstadoButton" type="button" class="btn btn-primary">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- CambiarPisoMenu -->
  <div class="modal fade" id="CambiarPisoMenu" tabindex="-1" role="dialog" aria-labelledby="CambiarPisoMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="CambiarPisoMenuLabel"><i class="fas fa-clone"></i> Cambiar piso</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="input-group mb-3">
            <p class="d-inline" style="background-color: #e9ecef; padding-top: 4px; padding-left: 17px; width: 40%; height: 28px;"><span>Nuevo piso:</span></p>
            <select id="nuevoPiso" class="form-control8" style="width: 60%;">

            </select>
          </div>
          <div class="descartar d-none text-danger text-center">*No has sincronizado tus movimientos en el mapa*</div>
          <!--<input type="hidden" id="selected_area" name="" value="">-->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button id="CambiarPisoMenuButton" type="button" class="btn btn-primary">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- EliminarArea -->
  <div class="modal fade" id="EliminarArea" tabindex="-1" role="dialog" aria-labelledby="EliminarAreaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="EliminarAreaLabel"><i class="fas fa-trash-alt"></i> Eliminar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <p style="font-weight: bold;">¿Está seguro?<p>
              <p>!Este cambio es permanente y no podrá ser revertido!</p>
              <div class="descartar d-none text-danger text-center">*No has sincronizado tus movimientos en el mapa*</div>
              <!--<input type="hidden" id="selected_area" name="" value="">-->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button id="EliminarAreaButton" type="button" class="btn btn-primary">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
  <!--Vista general-->
  <div class="modal fade" id="VistaGeneral" tabindex="-1" role="dialog" aria-labelledby="VistaGeneralLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <!--<div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="VistaGeneralLabel"><i class="far fa-eye"></i> Vista general</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>-->
        <div class="modal-body">
          <table id="lugares" class="table  table-borderless compact-tab w-100" style="">
            <thead class="bg-primary">
              <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Piso</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>

            </tbody>

          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
  @if( auth()->user()->can('View dash sabana') )

  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css" rel="stylesheet">
  <link href="css/sockets/cover.css" rel="stylesheet">
  <link href="css/sockets/toastr.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>
  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
  <script src="js/admin/sockets/dashboard/vistageneral.js" charset="utf-8"></script>
  <script src="js/admin/sockets/dashboard/main_socket.js" charset="utf-8"></script>
  <script src="js/admin/sockets/toastr.js"></script>
  <script src="js/admin/sockets/jquery.ui.touch-punch.min.js"></script>
  <script src="http://localhost:8081/socket.io/socket.io.js" charset="utf-8"></script>
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>-->
  <script>

    const socket = io.connect('http://localhost:8081');

    var hotel_id = 16;
    var width = 20;
    var height = 20;
    var left = 20;
    var _top = 20;
    var hotel_mapa = "20";

    var allAreas = null;
    var cambios = [];
    var pisoActual = "";
    var elementsarray = [];
    var ctrl_status = 1; //0 is OFF, 1 is ACTIVE and 2 is PRESSED

    $(window).on("load", function() {

      socket.on('cambiosExternos', function() {

        toastr.warning('', '!Alguien ha modificado el mapa!', {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "1500",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        });

      });

      $("#pisoAgregarArea").select2({
        dropdownParent: $('#AgregarArea'),
        placeholder: 'Piso 1',
        tags: true
      });

      $("#nuevoPiso").select2({
        dropdownParent: $('#CambiarPisoMenu'),
        placeholder: 'Piso 1',
        tags: true
      });

      $("#cambiarPiso").select2({
        dropdownParent: $('#ElegirPiso')
      });

      /*$("#equipos").select2({
        placeholder: 'Ninguno',
        allowClear: true
      });*/

    });

  </script>
  <script src="js/admin/sockets/dashboard/context-menu.js"></script>
  <script src="js/admin/sockets/dashboard/context-menu-mapa.js"></script>
  <script src="js/admin/sockets/dashboard/mapa.js?v1.0"></script>
  <script src="js/admin/sockets/dashboard/areas.js"></script>
  <script src="js/admin/sockets/dashboard/pisos.js"></script>
  @else
    <!--NO SCRIPTS-->
  @endif
@endpush
