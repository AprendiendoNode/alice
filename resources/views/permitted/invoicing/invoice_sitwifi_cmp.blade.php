<html lang="en">
<head>
<meta charset="UTF-8">
<title>
  {{$customer_complement->serie}}
  {{$customer_complement->folio}}
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
      height: 120px;
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
      height: 80px;
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
      line-height: .6rem;
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

    #table_complement_gral{
      width: 100%;
      margin-top: 5px;
      border: 1px solid black;
    }

    #table_complement_lines{
      width: 100%;
      margin-top: 1px;
    }

    #title_zero{
      margin:0px;
    }

    #table_cfdi{
      width: 100%;
      margin-top: 5px;
      border: 1px solid black;
      border-top: 1px solid black !important;
    }

    #table_cfdi p{
      font-size: 9px;
    }

    #table_cfdi tbody tr td{
      border-bottom: 1px solid black;
      border-right: 1px solid black;
    }
    #table_cfdi tbody tr td img{
      width: auto !important;
      height: auto !important;
      border-radius: 0px 6px 6px 0px !important;
    }


</style>

</head>
<body>
  @php
      //Obtiene datos del Cfdi33
      $cfdi33 = $data['cfdi33'];
      //Obtiene datos generales del complemento
      //$complement_gral = $data['complement_gral'][0];
  @endphp
  <table width="100%">
    <tr>
        <td style="width:25%;" valign="top"><img width="130" src="{{ public_path('images/storage/SIT070918IXA/files/companies/logo.png') }}"/></td>
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
        <p>Serie/Folio interno: <span>{{$customer_complement->serie}}</span> <span>{{$customer_complement->folio}}</span></p>
        <p>UUID: <span>{{ $customer_complement->customerInvoiceCfdi->uuid ?? '' }}</span></p>
        <p>No. serie certificado del emisor: <span>{{ $cfdi33['NoCertificado'] }}</span> </p>
        <p>Lugar de expedición:  <span> {{ $customer_complement->branchOffice->name ?? '' }}</span> {!! ( $customer_complement->branchOffice->postcode ? '<strong> C.P.</strong> <span>' . $customer_complement->branchOffice->postcode : '') !!}</p>
    </div>
    <div class="">
        <p>Fecha/Hora expedición: <span>{{ \App\Helpers\Helper::convertSqlToDateTime($customer_complement->date) }}</span> </p>
        <p>Fecha/Hora certificación: <span>{{ \App\Helpers\Helper::convertSqlToDateTime(str_replace('T',' ',$cfdi33->complemento->timbreFiscalDigital['FechaTimbrado'])) }}</span></p>
        <p>No. serie certificado del SAT: <span>{{ $cfdi33->complemento->timbreFiscalDigital['NoCertificadoSAT'] }}</span> </p>
        <p class="transparent">-</p>
    </div>
    <div class="">
        <p>Tipo de cambio: <span>{{ number_format($customer_complement->currency_value,4,'.',',') }}</span> </p>
        <p>Tipo de comprobante: <span>[{{ $customer_complement->documentType->cfdiType->code ?? ''}}] = Pago</span></p><!--MODIFICADO-->
        <p>Moneda: <span>{{ $cfdi33['Moneda'] }}</span></p><!--MODIFICADO-->
        <br/>
    </div>
  </div>
  <!--------->
  <div class="customer_info row">
    <div style="border-bottom: 0.1rem solid #000;" class="">
      <p>Cliente: <span>{{ mb_strtoupper($customer_complement->customer->name ?? '') }}</span> </p><!--MODIFICADO-->
    </div>
    <div class="">
      <p>R.F.C.: <span>{{ mb_strtoupper($customer_complement->customer->taxid ?? '') }}</span> </p><!--MODIFICADO-->
      <p style="line-height:.8rem;">Domicilio:
      <span>
        {{ $customer_complement->customer->address_1 ?? '' }} {{ $customer_complement->customer->address_2 ?? '' }} {{ $customer_complement->customer->address_3 ?? '' }} {{ $customer_complement->customer->address_4 ?? '' }}, {{ $estado ?? '' }}, {{ $pais ?? '' }}
      </span>
    </p>
    <p>C.P: <span>{{ $customer_complement->customer->postcode ?? '' }}</span> </p>

    <p>Uso de cfdi: <span>[{{ mb_strtoupper( $customer_complement->customer->cfdiUse->code ?? '') }}]{{ $customer_complement->customer->cfdiUse->name ?? '' }}</span> </p><!--MODIFICADO-->

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
        <th>Desc. %</th>
        <th align="center">Importe</th>
      </tr>
    </thead>
    <tbody>
      @foreach($customer_complement->customerInvoiceLines as $result)
      <tr>
        <td class="text-center">{{ $result->satProduct->code }}</td>
        <td class="text-center">{{ number_format($result->quantity, 2,'.', ','),$result->unitMeasure->decimal_place }}</td>
        <td class="text-center">[{{ $result->unitMeasure->code }}] {{ $result->unitMeasure->name }}</td>
        <td colspan="2">{{ $result->name }}</td>
        <td class="text-center">{{number_format($result->amount_untaxed, 2,'.', ',') }}</td>
        <td class="text-center">{{number_format($result->discount, 2,'.', ',') }}</td>
        <td align="right">${{ number_format($result->amount_total, 2,'.', ','),$customer_complement->currency->code ?? ''}}</td><!--MODIFICADO-->
      </tr>
      @endforeach
    </tbody>
  </table>
  <!--------->
  <table id="table_amounts">
    <tbody>
      <tr>
        <td rowspan="5" valign="top" colspan="3"> <span></span> </td><!--MODIFICADO-->
        <td align="right" colspan="2">Sub Total</td>
        <td align="right" colspan="2">$ <span>{{ number_format($customer_complement->amount_untaxed, 2,'.', ','),$customer_complement->currency->code ?? '' }}</span></td><!--MODIFICADO-->
      </tr>
      <tr>
        <td align="right" colspan="2">Descuento</td>
        <td align="right" colspan="2">$ <span>{{ number_format($customer_complement->amount_discount, 2,'.', ','),$customer_complement->currency->code ?? '' }}</span></td><!--MODIFICADO-->
      </tr>
      @if($customer_complement->customerInvoiceTaxes->isNotEmpty())
          @foreach($customer_complement->customerInvoiceTaxes as $result)
              <tr>
                  <td align="right" colspan="2">{{$result->name}}</td>
                  <td align="right" colspan="2">{{number_format(abs($result->amount_tax), 2,'.', ',') ,$customer_complement->currency->code ?? '' }}</td><!--MODIFICADO-->
              </tr>
          @endforeach
      @endif
      <tr>
        <td align="right" colspan="2">Total</td>
        <td align="right" style="border-top:1px solid black;" colspan="2">$ <span>{{number_format($customer_complement->amount_total, 2,'.', ','),$customer_complement->currency->code ?? '' }}</span></td><!--MODIFICADO-->
      </tr>
    </tbody>
  </table>
  <!--------->

  <!--------->
  <table id="table_complement_gral">
    <thead>
      <tr >
      <th colspan="10" class="text-center"> Complemento para recepción de pagos version 1.0</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td valign="left" colspan="2" ><b>Fecha Recepción pago:</b><span> {{ $complement_gral[0]->fecha_pago ?? ''}}</span> </td><!--MODIFICADO-->
        <td valign="right" colspan="2"><b>Forma de pago:</b><span></span> {{ $Fpago ?? ''}}</td><!--MODIFICADO-->
      </tr>
      <tr>
        <td align="left" colspan="2"><b>Importe Pagado:</b><span> {{ $complement_gral[0]->montototal ?? ''}}</span> </td>
        <td valign="right" colspan="2"><b>Moneda pago:</b><span>  {{ $moneda ?? ''}}</span></td><!--MODIFICADO-->
      </tr>
      <tr>
        <td align="left" colspan="2"><b>No. Operación:</b><span> {{ $complement_gral[0]->numoperacion ?? ''}}</span></td>
      </tr>
    </tbody>
  </table>
  <!--------->
  <!--------->
  <table id="table_complement_lines">
    <thead>
      <tr >
      <th colspan="10" class="text-center"><b>Documentos relacionados al pago:</b></th>
      </tr>
    </thead>
    <tbody>
      @foreach($complements as $result)
      <tr>
        <td>----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
      </tr>
      <tr>
        <td valign="left" colspan="2"><b>Id documento:</b><span> {{ $result->uuid ?? '' }}</span> </td><!--MODIFICADO-->
        <td valign="right" colspan="1"><b>Moneda:</b><span> {{ $moneda ?? ''}}</span> </td><!--MODIFICADO-->
        <td valign="right" colspan="1"><b>Método de pago:</b><span> </span> </td><!--MODIFICADO-->
      </tr>
      <tr>
        <td align="left" colspan="1"><b>Serie Folio:</b><span> {{ $result->folio ?? '' }}</span> </td>
        <td align="center" colspan="1"></td>
        <td valign="right" colspan="1"><b>No. parcialidad:</b><span> {{ $result->noparcialidad ?? '' }}</span> </td><!--MODIFICADO-->
        <td align="right" colspan="1"></td>
      </tr>
      <tr>
        <td align="left" colspan="1"><b>Saldo anterior:</b><span> {{ $result->importesaldoant ?? '' }}</span> </td>
        <td align="left" colspan="1"><b>Importe pagado:</b><span> {{ $result->importepagado ?? '' }}</span> </td>
        <td valign="right" colspan="1"><b>Saldo insoluto:</b><span> {{ $result->importesaldoIns ?? '' }}</span> </td><!--MODIFICADO-->
        <td align="right" colspan="1"></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <!--------->

  <!--------->
  <table id="table_cfdi">
    <tbody>
      @if(!empty($cfdi33))
        <tr style="border-top: 2px solid black !important;">
            <td width="23%" class="text-center" style="vertical-align: middle; padding: 5px; word-wrap:break-word;">
                <img src="{{ $data['qr'] }}" width="500px" style="margin: 9px 0;"/>
            </td>
            <td width="77%" style="vertical-align: middle; padding: 5px; word-wrap:break-word;">
                <strong>@lang('general.text_cfdi_tfd_cadena_origen') </strong><br/>
                <small>{{ $data['tfd_cadena_origen'] }}</small>
                <br/>
                <strong>@lang('general.text_cfdi_tfd_sello_cfdi') </strong><br/>
                <small>{{ $cfdi33->complemento->timbreFiscalDigital['SelloCFD'] }}</small>
                <br/>
                <strong>@lang('general.text_cfdi_tfd_sello_sat') </strong><br/>
                <small>{{ $cfdi33->complemento->timbreFiscalDigital['SelloSAT'] }}</small>
                <br/>
            </td>
        </tr>
      @endif
    </tbody>
  </table>

  <br><br>
  <p class="text-center">Este documento es una representación impresa de un CFDI</p>

</body>
</html>
