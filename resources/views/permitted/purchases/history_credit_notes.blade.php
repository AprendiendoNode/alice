@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View account to pay') )
    Historial de Nota de crédito - Compras
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customer credit notes purchases') )
    Historial de Nota de crédito - Compras
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
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

  @if( auth()->user()->can('View customer credit notes purchases') )
    <div class="row">
      <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
          <div class="card-body">
            <form id="form" name="form" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="row">
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
                    <label for="filter_customer_id">Cliente</label>
                    <select class="form-control" id="filter_customer_id" id="filter_customer_id">
                      <option value="" selected>Selecciona...</option>
                      @forelse ($providers as $providers_data)
                        <option value="{{ $providers_data->id  }}">{{ $providers_data->name }}</option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <!--
                <div class="col-md-2 col-xs-12">
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
                -->
                <div class="col-md-1 col-xs-12 pt-3">
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
              <table id="table_filter_fact" name='table_filter_fact' class="table table-striped table-hover table-condensed table-sm">
                <thead>
                  <tr>
                      <th class="text-center" width="5%">@lang('general.column_actions')</th>
                      <th class="text-center">Folio</th>
                      <th class="text-center">Cliente</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Moneda</th>
                      <th class="text-center">Total</th>
                      <th class="text-center">Saldo</th>
                      <th class="text-center">Enviada</th>
                      <th class="text-center">Estatus</th>

                  </tr>
                </thead>
              </table>
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
  @if( auth()->user()->can('View customer credit notes purchases') )
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
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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
    <script src="{{ asset('js/admin/purchases/history_credit_notes.js')}}"></script>

  @else
  @endif
@endpush
