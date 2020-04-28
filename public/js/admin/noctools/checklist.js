var _token = $('meta[name="csrf-token"]').attr('content');

$('#date_to_search').datepicker({
  language: 'es',
  format: "yyyy-mm-dd",
  viewMode: "months",
  minViewMode: "months",
  endDate: '0m',
  autoclose: true,
  clearBtn: true
}).datepicker("setDate",'now');
//$('#date_to_search').val('').datepicker('update');
var date=$('#date_to_search').val();
get_cl_general(date);
get_cl_diario(date);
get_cl_5_dia(date);
get_cl_20_dia(date);
get_cl_act_prin(date);
get_cl_oportunidades(date);
get_cl_instalaciones(date);
$('#btn-filtro').on('click',function(){
var date=$('#date_to_search').val();
if (date == ''){
  var date = moment().format('YYYY-MM-DD');
}
//console.log(date);
get_cl_general(date);
get_cl_diario(date);
get_cl_5_dia(date);
get_cl_20_dia(date);
get_cl_instalaciones(date);
get_cl_act_prin(date);
get_cl_oportunidades(date);
});


function get_cl_instalaciones(date) {
  $.post('get_cl_instalaciones', { _token, date }, response => {
    // console.log("Response check historial", response);
    table_instalaciones(response, $("#table_cl_instalaciones"));
  });
}

function get_cl_general(date){
  $.ajax({
    type:"POST",
    url:"/get_cl_general",
    data:{_token:_token,date:date},
    success:function(data){
      //console.log(date);
      //console.log(data);
      table_cl_general(data,$('#table_cl_general'));
    },
    error:function(data){

    }
  });

}


function get_cl_diario(date){
  $.ajax({
    type:"POST",
    url:"/get_cl_diario",
    data:{_token:_token,date:date},
    success:function(data){
      table_antenas(data,$('#table_cl_diario'));
    },
    error:function(data){

    }
  });
}

function get_cl_act_prin(date){
  $.ajax({
    type:"POST",
    url:"/get_cl_act_prin",
    data:{_token:_token,date:date},
    success:function(data){
      table_act_prin(data,$('#table_act_prin'));
    },
    error:function(data){

    }
  });
}

function get_cl_oportunidades(date){
  console.log(date);
  $.ajax({
    type:"POST",
    url:"/get_cl_oportunidades",
    data:{_token:_token,date:date},
    success:function(data){
      //console.log(data);
      table_oportunidades(data,$('#table_oportunidades'));
    },
    error:function(data){

    }
  });
}

function get_cl_5_dia(date){
  $.ajax({
    type:"POST",
    url:"/get_cl_5_dia",
    data:{_token:_token,date:date},
    success:function(data){
      table_cl_5(data,$('#table_cl_5'));
    },
    error:function(data){

    }
  });
}

