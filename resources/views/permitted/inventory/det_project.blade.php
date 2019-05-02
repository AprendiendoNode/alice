@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View detailed for proyect') )
    {{ trans('message.breadcrumb_detailed_hotel_proyect') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View detailed for proyect') )
    {{ trans('message.breadcrumb_detailed_hotel_proyect') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View detailed for proyect') )
  @else
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View detailed for proyect') )
  @else
  @endif
@endpush
