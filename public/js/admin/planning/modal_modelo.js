$(document).ready( function() {
  $('#creatmodelsystem').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      inputCreatModel: {
        validators: {
          notEmpty: {
            message: 'The model is required'
          },
          stringLength: {
            min: 3,
            max: 150,
          }
        }
      },
      sel_modal_especification: {
        validators: {
          notEmpty: {
            message: 'The specification is required'
          },
        }
      },
      sel_modal_marca:{
        validators: {
          notEmpty: {
            message: 'The brand is required'
          }
        }
      },
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
        var form = $('#creatmodelsystem')[0];
        var formData = new FormData(form);
        $.ajax({
          type: 'POST',
          url: "/adminprod_create_model",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            datax = data;
            if (datax != '0') {
              swal("Operación Completada!", ":)", "success");
              $.ajax({
                   type: "POST",
                   url: "/adminprod_restore_model",
                   data: { _token : $('input[name="_token"]').val() },
                   success: function (data){
                     count_data = data.length;
                     $("#sel_modelo option[value!='']").remove();
                     if (count_data > 0) {
                       $.each(JSON.parse(data),function(index, objdata){
                         $('#sel_modelo').append('<option value="'+objdata.id+'">'+ objdata.modelo +'</option>');
                       });
                     }
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
              });
              $('#modal-CreatModelo').modal('toggle');

            }
            else {
              $('#modal-CreatModelo').modal('toggle');
              swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
            }
          },
          error: function (data) {
            swal("Operación abortada", "Ningúna operación afectuada :)", "error");
            $('#creatmodelsystem')[0].reset();
            $('#creatmodelsystem').data('formValidation').resetForm();
            $('#modal-CreatModelo').modal('toggle');
          }
        });

      }
      else {
        swal("Operación abortada", "Ningúna operación afectuada :)", "error");
        $('#creatmodelsystem')[0].reset();
        $('#creatmodelsystem').data('formValidation').resetForm();
        $('#modal-CreatModelo').modal('toggle');
      }
    });
    /* --------------------------------------------------------------------- */
  });
});

$(".addmodel").on("click", function (){
    $('#modal-CreatModelo').modal('show');
    if (document.getElementById("creatmodelsystem")) {
      $('#creatmodelsystem')[0].reset();
      $('#creatmodelsystem').data('formValidation').resetForm();
    }
});
