@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View purchases show') )
    Historial de compras
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View purchases show') )
    Historial de compras
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('View purchases show') )
        <div class="modal modal-default fade" id="modal-view-deny" data-backdrop="static">
            <div class="modal-dialog" >
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-id-card" style="margin-right: 4px;"></i>DENEGAR SOLICITUD.</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="card-body table-responsive">
                <div class="card-body">
                  <div class="row">
                    <div id="captura_pdf_general" class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                      <div class="row pad-top-botm client-info">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <p class="text-center" style="border: 1px solid #3D9970" >DENEGAR.</p>
                          <div class="clearfix">
                            <input id="hidden_viatic" hidden></input>
                            <textarea id="comment_deny" class="form-control" style="resize: vertical;" placeholder="Comentario."></textarea>
                          </div>
                        </div>
                      </div>
                      </div>
                  </div>
                </div>
              </div>
                <div class="modal-footer">
                  <!-- <button type="button" class="btn btn-primary btn-export"><i class="fa fa-save"></i> Exportar PDF</button> -->
                  <button type="button" class="btn btn-danger" id="deny_request_v"><i class="fa fa-trash" style="margin-right: 4px;"></i>Denegar</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </div>
              </div>
            </div>
        </div>
        <div class="modal modal-default fade" id="modal-purchase-view" data-backdrop="static">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fa fa-eye"></i> Compra</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="card-body table-responsive">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <img src="/img/company/sitwifi_logo.jpg" style="max-width: 200%;" alt="Error" >
                    </div>
                    <div class="col-md-8 text-center">
                      <h4 style="margin-bottom: 0px;">SITWIFI, S.A. DE C.V.</h4>
                      <p style="margin-bottom: 0px;">HAMBURGO No. Ext. 159 No. Int. PISO 1</p>
                      <p style="margin-bottom: 0px;">Col. JUAREZ C.P. 06600</p>
                      <p style="margin-bottom: 0px;">Delg. CUAUHTÉMOC Cd. CIUDAD DE MÉXICO</p>
                      <p style="margin-bottom: 0px;">R.F.C.: SIT070918IXA</p>
                    </div>
                  </div>
                  <div class="row mt-2" style="border: 1px solid black;">
                    <div class="col-md-6" style="font-weight: bold;">
                      <p style="margin-bottom: 0px;">Folio: <span style="font-weight: normal;" id="modalFolio"></span></p>
                      <p style="margin-bottom: 0px;">Nombre: <span style="font-weight: normal;" id="modalNombre"></span></p>
                      <p style="margin-bottom: 0px;">Fecha de registro: <span style="font-weight: normal;" id="modalFechaReg"></span></p>
                      <p style="margin-bottom: 0px;">Fecha de facturación: <span style="font-weight: normal;" id="modalFechaFact"></span></p>
                      <p style="margin-bottom: 0px;">Fecha de vencimiento: <span style="font-weight: normal;" id="modalFechaVenc"></span></p>
                    </div>
                    <div class="col-md-6" style="font-weight: bold;">
                      <p style="margin-bottom: 0px;">Término de pago: <span style="font-weight: normal;" id="modalTerminoPago"></span></p>
                      <p style="margin-bottom: 0px;">Forma de pago: <span style="font-weight: normal;" id="modalFormaPago"></span></p>
                      <p style="margin-bottom: 0px;">Método de pago: <span style="font-weight: normal;" id="modalMetodoPago"></span></p>
                      <p style="margin-bottom: 0px;">Uso de CFDI: <span style="font-weight: normal;" id="modalUsoCFDI"></span></p>
                      <p style="margin-bottom: 0px;">Moneda: <span style="font-weight: normal;" id="modalMoneda"></span></p>
                    </div>
                  </div>
                  <div class="row mt-1">
                    <div class="table-responsive">
                       <table id="table_modal_purchase" class="table table-striped table-bordered table-hover compact-tab w-100">
                         <thead>
                           <tr class="bg-secondary" style="background: #088A68;">
                              <th> <small>Cantidad</small> </th>
                              <th> <small>Producto</small> </th>
                              <th> <small>Descripción</small> </th>
                              <th> <small>Costo Unitario</small> </th>
                              <th> <small>Importe S/Descuento</small> </th>
                              <th> <small>Importe C/Descuento</small> </th>
                           </tr>
                         </thead>
                         <tbody>
                         </tbody>
                         <tfoot id='tfoot_average'>
                           <tr>
                             <th></th>
                             <th></th>
                             <th></th>
                             <th></th>
                             <th></th>
                             <th></th>
                           </tr>
                         </tfoot>
                       </table>
                     </div>
                  </div>
                  <div class="row" style="font-weight: bold;">
                    <div id="montoLetras" class="col-md-7" style="padding-top: 20px; border: 1px solid black;">f</div>
                    <div class="col-md-3" style="border: 1px solid black;">
                      <p style="margin-bottom: 0px;">Total S/Descuento</p>
                      <p style="margin-bottom: 0px;">Total Descuento</p>
                      <p style="margin-bottom: 0px;">Subtotal</p>
                      <p style="margin-bottom: 0px;">Impuestos</p>
                      <p style="margin-bottom: 0px;">Total</p>
                    </div>
                    <div class="col-md-2 text-right" style="border: 1px solid black;">
                      <p style="margin-bottom: 0px;" id="totales1">$ 0</p>
                      <p style="margin-bottom: 0px;" id="totales2">$ 0</p>
                      <p style="margin-bottom: 0px;" id="totales3">$ 0</p>
                      <p style="margin-bottom: 0px;" id="totales4">$ 0</p>
                      <p style="margin-bottom: 0px; border-top: 1px solid black;" id="totales5">$ 0</p>
                    </div>
                  </div>
                </div>
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
                </div>
              </div>
            </div>
        </div>
    @if( auth()->user()->can('View level zero purchase') )
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <form id="form" name="form" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row">
                  <div class="col-md-3 col-xs-12">
                    <div class="form-group" id="date_from">
                      <label class="control-label" for="filter_date_from">
                        {{ __('general.date_from') }}
                      </label>
                      <div class="input-group mb-3">
                        <input type="text"  datas="filter_date_from" id="filter_date_from" name="filter_date_from" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('first day of this month')) }}" required>
                        <div class="input-group-append">
                          <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-xs-12">
                    <div class="form-group" id=date_to>
                      <label class="control-label" for="filter_date_to">
                        {{ __('general.date_to') }}
                      </label>
                      <div class="input-group mb-3">
                        <input type="text"  datas="filter_date_to" id="filter_date_to" name="filter_date_to" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('last day of this month')) }}" required>
                        <div class="input-group-append">
                          <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-xs-12">
                    <div class="form-group">
                      <label for="filter_status">Estado</label>
                      <select class="form-control" id="filter_status" name="filter_status">
                        <option value="" selected>Selecciona...</option>
                        @forelse ($statuses as $status)
                          <option value="{{ $status->id }}"> {{ $status->name }} </option>
                        @empty
                        @endforelse
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3 col-xs-12 pt-4">
                    <button type="submit"
                            onclick=""
                            class="btn btn-xs btn-info "
                            style="margin-top: 4px">
                        <i class="fa fa-filter"> {{__('general.button_search')}}</i>
                    </button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                 <table id="table_filter_fact" class="table table-striped table-bordered table-hover compact-tab w-100">
                   <thead>
                     <tr class="bg-primary" style="background: #088A68;">
                        <th> <small></small> </th>
                        <th> <small>Folio</small> </th>
                        <th> <small>Fecha factura</small> </th>
                        <th> <small>Termino de pago</small> </th>
                        <th> <small>Forma de pago</small> </th>
                        <th> <small>Moneda</small> </th>
                        <th> <small>Total</small> </th>
                        <th> <small>Estado</small> </th>
                        <th> <small>Acciones</small> </th>
                     </tr>
                   </thead>
                   <tbody>
                   </tbody>
                   <tfoot id='tfoot_average'>
                     <tr>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                     </tr>
                   </tfoot>
                 </table>
               </div>
              <!-- <div class="table-responsive table-data table-dropdown">
                <table id="table_filter_fact" name='table_filter_fact' class="table table-striped table-hover table-condensed">
                  <thead>
                    <tr class="mini">
                        <th class="text-center" width="5%">@lang('general.column_actions')</th>
                        <th class="text-center">
                          Folio
                        </th>
                        <th class="text-center">
                          Fecha de factura
                        </th>
                        <th class="text-center">
                          Termino de pago
                        </th>
                        <th class="text-center">
                          Forma de pago
                        </th>
                        <th class="text-center">
                          Moneda
                        </th>
                        <th class="text-center">
                          Total
                        </th>
                        <th class="text-center">
                          Estado
                        </th>
                    </tr>
                  </thead>
                </table>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    @endif
    @if( auth()->user()->can('View level one purchase') )
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <form id="form" name="form" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row">
                  <div class="col-md-3 col-xs-12">
                    <div class="form-group" id="date_from">
                      <label class="control-label" for="filter_date_from">
                        {{ __('general.date_from') }}
                      </label>
                      <div class="input-group mb-3">
                        <input type="text"  datas="filter_date_from" id="filter_date_from" name="filter_date_from" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('first day of this month')) }}" required>
                        <div class="input-group-append">
                          <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-xs-12">
                    <div class="form-group" id=date_to>
                      <label class="control-label" for="filter_date_to">
                        {{ __('general.date_to') }}
                      </label>
                      <div class="input-group mb-3">
                        <input type="text"  datas="filter_date_to" id="filter_date_to" name="filter_date_to" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('last day of this month')) }}" required>
                        <div class="input-group-append">
                          <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 col-xs-12 pt-4">
                    <button type="submit"
                            onclick=""
                            class="btn btn-xs btn-info "
                            style="margin-top: 4px">
                        <i class="fa fa-filter"> {{__('general.button_search')}}</i>
                    </button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                 <table id="table_filter_fact" class="table table-striped table-bordered table-hover compact-tab w-100">
                   <thead>
                     <tr class="bg-primary" style="background: #088A68;">
                        <th> <small></small> </th>
                        <th> <small>Folio</small> </th>
                        <th> <small>Fecha factura</small> </th>
                        <th> <small>Termino de pago</small> </th>
                        <th> <small>Forma de pago</small> </th>
                        <th> <small>Moneda</small> </th>
                        <th> <small>Total</small> </th>
                        <th> <small>Estado</small> </th>
                        <th> <small>Acciones</small> </th>
                        <th> <small></small> </th>
                     </tr>
                   </thead>
                   <tbody>
                   </tbody>
                   <tfoot id='tfoot_average'>
                     <tr>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                     </tr>
                   </tfoot>
                 </table>
               </div>
              <!-- <div class="table-responsive table-data table-dropdown">
                <table id="table_filter_fact" name='table_filter_fact' class="table table-striped table-hover table-condensed">
                  <thead>
                    <tr class="mini">
                        <th class="text-center" width="5%">@lang('general.column_actions')</th>
                        <th class="text-center">
                          Folio
                        </th>
                        <th class="text-center">
                          Fecha de factura
                        </th>
                        <th class="text-center">
                          Termino de pago
                        </th>
                        <th class="text-center">
                          Forma de pago
                        </th>
                        <th class="text-center">
                          Moneda
                        </th>
                        <th class="text-center">
                          Total
                        </th>
                        <th class="text-center">
                          Estado
                        </th>
                    </tr>
                  </thead>
                </table>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    @endif
    @if( auth()->user()->can('View level two purchase') )
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form id="form" name="form" enctype="multipart/form-data">
                  {{ csrf_field() }}

                  <div class="row">
                    <div class="col-md-3 col-xs-12">
                      <div class="form-group" id="date_from">
                        <label class="control-label" for="filter_date_from">
                          {{ __('general.date_from') }}
                        </label>
                        <div class="input-group mb-3">
                          <input type="text"  datas="filter_date_from" id="filter_date_from" name="filter_date_from" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('first day of this month')) }}" required>
                          <div class="input-group-append">
                            <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                      <div class="form-group" id=date_to>
                        <label class="control-label" for="filter_date_to">
                          {{ __('general.date_to') }}
                        </label>
                        <div class="input-group mb-3">
                          <input type="text"  datas="filter_date_to" id="filter_date_to" name="filter_date_to" class="form-control" placeholder="" value="{{ \App\Helpers\Helper::date(Date::parse('last day of this month')) }}" required>
                          <div class="input-group-append">
                            <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3 col-xs-12 pt-4">
                      <button type="submit"
                              onclick=""
                              class="btn btn-xs btn-info "
                              style="margin-top: 4px">
                          <i class="fa fa-filter"> {{__('general.button_search')}}</i>
                      </button>
                    </div>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                   <table id="table_filter_fact" class="table table-striped table-bordered table-hover compact-tab w-100">
                     <thead>
                       <tr class="bg-primary" style="background: #088A68;">
                          <th> <small></small> </th>
                          <th> <small>Folio</small> </th>
                          <th> <small>Fecha factura</small> </th>
                          <th> <small>Termino de pago</small> </th>
                          <th> <small>Forma de pago</small> </th>
                          <th> <small>Moneda</small> </th>
                          <th> <small>Total</small> </th>
                          <th> <small>Estado</small> </th>
                          <th> <small>Acciones</small> </th>
                          <th> <small></small> </th>
                       </tr>
                     </thead>
                     <tbody>
                     </tbody>
                     <tfoot id='tfoot_average'>
                       <tr>
                         <th></th>
                         <th></th>
                         <th></th>
                         <th></th>
                         <th></th>
                         <th></th>
                         <th></th>
                         <th></th>
                         <th></th>
                         <th></th>
                       </tr>
                     </tfoot>
                   </table>
                 </div>
                <!-- <div class="table-responsive table-data table-dropdown">
                  <table id="table_filter_fact" name='table_filter_fact' class="table table-striped table-hover table-condensed">
                    <thead>
                      <tr class="mini">
                          <th class="text-center" width="5%">@lang('general.column_actions')</th>
                          <th class="text-center">
                            Folio
                          </th>
                          <th class="text-center">
                            Fecha de factura
                          </th>
                          <th class="text-center">
                            Termino de pago
                          </th>
                          <th class="text-center">
                            Forma de pago
                          </th>
                          <th class="text-center">
                            Moneda
                          </th>
                          <th class="text-center">
                            Total
                          </th>
                          <th class="text-center">
                            Estado
                          </th>
                      </tr>
                    </thead>
                  </table>
                </div> -->
              </div>
            </div>
          </div>
        </div>
    @endif

  @else
    @include('default.denied')
  @endif
@endsection
@push('scripts')
  @if( auth()->user()->can('View purchases show') )
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script>
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
    <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

    <script src="{{ asset('js/admin/purchases/purchase_view.js')}}"></script>
    @if( auth()->user()->can('View level zero purchase') )
      <script src="{{ asset('js/admin/purchases/purchase_history_zero.js')}}"></script>
    @elseif( auth()->user()->can('View level one purchase') )
      <script src="{{ asset('js/admin/purchases/purchase_history_1.js')}}"></script>
    @elseif( auth()->user()->can('View level two purchase') )
      <script src="{{ asset('js/admin/purchases/purchase_history_2.js')}}"></script>
    @endif

  @else
  @endif
@endpush
