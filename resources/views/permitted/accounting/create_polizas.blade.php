@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('Create polizas') )
  Historial de polizas
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('breadcrumb_title')
  @if( auth()->user()->can('Create polizas') )
    Historial de polizas
  @else
  {{ trans('message.denied') }}
  @endif
@endsection

@section('content')
  @if( auth()->user()->can('Create polizas') )
  <div class="row">
    <div class="col-md-12 grid-margin-onerem card">
      <div class="card-body">
        <div class="row">
          <h4 class="text-dark">Creacion de polizas</h4>
        </div>
        <form id="form_create_asientos_contables">
            <input id="date_invoice" name="date_invoice" type="hidden" value="">
            <div class="row">
              <div class="col-md-3 col-xs-12">
                <div class="form-group">
                  <label for="date_poliza">Fecha:</label>
                  <input type="text" class="form-control form-control-sm" id="date_poliza" name="date_poliza" value="">
                </div>
              </div>
            </div>
            <!------TABLA DE PARTIDAS / ASIENTO CONTABLE------>
            <div class="row">
              <div class="form-group col-md-3">
                <label class="" for="type_poliza">Tipo:</label>
                <select class="form-control form-control-sm mb-2 mr-sm-2" id="type_poliza" name="type_poliza" >
                  @foreach ($tipos_poliza as $poliza_data)      
                    <option value="{{$poliza_data->id}}">{{$poliza_data->clave}} {{$poliza_data->descripcion}}</option>  
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-2">
                <label class="" for="">Número:</label>
                <input type="number" class="form-control form-control-sm mb-2 mr-sm-2" id="num_poliza" name="num_poliza"  value="">
              </div>   
              <div class="form-group col-md-2">
                <label class="" for="day_poliza">Día:</label>
                <input readonly type="number" class="form-control form-control-sm mb-2 mr-sm-2" value="" name="day_poliza" id="day_poliza">
              </div>
              <div class="form-group col-md-2">
                <label class="" for="mes_poliza">Mes:</label>
                <input readonly type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="mes_poliza" id="mes_poliza">
              </div>
              <div class="form-group col-md-3">
                <label class="" for="mes_poliza">Descripción:</label>
                <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="descripcion_poliza" id="descripcion_poliza">
              </div>
            </div>
            <div class="row mt-2 mb-3">
              <div id="data_asientos" class="col-12 table-responsive">
                <table id="create_asiento_contable" class="table table-sm">
                  <thead class="bg-secondary text-white">
                    <tr>
                      <th></th>
                      <th></th>
                      <th>Mov.</th>
                      <th>Cuenta</th>
                      <th>Dia</th>
                      <th>T.C.</th>
                      <th>Nombre</th>
                      <th>Cargo</th>
                      <th>Abono</th>
                      <th>Referencia</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="">
                        <td></td>
                        <td><input class="id_factura" type="hidden" value=""></td>
                        <td></td>
                        <td>
                          <select required style="width:230px;" class="form-control form-control-sm cuenta_contable select2">
                            <option value="">Seleccionar cuenta contable ...</option>
                            @foreach ($cuentas_contables as $cuenta_data)
                              <option value="{{$cuenta_data->id}}">{{$cuenta_data->cuenta}} {{$cuenta_data->nombre}}</option>   
                            @endforeach
                          </select>
                        </td>
                        <td><input style="width:58px;text-align:left" class="form-control form-control-sm dia" readonly type="number" value=""></td>
                        <td><input style="width:80px;text-align:center" class="form-control form-control-sm tipo_cambio" type="number" value="1"></td>
                        <td class=""><input style="width:170px;text-align:left" class="form-control form-control-sm nombre" type="text" value=""></td>
                        <td><input onblur="suma_total_asientos();" style="width:115px;text-align:right" class="form-control form-control-sm cargos" type="text" value="0.0"></td>
                        <td><input onblur="suma_total_asientos();" style="width:115px;text-align:right" class="form-control form-control-sm abonos"  type="text" value="0.0" ></td> 
                      <td><input style="width:135px;text-align:left" class="form-control form-control-sm referencia" type="text" value=""></td>
                    </tr> 
                    <tr id="trTemplateMov" class="row_mov d-none">
                      <td><button type="button" class="btn btn-sm btn-danger p-1 delete_mov_cc" onclick="delete_mov_cc(this);"> <i class="fas fa-trash-alt"></i> </button></td>
                      <td><input class="id_factura" type="hidden" value=""></td>
                      <td></td>
                      <td>
                        <select style="width:230px;" class="form-control form-control-sm cuenta_contable">
                          <option value="">Seleccionar cuenta contable ...</option>
                          @foreach ($cuentas_contables as $cuenta_data)
                            <option value="{{$cuenta_data->id}}">{{$cuenta_data->cuenta}} {{$cuenta_data->nombre}}</option>   
                          @endforeach
                        </select>
                      </td>
                      <td><input style="width:58px;text-align:left" class="form-control form-control-sm dia" readonly type="number" value=""></td>
                      <td><input style="width:80px;text-align:center" class="form-control form-control-sm tipo_cambio" type="number" value="1"></td>
                      <td><input style="width:170px;text-align:left" class="form-control form-control-sm nombre" type="text" value=""></td>
                      <td><input onblur="suma_total_asientos();" style="width:115px;text-align:right" class="form-control form-control-sm cargos" type="text" value="0.0"></td>
                      <td><input onblur="suma_total_asientos();" style="width:115px;text-align:right" class="form-control form-control-sm abonos"  type="text" value="0.0" ></td> 
                      <td><input style="width:125px;text-align:left" class="form-control form-control-sm referencia" type="text" value=""></td>
                    </tr>
                      
                  </tbody>
                  <tfoot>
                    <td><button id="add_mov_cc" type="button" class="btn btn-sm btn-dark p-1"> <i class="fas fa-plus-circle"></i> </button></td>
                  </tfoot>
                </table>
              </div>
            </div>
            <!--------------TOTALES----------->  
          <div class="row mt-5">
            <div class="form-inline col-md-7">
              
            </div>
            <div class="form-inline col-md-5">
              <label class="" for="">Totales: </label>
              <input style="width:120px;" value="0.00" readonly type="text" class="form-control form-control-sm mb-2 mr-sm-2 text-right font-weight-bold" name="total_cargos" id="total_cargos">
              <input style="width:120px;" value="0.00" readonly type="text" class="form-control form-control-sm mb-2 mr-sm-2 text-right font-weight-bold" name="total_abonos" id="total_abonos">
            </div>
          </div>

            <button type="submit" id="save_poliza_partida" type="button" class="btn btn-primary">Guardar</button>
        </form> 
      </div>
    </div>
  </div>

 <!----------------------------- FIN MODAL POLIZA MOVIMIENTOS--------------------------------->
  @else
    @include('default.denied')
  @endif
