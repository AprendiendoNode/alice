@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View distribucion') )
    {{ trans('message.breadcrumb_detailed_distribucion') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View distribucion') )
    {{ trans('message.breadcrumb_detailed_distribucion') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View distribucion') )
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <div class="card">
                <div class="card-body">
                  <div class="media">
                    <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                        {{ trans('general.distribucion_sitios') }}
                    </h4>
                  </div>
                  <div class="media">
                      <div class="media-body">
                          <div class="clearfix">
                              {{ csrf_field() }}
                              <div id="googlemap" style="height: 400px; width: 100%;"></div>
                          </div>
                      </div>
                  </div>
                 </div>
              </div>
            </div>

            <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mt-4">
              <div class="hojitha" style="background-color: #fff; border:1px solid #ccc; border-bottom-style:hidden; padding:10px; width: 100%">
                  <div class="row mt-4 ">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="clearfix">
                          <div id="main_country" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;"></div>
                        </div>
                    </div>
                  </div>

                  <div  class="row mt-4 client-info">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="clearfix">
                        <div id="main_pais_vertical" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;"></div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 mt-3 mt-sm-0">
                      <div class="clearfix">
                        <div id="main_distribution" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;"></div>
                      </div>
                    </div>
                  </div>

                  <div class="row text-center contact-info">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <hr />
                      <span>
                        <strong>{{ trans('general.equipamiento_total') }}</strong>
                      </span>
                      <hr />
                      <br/>
                    </div>
                  </div>

                  <div class="row  ">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-inline">
                          {{ csrf_field() }}
                          <div class="form-group">
                            <label for="cadena" class="control-label">Cadena: </label>
                            <select id="cadena" name="cadena"  class="form-control select2 form-control-sm" required>
                              <option value="" selected> Elija </option>
                              <option value="0"> Todos </option>
                              @forelse ($cadenas as $cadena)
                                <option value="{{ $cadena->id }}"> {{ $cadena->name }} </option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="hotel" class="control-label">{{ trans('message.hotel') }}: </label>
                            <select id="hotel" name="hotel"  class="form-control select2 form-control-sm" required>
                              <option value="" selected> Elija </option>
                              
                            </select>
                          </div>
                      </div>
                      <div class="table-responsive" style="padding:10px;">
                        <table id="table_equipment_all" class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Cadena</th>
                              <th>{{ trans('general.hotel') }}</th>
                              <th>{{ trans('general.equipo') }}</th>
                              <th>{{ trans('general.modelo') }}</th>
                              <th>{{ trans('general.cantidad') }}</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
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
  @if( auth()->user()->can('View distribucion') )
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pdf.css')}}" >
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCD07V9hwyUjrRCXiJHo9YdftE0VJIbRP8"></script>
    <script src="{{ asset('js/admin/inventory/distribucion.js?v=2.0')}}"></script>
  @else
  @endif
@endpush
