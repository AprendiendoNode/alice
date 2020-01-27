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
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View grouping code') )

  @else
  @endif
@endpush
