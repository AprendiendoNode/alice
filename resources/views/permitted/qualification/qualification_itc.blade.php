@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View Document P') )
     Evaluacion mensual ITC
  @else
    {{ trans('message.denied') }}
  @endif 
@endsection

@section('breadcrumb_title')
    @if( auth()->user()->can('View Document P') )
        Evaluacion mensual ITC
    @else
        {{ trans('message.denied') }}
    @endif 
@endsection

@section('content')
    


    
@endsection

@push('scripts')
<script src="{{ asset('js/admin/qualification/qualification_itc.js') }}"></script>
 
@endpush
