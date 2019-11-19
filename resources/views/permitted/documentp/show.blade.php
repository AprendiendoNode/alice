@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View cover') )
    {{ trans('message.breadcrumb_document_create') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View Document P') )
    {{ trans('message.document_create') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View Edit Document P') )
    <div class="container">
      <!-- Validation wizard -->
      <div class="row" id="validation">
          <div class="col-sm-12">
            <div class="col-sm-12">
              <div class="white-box contrato_a">
                  <div class="wizard-content">
                    <input type="hidden" name="id_documentp" id="id_documentp" value="{{$id_document}}">
                      <h4 class="text-danger">{{$data_header[0]->folio}}</h4>
                      <h5 class="text-danger">Última actualización: <span id="hour_created">{{$hour_created}}</span></h5>
                      <p class="text-primary">Número de ediciones: {{$data_header[0]->num_edit}}</p>
                      @include('permitted.documentp.form_edit')
                  </div>
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
  @if( auth()->user()->can('View Edit Document P') )
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
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>
    <link type="text/css" href="css/bootstrap-editable.css" rel="stylesheet" />
    <script src="{{ asset('js/bootstrap-editable.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css?v=2.0')}}" >

  @else
    @include('default.denied')
  @endif
  <script type="text/javascript" src="{{asset('js/admin/documentp/documentp_logs.js?v=1.0.3')}}"></script>
  <script type="text/javascript" src="{{asset('js/admin/documentp/edit_document_cart_general.js?v=2.0')}}"></script>
  @if( auth()->user()->can('View level zero documentp notification') )
    <script type="text/javascript" src="{{asset('js/admin/documentp/edit_documentp_itc.js?v=1.0.3')}}"></script>
  @elseif ( auth()->user()->can('View level one documentp notification') )
    <script type="text/javascript" src="{{asset('js/admin/documentp/edit_documentp_comercial.js?v=2.0.2')}}"></script>
  @elseif ( auth()->user()->can('View level two documentp notification') )
    <script type="text/javascript" src="{{asset('js/admin/documentp/edit_documentp_comercial.js?v=2.0.2')}}"></script>
  @elseif ( auth()->user()->can('View level three documentp notification') )
    <script type="text/javascript" src="{{asset('js/admin/documentp/edit_documentp_comercial.js?v=2.0.2')}}"></script>
  @else
    @include('default.denied')
  @endif
@endpush
