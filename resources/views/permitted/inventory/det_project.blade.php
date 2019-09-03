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
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <div class="card">
                <div class="card-body">
                  <div class="form-inline d-flex justify-content-around">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label for="select_one" class="control-label">{{ trans('message.cadena') }}: </label>
                        <select id="select_one" name="select_one"  class="form-control select2" required>
                          <option value="" selected> Elija </option>
                          @forelse ($cadena as $data_cadena)
                            <option value="{{ $data_cadena->id }}"> {{ $data_cadena->name }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                      <div class="form-group mt-sm-0 mt-3">
                        <button type="button" id="btn_generar" class="btn btn-dark btngeneral"><i class="fa fa-bullseye"></i> {{ trans('message.generate') }}</button>
                      </div>
                      <div class="form-group mt-sm-0 mt-3">
                        <button type="button" class="btn btn-success btn-danger hidden-xs btn-export"><i class="fas fa-file-pdf"></i> {{ trans('message.export') }} Portada</button>
                      </div>
                  </div>
                 </div>
              </div>
            </div>

            <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <div id="hojitha_cont" class="hojitha mt-3"   style="background-color: #fff; border:1px solid #ccc; border-bottom-style:hidden; padding:10px; width: 100%">
                  <div class="row mt-4 d-flex justify-content-between">
                      <div class="col-lg-3 col-md-3 col-sm-3 text-center">
                         <img class="img-fluid" src="{{ asset('/img/company/sitwifi_logo.jpg') }}" style="width:160px" />
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 text-center">
                        <h2> <small>Reporte por proyecto</small></h2>
                        <strong id="name_htl">Hard Rock</strong>
                        <br />
                      </div>
                      <div class="col-lg-3 col-md-3 col-sm-3 text-center">
                         <img class="img-fluid" id="img_htl" src="{{ asset('images/hotel/Hard_Rock_Punta_Cana.svg') }}" style="width:160px;" />
                      </div>
                  </div>

                  <div class="row text-center contact-info">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <hr />
                          <span>
                              <strong>Email : </strong><small id="email">info@sitwifi.com</small>
                          </span>
                          <span>
                              <strong>Tel : </strong> <small id="tel">8-84-46-30</small>
                          </span>
                           <span>
                              <strong>Expedición: </strong>  <small id="date"> @php
                                $mytime = Carbon\Carbon::now();
                                echo $mytime->toDateTimeString();
                              @endphp</small>
                          </span>
                          <hr />
                      </div>
                  </div>

                  <div  class="row mt-3 client-info">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="clearfix">
                        <div id="main_aps" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;"></div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="clearfix">
                        <div id="main_switch" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;"></div>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-4 client-info">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="clearfix">
                          <div id="main_equipos" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                          <div class="clearfix">
                            <div id="main_modelos" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;"></div>
                          </div>
                    </div>
                  </div>
              </div>
              <div class="captura_table_general"   style="background-color: #fff; border:1px solid #ccc; border-top-style:hidden; padding:10px; width: 100%">

                  <div  class="row text-center contact-info">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <hr />
                        <span>
                            <strong>Resumen por estatus</strong>
                        </span>
                      <hr />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6"></div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <label for="select_two" class="control-label">Estatus: </label>
                      <select id="select_two" name="select_two"  class="form-control select2" required>
                        <option value="" selected> Elija </option>
                      </select>
                    </div>
                    <hr />
                  </div>


                  <div class="row pad-top-botm client-info">
                    <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                        <table id="table_resume" class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>{{ trans('message.hotel') }}.</th>
                              <th>No. APS</th>
                              <th>No. ZD.</th>
                              <th>No. SMZ</th>
                              <th>No. SW</th>
                              <th>No. Sonda</th>
                              <th>No. ZQ</th>
                              <th>No. Sonicwall</th>
                              <th>No. Icomera</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                    </div>
                  </div>
              </div>

              <div class="captura_table_general_dos"   style="background-color: #fff; border:1px solid #ccc; border-top-style:hidden; padding:10px; width: 100%">
                <div  class="row text-center contact-info">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <hr />
                      <span>
                          <strong>Resumen General</strong>
                      </span>
                    <hr />
                  </div>
                </div>

                <div class="row mt-4 client-info">
                  <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                      <table id="table_resume_general" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>{{ trans('message.hotel') }}.</th>
                            <th>No. APS</th>
                            <th>No. ZD.</th>
                            <th>No. SMZ</th>
                            <th>No. SW</th>
                            <th>No. Sonda</th>
                            <th>No. ZQ</th>
                            <th>No. Sonicwall</th>
                            <th>No. Icomera</th>
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
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View detailed for proyect') )
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/datatables_bootstrap_4/datatables.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}"></script>
    <script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
    <script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
    <script src="{{ asset('js/admin/inventory/hotelp.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pdf.css')}}" >
  @else
  @endif
@endpush
