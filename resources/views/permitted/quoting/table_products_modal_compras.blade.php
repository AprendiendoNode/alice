<p><strong class="text-danger">Tipo de cambio: $<span>{{$tipo_cambio}}</span> </strong></p>
<table id="products" width="100%">
  <thead style="background-color: #0E2A38;color:white;">
    <tr>
      <th colspan="4">Descripción</th>
      <th align="center">Cant. Sug.</th>
      <th align="center">Cant. Req.</th>
      <th class="text-center">Precio unitario</th>
      <th class="text-center">Moneda</th>
      <th class="text-center">Desc. %</th>
      <th class="text-center">Total</th>
      <th class="text-center">Total USD</th>
    </tr>
  </thead>
  <tbody>
    @php
      $total_ea = 0.0;
      $total_materiales = 0.0;
      $total_mano_obra = 0.0;
      $background_progress = "progress-bar-warning";
    @endphp

    @foreach($equipo_activo as $producto)
      @php
      if($producto->order_status_id == 4) $background_progress  = "progress-bar-success";
      else if($producto->order_status_id == 5 || $producto->order_status_id == 6) $background_progress  = "progress-bar-primary";
      else $background_progress  = "progress-bar-warning";
      @endphp
      <tr id="{{$producto->id}}">
        <td colspan="4" class="descripcion">{{$producto->producto}}</td>
        <td align="center">{{(int)$producto->cantidad_sugerida}}</td>
        <td class="text-bold" align="center">{{ (int)$producto->cantidad}}</td>
        <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
        <td align="center">{{$producto->currency}}</td>
        <td align="center">{{$producto->descuento}}</td>
        <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
        <td class="p-left" align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
      </tr>
    @php $total_ea += $producto->total_usd @endphp
    @endforeach

    <tr class="bg-secondary text-white font-weight-bold">
        <td></td>
        <td colspan="4"></td>
        <td colspan="4" align="right">Total Equipo activo USD</td>
        <td colspan="3" align="right">$ {{ number_format($total_ea, 2, '.', ',') }}</td>
    </tr>

    @foreach($materiales as $producto)
      @php
        if($producto->order_status_id == 4) $background_progress  = "progress-bar-success";
        else if($producto->order_status_id == 5 || $producto->order_status_id == 6) $background_progress  = "progress-bar-primary";
        else $background_progress  = "progress-bar-warning";
      @endphp
      <tr id="{{$producto->id}}">
        <td colspan="4" class="descripcion">{{$producto->producto}}</td>
        <td align="center">{{(int)$producto->cantidad_sugerida}}</td>
        <td class="text-bold" align="center">{{ (int)$producto->cantidad}}</td>
        <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
        <td align="center">{{$producto->currency}}</td>
        <td align="center">{{$producto->descuento}}</td>
        <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
        <td class="p-left" align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
      </tr>
    @php  $total_materiales += $producto->total_usd @endphp
    @endforeach

    <tr class="bg-secondary text-white font-weight-bold">
        <td></td>
        <td colspan="4"></td>
        <td colspan="4" align="right">Total Materiales USD</td>
        <td colspan="3" align="right">$ {{ number_format($total_materiales, 2, '.', ',') }}</td>
    </tr>

    @if ($mano_obra != '[]')
      @foreach($mano_obra as $producto)
        @php
          if($producto->order_status_id == 4) $background_progress  = "progress-bar-success";
          else if($producto->order_status_id == 5 || $producto->order_status_id == 6) $background_progress  = "progress-bar-primary";
          else $background_progress  = "progress-bar-warning";
        @endphp
        <tr id="{{$producto->id}}">
          <td colspan="4" class="descripcion">{{$producto->producto}}</td>
          <td align="center">{{(int)$producto->cantidad_sugerida}}</td>
          <td class="text-bold" align="center">{{ (int)$producto->cantidad}}</td>
          <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
          <td align="center">{{$producto->currency}}</td>
          <td align="center">{{$producto->descuento}}</td>
          <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
          <td class="p-left" align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
        </tr>
      @php $total_mano_obra += $producto->total_usd @endphp
      @endforeach
    @else

    @endif
    <tr class="bg-secondary text-white font-weight-bold">
        <td></td>
        <td colspan="4"></td>
        <td colspan="4" align="right">Total Mano de obra USD</td>
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
          <td colspan="5" align="right">Total Equipo Activo USD</td>
          <td colspan="3" class="red-color" align="right">$ {{ number_format($total_ea, 2, '.', ',') }}</td>
      </tr>
      <tr>
          <td></td>
          <td></td>
          <td colspan="4" align="right">Total Material USD</td>
          <td colspan="3" class="red-color" align="right">$ {{ number_format($total_materiales, 2, '.', ',') }}</td>
      </tr>
      <tr>
          <td></td>
          <td></td>
          <td colspan="4" align="right">Total Mano de obra USD</td>
          <td colspan="3" class="red-color" align="right">$ {{ number_format($total_mano_obra, 2, '.', ',') }}</td>
      </tr>
      <tr>
        @php
          $total = 0.0;
          $total = $total_ea + $total_materiales + $total_mano_obra;
        @endphp
          <td></td>
          <td></td>
          <td colspan="4" align="right">Total USD</td>
          <td colspan="3" class="red-color" align="right" class="">$ {{ number_format($total, 2, '.', ',') }}</td>
      </tr>
  </tfoot>
</table>

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

  table tbody td:last-child{
    font-weight: bold;
  }

  table tbody tr:nth-child(odd) {background: #F7F2F2}

  table tfoot td, table tfoot th {
    border-bottom: 1px solid white !important;
  }

  .p-left{
    padding-left: 8px !important;
  }

  .progress-bar{
    margin: 4px !important;
    color: #393E46;
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

  .descripcion{
    text-transform: uppercase;
    font-weight: bold;
    font-size: 13px !important;
  }

</style>
