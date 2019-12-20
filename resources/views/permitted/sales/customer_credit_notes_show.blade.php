@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    Historial de {{ trans('invoicing.customers_credit_notes') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    Historial de {{ trans('invoicing.customers_credit_notes') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
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
                  <select class="form-control" id="filter_customer_id" id="filter_customer_id">
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
                        {{__('customer_credit_note.column_name')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_credit_note.column_date')}}
                    </th>
                    <th class="text-center">
                        @lang('customer_credit_note.column_uuid')
                    </th>
                    <th class="text-left">
                        {{__('customer_credit_note.column_customer')}}
                    </th>
                    <th class="text-left">
                        {{__('customer_credit_note.column_salesperson')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_credit_note.column_currency')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_credit_note.column_amount_total')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_credit_note.column_balance')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_credit_note.column_mail_sent')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_credit_note.column_status')}}
                    </th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  @else
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View customers invoices show') )
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
    <!-- Main Quill library -->
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
    <!-- Theme included stylesheets -->
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <script type="text/javascript">
    $(function() {
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
            url: "/sales/customer-credit-notes-searchfilter",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              if (typeof data !== 'undefined' && data.length > 0) {
                table_filter(data, $("#table_filter_fact"));
              }
              else {
                console.log(data.length);
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
        var html = "";

        if (parseInt(status) == OPEN) {
          html = '<span class="badge badge-success">{{__("customer_credit_note.text_status_open")}}</span>';
        }
        else if (parseInt(status) == PAID) {
          html = '<span class="badge badge-success">{{__("customer_credit_note.text_status_paid")}}</span>';
        }
        else if (parseInt(status) == CANCEL) {
          html = '<span class="badge badge-success">{{__("customer_credit_note.text_status_cancel")}}</span>';
        }
        else if (parseInt(status) == RECONCILED) {
          html = '<span class="badge badge-success">{{__("customer_credit_note.text_status_reconciled")}}</span>';
        }
        else {
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
        var a14 = '</div>';
        var a15 = '</div>';
        var dropdown = a01+a02+a03+a14+a15;

        vartable.fnAddData([
          dropdown,
          information.name,
          information.date,
          information.uuid,
          information.customer,
          information.salesperson,
          information.currency,
          information.amount_total,
          information.balance,
          mail_status,
          html,
        ]);
      });
    }
    function ta(datajson, table){
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
        var html = "";

        if (parseInt(status) == OPEN) {
          html = '<span class="badge badge-success">{{__("customer_credit_note.text_status_open")}}</span>';
        }
        else if (parseInt(status) == PAID) {
          html = '<span class="badge badge-success">{{__("customer_credit_note.text_status_paid")}}</span>';
        }
        else if (parseInt(status) == CANCEL) {
          html = '<span class="badge badge-success">{{__("customer_credit_note.text_status_cancel")}}</span>';
        }
        else if (parseInt(status) == RECONCILED) {
          html = '<span class="badge badge-success">{{__("customer_credit_note.text_status_reconciled")}}</span>';
        }
        else {
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
        var a04 = '<a class="dropdown-item" target="_blank" href="/sales/customer-invoice-pdf/'+information.id+'"><i class="fa fa-eye"></i> @lang('general.button_show')</a>';
        var a05 = '<a class="dropdown-item" href="/sales/customer-invoices/download-xml/'+information.id+'"><i class="far fa-file-code"></i> @lang('general.button_download_xml')</a>';
        var a06 = '<a class="dropdown-item" href="javascript:void(0);" onclick="link_send_mail(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-envelope"></i> @lang('general.button_send_mail')</a>';
        var a07 = '<a class="dropdown-item" href="javascript:void(0);"><i class="fa fa-print"></i> @lang('general.button_print')</a>';
        var a08 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_sent(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-hand-paper"></i> @lang('customer_credit_note.text_mark_sent')</a>';
        var a09,a10,a12,a13,a14;
        if (parseInt(status) == RECONCILED) {
          var a09 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_open(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-hand-paper"></i> @lang('customer_credit_note.text_mark_open')</a>';
        }
        if (parseInt(status) == OPEN) {
          var a10 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_reconciled(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-hand-paper"></i> @lang('customer_credit_note.text_mark_reconciled')</a>';
        }
        var a11 = '<a class="dropdown-item" href="javascript:void(0);" onclick="link_status_sat(this)" value="'+information.id+'" datas="'+information.name+'" ><i class="far fa-question-circle"></i> @lang('general.button_status_sat')</a>';
        if (parseInt(status) == CANCEL) {
          var a12 = '<div class="dropdown-divider"></div>';
          var a13 = '<a class="dropdown-item" href="javascript:void(0);"  onclick="link_cancel(this)" value="'+information.id+'" datas="'+information.name+'"><i class="fas fa-trash-alt"></i> @lang('general.button_cancel')</a>';
        }
        var a14 = '</div>';
        var a15 = '</div>';
        var dropdown = a01+a02+a03+a04+a05+a06+a07+a08+a10+a11+a12+a13+a14+a15;

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

    var Configuration_table_responsive_doctypes = {
      dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "order": [[ 1, "asc" ]],
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
                columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
              columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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

    //-----------------------------------------------------------
    </script>
  @else
  @endif
@endpush
