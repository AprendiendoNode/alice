$(function () {
  get_info_unit_measures();
  $('#creatunitmeasure').formValidation({
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
     var form = $('#creatunitmeasure')[0];
        var formData = new FormData(form);

        $.ajax({
          type: "POST",
          url: "/catalogs/unit-measures-create",
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
                    window.location.href = "/catalogs/unit-measures";
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


function get_info_unit_measures(){
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: "/catalogs/unit-measures-show",
      data: { _token : _token },
      success: function (data){
        table_unit_measures(data, $("#table_unit_measures"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function table_unit_measures(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_unit_measures);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var badge = '<span class="badge badge-success badge-pill text-uppercase text-white">Habilitado</span>';
    if (information.status == '0') {
      badge= '<span class="badge badge-danger badge-pill text-uppercase text-white">Inhabilitado</span>';
    }
    vartable.fnAddData([
      information.name,
      information.code,
      information.sort_order,
      badge,
      '<a href="javascript:void(0);" onclick="edit_unit_measures(this)" class="btn btn-primary  btn-sm" value="'+information.id+'"><i class="fas fa-pencil-alt btn-icon-prepend fastable"></i></a><a href="javascript:void(0);" onclick="destroy_unit_measures(this)" class="btn btn-danger btn-sm" value="'+information.id+'"><i class="fas fa-trash btn-icon-prepend fastable"></i></a>'
    ]);
  });
}

//Mostrar - Edit unit measures
function edit_unit_measures(e){
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
       type: "POST",
       url: '/unit-measures-edit',
       data: {value : valor, _token : _token},
       success: function (data) {
         if (data != '') {
           $('#inputEditCode').val(data.code);
           $('#inputEditName').val(data.name);
           $('#inputEditOrden').val(data.orden);
           $('#modal-editData').modal('show');
           $('#editusersystem').show();
           $('#editinfogenerad').hide();
         }
         else {
           $('#modal-editUser').modal('show');
           $('#editusersystem').hide();
           $('#editinfogenerad').show();
         }
       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}

//Mostrar - Destroy unit measures
function destroy_unit_measures(e){
  var valor= e.getAttribute('value');
}

var Configuration_table_responsive_unit_measures= {
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
          if (document.getElementById("creatunitmeasure")) {
            $('#creatunitmeasure')[0].reset();
          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Unidad de medida',
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
        title: 'Unidad de medida',
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
