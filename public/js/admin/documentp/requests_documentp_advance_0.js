$(function() {
  //Configuracion de x-editable jquery
  $.fn.editable.defaults.mode = 'popup';
  $.fn.editable.defaults.ajaxOptions = {type:'POST'};
  moment.locale('es');
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
  table_permission_zero();

});

$("#boton-aplica-filtro").click(function(event) {
  table_permission_zero();
});

function setAlert(id_doc, id_alert){
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/set_alert_documentp_advance",
      data: { id_doc : id_doc, id_alert : id_alert, _token : _token },
      success: function (data){
        if(data == "true"){
          menssage_toast('Mensaje', '3', 'Actualizado' , '2000');
        }else{
          menssage_toast('Error', '2', 'Ocurrio un error inesperado' , '3000');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function table_permission_zero() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/get_documentp_advance",
      data: objData,
      success: function (data){
        console.log(data);
        documentp_table(data, $("#table_documentp"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function documentp_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_documentp);
  vartable.fnClearTable();
  let datajson_result = datajson.filter(data => data.status != 'Denegado');

  $.each(datajson_result, function(index, data){
  /*vartable.fnAddData([
    data.nombre_proyecto,
    '<span class="badge badge-dark badge-pill">'+Math.floor(data.total_global)+'%</span>',
    '$' + data.total_usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    '<span class="badge badge-success badge-pill">'+Math.floor(data.presupuesto.slice(0,-1))+'%</span>',
    invertirFecha(data.fecha_inicio),
    invertirFecha(data.fecha_fin),
    data.atraso,
    data.motivo,
    invertirFecha(data.fecha_firma),
    data.atraso_instalacion,
    data.servicio,
    '$' + data.servicio_mensual.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    data.itc,
    `<div class="btn-group">
        <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="javascript:void(0);" onclick="enviar(this)" data-id="${data.id}"  data-cart="${data.documentp_cart_id}" value="${data.id}"><i class="fas fa-shopping-cart"></i> Ver productos</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="uploadActaEntrega(this)" data-id="${data.id}" value="${data.id}"><i class="fas fa-upload"></i> Subir acta de entrega</a>
            <a class="dropdown-item" target="_blank" href="/documentp_invoice/${data.id}/${data.documentp_cart_id}"><span class="far fa-file-pdf"></span> Imprimir productos</a>
        </div>
      </div>`,
    invertirFecha(data.updated_at.split(" ")[0])+" "+ data.updated_at.split(" ")[1]
  ]);*/
  var dias_instalacion = moment(data.fecha_fin).diff(moment(data.fecha_inicio),'days')+1;
  var dias_compras = moment(data.fecha_entrega_ena).diff(moment(data.fecha_entrega_ea),'days')+1;
  var dias_compras_ena = moment().diff(moment(data.fecha_entrega_ena),'days')+1;
  var dias_compras_ea = moment().diff(moment(data.fecha_entrega_ea),'days')+1;

  var avance_prop=eval_avance_prop(data.fecha_inicio,data.fecha_fin);//Evaluamos el avance propuesto
  var avance_prop_ena = eval_avance_prop_comp(dias_compras_ena,dias_compras);
  var avance_prop_ea = eval_avance_prop_comp(dias_compras_ea,dias_compras);

  vartable.fnAddData([
    `<div class="btn-group">
        <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="javascript:void(0);" onclick="enviar(this)" data-id="${data.id}"  data-cart="${data.documentp_cart_id}" value="${data.id}"><i class="fas fa-shopping-cart"></i> Ver productos</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="uploadActaEntrega(this)" data-id="${data.id}" value="${data.id}"><i class="fas fa-upload"></i> Subir acta de entrega</a>
            <a class="dropdown-item" target="_blank" href="/documentp_invoice/${data.id}/${data.documentp_cart_id}"><span class="far fa-file-pdf"></span> Imprimir productos</a>
        </div>
      </div>`,
    data.nombre_proyecto,
    isOverdue(data.total_global,avance_prop),//Avance real instalacion
    invertirFecha(data.fecha_entrega_ena),//Entrega de materiales
    invertirFecha(data.fecha_entrega_ea),//Entrega equipo activo
    data.fecha_entrega_ena!='-'? dias_compras : 'Faltan datos',//Dias de proyecto compras
    '$' + data.total_usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    isOverdue_mat(data.presupuesto_mat,avance_prop_ena),//isOverdue(data.presupuesto.slice(0,-1),data.fecha_entrega_ea),//'<span class="badge badge-success badge-pill">'+Math.floor(data.presupuesto.slice(0,-1))+'%</span>',
    isOverdue_ea(data.presupuesto_ea,avance_prop_ea),
    data.atraso,
    data.fecha_firma,
    data.motivo,
    //invertirFecha(data.fecha_firma),
    data.atraso_instalacion,
    data.servicio,
    data.itc,
    //invertirFecha(data.updated_at.split(" ")[0])+" "+ data.updated_at.split(" ")[1],
    ]);
  });
}

function eval_avance_prop(fecha_inicio,fecha_fin){//Evalua el avance propuesto dadas dos fechas (inicio y fin) conrespecto a la fecha actual

let inicio = moment(fecha_inicio);
let fin = moment(fecha_fin);
let hoy = moment();
let dias = fin.diff(inicio,'days')+1;
//console.log(dias);
if(fin<hoy || dias==0 || dias==1){//Si ya nos pasamos de la fecha o solo hay 1 dia para el proyecto
  return 100;
}else if(isNaN(dias)){ //Si faltan datos
return 'Faltan datos';
}
else {
  let dias_porcent = hoy.diff(inicio,'days')+1;
  //console.log('dias transcurridos: '+ dias_porcent);
  let av_diario = 100/parseInt(dias);
return (av_diario*dias_porcent).toFixed(2);
}

}

function eval_avance_prop_comp(dias_transcurridos,dias_proyecto){
  //console.log(dias_transcurridos);
  //console.log(dias_proyecto);
  //console.log(avance+'---');
  if(dias_transcurridos<0){
    var avance=0;
  return avance;
  }else
  if(dias_proyecto<=dias_transcurridos || dias_proyecto==0 || dias_proyecto==1){
    var avance=100;
    return avance;
  }else{
    var avance = (dias_transcurridos/dias_proyecto)*100;
    if(isNaN(avance)){
      return 'Faltan datos';
    }
    return avance.toFixed(2);
  }

}
function isOverdue(avance_real,avance_propuesto){
  let real = parseFloat(avance_real).toFixed(2);
  let op_11=(avance_propuesto-11);
  let op_10=(avance_propuesto-10);
  let margen = (avance_propuesto-9);


  if(avance_propuesto<=real || margen<=real){
    //real>=100? real=100:real;
    return '<span class="badge badge-success badge-pill">'+real.toString().replace(/\.00$/,'')+'%</span>';
  }
  else
  if(real<=op_10){
    if(real<=op_11){
        return '<span class="badge badge-danger badge-pill">'+real.toString().replace(/\.00$/,'')+'%</span>';
    }else{
      return '<span class="badge badge-warning badge-pill">'+real.toString().replace(/\.00$/,'')+'%</span>';
    }
  }
  else {
    return '<span class="badge badge-dark badge-pill">'+real.toString().replace(/\.00$/,'')+'%</span>';
  }

}

function isOverdue_mat(avance_real,avance_propuesto){
  let op_80100= (avance_propuesto-20);
  let op_7960= (avance_propuesto-40);
  let op_59= (avance_propuesto-41);

  if(avance_real<=avance_propuesto){
    if(avance_real<op_80100){
      if(avance_real<=op_59){
        return '<span class="badge badge-danger badge-pill">'+avance_real.toString().replace(/\.00$/,'')+'%</span>';
      }else
        return '<span class="badge badge-warning badge-pill">'+avance_real.toString().replace(/\.00$/,'')+'%</span>';
    }else{
      return '<span class="badge badge-success badge-pill">'+avance_real.toString().replace(/\.00$/,'')+'%</span>';
    }
  }else{
    return '<span class="badge badge-dark badge-pill">'+avance_real.toString().replace(/\.00$/,'')+'%</span>';
  }

}

function isOverdue_ea(avance_real,avance_propuesto){
  let op_5= (avance_propuesto-5);
  let op_25= (avance_propuesto-25);
  let op_26= (avance_propuesto-26);

  if(avance_real<=avance_propuesto){
    if(avance_real<op_5){
      if(avance_real<=op_26){
        return '<span class="badge badge-danger badge-pill">'+avance_real.toString().replace(/\.00$/,'')+'%</span>';
      }else
        return '<span class="badge badge-warning badge-pill">'+avance_real.toString().replace(/\.00$/,'')+'%</span>';
    }else{
      return '<span class="badge badge-success badge-pill">'+avance_real.toString().replace(/\.00$/,'')+'%</span>';
    }
  }else{
    return '<span class="badge badge-dark badge-pill">'+avance_real.toString().replace(/\.00$/,'')+'%</span>';
  }

}



var Configuration_table_responsive_documentp= {
        "order": [[ 1, "asc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "columnDefs": [
            {
              "targets": 0,
              "width": "0.5%",
              "className": "text-center cell-large",
            },
            {
              "targets": 1,
              "width": "2.8%",
              "className": "text-center status",
            },
            {
              "targets": 2,
              "width": "0.5%",
              "className": "text-center",
            },
            {
              "targets": 3,
              "width": "0.2%",
              "className": "text-center",
            },
            {
              "targets": 4,
              "width": "0.5%",
              "className": "text-center",
            },
            {
              "targets": 5,
              "width": "0.5%",
              "className": "text-center",
            },
            {
              "targets": 6,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 7,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 8,
              "width": "2%",
              "className": "text-center",
            },
            {
              "targets": 9,
              "width": "0.1%",
              "className": "text-center",
            },
            {
              "targets": 10,
              "width": "0.1%",
              "className": "text-center",
            },
            {
              "targets": 11,
              "width": "2%",
              "className": "text-center",
            },
            {
              "targets": 12,
              "width": "1%",
              "className": "text-center ",
            },
            {
              "targets": 13,
              "width": "1%",
              "className": "text-center ",
            },
            {
              "targets": 14,
              "width": "1%",
              "className": "text-center cell-name",
            },

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
              if($('input[name="date_to_search"]').val() != ''){
                ax= '- Periodo: ' + $('input[name="date_to_search"]').val();
              }
              else {
                txx='- Periodo: ';
                var fecha = new Date();
                var ano = fecha.getFullYear();
                var mes = fecha.getMonth()+1;
                var fechita = ano+'-'+mes;
                ax = txx+fechita;
              }
              return 'Avance de proyectos ';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14 ],
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
              if($('input[name="date_to_search"]').val() != ''){
                ax= '- Periodo: ' + $('input[name="date_to_search"]').val();
              }
              else {
                txx='- Periodo: ';
                var fecha = new Date();
                var ano = fecha.getFullYear();
                var mes = fecha.getMonth()+1;
                var fechita = ano+'-'+mes;
                ax = txx+fechita;
              }
              return 'Avance de proyectos ';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-info',
          },
          {
            extend: 'pdf',
            orientation: 'landscape',
            text: '<i class="fa fa-file-pdf-o"></i>  PDF',
            title: function ( e, dt, node, config ) {
              var ax = '';
              if($('input[name="date_to_search"]').val() != ''){
                ax= '- Periodo: ' + $('input[name="date_to_search"]').val();
              }
              else {
                txx='- Periodo: ';
                var fecha = new Date();
                var ano = fecha.getFullYear();
                var mes = fecha.getMonth()+1;
                var fechita = ano+'-'+mes;
                ax = txx+fechita;
              }
              return 'Avance de proyectos ';
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
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
    //Formatea la fecha dd/mm/aaaa
        function invertirFecha(f) {
           var fechaDividida = f.split("-");
           var fechaInvertida = fechaDividida.reverse();
           return fechaInvertida.join("-");
       }
