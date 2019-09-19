@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View dashboard project') )
    Dashboard de proyectos
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View dashboard project') )
    Dashboard de proyectos
  @else
      {{ trans('message.denied') }}
  @endif
@endsection

@section('content')

  @if( auth()->user()->can('View dashboard project') )

      <div class="row">
        <div class="col-12 card">
          <div class="row d-flex mb-short">
            <div class="col-xs-12 col-md-6">
              <h3 class="text-title">Resumen de compras</h3>
            </div>
            <div class="col-xs-12 col-md-6 col-md-offset-1">
              {{-- <form id="search_info" name="search_info" class="form-inline" method="post">
                {{ csrf_field() }}
                <div class="col-xs-8 col-md-7">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input id="date_to_search" type="text" class="form-control" name="date_to_search">
                  </div>
                </div>
                <div class="col-xs-3 col-md-5">
                  <button id="boton-aplica-filtro" type="button" class="btn btn-info filtrarDashboard">
                    <i class="glyphicon glyphicon-filter" aria-hidden="true"></i>  Filtrar
                  </button>
                </div>
              </form> --}}
            </div>
          </div>
          <ul class="nav nav-tabs" role="tablist">

            <li class="nav-item"></a>
              <a class="nav-link active" id="docp-tab" data-toggle="tab" href="#docp" role="tab" aria-controls="docp" aria-selected="true">DOCUMENTO P</a>
            </li>
            <li class="nav-item"></a>
              <a class="nav-link" id="docm-tab" data-toggle="tab" href="#docm" role="tab" aria-controls="docm" aria-selected="true">DOCUMENTO M</a>
            </li>
            <li class="nav-item"></a>
              <a class="nav-link" id="docc-tab" data-toggle="tab" href="#docc" role="tab" aria-controls="docc" aria-selected="true">COTIZACIONES</a>
            </li>
          </ul>
          <!---TABS--->
          <div class="tab-content">
            <div id="docp" class="tab-pane fade show active" aria-labelledby="docp-tab">
              <div class="row">
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-usd text-success" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Total Autorizado USD</p>
                    <h4><strong>${{number_format($status_compras[0]->Total_autorizado, 2, '.', ',')}}</strong></h4>
                  </div>
                </div>

                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-hashtag text-danger" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Total</p>
                    <h4><strong>{{ $status_compras[0]->Total_solicitudes }}</strong></h4>
                  </div>
                </div>

                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fas fa-check-square text-success"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Autorizado</p>
                    <h4><strong>{{ $status_compras[0]->Autorizado }}</strong></h4>
                  </div>
                </div>

                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-paper-plane text-primary" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Entregado</p>
                    <h4><strong>{{ $status_compras[0]->Entregado}}</strong></h4>
                  </div>
                </div>
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-eye text-warning" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Revisado</p>
                    <h4><strong>{{ $status_compras[0]->Revisado}}</strong></h4>
                  </div>
                </div>

                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-plus-square text-info" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default"> Nuevos </p>
                    <h4><strong>{{ $status_compras[0]->Nuevo }}</strong></h4>
                  </div>
                </div>

              </div>
            </div>
            <div id="docm" class="tab-pane fade">
              <div class="row">
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-usd text-success" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Total Autorizado USD</p>
                    <h4><strong>{{number_format($status_compras[1]->Total_autorizado, 2, '.', ',')}}</strong></h4>
                  </div>
                </div>

                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-hashtag text-danger" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Total</p>
                    <h4><strong>{{ $status_compras[1]->Total_solicitudes }}</strong></h4>
                  </div>
                </div>

                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fas fa-check-square text-success"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Autorizado</p>
                    <h4><strong>{{ $status_compras[1]->Autorizado }}</strong></h4>
                  </div>
                </div>

                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-paper-plane text-primary" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Entregado</p>
                    <h4><strong>{{ $status_compras[1]->Entregado}}</strong></h4>
                  </div>
                </div>
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-eye text-warning" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Revisado</p>
                    <h4><strong>{{ $status_compras[1]->Revisado}}</strong></h4>
                  </div>
                </div>

                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-plus-square text-info" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default"> Nuevos </p>
                    <h4><strong>{{ $status_compras[1]->Nuevo }}</strong></h4>
                  </div>
                </div>

              </div>
            </div>
            <div id="docc" class="tab-pane fade">
              <div class="row">
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-hashtag text-danger" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Total</p>
                    <h4><strong>{{ $status_compras[2]->Revisado +  $status_compras[2]->Nuevo}}</strong></h4>
                  </div>
                </div>
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-eye text-warning" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">En revisión</p>
                    <h4><strong>{{ $status_compras[2]->Revisado}}</strong></h4>
                  </div>
                </div>
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fa fa-plus-square text-info" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default"> Nuevos </p>
                    <h4><strong>{{ $status_compras[2]->Nuevo }}</strong></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <!---------------------------------------------------->
      <div class="row">
        <div class="col-12 card">
          <div class="row">
            <div class="col-12 col-md-6">
              <h4 class="text-title">Estatus de instalación / Facturación</h4>
            </div>
            <div class="col-12 col-md-6">
              <h4 class="text-right pr-4"><span id="calif_projects">0 %</span> </h4>
            </div>
          </div>
          <div class="row d-flex mb-short">
            <div class="col-xs-12 col-md-12 table-responsive">
              <table id="table-dash" class="table table-sm table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="background:black" class="text-center text-white" colspan="7">
                      Proyectos en ejecución
                    </th>
                    <th style="background:black" class="text-center text-white" colspan="4">
                      Proyectos instalados
                    </th>
                  </tr>
                  <tr style="background: #193257;color:white;">
                    <th>Estatus</th>
                    <th class="text-center">Riesgo</th>
                    <th class="text-center">Atención</th>
                    <th class="text-center">Normal</th>
                    <th></th>
                    <th colspan="2" class="text-center">USD</th>
                    <th>Estatus</th>
                    <th class="text-center">Instalado</th>
                    <th colspan="2" class="text-center">USD</th>
                  </tr>
                  <tr id="status" class="">
                    <th class="text">Tipo de servicio</th>
                    <th class="text-center"><i style="color:red;" class="fa fa-circle" aria-hidden="true"></i></th>
                    <th class="text-center"><i style="color:yellow;" class="fa fa-circle" aria-hidden="true"></i></th>
                    <th class="text-center"><i style="color:green;" class="fa fa-circle" aria-hidden="true"></i></th>
                    <th class="text-center" rowspan="">Total</th>
                    <th class="text-center">Inversión</th>
                    <th class="text-center">Por facturar</th>
                    <th class="text">Tipo de servicio</th>
                    <th class="text-center"><i style="color:blue;" class="fa fa-circle" aria-hidden="true"></i></th>
                    <th class="text-center">Inversión</th>
                    <th class="text-center">Facturando</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> <strong>Cliente Nuevo</strong> </td>
                    <td class="text-center p-2">{{ $status_projects[0]->riesgo }}</td>
                    <td class="text-center">{{ $status_projects[0]->atencion }}</td>
                    <td class="text-center">{{ $status_projects[0]->normal }}</td>
                    <td class="text-center font-weight-bold"> {{ $status_projects[0]->riesgo + $status_projects[0]->atencion + $status_projects[0]->normal }} </td>
                    <!------------------------->
                    <td class="text-right"> <span>{{ $status_projects[0]->total_usd }}</span> </td>
                    <td class="text-right"> <span>{{ $status_projects[0]->por_facturar }} </span> </td>
                    <!------------------------>
                    <td> <strong>Cliente Nuevo</strong> </td>
                    <td class="text-center p-2">{{ $status_projects_instalado[0]->instalado }}</td>
                    <td class="text-right">{{ $status_projects_instalado[0]->total_usd }}</td>
                    <td class="text-right">{{ $status_projects_instalado[0]->facturando }}</td>
                  </tr>
                  <tr>
                    <td> <strong>Ampliación</strong> </td>
                    <td class="text-center p-2">{{ $status_projects[1]->riesgo }}</td>
                    <td class="text-center">{{ $status_projects[1]->atencion }}</td>
                    <td class="text-center">{{ $status_projects[1]->normal }}</td>
                    <td class="text-center font-weight-bold"> {{ $status_projects[1]->riesgo + $status_projects[1]->atencion + $status_projects[1]->normal }} </td>
                    <!------------------------->
                    <td class="text-right"> <span>{{ $status_projects[1]->total_usd }}</span> </td>
                    <td class="text-right"> <span>{{ $status_projects[1]->por_facturar }} </span> </td>
                    <!------------------------>
                    <td> <strong>Ampliación</strong> </td>
                    <td class="text-center p-2">{{ $status_projects_instalado[1]->instalado }}</td>
                    <td class="text-right">{{ $status_projects_instalado[1]->total_usd }}</td>
                    <td class="text-right">{{ $status_projects_instalado[1]->facturando }}</td>
                  </tr>
                  <tr>
                    <td> <strong>Renovación</strong> </td>
                    <td class="text-center p-2">{{ $status_projects[2]->riesgo }}</td>
                    <td class="text-center">{{ $status_projects[2]->atencion }}</td>
                    <td class="text-center">{{ $status_projects[2]->normal }}</td>
                    <td class="text-center font-weight-bold"> {{ $status_projects[2]->riesgo + $status_projects[2]->atencion + $status_projects[2]->normal }} </td>
                    <!------------------------->
                    <td class="text-right"> <span>{{ $status_projects[2]->total_usd }}</span> </td>
                    <td class="text-right"> <span>{{ $status_projects[2]->por_facturar }} </span> </td>
                    <!------------------------>
                    <td> <strong>Renovación</strong> </td>
                    <td class="text-center p-2">{{ $status_projects_instalado[2]->instalado }}</td>
                    <td class="text-right">{{ $status_projects_instalado[2]->total_usd }}</td>
                    <td class="text-right">{{ $status_projects_instalado[2]->facturando }}</td>
                  </tr>
                  <tr>
                    <td> <strong>Venta</strong> </td>
                    <td class="text-center p-2">{{ $status_projects[4]->riesgo }}</td>
                    <td class="text-center">{{ $status_projects[4]->atencion }}</td>
                    <td class="text-center">{{ $status_projects[4]->normal }}</td>
                    <td class="text-center font-weight-bold"> {{ $status_projects[4]->riesgo + $status_projects[4]->atencion + $status_projects[4]->normal }} </td>
                    <!------------------------->
                    <td class="text-right"> <span>{{ $status_projects[4]->total_usd }}</span> </td>
                    <td class="text-right"> <span>{{ $status_projects[4]->por_facturar }} </span> </td>
                    <!------------------------>
                    <td> <strong>Venta</strong> </td>
                    <td class="text-center p-2">{{ $status_projects_instalado[4]->instalado }}</td>
                    <td class="text-right">{{ $status_projects_instalado[4]->total_usd }}</td>
                    <td class="text-right">{{ $status_projects_instalado[4]->facturando }}</td>
                  </tr>
                  <tr>
                    <td> <strong>F & F</strong> </td>
                    <td class="text-center p-2">{{ $status_projects[5]->riesgo }}</td>
                    <td class="text-center">{{ $status_projects[5]->atencion }}</td>
                    <td class="text-center">{{ $status_projects[5]->normal }}</td>
                    <td class="text-center font-weight-bold"> {{ $status_projects[5]->riesgo + $status_projects[5]->atencion + $status_projects[5]->normal }} </td>
                    <!------------------------->
                    <td class="text-right"> <span>{{ $status_projects[5]->total_usd }}</span> </td>
                    <td class="text-right"> <span>{{ $status_projects[5]->por_facturar }} </span> </td>
                    <!------------------------>
                    <td> <strong>F & F</strong> </td>
                    <td class="text-center p-2">{{ $status_projects_instalado[5]->instalado }}</td>
                    <td class="text-right">{{ $status_projects_instalado[5]->total_usd }}</td>
                    <td class="text-right">{{ $status_projects_instalado[5]->facturando }}</td>
                  </tr>
                </tbody>
                <tfooter>
                  @php
                    $total_inversion = str_replace(',','',$status_projects[0]->total_usd) + str_replace(',','',$status_projects[1]->total_usd) + str_replace(',','',$status_projects[2]->total_usd) + str_replace(',','',$status_projects[4]->total_usd) + str_replace(',','',$status_projects[5]->total_usd);
                    $total_por_facturar = str_replace(',','',$status_projects[0]->por_facturar) + str_replace(',','',$status_projects[1]->por_facturar) + str_replace(',','',$status_projects[2]->por_facturar) + str_replace(',','',$status_projects[4]->por_facturar) + str_replace(',','',$status_projects[5]->por_facturar);
                    $total_inversion_instalado = str_replace(',','',$status_projects_instalado[0]->total_usd) + str_replace(',','',$status_projects_instalado[1]->total_usd) + str_replace(',','',$status_projects_instalado[2]->total_usd) + str_replace(',','',$status_projects_instalado[4]->total_usd) + str_replace(',','',$status_projects_instalado[5]->total_usd);
                    $total_facturando = str_replace(',','',$status_projects_instalado[0]->facturando) + str_replace(',','',$status_projects_instalado[1]->facturando) + str_replace(',','',$status_projects_instalado[2]->facturando) + str_replace(',','',$status_projects_instalado[4]->facturando) + str_replace(',','',$status_projects_instalado[5]->facturando)
                   @endphp
                  <tr class="font-weight-bold" style="border-top:2px solid #B9B9B7 !important;">
                    <td><strong>Total</strong> </td>
                    <td class="text-center p-2"> <span id="total_rojo">{{ $status_projects[0]->riesgo + $status_projects[1]->riesgo + $status_projects[2]->riesgo + $status_projects[4]->riesgo + $status_projects[5]->riesgo }}</span> </td>
                    <td class="text-center"> <span id="total_amarillo">{{ $status_projects[0]->atencion + $status_projects[1]->atencion + $status_projects[2]->atencion + $status_projects[4]->atencion + $status_projects[5]->atencion }}</span> </td>
                    <td class="text-center"> <span id="total_verde">{{ $status_projects[0]->normal + $status_projects[1]->normal + $status_projects[2]->normal + $status_projects[4]->normal + $status_projects[5]->normal }}</span> </td>
                    <th class="text-center"> <span id="total_project_instalation"></span>  </th>
                    <td class="text-right"> <span id="">{{  number_format($total_inversion, 0, '.', ',')  }}</span> </td>
                    <td class="text-right"> <span id="">{{  number_format($total_por_facturar, 0, '.', ',')  }}</span> </td>
                    <!------------------------->
                    <td><strong>Total</strong> </td>
                    <td class="text-center"> <span id="">{{ $status_projects_instalado[0]->instalado + $status_projects_instalado[1]->instalado + $status_projects_instalado[2]->instalado + $status_projects_instalado[4]->instalado + $status_projects_instalado[5]->instalado }}</span> </td>
                    <td class="text-right"> <span id="">{{  number_format($total_inversion_instalado, 0, '.', ',')  }}</span> </td>
                    <td class="text-right"> <span id="">{{  number_format($total_facturando, 0, '.', ',')  }}</span> </td>
                  </tr>
                </tfooter>
              </table>
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-12 card">
          <div class="row d-flex mb-short">
            <div class="col-12 col-md-6">
              <h3 class="text-title">Atrasos</h3>
            </div>

          </div>
          <div class="row mb-short">
            <div class="col-12 col-md-6">
              <div class="clearfix">
                  <div id="graphicAtrasos" style="width: 100%; min-height: 370px; border:1px solid #ccc;padding:10px;"></div>
                </div>
            </div>
            <div class="col-12 col-md-6 table-responsive">
              <form class="form-inline mb-3">
                  <div class="form-group">
                    <label for="">Filtrar por:</label>
                    <select id="select_tipo_servicio" class="form-control form-control-sm mr-2" name="">
                      <option value="1">Cliente nuevo</option>
                      <option value="2">Ampliación</option>
                      <option value="3">Renovación</option>
                      <option value="5">Venta</option>
                      <option value="6">F & F</option>
                    </select>
                    <select id="select_atraso" class="form-control form-control-sm" name="">
                      <option value="1">Compras</option>
                      <option value="2">Instalación</option>
                    </select>
                  </div>
              </form>
              <table id="table_atrasos" class="cell-border compact stripe">
                <thead>
                  <tr>
                    <th>Proyecto</th>
                    <th>Tipo servicio</th>
                    <th>Atraso Compras</th>
                    <th>Atraso instalación</th>
                    <th>IT Concierge</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div><!------------->
          <div class="row mb-short">
            <div class="col-12 col-md-6">
              <div class="clearfix">
                  <div id="graphicAtrasosInstalado" style="width: 100%; min-height: 370px; border:1px solid #ccc;padding:10px;"></div>
                </div>
            </div>
            <div class="col-12 col-md-6 table-responsive">
              <form class="form-inline mb-3">
                  <div class="form-group">
                    <label for="">Filtrar por:</label>
                    <select id="select_tipo_servicio_instalado" class="form-control form-control-sm mr-2" name="">
                      <option value="1">Cliente nuevo</option>
                      <option value="2">Ampliación</option>
                      <option value="3">Renovación</option>
                      <option value="5">Venta</option>
                      <option value="6">F & F</option>
                    </select>
                    <select id="select_atraso_instalado" class="form-control form-control-sm" name="">
                      <option value="1">Compras</option>
                      <option value="2">Instalación</option>
                    </select>
                  </div>
              </form>
              <table id="table_atrasos_instalado" class="cell-border compact stripe">
                <thead>
                  <tr>
                    <th>Proyecto</th>
                    <th>Tipo servicio</th>
                    <th>Atraso Compras</th>
                    <th>Atraso instalación</th>
                    <th>IT Concierge</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <br>
      <!---------------------------------------------------->
      <div class="row">
        <div class="col-12 card">
          <div class="row d-flex mb-short">
            <div class="col-12 col-md-6">
              <h3 class="text-title">Motivos de atraso</h3>
            </div>
          </div>
          <div class="row mb-short">
            <div class="col-12 col-md-6">
              <div class="clearfix">
                  <div id="graphicMotives" style="width: 100%; min-height: 350px; border:1px solid #ccc;padding:10px;"></div>
                </div>
            </div>
            <div class="col-12 col-md-6">
              <form class="form-inline" >
                <div class="form-group">
                  <label class="" for="">Filtrar por:</label>
                    <select id="select_motivo_atraso" class="form-control form-control-sm" name="">
                      <option value="1">Cliente</option>
                      <option value="2">Equipo</option>
                      <option value="3">Comercial</option>
                      <option value="4">Acceso</option>
                      <option value="5">Material</option>
                      <option value="6">Otros</option>
                      <option value="7">N/A</option>
                      <option value="8">Configuración</option>
                      <option value="9">Instalaciones</option>
                      <option value="10">Coordinación</option>
                      <option value="11">Mano de obra</option>
                    </select>
                </div>
              </form>
                <div class="table-responsive">
                  <table id="tabla_atraso_x_motivo" class="table table-bordered" style="min-width:100%">
                    <thead>
                      <tr>
                        <th>Proyecto</th>
                        <th>Motivo</th>
                        <th>Atraso compras</th>
                        <th>Atraso instalación</th>
                        <th>IT Concierge</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
            </div>
          </div><!------>
          <div class="row mb-short">
            <div class="col-12 col-md-6">
              <div class="clearfix">
                  <div id="graphicMotivesInstalado" style="width: 100%; min-height: 350px; border:1px solid #ccc;padding:10px;"></div>
                </div>
            </div>
            <div class="col-12 col-md-6">
              <form class="form-inline" >
                <div class="form-group">
                  <label class="" for="">Filtrar por:</label>
                    <select id="select_motivo_atraso_instalado" class="form-control form-control-sm" name="">
                      <option value="1">Cliente</option>
                      <option value="2">Equipo</option>
                      <option value="3">Comercial</option>
                      <option value="4">Acceso</option>
                      <option value="5">Material</option>
                      <option value="6">Otros</option>
                      <option value="7">N/A</option>
                      <option value="8">Configuración</option>
                      <option value="9">Instalaciones</option>
                      <option value="10">Coordinación</option>
                      <option value="11">Mano de obra</option>
                    </select>
                </div>
              </form>
                <div class="table-responsive">
                  <table id="tabla_atraso_x_motivo_instalado" class="table table-bordered" style="min-width:100%">
                    <thead>
                      <tr>
                        <th>Proyecto</th>
                        <th>Motivo</th>
                        <th>Atraso compras</th>
                        <th>Atraso instalación</th>
                        <th>IT Concierge</th>
                        <th></th>
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
      <br>
      <!---------------------------------------------------->
      <div class="row">
        <div class="col-12 card">
          <div class="row d-flex mb-short">
            <div class="col-xs-12 col-md-6">
              <h3 class="text-title">Rentas perdidas por dia (USD)</h3>
            </div>
          </div>
          <div class="row mb-short">
            <div class="col-12 col-md-6">
              <div class="clearfix">
                  <div id="graphicRentasDia" style="width: 100%; min-height: 350px; border:1px solid #ccc;padding:10px;"></div>
                </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="clearfix">
                  <div id="graphicRentasDiaInstalados" style="width: 100%; min-height: 350px; border:1px solid #ccc;padding:10px;"></div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <!---------------------------------------------------->
      <div class="row">
        <div class="col-12 card">
          <div class="row d-flex mb-short">
            <div class="col-xs-12 col-md-12">
              <h3 class="text-title">% Promedio de Presupuesto ejercido vs Instalado</h3>
            </div>
          </div>
          <div class="row mb-short">
            <div class="col-12">
              <div class="clearfix">
                  <div id="graphicPresupuestoEjercido" style="width: 100%; min-height: 300px; border:1px solid #ccc;padding:10px;"></div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <br>
    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View dashboard project') )
    <script src="{{ asset('plugins/momentupdate/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="{{ asset('js/admin/documentp/dashboard_project.js?v=2.0.0')}}"></script>
    <script src="{{ asset('js/admin/documentp/request_modal_documentp.js?v=1.0.1')}}"></script>

