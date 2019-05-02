$(function () {
   graph_config_report();
   //Crear Usuario
   $('#re_data_type').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      select_one: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      select_two: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
    }
   })
   .on('success.form.fv', function(e) {
    e.preventDefault();
    var objData = $("#re_data_type").find("select,textarea, input").serialize();
    $.ajax({
         type: "POST",
         url: '/reg_user_type',
         data: objData,
         success: function (data) {
            if (data == '0') {
               menssage_toast('Mensaje', '2', 'Error encontrado, reintente mas tarde!' , '3000');
            }
            else if (data == 'abort') {
              menssage_toast('Mensaje', '2', 'Operation Abort - No se puede duplicar informacion ya existente' , '3000');
            }
            else {
              graph_config_report();
              $('#modal-CreatReport').modal('toggle');
              menssage_toast('Mensaje', '4', 'Operation complete!' , '3000');
            }
         },
         error: function (data) {
           menssage_toast('Mensaje', '2', 'Operation Abort' , '3000');
         }
     });
     $("#re_data_type")[0].reset();
     $('#re_data_type').data('formValidation').resetForm($('#re_data_type'));
  });
});

function graph_config_report() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/get_user_type",
      data: { _token : _token },
      success: function (data){
        table_config_report(data, $("#example_conf_hotel"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_config_report(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_report);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.hotel,
      status.report,
      '<a href="javascript:void(0);" onclick="sendDelete(this)" class="btn btn-danger btn-icon-text btn-sm" value="'+status.id+'"><i class="fas fa-trash btn-icon-prepend fastable"></i>Eliminar</a>'
    ]);
  });
}

var Configuration_table_report= {
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        text: '<i class="far fa-plus-square fastable mt-2"></i> Crear Nuevo',
        titleAttr: 'Crear Nuevo',
        className: 'btn btn-navy btn-sm',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        action: function ( e, dt, node, config ) {
          $('#modal-CreatReport').modal('show');
          if (document.getElementById("re_data_type")) {
            $('#re_data_type')[0].reset();
          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Asignación de tipos de reportes',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn btn-success btn-sm custombtntable',
        exportOptions: {
            columns: [ 0, 1]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Asignación de tipos de reportes',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
        titleAttr: 'CSV',
        className: 'btn btn-primary btn-sm',
        exportOptions: {
            columns: [ 0, 1]
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

function sendDelete(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
    Swal.fire({
    title: 'Estás seguro de eliminarlo?',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, bórralas!'
  }).then((result) => {
    if (result.value) {
      $.ajax({
          type: "POST",
          url: "/delete_assign_hotel_cl",
          data: { send: valor, _token : _token,  },
          success: function (data){
            if (data === '1') {
              graph_config_report();
              Swal.fire(
                'Borrado!',
                'El reporte se ha sido eliminado.',
                'success'
              );
            }else{
             Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Error encontrado, Espere unos minutos!',
                footer: 'Notificar a su administrador, en caso de continuar!'

              });
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
      });

    }
  });
}
