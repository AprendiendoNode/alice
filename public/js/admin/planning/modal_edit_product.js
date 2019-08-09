function createEvent_Mensualidad_Edit () {
  const element = document.querySelector('[name="inputEditcoindefault"]')
  element.addEventListener('keyup', function(event) {
    //Convertir formato pesos
    if (event.which >= 37 && event.which <= 40) {
      event.preventDefault();
    }
    var currentVal = $(this).val();
    var testDecimal = testDecimals(currentVal);
    if (testDecimal.length > 1) {
      currentVal = currentVal.slice(0, -1);
    }
    $(this).val(replaceCommas(currentVal));
  });
};

$(document).ready( function() {
  createEvent_Mensualidad_Edit();
  $("#editproductsystem").validate({
      ignore: "input[type=hidden]",
      errorClass: "text-danger",
      successClass: "text-success",
      errorPlacement: function (error, element) {
        var attr = $('[name="'+element[0].name+'"]').attr('edatas');

        if (element[0].id === 'editfileInput') {
          error.insertAfter($('#edit_cont_file'));
        }
        else {
          if(attr == 'edit_sel_categoria'){
            error.insertAfter($('#edit_cont_category'));
          }
          else if(attr == 'edit_sel_modelo'){
            error.insertAfter($('#edit_cont_model'));
          }
          else if(attr == 'edit_sel_estatus'){
            error.insertAfter($('#edit_cont_estatus'));
          }
          else {
            error.insertAfter(element);
          }
        }
      },
      rules: {
        editfileInput: {
          required: false,
          accept:"jpg,png,jpeg"
        },
      },
      messages: {
        editfileInput: {
          required: "Select Image",
          accept: "Only image type jpg/png/jpeg is allowed"
        },
      },
      // debug: true,
      // errorElement: "label",
      submitHandler: function(form){
        // swal("Operación abortada", "Ningúna operación afectuada, Ingrese la latitud y longitud :)", "error");
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
            var form = $('#editproductsystem')[0];
            var formData = new FormData(form);
            console.log(formData);
            $.ajax({
              type: 'POST',
              url: "/product_management_u",
              data: formData,
              contentType: false,
              processData: false,
              success: function (data){
                datax = data;
                if (datax != '0') {
                  $('#modal-Editprod').modal('toggle');
                  management_products();
                  swal("Operación Completada!", ":)", "success");
                }
                else {
                  $('#modal-Editprod').modal('toggle');
                  swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
                }
              },
              error: function (data) {
                $('#modal-Editprod').modal('toggle');
                $("#editproductsystem")[0].reset();
                var validator = $( "#editproductsystem" ).validate();
                validator.resetForm();
                swal("Operación abortada", "Ningúna operación afectuada :)", "error");
              }
            });
          }
          else {
            swal("Operación abortada", "Ningúna operación afectuada :)", "error");
            $("#editproductsystem")[0].reset();
            var validator = $( "#editproductsystem" ).validate();
            validator.resetForm();
            $('#modal-Editprod').modal('toggle');
          }
        });
      }
  });
});
