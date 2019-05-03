@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View detailed for hotel') )
    {{ trans('message.breadcrumb_detailed_hotel') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View detailed for hotel') )
    {{ trans('message.breadcrumb_detailed_hotel') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View detailed for hotel') )
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form id="omega10" class="form-inline">
                  {{ csrf_field() }}
                  <div class="input-group mb-2 mr-sm-4 col-md-3">
                    <label for="select_one">Proyecto</label>
                    <select class="form-control" id="select_one" name="select_one" style="width: 100%;">
                      <option value="" selected>Elija un proyecto</option>

                    </select>
                  </div>
                  <div class="input-group mb-2 mr-sm-2 col-md-3">
                    <label for="select_two">Sitio</label>
                    <select class="form-control" id="select_two" name="select_two" style="width: 100%;">
                      <option value="" selected>Elija un sitio</option>

                    </select>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                    <button id="boton-aplica-filtro10" name="boton-aplica-filtro10" type="button" class="btn btn-outline-primary">
                       <i class="fas fa-filter" style="margin-right: 4px;"></i> Generar
                    </button>
                  </div>
                  <div class="input-group mb-2 mr-sm-2">
                    <button id="btnacerrar2" name="btnacerrar2" type="button" class="btn btn-outline-danger">
                       <i class="fas fa-eye-slash" style="margin-right: 4px;"></i> Exportar.
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @else
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View detailed for hotel') )
  @else
  @endif
@endpush
