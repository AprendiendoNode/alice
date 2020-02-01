@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View provider') )
    Proveedores
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View provider') )
    Proveedores
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View provider') )
  <!-- Crear -->
  <div id="modal-CreatNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalcustomers" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalcustomers">Crear nuevo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="creatcustomers" name="creatcustomers" class="forms-sample" action="">
                {{ csrf_field() }}
                <div class="form-group row">
                  <label for="inputCreatName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatTaxid" class="col-sm-3 col-form-label">RFC <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatTaxid" name="inputCreatTaxid" placeholder="RFC" maxlength="50">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatNumid" class="col-sm-3 col-form-label">Razón social <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatNumid" name="inputCreatNumid" placeholder="Reg. identidad fiscal" maxlength="300">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatEmail" class="col-sm-3 col-form-label">Correo electrónico <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control form-control-sm required" id="inputCreatEmail" name="inputCreatEmail" placeholder="Correo electrónico" maxlength="100">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditCurrency" class="col-sm-3 col-form-label">Moneda <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="inputCreateCurrency" name="inputCreateCurrency" class="form-control form-control-sm required"  style="width: 100%;">
                      @forelse ($currency as $currency_data)
                        <option value="{{ $currency_data->id }}"> {{ $currency_data->code }} </option>
                      @empty
                      @endforelse
                    </select>
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
                  <label for="inputCreatPostCode" class="col-sm-3 col-form-label">Codigo Postal<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm onlynumber required" id="inputCreatPostCode" name="inputCreatPostCode" placeholder="" maxlength="10">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatComment" class="col-sm-3 col-form-label">Comentario</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm onlynumber" id="inputCreatComment" name="inputCreatComment" placeholder="" maxlength="100">
                  </div>
                </div>
                <div class="form-group row" style="display: none;">
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
  <div id="modal-Edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaledit">Editar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="editcustomers" name="editcustomers" class="forms-sample" action="">
                {{ csrf_field() }}
                <input class="form-control" type="hidden" placeholder="" id="token_b" name="token_b" value="">

                <div class="form-group row">
                  <label for="inputEditName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditName" name="inputEditName" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditTaxid" class="col-sm-3 col-form-label">RFC <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditTaxid" name="inputEditTaxid" placeholder="RFC" maxlength="50">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditNumid" class="col-sm-3 col-form-label">Razón social <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditNumid" name="inputEditNumid" placeholder="Reg. identidad fiscal" maxlength="300">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditEmail" class="col-sm-3 col-form-label">Correo electrónico <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control form-control-sm required" id="inputEditEmail" name="inputEditEmail" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditCurrency" class="col-sm-3 col-form-label">Moneda <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="inputEditCurrency" name="inputEditCurrency" class="form-control form-control-sm required"  style="width: 100%;">
                      @forelse ($currency as $currency_data)
                        <option value="{{ $currency_data->id }}"> {{ $currency_data->code }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditPhone" class="col-sm-3 col-form-label">Telefono</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm onlynumber" id="inputEditPhone" name="inputEditPhone" placeholder="" maxlength="12">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputEditMobile" class="col-sm-3 col-form-label">Telefono movil</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm onlynumber" id="inputEditMobile" name="inputEditMobile" placeholder="" maxlength="12">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="editCreatPostCode" class="col-sm-3 col-form-label">Codigo Postal<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm onlynumber required" id="editCreatPostCode" name="editCreatPostCode" placeholder="" maxlength="10">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="editCreatComment" class="col-sm-3 col-form-label">Comentario</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="editCreatComment" name="editCreatComment" placeholder="" maxlength="100">
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
          <p class="mt-2 card-title">Esta sección nos permite gestionar los proveedores, que podremos utilizar en nuestro proyecto.</p>
          <div class="d-flex justify-content-center pt-3"></div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="table_customers" name='table_customers' class="table table-striped border display nowrap compact-tab" style="width:100%; font-size: 10px;">
                  <thead class="bg-primary">
                    <tr>
                      <th>Opciones</th>
                      <th>Nombre</th>
                      <th>RFC</th>
                      <th>Correo electrónico</th>
                      <th>Teléfono</th>
                      <th>Estatus</th>
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
  <!-------------MODAL INTEGRACIÓN CONTABLE------------>
  <div id="modal-integracion-contable" class="modal fade" role="dialog" aria-labelledby="modal-integracion-contable" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaledit">Integración contable</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="form_integration_cc" name="integration_cc" class="forms-sample">
                {{ csrf_field() }}
                <input type="hidden" id="id_customer_cc" name="id_customer_cc">
                <input type="hidden" id="provider" name="provider" value="1">
                <div class="form-group row">
                  <label for="customer_name" class="col-sm-4 col-form-label">Cliente: <span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" readonly style="min-width: 100px;" class="form-control form-control-sm required select2" id="customer_name" name="customer_name">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="cuenta_contable" class="col-sm-4 col-form-label">Cuenta contable:<span style="color: red;">*</span></label>
                  <div class="col-sm-8">
                    <select required  class="form-control form-control-sm required select2" id="cuenta_contable" name="cuenta_contable">
                      <option value="">Elegir</option>
                      @foreach ($cuentas_contables as $cuenta_data)
                        <option value="{{$cuenta_data->id}}">{{$cuenta_data->cuenta}} {{$cuenta_data->nombre}}</option>
                      @endforeach
                    </select> 
                  </div>
                </div>
                <div class="form-group row">
                  <label for="cuenta_complementaria" class="col-sm-4 col-form-label">Cuenta complementaria:</label>
                  <div class="col-sm-8">
                    <select class="form-control form-control-sm required select2" id="cuenta_complementaria" name="cuenta_complementaria">
                      <option value="">Elegir</option>
                      @foreach ($cuentas_contables as $cuenta_data)
                        <option value="{{$cuenta_data->id}}">{{$cuenta_data->cuenta}} {{$cuenta_data->nombre}}</option>
                      @endforeach
                    </select> 
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="fas fa-check" style="margin-right: 4px;"></i> Aceptar</button>
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
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View provider') )
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <script src="{{ asset('js/admin/payments/providers.js')}}"></script>

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

    .dropdown-menu {
      font-size: 0.8rem !important;
    }

    #cuenta_contable, #cuenta_complementaria, #cuenta_anticipo{
      width: 400px;
    }
  </style>
  @else
  @endif
@endpush
