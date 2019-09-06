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
        console.log(data);
        documentp_table(data, $("#table_documentp"));
        document.getElementById("table_documentp_wrapper").childNodes[0].setAttribute("class", "form-inline");
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
  let datajson_result = datajson.filter(data => data.status != 'Denegado' && data.alert == 4);
  let color = 'red';
  $.each(datajson_result, function(index, data){
    if(data.alert == 1){
      color = 'red';
    }else if(data.alert == 2) {
      color = 'yellow';
    }else if(data.alert == 3){
      color = 'green';
    }else{
      color = 'blue';
    }
    vartable.fnAddData([
      '<a href="javascript:void(0)" style="background-color:' + color +';" data-type="select" data-pk="'+ data.id +'" data-title="Alerta" data-value="' + data.alert + '" class="set-alert">',
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
      '<a href="" data-type="number" data-pk="'+ data.id +'" data-title="Serv. mensual" data-value="' + data.servicio_mensual + '" class="set-servmensual">',
      data.itc,
      '<a href="javascript:void(0)" data-type="select" data-pk="'+ data.id +'" data-title="Estatus" data-value="' + data.facturando + '" class="set-facturacion">',
      invertirFecha(data.updated_at.split(" ")[0])+" "+ data.updated_at.split(" ")[1],
      '<a href="javascript:void(0);" onclick="addCommentModal(this)" data-id="' + data.id +'" value="'+data.id+'" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Añadir comentario"><span class="fas fa-comment-alt"></span></a><a target="_blank" href="/documentp_invoice/'+ data.id + '/ '+ data.documentp_cart_id +'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir" role="button"><span class="fas fa-file-pdf"></span></a><a href="javascript:void(0);" onclick="enviar(this)" data-id="' + data.id +'"  data-cart="' + data.documentp_cart_id +'" value="'+data.id+'" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Ver pedido"><span class="fa fa-shopping-cart"></span></a>',
      data.alert,
      data.comentario,
      data.servicio_mensual,
      data.facturando
      ]);
  });
}

var Configuration_table_responsive_documentp= {
        "order": [[ 1, "asc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "fnDrawCallback": function() {
          var source_colors = [{'value': 1, 'text': 'R'}, {'value': 2, 'text': 'A'}, {'value': 3, 'text': 'V'}, {'value': 4, 'text': 'B'}];
          var source_factura = [{'value': 0, 'text': 'No'}, {'value': 1, 'text': 'Si'}, {'value': 2, 'text': 'En proceso'}];

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
              "className": "text-center status",
            },
            {
              "targets": 1,
              "width": "2.8%",
              "className": "text-center",
            },
            {
              "targets": 2,
              "width": "0.5%",
              "className": "text-center",
            },
            {
              "targets": 3,
              "width": "0.2%",
              "className": "text-right",
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
              "width": "0.1%",
              "className": "text-center",
            },
            {
              "targets": 7,
              "width": "0.5%",
              "className": "text-center",
            },
            {
              "targets": 8,
              "width": "0.1%",
              "className": "text-center",
            },
            {
              "targets": 9,
              "width": "0.1%",
              "className": "text-center",
            },
            {
              "targets": 10,
              "width": "2%",
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
              "className": "text-center",
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
            },
            {
              "targets": 16,
              "width": "1%",
              "className": "text-center actions-button",
            },
            {
              "targets": 17,
              "width": "1%",
              "className": "text-center",
              "visible": false
            },
            {
              "targets": 18,
              "width": "1%",
              "className": "text-center",
              "visible": false
            },
            {
              "targets": 19,
              "width": "1%",
              "className": "text-center",
              "visible": false
            },
            {
              "targets": 20,
              "width": "1%",
              "className": "text-center",
              "visible": false
            }

        ],
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [

          {
            extend: 'excelHtml5',
            text: '<i class="far fa-file-excel"></i> Excel',
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
                columns: [ 1,2,3,4,5,6,7,8,9,10,11,13,17,18,19,20,15 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-success',
          },
          {
            extend: 'csvHtml5',
            text: '<i class="far fa-file-code"></i> CSV',
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
                columns: [ 1,2,3,4,5,6,7,8,9,10,11,13,17,18,19,20,15 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-info',
          },
          {
            extend: 'pdf',
            orientation: 'landscape',
            text: '<i class="far fa-file-pdf"></i>  PDF',
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
                columns: [ 1,2,3,4,5,6,7,8,9,10,11,13,17,18,19,20,15 ],
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
