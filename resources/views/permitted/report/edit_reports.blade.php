@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View individual general report') )
    {{ trans('message.breadcrumb_edit_capture_indiv') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View individual general report') )
    {{ trans('message.breadcrumb_edit_capture_indiv') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View individual general report') )
  <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-12 col-md-6 col-lg-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">{{ trans('message.clienttype')}}</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                <!-- <span class="label label-primary">Label</span> -->
              </div>
              <!-------->

            <!-- /.card-header -->
              <div class="row">
                <div class="col-sm-12">
                  <form id="form_img_upload_type" name="form_img_upload_type" class="form-horizontal" enctype="multipart/form-data"  method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <div class=""style="padding-top: 10px;">
                        <!--Div vacio para hacer espacio entre -->
                      </div>
                      <label for="select_one_type" class="col-md-2 control-label">{{ trans('message.hotel') }}</label>
                      <div class="col-md-10 selectContainer">
                        <select id="select_one_type" name="select_one_type" class="form-control select2">
                          <option value="" selected> Elija </option>
                          @forelse ($hotels as $data_hotel)
                            <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>
                    <div class=""style="padding-top: 30px;">
                      <!--Div vacio para hacer espacio entre -->
                    </div>
                    <div class="form-group" >
                      <label class="col-md-2 control-label" for="date_type_device">{{ trans('message.date')}} </label>
                      <div class="col-md-10" >
                        <input id="date_type_device" name="date_type_device"  type="text"  maxlength="7"
                          class="form-control input-md">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-12 control-label" for="dropzone_client">{{ trans('message.importarimg')}}  </label>
                      <div class="col-md-12">
                        <div id="dropzone_client" name="dropzone_client" class="dropzone"></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <a id="cargarimgclient" class="btn btn-navy" type="submit" style=" background-color: #002B56; color:white;"><i class="far fa-bookmark" ></i> {{ trans('message.capturar')}}</a>
                        <a id="generateimgtypeClear" class="btn btn-danger" style="color:white;"><i class="fa fa-times"></i> {{ trans('message.cancelar')}}</a>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

          </div>
        </div>

        <div class="col-xs-12 col-md-12 col-md-6 col-lg-6 grid-margin stretch-card">
          <div class="card">
              <div class="card-body">
              <h3 class="card-title">{{ trans('message.contentimgband')}}</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                <!-- <span class="label label-primary">Label</span> -->
              </div>
              <!-- /.box-tools -->

            <!-- /.box-header -->
              <div class="row">
                <div class="col-sm-12">
                  <form id="form_img_band_upload" name="form_img_band_upload" class="form-horizontal" enctype="multipart/form-data"  method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <div class=""style="padding-top: 10px;">
                        <!--Div vacio para hacer espacio entre -->
                      </div>
                      <label for="select_one_band" class="col-md-2 control-label">{{ trans('message.hotel') }}</label>
                      <div class="col-md-10 selectContainer">
                        <select id="select_one_band" name="select_one_band" class="form-control select2">
                          <option value="" selected> Elija </option>
                          @forelse ($hotels as $data_hotel)
                            <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>
                    <div class=""style="padding-top: 30px;">
                      <!--Div vacio para hacer espacio entre -->
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="date_type_banda">{{ trans('message.date')}} </label>
                      <div class="col-md-10">
                        <input id="date_type_banda" name="date_type_banda"  type="text"  maxlength="7"
                          class="form-control input-md">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-12 control-label" for="dropzone_band">{{ trans('message.importarimg')}}  </label>
                      <div class="col-md-12">
                        <div id="dropzone_band" name="dropzone_band" class="dropzone"></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <a id="cargarimgband" class="btn btn-navy" type="submit" style="color:white;" ><i class="far fa-bookmark"></i> {{ trans('message.capturar')}}</a>
                        <a id="clearimgband" class="btn btn-danger" style="color:white;"><i class="fa fa-times"></i> {{ trans('message.cancelar')}}</a>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

          </div>
        </div>

        <div class="col-xs-12 col-md-12 col-md-6 col-lg-6 grid-margin stretch-card">
          <div class="card">
              <div class="card-body">
              <h3 class="card-title">{{ trans('message.contentgbtrans')}}</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                <!-- <span class="label label-primary">Label</span> -->
              </div>
              <!-- /.box-tools -->

            <!-- /.box-header -->
              <div class="row">
                <div class="col-sm-12">
                  <form id="form_gb" name="form_gb" class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="date_trans_gb">{{ trans('message.date')}} <span style="color: red;">*</span></label>
                      <div class="col-md-10">
                        <input id="date_trans_gb" name="date_trans_gb"  type="text"  maxlength="10" placeholder="{{ trans('message.maxcardiez')}}"
                          class="form-control input-md">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="select_onet" class="col-md-2 control-label">{{ trans('message.hotel') }} <span style="color: red;">*</span></label>
                      <div class="col-md-10 selectContainer">
                        <select id="select_onet" name="select_onet" class="form-control select2">
                          <option value="" selected> Elija </option>
                          @forelse ($hotels as $data_hotel)
                            <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="select_two_zd" class="col-md-2 control-label">{{ trans('message.zonedirect') }} <span style="color: red;">*</span></label>
                      <div class="col-md-10 selectContainer">
                        <select id="select_two_zd" name="select_two_zd" class="form-control select2">
                          <!-- <option value="" selected> Elija </option> -->
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-5 control-label" for="data_trans_gb">{{ trans('message.transmitidosgb')}} </label>
                      <div class="col-md-7">
                        <input id="data_trans_gb" name="data_trans_gb"  type="text"  maxlength="20" placeholder="{{ trans('message.maxcarveint')}}"
                          class="form-control input-md" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-5 control-label" for="newdata_trans_gb">{{ trans('message.newtransmitidosgb')}} <span style="color: red;">*</span></label>
                      <div class="col-md-7">
                        <input id="newdata_trans_gb" name="newdata_trans_gb"  type="text"  maxlength="20" placeholder="{{ trans('message.maxcarveint')}}"
                          class="form-control input-md">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <a id="generateGbInfo" class="btn btn-navy" style="color:white;"><i class="far fa-bookmark"></i> {{ trans('message.capturar')}}</a>
                        <a id="generateGbClear" class="btn btn-danger" style="color:white;"><i class="fa fa-times"></i> {{ trans('message.cancelar')}}</a>
                      </div>
                    </div>


                  </form>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

          </div>
        </div>

        <div class="col-xs-12 col-md-12 col-md-6 col-lg-6 grid-margin stretch-card">
          <div class="card">
              <div class="card-body">
              <h3 class="card-title">{{ trans('message.contentnumberdevice')}}</h3>
              <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                <!-- <span class="label label-primary">Label</span> -->
              </div>
              <!-- /.card-tools -->

            <!-- /.card-header -->

              <div class="row">
                <div class="col-sm-12">
                  <form id="form_user" name="form_user" class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="date_trans_user">{{ trans('message.date')}} </label>
                      <div class="col-md-10">
                        <input id="date_trans_user" name="date_trans_user"  type="text"  maxlength="10" placeholder="{{ trans('message.maxcardiez')}}"
                          class="form-control input-md">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="select_one_device" class="col-md-2 control-label">{{ trans('message.hotel') }}</label>
                      <div class="col-md-10 selectContainer">
                        <select id="select_one_device" name="select_one_device" class="form-control select2">
                          <option value="" selected> Elija </option>
                          @forelse ($hotels as $data_hotel)
                            <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-6 control-label" for="data_trans_user">{{ trans('message.transmitidosuser')}} </label>
                      <div class="col-md-6">
                        <input id="data_trans_user" name="data_trans_user"  type="text"  maxlength="20" placeholder="{{ trans('message.maxcarveint')}}"
                          class="form-control input-md" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-6 control-label" for="newdata_trans_user">{{ trans('message.newtransmitidosuser')}} </label>
                      <div class="col-md-6">
                        <input id="newdata_trans_user" name="newdata_trans_user"  type="text"  maxlength="20" placeholder="{{ trans('message.maxcarveint')}}"
                          class="form-control input-md">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <a id="generateUserInfo" class="btn btn-navy" style="color:white;"><i class="far fa-bookmark"></i> {{ trans('message.capturar')}}</a>
                        <a id="generateUserClear" class="btn btn-danger" style="color:white;"><i class="fa fa-times"></i> {{ trans('message.cancelar')}}</a>
                      </div>
                      </br></br></br></br>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

          </div>
        </div>

        <!--CARD COMMENT-->

        <div class="col-xs-12 col-md-12 col-md-6 col-lg-6 col-md-offset-3 grid-margin stretch-card">
          <div class="card">
              <div class="card-body">
              <h3 class="card-title">{{ trans('message.contentcomment')}}</h3>
              <div class="box-tools pull-right">

              </div>
              <!-- /.card-tools -->

            <!-- /.card-header -->

              <div class="row">
                <div class="col-sm-12">
                  <form id="form_coment" name="form_user" class="form-horizontal" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="date_trans_user">{{ trans('message.date')}}</label>
                      <div class="col-md-10">
                        <input id="date_comment" name="date_comment"  type="text"
                          class="form-control input-md">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="select_one_device" class="col-md-2 control-label">{{ trans('message.hotel') }}</label>
                      <div class="col-md-10 selectContainer">
                        <select id="select_one_comment_hotel" name="select_one_comment_hotel" class="form-control select2">
                          <option value="" selected> Elija </option>
                          @forelse ($hotels as $data_hotel)
                            <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label" for="data_trans_user">{{ trans('message.commentsite')}} <span style="color: red;">*</span></label>
                      <br>
                      <div class="col-md-12">
                        <textarea maxlength="500" required="true" class="form-control" rows=6 id="comment_hotel" name="comment_hotel" placeholder="máximo 500 caracteres" type="text" name="" value=""></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-12">
                        <a id="generateCommentInfo" class="btn btn-navy" style="color:white;"><i class="far fa-bookmark"></i> {{ trans('message.capturar')}}</a>
                        <a id="generateCommentClear" class="btn btn-danger" style="color:white;"><i class="fa fa-times"></i> {{ trans('message.cancelar')}}</a>
                      </div>
                      </br></br>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

          </div>
        </div>
      </div>
    </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View individual general report') )
  <!--<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>-->
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/dropzone.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/dropzone.min.js"></script>
  <script src="{{ asset('js/admin/report/edit_reports.js')}}"></script>
  @else
  @endif
@endpush
