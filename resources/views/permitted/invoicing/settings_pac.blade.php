@extends('layouts.admin')

@section('contentheader_title')
  {{ trans('invoicing.settings_pac') }}
@endsection

@section('breadcrumb_title')
  {{ trans('invoicing.settings_pac') }}
@endsection

@section('content')
<div class="modal fade" id="userbyrole"  tabindex="-1" role="dialog" aria-labelledby="modaluserbyrole" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modaluserbyrole">Nuevo PAC</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <form id="creatnewpac" name="creatnewpac" class="forms-sample" action="">
              {{ csrf_field() }}
              <div class="form-group row">
                  <label for="name" class="col-md-4 col-xs-12 col-form-label">Nombre de conexión <span class="text-danger">*</span></label>
                  <div class="col-md-8 col-xs-12">
                      <input class="form-control form-control-sm required" placeholder="Nombre de conexión" required autofocus name="name" type="text" id="name">
                  </div>
              </div>

              <div class="form-group row">
                  <label for="code" class="col-md-4 col-xs-12 col-form-label">Nomb. del proveedor<span class="text-danger">*</span></label>
                  <div class="col-md-8 col-xs-12">
                      <input class="form-control form-control-sm required" placeholder="Nombre del proveedor" required autofocus name="code" type="text" id="code">
                  </div>
              </div>

              <div class="form-group row">
                  <label for="ws_url" class="col-md-4 col-xs-12 col-form-label">URL Web Service <span class="text-danger">*</span></label>
                  <div class="col-md-8 col-xs-12">
                      <input class="form-control form-control-sm required" placeholder="URL Web Service o URL Timbrar" required autofocus name="ws_url" type="text" id="ws_url">
                  </div>
              </div>
              <div class="form-group row">
                  <label for="ws_url_cancel" class="col-md-4 col-xs-12 col-form-label">URL Cancelación </label>
                  <div class="col-md-8 col-xs-12">
                      <input class="form-control form-control-sm" placeholder="URL Web Service Cancelación o URL Cancelar" name="ws_url_cancel" type="text" id="ws_url_cancel">
                  </div>
              </div>
              <div class="form-group row">
                  <label for="username" class="col-md-4 col-xs-12 col-form-label">Usuario<span class="text-danger">*</span></label>
                  <div class="col-md-8 col-xs-12">
                      <input class="form-control form-control-sm required" placeholder="Usuario" required autofocus name="username" type="text" id="username">
                  </div>
              </div>
              <div class="form-group row">
                  <label for="password" class="col-md-4 col-xs-12 col-form-label">Contraseña<span class="text-danger">*</span></label>
                  <div class="col-md-8 col-xs-12">
                      <input class="form-control form-control-sm required" placeholder="Contraseña" required autofocus name="password" type="password" id="password">
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-6 col-xs-12">
                    <!--------------------------------------------------------------------------->
                    <div class="form-group form-group-sm">
                        <label for="test" class="col-md-3 col-xs-12 control-label">Pruebas</label>
                        <div class="col-md-12 col-xs-12">
                            <label>
                                <input class="js-switch" name="test" type="checkbox" value="1" id="test">
                            </label>
                            <span class="check-change js-check-change-field1 ml-2 mt-1"></span>
                        </div>
                    </div>
                    <!--------------------------------------------------------------------------->
                  </div>
                  <div class="col-md-6 col-xs-12">
                    <!--------------------------------------------------------------------------->
                    <div class="form-group form-group-sm">
                        <label for="status" class="col-md-3 col-xs-12 control-label">Estatus</label>
                        <div class="col-md-12 col-xs-12">
                            <label>
                                <input class="js-switch" name="status" type="checkbox" value="1" id="status">
                            </label>
                            <span class="check-change js-check-change-field2 ml-2 mt-1"></span>
                        </div>
                    </div>
                    <!--------------------------------------------------------------------------->
                  </div>
              </div>
              <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
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
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <p class="card-title">{{ trans('invoicing.pac') }}</p>
        <div class="table-responsive">
          <form name="generate_graph1" class="form-inline">
            <div class="input-group mb-2 mr-sm-2">
              <button type="button" class="btn btn-danger btn-lg text-white pac" data-toggle="modal" data-target="#userbyrole"> <i class="fas fa-shipping-fast" style="margin-right: 4px;"></i> <strong>Nuevo</strong> </button>            
            </div>
          </form>
          <div class="table-responsive">
            <table id="all_registered_pac" name='all_registered_pac' class="table">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Proveedor</th>
                <th>URL Web Service</th>
                <th>Usuario</th>
                <th>Prueba</th>
                <th>Prioridad</th>
                <th>Acciones</th>
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

@endsection

@push('scripts')
<!-- FormValidation -->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
<script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
<script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

<link href="{{ asset('bower_components/switchery-master/dist/switchery.css')}}" rel="stylesheet" type="text/css">
<script src="{{ asset('bower_components/switchery-master/dist/switchery.js')}}" charset="utf-8"></script>

<script src="{{ asset('js/invoicing/settingpac.js')}}" charset="utf-8"></script>
<script type="text/javascript">
  var defaults = {
    color             : '#3FB5F3',
    secondaryColor    : '#dfdfdf',
    jackColor         : '#fff',
    jackSecondaryColor: null,
    className         : 'switchery',
    disabled          : true,
    disabledOpacity   : 0.5,
    speed             : '0.1s',
    size              : 'default',
  }
  // var elem = document.querySelector('.js-switch'),
  // changeField = document.querySelector('.js-check-change-field');
  // var init = new Switchery(elem, defaults);
  // elem.onchange = function() {
  //   changeField.innerHTML = elem.checked;
  // };

  var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
  elems.forEach(function(html) {
    var switchery = new Switchery(html, defaults);
  });

  var test = document.querySelector('#test'),
      changeFieldTest = document.querySelector('.js-check-change-field1');
      test.onchange = function() {
        // changeFieldTest.innerHTML = test.checked;
        if(test.checked) { changeFieldTest.innerHTML= 'Activo'; }
        else{ changeFieldTest.innerHTML= 'Inactivo'; }

      };

  var estado = document.querySelector('#status'),
      changeFieldStatus = document.querySelector('.js-check-change-field2');
      estado.onchange = function() {
        // changeFieldStatus.innerHTML = estado.checked;
        if(estado.checked) { changeFieldStatus.innerHTML= 'Activo'; }
        else{ changeFieldStatus.innerHTML= 'Inactivo'; }
      };

</script>
<style media="screen">
  .check-change {
    color: #686868;
    box-shadow: 0 0 0 3px rgba(104, 104, 104, 0.08);
    display: inline-block;
    height: 22px;
    text-align: center;
    vertical-align: middle;
    width: 80px;
  }
</style>
@endpush
