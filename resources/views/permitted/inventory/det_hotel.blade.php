@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View detailed for hotel') )
    {{ trans('message.breadcrumb_detailed_hotel') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View detailed for hotel') )
    {{ trans('message.breadcrumb_detailed_hotel') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View detailed for hotel') )
  @else
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View detailed for hotel') )
  @else
  @endif
@endpush
