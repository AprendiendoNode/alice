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

function table_permission_zero() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/view_request_quoting",
      data: objData,
      success: function (data){
        documentp_table(data, $("#table_quoting"));
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
  let data_filter = datajson.filter(data => data.cotizador_status == 'Autorizado');
  $.each(data_filter, function(index, data){
    let type_doc = 'C';
    let badge = '<span class="badge badge-success badge-pill text-white">Autorizado</span>';
    let parameters_icon = '';

    if(data.objetivos_cotizador == 0){
      parameters_icon = '<span class="badge badge-danger badge-pill text-white"><i class="fas fa-times"></i></span>';
    }else{
      parameters_icon = '<span class="badge badge-success badge-pill text-white"><i class="fas fa-check"></i></span>';
    }

    vartable.fnAddData([
      data.id,
      data.fecha,
      data.nombre_proyecto,
      '$' + data.total_ea.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$' + data.total_ena.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$' + data.total_mo.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      data.elaboro,
      badge,
      parameters_icon,
      type_doc,
      `<div class="btn-group">
        <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
          <a class="dropdown-item" href="javascript:void(0);" onclick="enviar(this)" data-id="${data.id}"  data-cart="${data.documentp_cart_id}" value="${data.id}"><i class="fas fa-shopping-cart"></i> Ver productos</a>
          <a class="dropdown-item" href="/view_pdf_propuesta_comercial/${data.id}" target="_blank"><i class="fas fa-file-pdf"></i> Ver propuesta comercial</a>
          <a class="dropdown-item" href="#" onclick="send_mail_propuesta_comercial(this)" data-id="${data.id}"><i class="fas fa-envelope-open-text"></i> Enviar propuesta a mi correo</a>    
        </div> 
       </div>`,
      data.cotizador_status
      ]);
    });
}

var Configuration_table_responsive_documentp= {
        "order": [[ 1, "desc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "columnDefs": [
            {
                "targets": 0,
                "width": "0.1%", 
                "visible": false,
            },
            {
              "targets": 1,
              "width": "1.5%",
              "className": "text-center cell-name",
            },
            {
              "targets": 2,
              "width": "0.5%",
              "className": "text-center",
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
              "className": "text-right cell-price",
            },
            {
              "targets": 6,
              "width": "1%",
              "className": "text-center cell-large",
            },
            {
              "targets": 7,
              "width": "0.3%",
              "className": "text-center",
            },
            {
              "targets": 8,
              "width": "0.3%",
              "className": "text-center",
            },
            {
              "targets": 9,
              "width": "0.2%",
              "className": "text-center cell-short",
            },
            {
              "targets": 10,
              "width": "3%",
              "className": "text-center",
            },
            {
              "targets": 11,
              "width": "3%",
              "className": "text-center",
              "visible": false,
            }
        ],
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
          
          
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
