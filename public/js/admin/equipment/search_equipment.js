$(function() {
    $('.input-daterange').datepicker({language: 'es', format: "yyyy-mm-dd",});
    general_table_equipment();
});

$(".btn-search-range").on("click", function () {
  var hotel_origen = $('#select_one').val();
  var date_a = $('input[name="date_start"]').val();
  var date_b = $('input[name="date_end"]').val();
  var status = $('#select_status').val();
  if ( date_a == '' || date_b == '' || status == ''){
    menssage_toast('Mensaje', '2', 'Ingrese un rango de fechas y estatus para continuar!' , '3000');
  }
  else {
    general_table_equipment();
  }
});


function general_table_equipment() {
  var _token = $('input[name="_token"]').val();
  var date_a = $('input[name="date_start"]').val();
  var date_b = $('input[name="date_end"]').val();
  var status = $('#select_status').val();

  $.ajax({
      type: "POST",
      url: "/search_range_equipament_all",
      data: { inicio: date_a, fin: date_b,  stat : status, _token : _token},
      success: function (data){
        table_consumption_remove(data, $("#table_equipament"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_consumption_remove(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.Nombre_hotel,
      status.name,
      status.Nombre_marca,
      status.MAC,
      status.Serie,
      status.ModeloNombre,
      "<center><kbd style='background-color:grey'>"+status.Nombre_estado+"</kbd></center>",
      status.Fecha_Baja,
    ]);
  });
}

$("#btn_search_mac").on("click", function () {
  var mac = $('#mac_input').val();

  if ( mac == '' || mac.length < 4){
    menssage_toast('Mensaje', '2', 'Ingrese datos en el campo de mac, minimo 4 caracteres.' , '3000');
  }
  else {
    general_tabla_search();
  }
});

function general_tabla_search() {
  var _token = $('input[name="_token"]').val();
  var mac = $('#mac_input').val();


  $.ajax({
      type: "POST",
      url: "/get_mac_res",
      data: { _token : _token, mac_input: mac },
      success: function (data){
        //console.log(data);
        tabla_search_mac(data, $('#table_buscador'));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });

}

function tabla_search_mac(datajson, table) {
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.Nombre_hotel,
      status.name,
      status.Nombre_marca,
      status.MAC,
      status.Serie,
      status.ModeloNombre,
      "<center><kbd style='background-color:grey'>"+status.Nombre_estado+"</kbd></center>",
      status.Fecha_Registro,
    ]);
  });
}

/*
*   Busqueda de salida de equipos de bodega
*/

$("#btn_search_equip_departures").on("click", function(){
  var _token = $('input[name="_token"]').val();
  var date_start = $("#date_start_salida").val();
  var date_end = $("#date_end_salida").val();

  $.ajax({
      type: "POST",
      url: "/get_equip_departure",
      data: { date_start: date_start, date_end: date_end ,_token : _token},
      success: function (data){
        console.log(data);
        tabla_search_equip_departure(data, $('#tabla_departures'));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });

})

function tabla_search_equip_departure(datajson, table) {
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_departures);
  vartable.fnClearTable();
  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.fecha,
      status.origen,
      status.destino,
      status.equipo,
      status.mac,
      status.serie,
      status.modelo,
    ]);
  });
}

var Configuration_table_responsive_departures= {
        "order": [[ 1, "asc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "columnDefs": [
            {
                "targets": 0,
                "width": "0.5%",
                "className": "text-center",
            },
            {
              "targets": 1,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 2,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 3,
              "width": "0.5%",
              "className": "text-center",
            },
            {
              "targets": 4,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 5,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 6,
              "width": "0.5%",
              "className": "text-center",
            }
        ],
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
          {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Excel',
            titleAttr: 'Excel',
            title: function ( e, dt, node, config ) {
              var ax = '';
              if($('input[name="date_start_salida"]').val() != ''){
                ax= '- Periodo: ' + $('input[name="date_start_salida"]').val() + ' - ' + $('input[name="date_end_salida"]').val();
              }
              else {

              }
              return 'Reporte de salida de bodega '+ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5,6 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-success',
          },
          {
            extend: 'csvHtml5',
            text: '<i class="fa fa-file-text-o"></i> CSV',
            titleAttr: 'CSV',
            title: function ( e, dt, node, config ) {
              var ax = '';
              if($('input[name="date_start_salida"]').val() != ''){
                ax= '- Periodo: ' + $('input[name="date_start_salida"]').val() + ' - ' + $('input[name="date_end_salida"]').val();
              }else{

              }

              return 'Reporte de salida de bodega '+ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5,6 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-info',
          },
         {
            extend: 'pdf',
            text: '<i class="fa fa-file-pdf-o"></i>  PDF',
            title: function ( e, dt, node, config ) {
              var ax = '';
              if($('input[name="date_start_salida"]').val() != ''){
                ax= '- Periodo: ' + $('input[name="date_start_salida"]').val() + ' - ' + $('input[name="date_end_salida"]').val();
              }else{

              }

              return 'Reporte de salida de bodega '+ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5,6 ],
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
