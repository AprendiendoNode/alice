$(function () {
    get_info_models();
  
    $('#creatmodels').formValidation({
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
       inputCreatCosto: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
       select_onemoneda: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
       select_onemarca: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
       select_oneespec: {
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
          var form = $('#creatmodels')[0];
          var formData = new FormData(form);
          $.ajax({
            type: "POST",
            url: "/catalogs/models-create",
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
                      window.location.href = "/catalogs/models";
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
  
    $('#editmodels').formValidation({
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
        inputEditCosto: {
          validators: {
            notEmpty: {
              message: 'The field is required'
            }
          }
        },
        editpositionmoneda: {
            validators: {
              notEmpty: {
                message: 'The field is required'
              }
            }
          },
          editpositionmarca: {
            validators: {
              notEmpty: {
                message: 'The field is required'
              }
            }
          },
          editpositionespec: {
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
        var form = $('#editmodels')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/catalogs/models-store",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
             if (data == 'false') {
               Swal.fire({
                  type: 'error',
                  title: 'Error encontrado..',
                  text: 'El nombre ya existe!',
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
                    window.location.href = "/catalogs/models";
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
  
  function get_info_models(){
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/catalogs/models-show",
        data: { _token : _token },
        success: function (data){
          table_models(data, $("#table_models"));
        },
        error: function (data) {
          console.log('Error:', data.statusText);
        }
    });
  }
  function table_models(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_banks);
    vartable.fnClearTable();
    $.each(JSON.parse(datajson), function(index, information){
      var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
      if (information.status == '0') {
        badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
      }
      vartable.fnAddData([
        information.ModeloNombre,
        information.Costo,
        information.currency,
        information.marca,
        information.especification_name,
        information.sort_order,
        badge,
        '<a href="javascript:void(0);" onclick="edit_models(this)" class="btn btn-primary  btn-sm" value="'+information.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a>'
      ]);
    });
  }
  
  function edit_models(e){
    var valor= e.getAttribute('value');
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
         type: "POST",
         url: '/catalogs/models-edit',
         data: {value : valor, _token : _token},
         success: function (data) {
           $("#editmodels")[0].reset();
           $('#editmodels').data('formValidation').resetForm($('#editmodels'));
  
           if (data != []) {
              $('#token_b').val(data[0].id);
              $('#inputEditName').val(data[0].ModeloNombre);
              $('#inputEditCosto').val(data[0].Costo);
              $("#editpositionmoneda").val(data[0].currency).trigger('change');
              $("#editpositionmarca").val(data[0].marca).trigger('change');
              $("#editpositionespec").val(data[0].especification_name).trigger('change');
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
  
  var Configuration_table_responsive_banks = {
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
            if (document.getElementById("creatmodels")) {
              $('#creatmodels')[0].reset();
              $('#creatmodels').data('formValidation').resetForm($('#creatmodels'));
              $('#inputCreatOrden').val(0);
            }
          }
        },
        {
          extend: 'excelHtml5',
          title: 'Modelos',
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
          title: 'Modelos',
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
  