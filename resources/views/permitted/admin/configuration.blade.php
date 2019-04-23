@extends('layouts.admin')

@section('contentheader_title')
  {{ trans('header.configuration') }}
@endsection

@section('breadcrumb_title')
  {{ trans('breadcrumb.configuration') }}
@endsection

@section('content')
  @if( auth()->user()->can('View Configuration') )
    <!-- Crear -->
    <div id="modal-CreatUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaluserbyrole" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modaluserbyrole">{{ trans('message.creatusers') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <div class="row">
              @if( auth()->user()->can('Create user') )
              <div class="col-12">
                <form id="creatusersystem" name="creatusersystem" class="forms-sample" action="">
                  {{ csrf_field() }}
                  <div class="form-group row">
                    <label for="inputCreatName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputCreatEmail" class="col-sm-3 col-form-label">{{ trans('auth.email') }}<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control form-control-sm required" id="inputCreatEmail" name="inputCreatEmail" placeholder="{{ trans('auth.email') }}" maxlength="60" title="{{ trans('message.maxcarname')}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputCreatLocation" class="col-sm-3 col-form-label">{{ trans('auth.location')}}<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required"  id="inputCreatLocation" name="inputCreatLocation"  placeholder="{{ trans('auth.location') }}" maxlength="50">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="selectCreatRole" class="col-sm-3 col-form-label">{{ trans('message.role') }}<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <select  id="selectCreatRole" name="selectCreatRole" class="form-control form-control-sm required">
                        <option value="">{{ trans('message.selectopt') }}</option>
                        @forelse ($roles as $id => $name)
                        <option value="{{ $id }}"> {{ $name }} </option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  @if( auth()->user()->can('Create user') )
                  <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  @endif
                  <button type="button" class="btn btn-danger waves-effect form_creat_user" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </form>
              </div>
              @else
              <div class="col-12">
                @include('default.deniedmodule')
              </div>
              @endif
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

    <!-- Editar -->
    <div id="modal-editUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditUser" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modaleditUser">{{ trans('message.editusers') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <div class="row">
              @if( auth()->user()->can('Edit user') )
              <div class="col-12">
                <form id="editusersystem" name="editusersystem" class="forms-sample" action="">
                  {{ csrf_field() }}
                  <input id='id_recibido' name='id_recibido' type="hidden" class="form-control" placeholder="">
                  <div class="form-group row">
                    <label for="inputEditName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required" id="inputEditName" name="inputEditName" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEditEmail" class="col-sm-3 col-form-label">{{ trans('auth.email') }}<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control form-control-sm" id="inputEditEmail" name="inputEditEmail" placeholder="{{ trans('auth.email') }}" maxlength="60" title="{{ trans('message.maxcarname')}}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inpuEditlocation" class="col-sm-3 col-form-label">{{ trans('auth.location')}}<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required"  id="inpuEditlocation" name="inpuEditlocation"  placeholder="{{ trans('auth.location') }}" maxlength="50">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="selectEditPriv" class="col-sm-3 col-form-label">{{ trans('message.role') }}<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <select  id="selectEditPriv" name="selectEditPriv" class="form-control form-control-sm required">
                        <option value="">{{ trans('message.selectopt') }}</option>
                        @forelse ($roles as $id => $name)
                          <option value="{{ $id }}"> {{ $name }} </option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  @if( auth()->user()->can('Edit user') )
                  <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  @endif
                  <button type="button" class="btn btn-danger waves-effect form_edit_user" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </form>
                <div id="editinfogenerad" class="card  card-hover hidden">
                  <div class="card-header bg-danger">
                    <h4 class="mb-0 text-white">Usuario Inactivo!</h4>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title">Información.!</h3>
                    <p class="card-text"> Apartado no disponible!.</p>
                  </div>
                </div>
              </div>
              @else
              <div class="col-xs-12">
                @include('default.deniedmodule')
              </div>
              @endif
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

    <div id="modal-menu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalmenu" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modalmenu">{{ trans('message.confMenu') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <div class="row">
              @if( auth()->user()->can('View Configuration') )
              <div id="menusgenerad" class="col-12">
                <form id="editusersystem_all" name="editusersystem_all" class="forms-sample" action="">
                  <input id='id_recibido_xd' name='id_recibido_xd' type="hidden" class="form-control" placeholder="" readonly>
                  {{ csrf_field() }}
                  @forelse ($sectionpermit as $section)
                    @php ( $iteration = $loop->iteration )
                    <div id="accordion_{{$iteration}}" role="tablist" class="card card-hover">
                      <div class="card-header bg-primary">
                        <h6 class="mb-0">
                          <a data-toggle="collapse" href="#{{ $section->sections_display_name }}" aria-expanded="true" aria-controls="collapseOne" class="mb-0 auth-link text-white" style="text-decoration: none;">
                            {{ $section->sections_display_name }} #{{$iteration}}
                          </a>
                        </h6>
                      </div>
                      <div id="{{ $section->sections_display_name }}" role="tabpanel" aria-labelledby="headingOne" class="card-body collapse">
                        @forelse ($msect_2 as $menu_new)
                          @if( $section->section_id == $menu_new->section_id )
                          <ul class="list-unstyled">
                            <li>
                              <div class="form-check mb-3">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" id="{{ $menu_new->menu_id }}" name="menu[]" value="{{ $menu_new->menu_id }}">
                                  Menu - {{ $menu_new->menu_display_name }}
                                </label>
                              </div>
                              <ul class="ml-3 list-unstyled">
                                @forelse ($union as $submenu)
                                @if( $submenu->menu_id ==  $menu_new->menu_id )
                                <li>
                                  <div class="form-check mb-3">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="checkbox" id="{{ $submenu->permission_id }}" name="permissions[]" value="{{ $submenu->name }}">
                                      {{ $submenu->name }}
                                    </label>
                                  </div>
                                </li>
                                @endif
                                @empty
                                @endforelse
                              </ul>
                            </li>
                          </ul>
                          @endif
                        @empty
                        @endforelse
                      </div>
                    </div>
                  @empty
                  @endforelse
                  @php ( $iteration1 = $iteration+1 )
                  <div id="accordion_{{$iteration1}}" role="tablist" class="card card-hover">
                    <div class="card-header bg-primary">
                      <h6 class="mb-0">
                        <a data-toggle="collapse" href="#tabextra" aria-expanded="true" aria-controls="collapseOne" class="mb-0 auth-link text-white" style="text-decoration: none;">
                          Extra #{{$iteration1}}
                        </a>
                      </h6>
                    </div>
                    <div id="tabextra" role="tabpanel" aria-labelledby="headingOne" class="card-body collapse">
                      <ul class="list-unstyled">
                        @forelse ($permisosdesarrollo as $submenudesarrollo)
                          <li>
                            <div class="form-check">
                              <label class="form-check-label mb-3">
                                <input class="form-check-input" type="checkbox" id="{{ $submenudesarrollo->id }}" name="permissions[]" value="{{ $submenudesarrollo->permissions }}">
                                {{ $submenudesarrollo->permissions }}
                              </label>
                            </div>
                          </li>
                        @empty
                        @endforelse
                      </ul>
                    </div>
                  </div>

                  <!----------------------------------------------------------------------------------------------------------->
                  <button type="button" class="btn btn-navy update_user_data_privile"><i class="fas fa-pencil-alt" style="margin-right: 4px;"></i>{{ trans('message.actualizar') }}</button>
                  <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </form>
              </div>

              <div id="infogenerad" class="col-md-12 hidden">
                  <div class="card  card-hover">
                    <div class="card-header bg-danger">
                      <h4 class="mb-0 text-white">Usuario Inactivo!</h4>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Información.!</h3>
                        <p class="card-text"> Apartado no disponible!.</p>
                    </div>
                  </div>
              </div>


              @else
              <div class="col-xs-12">
                @include('default.deniedmodule')
              </div>
              @endif
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
            <p class="card-title">Configuración - Usuario </p>
            <p class="mb-4">Para comenzar esta sección nos permite gestionar la configuración de los usuarios.</p>
            <div class="d-flex justify-content-center pt-3">

            </div>
            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table id="example_conf_user" name='example_conf_user' class="table table-striped border display nowrap" style="width:100%; font-size: 10px;">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Localización</th>
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
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <script src="{{ asset('js/admin/configuration.js')}}"></script>
    <style media="screen">
      #example_conf_user  th { font-size:  12px !important }
      #example_conf_user  td { font-size:  12px !important }
      #example_conf_user  button { font-size:  12px !important }
      #example_conf_user  tbody { font-size:  12px !important }
      #example_conf_user  a { font-size:  10px !important }
      #example_conf_user  fas { font-size:  10px !important }
      #example_conf_user  span { font-size:  10px !important }
      .pac-container {  z-index: 1051 !important;  }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7LGUHYSQjKM4liXutm2VilsVK-svO1XA&libraries=places"></script>
    <script type="text/javascript">
      function initialize() {
        var options = {
            types: ['(cities)'],
            componentRestrictions: {country: "mx"}
          };
          if (document.getElementById("inpuEditlocation")) {
            var input = document.getElementById('inpuEditlocation');
            var autocomplete = new google.maps.places.Autocomplete(input, options);
          }
          if (document.getElementById("inputCreatLocation")) {
            var input_two = document.getElementById('inputCreatLocation');
            var autocomplete_two = new google.maps.places.Autocomplete(input_two, options);
          }
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@endpush
