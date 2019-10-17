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
        document.getElementById("table_quoting_wrapper").childNodes[0].setAttribute("class", "form-inline");
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
  $.each(datajson, function(index, data){
    let type_doc = 'C';
    let badge = '';
    let parameters_icon = '';
    switch (data.cotizador_status) {
      case 'Nuevo':
        badge= '<span class="badge badge-secondary badge-pill text-white">Nuevo</span>';
        break;
      case 'En revisión':
        badge= '<span class="badge badge-warning badge-pill text-white">En revisión</span>';
        break;
      case 'Autorizado':
        badge= '<span class="badge badge-success badge-pill text-white">Autorizado</span>';
        break;
       case 'En Kick-off':
         badge= '<span class="badge badge-dark badge-pill text-white">En Kick-off</span>';
         break;
       case 'Fuera de parametros':
          badge= '<span class="badge badge-danger badge-pill text-white">Fuera de parametros</span>';
          break;
       default:
         badge= '<span class="badge badge-danger badge-pill text-white">Denegado</span>';
         break;
    }

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
            <a class="dropdown-item" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Editar" onclick="editar(this)" data-id="${data.id}" data-id="${data.id}"  data-cart="${data.id}'" value="${data.id}"><i class="fa fa-edit"></i>Editar cotizador</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="enviar(this)" data-id="${data.id}"  data-cart="${data.documentp_cart_id}" value="${data.id}"><i class="fas fa-shopping-cart"></i> Ver productos</a>
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
                "checkboxes": {
                  'selectRow': true
                },
                "width": "0.1%",
                "createdCell": function (td, cellData, rowData, row, col){
                  if ( cellData > 0 ) {
                    if(rowData[11] == 'En revisión' || rowData[11] == 'Autorizado' || rowData[11] == 'En Kick-off'){
                      this.api().cell(td).checkboxes.disable();
                    }
                  }
                },
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
          {
            text: '<i class=""></i> Enviar para autorización',
            titleAttr: 'Enviar para autorización',
            className: 'btn bg-dark',
            init: function(api, node, config) {
              $(node).removeClass('btn-default')
            },
            action: function ( e, dt, node, config ) {
              var rows_selected = $("#table_quoting").DataTable().column(0).checkboxes.selected();
              var _token = $('input[name="_token"]').val();
              // Iterate over all selected checkboxes
              var valores= new Array();
              // console.log(factura);
              $.each(rows_selected, function(index, rowId){
                valores.push(rowId);
              });

              if (valores.length === 0){
                Swal.fire("Operación abortada", "Ningún registro seleccionado :(", "error");
              }else{
                Swal.fire({
                  title: "¿Estás seguro?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Continuar",
                  cancelButtonText: "Cancelar",
                  customClass: 'swal-wide'
                }).then((result) => {
                  if(result.value){

                    var status_cotizador = 3 // Estatus en revision;
 
                    $('.cancel').prop('disabled', 'disabled');
                    $('.confirm').prop('disabled', 'disabled');

                    if(status_cotizador === ''){
                      Swal.fire("Operación abortada", "Debe seleccionar un estatus", "error")
                    }else{
                      $.ajax({
                        type: "POST",
                        url: "/set_status_quoting",
                        data: { idents: JSON.stringify(valores), status_cotizador: status_cotizador , _token : _token },
                        success: function (data){
                          if (data === 'true') {
                            Swal.fire("Operación Completada!", "", "success");
                            setTimeout("location.reload();", 2000);
                          }else{
                              Swal.fire("Ocurrio un error al cambiar estatus!", "", "error");
                          }
                        },
                        error: function (data) {
                          console.log('Error:', data);
                        }
                      });
                    }
                  }
                })
              }


            }
          },
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
