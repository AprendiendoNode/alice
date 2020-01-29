$(function () {
  $('#cuenta_contable').select2();
  get_info_taxes();
  $("#select_one").select2();
  $("#edit_select_one").select2();

  $('#creattaxes').formValidation({
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
     inputCreatName: {
       validators: {
         notEmpty: {
           message: 'The field is required'
         }
       }
     },
     inputCreatRate: {
       validators: {
         notEmpty: {
           message: 'The field is required'
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
        var form = $('#creattaxes')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/catalogs/taxes-create",
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
                    window.location.href = "/catalogs/taxes";
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

  $('#edittaxes').formValidation({
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
       inputEditName: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
       inputEditRate: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       },
       editposition: {
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
       var form = $('#edittaxes')[0];
       var formData = new FormData(form);
       $.ajax({
         type: "POST",
         url: "/catalogs/taxes-store",
         data: formData,
         contentType: false,
         processData: false,
         success: function (data){
            console.log(data);
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
                   window.location.href = "/catalogs/taxes";
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

function get_info_taxes(){
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/catalogs/taxes-show",
      data: { _token : _token },
      success: function (data){
        table_taxes(data, $("#table_taxes"));
      },
      error: function (data) {
        console.log('Error:', data.statusText);
      }
  });
}

function table_taxes(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_taxes);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (information.status == '0') {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      `<div class="btn-group">
          <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="javascript:void(0);" onclick="edit_taxes(this)" class="btn btn-primary  btn-sm" value="${information.id}"><i class="fas fa-pencil-alt"></i> Editar</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="edit_cc_modal(this)" class="btn btn-dark  btn-sm" value="${information.id}"><i class="fas fa-plus"></i> Integración contable</a>
        </div>
      </div>`,
      information.code,
      information.name,
      information.rate,
      information.factor,
      information.sort_order,
      badge
    ]);
  });
}

function edit_taxes(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/catalogs/taxes-edit',
       data: {value : valor, _token : _token},
       success: function (data) {
         $("#edittaxes")[0].reset();
         $('#edittaxes').data('formValidation').resetForm($('#edittaxes'));

         if (data != []) {
            $('#token_b').val(data[0].id);
            $('#inputEditCode').val(data[0].code);
            $('#inputEditName').val(data[0].name);
            $('#inputEditRate').val(data[0].rate);
            $("#editposition").val(data[0].factor).trigger('change');
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

function edit_cc_modal(e){
  var id_tax = e.getAttribute('value');
  $('#id_tax_cc').val(id_tax);
  var _token = $('meta[name="csrf-token"]').attr('content');

  $('#cuenta_contable').val(null).trigger('change');
  $('#cuenta_complementaria').val(null).trigger('change');
  $('#cuenta_anticipo').val(null).trigger('change');
    
    $.ajax({
      type: "POST",
      url: '/catalogs/taxes-edit',
      data: {value : id_tax, _token : _token},
      success: function (data) {

        if (data != []) {        
          
          $('#customer_name').val(data[0].name);    
          get_data_integracion_contable(id_tax);
          $('#modal-integracion-contable').modal('show');
        }
        else {
          Swal.fire({
            type: 'error',
            title: 'Error encontrado..',
            text: 'Realice la operacion nuevamente!',
          });
        }
      
      },
      error: function (data) {
        alert('Error:', data);
      }
  })
}

function get_data_integracion_contable(id_tax){
  var _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      type: "POST",
      url: '/catalogs/get_integration_cc_tax',
      data: {id_tax : id_tax, _token : _token},
      success: function (data) {
        console.log(data);
        if (data.length != 0) {
          // Set selected 
          $('#cuenta_contable').val(data[0].id_cuenta_contable);
          $('#cuenta_contable').select2().trigger('change'); 
            
        }
      
      },
      error: function (data) {
        alert('Error:', data);
      }
  })
}

$("#form_integration_cc").on("submit", function(e){
  e.preventDefault();

  var form = $('#form_integration_cc')[0];
  var formData = new FormData(form);

    $.ajax({
      type: "POST",
      url: "/catalogs/taxes-integration_cc",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data, textStatus, xhr){
        
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
          console.log(result);
          if (xhr.status == 200) {
            window.location.href = "/catalogs/taxes";
          }
        });
        
      },
      error: function (err) {
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: err.statusText,
          });
      }
    });
})

var Configuration_table_responsive_taxes = {
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
          if (document.getElementById("creattaxes")) {
            $('#creattaxes')[0].reset();
            $('#creattaxes').data('formValidation').resetForm($('#creattaxes'));
            $('#inputCreatOrden').val(0);

          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Impuestos',
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
        title: 'Impuestos',
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
