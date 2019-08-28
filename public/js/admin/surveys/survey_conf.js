$(function() {
  $(".select2").select2({width: '100%'});
  $('#select_hotels').select2({width: '100%',closeOnSelect:false});
  $('#select_ind_two').select2({width: '100%',closeOnSelect:false});
  google.maps.event.addDomListener(window, 'load', initialize_location);
  $('.input-daterange').datepicker({language: 'es', format: "yyyy-mm-dd",});
  $('.datepickermonth').datepicker({
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
              if (data == '3') {
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Mes ya evaluado!',
                 });
              }else if(data == '2'){
                let timerInterval;
                Swal.fire({
                  type: 'success',
                  title: 'Operación Completada!',
                  html: 'Se reenvio enlace activo!',
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
              }else if(data == '1'){
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
              }else{
                Swal.fire({
                   type: 'error',
                   title: 'Error encontrado..',
                   text: 'Operacion abortada!',
                 });
              }
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
  $("#form").validate({
    ignore: "input[type=hidden]",
    errorClass: "text-danger",
    successClass: "text-success",
    errorPlacement: function (error, element) {
      },
      rules: {
      },
      messages: {
      },
      submitHandler: function(e){
        var form = $('#form')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/send_survey_mail",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            var message = data.success;
            $('#modal_customer_invoice_send_mail').modal('toggle');
            Swal.fire({
                type: 'success',
                title: 'Good job!',
                text: message,
              });
          },
          error: function (error, textStatus, errorThrown) {
            $('#modal_customer_invoice_send_mail').modal('toggle');
            if (error.status == 422) {
                var message = error.responseJSON.error;

                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: message,
                  });
            }
            else {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: errorThrown + "\r\n" + error.statusText + "\r\n" + error.responseText,
                  });
            }
          }
        });
      }
  });
  table_surveyed();
  table_surveyed_clients();
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

$('#btn_filter_nps').on('click',function(){
  table_surveyed_clients();
});

function table_surveyed_clients(){
  var date = $('#calendar_fecha_nps').val();
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "/show_survey_table_month",
    data: {  data_one : date , _token : _token },
    success: function (data){
      // console.log(data);
      table_surveys_clients(data, $("#example_survey"));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function table_surveys_clients(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_pacs);
  vartable.fnClearTable();
  $.each(datajson, function(index, information){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Activo</span>';
    if (information.estatus_id == '2') {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inactivo</span>';
    }

    var badgetwo = '<span class="badge badge-success badge-pill text-uppercase text-white">Contestada</span>';
    if (information.estatus_res == '2') {
      badgetwo= '<span class="badge badge-danger badge-pill text-uppercase text-white">No contestada</span>';
    }
    var option_a ='<a href="javascript:void(0);" onclick="link_send_mail(this)" datas="'+information.email+'" class="btn btn-info  btn-sm" value="'+information.id+'"><i class="far fa-share-square btn-icon-prepend fastable"></i> Reenviar Mail</a>';
    var option_b ='<a href="javascript:void(0);" onclick="view_hotel(this)" datas="'+information.user_id+'" class="btn btn-warning  btn-sm" value="'+information.id+'"><i class="fas fa-search btn-icon-prepend fastable"></i> Ver Hotel</a>';
    var union = option_a + option_b;
    vartable.fnAddData([
      information.user,
      information.email,
      badge,
      badgetwo,
      information.fecha_corresponde,
      information.fecha_inicial,
      information.fecha_fin,
      union
    ]);
  });
}

var Configuration_table_responsive_pacs = {
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        title: 'Encuestados',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn btn-success btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Encuestados',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
        titleAttr: 'CSV',
        className: 'btn btn-primary btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4]
        },
      }
  ],
  "processing": true,
  language:{
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "<i class='fa fa-search'></i> Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
      "sFirst":    "Primero",
      "sLast":     "Último",
      "sNext":     "Siguiente",
      "sPrevious": "Anterior"
    },
    "oAria": {
      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
  }
};

//Modal para envio de correo
function link_send_mail(e){
  var valor= e.getAttribute('value');
  var email= [e.getAttribute('datas')];
  var _token = $('meta[name="csrf-token"]').attr('content');
  $("#modal_customer_invoice_send_mail").modal("show");
  //Correos para
  $("#modal_customer_invoice_send_mail .modal-body select[name='to\[\]']").select2({
    placeholder: "@lang('general.text_select')",
    theme: "bootstrap",
    width: "auto",
    dropdownAutoWidth: true,
    language: "{{ str_replace('_', '-', app()->getLocale()) }}",
    tags: true,
    disabled: true,
    tokenSeparators: [',', ' '],
      data: email
  });
  $("#modal_customer_invoice_send_mail .modal-body select[name='to\[\]']").val(email).trigger("change");
  //Correos para
  $("#modal_customer_invoice_send_mail .modal-body select[name='attach\[\]']").select2({
      placeholder: "Mail",
      theme: "bootstrap",
      width: "auto",
      dropdownAutoWidth: true,
      language: "{{ str_replace('_', '-', app()->getLocale()) }}",
      tags: true,
      tokenSeparators: [',', ' '],
  });
  $('#tken_b').val(valor);
}

function view_hotel(e){
  var valor= e.getAttribute('value');
  var user= e.getAttribute('datas');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/search_hotel_u',
       data: {token_b : user, _token : _token},
       success: function (data) {
         if (data != '') {
           var x='';
           $.each(JSON.parse(data), function(index, status){
             x=x+status.Nombre_hotel+'\n';
           });
           $('#message_site').val(x);
           $('#message_site').prop('disabled', true);
           $('#modal_customer_nps').modal('show');
         }
         else {
           $('#message_site').val('');
           $('#message_site').prop('disabled', true);
           $('#modal_customer_nps').modal('show');
         }

       },
       error: function (err) {
         Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: err.statusText,
          });
       }
  })
}
