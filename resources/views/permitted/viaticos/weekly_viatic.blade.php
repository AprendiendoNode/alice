@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View weekly viatic') )
    {{ trans('message.report_weekly') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View weekly viatic') )
    {{ trans('message.report_weekly') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View weekly viatic') )

    @else
    @endif
@endsection

@push('scripts')
    @if( auth()->user()->can('View weekly viatic') )
    @else
    @endif
@endpush
