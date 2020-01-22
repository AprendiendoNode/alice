@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View purchases show') )
    Historial de compras
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View purchases show') )
    Historial de compras
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View purchases show') )
  @else
    @include('default.denied')
  @endif
@endsection
@push('scripts')
  @if( auth()->user()->can('View purchases show') )
  @else
  @endif
@endpush
