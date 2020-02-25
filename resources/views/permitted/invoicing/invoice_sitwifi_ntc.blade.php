<html lang="en">
<head>
<meta charset="UTF-8">
<title>
  {{$customer_credit_note->serie}}
  {{$customer_credit_note->folio}}
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
        <p># {{ $customer_credit_note->name }}</p>
        <p>Estatus: <span>{!! \App\Helpers\SalesHelper::statusCustomerCreditNoteHtml($customer_credit_note->status) !!}</span> </p>
        <p>UUID: <span>{{ $customer_credit_note->customerInvoiceCfdi->uuid ?? '' }}</span></p>
    </div>
    <div class="">
      <p>Tipo de comprobante: <span>[{{ $customer_credit_note->documentType->cfdiType->code ?? '' }}] {{ $customer_credit_note->documentType->cfdiType->name ?? '' }}</span></p>
      <p>Fecha: <span>{{ \App\Helpers\Helper::convertSqlToDateTime($customer_credit_note->date) }}</span> </p>
      <p>Términos de pago: <span>{{ $customer_credit_note->paymentTerm->name }}</span> </p>
    </div>
    <div class="">
      <p>Uso de CFDI: <span>[{{ $customer_credit_note->cfdiUse->code }}] {{ $customer_credit_note->cfdiUse->name }}</span> </p>
      <p>Expedido en: <span>{{ $customer_credit_note->branchOffice->name ?? '' }}</span> </p>
      <p>C.P.: <span>{!! ($customer_credit_note->branchOffice->postcode ?  $customer_credit_note->branchOffice->postcode : '') !!} </span></p>
    </div>
  </div>

  <div  class="header row">
    <div class="">
      <p style="text-decoration: underline;">Cliente</p>
      <p>Nombre:  <span>{{ mb_strtoupper($customer_credit_note->customer->name) }}</span></p>
      <p>RFC: <span>{{ mb_strtoupper($customer_credit_note->customer->taxid) }}</span> </p>
      <p class="transparent">-</p>

    </div>
    <div class="">
      <p>Dirección: <span>{{ $customer_credit_note->customer->address_1 ?? '' }} {{ $customer_credit_note->customer->address_2 ?? '' }} {{ $customer_credit_note->customer->address_3 ?? '' }} {{ $customer_credit_note->customer->address_4 ?? '' }}</span></p>
      <p>Ciudad: <span>{{ $customer_credit_note->customer->city->name ?? '' }}</span> </p>
      <p>Estado: <span>{{ $customer_credit_note->customer->state->name ?? '' }}</span> </p>
      <p class="transparent">-</p>

    </div>
    <div class="">
      <p>Pais: <span>{{ $customer_credit_note->customer->country->name ?? '' }}</span> </p>
      <p>C.P: <span>{!! ($customer_credit_note->customer->postcode ? $customer_credit_note->customer->postcode : '') !!}</span></p>
      <p class="transparent">-</p>
      <p class="transparent">-</p>

    </div>
  </div>
  <!-- Table row -->
  <table id="table_products" width="100%">
    <thead>
      <tr>
        <th colspan="2">Descripción</th>
        <th class="text-center">Prod/Serv SAT</th>
        <th class="text-center">U.M.</th>
        <th class="text-center">Cantidad</th>
        <th class="text-center">Precio</th>
        <th class="text-center">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($customer_credit_note->customerInvoiceLines as $result)
          <tr>
              <td colspan="2">{{ $result->name }}</td>
              <td class="text-center">{{ $result->satProduct->code }}</td>
              <td class="text-center">[{{ $result->unitMeasure->code }}]{{ $result->unitMeasure->name }}</td>
              <td class="text-center">{{ number_format($result->quantity, 2,'.', ','),$result->unitMeasure->decimal_place }}</td>
              <td class="text-center">
                ${{ number_format($result->price_unit, 2,'.', ','),$customer_credit_note->currency->code }}
              </td>
              <td class="text-center">
                ${{ number_format($result->amount_untaxed, 2,'.', ','),$customer_credit_note->currency->code }}
              </td>
          </tr>
      @endforeach
    </tbody>
  </table>
  <!--------->
  <table id="table_amounts">
    <tbody>
      <tr>
        <td rowspan="5" valign="top" colspan="3">
           <span>Forma de pago:</span>
           <small style="font-weight: normal"> [{{ $customer_credit_note->paymentWay->code }}]{{ $customer_credit_note->paymentWay->name }} </small>
           <br>

           <span>Método de pago:</span>
           <small style="font-weight: normal"> [{{ $customer_credit_note->paymentMethod->code }}] {{ $customer_credit_note->paymentMethod->name }} </small>
           <br>

           <span>Moneda:</span>
           <small style="font-weight: normal"> {{ $customer_credit_note->currency->code }} </small>
           <span>TC:</span>
           <small style="font-weight: normal"> {{ number_format($customer_credit_note->currency_value,4,'.', ',') }} </small>
           <br>

           @if(!empty($cfdi33))
           <span>Certificado:</span>
           <small style="font-weight: normal"> {{ $cfdi33['NoCertificado'] }} </small>
           <br>
           <span>Certificado SAT:</span>
           <small style="font-weight: normal"> {{ $cfdi33->complemento->timbreFiscalDigital['NoCertificadoSAT'] }} </small>
           <br>

           <span>Fecha y hora de certificación:</span>
           <small style="font-weight: normal"> {{ \App\Helpers\Helper::convertSqlToDateTime(str_replace('T',' ',$cfdi33->complemento->timbreFiscalDigital['FechaTimbrado'])) }} </small>
           <br>
           @endif
        </td>
        <td align="right" colspan="2">Subtotal</td>
        <td align="right" colspan="2">$ <span>{{ number_format($customer_credit_note->amount_untaxed, 2,'.', ','),$customer_credit_note->currency->code }}</span></td>
      </tr>
      @if($customer_credit_note->customerInvoiceTaxes->isNotEmpty())
          @foreach($customer_credit_note->customerInvoiceTaxes as $result)
            <tr>
              <td align="right" colspan="2">
                <span>{{$result->name}}</span>
              </td>
              <td align="right" colspan="2">
                <span>
                    $ {{ number_format(abs($result->amount_tax), 2,'.', ','),$customer_credit_note->currency->code }}
                </span>
              </td>
            </tr>
          @endforeach
      @endif
      <tr>
        <td align="right" colspan="2">Total</td>
        <td align="right" style="border-top:1px solid black;" colspan="2">$<span>{{number_format($customer_credit_note->amount_total, 2,'.', ','),$customer_credit_note->currency->code }}</span></td>
      </tr>
    </tbody>
  </table>
  <!-- /.row -->
  @if(!empty($customer_credit_note->cfdi_relation_id))
    <table id="table_products" width="100%">
      <thead>
        <tr>
          <th class="text-center">CFDI's relacionadas</th>
          <th class="text-center">- {{ $customer_credit_note->cfdiRelation->name }}</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center">
            @if($customer_credit_note->customerInvoiceRelations->isNotEmpty())
                @foreach($customer_credit_note->customerInvoiceRelations as $result)
                    {{$result->relation->name}}<br/>
                @endforeach
            @endif
          </td>
          <td class="text-center">
            @if($customer_credit_note->customerInvoiceRelations->isNotEmpty())
                @foreach($customer_credit_note->customerInvoiceRelations as $result)
                    {{$result->relation->customerInvoiceCfdi->uuid}}<br/>
                @endforeach
            @endif
          </td>
        </tr>
      </tbody>
    </table>
  @endif
  <!--------->
  @if(!empty($customer_credit_note->comment))
    <table id="table_products" width="100%">
      <thead>
        <tr>
          <th class="text-center">Comentario</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center">
            {{ $customer_credit_note->comment }}
          </td>
        </tr>
      </tbody>
    </table>
  @endif
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
  <!--------->


  <br><br>
  <p class="text-center">Este documento es una representación impresa de un CFDI</p>

</body>
</html>
