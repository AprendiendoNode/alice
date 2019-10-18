@extends('layouts.admin')

@section('contentheader_title')
  {{ trans('message.profile') }}
@endsection

@section('breadcrumb_title')
  {{ trans('message.profile') }}
@endsection

@section('content')
<section class="content">
  <div class="row">
    <div class="col-md-4 col-xs-12">
      <div class="card">
        <div class="card-header bg-success">
          <h4 class="mb-0 text-white">Info!</h4>
        </div>
        <div class="card-body">
          <img src="{{ asset('/img/website/user.jpg') }}" class="mx-auto d-block rounded-circle"  alt="User Image" >
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item border-right-0 border-left-0">
              <b>Nombre:</b> <a class="float-right text-muted">{{ Auth::user()->name}}</a>
            </li>
            <li class="list-group-item border-right-0 border-left-0">
              <b>Email:</b> <a class="float-right text-muted"> {{ auth()->user()->email }}</a>
            </li>
            <li class="list-group-item border-right-0 border-left-0">
              <b>{{ trans('auth.privilegio') }}:</b> <a class="float-right text-muted"> {{ auth()->user()->roles->first()->name }} </a>
            </li>
            <li class="list-group-item border-right-0 border-left-0">
              <strong><i class="fa fa-map-marker"></i> {{ trans('auth.location') }}:</strong>
              <p class="text-muted float-right">{{ auth()->user()->city }}</p>
            </li>
            <li class="list-group-item border-right-0 border-left-0">
              <strong><i class="fa fa-list-alt"></i> {{ trans('auth.permisos') }}:</strong>
              <p class="text-muted">
                @if (auth()->user()->getAllPermissions()->count())
                  {{ auth()->user()->getAllPermissions()->pluck('name')->implode(', ') }}
                @else
                  Sin permisos asociados
                @endif
              </p>
            </li>
          </ul>
        </div>
      </div>

    </div>

    <div class="col-md-8 col-xs-12">
      <!-- Nav tabs -->
      <div class="card">
        <div class="card-body">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#settings" role="tab"><span class="hidden-sm-up">
                  <i class="fas fa-edit"></i></span> <span class="hidden-xs-down">{{ trans('auth.editar') }}</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#settings2" role="tab"><span class="hidden-sm-up">
                  <i class="fas fa-sync-alt"></i></span> <span class="hidden-xs-down">Actualizar Contraseña</span>
                </a>
              </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content tabcontent-border border">
              <div class="tab-pane active" id="settings" role="tabpanel">
                <div class="p-4">
                    <form class="form-horizontal formprofile" method="POST" action="/profile_up" accept-charset="UTF-8">
                      {{ csrf_field() }}
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">{{ trans('auth.nombre')}}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-sm required" id="inputName" name="inputName" placeholder="{{ trans('auth.nombre') }}" maxlength="60" value="{{ old('name')}}">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">{{ trans('auth.email') }}</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control form-control-sm" id="inputEmail" name="inputEmail" placeholder="{{ trans('auth.email') }}" value="{{ auth()->user()->email }}" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="city" class="col-sm-2 col-form-label">{{ trans('auth.location')}}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control form-control-sm required"  id="city" name="city"  placeholder="{{ trans('auth.location') }}" value="{{ old('city,  auth()->user()->city') }}">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="offset-2 col-sm-11">
                          <button type="button" class="btn btn-danger btneditprof"><i class="fas fa-pencil-alt"></i>Click Actualizar información</button>
                        </div>
                      </div>
                    </form>
                </div>
                <div class="p-4">
                    <form class="" action="" method="post">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="" class="col-form-label">Activar asistente</label>
                            </div>
                            <div class="col-sm-10 pt-3">
                                <input type="checkbox" id="act_asist" class="js-switch" name="" >
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row justify-content-center">
                  <div class="col-10 mx-auto">
                    <div class="alert alert-primary" role="alert">
                      <h4 class="alert-heading"><i class="fas fa-info"></i> Puntos que debe de tomar en cuenta!</h4>
                      <ol>
                        <li> La cantidad de caracteres de la contraseña debe de ser igual o mayor que 6. </li>
                        <li> La contraseña y la confirmación deben de ser iguales. </li>
                        <li> En caso que desee cambiar el nombre o la localizacion basta con llenar el campo deseado.</li>
                        <li> Para activar o desactivar el asistente de documentación haga clic en el interruptor.</li>
                      </ol>
                      <hr>
                      <p class="mb-0">Cuando sea necesario, asegúrese de leer estas instrucciones.</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane  p-4" id="settings2" role="tabpanel">
                <form class="form-horizontal formprofiletwo" method="POST" action="/profile_up_pass" accept-charset="UTF-8">
                  {{ csrf_field() }}
                  <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">{{ trans('auth.password') }} <span style="color: red;">*</span></label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control form-control-sm required" id="password" name="password" placeholder="{{ trans('auth.password') }}" maxlength="10">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-2 col-form-label">{{ trans('auth.retrypepassword') }}<span style="color: red;">*</span></label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control form-control-sm required" id="password_confirmation" name="password_confirmation" placeholder="{{ trans('auth.retrypepassword') }}" maxlength="10">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="offset-2 col-sm-10">
                      <button type="button" class="btn btn-danger btneditprofpass"><i class="fa fa-key"></i>Click Actualizar Contraseña</button>
                    </div>
                  </div>
                </form>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8 col-xs-12">
      @if (session('status'))
          <div class="alert alert-success">
              {{ session('status') }}
          </div>
      @endif
    </div>

  </div>
