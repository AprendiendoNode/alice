@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View filter proyect payment') )
    {{ trans('message.pay_filter_request') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View filter proyect payment') )
    {{ trans('message.breadcrumb_pay_filter') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View filter proyect payment') )
      <div class="container">
        <div class="card">
          <div class="card-body">

              <form id="search_info" name="search_info" class="form-inline" method="post">
                {{ csrf_field() }}

                  <div class="row form-group w-100">
                    <div class="col-md-3" style="font-size:90% !important;">
                      <label for="" class="control-label" >Buscar por hotel</label>
                    </div>
                      <select class="form-control col-md-6 select2" id="hotel" name="hotel" >
                        <option value="">Elegir</option>
                        @forelse ($cadena as $data_cadena )
                          <option value="{{ $data_cadena->id }}"> {{ $data_cadena->hotel }} </option>
                        @empty

                        @endforelse
                      </select>
                      <div class="col-md-3 pl-3">

                        <input class="form-control" list="folios" name="searchFolio" id="searchFolio" placeholder="Buscar por folio">
                        <datalist id="folios" name="folios" class="">
                          @forelse ($folio as $data_folio )
                            <option value="{{ $data_folio->folio}}"> </option>
                          @empty
                            <option value="No se encontraron registros"> </option>
                          @endforelse
                        </datalist>
                      </div>
                  </div>

                  <!-- <div class="form-group">
                    <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                      <i class="glyphicon glyphicon-filter" aria-hidden="true"></i>  Filtrar
                    </button>
                  </div> -->


              </form>
        <br>
        <!--SIERRA BEGIN-->
          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <form id="search_info2" name="search_info" class="form-inline" method="post">
                  {{ csrf_field() }}
                  <div class="">
                    <div class="form-group">
                      <div class="col-md-4">
                      <label for="" class="control-label">Buscar por proveedor</label>
                      </div>
                      <div class="col-md-3">
                        <select class="form-control select2 pl-2" id="proveedor" name="proveedor">
                          <option value="">Elegir</option>
                          @forelse ($proveedor as $data_proveedor )
                          <option value="{{ $data_proveedor->id }}"> {{ $data_proveedor->name }} </option>
                          @empty

                          @endforelse
                        </select>
                      </div>
                    </div>
                  </div>
                </form>
            </div>
          </div>
          <br>
        <!--SIERRA END-->
        
        <!--Cuenta contable-->
          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <form class="form-inline" method="post">
                  <div class="form-group">
                    <div class="col-md-6">
                      <label for="" class="control-label">Buscar por cuenta contable</label>
                    </div>
                    <div class="col-md-6">
                      <select class="form-control select2 pl-2" id="select_cc" name="select_cc">
                        <option value="">Elegir</option>
                        @forelse ($cuentas as $data_contable )
                        <option value="{{ $data_contable->cuenta_contable }}"> {{ $data_contable->cuenta_contable }} </option>
                        @empty

                        @endforelse
                      </select>
                    </div>
                  </div>
                </form>
            </div>
          </div>
          <br>
        <!--CC END-->

        <!--Cuenta contable-->
          <!-- <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <form>
                <div class="form-group">
                  <div class="col-md-2">
                  <label for="" class="control-label">Buscar por proveedor</label>
                  </div>
                  <div class="col-md-10">
                    <select class="form-control select2 pl-2" id="proveedor" name="proveedor">
                      <option value="">Elegir</option>
                      @forelse ($proveedor as $data_proveedor )
                      <option value="{{ $data_proveedor->id }}"> {{ $data_proveedor->name }} </option>
                      @empty

                      @endforelse
                    </select>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <br> -->
        <!--CC END-->

          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">

                <table id="table_pays" class="table table-striped table-bordered table-hover text-white compact-tab" style="width:100%">
                  <thead>
                    <tr class="bg-primary" style="background: #088A68;">
                      <th> <small>Factura</small> </th>
                      <th> <small>Proveedor</small> </th>
                      <th> <small>Estatus</small> </th>
                      <th> <small>Monto</small> </th>
                      <th> <small>Elaboró</small> </th>
                      <th> <small>Fecha de solicitud</small> </th>
                      <th> <small>Fecha límite de pago</small> </th>
                      <th> <small>Conceptos</small> </th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot id='tfoot_average'>
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                </table>

              </div>
              </div>
            </div>
        </div><!---row-->
      </div>


      @include('permitted.payments.modal_payment')

    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  <style media="screen">
  .pt-10 { padding-top: 10px;  }
  .margin-top-short{ margin-top: 7px;  }
  .modal-content{
    width: 180% !important;
    margin-left: -30% !important;
  }

  input:disabled,textarea:disabled {
       background: #ffffff !important;
       border-radius: 3px;
   }
    .margin-top-short{
      margin-top: 7px;
    }
  </style>
  @if( auth()->user()->can('View filter proyect payment') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('js/admin/payments/request_modal_payment.js')}}"></script>
    <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
    <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
    <script src="{{ asset('js/admin/payments/filters_pay.js')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
