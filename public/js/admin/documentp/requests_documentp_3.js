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
  table_permission_one();

});

$("#boton-aplica-filtro").click(function(event) {
  table_permission_one();
});

function table_permission_one() {
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
  //Filtrando documentos M
  let datajson_result = datajson.filter(data => data.doc_type == 1);
  let type_doc = 'P';
  $.each(datajson_result, function(index, data){

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
      data.id,
      `<div class="btn-group">
        <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="javascript:void(0);" onclick="editar(this)" data-id="${data.id}" data-cart="${data.documentp_cart_id}" value="${data.id}"><span class="fa fa-edit"></span> Editar</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="enviar(this)" data-id="${data.id}"  data-cart="${data.documentp_cart_id}" value="${data.id}"><i class="fas fa-shopping-cart"></i> Ver productos</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="uploadActaEntrega(this)" data-id="${data.id}" value="${data.id}"><i class="fas fa-upload"></i> Subir acta de entrega</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="editar_cotizador(this)" data-id="${data.id}" data-cart="${data.documentp_cart_id}" value="${data.id}"><span class="fa fa-calculator"></span> Ir a cotizador</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="kickoff(this)" data-id="${data.id}" data-id="${data.id}"  data-cart="${data.documentp_cart_id}" value="${data.id}"><i class="fas fa-tasks"></i> Kick-off</a>
            <a class="dropdown-item" target="_blank" href="/documentp_invoice/${data.id}/${data.documentp_cart_id}"><span class="far fa-file-pdf"></span> Imprimir productos</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="deny_docp(this)" value="${data.id}" role="button" data-target="#modal-deny"><span class="fa fa-ban"></span> Denegar</a>
        </div>
       </div>`,
      data.fecha,
      data.folio,
      data.nombre_proyecto,
      '$' + data.total_ea.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$' + data.total_ena.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$' + data.total_mo.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      data.itc,
      badge,
      data.num_edit,
      parseInt(data.porcentaje_compra) + '%',
      data.atraso,
      type_doc,
      data.prioridad ,
      data.status,
      data.cant_sug_total,
      data.cant_req_total
      ]);
  });

}
var Configuration_table_responsive_documentp= {
        "order": [[ 2, "desc" ]],
        "select": true,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "columnDefs": [
            {
                "targets": 0,
                "createdRow": function(row, data) {
                  console.log(data[13]);
                    $(row).addClass('bg-red');
                },
                "checkboxes": {
                  'selectRow': true
                },
                "width": "0.1%",
                "createdCell": function (td, cellData, rowData, row, col){
                  if ( cellData > 0 ) {
                    if(rowData[15] != 'Reviso' && rowData[15] != 'Denegado'){
                      this.api().cell(td).checkboxes.disable();
                    }
                    if(rowData[16] != null){
                      if(rowData[16] != rowData[17]){
                        $(td).parent().addClass('highlight-doc');
                      }

                    }
                  }
                },
                "className": "text-center",
            },
            {
              "targets": 1,
              "width": "1.0%",
              "className": "text-center ",
            },
            {
              "targets": 2,
              "width": "1.5%",
              "className": "text-center cell-name",
            },
            {
              "targets": 3,
              "width": "2.5%",
              "className": "text-center cell-large",
            },
            {
              "targets": 4,
              "width": "0.5%",
              "className": "text-center",
            },
            {
              "targets": 5,
              "width": "0.2%",
              "className": "text-right cell-price",
            },
            {
              "targets": 6,
              "width": "1.8%",
              "className": "text-right cell-price",
            },
            {
              "targets": 7,
              "width": "0.1%",
              "className": "text-right cell-price",
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
              "width": "0.2%",
              "className": "text-center cell-short",
              "visible": false
            },
            {
              "targets": 11,
              "width": "0.1%",
              "className": "text-center cell-short",
            },
            {
              "targets": 12,
              "width": "0.1%",
              "className": "text-center cell-short",
            },
            {
              "targets": 13,
              "width": "3%",
              "className": "text-center",
            },
            {
              "targets": 14,
              "width": "3%",
              "className": "text-center",
            },
            {
              "targets": 15,
              "visible": false,
              "className": "text-center",
            },
            {
              "targets": 16,
              "visible": false,
              "searchable": false
            },
            {
              "targets": 17,
              "visible": false,
              "searchable": false
            }
        ],
        dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [
                  {
                    text: '<i class=""></i> Autorizar Marcados',
                    titleAttr: 'Autorizar Marcados',
                    className: 'btn btn-dark',
                    init: function(api, node, config) {
                      $(node).removeClass('btn-default')
                    },
                    action: function ( e, dt, node, config ) {
                      Swal.fire({
                      title: '¿Estás seguro?',
                      text: "Se autorizarán todos los documentos seleccionados!",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Confirmar',
                      cancelButtonText: 'Cancelar',
                      showLoaderOnConfirm: true,
                      preConfirm: () => {
                        $('.cancel').prop('disabled', 'disabled');
                        $('.confirm').prop('disabled', 'disabled');
                        var rows_selected = $("#table_documentp").DataTable().column(0).checkboxes.selected();
                        var _token = $('input[name="_token"]').val();
                        // Iterate over all selected checkboxes
                        var valores= new Array();
                        $.each(rows_selected, function(index, rowId){
                          valores.push(rowId);
                        });

                        if ( valores.length === 0){
                          Swal.showValidationMessage(
                            `Debe seleccionar al menos un documento`
                          )
                        }else{

                          const headers = new Headers({
                            "Accept": "application/json",
                            'Content-Type': 'application/json',
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": _token
                          })

                          var miInit = { method: 'post',
                                            headers: headers,
                                            credentials: "same-origin",
                                            body: JSON.stringify({idents: valores}),
                                            cache: 'default' };
                          return fetch('/send_item_doc_auth', miInit)
                                .then(function(response){
                                  if (!response.ok) {
                                     throw new Error(response.statusText)
                                   }
                                  return response.text();
                                })
                                .catch(function(error){
                                  Swal.showValidationMessage(
                                    `Request failed: ${error}`
                                  )
                            });
                        }//else valores.lenght

                        }//preconfirm
                      }).then((result) => {
                        if (result.value) {
                          console.log(result);
                          table_permission_one();
                          Swal.fire({
                            title: 'Los documentos han sido autorizados',
                            text: "",
                            type: 'success',
                          })
                        }else{
                          Swal.showValidationMessage(
                            `Ocurrio un error inesperado`
                          )
                        }
                      }) //then resulr
                    },//action

                  },
                  {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
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
                      return 'Historial Documento P ';
                    },
                    init: function(api, node, config) {
                      $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                      columns: [ 2,3,4,5,6,7,8,9,10,11,12,13 ],
                      modifier: {
                        page: 'all',
                      }
                    },
                    className: 'btn btn-success',
                  },
                  {
                    extend: 'csvHtml5',
                    text: '<i class="fas fa-file-csv"></i> CSV',
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
                      return 'Historial Documento P ';
                    },
                    init: function(api, node, config) {
                      $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                      columns: [ 2,3,4,5,6,7,8,9,10,11,12,13 ],
                      modifier: {
                        page: 'all',
                      }
                    },
                    className: 'btn btn-info',
                  },
                  {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i>  PDF',
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
                      return 'Historial Documento P:  ';
                    },
                    init: function(api, node, config) {
                      $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                      columns: [ 2,3,4,5,6,7,8,9,10,11,12,13 ],
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
