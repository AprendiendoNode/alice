@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View test zd') )
    {{ trans('message.title_review') }} de zone director
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View test zd') )
    {{ trans('message.breadcrumb_test_zd') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View test zd') )
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="card-header">
              <strong class="card-title">{{ trans('message.required_view')}}</strong>
            </div>
              <div class="card-body">
                <div class="form-inline">
                    {{ csrf_field() }}
                    <div class="input-group">
                      <label for="select_one" class="control-label">{{ trans('message.hotel') }}</label>
                      <div class="selectContainer  mb-2 mr-sm-2">
                        <select id="select_one" name="select_one" class="form-control select2">
                          <option value="" selected> Elija </option>
                          @forelse ($hotels as $data_hotel)
                            <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>

                    <div class="input-group mr-sm-2">
                      <label for="direccion_ip"  class="control-label">{{ trans('message.direccionip')}}</label>
                      <div class="">
                        <input type="text" class="form-control" id="direccion_ip" name="direccion_ip" placeholder="xxx.xxx.xxx.xxx" maxlength="15" title="{{ trans('message.dir_ip_format')}}">
                      </div>
                    </div>
                    <div class="input-group mr-sm-2 mt-sm-3">
                      <label for="puerto_dir"  class="control-label">{{ trans('message.puerto')}}</label>
                      <div class="">
                        <input type="text" class="form-control" onkeyup="this.value=this.value.replace(/[^\d]/,'')" id="puerto_dir" name="puerto_dir" placeholder="xxxx" maxlength="4" title="{{ trans('message.maxfourcaract')}}">
                      </div>
                    </div>
                    <div class="input-group mr-sm-2 mt-sm-3 mt-2">
                      <a id="comprobarip" class="btn btn-secondary"><i class="fas fa-bookmark"></i> {{ trans('message.comprobar')}}</a>
                    </div>
                    <div class="input-group mt-sm-3 mt-2">
                      <a id="resetcomprobarip" class="btn btn-warning"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                    </div>
                </div>
              </div>
              <div class="card-footer">
                   <strong>Nota: Si no inserta puerto se tomara como si seleccionara el puerto por defecto '161'.</strong>
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
  @if( auth()->user()->can('View test zd') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/admin/tools/zone.js')}}"></script>
  @else
  @endif
@endpush
