

function table_antenas(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_chlist);
  vartable.fnClearTable();

  $.each(datajson, function(index, status){

    vartable.fnAddData([
      status.name,
      eval_state(status.calendario_hoy),
      eval_state(status.documentacion_tickets),
      eval_state(status.uniforme),
      eval_state(status.llave_uniforme),
      eval_state(status.gym),
      eval_state(status.mantener_orden),
      eval_state(status.trato_cordial),
      eval_state(status.calendario_2dias),
      eval_state(status.diagnosticar_equipos),
      status.fecha
    ]);
  });

}

function table_cl_5(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_chlist);
  vartable.fnClearTable();

  $.each(datajson, function(index, status){

    vartable.fnAddData([
      status.name,
      status.Nombre_hotel,
      eval_state(status.reporte),
      eval_state(status.nps),
      eval_state(status.factura_cliente),
      eval_state(status.memoria_tecnica),
      eval_state(status.inventario_actualizado),
      status.fecha
    ]);
  });

}

function table_cl_20(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_chlist);
  vartable.fnClearTable();

  $.each(datajson, function(index, status){

    vartable.fnAddData([
      status.name,
      status.Nombre_hotel,
      eval_state(status.visita_cliente),
      eval_state(status.revisar_disp),
      eval_state(status.detectar_oportunidad),
      eval_state(status.revisar_informacion),
      eval_state(status.detecta_nuevas_oportunidades),
      eval_state(status.mantto),
      eval_state(status.backup),
      eval_state(status.revisar_renovar),
      eval_state(status.cliente_pago),
      status.fecha
    ]);
  });

}


function eval_state(state){
  switch (state) {
      case 0:
      return '<span class="iconito fecha:11 hotel:452"><i class="mes9 detractor fas fa-times-circle" style="color: #DD4D46;"></i></span>';
      break;
      case 1:
        return '<span class="iconito fecha:11 hotel:452"><i class="mes1 promotor fas fa-check-circle" style="color: #28C941;"></i></span>';
        break;
      case 2:
        return '<span class="iconito fecha:11 hotel:452"><i class="mes3 pasivo fas fa-exclamation-circle" style="color: #FEBD2E;"></i></span>';
        break;
    default:

  }
}
var Configuration_table_chlist = {
  "order": [[ 0, "asc" ]],
  paging: true,
  //"pagingType": "simple",
  Filter: true,
  searching: true,
  ordering: true,
  "select": false,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
       "<'row'<'col-sm-12'tr>>" +
       "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

  bInfo: true,
  "createdRow": function ( row, data, index ) {

},
  "footerCallback": function(row, data, start, end, display){

  },
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
}
