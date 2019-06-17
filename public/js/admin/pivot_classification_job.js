$(function () {
  get_info_userworkstation();
  get_info_userdepartament();
  //1.-Jefe directo
  $('#created_position_user').formValidation({
   framework: 'bootstrap',
   excluded: ':disabled',
   fields: {
     selectposition: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     selectuserposition: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     inputdateposition: {
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
     var form = $('#created_position_user')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/workstation_create_user",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            if (data == 'abort') {
              Swal.fire({
                 type: 'error',
                 title: 'Error encontrado al insertar el registro.',
                 text: 'Realice la operacion nuevamente!',
               });
            }
            else if (data == 'false') {
              Swal.fire({
                 type: 'error',
                 title: 'Error encontrado.',
                 text: 'Solo puede existir un usuario asignado al puesto!',
                 footer: '<strong>Nota:</strong> Necesitas deshabilitar el otro usuario para poder insertar uno nuevo',

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
                    window.location.href = "/Classification";
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
   $('#edit_position_user').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      selectpositionEdit: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      selectuserpositionEdit: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputdatepositionEdit: {
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
        var form = $('#edit_position_user')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/workstation_update_user",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
             if (data.status  == 200) {
               let timerInterval;
               Swal.fire({
                 type: 'success',
                 title: 'Operación Completada!',
                 html: 'Aplicando los cambios.',
                 timer: 2500,
                 onBeforeOpen: () => {
                   Swal.showLoading ()
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
                   window.location.href = "/Classification";
                 }
               });

             }else{
              Swal.fire({
                 type: 'error',
                 title: 'Error encontrado..',
                 text: '',
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

  //2.-Usuarios a departamentos
  $('#created_user_departament').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      selectdepartament: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      selectuserdepartament: {
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
      var form = $('#created_user_departament')[0];
         var formData = new FormData(form);
         $.ajax({
           type: "POST",
           url: "/department_create_user",
           data: formData,
           contentType: false,
           processData: false,
           success: function (data){
             if (data == 'abort') {
               Swal.fire({
                  type: 'error',
                  title: 'Error encontrado al insertar el registro.',
                  text: 'Realice la operacion nuevamente!',
                });
             }
             else if (data == 'false') {
               Swal.fire({
                  type: 'error',
                  title: 'Error encontrado.',
                  text: 'Los datos a registrar ya existen!',
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
                     window.location.href = "/Classification";
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
//---------------------------------------------------------------------------------------------------
$(".reset_position_user").on("click", function () {
  $("#created_position_user")[0].reset();
  $('#created_position_user').data('formValidation').resetForm($('#created_position_user'));
});
$(".reset_user_departament").on("click", function () {
  $("#created_user_departament")[0].reset();
  $('#created_user_departament').data('formValidation').resetForm($('#created_user_departament'));
});
//---------------------------------------------------------------------------------------------------
function get_info_userworkstation() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/workstation_show_user",
      data: { _token : _token },
      success: function (data){
        table_user_workstation(data, $("#all_position_user"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_user_workstation(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_classification);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (status.active == 0) {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      status.name_user,
      status.name_workstation,
      status.start_activities,
      status.end_activities,
      badge,
      '<a href="javascript:void(0);" onclick="editar_user_workstation(this)" class="btn btn-primary  btn-sm mr-2" value="'+status.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a><a href="javascript:void(0);" onclick="destroy_user_workstation(this)" class="btn btn-danger btn-sm" value="'+status.id+'"><i class="fas fa-trash btn-icon-prepend fastable"></i></a>'
    ]);
  });
}
//Mostrar - Edit user workstation
function editar_user_workstation(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');

  $("#selectpositionEdit option").each(function(index){
      $("#selectpositionEdit option[value='"+index+"']").attr('selected', false);
  });

  $("#selectuserpositionEdit option").each(function(index){
      $("#selectuserpositionEdit option[value='"+index+"']").attr('selected', false);
  });

  $.ajax({
       type: "POST",
       url: '/workstation_edit_user',
       data: {value : valor, _token : _token},
       success: function (data) {
         $("#edit_position_user")[0].reset();
         $('#edit_position_user').data('formValidation').resetForm($('#edit_position_user'));;

         $('#token_e').val(data.id);
         $("#selectpositionEdit option[value='" + data.workstation_id +"']").attr('selected', true);
         $("#selectuserpositionEdit option[value='" + data.user_id +"']").attr('selected', true);
         $("#inputdatepositionEdit").val(data.start_activities);

         $('#modal-Edit-User-Puesto').modal('show');

       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}
//Destroy user workstation
function destroy_user_workstation(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
    title: '¿Estás seguro?',
    text: "No podras revertir este cambio",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Borrar',
    cancelButtonText: 'Cancelar'
    }).then((result) => {

      if (result.value) {
        $.ajax({
             type: "POST",
             url: '/workstation_destroy_user',
             data: {id : valor, _token : _token},
             success: function (data) {
              if(data.status == 200){
                Swal.fire('Asignación eliminada!', '', 'success')
                .then(()=> {
                  location.href ="/Classification";
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
         })

      }
    })
}

//---------------------------------------------------------------------------------------------------
function get_info_userdepartament() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/department_show_user",
      data: { _token : _token },
      success: function (data){
        table_user_departament(data, $("#all_user_departament"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_user_departament(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_classification);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (status.active == 0) {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      status.name_user,
      status.name_departament,
      '<a href="javascript:void(0);" onclick="destroy_user_departament(this)" class="btn btn-danger btn-sm" value="'+status.id+'"><i class="fas fa-trash btn-icon-prepend fastable"></i></a>'
    ]);
  });
}
//Mostrar - Destroy user department
function destroy_user_departament(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
    title: '¿Estás seguro?',
    text: "No podras revertir este cambio",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Borrar',
    cancelButtonText: 'Cancelar'
    }).then((result) => {

      if (result.value) {
        $.ajax({
             type: "POST",
             url: '/department_destroy_user',
             data: {id : valor, _token : _token},
             success: function (data) {
              if(data.status == 200){
                Swal.fire('Asignación eliminada!', '', 'success')
                .then(()=> {
                  location.href ="/Classification";
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
         })

      }
    })
}
