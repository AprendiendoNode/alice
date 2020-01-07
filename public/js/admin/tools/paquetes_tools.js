$(function() {
	$('#date_to_search').datepicker({
		language: 'es',
		format: "yyyy-mm",
		viewMode: "months",
		minViewMode: "months",
		endDate: '1m',
		autoclose: true,
		clearBtn: true
	});
	$('#date_to_search').val('').datepicker('update');
	get_info_paquetes();
});
$('#boton-aplica-filtro').on('click', function(){
	get_info_paquetes();
});
$('#boton-aplica-filtro_todos').on('click', function(){
	get_info_paquetes_all();
});
function get_info_paquetes(){
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/get_paquetes_month",
      data: objData,
      success: function (data){
        table_paquetes(data, $("#table_paquetes"));
      },
      error: function (data) {
        console.log('Error:', data.statusText);
      }
  });
}
function get_info_paquetes_all() {
	var _token = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
	  type: "POST",
	  url: "/get_paquetes_all",
	  data: { _token : _token },
	  success: function (data){
	    table_paquetes(data, $("#table_paquetes"));
	  },
	  error: function (data) {
	    console.log('Error:', data.statusText);
	  }
	});
}
function table_paquetes(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_customers);
  vartable.fnClearTable();
  $.each(datajson, function(index, information){
    // var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    // if (information.status == '0') {
    //   badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    // }
    vartable.fnAddData([
      information.service_name,
      information.nombre,
      information.apellido,
      information.wificode,
      information.reservation_id,
      information.owner,
      information.site,
      information.service_price,
      information.created_at,
      information.expiration
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
        title: 'Clientes',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn btn-success btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Clientes',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
        titleAttr: 'CSV',
        className: 'btn btn-primary btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3]
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