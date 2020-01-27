@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View accounting account') )
    Cuenta contable
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View accounting account') )
    Cuenta contable
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View accounting account') )
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View accounting account') )

  @else
  @endif
@endpush
