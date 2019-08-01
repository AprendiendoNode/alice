<div class="">
  <form id="form_proyect" class="">
    <h3 class="text-center text-danger">Avance de proyecto</h3>
    <h5 class="text-center">Última actualización: <span id="fecha_actualizacion" class="badge badge-dark badge-pill text-white">{{$docp_advance->updated_at}}</span> </h5>

      <div class="col-md-12">
        <div class="row">
          <div class="col-md-4">
            <label for="" class="control-label">Entrega estimada</label>
            <input type="date" class="form-control form-control-sm" name="date_start" id="date_start" value="{{$docp_advance->fecha_inicio}}">
          </div>
          <div class="col-md-4">
            <label for="" class="control-label">Entrega compromiso</label>
            <input type="date" class="form-control form-control-sm" name="date_end" id="date_end" value="{{$docp_advance->fecha_final}}">
          </div>
          <div class="col-md-4">
            <label for="" class="control-label">Firma contrato</label>
            <input type="date" class="form-control form-control-sm" name="date_signature" id="date_signature" value="{{$docp_advance->fecha_firma}}">
          </div>
        </div>
      </div>

    <br>
  <div class="row">
    <div class="col-md-4">
      <h4><span class="text-dark">Instalaciones</span></h4>
      <input type="hidden" class="form-control" name="id" id="id" value="{{$docp_advance->id}}">
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8">Tuberias y ducterias e IDFs</label>
          <input type="number" class="col form-control form-control-sm input_installation" name="tuberias" id="tuberias" value="{{$docp_advance->tuberias}}">
        <label for="" class="col">%</label>
      </div>
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8">Cableado</label>
        <input type="number" class="col form-control form-control-sm input_installation" name="cableado" id="cableado" value="{{$docp_advance->cableado}}">
        <label for="" class="col">%</label>
      </div>
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8">Organización de cableado</label>
        <input type="number" class="col form-control form-control-sm input_installation" name="org_cableado" id="org_cableado" value="{{$docp_advance->org_cableado}}">
        <label for="" class="col">%</label>
      </div>
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8">Ponchado de cables</label>
        <input type="number" class="col form-control form-control-sm input_installation" name="ponchado_cables" id="ponchado_cables" value="{{$docp_advance->ponchado_cables}}">
        <label for="" class="col">%</label>
      </div>
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8">Identificación y probado</label>
        <input type="number" class="col form-control form-control-sm input_installation" name="identificacion" id="identificacion" value="{{$docp_advance->identificacion}}">
        <label for="" class="col">%</label>
      </div>
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8">Instalación antenas ruckus</label>
        <input type="number" class="col form-control form-control-sm input_installation" name="instalacion_antenas" id="instalacion_antenas" value="{{$docp_advance->instalacion_antenas}}">
        <label for="" class="col">%</label>
      </div>
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8 control-label">Instalación de switches y UPS</label>
        <input type="number" class="col form-control form-control-sm input_installation" name="instalacion_switches" id="instalacion_switches" value="{{$docp_advance->instalacion_switches}}">
        <label for="" class="col">%</label>
      </div>
    </div><!--col-md-4-->
    <div class="col-md-4">
      <h4><span class="text-dark">Configuración y pruebas</span></h4>
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8">Configuración SITE</label>
        <input type="number" class="col form-control form-control-sm input_configuration" name="config_site" id="config_site" value="{{$docp_advance->config_site}}">
        <label for="" class="col">%</label>
      </div>
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8">Configuración zone director</label>
        <input type="number" class="col form-control form-control-sm input_configuration" name="config_zone_director" id="config_zone_director" value="{{$docp_advance->config_zone_director}}">
        <label for="" class="col">%</label>
      </div>
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8">Generación de pruebas de funcionamiento a insfraestructura</label>
        <input type="number" min="0.0" max="100" class="col form-control form-control-sm input_configuration" name="infraestructura_test" id="infraestructura_test" value="{{$docp_advance->infraestructura_test}}">
        <label for="" class="col">%</label>
      </div>

      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8">Pruebas generales</label>
        <input type="number" min="0.0" max="100" class="col form-control form-control-sm input_configuration" name="test_general" id="test_general" value="{{$docp_advance->test_general}}">
        <label for="" class="col control-label">%</label>
      </div>
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8 control-label">Recorrido y entrega de proyecto</label>
        <input type="number" min="0.0" max="100" class="col form-control form-control-sm input_configuration" name="recorrido" id="recorrido" value="{{$docp_advance->recorrido}}">
        <label for="" class="col">%</label>
      </div>

    </div>
    <div class="col-md-4">
      <h4><span class="text-dark">Firma acta de entrega</span></h4>
      <div class="form-row d-flex align-items-center">
        <label for="" class="col-8">Firma de acta de entrega por el cliente</label>
        <input type="number" class="col form-control form-control-sm input_test" name="firma_acta" id="firma_acta" value="{{$docp_advance->firma_acta}}">
        <label for="" class="col">%</label>
      </div>
      <div class="form-group">
        <br>
        <label for="" class="col-3 control-label">Observaciones:</label>
        <div class="col">
          <textarea rows="5"  class="form-control" name="comentario" id="comentario" value="{{$docp_advance->comentario}}">{{$docp_advance->comentario}}</textarea>
        </div>
      </div><!--col-md-4-->
      <br>
      <div class="form-group">
        <div class="col-sm-4 col-sm-offset-7">
          <button class="btn btn-warning" type="button" id="btn_save_project" name="button">Guardar cambios</button>
        </div>
      </div>
    </div><!--col-md-4-->
  </div>
