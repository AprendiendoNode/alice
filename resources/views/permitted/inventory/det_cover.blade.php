@extends('layouts.admin')

@section('contentheader_title')
@if( auth()->user()->can('View cover') )
{{ trans('message.breadcrumb_detailed_cover') }}
@else
{{ trans('message.denied') }}
@endif
@endsection

@section('breadcrumb_title')
@if( auth()->user()->can('View cover') )
{{ trans('message.breadcrumb_detailed_cover') }}
@else
{{ trans('message.denied') }}
@endif
@endsection

@section('content')
@if( auth()->user()->can('View cover') )
<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <form id="search" name="search" class="" action="index.html" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-8">
                                <div id="data_select_one" class="form-group row">
                                    <label class="col-sm-1 col-form-label" for="select_one"> Sitio </label>
                                    <div class="col-sm-11 mt-1">
                                        <select id="select_one" name="select_one" class="form-control form-control-sm select2 required" style="width: 100%;">
                                            <option value="" selected> Elija </option>
                                            @forelse ($hotels as $data_hotel)
                                            <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-dark mr-2">
                                        <i class="fa fa-bullseye margin-r5"></i> {{ trans('message.generate') }}
                                    </button>

                                    <button type="button" class="btn btn-danger btnexport">
                                        <i class="fas fa-file-pdf  margin-r5"></i> {{ trans('message.export') }} Portada
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="client_updl" class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mt-4">
            <div class="card with-border">
                <div class="card-body">
                    <h3 class="card-title">Actualizar datos del cliente</h3>
                    <form id="validate_client" name="validate_client" action="" method="POST" class="">
                        {{ csrf_field() }}
                        <input type="hidden" id="token_d" name="token_d" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Responsable:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="update_cliente_responsable" name="update_cliente_responsable" autocomplete="off" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Teléfono</label>
                                    <div class="col-sm-9">
                                        <input type="text" maxlength="10" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" class="form-control" id="update_cliente_tel"
                                          name="update_cliente_tel" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Correo</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="update_cliente_email" name="update_cliente_email" autocomplete="off" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Ciudad</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="update_city" name="update_city" autocomplete="off" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Fecha y hora</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="update_date_time" name="update_date_time" autocomplete="off" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Ubicación</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="update_ubicacion" name="update_ubicacion" autocomplete="off" required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-secondary"><i class="fa fa-save margin-r5"></i> Guardar & Actualizar</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12 mt-3">
            <div class="hojitha" style="background-color: #fff; border:1px solid #ccc; border-bottom-style:hidden; padding:10px; width: 100%">
                <div class="row pad-top-botm ">
                    <div class="col-lg-3 col-md-3 col-sm-3 text-center">
                        <img class="img-fluid" src="{{ asset('/img/company/sitwifi_logo.jpg') }}" style="width:140px" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 text-center">
                        <h2> <small>Carta de entrega</small></h2>
                        <strong id="name_htl"></strong>
                        <br />
                        <strong>ID Proyecto:</strong> <small id="id_proyect"></small>
                        <br />
                        <strong>Equipo activo</strong>
                        <br />
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 text-center">
                        <img class="logo-sit" id="client_img" src="{{ asset('images/hotel/Hard_Rock_Punta_Cana.svg') }}" style="padding-bottom:20px;width: 100%" />
                    </div>
                </div>

                <div class="row pad-top-botm client-info">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <p class="text-center" style="border: 1px solid #FF851B">Empresa</p>
                        <strong>Nombre: </strong><small id="empresa"></small>
                        <br />
                        <strong>Responsable: </strong><small id="responsable"></small>
                        <br />
                        <strong>Área de trabajo: </strong><small id="area"></small>
                        <br />
                        <strong>Dirección: </strong><small id="dir"></small>
                        <br />
                        <strong>Teléfono: </strong><small id="tel_empresa"></small>
                        <br />
                        <strong>Correo: </strong><small id="correo_empresa"></small>
                        <br />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <p class="text-center" style="border: 1px solid #007bff">Cliente</p>
                        <strong>Nombre: </strong><small id="cliente_nombre"></small>
                        <br />
                        <strong>Responsable: </strong><small id="cliente_responsable"></small>
                        <br />
                        <strong>Ubicación: </strong><small id="cliente_ubi"></small>
                        <br />
                        <strong>Dirección: </strong><small id="cliente_dir"></small>
                        <br />
                        <strong>Teléfono: </strong><small id="cliente_tel"></small>
                        <br />
                        <strong>Correo: </strong><small id="cliente_email"></small>
                        <br />
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <br />
                        {{-- <p class="text-center" style="border: 1px solid #3D9970" >Información</p> --}}
                        <p class="text_justify">
                            En <span class="bolds underlines">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            siendo las <span> class="bolds underlines"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            del día <span class="bolds underlines">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            de <span class="bolds underlines">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            del <span class="bolds underlines">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            se reúnen en las instalaciones de <strong class="bolds">(cliente)</strong>,
                            ubicado en <span class="bolds underlines">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>,
                            a quien en lo sucesivo de le denominará "EL CLIENTE" y la empresa SITWIFI S.A de C.V. a quien en lo sucesivo se le denominará
                            "EL PRESTADOR", quienes examinaron las áreas correspondientes, en lo que en lo sucesivo se denominará "EL SITIO", y una vez examinada por ambas
                            partes y habiendo sido encontrada en condiciones satisfactorias, se procede a levantar la presente
                            acta de ENTREGA-RECEPCIÓN de los equipos enlistados, la cual constituye la aceptación expresa de la
                            recepción de los equipos por parte del "CLIENTE".
                        </p>
                    </div>


                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <p class="text_justify">
                            En tales condiciones "el cliente", conviene en recibir "el equipo" a su entera conformidad y
                            satisfacción por lo que firma la presente como el finiquito mas amplio que proceda respecto a las
                            obligaciones a las que se encontraba sujeto "el prestador".
                        </p>

                        <p class="text_justify">
                            Las instalaciones de los equipos se realizaron acorde a cada uno de los términos y condiciones,
                            respetando así el tiempo estipulado para las instalaciones.
                        </p>

                        <br>
                        <strong>Fecha de inicio del proyecto: </strong><small id="fecha_ini"></small>
                        <br>
                        <strong>Fecha de termino del proyecto:</strong><small id="fecha_fin"></small>
                        <br>
                        <strong>Fecha de Facturación: </strong><small id="fecha_fact"></small>
                        <br>

                        <p class="text_justify padding_top">
                            Una vez leída la presente acta por los que en ella intervinieron, "el cliente" y "el prestador", la firman
                            al calce, ratificándola en todas y cada una de sus partes para los fines posteriores a que haya lugar.
                        </p>
                    </div>
                </div>

                <div class="row mt-3 client-info">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="clearfix">
                            <div id="comentarios" style="width: 100%; min-height: 80px; border:1px solid #ccc;padding:10px;">Observaciones o comentarios: <span id="observaciones_txt"></span> </div>
                        </div>
                    </div>
                </div>

                <div class="row pad-top-botm client-info text-center">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="clearfix">
                            <hr>
                            <strong>Nombre y Firma del responsable del proyecto.</strong>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="clearfix">
                            <hr>
                            <strong>Nombre y Firma del cliente.</strong>
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
@if( auth()->user()->can('View cover') )
<link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
<script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>

<script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
<script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('bower_components/jsPDF/dist/jspdf.min.js')}}"></script>
<script src="{{ asset('bower_components/html2canvas/html2canvas.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/pdf.css')}}">

<script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
<link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
<script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

<style media="screen">
    .select2-selection__rendered {
        line-height: 37px !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .select2-selection__arrow {
        height: 40px !important;
    }

    .bolds {
        font-weight: bold !important;
    }

    .underlines {
        text-decoration: underline !important;
    }

    .text_justify {
        text-align: justify !important;
    }

    .padding_top {
        padding-top: 20px !important;
    }
</style>
<script src="{{ asset('js/admin/inventory/cover.js')}}"></script>
@else
@endif
@endpush
