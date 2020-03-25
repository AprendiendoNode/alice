@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View customers invoices') )
    Historial - Complemento de pago
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customers invoices') )
    Historial - Complemento de pago
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  <!-- Estatus sat-->
  <div id="modal_customer_invoice_status_sat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalhistory" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <h4 class="modal-title" id="modalhistory"> {{ __('customer_invoice.text_modal_status_sat')}} <span id='text_folio'></span> </h4>
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

            <div class="col-9 my-4">
              <p>
                <strong>Folio fiscal (UUID) = </strong> <br> <span id='text_a'></span>
              </p>
              <p>
                <strong>@lang('general.text_is_cancelable_cfdi') = </strong> <span id='text_b'></span>
              </p>
              <p>
                <strong>@lang('general.text_status_cfdi') = </strong> <span id='text_c'></span>
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

  @if( auth()->user()->can('View customers invoices') )
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
                      {{ __('customer_payment.entry_name') }}
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
                    <label for="filter_payment_way_id">{{ __('customer_payment.entry_payment_way_id') }}</label>
                    <select class="form-control" id="filter_payment_way_id" name="filter_payment_way_id">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($payment_way as $payment_way_data)
                        <option value="{{ $payment_way_data->id }}"> [{{ $payment_way_data->code }}] {{ $payment_way_data->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>

                <div class="col-md-6 col-xs-12">
                  <label for="customer_id" class="control-label  my-2">Clientes:</label>
                  <div class="input-group">
                    <select class="custom-select" id="customer_id" name="customer_id">
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
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="filter_status">Estado: </label>
                    <select class="form-control" id="filter_status" name="filter_status">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      <option value="0"> Todos </option>
                      @forelse ($list_status as $key => $value)
                        <option value="{{ $key }}"> {{ $value }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 pt-4">
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
                    <th></th>
                    <th class="text-center" width="5%">
                      Opciones
                    </th>
                    <th class="text-center">
                        {{__('customer_payment.column_name') }}
                    </th>
                    <th class="text-center">
                        {{__('customer_payment.column_date') }}
                    </th>
                    <th class="text-center">
                        @lang('customer_payment.column_uuid')
                    </th>
                    <th class="text-left">
                        {{__('customer_payment.column_customer') }}
                    </th>
                    <th class="text-left">
                        {{__('customer_payment.column_payment_way') }}
                    </th>
                    <th class="text-center">
                        {{__('customer_payment.column_date_payment') }}
                    </th>
                    <th class="text-center">
                        {{__('customer_payment.column_currency') }}
                    </th>
                    <th class="text-center">
                        {{__('customer_payment.column_amount') }}
                    </th>
                    <th class="text-center" width="5%">
                        {{__('customer_payment.column_balance') }} -<br> Por aplicar
                    </th>
                    <th class="text-center">
                        {{__('customer_payment.column_mail_sent') }}
                    </th>
                    <th class="text-center">
                        {{__('customer_payment.column_status') }}
                    </th>
                  </tr>
                </thead>
              </table>
            </div>

          </div>
        </div>
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

   <!----------------------MODAL POLIZA MOVIMIENTOS--------------------------->
   <div id="modal_view_poliza" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Póliza</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form_update_asientos_contables">
        <div class="modal-body">
          <!------TABLA DE PARTIDAS / ASIENTO CONTABLE------>
          <div class="row mt-2 mb-3">
            <div id="data_asientos" class="col-12 table-responsive">
              
            </div>
          </div>
          <!------------RESUMEN FACTURA--------->
          {{-- <div class="row mt-5">
            <div class="col-12 table-responsive">
              <table class="table table-sm">
                <thead class="bg-secondary text-white">
                  <tr>
                    <th>Org.</th>
                    <th>Partida</th>
                    <th>Dia</th>
                    <th>No.</th>
                    <th>Tipo</th>
                    <th>UUID / Folio</th>
                    <th>Beneficiario</th>
                    <th>Importe</th>
                  </tr>
                </thead>
                <tbody>       
                </tbody>
              </table>
            </div>
          </div> --}}  
        </div>
        <div class="modal-footer">
          @if( auth()->user()->can('Polizas update') )
            <button type="submit" id="update_poliza_partida" type="button" class="btn btn-primary">Guardar</button>
          @endif
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </form> 
      </div>
    </div>
  </div>
 <!----------------------------- FIN MODAL POLIZA MOVIMIENTOS--------------------------------->

  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View customers invoices') )
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

      #table_filter_fact tbody tr td {
        padding: 0.2rem 0.5rem;
        height: 38px !important;
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
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  
    <script type="text/javascript">
      $(function() {
        var quill;
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
          submitHandler: function(e){
            var form = $('#form')[0];
            var formData = new FormData(form);
            $.ajax({
              type: "POST",
              url: "/sales/customer-payments-search",
              data: formData,
              contentType: false,
              processData: false,
              success: function (data){
                if (typeof data !== 'undefined' && data.length > 0) {
                  table_filter(data, $("#table_filter_fact"));
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
        $("#customer_id").select2();
        //-----------------------------------------------------------
      });

      function table_filter(datajson, table){
        table.DataTable().destroy();
        var vartable = table.dataTable(Configuration_table_responsive_comp_pago);
        vartable.fnClearTable();
        $.each(JSON.parse(datajson), function(index, information){
          var status = information.status;
          var mail = information.mail_sent;

          var OPEN = "{{ \App\Models\Sales\CustomerPayment::OPEN }}";
          var RECONCILED = "{{ \App\Models\Sales\CustomerPayment::RECONCILED }}";
          var CANCEL = "{{ \App\Models\Sales\CustomerPayment::CANCEL }}";
          var html = "";

          if (parseInt(status) == OPEN) {
            html = '<span class="badge badge-success">{{__("customer_payment.text_status_open")}}</span>';
          }
          else if (parseInt(status) == RECONCILED) {
            html = '<span class="badge badge-info">{{__("customer_payment.text_status_reconciled")}}</span>';
          }
          else if (parseInt(status) == CANCEL) {
            html = '<span class="badge badge-secondary">{{__("customer_payment.text_status_cancel")}}</span>';
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
          var a05 = '', a06 = '', a07 = '', a08 = '', a09 = '', a10 = '', a11 = '', a12 = '', a13 = '';


          var a04 = '<a class="dropdown-item" target="_blank" href="/sales/customer-payments-pdf/'+information.id+'"><i class="fa fa-eye"></i> @lang('general.button_show')</a>';

          if ( parseInt(status) == OPEN && information.balance > 0 && information.uuid == "" ) {
            a05 = '<a class="dropdown-item" href="javascript:void(0);" onclick="modal_reconciled(this)" value="'+information.id+'" datas="'+information.folio+'"><i class="fas fa-sync"></i> @lang('general.button_payment_reconciled') </a>';
          }

          if ( parseInt(status) == OPEN || parseInt(status) == RECONCILED || parseInt(status) == CANCEL && information.uuid != ""  ) {
            a06 = '<a class="dropdown-item" href="/sales/customer-payments/download-xml/'+information.id+'"> <i class="far fa-file-code"></i> @lang('general.button_download_xml')</a>';
            a07 = '<a class="dropdown-item" href="javascript:void(0);" onclick="link_send_mail(this)" value="'+information.id+'" datas="'+information.name+'"><i class="far fa-envelope"></i> @lang('general.button_send_mail')</a>';
          }

          if (parseInt(mail) == 0) {
            a08 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_sent(this)" value="'+information.id+'" datas="'+information.folio+'"><i class="far fa-hand-paper"></i> @lang('customer_payment.text_mark_sent')</a>';
          }
          if (parseInt(status) == RECONCILED) {
            a09 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_open(this)" value="'+information.id+'" datas="'+information.folio+'"><i class="far fa-hand-paper"></i> @lang('customer_payment.text_mark_open')</a>';
          }
          if (parseInt(status) == OPEN) {
            a10 = '<a class="dropdown-item" href="javascript:void(0);" onclick="mark_reconciled(this)" value="'+information.id+'" datas="'+information.folio+'"><i class="far fa-hand-paper"></i> @lang('customer_payment.text_mark_reconciled')</a>';
          }
          if ( information.uuid != "" ) {
            a11 = '<a class="dropdown-item" href="javascript:void(0);" onclick="link_status_sat(this)" value="'+information.id+'" datas="'+information.folio+'" ><i class="far fa-question-circle"></i> @lang('general.button_status_sat')</a>';
          }
          if (parseInt(status) != CANCEL) {
            a12 = '<div class="dropdown-divider"></div>';
            a13 = '<a class="dropdown-item" href="javascript:void(0);"  onclick="link_cancel(this)" value="'+information.id+'" datas="'+information.folio+'"><i class="fas fa-trash-alt"></i> @lang('general.button_cancel')</a>';
          }
          var a14 = '</div>';
          var a15 = '</div>';

          var dropdown = a01+a02+a03+a04+a05+a06+a07+a08+a09+a10+a11+a12+a13+a14+a15;

          vartable.fnAddData([
            information.id,
            dropdown,
            information.folio,
            information.date,
            information.uuid,
            information.customers,
            information.payment_ways,
            information.date_payment,
            information.currencies,
            information.amount,
            information.balance,
            mail_status,
            html,
            information.contabilizado
          ]);
        });
      }

      var Configuration_table_responsive_comp_pago = {
        "order": [[ 2, "asc" ]],
        "select": true,
        "aLengthMenu": [[25, -1], [25, "Todos"]],
        "columnDefs": [
              {
                "targets": 0,
                "checkboxes": {
                  'selectRow': true
                },
                "width": "0.1%",
                "createdCell": function (td, cellData, rowData, row, col){
                  if ( cellData > 0 ) {
                    if(rowData[13] == 1){
                      this.api().cell(td).checkboxes.disable();
                      $(td).parent().attr('style', 'background: #D6FFBE !important');
                    }
                  }
                },
              "className": "text-center",
            },
            {
                "targets": 10,
                "width": "0.2%",
                "className": "text-center",
            },
            {
                "targets": 11,
                "className": "text-center",
            },
            {
                "targets": 12,
                "className": "text-center",
            },
            {
                "targets": 13,
                "visible": false,
            }
        ],
        dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          "order": [[ 7, "asc" ]],
        buttons: [
          {
            text: '<i class=""></i> Contabilizar',
            titleAttr: 'Contabilizar',
            className: 'btn btn-dark btn-sm',
            init: function(api, node, config) {
              $(node).removeClass('btn-default')
            },
            action: function ( e, dt, node, config ) {

              var rows_selected = $("#table_filter_fact").DataTable().column(0).checkboxes.selected();
              var _token = $('input[name="_token"]').val();
              // Iterate over all selected checkboxes
              var facturas= new Array();
              $.each(rows_selected, function(index, rowId){
                facturas.push(rowId);
              });
              if ( facturas.length === 0){
                Swal.fire(
                  'Debe selecionar al menos una factura',
                  '',
                  'warning'
                )
              }else{
                let _token = $('meta[name="csrf-token"]').attr('content');

                $("#tabla_asiento_contable tbody").empty();

                $.ajax({
                    type: "POST",
                    url: '/accounting/customer-polizas-get-movs',
                    data: {facturas: JSON.stringify(facturas) , _token : _token},
                    success: function (data) {

                      $('#data_asientos').html(data);
                      $('.cuenta_contable').select2();
                      let dia_factura = $('#dia_hidden').val();
                      let mes_factura = $('#mes_hidden').val();
                      let anio_factura = $('#anio_hidden').val();
                      let mes_format = moment(new Date(anio_factura, parseInt(mes_factura)- 1, dia_factura)).format('MMMM');

                      $('#mes_poliza').val(mes_format);
                    },
                    error: function (err) {
                      Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: err.statusText,
                        });
                    }
                })

                $("#modal_view_poliza").modal("show");
              }

            }
          },
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
                  columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
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
                columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
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

      function modal_reconciled(e) {
        var valor= e.getAttribute('value');
        var _token = $('meta[name="csrf-token"]').attr('content');
        var folio = e.getAttribute('datas');
        //Modal
      }

      function link_send_mail(e) {
        var valor= e.getAttribute('value');
        var _token = $('meta[name="csrf-token"]').attr('content');
        var folio = e.getAttribute('datas');
        //Modal
      }

      function mark_sent(e) {
        var valor= e.getAttribute('value');
        var _token = $('meta[name="csrf-token"]').attr('content');
        var folio = e.getAttribute('datas');
        Swal.fire({
        title: '¿Estás seguro?',
        text: "Se marcara como enviada, el complemento de pago con folio: "+folio,
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
                 url: '/sales/customer-payments/mark-sent',
                 data: {token_b : valor, _token : _token},
                 success: function (data) {
                  if(data.status == 200){
                    Swal.fire('Operación completada!', '', 'success')
                    .then(()=> {
                      location.href ="/sales/customer-payments-show";
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
        });
      }

      function mark_open(e) {
        var valor= e.getAttribute('value');
        var _token = $('meta[name="csrf-token"]').attr('content');
        var folio = e.getAttribute('datas');
        Swal.fire({
          title: '¿Estás seguro?',
          text: "Se marcara como abierta, el complemento de pago con folio: "+folio,
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
                url: '/sales/customer-payments/mark-open',
                data: {token_b : valor, _token : _token},
                success: function (data) {
                  if(data.status == 200){
                    Swal.fire('Operación completada!', '', 'success')
                    .then(()=> {
                      location.href ="/sales/customer-payments-show";
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
          });
      }

      function mark_reconciled(e) {
        var valor= e.getAttribute('value');
        var _token = $('meta[name="csrf-token"]').attr('content');
        var folio = e.getAttribute('datas');
        Swal.fire({
          title: '¿Estás seguro?',
          text: "Se marcara como conciliada, el complemento de pago con folio: "+folio,
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
                url: '/sales/customer-payments/mark-reconciled',
                data: {token_b : valor, _token : _token},
                success: function (data) {
                  if(data.status == 200){
                    Swal.fire('Operación completada!', '', 'success')
                    .then(()=> {
                      location.href ="/sales/customer-payments-show";
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
          });
      }

      function link_status_sat(e) {
        var valor= e.getAttribute('value');
        var _token = $('meta[name="csrf-token"]').attr('content');
        var folio = e.getAttribute('datas');
        $.ajax({
          type: "POST",
          url: '/sales/customer-payments/modal-status-sat',
          data: {token_b : valor, _token : _token},
          success: function (data) {
            $('#text_folio').text(data.folio);
            $('#text_a').text(data.uuid);
            $('#text_b').text(data.text_is_cancelable_cfdi);
            $('#text_c').text(data.text_status_cfdi);
            $('#modal_customer_invoice_status_sat').modal('show');
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

      function link_cancel(e) {
        var valor= e.getAttribute('value');
        var folio= e.getAttribute('datas');
        var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
             type: "POST",
             url: '/sales/customer-payments/modal-status-sat',
             data: {token_b : valor, _token : _token},
             success: function (data) {
               var folio = data.folio;
               var uuid = data.uuid;
               var is_cancelable_cfdi = data.text_is_cancelable_cfdi;
               var status_cfdi = data.text_status_cfdi;

               Swal.fire({
               title: '¿Estás seguro de cancelar, el complemento de pago '+folio+'?',
               html: "Esta acción no se podrá deshacer una vez confirmada la cancelación"+'<br>'+
                     '<strong>@lang('customer_payment.column_uuid') = </strong>' + uuid +'<br>'+
                     '<strong>@lang('general.text_is_cancelable_cfdi') = </strong>' + is_cancelable_cfdi +'<br>'+
                     '<strong>@lang('general.text_status_cfdi') = </strong>' + status_cfdi +'<br>',
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
                        url: '/sales/customer-payments/destroy',
                        data: {token_b : valor, cancelable : is_cancelable_cfdi, cancel_state: status_cfdi, _token : _token},
                        success: function (data) {
                          if(data.status == 200){
                            Swal.fire('Operación completada!', '', 'success')
                            .then(()=> {
                              location.href ="/sales/customer-payments-show";
                            });
                          }
                          if(data.error == 304){
                            Swal.fire({
                               type: 'error',
                               title: 'Oops...',
                               text:  'El complemento de pago con el folio '+folio+', se encuentra cancelada',
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
             url: '/sales/customer-payments/modal-send-mail',
             data: {token_b : valor, _token : _token},
             success: function (data) {
               console.log(data);
               $("#modal_customer_invoice_send_mail").modal("show");
               
                $("#to").html('');


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

      fetch('customer-payments-sendmail-fact', miInit)
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

    </script>

  @else
  @endif
@endpush
