@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View Edit Document P') )
    Editar documento
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View Edit Document P') )
    {{ trans('message.document_create') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View Edit Document P') )
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-title p-3"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Permission Denied!</div>
                    <div class="card-body">
                        <p class="text-primary">{{$folio}}</p>
                        <p class="text-primary">Fecha y hora de aprobación: {{$hour_created}}</p>
                        @if( auth()->user()->can('View level zero documentp notification') )
                        <h4 class="text-danger">
                            El tiempo para hacer modificaciones de este Documento ha expirado
                            o el número de ediciones ha superado lo permitido.
                        </h4>
                        @elseif(auth()->user()->can('View level one documentp notification'))
                          <h4 class="text-danger">
                              Este pedido ya ha sido entregado. No se permiten más modificaciones.
                          </h4>
                        @elseif(auth()->user()->can('View level two documentp notification'))
                          <h4 class="text-danger">
                              Este pedido ya ha sido entregado. No se permiten más modificaciones.
                          </h4>
                        @elseif(auth()->user()->can('View level three documentp notification'))
                          <h4 class="text-danger">
                              Este pedido ya ha sido entregado. No se permiten más modificaciones.
                          </h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View Edit Document P') )

  @else
    @include('default.denied')
  @endif
@endpush
