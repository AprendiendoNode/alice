$('.btngeneral').on('click', function(e){

  var id= $('select[name="select_one"]').val();
  var _token = $('input[name="_token"]').val();
  if (id == ''){
    $('.contrato_a').hide(); //muestro mediante clase
    $('.contrato_b').hide(); //muestro mediante clase
  }
  if (id == '1'){
    $('.contrato_a').show(); //muestro mediante clase
    $('.contrato_b').hide(); //muestro mediante clase

  }
  if (id == '2'){
    $('.contrato_a').hide(); //muestro mediante clase
    $('.contrato_b').show(); //muestro mediante clase
  }

  $("#validation_master")[0].reset();
  var validator_master = $( "#validation_master" ).validate();
  validator_master.resetForm();
  $("#validation_master-t-0").get(0).click();

  $('input[name="key_maestro_service"]').val('');
  $('input[name="key_maestro_verticals"]').val('');
  $('input[name="key_maestro_cadena"]').val('');
  $('input[name="key_maestro_contrato"]').val('');
  $('input[name="key_maestro_sitio"]').val('');


  $("#validation_anexo")[0].reset();
  var validator_anexo = $( "#validation_anexo" ).validate();
  validator_anexo.resetForm();
  $("#validation_anexo-t-0").get(0).click();
  $('input[name="key_anexo_service"]').val('');
  $('input[name="key_anexo_verticals"]').val('');
  $('input[name="key_anexo_cadena"]').val('');
  $('input[name="key_anexo_contrato"]').val('');
  $('input[name="key_anexo_sitio"]').val('');

  $("#datainfo_name_cont").text('');
  $("#datainfo_email_cont").text('');
  $("#datainfo_resg_cont").text('');
  $("#datainfo_status_cont").text('');
  $("#datainfo_rfc_cont").text('');
  $("#datainfo_rfcname_cont").text('');
  $("#datainfo_address_cont").text('');
  $("#datainfo_postal_cont").text('');
  $("#datainfo_nat_cont").text('');
  $("#datainfo_type_cont").text('');
});
