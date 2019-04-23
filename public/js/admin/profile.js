$(".btneditprof").on("click", function () {
  var name = $('#inputName').val();
  var location = $('#city').val();
  var var_boolean=false;

  if (name.length < 1 && location.length < 1)  {
    toastr.info( 'Sin cambios', 'Mensaje',
      {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "slideUp"
      }
    );
    // menssage_toast('Mensaje', '3', 'Sin cambios' , '3000');
  }
  if (name.length >= 1 && location.length < 1)  {
    //menssage_toast('Mensaje', '4', 'Cambio de nombre' , '3000');
    $('.formprofile').submit();
  }
  if (name.length < 1 && location.length >= 1)  {
    //menssage_toast('Mensaje', '4', 'Cambio de location' , '3000');
    $('.formprofile').submit();
  }
  if (name.length >= 1 && location.length >= 1)  {
    //menssage_toast('Mensaje', '4', 'Cambio de nombre && location' , '3000');
    $('.formprofile').submit();
  }
});

$(".btneditprofpass").on("click", function () {
  var password = $('#password').val();
  var retrypas = $('#password_confirmation').val();

  if (password == retrypas && password.length >= 6) {
    toastr.success('Cambio de password', 'Mensaje', {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "linear",
      "showMethod": "slideDown",
      "hideMethod": "slideUp"
    });
    // menssage_toast('Mensaje', '4', 'Cambio de password' , '3000');
    $('.formprofiletwo').submit();
  }
  else {
    toastr.error('Cambio de password', 'Mensaje!', {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "linear",
      "showMethod": "slideDown",
      "hideMethod": "slideUp"
    });
    // menssage_toast('Mensaje', '2', 'No coinciden las contraseñas' , '3000');
  }
});
