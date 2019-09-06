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
  //Filtrando documentos M
  let datajson_result = datajson.filter(data => data.doc_type == 1 && data.status != 'Denegado');
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
      data.fecha,
      data.nombre_proyecto,
      '$' + data.total_ea.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$' + data.total_ena.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      '$' + data.total_mo.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      data.elaboro,
      badge,
      data.num_edit,
      data.porcentaje_compra + '%',
      data.atraso,
      type_doc,
      data.prioridad ,
      '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Editar" onclick="editar(this)" data-id="' + data.id +'" data-id="' + data.id +'"  data-cart="' + data.documentp_cart_id +'" value="'+data.id+'" class="btn btn-primary btn-sm"><span class="fa fa-edit"></span></a>'+
      '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Kick-off" onclick="kickoff(this)" data-id="' + data.id +'" data-id="' + data.id +'"  data-cart="' + data.documentp_cart_id +'" value="'+data.id+'" class="btn btn-success btn-sm"><span class="fas fa-tasks"></span></a>' +
      '<a href="javascript:void(0);" onclick="enviar(this)" data-id="' + data.id +'"  data-cart="' + data.documentp_cart_id +'" value="'+data.id+'" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Ver pedido"><span class="fa fa-shopping-cart"></span></a>' +
      '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Cotizador" onclick="editar_cotizador(this)" data-id="' + data.id +'" data-id="' + data.id +'"  data-cart="' + data.documentp_cart_id +'" value="'+data.id+'" class="btn btn-info btn-dark"><span class="fa fa-calculator"></span></a>' +
      '<a target="_blank" href="/documentp_invoice/'+ data.id + '/ '+ data.documentp_cart_id +'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir" role="button"><span class="far fa-file-pdf"></span></a>' +
      '<a href="javascript:void(0);" onclick="deny_docp(this)" value="'+data.id+'" class="btn btn-warning btn-xs" role="button" data-target="#modal-deny" title="Denegar"><span class="fa fa-ban"></span></a>',
      data.status,
      data.cant_sug_total,
      data.cant_req_total
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
                    if(rowData[14] != 'Reviso'){
                      this.api().cell(td).checkboxes.disable();
                    }
                    if(rowData[15] != null){
                      if(rowData[15] != rowData[16]){
                        $(td).parent().addClass('highlight-doc');
                      }

                    }
                  }
                },
                "className": "text-center",
            },
            {
              "targets": 1,
              "width": "0.1%",
              "className": "text-center cell-name",
            },
            {
              "targets": 2,
              "width": "1.5%",
              "className": "text-center cell-name",
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
              "width": "0.2%",
              "className": "text-right cell-price",
            },
            {
              "targets": 6,
              "width": "1.8%",
              "className": "text-center cell-name",
            },
            {
              "targets": 7,
              "width": "0.1%",
              "className": "text-center",
            },
            {
              "targets": 8,
              "width": "0.1%",
              "className": "text-center cell-short",
            },
            {
              "targets": 9,
              "width": "0.1%",
              "className": "text-center cell-short",
            },
            {
              "targets": 10,
              "width": "0.2%",
              "className": "text-center cell-short",
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
              "className": "text-center actions-button cell-large",
            },
            {
              "targets": 14,
              "visible": false,
              "searchable": false
            },
            {
              "targets": 15,
              "visible": false,
              "searchable": false
            },
            {
              "targets": 16,
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
                      return 'Historial Documento P ';
                    },
                    init: function(api, node, config) {
                      $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                      columns: [ 1,2,3,4,5,6,7,8,9,10,11 ],
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
                      return 'Historial Documento P ';
                    },
                    init: function(api, node, config) {
                      $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                      columns: [ 1,2,3,4,5,6,7,8,9,10,11 ],
                      modifier: {
                        page: 'all',
                      }
                    },
                    className: 'btn btn-info',
                  },
                  {
                    extend: 'pdf',
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
                      return 'Historial Documento P:  ';
                    },
                    init: function(api, node, config) {
                      $(node).removeClass('btn-default')
                    },
                    exportOptions: {
                      columns: [ 1,2,3,4,5,6,7,8,9,10,11 ],
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
