<html lang="en">
<head>
<meta charset="UTF-8">
<title>
  {{$customer_invoice->serie}}
  {{$customer_invoice->folio}}
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
        <p>Serie/Folio interno: <span>{{$customer_invoice->serie}}</span> <span>{{$customer_invoice->folio}}</span></p>
        <p>UUID: <span>{{ $customer_invoice->customerInvoiceCfdi->uuid ?? '' }}</span></p>
        <p>No. serie certificado del emisor: <span>{{ $cfdi33['NoCertificado'] }}</span> </p>
        <p>Lugar de expedición:  <span> {{ $customer_invoice->branchOffice->name ?? '' }}</span> {!! ( $customer_invoice->branchOffice->postcode ? '<strong> C.P.</strong> <span>' . $customer_invoice->branchOffice->postcode : '') !!}</p>
    </div>
    <div class="">
        <p>Fecha/Hora expedición: <span>{{ \App\Helpers\Helper::convertSqlToDateTime($customer_invoice->date) }}</span> </p>
        <p>Fecha/Hora certificación: <span>{{ \App\Helpers\Helper::convertSqlToDateTime(str_replace('T',' ',$cfdi33->complemento->timbreFiscalDigital['FechaTimbrado'])) }}</span></p>
        <p>No. serie certificado del SAT: <span>{{ $cfdi33->complemento->timbreFiscalDigital['NoCertificadoSAT'] }}</span> </p>
        <p class="transparent">-</p>
    </div>
    <div class="">
        <p>Moneda: <span>{{ $customer_invoice->currency->code }}</span></p>
        <p>Tipo de cambio: <span>{{ number_format($customer_invoice->currency_value,4,'.',',') }}</span> </p>
        <p>Forma de pago: <span>[{{ $customer_invoice->paymentWay->code }}] {{ $customer_invoice->paymentWay->name }}</span></p>
        <p>Método de pago: <span>[{{ $customer_invoice->paymentMethod->code }}]{{ $customer_invoice->paymentMethod->name }}</span></p>
    </div>
  </div>
  <!--------->
  <div class="customer_info row">
    <div style="border-bottom: 0.1rem solid #000;" class="">
      <p>Cliente: <span>{{ mb_strtoupper($customer_invoice->customer->name) }}</span> </p>
    </div>
    <div class="">
      <p>R.F.C.: <span>{{ mb_strtoupper($customer_invoice->customer->taxid) }}</span> </p>
      <p style="line-height:.8rem;">Domicilio:
      <span>
        {{ $customer_invoice->customer->address_1 ?? '' }} {{ $customer_invoice->customer->address_2 ?? '' }} {{ $customer_invoice->customer->address_3 ?? '' }} {{ $customer_invoice->customer->address_4 ?? '' }}
      </span>
    </p>
    <p>C.P: <span>{{ $customer_invoice->customer->postcode ?? '' }}</span> </p>

    <p>Uso de cfdi: <span>[{{ mb_strtoupper( $customer_invoice->customer->cfdiUse->code) }}]{{ $customer_invoice->customer->cfdiUse->name }}</span> </p>

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
      @foreach($customer_invoice->customerInvoiceLines as $result)
      <tr>
        <td class="text-center">{{ $result->satProduct->code }}</td>
        <td class="text-center">{{ number_format($result->quantity, 2,'.', ','),$result->unitMeasure->decimal_place }}</td>
        <td class="text-center">{{ $result->unitMeasure->name_sat }}</td>
        <td colspan="2">{{ $result->name }}</td>
        <td class="text-center">{{number_format($result->price_unit, 2,'.', ',') }}</td>
        <td class="text-center">{{number_format($result->discount, 2,'.', ',') }}</td>
        <td align="right">${{ number_format($result->amount_untaxed, 2,'.', ','),$customer_invoice->currency->code }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <!--------->
  <table id="table_amounts">
    <tbody>
      <tr>
        <td rowspan="5" valign="top" colspan="3"> <span>( {{$ammount_letter}} {{$customer_invoice->currency->code}})</span> </td>
        <td align="right" colspan="2">Sub Total</td>
        <td align="right" colspan="2">$ <span>{{ number_format($customer_invoice->amount_untaxed, 2,'.', ','),$customer_invoice->currency->code }}</span></td>
      </tr>
      <tr>
        <td align="right" colspan="2">Descuento</td>
        <td align="right" colspan="2">$ <span>{{ number_format($customer_invoice->amount_discount, 2,'.', ','),$customer_invoice->currency->code }}</span></td>
      </tr>
      @if($customer_invoice->customerInvoiceTaxes->isNotEmpty())
          @foreach($customer_invoice->customerInvoiceTaxes as $result)
              <tr>
                  <td align="right" colspan="2">{{$result->name}}</td>
                  <td align="right" colspan="2">{{number_format(abs($result->amount_tax), 2,'.', ',') ,$customer_invoice->currency->code }}</td>
              </tr>
          @endforeach
      @endif
      <tr>
        <td align="right" colspan="2">Total</td>
        <td align="right" style="border-top:1px solid black;" colspan="2">$ <span>{{number_format($customer_invoice->amount_total, 2,'.', ','),$customer_invoice->currency->code }}</span></td>
      </tr>
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
