var token = $('input[name="_token"]').val();
$(function(){
  // cx_sat.unshift({value: 0, text: "Elija..."});
  //console.log(cx_sat);
  // balance_table(token);

  $('.dateInput').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '1m',
    autoclose: true,
    clearBtn: true
  });
  $('.dateInput').val('').datepicker('update');
}());

function balance_table(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/por_definir", // definir en rutas y crear procedure.
      data: { _token : _token },
      success: function (data){
        generate_table(data, $('#table_balance'));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function generate_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable({
      "order": [[ 0, "asc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "select": true,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "columnDefs": [
          {
            "targets": 0,
            "checkboxes": {
              'selectRow': true
            },
            "width": "1%",
            "createdCell": function (td, cellData, rowData, row, col){

            }
          },
          {
              "type": "html",
              "targets": [5,11,12,13,14,15,16,17,18],
          }
      ],
      "select": {
          'style': 'multi',
      },
      //ordering: false,
      //"pageLength": 5,
      dom: "<'row'<'col-sm-6'B><'col-sm-3'l><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        /*{
          text: '<i class="fa fa-check margin-r5"></i> Aplicar fechas',
          titleAttr: 'Aplicar fechas seleccionadas',
          className: 'btn btn-basic aux',
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          action: function ( e, dt, node, config ) {
            // $('#modal-confirmation').modal('show');
            Swal.fire({
              title: "Estás seguro?",
              text: "Se aplicará la fecha a los seleccionados.!",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar.!",
              cancelButtonText: "Cancelar.!",
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
            }).then((result) => {
              if (result.value) {
                $('.cancel').prop('disabled', 'disabled');
                $('.confirm').prop('disabled', 'disabled');
                var rows_selected = $("#table_balance").DataTable().column(0).checkboxes.selected();
                var fc = $('#date_compromise').val();
                var ff = $('#date_factura').val();
                var _token = $('input[name="_token"]').val();
                // Iterate over all selected checkboxes
                var valores= new Array();
                $.each(rows_selected, function(index, rowId){
                    valores.push(rowId);
                });
                if ( valores.length === 0){
                  Swal.fire("Operación abortada", "Ningún registro seleccionado :(", "error");
                }
                else {
                    $.ajax({
                        type: "POST",
                        url: "/send_dates_cxp",
                        data: { idents: JSON.stringify(valores), _token: _token, date_compromise: fc, date_factura: ff },
                        success: function (data){
                          //console.log(data);
                          if (data === '1') {
                            Swal.fire("Operación Completada!", "Los registros seleccionados han sido afectados.", "success");
                            balance_table(token);
                          }
                          if (data === '0') {
                            Swal.fire("Operación abortada!", "Favor de seleccionar una fecha para aplicar la operación.", "error");
                          }
                        },
                        error: function (data) {
                          console.log('Error:', data);
                        }
                    });
                }
              }//Fin if result.value
              else {
                Swal.fire("Operación abortada", "Ningún registro afectado :)", "error");
              }
            })
          }
        },
        {
          text: '<i class="fa fa-check margin-r5"></i> Aprobar / facturación.',
          titleAttr: 'Aprobado para facturación.',
          className: 'btn btn-warning aux',
          init: function(api, node, config) {
            $(node).removeClass('btn-default')
          },
          action: function ( e, dt, node, config ) {
            // $('#modal-confirmation').modal('show');
                Swal.fire({
                  title: "Estás seguro?",
                  text: "Se pasaran a facturación todos los registros seleccionados.!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Continuar.!",
                  cancelButtonText: "Cancelar.!",
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
              }).then((result) => {
                if (result.value) {
                  $('.cancel').prop('disabled', 'disabled');
                  $('.confirm').prop('disabled', 'disabled');
                  var rows_selected = $("#table_balance").DataTable().column(0).checkboxes.selected();
                  var _token = $('input[name="_token"]').val();
                  // Iterate over all selected checkboxes
                  var valores= new Array();
                  $.each(rows_selected, function(index, rowId){
                    valores.push(rowId);
                  });
                  if ( valores.length === 0){
                    Swal.fire("Operación abortada", "Ningún registro seleccionado :(", "error");
                  }
                  else {
                    $.ajax({
                      type: "POST",
                      url: "/send_contracts_fact",
                      data: { idents: JSON.stringify(valores), _token : _token },
                      success: function (data){
                        console.log(data);
                        if (data === '1') {
                          Swal.fire("Operación Completada!", "Los registros seleccionados han sido afectados.", "success");
                          balance_table(token);
                        }else {
                          Swal.fire("Operación abortada!", "Los registros seleccionados no han sido afectados.", "error");
                          balance_table(token);
                        }
                      },
                      error: function (data) {
                        console.log('Error:', data);
                      }
                    });
                  }
                }//Fin if result.value
                else {
                  Swal.fire("Operación abortada", "Ningúna registro afectado :)", "error");
                }
              })
          }
        },*/
        {
          extend: 'excelHtml5',
          text: '<i class="far fa-file-excel"></i> Excel',
          titleAttr: 'Excel',
          title: function ( e, dt, node, config ) {
            return 'Balanza de comprobación';
          },
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          className: 'btn btn-success custombtntable aux',
        }
      ],
      //bInfo: false,
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
  );
  vartable.fnClearTable();
  // console.log(datajson);
  
  $.each(JSON.parse(datajson), function(index, data){
    vartable.fnAddData([
        data.id,
        data.cxclassification,
        data.vertical,
        data.cadena,
        data.key,
        data.pay_date,
        data.num_mes_actual,
        data.num_mes_saldo,
      ]);
  });
  document.getElementById("table_balance_wrapper").setAttribute("class", "dataTables_wrapper form-inline dt-bootstrap4 no-footer");
}
