@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View noc') )
    <strong>Dashboard de operaciones</strong>
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View noc') )

  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View noc') )
    NOC
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
            <div class="card-body">
              <div class="text-center">
                <h4>Check List actividades diarias del ITC</h4>
                <br>
                <table id="table_sitios" class="table table-striped table-bordered compact-tab table-hover">
                  <thead class="bg-aqua text-center">
                    <tr>
                      <th>No.</th>
                      <th>Rubro</th>
                      <th>Si</th>
                      <th>No</th>
                      <th>NA</th>
                    </tr>
                  </thead>
                  <tbody class="text-center"style="font-size: 11px;">
                    <tr>
                      <td>1</td>
                      <td>Revisar Calendario de citas de hoy - Planear Mi dia</td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Seguimiento, documentación y cierre de tickets</td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Uso del Uniforme de ITC</td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Uso de llave de ITC en el uniforme</td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td>Asistencia al gym</td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td>Mantener y dejar ordenado sus lugares de trabajo (no almacenar cajas ni equipo)</td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                    </tr>
                    <tr>
                      <td>7</td>
                      <td>Trato cordial y amable a todos</td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                    </tr>
                    <tr>
                      <td>8</td>
                      <td>Revisar Calendario de citas de los siguientes 2 dias</td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                      <td> <input type="checkbox" name="" value=""> </td>
                    </tr>

                  </tbody>
                </table>

                <div class="">

                                  <h4>Check List por cliente(entrega el día 5 del mes)</h4>
                                  <br>
                                  <table id="table_sitios" class="table table-striped table-bordered compact-tab table-hover">
                                    <thead class="bg-aqua text-center">
                                      <tr>
                                        <th>No.</th>
                                        <th>Rubro</th>
                                        <th>Si</th>
                                        <th>No</th>
                                        <th>NA</th>
                                      </tr>
                                    </thead>
                                    <tbody class="text-center"style="font-size: 11px;">
                                      <tr>
                                        <td>1</td>
                                        <td>Reporte de Red Elaborado y entregado al cliente o en la carpeta de acceso al cliente</td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                      </tr>
                                      <tr>
                                        <td>2</td>
                                        <td>NPS contestado</td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                      </tr>
                                      <tr>
                                        <td>3</td>
                                        <td>Factura Entregada al cliente</td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                      </tr>
                                      <tr>
                                        <td>4</td>
                                        <td>Memoria Técnica Actualizada</td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                      </tr>
                                      <tr>
                                        <td>5</td>
                                        <td>Inventario Actualizado</td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                        <td> <input type="checkbox" name="" value=""> </td>
                                      </tr>
                                    </tbody>
                                  </table>
                </div>

                <div class="">
                  <h4>Check List por cliente (entrega dia 20)</h4>
                  <br>
                  <table id="table_sitios" class="table table-striped table-bordered compact-tab table-hover">
                    <thead class="bg-aqua text-center">
                      <tr>
                        <th>No.</th>
                        <th>Rubro</th>
                        <th>Si</th>
                        <th>No</th>
                        <th>NA</th>
                      </tr>
                    </thead>
                    <tbody class="text-center"style="font-size: 11px;">
                      <tr>
                        <td>1</td>
                        <td>Visita a cliente</td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Detecta oportunidades del cliente</td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Revisión de Información del cliente en Alice (Dashboard del cliente)</td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>Detecta oportunidades de clientes nuevos  en el trayecto de visita a clientes asignados</td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>Mantenimiento Preventivo o correctivo a  MDF/IDF (de acuerdo a calendario)</td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td>Realizar  Backup de equipos de comunicaciones ZD, SonicWall, ZQ, SW, etc.</td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                      </tr>
                      <tr>
                        <td>7</td>
                        <td>Revisar y renovar licencia de ZD (si corresponde) </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                      </tr>
                      <tr>
                        <td>8</td>
                        <td>Cliente al corriente en el pago de factura del mes</td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                        <td> <input type="checkbox" name="" value=""> </td>
                      </tr>

                    </tbody>
                  </table>
                </div>

              </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <style media="screen">
    .tableFixHead          { overflow-y: auto; height: 620px; }
    .tableFixHead thead th { position: sticky !important; top: 0; }
    .bg-aqua{
    background: #02948c;
    }
    </style>
@endpush
