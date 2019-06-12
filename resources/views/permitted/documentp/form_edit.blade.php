<form id="validation_master" name="validation_master" class="form-horizontal validation-wizard-master wizard-circle m-t-40">
    {{ csrf_field() }}
    <!-- Step 1 -->
    <input type="hidden" name="key_doc" id="key_doc" value="{{$data_header[0]->doc_type}}">
    <input type="hidden" name="key_anexo" id="key_anexo" value="{{$data_header[0]->anexo_id}}">
    <h6>Paso 1 -Llenar datos y pedido de compras</h6>
    <section>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="doc_type" class="col-sm-4 control-label">Tipo Doc.</label>
            <div class="col-sm-8">
              <select class="form-control" name="doc_type" id="doc_type">
                <option value="1">Documento P</option>
                <option value="2">Documento M</option>
              </select>
            </div>
          </div>
          <div class="form-group fields_docp">
            <label for="proyecto" class="col-sm-4 control-label">Nombre del proyecto</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="proyecto" name="proyecto" value="{{$data_header[0]->nombre_proyecto}}" placeholder="">
            </div>
          </div>
          <div class="form-group fields_docm">
            <label for="grupo_id" class="col-sm-4 control-label">Grupo</label>
            <div class="col-sm-8">
              <select type="text" class="form-control select2" id="grupo_id" name="grupo_id" placeholder="">
                @foreach ($grupos as $grupo_data)
                  @if($grupo_data->id == $data_header[0]->grupo_id)
                    <option selected value="{{$grupo_data->id}}">{{$grupo_data->name}}</option>
                  @else
                    <option value="{{$grupo_data->id}}">{{$grupo_data->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="type_service" class="col-sm-4 control-label">Tipo de servicio</label>
            <div class="col-sm-8">
              <select class="form-control" id="type_service" name="type_service">
                @foreach ($type_service as $type_service_data)
                  @if($type_service_data->id == $data_header[0]->tipo_servicio_id)
                    <option selected value="{{$type_service_data->id}}">{{$type_service_data->name}}</option>
                  @else
                    <option value="{{$type_service_data->id}}">{{$type_service_data->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group fields_docp">
            <label for="sites" class="col-sm-4 control-label">Sitios</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" value="{{$data_header[0]->sitios}}" id="sites" name="sites" placeholder="">
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label for="vertical" class="col-sm-4 control-label">Vertical</label>
            <div class="col-sm-8">
              <select class="form-control" id="vertical" name="vertical">
                @foreach ($verticals as $vertical_data)
                  @if($vertical_data->id == $data_header[0]->vertical_id)
                    <option selected value="{{$vertical_data->id}}">{{$vertical_data->name}}</option>
                  @else
                    <option value="{{$vertical_data->id}}">{{$vertical_data->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group fields_docp">
            <label for="grupo" class="col-sm-4 control-label">Grupo / Nombre</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="grupo" name="grupo" value="{{$data_header[0]->nombre_grupo}}" placeholder="">
            </div>
          </div>
          <div id="" class="form-group fields_docm">
            <label for="grupo" class="col-sm-4 control-label">Anexo</label>
            <div class="col-sm-8">
              <select type="text" class="form-control select2" id="anexo_id" name="anexo_id">
              </select>
            </div>
          </div>
          <div class="form-group fields_docp">
            <label for="oportunity" class="col-sm-4 control-label">Num. oportunidad</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="oportunity" name="oportunity" value="{{$data_header[0]->num_oportunidad}}" placeholder="">
            </div>
          </div>
          <div class="form-group">
            <label for="fecha" class="col-sm-4 control-label">Propietario de la cuenta</label>
            <div class="col-sm-8">
              <select class="form-control" name="comercial" id="comercial">
                @foreach ($comerciales as $comercial_data)
                  @if($comercial_data->id == $data_header[0]->comercial_id)
                    <option selected value="{{$comercial_data->id}}">{{$comercial_data->nombre}}</option>
                  @else
                    <option value="{{$comercial_data->id}}">{{$comercial_data->nombre}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group fields_docp">
            <label for="fecha" class="col-sm-4 control-label">Densidad</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="densidad" name="densidad" value="{{$data_header[0]->densidad}}">
            </div>
          </div>
          <div class="form-group">
            <label for="fecha" class="col-sm-4 control-label">IT Concierge</label>
            <div class="col-sm-8">
              <select class="form-control select2" name="itc" id="itc">
                @foreach ($itc as $itc_data)
                  @if($itc_data->id == $data_header[0]->itc_id)
                    <option selected value="{{$itc_data->id}}">{{$itc_data->nombre}}</option>
                  @else
                    <option value="{{$itc_data->id}}">{{$itc_data->nombre}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="fecha" class="col-sm-4 control-label">Lugar de la instalación</label>
            <div class="col-sm-8">
              <select class="form-control" id="lugar_instalacion" name="lugar_instalacion">
                @foreach ($installation as $installation_data)
                  @if($installation_data->id == $data_header[0]->comercial_id)
                    <option selected value="{{$installation_data->id}}">{{$installation_data->name}}</option>
                  @else
                    <option value="{{$installation_data->id}}">{{$installation_data->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="fecha" class="col-sm-4 control-label">Tipo de cambio</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" onblur="exchange_rate()" id="tipo_cambio" name="tipo_cambio" value="{{$tipo_cambio}}">
            </div>
          </div>
        </div>
      </div><!---row -->

      <br>
      <div  class="row"></div>

      <div  class="row">
        <section id="products-grid-materiales" class="products-grid-materiales">
        </section>
      </div>

      <div class="row">
        <h3 class="text-center text-danger">Agregar material extra</h3>
        <div class="col-md-3">
          <div class="card-filter">
          <div class="container-card">
            <h4 class="text-center text-primary"><b>Filtrar por:</b></h4>
            <div>
              <div class="form-group">
                <label for="">Categoría:</label>
                <select class="form-control" id="categoria" name="categoria">
                  <option value="0">Elegir...</option>
                  @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="">Descripción:</label>
                <input class="form-control" id="description" placeholder=" Mínimo 4 letras"/>
              </div>
              <button id="get_categorias_button" type="button" class="boton azul">Buscar</button>
            </div>
          </div>
        </div>
        <br>
        </div>
        <div class="col-md-9">
          <section id="products-grid-categorias" class="products-grid-categorias">
          </section>
        </div>
      </div>
    </section>
    <!-- Step 2 -->
    <h6>Paso 2 -Editar Carrito de compras</h6>
    <section>
      <div class="row">
        <div class="col-md-12">
          <h4>Favor de verificar su pedido</h4>
          <p class="text-danger"></p>
              <div class="table-responsive">
                <table id="tabla_productos" class="table table-condensed">
                  <thead>
                    <tr style="background: #496E7D;color:white;">
                      <th  class="text-center"style="width:20px !important;">Cant. Sug.</th>
                      <th class="text-center">Cant. Req.</th>
                      <th width="250px">Descripción</th>
                      <th>Tipo</th>
                      <th width="100px">Código</th>
                      <th>Proveedor</th>
                      <th>Num. de parte</th>
                      <th>% Descuento</th>
                      <th>Precio Unitario</th>
                      <th>Moneda</th>
                      <th>Total</th>
                      <th>Total (USD)</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot class="text-right" style="font-size:18px;">
                    <tr>
                      <td colspan="2"></td> <td style="font-weight:bold;" colspan="3">Total Equipo Activo:</td>
                      <td  style="font-weight:bold;" colspan="3">$ <span id="total_eqactivo_footer">0.00</span> USD</td>
                    </tr>
                    <tr>
                      <td colspan="2"></td> <td style="font-weight:bold;" colspan="3">Total Materiales:</td>
                      <td  style="font-weight:bold;" colspan="3">$ <span id="total_materiales_footer">0.00</span> USD</td>
                    </tr>
                    <tr>
                      <td colspan="2"></td> <td style="font-weight:bold;" colspan="3">Total Mano de Obra:</td>
                      <td  style="font-weight:bold;" colspan="3">$ <span id="total_sitwifi_footer">0.00</span> USD</td>
                    </tr>
                    <tr>
                      <td colspan="2"></td> <td style="font-weight:bold;" colspan="3">Total:</td>
                      <td  class="text-danger" style="font-weight:bold;" colspan="3">$<span id="total_global">0.00</span> USD</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
          </div>
        </div>
      </div>
    </section>
</form>

<script type="text/javascript">
$(function () {

  $('#date').datepicker({
        format: 'dd/mm/yyyy'
  });

  $('#itc').select2();

  $(document).ready(function(){
    let type_doc = document.getElementById('key_doc').value;
    let key_anexo = document.getElementById('key_anexo').value;
    let type = $('#type_service').val();
    if(type_doc == 1){
      $(".fields_docp").css('display', 'block');
      $(".fields_docm").css('display', 'none');
      if(type == 2 || type == 3){
        $(".fields_docm").css('display', 'block');
        var _token = $('input[name="_token"]').val();
        var id_cadena = $('#grupo_id').val();
        var datax;
        $.ajax({
          type: "POST",
          url: "/get_hotel_cadena",
          data: { data_one : id_cadena, _token : _token },
          success: function (data){
            console.log(data);
            datax = JSON.parse(data);
            if ($.trim(data)){
              $('#anexo_id').empty();
              $.each(datax, function(i, item) {
                  $('#anexo_id').append("<option value="+item.id+">"+item.Nombre_hotel+"</option>");
              });
              $('#anexo_id option[value="'+ key_anexo +'"]').attr('selected','selected');
            }
            else{
              $("#anexo_id").text('');
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
      }else{
        $(".fields_docm").css('display', 'none');
      }
    }else{
      $(".fields_docp").css('display', 'none');
      $(".fields_docm").css('display', 'block')
      $('#doc_type option[value=2]').attr('selected','selected');
      var _token = $('input[name="_token"]').val();
      var id_cadena = $('#grupo_id').val();
      var datax;
      $.ajax({
        type: "POST",
        url: "/get_hotel_cadena",
        data: { data_one : id_cadena, _token : _token },
        success: function (data){
          console.log(data);
          datax = JSON.parse(data);
          if ($.trim(data)){
            $('#anexo_id').empty();
            $.each(datax, function(i, item) {
                $('#anexo_id').append("<option value="+item.id+">"+item.Nombre_hotel+"</option>");
            });
            $('#anexo_id option[value="'+ key_anexo +'"]').attr('selected','selected');
          }
          else{
            $("#anexo_id").text('');
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    }
  });

  $("#doc_type").on("change", function(){
    let type_doc = $(this).val();

    if(type_doc == 1){
      $(".fields_docp").css('display', 'block');
      $(".fields_docm").css('display', 'none');
      $('#type_service').val(1);
    }else{
      $(".fields_docp").find('input').val('');
      $(".fields_docp").css('display', 'none');
      $(".fields_docm").css('display', 'block');
      $('#type_service').val(4);
    }

  });

  $('#grupo_id').on('change', function(){
    var _token = $('input[name="_token"]').val();
    var id_cadena = $(this).val();
    var datax;
    $.ajax({
      type: "POST",
      url: "/get_hotel_cadena",
      data: { data_one : id_cadena, _token : _token },
      success: function (data){
        console.log(data);
        datax = JSON.parse(data);
        if ($.trim(data)){
          $('#anexo_id').empty();
          $.each(datax, function(i, item) {
              $('#anexo_id').append("<option value="+item.id+">"+item.Nombre_hotel+"</option>");
          });
          get_vertical_anexo();
        }
        else{
          $("#anexo_id").text('');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  })

  function get_vertical_anexo(){
    let id_anexo = $('#anexo_id').val();

    fetch(`/get_vertical_anexo/anexo/${id_anexo}`, miInit)
      .then(function(response){
        return response.json();
      })
      .then(function(data){
        if(data[0].vertical_id != null){
          $("#vertical").val(data[0].vertical_id);
        }else{
          $("#vertical").val(0);
        }
      })

  }


  $('#type_service').on('change',function(){
    let type = $(this).val();
    if(type == 2 || type == 3){
      $(".fields_docm").css('display', 'block');
    }else{
      $(".fields_docm").css('display', 'none');
    }
  })

  $('#grupo_id').select2();
  $('#anexo_id').select2();

    function getPaginationSelectedPage(url) {
          var chunks = url.split('?');
          var baseUrl = chunks[0];
          var querystr = chunks[1].split('&');
          var pg = 1;
          for (i in querystr) {
              var qs = querystr[i].split('=');
              if (qs[0] == 'page') {
                  pg = qs[1];
                  break;
              }
          }
          return pg;
      }

      $('#description').on('keyup',function(){
        var categoria = document.getElementById('categoria').value;
        var description = document.getElementById('description').value;
        let url = ``;
        console.log(categoria);
        if(description.length >=4){
          url = `/items/ajax/third/${categoria}/${description}`;
          getArticlesCategorias(url);
        }

      });

      $('#products-grid-categorias').on('click', '.pagination a', function(e) {
          e.preventDefault();
          var pg = getPaginationSelectedPage($(this).attr('href'));
          var categoria = document.getElementById('categoria').value;
          var description = document.getElementById('description').value;
          if(description.lenght != ''){
            url = `/items/ajax/third/${categoria}/${description}`;
          }else{
            url = `/items/ajax/third/${categoria}`;
          }

          $.ajax({
              url: url,
              data: { page: pg },
              success: function(data) {
                  $('#products-grid-categorias').html(data);
              }
          });
      });

    $("#get_categorias_button").on("click",function(e){
      e.preventDefault();
      var categoria = document.getElementById('categoria').value;
      var description = document.getElementById('description').value;
      if(description.lenght != ''){
        url = `/items/ajax/third/${categoria}/${description}`;
      }else{
        url = `/items/ajax/third/${categoria}`;
      }

      getArticlesCategorias(url);
    })


});

function leerDatosProductMO(producto){
  var tipo_cambio = document.getElementById('tipo_cambio').value;
  var precioTotal = 0.0;
  var precio_usd = 0.0;
  var cant_req = 0;
  var cant_sug = producto.cantidad;
  var currency_id = producto.currency_id;

  if(cant_req == 0){
    //Si  la cantidad requerida es 0 se toma en cuenta la cantidad sugerida como la cantidad de artculos solicitada
    cant_req = parseFloat(cant_sug);
  }else{
    cant_req = parseFloat(cant_req);
  }

  precioTotal = (parseFloat(cant_req) * parseFloat(producto.precio));

  if(currency_id == 1){
    precio_usd = precioTotal / parseFloat(tipo_cambio);
  }else{
    precio_usd = precioTotal;
  }

   const infoProducto = {
       id: producto.id,
       id_key: producto.idprod,
       descripcion: producto.descripcion,
       img: producto.img,
       codigo: producto.codigo,
       precio: producto.precio.toFixed(2),
       categoria: producto.categoria,
       categoria_id: producto.categoria_id,
       num_parte: producto.num_parte,
       currency: producto.currency,
       currency_id: producto.currency_id,
       proveedor: producto.proveedor,
       descuento: 0,
       cant_sug: cant_sug,
       cant_req: cant_req,
       precio_total : precioTotal.toFixed(2),
       precio_total_usd : precio_usd.toFixed(2)
   }

   insertarMO(infoProducto);
}

function guardarProductoLS(producto){
    let productos;

    productos = obtenerProductosLocalStorage();
    productos.push(producto);

    localStorage.setItem('productos', JSON.stringify(productos));
}

function insertarMO(producto){
    guardarProductoLS(producto);
}

function getArticles(url) {
    $.ajax({
        url : url
    }).done(function (data) {
        $('#products-grid').html(data);
    }).fail(function () {
        alert('Articles could not be loaded.');
    });
}

function getArticlesMateriales(url) {
    $.ajax({
        url : url
    }).done(function (data) {
        $('#products-grid-materiales').html(data);
    }).fail(function () {
        alert('Articles could not be loaded.');
    });
}

function getArticlesCategorias(url) {
    $.ajax({
        url : url
    }).done(function (data) {
        $('#products-grid-categorias').html(data);
    }).fail(function () {
        alert('Articles could not be loaded.');
    });
}

</script>
