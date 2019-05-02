@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View distribucion') )
    {{ trans('message.breadcrumb_detailed_distribucion') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View distribucion') )
    {{ trans('message.breadcrumb_detailed_distribucion') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View distribucion') )
  @else
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View distribucion') )
  @else
  @endif
@endpush
