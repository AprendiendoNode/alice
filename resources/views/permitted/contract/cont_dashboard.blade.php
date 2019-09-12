@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View contract dashboard') )
    {{ trans('message.dashboard') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View contract dashboard') )
    {{ trans('message.contratos') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View contract dashboard') )
<!--Contenido-->
<!--Modal.......................................................................................................................................-->
    <div class="modal modal-default fade" id="modal-verOne" data-backdrop="static">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-info-circle"></i> {{ trans('message.dataRegi') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card ">
              <div class="card-body">

                <div class="row">
                  <div class="col-xs-12 d-flex align-items-center">
                    <table id="table_noventa_anexo" name='table_noventa_anexo' class="compact-tab display nowrap table table-bordered table-hover w-100">
                      <thead>
                        <tr class="bg-primary" style="background: #FF851B; font-size: 11.5px;">
                          <th>IDContrato Anexos</th>
                          <th>Clasificación</th>
                          <th>Vertical</th>
                          <th>Cadena</th>
                          <th>IDContrato Maestro</th>
                          <th>ITC</th>
                          <th>Vencimiento</th>
                          <th>-</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tfoot>
                    </table>
                  </div>
                </div>

              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cerrar') }}</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal.......................................................................................................................................-->
    <div class="modal modal-default fade" id="modal-verTwo" data-backdrop="static">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-info-circle"></i> {{ trans('message.dataRegi') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body table-responsive">
                <div class="row">
                  <div class="col-xs-12 d-flex align-items-center">
                    <table id="table_vencer_anexo" name='table_vencer_anexo' class="compact-tab display nowrap table table-bordered table-hover" >
                      <thead>
                        <tr class="bg-primary" style="background: #00A65A; font-size: 10.5px;">
                          <th>IDContrato Anexos</th>
                          <th>Clasificación</th>
                          <th>Vertical</th>
                          <th>Cadena</th>
                          <th>IDContrato Maestro</th>
                          <th>ITC</th>
                          <th>Vencimiento</th>
                          <th>-</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tfoot>
                    </table>
                  </div>
                </div>

              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cerrar') }}</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal.......................................................................................................................................-->
    <div class="modal modal-default fade" id="modal-verThree" data-backdrop="static">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-info-circle"></i> {{ trans('message.dataRegi') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card table-responsive">
              <div class="card-body">
                <!----------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                  <div class="col-md-12">
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs " role="tablist">
                        <li class="nav-item"><a href="#tab_1_1nx" class="nav-link active"data-toggle="tab" role="tab"><b>Contratos Maestros</b></a></li>
                        <li class="nav-item"><a href="#tab_2_2nx" class="nav-link "data-toggle="tab" role="tab"><b>Anexos de contrato</b></a></li>
                      </ul>
                      <div class="tab-content ">
                        <div class="tab-pane active" id="tab_1_1nx" name="tab_1_1nx">
                          <div class="row mt-10 tab_one">
                            <div class="col-xs-12 d-flex align-items-center">
                              <table id="table_act_master_now" name='table_act_master_now' class=" compact-tab display nowrap table table-bordered table-hover" cellspacing="0" width="120%">
                                <thead>
                                  <tr class="bg-primary" style="background: #dd4b39;">
                                    <th>IDContrato</th>
                                    <th>Clasificación</th>
                                    <th>Vertical</th>
                                    <th>Cadena</th>
                                    <th>Resguardo</th>
                                    <th>Descarga</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2_2nx" name="tab_2_2nx">
                          <div class="row mt-10 tab_two">
                            <div class="col-xs-12">
                              <table id="table_act_anexo_now" name='table_act_anexo_now' class=" compact-tab display nowrap table table-bordered table-hover" cellspacing="0" width="110%">
                                <thead>
                                  <tr class="bg-primary" style="background: #dd4b39;">
                                    <th>IDContrato Anexos</th>
                                    <th>Clasificación</th>
                                    <th>Vertical</th>
                                    <th>Cadena</th>
                                    <th>IDContrato Maestro</th>
                                    <th>ITC</th>
                                    <th>Descarga</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                        <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                    </div>
                  </div>
                </div>
                <!----------------------------------------------------------------------------------------------------------------------------------------------->
              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cerrar') }}</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal.......................................................................................................................................-->
    <div class="modal modal-default fade" id="modal-verFour" data-backdrop="static">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-info-circle"></i> {{ trans('message.dataRegi') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card table-responsive">
              <div class="card-body">
                <!----------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                  <div class="col-md-12">
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs " role="tablist">
                        <li class="nav-item"><a href="#tab_1_1" class="nav-link active" data-toggle="tab" role="tab"><b>Contratos Maestros</b></a></li>
                        <li class="nav-item"><a href="#tab_2_2" class="nav-link"data-toggle="tab" role="tab"><b>Anexos de contrato</b></a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1" name="tab_1_1">
                          <div class="row mt-10 tab_one">
                            <div class="col-xs-12">
                              <table id="table_act_master" name='table_act_master' class=" compact-tab display nowrap table table-bordered table-hover" cellspacing="0" width="110%">
                                <thead>
                                  <tr class="bg-primary" style="background: #00BBF2;">
                                    <th>IDContrato</th>
                                    <th>Clasificación</th>
                                    <th>Vertical</th>
                                    <th>Cadena</th>
                                    <th>Resguardo</th>
                                    <th>Descarga</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2_2" name="tab_2_2">
                          <div class="row mt-10 tab_two">
                            <div class="col-xs-12">
                              <table id="table_act_anexo" name='table_act_anexo' class="compact-tab display nowrap table table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                  <tr class="bg-primary" style="background: #00BBF2;">
                                    <th>IDContrato Anexos</th>
                                    <th>Clasificación</th>
                                    <th>Vertical</th>
                                    <th>Cadena</th>
                                    <th>IDContrato Maestro</th>
                                    <th>ITC</th>
                                    <th>Descarga</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                        <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                    </div>
                  </div>
                </div>
                <!----------------------------------------------------------------------------------------------------------------------------------------------->
              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cerrar') }}</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal.......................................................................................................................................-->
    <div class="modal modal-default fade" id="modal-verFive" data-backdrop="static">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-info-circle"></i> {{ trans('message.dataRegi') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card table-responsive">
              <div class="card-body">
                <!----------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                  <div class="col-md-12">
                    <div class="nav-tabs-custom" class="tablist">
                      <ul class="nav nav-tabs">
                        <li class="nav-item"><a href="#tab_ven_1"class="nav-link active" data-toggle="tab" role="tab"><b>Contratos Maestros</b></a></li>
                        <li class="nav-item"><a href="#tab_ven_2"class="nav-link" data-toggle="tab" role="tab"><b>Anexos de contrato</b></a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_ven_1" name="tab_ven_1">
                          <div class="row mt-10 tab_one">
                            <div class="col-xs-12">
                              <table id="table_ven_master" name='table_ven_master' class="compact-tab display nowrap table table-bordered table-hover" cellspacing="0" width="120%">
                                <thead>
                                  <tr class="bg-primary" style="background: #563D7C;">
                                    <th>IDContrato</th>
                                    <th>Clasificación</th>
                                    <th>Vertical</th>
                                    <th>Cadena</th>
                                    <th>Resguardo</th>
                                    <th>Descarga</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_ven_2" name="tab_ven_2">
                          <div class="row mt-10 tab_two">
                            <div class="col-xs-12">
                              <table id="table_ven_anexo" name='table_ven_anexo' class="compact-tab display nowrap table table-bordered table-hover" cellspacing="0" width="110%">
                                <thead>
                                  <tr class="bg-primary" style="background: #563D7C;">
                                    <th>IDContrato Anexos</th>
                                    <th>Clasificación</th>
                                    <th>Vertical</th>
                                    <th>Cadena</th>
                                    <th>IDContrato Maestro</th>
                                    <th>ITC</th>
                                    <th>Descarga</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                        <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                    </div>
                  </div>
                </div>
                <!----------------------------------------------------------------------------------------------------------------------------------------------->
              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cerrar') }}</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal.......................................................................................................................................-->
    <div class="modal modal-default fade" id="modal-verSix" data-backdrop="static">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-info-circle"></i> {{ trans('message.dataRegi') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card table-responsive">
              <div class="card-body">
                <!----------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="row">
                  <div class="col-md-12">
                    <div class="nav-tabs-custom" role="tablist">
                      <ul class="nav nav-tabs ">
                        <li class="nav-item"><a href="#tab_pause_1nx" class="nav-link active"data-toggle="tab" role="tab"><b>Contratos Maestros</b></a></li>
                        <li class="nav-item"><a href="#tab_pause_2nx" class="nav-link "data-toggle="tab" role="tab"><b>Anexos de contrato</b></a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_pause_1nx" name="tab_pause_1nx">
                          <div class="row mt-10 tab_one">
                            <div class="col-xs-12">
                              <table id="table_pause_master" name='table_pause_master' class="compact-tab display nowrap table table-bordered table-hover" cellspacing="0" width="120%">
                                <thead>
                                  <tr class="bg-primary" style="background: #101D42;">
                                    <th>IDContrato</th>
                                    <th>Clasificación</th>
                                    <th>Vertical</th>
                                    <th>Cadena</th>
                                    <th>Resguardo</th>
                                    <th>Descarga</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_pause_2nx" name="tab_pause_2nx">
                          <div class="row mt-10 tab_two">
                            <div class="col-xs-12">
                              <table id="table_pause_anexo" name='table_pause_anexo' class="compact-tab display nowrap table table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                  <tr class="bg-primary" style="background: #101D42;">
                                    <th>IDContrato Anexos</th>
                                    <th>Clasificación</th>
                                    <th>Vertical</th>
                                    <th>Cadena</th>
                                    <th>IDContrato Maestro</th>
                                    <th>ITC</th>
                                    <th>Descarga</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                        <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                    </div>
                  </div>
                </div>
                <!----------------------------------------------------------------------------------------------------------------------------------------------->
              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cerrar') }}</button>
          </div>
        </div>
      </div>
    </div>


    <!--Modal.......................................................................................................................................-->
    <div class="modal modal-default fade" id="modal-verDetOne" data-backdrop="static">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-info-circle"></i> {{ trans('message.informacionaps') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card table-responsive">
              <div class="card-body">
                <div class="row">
                  <div class="col-xs-12">
                    <table id="table_det_One" name='table_det_One' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
                      <thead >
                        <tr class="bg-primary" style="background: #46BFBD;">
                          <th>{{ trans('message.vertical') }}</th>
                          <th>{{ trans('message.noAP') }}</th>
                          <th>%</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cerrar') }}</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal.......................................................................................................................................-->
    <div class="modal modal-default fade" id="modal-verDetTwo" data-backdrop="static">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-info-circle"></i> {{ trans('message.info') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card table-responsive">
              <div class="card-body">
                <div class="row">
                  <div class="col-xs-12">
                    <table id="table_det_Two" name='table_det_Two' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
                      <thead >
                        <tr class="bg-primary" style="background: #FFA538;">
                          <th>{{ trans('message.sector') }}</th>
                          <th>{{ trans('message.importe') }}</th>
                          <th>{{ trans('message.cantidadABRE') }}</th>
                          <th>%</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cerrar') }}</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal.......................................................................................................................................-->
    <div class="modal modal-default fade" id="modal-verDetThree" data-backdrop="static">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-info-circle"></i> {{ trans('message.info') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card table-responsive">
              <div class="card-body">
                <div class="row">
                  <div class="col-xs-12">
                    <table id="table_det_Three" name='table_det_Three' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
                      <thead >
                        <tr class="bg-primary" style="background: #0091EB;">
                          <th>{{ trans('message.cadena') }}</th>
                          <th>{{ trans('message.nsitio') }}</th>
                          <th>{{ trans('message.importe') }}</th>
                          <th>%</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div><!-- /.box-body -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.cerrar') }}</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal.......................................................................................................................................-->

    <div class="">
      <form class="form-horizontal">
        {{ csrf_field() }}
      </form>
    </div>
    <section id='invoiceContep' name='invoiceContep' class="">

      <h4 class="text-right text-muted" id="date_now"></h4>
      <!--End title row -->
      <!---->
      <div class="row">
        <section class="col-md-6">
          <div id="box-dash" class="row">
            <div class="col-md-6 col-sm-4 col-xs-12">
              <div class="info-box">
                <span id='contThree' class="info-box-icon bg-danger" style="color:white;"><i class="fa fa-eye"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;">{{ trans('message.contratos') }}</span>
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;"> Nuevos</span>
                  <span class="info-box-number" class="font-extra-bold m-t-xl m-b-xs" style=" color: #676a6c;"><p id="valueOne2">0</p></span>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-4 col-xs-12">
              <div class="info-box">
                <span id='contFour' class="info-box-icon "style="background: rgb(7, 149, 240); color: white;"><i class="fa fa-eye"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;">{{ trans('message.contratos') }}</span>
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;"> Activos</span>
                  <span class="info-box-number" class="font-extra-bold m-t-xl m-b-xs" style=" color: #676a6c;"><p id="valueThree">0</p></span>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-4 col-xs-12">
              <div class="info-box">
                <span id='contFive' class="info-box-icon bg-info" style="color:white;"><i class="fa fa-eye"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;">{{ trans('message.contratos') }}</span>
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;">{{ trans('message.vencidos') }}</span>
                  <span class="info-box-number" class="font-extra-bold m-t-xl m-b-xs" style=" color: #676a6c;"><p id="valueFour">0</p></span>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-4 col-xs-12">
              <div class="info-box">
                <span id='contSix' class="info-box-icon " style="background-color: #003E61; color:white"><i class="fa fa-eye"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;">{{ trans('message.contratos') }}</span>
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;">{{ trans('message.pausados') }}</span>
                  <span class="info-box-number" class="font-extra-bold m-t-xl m-b-xs" style=" color: #676a6c;"><p id="valueSix">0</p></span>
                </div>
              </div>
            </div>
            <div  class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span id='contOne' class="info-box-icon bg-warning" style="color:white;"><i class="fa fa-eye"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;">Cartera vencida</span>
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;">a 90 días</span>
                  <span class="info-box-number" class="font-extra-bold m-t-xl m-b-xs" style=" color: #676a6c; font-size:12px;"><p id="valueOne">0</p></span>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span id='contTwo' class="info-box-icon bg-success" style="color:white;"><i class="fa fa-eye"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;">{{ trans('message.contratos') }} por</span>
                  <span class="info-box-text" style="font-size:12px; color: #676a6c;">vencer en el 2018</span>
                  <span class="info-box-number" class="font-extra-bold m-t-xl m-b-xs" style=" color: #676a6c; font-size:12px;"><p id="valueTwo">0</p></span>
                </div>
              </div>
            </div>

          </div>
        </section>
        <section class="col-md-6 pb-4">
          <!--Primer campo del dashboard-->
          <div class="card">
            <div class="card-header with-border">
              <h3 class="card-title">{{ trans('message.contratos') }}</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="d-flex justify-content-center " style="width:100%">
                  <div id="main_graph_contracts" style="width: 100%; min-height: 250px;"></div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <!---->
      <div class="row">

        <!--Segundo campo del dashboard-->
        <div class="col-md-12 pb-4">
          <div class="card">
            <div class="card-header ">
              <h3 class="card-title">{{ trans('message.graphicsTwodash') }}</h3>
            </div>
            <div class="card-body chart-responsive">
              <div class="row">
                <div class="col-md-6" id='ContentTwo'>
                  <div class="d-flex justify-content-center">
                    <div id="main_graph_vertical_master" style="width: 100%; min-height: 250px;"></div>
                  </div>
                </div>
                <div class="col-md-6" id='ContentTwoB'>
                  <div class="d-flex justify-content-center">
                    <div id="main_graph_vertical_anexo" style="width: 100%; min-height: 250px;"></div>
                  </div>
                </div>
              <!--  <div class="col-md-6">
                  <table id="table_vertical_contr" name="table_vertical_contr" class="table compact-table table-sm">
                    <thead style="background:#F1C442;color:white">
                      <tr>
                        <th>Sector</th>
                        <th>Importe(USD)</th>
                        <th>Cant.</th>
                        <th>% Fact. Mensual</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>

                  </table>
                </div>-->
              </div>
            </div>
          </div>
        </div>
        <!---->
        <div class="col-md-12 pb-4">
          <div class="card">
            <div class="card-header with-border">
              <h3 class="card-title">{{ trans('message.graphicsThreedash') }}</h3>
            </div>
            <div class="card-body chart-responsive">
              <div class="row">
                <div class="col-md-6" id='ContentTwo'>
                  <div class="clearfix">
                    <div id="main_graph_vertical_customers" style="width: 100%; min-height: 450px;padding:20px"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <table id="tablevertical_aps" name="tablevertical_aps" class="table table-sm">
                    <thead style="background:#0795F0;color:white">
                      <tr>
                        <th>Vertical</th>
                        <th>No. Ap</th>
                        <th>% Fact. Mensual</th>
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


        <!--Aun no implementado
        <div class="col-md-12 pb-4">
          <div class="card card-primary">
            <div class="card-header with-border">
              <h3 class="card-title">{{ trans('message.graphicsvtcanual') }}</h3>
            </div>
            <div class="card-body chart-responsive">
              <div class="row">
                <div class="col-md-12" id='ContentTwo'>
                  <div class="clearfix">
                    <div id="main_graph_vtc" style="width: 100%; min-height: 300px;padding:20px"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div-->


        <div class="col-md-12 pb-4">
          <div class="card card-default">
            <div class="card-header with-border">
              <h3 class="card-title">{{ trans('message.graphicsfacturacion') }}</h3>
            </div>
            <div class="card-body chart-responsive">
              <div class="row">
                <div class="col-md-4" id='ContentTwo'>
                  <div class="clearfix">
                    <div id="main_graph_fact" style="width: 100%; min-height: 350px;padding:20px"></div>
                  </div>
                </div>
                <div class="col-md-8">
                  <table id="table_fact_cont" name="table_fact_cont"  class="table table-sm ">
                    <thead style="background:#51578A;color:white">
                      <tr>
                        <th>Cadena</th>
                        <th>No. CTTO Maestro</th>
                        <th>No. Anexo de CTTO </th>
                        <th>Importe(MXN)</th>
                        <th>Importe(USD)</th>
                        <th>Importe(DOP)</th>
                        <th>Importe(CRC)</th>
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

    </section>

  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View contract dashboard') )
    <style media="screen">
  #box-dash{
    display: flex;
    flex-wrap: wrap;
  }

  #contOne, #contTwo, #contThree,
  #contFour, #contFive{
    display: flex;
    justify-content: center;
    align-items: center;
  }
  /*
 * Component: Info Box
 * -------------------
 */
.info-box {
  display: block;
  min-height: 90px;
  background: #fff;
  width: 100%;
  -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
          box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  border-radius: 2px;
  margin-bottom: 15px;
}
.info-box small {
  font-size: 14px;
}
.info-box .progress {
  background: rgba(0, 0, 0, 0.2);
  margin: 5px -10px 5px -10px;
  height: 2px;
}
.info-box .progress,
.info-box .progress .progress-bar {
  border-radius: 0;
}
.info-box .progress .progress-bar {
  background: #fff;
}
.info-box-icon {
  border-top-left-radius: 2px;
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 2px;
  display: block;
  float: left;
  height: 90px;
  width: 90px;
  text-align: center;
  font-size: 45px;
  line-height: 90px;
  background: rgba(0, 0, 0, 0.2);
}
.info-box-icon > img {
  max-width: 100%;
}
.info-box-content {
  padding: 5px 10px;
  margin-left: 90px;
}
.info-box-number {
  display: block;
  font-weight: bold;
  font-size: 18px;
}
.progress-description,
.info-box-text {
  display: block;
  font-size: 12px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.info-box-text {
  text-transform: uppercase;
}

#table_fact_cont thead tr th{
  table-layout: fixed;
  width: 80px;
  white-space: pre-wrap !important;
  padding:0; margin:0;
  font-size: 14px;
}


  </style>
  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
  <script src="{{ asset('js/admin/contract/graph.js?v1.0')}}"></script>
  <script src="{{ asset('js/admin/contract/dashboard_contract.js?v1.0')}}"></script>
  <script src="{{ asset('js/admin/contract/graph1.js?v1.0')}}"></script>
  @else
  @endif
@endpush
