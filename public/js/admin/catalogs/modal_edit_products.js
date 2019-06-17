$(function() {
  //-----------------------------------------------------------
  $("#editproductsystem").validate({
      ignore: "input[type=hidden]",
      errorClass: "text-danger",
      successClass: "text-success",
      errorPlacement: function (error, element) {
          var attr = $('[name="'+element[0].name+'"]').attr('edatas');
          if (element[0].id === 'editfileInput') {
            error.insertAfter($('#edit_cont_file'));
          }
          else {
            if(attr == 'edit_sel_categoria'){
              error.insertAfter($('#edit_cont_category'));
            }
            else if(attr == 'edit_sel_modelo'){
              error.insertAfter($('#edit_cont_model'));
            }
            else if(attr == 'edit_sel_estatus'){
              error.insertAfter($('#edit_cont_estatus'));
            }
            else {
              error.insertAfter(element);
            }
          }
        },
        rules: {
          inputEditkey: {
            required: true,
            number: true,
            minlength: 2,
            maxlength: 10
          },
          editfileInput: {
            required: false,
            accept:"jpg,png,jpeg"
          },
        },
        messages: {
          editfileInput: {
            required: "Select Image",
            accept: "Only image type jpg/png/jpeg is allowed"
          },
        },
        // debug: true,
        // errorElement: "label",
        submitHandler: function(form){
          // swal("Operación abortada", "Ningúna operación afectuada, Ingrese la latitud y longitud :)", "error");
          Swal.fire({
            title: "Estás seguro?",
            text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Continuar.!",
            cancelButtonText: "Cancelar.!",
          }).then((result) => {
            if (result.value) {
              var form = $('#editproductsystem')[0];
              var formData = new FormData(form);
              $.ajax({
                type: 'POST',
                url: "/catalogs/products-store",
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
                      $('#modal-Edit').modal('toggle');
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
                         window.location.href = "/catalogs/products";
                        }
                      });
                  }
                },
                error: function (data) {
                  $('#modal-Edit').modal('toggle');
                  $("#editproductsystem")[0].reset();
                  var validator = $( "#editproductsystem" ).validate();
                  validator.resetForm();
                  Swal.fire({
                     type: 'error',
                     title: 'Operación abortada',
                     text: 'Ningúna operación afectuada :)',
                   });
                }
              });
            }
            else {
              $('#modal-Edit').modal('toggle');
              Swal.fire({
                 type: 'error',
                 title: 'Operación',
                 text: 'Cancelada',
               });
            }
          });



        }
  });

  //-----------------------------------------------------------
});
