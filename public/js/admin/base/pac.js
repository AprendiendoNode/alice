$(function () {
  get_info_pacs();
  $('#creatpacs').formValidation({
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
     inputCreatCode: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     entry_ws_url: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     entry_username: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     entry_password: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     inputCreatOrden: {
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
        var form = $('#creatpacs')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/base/pacs-create",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            if (data == 'abort') {
              Swal.fire({
                 type: 'error',
                 title: 'Error encontrado..',
                 text: 'Realice la operacion nuevamente!',
               });
            }
            else if (data == 'false') {
              Swal.fire({
                 type: 'error',
                 title: 'Error encontrado..',
                 text: 'Ya existe!',
               });
            }
            else {
                let timerInterval;
                Swal.fire({
                  type: 'success',
                  title: 'Operación Completada!',
                  html: 'Aplicando los cambios.',
                  timer: 2500,
                  onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                      Swal.getContent().querySelector('strong')
                    }, 100)
                  },
                  onClose: () => {
                    clearInterval(timerInterval)
                  }
                }).then((result) => {
                  if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.timer
                  ) {
                    window.location.href = "/base/settings_pac";
                  }
                });
            }
          },
          error: function (err) {
            Swal.fire({
               type: 'error',
               title: 'Oops...',
               text: err.statusText,
             });
          }
        });
  });

  $('#editpacs').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      inputEditCode: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputEditName: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      edit_entry_ws_url: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      edit_entry_username: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      edit_entry_password: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputEditOrden: {
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
      var form = $('#editpacs')[0];
      var formData = new FormData(form);
      $.ajax({
        type: "POST",
        url: "/base/pacs-store",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data){
           if (data == 'false') {
             Swal.fire({
                type: 'error',
                title: 'Error encontrado..',
                text: 'La clave ya existe!',
              });
           }
          else if (data == 'abort') {
            Swal.fire({
               type: 'error',
               title: 'Error encontrado..',
               text: 'Realice la operacion nuevamente!',
             });
          }
          else {
              let timerInterval;
              Swal.fire({
                type: 'success',
                title: 'Operación Completada!',
                html: 'Aplicando los cambios.',
                timer: 2500,
                onBeforeOpen: () => {
                  Swal.showLoading()
                  timerInterval = setInterval(() => {
                    Swal.getContent().querySelector('strong')
                  }, 100)
                },
                onClose: () => {
                  clearInterval(timerInterval)
                }
              }).then((result) => {
                if (
                  // Read more about handling dismissals
                  result.dismiss === Swal.DismissReason.timer
                ) {
                  window.location.href = "/base/settings_pac";
                }
              });
          }
        },
        error: function (err) {
          Swal.fire({
             type: 'error',
             title: 'Oops...',
             text: err.statusText,
           });
        }
      });
  });
});

function get_info_pacs(){
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/base/pacs-show",
      data: { _token : _token },
      success: function (data){
        table_pacs(data, $("#table_pacs"));
      },
      error: function (data) {
        console.log('Error:', data.statusText);
      }
  });
}
function table_pacs(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_pacs);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (information.status == '0') {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }

    var badgetwo = '<span class="badge badge-success badge-pill text-uppercase text-white"><i class="fas fa-check"></i></span>';
    if (information.test == '0') {
      badgetwo= '<span class="badge badge-danger badge-pill text-uppercase text-white"><i class="fas fa-times"></i></span>';
    }
    vartable.fnAddData([
      information.code,
      information.name,
      information.ws_url,
      information.username,
      badgetwo,
      information.sort_order,
      badge,
      '<a href="javascript:void(0);" onclick="edit_pac(this)" class="btn btn-primary  btn-sm" value="'+information.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a>'
    ]);
  });
}

function edit_pac(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/base/pacs-edit',
       data: {value : valor, _token : _token},
       success: function (data) {
         $("#editpacs")[0].reset();
         $('#editpacs').data('formValidation').resetForm($('#editpacs'));

         if (data != []) {
            $('#token_b').val(data[0].id);
            $('#inputEditCode').val(data[0].code);
            $('#inputEditName').val(data[0].name);
            $('#edit_entry_ws_url').val(data[0].ws_url);
            $('#edit_entry_ws_url_cancel').val(data[0].ws_url_cancel);
            $('#edit_entry_username').val(data[0].username);
            $('#edit_entry_password').val(data[0].password);
            $('#edit_entry_comment').val(data[0].comment);
            $('#inputEditOrden').val(data[0].sort_order);
            if (data[0].test == '0')
            {
              $("#edit_test").prop('checked', false).change();
            }
            else {
              $('#edit_test').prop('checked', true).change();
            }
            if (data[0].status == '0')
            {
              $("#editstatus").prop('checked', false).change();
            }
            else {
              $('#editstatus').prop('checked', true).change();
            }
            $('#modal-Edit').modal('show');
         }
         else {
           Swal.fire({
             type: 'error',
             title: 'Error encontrado..',
             text: 'Realice la operacion nuevamente!',
           });
         }
           //$('#modal-Edit').modal('show');
       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}
var Configuration_table_responsive_pacs = {
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
          if (document.getElementById("creatpacs")) {
            $('#creatpacs')[0].reset();
            $('#creatpacs').data('formValidation').resetForm($('#creatpacs'));
            $('#inputCreatOrden').val(0);
          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Configuración del Pacs',
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
        title: 'Configuración del Pacs',
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
