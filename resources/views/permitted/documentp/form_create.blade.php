<form id="validation_master" name="validation_master" class="form-horizontal validation-wizard-master wizard-circle">
    {{ csrf_field() }}
    <!-- Step 1 -->
    <h6>Paso 1 -Llenar datos y agregar materiales</h6>
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
            <input type="text" class="form-control form-control-sm" id="proyecto" name="proyecto" placeholder="">
          </div>
          <div class="form-group fields_docm">
            <label for="grupo_id" class="">Grupo</label>
              <select type="text" class="form-control form-control-sm select2" id="grupo_id" name="grupo_id" placeholder="">
                <option value="0">Elegir</option>
                @foreach ($grupos as $grupo_data)
                  <option value="{{$grupo_data->id}}">{{$grupo_data->name}}</option>
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
                <option value="">Elegir...</option>
                @foreach ($verticals as $vertical_data)
                  <option value="{{$vertical_data->id}}">{{$vertical_data->name}}</option>
                @endforeach
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
        </div>
        <!-------------------------------------------------------------------->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="form-group fields_docp">
            <label for="fecha" class="">Densidad</label>
              <input type="number" class="form-control form-control-sm" id="densidad" name="densidad">
          </div>
          <div class="form-group">
            <label for="fecha" class="">IT Concierge</label>
              <select class="form-control form-control-sm select2" name="itc" id="itc">
                <option value="">Elegir...</option>
                @foreach ($itc as $itc_data)
                  <option value="{{$itc_data->id}}">{{$itc_data->nombre}}</option>
                @endforeach
                <option value="310">Roberto Carlos Gomez Martinez</option>
              </select>
          </div>
          <div class="form-group">
            <label for="fecha" class="">Propietario de la cuenta</label>
              <select class="form-control form-control-sm" name="comercial" id="comercial">
                <option value="">Elegir...</option>
                @foreach ($comerciales as $comercial_data)
                  <option value="{{$comercial_data->id}}">{{$comercial_data->nombre}}</option>
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
                  <option value="{{$type_service_data->id}}">{{$type_service_data->name}}</option>
                @endforeach
              </select>
          </div>
          <div class="form-group">
            <label for="fecha" class="">Lugar de la instalación</label>
              <select class="form-control form-control-sm" id="lugar_instalacion" name="lugar_instalacion">
                <option value="">Elegir</option>
                @foreach ($installation as $installation_data)
                  <option value="{{$installation_data->id}}">{{$installation_data->name}}</option>
                @endforeach
              </select>
          </div>
          <div class="form-group">
            <label for="fecha" class="">Tipo de cambio</label>
              <input type="number" class="form-control form-control-sm" onblur="exchange_rate()" id="tipo_cambio" name="tipo_cambio" value="20">
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

      <div class="row">
        <div class="col-md-4 fields_docp">
          <div class="row mb-2">
            <div class="col-md-8">
              <h4 class="text-center text-primary">AP'S</h4>
            </div>
            <div class="col-md-2">
              <button class="btn btn-sm btn-dark p-1 addButtonAP" type="button"><i class="fa fa-plus"></i></button>
            </div>
          </div>

          <div class="row mb-2">
            <div class="form-row">
              <div class="col-6">
                <select class="form-control form-control-sm aps_modelo" name="aps_modelo[0]">
                  <option value="0">Elija ...</option>
                  @foreach ($product_ap as $product_ap_data)
                    <option data-key="{{$product_ap_data->clave}}" value="{{$product_ap_data->id}}">{{$product_ap_data->equipo}}</option>
                  @endforeach
                  <option data-key="APE" value="1075">Nodos extra (Voz y datos) no para antenas</option>
                </select>
              </div>
              <div class="col-4">
                <input class="form-control form-control-sm aps_cant" min="0" type="number" value="0" name="aps_cant[0]" placeholder="Cantidad">
              </div>
              <div class="col-2"></div>
            </div>
          </div>
          <div class="row clone d-none" id="optionTemplateAP">
            <div class="form-row">
              <div class="col-6">
                <select class="form-control form-control-sm aps_modelo" name="aps_modelo">
                  <option value="0"> Elija ...</option>
                  @foreach ($product_ap as $product_ap_data)
                    <option data-key="{{$product_ap_data->clave}}" value="{{$product_ap_data->id}}">{{$product_ap_data->equipo}}</option>
                  @endforeach
                  <option data-key="APE" value="1075">Nodos extra (Voz y datos) no para antenas</option>
                </select>
              </div>
              <div class="col-4">
                <input class="form-control form-control-sm aps_cant" value="0" min="0" type="number" name="aps_cant" placeholder="Cantidad">
              </div>
              <button type="button" class="col-1 btn removeButtonAP"><i class="fa fa-minus text-danger"></i></button>
            </div>
          </div>
        </div><!--row antenas--->

        <div class="col-md-4 fields_docp">
          <div class="row mb-2">
            <div class="col-md-8">
              <h4 class="text-center text-primary">FIREWALL</h4>
            </div>
            <div class="col-md-2">
              <button class="btn btn-sm btn-dark p-1 addButtonFW" type="button" name="button"> <i class="fa fa-plus"></i></button>
            </div>
          </div>
          <div class="row mb-2">
            <div class="form-row">
              <div class="col-6">
                <select class="form-control form-control-sm firewall_modelo" name="firew_mod[0]">
                  <option value="0">Elija ...</option>
                  @foreach ($product_fw as $product_fw_data)
                    <option value="{{$product_fw_data->id}}">{{$product_fw_data->equipo}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-4">
                <input class="form-control form-control-sm firewall_cant" value="0" min="0" type="number" name="firew_cant[0]" placeholder="Cantidad">
              </div>
              <div class="col-2"></div>
            </div>
          </div>
          <div class="row clone d-none" id="optionTemplateFIRE">
            <div class="form-row">
              <div class="col-6">
                <select class="form-control form-control-sm firewall_modelo" name="firew_mod">
                  <option value="0">Elija ...</option>
                  @foreach ($product_fw as $product_fw_data)
                    <option value="{{$product_fw_data->id}}">{{$product_fw_data->equipo}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-4">
                <input class="form-control form-control-sm firewall_cant" value="0" value="0" min="0" type="number" name="firew_cant" placeholder="Cantidad">
              </div>
              <button type="button" class="col-1 btn removeButtonFW"><i class="fa fa-minus text-danger"></i></button>
            </div>
          </div>
        </div><!--row firewall--->

        <div class="col-md-4 fields_docp">
          <div class="row mb-2">
            <div class="col-8">
              <h4 class="text-center text-primary">SWITCHES</h4>
            </div>
            <div class="col-2">
              <button class="btn btn-sm btn-dark p-1 addButtonSW" type="button" name="button"> <i class="fa fa-plus"></i></button>
            </div>
          </div>

          <div class="row mb-2">
            <div class="form-row">
              <div class="col-6">
                <select class="form-control form-control-sm switch_modelo" name="switches_mod[0]">
                  <option value="0">Elija ...</option>
                  @foreach ($product_sw as $product_sw_data)
                    <option value="{{$product_sw_data->id}}">{{$product_sw_data->equipo}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-4">
                <input class="form-control form-control-sm switch_cant" value="0" min="0" type="number" name="switches_cant[0]" placeholder="Cantidad">
              </div>
              <div class="col-1"></div>
            </div>
          </div>

          <div class="row clone d-none" id="optionTemplateSW">
            <div class="form-row">
              <div class="col-6">
                <select class="form-control form-control-sm switch_modelo" name="switches_mod">
                  <option value="0">Elija ...</option>
                  @foreach ($product_sw as $product_sw_data)
                    <option value="{{$product_sw_data->id}}">{{$product_sw_data->equipo}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-4">
                <input class="form-control form-control-sm switch_cant" value="0" min="0" type="number" name="switches_cant" placeholder="Cantidad">
              </div>
              <button type="button" class="col-1 btn removeButtonSW"><i class="fa fa-minus text-danger"></i></button>
              </div>
            </div>
          </div><!--row switches--->
      </div><!---row-->
      <br>
      <div class="row">
        
          
          <div class="col-md-4 fields_docp">
            <div class="row mb-2">
              <div class="col-8">
                <h4 class="text-center text-success">Gabinetes</h4>
              </div>
              <div class="col-2">
                <button class="btn btn-sm btn-dark p-1 addButtonGabinetes" type="button" name="button"> <i class="fa fa-plus"></i></button>
              </div>
            </div>
  
            <div class="row mb-2">
              <div class="form-row">
                <div class="col-6">
                  <select class="form-control form-control-sm gabinetes_select" name="gabinetes_select[0]">
                    <option value="0">Elija ...</option>
                    @foreach ($products_gabinetes as $gabinetes)
                      <option value="{{$gabinetes->id}}">{{$gabinetes->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4">
                  <input class="form-control form-control-sm gabinetes_cant" value="0" min="0" type="number" name="gabinetes_cant[0]" placeholder="Cantidad">
                </div>
                <div class="col-1"></div>
              </div>
            </div>
            <div class="row clone d-none" id="optionTemplateGabinetes">
              <div class="form-row">
                <div class="col-6">
                  <select class="form-control form-control-sm gabinetes_select" name="gabinetes_select">
                    <option value="0">Elija ...</option>
                    @foreach ($products_gabinetes as $gabinetes)
                      <option value="{{$gabinetes->id}}">{{$gabinetes->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4">
                  <input class="form-control form-control-sm gabinetes_cant" value="0" min="0" type="number" name="gabinetes_cant" placeholder="Cantidad">
                </div>
                <button type="button" class="col-1 btn removeButtonGabinetes"><i class="fa fa-minus text-danger"></i></button>
                </div>
              </div>
            </div><!--row gabinetes--->

          <div class="col-md-2 fields_docp">
            <div class="row mb-2">
              <div class="col-12">
                <h4 class="text-center text-success">Material</h4>
              </div>
            </div>
            <div class="row mb-2 d-flex justify-content-center">
              <div class="form-row">
                <div class="col-12">
                  <select class="form-control form-control-sm material_select" name="material_select[0]">
                    @foreach ($materiales as $material)
                      <option value="{{$material->id}}">{{$material->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>  
          </div><!--material--->
          <div class="col-md-2 fields_docp">
            <div class="row mb-2">
              <div class="col-12">
                <h4 class="text-center text-success">Medidas</h4>
              </div>
            </div>
            <div class="row mb-2 d-flex justify-content-center">
              <div class="form-row">
                <div class="col-12">
                  <select class="form-control form-control-sm medida_select" name="medida_select[0]">
                    @foreach ($medidas as $medida)
                      <option value="{{$medida->id}}">{{$medida->unit}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>  
          </div><!--Medidas--->
          <div class="col-md-4 fields_docp">
              <button type="button" id="add_shopping_cart" class="btn btn-sm btn-success m-3"> <i class="fas fa-cart-plus"></i> Agregar </button>
              <button type="button" id="delete_cart" class="btn btn-sm btn-danger m-3"> <i class="fas fa-trash-alt"></i> Vaciar carrito</button>
          </div><!----->
      </div>
      <div  class="row mb-3 fields_docp">
        <div class="col-12">
          
        </div>
      </div>

      <div class="row fields_docp">
        <h4 class="text-danger">Equipo activo</h4>
      </div>
      <div class="row fields_docp">
        <div class="col-md-4">
          <div class="form-group">
              <a href="#" class="btn btn-dark ml-20" id="get_equipo_button" name=""><i class="fas fa-hdd mr-2"></i> Equipo activo sugerido</a>
          </div>
        </div>
      </div>
      <div  class="row fields_docp">
        <section class="col-12" id="products-grid" class="products-grid">

        </section>
      </div>
      <br>
      <div class="row fields_docp">
        <h4 class="text-danger">Materiales</h4>
      </div>
      <div class="row fields_docp">
        <div class="col-md-4">
          <div class="form-group">
              <a href="#" class="btn btn-dark ml-20" id="get_materiales_button" name=""><i class="fas fa-tools mr-2"></i> Materiales sugeridos</a>
          </div>
        </div>
      </div>
      <div  class="row fields_docp">
        <section class="col-12" id="products-grid-materiales" class="products-grid-materiales">
        </section>
      </div>
      <br>
      <!--------MANO DE OBRA---------->
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
      <!--------VIATICOS---------->
      <div id="div_button_viatic" class="d-none">
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
      <div  class="row fields_docp">
        <section id="products-grid-mo" class="products-grid-mo">
        </section>
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
                      <input type="radio" name="optionsMedida" id="option1" value="4" checked> 1"
                    </label>
                    <label class="btn btn-danger">
                      <input type="radio" name="optionsMedida" id="option2" value="2"> 1/2"
                    </label>
                    <label class="btn btn-danger">
                      <input type="radio" name="optionsMedida" id="option3" value="3"> 3/4"
                    </label>
                    <label class="btn btn-danger">
                      <input type="radio" name="optionsMedida" id="option3" value="8"> 2"
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
    <h6>Paso 2 -Resumen de compras</h6>
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
