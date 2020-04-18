@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View dash sabana') )
    <strong>Dashboard General Directores</strong>
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View dash sabana') )

  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View dash sabana') )
    Dirección
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

<!--Contenido-->
@section('content')
  <div class="modal modal-default fade" id="modal_presupuesto" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content" style="width: 70vw; margin-left: -15vw;">
          <div class="modal-header">
            <h4 class="modal-title"><i class="far fa-address-card" style="margin-right: 4px;"></i>Sitios.</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="table-responsive">
            <table id="table_sites" align="center"class="table table-striped table-bordered compact-tab table-hover" style="width:97% !important;">
              <thead class="bg-primary">
                <tr>
                  <th>Hotel</th>
                  <th><small>Facturado Mensual</small> </th>
                  <th><small>Presupuesto</small> </th>
                  <th><small>Ene.</small> </th>
                  <th><small>Feb.</small> </th>
                  <th><small>Mar.</small> </th>
                  <th><small>Abr.</small> </th>
                  <th><small>May.</small> </th>
                  <th><small>Jun.</small> </th>
                  <th><small>Jul.</small> </th>
                  <th><small>Ago.</small> </th>
                  <th><small>Sep.</small> </th>
                  <th><small>Oct.</small> </th>
                  <th><small>Nov.</small> </th>
                  <th><small>Dic.</small> </th>
                  <th><small>% Ejercido</small> </th>
                </tr>
              </thead>
              <tbody class="text-center"style="font-size: 11px;">

              </tbody>
            </table>
        </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-primary btn-export"><i class="fa fa-save"></i> Exportar PDF</button> -->
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
          </div>
        </div>
      </div>
  </div>

  <div class="modal modal-default fade" id="modal-mantenimiento" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content" style="width: 70vw; margin-left: -15vw;">
          <div class="modal-header">
            <h4 class="modal-title">Presupuesto de mantenimiento</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="row p-3">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <div class="table-responsive">
                <table id="table_budget" name='table_budget' class="display nowrap table table-bordered table-hover compact-tab w-100" cellspacing="0">
                  <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
                  <thead>
                      <tr class="bg-dark" style="color: white">
                          <th><small>ID</small></th>
                          <th> <small>Sitio</small> </th>
                          <th> <small>Anexo</small> </th>
                          <th> <small>ID ubicacion</small> </th>
                          <th> <small>Moneda</small> </th>
                          <th> <small>Equipo activo</small> </th>
                          <th> <small>Equipo no activo</small> </th>
                          <th> <small>Licencias</small> </th>
                          <th> <small>Mano de obra</small> </th>
                          <th> <small>Enlaces</small> </th>
                          <th> <small>Viáticos</small> </th>
                          <th> <small>Acciones</small> </th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="row ">
              <div class="col-sm-12">
                <button type="button" class="btn btn-default closeModal pull-right" data-dismiss="modal">Close</button>
              </div>
              <!-- <div class="col-sm-3">
                <button type="submit" class="btn btn-warning pull-right">Save changes</button>
              </div> -->
            </div>
          </div>
        </div>
      </div>
  </div>

  <!-- Modal 2 -->
  <div class="modal fade" id="modal-view-algo">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <!-- Contenido de modal. -->
          <input type="hidden" id="id_annex" name="id_annex">
          <form id="form_tc" class="form-inline">
            <input id="tpgeneral" name="tpgeneral" type="number" class="form-control" placeholder="Tipo de cambio(pagos, viáticos)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10">
            <div class="input-group">
             <span class="input-group-addon"><i class="far fa-calendar-alt fa-3x"></i></span>
             <input id="date_to_search_tc" type="text" class="form-control date_plug" name="date_to_search_tc">
            </div>
            <button type="button" class="btn btn-primary btnupdetc">Update</button>

          </form>

            <div class="table-responsive">
              <div class="row fields_docm">
                <div class="col-md-12">
                  <div class="form-group">
                    <h4 class="text-center text-danger">Presupuesto Anual</h4>
                    <h5 class="text-center text-default">* Montos en USD</h5>
                    <br>
                    <div id="presupuesto_anual">

                    </div>
                  </div>
                </div>
              </div>
            </div>

        </div>
        <div class="modal-footer">
          <div class="row ">
            <div class="col-sm-12">
              <button type="button" class="btn btn-default closeModal pull-right" data-dismiss="modal">Close</button>
            </div>
            <!-- <div class="col-sm-3">
              <button type="submit" class="btn btn-warning pull-right">Save changes</button>
            </div> -->
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!--Modal desglose-->
  <div class="modal fade" id="modal-desglose">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <!-- Contenido de modal. -->
          <input type="hidden" id="id_annex" name="id_annex">
          <form id="form_tc_des" class="form-inline">
            <span class="input-group-addon"><i class="fas fa-dollar-sign fa-3x"></i></span>
            <input id="tpgeneral_des" name="tpgeneral_des" type="number" class="form-control" placeholder="Tipo de cambio(pagos, viáticos)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10">
            <div class="input-group">
             <span class="input-group-addon"><i class="far fa-calendar-alt fa-3x"></i></span>
             <input id="date_to_search_tc_des" type="text" class="form-control date_plug" name="date_to_search_tc_des">
            </div>
            <button type="button" class="btn btn-primary btnupdetc_des">Update</button>

          </form>

            <div class="table-responsive">
              <div class="row fields_docm">
                <div class="col-md-12">
                  <div class="form-group">
                    <h4 class="text-center text-danger">Presupuesto Anual</h4>
                    <h5 class="text-center text-default">* Montos en USD</h5>
                    <br>
                    <div id="presupuesto_anual">
                      <table id="table_desglose" name='table_desglose' class="display nowrap table table-bordered table-hover compact-tab w-100" cellspacing="0">
                        <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
                        <thead>
                          <tr class="bg-primary" style="background: #3D82C2">
                            <th> <small>Folio</small> </th>
                            <th> <small>Factura</small> </th>
                            <th> <small>Proveedor</small> </th>
                            <th> <small>Monto</small> </th>
                            <th> <small>Ver</small> </th>
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
        <div class="modal-footer">
          <div class="row ">
            <div class="col-sm-12">
              <button type="button" class="btn btn-default closeModal pull-right" data-dismiss="modal">Close</button>
            </div>
            <!-- <div class="col-sm-3">
              <button type="submit" class="btn btn-warning pull-right">Save changes</button>
            </div> -->
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <div class="pb-2 bg-white shadow mb-5">

      <div class="row pt-2">
        <div class="d-block mx-auto">
          <h3>Resumen de estado</h3>
        </div>
      </div>
        <div class="row">
            <div class="container-box col-md-2">
                <div class="icon_head_dash">
                    <i class="text-success" aria-hidden="true"></i>
                </div>
                <div class="info_head_dash">
                    <p class="text-default">Facturación mensual USD</p>
                    <h4 style="color:green;"><strong>$<span id="total_fact"></span></strong></h4>
                </div>
            </div>

            <div class="container-box col-md-3">
                <div class="icon_head_dash">
                    <i class="text-success" aria-hidden="true"></i>
                </div>
                <div class="info_head_dash">
                    <p class="text-default">Presupuesto Anual de mantenimiento USD</p>
                    <h4 style="color:blue;"><strong>$<span id="total_pres"></span></strong></h4>
                </div>
            </div>

            <div class="container-box col-md-2">
                <div class="icon_head_dash">
                    <i class="text-success" aria-hidden="true"></i>
                </div>
                <div class="info_head_dash">
                    <p class="text-default">Ejercido anual USD</p>
                    <h4 style="color:orange;"><strong>$<span id="total_ejercido"></span></strong></h4>
                </div>
            </div>

            <div class="container-box col-md-2">
                <div class="icon_head_dash">
                    <i class="text-success" aria-hidden="true"></i>
                </div>
                <div class="info_head_dash">
                    <p class="text-default">Por ejercer anual USD</p>
                    <h4><strong>$<span id="total_xejercer"></span></strong></h4>
                </div>
            </div>

            <div class="container-box col-md-3">
                <div class="icon_head_dash">
                    <i class="text-success" aria-hidden="true"></i>
                </div>
                <div class="info_head_dash">
                    <p class="text-default">Presupuesto disponible</p>
                    <h4 style="color:green;"><strong><span id="total_percent" >100</span>%</strong></h4>
                </div>
            </div>

        </div>
  </div>
  <div class="p-3 bg-white rounded shadow mb-5">
    <div class="row pt-2 pb-2">
      <div class="d-block mx-auto">
        <!--<h3><i class="fas fa-file-contract"></i>Seleccione</h3>-->
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <h4>Presupuesto(USD)</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4 col-xs-12 mb-3">
        <!--Input Form2-->
        <div class="input-group customSpinner">
          <div class="input-group-prepend">
            <button class="btn btn-sm btn-primary  spinnerMinus">
                <span class = "fas fa-arrow-left"></span>
              </button>
          </div>
          <input type="text" id="date_select"  readonly value="0" class="form-control text-center" />
          <div class="input-group-append">
            <button class="btn btn-sm btn-primary spinnerPlus">
                <span class = "fas fa-arrow-right"></span>
              </button>
          </div>
        </div>

      </div>
      <div class="col-md-4 "></div>
    </div>


    <div class="row pt-5">
      <!--<div class="table-responsive">
        <table id="table_budget_cadena" class="table table-bordered  table-striped table-hover display compact-tab" style="width: 100%">
          <thead class="bg-primary">
            <tr class="bg-aqua text-center">
              <th> <small>Cadena</small> </th>
              <th > <small>Mensualidad USD</small> </th>
              <th > <small>Presupuesto anual de mantenimiento USD</small> </th>
              <th> <small>Opciones</small> </th>
            </tr>
          </thead>
          <tbody class="text-center">
          </tbody>
          <tfoot >
            <tr >
              <th></th>
              <th></th>
              <th></th>
              <th ></th>
            </tr>
          </tfoot>
        </table>
      </div>-->
      <div class="col-md-12">
        <!--<button id="hide">Ocultar</button>-->
      <div id="gantt_cadenas" class="w-100" style="height:500px;" ></div>
      </div>
    </div>


        <div class="table-responsive pt-5">
          <table id="table_budget_months" name='table_budget' class="display nowrap table table-bordered table-hover compact-tab w-100" cellspacing="0">
            <thead>
              <tr class="bg-primary text-center">
                <th><small>Cadena</small> </th>
                <th class="sum_col"><small>Facturado Mensual</small> </th>
                <th class="sum_col"><small>Presupuesto</small> </th>
                <th class="sum_col"><small>Ene.</small> </th>
                <th class="sum_col"><small>Feb.</small> </th>
                <th class="sum_col"><small>Mar.</small> </th>
                <th class="sum_col"><small>Abr.</small> </th>
                <th class="sum_col"><small>May.</small> </th>
                <th class="sum_col"><small>Jun.</small> </th>
                <th class="sum_col"><small>Jul.</small> </th>
                <th class="sum_col"><small>Ago.</small> </th>
                <th class="sum_col"><small>Sep.</small> </th>
                <th class="sum_col"><small>Oct.</small> </th>
                <th class="sum_col"><small>Nov.</small> </th>
                <th class="sum_col"><small>Dic.</small> </th>
                <th class="sum_ejer"><small>% Ejercido</small> </th>
                <th><small></small> </th>
              </tr>
            </thead>
            <tbody class="text-center">

            </tbody>
            <!--<tfoot id='tfoot_average' class="bg-dark text-center text-white">
              <tr>
                <th class="text-center">TOTAL</th>
                <th id="facturado_mensual"></th>
                <th id="total_presupuesto"></th>
                <th id="total_ene"></th>
                <th id="total_feb"></th>
                <th id="total_mar"></th>
                <th id="total_abr"></th>
                <th id="total_may"></th>
                <th id="total_jun"></th>
                <th id="total_jul"></th>
                <th id="total_ago"></th>
                <th id="total_sep"></th>
                <th id="total_oct"></th>
                <th id="total_nov"></th>
                <th id="total_dic"></th>
                <th id="total_ejercido"></th>
                <th id="total_ejercido"></th>
              </tr>
            </tfoot>-->
          </table>
        </div>






  </div>
