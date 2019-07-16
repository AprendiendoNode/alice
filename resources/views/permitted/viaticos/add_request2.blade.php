@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View add request of travel expenses') )
    {{ trans('message.viaticos_dashboard_request') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View add request of travel expenses') )
    {{ trans('message.breadcrumb_dashboard_request') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View add request of travel expenses') )

    @else
    @endif
@endsection

@push('scripts')
    @if( auth()->user()->can('View add request of travel expenses') )
    @else
    @endif
@endpush
