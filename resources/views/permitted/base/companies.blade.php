@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.companies') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.companies') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('content')
  {{-- @if( auth()->user()->can('View cover') ) --}}

  <div class="col-md-12 col-xl-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body dashboard-tabs p-0">
        <ul class="nav nav-tabs px-4" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><i class="fas fa-search"></i> General</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false"><i class="fas fa-address-card"></i> Dirección</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="certificate-tab" data-toggle="tab" href="#certificate" role="tab" aria-controls="certificate" aria-selected="false"><i class="fas fa-key"></i> Certificado de sello digital</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="accounts-tab" data-toggle="tab" href="#accounts" role="tab" aria-controls="accounts" aria-selected="false"><i class="fas fa-money-check-alt"></i> Cuentas bancarias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="setting-tab" data-toggle="tab" href="#setting" role="tab" aria-controls="setting" aria-selected="false"><i class="fas fa-tools"></i> Configuración</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="media">
              <div class="media-body">
                <!-------------------------------------------------------------------------------->
                <div class="row">
                  <!-------------------------------------------------------------------------------->
                  <div id="ads" class="col-md-6">
                    <div class="card rounded">
                      <div class="card-image">
                        <span class="card-notify-badge">Preview</span>
                        <img id="img_preview" name="img_preview" src="{{ asset('img/company/Default.svg') }}" alt="Alternate Text" class="img-responsive mx-auto d-block"/>
                      </div>
                      <div class="mt-3">
                        <div class="form-group">
                          <div id="cont_file" class="">
                            <div class="input-group">
                              <label class="input-group-btn">
                                <span class="btn btn-primary">
                                  Imagen <input id="fileInput" name="fileInput" type="file" style="display: none;" class="required">
                                </span>
                              </label>
                              <input type="text" class="form-control" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label for="inputCreatName" class="col-sm-3 col-form-label">Nombre <span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="Nombre de la empresa" maxlength="60">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputCreatRFC" class="col-sm-3 col-form-label">RFC <span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm required" id="inputCreatRFC" name="inputCreatRFC" placeholder="RFC" maxlength="10">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputCreatEmail" class="col-sm-3 col-form-label">Correo electrónico<span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="email" class="form-control form-control-sm required" id="inputCreatEmail" name="inputCreatEmail" placeholder="Correo electrónico" maxlength="100">
                      </div>
                    </div>
                  </div>
                  <!-------------------------------------------------------------------------------->
                  <div class="col-md-12">
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Telefono:<span style="color: red;">*</span></label>
                          <input maxlength="12" type="text" class="form-control required onlynumber" id="inputCreatPhone" name="inputCreatPhone" placeholder="Ingrese el núm. telefono">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Telefono movil:<span style="color: red;">*</span></label>
                          <input maxlength="12" type="text" class="form-control required onlynumber" id="inputCreatMobile" name="inputCreatMobile" placeholder="Ingrese el núm. telefono movil">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="select_seven" class="col-md-12 col-form-label ml-0">Régimen fiscal<span style="color: red;">*</span></label>
                          <div class="col-md-12 ml-0">
                            <select  id="select_seven" name="select_seven" class="form-control form-control-sm required"  style="width: 100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row mt-3">
                          <label for="status" class="col-md-12 control-label">Estatus</label>
                          <div class="col-md-12 mb-3">
                            <input id="status" name="status" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="datainfo">Información adicional</label>
                          <textarea class="form-control" id="datainfo" name="datainfo" rows="4"></textarea>
                        </div>
                      </div>

                    </div>
                  </div>
                  <!-------------------------------------------------------------------------------->
                </div>
                <!-------------------------------------------------------------------------------->
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
            <div class="media">
              <div class="media-body">
                <!-------------------------------------------------------------------------------->
                <div class="row">
                  <div class="col-md-12">
                    <!-------------------------------------------------------------------------------->
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Direccion:<span style="color: red;">*</span></label>
                          <input maxlength="100" type="text" class="form-control required" id="inputCreatAddress_1" name="inputCreatAddress_1" placeholder="Direccion">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Num. Ext:</label>
                          <input type="text" class="form-control" id="inputCreatAddress_2" name="inputCreatAddress_2" placeholder="" maxlength="50">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Num Int.</label>
                          <input type="text" class="form-control" id="inputCreatAddress_3" name="inputCreatAddress_3" placeholder="" maxlength="50">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Colonia:</label>
                          <input type="text" class="form-control" id="inputCreatAddress_4" name="inputCreatAddress_4" placeholder="" maxlength="100">
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------------->
                  </div>
                </div>
                <!-------------------------------------------------------------------------------->
                <div class="row mt-3">
                  <div class="col-md-12">
                    <!-------------------------------------------------------------------------------->
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Localidad:<span style="color: red;">*</span></label>
                          <input type="text" class="form-control" id="inputCreatAddress_5" name="inputCreatAddress_5" placeholder="" maxlength="50">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Referencia:<span style="color: red;">*</span></label>
                          <input type="text" class="form-control" id="inputCreatAddress_6" name="inputCreatAddress_6" placeholder="" maxlength="50">
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------------->
                  </div>
                </div>
                <!-------------------------------------------------------------------------------->
                <div class="row mt-3">
                  <div class="col-md-12">
                    <!-------------------------------------------------------------------------------->
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="select_six" class="control-label">Paises:<span style="color: red;">*</span></label>
                            <select id="select_six" name="select_six" class="form-control required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="select_seven" class="control-label">Estados:<span style="color: red;">*</span></label>
                            <select id="select_seven" name="select_seven" class="form-control required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="select_eight" class="control-label">Ciudades:<span style="color: red;">*</span></label>
                            <select id="select_eight" name="select_eight" class="form-control required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                            </select>
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------------->
                  </div>
                </div>
                <!-------------------------------------------------------------------------------->
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="certificate" role="tabpanel" aria-labelledby="certificate-tab">
            <div class="media">
              <div class="media-body">
                <!-------------------------------------------------------------------------------->
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group row">
                      <label for="select_six" class="col-sm-3 col-form-label">Certificado (.cer)<span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="btn btn-danger custom-file-input" id="file01">
                                <label class="custom-file-label" for="file01">Choose file</label>
                            </div>
                            <div class="input-group-append">
                              <button class="btn btn-danger test_btm" type="button">Eliminar</button>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="select_six" class="col-sm-3 col-form-label">Llave privada (.key)<span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="btn btn-danger custom-file-input" id="file02">
                                <label class="custom-file-label" for="file02">Choose file</label>
                            </div>
                            <div class="input-group-append">
                              <button class="btn btn-danger test_btm" type="button">Eliminar</button>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputCreatKey" class="col-sm-3 col-form-label">Contraseña de llave privada <span style="color: red;">*</span></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm required" id="inputCreatKey" name="inputCreatKey" placeholder="Contraseña" maxlength="60">
                      </div>
                    </div>

                  </div>
                </div>
                <!-------------------------------------------------------------------------------->
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="accounts" role="tabpanel" aria-labelledby="accounts-tab">
            <div class="media">
              <div class="media-body">
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="setting-tab">
            <div class="media">
              <div class="media-body">
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted">
          <button class="btn btn-danger mt-2 mt-xl-0">Actualizar</button>
        </div>
      </div>
    </div>
  </div>
  {{-- @else --}}
  {{-- @endif --}}