@endsection()
<!--Contenido-->

@push('scripts')
  @if( auth()->user()->can('View dash sabana') )
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <link type="text/css" href="css/bootstrap-editable.css" rel="stylesheet" />
    <script src="{{ asset('js/bootstrap-editable.js')}}"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <link href="{{ asset('bower_components/dhtmlx-gantt/dhtmlxgantt.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/dhtmlx-gantt/dhtmlxgantt.js')}}"></script>
    <script src="{{ asset('bower_components/dhtmlx-gantt/ext/dhtmlxgantt_tooltip.js')}}"></script>
    <script src="{{ asset('bower_components/dhtmlx-gantt/ext/dhtmlxgantt_drag_timeline.js')}}"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('js/admin/sabana/sabana_directiva.js?v=1.0.10')}}"></script>
    <script src="{{ asset('js/admin/planning/budgets.js?v=1.0.2')}}"></script>
    <!--<script src="{{ asset('js/admin/payments/request_modal_payment.js?v=v4.1.2')}}"></script>-->

    <style media="screen">
    .icon_head_dash i{
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 5px;
      font-size: 2em;
    }

    .info_head_dash{
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 5px;
      text-align: center;
    }

    .container-box div{
      display: inline-block;
    }

    .container-box{
      margin-top: 1em;
      display: flex;
      justify-content: center;
      align-items: center;
      border-right: 1px solid #eee;
    }

    td.details-control {
    background-color: green;
    cursor: pointer;
    }
    tr.shown td.details-control {
        background-color: red;
    }

    .year{ background: #414141!important; color:white !important;}

    /*gantt colors */
    .high{
        border-color: #d96c49 !important;
        color: #d96c49 !important;
        background-color: #d96c49 !important;
    }
    .high .gantt_task_progress{
        background-color: #db2536 !important;
    }
    .medium{
        border-color: #ff7a00 !important;
        color:#ff7a00 !important;
        background-color: #e6740b !important;
    }
    .medium .gantt_task_progress{
        background-color: #f77d0c !important;
    }
    .low{
    border-color: #08cb4f !important;
    color:#08cb4f !important;
    background-color: #0aad46 !important;
    }
    .low .gantt_task_progress{
        background-color: #08913a !important;
    }

    #gantt_cadenas{
    background:white;
    width:600px;
    height:600px;
      }

    .cad, .sit {
      cursor: pointer;
    }

    </style>

  @else
    <!--NO SCRIPTS-->
  @endif
@endpush
