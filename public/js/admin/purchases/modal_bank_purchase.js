$('.databank').on('click', function(){
  var proveedor_act = $('#customer_id').val();
  if (proveedor_act == '') {
    Swal.fire({
       type: 'error',
       title: 'Operación abortada',
       text: "Selecciona un proveedor primero :("
     });
  }
  else {
    $('#data_account_bank')[0].reset();
    // $('#data_account_bank').data('formValidation').resetForm($('#data_account_bank'));

    $('#reg_provider').val($('#customer_id :selected').text());
    $('#reg_bancos').val('').trigger('change');
    $('#reg_coins').val('').trigger('change');
    $('#modal_bank').modal('toggle');
  }
});

function getBank() {
    var id_client = $('#customer').val();
    var id_prov = $('#customer_id').val();

    var _token = $('input[name="_token"]').val();
    var datax;

    $.ajax({
        type: "POST",
        url: "/get_data_bank",
        data: {
            data_one: id_client,
            data_two: id_prov,
            _token: _token
        },
        success: function(data) {
            if (data == null || data == '[]') {
                $('#bank').empty();
                $('#bank').append('<option value="">Elegir...</option>');
            } else {
                datax = JSON.parse(data);
                if ($.trim(data)) {
                    $.each(datax, function(i, item) {
                        if (item.status == 1) {
                            $('#bank').append("<option selected value=" + item.id + ">" + item.banco + "</option>");
                        } else {
                            $('#bank').append("<option value=" + item.id + ">" + item.banco + "</option>");
                        }

                    });
                } else {
                    $("#customer").text('');
                    alert('error');
                }
            }
            getCuentaClabe();
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
}

function getCuentaClabe() {
    var id_bank = $('#bank').val();
    var id_prov = $('#customer_id').val();

    var _token = $('input[name="_token"]').val();
    var datax;
    $.ajax({
        type: "POST",
        url: "/get_account_clabe",
        data: {
            data_one: id_prov,
            data_two: id_bank,
            _token: _token
        },
        success: function(data) {
            if (data == null || data == '[]') {
                $('#account').empty();
                $('#account').append('<option value="">Elegir...</option>');
                $('#clabe').val('');
                $('#reference_banc').val('');
            } else {
                $('#account').empty();
                $('#account').append('<option value="">Elegir...</option>');
                $('#clabe').val('');
                $('#reference_banc').val('');
                datax = JSON.parse(data);
                if ($.trim(data)) {

                    $.each(datax, function(i, item) {
                        if (i == 0) {
                            $('#account').append("<option selected value=" + item.id + ">" + item.cuenta + "</option>");
                        } else {
                            $('#account').append("<option value=" + item.id + ">" + item.cuenta + "</option>");
                        }

                        $('#clabe').val('');
                        $('#reference_banc').val('');
                    })
                } else {
                    $('#clabe').val('');
                    $('#reference_banc').val('');
                }
                var id_account = $('#account').val();
                getdataCuenta(id_account, _token);
            }
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
}
//Cuenta
$('#account').on('change', function(e) {
    var id = $(this).val();
    var _token = $('input[name="_token"]').val();
    $('#clabe').val('');
    $('#reference_banc').val('');
    getdataCuenta(id, _token);
});

function getdataCuenta(campoa, campob) {
    $.ajax({
        type: "POST",
        url: "/get_data_accw",
        data: {
            data_one: campoa,
            _token: campob
        },
        success: function(data) {
            if (data == null || data == '[]') {
                $('#reference_banc').val('');
                $('#clabe').val('');
            } else {
                if ($.trim(data)) {
                    datax = JSON.parse(data);
                    console.log(datax);
                    var currency = document.getElementById('clabe');
                    currency.dataset.currency = datax[0].currency_id;
                    $('#clabe').val(datax[0].clabe);
                    $("#reference_banc").val(datax[0].referencia);
                    checkCurrency();
                } else {
                    $('#reference_banc').val('');
                    $('#clabe').val('');
                }
            }
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
}

function checkCurrency() {
    var coinBank;
    var coinId;
    var coinselect;
    var option;
    var coinselect = document.getElementById('currency_id');
    var inputclabe = document.getElementById('clabe');
    coinId = coinselect.value;
    coinBank = inputclabe.dataset.currency;
    if (coinBank != coinId) {
        for (var i = 0; i < coinselect.options.length; i++) {
            option = coinselect.options[i];
            if (option.value == coinBank) {
                option.setAttribute('selected', true);
            } else {
                option.removeAttribute('selected');
            }
        }
    } else {
        $("#coin").parent().parent().removeClass('has-error');
        $("#coin").parent().parent().addClass('has-sucess');
    }
}
