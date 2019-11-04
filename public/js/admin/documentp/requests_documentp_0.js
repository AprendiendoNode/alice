$(function() {
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
      url: "/view_request_documentp_zero",
      data: objData,
      success: function (data){
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
  let docs_p = datajson.filter(data => data.doc_type == 1);
  $.each(docs_p, function(index, data){
    let type_doc = 'P';
    let badge = '';
    switch (data.status) {
      case 'Nuevo':
        badge= '<span class="badge badge-secondary badge-pill text-white">Nuevo</span>';
        break;
      case 'Reviso':
        badge= '<span class="badge badge-warning badge-pill text-white">Revisado</span>';
        break;
       case 'Autorizado':
         badge= '<span class="badge badge-success badge-pill text-white">Autorizado</span>';
         break;
       case 'Entregado':
          badge= '<span class="badge badge-dark badge-pill text-white">Entregado</span>';
          break;
       default:
         badge= '<span class="badge badge-danger badge-pill text-white">Denegado</span>';
         break;
    }
  vartable.fnAddData([
        data.fecha,
        data.nombre_proyecto,
        '$' + data.total_ea.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
        '$' + data.total_ena.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
        '$' + data.total_mo.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
        data.elaboro,
        badge,
        data.num_edit,
        parseInt(data.porcentaje_compra) + '%',
        data.atraso,
        type_doc,
        '<a href="" data-type="number" data-pk="'+ data.id +'" data-title="Serv. mensual" data-value="' + data.servicio_mensual + '" class="set-servmensual">',
        `<div class="btn-group">
          <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-h"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
              <a class="dropdown-item" href="javascript:void(0);" onclick="editar(this)" data-id="${data.id}" data-cart="${data.documentp_cart_id}" value="${data.id}"><span class="fa fa-edit"></span> Editar</a>
              <a class="dropdown-item" href="javascript:void(0);" onclick="enviar(this)" data-id="${data.id}"  data-cart="${data.documentp_cart_id}" value="${data.id}"><i class="fas fa-shopping-cart"></i> Ver productos</a>
              <a class="dropdown-item" href="javascript:void(0);" onclick="uploadActaEntrega(this)" data-id="${data.id}" value="${data.id}"><i class="fas fa-upload"></i> Subir acta de entrega</a>
              <a class="dropdown-item" href="javascript:void(0);" onclick="kickoff(this)" data-id="${data.id}" data-id="${data.id}"  data-cart="${data.documentp_cart_id}" value="${data.id}"><i class="fas fa-tasks"></i> Kick-off</a>
              <a class="dropdown-item" href="javascript:void(0);" onclick="editar_cotizador(this)" data-id="${data.id}" data-cart="${data.documentp_cart_id}" value="${data.id}"><span class="fa fa-calculator"></span> Ir a cotizador</a>
              <a class="dropdown-item" target="_blank" href="/documentp_invoice/${data.id}/${data.documentp_cart_id}"><span class="far fa-file-pdf"></span> Imprimir productos</a>
          </div>
         </div>`,
    ]);
  });
}
var Configuration_table_responsive_documentp= {
        "order": [[ 0, "desc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "fnDrawCallback": function() {
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
                "width": "0.3%",
                "className": "text-center",
            },
            {
              "targets": 1,
              "width": "1.5%",
              "className": "text-center cell-name",
            },
            {
              "targets": 2,
              "width": "0.5%",
              "className": "text-right cell-price",
            },
            {
              "targets": 3,
              "width": "0.5%",
              "className": "text-right cell-price",
            },
            {
              "targets": 4,
              "width": "0.5%",
              "className": "text-right cell-price",
            },
            {
              "targets": 5,
              "width": "1.6%",
              "className": "text-center cell-name",
            },
            {
              "targets": 6,
              "width": "0.3%",
              "className": "text-center",
            },
            {
              "targets": 7,
              "width": "0.1%",
              "className": "text-center cell-short",
              "visible": false
            },
            {
              "targets": 8,
              "width": "0.2%",
              "className": "text-center cell-short",
            },
            {
              "targets": 9,
              "width": "0.2%",
              "className": "text-center cell-short",
            },
            {
              "targets": 10,
              "width": "0.2%",
              "className": "text-center",
            },
            {
              "targets": 11,
              "width": "0.2%",
              "className": "text-center cell-short",
            },
            {
              "targets": 12,
              "width": "1.5%",
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
              return 'Documento P '+ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8,9,10,11 ],
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
              return 'Documento P '+ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8,9,10,11 ],
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
              return 'Documento P '+ ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8,9,10,11 ],
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
