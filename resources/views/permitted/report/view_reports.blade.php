@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View report') )
    {{ trans('message.breadcrumb_view_report') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View report') )
    {{ trans('message.breadcrumb_view_report') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View report') )
  <div class="container">
          <div class="row">
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mb-3">
                <div class="card">
                  <div class="card-body">
                    <div class="form-inline">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <label for="select_one" class="control-label">{{ trans('message.hotel') }}: </label>
                          <select id="select_one" name="select_one"  class="form-control select2" required>
                            <option value="" selected> Elija </option>
                            @forelse ($hotels as $hotel)
                              <option value="{{ $hotel->id }}"> {{ $hotel->Nombre_hotel }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="select_two" class="control-label">{{ trans('message.type') }}: </label>
                          <select id="select_two" name="select_two"  class="form-control select2" required>
                            <option value="" selected> Elija </option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="calendar_fecha" class="control-label">{{ trans('message.date') }}:</label>
                          <input type="text" class="form-control datepickermonth" id="calendar_fecha" placeholder="Example: 2017-12">
                        </div>
                        <div class="form-group">
                            <button type="button" id="btn_generar" class="btn btn-info btngeneral"><i class="fa fa-bullseye margin-r5"></i> {{ trans('message.generate') }}</button>
                            <button type="button" class="btn btn-success btn-export hidden-xs"><i class="fas fa-file-pdf  margin-r5"></i> {{ trans('message.export') }}</button>
                        </div>
                    </div>
                   </div>
                </div>
              </div>


              <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="hojitha"   style="background-color: #fff; border:1px solid #ccc; border-bottom-style:hidden; padding:10px; width: 100%">
                    <div class="row pad-top-botm ">
                        <div class="col-lg-3 col-md-3 col-sm-3 ">
                           <img class="img-fluid" src="{{ asset('/img/company/sitwifi_logo.jpg') }}" style="width:140px" />
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 text-center">
                          <h2><strong> Reporte de uso y estadísticas</strong></h2>
                          <strong style="font-style: italic;">Red wifi huéspedes / Guest</strong>
                          <br />
                          <p id="client_name">Hard Rock Punta Cana</p>
                          <strong>ID Proyecto:</strong> <small id="id_proyect"></small>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 ">
                           <img class="logo-sit" id="client_img" src="{{ asset('images/hotel/Hard_Rock_Punta_Cana.svg') }}" style="padding-bottom:20px;" />
                        </div>
                    </div>

                    <div class="row text-center contact-info">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <hr />
                            <span>
                                <strong>Email : </strong><small id="email"></small>
                            </span>
                            <span>
                                <strong>Telf : </strong><small id="tel"></small>
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
                        <p class="text-center" style="border: 1px solid #FF851B" >Gigabyte</p>
                        <strong><i class="fa fa-rss"></i> Maximo/Max: </strong> <p id="gigamax" class="sameline"></p>
                        <br />
                        <strong><i class="fa fa-upload"></i> Minino/Min:</strong> <p id="gigamin" class="sameline"></p>
                        <br />
                        <strong><i class="fa fa-database"></i> Promedio/Average:</strong> <p id="gigaprom" class="sameline"></p>
                      </div>


                      <div class="col-lg-3 col-md-3 col-sm-3">
                        <p class="text-center" style="border: 1px solid #007bff" >Usuarios/Users</p>
                        <strong><i class="fa fa fa-level-up"></i><i class="fa fa fa fa-user"></i>  Maximo por mes/Max per month: </strong> <p id="usermax" class="sameline"></p>
                        <br />
                        <strong><i class="fa fa-users"></i> Promedio/Average:</strong> <p id="userprom" class="sameline"></p>
                        <br />
                        <strong><i class="fa fa-database"></i>No. Usuarios mensuales/User per month:</strong> <p id="usermonth" class="sameline"> </p>
                      </div>

                      <div class="col-lg-3 col-md-3 col-sm-3">
                        <p class="text-center" style="border: 1px solid #3D9970" >Información Ad/Additional Inf.</p>
                        <strong><i class="fa fa fa-hdd-o"></i> No. Antenas/AP's: </strong> <p id="noant" class="sameline"> </p>
                        <br />
                        <strong><i class="fa fa-tablet"></i> Rogue devices:</strong> <p id="rogue" class="sameline"> - </p>
                        <br />
                      </div>

                      <div class="col-lg-3 col-md-3 col-sm-3">
                        <p class="text-center" style="border: 1px solid #D53A35" >Dispositivos/Devices</p>
                        <strong><i class="fa fa-desktop"></i> Diversos dispositivos por mes/Mult. devices per month: </strong> <p id="device" class="sameline"> </p>
                        <br />
                        <strong><i class="fa fa-building-o"></i> Promedio dispositivos por habitación diarios/ Average devices per room daily:</strong> <p id="promdevice" class="sameline"> </p>
                        <br />
                      </div>
                    </div>

                    <div  class="row text-center contact-info pad-top-botm" id="comment_section" style="display: block;">
                      <div class="col-lg-3 col-md-3 col-sm-3"></div>
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <hr />
                          <span>
                              <strong>Comentarios:</strong>
                          </span>
                        <hr />
                        <div class="clearfix pad-top-botm">
                            <div style="width: 100%; border: 1px solid #ccc;padding: 10px;"><p id="comment_text"></p></div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-3 col-sm-3"></div>
                    </div>

                    <div  class="row text-center contact-info">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <hr />
                          <span>
                              <strong>Clientes/Clients</strong>
                          </span>
                        <hr />
                      </div>
                    </div>

                    <div class="row pad-top-botm client-info">
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="clearfix">
                            <div id="main_client_wlan" style="width: 100%; min-height: 300px; border:1px solid #ccc;padding:10px;"></div>
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="clearfix">
                            <div id="main_top_ssid" style="width: 100%; min-height: 300px; border:1px solid #ccc;padding:10px;"></div>
                          </div>
                      </div>
                    </div>

                    <div  class="row text-center contact-info">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <hr />
                          <span>
                              <strong>Consumos/Consumption</strong>
                          </span>
                        <hr />
                      </div>
                    </div>

                    <div class="row pad-top-botm client-info">
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="clearfix">
                            <div id="main_client_day" style="width: 100%; min-height: 300px; border:1px solid #ccc;padding:10px;"></div>
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="clearfix">
                            <div id="main_gigabyte_day" style="width: 100%; min-height: 300px; border:1px solid #ccc;padding:10px;"></div>
                          </div>
                      </div>
                    </div>

                    <div class="row text-center contact-info">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <hr />
                          <span>
                              <strong>APS</strong>
                          </span>
                        <hr />
                      </div>
                    </div>

                    <div class="row pad-top-botm client-info">
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="clearfix">
                            <div id="main_top_aps" style="width: 100%; min-height: 280px; border:1px solid #ccc;padding:10px;"></div>
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="table-responsive">
                          <table id="table_top_aps" class="table table-striped table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Descripción/Description</th>
                                <th>MAC</th>
                                <th>No. Clientes./Clients</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                    <div  class="row text-center contact-info">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <hr/>
                          <span>
                              <strong>Tabla comparativa/Comparison</strong>
                          </span>
                        <hr />
                      </div>
                    </div>
                    <div class="row pad-top-botm client-info">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="table-responsive">
                          <table id="table_comparative" class="table table-striped table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Concepto/Concept</th>
                                <th>Mes 1</th>
                                <th>Mes 2</th>
                                <th>Identificador/Identifier</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                    <div id='adicional' name='adicional' class="row text-center contact-info" style="display:block;">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <hr />
                          <span>
                              <strong>Adicional</strong>
                          </span>
                        <hr />
                      </div>
                    </div>
                    <div class="row pad-top-botm client-info">
                      <div class="col-lg-6 col-md-6 col-sm-6" style="display:block;">
                        <div class="clearfix">
                            <div id="main_equipos" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;">
                              <strong>Tipos de dispositivos</strong>
                              <img id="client_device" src="{{ asset('images/hotel/Default.svg') }}" style="padding-bottom:20px; width: 100%;" />

                            </div>
                          </div>
                      </div>

                      <div class="col-lg-6 col-md-6 col-sm-6" style="display:block;">
                        <div class="clearfix">
                            <div id="main_modelos" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;">
                              <strong>Ancho de banda</strong>
                              <img id="client_band" src="{{ asset('images/hotel/Default.svg') }}" style="padding-bottom:20px; width: 100%;" />

                            </div>
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
  @if( auth()->user()->can('View report') )
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
    <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pdf.css')}}" >
    <script src="/plugins/momentupdate/moment-with-locales.js"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <script src="{{ asset('js/admin/report/view_reports.js?v2.0.1')}}"></script>
  @else
  <!--NO VER-->
  @endif
@endpush
