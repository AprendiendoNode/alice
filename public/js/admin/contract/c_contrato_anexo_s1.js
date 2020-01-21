function limpiar1_anexos1() {
  $("#sel_anexo_vertical option[value!='']").remove();
  $("#sel_anexo_cadenas option[value!='']").remove();
  $('input[name="key_anexo_verticals"]').val('');
  $('input[name="key_anexo_cadena"]').val('');
  $('input[name="key_anexo_contrato"]').val('');
  $('input[name="key_anexo_sitio"]').val('');
}

function limpiar2_anexo1() {
  $("#sel_anexo_cadenas option[value!='']").remove();
  $('input[name="key_anexo_cadena"]').val('');
  $('input[name="key_anexo_contrato"]').val('');
  $('input[name="key_anexo_sitio"]').val('');
}
function limpiar3_anexo1() {
  $("#sel_master_to_anexo option[value!='']").remove();
  $('input[name="key_anexo_sitio"]').val('');
}

$(".validation-wizard-anexo").on('click','.addcadenaanexo',function(){
    $('#modal_cadena').modal('show');
});


$(".validation-wizard-anexo").on('change','#sel_anexo_service',function(){
  var group = $(this).val();
  if (group != '') {
    $.ajax({
      type: "POST",
      url: "/idproy_search_key_one",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        $('input[name="key_anexo_service"]').val(datax[0].letter);
        $('#sel_anexo_vertical').val('').trigger('change');
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
    $.ajax({
         type: "POST",
         url: "/idproy_search_vertical_by_class",
         data: { valor : group , _token : _token },
         success: function (data){
           count_data = data.length;
           limpiar1_anexos1();
           if (count_data > 0) {
             $.each(JSON.parse(data),function(index, objdata){
               $('#sel_anexo_vertical').append('<option value="'+objdata.id+'">'+ objdata.name +'</option>');
             });
           }
         },
         error: function (data) {
           console.log('Error:', data);
         }
       });
  }
  else {
     limpiar1_anexos1();
     $('input[name="key_anexo_service"]').val('');
  }
});

$(".validation-wizard-anexo").on('change','#sel_anexo_vertical',function(){
  var group = $(this).val();
  if (group != '') {
    $.ajax({
      type: "POST",
      url: "/idproy_search_key_two",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        $('input[name="key_anexo_verticals"]').val(datax[0].key);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
    $.ajax({
      type: "POST",
      url: "/idproy_search_cadena_by_vert",
      data: { valor : group , _token : _token },
      success: function (data){
        count_data = data.length;
        limpiar2_anexo1();
        if (count_data > 0) {
          $.each(JSON.parse(data),function(index, objdata){
            $('#sel_anexo_cadenas').append('<option value="'+objdata.id+'">'+ objdata.cadena +'</option>');
          });
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else{
    limpiar2_anexo1();
    $('input[name="key_anexo_verticals"]').val('');
  }
});

$(".validation-wizard-anexo").on('change','#sel_anexo_cadenas',function(){
  var group = $(this).val();
  if (group != '') {
    $.ajax({
      type: "POST",
      url: "/idproy_search_key_three",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        $('input[name="key_anexo_cadena"]').val(datax[0].key);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
    $.ajax({
      type: "POST",
      url: "/idproy_search_by_cadena",
      data: { valor : group , _token : _token },
      success: function (data){
        count_data = data.length;
        limpiar3_anexo1();
        if (count_data > 0) {
          // $('#sel_master_to_anexo').append('<option value="1"> Opcion 1</option>');
          $('[name="sel_master_to_anexo"] option[value!=""]').remove();
          $.each(JSON.parse(data),function(index, objdata){
            $('#sel_master_to_anexo').append('<option value="'+objdata.id+'">'+ objdata.key +'</option>');
          });
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else {
    $('input[name="key_anexo_contrato"]').val('');
    $('input[name="key_anexo_cadena"]').val('');
    $('input[name="key_anexo_sitio"]').val('');
  }
});
//CORREGIR EN BASE DE LA BASE DE DATOS
$(".validation-wizard-anexo").on('change','#sel_master_to_anexo',function(){
  var group = $(this).val();
  if (group != '') {
    //numero del contrato maestro
    $.ajax({
      type: "POST",
      url: "/search_n_master_cadena",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = data;
        $('input[name="key_anexo_contrato"]').val(datax);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
    //CANTIDAD DE ANEXO MAS 1
    $.ajax({
      type: "POST",
      url: "/count_anexo_by_cont_maestro",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        var num_anexo = datax[0].cantidad + 1;
        $('input[name="key_anexo_sitio"]').val(num_anexo);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });


    $.ajax({
      type: "POST",
      url: "/getdata_infomaster_byanexo",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        if (datax != '[]' && datax.length != 0) {
          $("#datainfo_name_cont").text(datax[0].contacto);
          $("#datainfo_email_cont").text(datax[0].email_contacto);
          $("#datainfo_resg_cont").text(datax[0].resguardo);
          $("#datainfo_status_cont").text(datax[0].status);
          $("#datainfo_rfc_cont").text(datax[0].rfc);
          $("#datainfo_rfcname_cont").text(datax[0].razon_social);
          $("#datainfo_address_cont").text(datax[0].direccion);
          $("#datainfo_postal_cont").text(datax[0].postcode);
          $("#datainfo_nat_cont").text(datax[0].nacionalidad);
          $("#datainfo_type_cont").text(datax[0].tipo);
        }
        else {
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
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else{
    $('input[name="key_anexo_cadena"]').val('');
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
  }
});