@else
  @include('default.denied')
@endif
<style>
  .card{
    padding: 1em;
    border-radius: 5px;
    background-color: white;
  }

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

  .text-danger{
    color: #F23847 !important;
  }

  .text-info{
    color: #14A697 !important;
  }

  .text-primary{
    color: #0686CC !important;
  }

  .text-default{
    color: #8C8C8C !important;
  }

  .text-warning{
    color: #FFDC00 !important
  }

  .mb-short{
    margin-bottom: 15px;
  }

  .text-title{
    color: #595959;
  }

  #tabla_atraso_x_motivo td, #tabla_atraso_x_motivo th,
  #table_atrasos td, #table_atrasos th{
    vertical-align: middle;
  }

  #table_atraso_x_motivo a, #table_atrasos a{
    padding: 0.2rem 0.5rem !important;
    margin-left: 3px;
  }

  #tabla_atraso_x_motivo thead, #table_atrasos thead{
    height: 15px !important;
  }

  .dataTables_wrapper .dataTable thead th, .dataTables_wrapper .dataTable tbody tr td{
      border-bottom-width: 0;
      border: 1px solid rgba(151, 151, 151, 0.18);
      padding: 0.3rem 0.4375rem;
      white-space: normal;
      font-size: 0.8rem;
  }

  #status i{
    font-size: 1.2em;
  }

  @media (min-width: 768px) {
    .d-flex{
      display: flex;
      align-items: center;
    }
  }


</style>
@endpush
