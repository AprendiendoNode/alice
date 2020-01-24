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
                      @forelse ($list_status as $key => $value)
                        <option value="{{ $key }}"> {{ $value }} </option>
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
            <div class="table-responsive table-data table-dropdown">
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

    <script src="{{ asset('plugins/momentupdate/moment.js')}}"></script>
    <link href="{{ asset('plugins/daterangepicker-master/daterangepicker.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('plugins/daterangepicker-master/daterangepicker.js')}}"></script>

    <script src="{{ asset('plugins/jquery-wizard-master-two/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('plugins/jquery-wizard-master-two/additional-methods.js')}}"></script>
    <script type="text/javascript">
      $(function() {
        $("#form").validate({
          ignore: "input[type=hidden]",
          errorClass: "text-danger",
          successClass: "text-success",
          errorPlacement: function (error, element) {
              var attr = $('[name="'+element[0].name+'"]').attr('datas');
              if (element[0].id === 'fileInput') {
                error.insertAfter($('#cont_file'));
              }
              else {
                if(attr == 'filter_date_from'){
                  error.insertAfter($('#date_from'));
                }
                else if (attr == 'filter_date_to'){
                  error.insertAfter($('#date_to'));
                }
                else {
                  error.insertAfter(element);
                }
              }
            },
            rules: {

            },
            messages: {
            },
            // debug: true,
            // errorElement: "label",
            submitHandler: function(e){
              var form = $('#form')[0];
              var formData = new FormData(form);
              $.ajax({
                type: "POST",
                url: "/purchases/view_purchases_search",
                data: formData,
                contentType: false,
                processData: false,
                success: function (data){
                  // if (typeof data !== 'undefined' && data.length > 0) {console.log(data.length);}else {}
                  table_filter(data, $("#table_filter_fact"));
                },
                error: function (err) {
                  Swal.fire({
                     type: 'error',
                     title: 'Oops...',
                     text: err.statusText,
                   });
                }
              });
            }
        });
      });


      function table_filter(datajson, table){
        table.DataTable().destroy();
        var vartable = table.dataTable(Configuration_table_responsive_purchases);
        vartable.fnClearTable();
        $.each(JSON.parse(datajson), function(index, information){
          var status = information.status;
          if (parseInt(status) == 1) {
              html = '<span class="badge badge-info">Activo</span>';
          } else if (parseInt(status) == 0) {
              html = '<span class="badge badge-primary">Cancelado</span>';
          }
          vartable.fnAddData([
            information.id,
            information.name,
            information.date,
            information.payment_terms,
            information.payment_ways,
            information.currency,
            information.amount_total,
            html
          ]);
        });
      }
      var Configuration_table_responsive_purchases = {
        "columnDefs": [
            {
                "targets": 10,
                "className": "text-center",
            },
            {
                "targets": 11,
                "className": "text-center",
            }
        ],
        dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          "order": [[ 7, "asc" ]],
          buttons: [

            {
              extend: 'excelHtml5',
              title: 'Facturas',
              init: function(api, node, config) {
                 $(node).removeClass('btn-secondary')
              },
              text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
              titleAttr: 'Excel',
              className: 'btn btn-success btn-sm',
              exportOptions: {
                  columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
              },
            },
            {
              extend: 'csvHtml5',
              title: 'Facturas',
              init: function(api, node, config) {
                 $(node).removeClass('btn-secondary')
              },
              text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
              titleAttr: 'CSV',
              className: 'btn btn-primary btn-sm',
              exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5]
              },
            }
        ],
        "processing": true,
        language:{
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "<i class='fa fa-search'></i> Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
          },
          "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
        }
      };
    </script>
  @else
  @endif
@endpush