</form>
</div>
<br>
<div class="table-responsive">
<table  class="table table-condensed project_advance">
<thead style="background:#007369;color:white;height: 10px !important;">
  <tr>
    <th class="text-center">% Instalación</th>
    <th class="text-center">% Configuración y pruebas</th>
    <th class="text-center">% Firma acta de enrega</th>
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
        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="30"
        aria-valuemin="0" aria-valuemax="100" style="width:{{$docp_advance->total_global}}%">
          <span>{{$docp_advance->total_global}}%</span>
        </div>
    </td>
    <td align="center">
      <a id="motivo" href="javascript:void(0);"
      data-type="select"
      data-pk="{{$docp_advance->id}}"
      data-title="Motivos"
      data-source="{{$motives}}"
      data-value="{{$docp_advance->id_motivo}}" data-name="motivo" class="set-motivo"></a></td>
  </tr>
</tbody>
</table>
</div>
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
<script type="text/javascript">
$( document ).ready(function() {
  var _token = $('input[name="_token"]').val();

  const headers = new Headers({
    "Accept": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": _token
  })

    //Configuracion de x-editable jquery
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.ajaxOptions = {type:'POST'};

    $('.set-motivo').editable({
        container: 'body',
        success: function(response, newValue) {
          var id = $(this).data('pk');
          var motive = newValue;
          var miInit = { method: 'get',
                            headers: headers,
                            credentials: "same-origin",
                            cache: 'default' };

          fetch(`/update_motive_project/${id}/${motive}`,  miInit)
              .then(response => {
                return response.text();
              })
              .then(data => {

              })
              .catch(error => {
                console.log(error);
              })
        }
    });

    $('#btn_save_project').on('click', function(){
      var suma_instalaciones = 0.0;
      var percent_instalaciones = 0.0;
      var suma_configuration = 0.0;
      var percent_configuration = 0.0;
      var suma_test = 0.0;
      var percent_test = 0.0;

      var tuberias = $("#tuberias").val();
      tuberias *= .25;
      var cableado = $("#cableado").val();
      cableado *= .20;
      var org_cableado = $("#org_cableado").val();
      org_cableado *= .15;
      var ponchado_cables = $("#ponchado_cables").val();
      ponchado_cables *= .15;
      var identificacion = $("#identificacion").val();
      identificacion *= .05;
      var instalacion_antenas = $("#instalacion_antenas").val();
      instalacion_antenas *= .10;
      var instalacion_switches = $("#instalacion_switches").val();
      instalacion_switches *= .10;

      var config_site = $("#config_site").val();
      config_site *= .25;
      var config_zone_director = $("#config_zone_director").val();
      config_zone_director *= .25;
      var infraestructura_test = $("#infraestructura_test").val();
      infraestructura_test *= .10;
      var test_general = $("#test_general").val();
      test_general *= .15;
      var recorrido = $("#recorrido").val();
      recorrido *= .25;

      var total_project = 0.0;

      var form = $('#form_proyect')[0];
      var formData = new FormData(form);

      let test_inputs =  document.getElementsByClassName('input_test');


      suma_instalaciones = tuberias + cableado + org_cableado + ponchado_cables + identificacion + instalacion_antenas + instalacion_switches;
      suma_configuration = config_site + config_zone_director + infraestructura_test + test_general + recorrido;

      for(var i = 0; i < test_inputs.length; i++){
          suma_test += parseFloat(test_inputs[i].value);
      }

      percent_instalaciones = suma_instalaciones * 0.65;
      percent_configuration = suma_configuration * 0.20;
      percent_test = suma_test * 0.15;
      total_project = percent_instalaciones + percent_configuration  + percent_test;

      formData.append('instalacion_total', suma_instalaciones.toFixed(2) );
      formData.append('configuracion_total', suma_configuration.toFixed(2));
      formData.append('test_total', suma_test.toFixed(2));
      formData.append('total_global', total_project);

      var miInit = { method: 'post',
                        headers: headers,
                        credentials: "same-origin",
                        body:formData,
                        cache: 'default' };

      fetch('/update_advace_project', miInit)
      .then(function(response){
        return response.text();
      })
      .then(function(response){

        if(response == "true"){
          Swal.fire({
            title: 'Avance de proyecto actualizado',
            text: "",
            type: 'success',
          }).then(function (result) {
            if (result.value) {
              $("#instalacion_total").html(suma_instalaciones.toFixed(2) + '%');
              $("#configuracion_total").html(suma_configuration.toFixed(2) + '%');
              $("#test_total").html(suma_test.toFixed(2) + '%');
              $( "#total_global").find( "div.progress-bar" ).css( "width", total_project + '%' );
              $( "#total_global" ).find( "div.progress-bar").find("span").text(total_project.toFixed(2) + '%');
            }
          })

        }else{
          Swal.fire("Operación abortada", "Ocurrio un error al guardar :(", "error");
        }

      })
      .catch(function(error){
              console.log(error);
      });
})

});
</script>
