@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View checklist') )
    <strong>  Checklist</strong>
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View checklist') )

  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View checklist') )
    Checklist
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View checklist') )
<div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
            <div class="card-body">
              <div class="text-center">
                <h4>Check List actividades diarias del ITC</h4>
                <div class="row pb-3">
                  <div class="row pb-3 w-100">
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-3 ">
                      <div class="form-group" id="date_from">
                        <label class="control-label" for="date_to_search">
                          {{ __('general.date_from') }}
                        </label>
                        <div class="input-group mb-3">
                          <input type="text"  datas="filter_date_from" id="date_to_search" name="date_to_search" class="form-control form-control-sm" placeholder="" value="" required>
                          <div class="input-group-append">
                            <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3  pt-4">
                      <button id="btn-filtro"  type="button"
                              class="btn btn-primary" >
                          <i class="fas fa-filter"> Filtrar</i>
                      </button>
                    </div>
                  </div>
                </div>
                <br>
                <table id="table_cl_diario" class="table table-striped table-bordered compact-tab table-hover">
                  <thead class="bg-aqua text-center">
                    <tr>
                      <th>Nombre.</th>
                      <th>Revisar Calendario de citas de hoy - Planear Mi dia</th>
                      <th>Seguimiento, documentación y cierre de tickets</th>
                      <th>Uso del Uniforme de ITC</th>
                      <th>Uso de llave de ITC en el uniforme</th>
                      <th>Asistencia al gym</th>
                      <th>Mantener y dejar ordenado sus lugares de trabajo (no almacenar cajas ni equipo)</th>
                      <th>Trato cordial y amable a todos</th>
                      <th>Revisar Calendario de citas de los siguientes 2 dias</th>
                      <th>Limpiar y diagnosticar equipos dañado y entregar a almacén.</th>
                      <th>Fecha</th>
                    </tr>
                  </thead>
                  <tbody class="text-center"style="font-size: 11px;">

                  </tbody>
                </table>
                </div>

                <div class="row pt-4">
                  <div class="col-md-12">
                    <div class="text-center">
                      <h4>Actividades principales ITC</h4>
                      <br>
                      <div class="table-responsive">

                      <table id="table_act_prin" class="table table-striped table-bordered compact-tab table-hover">
                        <thead class="bg-aqua text-center">
                          <tr>
                              <th>Nombre</th>
                              <th>Seguimiento correos</th>
                              <th>Atención de tickets</th>
                              <th>Visita a clientes</th>
                              <th>Seguimiento a encuestas</th>
                              <th>Seguimiento a instalaciones nuevas y mantenimiento</th>
                              <th>Levantamiento</th>
                              <th>Mantenimiento</th>
                              <th>Seguimiento a llamadas</th>
                              <th>Otros</th>
                              <th>Fecha</th>
                          </tr>
                        </thead>
                        <tbody class="text-center"style="font-size: 11px;">


                        </tbody>
                      </table>
                      </div>
                    </div>
                  </div>

                </div>

  <div class="row pt-4">
      <div class="col-md-12">

          <div class="text-center">
              <h4>Check List por cliente(entrega el día 5 del mes)</h4>
              <br>
              <table id="table_cl_5" class="table table-striped table-bordered compact-tab table-hover w-100">
                  <thead class="bg-aqua text-center">
                      <tr>
                          <th>Nombre</th>
                          <th>Nombre sitio</th>
                          <th>Reporte de elaborado y entregado al cliente o en la carpeta de acceso al cliente</th>
                          <th>NPS contestado</th>
                          <th>Factura entregada al cliente</th>
                          <th>Memoria eécnica actualizada</th>
                          <th>Inventario actualizado</th>
                          <th>Fecha</th>
                      </tr>
                  </thead>
                  <tbody class="text-center" style="font-size: 11px;">

                  </tbody>
              </table>
          </div>

      </div>
  </div>

                <div class="row pt-4">
                  <div class="col-md-12">
                    <div class="text-center">
                      <h4>Check List por cliente (entrega el dia 20 del mes)</h4>
                      <br>
                      <div class="table-responsive">


                      <table id="table_cl_20" class="table table-striped table-bordered compact-tab table-hover">
                        <thead class="bg-aqua text-center">
                          <tr>
                              <th>Nombre</th>
                              <th>Nombre sitio</th>
                              <th>Visita a cliente</th>
                              <th>Revisar y Asegurar disponibilidad del 98 % del equipo activo en sitio</th>
                              <th>Detecta oportunidades del cliente</th>
                              <th>Revisión de Información del cliente en Alice (Dashboard del cliente)</th>
                              <th>Detecta oportunidades de clientes nuevos  en el trayecto de visita a clientes asignados</th>
                              <th>Mantenimiento Preventivo o correctivo a  MDF/IDF (de acuerdo a calendario)</th>
                              <th>Realizar  Backup de equipos de comunicaciones ZD, SonicWall, ZQ, SW, etc.</th>
                              <th>Revisar y renovar licencia de ZD (si corresponde)</th>
                              <th>Cliente al corriente en el pago de factura del mes</th>
                              <th>Fecha</th>
                          </tr>
                        </thead>
                        <tbody class="text-center"style="font-size: 11px;">


                        </tbody>
                      </table>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="row pt-4">
                  <div class="col-md-12">
                    <div class="text-center">
                      <h4>Check List Oportunidades</h4>
                      <br>
                      <div class="table-responsive">

                      <table id="table_oportunidades" class="table table-striped table-bordered compact-tab table-hover">
                        <thead class="bg-aqua text-center">
                          <tr>
                              <th>Nombre</th>
                              <th>Detección de oportunidad de mejorar cobertura de WiFi en Sitio</th>
                              <th>Detección de oportunidad de venta de enlaces en sitio</th>
                              <th>Detección de oportunidad de venta de CCTV</th>
                              <th>Detección de apertura de nuevas propiedades de la cadena</th>
                              <th>Detección de oportunidad de servicio de Soporte</th>
                              <th>Fecha</th>
                          </tr>
                        </thead>
                        <tbody class="text-center"style="font-size: 11px;">


                        </tbody>
                      </table>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="row pt-4">
                  <div class="col-md-12">
                    <div class="text-center">
                      <h4>Check List de Instalaciones</h4>
                      <br>
                      <div class="table-responsive">


                      <table id="table_cl_instalaciones" class="table table-striped table-bordered compact-tab table-hover">
                        <thead class="bg-aqua text-center">
                          <tr>
                              <th>Nombre</th>
                              <th>Nombre sitio</th>
                              <th>Se realizo el Levantamiento en sitio.</th>
                              <th>Revisar los Horarios de Inicio de labores con el contratista</th>
                              <th>Se Revizó la Cotización y los alcances del contrato</th>
                              <th>Realizar el Documento P, con todos los materiales y equipos</th>
                              <th>Realizar Documento A para KickOff</th>
                              <th>Realizar una Junta Operativa Interna (Sitwifi) externa (Cliente)</th>
                              <th>Se tienen los Planos Arquitectonicos del Inmueble</th>
                              <th>Se tienen los Diagramas de Red y Sembrado de AP</th>
                              <th>Se Realizó el Project y entregó al cliente </th>
                              <th>Solicitar la entrega de Materiales (Administracion)</th>
                              <th>Solicitar y revisar el Equipo ACTIVO (Soporte)</th>
                              <th>Revisar el Rack que este tenga las preparaciones para tierra fisica</th>
                              <th>Revisar el Rack que tenga las preparaciones para corriente regulada</th>
                              <th>Reviasar con el contratista la Identificacion-Probado y Etiquetado de Cables UTP y FO</th>
                              <th>Revisar la Instalacion de Antenas Ruckus en Habitaciones y Áreas (aleatorio-selectivo)</th>
                              <th>Revisar la Instalacion y Configuracion de Equipo Activo</th>
                              <th>Realizar las Pruebas de Funcionamiento para entrega al cliente</th>
                              <th>Revisar la Instalacion de Enlace de Internet</th>
                              <th>Revisar la Configuracion de Enlace de Internet y Pruebas (Soporte)</th>
                              <th>Actualizar en tiempo y forma los avances de proyecto en Alice.</th>
                              <th>Realizar / Revisar la Documentacion de Proyecto y Bitacora para cierre de proyecto</th>
                              <th>Realizar / Revisar la Memoria Técnica</th>
                              <th>Realizar / Revisar la Memoria Fotográfica</th>
                              <th>Raizar la Carta de Entrega para firma con el cliente.</th>
                              <th>Fecha</th>
                          </tr>
                        </thead>
                        <tbody class="text-center"style="font-size: 11px;">


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
  {{ trans('message.denied') }}
@endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View checklist') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <script src="{{ asset('js/admin/noctools/checklist.js?v=1.4.4')}}"></script>

    <style media="screen">
    .tableFixHead          { overflow-y: auto; height: 620px; }
    .tableFixHead thead th { position: sticky !important; top: 0; }
    .bg-aqua{
    background: #02948c;
    }
    </style>
  @else
    {{ trans('message.denied') }}
  @endif
@endpush
