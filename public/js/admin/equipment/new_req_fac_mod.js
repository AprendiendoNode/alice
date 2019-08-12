$(function() {
  $(".select2").select2();
  $('select').css('font-size', '11px');
  $(".select2").select2({ width: '100%' });
});


$('.search_fact').on('click', function(e){
  var date_a = $('#select_one_fact').val();
  if ( date_a == ''){
    menssage_toast('Mensaje', '2', 'Seleccione una factura' , '3000');
  }
  else {
    general_table_equipment_fact();
  }
});

$('.search_model').on('click', function(e){
  var date_b = $('#select_one_model').val();
  if ( date_b == ''){
    menssage_toast('Mensaje', '2', 'Seleccione un modelo!' , '3000');
  }
  else {
    general_table_equipment_model();
  }
});


function general_table_equipment_fact() {
  var form = $('#rep_fact')[0];
  var formData = new FormData(form);
  $.ajax({
      type: "POST",
      url: "/search_infoeq_fact",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data){
        table_info_fact_model(data, $("#table_report_fact"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function general_table_equipment_model() {
  var form = $('#rep_model')[0];
  var formData = new FormData(form);
  $.ajax({
      type: "POST",
      url: "/search_infoeq_model",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data){
        table_info_fact_model(data, $("#table_report_model"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function table_info_fact_model(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_nfact);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.sitio,
      status.MAC,
      status.serie,
      status.modelo,
      status.costo,
      status.estado,
      status.descripcion,
      status.fecha_registro
    ]);
  });
}

var Configuration_table_responsive_nfact= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return 'Reporte';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn bg-olive custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="fa fa-file-text-o"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return 'Reporte';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        className: 'btn btn-info',
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
