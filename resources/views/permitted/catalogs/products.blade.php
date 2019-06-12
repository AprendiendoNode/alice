@extends('layouts.admin')

@section('contentheader_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.productossat') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('breadcrumb_title')
  {{-- @if( auth()->user()->can('View cover') ) --}}
    {{ trans('invoicing.productossat') }}
  {{-- @else --}}
  {{-- {{ trans('message.denied') }} --}}
  {{-- @endif --}}
@endsection

@section('content')
  {{-- @if( auth()->user()->can('View cover') ) --}}
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
              <form id="creatproducts" name="creatproducts" class="forms-sample" action="">
                {{ csrf_field() }}
                <div class="row">
                  <div class="col-md-6">
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
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Clave:<span style="color: red;">*</span></label>
                          <input type="text" class="form-control required" id="inputCreatkey" name="inputCreatkey" placeholder="Ingrese una clave"oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
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
                  <div class="col-md-12 mt-4">
                    <div class="form-group">
                      <label for="comment">Comentario:</label>
                      <input type="password" class="form-control" id="comment">
                    </div>
                  </div>
                  <div class="col-md-12 mt-4">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sel_modal_coin" class="control-label">Moneda (Default)<span style="color: red;">*</span></label>
                            <select id="sel_modal_coin" name="sel_modal_coin" class="form-control required" style="width:100%;">
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
                            <select id="sel_modal_proveedor" name="sel_modal_proveedor" class="form-control required" style="width:100%;">
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
                          <select datas="sel_categoria" id="sel_categoria" name="sel_categoria" class="form-control required">
                            <option value="" selected>{{ trans('message.selectopt') }}</option>
                            @forelse ($category as $data_category)
                            <option value="{{ $data_category->id }}"> {{ $data_category->name }} </option>
                            @empty
                            @endforelse
                          </select>
                          <div class="input-group-append">
                            <button class="btn btn-primary addcategorias" type="button"><i class="fa fa-plus"></i></button>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="sel_modelo"> Modelo:
                          <span style="color: red;">*</span>
                        </label>
                        <div id="cont_model" class="input-group mb-3">
                          <select datas="sel_modelo" id="sel_modelo" name="sel_modelo" class="form-control required">
                            <option value="" selected>{{ trans('message.selectopt') }}</option>
                            @forelse ($models as $data_models)
                            <option value="{{ $data_models->id }}"> {{ $data_models->ModeloNombre }} </option>
                            @empty
                            @endforelse
                          </select>
                          <div class="input-group-append">
                            <button class="btn btn-primary addmodel" type="button"><i class="fa fa-plus"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="sel_unit"> Unidad de medida:
                          <span style="color: red;">*</span>
                        </label>
                        <div id="cont_unit" class="input-group mb-3">
                          <select datas="sel_unit" id="sel_unit" name="sel_unit" class="form-control required">
                            <option value="" selected>{{ trans('message.selectopt') }}</option>
                            @forelse ($unitmeasures as $data_unitmeasures)
                            <option value="{{ $data_unitmeasures->id }}"> {{ $data_unitmeasures->name }} </option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="sel_satserv"> Productos/Servicios SAT:
                          <span style="color: red;">*</span>
                        </label>
                        <div id="cont_satserv" class="input-group mb-3">
                          <select datas="sel_satserv" id="sel_satserv" name="sel_satserv" class="form-control required">
                            <option value="" selected>{{ trans('message.selectopt') }}</option>
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
                        <label for="sel_estatus"> Estatus:
                          <span style="color: red;">*</span>
                        </label>
                        <div id="cont_estatus" class="input-group mb-3">
                          <select datas="sel_estatus" id="sel_estatus" name="sel_estatus" class="form-control required">
                            <option value="" selected>{{ trans('message.selectopt') }}</option>
                          </select>
                          <div class="input-group-append">
                            <button class="btn btn-primary addstatus" type="button"><i class="fa fa-plus"></i></button>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="status" class="col-sm-3 control-label">Activo</label>
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

  <div class="row">
    <div class="col-md-12 grid-margin-onerem  stretch-card">
      <div class="card">
        <div class="card-body">
          <p class="mt-2 card-title">Esta sección nos permite gestionar los productos, que podremos utilizar en nuestro proyecto.</p>
          <div class="d-flex justify-content-center pt-3"></div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="table_product" name='table_product' class="table table-striped border display nowrap" style="width:100%; font-size: 10px;">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Clave</th>
                      <th>Modelo</th>
                      <th>Fabricante</th>
                      <th>Unidad de medida</th>
                      <th>Sat Producto</th>
                      <th>Order</th>
                      <th>Estatus</th>
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
  {{-- @else --}}
  {{-- @endif --}}
@endsection

@push('scripts')
  {{-- @if( auth()->user()->can('View cover') ) --}}
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

  <script src="{{ asset('js/admin/catalogs/products.js')}}"></script>

  <style media="screen">
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
    #img_preview {
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
  {{-- @else --}}
  {{-- @endif  --}}
@endpush
