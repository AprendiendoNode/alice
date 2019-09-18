@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('Create quoting') )
    Cotizador de proyectos
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('Create quoting') )
    Cotizador de proyectos
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')

  @if( auth()->user()->can('Create quoting') )
    <div class="container">
      <!-- Validation wizard -->
      <div class="row" id="validation">
          <div class="col-sm-12">
              <div class="white-box contrato_a">
                  <div class="wizard-content">
                      @include('permitted.quoting.form_create')
                  </div>
              </div>
            <!-- FIN FORMULARIO -->
          </div>
        </div>
    </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
  <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
  <script src="{{ asset('/plugins/momentupdate/moment-with-locales.js')}}"></script>
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <!-- FormValidation -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <!-- FormValidation plugin and the class supports validating Bootstrap form -->
  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.steps.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master-two/steps.css')}}" >
  <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >
  <!-- FormValidation plugin and the class supports validating Bootstrap form -->
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>
  <link type="text/css" href="css/bootstrap-editable.css" rel="stylesheet" />
  <script src="{{ asset('js/bootstrap-editable.js')}}"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >
  <script type="text/javascript" src="{{asset('js/admin/documentp/document_cart_general.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/admin/documentp/documentp_logs.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/admin/quoting/quoting.js?v=1.0.4')}}"></script>
  <script type="text/javascript" src="{{asset('js/admin/quoting/metricas.js?v=1.0.5')}}"></script>
  <script type="text/javascript">
  $(function() {
    localStorage.clear();
    });
  </script>
  <style media="screen">
    .table th, .table td{
      padding: 0.2rem 1.2rem;
    }
  </style>

@endpush
