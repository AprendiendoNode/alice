<div class="row">
    <form id="form_proyect" class="form-horizontal">
      <h3 class="text-center text-danger">Avance de proyecto</h3>
      <h5 class="text-center">Última actualización: <span id="fecha_actualizacion" class="badge label-danger">{{$docp_advance->updated_at}}</span> </h5>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Entrega estimada</label>
            <div class="col-sm-2">
              <input readonly type="date" class="form-control" name="date_start" id="date_start" value="{{$docp_advance->fecha_inicio}}">
            </div>
            <label for="" class="col-sm-2 control-label">Entrega compromiso</label>
            <div class="col-sm-2">
              <input readonly type="date" class="form-control" name="date_end" id="date_end" value="{{$docp_advance->fecha_final}}">
            </div>
            <label for="" class="col-sm-2 control-label">Firma contrato</label>
            <div class="col-sm-2">
              <input readonly type="date" class="form-control" name="date_signature" id="date_signature" value="{{$docp_advance->fecha_firma}}">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <h4><span class="label label-primary">Instalaciones</span></h4>
          <input type="hidden" class="form-control" name="id" id="id" value="{{$docp_advance->id}}">
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Tuberias y ducterias e IDFs</label>
            <div class="col-sm-3">
              <input readonly type="number" class="form-control input_installation" name="tuberias" id="tuberias" value="{{$docp_advance->tuberias}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Cableado</label>
            <div class="col-sm-3">
              <input readonly type="number" class="form-control input_installation" name="cableado" id="cableado" value="{{$docp_advance->cableado}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Organización de cableado</label>
            <div class="col-sm-3">
              <input readonly type="number" class="form-control input_installation" name="org_cableado" id="org_cableado" value="{{$docp_advance->org_cableado}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Ponchado de cables</label>
            <div class="col-sm-3">
              <input readonly type="number" class="form-control input_installation" name="ponchado_cables" id="ponchado_cables" value="{{$docp_advance->ponchado_cables}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Identificación y probado</label>
            <div class="col-sm-3">
              <input readonly type="number" class="form-control input_installation" name="identificacion" id="identificacion" value="{{$docp_advance->identificacion}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Instalación antenas ruckus</label>
            <div class="col-sm-3">
              <input readonly type="number" class="form-control input_installation" name="instalacion_antenas" id="instalacion_antenas" value="{{$docp_advance->instalacion_antenas}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Instalación de switches y UPS</label>
            <div class="col-sm-3">
              <input readonly type="number" class="form-control input_installation" name="instalacion_switches" id="instalacion_switches" value="{{$docp_advance->instalacion_switches}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>
        </div><!--col-md-4-->
        <div class="col-md-4">
          <h4><span class="label label-primary">Configuración y pruebas</span></h4>
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Configuración SITE</label>
            <div class="col-sm-3">
              <input readonly type="number" class="form-control input_configuration" name="config_site" id="config_site" value="{{$docp_advance->config_site}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Configuración zone director</label>
            <div class="col-sm-3">
              <input readonly type="number" class="form-control input_configuration" name="config_zone_director" id="config_zone_director" value="{{$docp_advance->config_zone_director}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Generación de pruebas de funcionamiento a insfraestructura</label>
            <div class="col-sm-3">
              <input readonly type="number" min="0.0" max="100" class="form-control input_configuration" name="infraestructura_test" id="infraestructura_test" value="{{$docp_advance->infraestructura_test}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>

          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Pruebas generales</label>
            <div class="col-sm-3">
              <input readonly type="number" min="0.0" max="100" class="form-control input_configuration" name="test_general" id="test_general" value="{{$docp_advance->test_general}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Recorrido y entrega de proyecto</label>
            <div class="col-sm-3">
              <input readonly type="number" min="0.0" max="100" class="form-control input_configuration" name="recorrido" id="recorrido" value="{{$docp_advance->recorrido}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>

        </div>
        <div class="col-md-4">
          <h4><span class="label label-primary">Firma acta de entrega</span></h4>
          <div class="form-group">
            <label for="" class="col-sm-8 control-label">Firma de acta de entrega por el cliente</label>
            <div class="col-sm-3">
              <input readonly type="number" class="form-control input_test" name="firma_acta" id="firma_acta" value="{{$docp_advance->firma_acta}}">
            </div>
            <label for="" class="col-sm-1 control-label">%</label>
          </div>
          <div class="form-group">
            <br>
            <label for="" class="col-sm-3 control-label">Observaciones:</label>
            <div class="col-sm-9">
              <textarea readonly rows="5"  class="form-control" name="comentario" id="comentario" value="{{$docp_advance->comentario}}">{{$docp_advance->comentario}}</textarea>
            </div>
          </div><!--col-md-4-->
          <br>
          <div class="form-group">
            <div class="col-sm-4 col-sm-offset-7">
              <button disabled class="btn btn-warning" type="button" id="btn_save_project" name="button">Guardar cambios</button>
            </div>
          </div>
        </div><!--col-md-4-->
      </div>
    </form>
</div>
<br>
<table  class="table table-condensed project_advance">
  <thead style="background:#007369;color:white;">
    <tr>
      <th class="text-center">% Instalación</th>
      <th class="text-center">% Configuración</th>
      <th class="text-center">% Pruebas y entregas</th>
      <th class="text-center">% Total de proyecto</th>
      <th class="text-center">Motivos</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td id="instalacion_total" style="vertical-align: bottom;">
          {{$docp_advance->instalacion_total}}%
      </td>
      <td id="configuracion_total" style="vertical-align: bottom;">
        {{$docp_advance->configuracion_total}}%
      </td>
      <td id="test_total" style="vertical-align: bottom;">
        {{$docp_advance->test_total}}%
      </td>
      <td id="total_global" style="vertical-align: bottom;">
          <div class="progress-bar progress-bar-primary  progress-bar-striped" role="progressbar" aria-valuenow="30"
          aria-valuemin="0" aria-valuemax="100" style="width:{{$docp_advance->total_global}}%">
            <span>{{$docp_advance->total_global}}%</span>
          </div>
      </td>
      <td align="center">{{$motivo_name}}</td>
    </tr>
  </tbody>
</table>
<div class="row">
  <div class="form-group">
    <label class="col-sm-12 control-label">Observaciones - Gerencia Instalaciones:</label>
      <div class="col-sm-6">
          <p class="form-control-static"><span id="folio">{{ $docp_advance->comentario_manager }}</span></p>
      </div>
  </div>
</div>
<style media="screen">

  .project_advance tbody tr td{
    width: 20%;
    text-align: center;
  }

  .project_advance tbody tr td span{
    font-weight: bold;
    font-size: 14px;
  }

  .form-horizontal .form-group {
    margin-top: 5px;
  }

  #form_proyect h3{
    color: #94090D;
    font-size: 2em;
  }

</style>
