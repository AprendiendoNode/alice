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
  let datajson_result = datajson.filter(data => data.status != 'Denegado' && data.alert == 3);

  $.each(datajson_result, function(index, data){
  vartable.fnAddData([
    data.nombre_proyecto,
    '<span class="label label-primary">'+Math.floor(data.total_global)+'%</span>',
    '$' + data.total_usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    '<span class="label label-success">'+Math.floor(data.presupuesto.slice(0,-1))+'%</span>',
    invertirFecha(data.fecha_inicio),
    invertirFecha(data.fecha_fin),
    data.atraso,
    data.motivo,
    invertirFecha(data.fecha_firma),
    data.atraso_instalacion,
    data.servicio,
    '$' + data.servicio_mensual.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),//serviciomensual
    data.itc,
    '<a target="_blank" href="/documentp_invoice/'+ data.id + '/ '+ data.documentp_cart_id +'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir" role="button"><span class="fa fa-file-pdf-o"></span></a><a href="javascript:void(0);" onclick="enviar(this)" data-id="' + data.id +'"  data-cart="' + data.documentp_cart_id +'" value="'+data.id+'" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Ver pedido"><span class="fa fa-shopping-cart"></span></a>',
    invertirFecha(data.updated_at.split(" ")[0])+" "+ data.updated_at.split(" ")[1],
    data.comentario
    ]);
  });
}

var Configuration_table_responsive_documentp= {
        "order": [[ 1, "asc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "columnDefs": [
            {
              "targets": 0,
              "width": "1%",
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
              "className": "text-right",
            },
            {
              "targets": 3,
              "width": "1%",
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
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 9,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 10,
              "width": "1%",
              "className": "text-center ",
            },
            {
              "targets": 11,
              "width": "1%",
              "className": "text-center",
            },
            {
              "targets": 12,
              "width": "1%",
              "className": "text-center",

            },
            {
              "targets": 13,
              "width": "3%",
              "className": "text-center actions",
            },
            {
              "targets": 14,
              "width": "1%",
              "className": "text-center ",
              "visible": false
            },
            {
              "targets": 15,
              "width": "1%",
              "className": "text-center ",
              "visible": false
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
                columns: [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15 ],
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
                columns: [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15 ],
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
                columns: [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15 ],
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
