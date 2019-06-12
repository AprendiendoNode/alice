<form id="validation_master" name="validation_master" class="form-horizontal validation-wizard-master wizard-circle">
    {{ csrf_field() }}
    <!-- Step 1 -->
    <h6>Paso 1 -Llenar datos y pedido de compras</h6>
    <section>
      <div class="row">
        <div class="col-6 col-md-4">
          <div class="form-group">
            <label for="doc_type" class="">Tipo Documento</label>
              <select class="form-control form-control-sm" name="doc_type" id="doc_type">
                <option value="1">Documento P</option>
                <option value="2">Documento M</option>
                {{-- <option value="3">Cotización</option> --}}
              </select>
          </div>
          <div class="form-group fields_docp">
            <label for="proyecto" class="">Nombre del proyecto</label>
            <input type="text" class="form-control form-control-sm" id="proyecto" name="proyecto" placeholder="">
          </div>
          <div class="form-group fields_docm">
            <label for="grupo_id" class="">Grupo</label>
              <select type="text" class="form-control form-control-sm select2" id="grupo_id" name="grupo_id" placeholder="">
                <option value="0">Elegir</option>
                {{-- @foreach ($grupos as $grupo_data)
                  <option value="{{$grupo_data->id}}">{{$grupo_data->name}}</option>
                @endforeach --}}
              </select>
          </div>
          <div class="form-group">
            <label for="type_service" class="">Tipo de servicio</label>
              <select class="form-control form-control-sm" id="type_service" name="type_service">
                <option value="">Elegir...</option>
                {{-- @foreach ($type_service as $type_service_data)
                  <option value="{{$type_service_data->id}}">{{$type_service_data->name}}</option>
                @endforeach --}}
              </select>
          </div>
          <div class="form-group fields_docp">
            <label for="sites" class="">Num. sitios</label>
            <input type="number" class="form-control form-control-sm" id="sites" name="sites" placeholder="">
          </div>
        </div>
        <!-------------------------------------------------------------------->
        <div class="col-6 col-md-4">
          <div class="form-group">
            <label for="vertical" class="">Vertical</label>
              <select class="form-control form-control-sm" id="vertical" name="vertical">
                <option value="0">Elegir...</option>
                {{-- @foreach ($verticals as $vertical_data)
                  <option value="{{$vertical_data->id}}">{{$vertical_data->name}}</option>
                @endforeach --}}
              </select>
          </div>
          <div id="" class="form-group fields_docp">
            <label for="grupo" class="">Grupo / Nombre</label>
              <input type="text" class="form-control form-control-sm" id="grupo" name="grupo" placeholder="">
          </div>
          <div id="" class="form-group fields_docm">
            <label for="grupo" class="">Anexo</label>
              <select type="text" class="form-control form-control-sm select2" id="anexo_id" name="anexo_id">
                <option value=""></option>
              </select>
          </div>
          <div class="form-group fields_docp">
            <label for="oportunity" class="">Num. oportunidad</label>
              <input type="text" class="form-control form-control-sm" id="oportunity" name="oportunity" placeholder="">
          </div>
          <div class="form-group">
            <label for="fecha" class="">Propietario de la cuenta</label>
              <select class="form-control form-control-sm" name="comercial" id="comercial">
                <option value="">Elegir...</option>
                {{-- @foreach ($comerciales as $comercial_data)
                  <option value="{{$comercial_data->id}}">{{$comercial_data->nombre}}</option>
                @endforeach --}}
              </select>
          </div>
        </div>
        <!-------------------------------------------------------------------->
        <div class="col-md-4">
          <div class="form-group fields_docp">
            <label for="fecha" class="">Densidad</label>
              <input type="number" class="form-control form-control-sm" id="densidad" name="densidad">
          </div>
          <div class="form-group">
            <label for="fecha" class="">IT Concierge</label>
              <select class="form-control form-control-sm select2" name="itc" id="itc">
                <option value="">Elegir...</option>
                {{-- @foreach ($itc as $itc_data)
                  <option value="{{$itc_data->id}}">{{$itc_data->nombre}}</option>
                @endforeach --}}
                <option value="310">Roberto Carlos Gomez Martinez</option>
              </select>
          </div>
          <div class="form-group">
            <label for="fecha" class="">Lugar de la instalación</label>
              <select class="form-control form-control-sm" id="lugar_instalacion" name="lugar_instalacion">
                <option value="">Elegir</option>
                {{-- @foreach ($installation as $installation_data)
                  <option value="{{$installation_data->id}}">{{$installation_data->name}}</option>
                @endforeach --}}
              </select>
          </div>
          <div class="form-group">
            <label for="fecha" class="">Tipo de cambio</label>
              <input type="number" class="form-control form-control-sm" onblur="exchange_rate()" id="tipo_cambio" name="tipo_cambio" value="20">
          </div>
        </div>

      </div><!---row -->


      <br>
      <div  class="row"></div>

      <div class="row fields_docp">
        <h4 class="text-danger">Equipo activo</h4>
      </div>
      <div class="row fields_docp">
        <div class="col-md-4">
          <div class="form-group">
              <a href="#" class="btn btn-dark ml-20" id="get_equipo_button" name=""><i class="fas fa-hdd mr-2"></i> Buscar Equipo Activo</a>
          </div>
        </div>
      </div>
      <div  class="row fields_docp">
        <section id="products-grid" class="products-grid">
        </section>
      </div>
      <br>
      <div class="row fields_docp">
        <h4 class="text-danger">Materiales</h4>
      </div>
      <div class="row fields_docp">
        <div class="col-md-4">
          <div class="form-group">
              <a href="#" class="btn btn-dark ml-20" id="get_materiales_button" name=""><i class="fas fa-tools mr-2"></i> Buscar Materiales</a>
          </div>
        </div>
      </div>
      <div  class="row fields_docp">
        <section id="products-grid-materiales" class="products-grid-materiales">
        </section>
      </div>
      <br>
      <div class="row fields_docp">
        <h4 class="text-danger">Mano de obra</h4>
      </div>
      <div class="row fields_docp">
        <div class="col-md-4">
          <div class="form-group">
              <a href="#" class="btn btn-danger ml-20" id="get_mo_button" name=""><i class="fas fa-people-carry mr-2"></i> Agregar Mano de obra</a>
          </div>
        </div>
      </div>
      <br>
      <div  class="row fields_docp">
        <section id="products-grid-mo" class="products-grid-mo">
        </section>
      </div>
      <br>
      <div class="row">
        <h4 class="text-danger col-12">Agregar material extra</h4>
        <br>
        <div class="col-md-3">
          <div class="card">
          <div class="card-body">
            <h4 class="text-center text-success"><b>Filtrar por:</b></h4>
            <div>
              <div class="form-group">
                <label for="">Categoría:</label>
                <select class="form-control form-control-sm" id="categoria" name="categoria">
                  <option value="0">Elegir...</option>
                  {{-- @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach --}}
                </select>
              </div>
              <div class="form-group">
                <label for="">Descripción:</label>
                <input id="description" class="form-control form-control-sm" placeholder=" Mínimo 4 letras"/>
              </div>
              <button id="get_categorias_button" type="button" class="btn btn-dark mt-3"><i class="fas fa-search"></i> Buscar</button>
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
    <h6>Paso 2 -Llenar datos y pedido de compras</h6>
    <section>
      <div class="row">
        <div class="col-md-12">
          <h4>Favor de verificar su pedido</h4>
          <p class="text-danger">* Despues de guardar solo se permitiran 3 modificaciones a partir de que su solicitud sea aprobada.</p>
              <div class="table-responsive">
                <table id="tabla_productos" class="table table-condensed table-sm">
                  <thead>
                    <tr style="background: #496E7D;color:white;font-size:10px;">
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
                  <tfoot class="text-right" style="font-size:18px;border-color:transparent">
                    <tr>
                      <td colspan="2"></td> <td style="font-weight:bold;border-color:transparent" colspan="3">Total Equipo Activo:</td>
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
    </section>

</form>
