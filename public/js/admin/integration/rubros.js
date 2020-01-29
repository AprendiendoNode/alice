$(function() {
  generate_table();

  $('#creatrecord').formValidation({
   framework: 'bootstrap',
   excluded: ':disabled',
   fields: {
     inputCreatCode: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     inputCreatDesc: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     inputCreatRubro: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     inputCreatLugar: {
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
        var form = $('#creatrecord')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/integration/rubros_create",
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
                $('#modal-CreatNew').modal('toggle');
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
                    window.location.href = "/integration/rubros";
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

  $('#editrecord').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      inputEditCode: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputEditDesc: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputEditRubro: {
        validators: {
          notEmpty: {
            message: 'The field is required'
          }
        }
      },
      inputEditLugar: {
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
      var form = $('#editrecord')[0];
      var formData = new FormData(form);
      $.ajax({
        type: "POST",
        url: "/integration/rubros_store",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data){
           if (data == 'false') {
             Swal.fire({
                type: 'error',
                title: 'Error encontrado..',
                text: 'La clave ya existe!',
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
              $('#modal-Edit').modal('toggle');
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
                  window.location.href = "/integration/rubros";
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

function generate_table() {
  var form = $('#form')[0];
  var formData = new FormData(form);
  $.ajax({
    type: "POST",
    url: "/integration/rubros_show",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data){
      if (typeof data !== 'undefined' && data.length > 0) {
        table_filter(data, $("#table_filter"));
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
}

function table_filter(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    vartable.fnAddData([
      '<a href="javascript:void(0);" onclick="edit_record(this)" class="btn btn-primary  btn-sm" value="'+information.id+'"  datas="'+information.descripcion+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a>',
      information.clave,
      information.descripcion,
      information.rubro,
      information.grupo,
      information.lugar,
    ]);
  });
}

var Configuration_table_responsive = {
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    "ordering": false,
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
          if (document.getElementById("creatrecord")) {
            $('#creatrecord')[0].reset();
            $('#creatrecord').data('formValidation').resetForm($('#creatrecord'));
          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Rubros contable',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn btn-success btn-sm',
        exportOptions: {
            columns: [ 1, 2, 3, 4, 5]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Rubros contables',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
        titleAttr: 'CSV',
        className: 'btn btn-primary btn-sm',
        exportOptions: {
          columns: [ 1, 2, 3, 4, 5]
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

//Editar registro
function edit_record(e) {
  var valor= e.getAttribute('value');
  var folio= e.getAttribute('datas');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: '/integration/rubros_edit',
      data: {token_b : valor, _token : _token},
      success: function (data) {
        $("#editrecord")[0].reset();
        $('#editrecord').data('formValidation').resetForm($('#editrecord'));
        if (data != []) {
          $('#token_b').val(data[0].id);
          $('#inputEditCode').val(data[0].clave);
          $('#inputEditDesc').val(data[0].descripcion);
          $('#inputEditRubro').val(data[0].rubro).trigger('change');
          $('#inputEditGrup').val(data[0].grupo).trigger('change');
          $('#inputEditLugar').val(data[0].lugar);
          $('#modal-Edit').modal('show');
        }
        else {
          Swal.fire({
            type: 'error',
            title: 'Error encontrado..',
            text: 'Realice la operacion nuevamente!',
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
  })
}
