
@extends('layouts.app')

@section('contentheader_title')
  @if( auth()->user()->can('View Edit Document P') )
    {{ trans('message.document_edit') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')


@endsection

@section('breadcrumb_ubication')
  @if( auth()->user()->can('View Edit Document P') )
    {{ trans('message.breadcrumb_document_edit') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View Edit Document P') )
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Permission Denied!</div>
                    <div class="panel-body">
                        <p class="text-primary">{{$folio}}</p>
                        <p class="text-primary">Última actualización: {{$hour_created}}</p>
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
