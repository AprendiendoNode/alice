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
              <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                <form id="form-modal" class="row">
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
                        <div class="form-group row">
                         <a onclick="show_logs(this)" id="button_history"  data-id="0"  href="javascript:void(0);" class="btn btn-warning ml-2"><i class="fa fa-history"></i> Historial</a>
                         <div class="col-sm-7"></div>
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
                </form>

              <!--  Fin del header de pago -->
              <hr>
            <br>
              <!------------------------------------------------------------------------------------------------------------------------------------------------------->
            <div  class="row">
              <div id="data_products" class="col-md-12">

              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="text-dark" id="label_reviso" for="reviso">Revisó: </label>
                  <p class="form-control-static" id="reviso"></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="text-dark" id="label_autorizo" for="autorizo">Autorizó: </label>
                  <p class="form-control-static" id="autorizo"></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="text-dark" for="entrego">Entregó: </label>
                  <p class="form-control-static" id="entrego"></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="observaciones">Observaciones: </label>
                  <p class="form-control-static" id="observaciones"></p>
                </div>
              </div>
            </div>
            <hr>
            <div  class="row">
              <div id="data_installation" class="col-md-12">

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

<!--Modal logs--->
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
