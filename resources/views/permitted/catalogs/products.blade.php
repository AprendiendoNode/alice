@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View productossat') )
    {{ trans('invoicing.productossat') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View productossat') )
    {{ trans('invoicing.productossat') }}
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View productossat') )
  <!-- Crear -->
  <div id="modal-CreatNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalproducts" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalproducts">Crear nuevo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="creatproductsystem" name="creatproductsystem" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="d-flex justify-content-center">
                  <div class="p-2 col-md-8">
                    <div id="ads">
                      <div class="card rounded">
                        <div class="card-image">
                          <span class="card-notify-badge">Preview</span>
                          <img id="img_preview" name="img_preview" src="{{ asset('img/company/Default.svg') }}" alt="Alternate Text" class="img-responsive mx-auto d-block"/>
                        </div>
                        <div class="mt-3">
                          <div class="form-group">
                            <div id="cont_file" class="">
                              <div class="input-group">
                                <label class="input-group-btn">
                                  <span class="btn btn-primary">
                                    Imagen <input id="fileInput" name="fileInput" type="file" style="display: none;" class="required">
                                  </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Clave:<span style="color: red;">*</span></label>
                          <input maxlength="30" type="text" class="form-control form-control-sm required" id="inputCreatkey" name="inputCreatkey" placeholder="Ingrese una clave">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>No. Parte:<span style="color: red;">*</span></label>
                          <input maxlength="30" type="text" class="form-control form-control-sm required" id="inputCreatpart" name="inputCreatpart" placeholder="Ingrese el núm. de parte">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Nombre:<span style="color: red;">*</span></label>
                          <input type="text" class="form-control form-control-sm required" id="inputCreatname" name="inputCreatname" placeholder="Ingrese el nombre">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Precio (Default):<span style="color: red;">*</span></label>
                          <input type="text" class="form-control form-control-sm required" id="inputCreatcoindefault" name="inputCreatcoindefault" placeholder="Ingrese el precio generico" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="form-group">
                      <label for="description">Descripcion:</label>
                      <input type="text" class="form-control form-control-sm" id="description" name="description">
                    </div>
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="form-group">
                      <label for="comment">Comentario:</label>
                      <input type="text" class="form-control form-control-sm" id="comment" name="comment">
                    </div>
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="discount" class="control-label">Descuento<span style="color: red;">*</span></label>
                            <input type="number" id="discount" name="discount" min="0" max="100" value="0" class="form-control form-control-sm required" style="width:100%;"/>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sel_modal_coin" class="control-label">Especificación<span style="color: red;">*</span></label>
                            <select id="sel_especification" name="sel_especification" class="form-control form-control-sm required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($especificacion as $especificacion_data)
                              <option value="{{ $especificacion_data->id }}"> {{ $especificacion_data->name }} </option>
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sel_modal_coin" class="control-label">Moneda (Default)<span style="color: red;">*</span></label>
                            <select id="sel_modal_coin" name="sel_modal_coin" class="form-control form-control-sm required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($currency as $data_currency)
                              <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sel_modal_proveedor" class="control-label">Proveedor/Clientes<span style="color: red;">*</span></label>
                            <select id="sel_modal_proveedor" name="sel_modal_proveedor" class="form-control form-control-sm required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($customer as $data_customer)
                              <option value="{{ $data_customer->id }}"> {{ $data_customer->name }} </option>
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="sel_categoria"> Categoria:
                          <span style="color: red;">*</span>
                        </label>
                        <div id="cont_category" class="input-group mb-3">
                          <select datas="sel_categoria" id="sel_categoria" name="sel_categoria" class="form-control form-control-sm required">
                            <option value="" selected>{{ trans('message.selectopt') }}</option>
                            @forelse ($category as $data_category)
                            <option value="{{ $data_category->id }}"> {{ $data_category->name }} </option>
                            @empty
                            @endforelse
                          </select>
                          <div class="input-group-append">
                            <button class="btn btn-primary btn-sm addcategorias" type="button"><i class="fa fa-plus"></i></button>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="sel_modelo"> Modelo:
                          <span style="color: red;">*</span>
                        </label>
                        <div id="cont_model" class="input-group mb-3">
                          <select datas="sel_modelo" id="sel_modelo" name="sel_modelo" class="form-control form-control-sm required">
                            <option value="" selected>{{ trans('message.selectopt') }}</option>
                            @forelse ($models as $data_models)
                            <option value="{{ $data_models->id }}"> {{ $data_models->ModeloNombre }} </option>
                            @empty
                            @endforelse
                          </select>
                          <div class="input-group-append">
                            <button class="btn btn-primary btn-sm addmodel" type="button"><i class="fa fa-plus"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sel_unit" class="control-label">Unidad de medida:<span style="color: red;">*</span></label>
                          <select id="sel_unit" name="sel_unit" class="form-control form-control-sm required" style="width:100%;">
                            <option value="">{{ trans('message.selectopt') }}</option>
                            @forelse ($unitmeasures as $data_unitmeasures)
                            <option value="{{ $data_unitmeasures->id }}"> {{ $data_unitmeasures->name }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sel_satserv" class="control-label">Productos/Servicios SAT:<span style="color: red;">*</span></label>
                            <select id="sel_satserv" name="sel_satserv" class="form-control form-control-sm required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($satproduct as $data_satproduct)
                              <option value="{{ $data_satproduct->id }}"> {{ $data_satproduct->name }} </option>
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Fabricante:</label>
                          <input type="text" class="form-control" id="inputCreatManufacter" name="inputCreatManufacter" placeholder="Nombre del fabricante" maxlength="60">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="sel_estatus"> Estatus:
                          <span style="color: red;">*</span>
                        </label>
                        <div id="cont_estatus" class="input-group mb-3">
                          <select datas="sel_estatus" id="sel_estatus" name="sel_estatus" class="form-control form-control-sm required">
                            <option value="" selected>{{ trans('message.selectopt') }}</option>
                            @forelse ($estatus as $data_estatus)
                              <option value="{{ $data_estatus->id }}"> {{ $data_estatus->name }} </option>
                            @empty
                            @endforelse
                          </select>
                          <div class="input-group-append">
                            <button class="btn btn-primary btn-sm addstatus" type="button"><i class="fa fa-plus"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Orden:<span style="color: red;">*</span></label>
                          <input type="text" class="form-control form-control-sm required" id="inputCreatOrden" name="inputCreatOrden" placeholder="Orden de visualización" value="0" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="status" class="col-sm-3 control-label">Filtrable</label>
                          <div class="col-md-9 mb-3">
                            <input id="status" name="status" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 mt-4">
                      <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                      <button type="button" class="btn btn-danger waves-effect form_creat_user" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!-- Editar -->
  <div id="modal-Edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaledit" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modaledit">Editar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="editproductsystem" name="editproductsystem" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input id="fsd" name="fsd" type="hidden" class="form-control">
                <input id="_token_c" name="_token_c" type="hidden" class="form-control">

                <div class="d-flex justify-content-center">
                  <div class="p-2 col-md-8">
                    <div id="ads">
                      <div class="card rounded">
                        <div class="card-image">
                          <span class="card-notify-badge">Preview</span>
                          <img id="edit_img_preview" name="edit_img_preview" src="{{ asset('img/company/Default.svg') }}" alt="Alternate Text" class="img-responsive mx-auto d-block"/>
                        </div>
                        <div class="mt-3">
                          <div class="form-group">
                            <div id="edit_cont_file" class="">
                              <div class="input-group">
                                <label class="input-group-btn">
                                  <span class="btn btn-primary">
                                    Imagen <input id="editfileInput" name="editfileInput" type="file" style="display: none;" class="required">
                                  </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Clave:<span style="color: red;">*</span></label>
                          <input maxlength="30" type="text" class="form-control form-control-sm required" id="inputEditkey" name="inputEditkey" placeholder="Ingrese una clave"oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>No. Parte:<span style="color: red;">*</span></label>
                          <input maxlength="30" type="text" class="form-control form-control-sm required" id="inputEditpart" name="inputEditpart" placeholder="Ingrese el núm. de parte">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Nombre:<span style="color: red;">*</span></label>
                          <input type="text" class="form-control form-control-sm required" id="inputEditname" name="inputEditname" placeholder="Ingrese el nombre">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Precio (Default):<span style="color: red;">*</span></label>
                          <input type="text" class="form-control form-control-sm required" id="inputEditcoindefault" name="inputEditcoindefault" placeholder="Ingrese el precio generico" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="form-group">
                      <label for="description">Descripcion:</label>
                      <input type="text" class="form-control form-control-sm" id="inputEditdescription" name="inputEditdescription">
                    </div>
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="form-group">
                      <label for="comment">Comentario:</label>
                      <input type="text" class="form-control form-control-sm" id="inputEditcomment" name="inputEditcomment">
                    </div>
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="edit_discount" class="control-label">Descuento<span style="color: red;">*</span></label>
                            <input type="number" id="edit_discount" name="edit_discount" min="0" max="100" value="0" class="form-control form-control-sm required" style="width:100%;"/>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sel_especification_edit" class="control-label">Especificación<span style="color: red;">*</span></label>
                            <select id="sel_especification_edit" name="sel_especification_edit" class="form-control form-control-sm required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($especificacion as $especificacion_data)
                              <option value="{{ $especificacion_data->id }}"> {{ $especificacion_data->name }} </option>
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="editsel_modal_coin" class="control-label">Moneda (Default)<span style="color: red;">*</span></label>
                            <select id="editsel_modal_coin" name="editsel_modal_coin" class="form-control form-control-sm required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($currency as $data_currency)
                              <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="editsel_modal_proveedor" class="control-label">Proveedor/Clientes<span style="color: red;">*</span></label>
                            <select id="editsel_modal_proveedor" name="editsel_modal_proveedor" class="form-control form-control-sm required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($customer as $data_customer)
                              <option value="{{ $data_customer->id }}"> {{ $data_customer->name }} </option>
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="edit_sel_categoria"> Categoria:
                          <span style="color: red;">*</span>
                        </label>
                        <div id="edit_cont_category" class="input-group mb-3">
                          <select edatas="edit_sel_categoria" id="edit_sel_categoria" name="edit_sel_categoria" class="form-control form-control-sm required">
                            <option value="" selected>{{ trans('message.selectopt') }}</option>
                            @forelse ($category as $data_category)
                            <option value="{{ $data_category->id }}"> {{ $data_category->name }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="edit_sel_modelo"> Modelo:
                          <span style="color: red;">*</span>
                        </label>
                        <div id="edit_cont_model" class="input-group mb-3">
                          <select edatas="edit_sel_modelo" id="edit_sel_modelo" name="edit_sel_modelo" class="form-control form-control-sm required">
                            <option value="" selected>{{ trans('message.selectopt') }}</option>
                            @forelse ($models as $data_models)
                            <option value="{{ $data_models->id }}"> {{ $data_models->ModeloNombre }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="edit_sel_unit" class="control-label">Unidad de medida:<span style="color: red;">*</span></label>
                          <select id="edit_sel_unit" name="edit_sel_unit" class="form-control form-control-sm required" style="width:100%;">
                            <option value="">{{ trans('message.selectopt') }}</option>
                            @forelse ($unitmeasures as $data_unitmeasures)
                            <option value="{{ $data_unitmeasures->id }}"> {{ $data_unitmeasures->name }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="edit_sel_satserv" class="control-label">Productos/Servicios SAT:<span style="color: red;">*</span></label>
                            <select id="edit_sel_satserv" name="edit_sel_satserv" class="form-control form-control-sm required" style="width:100%;">
                              <option value="">{{ trans('message.selectopt') }}</option>
                              @forelse ($satproduct as $data_satproduct)
                              <option value="{{ $data_satproduct->id }}"> {{ $data_satproduct->name }} </option>
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Fabricante:</label>
                          <input type="text" class="form-control" id="inputEditManufacter" name="inputEditManufacter" placeholder="Nombre del fabricante" maxlength="60">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="edit_sel_estatus"> Estatus:
                          <span style="color: red;">*</span>
                        </label>
                        <div id="edit_cont_estatus" class="input-group mb-3">
                          <select edatas="edit_sel_estatus" id="edit_sel_estatus" name="edit_sel_estatus" class="form-control form-control-sm required">
                            <option value="" selected>{{ trans('message.selectopt') }}</option>
                            @forelse ($estatus as $data_estatus)
                              <option value="{{ $data_estatus->id }}"> {{ $data_estatus->name }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Orden:<span style="color: red;">*</span></label>
                          <input type="text" class="form-control form-control-sm required" id="inputEditOrden" name="inputEditOrden" placeholder="Orden de visualización" value="0" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="status" class="col-sm-3 control-label">Filtrable</label>
                          <div class="col-md-9 mb-3">
                            <input id="editstatus" name="editstatus" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 mt-4">
                      <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.edit') }}</button>
                      <button type="button" class="btn btn-danger waves-effect form_creat_user" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!--Crear  Categoria Modal-->
  <div id="modal-CreatNew-Category" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalcategory" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalbanks">Crear nuevo</h4> <!-- change -->
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="creatcategories" name="creatcategories" class="forms-sample" action=""> <!-- change -->
                {{ csrf_field() }}
                <div class="form-group row">
                  <label for="inputCreatName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatOrden" class="col-sm-3 col-form-label">Orden<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required onlynumber" id="inputCreatOrden" name="inputCreatOrden" placeholder="Orden de visualización" value="0" maxlength="3">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="status" class="col-sm-3 control-label">Estatus</label>
                  <div class="col-md-9 mb-3">
                    <input id="status" name="status" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                <button type="button" class="btn btn-danger waves-effect form_creat_user" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!--Crear Modelo Modal-->
  <div id="modal-CreatNew-Model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalmodleo" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalmodels">Crear nuevo</h4> <!-- change -->
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="creatmodels" name="creatmodels" class="forms-sample" action=""> <!-- change -->
                {{ csrf_field() }}
                <div class="form-group row">
                  <label for="inputCreatName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatCosto" class="col-sm-3 col-form-label">Costo<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="number" step="any" class="form-control form-control-sm required" id="inputCreatCosto" name="inputCreatCosto" placeholder="Costo del modelo" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_onemoneda" class="col-sm-3 col-form-label">Moneda<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_onemoneda" name="select_onemoneda" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($list_moneda as $key => $value)
                        <option value="{{ $value }}"> {{ $value }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_onemarca" class="col-sm-3 col-form-label">Marca<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_onemarca" name="select_onemarca" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($list_marca as $key => $value)
                        <option value="{{ $value }}"> {{ $value }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="select_oneespec" class="col-sm-3 col-form-label">Especificación<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <select  id="select_oneespec" name="select_oneespec" class="form-control form-control-sm required"  style="width: 100%;">
                      <option value="">{{ trans('message.selectopt') }}</option>
                      @forelse ($list_espec as $key => $value)
                        <option value="{{ $value }}"> {{ $value }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatOrden" class="col-sm-3 col-form-label">Orden<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required onlynumber" id="inputCreatOrden" name="inputCreatOrden" placeholder="Orden de visualización" value="0" maxlength="3">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="status" class="col-sm-3 control-label">Estatus</label>
                  <div class="col-md-9 mb-3">
                    <input id="status" name="status" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                <button type="button" class="btn btn-danger waves-effect form_creat_user" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!--Modal Estatus Modal -->
  <div id="modal-CreatNew-Estatus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalstates" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalstates">Crear estado</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <form id="creatstates" name="creatstates" class="forms-sample" action="">
                {{ csrf_field() }}
                <div class="form-group row">
                  <label for="inputCreatName" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required" id="inputCreatName" name="inputCreatName" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputCreatOrden" class="col-sm-3 col-form-label">Orden<span style="color: red;">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm required onlynumber" id="inputCreatOrden" name="inputCreatOrden" placeholder="Orden de visualización" value="0" maxlength="3">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="status" class="col-sm-3 control-label">Estatus</label>
                  <div class="col-md-9 mb-3">
                    <input id="status" name="status" type="checkbox" checked data-toggle="toggle"data-onstyle="primary" data-offstyle="danger" value="1">
                  </div>
                </div>
                <button type="submit" class="btn btn-navy"><i class="far fa-plus-square" style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                <button type="button" class="btn btn-danger waves-effect form_creat_user" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <p class="mt-2 card-title">Esta sección nos permite gestionar los productos, que podremos utilizar en nuestro proyecto.</p>
          <div class="d-flex justify-content-center pt-3"></div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="table_product" name='table_product' class="table table-striped border display nowrap compact-tab" style="width:100%; font-size: 10px;">
                  <thead class="bg-primary">
                    <tr>
                      <th>Nombre</th>
                      <th>Clave</th>
                      <th>Modelo</th>
                      <th>Fabricante</th>
                      <th>Unidad</th>
                      <th>Sat Producto</th>
                      <th>Orden</th>
                      <th>Estatus</th>
                      <th>Filtrable</th>
                      <th>Opciones</th>
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
  </div>
  @else
    @include('default.denied')
  @endif

@endsection

@push('scripts')
  @if( auth()->user()->can('View productossat') )
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <script src="{{ asset('js/admin/catalogs/products.js?v=2.0.0')}}"></script>
  <script src="{{ asset('js/admin/catalogs/modal_products.js?v=2.0.0')}}"></script>
  <script src="{{ asset('js/admin/catalogs/modal_edit_products.js?v=2.0.0')}}"></script>

  <style media="screen">
    #table_product tbody tr td{
      padding: 0.5rem 0.9375rem;
    }

    #table_product thead th{
      width: 100%;
      padding: 0.9rem 0.9rem;
      white-space: pre-line;
    }

    .form-control{
      color:  #535352 !important;
    }

    .select2-selection__rendered {
      line-height: 44px !important;
      padding-left: 20px !important;
    }
    .select2-selection {
      height: 42px !important;
    }
    .select2-selection__arrow {
      height: 36px !important;
    }
    .text-danger {
      font-size: 12px !important;
    }
    #img_preview {
      margin-top: 20px;
      height: 90%;
      width: 90%;
    }
    #edit_img_preview {
      margin-top: 20px;
      height: 90%;
      width: 90%;
    }
    #ads {
        margin: 20px 0 0 0;
    }
    #ads .card-notify-badge {
        position: absolute;
        left: 0px;
        top: -10px;
        background: #f2d900;
        text-align: center;
        border-radius: 30px 30px 30px 30px;
        color: #000;
        padding: 5px 20px;
        font-size: 14px;

    }
    #ads .card-detail-badge {
        background: #f2d900;
        text-align: center;
        border-radius: 30px 30px 30px 30px;
        color: #000;
        padding: 5px 10px;
        font-size: 14px;
    }
    .toggle.btn {
      min-width: 5rem !important;
    }
  </style>
  @else
  @endif
@endpush
