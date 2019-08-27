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
            <!-- Step 2 -->
            <h6>Paso 2 - Preguntas</h6>
            <section>
              <div id="add_item_btn" class="btn-group float-right mt-2" role="group">
                <a class="btn btn-inverse-info btn-fw btn-sm" href="javascript:void(0);" onclick="addItem();"> <i class="far fa-plus-square" aria-hidden="true"></i> Añadir pregunta</a>
              </div>
              <!-- Items -->
              <div class="row">
                <div class="col-md-12 col-xs-12">
                  <div class="card">
                    <div class="card-header" role="tab" id="heading-4">
                      <h6 class="mb-0">
                        <span class="badge badge-secondary">Pregunta</span>
                        <a class="btn btn-danger float-right btn-sm btn-mod" href="javascript:void(0);" onclick="addItem();">
                          <i class="mdi mdi-close-octagon-outline "></i>
                        </a>
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="form-group mb-5">
                          <label>Ingrese su pregunta</label>
                          <input class="form-control" type="text" value="" required>
                      </div>

                      <div class="form-group">
                        <label for="salesperson_id" class="control-label">Tipo de respuesta:<span style="color: red;">*</span></label>
                        <select id="salesperson_id" name="salesperson_id" class="form-control required" style="width:100%;">
                          <option value="" selected>Elija</option>
                          <option value="1">Abierta</option>
                          <option value="2">Opción múltiple</option>
                        </select>
                      </div>

                      <div class="separator my-4"></div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label>Opcion 1 <span style="color: red;">*</span></label>
                              <input class="form-control" type="text" value="" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="salesperson_id" class="control-label">icono (Opcional)</label>
                            <select id="salesperson_id" name="salesperson_id" class="form-control required" style="width:100%;">
                              <option value="" selected>Elija</option>
                              @include('permitted.survey.option')
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label>Opcion 2 <span style="color: red;">*</span></label>
                              <input class="form-control" type="text" value="" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="salesperson_id" class="control-label">icono (Opcional)</label>
                            <select id="salesperson_id" name="salesperson_id" class="form-control required" style="width:100%;">
                              <option value="" selected>Elija</option>
                              @include('permitted.survey.option')
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label>Opcion 3 <span style="color: red;">*</span></label>
                              <input class="form-control" type="text" value="" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="salesperson_id" class="control-label">icono (Opcional)</label>
                            <select id="salesperson_id" name="salesperson_id" class="form-control required" style="width:100%;">
                              <option value="" selected>Elija</option>
                              @include('permitted.survey.option')
                            </select>
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
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
                    onclick="$('#item_row_{{ $item_row }}').remove(); totalItem();"
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
            @endforeach
            @php
            $item_row++;
            @endphp
            <div id="add_item"></div>
          </section>
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
                    <textarea class="form-control" rows="5" id="description"></textarea>
                  </div>
                </div>
              </div>
            </section>
            <!-- Step 3 -->
            <h6>Paso 3 -Vista previa</h6>
            <section>
            </section>
          </form>

        </div>
      </div>
    </div>
  </div>


  <div class="card question d-flex mb-4 edit-quesiton">
                                              <div class="d-flex flex-grow-1 min-width-zero">

                                                  <div
                                                      class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                                      <div class="list-item-heading mb-0 truncate w-80 mb-1 mt-1">
                                                          <span class="heading-number d-inline-block">
                                                              1
                                                          </span>
                                                          Age
                                                      </div>
                                                  </div>
                                                  <div
                                                      class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                      <button class="btn btn-outline-theme-3 icon-button edit-button">
                                                          <i class="simple-icon-pencil"></i>
                                                      </button>
                                                      <button class="btn btn-outline-theme-3 icon-button view-button">
                                                          <i class="simple-icon-eye"></i>
                                                      </button>
                                                      <button
                                                          class="btn btn-outline-theme-3 icon-button rotate-icon-click rotate"
                                                          type="button" data-toggle="collapse" data-target="#q1"
                                                          aria-expanded="true" aria-controls="q1">
                                                          <i class="simple-icon-arrow-down with-rotate-icon"></i>
                                                      </button>
                                                  </div>
                                              </div>
                                              <div class="question-collapse collapse show" id="q1">
                                                  <div class="card-body pt-0">
                                                      <div class="edit-mode">
                                                          <div class="form-group mb-3">
                                                              <label>Title</label>
                                                              <input class="form-control" type="text" value="Age">
                                                          </div>
                                                          <div class="form-group mb-5">
                                                              <label>Question</label>
                                                              <input class="form-control" type="text"
                                                                  value="How old are you?">
                                                          </div>

                                                          <div class="separator mb-4"></div>

                                                          <div class="form-group">
                                                              <label class="d-block">Answer Type</label>
                                                              <select class="form-control select2-single">
                                                                  <option label="&nbsp;">&nbsp;</option>
                                                                  <option value="0">Text Input</option>
                                                                  <option value="1" selected>Single Select</option>
                                                                  <option value="2">Multiple Select</option>
                                                                  <option value="3">Checkbox</option>
                                                                  <option value="4">Radiobutton</option>
                                                              </select>
                                                          </div>

                                                          <div class="form-group">
                                                              <label class="d-block">Answers</label>
                                                              <div class="answers mb-3 sortable">
                                                                  <div class="mb-1 position-relative">
                                                                      <input class="form-control" type="text"
                                                                          value="18-24">
                                                                      <div class="input-icons">
                                                                          <span
                                                                              class="badge badge-pill handle pr-0 mr-0">
                                                                              <i class="simple-icon-cursor-move"></i>
                                                                          </span>
                                                                          <span class="badge badge-pill">
                                                                              <i class="simple-icon-ban"></i>
                                                                          </span>
                                                                      </div>
                                                                  </div>
                                                                  <div class="mb-1 position-relative">
                                                                      <input class="form-control" type="text"
                                                                          value="24-30">
                                                                      <div class="input-icons">
                                                                          <span
                                                                              class="badge badge-pill handle pr-0 mr-0">
                                                                              <i class="simple-icon-cursor-move"></i>
                                                                          </span>
                                                                          <span class="badge badge-pill">
                                                                              <i class="simple-icon-ban"></i>
                                                                          </span>
                                                                      </div>
                                                                  </div>
                                                                  <div class="mb-1 position-relative">
                                                                      <input class="form-control" type="text"
                                                                          value="30-40">
                                                                      <div class="input-icons">
                                                                          <span
                                                                              class="badge badge-pill handle pr-0 mr-0">
                                                                              <i class="simple-icon-cursor-move"></i>
                                                                          </span>
                                                                          <span class="badge badge-pill">
                                                                              <i class="simple-icon-ban"></i>
                                                                          </span>
                                                                      </div>
                                                                  </div>
                                                                  <div class="mb-1 position-relative">
                                                                      <input class="form-control" type="text"
                                                                          value="40-50">
                                                                      <div class="input-icons">
                                                                          <span
                                                                              class="badge badge-pill handle pr-0 mr-0">
                                                                              <i class="simple-icon-cursor-move"></i>
                                                                          </span>
                                                                          <span class="badge badge-pill">
                                                                              <i class="simple-icon-ban"></i>
                                                                          </span>
                                                                      </div>
                                                                  </div>
                                                                  <div class="mb-1 position-relative">
                                                                      <input class="form-control" type="text"
                                                                          value="50+">
                                                                      <div class="input-icons">
                                                                          <span
                                                                              class="badge badge-pill handle pr-0 mr-0">
                                                                              <i class="simple-icon-cursor-move"></i>
                                                                          </span>
                                                                          <span class="badge badge-pill">
                                                                              <i class="simple-icon-ban"></i>
                                                                          </span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="text-center">
                                                                  <button type="button"
                                                                      class="btn btn-outline-primary btn-sm mb-2">
                                                                      <i class="simple-icon-plus btn-group-icon"></i>
                                                                      Add Answer</button>
                                                              </div>
                                                          </div>
                                                      </div>

                                                      <div class="view-mode">
                                                          <label>How old are you?</label>
                                                          <select class="form-control select2-single">
                                                              <option label="&nbsp;">&nbsp;</option>
                                                              <option value="0">18-24</option>
                                                              <option value="1">24-30</option>
                                                              <option value="2">30-40</option>
                                                              <option value="3">40-50</option>
                                                              <option value="4">50+</option>
                                                          </select>
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
    console.log('a');
        //#Solicitamos primero el tc a usar
        var html = '';
        html += '<div class="row" id="item_row_' + item_row + '">';
        html += '<div class="col-md-12 text-center" style="vertical-align: middle;">';
        html += '<button type="button" onclick="$(\'#item_row_' + item_row + '\').remove(); " class="btn btn-xs btn-danger" style="margin-bottom: 0;">';
        html += '<i class="fa fa-trash"></i>';
        html += '</button>';
        html += '<input type="hidden" name="item[' + item_row + '][id]" id="item_id_' + item_row + '" /> ';
        html += item_row;
        html += '</div>';
        html += '</div>';

        html += '</div>';

        $("#validation_master #add_item").before(html);
        /* Configura lineas*/
        // initItem();
        // totalItem();
        item_row++;
  }
</script>
{{-- @else --}}
{{-- @endif  --}}
@endpush
