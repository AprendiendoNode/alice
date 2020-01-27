@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View rubros') )
    Rubros
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View rubros') )
    Rubros
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View rubros') )
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View rubros') )

  @else
  @endif
@endpush
