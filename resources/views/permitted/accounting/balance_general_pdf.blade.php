<html lang="en">
<head>
<meta charset="UTF-8">
<title>
  
</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }

    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }

    .header_address{
      line-height: .2rem;
    }

    .header_address h4{
      font-size: 1.1rem;
    }

    .header_address p{
      font-size: 1em;
    }

    .text-center{
      text-align: center;
    }

    .text-address{
      font-size: 14px;
      line-height: .2rem;
    }

    .text-bold{
      font-weight: bold;
    }

    .text-uppercase{
      text-transform: uppercase;
    }

    #table_balance tbody tr td{
      font-size: 8px !important;
    }
</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td style="width:20%;" valign="top"></td>
        <td class="header_address" style="width:60%;" class="" align="center">
            <p> <span class="text-uppercase">{{ $data[0]->mes_nombre }}</span>  EJERCICIO {{ $data[0]->anio }}</p>  
            <p class="text-bold">SITWIFI, S.A DE C.V.</p>
            <p>HAMBURGO No. 159  COL JUAREZ</p>
            <p class="text-bold">SIT070918IXA</p>
            <h4>BALANZA DE COMPROBACION</h4>
            <p>PERIODO DEL {{ $first_day_month }}   AL {{ $last_day_month }}</p>
        </td>
        <td style="width:20%;" valign="top"></td>
    </tr>
  </table>



  <table id="table_balance" width="100%">
    <thead>
      <tr style="background: #A6A6A6;">
        <th align="center"> <small class="text-uppercase">Cuenta</small> </th>
        <th align="center"> <small class="text-uppercase">Nat.</small> </th>
        <th align="center"> <small class="text-uppercase">Nombre</small> </th>
        <th align="center"> <small class="text-uppercase">Saldo inicial</small> </th>
        <th align="center"> <small class="text-uppercase">Cargos</small> </th>
        <th align="center"> <small class="text-uppercase">Abonos</small> </th>
        <th align="center"> <small class="text-uppercase">Saldo final</small> </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $balanza)
          <tr>
            <td align="left">{{ $balanza->cuenta }}</td>
            <td align="center">{{ $balanza->NA }}</td>
            <td align="left">{{ $balanza->nombre }}</td>
            <td align="right">{{ $balanza->sdo_inicial }}</td>
            <td align="right">{{ $balanza->cargos }}</td>
            <td align="right">{{ $balanza->abonos }}</td>
            <td align="right">{{ $balanza->sdo_final }}</td>
          </tr>
      @endforeach
    </tbody>
  </table>

</body>
</html>
