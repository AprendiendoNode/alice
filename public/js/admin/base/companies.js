$(function () {
  $('.datepickercomplete').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    autoclose: true,
    clearBtn: true
  });
});
//file_file_cer-error
$(function() {
  //-----------------------------------------------------------
  $("#form").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    errorPlacement: function (error, element) {
        var attr = $('[name="'+element[0].name+'"]').attr('datas');
        if (element[0].id === 'fileInput') {
          error.insertAfter($('#cont_file'));
        }
        else {
           if(attr == 'file_file_cer'){
            error.insertAfter($('#cont_file_file_cer'));
          }
          else if(attr == 'file_file_key'){
            error.insertAfter($('#cont_file_file_key'));
          }
          else {
            error.insertAfter(element);
          }
        }
      },
      rules: {
        inputCreatkey: {
          required: true,
          number: true,
          minlength: 2,
          maxlength: 10
        },
        fileInput: {
          required: true,
          accept:"jpg,png,jpeg"
        },
      },
      messages: {
        fileInput: {
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
            //-------------------------------------------------------------------------------------->
            var form = $('#form')[0];
            var formData = new FormData(form);
            $.ajax({
              type: 'POST',
              url: "/base/companies-create",
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
                        window.location.href = "/base/companies";
                      }
                    });
                }
              },
              error: function (data) {
                var validator = $( "#form" ).validate();
                validator.resetForm();
                Swal.fire({
                   type: 'error',
                   title: 'Operación abortada',
                   text: 'Ningúna operación afectuada :)',
                 });
              }
            });
            //-------------------------------------------------------------------------------------->
          }
          else {
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
