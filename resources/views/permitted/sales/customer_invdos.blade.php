@extends('layouts.admin')

@section('contentheader_title')
  lorem
@endsection

@section('breadcrumb_title')
  lorem
@endsection

@section('content')

<!----------------------------------------------------------------------------->
<div class="card">
	<div class="card-body">
		<h4 class="card-title">
      @lang('customer_invoice.document_title_simple') Preview
      <i class="mdi mdi-check-circle-outline font-weight-bold ml-auto px-1 py-1 text-info mdi-24px"></i>
    </h4><hr>
    @php
        //Obtiene datos del Cfdi33
        $cfdi33 = $data['cfdi33'];
    @endphp
    <table width="100%">
      <tr>
          <td style="width:25%;" valign="top"><img width="120" src="@forelse ($companies as $data_company) {{ asset('images/storage/'.$data_company->image) }} @empty {{ __('reservedwords.notavailable') }}  @endforelse"/></td>
          <td class="header_address" style="width:50%;" class="" align="center">
              <h4>@forelse ($companies as $data_company) {{ $data_company->name }} @empty {{ __('reservedwords.notavailable') }}  @endforelse</h4>
              <h5>@forelse ($companies as $data_company) {{ $data_company->taxid }} @empty {{ __('reservedwords.notavailable') }}  @endforelse</h5>
              <p class="text-address">@forelse ($companies as $data_company) {{ $data_company->address_1 }} @empty {{ __('reservedwords.notavailable') }}  @endforelse,
                CP @forelse ($companies as $data_company) {{ $data_company->postcode }} @empty {{ __('reservedwords.notavailable') }}  @endforelse,
                   @forelse ($companies as $data_company) {{ $data_company->state }} @empty {{ __('reservedwords.notavailable') }} @endforelse, @forelse ($companies as $data_company) {{ $data_company->country }} @empty {{ __('reservedwords.notavailable') }} @endforelse</p>
              <p>Régimen fiscal: @forelse ($companies as $data_company) {{ $data_company->tax_regimen }} @empty {{ __('reservedwords.notavailable') }}  @endforelse</p>
          </td>
          <td style="width:25%;" valign="top"></td>
      </tr>
    </table>

    <div  class="header row mb-5">
      <div class="">
          {{-- <p><span># {{ $customer_invoice->name }}</span></p> --}}
          <p>Serie/Folio interno: <span>{{ $customer_invoice->serie }}</span> <span>{{ $customer_invoice->folio }}</span></p>
          <p>UUID: <span>{{ $customer_invoice->customerInvoiceCfdi->uuid ?? '' }}</span></p>
          <p>Lugar de expedición: <span>{{ $customer_invoice->branchOffice->name ?? '' }}</span> {!! ($customer_invoice->branchOffice->postcode ? '<strong>C.P.</strong> <span>' . $customer_invoice->branchOffice->postcode : '') !!}</span>
          <p>Tipo de comprobante: <span>[{{ $customer_invoice->documentType->cfdiType->code ?? '' }}] {{ $customer_invoice->documentType->cfdiType->name ?? '' }}</span> </p>
          <p>Términos de pago: <span>{{ $customer_invoice->paymentTerm->name }}</span> </p>
          <p class="transparent">-</p>
      </div>
      <div class="">
          <p>Fecha: <span>{{ \App\Helpers\Helper::convertSqlToDateTime($customer_invoice->date) }}</span> </p>
          <p>Fecha vencimiento: <span>{{ \App\Helpers\Helper::convertSqlToDate($customer_invoice->date_due) }}</span> </p>
          <p>Uso de CFDI: <span>[{{ $customer_invoice->cfdiUse->code }}] {{ $customer_invoice->cfdiUse->name }}</span> </p>
          <p>Moneda: <span>{{ $customer_invoice->currency->name }}</span></p>
          <p>Tipo de cambio: <span>{{ $customer_invoice->currency_value }}</span></p>
          <p class="transparent">-</p>
          <p class="transparent">-</p>
      </div>
      <div class="">
        <p>Forma de pago: <span>[{{ $customer_invoice->paymentWay->code }}] {{ $customer_invoice->paymentWay->name }}</span></p>
        <p>Método de pago: <span>[{{ $customer_invoice->paymentMethod->code }}]{{ $customer_invoice->paymentMethod->name }}</span></p>
        @if(!empty($cfdi33))
          <p>Certificado: <span>{{ $cfdi33['NoCertificado'] }}</span></p>
          <p>Certificado SAT: <span>{{ $cfdi33->complemento->timbreFiscalDigital['NoCertificadoSAT'] }}</span></p>
          <p>Fecha y hora de certificación: <span>{{ \App\Helpers\Helper::convertSqlToDateTime(str_replace('T',' ',$cfdi33->complemento->timbreFiscalDigital['FechaTimbrado'])) }}</span> </p>
        @endif


      </div>
    </div>

    <div  class="customer row mb-5 ">
      <div class="">
          <p>Nombre cliente: <span>{{ mb_strtoupper($customer_invoice->customer->name) }}</span> </p>
          <p>Dirección: <span>{{ $customer_invoice->customer->address_1 ?? '' }} {{ $customer_invoice->customer->address_2 ?? '' }} {{ $customer_invoice->customer->address_3 ?? '' }} {{ $customer_invoice->customer->address_4 ?? '' }}</span> </p>
          <p>C.P: <span>{{ $customer_invoice->customer->postcode ?? '' }}</span> </p>
          <p>RFC: <span>{{ mb_strtoupper($customer_invoice->customer->taxid) }}</span> </p>
          <p>Uso de cfdi: <span>[{{ mb_strtoupper( $customer_invoice->customer->cfdiUse->code) }}]{{ $customer_invoice->customer->cfdiUse->name }}</span> </p>

      </div>
    </div>


    <!-- Table row -->
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="table-responsive mb-5">
              <!--------->
                <table class="table table-striped table-bordered"  id="table_products" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">{{ mb_strtoupper(__('customer_invoice.column_line_name')) }}</th>
                        <th class="text-center"
                            width="9%">{{ mb_strtoupper(__('customer_invoice.column_line_sat_product_id')) }}</th>
                        <th class="text-center"
                            width="14%">{{ mb_strtoupper(__('customer_invoice.column_line_unit_measure_id')) }}</th>
                        <th class="text-center"
                            width="7%">{{ mb_strtoupper(__('customer_invoice.column_line_quantity')) }}</th>
                        <th class="text-center"
                            width="9%">{{ mb_strtoupper(__('customer_invoice.column_line_price_unit')) }}</th>
                        <th class="text-center"
                            width="6%">{{ mb_strtoupper(__('customer_invoice.column_line_discount')) }}</th>
                        <th class="text-right"
                            width="11%">{{ mb_strtoupper(__('customer_invoice.column_line_amount_untaxed')) }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customer_invoice->customerInvoiceLines as $result)
                        <tr>
                            <td>{{ $result->name }}</td>
                            <td class="text-center">{{ $result->satProduct->code }}</td>
                            <td class="text-center">{{ $result->unitMeasure->name_sat }}</td>
                            <td class="text-center">{{ $result->quantity,$result->unitMeasure->decimal_place }}</td>
                            <td class="text-center">{{ $result->price_unit }}</td>
                            <td class="text-center">{{ $result->discount }}</td>
                            <td class="text-right">{{ $result->amount_untaxed,$customer_invoice->currency->code }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row" style="margin-bottom: 30px;">
      <div class="col-md-6 col-xs-12 offset-md-6">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                <tr>
                    <th style="width:50%">@lang('general.text_amount_untaxed')</th>
                    <td>{{ $customer_invoice->amount_untaxed,$customer_invoice->currency->code }}</td>
                </tr>
                @if($customer_invoice->customerInvoiceTaxes->isNotEmpty())
                    @foreach($customer_invoice->customerInvoiceTaxes as $result)
                        <tr>
                            <th>{{$result->name}}</th>
                            <td>{{ abs($result->amount_tax),$customer_invoice->currency->code }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <th>{{ mb_strtoupper(__('general.text_amount_total')) }}</th>
                    <td>{{ $customer_invoice->amount_total,$customer_invoice->currency->code }}</td>
                </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
    <!--------->
    @if(!empty($cfdi33))
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <table border="1" cellpadding="0" cellspacing="0" class="table" width="100%" style="table-layout: fixed;"  id="table_cfdi" >
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
        </table>
      </div>
    </div>
    @endif


	</div>
</div>

{{ var_dump($data)}}


<!----------------------------------------------------------------------------->



@endsection

@push('scripts')
<style media="screen">
  table.table-bordered{
      border:1px solid black;
      margin-top:20px;
    }
  table.table-bordered > thead > tr > th{
      border:1px solid black;
  }
  table.table-bordered > tbody > tr > td{
      border:1px solid black;
  }

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
  height: auto;
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
  line-height: .9rem;
  display: block;
}

.customer{
  border: 1px solid #000;
  border-radius: 5px;
  margin-top: 20px;
  font-size: 9px;
  height: auto;
}

.customer div{
  display: inline-block;
  width: 100%;
  padding: 1.2rem 1px;
  font-weight: bold;
  text-align: left;
}

.customer div span{
  font-weight: normal !important;
}

.customer div p{
  line-height: .9rem;
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
@endpush
