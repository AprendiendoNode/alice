//file_file_cer-error
$(function() {
  jQuery.validator.addMethod("noSpace", function(value, element) {
  return value.indexOf(" ") < 0 && value != "";
  }, "This field is required, spaces are not accepted");
  //-----------------------------------------------------------
  $("#form").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
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
            var customer = $('#select_customer').val();
            formData.append("customer", customer);
            $.ajax({
              type: 'POST',
              url: "edit_data_customer",
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
                       window.location.href = "/sales/customer-banks";
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
