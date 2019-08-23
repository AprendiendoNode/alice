$(function() {
  $(".select2").select2({width: '100%'});
  $('#select_hotels').select2({width: '100%',closeOnSelect:false});
  $('#select_ind_two').select2({width: '100%',closeOnSelect:false});
  google.maps.event.addDomListener(window, 'load', initialize_location);
  $('.input-daterange').datepicker({language: 'es', format: "yyyy-mm-dd",});
  $('#month_evaluate').datepicker({
      language: 'es',
      defaultDate: '',
      format: "yyyy-mm",
      viewMode: "months",
      minViewMode: "months",
      endDate: '-1m', //Esto indica que aparecera el mes hasta que termine el ultimo dia del mes.
      autoclose: true
  });
  $("#creatusersystem").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
      /*rules: {
        inputCreatkey: {
          required: true,
          number: true,
          minlength: 2,
          maxlength: 10
        },
        fileInput: {
          required: true,
          accept:"jpg,png,jpeg"
        },
      },
      messages: {
        fileInput: {
          required: "Select Image",
          accept: "Only image type jpg/png/jpeg is allowed"
        },
      },*/
      // debug: true,
      // errorElement: "label",
      submitHandler: function(form){
        // swal("Operación abortada", "Ningúna operación afectuada, Ingrese la latitud y longitud :)", "error");
        Swal.fire({
          title: "Estás seguro?",
          text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: "Continuar.!",
          cancelButtonText: "Cancelar.!",
        }).then((result) => {
          if (result.value) {
            //-------------------------------------------------------------------------------------->
            var form = $('#creatusersystem')[0];
            var formData = new FormData(form);
            // console.log(formData);
            $.ajax({
              type: 'POST',
              url: "/data_create_client_config",
              data: formData,
              contentType: false,
              processData: false,
              success: function (data){
                console.log(data);
                if (data == 'abort') {
                  console.log(data);
                  Swal.fire({
                     type: 'error',
                     title: 'Error encontrado..',
                     text: 'Realice la operacion nuevamente!',
                   });
                }
                else if (data == 'false') {
                  Swal.fire({
                     type: 'error',
                     title: 'Error encontrado..',
                     text: 'Ya existe!',
                   });
                }
                else {
                    let timerInterval;
                    Swal.fire({
                      type: 'success',
                      title: 'Operación Completada!',
                      html: 'Aplicando los cambios.',
                      timer: 2500,
                      onBeforeOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                          Swal.getContent().querySelector('strong')
                        }, 100)
                      },
                      onClose: () => {
                        clearInterval(timerInterval)
                      }
                    }).then((result) => {
                      if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.timer
                      ) {
                        window.location.href = "/configure_survey_admin_nps";
                      }
                    });
                }
              },
              error: function (data) {
                var validator = $( "#creatusersystem" ).validate();
                validator.resetForm();
                Swal.fire({
                   type: 'error',
                   title: 'Operación abortada',
                   text: 'Ningúna operación afectuada :)',
                 });
              }
            });
            //-------------------------------------------------------------------------------------->
          }
          else {
            Swal.fire({
               type: 'error',
               title: 'Operación',
               text: 'Cancelada',
             });
          }
        });
      }
  });
  $("#assign_hotel_client").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    submitHandler: function(form){
      Swal.fire({
        title: "Estás seguro?",
        text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Continuar.!",
        cancelButtonText: "Cancelar.!",
      }).then((result) => {
        if (result.value) {
          //-------------------------------------------------------------------------------------->
          var form = $('#assign_hotel_client')[0];
          var formData = new FormData(form);
          // console.log(formData);
          $.ajax({
            type: 'POST',
            url: "/creat_assign_surveyed",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              // console.log(data);
              if (data == 'abort') {
                console.log(data);
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Realice la operacion nuevamente!',
                 });
              }
              else if (data == 'false') {
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Ya existe!',
                 });
              }
              else {
                  let timerInterval;
                  Swal.fire({
                    type: 'success',
                    title: 'Operación Completada!',
                    html: 'Aplicando los cambios.',
                    timer: 2500,
                    onBeforeOpen: () => {
                      Swal.showLoading()
                      timerInterval = setInterval(() => {
                        Swal.getContent().querySelector('strong')
                      }, 100)
                    },
                    onClose: () => {
                      clearInterval(timerInterval)
                    }
                  }).then((result) => {
                    if (
                      // Read more about handling dismissals
                      result.dismiss === Swal.DismissReason.timer
                    ) {
                      window.location.href = "/configure_survey_admin_nps";
                    }
                  });
              }
            },
            error: function (data) {
              var validator = $( "#assign_hotel_client" ).validate();
              validator.resetForm();
              Swal.fire({
                 type: 'error',
                 title: 'Operación abortada',
                 text: 'Ningúna operación afectuada :)',
               });
            }
          });
          //-------------------------------------------------------------------------------------->
        }
        else {
          Swal.fire({
             type: 'error',
             title: 'Operación',
             text: 'Cancelada',
           });
        }
      });
    }
  });
  $("#delete_all_client").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    submitHandler: function(form){
      Swal.fire({
        title: "Estás seguro?",
        text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Continuar.!",
        cancelButtonText: "Cancelar.!",
      }).then((result) => {
        if (result.value) {
          //-------------------------------------------------------------------------------------->
          var form = $('#delete_all_client')[0];
          var formData = new FormData(form);
          // console.log(formData);
          $.ajax({
            type: 'POST',
            url: "/data_delete_client_config",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              console.log(data);
              if (data == 'abort') {
                console.log(data);
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Realice la operacion nuevamente!',
                 });
              }
              else {
                  let timerInterval;
                  Swal.fire({
                    type: 'success',
                    title: 'Operación Completada!',
                    html: 'Aplicando los cambios.',
                    timer: 2500,
                    onBeforeOpen: () => {
                      Swal.showLoading()
                      timerInterval = setInterval(() => {
                        Swal.getContent().querySelector('strong')
                      }, 100)
                    },
                    onClose: () => {
                      clearInterval(timerInterval)
                    }
                  }).then((result) => {
                    if (
                      // Read more about handling dismissals
                      result.dismiss === Swal.DismissReason.timer
                    ) {
                      window.location.href = "/configure_survey_admin_nps";
                    }
                  });
              }
            },
            error: function (data) {
              var validator = $( "#delete_all_client" ).validate();
              validator.resetForm();
              Swal.fire({
                 type: 'error',
                 title: 'Operación abortada',
                 text: 'Ningúna operación afectuada :)',
               });
            }
          });
          //-------------------------------------------------------------------------------------->
        }
        else {
          Swal.fire({
             type: 'error',
             title: 'Operación',
             text: 'Cancelada',
           });
        }
      });
    }
  });
  $("#form_reg_survey").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    submitHandler: function(form){
      Swal.fire({
        title: "Estás seguro?",
        text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Continuar.!",
        cancelButtonText: "Cancelar.!",
      }).then((result) => {
        if (result.value) {
          //-------------------------------------------------------------------------------------->
          var form = $('#form_reg_survey')[0];
          var formData = new FormData(form);
          // console.log(formData);
          $.ajax({
            type: 'POST',
            url: "/create_data_client",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data){
              console.log(data);
              /*if (data == 'abort') {
                console.log(data);
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Realice la operacion nuevamente!',
                 });
              }
              else {
                  let timerInterval;
                  Swal.fire({
                    type: 'success',
                    title: 'Operación Completada!',
                    html: 'Aplicando los cambios.',
                    timer: 2500,
                    onBeforeOpen: () => {
                      Swal.showLoading()
                      timerInterval = setInterval(() => {
                        Swal.getContent().querySelector('strong')
                      }, 100)
                    },
                    onClose: () => {
                      clearInterval(timerInterval)
                    }
                  }).then((result) => {
                    if (
                      // Read more about handling dismissals
                      result.dismiss === Swal.DismissReason.timer
                    ) {
                      window.location.href = "/configure_survey_admin_nps";
                    }
                  });
              }*/
            },
            error: function (data) {
              var validator = $( "#form_reg_survey" ).validate();
              validator.resetForm();
              Swal.fire({
                 type: 'error',
                 title: 'Operación abortada',
                 text: 'Ningúna operación afectuada :)',
               });
            }
          });
          //-------------------------------------------------------------------------------------->
        }
        else {
          Swal.fire({
             type: 'error',
             title: 'Operación',
             text: 'Cancelada',
           });
        }
      });
    }
  });

  table_surveyed();
});

