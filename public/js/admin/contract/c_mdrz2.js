$(document).ready( function() {
  $('#validate_d').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      inputCreatName: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputCreatTaxid: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputCreatNumid: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputCreatEmail: {
          validators: {
              notEmpty: {
                  message: 'The email address is required and can\'t be empty'
              },
              emailAddress: {
                  message: 'The input is not a valid email address'
              }
          }
      },
      select_one_mdal: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      select_two_mdal: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      select_three_mdal: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      select_four_mdal: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputCreatAddress_1: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      select_six_mdal: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      select_seven_mdal: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      select_eight_mdal: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputCreatPostCode: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
    }
  })
  .on('success.form.fv', function(e) {
    e.preventDefault();
    /* --------------------------------------------------------------------- */
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
          url: "/create_rza_by_contract",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            datax = data;
            if (datax != '0') {
              $('#modal_razon').modal('toggle');
              /*Recargar las razones sociales ------------------------------------*/
              $.ajax({
                type: "POST",
                url: "./reset_rza_by_contract",
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

});
