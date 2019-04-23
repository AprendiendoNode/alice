@extends('layouts.admin')

@section('contentheader_title')
  {{ trans('header.dashboard') }}
@endsection

@section('breadcrumb_title')
  {{ trans('breadcrumb.home') }}
@endsection

@section('content')
  @if( auth()->user()->can('View dashboard pral') )
  <!-- <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body dashboard-tabs p-0">
        </div>
      </div>
    </div>
  </div> -->
  <div class="row">
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <p class="card-title">Dashboard NPS del <span>2019-03</span></p>
          <canvas id="cash-deposits-chart"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <p class="card-title">Distribución de antenas por país</p>
        </div>
        <canvas id="total-sales-chart"></canvas>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <p class="card-title">Tickets resueltos en el año.</p>
          <div class="table-responsive">
            <table id="recent-purchases-listing" class="table">
              <thead>
                <tr>
                    <th>Name</th>
                    <th>Status report</th>
                    <th>Office</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Gross amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                    <td>Jeremy Ortega</td>
                    <td>Levelled up</td>
                    <td>Catalinaborough</td>
                    <td>$790</td>
                    <td>06 Jan 2018</td>
                    <td>$2274253</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <p class="card-title">Pagos registrados - 1 Semana atras de la fecha actual</p>
          <div class="table-responsive">
            <table id="recent-purchases-listing" class="table">
              <thead>
                <tr>
                  <th>Factura</th>
                  <th>Proveedor</th>
                  <th>Estatus</th>
                  <th>Realizo</th>
                  <th>Monto</th>
                  <th>Moneda</th>
                  <th>Fecha</th>
                  <th>Folio</th>
                  <th>Elaboro</th>
                  <th>Concepto</th>
                  <th>Fecha elaboro</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                    <td>Jeremy Ortega</td>
                    <td>Levelled up</td>
                    <td>Activo</td>
                    <td>Catalinaborough</td>
                    <td>$790</td>
                    <td>Pesos Mexicanos</td>
                    <td>06 hyd 2018</td>
                    <td>123456</td>
                    <td>CGABGISI IAJSJD</td>
                    <td>Lorem ipsum dolor</td>
                    <td>06 Jan 2018</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  @else
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card mb-3">
            <div class="card-header bg-primary text-white">Dashboard</div>
            <div class="card-body mb-3 mt-2">
              <i class="mdi mdi-bell-ring text-primary"></i> Has iniciado sesión!
              <br>
            </div>
            <span class="badge badge-secondary y-4">
              @php
              $dt = new DateTime(); echo $dt->format('d-m-Y H:i:s');
              @endphp
            </span>
          </div>

          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
        </div>
      </div>
    </div>
  @endif
@endsection
