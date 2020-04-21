@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View create contract cover') )
  Carátula de contrato de prestación de servicios
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View create contract cover') )
  Carátula de contrato de prestación de servicios
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View create contract cover') )
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <form id="form" name="form" class="forms-sample" target="_blank" method="post" action="{{url('/caratula_contrato_store')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <pre>INFORMACIÓN GENERAL DEL CLIENTE</pre>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Razón social</label>
                                <div class="col-sm-9">
                                    <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputRazonSocial" name="InputRazonSocial" maxlength="100" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Representante/Apoderado Legal</label>
                                <div class="col-sm-9">
                                    <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputRepresentante" name="InputRepresentante" maxlength="100" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Teléfono de contacto</label>
                                <div class="col-sm-9">
                                    <input type="text"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"
                                    class="form-control" id="InputTelefonoContacto" name="InputTelefonoContacto" maxlength="10" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Correo de contacto</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="InputCorreoContacto" name="InputCorreoContacto" maxlength="100" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <p class="mt-4">This will install the dev dependencies in the local <span class="font-weight-bold">node_modules</span> folder in your root directory.</p> --}}
                    <hr class="mt-3">

                    <pre>DATOS FISCALES DEL CLIENTE</pre>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">RFC</label>
                                <div class="col-sm-9">
                                    <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputRfc" name="InputRfc" maxlength="100" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Uso de CFDI</label>
                                <div class="col-sm-9">
                                    <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputCfdi" name="InputCfdi" maxlength="100" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dirección</label>
                                <div class="col-sm-9">
                                    <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputDireccion" name="InputDireccion" maxlength="300" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Forma y método de pago</label>
                                <div class="col-sm-9">
                                    <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputMetodoPago" name="InputMetodoPago" maxlength="300" required autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <p class="mt-4">This will install the dev dependencies in the local <span class="font-weight-bold">node_modules</span> folder in your root directory.</p> --}}
                    <hr class="mt-3">

                    <pre>DOMICILIO Y PERSONAS AUTORIZADAS PARA RECIBIR NOTIFICACIONES Y DOCUMENTOS</pre>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dirección</label>
                                <div class="col-sm-9">
                                    <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputDireccionPersona" name="InputDireccionPersona" maxlength="300" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">En atención a</label>
                                <div class="col-sm-9">
                                    <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputAtencionPersona" name="InputAtencionPersona" maxlength="300" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <p class="mt-4">This will install the dev dependencies in the local <span class="font-weight-bold">node_modules</span> folder in your root directory.</p> --}}
                    <hr class="mt-3">

                    <pre>ESPECIFICACIONES DEL SERVICIO</pre>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                {{-- <label class="col-sm-3 col-form-label">Dirección</label> --}}
                                <div class="col-sm-12">
                                    <textarea onkeyup="mayuscula(this);" class="form-control" id="textareaEspecificaciones" name="textareaEspecificaciones" rows="4" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <p class="mt-4">Esta sección es<code><span class="font-weight-bold">Opcional</span></code>.</p> --}}
                    <hr class="mt-3">

                    <pre>VIGENCIA</pre>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"
                                    class="form-control" id="InputVigencia" name="InputVigencia" maxlength="4" required autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-3">

                    <pre>CONTRAPRESTACIÓN Y FORMA DE PAGO</pre>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">Monto</label>
                                <div class="col-sm-12">
                                    <input onblur="redondeo_monto();"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"
                                    type="text" class="form-control" id="InputMontoPago" name="InputMontoPago" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">DÍAS DE PAGO DE CADA MES</label>
                                <div class="col-sm-12">
                                    {{-- <input type="text" class="form-control" id="InputDiasPago" name="InputDiasPago" required /> --}}
                                    <select  id="InputDiasPago" name="InputDiasPago" class="form-control form-control-sm required"  style="width: 100%;">
                                      <option value="" selected > Elija </option>
                                      @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{$i}}">{{ $i }}</option>
                                      @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">PESOS O DÓLARES </label>
                                <div class="col-sm-12">
                                  <select  id="InputMonedaPago" name="InputMonedaPago" class="form-control form-control-sm required"  style="width: 100%;">
                                    <option value="" selected> Elija </option>
                                    <option value="PESOS" >PESOS</option>
                                    <option value="DOLARES">DÓLARES</option>
                                  </select>
                                    {{-- <input type="text" class="form-control" id="InputMonedaPago" name="InputMonedaPago" required /> --}}
                                </div>
                                <p class="mt-1 ml-2">(<span class="font-weight-bold">Más el correspondiente impuesto</span>).</p>
                            </div>
                        </div>
                    </div>
                    {{-- <p class="mt-4">This will install the dev dependencies in the local <span class="font-weight-bold">node_modules</span> folder in your root directory.</p> --}}
                    <hr class="mt-3">

                    <pre>CONDICIONES ESPECIALES</pre>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="textareaCondicionesEspeciales" name="textareaCondicionesEspeciales" rows="4" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <p class="mt-4">Esta sección es<code><span class="font-weight-bold">Opcional</span></code>.</p> --}}
                    <hr class="mt-3">

                    <pre>DEPÓSITO EN GARANTÍA</pre>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label">APLICA</label>
                                        <div class="col-sm-12">
                                            {{-- <input id="InputAplicaGarantia" name="InputAplicaGarantia" type="checkbox" data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="0"
                                            data-on="Si" data-off="No"> --}}
                                            <select  id="InputAplicaGarantia" name="InputAplicaGarantia" class="form-control form-control-sm required"  style="width: 100%;">
                                              <option value="0" selected >NO</option>
                                              <option value="1">SI</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">MONTO</label>
                                <div class="col-sm-12">
                                    <input onblur="redondeo_garantia();"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"
                                    type="text" class="form-control" id="InputMontoGarantia" name="InputMontoGarantia" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-3">

                    <pre>OBSERVACIONES</pre>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="textareaObservaciones" name="textareaObservaciones" rows="4" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <p class="mt-4">Esta sección es<code><span class="font-weight-bold">Opcional</span></code>.</p> --}}
                    <hr class="mt-3">

                    <pre>PENALIZACIONES</pre>
                    <p class="mt-4 text-justify">
                        Para el caso de que <span class="font-weight-bold">EL CLIENTE</span> incurra en algunas de las causales de rescisión estipuladas en la cláusula novena del Contrato o en su caso decida terminar anticipadamente el Contrato y/o
                        Anexo según aplique, pagará por concepto de pena convencional a <span class="font-weight-bold">EL PRESTADOR</span> el importe de todas las mensualidades de la <span class="font-weight-bold">CONTRAPRESTACIÓN</span> establecida
                        en la presente Carátula, correspondientes a los meses restantes en la vigencia del Contrato y/o Anexo según aplique. Lo anterior, no exime al <span class="font-weight-bold">CLIENTE</span> del pago de todas las mensualidades de
                        la <span class="font-weight-bold">CONTRAPRESTACIÓN</span> por los Servicios ya prestados en la fecha de terminación o rescisión del Contrato y/o Anexo según aplique. Dicho pago deberá ser realizado dentro de los 10 (diez) días
                        naturales siguientes de la fecha en la que el <span class="font-weight-bold">PRESTADOR</span> notifique al <span class="font-weight-bold">CLIENTE</span> la rescisión del Contrato o el <span
                          class="font-weight-bold">CLIENTE</span> notifique al <span class="font-weight-bold">PRESTADOR</span> la terminación anticipada del presente Contrato, según sea el caso.
                    </p>
                    <hr class="mt-3">

                    <button type="submit" class="btn btn-primary mr-2">Guardar y descargar</button>
                    <button class="btn btn-danger">Cancelar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
    @if( auth()->user()->can('View create contract cover') )
      <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
      <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

      <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
      <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

      <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
      <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

      <script src="{{ asset('js/admin/contract/caratula_contrato.js')}}"></script>
      <style media="screen">
          .toggle.btn {
              min-width: 5rem !important;
          }

          #form * {
              /* margin: 0.3 !important;
            padding:1; */
          }
      </style>
    @else
    @endif
@endpush
