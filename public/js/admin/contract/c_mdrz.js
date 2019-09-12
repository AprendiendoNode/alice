$(document).ready( function() {
  $('#validate_d').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      n_rfc: {
        validators: {
          notEmpty: {
            message: 'The RFC is required'
          }
        }
      },
      rfc_name: {
        validators: {
          notEmpty: {
            message: 'The company name is required'
          },
          stringLength: {
            min: 3,
            max: 150,
            // message: 'The payment concept must be less than 700 characters long'
          }
        }
      },
      rfc_dir1: {
        validators: {
          notEmpty: {
            message: 'The address 1 is required'
          },
          stringLength: {
            min: 3,
            // message: 'The payment concept must be less than 700 characters long'
          }
        }
      },
      rfc_cp: {
        validators: {
          notEmpty: {
            message: 'The zip code is required'
          },
          stringLength: {
            min: 5,
          }
        }
      },
      rfc_type: {
        validators: {
          notEmpty: {
            message: 'The  type of person is required'
          }
        }
      },
      rfc_comp:{
        validators: {
          notEmpty: {
            message: 'The use of proof is required'
          }
        }
      },
      email_fact: {
          validators: {
              notEmpty: {
                  message: 'The email address is required and can\'t be empty'
              },
              emailAddress: {
                  message: 'The input is not a valid email address'
              }
          }
      },
      rfc_nacionalidad: {
        validators: {
          notEmpty: {
            message: 'The nationality is required'
          }
        }
      },
    }
  })
  .on('success.form.fv', function(e) {
    e.preventDefault();
        Swal.fire({
          title: "¿Desea continuar?",
          text: "Espere mientras se sube la información.",
          type: "info",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Continuar.!",
          cancelButtonText: "Cancelar.!",
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          showLoaderOnConfirm: true,
    }).then((result) => {
      if (result.value) {
        var form = $('#validate_d')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/create_rzcliente_by_contract",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            // console.log(data);
            datax = data;
            if (datax != '0') {
              $('#modal_razon').modal('toggle');
              /*Recargar las razones sociales ------------------------------------*/
              $.ajax({
                type: "POST",
                url: "./view_rzcliente_by_contract",
                data: { _token : $('input[name="_token"]').val() },
                success: function (data){
                    $('#sel_razon').val('').trigger('change');
                    $('[name="sel_razon"] option[value!=""]').remove();
                    $.each(JSON.parse(data),function(index, objdata){
                      $('[name="sel_razon"]').append('<option value="'+objdata.id+'">'+ objdata.name +'</option>');
                    });
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });
              /*--------------------------------------------------------------------*/

              Swal.fire("Operación Completada!", ":)", "success");
            }
            else {
              $('#modal_razon').modal('toggle');
              Swal.fire("Operación abortada", "Error al registrar intente otra vez :(", "error");
            }
            $("#validate_d")[0].reset();
            $('#validate_d').data('formValidation').resetForm($('#validate_d'));
          },
          error: function (data) {
            console.log('Error:', data);
            Swal.close();
          }
        }) //Fin ajax

      }//Fin if result.value
      else {
        $("#validate_d")[0].reset();
        $('#validate_d').data('formValidation').resetForm($('#validate_d'));
        $('#modal_razon').modal('toggle');
        Swal.fire("Operación abortada", "Ningún RFC añadido :(", "error");
      }
    })//Fin then
    /* --------------------------------------------------------------------- */
  });

  $("#rfc_cp").keyup(function(){
    // console.log(this.value.length);
    var valx = this.value;
    var valx_length = this.value.length;
    if(valx_length ==5 ){
      $.ajax({
        type: "POST",
        url: "/get_bankdata_zipcode",
        data: { valor : valx , _token : _token },
        success: function (data){
          count_data = data.length;
          if (count_data > 0) {
            datax = JSON.parse(data);
            if (JSON.stringify(data) != '"[]"') {
              $('input[name="rfc_pais"]').val(datax[0].pais);
              $('input[name="rfc_estado"]').val(datax[0].estado);
              $('input[name="rfc_municipio"]').val(datax[0].municipio);
              $('input[name="rfc_localidad"]').val(datax[0].localidad);
            }
            else {
              $('input[name="rfc_pais"]').val('');
              $('input[name="rfc_estado"]').val('');
              $('input[name="rfc_municipio"]').val('');
              $('input[name="rfc_localidad"]').val('');
            }
          }
          else{
            $('input[name="rfc_pais"]').val('');
            $('input[name="rfc_estado"]').val('');
            $('input[name="rfc_municipio"]').val('');
            $('input[name="rfc_localidad"]').val('');
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    }
    else {
      $('input[name="rfc_pais"]').val('');
      $('input[name="rfc_estado"]').val('');
      $('input[name="rfc_municipio"]').val('');
      $('input[name="rfc_localidad"]').val('');
    }

	});

  $('#n_rfc').on('blur', function() {
    var _token = $('input[name="_token"]').val();
    var valor = this.value;
    $.ajax({
      type: "POST",
      url: "/find_rfc_by_contract",
      data: { _token : _token,  text: valor},
      success: function (data){
        if (data === '1') {
          $('#n_rfc').val('');
          $('#validate_d').data('formValidation').resetField($('#n_rfc'));
          Swal.fire("Operación abortada", "Error RFC ya registrada, intenta nuevamente :(", "error");
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });

  $('#rfc_name').on('blur', function() {
    var _token = $('input[name="_token"]').val();
    var valor = this.value;
    $.ajax({
      type: "POST",
      url: "/find_namerfc_by_contract",
      data: { _token : _token,  text: valor},
      success: function (data){
        if (data === '1') {
          $('#rfc_name').val('');
          $('#validate_d').data('formValidation').resetField($('#rfc_name'));
          Swal.fire("Operación abortada", "Error Razon Social ya registrada, intenta nuevamente :(", "error");
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });


});
