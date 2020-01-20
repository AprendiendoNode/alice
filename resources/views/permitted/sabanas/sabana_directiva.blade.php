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
                  <th></th>
                  <th>Hotel</th>
                  <th>Key</th>
                  <th>Fecha inicio</th>
                  <th>Fecha final</th>
                  <th>Meses restantes</th>
                  <th>Mensualidad USD</th>
                  <th>Presupuesto anual</th>
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
                    <h4><strong>$<span id="total_xejercier"></span></strong></h4>
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
        <h3><i class="fas fa-file-contract"></i> Vigencia de contratos</h3>
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

    <div class="row pb-3">
      <div class="col-md-12">
        <!--<button id="hide">Ocultar</button>-->
      <div id="gantt_cadenas" class="w-100" style="height:500px;" ></div>
      </div>
    </div>

<!--
    <div class="table-responsive">
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
    </div>
-->



  </div>
@endsection()
<!--Contenido-->

@push('scripts')
  @if( auth()->user()->can('View dash sabana') )
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <link href="{{ asset('bower_components/dhtmlx-gantt/dhtmlxgantt.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/dhtmlx-gantt/dhtmlxgantt.js')}}"></script>
    <script src="{{ asset('bower_components/dhtmlx-gantt/ext/dhtmlxgantt_tooltip.js')}}"></script>
    <script src="{{ asset('bower_components/dhtmlx-gantt/ext/dhtmlxgantt_drag_timeline.js')}}"></script>
    <script src="{{ asset('js/admin/sabana/sabana_directiva.js?v=1.0.0')}}"></script>

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
        background-color: #03aa3f !important;
    }
    </style>

  @else
    <!--NO SCRIPTS-->
  @endif
@endpush
