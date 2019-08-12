@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View cover delivery') )
    {{ trans('message.title_cover_delivery') }}
  @else
    {{ trans('message.title_cover_delivery') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View cover delivery') )
    {{ trans('message.subtitle_cover_delivery') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View cover delivery') )
    {{ trans('message.breadcrumb_cover_delivery') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View cover delivery') )
      <div class="container">
          <div class="row">
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-body">
                    <div class="form-inline">
                        {{ csrf_field() }}

                        <div class="form-group row">
                          <label for="select_one" class="control-label col-md-1">{{ trans('message.grupo') }}: </label>
                          <select id="select_one" name="select_one"  class="form-control select2 col-md-7" required>
                            <option value="" selected> Elija un grupo </option>
                            @forelse ($groups as $data_group)
                              <option value="{{ $data_group->id }}"> {{ $data_group->name }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                        <div class="form-group pt-3">
                            <button type="button" id="btn_generar" class="btn btn-info btngeneral"><i class="fa fa-bullseye margin-r5"></i> {{ trans('message.generate') }}</button>
                            <button type="button" class="btn btn-danger btn-export hidden-xs ml-2"><i class="far fa-file-pdf"></i> {{ trans('message.export') }} Portada</button>
                        </div>
                    </div>
                   </div>
                </div>
              </div>


            <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <div class="hojitha"   style="background-color: #fff; border:1px solid #ccc; border-bottom-style:hidden; padding:10px; width:100%">
                  <div class="row pad-top-botm ">
                      <div class="col-lg-3 col-md-3 col-sm-3 ">
                         <img class="logo-sit" src="{{ asset('/images/users/logo.svg') }}" style="padding-bottom:20px;width:150px" />
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 text-center">
                        <h2> <small>Entrega de equipos</small></h2>
                        <h4 id="name_group">GRUPO:</h4>

                        <br />
                      </div>

                  </div>

                  <div class="row text-center contact-info">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <hr />
                           <span>
                             <strong>Expedición de reporte: </strong>
                              @php
                               $mytime = Carbon\Carbon::now();
                               echo $mytime->toDateTimeString();
                              @endphp
                          </span>
                          <hr />
                      </div>
                  </div>

                  <div  class="row pad-top-botm client-info">
                    <div style="font-size:16px;" class="col-lg-6 col-md-6 col-sm-6">
                      <p class="text-center" style="border: 1px solid #FF851B" >Empresa</p>
                      <strong>Nombre: </strong><small id="name_htl"></small>
                      <br />
                      <strong>ID Proyecto:</strong> <small id="id_proyect"></small>
                      <br />
                      <strong>Dirección: </strong><small id="dir"></small>
                      <br />
                      <strong>País: </strong><small id="country"></small>
                      <br />
                      <strong>Estado: </strong><small id="state"></small>
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

                  <div class="row pad-top-botm client-info">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="clearfix">
                          <div id="main_equipos" style="width: 100%; min-height: 300px; border:1px solid #ccc;padding:10px;"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="clearfix">
                          <div id="main_modelos" style="width: 100%; min-height: 300px; border:1px solid #ccc;padding:10px;"></div>
                        </div>
                    </div>
                  </div>
                  <!-- Tabla -->
                  <div id="captura_table_general" style="background-color: #fff; border:1px solid #ccc; border-top-style:hidden; padding:10px; width: 100%">
                    <div  class="row pad-top-botm client-info">



                    </div>
                    <div class="row text-center contact-info">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <hr />
                        <span>
                          <strong>Grupos detallado</strong>
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
                                <th>Ubicación</th>
                                <th>Equipo</th>
                                <th>MAC</th>
                                <th>Serie</th>
                                <th>Modelo</th>
                                <th>Descripción</th>
                                <th>Marca</th>
                                <th>Estado</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row pad-top-botm client-info">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="clearfix">
                          <div id="comentarios" style="width: 100%; min-height: 150px; border:1px solid #ccc;padding:10px;">Observaciones o comentarios:</div>
                        </div>
                    </div>
                  </div>

                  <div class="row pad-top-botm client-info text-center">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="clearfix">
                          <hr>
                          <strong>Nombre y Firma recibe</strong>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="clearfix">
                          <hr>
                          <strong>Nombre y Firma entrega</strong>
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
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
    <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pdf.css')}}" >
    <script src="/plugins/momentupdate/moment-with-locales.js"></script>
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/inventory/cover_delivery.js')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
