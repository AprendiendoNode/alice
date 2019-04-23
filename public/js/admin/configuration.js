$(function () {
   graph_config_user();
   //Crear Usuario
   $('#creatusersystem').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      inputCreatName: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputCreatLocation: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputCreatEmail: {
          validators: {
              notEmpty: {
                message: 'The field is required'
              },
              emailAddress: {
                  message: 'The value is not a valid email address'
              }
          }
      },
      selectCreatRole: {
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
    var objData = $("#creatusersystem").find("select,textarea, input").serialize();
    //var _token = $('input[name="_token"]').val();
    $.ajax({
         type: "POST",
         url: '/data_create_user_config',
         data: objData,
         success: function (data) {
            // console.log(data);
            if (data == 'true') {
              graph_config_user();
              $('#modal-CreatUser').modal('toggle');
              menssage_toast('Mensaje', '4', 'Operation complete!' , '3000');
            }
            if (data == 'false') {
               menssage_toast('Mensaje', '2', 'You do not have permission to access this module, please refer to your system administrator!' , '3000');
            }
         },
         error: function (data) {
           menssage_toast('Mensaje', '2', 'Operation Abort- This Email is already registered' , '3000');
         }
     });
     $("#creatusersystem")[0].reset();
     $('#creatusersystem').data('formValidation').resetForm($('#creatusersystem'));
  });
   //Editar Usuario
   $('#editusersystem').formValidation({
     framework: 'bootstrap',
     excluded: ':disabled',
     fields: {
       inputEditName: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
       inpuEditlocation: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
       inputEditEmail: {
           validators: {
               notEmpty: {
                 message: 'The field is required'
               },
               emailAddress: {
                   message: 'The value is not a valid email address'
               }
           }
       },
       selectEditPriv: {
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
     var objData = $("#editusersystem").find("select,textarea, input").serialize();
     $.ajax({
       type: "POST",
       url: '/data_edit_user_config',
       data: objData,
       success: function (data) {
         if (data == 'true') {
           graph_config_user();
           $('#modal-editUser').modal('toggle');
           menssage_toast('Mensaje', '4', 'Operation complete!' , '3000');
         }
         if (data == 'false') {
           menssage_toast('Mensaje', '2', 'You do not have permission to access this module, please refer to your system administrator!' , '3000');
         }
       },
       error: function (data) {
         //  console.log(data);
         menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
       }
     });
     $("#editusersystem")[0].reset();
     $('#editusersystem').data('formValidation').resetForm($('#editusersystem'));
   });
});

function graph_config_user() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/data_config",
      data: { _token : _token },
      success: function (data){
        table_config_user(data, $("#example_conf_user"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_config_user(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_user);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (status.deleted_at) {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      status.name,
      status.email,
      status.city,
      badge,
      '<a href="javascript:void(0);" onclick="enviar(this)" class="btn btn-primary btn-icon-text btn-sm" value="'+status.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i>Editar</a><a href="javascript:void(0);" onclick="enviarmenu(this)" class="btn btn-success btn-icon-text btn-sm" value="'+status.id+'"><i class="far fa-caret-square-down btn-icon-prepend fastable"></i>Menu</a><a href="javascript:void(0);" onclick="enviart(this)" class="btn btn-danger btn-icon-text btn-sm" value="'+status.id+'"><i class="fas fa-user-times btn-icon-prepend fastable"></i>Eliminar</a>'
    ]);
  });
}

