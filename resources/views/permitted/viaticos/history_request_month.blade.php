@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View history all viatic') )
    {{ trans('message.history') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View history all viatic') )
    {{ trans('message.history_viat_month') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View history all viatic') )

    @else
    @endif
@endsection

@push('scripts')
    @if( auth()->user()->can('View history all viatic') )
    @else
    @endif
@endpush
