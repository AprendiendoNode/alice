@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View individual capture') )
    {{ trans('message.breadcrumb_capture_indiv') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View individual capture') )
    {{ trans('message.breadcrumb_capture_indiv') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View individual capture') )
    <div class="row">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Tipo de dispositivo del cliente</p>
            <form id="form_img_upload_type" name="form_img_upload_type" class="forms-sample" enctype="multipart/form-data"  method="POST">
              {{ csrf_field() }}
              <div class="form-group row">
                <label for="select_one_type" class="col-sm-3 col-form-label">Sitio<span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <select  id="select_one_type" name="select_one_type" class="form-control form-control-sm required select2">
                    <option value="">{{ trans('message.selectopt') }}</option>
                    @forelse ($hotels as $data_hotel)
                      <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="month_upload_type" class="col-sm-3 col-form-label">Fecha <span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control form-control-sm required" id="month_upload_type" name="month_upload_type" placeholder="{{ trans('message.maxcardiez')}}" maxlength="10">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-12 control-label" for="dropzone_client">{{ trans('message.importarimg')}} <span style="color: red;">*</span></label>
                <div class="col-md-12">
                  <div id="dropzone_client" name="dropzone_client" class="dropzone"></div>
                </div>
              </div>
              <div class="form-group row mt-2">
                <div class="col-sm-9">
                  <button id="cargarimgclient" name="cargarimgclient" type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  <button id="generateimgtypeClear" name="generateimgtypeClear" type="button" class="btn btn-danger reset_position_user"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Apartado subir imagen de ancho de banda (Mensual)</p>
            <form id="form_img_band_upload" name="form_img_band_upload" class="forms-sample" enctype="multipart/form-data"  method="POST">
              {{ csrf_field() }}
              <div class="form-group row">
                <label for="select_one_band" class="col-sm-3 col-form-label">Sitio<span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <select  id="select_one_band" name="select_one_band" class="form-control form-control-sm required select2">
                    <option value="">{{ trans('message.selectopt') }}</option>
                    @forelse ($hotels as $data_hotel)
                      <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="month_upload_band" class="col-sm-3 col-form-label">Fecha <span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control form-control-sm required" id="month_upload_band" name="month_upload_band" placeholder="{{ trans('message.maxcardiez')}}" maxlength="10">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-12 control-label" for="dropzone_band">{{ trans('message.importarimg')}} <span style="color: red;">*</span></label>
                <div class="col-md-12">
                  <div id="dropzone_band" name="dropzone_band" class="dropzone"></div>
                </div>
              </div>
              <div class="form-group row mt-2">
                <div class="col-sm-9">
                  <button id="cargarimgband" name="cargarimgband" type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  <button id="clearimgband" name="clearimgband" type="button" class="btn btn-danger reset_position_user"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Número de Gigabytes transmitidos en 24hrs</p>
            <form id="form_gb" name="form_gb" class="forms-sample" action="">
              {{ csrf_field() }}
              <div class="form-group row">
                <label for="select_onet" class="col-sm-3 col-form-label">{{ trans('message.hotel') }}<span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <select  id="select_onet" name="select_onet" class="form-control form-control-sm required select2">
                    <option value="">{{ trans('message.selectopt') }}</option>
                    @forelse ($hotels as $data_hotel)
                      <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="select_two_zd" class="col-sm-3 col-form-label">{{ trans('message.zonedirect') }}<span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <select  id="select_two_zd" name="select_two_zd" class="form-control form-control-sm required select2">
                    <option value="">{{ trans('message.selectopt') }}</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="month_trans_zd" class="col-sm-3 col-form-label">{{ trans('message.date')}} <span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control form-control-sm required datepickermonth" id="month_trans_zd" name="month_trans_zd" placeholder="{{ trans('message.maxcardiez')}}" maxlength="10">
                </div>
              </div>
              <div class="form-group row">
                <label for="valorgb_trans" class="col-sm-3 col-form-label">{{ trans('message.gbtrans')}} <span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <input type="number" class="form-control form-control-sm required" id="valorgb_trans" name="valorgb_trans" placeholder="Máximo 5 digitos." maxlength="5" title="{{ trans('message.gbtrans')}}">
                </div>
              </div>
              <div class="form-group row mt-2">
                <div class="col-sm-9">
                  <button id="generateGbInfo" name="generateGbInfo"  type="button" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  <button id="generateGbClear"  name="generateGbClear"  type="button" class="btn btn-danger"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Número de dispositivos cliente autorizados</p>
            <form id="form_device" name="form_device" class="forms-sample" action="">
              {{ csrf_field() }}
              <div class="form-group row">
                <label for="select_one_device" class="col-sm-3 col-form-label">{{ trans('message.hotel') }}<span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <select  id="select_one_device" name="select_one_device" class="form-control form-control-sm required select2">
                    <option value="">{{ trans('message.selectopt') }}</option>
                    @forelse ($hotels as $data_hotel)
                      <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="month_device" class="col-sm-3 col-form-label">{{ trans('message.date')}} <span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control form-control-sm required datepickermonth" id="month_device" name="month_device" placeholder="{{ trans('message.maxcardiez')}}" maxlength="10">
                </div>
              </div>
              <div class="form-group row">
                <label for="valor_users" class="col-sm-3 col-form-label">{{ trans('message.usersauth')}} <span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <input type="number" class="form-control form-control-sm required" id="valor_users" name="valor_users" placeholder="Máximo 5 digitos." maxlength="5" title="{{ trans('message.usersauth')}}">
                </div>
              </div>
              <div class="form-group row mt-2">
                <div class="col-sm-9">
                  <button id="generateUserInfo" name="generateUserInfo"  type="button" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  <button id="generateUserClear"  name="generateUserClear"  type="button" class="btn btn-danger"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Añadir comentarios.</p>
            <form id="form_comments" name="form_comments" class="forms-sample" action="">
              {{ csrf_field() }}
              <div class="form-group row">
                <label for="select_one_comments" class="col-sm-3 col-form-label">{{ trans('message.hotel') }}<span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <select  id="select_one_comments" name="select_one_comments" class="form-control form-control-sm required select2">
                    <option value="">{{ trans('message.selectopt') }}</option>
                    @forelse ($hotels as $data_hotel)
                      <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="month_comments" class="col-sm-3 col-form-label">{{ trans('message.date')}} <span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control form-control-sm required" id="month_comments" name="month_comments" placeholder="{{ trans('message.maxcardiez')}}" maxlength="10">
                </div>
              </div>
              <div class="form-group row">
                <label for="report_comment" class="col-sm-12 col-form-label mb-0">Comentario:</label>
                <div class="col-sm-12">
                  <textarea class="form-control" rows="4" id="report_comment" name="report_comment" placeholder="..." style="resize: vertical;"></textarea>
                </div>
              </div>

              <div class="form-group row mt-2">
                <div class="col-sm-9">
                  <button id="generateComment" name="generateComment"  type="button" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  <button id="generateCommentClear"  name="generateCommentClear"  type="button" class="btn btn-danger"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Top 5 de Ap‘s mas usadas</p>
            <form id="form_aps" name="form_aps" class="forms-sample" action="">
              {{ csrf_field() }}
              <div class="form-group row">
                <label for="select_three" class="col-sm-3 col-form-label">{{ trans('message.hotel') }}<span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <select  id="select_three" name="select_three" class="form-control form-control-sm required select2">
                    <option value="">{{ trans('message.selectopt') }}</option>
                    @forelse ($hotels as $data_hotel)
                      <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="datepickermonth" class="col-sm-3 col-form-label">{{ trans('message.date')}} <span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control form-control-sm required datepickermonth" id="fecha_aps" name="fecha_aps" placeholder="{{ trans('message.maxcardiez')}}" maxlength="10">
                </div>
              </div>

              <ul class="list-group">
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <span class="badge badge-pill badge-primary">TOP 1</span>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="mac1" name="mac1" type="text" placeholder="{{ trans('message.ingmac')}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="modelo1" name="modelo1" type="text" placeholder="{{ trans('message.ingmod')}}"  class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="cliente1" name="cliente1" type="number" placeholder="5 digitos." maxlength="5" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <span class="badge badge-pill badge-primary">TOP 2</span>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="mac2" name="mac2" type="text" placeholder="{{ trans('message.ingmac')}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="modelo2" name="modelo2" type="text" placeholder="{{ trans('message.ingmod')}}"  class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="cliente2" name="cliente2" type="number" placeholder="5 digitos." maxlength="5" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <span class="badge badge-pill badge-primary">TOP 3</span>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="mac3" name="mac3" type="text" placeholder="{{ trans('message.ingmac')}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="modelo3" name="modelo3" type="text" placeholder="{{ trans('message.ingmod')}}"  class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="cliente3" name="cliente3" type="number" placeholder="5 digitos." maxlength="5" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <span class="badge badge-pill badge-primary">TOP 4</span>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="mac4" name="mac4" type="text" placeholder="{{ trans('message.ingmac')}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="modelo4" name="modelo4" type="text" placeholder="{{ trans('message.ingmod')}}"  class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="cliente4" name="cliente4" type="number" placeholder="5 digitos." maxlength="5" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <span class="badge badge-pill badge-primary">TOP 5</span>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="mac5" name="mac5" type="text" placeholder="{{ trans('message.ingmac')}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="modelo5" name="modelo5" type="text" placeholder="{{ trans('message.ingmod')}}"  class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="cliente5" name="cliente5" type="number" placeholder="5 digitos." maxlength="5" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <button id="generateapsInfo" name="generateapsInfo"  type="button" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.capturar') }}</button>
                      <button id="generateapsClear"  name="generateapsClear"  type="button" class="btn btn-danger"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }}</button>
                    </div>
                  </div>
                </li>
              </ul>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Top 5 de wlan‘s mas usadas</p>
            <form id="form_wlan" name="form_wlan" class="forms-sample" action="">
              {{ csrf_field() }}
              <div class="form-group row">
                <label for="select_four" class="col-sm-3 col-form-label">{{ trans('message.hotel') }}<span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <select  id="select_four" name="select_four" class="form-control form-control-sm required select2">
                    <option value="">{{ trans('message.selectopt') }}</option>
                    @forelse ($hotels as $data_hotel)
                      <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="fecha_nwlan" class="col-sm-3 col-form-label">{{ trans('message.date')}} <span style="color: red;">*</span></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control form-control-sm required datepickermonth" id="fecha_nwlan" name="fecha_nwlan" placeholder="{{ trans('message.maxcardiez')}}" maxlength="10">
                </div>
              </div>

              <ul class="list-group">
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <span class="badge badge-pill badge-primary">TOP 1</span>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="nombrew1" name="nombrew1" placeholder="{{ trans('message.ingnombw')}}" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-danger" id="inputGroup-sizing-sm">*</span>
                        </div>
                        <input id="clientew1" name="clientew1" placeholder="{{ trans('message.ingnumcw')}}" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <span class="badge badge-pill badge-primary">TOP 2</span>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-dark" id="inputGroup-sizing-sm">-</span>
                        </div>
                        <input id="nombrew2" name="nombrew2" placeholder="{{ trans('message.ingnombw')}}" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-dark" id="inputGroup-sizing-sm">-</span>
                        </div>
                        <input id="clientew2" name="clientew2" placeholder="{{ trans('message.ingnumcw')}}" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <span class="badge badge-pill badge-primary">TOP 3</span>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-dark" id="inputGroup-sizing-sm">-</span>
                        </div>
                        <input id="nombrew3" name="nombrew3" placeholder="{{ trans('message.ingnombw')}}" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-dark" id="inputGroup-sizing-sm">-</span>
                        </div>
                        <input id="clientew3" name="clientew3" placeholder="{{ trans('message.ingnumcw')}}" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <span class="badge badge-pill badge-primary">TOP 4</span>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-dark" id="inputGroup-sizing-sm">-</span>
                        </div>
                        <input id="nombrew4" name="nombrew4" placeholder="{{ trans('message.ingnombw')}}" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-dark" id="inputGroup-sizing-sm">-</span>
                        </div>
                        <input id="clientew4" name="clientew4" placeholder="{{ trans('message.ingnumcw')}}" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <span class="badge badge-pill badge-primary">TOP 5</span>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-dark" id="inputGroup-sizing-sm">-</span>
                        </div>
                        <input id="nombrew5" name="nombrew5" placeholder="{{ trans('message.ingnombw')}}" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white text-dark" id="inputGroup-sizing-sm">-</span>
                        </div>
                        <input id="clientew5" name="clientew5" placeholder="{{ trans('message.ingnumcw')}}" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                    </div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-12">
                      <button id="generatewlanInfo" name="generatewlanInfo"  type="button" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.capturar') }}</button>
                      <button id="generatewlanClear"  name="generatewlanClear"  type="button" class="btn btn-danger"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }}</button>
                    </div>
                  </div>
                </li>
              </ul>
              <div class="card-footer">
                * {{ trans('message.meansrequired')}}.
                - {{ trans('message.meansnotrequired')}}.
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View individual capture') )
    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/dropzone.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/dropzone.min.js"></script>

    <script src="{{ asset('js/admin/report/individual.js')}}"></script>
    <style media="screen">
    .select2-selection__rendered {
      line-height: 44px !important;
      padding-left: 20px !important;
    }
    .select2-selection {
      height: 42px !important;
    }
    .select2-selection__arrow {
      height: 36px !important;
    }
    .select2 {
      width:100%!important;
    }
    .input-group-text {
      line-height: 0!important;
    }
    </style>

  @else
  @endif
@endpush
