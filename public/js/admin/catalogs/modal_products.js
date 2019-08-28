$(function() {
  //-----------------------------------------------------------
  $("#creatproductsystem").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    errorPlacement: function (error, element) {
        var attr = $('[name="'+element[0].name+'"]').attr('datas');
        // console.log(element[0].name);
        // console.log(attr);
        // console.log($('[name="'+element[0].name+'"]'));
        if (element[0].id === 'fileInput') {
          error.insertAfter($('#cont_file'));
        }
        else {
          if(attr == 'sel_categoria'){
            error.insertAfter($('#cont_category'));
          }
          else if(attr == 'sel_modelo'){
            error.insertAfter($('#cont_model'));
          }
          else if(attr == 'sel_estatus'){
            error.insertAfter($('#cont_estatus'));
          }
          else {
            error.insertAfter(element);
          }
        }
      },
      rules: {
        inputCreatkey: {
          required: true,
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
            var form = $('#creatproductsystem')[0];
            var formData = new FormData(form);
            $.ajax({
              type: 'POST',
              url: "/catalogs/products-create",
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
                        window.location.href = "/catalogs/products";
                      }
                    });
                }
              },
              error: function (data) {
                $('#modal-CreatProduct').modal('toggle');
                $("#creatproductsystem")[0].reset();
                var validator = $( "#creatproductsystem" ).validate();
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
            $('#modal-CreatNew').modal('toggle');
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
