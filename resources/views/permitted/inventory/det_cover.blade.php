@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View cover') )
    {{ trans('message.breadcrumb_detailed_cover') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View cover') )
    {{ trans('message.breadcrumb_detailed_cover') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View cover') )
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <div class="card">
                <div class="card-body">
                  <div class="form-inline d-flex justify-content-around">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label for="select_one" class="control-label">{{ trans('message.hotel') }}:&nbsp;</label>
                        <select id="select_one" name="select_one"  class="form-control select2" required>
                          <option value="" selected> Elija </option>
                          @forelse ($hotels as $data_hotel)
                            <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                      <div class="form-group mt-sm-0 mt-3">
                          <button type="button" id="btn_generar" class="btn btn-dark btngeneral"><i class="fa fa-bullseye margin-r5"></i> {{ trans('message.generate') }}</button>
                      </div>
                      <div class="form-group mt-sm-0 mt-3">
                          <button type="button" class="btn btn-danger btn-export hidden-xs"><i class="fas fa-file-pdf  margin-r5"></i> {{ trans('message.export') }} Portada</button>
                      </div>
                  </div>
                 </div>
              </div>
            </div>

            <div id="client_updl" class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mt-4">
                <div class="card with-border">
                  <div class="card-body">
                      <h3 class="card-title">Actualizar datos del cliente</h3>
                    <div class="row">
                      <form id="validate_client" name="validate_client" action="" method="POST" class="form-inline d-flex justify-content-between">
                        {{ csrf_field() }}
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="update_cliente_responsable" class="control-label">Responsable:</label>
                            <input type="text" class="form-control required" id="update_cliente_responsable" name="update_cliente_responsable">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="update_cliente_tel" class="control-label">Teléfono:</label>
                            <input type="text" class="form-control" id="update_cliente_tel" name="update_cliente_tel">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="update_cliente_email" class="control-label">Correo:</label>
                            <input type="text" class="form-control" id="update_cliente_email" name="update_cliente_email">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group" style="padding-top: 25px">
                            <button type="submit" class="btn btn-secondary"><i class="fa fa-save margin-r5"></i> Guardar & Actualizar</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            </div>


            <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mt-3">
              <div class="hojitha"   style="background-color: #fff; border:1px solid #ccc; border-bottom-style:hidden; padding:10px; width: 100%">
                  <div class="row pad-top-botm ">
                      <div class="col-lg-3 col-md-3 col-sm-3 text-center">
                         <img class="img-fluid" src="{{ asset('/images/users/logo.svg') }}" style="width:120px" />
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 text-center">
                        <h2> <small>Carta de entrega</small></h2>
                        <strong id="name_htl"></strong>
                        <br />
                        <strong>ID Proyecto:</strong> <small id="id_proyect"></small>
                        <br />
                        <strong>Equipo activo</strong>
                        <br />
                      </div>
                      <div class="col-lg-3 col-md-3 col-sm-3 text-center">
                         <img class="logo-sit" id="client_img" src="{{ asset('images/hotel/Hard_Rock_Punta_Cana.svg') }}" style="padding-bottom:20px;width: 100%" />
                      </div>
                  </div>

                  <div class="row text-center contact-info">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <hr />
                          <span>
                              <strong>Email: </strong><small id="email"></small>
                          </span>
                          <span>
                              <strong>Telf: </strong><small id="tel"></small>
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
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <p class="text-center" style="border: 1px solid #FF851B" >Empresa</p>
                      <strong>Nombre: </strong><small id="empresa"></small>
                      <br />
                      <strong>Responsable: </strong><small id="responsable"></small>
                      <br />
                      <strong>Área de trabajo: </strong><small id="area"></small>
                      <br />
                      <strong>Dirección: </strong><small id="dir"></small>
                      <br />
                      <strong>Teléfono: </strong><small id="tel_empresa"></small>
                      <br />
                      <strong>Correo: </strong><small id="correo_empresa"></small>
                      <br />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <p class="text-center" style="border: 1px solid #007bff" >Cliente</p>
                      <strong>Nombre: </strong><small id="cliente_nombre"></small>
                      <br />
                      <strong>Responsable: </strong><small id="cliente_responsable"></small>
                      <br />
                      <strong>Ubicación: </strong><small id="cliente_ubi"></small>
                      <br />
                      <strong>Dirección: </strong><small id="cliente_dir"></small>
                      <br />
                      <strong>Teléfono: </strong><small id="cliente_tel"></small>
                      <br />
                      <strong>Correo: </strong><small id="cliente_email"></small>
                      <br />
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <br />
                      <p class="text-center" style="border: 1px solid #3D9970" >Información</p>
                      Las instalaciones de los equipos se realizaron acorde a cada uno de los términos y condiciones, respetando así el tiempo estipulado para las instalaciones.
                      <br />
                      <strong>Fecha de inicio del proyecto: </strong><small id="fecha_ini"></small>
                      <br />
                      <strong>Fecha de termino del proyecto:</strong><small id="fecha_fin"></small>
                      <br />
                    </div>

                  </div>

                  <div  class="row text-center contact-info">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <hr />
                        <span>
                            <strong>Equipamiento</strong>
                        </span>
                      <hr />
                    </div>
                  </div>

                  <div class="row mt-2 client-info">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="clearfix">
                          <div id="main_equipos" style="width: 100%; min-height: 500px; border:1px solid #ccc;padding:10px;"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 mt-2 mt-sm-0">
                      <div class="clearfix">
                          <div id="main_modelos" style="width: 100%; min-height: 500px; border:1px solid #ccc;padding:10px;"></div>
                        </div>
                    </div>
                  </div>
                  <div class="row mt-3 client-info">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="clearfix">
                          <div id="comentarios" style="width: 100%; min-height: 80px; border:1px solid #ccc;padding:10px;">Observaciones o comentarios:</div>
                        </div>
                    </div>
                  </div>

                  <div class="row pad-top-botm client-info text-center">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="clearfix">
                          <hr>
                          <strong>Nombre y Firma del responsable del proyecto.</strong>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="clearfix">
                          <hr>
                          <strong>Nombre y Firma del cliente.</strong>
                      </div>
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
  @if( auth()->user()->can('View cover') )
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/admin/inventory/cover_update_client.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
    <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
    <script src="{{ asset('js/admin/inventory/cover.js')}}"></script>
  @else
  @endif
@endpush
