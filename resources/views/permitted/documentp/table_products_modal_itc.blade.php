<style media="screen">

table{
    border-collapse: collapse;
}
tfoot tr td{
    font-weight: bold;
}

table td, table th {
  border-bottom: 1px solid #D1D1D1;
}

table tbody tr:nth-child(odd) {background: #F7F2F2}

table tfoot td, table tfoot th {
  border-bottom: 1px solid white !important;
}

.p-left{
  padding-left: 8px !important;
}

</style>
<p><strong class="text-danger">Tipo de cambio: $<span>{{$tipo_cambio}}</span> </strong></p>
<div class="table-responsive">
  <table id="products" width="100%">
    <thead style="background-color: #0E2A38;color:white;">
      <tr>
        <th>Descripción</th>
        <th align="center">Cant. Sug.</th>
        <th align="center">Cant. Req.</th>
        <th class="text-center">Precio unitario</th>
        <th class="text-center">Moneda</th>
        <th class="text-center">Desc. %</th>
        <th class="text-center">Total</th>
        <th class="text-center">Total USD</th>
        <th class="text-center">Recibido</th>
        <th class="text-center" style="min-width: 80px;">% de compra</th>
        <th class="text-center">Orden de compra</th>
        <th class="text-center">Fecha de entrega</th>
        <th width="90" class="text-center">Estatus</th>
      </tr>
    </thead>
    <tbody>
      @php
        $total_ea = 0.0;
        $total_materiales = 0.0;
        $total_mano_obra = 0.0;
        $background_progress = "bg-warning";
      @endphp

      @foreach($equipo_activo as $producto)
        @php
        if($producto->order_status_id == 4) $background_progress  = "bg-success";
        else if($producto->order_status_id >= 5) $background_progress  = "bg-primary";
        else $background_progress  = "bg-warning";
        @endphp
        <tr id="{{$producto->id}}">
          <td class="descripcion">{{$producto->producto}}</td>
          <td align="center">{{$producto->cantidad_sugerida}}</td>
          <td class="text-bold" align="center">{{$producto->cantidad}}</td>
          <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
          <td align="center">{{$producto->currency}}</td>
          <td align="center">{{$producto->descuento}}</td>
          <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
          <td class="p-left" align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
          <td align="center">{{$producto->cantidad_recibida}}</td>
          <td  style="vertical-align: center;">
              <div style="height: 14px;width:{{$producto->porcentaje_compra}}%" class="progress-bar {{$background_progress}}  progress-bar-striped" role="progressbar"
                aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{$producto->porcentaje_compra}}">
                <span>{{$producto->porcentaje_compra}}%</span>
              </div>
          </td>
          <td align="center">{{$producto->purchase_order}}</td>
          <td align="center">{{ ($producto->fecha_entrega != null ? date("d-m-Y", strtotime($producto->fecha_entrega))  : $producto->fecha_entrega) }}</td>
          <td align="center">{{$producto->order_name}}</td>
        </tr>
      @php $total_ea += $producto->total_usd @endphp
      @endforeach

      <tr class="bg-blue text-bold">
          <td></td>
          <td colspan="5"></td>
          <td colspan="5" align="right">Total Equipo Activo USD</td>
          <td colspan="3" align="right">$ {{ number_format($total_ea, 2, '.', ',') }}</td>
      </tr>

      @foreach($materiales as $producto)
        @php
          if($producto->order_status_id == 4) $background_progress  = "bg-success";
          else if($producto->order_status_id >= 5) $background_progress  = "bg-primary";
          else $background_progress  = "bg-warning";
        @endphp
        <tr id="{{$producto->id}}">
          <td class="descripcion">{{$producto->producto}}</td>
          <td align="center">{{$producto->cantidad_sugerida}}</td>
          <td class="text-bold" align="center">{{$producto->cantidad}}</td>
          <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
          <td align="center">{{$producto->currency}}</td>
          <td align="center">{{$producto->descuento}}</td>
          <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
          <td class="p-left" align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
          <td align="center">{{$producto->cantidad_recibida}}</td>
          <td  style="vertical-align: center;">
              <div style="height: 14px;width:{{$producto->porcentaje_compra}}%" class="progress-bar {{$background_progress}}  progress-bar-striped" role="progressbar"
                aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{$producto->porcentaje_compra}}">
                <span>{{$producto->porcentaje_compra}}%</span>
              </div>
          </td>
          <td align="center">{{$producto->purchase_order}}</td>
          <td align="center">{{ ($producto->fecha_entrega != null ? date("d-m-Y", strtotime($producto->fecha_entrega))  : $producto->fecha_entrega) }}</td>
          <td align="center">{{$producto->order_name}}</td>
        </tr>
      @php  $total_materiales += $producto->total_usd @endphp
      @endforeach

      <tr class="bg-blue text-bold">
          <td></td>
          <td colspan="5"></td>
          <td colspan="5" align="right">Total Materiales USD</td>
          <td colspan="3" align="right">$ {{ number_format($total_materiales, 2, '.', ',') }}</td>
      </tr>

      @if ($mano_obra != '[]')
        @foreach($mano_obra as $producto)
          @php
            if($producto->order_status_id == 4) $background_progress  = "bg-success";
            else if($producto->order_status_id >= 5) $background_progress  = "bg-primary";
            else $background_progress  = "bg-warning";
          @endphp
          <tr id="{{$producto->id}}">
            <td class="descripcion">{{$producto->producto}}</td>
            <td align="center">{{$producto->cantidad_sugerida}}</td>
            <td class="text-bold" align="center">{{$producto->cantidad}}</td>
            <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
            <td align="center">{{$producto->currency}}</td>
            <td align="center">{{$producto->descuento}}</td>
            <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
            <td class="p-left" align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
            <td align="center">{{$producto->cantidad_recibida}}</td>
            <td  style="vertical-align: center;">
                <div style="height: 14px;width:{{$producto->porcentaje_compra}}%" class="progress-bar {{$background_progress}}  progress-bar-striped" role="progressbar"
                  aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{$producto->porcentaje_compra}}">
                  <span>{{$producto->porcentaje_compra}}%</span>
                </div>
            </td>
            <td align="center">{{$producto->purchase_order}}</td>
            <td align="center">{{ ($producto->fecha_entrega != null ? date("d-m-Y", strtotime($producto->fecha_entrega))  : $producto->fecha_entrega) }}</td>
            <td align="center">{{$producto->order_name}}</td>
          </tr>
        @php $total_mano_obra += $producto->total_usd @endphp
        @endforeach
      @else

      @endif
      <tr class="bg-blue text-bold">
          <td></td>
          <td colspan="5"></td>
          <td colspan="5" align="right">Total Mano de obra USD</td>
          <td colspan="3" align="right">$ {{ number_format($total_mano_obra, 2, '.', ',') }}</td>
      </tr>
    </tbody>

    <tfoot>
      <tr>
          <td></td>
          <td colspan="3"></td>
          <td align="right"></td>
          <td align="right">-</td>
      </tr>
        <tr>
            <td></td>
            <td id="" rowspan="4" colspan="4"> </td>
            <td colspan="6" align="right">Total Equipo Activo USD</td>
            <td colspan="3" class="text-danger" align="right">$ {{ number_format($total_ea, 2, '.', ',') }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="5" align="right">Total Material USD</td>
            <td colspan="3" class="text-danger" align="right">$ {{ number_format($total_materiales, 2, '.', ',') }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="5" align="right">Total Mano de obra USD</td>
            <td colspan="3" class="text-danger" align="right">$ {{ number_format($total_mano_obra, 2, '.', ',') }}</td>
        </tr>
        <tr>
          @php
            $total = 0.0;
            $total = $total_ea + $total_materiales + $total_mano_obra;
          @endphp
            <td></td>
            <td></td>
            <td colspan="5" align="right">Total USD</td>
            <td colspan="3" class="text-danger" align="right" class="">$ {{ number_format($total, 2, '.', ',') }}</td>
        </tr>
    </tfoot>
  </table>
</div>
<style media="screen">
.progress-bar{
  margin: 4px !important;
  color: #393E46;
}

.bg-primary{
  background-color: #0078BF !important;
}

.bg-blue{
  background-color: #0078BF !important;
  color: white;
}

.text-bold{
  font-weight: bold;
}

table#products{
  font-size: 13px
}

table#products thead tr th{
  padding: 0px 2px;
  font-size: 12px;
}

table#products tbody tr td{
  padding: 0px 3px;
}

.descripcion, .set-status{
  font-size: 12px !important;
}

.editable-error-block{
  position: absolute;
  background-color:  white;
  margin-top: 35px !important;
}


</style>
