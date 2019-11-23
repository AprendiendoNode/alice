<html lang="en">
<head>
<meta charset="UTF-8">
<title>
  <h4>SOLICITUD DE PAGO</h4>
</title>
<style type="text/css">
    * {
      font-family: Verdana, Arial, sans-serif;
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }
    body {
      padding: 5%;
    }
    #header-left {
      display: inline-block;
      width: 60%;
    }
    #header-right {
      display: inline-block;
      width: 40%;
    }
    #header-left img, #header-left h2 {
      display: inline-block;
    }
    #header2 p, #header3 p {
      display: inline-block;
      width: 50%;
    }
    #header2 span {
      font-weight: bold;
    }
    table {
      margin: 5px auto;
    }
    table td, table th {
      padding: 0 5px;
    }
    #concepto, #forma, #banco, #cuenta, #clabe, #referencia, #observaciones, #subtotal, #iva, #total {
      margin-top: 10px;
    }
    #concepto p, #forma p, #banco p, #cuenta p, #clabe p, #referencia p, #observaciones p, #subtotal p, #iva p, #total p {
      display: inline-block;
    }
</style>
</head>
<body>
  <div id="header-left">
    <img width="140" src="{{ public_path('/img/company/sitwifi_logo.jpg') }}"/>
    <h2 style="padding-left: 7%; padding-bottom: 3%;">
      Solicitud de pagos
    </h2>
  </div>
  <div id="header-right">
    <p>
      C.C.
    </p>
    <p style="background-color: #EAEAEA; padding: 5px; margin-bottom: 10px;">
      {{$cc}}
    </p>
    <p>
      Fecha de solicitud: {{$fecha_de_solicitud}}
    </p>
    <p>
      Fecha de pago: {{$fecha_de_pago}}
    </p>
  </div>
  <div id="header2">
    <p>Núm. Factura: <span>{{$num_factura}}</span></p>
    <p>Orden de compra: <span>{{$orden_de_compra}}</span></p>
  </div>
  <div id="header3">
    <p>Prioridad: {{$prioridad}}</p>
    <p>Folio: {{$folio}}</p>
  </div>
  <p>Proveedor: {{$proveedor}}</p>
  <div id="monto1" style="margin-top: 30px;">
    <p style="display: inline-block; vertical-align: middle; width: 25%;">
      Monto ($):
    </p>
    <div style="display: inline-block; width: 75%;">
      <p style="font-size: 18px;">{{$monto}}</p>
      <p style="font-weight: bold;">{{$monto_texto}}</p>
    </div>
  </div>
  <p>(*) Datos del sitio</p>
  <table cellspacing="0">
    <tr style="background-color: gray; color: white;">
      <th>Grupo</th>
      <th>Sitio</th>
      <th>Anexo ID</th>
      <th>Ubicacion ID</th>
      <th>Monto</th>
      <th>IVA</th>
      <th>Monto IVA</th>
    </tr>
    @php
      $fila = 0;
    @endphp
    @foreach($valores_tabla as $valor)
      @if ($fila == 0)
        <tr style="background-color: #EAEAEA;">
          {{ $fila++ }}
      @else
        <tr>
          {{ $fila-- }}
      @endif
          <td>{{$valor[0]}}</td>
          <td>{{$valor[1]}}</td>
          <td>{{$valor[2]}}</td>
          <td>{{$valor[3]}}</td>
          <td>{{$valor[4]}}</td>
          <td>{{$valor[5]}}</td>
          <td>{{$valor[6]}}</td>
        </tr>
    @endforeach
  </table>
  <div id="concepto">
    <p style="width: 25%;">Concepto de pago: </p>
    <p style="width: 75%;">{{$concepto_de_pago}}</p>
  </div>
  <div id="forma">
    <p style="width: 25%;">Forma de pago: </p>
    <p style="width: 75%;">{{$forma_de_pago}}</p>
  </div>
  <p>(*) Datos bancarios del beneficiario</p>
  <div id="banco">
    <p style="width: 25%;">Banco: </p>
    <p style="width: 75%; font-weight: bold;">{{$banco}}</p>
  </div>
  <div id="cuenta">
    <p style="width: 25%;">Cuenta: </p>
    <p style="width: 75%; font-weight: bold;">{{$cuenta}}</p>
  </div>
  <div id="clabe">
    <p style="width: 25%;">Clabe: </p>
    <p style="width: 75%; font-weight: bold;">{{$clabe}}</p>
  </div>
  <div id="referencia">
    <p style="width: 25%;">Referencia: </p>
    <p style="width: 75%; font-weight: bold;">{{$referencia}}</p>
  </div>
  <div id="observaciones">
    <p style="width: 25%;">Observaciones: </p>
    <p style="width: 75%;">{{$observaciones}}</p>
  </div>
  <div id="subtotal">
    <p style="width: 25%;">Subtotal: </p>
    <p style="width: 75%;">{{$subtotal}}</p>
  </div>
  <div id="iva">
    <p style="width: 25%;">IVA: </p>
    <p style="width: 75%;">{{$iva}}</p>
  </div>
  <div id="total">
    <p style="width: 25%;">Total: </p>
    <p style="width: 75%;">{{$total}}</p>
  </div>
</body>
</html>
