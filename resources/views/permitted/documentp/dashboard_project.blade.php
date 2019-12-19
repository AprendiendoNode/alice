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
                <div class="container-box col-md-1">
                  <div class="icon_head_dash">
                    <i class="fa fa-hashtag text-danger" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Total</p>
                    <h4><strong>{{ $status_cotizador[0]->Total_solicitudes}}</strong></h4>
                  </div>
                </div>
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fas fa-tasks text-dark" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">En Kick-off</p>
                    <h4><strong>{{ $status_cotizador[0]->En_kickoff}}</strong></h4>
                  </div>
                </div>
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fas fa-pen-alt text-primary" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Firma contrato</p>
                    <h4><strong>{{ $status_cotizador[0]->Firma_contrato}}</strong></h4>
                  </div>
                </div>
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fas fa-check-circle text-success" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Autorizados</p>
                    <h4><strong>{{ $status_cotizador[0]->Autorizado}}</strong></h4>
                  </div>
                </div>
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fas fa-exclamation-circle text-warning" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">En revision</p>
                    <h4><strong>{{ $status_cotizador[0]->En_revision}}</strong></h4>
                  </div>
                </div>
                <div class="container-box col-md-2">
                  <div class="icon_head_dash">
                    <i class="fas fa-times-circle text-danger" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default">Fuera de parametros</p>
                    <h4><strong>{{ $status_cotizador[0]->Fuera_parametros}}</strong></h4>
                  </div>
                </div>
                <div class="container-box col-md-1">
                  <div class="icon_head_dash">
                    <i class="fa fa-plus-square text-info" aria-hidden="true"></i>
                  </div>
                  <div class="info_head_dash">
                    <p class="text-default"> Nuevo </p>
                    <h4><strong>{{ $status_cotizador[0]->Nuevo }}</strong></h4>
                  </div>
                </div> 
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <!----------ESTATUS INSTALACION------------------------------------------>
      <div class="row">
        <div class="col-12 card">
          <div class="row">
            <div class="col-12 col-md-6">
              <h4 class="text-title">Estatus de instalación</h4>
            </div>
            <div class="col-12 col-md-6">
              <h4 class="text-right pr-4"><span id="calif_projects">0 %</span> </h4>
            </div>
          </div>
          <div class="row d-flex mb-short">
            <div class="col-xs-12 col-md-6 table-responsive p-3">
              <table id="table-dash" class="table table-sm table-bordered table-striped ">
                <thead>
                  <tr>
                    <th class="text-center text-success text-weigh-bold" colspan="7">
                      Proyectos en ejecución
                    </th>
                  </tr>
                  <tr style="background: #193257;color:white;">
                    <th>Estatus</th>
                    <th class="text-center">Riesgo</th>
                    <th class="text-center">Atención</th>
                    <th class="text-center">Normal</th>
                    <th></th>
                  </tr>
                  <tr id="status" class="">
                    <th class="text">Tipo de servicio</th>
                    <th class="text-center"><i style="color:red;" class="fa fa-circle" aria-hidden="true"></i></th>
                    <th class="text-center"><i style="color:yellow;" class="fa fa-circle" aria-hidden="true"></i></th>
                    <th class="text-center"><i style="color:green;" class="fa fa-circle" aria-hidden="true"></i></th>
                    <th class="text-center" rowspan="">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> <strong>Cliente Nuevo</strong> </td>
                    <td class="text-center p-2">{{ $status_projects[0]->riesgo }}</td>
                    <td class="text-center">{{ $status_projects[0]->atencion }}</td>
                    <td class="text-center">{{ $status_projects[0]->normal }}</td>
                    <td class="text-center font-weight-bold"> {{ $status_projects[0]->riesgo + $status_projects[0]->atencion + $status_projects[0]->normal }} </td>
                  </tr>
                  <tr>
                    <td> <strong>Ampliación</strong> </td>
                    <td class="text-center p-2">{{ $status_projects[1]->riesgo }}</td>
                    <td class="text-center">{{ $status_projects[1]->atencion }}</td>
                    <td class="text-center">{{ $status_projects[1]->normal }}</td>
                    <td class="text-center font-weight-bold"> {{ $status_projects[1]->riesgo + $status_projects[1]->atencion + $status_projects[1]->normal }} </td>
                  </tr>
                  <tr>
                    <td> <strong>Renovación</strong> </td>
                    <td class="text-center p-2">{{ $status_projects[2]->riesgo }}</td>
                    <td class="text-center">{{ $status_projects[2]->atencion }}</td>
                    <td class="text-center">{{ $status_projects[2]->normal }}</td>
                    <td class="text-center font-weight-bold"> {{ $status_projects[2]->riesgo + $status_projects[2]->atencion + $status_projects[2]->normal }} </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr class="font-weight-bold" style="border-top:2px solid #B9B9B7 !important;">
                    <td><strong>Total</strong> </td>
                    <td class="text-center p-2"> <span id="total_rojo">{{ $status_projects[0]->riesgo + $status_projects[1]->riesgo + $status_projects[2]->riesgo }}</span> </td>
                    <td class="text-center"> <span id="total_amarillo">{{ $status_projects[0]->atencion + $status_projects[1]->atencion + $status_projects[2]->atencion }}</span> </td>
                    <td class="text-center"> <span id="total_verde">{{ $status_projects[0]->normal + $status_projects[1]->normal + $status_projects[2]->normal }}</span> </td>
                    <th class="text-center"> <span id="total_project_instalation"></span>  </th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-------------------------------------------------->
            <div class="col-xs-12 col-md-6 table-responsive p-3">
              <table id="table-dash" class="table table-sm table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="text-center text-dark text-weigh-bold" colspan="7">
                      Proyectos terminados
                    </th>
                  </tr>
                  <tr style="background: #193257;color:white;">
                    <th>Estatus</th>
                    <th class="text-center">Instalado</th>
                  </tr>
                  <tr id="status" class="">
                    <th class="text">Tipo de servicio</th>
                    <th class="text-center"><i style="color:blue;" class="fa fa-circle" aria-hidden="true"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> <strong>Cliente Nuevo</strong> </td>
                    <td class="text-center font-weight-bold p-2">{{ $status_projects_instalado[0]->instalado }}</td>
                  </tr>
                  <tr>
                    <td> <strong>Ampliación</strong> </td>
                    <td class="text-center font-weight-bold p-2">{{ $status_projects_instalado[1]->instalado }}</td>
                  </tr>
                  <tr>
                    <td> <strong>Renovación</strong> </td>
                    <td class="text-center font-weight-bold p-2">{{ $status_projects_instalado[2]->instalado }}</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr class="font-weight-bold" style="border-top:2px solid #B9B9B7 !important;">
                    <td><strong>Total</strong> </td>
                    <td class="text-center p-2"> <span id="">{{ $status_projects_instalado[0]->instalado + $status_projects_instalado[1]->instalado + $status_projects_instalado[2]->instalado }}</span> </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <!-----------VENTA------------->
          <div class="row">
            <div class="col-12">
              <div class="row d-flex mb-short">
                <div class="col-xs-12 col-md-6 table-responsive p-3">
                  <table id="" class="table table-sm table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="text-center text-success text-weigh-bold" colspan="7">
                          Proyectos en ejecución
                        </th>
                      </tr>
                      <tr style="background: #193257;color:white;">
                        <th>Estatus</th>
                        <th class="text-center">Riesgo</th>
                        <th class="text-center">Atención</th>
                        <th class="text-center">Normal</th>
                        <th></th>
                      </tr>
                      <tr id="status" class="">
                        <th class="text">Tipo de servicio</th>
                        <th class="text-center"><i style="color:red;" class="fa fa-circle" aria-hidden="true"></i></th>
                        <th class="text-center"><i style="color:yellow;" class="fa fa-circle" aria-hidden="true"></i></th>
                        <th class="text-center"><i style="color:green;" class="fa fa-circle" aria-hidden="true"></i></th>
                        <th class="text-center" rowspan="">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td> <strong>Venta</strong> </td>
                        <td class="text-center p-2">{{ $status_projects[4]->riesgo }}</td>
                        <td class="text-center">{{ $status_projects[4]->atencion }}</td>
                        <td class="text-center">{{ $status_projects[4]->normal }}</td>
                        <td class="text-center font-weight-bold"> {{ $status_projects[4]->riesgo + $status_projects[4]->atencion + $status_projects[4]->normal }} </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-xs-12 col-md-6 table-responsive p-3">
                  <table id="table-dash" class="table table-sm table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="text-center text-dark text-weigh-bold" colspan="7">
                          Proyectos terminados
                        </th>
                      </tr>
                      <tr style="background: #193257;color:white;">
                        <th>Estatus</th>
                        <th class="text-center">Instalado</th>
                      </tr>
                      <tr id="status" class="">
                        <th class="text">Tipo de servicio</th>
                        <th class="text-center"><i style="color:blue;" class="fa fa-circle" aria-hidden="true"></i></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td> <strong>Venta</strong> </td>
                        <td class="text-center font-weight-bold p-2">{{ $status_projects_instalado[4]->instalado }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <!----------FACTURACION------------------------------------------>
      <div class="row">
        <div class="col-12 card">
          <div class="row">
            <div class="col-12 col-md-6">
              <h4 class="text-title">Facturación</h4>
            </div>
          </div>
          <div class="row d-flex mb-short">
            <div class="col-xs-12 col-md-6 table-responsive p-3">
              <table id="table-dash" class="table table-sm table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="text-center text-success text-weigh-bold" colspan="7">
                      Proyectos en ejecución
                    </th>
                  </tr>
                  <tr style="background: #193257;color:white;">
                    <th class="text-center">Tipo de servicio</th>
                    <th class="text-center" colspan="2">Facturando</th>
                    <th class="text-center" colspan="2">Sin facturar</th>
                  </tr>
                  <tr id="status" class="">
                    <th></th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center" rowspan="">USD</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center" rowspan="">USD</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> <strong>Cliente Nuevo</strong> </td>
                    <td class="text-center p-2">{{ $projects_ejecucion_fact[0]->cantidad_facturando }}</td>
                    <td class="text-center font-weight-bold">{{ number_format($projects_ejecucion_fact[0]->suma_facturando, 0, '.', ',') }}</td>
                    <td class="text-center">{{ $projects_ejecucion_fact[0]->cantidad_xfacturar }}</td>
                    <td class="text-center font-weight-bold"> {{ number_format($projects_ejecucion_fact[0]->suma_xfacturar, 0, '.', ',')  }} </td>
                  </tr>
                  <tr>
                    <td> <strong>Ampliación</strong> </td>
                    <td class="text-center p-2">{{ $projects_ejecucion_fact[1]->cantidad_facturando }}</td>
                    <td class="text-center font-weight-bold">{{ number_format($projects_ejecucion_fact[1]->suma_facturando, 0, '.', ',') }}</td>
                    <td class="text-center">{{ $projects_ejecucion_fact[1]->cantidad_xfacturar }}</td>
                    <td class="text-center font-weight-bold"> {{ number_format($projects_ejecucion_fact[1]->suma_xfacturar, 0, '.', ',')  }} </td>
                  </tr>
                  <tr>
                    <td> <strong>Renovación</strong> </td>
                    <td class="text-center p-2">{{ $projects_ejecucion_fact[4]->cantidad_facturando }}</td>
                    <td class="text-center font-weight-bold">{{ number_format($projects_ejecucion_fact[4]->suma_facturando, 0, '.', ',') }}</td>
                    <td class="text-center">{{ $projects_ejecucion_fact[4]->cantidad_xfacturar }}</td>
                    <td class="text-center font-weight-bold"> {{ number_format($projects_ejecucion_fact[4]->suma_xfacturar, 0, '.', ',')  }} </td>
                  </tr>
                </tbody>
                <tfoot>
                  @php
                      $total_facturando_ejecucion = $projects_ejecucion_fact[0]->suma_facturando + $projects_ejecucion_fact[1]->suma_facturando + $projects_ejecucion_fact[4]->suma_facturando;
                      $total_xfacturar_ejecucion = $projects_ejecucion_fact[0]->suma_xfacturar + $projects_ejecucion_fact[1]->suma_xfacturar + $projects_ejecucion_fact[4]->suma_xfacturar;
                 @endphp
                  <tr class="font-weight-bold" style="background-color: #D9D9D9 !important;">
                    <td><strong>Total</strong> </td>
                    <td class="text-center p-2"> <span id="">{{ $projects_ejecucion_fact[0]->cantidad_facturando + $projects_ejecucion_fact[1]->cantidad_facturando + $projects_ejecucion_fact[4]->cantidad_facturando }}</span> </td>
                    <td class="text-center"> <span id="">{{ number_format($total_facturando_ejecucion ,  0, '.', ',') }}</span> </td>
                    <td class="text-center"> <span id="">{{ $projects_ejecucion_fact[0]->cantidad_xfacturar + $projects_ejecucion_fact[1]->cantidad_xfacturar + $projects_ejecucion_fact[4]->cantidad_xfacturar }}</span> </td>
                    <th class="text-center"> <span id=""></span> {{ number_format($total_xfacturar_ejecucion ,  0, '.', ',') }} </th>
                  </tr>
                  <!-----------venta-------------->
                  <tr>
                    <td rowspan="2"><strong>Venta</strong></td>
                    <td class="text-center font-weight-bold">Cantidad</td>
                    <td class="text-center font-weight-bold" rowspan="">USD</td>
                    <td class="text-center font-weight-bold">Cantidad</td>
                    <td class="text-center font-weight-bold" rowspan="">USD</td>
                  </tr>
                  <tr>
                    <td class="text-center p-2">{{ $projects_ejecucion_fact[3]->cantidad_facturando }}</td>
                    <td class="text-center font-weight-bold">{{ number_format($projects_ejecucion_fact[3]->suma_facturando, 0, '.', ',') }}</td>
                    <td class="text-center">{{ $projects_ejecucion_fact[3]->cantidad_xfacturar }}</td>
                    <td class="text-center font-weight-bold"> {{ number_format($projects_ejecucion_fact[3]->suma_xfacturar, 0, '.', ',')  }} </td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-----------------Facturacion Instalados--------------------------------->
            <div class="col-xs-12 col-md-6 table-responsive p-3">
              <table id="" class="table table-sm table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="text-center text-dark text-weigh-bold" colspan="7">
                      Proyectos instalados
                    </th>
                  </tr>
                  <tr style="background: #193257;color:white;">
                    <th class="text-center">Tipo de servicio</th>
                    <th class="text-center" colspan="2">Facturando</th>
                    <th class="text-center" colspan="2">Sin facturar</th>
                  </tr>
                  <tr id="status" class="">
                    <th></th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center" rowspan="">USD</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center" rowspan="">USD</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> <strong>Cliente Nuevo</strong> </td>
                    <td class="text-center p-2">{{ $projects_instalacion_fact[0]->cantidad_facturando }}</td>
                    <td class="text-center font-weight-bold">{{ number_format($projects_instalacion_fact[0]->suma_facturando, 0, '.', ',') }}</td>
                    <td class="text-center">{{ $projects_instalacion_fact[0]->cantidad_xfacturar }}</td>
                    <td class="text-center font-weight-bold"> {{ number_format($projects_instalacion_fact[0]->suma_xfacturar, 0, '.', ',')  }} </td>
                  </tr>
                  <tr>
                    <td> <strong>Ampliación</strong> </td>
                    <td class="text-center p-2">{{ $projects_instalacion_fact[1]->cantidad_facturando }}</td>
                    <td class="text-center font-weight-bold">{{ number_format($projects_instalacion_fact[1]->suma_facturando, 0, '.', ',') }}</td>
                    <td class="text-center">{{ $projects_instalacion_fact[1]->cantidad_xfacturar }}</td>
                    <td class="text-center font-weight-bold"> {{ number_format($projects_instalacion_fact[1]->suma_xfacturar, 0, '.', ',')  }} </td>
                  </tr>
                  <tr>
                    <td> <strong>Renovación</strong> </td>
                    <td class="text-center p-2">{{ $projects_instalacion_fact[2]->cantidad_facturando }}</td>
                    <td class="text-center font-weight-bold">{{ number_format($projects_instalacion_fact[2]->suma_facturando, 0, '.', ',') }}</td>
                    <td class="text-center">{{ $projects_instalacion_fact[2]->cantidad_xfacturar }}</td>
                    <td class="text-center font-weight-bold"> {{ number_format($projects_instalacion_fact[2]->suma_xfacturar, 0, '.', ',')  }} </td>
                  </tr>
                </tbody>
                <tfoot>
                  @php
                      $total_facturando_instalacion = $projects_instalacion_fact[0]->suma_facturando + $projects_instalacion_fact[1]->suma_facturando + $projects_instalacion_fact[2]->suma_facturando;
                      $total_xfacturar_instalacion = $projects_instalacion_fact[0]->suma_xfacturar + $projects_instalacion_fact[1]->suma_xfacturar + $projects_instalacion_fact[2]->suma_xfacturar;
                  @endphp
                  <tr class="font-weight-bold" style="background-color: #D9D9D9 !important;">
                    <td><strong>Total</strong> </td>
                    <td class="text-center p-2"> <span id="">{{ $projects_instalacion_fact[0]->cantidad_facturando + $projects_instalacion_fact[1]->cantidad_facturando + $projects_instalacion_fact[2]->cantidad_facturando }}</span> </td>
                    <td class="text-center"> <span id="">{{ number_format($total_facturando_instalacion, 0, '.' , ',') }}</span> </td>
                    <td class="text-center"> <span id="">{{ $projects_instalacion_fact[0]->cantidad_xfacturar + $projects_instalacion_fact[1]->cantidad_xfacturar + $projects_instalacion_fact[2]->cantidad_xfacturar }}</span> </td>
                  <th class="text-center"> <span id=""></span>{{ number_format($total_xfacturar_instalacion, 0, '.' , ',') }}</th>
                  </tr>
                  <!-----------venta-------------->
                  <tr>
                    <td rowspan="2"><strong>Venta</strong></td>
                    <td class="text-center font-weight-bold">Cantidad</td>
                    <td class="text-center font-weight-bold" rowspan="">USD</td>
                    <td class="text-center font-weight-bold">Cantidad</td>
                    <td class="text-center font-weight-bold" rowspan="">USD</td>
                  </tr>
                  <tr>
                    <td class="text-center p-2">{{ $projects_instalacion_fact[4]->cantidad_facturando }}</td>
                    <td class="text-center font-weight-bold">{{ number_format($projects_instalacion_fact[4]->suma_facturando, 0, '.', ',') }}</td>
                    <td class="text-center">{{ $projects_instalacion_fact[4]->cantidad_xfacturar }}</td>
                    <td class="text-center font-weight-bold"> {{ number_format($projects_instalacion_fact[4]->suma_xfacturar, 0, '.', ',')  }} </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          
        </div>
      </div>
      <br>
      <!---PORCETAJE DE FACTURACION POR MOTIVO DE ATRASO------------------------------------------------------------------------------>
      <div class="row">
        <div class="col-12 card">
          <div class="row d-flex mb-short">
            <div class="col-12 col-md-6">
              <h3 class="text-title">% de facturación por motivo de atraso</h3>
            </div>
          </div>
          <div class="row mb-short">
            <div class="col-12 col-md-6 table-responsive">
              <table class="table table-sm table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="text-center text-success text-weigh-bold" colspan="6">
                      Proyectos en ejecución
                    </th>
                  </tr>
                  <tr style="background: #193257;color:white;">
                    <th rowspan="2">Motivo</th>
                    <th rowspan="2">Cantidad</th>
                    <th rowspan="2">Renta mensual (USD)</th>
                    <th colspan="2">Facturando</th>
                    <th rowspan="2" class="text-center">% Facturación</th>
                  </tr>
                  <tr style="background: #193257;color:white;">
                    <th class="text-center">Si</th>
                    <th class="text-center">No</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($projects_ejecucion_motivo as $projects)
                    <tr>
                      <td>{{$projects->name}}</td>
                      <td>-</td>
                      <td>{{$projects->renta_mensual}}</td>
                      <td>{{$projects->suma_facturando}}</td>
                      <td>{{$projects->suma_xfacturar}}</td>
                      <td>{{$projects->porc}}</td>
                    </tr>
                    @endforeach                
                </tbody>
                <tfoot class="font-weight-bold" style="border-top:2px solid #B9B9B7 !important;">
                  <tr>
                    <td>Total</td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!------------->
            <div class="col-12 col-md-6 table-responsive">
              <table class="table table-sm table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="text-center text-dark text-weigh-bold" colspan="6">
                      Proyectos instalados
                    </th>
                  </tr>
                  <tr style="background: #193257;color:white;">
                    <th rowspan="2">Motivo</th>
                    <th rowspan="2">Cantidad</th>
                    <th rowspan="2">Renta mensual (USD)</th>
                    <th colspan="2">Facturando</th>
                    <th rowspan="2" class="text-center">% Facturación</th>
                  </tr>
                  <tr style="background: #193257;color:white;">
                    <th class="text-center">Si</th>
                    <th class="text-center">No</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    @foreach ($projects_instalados_motivo as $projects)
                    <tr>
                      <td>{{$projects->name}}</td>
                      <td>-</td>
                      <td>{{$projects->renta_mensual}}</td>
                      <td>{{$projects->suma_facturando}}</td>
                      <td>{{$projects->suma_xfacturar}}</td>
                      <td>{{$projects->proc}}</td>
                    </tr>
                    @endforeach  
                  </tr>
                </tbody>
                <tfoot class="font-weight-bold" style="border-top:2px solid #B9B9B7 !important;">
                  <tr>
                    <td>Total</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
      
   
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
    <script src="{{ asset('js/admin/documentp/dashboard_project.js?v=3.1.0')}}"></script>
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
