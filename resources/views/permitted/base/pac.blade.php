@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View pacs') )
    {{ trans('invoicing.pac') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View pacs') )
    {{ trans('invoicing.pac') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View pacs') )
  <!-- Crear -->
  <div id="modal-CreatNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalbanks" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalbanks">Crear nuevo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="creatpacs" name="creatpacs" class="forms-sample" action="">
                {{ csrf_field() }}
                <div class="form-group row">
                  <label for="inputCreatCode" class="col-sm-3 col-form-label">Clave <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatCode" name="inputCreatCode" placeholder="Clave" maxlength="10">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatName" class="col-sm-3 col-form-label">Nombre <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="{{ trans('auth.nombre') }}" maxlength="20">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="entry_ws_url" class="col-sm-3 col-form-label">Url Timbrado<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="url" class="form-control form-control-sm required" id="entry_ws_url" name="entry_ws_url" placeholder="" maxlength="200">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="entry_ws_url_cancel" class="col-sm-3 col-form-label">Url de cancelación</label>
                  <div class="col-sm-9">
                    <input type="url" class="form-control form-control-sm" id="entry_ws_url_cancel" name="entry_ws_url_cancel" placeholder="" maxlength="200">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="entry_username" class="col-sm-3 col-form-label">Usuario<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="entry_username" name="entry_username" placeholder="" maxlength="200">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="entry_password" class="col-sm-3 col-form-label">Contraseña<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="entry_password" name="entry_password" placeholder="" maxlength="200">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="entry_comment" class="col-sm-3 col-form-label">Comentario<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="entry_comment" name="entry_comment" placeholder="" maxlength="200">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatOrden" class="col-sm-3 col-form-label">Orden<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required onlynumber" id="inputCreatOrden" name="inputCreatOrden" placeholder="Orden de visualización" value="0" maxlength="3">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="test" class="col-sm-3 control-label">Pruebas</label>
                  <div class="col-md-9 mb-3">
                    <input id="test" name="test" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="status" class="col-sm-3 control-label">Estatus</label>
                  <div class="col-md-9 mb-3">
                    <input id="status" name="status" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                <button type="button" class="btn btn-danger waves-effect form_creat_user" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!-- Editar -->
  <div id="modal-Edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;"> <!-- change -->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaledit">Editar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="editpacs" name="editpacs" class="forms-sample" action="">
                {{ csrf_field() }}
                <input class="form-control" type="hidden" placeholder="" id="token_b" name="token_b" value="">

                <div class="form-group row">
                  <label for="inputEditCode" class="col-sm-3 col-form-label">Clave <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditCode" name="inputEditCode" placeholder="Clave" maxlength="10">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditName" class="col-sm-3 col-form-label">Nombre <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditName" name="inputEditName" placeholder="{{ trans('auth.nombre') }}" maxlength="20">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_entry_ws_url" class="col-sm-3 col-form-label">Url Timbrado<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="url" class="form-control form-control-sm required" id="edit_entry_ws_url" name="edit_entry_ws_url" placeholder="" maxlength="200">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_entry_ws_url_cancel" class="col-sm-3 col-form-label">Url de cancelación</label>
                  <div class="col-sm-9">
                    <input type="url" class="form-control form-control-sm" id="edit_entry_ws_url_cancel" name="edit_entry_ws_url_cancel" placeholder="" maxlength="200">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_entry_username" class="col-sm-3 col-form-label">Usuario<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="edit_entry_username" name="edit_entry_username" placeholder="" maxlength="200">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_entry_password" class="col-sm-3 col-form-label">Contraseña<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="edit_entry_password" name="edit_entry_password" placeholder="" maxlength="200">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_entry_comment" class="col-sm-3 col-form-label">Comentario<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="edit_entry_comment" name="edit_entry_comment" placeholder="" maxlength="200">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditOrden" class="col-sm-3 col-form-label">Orden<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required onlynumber" id="inputEditOrden" name="inputEditOrden" placeholder="Orden de visualización" value="0" maxlength="3">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_test" class="col-sm-3 control-label">Pruebas</label>
                  <div class="col-md-9 mb-3">
                    <input id="edit_test" name="edit_test" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="editstatus" class="col-sm-3 control-label">Estatus</label>
                  <div class="col-md-9 mb-3">
                    <input id="editstatus" name="editstatus" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                <button type="button" class="btn btn-danger waves-effect form_creat_user" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <p class="mt-2 card-title">Esta sección nos permite gestionar los pacs, que podremos utilizar en nuestro proyecto.</p>
          <div class="d-flex justify-content-center pt-3"></div>

          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="table_pacs" name='table_pacs' class="table table-striped border display nowrap compact-tab" style="width:100%; font-size: 10px;">
                  <thead class="bg-primary">
                    <tr>
                      <th>Clave</th>
                      <th>Nombre</th>
                      <th>URL Web Service</th>
                      <th>Usuario</th>
                      <th>Prueba</th>
                      <th>Orden</th>
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

  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View pacs') )
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <script src="{{ asset('js/admin/base/pac.js')}}"></script>

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
  </style>
  @else
  @endif
@endpush
