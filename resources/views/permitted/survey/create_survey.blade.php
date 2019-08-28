@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  Desarrollo de encuestas
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  Desarrollo de encuestas
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('content')
  {{-- @if( auth()->user()->can('View cover') ) --}}

  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card white-box">
        <div class="card-body wizard-content">

          <form id="validation_master" name="validation_master" enctype="multipart/form-data" class="validation-wizard-master wizard-circle m-t-40">
            {{ csrf_field() }}
            <!-- Step 1 -->
            <h6>Paso 1 - Nombre</h6>
            <section>
              <div class="row">
                <div class="col-md-12 col-xs-12">
                  <div class="form-group">
                    <label for="title">Nombre de la encuesta:</label>
                    <input type="text" class="form-control" id="title" name="title" value="" required>
                  </div>
                </div>
                <div class="col-md-12 col-xs-12">
                  <div class="form-group">
                    <label for="description">Descripción:</label>
                    <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                  </div>
                </div>
              </div>
            </section>
            <!-- Step 2 -->
            <h6>Paso 2 - Preguntas</h6>
            <section>
              <div id="add_item_btn" class="btn-group float-right mt-2" role="group">
                <a class="btn btn-inverse-info btn-fw btn-sm" href="javascript:void(0);" onclick="addItem();"> <i class="far fa-plus-square" aria-hidden="true"></i> Añadir pregunta</a>
              </div>
              <!-- Items -->
              @php
              $item_row = 0;
              $items = (empty(old('item')) ? [] : old('item'));
              @endphp
              @foreach ($items as $item_row => $item)
                @php
                $tmp_products = [];
                @endphp
                <div class="row" id="item_row_{{ $item_row }}">
                  <div class="col-md-12 text-center" style="vertical-align: middle;">
                    <button type="button"
                    onclick="$('#item_row_{{ $item_row }}').remove();"
                    class="btn btn-xs btn-danger"
                    style="margin-bottom: 0;">
                    <i class="fa fa-trash-o"></i>
                  </button>
                  <!-- input hidden -->
                    <input type="hidden" id="item_id_{{ $item_row }}"
                    name="item[{{ $item_row }}][id]"
                    value="{{ old('item.' . $item_row . '.id') }}">
                    <!-- /.input hidden -->
                  </div>
                </div>

                <div class="row" id="item_row_{{ $item_row }}">
                  <div class="col-md-12 col-xs-12">
                    <div class="card">
                      <div class="card-header" role="tab" id="heading-4">
                        <h6 class="mb-0">
                          <span class="badge badge-secondary">Pregunta {{ $item_row }}</span>
                          <a class="btn btn-danger float-right btn-sm btn-mod" href="javascript:void(0);"
                            onclick="$('#item_row_{{ $item_row }}').remove();">
                            <i class="mdi mdi-close-octagon-outline "></i>
                          </a>
                        </h6>
                        <input type="hidden" id="item_id_{{ $item_row }}"
                        name="item[{{ $item_row }}][id]"
                        value="{{ old('item.' . $item_row . '.id') }}">
                      </div>
                      <div class="card-body">
                        <div class="form-group mb-5">
                            <label>Ingrese su pregunta</label>
                            <input id="item{{ $item_row.'[question]'}}" name="item[{{ $item_row }}][question]"
                            class="form-control" type="text" value="" required>
                        </div>

                        <div class="form-group">
                          <label for="item{{ $item_row.'[answertype]'}}" class="control-label">Tipo de respuesta:<span style="color: red;">*</span></label>
                          <select  id="item{{ $item_row.'[answertype]'}}" name="item[{{ $item_row }}][answertype]"
                           class="form-control required" style="width:100%;" onchange="getanswertype(this);" datas="item[{{ $item_row }}][answertype]" datas2="{{ $item_row }}">
                            <option value="" selected>Elija</option>
                            <option value="1">Abierta</option>
                            <option value="2">Opción múltiple</option>
                          </select>
                        </div>

                        <div class="separator my-4"></div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
              @php
              $item_row++;
              @endphp
              <div id="add_item"></div>
            </section>
          </form>

        </div>
      </div>
    </div>
  </div>

  {{-- @else --}}
  {{-- @endif --}}
