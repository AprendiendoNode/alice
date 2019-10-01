@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View add equipment') )
    {{ trans('message.title_equipment') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View add equipment') )
    {{ trans('message.breadcrumb_add_equipment') }}
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
    @if( auth()->user()->can('View add equipment') )
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
           <h4 class="text-center">Añadir equipo individual</h4>
          <div class="card">
            <div class="card-body">
              <div class="form-inline">
                 {{ csrf_field() }}
                 <div class="form-group">
                   <div class="col-sm-12">
                      <label class="control-label d-inline p-2">¿{{ trans('general.cuenta_con_factura') }}?</label>
                      <label class="radio-inline d-inline p-2"> <input type="radio" name="facturitha" id="yes" value="yes" class="flat-red"> Si </label>
                      <label class="radio-inline d-inline p-2"> <input type="radio" name="facturitha" id="no" value="no" class="flat-red"> No </label>
                   </div>
                 </div>
              </div>
            </div>
          </div>
        </div>

        <div class=" ocultar data_fact pt-3">
          <div class="card">
            <div class="card-body">
              <div class="form-inline">
                 {{ csrf_field() }}
                 <div class="row">
                   <div class="col-md-2 p-1">
                     <div class="form-group" >
                       <label for="nfactura">{{ trans('general.factura') }}:</label>
                       <input type="text" class="form-control input-sm" id="nfactura" name="nfactura" maxlength="25" placeholder="Mínimo 8 caracteres" style="width:90%">
                     </div>
                   </div>
                   <div class="col-md-2 p-1">
                     <div class="form-group">
                       <label for="order">{{ trans('general.orden') }}:</label>
                       <input type="text" class="form-control" id="order" name="order" maxlength="20" style="width:90%">
                     </div>
                   </div>
                   <div class="col-md-2 p-1">
                     <div class="form-group">
                       <label for="date_fact">{{ trans('general.fecha_factura') }}:</label>
                       <input type="text" class="form-control" id="date_fact" name="date_fact" maxlength="10" style="width:90%" >
                     </div>
                   </div>
                   <div class="col-md-4 p-1">
                     <div class="form-group">
                       <label for="select_one" class="control-label">{{ trans('message.title_provider') }}: </label>
                       <select id="select_one" name="select_one"  class="form-control select2" required>
                         <option value="" selected> Elija </option>
                         @forelse ($proveedores as $data_proveedores)
                           <option value="{{ $data_proveedores->id }}"> {{ $data_proveedores->nombre }} </option>
                         @empty
                         @endforelse
                       </select>
                     </div>
                   </div>
                   <div class="col-md-2 p-1">
                     <label for="" class="d-block">{{ trans('general.nuevo_prov') }}</label>
                     <button type="button" class="btn btn-sm btn-success p-2" data-toggle="modal" data-target="#add_provider" style="width:90%">
                       <i class="fa fa-plus-square margin-r5"></i>
                     </button>
                   </div>
                 </div>

              </div>
            </div>
          </div>
        </div>
        <!--Formulario equipo individual-->
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 ocultar data_equipament pt-3">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal" id='add_equipitho'>
                 {{ csrf_field() }}
                 <div class="input-group row">
                   <div class="col-md-1">
                      <span class="input-group-addon">{{ trans('general.mac') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                   </div>
                   <div class="col-md-11">
                  <input id="add_mac_eq" name="add_mac_eq" type="text" class="form-control " maxlength="17" placeholder="MAC. Mínimo 15 caracteres">
                   </div>
                 </div>
                 <br>

                 <div class="input-group row">
                   <div class="col-md-1">
                  <span class="input-group-addon">{{ trans('general.num_serie') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                   </div>
                   <div class="col-md-11">
                     <input id="add_num_se"  name="add_num_se"  type="text" class="form-control" placeholder="Núm. Serie. Mínimo 10 caracteres" maxlength="25">
                   </div>
                 </div>
                 <br>

                 <div class="row">
                   <div class="col-lg-6 col-md-6">
                     <div class="input-group row">
                       <div class="col-md-2">
                      <span class="input-group-addon">{{ trans('general.grupo') }}</span>
                       </div>
                       <div class="col-md-9">
                         <select class="form-control select2" id="grupitho" name="grupitho" >
                           <option value="" selected> Elija </option>
                           @forelse ($groups as $data_groups)
                             <option value="{{ $data_groups->id }}"> {{ $data_groups->name }} </option>
                           @empty
                           @endforelse
                         </select>
                         <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#add_grupo_1">
                           <i class="fa fa-plus-square"></i>
                         </button>
                       </div>
                       <div class="col-md-1">

                       </div>

                     </div>
                   </div>
                   <div class="col-lg-6 col-md-6">
                     <div class="input-group row">
                       <div class="col-md-3">
                       <span class="input-group-addon">{{ trans('general.descripcion') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                       </div>
                      <div class="col-md-9">
                      <input id="add_descrip" name="add_descrip" maxlength="150" type="text" class="form-control" placeholder="Descripción. Mínimo 4 caracteres.">
                      </div>
                     </div>
                   </div>
                 </div>
                 <br>

                 <div class="row">
                   <div class="col-lg-6">
                     <div class="input-group row">
                       <div class="col-md-4">
                      <span class="input-group-addon">{{ trans('general.tipo_equipo') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                       </div>
                       <div class="col-md-8">
                         <select class="form-control select2" id="type_equipment" name="type_equipment">
                           <option value="" selected> Elija </option>
                           @forelse ($especificaciones as $data_especificaciones)
                             <option value="{{ $data_especificaciones->id }}"> {{ $data_especificaciones->name }} </option>
                           @empty
                           @endforelse
                         </select>
                       </div>
                     </div>
                   </div>
                   <div class="col-lg-6">
                     <div class="input-group row">
                       <div class="col-md-3">
                      <span class="input-group-addon">{{ trans('general.marca') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                       </div>
                       <div class="col-md-8">
                         <select class="form-control select2" id="Marcas" name="Marcas">
                           <option value="" selected> Elija </option>
                         </select>
                         <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#add_marca_4">
                           <i class="fa fa-plus-square"></i>
                         </button>
                       </div>
                       <div class="col-md-1">

                       </div>
                     </div>
                   </div>
                 </div>
                 <br>

                 <div class="row">
                   <div class="col-lg-6">
                     <div class="input-group row">
                       <div class="col-md-3">
                      <span class="input-group-addon">{{ trans('general.modelo') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                       </div>
                       <div class="col-md-8">
                         <select class="form-control select2" id="mmodelo" name="mmodelo">
                           <option value="" selected> Elija </option>
                         </select>
                         <button type="button" class="btn btn-warning btn-sm btn_rmd" data-toggle="modal" data-target="#add_modelo">
                           <i class="fa fa-plus-square"></i>
                         </button>
                       </div>
                       <div class="col-md-1">

                       </div>
                     </div>
                   </div>
                   <div class="col-lg-6">
                     <div class="input-group row">
                       <div class="col-md-3">
                      <span class="input-group-addon">{{ trans('general.estado') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                       </div>
                       <div class="col-md-9">
                         <select class="form-control select2" id="add_estado" name="add_estado">
                           <option value="" selected> Elija </option>
                           @forelse ($estados as $data_estados)
                             <option value="{{ $data_estados->id }}"> {{ $data_estados->Nombre_estado }} </option>
                           @empty
                           @endforelse
                         </select>
                       </div>
                     </div>
                   </div>
                 </div>
                 <br>

                 <div class="row">
                   <div class="col-lg-6">
                     <div class="input-group row">
                       <div class="col-md-2">
                      <span class="input-group-addon">{{ trans('general.hotel') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                       </div>
                       <div class="col-md-10">
                         <select class="form-control select2" id="venue" name="venue">
                           <option value="" selected> Elija </option>
                           @forelse ($hotels as $data_hotel)
                             <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                           @empty
                           @endforelse
                         </select>
                       </div>
                     </div>
                   </div>
                   <div class="col-lg-6 priceadd">
                     <div class="input-group">
                       <span class="input-group-addon ">Precio (S/IVA) <i class="glyphicon glyphicon-asteris text-danger">(*)</i></span>
                       <div id="cont_tp" class="input-group row">

                           <div class="col-md-6">
                           <input type="text" class="form-control d-inline" id="precio" name="precio" placeholder="Precio (S/IVA)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:90%"/>
                           </div>
                           <div class="col-md-6">
                             <select datas="tp_forma" class="form-control d-inline" id="coinmonto" name="coinmonto" style="width:90%">
                               <option value="" selected>{{ trans('pay.select_op') }} la moneda</option>
                               @forelse ($currency as $data_currency)
                               <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                               @empty
                               @endforelse
                             </select>
                           </div>
                       </div>
                     </div>
                   </div>

                  <div class="col-lg-6">
                    <div class="btn-group">
                       <button type="button" class="btn  btn-sm btn-primary btn-save"><i class="fa fa-save"></i> {{ trans('general.guardar') }}</button>
                       <button type="button" class="btn btn-sm btn-default btn-clear"><i class="fa fa-eraser"></i> {{ trans('general.limpiar') }}</button>
                       <button type="button" class="btn btn-sm btn-danger btn-cancel"><i class="fa fa-times"></i> {{ trans('general.cancelar') }}</button>
                    </div>
                  </div>
                </div>



                 <br>
              </form>
            </div>
          </div>
        </div>
        <!--Tabla equipo individual-->
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 ocultar data_temporal">
          <div class="table-responsive">
            <table id="table_temporality" name='table_temporality' class="table table-bordered table-hover" width="100%" cellspacing="0">
              <thead class="bg-primary text-white">
                <tr class="bg-primary">
                  <th> <small>{{ trans('general.hotel') }}</small> </th>
                  <th> <small>{{ trans('general.equipo') }}.</small> </th>
                  <th> <small>{{ trans('general.marca') }}.</small> </th>
                  <th> <small>{{ trans('general.mac') }}.</small> </th>
                  <th> <small>{{ trans('general.serie') }}.</small> </th>
                  <th> <small>{{ trans('general.grupo') }}.</small> </th>
                  <th> <small>{{ trans('general.descripcion') }}.</small> </th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>



<div class="container">
  <div class="row  p-2">
<!--titulo-->
<div class="col-md-12 col-sm-12">
  <h4 class="text-center">Carga Masiva de equipos</h4>
</div>
<!--Factura si o no-->
</div>
<div class="row">
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-body">
        <div class="form-inline">
           {{ csrf_field() }}
           <div class="form-group">
             <div class="col-sm-12">

                <label class="control-label d-inline p-2">¿{{ trans('general.cuenta_con_factura') }}?</label>
                <label class="radio-inline d-inline p-2"> <input type="radio" name="factura_masiva" id="yes" value="yes" class="flat-red"> Si </label>
                <label class="radio-inline d-inline p-2"> <input type="radio" name="factura_masiva" id="no" value="no" class="flat-red"> No </label>
             </div>
           </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 ocultar data_fact_masiva">
    <div class="card">
      <div class="card-body">
        <div class="form-inline row">
           {{ csrf_field() }}
           <div class="col-md-2 p-1">
             <div class="form-group">
               <label for="nfactura_masiva">{{ trans('general.factura') }}:</label>
               <input type="text" class="form-control" id="nfactura_masiva" name="nfactura_masiva" maxlength="25" placeholder="Mínimo 8 caracteres" style="width:90%">
             </div>
           </div>
           <div class="col-md-2 p-1">
             <div class="form-group">
               <label for="order_massive">{{ trans('general.orden') }}:</label>
               <input type="text" class="form-control" id="order_massive" name="order_massive" maxlength="20" style="width:90%">
             </div>
           </div>
           <div class="col-md-2 p-1">
             <div class="form-group">
               <label for="date_fact_masiva">{{ trans('general.fecha_factura') }}:</label>
               <input type="text" class="form-control" id="date_fact_masiva" name="date_fact_masiva" maxlength="10" style="width:90%">
             </div>
           </div>
           <div class="col-md-4 p-1 ">
             <div class="form-group">
               <label for="select_one_massive" class="control-label">{{ trans('message.title_provider') }}: </label>
               <select id="select_one_massive" name="select_one_massive"  class="form-control select2" required style="width:100%; overflow-x:hidden;">
                 <option value="" selected> Elija </option>
                 @forelse ($proveedores as $data_proveedores)
                   <option value="{{ $data_proveedores->id }}"> {{ $data_proveedores->nombre }} </option>
                 @empty
                 @endforelse
               </select>
             </div>
           </div>
           <div class="col-md-2 p-1">
             <label for="">{{ trans('general.nuevo_prov') }}</label>
             <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#add_provider" style="width:90%">
               <i class="fa fa-plus-square margin-r5"></i>
             </button>
           </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!--Boton carga masiva desde excel-->
  <div class="row">
<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

      <div class="form-inline">
        <div class="col-md-10">
          <div class="input-group" id="file_upload_excel">
              <label class="input-group-btn">
                  <span class="btn btn-success">
                      <i class="fa fa-file-excel-o"></i>  Subir plantilla Excel
                      <input id="file_excel" name="file_excel" type="file" style="display: none;">
                  </span>
                </label>
              <input type="text" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-2">
            <a class="btn btn-primary"  href="formats/excel/EjemploAltasEquipos.xlsx" download>Descargar plantilla vacia</a>
          </div>
      </div>
    </div>
</div>

<!--Datos generales carga masiva-->

    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 ">
        <div class="card">
          <div class="card-body">
            <form class="form-horizontal" id='add_equipo_masivo'>
               {{ csrf_field() }}
               <br>
               <br>

               <div class="row">
                 <div class="col-lg-6">
                   <div class="input-group row">
                     <div class="col-md-2">
                     <span class="input-group-addon">{{ trans('general.grupo') }}</span>
                     </div>
                     <div class="col-md-9">
                       <select class="form-control select2" id="grupo_masivo" name="grupo_masivo">
                         <option value="" selected> Elija </option>
                         @forelse ($groups as $data_groups)
                           <option value="{{ $data_groups->id }}"> {{ $data_groups->name }} </option>
                         @empty
                         @endforelse
                       </select>
                       <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#add_grupo_1">
                         <i class="fa fa-plus-square"></i>
                       </button>
                     </div>
                   </div>
                 </div>
                 <div class="col-lg-6">
                   <div class="input-group row">
                     <div class="col-md-3">
                    <span class="input-group-addon">{{ trans('general.descripcion') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                     </div>
                     <div class="col-md-9">
                    <input id="add_descrip_masiva" name="add_descrip_masiva" maxlength="150" type="text" class="form-control" placeholder="Descripción. Mínimo 4 caracteres.">
                     </div>
                   </div>
                 </div>
               </div>
               <br>

               <div class="row">
                 <div class="col-lg-6">
                   <div class="input-group row">
                     <div class="col-md-4">
                    <span class="input-group-addon">{{ trans('general.tipo_equipo') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                     </div>
                     <div class="col-md-8">
                       <select class="form-control select2" id="type_equipment_massive" name="type_equipment_massive">
                         <option value="" selected> Elija </option>
                         @forelse ($especificaciones as $data_especificaciones)
                           <option value="{{ $data_especificaciones->id }}"> {{ $data_especificaciones->name }} </option>
                         @empty
                         @endforelse
                       </select>
                     </div>
                   </div>
                 </div>
                 <div class="col-lg-6">
                   <div class="input-group row">
                     <div class="col-md-3">
                        <span class="input-group-addon">{{ trans('general.marca') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                     </div>
                     <div class="col-md-8">
                       <select class="form-control select2" id="Marcas_masiva" name="Marcas_masiva">
                         <option value="" selected> Elija </option>

                       </select>
                       <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#add_marca_4">
                         <i class="fa fa-plus-square"></i>
                       </button>
                     </div>

                   </div>
                 </div>
               </div>
               <br>

               <div class="row">
                 <div class="col-lg-6">
                   <div class="input-group row">
                     <div class="col-md-3">
                    <span class="input-group-addon">{{ trans('general.modelo') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                     </div>
                     <div class="col-md-8">
                       <select class="form-control select2" id="mmodelo_masivo" name="mmodelo_masivo">
                         <option value="" selected> Elija </option>

                       </select>
                       <button type="button" class="btn btn-warning btn-sm btn_rmd" data-toggle="modal" data-target="#add_modelo">
                         <i class="fa fa-plus-square"></i>
                       </button>
                     </div>

                   </div>
                 </div>
                 <div class="col-lg-6">
                   <div class="input-group row">
                     <div class="col-md-3">
                        <span class="input-group-addon">{{ trans('general.estado') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                     </div>
                     <div class="col-md-8">
                       <select class="form-control select2" id="add_estado_masivo" name="add_estado_masivo">
                         <option value="" selected> Elija </option>
                         @forelse ($estados as $data_estados)
                           <option value="{{ $data_estados->id }}"> {{ $data_estados->Nombre_estado }} </option>
                         @empty
                         @endforelse
                       </select>
                     </div>
                   </div>
                 </div>
               </div>
               <br>

               <div class="row">
                 <div class="col-lg-6">
                   <div class="input-group row">
                     <div class="col-md-2">
                       <span class="input-group-addon">{{ trans('general.hotel') }} <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                     </div>
                     <div class="col-md-8">
                       <select class="form-control select2" id="venue_massive" name="venue_massive">
                         <option value="" selected> Elija </option>
                         @forelse ($hotels as $data_hotel)
                           <option value="{{ $data_hotel->id }}"> {{ $data_hotel->Nombre_hotel }} </option>
                         @empty
                         @endforelse
                       </select>
                     </div>
                   </div>
                 </div>
                 <div class="col-lg-6 priceadd_massive">
                   <div class="input-group">
                     <span class="input-group-addon">Precio (S/IVA) <i class="glyphicon glyphicon-asteris text-danger">(*)</i></span>
                     <div id="cont_tp" class="input-group row">
                       <div class="col-md-6">
                          <input type="text" class="form-control" id="precio_masivo" name="precio_masivo" placeholder="Precio (S/IVA)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:90%;"/>
                       </div>

                       <div class="col-md-6">
                           <select datas="tp_forma" class="form-control" id="coinmonto_masivo" name="coinmonto_masivo" style="width:90%">
                             <option value="" selected>{{ trans('pay.select_op') }} la moneda</option>
                             @forelse ($currency as $data_currency)
                             <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                             @empty
                             @endforelse
                           </select>
                       </div>

                     </div>
                   </div>
                 </div>

                <div class="col-lg-6">
                  <div class="btn-group">
                     <button type="button" class="btn btn-sm btn-primary btn-save-massive"><i class="fa fa-save"></i> {{ trans('general.guardar') }}</button>
                     <button type="button" class="btn btn-sm btn-default btn-clear-massive"><i class="fa fa-eraser"></i> {{ trans('general.limpiar') }}</button>
                     <button type="button" class="btn btn-sm btn-danger btn-cancel-massive"><i class="fa fa-times"></i> {{ trans('general.cancelar') }}</button>
                  </div>
                </div>
              </div>



               <br>
            </form>
          </div>
        </div>
      </div>
    </div>




    <div class="row">


    <!--Visualización tabla-->
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 ">
          <div class="form-group">
<div class="table-responsive">
              <table class="table table-striped compact-tab" id="preview_excel">
                <thead class="bg-primary">
                  <tr>
                    <th>Factura</th>
                    <th>No Factura</th>
                    <th>Fecha</th>
                    <th>Mac</th>
                    <th>serie</th>
                    <th>Descripcion</th>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Estado</th>
                    <th>Sitio</th>
                    <th>Precio/peso</th>
                    <th>Grupo</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>

                </tfoot>
              </table>
</div>
          </div>
        </div>
      </div>



</div>
    <div id="add_modelo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalbanks" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modalmodels">Crear nuevo</h4> <!-- change -->
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                @if( auth()->user()->can('Create model') )
                <form id="form_model" name="form_model" class="forms-sample" action=""> <!-- change -->
                  {{ csrf_field() }}
                  <div class="form-group row">
                    <label for="add_modelitho" class="col-sm-3 col-form-label">{{ trans('auth.nombre')}} <span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm required" id="add_modelitho" name="add_modelitho" placeholder="{{ trans('auth.nombre') }}" maxlength="60">
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
                    <label for="marcas_current" class="col-sm-3 col-form-label">Marca<span style="color: red;">*</span></label>
                    <div class="col-sm-9">
                      <select  id="marcas_current" name="marcas_current" class="form-control form-control-sm required"  style="width: 100%;">
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
                  @if( auth()->user()->can('Create model') )
                  <button type="button" class="btn btn-navy create_model"><i class="far fa-plus-square " style="margin-right: 4px;"></i> {{ trans('message.create') }}</button>
                  @endif
                  <button type="button" class="btn btn-danger waves-effect form_creat_user close_model" data-dismiss="modal"><i class="fas fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </form>
              @else
                <div class="col-xs-12">
                  @include('default.deniedmodule')
                </div>
              @endif
              </div>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>


    <div class="modal modal-default fade" id="add_grupo_1" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-id-card" style="margin-right: 4px;"></i>{{ trans('message.grupo')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card table-responsive">
              <div class="card-body">
                  @if( auth()->user()->can('Create grupos') )
                  <form class="form-horizontal" id="form_group" name="form_group">
                    {{ csrf_field() }}
                    <div class="form-group ">
                      <div class="col-md-3">
                      <label class=" control-label" for="add_grupitho">{{ trans('message.grupo')}} </label>
                      </div>
                      <div class="col-md-10">
                        <input id="add_grupitho" name="add_grupitho"  type="text"  maxlength="50" placeholder="Min. 4 Caracteres. {{ trans('message.maxcarcincuent')}}"
                          class="form-control " style="width:100%"/>
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
          <div class="modal-footer">
            @if( auth()->user()->can('Create grupos') )
              <button type="button" class="btn btn-navy create_grupo"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button>
            @endif
            <button type="button" class="btn btn-danger close_grupo" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal modal-default fade" id="add_marca_4" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-id-card" style="margin-right: 4px;"></i>{{ trans('general.marca') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card table-responsive">
              <div class="card-body">
                  @if( auth()->user()->can('Create marcas') )
                  <form class="form-horizontal" id="form_marca" name="form_marca">
                    {{ csrf_field() }}
                    <div class="form-group">
                     <label class=" control-label" for="modelitho_current">Tipo equipo:</label>
                     <div class="col-md-8">
                       <select class="form-control select2" id="modelitho_current" name="modelitho_current">
                         <option value="" selected> Elija </option>
                         @forelse ($especificaciones as $data_especificaciones)
                           <option value="{{ $data_especificaciones->id }}"> {{ $data_especificaciones->name }} </option>
                         @empty
                         @endforelse
                       </select>
                     </div>
                    </div>

                    <div class="form-group">
                      <label class=" control-label" for="">{{ trans('message.marcas')}} </label>
                      <div class="col-md-8">
                        <select class="form-control select2" id="marcas_select" name="marcas_select">
                          <option value="" selected>Elegir marca</option>
                          @forelse ($marcas as $data_marca)
                            <option value="{{ $data_marca->id }}"> {{ $data_marca->Nombre_marca }} </option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <div  class="col-md-9 col-md-offset-3">
                        <label for=""> <input id="new_marca" type="checkbox" class="icheckbox_square" name="" value="">Nueva marca</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class=" control-label" for="add_marquitha">Marca</label>
                      <div class="col-md-8">
                        <input id="add_marquitha" disabled name="add_marquitha"  type="text" minlength="4"  maxlength="50" placeholder="Min. 4 Caracteres. {{ trans('message.maxcarcincuent')}}"
                          class="form-control input-md"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class=" control-label" for="add_distribuidor">{{ trans('message.distribuidor')}} </label>
                      <div class="col-md-8">
                        <input id="add_distribuidor" disabled name="add_distribuidor"  type="text"  maxlength="50" placeholder="Min. 4 Caracteres. {{ trans('message.maxcarcincuent')}}"
                          class="form-control input-md"/>
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
          <div class="modal-footer">
            @if( auth()->user()->can('Create marcas') )
              <button type="button" class="btn btn-navy create_marca"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button>
            @endif
            <button type="button" class="btn btn-danger close_marca" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-default fade" id="add_provider" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-id-card" style="margin-right: 4px;"></i>{{ trans('message.title_provider') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="card table-responsive">
              <div class="card-body">
                <div class="row">
                @if( auth()->user()->can('Create provider') )
                  <div class="">
                    <form id="reg_provider" name="reg_provider"  class="form-horizontal" action="">
                      {{ csrf_field() }}
                      <div class="input-group row">
                        <div class="col-md-3">
                        <span class="input-group-addon">RFC <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                        </div>
                        <div class="col-md-8">
                        <input id="provider_rfc" name="provider_rfc" type="text" class="form-control" placeholder="RFC. Obligatorio 13 Caracteres" maxlength="13" title=""/>
                        </div>

                      </div>

                      <div class="input-group row">
                        <div class="col-md-3">
                        <span class="input-group-addon">Razón social (Nombre) <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                        </div>
                        <div class="col-md-8">
                        <input id="provider_name" name="provider_name"  type="text" class="form-control" placeholder="Razón social. Minimo 4 Caracteres" >
                        </div>
                      </div>

                          <div class="input-group row">
                            <div class="col-md-3">
                                  <span class="input-group-addon">Tipo fiscal <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                            </div>
                            <div class="col-md-8">
                              <input id="provider_tf" name="provider_tf"  type="text" class="form-control" placeholder="Tipo fiscal. Minimo 4 Caracteres">
                            </div>
                          </div>

                          <div class="input-group row">
                            <div class="col-md-3">
                                <span class="input-group-addon">Delegación o Municipio</span>
                            </div>
                            <div class="col-md-8">
                                <input id="provider_municipality" name="provider_municipality"  type="text" class="form-control" placeholder="Opcional">
                            </div>
                          </div>

                          <div class="input-group row">
                            <div class="col-md-3">
                                <span class="input-group-addon">Dirección <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                            </div>
                            <div class="col-md-8">
                                <input id="provider_address" name="provider_address"  type="text" class="form-control" placeholder="Minimo 4 Caracteres">
                            </div>
                          </div>

                          <div class="input-group row">
                            <div class="col-md-3">
                                <span class="input-group-addon">Estado <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                            </div>
                            <div class="col-md-8">
                                <input id="provider_estate" name="provider_estate"  type="text" class="form-control" placeholder="Minimo 4 Caracteres">
                            </div>
                          </div>

                          <div class="input-group row">
                            <div class="col-md-3">
                                <span class="input-group-addon">País <i class="glyphicon glyphicon-asteris text-danger">*</i></span>
                            </div>
                            <div class="col-md-8">
                                <input id="provider_country" name="provider_country"  type="text" class="form-control" placeholder="Minimo 4 Caracteres">
                            </div>
                          </div>

                          <div class="input-group row">
                            <div class="col-md-3">
                                <span class="input-group-addon">C.P</span>
                            </div>
                            <div class="col-md-8">
                                <input id="provider_postcode" name="provider_postcode"  type="text" class="form-control" placeholder="Opcional">
                            </div>
                          </div>

                          <div class="input-group row">
                            <div class="col-md-3">
                                <span class="input-group-addon">Telefono</span>
                            </div>
                            <div class="col-md-8">
                                <input id="provider_phone" name="provider_phone"  type="text" class="form-control" placeholder="Opcional">
                            </div>
                          </div>

                          <div class="input-group row">
                            <div class="col-md-3">
                                <span class="input-group-addon">Fax</span>
                            </div>
                            <div class="col-md-8">
                                <input id="provider_fax" name="provider_fax"  type="text" class="form-control" placeholder="Opcional">
                            </div>
                          </div>


                          <div class="input-group row">
                            <div class="col-md-3">
                                <span class="input-group-addon">Email</span>
                            </div>
                            <div class="col-md-8">
                                <input id="provider_email" name="provider_email"  type="text" class="form-control" placeholder="Opcional">
                            </div>
                          </div>

                      <div class="row p-3">
                        <h4>Datos del agente o contacto</h4>
                          <div class="input-group row">
                            <div class="col-md-3">
                                <span class="input-group-addon">Nombre</span>
                            </div>
                            <div class="col-md-8">
                                <input id="agent_name" name="agent_name" type="text" class="form-control" placeholder="Opcional">
                            </div>
                          </div>
                          <div class="input-group row">
                            <div class="col-md-3">
                                <span class="input-group-addon">Telefono</span>
                            </div>
                            <div class="col-md-8">
                                <input id="agent_phone" name="agent_phone" type="text" class="form-control" placeholder="Opcional">
                            </div>
                          </div>

                      </div>
                    </form>
                  </div>
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
            @if( auth()->user()->can('Create provider') )
              <button type="button" class="btn btn-navy create_provider"><i class="fa fa-plus-square-o" style="margin-right: 4px;"></i>{{ trans('message.create') }}</button>
            @endif
            <button type="button" class="btn btn-danger btn-sm delete_provider" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
          </div>
        </div>
      </div>
    </div>

    @else
      @include('default.denied')
    @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View add equipment') )
   <style media="screen">
    ul.typeahead.dropdown-menu {
      max-height: 150px;
      overflow: auto;
    }
    .ocultar {
      display: none ;
    }
   </style>
    <script type="text/javascript">
     $('#new_marca').on('click',function(){
       if(document.getElementById('new_marca').checked){
         $('#add_marquitha').prop('disabled',false);
         $('#add_distribuidor').prop('disabled', false);
         reset_select2('marcas_select');
         $('#marcas_select').prop('disabled',true);
       }else{
         $('#add_marquitha').prop('disabled',true);
         $('#add_distribuidor').prop('disabled', true);
         $('#add_marquitha').val('');
         $('#marcas_select').prop('disabled',false);
       }
     });
   </script>

    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" type="text/css" />
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>

      <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
      <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>
    <script src="{{ asset('js/admin/equipment/add_equipment.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/_all.css') }}" type="text/css" />
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
    <!--<script src="{{ asset('bower_components/Bootstrap-3-Typeahead-master/bootstrap3-typeahead.min.js')}}"></script>-->

  @else
    <!--NO VER-->
  @endif
@endpush
