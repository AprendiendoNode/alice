@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View projects docp') )
    Edicion de proyectos
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
   @if( auth()->user()->can('View projects docp') )
    Edicion de proyectos
    @else
      {{ trans('message.denied') }}
    @endif
@endsection

@section('content')

  @if( auth()->user()->can('View projects docp') )
    <div class="container">
      <!-- Validation wizard -->
      <div class="row" id="">
          <div class="col-12">
              <div class="row card">
                <form class="form-horizontal" action="" method="post">
                  <div class="form-group row">
                    <label class="label-control col-sm-12 col-md-2" for="">Seleccionar proyecto:</label>
                    <div class="col-sm-12 col-md-4">
                      <select class="form-control form-control-sm select2" id="project" name="project">
                        <option value="">Elejir...</option>
                        @foreach ($projects as $project)
                          <option value="{{$project->id}}">{{$project->nombre_proyecto}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </form>
                <br>
                <div class="row">
                  <form id="form_project" class="form-inline" action="" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="form-group">
                        <label class="" for="folio">Folio:</label>
                        <input class="form-control form-control-sm" type="text" id="folio" name="folio" value="" readonly>
                      </div>
                      <div class="form-group">
                        <label class="" for="total">Total USD $</label>
                        <input class="form-control form-control-sm" type="text" id="total" name="total" value="" readonly>
                      </div>
                      <div class="form-group">
                        <label class="" for="itc">IT Concierge:</label>
                        <select class="form-control" id="itc" name="itc">
                            <option value=""></option>
                            @foreach ($itcs as $itc)
                              <option value="{{$itc->id}}">{{$itc->nombre}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <br><br>
                    <div class="row mt-3">
                      <br>
                      <div class="form-group">
                        <label class="" for="">Grupo:</label>
                        <select style="width:230px;" class="form-control form-control-sm" id="grupo_id" name="grupo_id">
                            <option value=""></option>
                            @foreach ($grupos as $grupo)
                              <option value="{{$grupo->id}}">{{$grupo->name}}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="" for="">Sitio:</label>
                        <select style="width:250px;" class="form-control form-control-sm" id="anexo_id" name="anexo_id">
                            <option value=""></option>
                        </select>
                      </div>

                      <br>
                      <br>
                      <button class="btn btn-primary ml-3" type="submit" name="button">Guardar</button>
                    </div>

                  </form>
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
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('/plugins/momentupdate/moment-with-locales.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>



    <script type="text/javascript">

      $(document).ready(function(){
        $('#project').select2();
        $('#grupo_id').select2();
        $('#anexo_id').select2();
        $('#itc').select2();
      })

      $("#project").on('change', function(){
        let id = $(this).val();
        var _token = $('input[name="_token"]').val();
        var datax;

        $.ajax({
          type: "POST",
          url: "/get_data_project",
          data: { id : id, _token : _token },
          success: function (data){
            $('#folio').val(data[0].folio);
            $('#total').val(data[0].total_usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#itc').val(data[0].itc_id);
            $('#itc').select2().trigger('change');
            $('#grupo_id').val(data[0].grupo_id);
            $('#grupo_id').select2().trigger('change');
            $('#renta_mensual').val(data[0].renta_mensual);
            setTimeout(function(){
              $('#anexo_id').val(data[0].anexo_id).trigger('change');
            }, 500);
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
      })

      $('#grupo_id').on('change', function(){
        var _token = $('input[name="_token"]').val();
        var id_cadena = $(this).val();
        var datax;
        $.ajax({
          type: "POST",
          url: "/get_hotel_cadena_doc",
          data: { data_one : id_cadena, _token : _token },
          success: function (data){
            console.log(data);
            datax = JSON.parse(data);
            if ($.trim(data)){
              $('#anexo_id').empty();
              $.each(datax, function(i, item) {
                  $('#anexo_id').append("<option value="+item.id+">"+item.Nombre_hotel+"</option>");
              });

            }
            else{
              $("#anexo_id").text('');
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
      })

      $

      $('#form_project').on('submit', function(e){
        e.preventDefault();

        var _token = $('input[name="_token"]').val();
        var id_project = $('#project').val();
        var grupo_id = $('#grupo_id').val();
        var anexo_id = $('#anexo_id').val();
        var itc_id = $('#itc').val();
        var renta_mensual = $('#renta_mensual').val();


        $.ajax({
          type: "POST",
          url: "/edit_form_docp",
          data: {  id : id_project, grupo_id : grupo_id, anexo_id : anexo_id, itc_id : itc_id, renta_mensual : renta_mensual, _token : _token },
          success: function (data){
            if(data == 1){
              Swal.fire(
                'Datos actualizados!',
                '',
                'success'
              )
            }else{
              Swal.fire(
                'Ocurrio un error al guardar!',
                '',
                'error'
              )
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });

      })



    </script>
    <style>
      .card{
        background: white;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        padding: 30px;
      }

      @media (max-width: 400px) {

          input{
            width: 90%;
          }

      }
    </style>


@endpush
