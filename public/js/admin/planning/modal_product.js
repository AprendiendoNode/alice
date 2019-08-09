function testDecimals(currentVal) {
  var count;
  currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
  return count;
}

function replaceCommas(yourNumber) {
  var components = yourNumber.toString().split(".");
  if (components.length === 1)
  components[0] = yourNumber;
  components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  if (components.length === 2)
  components[1] = components[1].replace(/\D/g, "");
  return components.join(".");
}
function createEvent_Mensualidad () {
  const element = document.querySelector('[name="inputCreatcoindefault"]')
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
  createEvent_Mensualidad();

  $("#creatproductsystem").validate({
      ignore: "input[type=hidden]",
      errorClass: "text-danger",
      successClass: "text-success",
      errorPlacement: function (error, element) {
        var attr = $('[name="'+element[0].name+'"]').attr('datas');
        // console.log(element[0].name);
        // console.log(attr);
        // console.log($('[name="'+element[0].name+'"]'));
        if (element[0].id === 'fileInput') {
          error.insertAfter($('#cont_file'));
        }
        else {
          if(attr == 'sel_categoria'){
            error.insertAfter($('#cont_category'));
          }
          else if(attr == 'sel_modelo'){
            error.insertAfter($('#cont_model'));
          }
          else if(attr == 'sel_estatus'){
            error.insertAfter($('#cont_estatus'));
          }
          else {
            error.insertAfter(element);
          }
        }
      },
      rules: {
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
            var form = $('#creatproductsystem')[0];
            var formData = new FormData(form);
            $.ajax({
              type: 'POST',
              url: "/product_management_c",
              data: formData,
              contentType: false,
              processData: false,
              success: function (data){
                datax = data;
                if (datax != '0') {
                  $('#modal-CreatProduct').modal('toggle');
                  management_products();
                  swal("Operación Completada!", ":)", "success");
                }
                else {
                  $('#modal-CreatProduct').modal('toggle');
                  swal("Operación abortada", "Error al registrar intente otra vez :(", "error");
                }
              },
              error: function (data) {
                $('#modal-CreatProduct').modal('toggle');
                $("#creatproductsystem")[0].reset();
                var validator = $( "#creatproductsystem" ).validate();
                validator.resetForm();
                swal("Operación abortada", "Ningúna operación afectuada :)", "error");
              }
            });
          }
          else {
            swal("Operación abortada", "Ningúna operación afectuada :)", "error");
            $("#creatproductsystem")[0].reset();
            var validator = $( "#creatproductsystem" ).validate();
            validator.resetForm();
            $('#modal-CreatProduct').modal('toggle');
          }
        });
      }
  });
});
