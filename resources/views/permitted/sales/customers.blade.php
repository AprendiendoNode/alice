@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View cover') )
    {{ trans('invoicing.customers') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customers') )
    {{ trans('invoicing.customers') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View customers') )
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
                    <input type="text" class="form-control form-control-sm required" id="inputCreatTaxid" name="inputCreatTaxid" placeholder="RFC" maxlength="30">
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
                    <input type="text" class="form-control form-control-sm required" id="inputCreatEmail" name="inputCreatEmail" placeholder="Correo electrónico" maxlength="100">
                    <small id="passwordHelpBlock" class="form-text text-muted">
                      Para agregar mas de un email favor de separar por un <strong class="text-danger">;</strong> 
                      al final de cada email sin agregar espacios.
                    </small>
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
                <!-- <div class="form-group row">
                  <label for="select_one" class="col-sm-3 col-form-label">Término de pago <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_one" name="select_one" class="form-control form-control-sm required"  style="width: 100%;">
                      @forelse ($payment_term as $payment_term_data)
                      <option value="{{ $payment_term_data->id }}"> {{ $payment_term_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_two" class="col-sm-3 col-form-label">Formas de pago<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_two" name="select_two" class="form-control form-control-sm required"  style="width: 100%;">
                      @forelse ($payment_way as $payment_way_data)
                      <option value="{{ $payment_way_data->id }}"> {{ $payment_way_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_three" class="col-sm-3 col-form-label">Metodo de pago<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_three" name="select_three" class="form-control form-control-sm required"  style="width: 100%;">
                      @forelse ($payment_methods as $payment_methods_data)
                      <option value="{{ $payment_methods_data->id }}"> {{ $payment_methods_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_four" class="col-sm-3 col-form-label">Usos de CFDI<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_four" name="select_four" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($cfdi_uses as $cfdi_uses_data)
                      <option value="{{ $cfdi_uses_data->id }}"> {{ $cfdi_uses_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_five" class="col-sm-3 col-form-label">Vendedores<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_five" name="select_five" class="form-control form-control-sm required"  style="width: 100%;">
                      @forelse ($salespersons as $salespersons_data)
                      <option value="{{ $salespersons_data->id }}"> {{ $salespersons_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div> -->
                <div class="form-group row">
                  <label for="inputCreatAddress_1" class="col-sm-3 col-form-label">Direccion<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatAddress_1" name="inputCreatAddress_1" placeholder="Direccion" maxlength="100">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatAddress_2" class="col-sm-3 col-form-label">Num. Ext</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="inputCreatAddress_2" name="inputCreatAddress_2" placeholder="" maxlength="50">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatAddress_3" class="col-sm-3 col-form-label">Num Int.</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="inputCreatAddress_3" name="inputCreatAddress_3" placeholder="" maxlength="50">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatAddress_4" class="col-sm-3 col-form-label">Colonia</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="inputCreatAddress_4" name="inputCreatAddress_4" placeholder="" maxlength="100">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatAddress_5" class="col-sm-3 col-form-label">Localidad</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="inputCreatAddress_5" name="inputCreatAddress_5" placeholder="" maxlength="100">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatAddress_6" class="col-sm-3 col-form-label">Referencia</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatAddress_6" name="inputCreatAddress_6" placeholder="" maxlength="150">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_six" class="col-sm-3 col-form-label">Paises<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_six" name="select_six" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($countries as $countries_data)
                      <option value="{{ $countries_data->id }}"> {{ $countries_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_seven" class="col-sm-3 col-form-label">Estados<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_seven" name="select_seven" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($states as $states_data)
                      <option value="{{ $states_data->id }}"> {{ $states_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_eight" class="col-sm-3 col-form-label">Ciudades<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_eight" name="select_eight" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($cities as $cities_data)
                      <option value="{{ $cities_data->id }}"> {{ $cities_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
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
                    <input type="text" class="form-control form-control-sm" id="inputCreatComment" name="inputCreatComment" placeholder="" maxlength="100">
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
                    <input type="text" class="form-control form-control-sm required" id="inputEditTaxid" name="inputEditTaxid" placeholder="RFC" maxlength="30">
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
                    <input type="text" class="form-control form-control-sm required" id="inputEditEmail" name="inputEditEmail" placeholder="{{ trans('auth.nombre') }}">
                    <small id="passwordHelpBlock" class="form-text text-muted">
                      Para agregar mas de un email favor de separar por un <strong class="text-danger">;</strong> 
                      al final de cada email sin agregar espacios.
                    </small>
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
                <!-- <div class="form-group row">
                  <label for="edit_select_one" class="col-sm-3 col-form-label">Termino de pago <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="edit_select_one" name="edit_select_one" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($payment_term as $payment_term_data)
                      <option value="{{ $payment_term_data->id }}"> {{ $payment_term_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_select_two" class="col-sm-3 col-form-label">Formas de pago<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="edit_select_two" name="edit_select_two" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($payment_way as $payment_way_data)
                      <option value="{{ $payment_way_data->id }}"> {{ $payment_way_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_select_three" class="col-sm-3 col-form-label">Metodo de pago<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="edit_select_three" name="edit_select_three" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($payment_methods as $payment_methods_data)
                      <option value="{{ $payment_methods_data->id }}"> {{ $payment_methods_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_select_four" class="col-sm-3 col-form-label">Usos de CFDI<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="edit_select_four" name="edit_select_four" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($cfdi_uses as $cfdi_uses_data)
                      <option value="{{ $cfdi_uses_data->id }}"> {{ $cfdi_uses_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_select_five" class="col-sm-3 col-form-label">Vendedores<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="edit_select_five" name="edit_select_five" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($salespersons as $salespersons_data)
                      <option value="{{ $salespersons_data->id }}"> {{ $salespersons_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div> -->
                <div class="form-group row">
                  <label for="editCreatAddress_1" class="col-sm-3 col-form-label">Direccion<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="editCreatAddress_1" name="editCreatAddress_1" placeholder="Direccion" maxlength="100">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="editCreatAddress_2" class="col-sm-3 col-form-label">Num. Ext</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="editCreatAddress_2" name="editCreatAddress_2" placeholder="" maxlength="50">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="editCreatAddress_3" class="col-sm-3 col-form-label">Num Int.</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="editCreatAddress_3" name="editCreatAddress_3" placeholder="" maxlength="50">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="editCreatAddress_4" class="col-sm-3 col-form-label">Colonia</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="editCreatAddress_4" name="editCreatAddress_4" placeholder="" maxlength="100">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="editCreatAddress_5" class="col-sm-3 col-form-label">Localidad</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="editCreatAddress_5" name="editCreatAddress_5" placeholder="" maxlength="100">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="editCreatAddress_6" class="col-sm-3 col-form-label">Referencia</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="editCreatAddress_6" name="editCreatAddress_6" placeholder="" maxlength="150">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_select_six" class="col-sm-3 col-form-label">Paises<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="edit_select_six" name="edit_select_six" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($countries as $countries_data)
                      <option value="{{ $countries_data->id }}"> {{ $countries_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_select_seven" class="col-sm-3 col-form-label">Estados<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="edit_select_seven" name="edit_select_seven" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($states as $states_data)
                      <option value="{{ $states_data->id }}"> {{ $states_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="edit_select_eight" class="col-sm-3 col-form-label">Ciudades<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="edit_select_eight" name="edit_select_eight" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($cities as $cities_data)
                      <option value="{{ $cities_data->id }}"> {{ $cities_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
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
          <p class="mt-2 card-title">Esta sección nos permite gestionar los clientes, que podremos utilizar en nuestro proyecto.</p>
          <div class="d-flex justify-content-center pt-3"></div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="table_customers" name='table_customers' class="table table-striped border display nowrap compact-tab" style="width:100%; font-size: 10px;">
                  <thead class="bg-primary">
                    <tr>
                      <th>Nombre</th>
                      <th>RFC</th>
                      <th>Correo electrónico</th>
                      <th>Teléfono</th>
                      <th>País</th>
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
  @if( auth()->user()->can('View customers') )
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <script src="{{ asset('js/admin/sales/customers.js')}}"></script>

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
