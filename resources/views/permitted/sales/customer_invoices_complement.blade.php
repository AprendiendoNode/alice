@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View customers invoices show') )
    <!--{{ trans('invoicing.customers_invoices_show') }}-->
    Complementos de pago
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View customers invoices show') )
    <!--{{ trans('invoicing.customers_invoices_show') }}-->
    Complementos de pago
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View customers invoices show') )
    <form id="form" name="form" enctype="multipart/form-data">
      {{ csrf_field() }}
    </form>

    <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive table-data table-dropdown">
            <table id="table_complements" name='table_filter_fact' class="table table-striped table-hover table-condensed">
              <thead>
                <tr class="mini text-center">
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
                    <!--<th class="text-left">
                        {{__('customer_invoice.column_salesperson')}}
                    </th>-->
                    <!--<th class="text-center">
                        {{__('customer_invoice.column_date_due')}}
                    </th>-->
                    <th class="text-center">
                        {{__('customer_invoice.column_currency')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_amount_total')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_balance')}}
                    </th>
                    <!--<th class="text-center">
                        {{__('customer_invoice.column_mail_sent')}}
                    </th>
                    <th class="text-center">
                        {{__('customer_invoice.column_status')}}
                    </th> -->
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
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />

  <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
  <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

  <!-- Main Quill library -->
  <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
  <!-- Theme included stylesheets -->
  <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<script src="{{ asset('js/admin/sales/complement.js?v=1.0.1')}}"></script>
  @else
  @endif
@endpush
