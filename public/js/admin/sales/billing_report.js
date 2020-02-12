$(function () {
  $('#date_to_search').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '1m',
    autoclose: true,
    clearBtn: true
  });
  get_billing_report();
});

$("#search_info").validate({
  ignore: "input[type=hidden]",
  errorClass: "text-danger",
  successClass: "text-success",
  rules: {
  },
  messages: {
  },
  submitHandler: function(e){
    var form = $('#search_info')[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "/accounting/get_billing_report",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data){
        // console.log(data);
        table_billing(data, $("#table_billing"));
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

function get_billing_report(){
    var form = $('#search_info')[0];
    var formData = new FormData(form);
    $.ajax({
      type: "POST",
      url: "/accounting/get_billing_report",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data){
        console.log(data);
        table_billing(data, $("#table_billing"));
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

function table_billing(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_customers);
    vartable.fnClearTable();
    $.each(datajson, function(index, data){
      vartable.fnAddData([
        data.code,
        data.serie,
        data.folio,
        data.date,
        data.control_id,
        data.name,
        data.status,
        data.N,
        data.amount_untaxed,
        data.amount_discount,
        data.amount_tax,
        data.amount_tax_ret,
        data.amount_total,
        data.currency_value,
        data.uuid,
        data.key_master,
        data.reference
      ]);
    });
  }

var Configuration_table_responsive_customers = {
    dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [

        {
          extend: 'excelHtml5',
          title: 'Reporte facturación',
          init: function(api, node, config) {
             $(node).removeClass('btn-secondary')
          },
          text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
          titleAttr: 'Excel',
          className: 'btn btn-success btn-sm',
          exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
          },
        },
        {
          extend: 'csvHtml5',
          title: 'Reporte facturación',
          init: function(api, node, config) {
             $(node).removeClass('btn-secondary')
          },
          text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
          titleAttr: 'CSV',
          className: 'btn btn-primary btn-sm',
          exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
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
  