</section>
@endsection


@push('scripts')
<style media="screen">
.toast {
opacity: 1 !important;
}

#toast-container > div {
opacity: 1 !important;
}
</style>
<script src="{{ asset('js/admin/profile.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7LGUHYSQjKM4liXutm2VilsVK-svO1XA&libraries=places"></script>
<link href="{{ asset('bower_components/switchery-master/dist/switchery.css')}}" rel="stylesheet" type="text/css">
<script src="{{ asset('bower_components/switchery-master/dist/switchery.js')}}" charset="utf-8"></script>
<script type="text/javascript">
    function initialize() {
        var options = {
            types: ['(cities)'],
            componentRestrictions: {country: "mx"}
        };
        var input = document.getElementById('city');
        var autocomplete = new google.maps.places.Autocomplete(input, options);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
//switch
function setSwitchery(switchElement, checkedBool) {
    if((checkedBool && !switchElement.isChecked()) || (!checkedBool && switchElement.isChecked())) {
        switchElement.setPosition(true);
        switchElement.handleOnchange(true);
    }
}

var defaults = {
color : '#15d640',
secondaryColor : '#fa3232',
jackColor : '#fff',
jackSecondaryColor: null,
className : 'switchery',
disabled : true,
disabledOpacity : 0.5,
speed : '0.1s',
size : 'default',
}



var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
var switchery;
elems.forEach(function(html) {
switchery = new Switchery(html, defaults);
});

var estado = {!! json_encode($estado, JSON_HEX_TAG) !!}; //Estado recuperado de la base de datos
//console.log(estado);
setSwitchery(switchery,estado);

$('#act_asist').on('change',function(){
//var switchAsit =('#act_asist');
//alert($('#act_asist').prop('checked'));
if($('#act_asist').prop('checked')==true){
//alert('activado');
var _token = $('input[name="_token"]').val();
$.ajax({
  type: "POST",
  url: '/activeassistant',
  data:{ _token: _token},
  success: function (data) {
    //console.log(data);
    Swal.fire({
    position: 'center',
    type: 'success',
    title: 'Asistente activado',
    showConfirmButton: false,
    timer: 1200
    }).then((result) => {
          location.reload();
  })
  },
  error: function (data) {
    console.log(data);
  }
});


}else{
//alert('desactivado');
var _token = $('input[name="_token"]').val();
$.ajax({
  type:"POST",
  url:"/disableassistant",
  data:{_token: _token},
  success: function(data){
    Swal.fire({
    position: 'center',
    type: 'warning',
    title: 'Asistente desactivado',
    showConfirmButton: false,
    timer: 1200
  }).then((result) => {
        location.reload();
})

  },
  error:function(data){
    console.log(data);
  }
});



}

})
</script>
@endpush
