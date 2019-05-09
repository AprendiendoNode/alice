@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.unit_measures') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.unit_measures') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('content')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  {{-- @else --}}
  <!-- Crear -->
  <div id="modal-CreatNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalunitmeasure" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalunitmeasure">Crear unidad de medida</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="creatunitmeasure" name="creatunitmeasure" class="forms-sample" action="">
                {{ csrf_field() }}
                <div class="form-group row">
                  <label for="inputCreatCode" class="col-sm-3 col-form-label">Clave <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatCode" name="inputCreatCode" placeholder="Clave" maxlength="4">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatOrden" class="col-sm-3 col-form-label">Orden<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required onlynumber" id="inputCreatOrden" name="inputCreatOrden" placeholder="Orden de visualización" value="0" maxlength="3">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="status" class="col-sm-3 control-label">Estatus</label>
                  <div class="col-md-9">
                      <label>
                          <input class="js-switch" name="status" type="checkbox" value="1" id="status" checked>
                      </label>
                      <span class="check-change js-check-change-field2 ml-2 mt-1"></span>
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

  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <p class="mt-2 card-title">Esta sección nos permite gestionar las unidades de medidas, que podremos utilizar en nuestro proyecto.</p>
          <strong>Nota:</strong>
          <span class="text_content">Si necesitas añadir una nueva unidad de medida, debes de consultar el siguiente hipervínculo del sat, para obtener la informacion correcta antes de registrarla en el sistema.</span>
          <a href="http://200.57.3.89/PyS/catUnidades.aspx" target="_blank">Catálogo de Unidades de Medida (SAT)</a>

          <div class="d-flex justify-content-center pt-3"></div>

          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="table_unit_measures" name='table_unit_measures' class="table table-striped border display nowrap" style="width:100%; font-size: 10px;">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Clave</th>
                      <th>Orden</th>
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
  {{-- @endif --}}
@endsection

@push('scripts')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  <style media="screen">
    .text_content {
      font-size: 0.875rem;
      line-height: 1.5rem;
    }
  </style>

  <!-- FormValidation -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <link href="{{ asset('bower_components/switchery-master/dist/switchery.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/switchery-master/dist/switchery.js')}}" charset="utf-8"></script>

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <script src="{{ asset('js/admin/catalogs/unit_measures.js')}}"></script>

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

    // var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    // elems.forEach(function(html) {
    //   var switchery = new Switchery(html, defaults);
    // });
    $(document).ready(function() {
    if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, defaults);
        });
    }
});
  </script>
  {{-- @else --}}
  {{-- @endif  --}}
@endpush
