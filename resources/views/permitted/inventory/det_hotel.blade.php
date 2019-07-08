@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View detailed for hotel') )
    {{ trans('message.breadcrumb_detailed_hotel') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View detailed for hotel') )
    {{ trans('message.breadcrumb_detailed_hotel') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View detailed for hotel') )
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form id="omega10" class="form-inline">
                  {{ csrf_field() }}
                  <div class="input-group mb-2 mr-sm-4 col-md-3">
                    <label for="select_one">Proyecto</label>
                    <select class="form-control" id="select_one" name="select_one" style="width: 100%;">
                      <option value="" selected>Elija un proyecto</option>
                      @forelse ($cadena as $data_cadena)
                        <option value="{{ $data_cadena->id }}"> {{ $data_cadena->name }} </option>
                        @empty
                      @endforelse
                    </select>
                  </div>
                  <div class="input-group mb-2 mr-sm-2 col-md-3">
                    <label for="select_two">Sitio</label>
                    <select class="form-control" id="select_two" name="select_two" style="width: 100%;">
                      <option value="" selected>Elija un sitio</option>

                    </select>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                    <button id="boton-generar" name="boton-generar" type="button" class="btn btn-outline-primary">
                       <i class="fas fa-filter" style="margin-right: 4px;"></i> Generar
                    </button>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                    <button id="boton-exportar" name="boton-exportar" type="button" class="btn btn-outline-danger">
                       <i class="fas fa-eye-slash" style="margin-right: 4px;"></i> Exportar.
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="captura_pdf_general" style="display:none" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="hojitha"   style="background-color: #fff; border:1px solid #ccc; border-bottom-style:hidden; padding:10px; width: 100%">
            <div class="row pad-top-botm ">
                <div class="col-lg-3 col-md-3 col-sm-3 ">
                   <img class="logo-sit" src="{{ asset('/images/users/logo.svg') }}" style="padding-bottom:20px;" />
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 ">
                  <strong >Cliente: </strong> <small id="client"></small>
                  <br />
                  <strong>Dirección:</strong> <small id="direccion"></small>
                  <br />
                  <strong>País:</strong> <small id="pais"></small>
                  <br />
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 ">
                 <strong>Estado:</strong> <small id="estado"></small>
                 <br />
                 <strong>Servicio:</strong> <small id="servicio"></small>
                 <br />
                 <strong>ID Proyecto:</strong> <small id="id_proyect"></small>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 ">
                   <img class="logo-sit" id="client_img" src="{{ asset('images/hotel/Default.svg') }}" style="padding-bottom:20px;" />
                </div>
            </div>

            <div class="row text-center contact-info">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <hr />
                    <span>
                        <strong>Email : </strong> <small id="email"></small>
                    </span>
                    <span>
                        <strong>Tel : </strong> <small id="tel"></small>
                    </span>
                     <span>
                        <strong>Expedición: </strong>  @php
                          $mytime = Carbon\Carbon::now();
                          echo $mytime->toDateTimeString();
                        @endphp
                    </span>
                    <hr />
                </div>
            </div>

            <div  class="row pad-top-botm client-info">
              <div class="col-lg-3 col-md-3 col-sm-3">
                <p class="text-center" style="border: 1px solid #FF851B" >Resumen</p>
                    <table class="table table-bordered" id="tableSum">
                      <thead>
                        <tr>
                          <th scope="col">Concepto</th>
                          <th scope="col">Cantidad</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3">
                <p class="text-center" style="border: 1px solid #007bff" >Switch</p>
                <table class="table table-bordered" id="tableSW">
                  <thead>
                    <tr>
                      <th scope="col">Concepto</th>
                      <th scope="col">Cantidad</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                <p class="text-center" style="border: 1px solid #3D9970" >Zone Director</p>
                <table class="table table-bordered" id="tableZD">
                  <thead>
                    <tr>
                      <th scope="col">Concepto</th>
                      <th scope="col">Cantidad</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="clearfix">
                  <div id="main_aps" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;"></div>
                </div>
              </div>
            </div>

            <div  class="row text-center contact-info">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <hr />
                  <span>
                      <strong>Grafica de número de equipos</strong>
                  </span>
                <hr />
              </div>
            </div>

            <div class="row pad-top-botm client-info">
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="clearfix">
                    <div id="main_equipos" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;"></div>
                  </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="clearfix">
                    <div id="main_modelos" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;"></div>
                  </div>
              </div>
            </div>

        </div>
        <div id="captura_table_general" style="background-color: #fff; border:1px solid #ccc; border-top-style:hidden; padding:10px; width: 100%">
          <div class="row text-center contact-info">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <hr />
              <span>
                <strong>Equipamiento detallado</strong>
              </span>
              <hr />
              <br/>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="table-responsive">
                <table id="table_equipment" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Equipo.</th>
                      <th>MAC</th>
                      <th>Serie.</th>
                      <th>Modelo</th>
                      <th>Descripción</th>
                      <th>Marca</th>
                      <th>Estado</th>
                      <!-- <th>Servicio</th> -->
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>






    </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View detailed for hotel') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('bower_components/datatables_bootstrap_4/datatables.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>

    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}"></script>
    <script src="{{ asset('js/admin/inventory/hoteld.js')}}"></script>
    <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pdf.css')}}" >
  @else
  @endif
@endpush
