$(function () {
  get_info_customers();
  $('#creatcustomers').formValidation({
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
               message: 'The field is required'
             },
             emailAddress: {
                 message: 'The value is not a valid email address'
             }
         }
     },
     select_one: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     select_two: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     select_three: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     select_four: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     select_five: {
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
     select_six: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     select_seven: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     select_eight: {
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
     inputCreatOrden: {
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
        var form = $('#creatcustomers')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/sales/customers-create",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            if (data == 'abort') {
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
                    window.location.href = "/sales/customers";
                  }
                });
            }
          },
          error: function (err) {
            Swal.fire({
               type: 'error',
               title: 'Oops...',
               text: err.statusText,
             });
          }
        });
  });


  $('#editcustomers').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      inputEditName: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputEditTaxid: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputEditNumid: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputEditEmail: {
          validators: {
              notEmpty: {
                message: 'The field is required'
              },
              emailAddress: {
                  message: 'The value is not a valid email address'
              }
          }
      },
      edit_select_one: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      edit_select_two: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      edit_select_three: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      edit_select_four: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      edit_select_five: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      editCreatAddress_1: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      edit_select_six: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      edit_select_seven: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      edit_select_eight: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      editCreatPostCode: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputEditOrden: {
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
      var form = $('#editcustomers')[0];
      var formData = new FormData(form);
      $.ajax({
        type: "POST",
        url: "/sales/customers-store",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data){
           if (data == 'false') {
             Swal.fire({
                type: 'error',
                title: 'Error encontrado..',
                  text: 'Ya existe!',
              });
           }
          else if (data == 'abort') {
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
                  window.location.href = "/sales/customers";
                }
              });
          }
        },
        error: function (err) {
          Swal.fire({
             type: 'error',
             title: 'Oops...',
             text: err.statusText,
           });
        }
      });
  });


});
function get_info_customers(){
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/sales/customers-show",
      data: { _token : _token },
      success: function (data){
        table_customers(data, $("#table_customers"));
      },
      error: function (data) {
        console.log('Error:', data.statusText);
      }
  });
}
function table_customers(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_customers);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (information.status == '0') {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      information.name,
      information.taxid,
      information.payment_terms,
      information.email,
      information.phone,
      information.countries,
      badge,
      '<a href="javascript:void(0);" onclick="edit_customers(this)" class="btn btn-primary  btn-sm" value="'+information.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a>'
    ]);
  });
}
function edit_customers(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/sales/customers-edit',
       data: {value : valor, _token : _token},
       success: function (data) {
         $("#editcustomers")[0].reset();
         $('#editcustomers').data('formValidation').resetForm($('#editcustomers'));

         if (data != []) {
            $('#token_b').val(data[0].id);
            $('#inputEditName').val(data[0].name);
            $('#inputEditTaxid').val(data[0].taxid);
            $('#inputEditNumid').val(data[0].numid);
            $('#inputEditEmail').val(data[0].email);
            $('#inputEditPhone').val(data[0].phone);
            $('#inputEditMobile').val(data[0].phone_mobile);

            $('#edit_select_one').val(data[0].payment_terms_id).trigger('change');
            $('#edit_select_two').val(data[0].payment_ways_id).trigger('change');
            $('#edit_select_three').val(data[0].payment_methods_id).trigger('change');
            $('#edit_select_four').val(data[0].cfdi_uses_id).trigger('change');
            $('#edit_select_five').val(data[0].salespersons_id).trigger('change');

            $('#editCreatAddress_1').val(data[0].address_1);
            $('#editCreatAddress_2').val(data[0].address_2);
            $('#editCreatAddress_3').val(data[0].address_3);
            $('#editCreatAddress_4').val(data[0].address_4);
            $('#editCreatAddress_5').val(data[0].address_5);
            $('#editCreatAddress_6').val(data[0].address_6);


            $('#edit_select_six').val(data[0].countries_id).trigger('change');
            $('#edit_select_seven').val(data[0].states_id).trigger('change');
            $('#edit_select_eight').val(data[0].cities_id).trigger('change');


            $('#editCreatPostCode').val(data[0].postcode);
            $('#editCreatComment').val(data[0].comment);
            $('#inputEditOrden').val(data[0].sort_order);

            if (data[0].status == '0')
            {
              $("#editstatus").prop('checked', false).change();
            }
            else {
              $('#editstatus').prop('checked', true).change();
            }
            $('#modal-Edit').modal('show');
         }
         else {
           Swal.fire({
             type: 'error',
             title: 'Error encontrado..',
             text: 'Realice la operacion nuevamente!',
           });
         }
           //$('#modal-Edit').modal('show');
       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}
var Configuration_table_responsive_customers = {
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        text: '<i class="fas fa-plus-circle fastable mt-2"></i> Crear nuevo',
        titleAttr: 'Crear nuevo',
        className: 'btn btn-danger btn-sm',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        action: function ( e, dt, node, config ) {
          $('#modal-CreatNew').modal('show');
          if (document.getElementById("creatcustomers")) {
            $('#creatcustomers')[0].reset();
            $('#creatcustomers').data('formValidation').resetForm($('#creatcustomers'));
            $('#inputCreatOrden').val(0);
            $('#select_one').val(5);
            $('#select_two').val(3);
            $('#select_three').val(1);
            $('#select_five').val(1);
          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Clientes',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn btn-success btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Clientes',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
        titleAttr: 'CSV',
        className: 'btn btn-primary btn-sm',
        exportOptions: {
            columns: [ 0, 1, 2, 3]
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

$(".onlynumber").keypress(function (e) {
  //if the letter is not digit then display error and don't type anything
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    //display error message
    // $("#errmsg").html("Digits Only").show().fadeOut("slow");
    return false;
  }
});
