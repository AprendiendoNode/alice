@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.customers_credit_notes') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.customers_credit_notes') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('content')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <form id="form" name="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- input hidden -->
            <input type="hidden"
                id="amount_total_tmp"
                name="amount_total_tmp"
                value="{{ old('amount_total_tmp',0) }}">
            <!-- input hidden -->



          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- @else --}}
  {{-- @endif --}}
@endsection

@push('scripts')
  <style media="screen">
    .btn-xs {
      padding: .35rem .4rem .25rem !important;
    }
    input {
      padding-left: 0px !important;
      padding-right: : 0px !important;
    }
    .datepicker td, .datepicker th {
        width: 1.5em !important;
        height: 1.5em !important;
    }
  </style>
  {{-- @else --}}
  {{-- @endif  --}}
@endpush
