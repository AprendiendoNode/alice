$(function() {
  moment.locale('es');
  $('#datepickerMonthticket').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "years",
    minViewMode: "months",
  });
  ticket_table();
});

var mesyearnow = moment().format("YYYY-MM");
$('#datepickerMonthticket').val(mesyearnow);
$('#datepickerMonthticket').children().val(mesyearnow);

$('.btn_search').on('click', function(){
  ticket_table();
});

function ticket_table() {
  var objData = $('#search_tickets').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/get_table_allticket",
      data: objData,
      success: function (data){
        gen_ticket_table(data, $("#table_tickets"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function gen_ticket_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_allticket);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
  vartable.fnAddData([
    status.itc,
    status.open,
    status.pending,
    status.hold,
    status.solved,
    status.closed,
    status.all,
    ]);
  });
}

var Configuration_table_responsive_allticket= {
        "order": [[ 1, "asc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
        "columnDefs": [
            {
                "targets": 0,
                "width": "1%",
                "className": "text-center",
            },
            {
                "targets": 1,
                "width": "0.2%",
                "className": "text-center",
            },
            {
                "targets": 2,
                "width": "0.2%",
                "className": "text-center",
            },
            {
                "targets": 3,
                "width": "0.2%",
                "className": "text-center",
            },
            {
                "targets": 4,
                "width": "0.2%",
                "className": "text-center",
            },
            {
                "targets": 5,
                "width": "0.2%",
                "className": "text-center",
            },
            {
                "targets": 6,
                "width": "0.2%",
                "className": "text-center",
            }
        ],
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
          {
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> Excel',
            titleAttr: 'Excel',
            title: function ( e, dt, node, config ) {
              var ax = 'Estadisticas de tickets';
              return ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-secondary')
            },
            exportOptions: {
                columns: [ 0,1,2,3 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-success',
          },
          {
            extend: 'csvHtml5',
            text: '<i class="fas fa-file-csv"></i> CSV',
            titleAttr: 'CSV',
            title: function ( e, dt, node, config ) {
              var ax = 'Estadisticas de tickets';
              return ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-secondary')
            },
            exportOptions: {
                columns: [ 0,1,2,3 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-info',
          },
          {
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf"></i>  PDF',
            title: function ( e, dt, node, config ) {
              var ax = 'Estadisticas de tickets';
              return ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-secondary')
            },
            exportOptions: {
                columns: [ 0,1,2,3 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-danger',
          }
        ],
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
            },
            'select': {
                'rows': {
                    _: "%d Filas seleccionadas",
                    0: "Haga clic en una fila para seleccionarla",
                    1: "Fila seleccionada 1"
                }
            }
        },
};
