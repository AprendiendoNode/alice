$(function(){

get_complements();

  function get_complements(){
    var _token = $('input[name="_token"]').val();

    $.ajax({
      type: "POST",
      url: "get_data_complements",
      data: { _token : _token},
      success: function (data){
        console.log(data);
        table_complements(data,$('#table_complements'));
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  }


  function table_complements(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_history);
    vartable.fnClearTable();

    $.each(datajson, function(index, status){
      vartable.fnAddData([
        status.customer_invoice_id,
        status.name,
        status.date_due,
        status.uuid,
        status.customers,
        status.currencies,
        status.total,
        status.saldo,
      ]);
    });
  }
  var Configuration_table_responsive_history={
    "select": true,
    "columnDefs": [
      { //Subida 1
        "targets": 0,
        "checkboxes": {
          'selectRow': true
        },
        "width": "1%",
      },
      {
        "targets": 1,
        "width": "1%",
        "className": "text-center fix-colums",
      },
      {
        "targets": 2,
        "width": "1%",
        "className": "text-center fix-colums",
      },
      {
        "targets": 3,
        "width": "1%",
        "className": "text-center fix-columns",
      },
      {
        "targets": 4,
        "width": "1%",
        "className": "text-center fix-columns",
      },
      {
        "targets": 5,
        "width": "0.2%",
        "className": "text-center fix-columns",
      },
      {
        "targets": 6,
        "width": "0.2%",
        "className": "text-center fix-columns",
      },
      {
        "targets": 7,
        "width": "0.2%",
        "className": "text-center fix-columns",
      }
    ],
    "select": {
      'style': 'multi',
    },
    dom: "<'row'<'col-sm-3'l><'col-sm-9'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    "order": [[ 0, "asc" ]],
    paging: true,
    //"pagingType": "simple",
    Filter: true,
    searching: true,
    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
    //ordering: false,
    //"pageLength": 5,
    bInfo: false,
        language:{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
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

});