$('#cancela_hc').click(function(){
  $('#select_clients').val('').trigger('change');
  $("#select_hotels").val("");
  $("#select_hotels").trigger("change");
});

$('#cancela_cu').click(function(){
  $('#creatusersystem')[0].reset();
});
$('#cancela_dc').click(function(){
  $('#delete_clients').val('').trigger('change');
});
function initialize_location() {
  var options = {
      types: ['(cities)'],
      componentRestrictions: {country: "mx"}
  };
  if (document.getElementById("inputCreatLocation")) {
    var input_two = document.getElementById('inputCreatLocation');
    var autocomplete_two = new google.maps.places.Autocomplete(input_two, options);
  }
}
function table_surveyed(){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./show_assign_surveyed",
    data: { _token : _token },
    success: function (data){
        // console.log(data);
        table_equipment(data, $("#see_venue_client"));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function table_equipment(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_with_pdf_client_hotel);
  vartable.fnClearTable();
  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.nombre,
      status.Venue,
      '<a href="javascript:void(0);" onclick="enviar_reluser(this)" value="'+status.hotel_user_id+'" class="btn btn-danger btn-xs" role="button" data-target="#DeletServ">Eliminar</a>'
    ]);
  });
}
function enviar_reluser(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  Swal.fire({
    title: "Estás seguro?",
    text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: "Continuar.!",
    cancelButtonText: "Cancelar.!",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: 'POST',
        url: "/delete_assign_surveyed",
        data: {  uh : valor , _token : _token },
        success: function (data){
          // console.log(data);
          if (data == '1') {
            let timerInterval;
            Swal.fire({
              type: 'success',
              title: 'Operación Completada!',
              html: 'Aplicando los cambios.',
              timer: 2500,
              onBeforeOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                  Swal.getContent().querySelector('strong')
                }, 100)
              },
              onClose: () => {
                clearInterval(timerInterval)
              }
            }).then((result) => {
              if (

                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.timer
              ) {
                // window.location.href = "/configure_survey_admin_nps";
                table_surveyed();
              }
            });
          }
          else {
            console.log(data);
            Swal.fire({
               type: 'error',
               title: 'Error encontrado..',
               text: 'Realice la operacion nuevamente!',
             });
          }
        },
        error: function (data) {
          Swal.fire({
             type: 'error',
             title: 'Operación abortada',
             text: 'Ningúna operación afectuada :)',
           });
        }
      });
      //-------------------------------------------------------------------------------------->
    }
    else {
      Swal.fire({
         type: 'error',
         title: 'Operación',
         text: 'Cancelada',
       });
    }
  });
}

$('#select_ind_one').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();
  var datax = [];

  if (id != ''){
    let countC = 0;
    $.ajax({
      type: "POST",
      url: "/user_vertical",
      data: { iv : id , _token : _token },
      success: function (data){
        countH = data.length;
        // console.log(data);
        // console.log(countH);
        
        if (countH === 0) {
          $('#select_ind_two').empty();
        }
        else{
          $('#select_ind_two').empty();
          // datax.push({id : "", text : "Elija ..."});
          $.each(data, function(index, datos){
            datax.push({id: datos.id, text: datos.name});
          });
          $('#select_ind_two').select2({
              data : datax
          });        
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else{
    $('#select_ind_two').empty();
  }
});