@endsection

@push('scripts')
{{-- @if( auth()->user()->can('View cover') ) --}}
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master-two/steps.css')}}" >
<script src="{{ asset('plugins/jquery-wizard-master-two/jquery.steps.min.js')}}"></script>
<script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
<script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />

<!-- FormValidation -->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
<!-- FormValidation plugin and the class supports validating Bootstrap form -->
<script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
<script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>
<link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
<script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
<style media="screen">
  select {
    font-family: 'FontAwesome', 'sans-serif';
  }
  .separator {
      border-bottom: 1px solid #d7d7d7 !important;
  }
  .btn-mod {
      padding: 0.1rem 0.2rem !important;
  }
  input::-webkit-input-placeholder {
      font-size: 12px;
      line-height: 3;
  }
  .text-danger {
      color: #f62d51;;
  }
  .white-box {
   background:#ffffff;
   padding:25px;
   margin-bottom:10px;
   border-color: rgba(120,130,140,.13);
   border: 1px solid #aaa;
  }
  .white-box .box-title {
   margin:0px 0px 12px;
   font-weight:500;
   text-transform:uppercase;
   font-size:16px
  }
  .wizard-steps {
   display:table;
   width:100%
  }
  .wizard-steps>li {
   display:table-cell;
   padding:10px 20px;
   background:#f7fafc
  }
  .wizard-steps>li span {
   border-radius:100%;
   border:1px solid rgba(120, 130, 140, 0.13);
   width:40px;
   height:40px;
   display:inline-block;
   vertical-align:middle;
   padding-top:9px;
   margin-right:8px;
   text-align:center
  }
  .wizard-content {
   padding:5px;
   border-color:rgba(120, 130, 140, 0.13);
   margin-bottom:10px
  }
  .wizard-steps>li.current,.wizard-steps>li.done {
   background:#2cabe3;
   color:#ffffff
  }
  .wizard-steps>li.current span,.wizard-steps>li.done span {
   border-color:#ffffff;
   color:#ffffff
  }
  .wizard-steps>li.current h4,.wizard-steps>li.done h4 {
   color:#ffffff
  }
  .wizard-steps>li.done {
   background:#53e69d
  }
  .wizard-steps>li.error {
   background:#ff7676
  }
  .wiz-aco .pager {
   margin:0px
  }
  .wizard-content .wizard>.actions{
    margin-top: 10px
  }
