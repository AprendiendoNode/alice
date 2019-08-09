<div class="modal modal-default fade" id="modal-view-concept" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="" style="margin-right: 4px;"></i><span class="badge badge-primary" id="tipo_doc"></span></h4>
        </div>
        <div class="modal-body table-responsive">
            <div class="box-body">
              <div class="row">
                  <!------------------------------------------------------------------------------------------------------------------------------------------------------->
                  <div id="captura_pdf_general" style="margin-left:3em;font-size:1.1em;" class="">
                    <div class="hojitha">
                      <div class="header-pays">
                        <form class="form-horizontal">
                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                  <label class="col-sm-5 control-label">{{ trans('documentp.proyect') }}:</label>
                                  <div class="col-sm-7">
                                    <p class="form-control-static"><span id="proyecto"></span></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-5 control-label">{{ trans('documentp.vertical') }}:</label>
                                  <div class="col-sm-7">
                                    <p class="form-control-static"><span id="vertical"></span></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-5 control-label">{{ trans('documentp.type') }}:</label>
                                  <div class="col-sm-7">
                                    <p class="form-control-static"><span id="tipo"></span></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-5 control-label">{{ trans('documentp.instalacion') }}:</label>
                                  <div class="col-sm-7">
                                    <p class="form-control-static"><span id="instalacion"></span></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-5 control-label">
                                    <a onclick="show_logs(this)" id="button_history"  data-id="0"  href="javascript:void(0);" class="btn btn-warning"  type="button" name="button"><i class="fa fa-history"></i> Historial</a>
                                  </label>
                                  <div class="col-sm-7"></div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                  <label class="col-sm-7 control-label">{{ trans('documentp.densidad') }}:</label>
                                  <div class="col-sm-5">
                                    <p class="form-control-static"><span id="densidad"></span></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-7 control-label">{{ trans('documentp.numsite') }}:</label>
                                  <div class="col-sm-5">
                                    <p class="form-control-static"><span id="sitios"></span></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-7 control-label">{{ trans('documentp.num_oportunity') }}:</label>
                                  <div class="col-sm-5">
                                    <p class="form-control-static"><span id="num_oportunidad"></span></p>
                                  </div>
                              </div>
                            </div>
                            <div class="col-md-5">
                              <div class="form-group">
                                  <label class="col-sm-5 control-label">{{ trans('documentp.date_solicitude') }}:</label>
                                  <div class="col-sm-7">
                                    <p class="form-control-static"><span id="fecha"></span></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-5 control-label">{{ trans('documentp.folio') }}:</label>
                                  <div class="col-sm-7">
                                    <p class="form-control-static"><span id="folio"></span></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-5 control-label">{{ trans('documentp.itc') }}:</label>
                                  <div class="col-sm-7">
                                    <p class="form-control-static"><span id="itc"></span></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-5 control-label">{{ trans('documentp.comercial') }}:</label>
                                  <div class="col-sm-7">
                                    <p class="form-control-static"><span id="comercial"></span></p>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                      <!--  Fin del header de pago -->
                      <hr>
                    <br>

                  </div>

                  <!------------------------------------------------------------------------------------------------------------------------------------------------------->
              </div>
            </div>
            <div  class="row">
              <div id="data_products" class="col-md-12">

              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="reviso">Revisó: </label>
                  <p class="form-control-static" id="reviso"></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="autorizo">Autorizó: </label>
                  <p class="form-control-static" id="autorizo"></p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="entrego">Entregó: </label>
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
  <div class="modal modal-default fade" id="modal-logs" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-history" style="margin-right: 4px;"></i> Historial de modificaciones</h4>
          </div>
          <div class="modal-body table-responsive">
            <div class="box-body">
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pt-10">
                    <div class="table-responsive">
                      <table id="table_documentp_logs" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr class="bg-primary" style="background: #088A68;">
                            <th> <small>Fecha del movimiento</small> </th>
                            <th> <small>Cantidad anterior</small> </th>
                            <th> <small>Cantidad actual</small> </th>
                            <th> <small>Descripción</small> </th>
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
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<style media="screen">
  .pt-10 { padding-top: 10px;  }
  .margin-top-short{ margin-top: 7px;  }
  .modal-content{
    width: 190% !important;
    margin-left: -40% !important;
  }

  .form-group {
    margin-bottom: 0px !important;
  }

  .red-color{
    color: #A72B30;
    font-weight: bold;
  }

  .header-pay p{
    font-weight: bold;
  }

  .header-pays span{
    font-weight: normal;
    color: #585858;
  }

  #tipo_doc{
    font-size: 1em;
  }
</style>
<script type="text/javascript">
$(document).ready(function() {



$(document).on({
  'show.bs.modal': function() {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
      $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
  },
  'hidden.bs.modal': function() {
    if ($('.modal:visible').length > 0) {
      // restore the modal-open class to the body element, so that scrolling works
      // properly after de-stacking a modal.
      setTimeout(function() {
        $(document.body).addClass('modal-open');
      }, 0);
    }
  }
}, '.modal');
});

</script>
