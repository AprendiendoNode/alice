@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('Create id ubicacion') )
    {{ trans('message.idlocation') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('Create id ubicacion') )
    {{ trans('message.breadcrumb_idlocation') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('Create id ubicacion') )
      <div class="container">
        <div class="col-sm-12">
          <div class="white-box">
            <div class="wizard-content">
              <!-- <h4 class="">Crear un id ubicación</h4> -->
              <!-- <h6 class="card-subtitle"></h6> -->
              <div class="row">
                <!-- <form id="Ubicacion_sitios" name="Ubicacion_sitios" enctype="multipart/form-data"> -->
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="col-md-5">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="nav-tabs-custom">
                              <ul class="nav nav-tabs " role="tablist">
                                <li class="nav-item"><a href="#tab_1_1" class="nav-link active" data-toggle="tab" role="tab"><b>Crear</b></a></li>
                                <li class="nav-item"><a href="#tab_2_2" class="nav-link" data-toggle="tab" role="tab"><b>Editar</b></a></li>
                              </ul>
                              <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1" name="tab_1_1">
                                  <div class="row mt-10 tab_one">
                                    <form id="validation_crear" name="validation_crear" enctype="multipart/form-data">
                                      {{ csrf_field() }}
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="hotel_name" class="control-label">Nombre del sitio:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <input type="text" class="form-control form-control-sm required" id="hotel_name" name="hotel_name" maxlength="100">
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="hotel_address" class="control-label">Dirección:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <input type="text" class="form-control form-control-sm required" id="hotel_address" name="hotel_address" maxlength="100">
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="hotel_telephone" class="control-label">Telefono:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <input type="text" class="form-control form-control-sm required" id="hotel_telephone" name="hotel_telephone" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                      </div>

                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="hotel_street" class="control-label">Calle:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <input type="text" class="form-control form-control-sm required" id="hotel_street" name="hotel_street" maxlength="100" >
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label for="hotel_noext" class="control-label">No.Ext:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <input type="text" class="form-control form-control-sm required" id="hotel_noext" name="hotel_noext" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                      </div>

                                      <div class="col-md-4 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="hotel_noint" class="control-label">No.Int:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <input type="text" class="form-control form-control-sm required" id="hotel_noint" name="hotel_noint" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label for="hotel_cp" class="control-label">CP:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <input type="text" class="form-control form-control-sm required" id="hotel_cp" name="hotel_cp" maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                      </div>

                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="sel_master_grupo"> Selecciona el grupo:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <select class="form-control form-control-sm required" id="sel_master_grupo" name="sel_master_grupo" style="width:100%;">
                                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                                            @forelse ($cadenas as $data_cadenas)
                                            <option value="{{ $data_cadenas->id }}"> {{ $data_cadenas->name }} </option>
                                            @empty
                                            @endforelse
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="id_generate" class="control-label">ID ubicación</label>
                                          <input type="text" class="form-control form-control-sm" id="id_generate" name="id_generate" readonly>
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="sel_service"> Tipo de servicio:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <select class="form-control form-control-sm required" id="sel_service" name="sel_service" style="width:100%;">
                                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                                            @forelse ($servicios as $servicio)
                                            <option value="{{ $servicio->id }}"> {{ $servicio->Nombre_servicio }} </option>
                                            @empty
                                            @endforelse
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="sel_vertical"> Vertical:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <select class="form-control form-control-sm required" id="sel_vertical" name="sel_vertical" style="width:100%;">
                                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                                            @forelse ($verticals as $data_vertical)
                                            <option value="{{ $data_vertical->id }}"> {{ $data_vertical->name }} </option>
                                            @empty
                                            @endforelse
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2 mt-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info btngeneralcrear"><i class="fa fa-bullseye margin-r5"></i> Guardar</button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2_2" name="tab_2_2">
                                  <div class="row mt-10 tab_two">
                                    <form id="validation_edit" name="validation_edit" enctype="multipart/form-data">
                                      {{ csrf_field() }}
                                      <div class="col-md-8 col-md-offset-2">
                                      <div class="form-group">
                                        <label for="sel_edit_cadena"> Selecciona el grupo:
                                          <span style="color:red;">*</span>
                                        </label>
                                        <select class="form-control form-control-sm required" id="sel_edit_cadena" name="sel_edit_cadena" style="width:100%;">
                                          <option value="" selected>{{ trans('pay.select_op') }}</option>
                                          @forelse ($cadenas as $data_cadenas)
                                          <option value="{{ $data_cadenas->id }}"> {{ $data_cadenas->name }} </option>
                                          @empty
                                          @endforelse
                                        </select>
                                      </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="sel_edit_sitio"> Selecciona el sitio:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <select class="form-control form-control-sm required" id="sel_edit_sitio" name="sel_edit_sitio" style="width:100%;">
                                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="edit_hotel_name" class="control-label">Nombre del sitio:</label>
                                          <input type="text" class="form-control form-control-sm required" id="edit_hotel_name" name="edit_hotel_name" readonly>
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="edit_hotel_address" class="control-label">Dirección:</label>
                                          <input type="text" class="form-control form-control-sm required" id="edit_hotel_address" name="edit_hotel_address" readonly>
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="edit_hotel_telephone" class="control-label">Telefono:</label>
                                          <input type="text" class="form-control form-control-sm required" id="edit_hotel_telephone" name="edit_hotel_telephone" maxlength="30" readonly>
                                        </div>
                                      </div>
                                      <div class="col-md-4 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="edit_hotel_street" class="control-label">Calle:</label>
                                          <input type="text" class="form-control form-control-sm" id="edit_hotel_street" name="edit_hotel_street" maxlength="100" readonly>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label for="edit_hotel_noext" class="control-label">No.Ext:</label>
                                          <input type="text" class="form-control form-control-sm" id="edit_hotel_noext" name="edit_hotel_noext" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                                        </div>
                                      </div>

                                      <div class="col-md-4 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="edit_hotel_noint" class="control-label">No.Int:</label>
                                          <input type="text" class="form-control form-control-sm" id="edit_hotel_noint" name="edit_hotel_noint" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label for="edit_hotel_cp" class="control-label">CP:</label>
                                          <input type="text" class="form-control form-control-sm" id="edit_hotel_cp" name="edit_hotel_cp" maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                                        </div>
                                      </div>

                                      <div class="col-md-8 col-md-offset-2">
                                        <label  class="control-label">Id de ubicación:</label>
                                        <div class="input-group inputids">
                                          <input type="text" class="form-control form-control-sm required" name="key_edit_cadena" readonly>
                                          <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">-</button>
                                          </span>
                                          <input type="text" class="form-control form-control-sm required" name="key_edit_sitio" readonly>
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="sel_service_edit"> Tipo de servicio:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <select class="form-control form-control-sm required" id="sel_service_edit" name="sel_service_edit" style="width:100%;">
                                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                                            @forelse ($servicios as $servicio)
                                            <option value="{{ $servicio->id }}"> {{ $servicio->Nombre_servicio }} </option>
                                            @empty
                                            @endforelse
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                          <label for="sel_vertical_edit"> Vertical:
                                            <span style="color:red;">*</span>
                                          </label>
                                          <select class="form-control form-control-sm required" id="sel_vertical_edit" name="sel_vertical_edit" style="width:100%;">
                                            <option value="" selected>{{ trans('pay.select_op') }}</option>
                                            @forelse ($verticals as $data_vertical)
                                            <option value="{{ $data_vertical->id }}"> {{ $data_vertical->name }} </option>
                                            @empty
                                            @endforelse
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group mt-10">
                                            <button type="submit" class="btn btn-info btngeneraleditar"><i class="fa fa-bullseye margin-r5"></i> Guardar</button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <!-- /.tab-pane -->
                              </div>
                              <!-- /.tab-content -->
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="col-md-6">
                        <div class="row bordesito">

                            <div class="row">
                            <div class="mt-30">
                              <div class="input-group input-group-sm mb-3 mt-3 ml-5">
                                <span class="input-group-btn">
                                  <button class="btn btn-sm btn-success" type="button">Buscar</button>
                                </span>
                                <input type="text" id="searchmap" class="form-control">
                              </div>
                            </div>
                            </div>

                            <div class="col-md-11 mt-25" style="width:100%">
                                <div id="map-canvas" class="col-xs-offset-s05" style="width:100%"></div>
                            </div>
                            <div class="row">
                            <div class="col-md-6 mb-3">
                              <div class="form-group text-center ">
                                <label for="lat" class="control-label">Latitud
                                  <span style="color:red;">*</span>
                                </label>
                                <input type="text" class="form-control required" id="lat" name="lat">
                              </div>
                            </div>
                            <div class="col-md-6 mb-3">
                              <div class="form-group text-center ">
                                <label for="lng" class="control-label">Longitud:
                                  <span style="color:red;">*</span>
                                </label>
                                <input type="text" class="form-control required" id="lng" name="lng">
                              </div>
                            </div>
                            </div>

                        </div>
                      </div>
                    </div>
                <!-- </form> -->
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
  @if( auth()->user()->can('Create id ubicacion') )
  <!--<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-3-right-offset.css')}}" >
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extras-margins-padding.css')}}" > -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCD07V9hwyUjrRCXiJHo9YdftE0VJIbRP8&libraries=places"></script>

  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>

  <style>
    .nav-tabs-custom > .nav-tabs > li > a { color: #444; border-radius: 0; }
    .nav-tabs-custom > .nav-tabs > li.disabled > a { color: #777; }

    .nav-tabs-custom {
        -webkit-box-shadow: 0 0 0 rgba(0, 0, 0, 0.1) !important;
        box-shadow: 0 0 0 rgba(0, 0, 0, 0.1) !important;
    }
    .error {
        color: #f62d51;;
    }


    .col-xs-offset-s05 {
      margin-left: 4.166666665%;
    }
    #map-canvas{
     width:500px;
     height:370px;
    }
    .text-danger {
        color: #f62d51;;
    }
    .bordesito{
      border-color: rgba(120,130,140,.13);
      border: 1px solid #aaa;
    }
    .white-box {
     background:#ffffff;
     padding:25px;
     margin-bottom:10px;
     border-color: rgba(120,130,140,.13);
     border: 1px solid #aaa;
    }
    .white-box .box-title {
     margin:0px 0px 12px;
     font-weight:500;
     text-transform:uppercase;
     font-size:16px
    }
    .wizard-steps {
     display:table;
     width:100%
    }
    .wizard-steps>li {
     display:table-cell;
     padding:10px 20px;
     background:#f7fafc
    }
    .wizard-steps>li span {
     border-radius:100%;
     border:1px solid rgba(120, 130, 140, 0.13);
     width:40px;
     height:40px;
     display:inline-block;
     vertical-align:middle;
     padding-top:9px;
     margin-right:8px;
     text-align:center
    }
    .wizard-content {
     padding:5px;
     border-color:rgba(120, 130, 140, 0.13);
     margin-bottom:10px
    }
    .wizard-steps>li.current,.wizard-steps>li.done {
     background:#2cabe3;
     color:#ffffff
    }
    .wizard-steps>li.current span,.wizard-steps>li.done span {
     border-color:#ffffff;
     color:#ffffff
    }
    .wizard-steps>li.current h4,.wizard-steps>li.done h4 {
     color:#ffffff
    }
    .wizard-steps>li.done {
     background:#53e69d
    }
    .wizard-steps>li.error {
     background:#ff7676
    }
    .wiz-aco .pager {
     margin:0px
    }
    .wizard-content .wizard>.actions{
      margin-top: 10px
    }
  </style>
  <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
  <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>

  <script>
    var _token = $('input[name="_token"]').val();
    var map = new google.maps.Map(document.getElementById('map-canvas'),{
    center:{
     lat:21.1484265,
     lng:-86.8362061
     },
     zoom:15
    });

    var marker= new google.maps.Marker({
     position:{
       lat:21.1484265,
       lng:-86.8362061
     },
     map:map,
     draggable:true
    });
    var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));
    google.maps.event.addListener(searchBox,'places_changed',function(){
    var places = searchBox.getPlaces();
    var bounds = new google.maps.LatLngBounds();
    var i , place;
    for(i=0;place=places[i];i++){
     bounds.extend(place.geometry.location);
     marker.setPosition(place.geometry.location);
    }
    map.fitBounds(bounds);
    map.setZoom(17);
    });
    google.maps.event.addListener(marker,'position_changed',function(){
     var lat = marker.getPosition().lat();
     var lng = marker.getPosition().lng();
     $('#lat').val(lat);
     $('#lng').val(lng);
    });

    $('#lat').on('blur', function() {
      var _token = $('input[name="_token"]').val();
      var valor = this.value,
          logitud_rec = $('input[name="lng"]').val();
          if (logitud_rec == '') {  logitud_rec = 0;  }

      var latlng = new google.maps.LatLng(valor, logitud_rec);
      marker.setPosition(latlng);
      map.setCenter(latlng);
    });

    $('#lng').on('blur', function() {
      var _token = $('input[name="_token"]').val();
      var valor = this.value,
          latitud_rec = $('input[name="lat"]').val();

          if (latitud_rec == '') {
            latitud_rec = 0;
          }

      var latlng = new google.maps.LatLng(latitud_rec, valor);
      marker.setPosition(latlng);
      map.setCenter(latlng);
    });

    $('#sel_master_grupo').on('change', function(e){
      var group = $(this).val();
      if (group != '') {
        $.ajax({
          type: "POST",
          url: "/find_new_idubication",
          data: { valor : group , _token : _token },
          success: function (data){
            datax = JSON.parse(data);
            $('input[name="id_generate"]').val(datax[0].key);
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
      }
      else {
         $('input[name="id_generate"]').val('');
      }
    });

    $('#sel_edit_cadena').on('change', function(e){
      $.ajax({
        type: "POST",
        url: "/idproy_search_hotel_by_cadena",
        data: { valor : this.value , _token : _token },
        success: function (data){
          count_data = data.length;
          $('[name="sel_edit_sitio"] option[value!=""]').remove();
          if (count_data > 0) {
            $.each(JSON.parse(data),function(index, objdata){
              $('[name="sel_edit_sitio"]').append('<option value="'+objdata.id+'">'+ objdata.sitio +'</option>');
            });
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    });

    $('#sel_edit_sitio').on('change', function(e){
      var group = $(this).val();
      $.ajax({
        type: "POST",
        url: "/search_info_site_idubicacion",
        data: { valor : group , _token : _token },
        success: function (data){
          count_data = data.length;
          if (count_data > 2) {
            datax = JSON.parse(data);
            $('[name="edit_hotel_name"]').val(datax[0].sitio);
            $('[name="edit_hotel_address"]').val(datax[0].Direccion);
            $('[name="edit_hotel_telephone"]').val(datax[0].Telefono);
            $('[name="sel_service_edit"]').val(datax[0].servicios_id);
            $('[name="sel_vertical_edit"]').val(datax[0].vertical_id);

            $('[name="key_edit_cadena"]').val(datax[0].key_cadena);
            $('[name="key_edit_sitio"]').val(datax[0].key_sitio);

            $('[name="edit_hotel_street"]').val(datax[0].calle);
            $('[name="edit_hotel_noext"]').val(datax[0].num_ext);
            $('[name="edit_hotel_noint"]').val(datax[0].num_int);
            $('[name="edit_hotel_cp"]').val(datax[0].codigopostal);

            $('input[name="edit_hotel_name"]').prop("readonly", false);
            $('input[name="edit_hotel_address"]').prop("readonly", false);
            $('input[name="edit_hotel_telephone"]').prop("readonly", false);
            $('input[name="key_edit_cadena"]').prop("readonly", false);
            $('input[name="key_edit_sitio"]').prop("readonly", false);

            $('input[name="edit_hotel_street"]').prop("readonly", false);
            $('input[name="edit_hotel_noext"]').prop("readonly", false);
            $('input[name="edit_hotel_noint"]').prop("readonly", false);
            $('input[name="edit_hotel_cp"]').prop("readonly", false);

            var rec_latitud= datax[0].Latitude;
            var rec_longitud= datax[0].Longitude;

            if (rec_latitud === null || rec_latitud === '' || rec_latitud === 'NULL') {
              var rec_latitud= 0;
            }
            if (rec_longitud === null || rec_longitud === '' || rec_longitud === 'NULL') {
              var rec_longitud= 0;
            }
            $('[name="lat"]').val(rec_latitud);
            $('[name="lng"]').val(rec_longitud);


            var latlng2 = new google.maps.LatLng(rec_latitud, rec_longitud);
            marker.setPosition(latlng2);
            map.setCenter(latlng2);
          }
          else {
            $('input[name="edit_hotel_name"]').val('');
            $('input[name="edit_hotel_address"]').val('');
            $('input[name="edit_hotel_telephone"]').val('');
            $('input[name="key_edit_cadena"]').val('');
            $('input[name="key_edit_sitio"]').val('');

            $('[name="edit_hotel_street"]').val('');
            $('[name="edit_hotel_noext"]').val('');
            $('[name="edit_hotel_noint"]').val('');
            $('[name="edit_hotel_cp"]').val('');

            $('input[name="edit_hotel_name"]').prop("readonly", true);
            $('input[name="edit_hotel_address"]').prop("readonly", true);
            $('input[name="edit_hotel_telephone"]').prop("readonly", true);
            $('input[name="key_edit_cadena"]').prop("readonly", true);
            $('input[name="key_edit_sitio"]').prop("readonly", true);

            $('input[name="edit_hotel_street"]').prop("readonly", true);
            $('input[name="edit_hotel_noext"]').prop("readonly", true);
            $('input[name="edit_hotel_noint"]').prop("readonly", true);
            $('input[name="edit_hotel_cp"]').prop("readonly", true);

            var latlng2 = new google.maps.LatLng(21.1484265,-86.8362061);
            marker.setPosition(latlng2);
            map.setCenter(latlng2);

            $('[name="lat"]').val('');
            $('[name="lng"]').val('');
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href"); // activated tab

      if (target == '#tab_1_1') {
        $('.tab_one').find('input:text').val('');
        $('.tab_one').find('input:text').prop("readonly", false);
        $('[name="sel_master_grupo"]').val('').trigger('change');
        $('input[name="id_generate"]').prop("readonly", true);

        $("#validation_crear")[0].reset();
        var validator = $( "#validation_crear" ).validate();
        validator.resetForm();
      }
      if (target == '#tab_2_2') {
        $('.tab_two').find('input:text').val('');
        $('.tab_two').find('input:text').prop("readonly", true);
        $('[name="sel_edit_cadena"]').val('').trigger('change');
        $('[name="sel_edit_sitio"] option[value!=""]').remove();

        $("#validation_edit")[0].reset();
        var validatore = $( "#validation_edit" ).validate();
        validatore.resetForm();
      }

      var latlng2 = new google.maps.LatLng(21.1484265,-86.8362061);
      marker.setPosition(latlng2);
      map.setCenter(latlng2);

      $('#searchmap').val('');
      $('[name="lat"]').val('');
      $('[name="lng"]').val('');
    });
    $("#validation_crear").validate({
        rules: {
          hotel_telephone: {
            required: true,
            number: true,
            minlength: 7,
            maxlength: 10
          },
        },
        messages: {

        },
        debug: true,
        errorElement: "label",
        submitHandler: function(form){
          var rec_a = $('[name="lat"]').val();
          var rec_b = $('[name="lng"]').val();
          if (rec_a =='' || rec_b =='' ) {
            swal("Operación abortada", "Ningúna operación afectuada, Ingrese la latitud y longitud :)", "error");
          }
          else{
            swal({
              title: "Estás seguro?",
              text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              closeOnConfirm: false,
              closeOnCancel: false,
              showLoaderOnConfirm: true,
            },
            function(isConfirm) {
              if (isConfirm) {
                // The AJAX
                var form = $('#validation_crear')[0];
                var formData = new FormData(form);
                formData.append('latitud', rec_a);
                formData.append('longitud', rec_b);

                $.ajax({
                  type: 'POST',
                  url: "/cont_create_newidubic",
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function (data){
                    datax = data;
                    if (datax != '0') {
                      swal("Operación Completada!", ":)", "success");
                    }
                    else {
                      swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
                    }
                    // This is a callback that runs if the submission was a success.
                    // Clear the form

                    var latlng2 = new google.maps.LatLng(21.1484265,-86.8362061);
                    marker.setPosition(latlng2);
                    map.setCenter(latlng2);

                    $('[name="lat"]').val('');
                    $('[name="lng"]').val('');

                    $("#validation_crear")[0].reset();
                    var validator = $( "#validation_crear" ).validate();
                    validator.resetForm();
                  },
                  error: function (data) {
                    swal("Operación abortada", "Ningúna operación afectuada :)", "error");
                  }
                });
              }
              else {
                swal("Operación abortada", "Ningúna operación afectuada :)", "error");
              }
            });
          }


        }
    });


    $("#validation_edit").validate({
        rules: {

        },
        messages: {

        },
        debug: true,
        errorElement: "label",
        submitHandler: function(form){
          var rec_a = $('[name="lat"]').val();
          var rec_b = $('[name="lng"]').val();
          if (rec_a =='' || rec_b =='' ) {
            swal("Operación abortada", "Ningúna operación afectuada, Ingrese la latitud y longitud :)", "error");
          }
          else{
            swal({
              title: "Estás seguro?",
              text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              closeOnConfirm: false,
              closeOnCancel: false,
              showLoaderOnConfirm: true,
            },
            function(isConfirm) {
              if (isConfirm) {
                // The AJAX
                var form = $('#validation_edit')[0];
                var formData = new FormData(form);
                formData.append('latitud', rec_a);
                formData.append('longitud', rec_b);
                $.ajax({
                  type: 'POST',
                  url: "/cont_edit_idubic",
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function (data){
                    datax = data;
                    if (datax != '0') {
                      swal("Operación Completada!", ":)", "success");
                    }
                    else {
                      swal("Operación abortada", "Error al actualizar intente otra vez :(", "error");
                    }
                    // This is a callback that runs if the submission was a success.
                    // Clear the form
                    var latlng2 = new google.maps.LatLng(21.1484265,-86.8362061);
                    marker.setPosition(latlng2);
                    map.setCenter(latlng2);

                    $('[name="lat"]').val('');
                    $('[name="lng"]').val('');

                    $('[name="sel_edit_sitio"] option[value!=""]').remove();

                    $("#validation_edit")[0].reset();
                    var validator = $( "#validation_edit" ).validate();
                    validator.resetForm();
                  },
                  error: function (data) {
                    swal("Operación abortada", "Ningúna operación afectuada :)", "error");
                  }
                });
              }
              else {
                swal("Operación abortada", "Ningúna operación afectuada :)", "error");
              }
            });
          }


        }
    });


  </script>

  @else

  @endif
@endpush
