<html lang="en">
<head>
<meta charset="UTF-8">
<title>
  @if ($doc_type == 1)
  <h4>DOCUMENTO P</h4>
  @else
    <h4>DOCUMENTO M</h4>
  @endif
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

    #watermark h1{
      font-size: 4em;
      color: rgba(255, 0, 0, 0.3);
      transform: rotate(-20deg);
    }

</style>

</head>
<body>
  <div id="watermark">
    @if ($status != 3 && $status != 5)
      <h1>DOCUMENTO NO AUTORIZADO</h1>
    @endif

  </div>
  <table width="100%">
    <tr>
        <td valign="top"><img width="140" src="{{ public_path('/img/company/sitwifi_logo.jpg') }}"/></td>
        <td align="right">
            <h3>SITWIFI S.A DE C.V</h3>
            @if ($doc_type == 1)
              <h4>DOCUMENTO P</h4>
            @else
              <h4>DOCUMENTO M</h4>
            @endif

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
        <th colspan="2">Descripción</th>
        <th align="center">Cantidad</th>
        <th>Precio U.</th>
        <th align="center">Moneda</th>
        <th align="center">Desc. %</th>
        <th align="center">% compra</th>
        <th align="center">Total</th>
        <th align="center">Total USD</th>
      </tr>
    </thead>
    <tbody>
      @php
        $total_ea = 0.0;
        $total_materiales = 0.0;
        $total_mano_obra = 0.0;
        $total_viatico = 0.0;
      @endphp

      @foreach($equipo_activo as $producto)
      <tr>
        <td colspan="2">{{$producto->producto}}</td>
        <td align="center">{{$producto->cantidad}}</td>
        <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
        <td align="center">{{$producto->currency}}</td>
        <td align="center">{{$producto->descuento}}</td>
        <td align="right">{{ (int)$producto->porcentaje_compra }}%</td>
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
      <tr>
        <td colspan="2">{{$producto->producto}}</td>
        <td align="center">{{$producto->cantidad}}</td>
        <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
        <td align="center">{{$producto->currency}}</td>
        <td align="center">{{$producto->descuento}}</td>
        <td align="right">{{ (int)$producto->porcentaje_compra }}%</td>
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
          <td colspan="2">{{$producto->producto}}</td>
          <td align="center">{{$producto->cantidad}}</td>
          <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
          <td align="center">{{$producto->currency}}</td>
          <td align="center">{{$producto->descuento}}</td>
          <td align="right">{{ (int)$producto->porcentaje_compra }}%</td>
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

      @if ($viaticos != '[]')
        @foreach($viaticos as $producto)
        <tr>
          <td colspan="2">{{$producto->producto}}</td>
          <td align="center">{{$producto->cantidad}}</td>
          <td align="right">{{number_format($producto->precio, 2, '.', ',')}}</td>
          <td align="center">{{$producto->currency}}</td>
          <td align="center">{{$producto->descuento}}</td>
          <td align="right">{{ (int)$producto->porcentaje_compra }}%</td>
          <td align="right">{{number_format($producto->total, 2, '.', ',')}}</td>
          <td align="right">{{ number_format($producto->total_usd, 2, '.', ',')}}</td>
        </tr>
        {{$total_viatico += $producto->total_usd}}
        @endforeach
      @else

      @endif
      <tr class="bg-blue">
          <td></td>
          <td colspan="4"></td>
          <td colspan="3" align="right">Total Viaticos USD</td>
          <td align="right">$ {{ number_format($total_viatico, 2, '.', ',') }}</td>
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
