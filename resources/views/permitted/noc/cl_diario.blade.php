@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View noc') )
    <strong>CL diario</strong>
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
<!--
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
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Detecta oportunidades del cliente</td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Revisión de Información del cliente en Alice (Dashboard del cliente)</td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>Detecta oportunidades de clientes nuevos  en el trayecto de visita a clientes asignados</td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>Mantenimiento Preventivo o correctivo a  MDF/IDF (de acuerdo a calendario)</td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td>Realizar  Backup de equipos de comunicaciones ZD, SonicWall, ZQ, SW, etc.</td>
                      </tr>
                      <tr>
                        <td>7</td>
                        <td>Revisar y renovar licencia de ZD (si corresponde) </td>

                      </tr>
                      <tr>
                        <td>8</td>
                        <td>Cliente al corriente en el pago de factura del mes</td>

                      </tr>

                    </tbody>
                  </table>
                </div>-->
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
    <script src="{{ asset('js/admin/noctools/checklist.js?v=1.0.0')}}"></script>
    <script type="text/javascript">
    var cl_diario = {!! json_encode($cl_diario->toArray()) !!};
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type:"POST",
      url:"/get_cl_diario",
      data:{_token:_token},
      success:function(data){
        table_antenas(data,$('#table_cl_diario'));
      },
      error:function(data){

      }
    });

    $.ajax({
      type:"POST",
      url:"/get_cl_5_dia",
      data:{_token:_token},
      success:function(data){
        table_cl_5(data,$('#table_cl_5'));
      },
      error:function(data){

      }
    });


    </script>

    <style media="screen">
    .tableFixHead          { overflow-y: auto; height: 620px; }
    .tableFixHead thead th { position: sticky !important; top: 0; }
    .bg-aqua{
    background: #02948c;
    }
    </style>
@endpush
