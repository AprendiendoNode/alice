@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View dashboard pral') )
    Tesorería
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View dashboard pral') )
    {{ trans('message.dashboard') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View dashboard pral') )
    <div class="container">
      <div class="row">
        <!-- Row Fecha -->
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pb-2">
            <!-- <form id="search_info" name="search_info" class="form-inline" method="post"> -->
            <form class="" action="" method="">
              {{ csrf_field() }}
              <div class="card">
              <div class="card-body">
                  <div class="row">
                  <div class="col-sm-2">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      <input id="date_to_search" type="number" min="1" max="53"class="form-control" name="date_to_search" placeholder="# semana" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="true">
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="input-group">
                      <input id="year_to_search" type="number" min="2000"class="form-control" name="year_to_search" placeholder="# año" required="true">
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                    <i class="fas fa-filter"></i>  Filtrar
                    </button>
                  </div>
                  <div class="col-sm-1">
                    <label for="">Current Rate:</label>
                  </div>
                  <div class="col-sm-2">
                      <div class="input-group">
                      <input type="text" id="dollar" name="dollar" value="{{$dollar}}" class="form-control" readonly="readonly">
                      </div>
                  </div>
                  </div>
              </div>
              </div>
            </form>

        </div>
        <hr>
        <!-- Contenido. -->
        <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
          <div class="hojitha"   style="background-color: #fff; border:1px solid #ccc; border-bottom-style:hidden; padding:10px; width: 100%">
            <div class="row text-center contact-info">
                <div class="col-sm-12">
                  <hr />
                    <span>
                        <strong>Reporte de movimientos bancos(MXN)</strong>
                    </span>
                  <hr />
                  <div class="clearfix mt-10">
                    <div class="table-responsive table_dyn_mx">
                      <table id="table_banks1" class="table table-bordered  table-striped table-hover display compact-tab" style="width: 100%">
                        <thead>
                          <tr style="background: #1B1D23">
                            <th> <small>Banco</small> </th>
                            <th class="sum_col"> <small>Saldo inicial</small> </th>
                            <th class="sum_col"> <small>Depositos</small> </th>
                            <th class="sum_col"> <small>Retiros</small> </th>
                            <th class="sum_col"> <small>Saldo final</small> </th>
                            <th class="sum_col " style="background: #005A96"> <small>Saldo inicial MXN</small> </th>
                            <th class="sum_col " style="background: #005A96"> <small>Saldo final MXN</small> </th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot id='tfoot_average'>
                          <tr >
                            <th></th>
                            <th></th>
                            <th id="tdep_mov"></th>
                            <th id="tret_mov"></th>
                            <th></th>
                            <th id="t1_i"></th>
                            <th id="t1_f"></th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
            </div>

            <div class="row text-center contact-info">
                <div class="col-sm-12">
                  <hr />
                    <span>
                        <strong>Reporte de movimientos bancos(USD)</strong>
                    </span>
                  <hr />
                  <div class="clearfix mt-10">
                    <div class="table-responsive table_dyn_usd">
                      <table id="table_banks2" class="table table-bordered table-striped table-hover display compact-tab" style="width: 100%">
                        <thead>
                          <tr style="background: #1B1D23">
                            <th> <small>Banco</small> </th>

                            <th class="sum_col"> <small>Saldo inicial</small> </th>
                            <th class="sum_col"> <small>Depositos</small> </th>
                            <th class="sum_col"> <small>Retiros</small> </th>
                            <th class="sum_col"> <small>Saldo final</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Saldo inicial MXN</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Saldo final MXN</small> </th>
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
                            <th id="t2_i"></th>
                            <th id=t2_f></th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
            </div>

            <div class="row text-center contact-info">
                <div class="col-sm-12">
                  <hr />
                    <span>
                        <strong>Reporte de movimientos bancos extranjeros</strong>
                    </span>
                  <hr />
                  <div class="clearfix mt-10">
                    <div class="table-responsive table_dyn_ext">
                      <table id="table_banks3" class="table table-bordered table-striped table-hover display compact-tab" style="width: 100%">
                        <thead>
                          <tr style="background: #1B1D23">
                            <th> <small>Banco</small> </th>
                            <th class="sum_col"> <small>Saldo inicial</small> </th>
                            <th class="sum_col"> <small>Depositos</small> </th>
                            <th class="sum_col"> <small>Retiros</small> </th>
                            <th class="sum_col"> <small>Saldo final</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Saldo inicial MXN</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Saldo final MXN</small> </th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot id='tfoot_average'>
                          <tr >
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th id="t3_i"></th>
                            <th id="t3_f"></th>
                          </tr>
                          <tr style="background: #252525; padding:0;" >
                            <th class="text-white" colspan="5">Gran total</th>
                            <th class="text-white" id="gt_i"></th>
                            <th class="text-white" id="gt_f"></th>
                          </tr>

                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
            <!--Credito revolvente -->
            <div class="row text-center contact-info">
                <div class="col-sm-12">
                  <hr />
                    <span>
                        <strong>Crédito Revolvente</strong>
                    </span>
                  <hr />
                  <div class="clearfix mt-10">
                    <div class="table-responsive table_dyn_ext">
                      <table id="table_banks4" class="table table-bordered table-striped table-hover display compact-tab" style="width: 100%">
                        <thead>
                          <tr style="background: #1B1D23">
                            <th> <small>Banco</small> </th>
                            <th class="sum_col"> <small>Saldo inicial</small> </th>
                            <th class="sum_col"> <small>Depositos</small> </th>
                            <th class="sum_col"> <small>Retiros</small> </th>
                            <th class="sum_col"> <small>Saldo final</small> </th>
                            <!--<th class="sum_col" style="background: #005A96"> <small>Saldo inicial MXN</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Saldo final MXN</small> </th>-->
                            <th class="sum_col" style="background: #EB382B"> <small>Deuda actual</small> </th>
                            <th class="sum_col"style="background: #005A96" > <small>Disponible</small> </th>
                            <th class="sum_col" > <small>Monto Crédito</small> </th>
                            <th style="background: #008B86"><small>Liquidez Disponible(MXN)</small></th>
                          </tr>
                        </thead>
                        <tbody>
                        <!--  <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        -->
                        </tbody>
                        <tfoot id='tfoot_average'>
                          <tr >
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <!--<th id="t1_i"></th>
                            <th id="t1_f"></th>-->
                            <th></th>
                            <th id="rev_disp"></th>
                            <th></th>
                            <th id="liquidez_tot">gfd</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
            </div>


            <div class="row text-center contact-info">
                <div class="col-sm-12">
                  <hr />
                    <span>
                        <strong>Reporte bancario</strong>
                    </span>
                  <hr />
                  <div class="clearfix mt-10">
                    <!-- <div id="main_nps" style="width: 100%; min-height: 400px; border:1px solid #ccc;padding:10px;"></div> -->
                    <div class="table-responsive">
                      <table id="table_all_banks" class="table table-bordered table-striped table-hover display compact-tab" style="width: 100%">
                        <thead>
                          <!-- <tr class="bg-primary" style="background: #3D82C2">
                            <td></td>
                            <th colspan="2" align="center">MX</th>
                            <th colspan="2" align="center">USD</th>
                          </tr> -->
                          <tr class="text-center">
                              <th rowspan="1" colspan="3" class="text-center" style="background: #1B1D23;text-align: center !important;">
                                  <label>BANCARIOS</label>
                              </th>
                              <th rowspan="1" colspan="4" class="text-center" style="background: #005A96;text-align: center !important;">
                                  <label>MXN</label>
                              </th>

                              <th rowspan="1" colspan="4" class="text-center" style="background: #198E40;text-align: center !important;">
                                  <label>USD</label>
                              </th>
                          </tr>
                          <tr class="bg-primary" style="background: #252525">
                            <th style="background:#1B1D23;"> <small>Semana</small> </th>
                            <th style="background:#1B1D23;"> <small>Fecha Inicial</small> </th>
                            <th style="background:#1B1D23"> <small>Fecha Final</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Saldo inicial MX</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Depositos MX</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Retiros MX</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Saldo final MX</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>Saldo inicial USD</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>Depositos USD</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>Retiros USD</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>Saldo final USD</small> </th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot id='tfoot_average'>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th id="saldo_inicial_mxn"></th>
                            <th id="depositos_mxn"></th>
                            <th id="retiros_mxn"></th>
                            <th id="saldo_final_mxn"></th>
                            <th id="saldo_inicial_usd"></th>
                            <th id="depositos_usd"></th>
                            <th id="retiros_usd"></th>
                            <th id="saldo_final_usd"></th>

                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
            </div>

            <div class="row text-center contact-info">
                <div class="col-sm-12">
                  <hr />
                    <span>
                        <strong>Reporte contable</strong>
                    </span>
                  <hr />
                  <div class="clearfix mt-10">
                    <div class="table-responsive">
                      <table id="table_cxc" class="table table-bordered table-striped table-hover display compact-tab" style="width: 100%">
                        <thead>
                          <tr>
                              <th rowspan="1" colspan="3" class="text-center" style="background: #1B1D23">
                                  <label>BANCARIOS</label>
                              </th>
                              <th rowspan="1" colspan="4" class="text-center" style="background: #1B1D23">
                                <label >CXC</label>
                              </th>
                              <th rowspan="1" colspan="4" class="text-center" style="background: #1B1D23">
                                <label>CXP</label>
                              </th>
                          </tr>
                          <tr class="bg-primary" style="background: #252525">
                            <th style="background:#1B1D23;"> <small>Semana</small> </th>
                            <th style="background:#1B1D23;"> <small>Fecha Inicial</small> </th>
                            <th style="background:#1B1D23;"> <small>Fecha Final</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Ingresado MX</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Por cobrar MX</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>Ingresado USD</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>Por cobrar USD</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Pagado MX</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Por pagar MX</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>Pagado USD</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>Por pagar USD</small> </th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tr id="TSemana">
                          <th colspan="3" class="text-center">Total de la semana(MXN)</th>
                          <th id="Semana_Ingresado_MXN" class="text-center"></th>
                          <th id="Semana_PorCobrar_MXN" class="text-center"></th>
                          <th class="text-center"></th>
                          <th class="text-center"></th>
                          <th id="Semana_Pagado_MXN" class="text-center"></th>
                          <th id="Semana_PorPagar_MXN" class="text-center"></th>
                          <th class="text-center"></th>
                          <th class="text-center"></th>
                        </tr>
                        <tfoot id='tfoot_average'>
                          <tr >
                            <th colspan="3">Acumulado(5 semanas)</th>
                            <th id="tot_ing_acum_mxn"></th>
                            <th></th>
                            <th id="tot_ing_acum_usd"></th>
                            <th></th>
                            <th id="tot_pag_acum_mxn"></th>
                            <th></th>
                            <th id="tot_pag_acum_usd"></th>
                            <th></th>
                          </tr>
                          <tr >
                            <th colspan="3" class="text-center">Total</th>
                            <th id="Total_Ingresado_MXN" class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            <th id="Total_Pagado_MXN" class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                          </tr>
                        </tfoot>

                      </table>
                    </div>
                  </div>
                </div>
            </div>

            <div class="row text-center contact-info">
                <div class="col-sm-12">

                  <div class="clearfix mt-10">
                    <div class="table-responsive">
                      <table id="table_validaciones" class="table table-bordered display table-striped table-hover compact-tab" style="width: 100%">
                        <thead>
                          <tr>
                              <th rowspan="1" colspan="1" class="text-center " style="background: #1B1D23">
                                CONCEPTO
                              </th>
                              <th rowspan="1" colspan="2" class="text-center" style="background: #005A96">
                                <label>SALDOS MXN</label>
                              </th>

                              <th rowspan="1" colspan="2" class="text-center" style="background: #198E40">
                                <label>SALDOS USD</label>
                              </th>
                              <th rowspan="1" colspan="2" class="text-center" style="background: #1B1D23">
                                <label>SALDOS TOTAL</label>
                              </th>

                          </tr>
                          <tr class="" style="background: #1B1D23">
                            <th> <small></small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Depositos MX</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Retiros MX</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>Depositos USD</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>Retiros USD</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Suma Depositos</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Suma Retiros</small> </th>
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
                            <th></th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
            </div>

            <div class="row text-center ">
                <div class="col-sm-12">
                  <div class=" table-responsive divCXC mt-10">
                      <table id="table_cxc_vencidas" class="table table-bordered  compact-tab table-hover " style="width: 100%;">
                        <thead  >
                          <tr class="" style="background: #252525;">
                            <th class="text-center " style="background: #252525"> <small>Cuentas por cobrar</small> </th>
                            <th class="text-center  sum_col" style="background: #005A96"> <small>1 Mes(MXN)</small> </th>
                            <th class="text-center  sum_col" style="background: #005A96"> <small>2 Mes(MXN)</small> </th>
                            <th  class="text-center  sum_col" style="background: #005A96"> <small>3 Mes(MXN)</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>1 Mes(USD)</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>2 Mes(USD)</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>3 Mes(USD)</small> </th>
                            <th class="sum_col" style="background: #005A96"> <small>Total MXN</small> </th>
                            <th class="sum_col" style="background: #198E40"> <small>Total USD</small> </th>
                            <th  style="background: #005A96"> <small>Status</small> </th>
                            <th  style="background: #1B1D23"> <small>Observaciones</small> </th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot id='tfoot_average'>
                          <tr class="text-white">
                            <th class="text-center " style="background: #4C4C4C">Total General</th>
                            <th class="text-center  sum_col" style="background: #4C4C4C"></th>
                            <th class="text-center  sum_col" style="background: #4C4C4C"></th>
                            <th class="text-center  sum_col" style="background: #4C4C4C"></th>
                            <th class="text-center  sum_col" style="background: #4C4C4C"></th>
                            <th class="text-center  sum_col" style="background: #4C4C4C"></th>
                            <th class="text-center  sum_col" style="background: #4C4C4C"></th>
                            <th class="text-center  sum_col" style="background: #4C4C4C"></th>
                            <th class="text-center  sum_col" style="background: #4C4C4C"></th>
                            <th class="text-center  " style="background: #4C4C4C"></th>
                            <th class="text-center " style="background: #4C4C4C"></th>
                            <!--<th class="text-center bg-primary" style="background: #4C4C4C"></th>-->

                          </tr>
                        </tfoot>
                      </table>

                  </div>
                </div>
            </div>

          </div>
        </div>
        <hr>
      </div>

      <div class="modal modal-default fade" id="modal-view-comment" data-backdrop="static">
          <div class="modal-dialog" >
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>Comentario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="card">
              <div class="card-body">
                <div class="row">
                  <div id="captura_comentario" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="row pad-top-botm client-info">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="d-inline">
                          Contrato: <label id="clave_contrato"></label>
                          <input type="hidden" id="cadena_id"name="" value="" style="margin:1px; color:black;">
                        </div>
                        <p class="text-center" style="border: 1px solid #3D9970" >Observaciones.</p>
                        <div class="clearfix">
                          <label for="">Comentarios Anteriores</label>
                          <textarea id="history_comment"name="history_comment" class="form-control" style="resize: vertical;" placeholder="Ningun comentario" rows="6"readonly></textarea>
                        </div>
                        <div class="clearfix">
                          <label for="">Nuevo Comentario</label>

                          <textarea id="newcomment" class="form-control" style="resize: vertical;" placeholder="Comentario."></textarea>
                        </div>
                      </div>
                    </div>
                    </div>
                </div>
              </div>
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" id="save_comment"><i class="fa fa-check-circle" style="margin-right: 4px;"></i>Aceptar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </div>
            </div>
          </div>
      </div>

    </div>
    @else
      <!--NO VER-->
      @include('default.session')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View dashboard pral') )
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <!--<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-3-right-offset.css')}}" >-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extras-margins-padding.css')}}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pdf.css')}}" >
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.dataTables.min.css">
    <style media="screen">
      .none_pading {
        padding:0px 0px 0px 0px !important;
      }
      table.dataTable tfoot th {
        text-align: center !important;
      }
      .table-striped-mxn>tbody>tr:nth-child(odd)>td,
      .table-striped-mxn>tbody>tr:nth-child(odd)>th {
        background-color: #A4BED8;
        }
      .table-striped-usd>tbody>tr:nth-child(odd)>td,
      .table-striped-usd>tbody>tr:nth-child(odd)>th {
        background-color: #9FD5B7;
        }
        .table-striped>tbody> #TSemana:nth-child(odd)>th{
          background-color: #FFFFFF !important;
          font-size: 14px !important;
        }
      .table-striped>tbody>tr:nth-child(odd)>td,
      .table-striped>tbody>tr:nth-child(odd)>th {
          background-color: #DDDDDD;
        }


      .negative {
       font-weight: bold !important;
       color: red !important;
      }
      .negativeleft:before {
       content: "(";
      }
      .negativeright:after {
       content: ")";
      }
      .text-white{
        color:#FFFFFF;
      }
      #history_comment{
        white-space:break-all  !important;
      }
      .tableFixHead          { overflow-y: auto; height: 600px; }
      .tableFixHead thead th { position: sticky !important; top: 0; }

    </style>
    <script src="{{ asset('js/admin/treasury/dash_finanzas.js?v=3.5')}}"></script>
  @else
    <!--NO VER-->
  @endif
@endpush
