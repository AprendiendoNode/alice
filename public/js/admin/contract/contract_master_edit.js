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
        var service = $('#sel_master_service').val();
        var vertical = $('#sel_master_vertical').val();
        var cadena = $('#sel_master_cadenas').val();
        $('#sel_master_digit').empty().append('<option selected="selected" value="test">Elegir</option>');
        $('input[name="key_maestro_contrato"]').val('');
        get_digit_master(service, vertical, cadena);
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
        var nuevo_cont = datax[0].cantidad;

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

function get_digit_master(service, vertical, cadena){
  $.ajax({
    type: "POST",
    url: "/get_digit_contract_master",
    data: { id_service : service, id_vertical : vertical , id_cadena : cadena,  _token : _token },
    success: function (data){
      console.log(data);
      data.forEach(contrato => {
        $('#sel_master_digit').append($('<option>', {
          value: contrato.id_contract,
          text : contrato.digit
        }));

      });

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

}
$(".validation-wizard-master").on('change','#sel_razon',function(){
  console.log('entra');
  var razon = $(this).val();
  if (razon != '') {
    $.ajax({
      type: "POST",
      url: "/get_data_rz_selected",
      data: { razon : razon, _token : _token },
      success: function (data){
        //console.log(data);
        $('#contact_taxid').val(data[0]['taxid']);
        $('#contact_numid').val(data[0]['numid']);
        $('#contact_email').val(data[0]['email']);
        $('#contact_telephone').val(data[0]['phone']);
        $('#contact_cellphone').val(data[0]['phone_mobile']);
        $('#contact_address').val(data[0]['address_1']);
        $('#contact_postcode').val(data[0]['postcode']);

      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  }

});

$(".validation-wizard-master").on('change','#sel_master_digit',function(){
  var digit = $("#sel_master_digit option:selected").text();
  var id_contract = $("#sel_master_digit option:selected").val();
  $('input[name="key_maestro_contrato"]').val(digit);
  $('input[name="key_maestro_sitio"]').val('00');

  $.ajax({
    type: "POST",
    url: "/get_data_contract_master",
    data: { id_contract : id_contract,  _token : _token },
    success: function (data){
      //console.log(data);
      //$("#contact_name").val(data[0].cliente);
      //$("#contact_email").val(data[0].email);
      //$("#contact_telephone").val(data[0].telephone);
      $('#contact_taxid').val(data[0]['taxid']);
      $('#contact_numid').val(data[0]['numid']);
      $('#contact_email').val(data[0]['email']);
      $('#contact_telephone').val(data[0]['phone']);
      $('#contact_cellphone').val(data[0]['phone_mobile']);
      $('#contact_address').val(data[0]['address_1']);
      $('#contact_postcode').val(data[0]['postcode']);
      var rz_select = document.getElementById("sel_razon");
      var option_rz;
      var user_select = document.getElementById("user_resc");
      var option_user;
      var status_select = document.getElementById("status_cont");
      var option_status;
      // setting RFC
      for (var i=0; i < rz_select.options.length; i++) {
          option_rz = rz_select.options[i];
          if (option_rz.value == data[0].rfc_id) {
              option_rz.setAttribute('selected', true);
          }else{
              option_rz.removeAttribute('selected');
          }
      }
      // Setting user resg
      for (var i=0; i < user_select.options.length; i++) {
          option_user = user_select.options[i];
          if (option_user.value == data[0].user_id) {
              option_user.setAttribute('selected', true);
          }else{
              option_user.removeAttribute('selected');
          }
      }
      //Setting status contract
      for (var i=0; i < status_select.options.length; i++) {
          option_status = status_select.options[i];
          if (option_status.value == data[0].contract_status_id) {
              option_status.setAttribute('selected', true);
          }else{
              option_status.removeAttribute('selected');
          }
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

});


/*
*  Enviando formulario
*/

$.validator.addMethod('filesize', function(value, element, param) {
    // param = size (in bytes)
    // element = element to validate (<input>)
    // value = value of the element (file name)
    return this.optional(element) || (element.files[0].size <= param)
});

//Contrato Maestro
var form_master = $(".validation-wizard-master").show();

$(".validation-wizard-master").steps({
    headerTag: "h6",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: "Submit"
    },
    onStepChanging: function (event, currentIndex, newIndex) {
        return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form_master.find(".body:eq(" + newIndex + ") label.error").remove(), form_master.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form_master.validate().settings.ignore = ":disabled,:hidden", form_master.valid())
    },
    onFinishing: function (event, currentIndex) {
        return form_master.validate().settings.ignore = ":disabled", form_master.valid()
    },
    onFinished: function (event, currentIndex) {
      event.preventDefault();
        // swal("form_master Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
              Swal.fire({
                title: "Estás seguro?",
                text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Continuar.!",
                cancelButtonText: "Cancelar.!",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                showLoaderOnConfirm: true,
      }).then((result) => {
        if (result.value) {

                        var form = $('#validation_master')[0];
                        var formData = new FormData(form);
                        var digit = $("#sel_master_digit option:selected").text();
                        formData.append('digit', digit);

                        $.ajax({
                          type: "POST",
                          url: "/update_contract_master",
                          data: formData,
                          contentType: false,
                          processData: false,
                          success: function (data){

                            if(data == "true"){
                              $("#validation_master")[0].reset();

                              $("input[name='key_maestro_service']").val('');
                              $('input[name="key_maestro_verticals"]').val('');
                              $('input[name="key_maestro_cadena"]').val('');
                              $('input[name="key_maestro_contrato"]').val('');
                              $('input[name="key_maestro_sitio"]').val('');

                              Swal.fire({title: "Contrato actualizado",  type: "success"},
                                  function(){
                                      location.reload();
                                  }
                               );

                            }else{
                              Swal.fire("Error al actualizar contrato", "", "Error");
                            }


                          },
                          error: function (data) {
                            console.log('Error:', data);
                            Swal.close();
                          }
                        })
        }
        else {
         Swal.fire("Operación abortada", "Ningúna operación afectuada :)", "error");
       }
      })
      /************************************************************************************/
    }
}), $(".validation-wizard-master").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    highlight: function (element, errorClass) {
        $(element).removeClass(errorClass)
    },
    unhighlight: function (element, errorClass) {
        $(element).removeClass(errorClass)
    },
    errorPlacement: function (error, element) {
        // error.insertAfter(element);
        if (element[0].id === 'fileInput') {
          error.insertAfter($('#cont_file'));
        }
        else {
          error.insertAfter(element);
        }
    },
    rules: {
        contact_email: {
          //email: true
        },
        fileInput: {
          extension: 'pdf',
          filesize: 20000000
        },
        contact_telephone: {
          //required: true,
          //number: true,
          //minlength: 7,
          //maxlength: 10
        },
    },
    messages: {
            fileInput:{
                filesize:" file size must be less than 20 MB.",
                accept:"Please upload .pdf file of notice.",
                required:"Please upload file."
            }
        },
})
