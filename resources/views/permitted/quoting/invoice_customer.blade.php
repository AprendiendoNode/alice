<html lang="en">
<head>
<meta charset="UTF-8">
<title>
  COTIZACIÓN
</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
        border-collapse: collapse;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }

    table#products td, table#products th {
      border-bottom: 1px solid #D1D1D1;
    }

    table#products tfoot td, table#products tfoot th {
      border-bottom: 1px solid white !important;
    }

    .gray {
        background-color: lightgray;
    }
    .red-color{
      color: #D5232C;
    }
    .bg-blue{
      background-color: #00427F !important;
      color: white;
      font-weight: bold;
    }

    .description{
      font-size: 11px;
      font-weight: bold;
    }

    #watermark {
      position: fixed;
      bottom:   10cm;
      left:     5.5cm;
      /** Change image dimensions**/
      width:    8cm;
      height:   8cm;
      /** Your watermark should be behind every content**/
      z-index:  1000;
      text-align: center;
    }

</style>

</head>
<body>
  <div id="watermark">

  </div>
  <table width="100%">
    <tr>
        <td valign="top"><img width="120" src="{{ public_path('/images/users/logo.svg') }}"/></td>
        <td align="right">
            <h3>SITWIFI S.A DE C.V</h3>
            COTIZACIÓN
            <pre>
                Fecha: {{$fecha}}
                Folio: {{$folio}}
                Proyecto: {{$nombre_proyecto}}
                Vertical: {{$vertical}}
            </pre>
        </td>
    </tr>

  </table>

  <table width="100%">
    <tr>
        <td><strong>IT Concierge:</strong> {{$itc}}</td>
        <td align="right"><strong>Comercial:</strong> {{$comercial}}</td>
    </tr>
    <tr>
      <td><strong>Tipo de cambio: <span class="red-color"> ${{$tipo_cambio}}</span></strong></td>
    </tr>

  </table>

  <br/>

  <table id="products" width="100%">
    <thead style="background-color: #00427F;color:white;">
      <tr>
        <th colspan="3">Descripción</th>
        <th align="center">Cantidad</th>
        <th>Precio U.</th>
        <th align="center">Moneda</th>
        <th align="center">Desc. %</th>
        <th align="center">Total</th>
        <th align="center">Total USD</th>
      </tr>
    </thead>
    <tbody>
      @php
        $total_ea = 0.0;
        $total_materiales = 0.0;
        $total_mano_obra = 0.0;
      @endphp

      @foreach($equipo_activo as $producto)
      <tr>
        <td class="description" colspan="3">{{ strtoupper($producto->producto) }}</td>
        <td align="center">{{$producto->cantidad}}</td>
        <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
        <td align="center">{{$producto->currency}}</td>
        <td align="center">{{$producto->descuento}}</td>
        <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
        <td align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
      </tr>
      {{$total_ea += $producto->total_usd}}
      @endforeach

      <tr class="bg-blue">
          <td></td>
          <td colspan="4"></td>
          <td colspan="3" align="right">Total Equipo activo USD</td>
          <td align="right">$ {{ number_format($total_ea, 2, '.', ',') }}</td>
      </tr>

      @foreach($materiales as $producto)
      <tr>$producto->producto
        <td class="description" colspan="3">{{ strtoupper($producto->producto) }}</td>
        <td align="center">{{$producto->cantidad}}</td>
        <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
        <td align="center">{{$producto->currency}}</td>
        <td align="center">{{$producto->descuento}}</td>
        <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
        <td align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
      </tr>
      {{$total_materiales += $producto->total_usd}}
      @endforeach

      <tr class="bg-blue">
          <td></td>
          <td colspan="4"></td>
          <td colspan="3" align="right">Total Materiales USD</td>
          <td align="right">$ {{ number_format($total_materiales, 2, '.', ',') }}</td>
      </tr>

      @if ($mano_obra != '[]')
        @foreach($mano_obra as $producto)
        <tr>
          <td class="description" colspan="3">{{ strtoupper($producto->producto) }}</td>
          <td align="center">{{$producto->cantidad}}</td>
          <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
          <td align="center">{{$producto->currency}}</td>
          <td align="center">{{$producto->descuento}}</td>
          <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
          <td align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
        </tr>
        {{$total_mano_obra += $producto->total_usd}}
        @endforeach
      @else

      @endif
      <tr class="bg-blue">
          <td></td>
          <td colspan="4"></td>
          <td colspan="3" align="right">Total Mano de obra USD</td>
          <td align="right">$ {{ number_format($total_mano_obra, 2, '.', ',') }}</td>
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
            <td id="" rowspan="4" colspan="2"> </td>
            <td colspan="4" align="right">Total Equipo Activo USD</td>
            <td class="red-color" align="right">$ {{ number_format($total_ea, 2, '.', ',') }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="3" align="right">Total Material USD</td>
            <td class="red-color" align="right">$ {{ number_format($total_materiales, 2, '.', ',') }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="3" align="right">Total Mano de obra USD</td>
            <td class="red-color" align="right">$ {{ number_format($total_mano_obra, 2, '.', ',') }}</td>
        </tr>
        <tr>
          @php
            $total = 0.0;
            $total = $total_ea + $total_materiales + $total_mano_obra;
          @endphp
            <td></td>
            <td></td>
            <td colspan="3" align="right">Total USD</td>
            <td class="red-color" align="right" class="">$ {{ number_format($total, 2, '.', ',') }}</td>
        </tr>
    </tfoot>
  </table>

</body>
</html>
