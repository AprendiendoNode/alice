<div class="modal fade" id="modal-view-concept" role="dialog">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="" style="margin-right: 4px;"></i><span class="badge badge-dark" id="tipo_doc"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
          <div class="box-body">
    <!-------INFORMACION DEL PROYECTOS--------------------------------------------->
        <form id="form-modal" class="row">
        <input type="hidden" name="id_doc" id="id_doc" value="">
                <div class="col-12">
                  <div class="row">
                      <h6 class="text-danger">* Datos del proyecto</h6>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="form-group row">
                          <label class="col-sm-5 control-label">{{ trans('documentp.proyect') }}:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static"><span id="proyecto"></span></p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-5 control-label">{{ trans('documentp.vertical') }}:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static"><span id="vertical"></span></p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-5 control-label">{{ trans('documentp.type') }}:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static"><span id="tipo"></span></p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-5 control-label">{{ trans('documentp.instalacion') }}:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static"><span id="instalacion"></span></p>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group row">
                          <label class="col-sm-7 control-label">{{ trans('documentp.densidad') }}:</label>
                          <div class="col-sm-5">
                            <p class="form-control-static"><span id="densidad"></span></p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-7 control-label">{{ trans('documentp.numsite') }}:</label>
                          <div class="col-sm-5">
                            <p class="form-control-static"><span id="sitios"></span></p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-7 control-label">{{ trans('documentp.num_oportunity') }}:</label>
                          <div class="col-sm-5">
                            <p class="form-control-static"><span id="num_oportunidad"></span></p>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group row">
                          <label class="col-sm-5 control-label">{{ trans('documentp.date_solicitude') }}:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static"><span id="fecha"></span></p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-5 control-label">{{ trans('documentp.folio') }}:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static"><span id="folio"></span></p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-5 control-label">{{ trans('documentp.itc') }}:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static"><span id="itc"></span></p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-5 control-label">{{ trans('documentp.comercial') }}:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static"><span id="comercial"></span></p>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row">
                      <h6 class="text-danger">* Datos financieros</h6>
                  </div>
                  <div class="row">
                    <div class="col-12 col-md-3">
                      <div class="form-group row">
                          <label class="col-sm-5 control-label text-success">Servicio mensual:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static">$<span id="servicio_mensual"></span> USD</p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-5 control-label text-success">Plazo:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static"><span id="plazo"></span> meses</p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-5 control-label text-success">Renta anticipada:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static">$<span id="renta_anticipada"></span> USD</p>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-5 control-label text-success">Capex:</label>
                          <div class="col-sm-7">
                            <p class="form-control-static">$<span id="capex"></span> USD</p>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 table-responsive">
                      <table id="tabla_objetivos" class="table table-striped table-condensed">
                        <thead class="bg-dark text-white">
                          <tr>
                            <th colspan="2">OBJETIVOS DEL PROYECTO (USD)</th>
                            <th>%</th>
                            <th></th>
                          </tr>
                          <tbody>
                            <tr>
                              <td>Utilidad Mensual</td>
                              <td>$<span id="utilidad_mensual">0.0</span> </td>
                              <td> <span id="utilidad_mensual_percent"></span></td>
                              <td></td>
                            </tr>
                            <tr class="text-primary">
                              <td>Utilidad Proyecto!!</td>
                              <td>$<span id="utilidad_proyecto">0.0</span> </td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr class="text-primary">
                              <td>VTC!!</td>
                              <td>$<span id="vtc">0.0</span> </td>
                              <td><span id="vtc_percent"></span></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td>Renta Mensual / Inversión</td>
                              <td></td>
                              <td><span id="renta_mensual_inversion">0</span>%</td>
                              <td id="renta_mensual_inversion_icon"></td>
                            </tr>
                            <tr>
                              <td>% Utilidad / Inversión</td>
                              <td></td>
                              <td> <span id="utilidad_inversion">0</span>% </td>
                              <td id="utilidad_inversion_icon"></td>
                            </tr>
                            <tr>
                              <td>% Utilidad / Renta</td>
                              <td></td>
                              <td> <span id="utilidad_renta">0</span>% </td>
                              <td id="utilidad_renta_icon"></td>
                            </tr>
                            <tr>
                              <td>TIR</td>
                              <td></td>
                              <td><span id="tir">0.0</span>%</td>
                              <td id="tir_icon"></td>
                            </tr>
                            <tr>
                              <td>Utilidad a 3 años</td>
                              <td>$<span id="utilidad_3_anios">0.0</span> </td>
                              <td>$<span id="utilidad_3_anios_percent">0</span> (MIN)</td>
                              <td id="utilidad_3_anios_percent_icon"></td>
                            </tr>
                            <tr>
                              <td>Tiempo de retorno</td>
                              <td><span id="tiempo_retorno">0.0</span> meses</td>
                              <td> </td>
                              <td id="tiempo_retorno_icon"></td>
                            </tr>
                          </tbody>
                        </thead>
                      </table>
                    </div>
                    <!-------checks directores-------------------------------------------------------------->
                    <div class="col-12 col-md-3">
                      <div  class="row">
                        <div id="checks_propuesta_comercial" class="col-md-12">
            
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-12">
                  <div class="form-group row">
                    <a onclick="show_logs(this)" id="button_history"  data-id="0"  href="javascript:void(0);" class="btn btn-warning ml-2"><i class="fa fa-history"></i> Historial</a>
                    <div class="col-sm-7"></div>
                   </div>
                </div>
              </form>

            <!--  Fin del header de pago -->
            <hr>
          <br>
 <!-------TABLA DE PRODUCTOS-------------------------------------------------------------->
          <div  class="row">
            <div id="data_products" class="col-md-12">

            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
      </div>
    </div>
  </div>
</div>
</div>

<!-----------Modal logs----------------------------------->
<div class="col-md-5">
<div class="modal fade" id="modal-logs" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-history" style="margin-right: 4px;"></i> Historial de modificaciones</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body table-responsive">
              <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
                  <div class="table-responsive">
                    <table id="table_documentp_logs" class="table table-striped table-bordered table-hover">
                      <thead style="height:15px !important;">
                        <tr class="bg-secondary">
                          <th> <small>Fecha del movimiento</small> </th>
                          <th class="cell-short"> <small>Cantidad anterior</small> </th>
                          <th class="cell-short"> <small>Cantidad actual</small> </th>
                          <th class="cell-large"> <small>Descripción</small> </th>
                          <th> <small>Acción</small> </th>
                          <th> <small>Modificó</small> </th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot id='tfoot_average'>
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

