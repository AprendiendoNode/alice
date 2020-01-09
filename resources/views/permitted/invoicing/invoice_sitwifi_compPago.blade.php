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
    $cfdi33 = !empty($data['cfdi33']) ? $data['cfdi33'] : [];

    $request_companie = !empty($companies[0]->name) ? $companies[0]->name : 'Default Company';
    $request_RFC = !empty($companies[0]->taxid) ? $companies[0]->taxid : 'Default RFC';

    $request_address_1 = !empty($companies[0]->address_1) ? $companies[0]->address_1 : 'Address_1';
    $request_address_2 = !empty($companies[0]->address_2) ? $companies[0]->address_2 : 'Address_2';
    $request_address_3 = !empty($companies[0]->address_3) ? $companies[0]->address_3 : 'Address_3';
    $request_address_4 = !empty($companies[0]->address_4) ? $companies[0]->address_4 : 'Address_4';
    $request_address_5 = !empty($companies[0]->address_5) ? $companies[0]->address_5 : 'Address_5';
    $request_address_6 = !empty($companies[0]->address_6) ? $companies[0]->address_6 : '';

    $request_city = !empty($companies[0]->city) ? $companies[0]->city : '';
    $request_postcode = !empty($companies[0]->postcode) ? $companies[0]->postcode : '';

    $request_state = !empty($companies[0]->state) ? $companies[0]->state : '';
    $request_country = !empty($companies[0]->country) ? $companies[0]->country : '';

    $request_address = strtoupper($request_address_1).' '.$request_address_2.'-'.strtoupper($request_address_3).' Col.'.strtoupper($request_address_4).', Cd.'.strtoupper($request_state).', CP '.$request_postcode.', '.strtoupper($request_address_5).', '.strtoupper($request_state).', '.strtoupper($request_country);

    $request_country = !empty($companies[0]->country) ? $companies[0]->country : '';

    $request_tax_code = DB::table('tax_regimens')->select('code')->where('id', $companies[0]->tax_regimen_id)->value('code');
    $request_tax = !empty($companies[0]->tax_regimen) ? $companies[0]->tax_regimen : '';

    $mayusculas_company = strtoupper($request_companie);
    $mayusculas_RFC = strtoupper($request_RFC);

  @endphp

  <table width="100%">
    <tr>
      <td style="width:25%;" valign="top"><img width="130" src="{{ public_path('images/storage/SIT070918IXA/files/companies/logo.png') }}"/></td>
        <td class="header_address" style="width:50%;" class="" align="center">
            <h4>{{ $mayusculas_company }}</h4>
            <h5>{{ $mayusculas_RFC }}</h5>
            <p class="text-address">{{ $request_address }}</p>
            <p>Régimen fiscal: [{{$request_tax_code}}] {{ $request_tax }}</p>
        </td>
        <td style="width:25%;" valign="top"></td>
    </tr>
  </table>
  <!--------->
  @if($customer_payment->status == 4)
    <span class=""
    style="background-color: #777;padding: .2em .6em .3em; font-size: 75%;font-weight: 700; line-height: 1; color: #fff; ">
    {{ __('customer_invoice.text_status_cancel') }}
  </span>
  @endif
  <div class="header row">
    <div class="">
        <p>Serie/Folio interno: <span>{{ $customer_payment->folio }}</span>
        </p>
        <p>UUID: <span>{{ $customer_payment->customerPaymentCfdi->uuid ?? '' }}</span></p>
        <p>Tipo de comprobante: <span>[{{ $customer_payment->documentType->cfdiType->code ?? '' }}] {{ $customer_payment->documentType->cfdiType->name ?? '' }}</span></p>
    </div>
    <div class="">
        <p>Fecha/Hora: <span>{{ \App\Helpers\Helper::convertSqlToDateTime($customer_payment->date) }}</span> </p>
        <p>Fecha/Hora De Pago: <span>{{ $customer_payment->date_payment ? \App\Helpers\Helper::convertSqlToDateTime($customer_payment->date_payment) : '' }}</span></p>
        <p class="transparent">-</p>
    </div>
    <div class="">
        <p>Monto: <span>${{ number_format($customer_payment->amount, 2,'.', ','),$customer_payment->currency->code }}</span> </p>
        <p>Moneda:
          <span>
            {{ $customer_payment->currency->code }}{!! ($customer_payment->currency->code!='MXN' ? '&nbsp;&nbsp;&nbsp;<strong>'.__('customer_payment.entry_currency_value').':</strong> '.round($customer_payment->currency_value,4) :'') !!}
          </span>
        </p><!--MODIFICADO-->
        <p>Expedido en: <span>{{ $customer_payment->branchOffice->name ?? '' }}.</span>
           C.P.: <span>{{ $customer_payment->branchOffice->postcode ?? '' }}</span></p><!--MODIFICADO-->
    </div>
  </div>
  <!--------->
  <div class="customer_info row">
    <div style="border-bottom: 0.1rem solid #000;" class="">
      <p>Cliente: <span>{{ mb_strtoupper($customer_payment->customer->name) }}</span> </p><!--MODIFICADO-->
    </div>
    <div class="">
      <p>R.F.C.: <span>{{ mb_strtoupper($customer_payment->customer->taxid ?? '') }}</span> </p><!--MODIFICADO-->
      <p style="line-height:.8rem;">Domicilio:
      <span>
        {{ $customer_payment->customer->address_1 ?? '' }} {{ $customer_payment->customer->address_2 ?? '' }} {{ $customer_payment->customer->address_3 ?? '' }} {{ $customer_payment->customer->address_4 ?? '' }}
      </span>
      <br/>
      <span>
        {{ $customer_payment->customer->city->name ?? '' }} , {{ $customer_payment->customer->state->name ?? '' }}
      </span>
      <br/>
    </p>
    <p>C.P: <span>{{ $customer_payment->customer->postcode ?? '' }}</span> </p>
    </div>
  </div>
  <!--------->
  <table id="table_products" width="100%">
    <thead>
      <tr>
        <th align="center">Descripción.</th>
        <th align="center">Prod/Serv SAT</th>
        <th align="center">Unidad</th>
        <th align="center">Cantidad</th>
        <th align="center">Precio</th>
        <th align="center">Total</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Pago</td>
        <td class="text-center">84111506</td>
        <td class="text-center">ACT</td>
        <td class="text-center">1</td>
        <td class="text-center">$0</td>
        <td class="text-center">$0</td>
      </tr>
    </tbody>
  </table>
  <!--------->
  <div class="header row">
    <div class="">
      <p>Forma de pago: <span>[{{ $customer_payment->paymentWay->code }}] {{ $customer_payment->paymentWay->name }}</span></p>
      <p>Número de operación: <span>{{ $customer_payment->reference }}</span></p>
    </div>
    @if(!empty($cfdi33))
    <div class="">
      <p>Certificado: <span>{{ $cfdi33['NoCertificado'] }}</span></p>
      <p>Certificado SAT: <span>{{ $cfdi33->complemento->timbreFiscalDigital['NoCertificadoSAT'] }}</span></p>
    </div>
    <div class="">
      <p>Fecha y hora de certificación: <span>{{ \App\Helpers\Helper::convertSqlToDateTime(str_replace('T',' ',$cfdi33->complemento->timbreFiscalDigital['FechaTimbrado'])) }}</span></p>
      <p class="transparent">-</p>
    </div>
    @endif
  </div>
  <!--------->
  <div class="header row">
    <strong> - @lang('customer_payment.text_ordenante') - </strong>
    <div class="">
      <p>@lang('customer_payment.text_RfcEmisorCtaOrd'):
        <span>{{ $customer_payment->customerBankAccount->bank->taxid ?? '' }}</span>
      </p>
    </div>
    <div class="">
      <p>@lang('customer_payment.text_NomBancoOrdExt'):
        <span>
          @if(!empty($customer_payment->customerBankAccount->bank->taxid) && $customer_payment->customerBankAccount->bank->taxid == 'XEXX010101000')
            {{ $customer_payment->customerBankAccount->bank->name ?? '' }}
          @endif
        </span>
      </p>
    </div>
    <div class="">
      <p>@lang('customer_payment.text_CtaOrdenante'):
        <span>{{ $customer_payment->customerBankAccount->account_number ?? '' }}</span>
      </p>
    </div>
  </div>
  <div class="header row">
    <strong> - @lang('customer_payment.text_beneficiario') - </strong>
    <div class="">
      <p>@lang('customer_payment.text_RfcEmisorCtaOrd'):
        <span>{{ $customer_payment->companyBankAccount->bank->taxid ?? '' }}</span>
      </p>
    </div>
    <div class="">
      <p>@lang('customer_payment.text_CtaOrdenante'):
        <span>{{ $customer_payment->companyBankAccount->account_number ?? '' }}</span>
      </p>
    </div>
  </div>
  <!--------->
  <table id="table_products" width="100%">
    <thead>
      <tr>
        <th align="center">UUID</th>
        <th align="center">Serie</th>
        <th align="center">Folio</th>
        <th align="center">Moneda</th>
        <th align="center">TC</th>
        <th align="center">Método de pago</th>
        <th align="center">Parcialidad</th>
        <th align="center">Saldo anterior</th>
        <th align="center">Monto pagado</th>
        <th align="center">Saldo insoluto</th>
      </tr>
    </thead>
    <tbody>
      @if($customer_payment->customerPaymentReconcileds->isNotEmpty())
        @foreach($customer_payment->customerPaymentReconcileds as $result)
          @php
            $customer_invoice = $result->reconciled;
            $tmp = \App\Helpers\Helper::invertBalanceCurrency($customer_payment->currency,$result->amount_reconciled,$customer_invoice->currency->code,$result->currency_value);
            $saldo_insoluto = $result->last_balance - $tmp;
          @endphp
          <tr>
            <td class="text-left">{{ $customer_invoice->customerInvoiceCfdi->uuid }}</td>
            <td class="text-center">{{ $customer_invoice->serie }}</td>
            <td class="text-center">{{ $customer_invoice->folio }}</td>
            <td class="text-center">{{ $customer_invoice->currency->code }}</td>
            <td class="text-center">
              @if($customer_payment->currency->code != $customer_invoice->currency->code)
                {{ \App\Helpers\Helper::numberFormatMoney($customer_payment->currency_value/$result->currency_value,4) }}
              @endif
            </td>
            <td class="text-center">{{ $customer_invoice->paymentMethod->code }}</td>
            <td class="text-center">{{ $result->number_of_payment }}</td>
            <td class="text-right">
              $ {{number_format($result->last_balance, 2,'.', ',') }}
            </td>
            <td class="text-right">
              $ {{number_format($tmp, 2,'.', ',') }}
            </td>
            <td class="text-right">
              $ {{number_format($saldo_insoluto, 2,'.', ',') }}
            </td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
  <!--------->
  @if(!empty($customer_payment->cfdi_relation_id))
    <table id="table_products" width="100%">
      <thead>
        <tr>
          <th class="text-center">CFDI's relacionadas</th>
          <th class="text-center">- {{ $customer_payment->cfdiRelation->name }}</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center">
            @if($customer_payment->customerPaymentRelations->isNotEmpty())
              @foreach($customer_payment->customerPaymentRelations as $result)
                {{$result->relation->name}}<br/>
              @endforeach
            @endif
          </td>
          <td class="text-center">
            @if($customer_payment->customerPaymentRelations->isNotEmpty())
              @foreach($customer_payment->customerPaymentRelations as $result)
                {{$result->relation->customerPaymentCfdi->uuid}}<br/>
              @endforeach
            @endif
          </td>
        </tr>
      </tbody>
    </table>
  @endif
  <!--------->
  @if(!empty($customer_payment->comment))
  <table id="table_products" width="100%">
    <thead>
      <tr>
        <th class="text-center">Comentario</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="text-center">
          {{ $customer_payment->comment }}
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

  <br><br>

</body>
</html>
