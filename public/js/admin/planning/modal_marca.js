$(document).ready( function() {
  $('#creatmodelmarca').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      inputCreatMarca: {
        validators: {
          notEmpty: {
            message: 'The brand is required'
          },
          stringLength: {
            min: 3,
            max: 150,
          }
        }
      },
      inputCreatDistribuidor: {
        validators: {
          notEmpty: {
            message: 'The name of the distributor is required'
          },
          stringLength: {
            min: 3,
            max: 150,
          }
        }
      }
    }
  })
  .on('success.form.fv', function(e) {
    e.preventDefault();
    /* --------------------------------------------------------------------- */
    swal({
      title: "Estás seguro?",
      text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Continuar.!",
      cancelButtonText: "Cancelar.!",
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true,
    },
    function(isConfirm) {
      if (isConfirm) {
        // The AJAX
        var form = $('#creatmodelmarca')[0];
        var formData = new FormData(form);
        $.ajax({
          type: 'POST',
          url: "/adminprod_create_marca",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            datax = data;
            if (datax != '0') {
              swal("Operación Completada!", ":)", "success");
              $.ajax({
                   type: "POST",
                   url: "/adminprod_restore_marca",
                   data: { _token : $('input[name="_token"]').val() },
                   success: function (data){
                     count_data = data.length;
                     $("#sel_modal_marca option[value!='']").remove();
                     if (count_data > 0) {
                       $.each(JSON.parse(data),function(index, objdata){
                         $('#sel_modal_marca').append('<option value="'+objdata.id+'">'+ objdata.marca +'</option>');
                       });
                     }
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
              });
              $('#modal-CreatMarca').modal('toggle');

            }
            else {
              $('#modal-CreatMarca').modal('toggle');
              swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
            }
          },
          error: function (data) {
            swal("Operación abortada", "Ningúna operación afectuada :)", "error");
            $('#creatmodelmarca')[0].reset();
            $('#creatmodelmarca').data('formValidation').resetForm();
            $('#modal-CreatMarca').modal('toggle');
          }
        });
      }
      else {
        swal("Operación abortada", "Ningúna operación afectuada :)", "error");
        $('#creatmodelmarca')[0].reset();
        $('#creatmodelmarca').data('formValidation').resetForm();
        $('#modal-CreatMarca').modal('toggle');
      }
    });
    /* --------------------------------------------------------------------- */
  });
});
