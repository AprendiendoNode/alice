@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View provider') )
    {{ trans('message.title_provider') }}
  @else
    {{ trans('message.title_provider') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View provider') )
    {{ trans('message.subtitle_search_provider') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View provider') )
    {{ trans('message.breadcrumb_search_provider') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View provider') )
    <div class="modal modal-default fade" id="add_provider" data-backdrop="static">
        <div class="modal-dialog" >
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>{{ trans('message.title_provider') }}</h4>
            </div>
            <div class="modal-body">
              <div class="card-body table-responsive">
                <div class="card-body">
                  <div class="row">
                  @if( auth()->user()->can('Create provider') )
                    <div class="col-xs-12">
                      <form id="reg_provider" name="reg_provider"  class="form-horizontal" action="">
                        {{ csrf_field() }}
                        <div class="input-group">
                          <span class="input-group-addon">RFC <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                          <input id="provider_rfc" name="provider_rfc" type="text" class="form-control" placeholder="RFC" maxlength="500" title=""/>
                        </div>
                        <br>

                        <div class="input-group">
                          <span class="input-group-addon">Razón social (Nombre) <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                          <input id="provider_name" name="provider_name"  type="text" class="form-control" placeholder="" >
                        </div>
                        <br>

                        <div class="row">
                          <div class="col-lg-6">
                            <div class="input-group">
                              <span class="input-group-addon">Régimen fiscal <i class="glyphicon glyphicon-asteris text-danger"></i></span>
                              <select id="provider_tf" name="provider_tf" class="form-control">
                                <option value="">Elija...</option>
                                <option value="1">Persona Fisica</option>
                                <option value="2">Persona Moral</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="input-group">
                              <span class="input-group-addon">Delegación o Municipio</span>
                              <input id="provider_municipality" name="provider_municipality"  type="text" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>

                        <br>
                        <div class="input-group">
                          <span class="input-group-addon">Dirección <i class="glyphicon glyphicon-asteris text-danger"></i></span>
                          <input id="provider_address" name="provider_address"  type="text" class="form-control" placeholder="">
                        </div>
                        <br>

                        <div class="row">
                          <div class="col-lg-6">
                            <div class="input-group">
                              <span class="input-group-addon">Estado <i class="glyphicon glyphicon-asteris text-danger"></i></span>
                              <input id="provider_estate" name="provider_estate"  type="text" class="form-control" placeholder="">
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="input-group">
                              <span class="input-group-addon">País</span>
                              <input id="provider_country" name="provider_country"  type="text" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>
                        <br>

                        <div class="row">
                          <div class="col-lg-6">
                            <div class="input-group">
                              <span class="input-group-addon">C.P <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                              <input id="provider_postcode" name="provider_postcode"  type="text" class="form-control" placeholder="">
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="input-group">
                              <span class="input-group-addon">Telefono</span>
                              <input id="provider_phone" name="provider_phone"  type="text" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>
                        <br>

                        <div class="row">
                          <div class="col-lg-6">
                            <div class="input-group">
                              <span class="input-group-addon">Fax</span>
                              <input id="provider_fax" name="provider_fax"  type="text" class="form-control" placeholder="">
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="input-group">
                              <span class="input-group-addon">Email</span>
                              <input id="provider_email" name="provider_email"  type="text" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>
                        <h4>Datos del agente o contacto</h4>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="input-group">
                              <span class="input-group-addon">Nombre</span>
                              <input id="agent_name" name="agent_name" type="text" class="form-control" placeholder="">
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="input-group">
                              <span class="input-group-addon">Telefono</span>
                              <input id="agent_phone" name="agent_phone" type="text" class="form-control" placeholder="">
                            </div>
                          </div>
                        </div>
                      </form>
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
            <div class="modal-footer">
              @if( auth()->user()->can('Create provider') )
                <button type="button" class="btn bg-navy create_provider"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button>
              @endif
              <button type="button" class="btn btn-danger delete_provider" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal modal-default fade" id="edit_provider" data-backdrop="static">
        <div class="modal-dialog" >
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>{{ trans('message.edit') }}</h4>
            </div>
            <div class="modal-body">
              <div class="card-body table-responsive">
                <div class="card-body">
                  <div class="row">
                    @if( auth()->user()->can('Edit provider') )
                    <div class="col-xs-12">
                        <form id="ed_provider" name="ed_provider" action="">
                          {{ csrf_field() }}
                           <input id='rec_provider' name='rec_provider' type="hidden" class="form-control" placeholder="">
                           <div class="input-group">
                             <span class="input-group-addon">RFC <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                             <input name="provider_rfc1" id="provider_rfc1" type="text" class="form-control" placeholder="RFC">
                           </div>
                           <br>

                           <div class="input-group">
                             <span class="input-group-addon">Razón social (Nombre) <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                             <input name="provider_name1" id="provider_name1" type="text" class="form-control" placeholder="">
                           </div>
                           <br>

                           <div class="row">
                             <div class="col-lg-6">
                               <div class="input-group">
                                 <span class="input-group-addon">Tipo fiscal<i class="glyphicon glyphicon-asteris text-danger"></i></span>
                                  <select id="provider_tf" name="provider_tf" class="form-control">
                                    <option value="">Elija...</option>
                                    <option value="1">Persona Fisica</option>
                                    <option value="2">Persona Moral</option>
                                  </select>
                               </div>
                             </div>
                             <div class="col-lg-6">
                               <div class="input-group">
                                 <span class="input-group-addon">Delegación o Municipio</span>
                                 <input name="provider_municipality1" id="provider_municipality1" type="text" class="form-control" placeholder="">
                               </div>
                             </div>
                           </div>

                           <br>
                           <div class="input-group">
                             <span class="input-group-addon">Dirección <i class="glyphicon glyphicon-asteris text-danger"></i></span>
                             <input name="provider_address1" id="provider_address1" type="text" class="form-control" placeholder="">
                           </div>
                           <br>

                           <div class="row">
                             <div class="col-lg-6">
                               <div class="input-group">
                                 <span class="input-group-addon">Estado <i class="glyphicon glyphicon-asteris text-danger"></i></span>
                                 <input name="provider_estate1" id="provider_estate1" type="text" class="form-control" placeholder="">
                               </div>
                             </div>
                             <div class="col-lg-6">
                               <div class="input-group">
                                 <span class="input-group-addon">País <i class="glyphicon glyphicon-asteris text-danger"></i></span>
                                 <input name="provider_country1" id="provider_country1" type="text" class="form-control" placeholder="">
                               </div>
                             </div>
                           </div>
                           <br>

                           <div class="row">
                             <div class="col-lg-6">
                               <div class="input-group">
                                 <span class="input-group-addon">C.P <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                                 <input name="provider_postcode1" id="provider_postcode1" type="text" class="form-control" placeholder="">
                               </div>
                             </div>
                             <div class="col-lg-6">
                               <div class="input-group">
                                 <span class="input-group-addon">Telefono</span>
                                 <input name="provider_phone1" id="provider_phone1" type="text" class="form-control" placeholder="">
                               </div>
                             </div>
                           </div>
                           <br>

                           <div class="row">
                             <div class="col-lg-6">
                               <div class="input-group">
                                 <span class="input-group-addon">Fax</span>
                                 <input name="provider_fax1" id="provider_fax1" type="text" class="form-control" placeholder="">
                               </div>
                             </div>
                             <div class="col-lg-6">
                               <div class="input-group">
                                 <span class="input-group-addon">Email</span>
                                 <input name="provider_email1" id="provider_email1"  type="text" class="form-control" placeholder="">
                               </div>
                             </div>
                           </div>
                           <h4>Datos del agente o contacto</h4>
                           <div class="row">
                             <div class="col-lg-6">
                               <div class="input-group">
                                 <span class="input-group-addon">Nombre</span>
                                 <input name="agent_name1" id="agent_name1" type="text" class="form-control" placeholder="">
                               </div>
                             </div>
                             <div class="col-lg-6">
                               <div class="input-group">
                                 <span class="input-group-addon">Telefono</span>
                                 <input name="agent_phone1" id="agent_phone1" type="text" class="form-control" placeholder="">
                               </div>
                             </div>
                           </div>
                        </form>
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
            <div class="modal-footer">
              @if( auth()->user()->can('Edit provider') )
                <button type="button" class="btn bg-navy update_data"><i class="fas fa-pencil-alt" style="margin-right: 4px;"></i>{{ trans('message.actualizar') }}</button>
              @endif
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal modal-default fade" id="del_provider" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-bookmark" style="margin-right: 4px;"></i>{{ trans('message.confirmacion') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card-body table-responsive">
              <div class="card-body">
                <div class="row">
                  <div class="col-xs-12">
                    @if( auth()->user()->can('Delete provider') )
                    <form id="deleteprovidersystem" name="deleteprovidersystem" action="">
                      {{ csrf_field() }}
                      <input id='recibidoconf' name='recibidoconf' type="hidden" class="form-control" placeholder="">
                      <h4 style="font-weight: bold;">{{ trans('message.preguntaconf') }}</h4>
                    </form>
                    @else
                        @include('default.deniedmodule')
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            @if( auth()->user()->can('Delete provider') )
              <button type="button" class="btn btn-danger btndelete"><i class="fas fa-trash-alt" style="margin-right: 4px;"></i>{{ trans('message.eliminar') }}</button>
            @endif
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>

          </div>
        </div>
      </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <div class="card">
                <div class="card-body">
                  <div class="pull-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_provider">
                      <i class="fa fa-plus-square margin-r5"></i> Nuevo Registro
                    </button>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      </br>
                      <div class="table-responsive">
                        <table class="table" id="table_providers" name='table_providers' class="hover" width="100%" cellspacing="0">
                          <thead class="cabecera">
                              <tr>
                                  <th> <small>Nombre</small> </th>
                                  <th> <small>Razón Social</small> </th>
                                  <th> <small>Dirección</small> </th>
                                  <th> <small>Opciones</small> </th>
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
  @if( auth()->user()->can('View provider') )

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/admin/equipment/provider.js')}}"></script>
 <!--    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/sweetalert-master/dist/sweetalert.min.js') }}"></script> -->


  @else
    <!--NO VER-->
  @endif
@endpush
