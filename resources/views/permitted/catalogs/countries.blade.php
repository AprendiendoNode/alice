@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View countries') )
    {{ trans('invoicing.countries') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View countries') )
    {{ trans('invoicing.countries') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View countries') )
    <!-- Crear -->
    <div id="modal-CreatNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalcountries" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modalcountries">Crear país</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <form id="creatcountry" name="creatcountry" class="forms-sample" action="">
                  {{ csrf_field() }}
                  <div class="form-group row">
                    <label for="inputCreatCode" class="col-sm-3 col-form-label">Clave <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required" id="inputCreatCode" name="inputCreatCode" placeholder="Clave" maxlength="4">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputCreatName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputCreatOrden" class="col-sm-3 col-form-label">Orden<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required onlynumber" id="inputCreatOrden" name="inputCreatOrden" placeholder="Orden de visualización" value="0" maxlength="3">
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
    <div id="modal-Edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditcountry" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modaleditcountry">Editar pais</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <form id="editcountry" name="editcountry" class="forms-sample" action="">
                  {{ csrf_field() }}
                  <input class="form-control" type="hidden" placeholder="" id="token_b" name="token_b" value="">

                  <div class="form-group row">
                    <label for="inputEditCode" class="col-sm-3 col-form-label">Clave <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required" id="inputEditCode" name="inputEditCode" placeholder="Clave" maxlength="3">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEditName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required" id="inputEditName" name="inputEditName" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEditOrden" class="col-sm-3 col-form-label">Orden<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required onlynumber" id="inputEditOrden" name="inputEditOrden" placeholder="Orden de visualización" value="0" maxlength="3">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="editstatus" class="col-sm-3 control-label">Estatus</label>
                    <div class="col-md-9 mb-3">
                      <input id="editstatus" name="editstatus" type="checkbox" data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
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
    <div class="row">
      <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="mt-2 card-title">Esta sección nos permite gestionar los paises, que podremos utilizar en nuestro proyecto.</p>
            <strong>Nota:</strong>
            <span class="text_content">Si necesitas añadir un nuevo país, debes de consultar el siguiente hipervínculo del sat, para obtener la informacion correcta antes de registrar en el sistema.</span>
            <a href="http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Paginas/Catalogos_comercio_exterior.aspx" target="_blank">Catálogos para la emision de CFDI</a>

            <div class="d-flex justify-content-center pt-3"></div>

            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table id="table_countries" name='table_countries' class="table table-striped border display nowrap" style="width:100%; font-size: 10px;">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Clave</th>
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
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View countries') )
    <style media="screen">
      .text_content {
        font-size: 0.875rem;
        line-height: 1.5rem;
      }
    </style>
    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <script src="{{ asset('js/admin/catalogs/countries.js')}}"></script>
  @else
  @endif
@endpush
