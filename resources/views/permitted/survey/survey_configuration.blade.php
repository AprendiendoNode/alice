@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View survey configuration') ) --}}
    Configuracion encuestas.
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View survey configuration') ) --}}
    Encuestas.
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('content')
    @if( auth()->user()->can('View survey configuration') )    

    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body dashboard-tabs p-0">
            <ul class="nav nav-tabs px-4" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><i class="fa fa-user-plus"></i> Añadir clientes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="assign-tab" data-toggle="tab" href="#assign" role="tab" aria-controls="assign" aria-selected="true"><i class="fa fa-handshake"></i> Asignar cliente-sitio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="view-tab" data-toggle="tab" href="#view" role="tab" aria-controls="view" aria-selected="true"><i class="fas fa-search"></i> Ver asignaciones</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="delete-tab" data-toggle="tab" href="#delete" role="tab" aria-controls="delete" aria-selected="true"><i class="fa fa-user-times"></i> Eliminar clientes</a>
              </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                  <div class="media">
                    <div class="media-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">
                          @if( auth()->user()->can('Create user nps') )                            
                          <div class="col-md-12">
                            <form id="creatusersystem" name="creatusersystem" class="form-horizontal" data-toggle="validator">
                              {{ csrf_field() }}
                              <div class="form-group">
                                <label>Nombre:<span style="color: red;">*</span></label>
                                <input maxlength="60" type="text" class="form-control" id="inputCreatName" name="inputCreatName" placeholder="Inserte un nombre" maxlength="60" title="" data-minlength="3" required data-error="Por favor ingrese al menos 3 caracteres"/>
                                <div class="help-block with-errors"></div>
                              </div>

                              <div class="form-group">
                                <label>Email:<span style="color: red;">*</span></label>
                                <input type="email" class="form-control" id="inputCreatEmail" name="inputCreatEmail" placeholder="Inserte un correo valido." maxlength="60" title="" required data-error="Por favor ingrese un correo valido.">
                                <div class="help-block with-errors"></div>
                              </div>

                              <div class="form-group">
                                <label>Ubicación:<span style="color: red;">*</span></label>
                                <input type="text" id="inputCreatLocation" name="inputCreatLocation" class="form-control"  placeholder=" Escriba una ubicación" maxlength="60" data-minlength="4" required data-error="Por favor ingrese al menos 4 caracteres">
                                <div class="help-block with-errors"></div>
                              </div>
                              <br>
                              <div class="form-group">
                                <div class="row">
                                  <div class="col-sm-12 text-center">
                                    <button class="btn btn-primary mr-2" type="submit" id="capture_cu"><i class="fa fa-plus-square"></i> {{ trans('message.create')}}</button>
                                    <a id="cancela_cu" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                                  </div>
                                </div>
                              </div>

                            </form>
                          </div>
                          @else
                            <div class="col-md-12">
                              @include('default.deniedmodule')
                            </div>
                          @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="assign" role="tabpanel" aria-labelledby="assign-tab">
                  <div class="media">
                    <div class="media-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">
                          @if( auth()->user()->can('View assign hotel user') )
                            <div class="col-md-12">
                              <form id="assign_hotel_client" name="assign_hotel_client" class="form-horizontal" data-toggle="validator">
                                {{ csrf_field() }}
                                <div class="form-group">
                                  <label>Clientes:<span style="color: red;">*</span></label>
                                  <select id="select_clients" name="select_clients"class="form-control select2" required>
                                    <option value="" selected> Elija </option>
                                    @forelse ($users as $data_users)
                                      <option value="{{ $data_users->id }}"> {{ $data_users->name }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                                  <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                  <label>Sitio:<span style="color: red;">*</span></label>
                                  <select multiple id="select_hotels" name="select_hotels[]" class="form-control" required>
                                    @forelse ($hotels as $data_hotel)
                                      <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                                  <div class="help-block with-errors"></div>
                                </div>

                                <br>
                                <div class="form-group">
                                  <div class="row">
                                    <div class="col-sm-12 text-center">
                                      <button id="capture_hc" type="submit" class="btn btn-primary mr-2" ><i class="fa fa-plus-square"></i> {{ trans('message.create')}}</button>
                                      <a id="cancela_hc" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                          @else
                            <div class="col-md-12">
                              @include('default.deniedmodule')
                            </div>
                          @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="view" role="tabpanel" aria-labelledby="view-tab">
                  <div class="media">
                    <div class="media-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">
                            @if( auth()->user()->can('View list assign hotel user') )
                              <div class="col-md-12">
                                <div class="table-responsive">
                                  <table id="see_venue_client" name='see_venue_client' class="display nowrap table table-bordered table-hover" width="100%" cellspacing="0">
                                    <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
                                    <thead>
                                      <tr class="bg-primary" style="background: #789F8A; font-size: 11.5px; ">
                                        <th> <small>Name User</small> </th>
                                        <th> <small>Venue</small> </th>
                                        <th> <small>Operación A</small> </th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            @else
                              <div class="col-xs-12">
                                @include('default.deniedmodule')
                              </div>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="delete" role="tabpanel" aria-labelledby="delete-tab">
                  <div class="media">
                    <div class="media-body">

                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">
                            @if( auth()->user()->can('View assign delete client') )
                           <div class="col-md-12">
                              <form id="delete_all_client" name="delete_all_client" class="form-horizontal" data-toggle="validator">
                                {{ csrf_field() }}
                                <div class="form-group">
                                  <label>Clientes:<span style="color: red;">*</span></label>
                                  <select id="delete_clients" name="delete_clients" class="form-control select2" required>
                                    <option value="" selected> Elija </option>
                                    @forelse ($users as $data_users)
                                      <option value="{{ $data_users->id }}"> {{ $data_users->name }} </option>
                                    @empty
                                    @endforelse
                                  </select>
                                  <div class="help-block with-errors"></div>
                                </div>
                                <br>
                                <div class="form-group">
                                  <div class="row">
                                    <div class="col-sm-12 text-center">
                                      <button id="capture_dc" type="submit" class="btn btn-primary mr-2" ><i class="fa fa-user-times"></i> {{ trans('message.eliminar')}}</button>
                                      <a id="cancela_dc" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                            @else
                              <div class="col-md-12">
                                @include('default.deniedmodule')
                              </div>
                            @endif
                                
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-header"><strong class="card-title">Creación de encuestas</strong></div>
          <div class="card-body">
            <div class="media">
              <div class="media-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      @if( auth()->user()->can('View config nps individual') )
                        <div class="col-md-12">
                          <form id="form_reg_survey" name="form_reg_survey" class="form-horizontal" data-toggle="validator">
                            {{ csrf_field() }}
                            <div class="form-group">
                             <label>{{ trans('message.vertical') }}<span style="color: red;">*</span></label>
                              <select id="select_ind_one" name="select_ind_one"class="form-control select2" required>
                                <option value="" selected>Elija...</option>
                                @forelse (  App\Vertical::select('id', 'name')->get(); as $verticals)
                                  <option value="{{ $verticals->id }}"> {{ $verticals->name }} </option>
                                @empty
                                @endforelse
                              </select>
                              <div class="help-block with-errors"></div>
                            </div>
                            
                            <div class="form-group">
                              <label>{{ trans('message.user') }}<span style="color: red;">*</span></label>
                              <select multiple id="select_ind_two" name="select_ind_two[]" class="form-control" required>
                              </select>
                              <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                              <label>{{ trans('message.periodactive')}}<span style="color: red;">*</span></label>
                              <div class="input-group input-daterange">
                                  <input name="date_start"  type="text" class="form-control" value="" required>
                                  <div class="input-group-addon">to</div>
                                  <input name="date_end"  type="text" class="form-control" value="" required>
                              </div>
                            </div>

                            <div class="form-group">
                              <label>Mes a evaluar:<span style="color: red;">*</span></label>
                              <input id="month_evaluate" name="month_evaluate"  type="text"  maxlength="10" placeholder="" class="form-control input-md" required>
                            </div>


                            <br>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-12 text-center">
                                  <button class="btn btn-primary mr-2" type="submit" id="capture"><i class="fa fa-bookmark"></i> {{ trans('message.create')}}</button>
                                  <a id="clear" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      @else
                        <div class="col-md-12">
                          @include('default.deniedmodule')
                        </div>
                      @endif
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-header"><strong class="card-title">Ver usuarios encuestados</strong></div>
          <div class="card-body">
            <div class="media">
              <div class="media-body">
                <div class="form-inline">
                    <div class="form-group">
                      <label for="calendar_fecha_nps" class="control-label">Buscar por mes:</label>
                      <input type="text" class="form-control datepickermonth" id="calendar_fecha_nps" placeholder="Example: 2019-12">
                    </div>
                    <div class="form-group">
                        <button type="button" id="btn_filter_nps" class="btn btn-info btngeneral"><i class="fa fa-bullseye margin-r5"></i> Filtrar</button>
                    </div>
                </div>
              </div>
            </div>
            <br>
            <div class="media">
              <div class="media-body">
                <div class="clearfix">
                  <div class="table-responsive">
                    <table id="example_survey" name='example_survey' class="display nowrap table table-bordered table-hover" width="100%" cellspacing="0">
                      <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
                      <thead>
                          <tr class="bg-primary" style="background: #789F8A; font-size: 11.5px; ">
                              <th> <small>Nombre</small> </th>
                              <th> <small>Email</small> </th>
                              <th> <small>Estatus</small> </th>
                              <th> <small>Estado</small> </th>
                              <th> <small>Fecha corresponde</small> </th>
                              <th> <small>Fecha inicio</small> </th>
                              <th> <small>Fecha fin</small> </th>
                              <th> <small>Operación A</small> </th>
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
    </div>

    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View survey configuration') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7LGUHYSQjKM4liXutm2VilsVK-svO1XA&libraries=places"></script>

    <script src="{{ asset('js/admin/surveys/survey_conf.js')}}"></script>

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
      #img_preview {
        margin-top: 20px;
        height: 30%;
        width: 30%;
      }
      #ads {
          margin: 20px 0 0 0;
      }
      #ads .card-notify-badge {
          position: absolute;
          left: 0px;
          top: -10px;
          background: #f2d900;
          text-align: center;
          border-radius: 30px 30px 30px 30px;
          color: #000;
          padding: 5px 20px;
          font-size: 14px;

      }
      #ads .card-detail-badge {
          background: #f2d900;
          text-align: center;
          border-radius: 30px 30px 30px 30px;
          color: #000;
          padding: 5px 10px;
          font-size: 14px;
      }
      .tab-content {
        border: 1px solid $border-color;
        border-top: 0;
        padding: 2rem 1.5rem;
        text-align: justify;
        &.tab-content-vertical {
          border-top: 1px solid $border-color;
        }
        &.tab-content-vertical-custom {
          border: 0;
          padding-top: 0;
        }
        &.tab-content-custom-pill {
          border: 0;
          padding-left: 0;
        }
      }
      .test_btm {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        padding-top: 1;
        display: block;
        height: calc(1.8em + 0.75rem);
        padding: 0.5rem 0.75rem;
        line-height: 1.5;
      }
    </style>
  @else
    <!--NO VER-->
  @endif
@endpush
