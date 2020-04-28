$(function() {
    $('#InputAplicaGarantia').val(0).trigger('change');
    $('#InputMontoGarantia').val('');
    $('#InputMontoGarantia').prop('readonly', true);

    $("#form").validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        errorPlacement: function(error, element) {
            var attr = $('[name="' + element[0].name + '"]').attr('datas');
            if (element[0].id === 'fileInput') {
                error.insertAfter($('#cont_file'));
            } else {
                if (attr == 'sel_estatus') {
                    error.insertAfter($('#cont_estatus'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        rules: {
            InputTelefonoContacto: {
                required: true,
                number: true,
                minlength: 8,
                maxlength: 10
            },
            InputVigencia: {
                required: true,
                number: true,
                minlength: 1,
                maxlength: 4
            }
        },
        messages: {
        },
        // debug: true,
        // errorElement: "label",
        submitHandler: function(form, event) {
            event.preventDefault();
            $('#form')[0].submit();

            $("#form")[0].reset();
            $('#InputAplicaGarantia').val(0).trigger('change');
            $('#InputMontoGarantia').val('');
            $('#InputMontoGarantia').prop('readonly', true);
        }
    });
});

$('#InputAplicaGarantia').on('change', function() {
    var valor = $(this).val();
    $('#InputMontoGarantia').val('');
    if (valor == 0) {
        $('#InputMontoGarantia').prop('readonly', true); // console.log(0);
        $("#InputMontoGarantia").prop('required', false);
    } else {
        $('#InputMontoGarantia').prop('readonly', false); // console.log(1);
        $("#InputMontoGarantia").prop('required', true);
    }
});

function mayuscula(e) {
    e.value = e.value.toUpperCase();
}

function redondeo_tc() {
    var token = $('input[name="_token"]').val();
    var valor = $('#currency_value').val();
    $.ajax({
        type: "POST",
        url: "/sales/redondeo_tc",
        data: {
            _token: token,
            tc: valor
        },
        success: function(data) {
            var valor = $('#currency_value').val(data.text);
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
}

function redondeo_monto() {
    var token = $('input[name="_token"]').val();
    var valor = $('#InputMontoPago').val();
    if (valor) {
      $.ajax({
        type: "POST",
        url: "/monto_caratula_contrato",
        data: {
          _token: token,
          valorInput: valor
        },
        success: function(data) {
          $('#InputMontoPago').val(data.text);
        },
        error: function(data) {
          console.log('Error:', data);
        }
      });
    }
}

function redondeo_garantia() {
    var token = $('input[name="_token"]').val();
    var valor = $('#InputMontoGarantia').val();
    if (valor) {
      $.ajax({
          type: "POST",
          url: "/monto_caratula_contrato",
          data: {
              _token: token,
              valorInput: valor
          },
          success: function(data) {
              $('#InputMontoGarantia').val(data.text);
          },
          error: function(data) {
              console.log('Error:', data);
          }
      });
    }
}

$('.plantilla').on('click', function() {
  $('#form_blank')[0].submit();
});
