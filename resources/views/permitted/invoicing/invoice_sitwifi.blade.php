<html lang="en">
<head>
<meta charset="UTF-8">
<title>
  invoice
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
      line-height: .3rem;
    }

    .header_address h5{
      line-height: .1rem !important;
    }

    .text-center{
      text-align: center;
    }

    .text-address{
      font-size: 11px;
      line-height: .7rem;
    }

    .row{
      width: 100%;
    }

    .customer_info{
      height: 100px;
      border: 1px solid #000;
      border-radius: 5px;
      margin-top: 5px;
      font-size: 12px;
    }

    .customer_info div{
      padding: 0rem 2px;
    }

    .customer_info div p{
      line-height: .2rem;
      font-weight: bold;
    }

    .customer_info div span{
      font-weight: normal;
    }

    .header{
      border: 1px solid #000;
      border-radius: 5px;
      margin-top: 20px;
      font-size: 9px;
      height: 60px;
    }

    .header div{
      display: inline-block;
      width: 32%;
      padding: 1.2rem 1px;
      font-weight: bold;
      text-align: left;
    }

    .header div span{
      font-weight: normal !important;
    }

    .header div p{
      line-height: .3rem;
      display: block;
    }

    .product_description{
      height: 100px;
      border: 1px solid #000;
      border-radius: 5px;
      margin-top: 5px;
      font-size: 12px;
    }

    .transparent{
      color: white;
    }

    #table_products{
      margin-top: 10px;
      border: 2px solid;
      border-radius: 2px;
    }

    #table_products {
      border-collapse: collapse;
    }

    #table_products tbody {
      border: 1px solid black;
    }

    #table_products tbody tr td{
      border-right: 1px solid black;
    }

    #table_amounts{
      width: 100%;
      margin-top: 5px;
      border: 1px solid black;
      font-weight: bold;
    }

    #table_cfdi{
      width: 100%;
      margin-top: 5px;
      border: 1px solid black;
    }

    #table_cfdi p{
      font-size: 9px;
    }

    #table_cfdi tbody tr td{
      border-bottom: 1px solid black;
      border-right: 1px solid black;
    }


