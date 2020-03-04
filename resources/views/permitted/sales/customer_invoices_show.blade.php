@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View customers invoices show') )
    {{ trans('invoicing.customers_invoices_show') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customers invoices show') )
    {{ trans('invoicing.customers_invoices_show') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View customers invoices show') )
  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <form id="form" name="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <select id="aux" style="display: none">
                <option value="" selected> Elija </option>
                @forelse ($bancos as $banco)
                  <option value="{{ $banco->id }}"> {{ $banco->name }} </option>
                @empty
                @endforelse
              </select>
              <div class="col-md-3 col-xs-12">
                <div class="form-group">
                  <label class="control-label" for="filter_name">
                    {{ __('customer_invoice.entry_name') }}
                  </label>
                  <input class="form-control" id="filter_name" name="filter_name" type="text"/>
                </div>
              </div>
              <div class="col-md-3 col-xs-12">
                <div class="form-group" id="date_from">
                  <label class="control-label" for="filter_date_from">
                    {{ __('general.date_from') }}
                  </label>
                  <div class="input-group mb-3">
                    <input type="text"  datas="filter_date_from" id="filter_date_from" name="filter_date_from" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('first day of this month')) }}" required>
                    <div class="input-group-append">
                      <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-xs-12">
                <div class="form-group" id=date_to>
                  <label class="control-label" for="filter_date_to">
                    {{ __('general.date_to') }}
                  </label>
                  <div class="input-group mb-3">
                    <input type="text"  datas="filter_date_to" id="filter_date_to" name="filter_date_to" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('last day of this month')) }}" required>
                    <div class="input-group-append">
                      <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-xs-12">
                <div class="form-group">
                  <label for="filter_branch_office_id">{{ __('general.sucursal') }}</label>
                  <select class="form-control" id="filter_branch_office_id" name="filter_branch_office_id">
                    <option value="">{{ trans('message.selectopt') }}</option>
                    @forelse ($sucursal as $sucursal_data)
                      <option value="{{ $sucursal_data->id  }}">{{ $sucursal_data->name }}</option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="filter_customer_id">Cliente</label>
                  <select class="form-control" id="filter_customer_id" name="filter_customer_id">
                    <option value="" selected>Selecciona...</option>
                    @forelse ($customer as $customer_data)
                      <option value="{{ $customer_data->id  }}">{{ $customer_data->name }}</option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="col-md-3 col-xs-12">
                <div class="form-group">
                  <label for="filter_status">Estado</label>
                  <select class="form-control" id="filter_status" name="filter_status">
                    <option value="" selected>Selecciona...</option>
                    @forelse ($list_status as $key => $value)
                      <option value="{{ $key }}"> {{ $value }} </option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="col-md-3 col-xs-12 pt-4">
                <button type="submit"
                        onclick=""
                        class="btn btn-xs btn-info "
                        style="margin-top: 4px">
                    <i class="fa fa-filter"> {{__('general.button_search')}}</i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive table-data table-dropdown">
            <table id="table_filter_fact" name='table_filter_fact' class="table table-striped table-hover table-condensed">
              <thead>
                <tr class="mini">
                    <th class="text-center" width="5%">@lang('general.column_actions')</th>
                    <th class="text-center">
                      {{  __('customer_invoice.column_name')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_date')}}
                    </th>
                    <th class="text-center">
                        @lang('customer_invoice.column_uuid')
                    </th>
                    <th class="text-left">
                        {{__('customer_invoice.column_customer')}}
                    </th>
                    <th class="text-left">
                        {{__('customer_invoice.column_salesperson')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_date_due')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_currency')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_amount_total')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_balance')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_mail_sent')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_status')}}
                    </th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Editar Workstation-->
  <div id="modal-history" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalhistory" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalhistory">Historial de pagos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="form-group form-group-sm">
                  <label class="control-label" for="name">
                    {{ __('customer_fee.entry_name') }}
                  </label>
                  <input class="form-control" id="name" name="name" type="text" readonly/>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="form-group form-group-sm">
                  <label class="control-label" for="customer">
                    {{ __('customer_fee.entry_customer_id') }}
                  </label>
                  <input class="form-control" id="customer" name="customer" type="text" readonly/>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group form-group-sm">
                <label class="control-label" for="branch_office">
                  {{ __('customer_fee.entry_branch_office_id') }}
                </label>
                <input class="form-control" id="branch_office" name="branch_office" type="text" readonly/>
              </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group form-group-sm">
                <label class="control-label" for="currency">
                  {{ __('customer_fee.entry_currency_id') }}
                </label>
                <input class="form-control" id="currency" name="currency" type="text" readonly/>
              </div>
            </div>
            <div class="col-md-2 col-xs-12">
              <div class="form-group form-group-sm">
                <label class="control-label" for="currency_value">
                  {{ __('customer_fee.entry_currency_value') }}
                </label>
                <input class="form-control" id="currency_value" name="currency_value" type="text" readonly/>
              </div>
            </div>
            <div class="col-md-2 col-xs-12">
              <div class="form-group form-group-sm">
                <label class="control-label" for="amount_total">
                  {{ __('customer_fee.entry_amount_total') }}
                </label>
                <input class="form-control" id="amount_total" name="amount_total" type="text" readonly/>
              </div>
            </div>
            <div class="col-md-2 col-xs-12">
              <div class="form-group form-group-sm">
                <label class="control-label" for="balance">
                  {{ __('customer_fee.entry_balance') }}
                </label>
                <input class="form-control" id="balance" name="balance" type="text" readonly/>
              </div>
            </div>
            <div class="col-md-3 col-xs-12">
              <div class="form-group form-group-sm">
                <label class="control-label" for="reconciled">
                  {{ __('customer_fee.entry_reconciled') }}
                </label>
                <input class="form-control" id="reconciled" name="reconciled" type="text" readonly/>
              </div>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-md-12">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">@lang('customer_fee.tab_payments')</a>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive table-data">
                        <table id="payment_history_all" name="payment_history_all" class="table table-striped table-hover table-condensed">
                            <thead>
                              <tr>
                                <th class="text-center">{{__('customer_payment.column_name')}}
                                </th>
                                <th class="text-center">{{__('customer_payment.column_currency') }}
                                </th>
                                <th class="text-center">{{__('customer_payment.column_date') }}
                                </th>
                                <th class="text-left">{{__('customer_payment.column_payment_way') }}
                                </th>
                                <th class="text-center">{{__('customer_payment.column_reconciled_amount_reconciled2') }}
                                </th>
                                <th class="text-center">{{__('customer_payment.column_reconciled_amount_reconciled') }}
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>



        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  <!-- Estatus sat-->
  <div id="modal_customer_invoice_status_sat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalhistory" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <h4 class="modal-title" id="modalhistory"> {{ __('customer_invoice.text_modal_status_sat')}} </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">&times;</span>
          </button>
        </div>
        <!--Body-->
        <div class="modal-body">
          <div class="row">
            <div class="col-3">
              <p></p>
              <p class="text-center">
                <i class="fas fa-question-circle fa-8x btn-primary mt-3"></i>
              </p>
            </div>

            <div class="col-9">
              <p><strong>Folio fiscal (UUID) = </strong> <br> <span id='text_a'></span>   </p>
              <p><strong>RFC Emisor = </strong> <span id='text_b'></span>   </p>
              <p><strong>RFC Receptor = </strong> <span id='text_c'></span>   </p>
              <p><strong>Total = </strong> <span id='text_d'></span>   </p>
              <p>
                <strong>@lang('general.text_is_cancelable_cfdi') = </strong> <span id='text_e'></span>
              </p>
              <p>
                <strong>@lang('general.text_status_cfdi') = </strong> <span id='text_f'></span>
              </p>
            </div>
          </div>
        </div>
        <!--Footer-->
        <div class="modal-footer flex-center">
          <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>

  <!-- modal about -->
  <div id="modal_customer_invoice_send_mail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalmail" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <h4 class="modal-title" id="modalmail"> {{ __('customer_invoice.text_modal_send_mail')}} </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">&times;</span>
          </button>
        </div>
        <!--Body-->
        <div class="modal-body">
          <form id="form_email_fact">
              <div class="row">
                  <input id="customer_invoice_id" name="customer_invoice_id" type="hidden" value="">
                  <input id="fact_name" name="fact_name" type="hidden" value="">
                  <input id="cliente_name" name="cliente_name" type="hidden" value="">
                  <div class="col-md-12 col-xs-12">
                    <div class="form-group form-group-sm">
                      <label for="subject" class="control-label">Subject <span class="required text-danger">*</span></label>
                      <input class="form-control" placeholder="Asunto" required="" name="subject" type="text" value="" id="subject">
                    </div>
                  </div>
                  <div class="col-md-12 col-xs-12">
                      <div class="form-group form-group-sm">
                        <label for="to" class="control-label">Para <span class="required text-danger">*</span></label>
                        <select style="height:180px !important;" id='to' name='to[]' class="form-control" multiple="multiple">
                        </select>
                      </div>
                  </div>
                  <div class="col-md-12 col-xs-12">
                    <div class="form-group form-group-sm">
                      <label for="attach" class="control-label">{{__('general.entry_mail_attach')}} <span class="required text-danger">*</span></label>
                      <select id='attach' name='attach[]' class="form-control" multiple="multiple">
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12 col-xs-12 editor_quill">
                      <div class="form-group form-group-sm">
                        <label for="attach" class="control-label">{{__('general.entry_mail_message')}} <span class="required text-danger">*</span></label>
                      </div>
                      <div name="message" id="message" class="mb-4"></div>
                  </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="pull-right">
            <button type="button" id="send_mail_button" class="btn btn-xs btn-info "> <i class="fas fa-paper-plane"> Enviar </i></button>
            <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal"> <i class="fa fas fa-times"> {{ __('general.button_close') }} </i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /modal about -->

  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View customers invoices show') )
  <style media="screen">
    .editor-wrapper {
      min-height: 250px;
      background-color: #fff;
      border-collapse: separate;
      border: 1px solid #ccc;
      padding: 4px;
      box-sizing: content-box;
      box-shadow: rgba(0,0,0,.07451) 0 1px 1px 0 inset;
      overflow: scroll;
      outline: 0;
      border-radius: 3px;
    }
    .editor_quill {
      margin-bottom: 5rem !important;
    }
  </style>

  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
  <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
  <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>


  {{-- <script src="{{ asset('plugins/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery.hotkeys/jquery.hotkeys.js') }}"></script>

  <link rel="stylesheet" href="{{ asset('plugins/google-code-prettify/src/prettify.css') }}" type="text/css" />
  <script src="{{ asset('plugins/google-code-prettify/src/prettify.js') }}"></script> --}}

  {{-- <link rel="stylesheet" href="{{ asset('plugins/summernote-develop/dist/summernote-bs4.css') }}" type="text/css" />
  <script src="{{ asset('plugins/summernote-develop/dist/summernote.js') }}"></script> --}}

  <!-- Main Quill library -->
  <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
  {{-- <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script> --}}

  <!-- Theme included stylesheets -->
  <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  {{-- <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet"> --}}

  <!-- Core build with no theme, formatting, non-essential modules -->
  {{-- <link href="//cdn.quilljs.com/1.3.6/quill.core.css" rel="stylesheet">
  <script src="//cdn.quilljs.com/1.3.6/quill.core.js"></script> --}}
  <style media="screen">
    .white {background-color: #ffffff;}
    .select2-selection__rendered {
      line-height: 44px !important;
      padding-left: 20px !important;
    }
    .select2-selection {
      height: 42px !important;
    }
    .select2-selection__arrow {
      height: 36px !important;
    }
    th { font-size: 12px !important; }
    td { font-size: 10px !important; }


  </style>
  <script type="text/javascript">
      var quill;

      $(function() {
        //-----------------------------------------------------------
        if ($("#message").length) {
            quill = new Quill('#message', {
            modules: {
              toolbar: [
                [{
                  header: [1, 2, false]
                }],
                ['bold', 'italic', 'underline'],
                // ['image', 'code-block']
              ]
            },
            placeholder: 'Ingresé su mensaje...',
            theme: 'snow' // or 'bubble'
          });
        }
        //-----------------------------------------------------------
        $("#form").validate({
          ignore: "input[type=hidden]",
          errorClass: "text-danger",
          successClass: "text-success",
          errorPlacement: function (error, element) {
              var attr = $('[name="'+element[0].name+'"]').attr('datas');
              if (element[0].id === 'fileInput') {
                error.insertAfter($('#cont_file'));
              }
              else {
                if(attr == 'filter_date_from'){
                  error.insertAfter($('#date_from'));
                }
                else if (attr == 'filter_date_to'){
                  error.insertAfter($('#date_to'));
                }
                else {
                  error.insertAfter(element);
                }
              }
            },
            rules: {

            },
            messages: {
            },
            // debug: true,
            // errorElement: "label",
            submitHandler: function(e){
              var form = $('#form')[0];
              var formData = new FormData(form);
              $.ajax({
                type: "POST",
                url: "/sales/customer-invoices-search",
                data: formData,
                contentType: false,
                processData: false,
                success: function (data){
                  table_filter(data, $("#table_filter_fact"));
                  if (typeof data !== 'undefined' && data.length > 0) {
                    console.log(data.length);
                  }
                  else {

                  }
                },
                error: function (err) {
                  Swal.fire({
                     type: 'error',
                     title: 'Oops...',
                     text: err.statusText,
                   });
                }
              });
            }
        });
        //-----------------------------------------------------------
        $("#form input[name='filter_date_from']").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY'
            },
            autoUpdateInput: false
        }, function (chosen_date) {
            $("#form input[name='filter_date_from']").val(chosen_date.format('DD-MM-YYYY'));
        });
        $("#form input[name='filter_date_to']").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY'
            },
            autoUpdateInput: false,
        }, function (chosen_date) {
            $("#form input[name='filter_date_to']").val(chosen_date.format('DD-MM-YYYY'));
        });
        $("#filter_customer_id").select2();
        //-----------------------------------------------------------
      });

      function table_filter(datajson, table){
        table.DataTable().destroy();
        var vartable = table.dataTable(Configuration_table_responsive_doctypes);
        vartable.fnClearTable();
        $.each(JSON.parse(datajson), function(index, information){
          var status = information.status;
          var mail = information.mail_sent;

          var OPEN = "{{ \App\Models\Sales\CustomerInvoice::OPEN }}";
          var PAID = "{{ \App\Models\Sales\CustomerInvoice::PAID }}";
          var CANCEL = "{{ \App\Models\Sales\CustomerInvoice::CANCEL }}";
          var RECONCILED = "{{ \App\Models\Sales\CustomerInvoice::RECONCILED }}";
          var CANCEL_PER_AUTHORIZED = "{{ \App\Models\Sales\CustomerInvoice::CANCEL_PER_AUTHORIZED }}";
          var html = "";

          if (parseInt(status) == OPEN) {
              html = '<span class="badge badge-info">{{__("customer_invoice.text_status_open")}}</span>';
          } else if (parseInt(status) == PAID) {
              html = '<span class="badge badge-primary">{{__("customer_invoice.text_status_paid")}}</span>';
          } else if (parseInt(status) == CANCEL) {
              html = '<span class="badge badge-secondary">{{__("customer_invoice.text_status_cancel")}}</span>';
          } else if (parseInt(status) == CANCEL_PER_AUTHORIZED) {
              html = '<span class="badge badge-dark">{{__("customer_invoice.text_status_cancel_per_authorized")}}</span>';
          } else if (parseInt(status) == RECONCILED) {
              html = '<span class="badge badge-success">{{__("customer_credit_note.text_status_reconciled")}}</span>';
          }

          if (parseInt(mail) != 0) {
              mail_status = '<i class="fas fa-check text-success"></i>';
          }
          else {
            mail_status = '<i class="fas fa-times text-danger"></i>';
          }

          var a01 = '<div class="btn-group">';
          var a02 = '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>';
          var a03 = '<div class="dropdown-menu">';
          var a04 = '<a class="dropdown-item" target="_blank" href="/sales/customer-invoice-pdfs/'+information.id+'"><i class="fa fa-eye"></i> @lang('general.button_show')</a>';
          var a05 = '', a06 ='', a07 ='', a08 ='', a09 ='', a10 ='', a11 ='', a12 ='', a13 ='', a14 ='', a15 ='', a16='', a17='', a19='';
          if ( parseInt(status) == OPEN || parseInt(status) == PAID || parseInt(status) == CANCEL && information.uuid != ""  ) {
            a05 = '<a class="dropdown-item" href="/sales/customer-invoices/download-xml/'+information.id+'"><i class="far fa-file-code"></i> @lang('general.button_download_xml')</a>';
            a06 = '<a class="dropdown-item" href="javascript:void(0);" onclick="link_send_mail(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-envelope"></i> @lang('general.button_send_mail')</a>';
          }
          if (parseInt(mail) == 0) {
            a08 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_sent(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-hand-paper"></i> @lang('customer_invoice.text_mark_sent')</a>';
          }
          if (parseInt(status) == PAID) {
            a09 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_open(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-hand-paper"></i> @lang('customer_invoice.text_mark_open')</a>';
          }
          if (parseInt(status) == OPEN) {
            a10 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_paid(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-hand-paper"></i> @lang('customer_invoice.text_mark_paid')</a>';
          }
          if ( information.balance < information.amount_total ) {
            a11 = '<a class="dropdown-item" href="javascript:void(0);" onclick="payment_history(this)" value="'+information.id+'" datas="'+information.name+'"><i class="fa fa-history"></i> @lang('customer_invoice.text_payment_history')</a>';
          }
          if ( information.uuid != "" ) {
            a12 = '<a class="dropdown-item" href="javascript:void(0);" onclick="link_status_sat(this)" value="'+information.id+'" datas="'+information.name+'" ><i class="far fa-question-circle"></i> @lang('general.button_status_sat')</a>';
          }
          if ( information.uuid != "" ) {
            a19 = '<a class="dropdown-item" href="javascript:void(0);" onclick="link_send_poliza(this)" value="'+information.id+'" datas="'+information.name+'" ><i class="fas fa-file-alt"></i> Enviar a póliza</a>';
          }
          if ( parseInt(status) != CANCEL || parseInt(status) != CANCEL_PER_AUTHORIZED || information.balance >= information.amount_total ) {
            a13 = '<div class="dropdown-divider"></div>';
            a14 = '<a class="dropdown-item" href="javascript:void(0);"  onclick="link_cancel(this)" value="'+information.id+'" datas="'+information.name+'"><i class="fas fa-trash-alt"></i> @lang('general.button_cancel')</a>';
            a15 = '</div>';
          }
          if ( parseInt(status) == CANCEL_PER_AUTHORIZED ) {
            a16 = '<a class="dropdown-item" href="javascript:void(0);" onclick="cancel_authorized(this)" value="'+information.id+'" datas="'+information.name+'" ><i class="far fa-question-circle"></i> @lang('customer_invoice.text_cancel_authorized')</a>';
            a17 = '<a class="dropdown-item" href="javascript:void(0);" onclick="cancel_rejected(this)" value="'+information.id+'" datas="'+information.name+'" ><i class="far fa-question-circle"></i> @lang('customer_invoice.text_cancel_rejected')</a>';
          }
          var a18 = '</div>';
          var dropdown = a01+a02+a03+a04+a05+a06+a07+a08+a09+a10+a11+a12+a19+a13+a14+a15+a16+a17+a18;

          vartable.fnAddData([
            dropdown,
            information.name,
            information.date,
            information.uuid,
            information.customer,
            information.salesperson,
            information.date_due,
            information.currency,
            information.amount_total,
            information.balance,
            mail_status,
            html,
          ]);
        });
      }

      $('.table-responsive').on('show.bs.dropdown', function () {
           $('.table-responsive').css( "overflow", "inherit" );
      });

      $('.table-responsive').on('hide.bs.dropdown', function () {
           $('.table-responsive').css( "overflow", "auto" );
      })

      var Configuration_table_responsive_doctypes = {
        "columnDefs": [
            {
                "targets": 10,
                "className": "text-center",
            },
            {
                "targets": 11,
                "className": "text-center",
            }
        ],
        dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          "order": [[ 7, "asc" ]],
          buttons: [

            {
              extend: 'excelHtml5',
              title: 'Facturas',
              init: function(api, node, config) {
                 $(node).removeClass('btn-secondary')
              },
              text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
              titleAttr: 'Excel',
              className: 'btn btn-success btn-sm',
              exportOptions: {
                  columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
              },
            },
            {
              extend: 'csvHtml5',
              title: 'Facturas',
              init: function(api, node, config) {
                 $(node).removeClass('btn-secondary')
              },
              text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
              titleAttr: 'CSV',
              className: 'btn btn-primary btn-sm',
              exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
              },
            }
        ],
        "processing": true,
        language:{
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "<i class='fa fa-search'></i> Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
          },
          "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
        }
      };

      //Marcar como enviada
      function mark_sent(e){
        var valor= e.getAttribute('value');
        var _token = $('meta[name="csrf-token"]').attr('content');
        var folio = e.getAttribute('datas');
          Swal.fire({
          title: '¿Estás seguro?',
          text: "Se marcara como enviada, la factura con folio: "+folio,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Aceptar',
          cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.value) {
              $.ajax({
                   type: "POST",
                   url: '/sales/customer-invoices/mark-sent',
                   data: {token_b : valor, _token : _token},
                   success: function (data) {
                    if(data.status == 200){
                      Swal.fire('Operación completada!', '', 'success')
                      .then(()=> {
                        location.href ="/sales/customer-invoices-show";
                      });
                    }
                    else {
                      Swal.fire({
                         type: 'error',
                         title: 'Oops... Error: '+data.status,
                         text: 'El recurso no se ha modificado, por el motivo que ya esta marcada como enviada',
                      });
                    }
                   },
                   error: function (err) {
                     Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: err.statusText,
                      });
                   }
               })
            }
          })
      }
      //Marcar como pagada
      function mark_paid(e){
        var valor= e.getAttribute('value');
        var _token = $('meta[name="csrf-token"]').attr('content');
        var folio = e.getAttribute('datas');
          Swal.fire({
          title: '¿Estás seguro?',
          // text: "Se marcara como pagada, la factura con folio: "+folio,
          html: "Se marcara como pagada, la factura con folio: "+folio +
            "<br><br><div><label>Fecha de cobro: </label><input style='display: block;' class='datepicker form-control' type='text' placeholder='Fecha del cobro' id='fecha_cobro'></div>"+
            "<div><label>Banco: </label><select class='form-control' style='display: block;' id='banco'></select></div>",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Aceptar',
          cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.value) {
              var fecha_cobro = $('#fecha_cobro').val();
              var banco = $('#banco').val();
              $('.cancel').prop('disabled', 'disabled');
              $('.confirm').prop('disabled', 'disabled');
              if(fecha_cobro === ''){
                Swal.fire("Operación abortada", "Debe seleccionar la fecha del cobro.", "error")
              }else if(banco === ''){
                Swal.fire("Operación abortada", "Debe elegir un banco.", "error")
              }else{
                $.ajax({
                     type: "POST",
                     url: '/sales/customer-invoices/mark-paid',
                     data: {token_b : valor, banco : banco , fecha_cobro : fecha_cobro , _token : _token},
                     success: function (data) {
                      if(data.status == 200){
                        Swal.fire('Pago registrado!', '', 'success')
                        .then(()=> {
                          location.href ="/sales/customer-invoices-show";
                        });
                      }
                      else {
                        Swal.fire({
                           type: 'error',
                           title: 'Oops... Error: '+data.status,
                           text: 'El recurso no se ha modificado, por el motivo que ya esta marcada como pagada',
                        });
                      }
                     },
                     error: function (err) {
                       Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: err.statusText,
                        });
                     }
                })
              }
            }
          })
        $(".swal-wide").scrollTop(0);
        var $options = $("#aux > option").clone();
        $('#banco').append($options);
        // $('#factura').val(name_fact);
        $('.datepicker').datepicker({
          language: 'es',
          format: "yyyy-mm-dd",
          viewMode: "days",
          minViewMode: "days",
          //endDate: '1m',
          autoclose: true,
          clearBtn: true
        });
      }
      //Marcar como abierta
      function mark_open(e){
        var valor= e.getAttribute('value');
        var folio= e.getAttribute('datas');
        var _token = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
        title: '¿Estás seguro?',
        text: "Se marcara como abierta, la factura con folio: "+folio,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
            $.ajax({
                 type: "POST",
                 url: '/sales/customer-invoices/mark-open',
                 data: {token_b : valor, _token : _token},
                 success: function (data) {
                  if(data.status == 200){
                    Swal.fire('Operación completada!', '', 'success')
                    .then(()=> {
                      location.href ="/sales/customer-invoices-show";
                    });
                  }
                  else {
                    Swal.fire({
                       type: 'error',
                       title: 'Oops... Error: '+data.status,
                       text: 'El recurso no se ha modificado',
                    });
                  }
                 },
                 error: function (err) {
                   Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: err.statusText,
                    });
                 }
             })
          }
        });
      }
      //Cancelación autorizada
      function cancel_authorized(e){
        var valor= e.getAttribute('value');
        var folio= e.getAttribute('datas');
        var _token = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
        title: '¿Estás seguro?',
        text: "Se marcara como cancelación autorizada, la factura con folio: "+folio,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
            $.ajax({
                 type: "POST",
                 url: '/sales/customer-invoices/cancel-authorized',
                 data: {token_b : valor, _token : _token},
                 success: function (data) {
                  if(data.status == 200){
                    Swal.fire('Operación completada!', '', 'success')
                    .then(()=> {
                      location.href ="/sales/customer-invoices-show";
                    });
                  }
                  else {
                    Swal.fire({
                       type: 'error',
                       title: 'Oops... Error: '+data.status,
                       text: 'El recurso no se ha modificado',
                    });
                  }
                 },
                 error: function (err) {
                   Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: err.statusText,
                    });
                 }
             })
          }
        });
      }
      //Cancelación rechazada
      function cancel_rejected(e){
        var valor= e.getAttribute('value');
        var folio= e.getAttribute('datas');
        var _token = $('meta[name="csrf-token"]').attr('content');
        Swal.fire({
        title: '¿Estás seguro?',
        text: "Se marcara como cancelación rechazada, la factura con folio: "+folio,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
            $.ajax({
                 type: "POST",
                 url: '/sales/customer-invoices/cancel-rejected',
                 data: {token_b : valor, _token : _token},
                 success: function (data) {
                  if(data.status == 200){
                    Swal.fire('Operación completada!', '', 'success')
                    .then(()=> {
                      location.href ="/sales/customer-invoices-show";
                    });
                  }
                  else {
                    Swal.fire({
                       type: 'error',
                       title: 'Oops... Error: '+data.status,
                       text: 'El recurso no se ha modificado',
                    });
                  }
                 },
                 error: function (err) {
                   Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: err.statusText,
                    });
                 }
             })
          }
        });
      }
      //Historial de pagos
      function payment_history(e){
        var valor= e.getAttribute('value');
        var folio= e.getAttribute('datas');
        var _token = $('meta[name="csrf-token"]').attr('content');
        // $('#modal-history').modal('show');
        $.ajax({
             type: "POST",
             url: '/sales/customer-invoices/modal-payment-history-head',
             data: {token_b : valor, _token : _token},
             success: function (data) {
               if ($.trim(data)){
                 $('#modal-history').modal('show');
                 datax = JSON.parse(data);
                 $("#name").val(datax[0].name);
                 $("#customer").val(datax[0].customer);
                 $("#branch_office").val(datax[0].branch_office);
                 $("#currency").val(datax[0].currency);
                 $("#currency_value").val(datax[0].currency_value);
                 $("#amount_total").val(datax[0].amount_total);
                 $("#balance").val(datax[0].balance);
                 $("#reconciled").val(datax[0].amount_total-datax[0].balance);
                 $.ajax({
                      type: "POST",
                      url: '/sales/customer-invoices/modal-payment-history',
                      data: {token_b : valor, _token : _token},
                      success: function (data) {
                        table_payments(data, $("#payment_history_all"));
                      },
                      error: function (err) {
                        Swal.fire({
                           type: 'error',
                           title: 'Oops...',
                           text: err.statusText,
                         });
                      }
                 })
               }
             },
             error: function (err) {
               Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: err.statusText,
                });
             }
        })
      }
      function table_payments(datajson, table){
        table.DataTable().destroy();
        var vartable = table.dataTable(Configuration_table_responsive_history);
        vartable.fnClearTable();
        $.each(JSON.parse(datajson), function(index, status){
          vartable.fnAddData([
            status.name,
            status.currency,
            status.date,
            status.payment_way,
            status.amount_reconciled,
            status.amount,
          ]);
        });
      }
      var Configuration_table_responsive_history={
        dom: "<'row'<'col-sm-3'l><'col-sm-9'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "order": [[ 0, "asc" ]],
        paging: true,
        //"pagingType": "simple",
        Filter: true,
        searching: false,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
        //ordering: false,
        //"pageLength": 5,
        bInfo: false,
            language:{
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                  "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                      "sFirst":    "Primero",
                      "sLast":     "Último",
                      "sNext":     "Siguiente",
                      "sPrevious": "Anterior"
                  },
                  "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
            }
      }
      //Modal para estatus de CFDI
      function link_status_sat(e){
        var valor= e.getAttribute('value');
        var folio= e.getAttribute('datas');
        var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
             type: "POST",
             url: '/sales/customer-invoices/modal-status-sat',
             data: {token_b : valor, _token : _token},
             success: function (data) {
               $('#text_a').text(data.uuid);
               $('#text_b').text(data.rfcE);
               $('#text_c').text(data.rfcR);
               $('#text_d').text(data.amount_total);
               $('#text_e').text(data.text_is_cancelable_cfdi);
               $('#text_f').text(data.text_status_cfdi);
               $('#modal_customer_invoice_status_sat').modal('show');
             },
             error: function (err) {
               Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: err.statusText,
                });
             }
        })
      }
      //Cancelacion de CFDi
      function link_cancel(e){
        var valor= e.getAttribute('value');
        var folio= e.getAttribute('datas');
        var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
             type: "POST",
             url: '/sales/customer-invoices/modal-cancel',
             data: {token_b : valor, _token : _token},
             success: function (data) {
               var cancelable = data.data_status_sat['cancelable'];
               var cancel_state = data.data_status_sat['pac_is_cancelable'];
               var pac_status = data.data_status_sat['pac_status'];

               Swal.fire({
               title: '¿Estás seguro de cancelar la Factura '+folio+'?',
               html: "Esta acción no se podrá deshacer una vez confirmada la cancelación"+'<br>'+
                     '<strong>@lang('general.text_is_cancelable_cfdi') = </strong>' + cancel_state +'<br>'+
                     '<strong>@lang('general.text_status_cfdi') = </strong>' + pac_status +'<br>',
               type: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Confirmar',
               cancelButtonText: 'Cancelar'
               }).then((result) => {
                 if (result.value) {
                   $.ajax({
                        type: "POST",
                        url: '/sales/customer-invoices/destroy',
                        data: {token_b : valor, cancelable : cancelable, cancel_state: cancel_state,_token : _token},
                        success: function (data) {
                          if(data.status == 200){
                            Swal.fire('Operación completada!', '', 'success')
                            .then(()=> {
                              location.href ="/sales/customer-invoices-show";
                            });
                          }
                          if(data.error == 304){
                            Swal.fire({
                               type: 'error',
                               title: 'Oops...',
                               text:  'La Factura '+folio+', se encuentra cancelada',
                             });
                          }
                        },
                        error: function (err) {
                          Swal.fire({
                             type: 'error',
                             title: 'Oops...',
                             text: err.statusText,
                           });
                        }
                   })
                 }
               });
             },
             error: function (err) {
               Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: err.statusText,
                });
             }
        })
      }

      //Modal para envio de correo
      function link_send_mail(e){
        var valor= e.getAttribute('value');
        var folio= e.getAttribute('datas');
        var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
             type: "POST",
             url: '/sales/customer-invoices/modal-send-mail',
             data: {token_b : valor, _token : _token},
             success: function (data) {
               console.log(data);
               $("#modal_customer_invoice_send_mail").modal("show");
               /*Quill editor*/
                  var inicio = 'Le remitimos adjunta la siguiente factura:';
                  var factura = 'Factura= '+data.customer_invoice.name;
                  var cliente = 'Cliente= '+data.customer_invoice.customer.name;
                  var fecha = 'Fecha = '+data.customer_invoice.date;
                  $("#to").html('');

                  quill.setContents([
                      { insert: inicio, attributes: { bold: true } },
                      { insert: '\n' },
                      { insert: factura, attributes: { bold: false } },
                      { insert: '\n' },
                      { insert: cliente, attributes: { bold: false } },
                      { insert: '\n' },
                      { insert: fecha, attributes: { bold: false } },
                      { insert: '\n' }
                    ]);

               //Correos para
               $("#modal_customer_invoice_send_mail .modal-body select[name='to\[\]']").select2({
                   placeholder: "@lang('general.text_select')",
                   theme: "bootstrap",
                   width: "auto",
                   dropdownAutoWidth: true,
                   language: "{{ str_replace('_', '-', app()->getLocale()) }}",
                   tags: true,
                   tokenSeparators: [',', ' '],
                   data: data.to_selected[0],
               });
               $("#modal_customer_invoice_send_mail .modal-body select[name='to\[\]']").val(data.to_selected[0]).trigger("change");
               $('#to option').each(function(){
                    $(this).prop('selected', true);
                });
               //Archivos
               $("#modal_customer_invoice_send_mail .modal-body select[name='attach\[\]']").select2({
                   placeholder: "@lang('general.text_select')",
                   theme: "bootstrap",
                   width: "auto",
                   dropdownAutoWidth: true,
                   language: "{{ str_replace('_', '-', app()->getLocale()) }}",
                   disabled: true,
                   data: data.files_selected
               });
               $("#modal_customer_invoice_send_mail .modal-body select[name='attach\[\]']").val(data.files_selected).trigger("change");

               $("#customer_invoice_id").val(data.customer_invoice.id);
               $("#fact_name").val(data.customer_invoice.name);
               $("#cliente_name").val(data.customer_invoice.customer.name);
               //Asunto
               $("#subject").val(data.customer_invoice.name);
               //PARA
               // $("#modal_customer_invoice_send_mail .modal-body select[name='to\[\]']").select2({data: data.to_selected});
               //

               // $("#modal_customer_invoice_send_mail .modal-body select[name='attach\[\]']").select2({data: data.files});
               // $("#modal_customer_invoice_send_mail .modal-body select[name='attach\[\]']").val(data.files).trigger("change");
               //
               // $("#modal_customer_invoice_send_mail .modal-body select[name='to\[\]']").val(data.to_selected);
               // $("#to").select2("val", $("#to").select2("val").concat(data.to_selected));

             },
             error: function (err) {
               Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: err.statusText,
                });
             }
        })
      }


    $('#send_mail_button').on('click', function(){
      let _token = $('meta[name="csrf-token"]').attr('content');
      let form = $('#form_email_fact')[0];
      let formData = new FormData(form);
      const headers = new Headers({
               "Accept": "application/json",
               "X-Requested-With": "XMLHttpRequest",
               "X-CSRF-TOKEN": _token
             })

      let miInit = { method: 'post',
                        headers: headers,
                        body: formData,
                        credentials: "same-origin",
                        cache: 'default' };

      fetch('customer-invoices-sendmail-fact', miInit)
        .then(res => {
          return res.json();
        })
        .then(data => {
          if(data.code == 200){
            Swal.fire(data.message,'','success');
          }else{
            Swal.fire('Ocurrio un error inesperado',
            'Revise que los correos sean validos.',
            'error');
          }
        })
        .catch(error => {
          Swal.fire('Ocurrio un error inesperado','','error');
        })
    })

    function link_send_poliza(e){
      let id_invoice = e.getAttribute('value');
      console.log(id_invoice);
      let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          type: "POST",
          url: '/sales/customer-invoices/send_invoice_to_poliza',
          data: {id_invoice : id_invoice, _token : _token},
          success: function (data) {
            if(data.code == 200){
              Swal.fire('Operación completada!', data.message, 'success')
              .then(()=> {
                location.href ="/sales/customer-invoices-show";
              });
            }

          },
          error: function (err) {
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: err.statusText,
              });
          }
      })
    }
  </script>
  @else
  @endif
@endpush