@endsection

@push('scripts')
  @if( auth()->user()->can('Create polizas') )
  <style media="screen">
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
  </style>

  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2-bootstrap.min.css') }}" type="text/css" />
  <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/select2/dist/js/i18n/es-MX.js') }}" type="text/javascript"></script>


  <link href="{{ asset('bower_components/bootstrap4-toggle-master/css/bootstrap4-toggle.min.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('bower_components/bootstrap4-toggle-master/js/bootstrap4-toggle.min.js')}}"></script>

  
  <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
  <script src="{{ asset('plugins/momentupdate/moment-with-locales.js') }}" type="text/javascript"></script>
  <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
  <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

  <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
  <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>

  <script src="{{ asset('bower_components/datatables_bootstrap_4/datatables.js')}}" charset="utf-8"></script>
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css" rel="stylesheet" />
  

  <!-- Main Quill library -->
  <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>

  <!-- Theme included stylesheets -->
  <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <script src="{{ asset('js/admin/accounting/polizas.js?v=1.0')}}"></script>
  <script src="{{ asset('js/admin/accounting/create_polizas.js?v=1.0')}}"></script>

  <style media="screen">
    .white {background-color: #ffffff;}
    
    .select2-selection__rendered {
      line-height: 36px !important;
      padding-left: 15px !important;
    }
    .select2-selection {
      height: 34px !important;
    }
    .select2-selection__arrow {
      height: 28px !important;
    }
    
    th { font-size: 12px !important; }
    td { font-size: 12px !important; }

    #table_filter_fact tbody tr td {
      padding: 0.2rem 0.5rem;
      height: 38px !important;
    }

  </style>
  @else
  @endif
@endpush
