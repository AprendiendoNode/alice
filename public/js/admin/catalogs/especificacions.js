$(function () {
    get_info_especificacions();
  
    $('#createspecificacions').formValidation({
     framework: 'bootstrap',
     excluded: ':disabled',
     fields: {
       inputCreatName: {
         validators: {
           notEmpty: {
             message: 'The field is required'
           }
         }
       }
     }
    })
    .on('success.form.fv', function(e) {
          e.preventDefault();
          var form = $('#createspecificacions')[0];
          var formData = new FormData(form);
          $.ajax({
            type: "POST",
            url: "/catalogs/especificacions-create",
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
                      window.location.href = "/catalogs/especificacions";
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
  
    $('#editespecificacions').formValidation({
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
        var form = $('#editespecificacions')[0];
        var formData = new FormData(form);
        $.ajax({
          type: "POST",
          url: "/catalogs/especificacions-store",
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
                    window.location.href = "/catalogs/especificacions";
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
  
  function get_info_especificacions(){
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/catalogs/especificacions-show",
        data: { _token : _token },
        success: function (data){
          table_especificacions(data, $("#table_especificacions"));
        },
        error: function (data) {
          console.log('Error:', data.statusText);
        }
    });
  }
  function table_especificacions(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_responsive_banks);
    vartable.fnClearTable();
    $.each(JSON.parse(datajson), function(index, information){
      var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
      if (information.status == '0') {
        badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
      }
      vartable.fnAddData([
        information.name,
        badge,
        '<a href="javascript:void(0);" onclick="edit_especificacions(this)" class="btn btn-primary  btn-sm" value="'+information.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a>'
      ]);
    });
  }
  
  function edit_especificacions(e){
    var valor= e.getAttribute('value');
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
         type: "POST",
         url: '/catalogs/especificacions-edit',
         data: {value : valor, _token : _token},
         success: function (data) {
           $("#editespecificacions")[0].reset();
           $('#editespecificacions').data('formValidation').resetForm($('#editespecificacions'));
  
           if (data != []) {
              $('#token_b').val(data[0].id);
              $('#inputEditName').val(data[0].name);
  
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
            if (document.getElementById("createspecificacions")) {
              $('#createspecificacions')[0].reset();
              $('#createspecificacions').data('formValidation').resetForm($('#createspecificacions'));
              $('#inputCreatOrden').val(0);
            }
          }
        },
        {
          extend: 'excelHtml5',
          title: 'Especificaciones',
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
          title: 'Especificaciones',
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
  