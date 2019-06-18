$(function () {
  get_info_itcmaster();
  get_info_itcjunior();
  //Create ITC Master
  $('#created_master').formValidation({
   framework: 'bootstrap',
   excluded: ':disabled',
   fields: {
     selectcadena: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     selectusermaster: {
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
     var form = $('#created_master')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/create_master",
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
                 text: 'Solo puede existir un ITC Activo asignado a una cadena!',
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
  //Edit ITC Master
  $('#edit_itc_master').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      selectcadenaEdit: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      selectUserMasterEdit: {
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
        var form = $('#edit_itc_master')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/update_master",
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
  //Create ITC Junior
  $('#created_junior').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      selecthotel: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      selectuserjunior: {
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
      var form = $('#created_junior')[0];
         var formData = new FormData(form);
         $.ajax({
           type: "POST",
           url: "/create_junior",
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
    //Edit ITC Junior
    $('#edit_itc_junior').formValidation({
      framework: 'bootstrap',
      excluded: ':disabled',
      fields: {
        selectHotelEdit: {
          validators: {
            notEmpty: {
              message: 'The field is required'
            }
          }
        },
        selectUserJuniorEdit: {
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
          var form = $('#edit_itc_junior')[0];
          var formData = new FormData(form);
          $.ajax({
            type: "POST",
            url: "/update_junior",
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
});

function get_info_itcmaster() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/show_master",
      data: { _token : _token },
      success: function (data){
        table_itcmaster(data, $("#all_master"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_itcmaster(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_classification);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (status.active == 0) {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      status.name_cadena,
      status.name_user,
      badge,
      '<a href="javascript:void(0);" onclick="editar_itcmaster(this)" class="btn btn-primary  btn-sm mr-2" value="'+status.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a><a href="javascript:void(0);" onclick="destroy_itcmaster(this)" class="btn btn-danger btn-sm" value="'+status.id+'"><i class="fas fa-trash btn-icon-prepend fastable"></i></a>'
    ]);
  });
}
//Mostrar - Edit itc master
function editar_itcmaster(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');

  $("#selectcadenaEdit option").each(function(index){
      $("#selectcadenaEdit option[value='"+index+"']").attr('selected', false);
  });

  $("#selectUserMasterEdit option").each(function(index){
      $("#selectUserMasterEdit option[value='"+index+"']").attr('selected', false);
  });

  $.ajax({
       type: "POST",
       url: '/edit_master',
       data: {value : valor, _token : _token},
       success: function (data) {
         $("#edit_itc_master")[0].reset();
         $('#edit_itc_master').data('formValidation').resetForm($('#edit_itc_master'));

         if (data != []) {
            $('#token_f').val(data.id);
            $("#selectcadenaEdit option[value='" + data.cadena_id +"']").attr('selected', true);
            $("#selectUserMasterEdit option[value='" + data.user_id +"']").attr('selected', true);

            $('#modal-Edit-Itc-Master').modal('show');
         }
         else {
           Swal.fire({
             type: 'error',
             title: 'Error encontrado..',
             text: 'Realice la operacion nuevamente!',
           });
         }

       },
       error: function (data) {
         alert('Error:', data);
       }
   })

}

//Destroy itc master
function destroy_itcmaster(e){
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
             url: '/destroy_master',
             data: {id : valor, _token : _token},
             success: function (data) {
              if(data.status == 200){
                Swal.fire('ITC Maestro eliminado!', '', 'success')
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
$(".reset_master").on("click", function () {
  $("#created_master")[0].reset();
  $('#created_master').data('formValidation').resetForm($('#created_master'));
});
//----------------------------------------------------------------------------------------------------------------
function get_info_itcjunior() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/show_junior",
      data: { _token : _token },
      success: function (data){
        table_itcjunior(data, $("#all_junior"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function table_itcjunior(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_classification);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (status.active == 0) {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      status.name_hotel,
      status.name_user,
      badge,
      '<a href="javascript:void(0);" onclick="editar_itcjunior(this)" class="btn btn-primary  btn-sm mr-2" value="'+status.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a><a href="javascript:void(0);" onclick="destroy_itcjunior(this)" class="btn btn-danger btn-sm" value="'+status.id+'"><i class="fas fa-trash btn-icon-prepend fastable"></i></a>'
    ]);
  });
}

//Mostrar - Edit itc junior
function editar_itcjunior(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');

  $("#selectHotelEdit option").each(function(index){
      $("#selectHotelEdit option[value='"+index+"']").attr('selected', false);
  });

  $("#selectUserJuniorEdit option").each(function(index){
      $("#selectUserJuniorEdit option[value='"+index+"']").attr('selected', false);
  });

  $.ajax({
       type: "POST",
       url: '/edit_junior',
       data: {value : valor, _token : _token},
       success: function (data) {
         $("#edit_itc_junior")[0].reset();
         $('#edit_itc_junior').data('formValidation').resetForm($('#edit_itc_junior'));;

         if (data != []) {
            $('#token_d').val(data.id);
            $("#selectHotelEdit option[value='" + data.hotel_id +"']").attr('selected', true);
            $("#selectUserJuniorEdit option[value='" + data.user_id +"']").attr('selected', true);

            $('#modal-Edit-Itc-Junior').modal('show');
         }
         else {
           Swal.fire({
             type: 'error',
             title: 'Error encontrado..',
             text: 'Realice la operacion nuevamente!',
           });
         }

       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}

//Destroy itc junior
function destroy_itcjunior(e){
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
             url: '/destroy_junior',
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
$(".reset_junior").on("click", function () {
  $("#created_junior")[0].reset();
  $('#created_junior').data('formValidation').resetForm($('#created_junior'));
});
