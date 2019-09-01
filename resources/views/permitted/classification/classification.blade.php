@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('personnel_classification') )
  {{ trans('header.classification') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('personnel_classification') )

  {{ trans('breadcrumb.classification') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('personnel_classification') )
<div class="row">
  <div class="col-12 mb-3">
    <div class="card  card-hover">
        <div class="card-header bg-info">
            <h4 class="mb-0 text-white ">Puestos de trabajo</h4>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <form id="created_position" name="created_position" class="forms-sample" action="">
                  {{ csrf_field() }}
                  <p class="mb-2 font-weight-bold">Crea un puesto de trabajo.</p>
                  <div class="form-group row">
                    <label for="inputnameposition" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required" id="inputnameposition" name="inputnameposition" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  <button type="button" class="btn btn-danger reset_position"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </form>
              </div>
              <div class="col-md-6 mb-3">
                <div class="table-responsive">
                  <table id="all_workstation" class="table table-striped border display nowrap" style="width:100%">
                    <thead>
                      <tr>
                        <th>Nombre</th>
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
            <hr>
        </div>
    </div>
  </div>
  <!-- Editar Workstation-->
  <div id="modal-Edit-Workstation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditwork" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaleditwork">Editar puesto de trabajo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="editwork" name="editwork" class="forms-sample" action="">
                {{ csrf_field() }}
                <input class="form-control" type="hidden" placeholder="" id="token_b" name="token_b" value="">

                <div class="form-group row">
                  <label for="inputEditName" class="col-sm-3 col-form-label">Nombre<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditName" name="inputEditName" placeholder="Nombre">
                  </div>
                </div>

                <button type="submit" class="btn btn-navy"><i class="fas fa-check" style="margin-right: 4px;"></i> {{ trans('message.editar') }}</button>
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
  <div class="col-12 mb-3">
    <div class="card  card-hover">
        <div class="card-header bg-primary">
            <h4 class="mb-0 text-white">Usuario - Puesto de trabajo</h4></div>
        <div class="card-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <form id="created_position_user" name="created_position_user" class="forms-sample" action="">
                  {{ csrf_field() }}
                  <p class="mb-2 font-weight-bold">Asignación de jefes directos.</p>
                  <div class="form-group row">
                    <label for="selectposition" class="col-sm-3 col-form-label">Puesto de trabajo<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <select  id="selectposition" name="selectposition" class="form-control form-control-sm required">
                        <option value="">{{ trans('message.selectopt') }}</option>
                        @forelse ($workstations as $workstations_data)
                        <option value="{{ $workstations_data->id }}"> {{ $workstations_data->name }} </option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="selectuserposition" class="col-sm-3 col-form-label">Usuario<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <select  id="selectuserposition" name="selectuserposition" class="form-control form-control-sm required">
                        <option value="">{{ trans('message.selectopt') }}</option>
                        @forelse ($user as $user_data)
                        <option value="{{ $user_data->id }}"> {{ $user_data->name }} </option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputdateposition" class="col-sm-3 col-form-label">Inicio de actividades <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm datepicker required" id="inputdateposition" name="inputdateposition" placeholder="Inicio de actividades" maxlength="10">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  <button type="button" class="btn btn-danger reset_position_user"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </form>
              </div>
              <div class="col-md-6 mb-3">
                <div class="table-responsive">
                  <table id="all_position_user" class="table table-striped border display nowrap" style="width:100%">
                    <thead>
                      <tr>
                        <th>Usuario</th>
                        <th>Puesto</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
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
            <hr>
        </div>
    </div>
  </div>
  <!-- Editar Usuario - puesto trabajo-->
  <div id="modal-Edit-User-Puesto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaledituserpuesto" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaledituserpuesto">Editar Usuario - Puesto de trabajo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="edit_position_user" name="edit_position_user" class="forms-sample" action="">
                {{ csrf_field() }}
                <input class="form-control" type="hidden" placeholder="" id="token_e" name="token_e" value="">
                <div class="form-group row">
                  <label for="selectpositionEdit" class="col-sm-3 col-form-label">Puesto de trabajo<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="selectpositionEdit" name="selectpositionEdit" class="form-control form-control-sm required">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($workstations as $workstations_data)
                      <option value="{{ $workstations_data->id }}"> {{ $workstations_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="selectuserpositionEdit" class="col-sm-3 col-form-label">Usuario<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="selectuserpositionEdit" name="selectuserpositionEdit" class="form-control form-control-sm required">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($user as $user_data)
                      <option value="{{ $user_data->id }}"> {{ $user_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputdatepositionEdit" class="col-sm-3 col-form-label">Inicio de actividades <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm datepicker required" id="inputdatepositionEdit" name="inputdatepositionEdit" placeholder="Inicio de actividades" maxlength="10">
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="fas fa-check" style="margin-right: 4px;"></i> {{ trans('message.edit') }}</button>
                <button type="button" class="btn btn-danger reset_workstation_user" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 mb-3">
    <div class="card  card-hover">
        <div class="card-header bg-danger">
            <h4 class="mb-0 text-white">Departamentos</h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <form id="created_departament" name="created_departament" class="forms-sample" action="">
                {{ csrf_field() }}
                <p class="mb-2 font-weight-bold">Crea un departamento.</p>
                <div class="form-group row">
                  <label for="inputnamedepartament" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputnamedepartament" name="inputnamedepartament" placeholder="{{ trans('auth.nombre') }} del departamento" maxlength="60">
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                <button type="button" class="btn btn-danger reset_departament"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
            <div class="col-md-6 mb-3">
              <div class="table-responsive">
                <table id="all_department" class="table table-striped border display nowrap" style="width:100%">
                  <thead>
                    <tr>
                      <th>Nombre</th>
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
          <hr>
        </div>
    </div>
  </div>
  <!-- Editar Departamento-->
  <div id="modal-Edit-Department" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditwork" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaleditwork">Editar departamento</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="editdepartment" name="editdepartment" class="forms-sample" action="">
                {{ csrf_field() }}
                <input class="form-control" type="hidden" placeholder="" id="token_c" name="token_c" value="">

                <div class="form-group row">
                  <label for="inputEditNameDep" class="col-sm-3 col-form-label">Nombre<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputEditNameDep" name="inputEditNameDep" placeholder="Nombre">
                  </div>
                </div>

                <button type="submit" class="btn btn-navy"><i class="fas fa-check" style="margin-right: 4px;"></i> {{ trans('message.editar') }}</button>
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
  <div class="col-12 mb-3">
    <div class="card  card-hover">
        <div class="card-header bg-secondary">
            <h4 class="mb-0 text-white">Usuarios - Departamento</h4></div>
        <div class="card-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <form id="created_user_departament" name="created_user_departament" class="forms-sample" action="">
                  {{ csrf_field() }}
                  <p class="mb-2 font-weight-bold">Asignación de usuarios a los departamentos.</p>
                  <div class="form-group row">
                    <label for="selectdepartament" class="col-sm-3 col-form-label">Departamento<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <select  id="selectdepartament" name="selectdepartament" class="form-control form-control-sm required">
                        <option value="">{{ trans('message.selectopt') }}</option>
                        @forelse ($departments as $departments_data)
                        <option value="{{ $departments_data->id }}"> {{ $departments_data->name }} </option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="selectuserdepartament" class="col-sm-3 col-form-label">Usuario<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <select  id="selectuserdepartament" name="selectuserdepartament" class="form-control form-control-sm required">
                        <option value="">{{ trans('message.selectopt') }}</option>
                        @forelse ($user as $user_data)
                        <option value="{{ $user_data->id }}"> {{ $user_data->name }} </option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  <button type="button" class="btn btn-danger reset_user_departament"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </form>
              </div>
              <div class="col-md-6 mb-3">
                <div class="table-responsive">
                  <table id="all_user_departament" class="table table-striped border display nowrap" style="width:100%">
                    <thead>
                      <tr>
                        <th>Departamento</th>
                        <th>Usuario</th>
                        <th>Opciones</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <hr>
        </div>
    </div>
  </div>

  <div class="col-12 mb-3">
    <div class="card  card-hover">
        <div class="card-header bg-success">
            <h4 class="mb-0 text-white">ITC - Cadena</h4></div>
        <div class="card-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <form id="created_master" name="created_master" class="forms-sample" action="">
                  {{ csrf_field() }}
                  <p class="mb-2 font-weight-bold">Asignación de ITC Maestro.</p>
                  <div class="form-group row">
                    <label for="selectcadena" class="col-sm-3 col-form-label">Cadena<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <select  id="selectcadena" name="selectcadena" class="form-control form-control-sm required">
                        <option value="">{{ trans('message.selectopt') }}</option>
                        @forelse ($cadena as $cadena_data)
                        <option value="{{ $cadena_data->id }}"> {{ $cadena_data->name }} </option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="selectusermaster" class="col-sm-3 col-form-label">Usuario<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <select  id="selectusermaster" name="selectusermaster" class="form-control form-control-sm required">
                        <option value="">{{ trans('message.selectopt') }}</option>
                        @forelse ($user as $user_data)
                        <option value="{{ $user_data->id }}"> {{ $user_data->name }} </option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  <button type="button" class="btn btn-danger reset_master"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </form>
              </div>
              <div class="col-md-6 mb-3">
                <div class="table-responsive">
                  <table id="all_master" class="table table-striped border display nowrap" style="width:100%">
                    <thead>
                      <tr>
                        <th>Cadena</th>
                        <th>Usuario</th>
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
            <hr>
            <p><strong>Editar:</strong> Nos permite Habilitar o Inhabilitar el registro</p>
            <p><strong>Eliminar:</strong> Destruye completamente el registro</p>
        </div>
    </div>
  </div>
  <!-- Editar itc master-->
  <div id="modal-Edit-Itc-Master" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaledititcmaster" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaledititcmaster">Editar ITC Junior</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="edit_itc_master" name="edit_itc_master" class="forms-sample" action="">
                {{ csrf_field() }}
                <input class="form-control" type="hidden" placeholder="" id="token_f" name="token_f" value="">
                <div class="form-group row">
                  <label for="selectcadenaEdit" class="col-sm-3 col-form-label">Hotel<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="selectcadenaEdit" name="selectcadenaEdit" class="form-control form-control-sm required">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($cadena as $cadena_data)
                      <option value="{{ $cadena_data->id }}"> {{ $cadena_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="selectUserMasterEdit" class="col-sm-3 col-form-label">Usuario<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="selectUserMasterEdit" name="selectUserMasterEdit" class="form-control form-control-sm required">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($user as $user_data)
                      <option value="{{ $user_data->id }}"> {{ $user_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="fas fa-check" style="margin-right: 4px;"></i> {{ trans('message.edit') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 mb-3">
    <div class="card  card-hover">
        <div class="card-header bg-warning">
            <h4 class="mb-0 text-white">ITC - Hotel</h4></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <form id="created_junior" name="created_junior" class="forms-sample" action="">
                {{ csrf_field() }}
                <p class="mb-2 font-weight-bold">Asignación de ITC Junior.</p>
                <div class="form-group row">
                  <label for="selecthotel" class="col-sm-3 col-form-label">Hotel<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="selecthotel" name="selecthotel" class="form-control form-control-sm required">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($hotel as $hotel_data)
                      <option value="{{ $hotel_data->id }}"> {{ $hotel_data->Nombre_hotel }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="selectuserjunior" class="col-sm-3 col-form-label">Usuario<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="selectuserjunior" name="selectuserjunior" class="form-control form-control-sm required">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($user as $user_data)
                      <option value="{{ $user_data->id }}"> {{ $user_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                <button type="button" class="btn btn-danger reset_junior"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
            <div class="col-md-6 mb-3">
              <div class="table-responsive">
                <table id="all_junior" class="table table-striped border display nowrap" style="width:100%">
                  <thead>
                    <tr>
                      <th>Hotel</th>
                      <th>Usuario</th>
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
          <hr>
          <p><strong>Editar:</strong> Nos permite Habilitar o Inhabilitar el registro</p>
          <p><strong>Eliminar:</strong> Destruye completamente el registro</p>
        </div>
    </div>
  </div>
  <!-- Editar itc junior-->
  <div id="modal-Edit-Itc-Junior" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaledititcjunior" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaledititcjunior">Editar ITC Junior</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="edit_itc_junior" name="edit_itc_junior" class="forms-sample" action="">
                {{ csrf_field() }}
                <input class="form-control" type="hidden" placeholder="" id="token_d" name="token_d" value="">
                <div class="form-group row">
                  <label for="selectHotelEdit" class="col-sm-3 col-form-label">Hotel<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="selectHotelEdit" name="selectHotelEdit" class="form-control form-control-sm required">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($hotel as $hotel_data)
                      <option value="{{ $hotel_data->id }}"> {{ $hotel_data->Nombre_hotel }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="selectUserJuniorEdit" class="col-sm-3 col-form-label">Usuario<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="selectUserJuniorEdit" name="selectUserJuniorEdit" class="form-control form-control-sm required">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($user as $user_data)
                      <option value="{{ $user_data->id }}"> {{ $user_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="fas fa-check" style="margin-right: 4px;"></i> {{ trans('message.edit') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
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
  @if( auth()->user()->can('personnel_classification') )
  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" type="text/css" />
  <script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
  <script src="{{ asset('bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js')}}"></script>

  <!-- FormValidation -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <script src="{{ asset('js/admin/classification.js')}}"></script>
  <script src="{{ asset('js/admin/pivot_classification_job.js')}}"></script>
  <script src="{{ asset('js/admin/pivot_classification_itc.js')}}"></script>

  <style media="screen">
    table th { font-size:  12px !important }
    table td { font-size:  12px !important }
    table button { font-size:  12px !important }
    table tbody { font-size:  12px !important }
    table a { font-size:  10px !important }
    table fas { font-size:  10px !important }
    table span { font-size:  10px !important }
    .pac-container {  z-index: 1051 !important;  }
  </style>
  @else
  @endif
@endpush
