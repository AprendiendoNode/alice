$(function() {
  $(".first_tab").champ();
  $(".select2").select2();
  $("#cliente").on('change', function(e) {
    var _token = $('input[name="_token"]').val();
    var cadena = $('#cliente').val();
    $(".first_tab").addClass("d-none");
    $("#cargando").removeClass("d-none");
    $.ajax({
      type: "POST",
      url: "/informacionCliente",
      data: { cliente : cadena, _token : _token },
      success: function (data){
        console.log(data);
        $("#imagenCliente").attr("src", "../images/hotel/" + data[0].dirlogo1);
        $("#telefonoCliente").text(data[0].Telefono);
        $("#direccionCliente").text(data[0].Direccion);
        $("#cargando").addClass("d-none");
        $(".first_tab").removeClass("d-none");
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });
});
