@extends('layouts.admin')

@section('contentheader_title')
@endsection

@section('contentheader_description')
@endsection

@section('breadcrumb_title')
@endsection

@section('content')
  @if( auth()->user()->can('View Reg. Mensual CXC Det') )
  <div class="modal fade" id="modal_default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Default Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form id="form" class="form-horizontal addmens">
              {{ csrf_field() }}
              <div class="form-body">

                <div class="row form-group">
                  <label class="control-label col-md-4">Elija el servicio</label>
                  <div class="col-md-8">
                    <select id="sel_anexo_service" name="sel_anexo_service" class="form-control">
                      <option value="" selected>{{ trans('pay.select_op') }}</option>
                      @forelse ($classifications as $data_classifications)
                      <option value="{{ $data_classifications->id }}"> {{ $data_classifications->name }} </option>
                      @empty
                      @endforelse
                    </select>
                  </div>
                </div>
                <div class="row form-group">
                  <label class="control-label col-md-4">Elija la vertical</label>
                  <div class="col-md-8">
                    <select id="sel_anexo_vertical" name="sel_anexo_vertical" class="form-control">
                      <option value="" selected>{{ trans('pay.select_op') }}</option>
                    </select>
                  </div>
                </div>
                <div class="row form-group">
                  <label class="control-label col-md-4">Elija el grupo</label>
                  <div class="col-md-8">
                    <select id="sel_anexo_cadenas" name="sel_anexo_cadenas" class="form-control">
                      <option value="" selected>{{ trans('pay.select_op') }}</option>
                    </select>
                  </div>
                </div>
                <div class="row form-group">
                  <label class="control-label col-md-4">Elija el anexo de contrato</label>
                  <div class="col-md-8">
                    <select id="sel_to_anexo" name="sel_to_anexo" class="form-control">
                      <option value="" selected>{{ trans('pay.select_op') }}</option>
                    </select>
                  </div>
                </div>

                <div class="row form-group">
                  <label class="control-label col-md-2">Concepto</label>
                  <div class="col-md-10">
                    <select id="concept" name="concept" class="form-control">
                      <option value="" selected>{{ trans('pay.select_op') }}</option>
                      @forelse ($conceptos_sat as $data_conceptos_sat)
                      <option value="{{ $data_conceptos_sat->value }}"> {{ $data_conceptos_sat->text }} </option>
                      @empty
                      @endforelse
                    </select>
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="row form-group">
                  <label class="control-label col-md-2">Moneda</label>
                  <div class="col-md-4">
                    <select id="currency" name="currency" class="form-control">
                      <option value="" selected>{{ trans('pay.select_op') }} la moneda</option>
                      @forelse ($currency as $data_currency)
                      <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                      @empty
                      @endforelse
                    </select>
                    <span class="help-block"></span>
                  </div>

                  <label class="control-label col-md-2">Monto</label>
                  <div class="col-md-4">
                    <input id="monto" name="monto" placeholder="Obligatory field" class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10">
                    <span class="help-block"></span>
                  </div>
                </div>

                <div class="row form-group">
                  <label class="control-label col-md-2">Descuento</label>
                  <div class="col-md-4">
                    <input value="0" id="descuento" name="descuento" placeholder="Obligatory field" class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10">
                    <span class="help-block"></span>
                  </div>
                  <label class="control-label col-md-2">% de IVA</label>
                  <div class="col-md-4">
                    <input value="0" id="iva" name="iva" placeholder="Obligatory field" class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="row form-group">
                  <label class="control-label col-md-2">TC</label>
                  <div class="col-md-3">
                    <input value="0" id="tc" name="tc" placeholder="Obligatory field" class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10">
                    <span class="help-block"></span>
                  </div>
                  <label class="control-label col-md-3">Monto c/iva</label>
                  <div class="col-md-4">
                    <input value="0" id="mens_iva" name="mens_iva" readonly placeholder="Obligatory field" class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10">
                    <span class="help-block"></span>
                  </div>
                </div>
                <div class="row form-group">
                  <label class="control-label col-md-3">Monto final</label>
                  <div class="col-md-9">
                    <input id="mfinal"  name="mfinal" placeholder="" class="form-control" type="text" readonly>
                    <span class="help-block"></span>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                  <button type="button" class="btn btn-danger col-md-3" data-dismiss="modal">Close</button>
                  <span class="col-md-4">&nbsp;</span>
                  <button type="submit" class="btn btn-warning col-md-5">Save changes</button>
              </div>
          </form>
        </div>
        <div class="modal-footer"></div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
    <!-- /.modal -->

    <!-- Validation wizard -->
    <div class="row" id="validation">
      <div class="col-sm-12">
        <div class="white-box contrato_a">
            <div class="wizard-content">
              <div class="row">
                <div class="col-sm-12">
                  <h4 class="">Mensualidades</h4>
                </div>
                <div class="col-sm-12 mt-5">
                  <button type="button" class="btn btn-success add_record"><i class="fas fa-plus"></i> Add Record</button>
                  <button type="button" class="btn btn-default reload_table"><i class="fas fa-sync-alt"></i> Reload</button>
                </div>
                <div class="col-sm-12 mt-5 form-inline">
                  <form id="form_tc" class="form-inline">
                    {{ csrf_field() }}
                    <label class="control-label">Tipo de cambio (General)</label>
                    <input id="tpgeneral" name="tpgeneral" type="number" class="form-control" placeholder="0"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10">
                    <select id="updcurrency" name="updcurrency" class="form-control ml-1">
                      <option value="" selected>{{ trans('pay.select_op') }} la moneda</option>
                      @forelse ($currency as $data_currency)
                      <option value="{{ $data_currency->id }}"> {{ $data_currency->name }} </option>
                      @empty
                      @endforelse
                    </select>
                    <button type="button" class="btn btn-primary btnupdetc ml-1">Update</button>
                  </form>
                </div>

                <div class="col-sm-12 mt-5 form-inline">
                  <form id="form_iva" class="form-inline">
                    {{ csrf_field() }}
                    <label class="control-label">IVA</label>
                    <input id="iva_general" name="iva_general" type="number" class="form-control" placeholder="0"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10">
                    <button type="button" class="btn btn-primary btnupdeiva ml-1">Update</button>
                  </form>
                </div>

                <div class="col-sm-12 mt-5 form-inline">
                  <form id="form_fc_ff" class="form-inline">
                    {{ csrf_field() }}
                    <label class="control-label"><span class="input-group-addon"><i class="fas fa-calendar-alt fa-2x"></i></span>&nbsp;Fecha compromiso:</label>
                    <div class="input-group">
                      <input id="date_compromise" type="text" class="form-control dateInput"  placeholder="Fecha" name="date_compromise">
                    </div>
                    <label class="control-label ml-1"><span class="input-group-addon"><i class="fas fa-calendar-alt fa-2x"></i></span>&nbsp;Fecha factura:</label>
                    <div class="input-group">
                      <input id="date_factura" type="text" class="form-control dateInput" placeholder="Fecha" name="date_factura">
                    </div>
                    <button type="button" class="btn btn-primary btnupdefc ml-1">Update</button>
                  </form>
                </div>
                <div class="col-sm-12 mt-5 form-inline">
                  <form id="form_concepts" class="form-inline">
                    <label>Concepto de facturación:</label>
                      <select id="upd_concept" name="upd_concept" class="form-control">
                      <option value="" selected>{{ trans('pay.select_op') }} el concepto</option>
                      @forelse ($conceptos_sat as $data_concept)
                      <option value="{{ $data_concept->value }}"> {{ $data_concept->text }} </option>
                      @empty
                      @endforelse
                    </select>
                    <!-- <button type="button" class="btn btn-primary btnupdconcepts">Update</button> -->
                  </form>
                </div>
                <div class="col-sm-12 form-inline" style="margin-bottom: 30px;">
                  <form id="" class="form-inline">
                    {{ csrf_field() }}
                    <label class="control-label">Total MXN</label>
                    <input id="total_mxn" name="total_mxn" type="text" class="form-control" readonly>
                  </form>
                </div>
                <!--  <div class="col-sm-12 mt-10 form-inline">
                  <form id="form_ff">
                    {{ csrf_field() }}
                    <label class="control-label">Fecha factura:</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      <input id="date_factura" type="text" class="form-control dateInput" name="date_factura">
                    </div>
                    <button type="button" class="btn btn-primary btnupdeff">Update</button>
                  </form>
                </div> -->
                <div class="col-sm-12">
                  <div class="box-body table-responsive no-padding">
                    <table id="mens_table" name="mens_table" class="table table-hover compact-tab">
                      <thead>
                        <tr class="bg-primary" style="background: #3D82C2">
                          <th>ID</th>
                          <th>Clasificación</th>
                          <th>Vertical</th>
                          <th>Cadena</th>
                          <th>ID_Contrato</th>
                          <th>Concepto</th>
                          <th>No. Mensualidad<br>Actual</th>
                          <th>No. Mensualidades<br>Faltantes</th>
                          <th>Meses<br>Totales</th>
                          <th>Fecha_real</th>
                          <th>Fecha_fin</th>
                          <th>Moneda</th>
                          <th>Monto</th>
                          <th>Descuento</th>
                          <th>Subtotal</th>
                          <th>IVA</th>
                          <th>Mensualidad c/iva:</th>
                          <th>TC</th>
                          <th>Total MXN</th>
                          <th></th>
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
      <!-- FIN FORMULARIO -->
    </div>
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('View Reg. Mensual CXC Det') )
    <link href="/plugins/sweetalert-master/dist/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/plugins/sweetalert-master/dist/sweetalert-dev.js"></script>

    <script src="{{ asset('/plugins/momentupdate/moment-with-locales.js')}}"></script>

    <!-- FormValidation -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.css')}}" >
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/formValidation.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master/libs/formvalidation/bootstrap.min.js')}}"></script>

    <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/documentp.css')}}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extras-margins-padding.css')}}" >
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script type="text/javascript">
        var cx_sat = {!! json_encode($conceptos_sat) !!};
    </script>

    <style>
    .glyphicon-ok:before {
        content: "OK";
    }
    .glyphicon-remove:before {
        content: "X";
    }
    .glyphicon {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .compact-tab thead tr th{
     table-layout: fixed !important;
     width: 80px !important;
     white-space: pre-wrap !important;
     padding:5px !important;
     margin:0 !important;
     font-size: 14px !important;
     color:white;
    }
    .compact-tab tbody tr td{
     table-layout: fixed !important;
     width: 80px !important;
     white-space: pre-wrap !important;
     padding:10px !important;
     margin:0 !important;
     font-size: 14px !important;
    }
    .aux {
      font-size: 13px !important;
      padding: 0px 5px !important;
      white-space: nowrap !important;
      height: 30px !important;
    }
    </style>

    <script type="text/javascript" src="{{asset('js/admin/contract/pruebapayauto.js')}}"></script>
  @else
    @include('default.denied')
  @endif
@endpush
