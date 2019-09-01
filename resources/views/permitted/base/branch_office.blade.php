@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View branch office') )
    {{ trans('invoicing.branchoffice') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View branch office') )
    {{ trans('invoicing.branchoffice') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View branch office') )
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
        </ul>
        <form id="createBranchOffice" name="createBranchOffice">
        <div class="tab-content">
          <!--- TAB GENERAL ------------------->
          <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="media">
              <div class="media-body">
                <div class="row">
                  <div id="" class="col-md-6">
                    <div class="form-group row">
                      <label for="inputCreateName" class="col-sm-4 col-form-label">Nombre <span style="color: red;">*</span></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm required" id="inputCreateName" name="inputCreateName" placeholder="Nombre de la empresa" maxlength="60">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputCreateEmail" class="col-sm-4 col-form-label">Correo electrónico</label>
                      <div class="col-sm-8">
                        <input type="email" class="form-control form-control-sm required" id="inputCreatEmail" name="inputCreatEmail" placeholder="Correo electrónico" maxlength="100">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputCreatePhone" class="col-sm-4 col-form-label">Telefono:</label>
                      <div class="col-sm-8">
                        <input maxlength="12" type="text" class="form-control required onlynumber" id="inputCreatPhone" name="inputCreatPhone" placeholder="Ingrese el núm. telefono">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputCreatePhoneMobile" class="col-sm-4 col-form-label">Telefono móvil:</label>
                      <div class="col-sm-8">
                        <input maxlength="12" type="text" class="form-control required onlynumber" id="inputCreatPhoneMobile" name="inputCreatPhoneMobile" placeholder="Ingrese el núm. telefono">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label for="inputCreateOrden" class="col-sm-4 col-form-label">Orden:<span style="color: red;">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm required onlynumber" id="inputCreatOrden" name="inputCreatOrden" placeholder="Orden de visualización" value="0" maxlength="3">
                      </div>
                    </div>
                    <div class="form-group row mt-3">
                      <label for="status" class="col-sm-4 control-label">Estatus</label>
                      <div class="col-md-8 mb-3">
                        <input id="status" name="status" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                      </div>
                    </div>
                    <div class="form-group row mt-3">
                      <label for="datainfo" class="col-sm-4 control-label">Información adicional</label>
                      <div class="col-md-8 mb-3">
                        <textarea class="form-control" id="datainfo" name="datainfo" rows="4"></textarea>
                      </div>
                    </div>

                  </div>
                </div><!---row---->
              </div>
            </div>
          </div>
          <!--- TAB ADDRESS ------------------->
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
                          <label>Direccion:</label>
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
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Localidad:</label>
                          <input type="text" class="form-control" id="inputCreatAddress_5" name="inputCreatAddress_5" placeholder="" maxlength="50">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Código postal:</label>
                          <input type="text" class="form-control" id="inputZipCode" name="inputZipCode" placeholder="" maxlength="10">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Referencia:</label>
                          <input type="text" class="form-control" id="inputCreatAddress_6" name="inputCreatAddress_6" placeholder="" maxlength="100">
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
                          <label for="select_paises" class="control-label">País:<span style="color: red;">*</span></label>
                            <select id="select_paises" name="select_paises" class="form-control required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="select_estados" class="control-label">Estado:<span style="color: red;">*</span></label>
                            <select id="select_estados" name="select_estados" class="form-control required" style="width:100%;">
                              @forelse ($states as $states_data)
                                @if(isset($company[0]->state_id))
                                  @if ($company[0]->state_id === $states_data->id)
                                    <option value="{{ $states_data->id }}" selected> {{ $states_data->name }} </option>
                                  @else
                                    <option value="{{ $states_data->id }}"> {{ $states_data->name }} </option>
                                  @endif
                                @else
                                  <option value="{{ $states_data->id }}"> {{ $states_data->name }} </option>
                                @endif
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="select_ciudades" class="control-label">Ciudad:<span style="color: red;">*</span></label>
                            <select id="select_ciudades" name="select_ciudades" class="form-control required" style="width:100%;">
                              @forelse ($cities as $cities_data)
                                @if(isset($company[0]->city_id))
                                  @if ($company[0]->city_id === $cities_data->id)
                                    <option value="{{ $cities_data->id }}" selected> {{ $cities_data->name }} </option>
                                  @else
                                    <option value="{{ $cities_data->id }}"> {{ $cities_data->name }} </option>
                                  @endif
                                @else
                                  <option value="{{ $cities_data->id }}"> {{ $cities_data->name }} </option>
                                @endif
                              @empty
                              @endforelse
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
        </div>

        <div class="card-footer text-muted">
          <button class="btn btn-danger mt-2 mt-xl-0">Actualizar</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <p class="mt-2 card-title">Esta sección nos permite gestionar las sucursales.</p>
          <div class="d-flex justify-content-center pt-3"></div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="table_branch" name='table_branch' class="table table-striped border display nowrap" style="width:100%; font-size: 10px;">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>Telefono</th>
                      <th>País</th>
                      <th>Estado</th>
                      <th>Ciudad</th>
                      <th>Estatus</th>
                      <th>Opciones</th>
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
  </div>

  <!-- Editar -->
  <div id="modal-Edit-Branch" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-Edit-Branch" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modal-Edit-Branch">Editar sucursal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <p class="text-primary ml-2">General</p>
            <div class="col-12">
              <form id="editBranchOffice" name="editBranchOffice" class="forms-sample" action="">
                {{ csrf_field() }}
                <input class="form-control" type="hidden" placeholder="" id="id_branch" name="id_branch" value="">
                <div class="row">
                  <div id="" class="col-md-6">
                    <div class="form-group row">
                      <label for="inputEditName" class="col-sm-4 col-form-label">Nombre <span style="color: red;">*</span></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm required" id="inputEditName" name="inputEditName" placeholder="Nombre de la empresa" maxlength="60">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEditEmail" class="col-sm-4 col-form-label">Correo electrónico</label>
                      <div class="col-sm-8">
                        <input type="email" class="form-control form-control-sm required" id="inputEditEmail" name="inputEditEmail" placeholder="Correo electrónico" maxlength="100">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEditPhone" class="col-sm-4 col-form-label">Telefono:</label>
                      <div class="col-sm-8">
                        <input maxlength="12" type="text" class="form-control required onlynumber" id="inputEditPhone" name="inputEditPhone" placeholder="Ingrese el núm. telefono">
                      </div>
                    </div>
                  </div><!---col-md-6-->
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label for="inputEditOrden" class="col-sm-4 col-form-label">Orden:<span style="color: red;">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm required onlynumber" id="inputEditOrden" name="inputEditOrden" placeholder="Orden de visualización" value="0" maxlength="3">
                      </div>
                    </div>
                    <div class="form-group row mt-3">
                      <label for="statusEdit" class="col-sm-4 control-label">Estatus</label>
                      <div class="col-md-8 mb-3">
                        <input id="statusEdit" name="statusEdit" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEditPhoneMobile" class="col-sm-4 col-form-label">Telefono móvil:</label>
                      <div class="col-sm-8">
                        <input maxlength="12" type="text" class="form-control required onlynumber" id="inputEditPhoneMobile" name="inputEditPhoneMobile" placeholder="Ingrese el núm. telefono">
                      </div>
                    </div>
                  </div>
                </div><!---row---->
                <div class="form-group row">
                  <label for="datainfoEdit" class="col-sm-4 control-label">Información adicional</label>
                  <div class="col-sm-8 mb-3">
                    <textarea class="form-control" id="datainfoEdit" name="datainfoEdit" rows="4"></textarea>
                  </div>
                </div>

                  <!------------------------------------------------------------------------------>
                <div class="row">
                  <div class="col-md-12">

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Direccion:</label>
                          <input maxlength="100" type="text" class="form-control required" id="inputEditAddress_1" name="inputCreatAddress_1" placeholder="Direccion">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Num. Ext:</label>
                          <input type="text" class="form-control" id="inputEditAddress_2" name="inputEditAddress_2" placeholder="" maxlength="50">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Num Int.</label>
                          <input type="text" class="form-control" id="inputEditAddress_3" name="inputEditAddress_3" placeholder="" maxlength="50">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Colonia:</label>
                          <input type="text" class="form-control" id="inputEditAddress_4" name="inputEditAddress_4" placeholder="" maxlength="100">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Localidad:</label>
                          <input type="text" class="form-control" id="inputEditAddress_5" name="inputEditAddress_5" placeholder="" maxlength="50">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Código postal:</label>
                          <input type="text" class="form-control" id="inputZipCodeEdit" name="inputZipCodeEdit" placeholder="" maxlength="10">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Referencia:</label>
                          <input type="text" class="form-control" id="inputEditAddress_6" name="inputEditAddress_6" placeholder="" maxlength="100">
                        </div>
                      </div>
                    </div>
                    <!-------------------------------------------------------------------------------->
                    <div class="row mt-3">
                      <div class="col-md-12">
                        <!-------------------------------------------------------------------------------->
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="select_paises_edit" class="control-label">País:<span style="color: red;">*</span></label>
                                <select id="select_paises_edit" name="select_paises_edit" class="form-control required" style="width:100%;">
                                  <option value="">{{ trans('message.selectopt') }}</option>
                                  @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                  @endforeach
                                </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="select_estados_edit" class="control-label">Estado:<span style="color: red;">*</span></label>
                                <select id="select_estados_edit" name="select_estados_edit" class="form-control required" style="width:100%;">
                                  @forelse ($states as $states_data)
                                    @if(isset($company[0]->state_id))
                                      @if ($company[0]->state_id === $states_data->id)
                                        <option value="{{ $states_data->id }}" selected> {{ $states_data->name }} </option>
                                      @else
                                        <option value="{{ $states_data->id }}"> {{ $states_data->name }} </option>
                                      @endif
                                    @else
                                      <option value="{{ $states_data->id }}"> {{ $states_data->name }} </option>
                                    @endif
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="select_ciudades_edit" class="control-label">Ciudad:<span style="color: red;">*</span></label>
                                <select id="select_ciudades_edit" name="select_ciudades_edit" class="form-control required" style="width:100%;">
                                  @forelse ($cities as $cities_data)
                                    @if(isset($company[0]->city_id))
                                      @if ($company[0]->city_id === $cities_data->id)
                                        <option value="{{ $cities_data->id }}" selected> {{ $cities_data->name }} </option>
                                      @else
                                        <option value="{{ $cities_data->id }}"> {{ $cities_data->name }} </option>
                                      @endif
                                    @else
                                      <option value="{{ $cities_data->id }}"> {{ $cities_data->name }} </option>
                                    @endif
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                          </div>
                        </div>
                        <!-------------------------------------------------------------------------------->
                      </div>
                    </div>
                    <br>
                  </div>
                </div>

                <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.editar') }}</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  <!-- Tabla de sucursales -->

  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View branch office') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <script src="{{ asset('js/admin/base/branch_office.js')}}"></script>


    <style media="screen">
      .modal-content{
        width: 120%;
      }

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
    @else
    @endif
@endpush
