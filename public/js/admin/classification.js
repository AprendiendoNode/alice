$(function () {
  get_info_workstation();
  get_info_department();
  $('.datepicker').datepicker({
   language: 'es',
   format: "yyyy-mm-dd",
   viewMode: "days",
   minViewMode: "days",
   endDate: '1m',
   autoclose: true,
   clearBtn: true
 });
  //Create workstation
  $('#created_position').formValidation({
   framework: 'bootstrap',
   excluded: ':disabled',
   fields: {
     inputnameposition: {
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
     var form = $('#created_position')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/workstation_create",
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
                    window.location.href = "/Classification";
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
   //Edit Workstation
   $('#editwork').formValidation({
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
      }
   })
   .on('success.form.fv', function(e) {
        e.preventDefault();
        var form = $('#editwork')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/workstation_update",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
             if (data.status  == 200) {
               let timerInterval;
               Swal.fire({
                 type: 'success',
                 title: 'Operación Completada!',
                 html: 'Aplicando los cambios.',
                 timer: 2500,
                 onBeforeOpen: () => {
                   Swal.showLoading ()
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
                   window.location.href = "/Classification";
                 }
               });

             }else{
              Swal.fire({
                 type: 'error',
                 title: 'Error encontrado..',
                 text: '',
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
  //Create department
  $('#created_departament').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      inputnamedepartament: {
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
      var form = $('#created_departament')[0];
         var formData = new FormData(form);
         $.ajax({
           type: "POST",
           url: "/department_create",
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
                     window.location.href = "/Classification";
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
    //Edit Workstation
    $('#editdepartment').formValidation({
       framework: 'bootstrap',
       excluded: ':disabled',
       fields: {
         inputEditNameDep: {
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
         var form = $('#editdepartment')[0];
         var formData = new FormData(form);
         $.ajax({
           type: "POST",
           url: "/department_update",
           data: formData,
           contentType: false,
           processData: false,
           success: function (data){
              if (data.status  == 200) {
                let timerInterval;
                Swal.fire({
                  type: 'success',
                  title: 'Operación Completada!',
                  html: 'Aplicando los cambios.',
                  timer: 2500,
                  onBeforeOpen: () => {
                    Swal.showLoading ()
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
                    window.location.href = "/Classification";
                  }
                });

              }else{
               Swal.fire({
                  type: 'error',
                  title: 'Error encontrado..',
                  text: '',
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

function get_info_workstation() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/workstation_show",
      data: { _token : _token },
      success: function (data){
        table_workstation(data, $("#all_workstation"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_workstation(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_classification);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (status.deleted_at) {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      status.name,
      badge,
      '<a href="javascript:void(0);" onclick="editar_work(this)" class="btn btn-primary  btn-sm mr-2" value="'+status.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a><a href="javascript:void(0);" onclick="destroy_work(this)" class="btn btn-danger btn-sm" value="'+status.id+'"><i class="fas fa-trash btn-icon-prepend fastable"></i></a>'
    ]);
  });
}

//Mostrar - Edit workstation
function editar_work(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/workstation_edit',
       data: {value : valor, _token : _token},
       success: function (data) {
         $("#editwork")[0].reset();
         $('#editwork').data('formValidation').resetForm($('#editwork'));

         if (data != []) {
            $('#token_b').val(data[0].id);
            $('#inputEditName').val(data[0].name);

            $('#modal-Edit-Workstation').modal('show');
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

//Destroy workstation
function destroy_work(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
    title: '¿Estás seguro?',
    text: "No podras revertir este cambio",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Borrar',
    cancelButtonText: 'Cancelar'
    }).then((result) => {

      if (result.value) {
        $.ajax({
             type: "POST",
             url: '/workstation_destroy',
             data: {id : valor, _token : _token},
             success: function (data) {
              if(data.status == 200){
                Swal.fire('Puesto eliminado!', '', 'success')
                .then(()=> {
                  location.href ="/Classification";
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
    })
}

$(".reset_position").on("click", function () {
  $("#created_position")[0].reset();
  $('#created_position').data('formValidation').resetForm($('#created_position'));
});

var Configuration_table_responsive_simple_classification={
  dom: "<'row'<'col-sm-3'l><'col-sm-9'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
  "order": [[ 0, "asc" ]],
  paging: true,
  //"pagingType": "simple",
  Filter: true,
  searching: true,
  "aLengthMenu": [[3, 5, 10, 25, -1], [3, 5, 10, 25, "Todos"]],
  //ordering: false,
  //"pageLength": 5,
  bInfo: false,
      language:{
              "sProcessing":     "Procesando...",
              "sLengthMenu":     "Mostrar _MENU_ registros",
              "sZeroRecords":    "No se encontraron resultados",
              "sEmptyTable":     "Ningún dato disponible",
              "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
              "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix":    "",
              "sSearch":         "Buscar:",
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
}


//Department -----------------------------------------------------------------------------------------------------------------------
function get_info_department() {
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/department_show",
      data: { _token : _token },
      success: function (data){
        table_department(data, $("#all_department"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_department(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_classification);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (status.deleted_at) {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      status.name,
      badge,
      '<a href="javascript:void(0);" onclick="editar_department(this)" class="btn btn-primary  btn-sm mr-2" value="'+status.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a><a href="javascript:void(0);" onclick="destroy_department(this)" class="btn btn-danger btn-sm" value="'+status.id+'"><i class="fas fa-trash btn-icon-prepend fastable"></i></a>'
    ]);
  });
}

//Mostrar - Edit department
function editar_department(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/department_edit',
       data: {value : valor, _token : _token},
       success: function (data) {
         $("#editdepartment")[0].reset();
         $('#editdepartment').data('formValidation').resetForm($('#editdepartment'));
         console.log(data)
         if (data != []) {
            $('#token_c').val(data.id);
            $('#inputEditNameDep').val(data.name);

            $('#modal-Edit-Department').modal('show');
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

//Mostrar - Destroy department
function destroy_department(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
    title: '¿Estás seguro?',
    text: "No podras revertir este cambio",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Borrar',
    cancelButtonText: 'Cancelar'
    }).then((result) => {
      console.log(result);
      if (result.value) {
        $.ajax({
             type: "POST",
             url: '/department_destroy',
             data: {id : valor, _token : _token},
             success: function (data) {
              if(data.status == 200){
                Swal.fire('Departamento eliminado!', '', 'success')
                .then(()=> {
                  location.href ="/Classification";
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
    })
}
$(".reset_departament").on("click", function () {
  $("#created_departament")[0].reset();
  $('#created_departament').data('formValidation').resetForm($('#created_departament'));
});
