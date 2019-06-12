$(document).ready( function() {
  $("#update_cliente_responsable").on("blur", function(){
    $("#cliente_responsable").text($(this).val());
  });
  $("#update_cliente_tel").on("blur", function(){
        $("#cliente_tel").text($(this).val());
  });
  $("#update_cliente_email").on("blur", function(){
        $("#cliente_email").text($(this).val());
  });
  $('#validate_client').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      update_cliente_responsable: {
        validators: {
          notEmpty: {
            message: 'The name of the responsible is required'
          },
          stringLength: {
            min: 3,
            max: 100,
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
        var form = $('#validate_client')[0];
        var formData = new FormData(form);
        var id_site = $('#select_one').val();
        formData.append('id_site', id_site);

        $.ajax({
          type: "POST",
          url: "/update_reference_by_cover",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            datax = data;
            if (datax != '0') {
              swal("Operación Completada!", ":)", "success");
            }
            else {
              swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
            }
            $("#validate_client")[0].reset();
            $('#validate_client').data('formValidation').resetForm($('#validate_client'));
          },
          error: function (data) {
            console.log('Error:', data);
            swal.close();
          }
        })
      }
      else {
        $("#validate_client")[0].reset();
        $('#validate_client').data('formValidation').resetForm($('#validate_client'));
        swal("Operación abortada", "Ningún cambio registrado :)", "error");
      }
    });
    /* --------------------------------------------------------------------- */

    // alert('Pending reset button');
    // $('#modal_cadena').modal('toggle');
  });
});
