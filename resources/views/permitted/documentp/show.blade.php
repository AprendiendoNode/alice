@extends('layouts.app')

@section('contentheader_title')
  @if( auth()->user()->can('View Edit Document P') )
    {{ trans('message.document_edit') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')


@endsection

@section('breadcrumb_ubication')
  @if( auth()->user()->can('View Edit Document P') )
    {{ trans('message.breadcrumb_document_edit') }}
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
    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.steps.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>


    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master-two/steps.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>



    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/pagination.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('/plugins/momentupdate/moment-with-locales.js')}}"></script>
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

    <style media="screen">



    </style>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script type="text/javascript">
      $(function() {
        $('#select_one').val('').trigger('change');

        $('.btngeneral').on('click', function(e){

          var id= $('select[name="select_one"]').val();
          var _token = $('input[name="_token"]').val();



        });

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
    <script type="text/javascript" src="{{asset('js/admin/documentp/documentp_logs.js')}}"></script>
  @if( auth()->user()->can('View level zero documentp notification') )
    <script type="text/javascript" src="{{asset('js/admin/documentp/edit_documentp_itc.js?v=1.0.2')}}"></script>
  @elseif ( auth()->user()->can('View level one documentp notification') )
    <script type="text/javascript" src="{{asset('js/admin/documentp/edit_documentp_comercial.js?v=1.0.2')}}"></script>
  @elseif ( auth()->user()->can('View level two documentp notification') )
    <script type="text/javascript" src="{{asset('js/admin/documentp/edit_documentp_comercial.js?v=1.0.2')}}"></script>

  @endif
  @else
    @include('default.denied')
  @endif
@endpush