</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td style="width:25%;" valign="top"><img width="120" src="{{ public_path('/images/users/logo.svg') }}"/></td>
        <td class="header_address" style="width:50%;" class="" align="center">
            <h4>SITWIFI, S.A DE C.V.</h4>
            <h5>SIT070918IXA</h5>
            <p class="text-address">HAMBURGO 159-PISO 1, Col. JUAREZ, Cd. CIUDAD DE MÉXICO,
              CP 06600, CUAUHTÉMOC, CIUDAD DE MÉXICO, MÉXICO</p>
            <p>Régimen fiscal: General de Ley Personas Morales</p>
        </td>
        <td style="width:25%;" valign="top"></td>
    </tr>
  </table>

  <div  class="header row">
    <div class="">
        <p>Serie/Folio interno: <span>FASA</span> <span>000234</span></p>
        <p>UUID: <span>34356568-6284-B532-1212</span></p>
        <p>No. serie certificado del emisor: <span>000011000400338</span> </p>
        <p>Lugar de expedición:  <span> 06660 </span></p>
    </div>
    <div class="">
        <p>Fecha/Hora expedición: <span>01/04/2019</span> <span>16:16:02</span> </p>
        <p>Fecha/Hora certificación: <span>01/04/2019</span> <span>16:16:02</span> </p>
        <p>No. serie certificado del SAT: <span>00000000028238000</span> </p>
        <p class="transparent">-</p>
    </div>
    <div class="">
        <p>Moneda: <span>USD</span></p>
        <p>Tipo de cambio: <span>19.3779</span> </p>
        <p class="transparent">-</p>
        <p class="transparent">-</p>
    </div>
  </div>
  <!--------->
  <div class="customer_info row">
    <div style="border-bottom: 0.1rem solid #000;" class="">
      <p>Cliente: <span>ARENA DE VERANO S.A. DE C.V.</span> </p>
    </div>
    <div class="">
      <p>R.F.C. <span>AVE1211144C0</span> </p>
      <p style="line-height:.8rem;">Domicilio:
      <span>
        BOULEVARD KUKULCAN KILOMETRO 3.5 166, COL. Zona  Hotelera, Cd. Cancún,
        CP 77500, Benito Juárez, Quintana Roo, México
      </span>
    </p>
    <p>Uso CFDI: <span>Por definir</span> </p>
    </div>
  </div>
  <!--------->
  <table id="table_products" width="100%">
    <thead>
      <tr>
        <th align="center">C. Srv.Prd.</th>
        <th align="center">Cantidad</th>
        <th align="center">Unidad</th>
        <th colspan="2">Descripción</th>
        <th>Precio Unitario</th>
        <th align="center">Importe</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>813323</td>
        <td align="right">1.00</td>
        <td>PZA</td>
        <td colspan="2">PRESTACIÓN DE SERVICIOS DE ACCESO A LA RED INTERNET</td>
        <td align="right">$550.00</td>
        <td align="right">$550.00</td>
      </tr>
    </tbody>
  </table>
  <!--------->
  <table id="table_amounts">
    <tbody>
      <tr>
        <td rowspan="5" valign="top" colspan="3"> <span>(SEISCIENTOS TERINTA Y OCHO DOLARES 00 / 100 USD)</span> </td>
        <td align="right" colspan="2">Sub Total</td>
        <td align="right" colspan="2">$ <span>550.00</span></td>
      </tr>
      <tr>
        <td align="right" colspan="2">Descuentos</td>
        <td align="right" colspan="2">$ <span>0.00</span></td>
      </tr>
      <tr>
        <td align="right" colspan="2">Total Impuestos Trasladados</td>
        <td align="right" colspan="2">$ <span>88.00</span></td>
      </tr>
      <tr>
        <td align="right" colspan="2">Total Impuestos Retenidos</td>
        <td align="right" colspan="2">$ <span>0.00</span></td>
      </tr>
      <tr>
        <td align="right" colspan="2">Total</td>
        <td align="right" style="border-top:1px solid black;" colspan="2">$ <span>0.00</span></td>
      </tr>
    </tbody>
  </table>
  <!--------->

  <!--------->
  <table id="table_cfdi">
    <tbody>
      <tr>
        <td rowspan="2" style="width:20%;"> <img src="https://upload.wikimedia.org/wikipedia/commons/d/d7/Commons_QR_code.png" alt=""> </td>
        <td valign="top" style="width:80%;">
          Sello Digital del CFDI
          <br>
          <p>E2wQhqOCVzwME4866yVEME/8PD1S1g6AV48D8VrLhKUDq0Sjqnp9IwfMAbX0ggwUCLRKa Hg5q8aYhya63If2HVqH1sA08poer080P1J6Z
            BwTrQkhcb5Jw8jENXoErkFE8qdOcIdFFAuZPVT 9mkTb0Xn5Emu5U8=
          </p>
        </td>
      </tr>
      <tr>
        <td valign="top" style="width:80%;">
          Versión timbre fiscal digital
          <br>
          Cadena original del complemento de certificación digital del sat
          <br>
          <p>E2wQhqOCVzwME4866yVEME/8PD1S1g6AV48D8VrLhKUDq0Sjqnp9IwfMAbX0ggwUCLRKa Hg5q8aYhya63If2HVqH1sA08poer080P1J6Z
            BwTrQkhcb5Jw8jENXoErkFE8qdOcIdFFAuZPVTBwTrQkhcb5Jw8jENXoErkFE8qdOcIdFFAuZPVT BwTrQkhcb5Jw8jENXoErkFE8qdOcIdFFAuZPVT  9mkTb0Xn5Emu5U8=
          </p>
        </td>
      </tr>
      <tr>
        <td style="border-bottom:none;"></td>
        <td style="width:20%;border-bottom:none;" valign="top" style="width:80%;">
          Sello Digital del SAT
          <br>
          <p>E2wQhqOCVzwME4866yVEME/8PD1S1g6AV48D8VrLhKUDq0Sjqnp9IwfMAbX0ggwUCLRKa Hg5q8aYhya63If2HVqH1sA08poer080P1J6Z
            BwTrQkhcb5Jw8jENXoErkFE8qdOcIdFFAuZPVTBwTrQkhcb5Jw8jENXoErkFE8qdOcIdFFAuZPVT BwTrQkhcb5Jw8jENXoErkFE8qdOcIdFFAuZPVT  9mkTb0Xn5Emu5U8=
          </p>
        </td>
      </tr>
    </tbody>
  </table>

  <br><br>
  <p class="text-center">Este documento es una representación impresa de un CFDI</p>

</body>
</html>
