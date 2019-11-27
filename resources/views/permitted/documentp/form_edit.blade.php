<form id="validation_master" name="validation_master" class="form-horizontal validation-wizard-master wizard-circle">
    {{ csrf_field() }}
    <input type="hidden" name="key_doc" id="key_doc" value="{{$data_header[0]->doc_type}}">
    <input type="hidden" name="key_anexo" id="key_anexo" value="{{$data_header[0]->anexo_id}}">
    <!-- Step 1 -->
    <h6>Paso 1 -Llenar datos y pedido de compras</h6>
    <section>
      <div class="row">
        <div class="col-6 col-md-4 col-lg-3">
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
            <input type="text" class="form-control" id="proyecto" name="proyecto" value="{{$data_header[0]->nombre_proyecto}}" placeholder="">
          </div>
          <div class="form-group fields_docm">
            <label for="grupo_id" class="">Grupo</label>
              <select type="text" class="form-control form-control-sm select2" id="grupo_id" name="grupo_id" placeholder="">
                <option value="0">Elegir</option>
                @foreach ($grupos as $grupo_data)
                  @if($grupo_data->id == $data_header[0]->grupo_id)
                    <option selected value="{{$grupo_data->id}}">{{$grupo_data->name}}</option>
                  @else
                    <option value="{{$grupo_data->id}}">{{$grupo_data->name}}</option>
                  @endif
                @endforeach
              </select>
          </div>

          <div class="form-group fields_docp">
            <label for="sites" class="">Num. sitios</label>
            <input type="number" class="form-control form-control-sm" id="sites" name="sites" placeholder="">
          </div>
        </div>
        <!-------------------------------------------------------------------->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="form-group">
            <label for="vertical" class="">Vertical</label>
              <select class="form-control form-control-sm" id="vertical" name="vertical">
                <option value="0">Elegir...</option>
                @foreach ($verticals as $vertical_data)
                  @if($vertical_data->id == $data_header[0]->vertical_id)
                    <option selected value="{{$vertical_data->id}}">{{$vertical_data->name}}</option>
                  @else
                    <option value="{{$vertical_data->id}}">{{$vertical_data->name}}</option>
                  @endif
                @endforeach
              </select>
          </div>
          <div id="" class="form-group fields_docp">
            <label for="grupo" class="">Grupo / Nombre</label>
              <input type="text" class="form-control" id="grupo" name="grupo" value="{{$data_header[0]->nombre_grupo}}" placeholder="">
          </div>
          <div id="" class="form-group fields_docm">
            <label for="grupo" class="">Anexo</label>
              <select type="text" class="form-control form-control-sm select2" id="anexo_id" name="anexo_id">
                <option value=""></option>
              </select>
          </div>
          <div class="form-group fields_docp">
            <label for="oportunity" class="">Num. oportunidad</label>
              <input type="number" class="form-control" id="oportunity" name="oportunity" value="{{$data_header[0]->num_oportunidad}}" placeholder="">
          </div>
        </div>
        <!-------------------------------------------------------------------->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="form-group fields_docp">
            <label for="fecha" class="">Densidad</label>
              <input type="number" class="form-control" id="densidad" name="densidad" value="{{$data_header[0]->densidad}}">
          </div>
          <div class="form-group">
            <label for="fecha" class="">IT Concierge</label>
              <select class="form-control form-control-sm select2" name="itc" id="itc">
                <option value="">Elegir...</option>
                @foreach ($itc as $itc_data)
                  @if($itc_data->id == $data_header[0]->itc_id)
                    <option selected value="{{$itc_data->id}}">{{$itc_data->nombre}}</option>
                  @else
                    <option value="{{$itc_data->id}}">{{$itc_data->nombre}}</option>
                  @endif
                @endforeach
                <option value="310">Roberto Carlos Gomez Martinez</option>
              </select>
          </div>
          <div class="form-group">
            <label for="fecha" class="">Propietario de la cuenta</label>
              <select class="form-control form-control-sm" name="comercial" id="comercial">
                <option value="">Elegir...</option>
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
        <!-------------------------------------------------------------------->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="form-group">
            <label for="type_service" class="">Tipo de servicio</label>
              <select class="form-control form-control-sm" id="type_service" name="type_service">
                <option value="">Elegir...</option>
                @foreach ($type_service as $type_service_data)
                  @if($type_service_data->id == $data_header[0]->tipo_servicio_id)
                    <option selected value="{{$type_service_data->id}}">{{$type_service_data->name}}</option>
                  @else
                    <option value="{{$type_service_data->id}}">{{$type_service_data->name}}</option>
                  @endif
                @endforeach
              </select>
          </div>
          <div class="form-group">
            <label for="fecha" class="">Lugar de la instalación</label>
              <select class="form-control form-control-sm" id="lugar_instalacion" name="lugar_instalacion">
                <option value="">Elegir</option>
                @foreach ($installation as $installation_data)
                  @if($installation_data->id == $data_header[0]->lugar_instalacion_id)
                    <option selected value="{{$installation_data->id}}">{{$installation_data->name}}</option>
                  @else
                    <option value="{{$installation_data->id}}">{{$installation_data->name}}</option>
                  @endif
                @endforeach
              </select>
          </div>
          <div class="form-group">
            <label for="fecha" class="">Tipo de cambio</label>
                <input type="number" class="form-control" onblur="exchange_rate()" id="tipo_cambio" name="tipo_cambio" value="{{$tipo_cambio}}">
          </div>
        </div>
      </div><!---row -->
      <br>
      <div class="row fields_docm">
        <div class="col-md-12">
          <div class="form-group">
            <h4 class="text-center text-danger">Presupuesto Anual</h4>
            <br>
            <div id="presupuesto_anual">

            </div>
          </div>
        </div>
      </div>


      <div  class="row mb-3"></div>

      <br>
      <div class="row fields_docp">
        <h4 class="text-danger">Mano de obra</h4>
      </div>
       <div class="row fields_docp">
        <div class="col-md-4">
          <div class="form-group">
              <a href="#" class="btn btn-danger" id="get_mo_button" name=""><i class="fas fa-people-carry mr-2"></i> Agregar Mano de obra</a>
          </div>
        </div>
      </div>
      <br>
      <div  class="row fields_docp">
        <section id="products-grid-mo" class="products-grid-mo">
        </section>
      </div>
      <br>
      <!--------VIATICOS---------->
      <div id="div_button_viatic" class="">
        <div class="row fields_docp">
          <h4 class="text-danger">Viaticos</h4>
        </div>
        <div class="row fields_docp">
          <div class="col-md-4">
            <div class="form-group">
                <button type="button" class="btn btn-success ml-20" id="get_viatics_button" name=""><i class="fas fa-utensils mr-2"></i></i><i class="fas fa-suitcase-rolling mr-1"></i> Agregar Viaticos</button>
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <h4 class="text-danger col-12">Agregar material extra</h4>
      </div>
        <br>
        <div class="row">
          <div class="col-3 p-3">
            <div class="form-group">
              <h4 class="col text-dark"><b>Filtrar por:</b></h4>
              <label for="">Categoría:</label>
              <select class="col form-control form-control-sm" id="categoria" name="categoria">
                <option value="0">Elegir...</option>
                @foreach ($categories as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="">Descripción:</label>
              <input id="description" class="col form-control form-control-sm" placeholder=" Mínimo 4 letras"/>
            </div>
            <div id="div_tuberia" class="d-none">
              <div class="form-group">
                <label for="">Material:</label><br>
                <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-dark">
                    <input type="radio" name="optionsMaterial" id="option1" value="1"> Galvanizado
                  </label>
                  <label class="btn btn-dark">
                    <input type="radio" name="optionsMaterial" id="option2" value="2"> PVC
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label for="">Tipo:</label>
                <select class="col form-control form-control-sm" id="tipo_material" name="tipo_material">
                  <option value="0">Elegir...</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Medida:</label>
                <div class="btn-group btn-group-sm btn-group-toggle d-flex justify-content-center" data-toggle="buttons">
                  <label class="btn btn-danger active">
                    <input type="radio" name="optionsMedida" id="option1" value="1" checked> 1"
                  </label>
                  <label class="btn btn-danger">
                    <input type="radio" name="optionsMedida" id="option2" value="2"> 1/2"
                  </label>
                  <label class="btn btn-danger">
                    <input type="radio" name="optionsMedida" id="option3" value="3"> 3/4"
                  </label>
                  <label class="btn btn-danger">
                    <input type="radio" name="optionsMedida" id="option3" value="4"> 2"
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <button id="get_categorias_button" type="button" class="col btn btn-dark mt-3"><i class="fas fa-search"></i> Buscar</button>
            </div>
          </div>

          <div class="col-9">
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
                      <td colspan="2"></td> <td style="font-weight:bold;" colspan="3">Total Viaticos:</td>
                      <td  style="font-weight:bold;" colspan="3">$ <span id="total_viaticos_footer">0.00</span> USD</td>
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
