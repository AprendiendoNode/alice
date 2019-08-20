<div class="modal modal-default fade" id="modal-view-concept" data-backdrop="static" >
    <div class="modal-dialog">
      <div class="modal-content" >
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-eye" style="margin-right: 4px;"></i>Preview</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body ">
          <div class="card">
            <div class="card-body">

                  <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                  <div id="captura_pdf_general" style="font-size:1.1em;" class="">
                    <div class="hojitha">
                      <div class="header-pays">
                        <div class="row text-left">
                          <div class="col-md-7">

                          </div>
                          <div class="col-md-5 d-inline text-left">
                            <label class="control-label d-inline">C.C.</label>
                            <input type="text" class="form-control d-inline input-sm" name="cc_key" id="cc_key" style="font-size:75%;"readonly="">
                          </div>


                        </div>
                        <div class="row">
                          <input type="hidden" id="id_xs" name="id_xs" class="text">
                          <div class="col-md-3">
                            <img class="logo-sit" src="{{ asset('/images/users/logo.svg') }}" style="padding-bottom:20px;width:100px" />
                          </div>
                          <div class="col-md-4">
                            <h3>{{ trans('pay.title') }}</h3>
                          </div>
                          <div style="padding-top:1.1em;" class="col-md-5">
                            <p class="text-left">
                              {{ trans('pay.date_solicitude') }}:
                                <span id="fecha_ini"></span>
                            </p>
                            <p id="" class="text-left">
                              {{ trans('pay.date_pay') }}:
                              <span id="fecha_pay"></span>
                            </p>

                          </div>

                        </div>

                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-1">
                              <label for="factura" class=" control-label">{{ trans('pay.factura') }}</label>
                              </div>
                              <div class="col-md-4">
                                <input style="font-size:22px;font-weight: bold;" disabled class="form-control" type="text" name="numfact" id="numfact" value="">
                              </div>
                              <div class="col-md-2">
                              <label for="customer" class="control-label"> Orden de compra</label>
                              </div>
                              <div class="col-md-4">
                                <input style="font-size:22px" disabled class="form-control" id="rec_order_purchase" type="text" name="rec_order_purchase" value="">
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-1">
                              <label for="" class=" control-label">{{ trans('pay.prioridad') }}:</label>
                              </div>
                                <div class="col-md-4">
                                  <input disabled class="form-control" id="rec_priority" type="text" name="" value="">
                                </div>
                                <div class="col-md-2">
                                <label for="" class=" control-label">Folio:</label>
                                </div>
                                <div class="col-md-4">
                                  <input class="form-control" type="text" id="folio" name="folio" value="" disabled="true">
                                </div>
                            </div>
                          </div>

                      <div class="form-group ">
                        <div class=" row">
                          <div class="col-md-2">
                          <label for="provider" class=" control-label">{{ trans('pay.proveedor') }}</label>
                          </div>

                          <div class="col-md-10">
                            <input style="font-size:75%" id="rec_proveedor" disabled class="form-control" type="text" name="" value="">
                          </div>
                        </div>
                      </div>

                      <hr>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-3">
                          <label for="amount" class="control-label">{{ trans('pay.amount') }}</label>
                          </div>
                          <div class="col-md-7">
                            <input style="font-size:75%" disabled class="form-control" type="text" name="rec_monto" id="rec_monto" value="$1,100,500.00 MNX">
                          </div>

                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-3">

                          </div>
                          <div class="col-md-9 col-md-offset-2 margin-top-short">
                            <input style="font-size:75%;font-weight:bold;" class="form-control" type="text" disabled="true" name="amountText" id="amountText" value="">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <br>
                          <hr>
                          <p>(*) Datos del sitio</p>
                        </div>
                      </div>
                      <div class="row ">
                        <div class="">
                          <table id="rec_venues_table" class="table table-responsive table-striped" style="margin-left: 7%; width:90% !important;">
                            <thead class="bg-secondary text-white">
                              <tr>
                                <th>Grupo</th>
                                <th>Sitio</th>
                                <th>Anexo ID</th>
                                <th>Ubicacion ID</th>
                                <th>Monto</th>
                                <th>IVA</th>
                                <th>Monto IVA</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    <!--  Fin del header de pago -->

                      <div class="form-group pt-10">
                        <div class="row">
                          <div class="col-md-2">
                          <label for="description" class=" control-label">{{ trans('pay.concept_pay') }}</label>
                          </div>
                          <div class="col-md-10">
                            <textarea style="resize:none;" disabled class="form-control" id="rec_description" name="rec_description" rows="4" cols="40"></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-2">
                          <label for="method-pay" class="control-label">{{ trans('pay.way_pay') }}</label>
                          </div>
                          <div class="col-md-10">
                            <input id="rec_way_pay" disabled class="form-control" type="text" name="" value="">
                          </div>
                        </div>

                        <div class="row margin-top-short">
                          <div class="col-md-12">
                              <div class="form-group margin-top-short">
                                <label for="" class="col-md-12 control-label">(*) {{ trans('pay.data_bank') }}</label>
                              </div>
                              <br>
                                <div class="form-group margin-top-short row">
                                  <div class="col-md-2">
                                  <label for="bank" class=" control-label">{{ trans('pay.bank') }}</label>
                                  </div>
                                  <div class="col-md-8">
                                    <input style="font-size:22px" id="rec_bank" disabled class="form-control" type="text" name="rec_bank" value="">
                                  </div>
                                </div>

                                <br>

                                <div class="form-group margin-top-short row">
                                  <div class="col-md-2">
                                  <label for="account" class=" control-label">{{ trans('pay.cuenta') }}</label>
                                  </div>
                                    <div class="col-md-8">
                                      <input style="font-size:22px" id="rec_cuenta" disabled class="form-control" type="text" name="rec_cuenta" value="">
                                    </div>
                                </div>
                                <div class="form-group margin-top-short row">
                                  <div class="col-md-2">
                                  <label for="clabe" class="control-label">{{ trans('pay.clabe') }}</label>
                                  </div>
                                  <div class="col-md-8">
                                    <input style="font-size:22px" type="text" class="form-control" id="rec_clabe" name="rec_clabe" placeholder="{{ trans('pay.clabe_int') }}" disabled>
                                  </div>
                                </div>

                                <div class="form-group margin-top-short row">
                                  <div class="col-md-2">
                                  <label for="reference_banc" class="control-label">{{ trans('pay.reference') }}</label>
                                  </div>
                                  <div class="col-md-8">
                                    <input style="font-size:22px" type="text" class="form-control" id="rec_reference" name="rec_reference" placeholder="{{ trans('pay.reference_bank') }}" disabled>
                                  </div>
                                </div>
                           </div>
                        </div>
                      </div>
                      <hr>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-2">
                        <label for="observaciones" class=" control-label">{{ trans('pay.observation') }}</label>
                        </div>
                        <div class="col-md-9">
                          <textarea disabled style="resize:none;" class="form-control" id="rec_observation" name="rec_observation" rows="4" cols="40"></textarea>
                        </div>
                      </div>
                    </div>

                    <br>
                    <div class="form-group row">
                      <div class="col-md-2">
                      <label  class="control-label">Subtotal:</label>
                      </div>
                      <div class="col-md-4">
                        <input id="subtotal" type="text" class="form-control" disabled>
                      </div>
                    </div>

                    <br>
                    <div class="form-group  row  pt-10">
                      <div class="col-md-2">
                      <label  class=" control-label">IVA:</label>
                      </div>
                      <div class="col-md-4">
                        <input id="iva" type="text" class="form-control" disabled>
                      </div>
                    </div>

                    <br>
                    <div class="form-group row pt-10">
                      <div class="col-md-2">
                      <label  class="control-label">Total:</label>
                      </div>
                      <div class="col-md-4">
                        <input id="total" type="text" class="form-control" disabled>
                      </div>
                    </div>

                    <br>
                    <div class="row">
                      <div class="col-sm-12">
                        <p><strong>{{ trans('pay.confpay') }}: </strong> <small id="rec_name_conf">{{ trans('pay.no_data') }}</small></p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <p><strong>{{ trans('pay.delconfpay') }}: </strong> <small id="rec_name_conf_del">{{ trans('pay.no_data') }}</small></p>
                      </div>
                    </div>
                  </div>

                  <!------------------------------------------------------------------------------------------------------------------------------------------------------->
              </div>
            </div>

        </div>
        <div class="modal-footer">
          @if ( auth()->user()->can('View level three payment notification') )
            <button type="button" class="btn btn-warning btn-aprobar"><i class="fa fa-check"></i> Aprobar</button>
          @endif
          <button type="button" class="btn btn-success btn-print-invoice"><i class="fa fa-download"></i> Descargar facturas (.zip)</button>
          <button type="button" class="btn btn-danger btn-print-pdf"><i class="fas fa-file-pdf"></i> Descargar factura PDF</button>
          <button type="button" class="btn btn-primary btn-export"><i class="fa fa-print"></i> Exportar solicitud</button>
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
