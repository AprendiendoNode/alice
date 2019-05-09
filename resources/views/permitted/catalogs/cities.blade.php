@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.cities') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.cities') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('content')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  {{-- @else --}}
  {{-- @endif --}}
@endsection

@push('scripts')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  {{-- @else --}}
  {{-- @endif  --}}
@endpush
