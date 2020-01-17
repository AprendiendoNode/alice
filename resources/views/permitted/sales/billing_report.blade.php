@extends('layouts.admin')

@section('contentheader_title')
 Reporte de facturacion
@endsection

@section('breadcrumb_title')
  
@endsection

@section('content')
  <div class="row">
    <div class="card">
        <div class="table-responsive">
            <table id="table_billing" class="table table-sm">
                <thead class="">
                    <tr>
                        <th>Tipo</th>
                        <th>Numero</th>
                        <th>Cliente</th>
                        <th>Nombre del cliente</th>
                        <th>Estatus</th>
                        <th>N</th>
                        <th>Subtotal</th>
                        <th>Descuento</th>
                        <th>Imp. IVA</th>
                        <th>Imp. Ref. IVA</th>
                        <th>Imp. Ref. ISR</th>
                        <th>Imp. Total</th>
                        <th>UUID</th>
                        <th>Dato 1</th>
                        <th>Dato 2</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
  </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/sales/billing_report.js')}}"></script>

@endpush
