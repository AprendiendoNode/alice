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
          required: false,
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
              url: "/base/companies-store",
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
$(function() {
  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });
  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;
          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }
      });
  });
});
$("#fileInput").change(function () {
  filePreview(this);
});
function filePreview(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var result=e.target.result;
      $('#img_preview').attr("src",result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
