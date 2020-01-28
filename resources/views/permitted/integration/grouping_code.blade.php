@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View grouping code') )
    Codigo agrupador
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View grouping code') )
    Codigo agrupador
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View grouping code') )
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form id="form" name="form" enctype="multipart/form-data">
              {{ csrf_field() }}
            </form>
            <div class="table-responsive table-data table-dropdown">
              <table id="table_filter" name='table_filter' class="table table-striped table-hover table-condensed">
                <thead>
                  <tr class="mini">
                      <th class="text-center" width="5%">@lang('general.column_actions')</th>
                      <th class="text-center">
                          Nivel
                      </th>
                      <th class="text-center">
                          Código agrupador
                      </th>
                      <th class="text-left">
                          Nombre
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
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View grouping code') )
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>

    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

    <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
    <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

    <script src="{{ asset('bower_components/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js')}}"></script>

    <script src="{{ asset('js/admin/integration/grouping_code.js')}}"></script>
  @else
  @endif
@endpush
