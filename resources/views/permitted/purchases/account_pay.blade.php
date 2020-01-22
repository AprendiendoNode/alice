@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View account to pay') )
    Cuentas por pagar
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View account to pay') )
    Cuentas por pagar
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View account to pay') )
  @else
    @include('default.denied')
  @endif
@endsection
@push('scripts')
  @if( auth()->user()->can('View account to pay') )
  @else
  @endif
@endpush