@endsection

@push('scripts')
    {{-- @if( auth()->user()->can('View cover') ) --}}
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <script src="{{ asset('js/admin/base/document_types.js')}}"></script>
    <script type="text/javascript">
      $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });
    </script>

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
      .toggle.btn {
        min-width: 5rem !important;
      }
      #img_preview {
        margin-top: 20px;
        height: 30%;
        width: 30%;
      }
      #ads {
          margin: 20px 0 0 0;
      }
      #ads .card-notify-badge {
          position: absolute;
          left: 0px;
          top: -10px;
          background: #f2d900;
          text-align: center;
          border-radius: 30px 30px 30px 30px;
          color: #000;
          padding: 5px 20px;
          font-size: 14px;

      }
      #ads .card-detail-badge {
          background: #f2d900;
          text-align: center;
          border-radius: 30px 30px 30px 30px;
          color: #000;
          padding: 5px 10px;
          font-size: 14px;
      }
      .tab-content {
      	border: 1px solid $border-color;
      	border-top: 0;
      	padding: 2rem 1.5rem;
      	text-align: justify;
      	&.tab-content-vertical {
      		border-top: 1px solid $border-color;
      	}
      	&.tab-content-vertical-custom {
      		border: 0;
      		padding-top: 0;
      	}
      	&.tab-content-custom-pill {
      		border: 0;
      		padding-left: 0;
      	}
      }
      .test_btm {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        padding-top: 1;
        display: block;
        height: calc(1.8em + 0.75rem);
        padding: 0.5rem 0.75rem;
        line-height: 1.5;
      }
      /**/
      .custom-file {
      	position: relative;
      	display: inline-block;
      	width: 100%;
        height: calc(1.8em + 0.75rem) !important;
      	margin-bottom: 0
      }

      .custom-file-input {
      	position: relative;
      	z-index: 3;
      	width: 100%;
        height: calc(1.8em + 0.75rem) !important;
      	margin: 0;
      	opacity: 0
      }

      .custom-file-input:focus~.custom-file-control {
      	border-color: #007bff !important;
      	box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25)
      }

      .custom-file-input:focus~.custom-file-control::before {
      	border-color: #007bff !important;
      }

      .custom-file-label {
      	position: absolute;
      	top: 0;
      	right: 0;
      	left: 0;
      	z-index: 1;
      	height: calc(2.25rem + 2px);
      	padding: .375rem .75rem;
      	line-height: 1.5;
      	color: #495057;
      	background-color: #fff;
      	border: 1px solid #ced4da;
      	border-radius: .25rem
      }

      .custom-file-label::after {
      	position: absolute;
      	top: 0;
      	right: 0;
      	bottom: 0;
      	z-index: 3;
      	display: block;
      	height: calc(calc(2.25rem + 2px) - 1px * 2);
      	padding: .375rem .75rem;
      	line-height: 1.5;
      	color: #fff;
      	content: "Subir";
      	background-color: #007bff !important;
      	border-left: 1px solid #007bff !important;
      	border-radius: 0 .25rem .25rem 0
      }
      /**/
      .custom-file-input.is-valid~.custom-file-label,
      .was-validated .custom-file-input:valid~.custom-file-label {
      	border-color: #28a745
      }

      .custom-file-input.is-valid~.custom-file-label::before,
      .was-validated .custom-file-input:valid~.custom-file-label::before {
      	border-color: inherit
      }

      .custom-file-input.is-valid~.valid-feedback,
      .custom-file-input.is-valid~.valid-tooltip,
      .was-validated .custom-file-input:valid~.valid-feedback,
      .was-validated .custom-file-input:valid~.valid-tooltip {
      	display: block
      }

      .custom-file-input.is-valid:focus~.custom-file-label,
      .was-validated .custom-file-input:valid:focus~.custom-file-label {
      	box-shadow: 0 0 0 .2rem rgba(40, 167, 69, .25)
      }
      .custom-file-input.is-invalid~.custom-file-label,
      .was-validated .custom-file-input:invalid~.custom-file-label {
      	border-color: #dc3545
      }

      .custom-file-input.is-invalid~.custom-file-label::before,
      .was-validated .custom-file-input:invalid~.custom-file-label::before {
      	border-color: inherit
      }

      .custom-file-input.is-invalid~.invalid-feedback,
      .custom-file-input.is-invalid~.invalid-tooltip,
      .was-validated .custom-file-input:invalid~.invalid-feedback,
      .was-validated .custom-file-input:invalid~.invalid-tooltip {
      	display: block
      }

      .custom-file-input.is-invalid:focus~.custom-file-label,
      .was-validated .custom-file-input:invalid:focus~.custom-file-label {
      	box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .25)
      }
    </style>
    {{-- @else --}}
    {{-- @endif  --}}
@endpush
