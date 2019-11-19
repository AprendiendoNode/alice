@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View Document P') )
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
  @if( auth()->user()->can('View Document P') )

      <!-- Validation wizard -->
      <div class="" id="validation">
          <div class="col-sm-12">
              <div class="card contrato_a">
                  <div class="wizard-content">
                      <h5 class="p-3 text-secondary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> COMPRA DE MATERIALES</h5>
                      @include('permitted.documentp.form_create')
                  </div>
              </div>

            <!-- FIN FORMULARIO -->
          </div>
        </div>

  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View Document P') )
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




    <script type="text/javascript">
      $(function() {
        localStorage.clear();
        $('#select_one').val('').trigger('change');

        $('.btngeneral').on('click', function(e){

          var id= $('select[name="select_one"]').val();
          var _token = $('input[name="_token"]').val();

        });

        $("[data-toggle=popover]").popover();

        $(document).on('change', ':file', function() {
          var input = $(this),
          numFiles = input.get(0).files ? input.get(0).files.length : 1,
          label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
          input.trigger('fileselect', [numFiles, label]);
        });
        // We can watch for our custom `fileselect` event like this
        $(document).ready( function() {
          $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
              input.val(log);
            } else {
              if( log ) alert(log);
            }

          });
        });


      });
    </script>
    <script type="text/javascript" src="{{asset('js/admin/documentp/document_cart_general.js?v=2.0')}}"></script>
    @else
      @include('default.denied')
    @endif
    <script type="text/javascript" src="{{asset('js/admin/documentp/documentp_logs.js')}}"></script>
    @if( auth()->user()->can('View level zero documentp notification') )
      <script type="text/javascript" src="{{asset('js/admin/documentp/documentp.js?v=1.0.2')}}"></script>
    @elseif ( auth()->user()->can('View level one documentp notification') )
      <script type="text/javascript" src="{{asset('js/admin/documentp/documentp_create_comercial.js?v=1.0.2')}}"></script>
    @elseif ( auth()->user()->can('View level two documentp notification') )
      <script type="text/javascript" src="{{asset('js/admin/documentp/documentp_create_comercial.js?v=1.0.2')}}"></script>
    @elseif ( auth()->user()->can('View level three documentp notification') )
      <script type="text/javascript" src="{{asset('js/admin/documentp/documentp_create_comercial.js?v=1.0.2')}}"></script>
    @endif


@endpush