</style>
<script type="text/javascript">
  //Logica
  var form_master = $(".validation-wizard-master").show();
  $(".validation-wizard-master").steps({
      headerTag: "h6",
      bodyTag: "section",
      transitionEffect: "fade",
      titleTemplate: '<span class="step">#index#</span> #title#',
      labels: {
          finish: "Submit"
      },
      onStepChanging: function (event, currentIndex, newIndex) {
          return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form_master.find(".body:eq(" + newIndex + ") label.error").remove(), form_master.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form_master.validate().settings.ignore = ":disabled,:hidden", form_master.valid())
      },
      onFinishing: function (event, currentIndex) {
          return form_master.validate().settings.ignore = ":disabled", form_master.valid()
      },
      onFinished: function (event, currentIndex) {
        event.preventDefault();
        /************************************************************************************/
          swal({
            title: "Estás seguro, estas apunto de crear una encuesta?",
            text: "Al dar clic en continuar necesita espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Continuar.!",
            cancelButtonText: "Cancelar.!",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true,
          },
          function(isConfirm) {
            if (isConfirm) {
                var form = $('#validation_master')[0];
                var formData = new FormData(form);
                // var digit = $("#sel_master_digit option:selected").text();
                // formData.append('digit', digit);

                $.ajax({
                  type: "POST",
                  url: "/store_new_survey_admin",
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function (data){
                    console.log(data);
                    swal.close();

                    // if(data == "true"){
                    //
                    // }else{
                    //   swal("Error al actualizar contrato", "", "Error");
                    // }
                  },
                  error: function (data) {
                    console.log('Error:', data);
                    swal.close();
                  }
                })

            } else {
              swal("Operación abortada", "Ningúna operación afectuada :)", "error");
            }
          });
        /************************************************************************************/
      }
  }), $(".validation-wizard-master").validate({
      ignore: "input[type=hidden]",
      errorClass: "text-danger",
      successClass: "text-success",
      highlight: function (element, errorClass) {
          $(element).removeClass(errorClass)
      },
      unhighlight: function (element, errorClass) {
          $(element).removeClass(errorClass)
      },
      errorPlacement: function (error, element) {
          // error.insertAfter(element);
          if (element[0].id === 'fileInput') {
            error.insertAfter($('#cont_file'));
          }
          else {
            error.insertAfter(element);
          }
      },
      rules: {
          contact_email: {
            email: true
          },
          fileInput: {
            extension: 'pdf',
            filesize: 20000000
          },
          contact_telephone: {
            required: true,
            number: true,
            minlength: 7,
            maxlength: 10
          },
      },
      messages: {
              fileInput:{
                  filesize:" file size must be less than 20 MB.",
                  accept:"Please upload .pdf file of notice.",
                  required:"Please upload file."
              }
          },
  })

  var item_row = "{{ $item_row }}";

  function addItem() {

        //#Solicitamos primero el tc a usar
        var html = '';



 html += '<div class="row mb-4" id="item_row_' + item_row + '">';
  html += '<div class="col-md-12 col-xs-12">';
    html += '<div class="card">';

    html += '<div class="card-header">';
      html += '<h6 class="mb-0">';
      html += '<span class="badge badge-secondary">Pregunta ' + item_row + '</span>';
      html += '<a class="btn btn-danger float-right btn-sm btn-mod" href="javascript:void(0);" onclick="$(\'#item_row_' + item_row + '\').remove(); ">';
        html += '<i class="mdi mdi-close-octagon-outline"></i>';
      html += '</a>';
      html += '</h6>';
      html += '<input type="hidden" name="item[' + item_row + '][id]" id="item_id_' + item_row + '" value="' + item_row + '" /> ';

    html += '</div>';

    html += '<div class="card-body">';
      html += '<div class="form-group mb-5">';
        html += '<label>Ingrese su pregunta</label>';
        html += '<input id="item_question_' + item_row + '" name="item[' + item_row + '][question]" class="form-control" type="text" required/> ';
      html += '</div>';

      html += '<div class="form-group">';
        html += '<label for="item[' + item_row + '][answertype]" class="control-label">Tipo de respuesta: <span style="color: red;">*</span> </label>';
        html += '<select class="form-control input-sm col-product-id" name="item[' + item_row + '][answertype]" id="item_answertype_id_' + item_row + '" data-row="' + item_row + '" datas2="' + item_row + '" onchange="getanswertype(this);" >';
        html += '<option selected="selected" value="">@lang('message.selectopt')</option>';
        html += '<option value="1">Abierta</option>';
        html += '<option value="2">Opción múltiple</option>';

        html += '</select>';
      html += '</div>';

      html += '<div id="separator_text' + item_row + '" class="separator my-4">';
      html += '</div>';


    html += '</div>';
  html += '</div>';
 html += '</div>';




        html += '</div>';
        $("#validation_master #add_item").before(html);
        /* Configura lineas*/
        // initItem();
        // totalItem();
        item_row++;
  }
  function getanswertype(el)
  {
    var id = el.id;
    var name = el.name;
    var data2 = $('#'+id).attr('datas2');
    var valor_option = $('option:selected', el).attr('value');
    var valor_a = 1;
    var valor_b = 2;
    var valor_c = 3;

    if (valor_option == 2) {
      var html2 = '';
      html2 += '<div id="content_item_answer_' + data2 + '">';

      html2 += '<div class="row">';
        html2 += '<div class="col-md-6">';
          html2 += '<div class="form-group">';
            html2 += '<label>Opcion ' + valor_a + ' <span style="color: red;">*</span></label>';
            html2 += '<input id="item_answer_' + data2 + '_' + valor_a + '" name="item_' + data2 + '[' + valor_a + '][answer]" class="form-control" type="text" value="" required>';
          html2 += '</div>';
        html2 += '</div>';

        html2 += '<div class="col-md-6">';
          html2 += '<div class="form-group">';
          html2 += '<label class="control-label">icono (Opcional)</label>';

          html2 += '<select class="form-control input-sm col-icon-id" name="item_' + data2 + '[' + valor_a + '][icon]" id="item_answertype' + data2 + '_id_' + valor_a + '" data-row="' + valor_a + '" datas2="' + valor_a + '" >';
            html2 += '<option selected="selected" value="">@lang('message.selectopt')</option>';
            @include('permitted.survey.option0')
          html2 += '</select>';
          html2 += '</div>';
        html2 += '</div>';
      html2 += '</div>';

      html2 += '<div class="row">';
        html2 += '<div class="col-md-6">';
          html2 += '<div class="form-group">';
            html2 += '<label>Opcion ' + valor_b + ' <span style="color: red;">*</span></label>';
            html2 += '<input id="item_answer_' + data2 + '_' + valor_b + '" name="item_' + data2 + '[' + valor_b + '][answer]" class="form-control" type="text" value="" required>';
          html2 += '</div>';
        html2 += '</div>';

        html2 += '<div class="col-md-6">';
          html2 += '<div class="form-group">';
          html2 += '<label class="control-label">icono (Opcional)</label>';

          html2 += '<select class="form-control input-sm col-icon-id" name="item_' + data2 + '[' + valor_b + '][icon]" id="item_answertype' + data2 + '_id_' + valor_b + '" data-row="' + valor_b + '" datas2="' + valor_b + '" >';
            html2 += '<option selected="selected" value="">@lang('message.selectopt')</option>';
            @include('permitted.survey.option0')
          html2 += '</select>';
          html2 += '</div>';
        html2 += '</div>';
      html2 += '</div>';

      html2 += '<div class="row">';
        html2 += '<div class="col-md-6">';
          html2 += '<div class="form-group">';
            html2 += '<label>Opcion ' + valor_c + ' <span style="color: red;">*</span></label>';
            html2 += '<input id="item_answer_' + data2 + '_' + valor_c + '" name="item_' + data2 + '[' + valor_c + '][answer]" class="form-control" type="text" value="" required>';
          html2 += '</div>';
        html2 += '</div>';

        html2 += '<div class="col-md-6">';
          html2 += '<div class="form-group">';
          html2 += '<label class="control-label">icono (Opcional)</label>';

          html2 += '<select class="form-control input-sm col-icon-id" name="item_' + data2 + '[' + valor_c + '][icon]" id="item_answertype' + data2 + '_id_' + valor_c + '" data-row="' + valor_c + '" datas2="' + valor_c + '" >';
            html2 += '<option selected="selected" value="">@lang('message.selectopt')</option>';
            @include('permitted.survey.option0')
          html2 += '</select>';
          html2 += '</div>';
        html2 += '</div>';
      html2 += '</div>';

      html2 += '</div>';

      $('#separator_text' + data2 + '').before(html2);
    }
    else {
      console.log(1);
      if ($('#content_item_answer_' + data2 ).length > 0){
        $('#content_item_answer_' + data2).remove();
      }
    }
  }
</script>
{{-- @else --}}
{{-- @endif  --}}
@endpush
