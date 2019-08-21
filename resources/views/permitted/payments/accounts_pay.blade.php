@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View manage bank account') )
    {{ trans('message.manage') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View manage bank account') )
    {{ trans('message.manage_account') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View manage bank account') )
    {{ trans('message.breadcrumb_manage_account') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View manage bank account') )
      @if( auth()->user()->can('Edit bank provider') )
        <div class="modal modal-default fade" id="modal_bank" data-backdrop="static">
            <div class="modal-dialog" >
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-university" style="margin-right: 4px;"></i>{{ trans('pay.data_bakl') }}</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                  <div class="card table-responsive">
                    <div class="card-body">
                      @if( auth()->user()->can('Edit bank provider') )
                          <form class="form-horizontal" id="data_account_bank" name="data_account_bank">
                            {{ csrf_field() }}
                            <input class="form-control hidden" style="display: none;" type="text" name="reg_id_prvcta" id="reg_id_prvcta">

                            <div class="row form-group">
                              <label for="reg_bancos" class="col-md-3 control-label">{{ trans('pay.bank') }}</label>
                              <input class="col-md-9 form-control" type="text" name="reg_bancos" id="reg_bancos" value="" readonly>
                            </div>
                            <div class="row form-group my-3">
                              <label for="reg_coins" class="col-md-3 control-label">{{ trans('pay.type_coins') }}</label>
                                <input class="col-md-9 form-control" type="text" name="reg_coins" id="reg_coins" value="" readonly>
                            </div>
                            <div class="row form-group my-3">
                              <label for="reg_cuenta" class="col-md-3 control-label">{{ trans('pay.cuenta') }}</label>
                                <input class="col-md-9 form-control" type="text" name="reg_cuenta" id="reg_cuenta" value="">
                            </div>
                            <div class="row form-group my-3">
                              <label for="reg_clabe" class="col-md-3 control-label">{{ trans('pay.clabe') }}</label>
                                <input class="col-md-9 form-control" type="text" name="reg_clabe" id="reg_clabe" value="">
                            </div>
                            <div class="row form-group my-3">
                              <label for="reg_reference" class="col-md-3 control-label">{{ trans('pay.reference') }}</label>
                                <input class="col-md-9 form-control" type="text" name="reg_reference" id="reg_reference" value="">
                            </div>
                            @if( auth()->user()->can('Edit bank provider') )
                              <button type="button" class="btn btn-secondary btn_bank_edit mt-3"><i class="fas fa-plus-square" style="margin-right: 4px;"></i>Editar</button>
                              <!-- <button type="button" class="btn bg-navy create_provider"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button> -->
                            @endif
                            <button type="button" class="btn btn-danger delete_provider mt-3" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cancelar') }} & {{ trans('message.ccmodal') }}</button>

                          </form>
                      @else
                        <div>
                          @include('default.deniedmodule')
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                </div>
              </div>
            </div>
        </div>
      @endif
      <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-md-12 col-lg-12">
              <div class="card">
                <!-- /.box-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <form id="form_bank" name="form_bank" class="form-horizontal" method="POST">
                        {{ csrf_field() }}
                        <div class="form-inline">
                          <label for="select_one" class="col-md-2 control-label">{{ trans('message.title_provider') }}</label>
                          <div class="col-md-10 selectContainer">
                            <select id="select_one" name="select_one" class="form-control select2">
                              <option value="" selected> Elija </option>
                              @forelse ($proveedor as $data_proveedor)
                                <option value="{{ $data_proveedor->id }}"> {{ $data_proveedor->nombre }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        </div>
                      </form>
                      <div class="mt-3 table-responsive">
                        <table id="table_pays" class="table table-striped table-bordered table-hover compact-tab w-100">
                          <thead>
                            <tr class="bg-primary" style="background: #38393f;">
                              <th> <small>Banco</small> </th>
                              <th> <small>Cuenta</small> </th>
                              <th> <small>Clave</small> </th>
                              <th> <small>Referencia</small> </th>
                              <th> <small>Unidad</small> </th>
                              <th> <small>Estatus</small> </th>
                              <th> <small>Conceptos</small> </th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <!-- <tfoot id='tfoot_average'>
                            <tr>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                            </tr>
                          </tfoot> -->
                        </table>
                      </div>

                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <!-- The footer of the box -->
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
  @if( auth()->user()->can('View manage bank account') )
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
  <script src="{{ asset('js/admin/payments/bk_pay.js')}}"></script>
  <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
  <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
  @endif
  @if( auth()->user()->can('Edit bank provider') )
    <script type="text/javascript">
      permission = true;
    </script>
  @endif
@endpush
