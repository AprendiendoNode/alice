@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View history contract cover') )
  Carátula de contrato de prestación de servicios
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View history contract cover') )
  Carátula de contrato de prestación de servicios
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View history contract cover') )
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="mt-2 card-title">Esta sección nos permite gestionar las caratulas creadas.</p>
                    <div class="d-flex justify-content-center pt-3"></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="table_caratula" name='table_caratula' class="table table-striped border display nowrap compact-tab" style="width:100%; font-size: 10px;">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>RFC</th>
                                            <th>Razón social</th>
                                            <th>Teléfono</th>
                                            <th>Tipo Servicio</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
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
    <!-- Editar -->
    <div id="modal-Edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
      <!-- change -->
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="modaledit">Editar</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
                  <form id="editar" name="editar" class="forms-sample" action="">
                    {{ csrf_field() }}
                    <input class="form-control" type="hidden" placeholder="" id="token_b" name="token_b" value="">

                    <div class="row">
                      <div class="col-12">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header bg-primary mt-0 mb-0 pt-0 pb-0" id="headingUno">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link mb-0 text-white" href="collapseUno" data-toggle="collapse" data-target="#collapseUno" aria-expanded="true" aria-controls="collapseUno" style="text-decoration: none;">
                                          INFORMACIÓN GENERAL DEL CLIENTE
                                        </a>
                                    </h5>
                                </div>

                                <div id="collapseUno" class="collapse show" aria-labelledby="headingUno" data-parent="#accordion">
                                    <div class="card-body pt-0">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group row">
                                                  <label class="col-sm-12 col-form-label">Razón social</label>
                                                  <div class="col-sm-12">
                                                      <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputRazonSocial" name="InputRazonSocial" maxlength="100" autocomplete="off" required />
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group row">
                                                  <label class="col-sm-12 col-form-label">Representante/Apoderado Lega</label>
                                                  <div class="col-sm-12">
                                                      <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputRepresentante" name="InputRepresentante" maxlength="100" autocomplete="off" required />
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group row">
                                                  <label class="col-sm-12 col-form-label">Teléfono de contacto</label>
                                                  <div class="col-sm-12">
                                                      <input type="text"
                                                       oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"
                                                       class="form-control" id="InputTelefonoContacto" name="InputTelefonoContacto" maxlength="10" autocomplete="off" required />
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-primary mt-0 mb-0 pt-0 pb-0" id="headingDosMail">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link mb-0 text-white collapsed" href="collapseDosMail" data-toggle="collapse" data-target="#collapseDosMail" aria-expanded="false" aria-controls="collapseDosMail" style="text-decoration: none;">
                                            CORREO DE CONTACTO
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseDosMail" class="collapse" aria-labelledby="headingDosMail" data-parent="#accordion">
                                    <div class="card-body pt-0">
                                      <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">Cobranza</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="InputEmailCobranza" name="InputEmailCobranza" maxlength="100" autocomplete="off" required />
                                                </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">Comercial</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="InputEmailComercial" name="InputEmailComercial" maxlength="100" autocomplete="off" required />
                                                </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">Legal</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="InputEmailLegal" name="InputEmailLegal" maxlength="100" autocomplete="off" required />
                                                </div>
                                            </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header bg-primary mt-0 mb-0 pt-0 pb-0" id="headingDos">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link mb-0 text-white collapsed" href="collapseDos" data-toggle="collapse" data-target="#collapseDos" aria-expanded="false" aria-controls="collapseDos" style="text-decoration: none;">
                                            DATOS FISCALES DEL CLIENTE
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseDos" class="collapse" aria-labelledby="headingDos" data-parent="#accordion">
                                    <div class="card-body pt-0">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group row">
                                                  <label class="col-sm-12 col-form-label">RFC</label>
                                                  <div class="col-sm-12">
                                                      <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputRfc" name="InputRfc" maxlength="100" autocomplete="off" required />
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group row">
                                                  <label class="col-sm-12 col-form-label">Uso de CFDI</label>
                                                  <div class="col-sm-12">
                                                      <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputCfdi" name="InputCfdi" maxlength="100" autocomplete="off" required />
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group row">
                                                  <label class="col-sm-12 col-form-label">Dirección</label>
                                                  <div class="col-sm-12">
                                                      <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputDireccion" name="InputDireccion" maxlength="300" autocomplete="off" required />
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group row">
                                                  <label class="col-sm-12 col-form-label">Forma y método de pago</label>
                                                  <div class="col-sm-12">
                                                      <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputMetodoPago" name="InputMetodoPago" maxlength="300" autocomplete="off" required />
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-primary mt-0 mb-0 pt-0 pb-0" id="headingTres">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link mb-0 text-white collapsed" href="collapseTres" data-toggle="collapse" data-target="#collapseTres" aria-expanded="false" aria-controls="collapseTres" style="text-decoration: none;">
                                            DOMICILIO Y PERSONAS AUTORIZADAS PARA RECIBIR NOTIFICACIONES Y DOCUMENTOS
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseTres" class="collapse" aria-labelledby="headingTres" data-parent="#accordion">
                                    <div class="card-body">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="form-group row">
                                                  <label class="col-sm-12 col-form-label">Dirección</label>
                                                  <div class="col-sm-12">
                                                    <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputDireccionPersona" name="InputDireccionPersona" maxlength="300" autocomplete="off" required />
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group row">
                                                  <label class="col-sm-12 col-form-label">Correo electrónico</label>
                                                  <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="InputEmailCliente" name="InputEmailCliente" maxlength="300" autocomplete="off" required />
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-12">
                                              <div class="form-group row">
                                                  <label class="col-sm-12 col-form-label">En atención a</label>
                                                  <div class="col-sm-12">
                                                    <input onkeyup="mayuscula(this);" type="text" class="form-control" id="InputAtencionPersona" name="InputAtencionPersona" maxlength="300" autocomplete="off" required />
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-primary mt-0 mb-0 pt-0 pb-0" id="headingCuatro">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link mb-0 text-white collapsed" href="collapseCuatro" data-toggle="collapse" data-target="#collapseCuatro" aria-expanded="false" aria-controls="collapseCuatro" style="text-decoration: none;">
                                            ESPECIFICACIONES DEL SERVICIO
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseCuatro" class="collapse" aria-labelledby="headingCuatro" data-parent="#accordion">
                                    <div class="card-body">
                                      <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Tipo de servicio:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="InputTipoServ" name="InputTipoServ" maxlength="300" autocomplete="off" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Vigencia (Meses):</label>
                                                <div class="col-sm-8">
                                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"
                                                    class="form-control" id="InputVigencia" name="InputVigencia" maxlength="4" required autocomplete="off"/>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-primary mt-0 mb-0 pt-0 pb-0" id="headingSeis">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link mb-0 text-white collapsed" href="collapseSeis" data-toggle="collapse" data-target="#collapseSeis" aria-expanded="false" aria-controls="collapseSeis" style="text-decoration: none;">
                                            CONTRAPRESTACIÓN Y FORMA DE PAGO
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseSeis" class="collapse" aria-labelledby="headingSeis" data-parent="#accordion">
                                    <div class="card-body">
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
                                                  <label class="col-sm-12 col-form-label">PESOS O DÓLARES </label>
                                                  <div class="col-sm-12">
                                                      <select  id="InputMonedaPago" name="InputMonedaPago" class="form-control form-control-sm required"  style="width: 100%;">
                                                        <option value="" selected> Elija </option>
                                                        <option value="PESOS" >PESOS</option>
                                                        <option value="DOLARES">DÓLARES</option>
                                                      </select>
                                                  </div>
                                                  <p class="mt-1 ml-2">(<span class="font-weight-bold">Más el correspondiente impuesto</span>).</p>
                                              </div>
                                          </div>
                                          <div class="col-md-4">
                                              <div class="form-group row">
                                                  <label class="col-sm-12 col-form-label">PAGO DOS ÚLTIMOS MESES</label>
                                                  <div class="col-sm-12">
                                                      <select  id="InputDosUltMeses" name="InputDosUltMeses" class="form-control form-control-sm required"  style="width: 100%;">
                                                        <option value="" selected > Elija </option>
                                                        <option value="no" > NO </option>
                                                        <option value="si" > SI </option>
                                                      </select>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>



                            <div class="card">
                              <div class="card-header bg-primary mt-0 mb-0 pt-0 pb-0" id="headingOcho">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link mb-0 text-white collapsed" href="collapseOcho" data-toggle="collapse" data-target="#collapseOcho" aria-expanded="false" aria-controls="collapseOcho" style="text-decoration: none;">
                                            DEPÓSITO EN GARANTÍA
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseOcho" class="collapse" aria-labelledby="headingOcho" data-parent="#accordion">
                                    <div class="card-body">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <div class="form-group row">
                                                          <label class="col-sm-12 col-form-label">APLICA</label>
                                                          <div class="col-sm-12">
                                                              <select  id="InputAplicaGarantia" name="InputAplicaGarantia" class="form-control form-control-sm"  style="width: 100%;" required>
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
                                                      type="text" class="form-control" id="InputMontoGarantia" name="InputMontoGarantia" required/>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header bg-primary mt-0 mb-0 pt-0 pb-0" id="headingSiete">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link mb-0 text-white collapsed" href="collapseSiete" data-toggle="collapse" data-target="#collapseSiete" aria-expanded="false" aria-controls="collapseSiete" style="text-decoration: none;">
                                            CONDICIONES ESPECIALES
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseSiete" class="collapse" aria-labelledby="headingSiete" data-parent="#accordion">
                                    <div class="card-body">
                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group row">
                                                  <div class="col-sm-12">
                                                      <textarea onkeyup="mayuscula(this);" class="form-control" id="textareaCondicionesEspeciales" name="textareaCondicionesEspeciales" rows="4" required></textarea>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-primary mt-0 mb-0 pt-0 pb-0" id="headingNueve">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link mb-0 text-white collapsed" href="collapseNueve" data-toggle="collapse" data-target="#collapseNueve" aria-expanded="false" aria-controls="collapseNueve" style="text-decoration: none;">
                                            OBSERVACIONES
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseNueve" class="collapse" aria-labelledby="headingNueve" data-parent="#accordion">
                                    <div class="card-body">
                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group row">
                                                  <div class="col-sm-12">
                                                      <textarea class="form-control" id="textareaObservaciones" name="textareaObservaciones" rows="4" required></textarea>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                      </div>
                      <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                      </div>
                    </div>
                  </form>
              </div>
              <div class="modal-footer">
              </div>
          </div>
      </div>
    </div>

    <form id="pdf" name="pdf" class="forms-sample" target="_blank"
     method="post" action="{{url('/download/caratula')}}" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input class="form-control" type="hidden" id="token_ab" name="token_ab">
    </form>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
    @if( auth()->user()->can('View history contract cover') )
      <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
      <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

      <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
      <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

      <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
      <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

      <script src="{{ asset('js/admin/contract/ver_caratula_contrato.js')}}"></script>
      <style media="screen">
        th {
          font-size: 12px !important;
        }

        td {
          font-size: 10px !important;
        }

        table tbody tr td {
          padding: 0.2rem 0.5rem;
          height: 38px !important;
        }

        .dropdown,
        .dropdown-menu {
          z-index: 2 !important;
        }
      </style>
    @else
    @endif
@endpush
