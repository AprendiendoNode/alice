@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View requests via') )
    {{ trans('message.viaticos_dashboard_request') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View requests via') )
    {{ trans('message.breadcrumb_dashboard_request') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View requests via') )

    @else
    @endif
@endsection

@push('scripts')
    @if( auth()->user()->can('View requests via') )
    @else
    @endif
@endpush
