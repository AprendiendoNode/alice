@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View dashboard cfdi') )
    {{ trans('invoicing.dashboard_cfdi') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View dashboard cfdi') )
    {{ trans('invoicing.dashboard_cfdi') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View dashboard cfdi') )
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="d-flex justify-content-between flex-wrap">
        <div class="d-flex justify-content-between align-items-end flex-wrap">
          <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0" title="Actualizar">
            <i class="fas fa-sync-alt text-muted"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">

    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body p-0">
          <div class="d-flex flex-wrap justify-content-xl-between">

            <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
              <i class="mdi mdi-file-check mr-3 icon-lg text-success"></i>
              <div class="d-flex flex-column justify-content-around">
                <small class="mb-1 text-muted">Vigente</small>
                <h5 class="mr-2 mb-0">0</h5>
              </div>
            </div>

            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
              <i class="mdi mdi-file-excel mr-3 icon-lg text-danger"></i>
              <div class="d-flex flex-column justify-content-around">
                <small class="mb-1 text-muted">Canceladas</small>
                <h5 class="mr-2 mb-0">0</h5>
              </div>
            </div>

            <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
              <i class="fas fa-file-import mr-3 icon-lg text-primary"></i>
              <div class="d-flex flex-column justify-content-around">
                <small class="mb-1 text-muted">En proceso</small>
                <h5 class="mr-2 mb-0">0</h5>
              </div>
            </div>

            <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
              <i class="fas fa-window-close mr-3 icon-lg text-secondary"></i>
              <div class="d-flex flex-column justify-content-around">
                <small class="mb-1 text-muted">Solicitud rechazada</small>
                <h5 class="mr-2 mb-0">0</h5>
              </div>
            </div>

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
  @if( auth()->user()->can('View dashboard cfdi') )
  @else
  @endif
@endpush
