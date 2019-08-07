$(document).ready( function() {
  $('#validate_grup').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      cadena_name: {
        validators: {
          notEmpty: {
            message: 'The name is required'
          },
          stringLength: {
            min: 3,
            max: 100,
          }
        }
      },
      cadena_key: {
        validators: {
          notEmpty: {
            message: 'The key of the group is required'
          },
          stringLength: {
            min: 3,
            max: 5,
          }
        }
      }
    }
  })
  .on('success.form.fv', function(e) {
    e.preventDefault();

    /* --------------------------------------------------------------------- */
    swal({
      title: "¿Desea continuar?",
      text: "Espere mientras se sube la información.",
      type: "info",
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
        var form = $('#validate_grup')[0];
        var formData = new FormData(form);
        var id_vertical = $('#sel_master_vertical').val();
        formData.append('id_vertical', id_vertical);

        console.log(formData);
        $.ajax({
          type: "POST",
          url: "/create_group_by_contract",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            datax = data;
            if (datax != '0') {
              $('#modal_cadena').modal('toggle');

              $('#sel_master_service').val('').trigger('change');
              $("#sel_master_vertical option[value!='']").remove();
              $("#sel_master_cadenas option[value!='']").remove();
              swal("Operación Completada!", "Realice la operacion nuevamente, :)", "success");
            }
            else {
              $('#modal_cadena').modal('toggle');
              swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
            }
            $("#validate_grup")[0].reset();
            $('#validate_grup').data('formValidation').resetForm($('#validate_grup'));
          },
          error: function (data) {
            console.log('Error:', data);
            swal.close();
          }
        })

      }
      else {
        $("#validate_grup")[0].reset();
        $('#validate_grup').data('formValidation').resetForm($('#validate_grup'));
        $('#modal_cadena').modal('toggle');
        swal("Operación abortada", "Ningún grupo añadido :)", "error");
      }
    });
    /* --------------------------------------------------------------------- */

    // alert('Pending reset button');
    // $('#modal_cadena').modal('toggle');
  });
});

$('#cadena_name').on('blur', function() {
  var _token = $('input[name="_token"]').val();
  var valor = this.value;
  $.ajax({
    type: "POST",
    url: "/find_cadena_by_contract",
    data: { _token : _token,  text: valor},
    success: function (data){
      if (data === '1') {
        $('#cadena_name').val('');
        // $('#validate_grup').data('formValidation').resetForm($('#validate_grup'));
        $('#validate_grup').data('formValidation').resetField($('#cadena_name'));
        swal("Operación abortada", "Error cadena ya registrada, intenta nuevamente :(", "error");
        // menssage_toast('Mensaje', '2', 'Error cadena ya registrada, intenta nuevamente.' , '3000');
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
});
