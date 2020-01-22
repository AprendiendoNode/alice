@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View cb provider') )
    Cuentas bancaras por proveedor
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View cb provider') )
    Cuentas bancaras por proveedor
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View cb provider') )
  @else
    @include('default.denied')
  @endif
@endsection
@push('scripts')
  @if( auth()->user()->can('View cb provider') )
  @else
  @endif
@endpush