function get_cl_20_dia(date){
  $.ajax({
    type:"POST",
    url:"/get_cl_20_dia",
    data:{_token:_token,date:date},
    success:function(data){
      table_cl_20(data,$('#table_cl_20'));
    },
    error:function(data){

    }
  });
}
function table_cl_general(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_chlist);
  vartable.fnClearTable();

  $.each(datajson, function(index, status){

    vartable.fnAddData([
      status.itc,
      status.regs_d,//diario
      status.dias_d,
      eval_diario(status.regs_d,status.dias_d),
      status.ultima_act_d,
      eval_entregados(status.regs_5,status.ultima_act_5,5),//5 dia
      status.dias_5,
      evalua_520(status.regs_5,status.ultima_act_5,5),
      status.ultima_act_5,
      eval_entregados(status.regs_20,status.ultima_act_20,20),//20 dia
      status.dias_20,
      evalua_520(status.regs_20,status.ultima_act_20,20),
      status.ultima_act_20,
      status.regs_inst,//instalaciones
      status.ultima_act_inst,
      status.regs_op,//oportunidades
      status.ultima_act_op,
      promedio(status.regs_d,status.dias_d,status.regs_5,status.ultima_act_5,status.regs_20,status.ultima_act_20)
    ]);

  });


}
function promedio(regs_d,dias_d,regs_5,ult_5,regs_20,ult_20){
let per = ((100/dias_d)*regs_d).toFixed(2);//diario
//console.log(per);
let entregados_5= eval_entregados(regs_5,ult_5,5);
let entregados_20= eval_entregados(regs_20,ult_20,20);

var result_5=get_advance(entregados_5);//5 dia
var result_20=get_advance(entregados_20);//20 dia

let promedio = ((parseFloat(per)+parseInt(result_5)+parseInt(result_20))/3).toFixed(2);
var badge=set_badge(promedio);
return badge;
//return promedio.toFixed(2);

}
function get_advance(result){
  switch (true) {
    case result===null :
        return 0;
      break;
    case result!=0 :
        return 100;
      break;
    case result==0:
      return 0;
      break;

    default: return 0;

  }
}
function eval_diario(entregados,referencia){
let per = ((100/referencia)*entregados).toFixed(2);
var badge=set_badge(per);
return badge;
}
function set_badge(per){
  switch (true) {
    case per>=86:
        return '<span class="badge badge-success badge-pill">'+per.toString().replace(/\.00$/,'')+'%</span>';
      break;

    case per>=50:
      return '<span class="badge badge-warning badge-pill">'+per.toString().replace(/\.00$/,'')+'%</span>';
      break;

    case per<=49:
      return '<span class="badge badge-danger badge-pill">'+per.toString().replace(/\.00$/,'')+'%</span>';
      break;

    default: return '<span class="badge badge-dark badge-pill">N/A</span>';

  }
}
function eval_entregados(entregados,fecha,type){
  if(type==5){

    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth()+1;
    var fecha_entrega = moment(fecha);
    var begin_date= moment(year+'-'+'0'+month+'-01');
    var end_date = moment(year+'-'+'0'+month+'-05');

    var flag=moment(fecha_entrega).isBetween(begin_date,end_date,'days', '[]');//[] para que sea inclusivo y () para que sea exclusivo
    if (flag==true){
      return entregados;
    }
    else{
      return 0;
    }
  }
  else{//type 20

    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth()+1;
    var fecha_entrega = moment(fecha);
    var begin_date= moment(year+'-'+'0'+month+'-01');
    var end_date = moment(year+'-'+'0'+month+'-20');

    var flag=moment(fecha_entrega).isBetween(begin_date,end_date,'days', '[]');//[] para que sea inclusivo y () para que sea exclusivo
    if (flag==true){
      return entregados;
    }
    else{
      return 0;
    }

  }

}
function evalua_520(entregados,fecha,type){
  var result= eval_entregados(entregados,fecha,type);
  //console.log(result);
switch (true) {
  case result===null :
      return '<span class="badge badge-dark badge-pill">N/A</span>';
    break;
  case result!=0 :
      return '<span class="badge badge-success badge-pill">100%</span>';
    break;
  case result==0:
    return '<span class="badge badge-danger badge-pill">0%</span>';
    break;

  default: return '<span class="badge badge-dark badge-pill">N/A</span>';

}

}

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

function table_act_prin(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_chlist);
  vartable.fnClearTable();

  $.each(datajson, function(index, status){

    vartable.fnAddData([
      status.name,
      eval_state(status.correos),
      eval_state(status.tickets),
      eval_state(status.visita),
      eval_state(status.encuestas),
      eval_state(status.seguimiento_inst),
      eval_state(status.levantamiento),
      eval_state(status.mantto),
      eval_state(status.llamadas),
      status.Otros,
      status.fecha
    ]);
  });

}

function table_oportunidades(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_chlist);
  vartable.fnClearTable();

  $.each(datajson, function(index, status){

    vartable.fnAddData([
      status.name,
      eval_state(status.oportunidad_cobertura),
      eval_state(status.oportunidad_enlaces),
      eval_state(status.oportunidad_cctv),
      eval_state(status.deteccion_propiedades),
      eval_state(status.deteccion_soporte),
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

function table_instalaciones(data, table) {
  table.DataTable().destroy();
  const vartable = table.dataTable(Configuration_table_chlist);
  vartable.fnClearTable();
  $.each(data, (index, status) => {
    vartable.fnAddData([
      status.itc,
      status.sitio,
      eval_state(status.levantamiento),
      eval_state(status.horario_inicio),
      eval_state(status.cotizacion_alcances),
      eval_state(status.documento_p),
      eval_state(status.documento_kickoff),
      eval_state(status.junta_operativa),
      eval_state(status.planos_inmueble),
      eval_state(status.diagramas_red_sembrado),
      eval_state(status.realizo_entrega_proyecto),
      eval_state(status.entrega_materiales),
      eval_state(status.equipo_activo),
      eval_state(status.rack_tierra_fisica),
      eval_state(status.rack_corriente_regulada),
      eval_state(status.contratista_UTP_FO),
      eval_state(status.antenas_ruckus),
      eval_state(status.revisar_equipo),
      eval_state(status.puebas_funcionamiento),
      eval_state(status.revision_enlace),
      eval_state(status.revision_enlace_conf),
      eval_state(status.actualizar_proyecto_alice),
      eval_state(status.bitacora_cierre),
      eval_state(status.memoria_tecnica),
      eval_state(status.memoria_foto),
      eval_state(status.carta_entrega),
      status.created_at
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
