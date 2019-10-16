@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') )
    {{ trans('message.breadcrumb_document_create') }}
  @else
    {{ trans('message.denied') }}
  @endif --}}
  Editar cotización
@endsection

@section('breadcrumb_title')
   @if( auth()->user()->can('View Document P') )
    Editar cotización
    @else
      {{ trans('message.denied') }}
    @endif
@endsection
@section('content')

  @if( auth()->user()->can('View Document P') )
    <div class="container">
      <!-- Validation wizard -->
      <div class="row" id="validation">
          <div class="col-12">
              <div class="white-box contrato_a">
                  <form id="form_edit_kickoff" class="" action="/edit_kickoff" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_doc_3" id="id_doc_3" value="">
                  </form>
                  <div class="wizard-content">
                    <input type="hidden" name="id_documentp" id="id_documentp" value="{{$id_document}}">
                    <h4 class="text-danger">{{$data_header[0]->folio}}</h4>
                    <h5 class="text-danger">Última actualización: <span id="hour_created">{{$hour_created}}</span></h5>
                    <p class="text-primary">Número de ediciones: {{$data_header[0]->num_edit}}</p> 
                      <!---Si el estatus del cotizador es AUTORIZADO o EN KICK-OFF  se muestra el boto de enlace al kickoff-->
                      @if($data_header[0]->cotizador_status_id == 4 || $data_header[0]->cotizador_status_id == 5)
                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="KICK-OFF" onclick="kickoff(this)" data-id="{{$id_document}}"  value="{{$id_document}}" class="btn btn-success text-white"><span class="fas fa-tasks"></span> Ir a KICK-OFF</a>
                      @endif
                      @include('permitted.quoting.form_edit')
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>
    <link type="text/css" href="css/bootstrap-editable.css" rel="stylesheet" />
    <script src="{{ asset('js/bootstrap-editable.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >
    <script type="text/javascript" src="{{asset('js/admin/documentp/documentp_logs.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/admin/quoting/edit_quoting_cart_general.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/admin/quoting/edit_quoting.js?v=4.0.0')}}"></script>
    <script type="text/javascript" src="{{asset('js/admin/quoting/metricas.js?v=4.0.0')}}"></script>
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
  <script type="text/javascript">
      function kickoff(e){
        var element = e;
        var _token = $('input[name="_token"]').val();
        let id_documentp = element.dataset.id;
        var form = $('#form_edit_kickoff');
        $('#id_doc_3').val(id_documentp);

        form.submit();

      }
  </script>
  @endif
@endpush
