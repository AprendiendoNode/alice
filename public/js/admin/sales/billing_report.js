$(function () {

});

function get_billing_report(){
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/sales/get_billing_report",
        data: { _token : _token },
        success: function (data){
          table_billing(data, $("#table_billing"));
        },
        error: function (data) {
          console.log('Error:', data.statusText);
        }
    });
}

function table_customers(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_customers);
    vartable.fnClearTable();
    $.each(JSON.parse(datajson), function(index, data){
      vartable.fnAddData([
        data.id,
       
      ]);
    });
  }

var Configuration_table_responsive_customers = {
    dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          text: '<i class="fas fa-plus-circle fastable mt-2"></i> Crear nuevo',
          titleAttr: 'Crear nuevo',
          className: 'btn btn-danger btn-sm',
          init: function(api, node, config) {
             $(node).removeClass('btn-secondary')
          },
          action: function ( e, dt, node, config ) {
            $('#modal-CreatNew').modal('show');
            if (document.getElementById("creatcustomers")) {
              $('#creatcustomers')[0].reset();
              $('#creatcustomers').data('formValidation').resetForm($('#creatcustomers'));
              $('#inputCreatOrden').val(0);
              $('#select_one').val(5);
              $('#select_two').val(3);
              $('#select_three').val(1);
              $('#select_five').val(1);
            }
          }
        },
        {
          extend: 'excelHtml5',
          title: 'Clientes',
          init: function(api, node, config) {
             $(node).removeClass('btn-secondary')
          },
          text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
          titleAttr: 'Excel',
          className: 'btn btn-success btn-sm',
          exportOptions: {
              columns: [ 0, 1, 2, 3]
          },
        },
        {
          extend: 'csvHtml5',
          title: 'Clientes',
          init: function(api, node, config) {
             $(node).removeClass('btn-secondary')
          },
          text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
          titleAttr: 'CSV',
          className: 'btn btn-primary btn-sm',
          exportOptions: {
              columns: [ 0, 1, 2, 3]
          },
        }
    ],
    "processing": true,
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
  };
  