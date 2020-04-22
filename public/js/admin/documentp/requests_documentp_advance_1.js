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

function setStatusFactura(id, newValue){
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/set_statusfact_documentp_advance",
      data: { id_doc : id, id_status : newValue, _token : _token },
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

function setServicioMensual(id_doc, serv_mensual){
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/set_servmensual_documentp",
      data: { id : id_doc, servicio_mensual : serv_mensual, _token : _token },
      success: function (data){
        console.log(data);
        if(data.status == 200){
          menssage_toast('Mensaje', '3', 'Serv. mensual actualizado' , '2000');
        }else{
          menssage_toast('Error', '2', 'Ocurrio un error inesperado' , '3000');
        }
      },
      error: function (data) {
        console.log('Error:', data);
        menssage_toast('Error', '2', 'Ocurrio un error inesperado' , '3000');
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
        //console.log(data);
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
  let datajson_result = datajson.filter(data => data.status != 'Denegado' && data.alert != 4);
  let color = 'red';
  $.each(datajson_result, function(index, data){
    //Verifica el estado del proyecto y lo actualiza en base a sus fechas
    /*if(Math.floor(data.total_global)==100 && Math.floor(data.presupuesto.slice(0,-1))>=100){
      color = 'green';
      setAlert(data.id, 3);//Estatus 3 verde
    }else{

    var current_date= moment().format('YYYY-MM-DD'); //Fecha actual

    var limit_date= moment(data.fecha_inicio).format('YYYY-MM-DD')//fecha inicial proyectos
    var fecha_fin =  moment(data.fecha_fin).format('YYYY-MM-DD')//fecha final proyectos


    var limit_date2=moment(data.fecha_entrega_ea).format('YYYY-MM-DD')//fecha compras

    var limit_date_plus_seven = moment(data.fecha_inicio).add(7,'days').format('YYYY-MM-DD'); //fecha proyectos + 7 dias
    var result_dates = moment(current_date).isBetween(limit_date,limit_date_plus_seven);//entre fecha proyectos y fecha proyectos + 7 dias
    //console.log(limit_date);
    //console.log(limit_date_plus_seven);
    //console.log(result_dates);

    if(data.alert!=1){//Primero los que estan en riesgo
    if(data.fecha_inicio!='-' && data.fecha_entrega_ea!='-'){
      //var current_date= new Date().toISOString().slice(0,10);
      //var limit_date= new Date(data.fecha_inicio).toISOString().slice(0,10);
      //var limit_date2=new Date(data.fecha_entrega_ea).toISOString().slice(0,10);
      if(!current_date<limit_date){
        setAlert(data.id, 1);
        data.alert=1;
      }
      if(!current_date<limit_date2){
        setAlert(data.id, 1);
        data.alert=1;
      }
    }else{
        setAlert(data.id, 1);
        data.alert=1;
    }


    }
    //Despues verificamos si existe alguno en atencion (a tiempo).
    if(result_dates){
      setAlert(data.id, 2);
      data.alert=2;
      current_date='';
    }

  }*/
  var dias_instalacion = moment(data.fecha_fin).diff(moment(data.fecha_inicio),'days')+1;
  var dias_compras = moment(data.fecha_entrega_ena).diff(moment(data.fecha_entrega_ea),'days')+1;
  var dias_compras_ena = moment().diff(moment(data.fecha_entrega_ena),'days')+1;
  var dias_compras_ea = moment().diff(moment(data.fecha_entrega_ea),'days')+1;

  var avance_prop=eval_avance_prop(data.fecha_inicio,data.fecha_fin);//Evaluamos el avance propuesto
  var avance_prop_ena = eval_avance_prop_comp(dias_compras_ena,dias_compras);
  var avance_prop_ea = eval_avance_prop_comp(dias_compras_ea,dias_compras);

  var eval_avance_inst_ = eval_avance_inst(data.total_global,avance_prop);
  var eval_avance_mat_ = eval_avance_mat(data.presupuesto_mat,avance_prop_ena);
  var eval_avance_ea_ = eval_avance_ea(data.presupuesto_ea,avance_prop_ea);
  //console.log(eval_avance_inst_+'-'+eval_avance_mat_+'-'+eval_avance_ea_);
  if(eval_avance_inst_<=eval_avance_mat_){

    if(eval_avance_inst_<=eval_avance_ea_){
      setAlert(data.id, eval_avance_inst_);
      data.alert=eval_avance_inst_;
    }else {
      setAlert(data.id, eval_avance_ea_);
      data.alert=eval_avance_ea_;
    }

  }else {
    if(eval_avance_mat_<=eval_avance_ea_){
      setAlert(data.id, eval_avance_mat_);
      data.alert=eval_avance_mat_;
    }else{
      setAlert(data.id, eval_avance_ea_);
      data.alert=eval_avance_ea_;
    }

  }

    if(data.alert == 1){
      color = 'red';
    }else if(data.alert == 2) {
      color = 'yellow';
    }else if(data.alert == 3){
      color = 'green';
    }else{
      color = 'blue';
    }

    /*if(alert!=1){
    setAlert(id, 1);
  }*/
  //console.log(av_diario);
    vartable.fnAddData([
      `<div class="btn-group">
       <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-ellipsis-h"></i>
       </button>
       <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
           <a class="dropdown-item" href="javascript:void(0);" onclick="addCommentModal(this)" data-id="${data.id}" value="${data.id}"><i class="fas fa-comment-alt"></i> Añadir comentario</a>
           <a class="dropdown-item" href="javascript:void(0);" onclick="enviar(this)" data-id="${data.id}"  data-cart="${data.documentp_cart_id}" value="${data.id}"><i class="fas fa-shopping-cart"></i> Ver productos</a>
           <a class="dropdown-item" href="javascript:void(0);" onclick="uploadActaEntrega(this)" data-id="${data.id}" value="${data.id}"><i class="fas fa-upload"></i> Subir acta de entrega</a>
           <a class="dropdown-item" target="_blank" href="/documentp_invoice/${data.id}/${data.documentp_cart_id}"><span class="far fa-file-pdf"></span> Imprimir productos</a>
           <a class="dropdown-item" href="javascript:void(0);" onclick="deniega(this)" data-id="${data.id}" value="${data.id}"><i class="fas fa-ban"></i> Denegar</a>
       </div>
     </div>`,
      '<a href="javascript:void(0)" style="background-color:' + color +';" data-type="select" data-pk="'+ data.id +'" data-title="Estatus" data-value="' + data.alert + '" class="set-alert"></a>',
      data.nombre_proyecto,
      invertirFecha(data.fecha_inicio),
      invertirFecha(data.fecha_fin),
      data.fecha_fin!='-'? dias_instalacion : 'Faltan datos',
      avance_prop +'%', //Avance propuesto instalacion
      isOverdue(data.total_global,avance_prop),//Avance real instalacion
      invertirFecha(data.fecha_entrega_ena),//Entrega de materiales
      invertirFecha(data.fecha_entrega_ea),//Entrega equipo activo
      data.fecha_entrega_ena!='-'? dias_compras : 'Faltan datos',//Dias de proyecto compras
      avance_prop_ena+'%',
      avance_prop_ea+'%',
      '$' + data.total_usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      isOverdue_mat(data.presupuesto_mat,avance_prop_ena),//isOverdue(data.presupuesto.slice(0,-1),data.fecha_entrega_ea),//'<span class="badge badge-success badge-pill">'+Math.floor(data.presupuesto.slice(0,-1))+'%</span>',
      isOverdue_ea(data.presupuesto_ea,avance_prop_ea),
      data.atraso,
      data.motivo,
      //invertirFecha(data.fecha_firma),
      data.atraso_instalacion,
      data.servicio,
      '<a href="" data-type="number" data-pk="'+ data.id +'" data-title="Serv. mensual" data-value="' + data.servicio_mensual + '" class="set-servmensual">',
      data.itc,
      '<a href="javascript:void(0)" data-type="select" data-pk="'+ data.id +'" data-title="Estatus" data-value="' + data.facturando + '" class="set-facturacion">',
      //invertirFecha(data.updated_at.split(" ")[0])+" "+ data.updated_at.split(" ")[1],
      ]);
        //console.log(data.fecha_inicio);
  });
  //Esconde la columna facturacion si el ID no es el de Sandra
  if (user_id!=21) { //21
    var column = vartable.api().columns(22);//21 Es la columna de facturando,empezando por el 0 hasta el 17
    column.visible(!column.visible());
  }
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


function eval_avance_inst(avance_real,avance_propuesto){
  let real = parseFloat(avance_real).toFixed(2);
  let op_11=(avance_propuesto-11);
  let op_10=(avance_propuesto-10);
  let margen = (avance_propuesto-9);


  if(avance_propuesto<=real || margen<=real){
    //real>=100? real=100:real;
    return 3;//Green
  }
  else
  if(real<=op_10){
    if(real<=op_11){
        return 1;//Red
    }else{
      return 2; //Yellow
    }
  }
  else {
    return 1;//estado indefinido por lo que retorno red
  }

}

function eval_avance_mat(avance_real,avance_propuesto){
  let op_80100= (avance_propuesto-20);
  let op_7960= (avance_propuesto-40);
  let op_59= (avance_propuesto-41);

  if(avance_real<=avance_propuesto){
    if(avance_real<op_80100){
      if(avance_real<=op_59){
        return 1; //Red
      }else
        return 2; //Yellow
    }else{
      return 3; //Green
    }
  }else{
    return 1; //Red
  }

}

function eval_avance_ea(avance_real,avance_propuesto){
  let op_5= (avance_propuesto-5);
  let op_25= (avance_propuesto-25);
  let op_26= (avance_propuesto-26);

  if(avance_real<=avance_propuesto){
    if(avance_real<op_5){
      if(avance_real<=op_26){
        return 1; //Red
      }else
        return 2;//Yellow
    }else{
      return 3; //Green
    }
  }else{
    return 1; //Red
  }

}


function inRisk(date1,date2,id,alert){
  if(date1!='-' && date2!='-' ){
    var current_date= new Date().toISOString().slice(0,10);
    var limit_date= new Date(date1).toISOString().slice(0,10);
    var limit_date2=new Date(date2).toISOString().slice(0,10);
    if(!current_date<limit_date){

      setAlert(id, 1);
      return color = 'red';
    }
    if(!current_date<limit_date2){
      setAlert(id, 1);
      return color = 'red';
    }

  }else{
      setAlert(id, 1);
      return color = 'red';
  }
}


var Configuration_table_responsive_documentp= {
        "order": [[ 1, "asc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "fnDrawCallback": function() {
          var source_colors = [{'value': 1, 'text': 'R'}, {'value': 2, 'text': 'A'}, {'value': 3, 'text': 'V'}, {'value': 4, 'text': 'B'}];
          var source_factura = [{'value': 0, 'text': 'No'}, {'value': 1, 'text': 'Si'}, {'value': 2, 'text': 'En proceso'},{'value': 3, 'text': 'N/A'}];

          $('.set-alert').editable({
              type : 'select',
              inputclass:'text-danger',
              source: function() {
              return source_colors;
            },
            success: function(response, newValue) {
              var id = $(this).data('pk');
              setAlert(id, newValue)
              if(newValue == 1){
                $(this).css("background-color", "red");
              }else if(newValue == 2){
                $(this).css("background-color", "yellow");
              }else if(newValue == 3){
                $(this).css("background-color", "green");
              }else{
                $(this).css("background-color", "blue");
              }
            }
          });

          $('.set-facturacion').editable({
              type : 'select',
              source: function() {
              return source_factura;
            },
            success: function(response, newValue) {
              var id = $(this).data('pk');
              console.log(newValue);
              setStatusFactura(id, newValue);
            }
          });

          $('.set-servmensual').editable({
              type : 'text',
              source: function() {
              return source;
            },
            success: function(response, newValue) {
              var id = $(this).data('pk');
              console.log(newValue);
              setServicioMensual(id, newValue);
            }
          });

        },
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
              "className": "text-center cell-name",
            },
            {
              "targets": 14,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 15,
              "width": "1%",
              "className": "text-center",
              //"visible": false
            },
            {
              "targets": 16,
              "width": "1%",
              "className": "text-center ",
            },
            {
              "targets": 17,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 18,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 19,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 20,
              "width": "1%",
              "className": "text-center",
            },
           {
              "targets": 21,
              "width": "1%",
              "className": "text-center",
            },
            {
               "targets": 22,
               "width": "1%",
               "className": "text-center",
               "visible":false
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
                columns: [ 1,2,3,4,5,6,7,8,9,10,11,13,14,17,18,19 ],
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
                columns: [ 1,2,3,4,5,6,7,8,9,10,11,13,14,17,18,19],
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
                columns: [ 1,2,3,4,5,6,7,8,9,10,11,13,14,17,18,19],
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
