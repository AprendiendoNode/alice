@extends('layouts.app')

@section('contentheader_title')
  @if( auth()->user()->can('View management to products') )
    {{ trans('planning.management_product') }}
  @else
    {{ trans('planning.management_product') }}
  @endif
@endsection

@section('contentheader_description')
  @if( auth()->user()->can('View management to products') )
    {{ trans('planning.subtitle_management_product') }}
  @else
    {{ trans('planning.subtitle_management_product') }}
  @endif
@endsection

@section('breadcrumb_ubication')
  @if( auth()->user()->can('View management to products') )
    {{ trans('planning.breadcrumb_management_product') }}
  @else
    {{ trans('planning.breadcrumb_management_product') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View management to products') )

    <!--Producto------------------------------------------------------------------------------------------------------------------------>
  <div class="modal modal-default fade" id="modal-CreatProduct" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>Nuevo Producto</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="box-body">
                <div class="row">
                  @if( auth()->user()->can('Management to create products') )
                    <form id="creatproductsystem" name="creatproductsystem" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="col-md-6">
                        <div class="row">
                          <div id="ads">
                            <div class="card rounded">
                                <div class="card-image">
                                    <span class="card-notify-badge">Preview</span>
                                    <img id="img_preview" name="img_preview" src="{{ asset('images/hotel/Default.svg') }}" alt="Alternate Text" class="img-responsive"/>
                                </div>
                                <div class="pt-10">
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
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Clave:<span style="color: red;">*</span></label>
                              <input type="text" class="form-control required" id="inputCreatkey" name="inputCreatkey" placeholder="Ingrese una clave">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>No. Parte:<span style="color: red;">*</span></label>
                              <input type="text" class="form-control required" id="inputCreatpart" name="inputCreatpart" placeholder="Ingrese el núm. de parte">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Nombre:<span style="color: red;">*</span></label>
                              <input type="text" class="form-control required" id="inputCreatname" name="inputCreatname" placeholder="Ingrese el nombre">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Precio (Default):<span style="color: red;">*</span></label>
                              <input type="text" class="form-control required" id="inputCreatcoindefault" name="inputCreatcoindefault" placeholder="Ingrese el precio generico" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                          </div>
                        </div>


                      </div>
                      <div class="col-md-12">
                        <div class="row">
                          <!--------------------------------------------------------------------->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="sel_modal_coin" class="control-label">Moneda (Default)<span style="color: red;">*</span></label>
                                <select id="sel_modal_coin" name="sel_modal_coin" class="form-control required" style="width:100%;">
                                  <option value="">{{ trans('message.selectopt') }}</option>
                                  @forelse ($moneda as $data_moneda)
                                  <option value="{{ $data_moneda->id }}"> {{ $data_moneda->moneda }} </option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="sel_modal_proveedor" class="control-label">Proveedor<span style="color: red;">*</span></label>
                                <select id="sel_modal_proveedor" name="sel_modal_proveedor" class="form-control required" style="width:100%;">
                                  <option value="">{{ trans('message.selectopt') }}</option>
                                  @forelse ($proveedores as $data_proveedores)
                                  <option value="{{ $data_proveedores->id }}"> {{ $data_proveedores->proveedor }} </option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="sel_categoria"> Categoria:
                              <span style="color: red;">*</span>
                            </label>
                            <div id="cont_category" class="input-group">
                              <select datas="sel_categoria" id="sel_categoria" name="sel_categoria" class="form-control required" style="width:100%;">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                                @forelse ($categorias as $data_categorias)
                                <option value="{{ $data_categorias->id }}"> {{ $data_categorias->categoria }} </option>
                                @empty
                                @endforelse
                              </select>
                              <span class="input-group-btn">
                                <button class="btn btn-primary addcategorias" type="button"><i class="fa fa-plus"></i></button>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <label for="sel_modelo"> Modelo:
                              <span style="color: red;">*</span>
                            </label>
                            <div id="cont_model" class="input-group">
                              <select datas="sel_modelo" id="sel_modelo" name="sel_modelo" class="form-control required" style="width:100%;">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                                @forelse ($modelos as $data_modelos)
                                <option value="{{ $data_modelos->id }}"> {{ $data_modelos->modelo }} </option>
                                @empty
                                @endforelse
                              </select>
                              <span class="input-group-btn">
                                <button class="btn btn-primary addmodel" type="button"><i class="fa fa-plus"></i></button>
                              </span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="sel_estatus"> Estatus:
                              <span style="color: red;">*</span>
                            </label>
                            <div id="cont_estatus" class="input-group">
                              <select datas="sel_estatus"  id="sel_estatus" name="sel_estatus" class="form-control required" style="width:100%;">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                                @forelse ($estatus as $data_estatus)
                                <option value="{{ $data_estatus->id }}"> {{ $data_estatus->status }} </option>
                                @empty
                                @endforelse
                              </select>
                              <span class="input-group-btn">
                                <button class="btn btn-primary addstatus" type="button"><i class="fa fa-plus"></i></button>
                              </span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="pt-25">
                              @if( auth()->user()->can('Management to create products') )
                              <button type="submit" class="btn bg-navy"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button>
                              @endif
                              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                            </div>
                          </div>
                          <!--------------------------------------------------------------------->
                        </div>
                      </div>
                    </form>
                  @else
                    <div class="col-xs-12">
                      @include('default.deniedmodule')
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
  </div>

  <!--MODELO------------------------------------------------------------------------------------------------------------------------>
  <div class="modal modal-default fade" id="modal-CreatModelo" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>Nuevo Modelo</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="box-body">
                <div class="row">
                  <div class="row">
                  @if( auth()->user()->can('Management to create products') )
                    <form id="creatmodelsystem" name="creatmodelsystem" action="">
                      {{ csrf_field() }}
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sel_modal_marca" class="control-label">Marca<span style="color: red;">*</span></label>
                            <select id="sel_modal_marca" name="sel_modal_marca" class="form-control" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($marcas as $data_marcas)
                              <option value="{{ $data_marcas->id }}"> {{ $data_marcas->marca }} </option>
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sel_modal_especification" class="control-label">Especifique<span style="color: red;">*</span></label>
                            <select id="sel_modal_especification" name="sel_modal_especification" class="form-control" style="width:100%;">
                              <option value="" selected>{{ trans('pay.select_op') }}</option>
                              @forelse ($especificaciones as $data_especificaciones)
                              <option value="{{ $data_especificaciones->id }}"> {{ $data_especificaciones->equipo }} </option>
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Nombre del modelo:<span style="color: red;">*</span></label>
                          <input type="text" class="form-control required" id="inputCreatModel" name="inputCreatModel" placeholder="Ingrese un modelo">
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="pull-right">
                          @if( auth()->user()->can('Management to create products') )
                            <button type="submit" class="btn bg-navy"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button>
                          @endif
                          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                        </div>
                      </div>
                    </form>
                  @else
                    <div class="col-xs-12">
                      @include('default.deniedmodule')
                    </div>
                  @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
  </div>

  <!--MARCA------------------------------------------------------------------------------------------------------------------------>
  <div class="modal modal-default fade" id="modal-CreatMarca" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>Nueva Marca</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="box-body">
                <div class="row">
                  @if( auth()->user()->can('Management to create products') )
                  <form id="creatmodelmarca" name="creatmodelmarca" class="form-horizontal"  action="">
                    {{ csrf_field() }}
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Nombre de la marca<span style="color: red;">*</span></label>
                        <input type="text" class="form-control required" id="inputCreatMarca" name="inputCreatMarca" placeholder="Ingrese una marca">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Distribuidor<span style="color: red;">*</span></label>
                        <input type="text" class="form-control required" id="inputCreatDistribuidor" name="inputCreatDistribuidor" placeholder="Ingrese una marca">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="pull-right">
                        @if( auth()->user()->can('Management to create products') )
                          <button type="submit" class="btn bg-navy"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button>
                        @endif
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                      </div>
                    </div>
                  </form>
                  @else
                    <div class="col-xs-12">
                      @include('default.deniedmodule')
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
  </div>

  <!--Categoria------------------------------------------------------------------------------------------------------------------->
  <div class="modal modal-default fade" id="modal-CreatCategory" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>Nueva Categoria</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="box-body">
                <div class="row">
                  <div class="row">
                  @if( auth()->user()->can('Management to create products') )
                    <form id="creatcategorysystem" name="creatcategorysystem" action="">
                      {{ csrf_field() }}
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Nombre de la categoria<span style="color: red;">*</span></label>
                          <input type="text" class="form-control required" id="inputCreatCategory" name="inputCreatCategory" placeholder="Ingrese una categoria">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="pull-right">
                          @if( auth()->user()->can('Management to create products') )
                            <button type="submit" class="btn bg-navy"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button>
                          @endif
                          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                        </div>
                      </div>
                    </form>
                  @else
                    <div class="col-xs-12">
                      @include('default.deniedmodule')
                    </div>
                  @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
  </div>

  <!--Estatus------------------------------------------------------------------------------------------------------------------->
  <div class="modal modal-default fade" id="modal-CreatStatus" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>Nuevo Estatus</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="box-body">
                <div class="row">
                  <div class="row">
                  @if( auth()->user()->can('Management to create products') )
                    <form id="creatstatussystem" name="creatstatussystem" action="">
                      {{ csrf_field() }}
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Nombre del estatus:<span style="color: red;">*</span></label>
                          <input type="text" class="form-control required" id="inputCreatStatus" name="inputCreatStatus" placeholder="Ingrese un estatus">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="pull-right">
                          @if( auth()->user()->can('Management to create products') )
                            <button type="submit" class="btn bg-navy"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button>
                          @endif
                          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                        </div>
                      </div>
                    </form>
                  @else
                    <div class="col-xs-12">
                      @include('default.deniedmodule')
                    </div>
                  @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
  </div>

  <!--Editar --------------------------------------------------------------------------------------------------------------------->
  <div class="modal modal-default fade" id="modal-Editprod" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>Editar Producto</h4>
          </div>
          <div class="modal-body">
            <div class="box-body">
              <div class="box-body">
                <div class="row">
                  @if( auth()->user()->can('Management to create products') )
                    <form id="editproductsystem" name="editproductsystem" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <input id="fsd" name="fsd" type="hidden" class="form-control">

                      <div class="col-md-6">
                        <div class="row">
                          <div id="ads">
                            <div class="card rounded">
                                <div class="card-image">
                                    <span class="card-notify-badge">Preview</span>
                                    <img id="edit_img_preview" name="edit_img_preview" src="{{ asset('images/hotel/Default.svg') }}" alt="Alternate Text" class="img-responsive"/>
                                </div>
                                <div class="pt-10">
                                    <div class="form-group">
                                        <div id="edit_cont_file" class="">
                                            <div class="input-group">
                                              <label class="input-group-btn">
                                                <span class="btn btn-primary">
                                                    Imagen <input id="editfileInput" name="editfileInput" type="file" style="display: none;" class="">
                                                </span>
                                              </label>
                                              <input type="text" class="form-control dodoo" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Clave:<span style="color: red;">*</span></label>
                              <input type="text" class="form-control required" id="inputEditkey" name="inputEditkey" placeholder="Ingrese una clave">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>No. Parte:<span style="color: red;">*</span></label>
                              <input type="text" class="form-control required" id="inputEditpart" name="inputEditpart" placeholder="Ingrese el núm. de parte">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Nombre:<span style="color: red;">*</span></label>
                              <input type="text" class="form-control required" id="inputEditname" name="inputEditname" placeholder="Ingrese el nombre">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Precio (Default):<span style="color: red;">*</span></label>
                              <input type="text" class="form-control required" id="inputEditcoindefault" name="inputEditcoindefault" placeholder="Ingrese el precio generico" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                          </div>
                        </div>


                      </div>
                      <div class="col-md-12">
                        <div class="row">
                          <!--------------------------------------------------------------------->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="editsel_modal_coin" class="control-label">Moneda (Default)<span style="color: red;">*</span></label>
                                <select id="editsel_modal_coin" name="editsel_modal_coin" class="form-control required" style="width:100%;">
                                  <option value="">{{ trans('message.selectopt') }}</option>
                                  @forelse ($moneda as $data_moneda)
                                  <option value="{{ $data_moneda->id }}"> {{ $data_moneda->moneda }} </option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="editsel_modal_proveedor" class="control-label">Proveedor<span style="color: red;">*</span></label>
                                <select id="editsel_modal_proveedor" name="editsel_modal_proveedor" class="form-control required" style="width:100%;">
                                  <option value="">{{ trans('message.selectopt') }}</option>
                                  @forelse ($proveedores as $data_proveedores)
                                  <option value="{{ $data_proveedores->id }}"> {{ $data_proveedores->proveedor }} </option>
                                  @empty
                                  @endforelse
                                </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="edit_sel_categoria"> Categoria:
                              <span style="color: red;">*</span>
                            </label>
                            <div id="edit_cont_category" class="input-group">
                              <select edatas="edit_sel_categoria" id="edit_sel_categoria" name="edit_sel_categoria" class="form-control required" style="width:100%;">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                                @forelse ($categorias as $data_categorias)
                                <option value="{{ $data_categorias->id }}"> {{ $data_categorias->categoria }} </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <label for="edit_sel_modelo"> Modelo:
                              <span style="color: red;">*</span>
                            </label>
                            <div id="edit_cont_model" class="input-group">
                              <select edatas="edit_sel_modelo" id="edit_sel_modelo" name="edit_sel_modelo" class="form-control required" style="width:100%;">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                                @forelse ($modelos as $data_modelos)
                                <option value="{{ $data_modelos->id }}"> {{ $data_modelos->modelo }} </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="edit_sel_estatus"> Estatus:
                              <span style="color: red;">*</span>
                            </label>
                            <div id="edit_cont_estatus" class="input-group">
                              <select edatas="edit_sel_estatus"  id="edit_sel_estatus" name="edit_sel_estatus" class="form-control required" style="width:100%;">
                                <option value="" selected>{{ trans('pay.select_op') }}</option>
                                @forelse ($estatus as $data_estatus)
                                <option value="{{ $data_estatus->id }}"> {{ $data_estatus->status }} </option>
                                @empty
                                @endforelse
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="pt-25">
                              @if( auth()->user()->can('Management to create products') )
                              <button type="submit" class="btn bg-navy"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.actualizar') }}</button>
                              @endif
                              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                            </div>
                          </div>
                          <!--------------------------------------------------------------------->
                        </div>
                      </div>
                    </form>
                  @else
                    <div class="col-xs-12">
                      @include('default.deniedmodule')
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
  </div>
  <!----------------------------------------------------------------------------------------------------------------------------->

  <div class="container">
      <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="box box-solid">
              <div class="box-header with-border">
                <i class="fa fa-search"></i>
                <h3 class="box-title">{{ trans('planning.searchproducts')}}</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                      <table id="table_manag_products" name='table_manag_products' class="display nowrap table table-bordered table-hover" width="100%" cellspacing="0">
                        <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
                        <thead>
                            <tr class="bg-primary" style="background: #789F8A; font-size: 11.5px; ">
                                <th> <small>{{ trans('planning.productclave')}}</small> </th>
                                <th> <small>{{ trans('planning.productmodel')}}</small> </th>
                                <th> <small>{{ trans('planning.productname')}}</small> </th>
                                <th> <small>{{ trans('planning.productcategory')}}</small> </th>
                                <th> <small>{{ trans('planning.productproveedor')}}</small> </th>
                                <th> <small>{{ trans('planning.productcoin')}}</small> </th>
                                <th> <small>{{ trans('planning.productMoneda')}}</small> </th>
                                <th> <small>{{ trans('planning.productstatus')}}</small> </th>
                                <th> <small>{{ trans('planning.productactions')}}</small> </th>
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
  </div>

  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View management to products') )
  <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
  <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>
  <!-- FormValidation -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-3-right-offset.css')}}" >
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extras-margins-padding.css')}}" >
  <script src="{{ asset('js/admin/planning/planning.js')}}"></script>
  <script src="{{ asset('js/admin/planning/modal_product.js?v=1.0.2')}}"></script>
  <script src="{{ asset('js/admin/planning/modal_marca.js')}}"></script>
  <script src="{{ asset('js/admin/planning/modal_categoria.js')}}"></script>
  <script src="{{ asset('js/admin/planning/modal_modelo.js')}}"></script>
  <script src="{{ asset('js/admin/planning/modal_edit_product.js?v=1.0.1')}}"></script>


  <style media="screen">
  .error {
      color: #f62d51;;
  }
  .text-danger {
      color: #f62d51;;
  }
    /* Category Ads */
    #ads {
        margin: 30px 0 0 0;

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
  </style>
  <script type="text/javascript">
    $(function() {
      // We can attach the `fileselect` event to all file inputs on the page
      $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
      });
      // We can watch for our custom `fileselect` event like this
      $(document).ready( function() {
          $(':file').on('fileselect', function(event, numFiles, label) {

              var input = $(this).parents('.input-group').find(':text'),
                  log = numFiles > 1 ? numFiles + ' files selected' : label;

              if( input.length ) {
                  input.val(log);
              } else {
                  if( log ) alert(log);
              }

          });
      });
    });
    $("#fileInput").change(function () {
        filePreview(this);
    });

    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var result=e.target.result;
                $('#img_preview').attr("src",result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }


    $("#editfileInput").change(function () {
        editfilePreview(this);
    });

    function editfilePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var result=e.target.result;
                $('#edit_img_preview').attr("src",result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

  </script>
  @else
  @endif
@endpush
