@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View accounting account') )
    Cuenta contable
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View accounting account') )
    Cuenta contable
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  <!-- Crear -->
  <div id="modal-CreatNew" class="modal fade" role="dialog" aria-labelledby="modalaccount" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalaccount">Crear nuevo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="creatrecord" name="creatrecord" class="forms-sample" action="">
                {{ csrf_field() }}
                <div class="form-group row">
                  <label for="inputCreatCode" class="col-sm-3 col-form-label">Clave <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatCode" name="inputCreatCode" placeholder="{{ trans('auth.nombre') }}" maxlength="24"
                    data-mask="0000-000-000-000-000-000">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatName" class="col-sm-3 col-form-label">Cuenta contable<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="Cuenta contable" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_one" class="col-sm-3 col-form-label">Codigo agrupador</label>
                  <div class="col-sm-9">
                    <select  id="select_one" name="select_one" class="form-control form-control-sm select2"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($list_code_agrup as $list_code_agrup_data)
                        <option value="{{ $list_code_agrup_data->id }}"> {{ $list_code_agrup_data->Codigo_agrupador }} - {{ $list_code_agrup_data->Nombre }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_two" class="col-sm-3 col-form-label">Naturaleza<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_two" name="select_two" class="form-control form-control-sm select2 required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($list_nature as $list_nature_data)
                        <option value="{{ $list_nature_data->id }}"> {{ $list_nature_data->NA }} - {{ $list_nature_data->naturaleza }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_three" class="col-sm-3 col-form-label">Rubro<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_three" name="select_three" class="form-control form-control-sm select2 required"  style="width: 100%;">
                      <option value="" selected>{{ trans('message.selectopt') }}</option>
                      @forelse ($list_rubro as $list_rubro_data)
                        <option value="{{ $list_rubro_data->id }}"> {{ $list_rubro_data->clave }} - {{ $list_rubro_data->descripcion }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="last_level" class="col-sm-3 control-label">Ultimo nivel</label>
                  <div class="col-md-9 mb-3">
                    <input id="last_level" name="last_level" type="checkbox" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger" value="0" data-on="Si" data-off="No">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="status" class="col-sm-3 control-label">Estatus</label>
                  <div class="col-md-9 mb-3">
                    <input id="status" name="status" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1" data-on="Activo" data-off="Deshabilitado">
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
  <div id="modal-Edit" class="modal fade" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaledit">Editar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="editrecord" name="editrecord" class="forms-sample" action="">
                {{ csrf_field() }}
                <input class="form-control" type="hidden" placeholder="" id="token_b" name="token_b" value="">
                <div class="form-group row">
                  <label for="inputEditCode" class="col-sm-3 col-form-label">Clave <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditCode" name="inputEditCode" placeholder="Clave" maxlength="24"
                    data-mask="0000-000-000-000-000-000">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEditName" class="col-sm-3 col-form-label">Cuenta contable<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditName" name="inputEditName" placeholder="Nombre" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_select_one" class="col-sm-3 col-form-label">Codigo agrupador</label>
                  <div class="col-sm-9">
                    <select  id="edit_select_one" name="edit_select_one" class="form-control form-control-sm select2"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($list_code_agrup as $list_code_agrup_data)
                        <option value="{{ $list_code_agrup_data->id }}"> {{ $list_code_agrup_data->Codigo_agrupador }} - {{ $list_code_agrup_data->Nombre }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_select_two" class="col-sm-3 col-form-label">Naturaleza<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="edit_select_two" name="edit_select_two" class="form-control form-control-sm select2 required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($list_nature as $list_nature_data)
                        <option value="{{ $list_nature_data->id }}"> {{ $list_nature_data->NA }} - {{ $list_nature_data->naturaleza }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_select_three" class="col-sm-3 col-form-label">Rubro<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="edit_select_three" name="edit_select_three" class="form-control form-control-sm select2 required"  style="width: 100%;">
                      <option value="" selected>{{ trans('message.selectopt') }}</option>
                      @forelse ($list_rubro as $list_rubro_data)
                        <option value="{{ $list_rubro_data->id }}"> {{ $list_rubro_data->clave }} - {{ $list_rubro_data->descripcion }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_last_level" class="col-sm-3 control-label">Ultimo nivel</label>
                  <div class="col-md-9 mb-3">
                    <input id="edit_last_level" name="edit_last_level" type="checkbox" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger" value="0" data-on="Si" data-off="No">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_status" class="col-sm-3 control-label">Estatus</label>
                  <div class="col-md-9 mb-3">
                    <input id="edit_status" name="edit_status" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1" data-on="Activo" data-off="Deshabilitado">
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


  @if( auth()->user()->can('View accounting account') )
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form id="form" name="form" enctype="multipart/form-data">
              {{ csrf_field() }}
            </form>
            <div class="table-responsive table-data table-dropdown">
              <table id="table_filter" name='table_filter' class="table table-striped table-hover table-condensed">
                <thead>
                  <tr class="mini">
                      <th class="text-center" width="5%">@lang('general.column_actions')</th>
                      <th class="text-center">
                          Clave
                      </th>
                      <th class="text-center">
                          Cuenta Contable
                      </th>
                      <th class="text-left">
                          Naturaleza
                      </th>
                      <th class="text-center">
                          Rubro
                      </th>
                      <th class="text-left">
                          Codigo Agrupador
                      </th>
                      <th class="text-left">
                          Estatus
                      </th>
                  </tr>
                </thead>
              </table>
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
  @if( auth()->user()->can('View accounting account') )
    {{-- <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" /> --}}
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
    <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

    <script src="{{ asset('bower_components/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js')}}"></script>

    <script src="{{ asset('js/admin/integration/accounting_account.js')}}"></script>
    <style media="screen">
      .toggle.btn {
        min-width: 7.5rem !important;
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

      #table_filter tbody tr td {
        padding: 0.2rem 0.5rem;
        height: 38px !important;
      }

      #table_filter thead tr th{
          padding: 0.2rem 0.5rem;
          height: 38px !important;
      }
    </style>
  @else
  @endif
@endpush
