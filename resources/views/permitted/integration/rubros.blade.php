@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View rubros') )
    Rubros
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View rubros') )
    Rubros
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  <!-- Crear -->
  <div id="modal-CreatNew" class="modal fade" role="dialog" aria-labelledby="modalbanks" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalbanks">Crear nuevo</h4>
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
                    <input type="text" class="form-control form-control-sm required" id="inputCreatCode" name="inputCreatCode" placeholder="Clave" maxlength="3">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatDesc" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatDesc" name="inputCreatDesc" placeholder="{{ trans('auth.nombre') }}" maxlength="80">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatRubro" class="col-sm-3 col-form-label">Rubro <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="inputCreatRubro" name="inputCreatRubro" class="form-control form-control-sm select2 required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($list_rubro as $key => $value)
                        <option value="{{ $key }}"> {{ $value }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputCreatGrup" class="col-sm-3 col-form-label">Grupo</label>
                  <div class="col-sm-9">
                    <select  id="inputCreatGrup" name="inputCreatGrup" class="form-control form-control-sm select2" style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($list_grup as $key => $value)
                        <option value="{{ $key }}"> {{ $value }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputCreatLugar" class="col-sm-3 col-form-label">Lugar</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="inputCreatLugar" name="inputCreatLugar"
                    maxlength="3" pattern="^\d{0,10}(\.\d{1,2})?$" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
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
                    <input type="text" class="form-control form-control-sm required" id="inputEditCode" name="inputEditCode" placeholder="Clave" maxlength="3">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputEditDesc" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditDesc" name="inputEditDesc" placeholder="{{ trans('auth.nombre') }}" maxlength="80">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputEditRubro" class="col-sm-3 col-form-label">Rubro <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="inputEditRubro" name="inputEditRubro" class="form-control form-control-sm select2 required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($list_rubro as $key => $value)
                        <option value="{{ $key }}"> {{ $value }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputEditGrup" class="col-sm-3 col-form-label">Grupo</label>
                  <div class="col-sm-9">
                    <select  id="inputEditGrup" name="inputEditGrup" class="form-control form-control-sm select2" style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($list_grup as $key => $value)
                        <option value="{{ $key }}"> {{ $value }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputEditLugar" class="col-sm-3 col-form-label">Lugar</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="inputEditLugar" name="inputEditLugar" maxlength="3">
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

  @if( auth()->user()->can('View rubros') )
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
                          Descripción
                      </th>
                      <th class="text-left">
                          Rubro
                      </th>
                      <th class="text-center">
                          Grupo
                      </th>
                      <th class="text-left">
                          Lugar
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
  @if( auth()->user()->can('View rubros') )
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

    <script src="{{ asset('js/admin/integration/rubros.js')}}"></script>
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
    </style>
  @else
  @endif
@endpush
