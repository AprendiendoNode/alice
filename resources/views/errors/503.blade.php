@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('content')
	<img  class="resize_fit_center" src="{{ asset('images/rick_maintenance.png') }}">
@endsection
@section('message', __($exception->getMessage() ?: 'Aplicación en mantenimiento'))
