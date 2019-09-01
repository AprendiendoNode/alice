@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View salespersons') )
    {{ trans('invoicing.salespersons') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View salespersons') )
    {{ trans('invoicing.salespersons') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View salespersons') )
  <!-- Crear -->
  <div id="modal-CreatNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalsalespersons" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalsalespersons">Crear nuevo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="creatsalespersons" name="creatsalespersons" class="forms-sample" action="">
                {{ csrf_field() }}
                <div class="form-group row">
                  <label for="inputCreatName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} completo <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="{{ trans('auth.nombre') }} completo" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatFirst" class="col-sm-3 col-form-label">Nombres</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="inputCreatFirst" name="inputCreatFirst" placeholder="Nombres" maxlength="30">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatLast" class="col-sm-3 col-form-label">Apellidos</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="inputCreatLast" name="inputCreatLast" placeholder="Apellidos" maxlength="30">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatEmail" class="col-sm-3 col-form-label">Correo electrónico <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control form-control-sm required" id="inputCreatEmail" name="inputCreatEmail" placeholder="Correo electrónico" maxlength="100">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatPhone" class="col-sm-3 col-form-label">Telefono</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm onlynumber" id="inputCreatPhone" name="inputCreatPhone" placeholder="" maxlength="12">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatMobile" class="col-sm-3 col-form-label">Telefono movil</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm onlynumber" id="inputCreatMobile" name="inputCreatMobile" placeholder="" maxlength="12">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatComission" class="col-sm-3 col-form-label">Porcentaje de comisión</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm onlynumber" id="inputCreatComission" name="inputCreatComission" placeholder="Porcentaje de comisión" maxlength="60" value="0">
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
  <div id="modal-Edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditsalespersons" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaleditsalespersons">Editar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="editsalespersons" name="editsalespersons" class="forms-sample" action="">
                {{ csrf_field() }}
                <input class="form-control" type="hidden" placeholder="" id="token_b" name="token_b" value="">

                <div class="form-group row">
                  <label for="inputEditName" class="col-sm-3 col-form-label">Nombre completo <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditName" name="inputEditName" placeholder="Nombre completo" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditFirst" class="col-sm-3 col-form-label">Nombres</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="inputEditFirst" name="inputEditFirst" placeholder="Nombres" maxlength="30">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditLast" class="col-sm-3 col-form-label">Apellidos</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="inputEditLast" name="inputEditLast" placeholder="Apellidos" maxlength="30">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditEmail" class="col-sm-3 col-form-label">Correo electrónico <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditEmail" name="inputEditEmail" placeholder="Correo electrónico " maxlength="100">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditPhone" class="col-sm-3 col-form-label">Telefono</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm onlynumber" id="inputEditPhone" name="inputEditPhone" placeholder="Telefono" maxlength="12">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditMobile" class="col-sm-3 col-form-label">Telefono movil</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm onlynumber" id="inputEditMobile" name="inputEditMobile" placeholder="Telefono" maxlength="12">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditComission" class="col-sm-3 col-form-label">Porcentaje de comisión</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm onlynumber" id="inputEditComission" name="inputEditComission" placeholder="Nombre completo" maxlength="60" value="0">
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
          <p class="mt-2 card-title">Esta sección nos permite gestionar los vendedores, que podremos utilizar en nuestro proyecto.</p>
          <div class="d-flex justify-content-center pt-3"></div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="table_salespersons" name='table_salespersons' class="table table-striped border display nowrap" style="width:100%; font-size: 10px;">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Correo electrónico</th>
                      <th>Teléfono</th>
                      <th>Porcentaje de comisión</th>
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
  @if( auth()->user()->can('View salespersons') )
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <script src="{{ asset('js/admin/sales/salespersons.js')}}"></script>

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
  </style>
  @else
  @endif
@endpush
