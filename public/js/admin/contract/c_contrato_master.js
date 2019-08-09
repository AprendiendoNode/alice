var _token = $('input[name="_token"]').val();

function limpiar1_master() {
  $("#sel_master_vertical option[value!='']").remove();
  $("#sel_master_cadenas option[value!='']").remove();
  $('input[name="key_maestro_verticals"]').val('');
  $('input[name="key_maestro_cadena"]').val('');
  $('input[name="key_maestro_contrato"]').val('');
  $('input[name="key_maestro_sitio"]').val('');
}

function limpiar2_master() {
  $("#sel_master_cadenas option[value!='']").remove();
  $('input[name="key_maestro_cadena"]').val('');
  $('input[name="key_maestro_contrato"]').val('');
  $('input[name="key_maestro_sitio"]').val('');
}

$(".validation-wizard-master").on('change','#sel_master_service',function(){
  var group = $(this).val();
  if (group != '') {
    $.ajax({
      type: "POST",
      url: "/idproy_search_key_one",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        $('input[name="key_maestro_service"]').val(datax[0].letter);
        $('#sel_master_vertical').val('').trigger('change');
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
           limpiar1_master();
           if (count_data > 0) {
             $.each(JSON.parse(data),function(index, objdata){
               $('#sel_master_vertical').append('<option value="'+objdata.id+'">'+ objdata.name +'</option>');
             });
           }
         },
         error: function (data) {
           console.log('Error:', data);
         }
       });
  }
  else {
     limpiar1_master();
     $('input[name="key_maestro_service"]').val('');
  }
});

$(".validation-wizard-master").on('change','#sel_master_vertical',function(){
  var group = $(this).val();
  if (group != '') {
    $.ajax({
      type: "POST",
      url: "/idproy_search_key_two",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        $('input[name="key_maestro_verticals"]').val(datax[0].key);
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
        limpiar2_master();
        if (count_data > 0) {
          $.each(JSON.parse(data),function(index, objdata){
            $('#sel_master_cadenas').append('<option value="'+objdata.id+'">'+ objdata.cadena +'</option>');
          });
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else{
    limpiar2_master();
    $('input[name="key_maestro_verticals"]').val('');
  }
});

$(".validation-wizard-master").on('change','#sel_master_cadenas',function(){
  var group = $(this).val();
  if (group != '') {
    $.ajax({
      type: "POST",
      url: "/idproy_search_key_three",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        $('input[name="key_maestro_cadena"]').val(datax[0].key);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
    $.ajax({
      type: "POST",
      url: "/count_cont_by_cadena",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        var nuevo_cont = datax[0].cantidad + 1;
        $('input[name="key_maestro_contrato"]').val(nuevo_cont);
        $('input[name="key_maestro_sitio"]').val('00');
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else {
    $('input[name="key_maestro_contrato"]').val('');
    $('input[name="key_maestro_cadena"]').val('');
    $('input[name="key_maestro_sitio"]').val('');
  }
});

$(".validation-wizard-master").on('click','.addcadenamaster',function(){

    if ($('#sel_master_vertical').val() != '') {
      $("#validate_grup")[0].reset();
      $('#validate_grup').data('formValidation').resetForm($('#validate_grup'));
      $('#modal_cadena').modal('show');
    }
    else {
      $("#validate_grup")[0].reset();
      $('#validate_grup').data('formValidation').resetForm($('#validate_grup'));
      swal("Operación abortada", "Seleccione la vertical primero antes de añadir un grupo :(", "error");
    }
});

$(".validation-wizard-master").on('click','.addButtonrazonmaster',function(){
    $('#modal_razon').modal('show');
});
