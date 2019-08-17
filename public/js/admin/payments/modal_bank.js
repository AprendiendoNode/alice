$('.databank').on('click', function(){
  var proveedor_act = $('#provider').val();
  if (proveedor_act == '') {
    swal("Operación abortada", "Selecciona un proveedor primero :(", "error");
  }
  else {
    $('#data_account_bank')[0].reset();
    $('#data_account_bank').data('formValidation').resetForm($('#data_account_bank'));

    $('#reg_provider').val($('#provider :selected').text());
    $('#reg_bancos').val('').trigger('change');
    $('#reg_coins').val('').trigger('change');
    $('#modal_bank').modal('toggle');
  }
});
