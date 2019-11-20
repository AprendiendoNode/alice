@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View facturas pendientes') )
    {{ trans('message.pay_hist_request') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View facturas pendientes') )
    {{ trans('message.breadcrumb_status_paid') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @include('permitted.payments.modal_payment')

    @if( auth()->user()->can('View facturas pendientes') )
    <div class="container">
      <div class="card">
        <div class="card-body">
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <form id="validation_fact" name="validation_fact" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="info_fact_pend"> Selecciona el pago con factura pendiente:
                        <span class="danger">*</span>
                    </label>
                    <select class="form-control required select2" id="info_fact_pend" name="info_fact_pend" style="width:100%;">
                        <option value="" selected>{{ trans('pay.select_op') }}</option>
                          @forelse ($facturas as $fact)
                            <option value="{{ $fact->id }}"> {{ $fact->folio }} </option>
                          @empty
                          @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <label for="info_proveedor" class="control-label">Nombre del Proveedor:</label>
                    <input type="text" class="form-control" id="info_proveedor" name="info_proveedor" readonly>
                </div>
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="info_cantidad" class="control-label">Monto:</label>
                        <input type="text" class="form-control" id="info_cantidad" name="info_cantidad" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="info_orden" class="control-label">Orden de pago:</label>
                        <input type="text" class="form-control" id="info_orden" name="info_orden" readonly>
                    </div>
                </div>

                <center>
                    <label for="" class="col-md-12 control-label text-danger"><i class="fas fa-cloud-upload-alt" aria-hidden="true"></i> Importar facturas en PDF O XML</label>
                </center>
                <div class="row mb-2">
                    <div class="col-md-8 m-auto">
                      <div class="form-group">
                          <label for="info_nofact" class="control-label">No. Factura:</label>
                          <input type="text" class="form-control required" id="info_nofact" name="info_nofact" readonly>
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-8 m-auto">
                      <div class="input-group" id="cont_1">
                          <label class="input-group-btn">
                              <span class="btn btn-danger">
                                <i class="far fa-file-pdf"></i>  PDF
                                <input id="file_pdf" name="file_pdf" type="file" style="display: none;" class="required">
                              </span>
                          </label>
                          <input type="text" class="form-control" readonly>
                      </div>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-md-8 m-auto">
                      <div class="input-group" id="cont_2">
                          <label class="input-group-btn">
                              <span class="btn btn-success">
                                <i class="far fa-file-excel"></i> XLSX
                                <input id="file_xml" name="file_xml" type="file" style="display: none;" class="required">
                              </span>
                          </label>
                          <input type="text" class="form-control" readonly>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 m-auto">
                      <div class="form-group mt-10">
                          <button type="submit" class="btn btn-info"><i class="fa fa-bullseye margin-r5"></i> Guardar</button>
                      </div>
                  </div>
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
  <style media="screen">
  input:disabled,textarea:disabled {
       background: #ffffff !important;
       border-radius: 3px;
   }
  </style>
  @if( auth()->user()->can('View facturas pendientes') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
    <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

    <script type="text/javascript">
      $(function() {
        $('.select2').select2();
      });
      // onclick='modalPendiente()'
        function modalPendiente() {
            $('#modalPendiente').modal('toggle');
            $.ajax({
              type: "POST",
              url: "/find_fact_pend",
              data: { _token : $('input[name="_token"]').val() },
              success: function (data){
                  $('#info_fact_pend').val('').trigger('change');
                  $('[name="info_fact_pend"] option[value!=""]').remove();
                  $.each(JSON.parse(data),function(index, objdata){
                    $('[name="info_fact_pend"]').append('<option value="'+objdata.id+'">'+ objdata.folio +'</option>');
                  });
              },
              error: function (data) {
                console.log('Error:', data);
              }
            });
        };

        $('#info_fact_pend').on('change', function(e){
          var id_pay = $(this).val();
          if (id_pay != '') {
            $.ajax({
              type: "POST",
              url: "/get_data_fact_by_drive",
              data: { data_one : id_pay, _token : $('input[name="_token"]').val() },
              success: function (data){
                datax = JSON.parse(data);
                if (datax == null || datax == '[]') {
                  $('#validation_modal_fact').find('input:text').val('');
                  $('#validation_modal_fact').find('input:file').val('');
                  $('input[name="info_nofact"]').prop("readonly", true);
                }
                else {
                    $("#info_proveedor").val(datax[0].folio);
                    $("#info_cantidad").val(datax[0].monto_str);
                    $("#info_orden").val(datax[0].concept_pay);
                    // $("#info_nofact").val(datax[0].date_solicitude);
                    $("#info_nofact").val(datax[0].factura);
                    $('input[name="info_nofact"]').prop("readonly", false);
                }
              },
              error: function (data) {
                console.log('Error:', data);
              }
            });
          }
          else {
            $('input[name="info_nofact"]').prop("readonly", true);
            $('#validation_modal_fact').find('input:text').val('');
            $('#validation_modal_fact').find('input:file').val('');
          }
        });

        $("#validation_fact").validate({
            ignore: '*:not([name])', //Fixes your name issue
            rules: {
              file_pdf: {
                extension: 'pdf',
              },
              file_xml: {
                extension: 'xlsx',
              },
            },
            messages: {

            },
            debug: true,
            errorElement: "label",
            errorPlacement: function(error, element) {
              console.log(element);
              if (element[0].id === 'file_pdf') {
                error.insertAfter($('#cont_1'));
              }
              else if (element[0].id === 'file_xml') {
                error.insertAfter($('#cont_2'));
              }
              else{
                 error.insertAfter(element);
              }
            },
            submitHandler: function(form){
                    Swal.fire({
                      title: "Estás seguro?",
                      text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "Continuar.!",
                      cancelButtonText: "Cancelar.!",
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
              }).then((result) => {
                if (result.value) {
                  // The AJAX
                  var form = $('#validation_fact')[0];
                  var formData = new FormData(form);
                  $.ajax({
                    type: 'POST',
                    url: "/add_fact_pend_by_drive",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data){
                      datax = data;
                      if (datax != '0') {
                        $('#modalPendiente').modal('toggle');
                        Swal.fire("Operación Completada!", ":)", "success");
                      }
                      else {
                        $('#modalPendiente').modal('toggle');
                        Swal.fire("Operación abortada", "Error al registrar intente otra vez :(", "error");
                      }

                      $("#validation_fact")[0].reset();
                      var validator = $( "#validation_fact" ).validate();
                      validator.resetForm();
                    },
                    error: function (data) {
                      $('#modalPendiente').modal('toggle');
                      Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
                    }
                  });
                }//Fin if result.value
                else {
                  $('#modalPendiente').modal('toggle'); // cambiar a reseteo de formulario
                  Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
                }
              })
            }
        });
    </script>
  @else
    <!--NO VER-->
  @endif
@endpush
