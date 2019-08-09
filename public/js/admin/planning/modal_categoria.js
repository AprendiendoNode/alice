$(".addcategorias").on("click", function (){
    $('#modal-CreatCategory').modal('show');
    if (document.getElementById("creatcategorysystem")) {
      $('#creatcategorysystem')[0].reset();
      $('#creatcategorysystem').data('formValidation').resetField($('#inputCreatCategory'));
    }
});

$(document).ready( function() {
  $('#creatcategorysystem').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      inputCreatCategory: {
        validators: {
          notEmpty: {
            message: 'The category is required'
          },
          stringLength: {
            min: 3,
            max: 150,
          }
        }
      }
    }
  })
  .on('success.form.fv', function(e) {
    e.preventDefault();
    /* --------------------------------------------------------------------- */
    swal({
      title: "Estás seguro?",
      text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Continuar.!",
      cancelButtonText: "Cancelar.!",
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true,
    },
    function(isConfirm) {
      if (isConfirm) {
        // The AJAX
        var form = $('#creatcategorysystem')[0];
        var formData = new FormData(form);
        $.ajax({
          type: 'POST',
          url: "/adminprod_create_cat",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            datax = data;
            if (datax != '0') {
              swal("Operación Completada!", ":)", "success");
              $.ajax({
                   type: "POST",
                   url: "/adminprod_restore_cat",
                   data: { _token : $('input[name="_token"]').val() },
                   success: function (data){
                     count_data = data.length;
                     $("#sel_categoria option[value!='']").remove();
                     if (count_data > 0) {
                       $.each(JSON.parse(data),function(index, objdata){
                         $('#sel_categoria').append('<option value="'+objdata.id+'">'+ objdata.categoria +'</option>');
                       });
                     }
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
              });
              $('#modal-CreatCategory').modal('toggle');

            }
            else {
              $('#modal-CreatCategory').modal('toggle');
              swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
            }
          },
          error: function (data) {
            swal("Operación abortada", "Ningúna operación afectuada :)", "error");
            $('#creatcategorysystem')[0].reset();
            $('#creatcategorysystem').data('formValidation').resetField($('#inputCreatCategory'));
            $('#modal-CreatCategory').modal('toggle');
          }
        });
      }
      else {
        swal("Operación abortada", "Ningúna operación afectuada :)", "error");
        $('#creatcategorysystem')[0].reset();
        $('#creatcategorysystem').data('formValidation').resetField($('#inputCreatCategory'));
        $('#modal-CreatCategory').modal('toggle');
      }
    });
    /* --------------------------------------------------------------------- */
  });
});


/* ------------------------------------------------------------------------------------------------------------------*/
/* ------------------------------------------------------------------------------------------------------------------*/
$(".addstatus").on("click", function (){
    $('#modal-CreatStatus').modal('show');
    if (document.getElementById("creatstatussystem")) {
      $('#creatstatussystem')[0].reset();
      $('#creatstatussystem').data('formValidation').resetField($('#inputCreatStatus'));
    }
});


$(document).ready( function() {
  $('#creatstatussystem').formValidation({
    framework: 'bootstrap',
    excluded: ':disabled',
    fields: {
      inputCreatStatus: {
        validators: {
          notEmpty: {
            message: 'The status is required'
          },
          stringLength: {
            min: 3,
            max: 150,
          }
        }
      }
    }
  })
  .on('success.form.fv', function(e) {
    e.preventDefault();
    /* --------------------------------------------------------------------- */
    swal({
      title: "Estás seguro?",
      text: "Espere mientras se sube la información. Aparecera una ventana de dialogo al terminar.!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Continuar.!",
      cancelButtonText: "Cancelar.!",
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true,
    },
    function(isConfirm) {
      if (isConfirm) {
        // The AJAX
        var form = $('#creatstatussystem')[0];
        var formData = new FormData(form);
        $.ajax({
          type: 'POST',
          url: "/adminprod_create_status",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data){
            datax = data;
            if (datax != '0') {
              swal("Operación Completada!", ":)", "success");
              $.ajax({
                   type: "POST",
                   url: "/adminprod_restore_status",
                   data: { _token : $('input[name="_token"]').val() },
                   success: function (data){
                     count_data = data.length;
                     $("#sel_estatus option[value!='']").remove();
                     if (count_data > 0) {
                       $.each(JSON.parse(data),function(index, objdata){
                         $('#sel_estatus').append('<option value="'+objdata.id+'">'+ objdata.status +'</option>');
                       });
                     }
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
              });
              $('#modal-CreatStatus').modal('toggle');

            }
            else {
              $('#modal-CreatStatus').modal('toggle');
              swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
            }
          },
          error: function (data) {
            swal("Operación abortada", "Ningúna operación afectuada :)", "error");
            $('#creatstatussystem')[0].reset();
            $('#creatstatussystem').data('formValidation').resetField($('#inputCreatStatus'));
            $('#modal-CreatStatus').modal('toggle');
          }
        });
      }
      else {
        swal("Operación abortada", "Ningúna operación afectuada :)", "error");
        $('#creatstatussystem')[0].reset();
        $('#creatstatussystem').data('formValidation').resetField($('#inputCreatStatus'));
        $('#modal-CreatStatus').modal('toggle');
      }
    });
    /* --------------------------------------------------------------------- */
  });
});