var Configuration_table_user= {
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        text: '<i class="fa fa-user-plus fastable mt-2"></i> Crear Usuario',
        titleAttr: 'Crear Usuario',
        className: 'btn btn-navy btn-sm creatadduser',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        action: function ( e, dt, node, config ) {
          $('#modal-CreatUser').modal('show');
          if (document.getElementById("creatusersystem")) {
            $('#creatusersystem')[0].reset();
          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Export of user data',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn btn-success btn-sm custombtntable',
        exportOptions: {
            columns: [ 0, 1, 2, 3]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Export of user data',
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
//Mostrar - Editar Usuarios
function enviar(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $.ajax({
       type: "POST",
       url: '/data_edit_config',
       data: {sector : valor, _token : _token},
       success: function (data) {
         if (data != '') {
           $('#inputEditName').val(data.name);
           $('#inputEditEmail').val(data.email);
           $('#inpuEditlocation').val(data.city);
           $("#selectEditPriv option[value='"+data.roles[0].id+"']").prop('selected', true);
           $('#modal-editUser').modal('show');
           $('#editusersystem').show();
           $('#editinfogenerad').hide();
         }
         else {
           $('#modal-editUser').modal('show');
           $('#editusersystem').hide();
           $('#editinfogenerad').show();
         }
       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}

//Mostrar - Menu Permisos
function enviarmenu(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $('#modal-menu').modal('show');
  $('#id_recibido_xd').val(valor);
  $.ajax({
       type: "POST",
       url: '/data_menu_config',
       data: {sector : valor, _token : _token},
       success: function (data) {
         if (data == 'abort') {
           $('#infogenerad').show();
           $('#menusgenerad').hide();
         }
         else {
           $('#menusgenerad').show();
           $('#infogenerad').hide();

           $('#editusersystem_all')[0].reset();
           for (i = 0; i < data.menus.length; i++) {
             $('#editusersystem_all input:checkbox[name="menu[]"][value=' + data.menus[i].id + ']').prop('checked', 'checked');
           }
           for (j = 0; j < data.permissions.length; j++) {
             $('#editusersystem_all input:checkbox[name="permissions[]"][id=' + data.permissions[j].id + ']').prop('checked', 'checked');
             // $('#editusersystem_all input:checkbox[value='+data.permissions[j].name+']').prop('checked', 'checked');
           }
         }
         // console.log(data);
       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}

//Reset form
$(".form_creat_user").on("click", function () {
  $("#creatusersystem")[0].reset();
  $('#creatusersystem').data('formValidation').resetForm($('#creatusersystem'));
});
$(".form_edit_user").on("click", function () {
  $("#editusersystem")[0].reset();
  $('#editusersystem').data('formValidation').resetForm($('#editusersystem'));
});

//Actualizar Menu
$(".update_user_data_privile").on("click", function () {
  var id = $('#id_recibido_xd').val();
  var objData = $("#editusersystem_all").find("select,textarea, input").serialize();
  $.ajax({
    type: "POST",
    url: '/data_edit_user_config_nuevos',
    data: objData + "&identificador=" + id,
    success: function (data) {
      if (data == 'abort') {
        $('#modal-menu').modal('toggle');
        menssage_toast('Mensaje', '2', 'Operation Abort- You can not remove all permissions from this user' , '3000');
      }
      if (data == 'uncompleted') {
        $('#modal-menu').modal('toggle');
        menssage_toast('Mensaje', '2', 'Operation Abort- You must check the Configuration option' , '3000');
      }
      if (data == 'complete') {
        graph_config_user();
        $('#modal-menu').modal('toggle');
        menssage_toast('Mensaje', '4', 'Operation complete, Wait 2 seconds while the changes are applied!' , '3000');
        setInterval(function(){ window.location.reload(true) },4000);
      }
      if (data == 'complete_two') {
        graph_config_user();
        $('#modal-menu').modal('toggle');
        menssage_toast('Mensaje', '4', 'Operation complete!' , '3000');
      }

    },
    error: function (data) {
      alert('Operation Abort- Changes not made');
    }
  })
});
function enviart(e) {
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');

  Swal.fire({
    title: "¿Desea eliminar este usuario?",
    html: '<i class="far fa-flushed text-info"></i>',
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Confirmar',
    footer: '<strong>Nota:</strong> Se deshabilitara en todo el sistema',
  }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: "/data_delete_config",
          data: { identificador: valor,_token : _token },
          success: function (data){
            //console.log(data);
            if (data === 'true') {
              graph_config_user();
              Swal.fire("Operación Completada!", "Cambios aplicados! :)", "success");
            }else{
              graph_config_user();
              Swal.fire("Operación Abortada!", "No se pudo completar la operacion intente nuevamente. :(", "error");
            }
          },
          error: function (data) {
            console.log('Error:', data.statusText);
          }
        });
      }
  });
}
