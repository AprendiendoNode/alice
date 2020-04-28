@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View banks') )
  DASHBOARD DE CLIENTES CON INGRESOS COMPARTIDOS
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View banks') )
  DASHBOARD DE CLIENTES CON INGRESOS COMPARTIDOS
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View banks') )

  @else
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View banks') )
  @else
  @endif
@endpush
