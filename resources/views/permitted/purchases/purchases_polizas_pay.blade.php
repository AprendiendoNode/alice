@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View purchase poliza pay') )
    Póliza de pago
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('View purchase poliza pay') )
    Póliza de pago
  @else
    {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  <!-- modal about -->
  <div id="modal_customer_invoice_send_mail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalmail" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <h4 class="modal-title" id="modalmail"> {{ __('customer_invoice.text_modal_send_mail')}} </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">&times;</span>
          </button>
        </div>
        <!--Body-->
        <div class="modal-body">
          <form id="form_email_fact">
              <div class="row">
                  <input id="customer_invoice_id" name="customer_invoice_id" type="hidden" value="">
                  <input id="fact_name" name="fact_name" type="hidden" value="">
                  <input id="cliente_name" name="cliente_name" type="hidden" value="">
                  <div class="col-md-12 col-xs-12">
                    <div class="form-group form-group-sm">
                      <label for="subject" class="control-label">Subject <span class="required text-danger">*</span></label>
                      <input class="form-control" placeholder="Asunto" required="" name="subject" type="text" value="" id="subject">
                    </div>
                  </div>
                  <div class="col-md-12 col-xs-12">
                      <div class="form-group form-group-sm">
                        <label for="to" class="control-label">Para <span class="required text-danger">*</span></label>
                        <select style="height:180px !important;" id='to' name='to[]' class="form-control" multiple="multiple">
                        </select>
                      </div>
                  </div>
                  <div class="col-md-12 col-xs-12">
                    <div class="form-group form-group-sm">
                      <label for="attach" class="control-label">{{__('general.entry_mail_attach')}} <span class="required text-danger">*</span></label>
                      <select id='attach' name='attach[]' class="form-control" multiple="multiple">
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12 col-xs-12 editor_quill">
                      <div class="form-group form-group-sm">
                        <label for="attach" class="control-label">{{__('general.entry_mail_message')}} <span class="required text-danger">*</span></label>
                      </div>
                      <div name="message" id="message" class="mb-4"></div>
                  </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="pull-right">
            <button type="button" id="send_mail_button" class="btn btn-xs btn-info "> <i class="fas fa-paper-plane"> Enviar </i></button>
            <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal"> <i class="fa fas fa-times"> {{ __('general.button_close') }} </i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /modal about -->
  <!--MODAL POLIZA MOVIMIENTOS--------------------------->
  <div id="modal_view_poliza" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Póliza</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form_save_asientos_contables">
          <div class="modal-body">
            <!--TABLA DE PARTIDAS / ASIENTO CONTABLE------>
            <div class="row mt-2 mb-3">
              <div id="data_asientos" class="col-12 table-responsive">
              </div>
            </div>
            <!--TABLA DE PARTIDAS / ASIENTO CONTABLE------>
          </div>
          <div class="modal-footer">
            <button type="submit" id="save_poliza_partida" type="button" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--MODAL COMPRAS DETALLE--------------------------->
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
  @if( auth()->user()->can('View purchase poliza pay') )
    <div class="row">
      <div class="col-md-12 grid-margin-onerem  stretch-card">
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
                      <input type="text"  datas="filter_date_from" id="filter_date_from" name="filter_date_from" class="form-control" placeholder="" required>
                      <div class="input-group-append">
                        <span class="input-group-text white"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <div class="form-group">
                    <label for="filter_customer_id">Cliente</label>
                    <select class="form-control" id="filter_customer_id" id="filter_customer_id">
                      <option value="" selected>Selecciona...</option>
                      @forelse ($providers as $providers_data)
                        <option value="{{ $providers_data->id  }}">{{ $providers_data->name }}</option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="col-md-1 col-xs-12 pt-3">
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
    <div class="row">
      <div class="col-md-12 grid-margin-onerem  stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="form-group col-md-3">
              <label class="" for="tipo_poliza">Elija poliza de egreso:</label>
              <select class="form-control form-control-sm mb-2 mr-sm-2 required" id="tipo_poliza" name="tipo_poliza" >
                <option value="" selected>Selecciona...</option>
                @foreach ($tipos_poliza as $poliza_data)
                  <option value="{{$poliza_data->id}}">{{$poliza_data->clave}} {{$poliza_data->descripcion}}</option>
                @endforeach
              </select>
            </div>
            <div class="table-responsive table-data table-dropdown">
              <table id="table_filter_fact" name='table_filter_fact' class="table table-striped table-hover table-condensed table-sm">
                <thead>
                  <tr class="mini">
                      <th></th>
                      <th class="text-center" width="5%">@lang('general.column_actions')</th>
                      <th class="text-center">Folio</th>
                      <th class="text-center">Cliente</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Moneda</th>
                      <th class="text-center">Total</th>
                      <th class="text-center">Saldo</th>
                      <th class="text-center">Enviada</th>
                      <th class="text-center">Estatus</th>
                      <th class="text-center">Pago<br>Contabilizado</th>
                      <th></th>
                  </tr>
                </thead>
              </table>
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
  @if( auth()->user()->can('View purchase poliza pay') )
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

    {{-- <link href="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.css')}}" rel="stylesheet" type="text/css"> --}}
    {{-- <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.min.js')}}"></script> --}}

    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />

    <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
    <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>

    <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>
    <!-- Main Quill library -->
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style media="screen">
      .white {background-color: #ffffff;}
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
      th { font-size: 12px !important; }
      td { font-size: 10px !important; }
      .editor-wrapper {
        min-height: 250px;
        background-color: #fff;
        border-collapse: separate;
        border: 1px solid #ccc;
        padding: 4px;
        box-sizing: content-box;
        box-shadow: rgba(0,0,0,.07451) 0 1px 1px 0 inset;
        overflow: scroll;
        outline: 0;
        border-radius: 3px;
      }
      .editor_quill {
        margin-bottom: 5rem !important;
      }
      #table_filter_fact tbody tr td {
        padding: 0.2rem 0.5rem;
        height: 38px !important;
      }
    </style>
    <script src="{{ asset('js/admin/purchases/poliza_pago.js')}}"></script>

  @else
  @endif
@endpush
