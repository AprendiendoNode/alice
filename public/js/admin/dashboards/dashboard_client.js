if ($().select2) {
    $("#InputCadena").select2({
        theme: "bootstrap",
        width: '100%'
    });
    $("#InputHotel").select2({
        theme: "bootstrap",
        width: '100%'
    });
}

$( function() {
  $(".row_cadena").hide();
  $(".row_hotel").hide();
});

$('.min_meses').on('click', function(){

});

$('.max_meses').on('click', function(){

});

/*Tipo*/
$("select[name='SelectTipo']").select2({
  theme: "bootstrap",
  dropdownAutoWidth : true,
  width: "100%",
}).on("change", function () {
  let id = $(this).val();

  $('#data_c').val('');//cadena
  $('#data_h').val('');//sitio

  if (id  == '') {
    $(".row_cadena").hide();
    $(".row_hotel").hide();
    $('#InputCadena').val('').trigger('change');
    $('#InputHotel').val('').trigger('change');
  }
  if (id == 'cadena') {
    $(".row_cadena").show();
    $(".row_hotel").hide();
    $('#InputCadena').val('').trigger('change');
    $('#InputHotel').val('').trigger('change');
  }
  if (id == 'sitio') {
    $(".row_cadena").hide();
    $(".row_hotel").show();
    $('#InputCadena').val('').trigger('change');
    $('#InputHotel').val('').trigger('change');
  }
});
/*Cadena*/
$('#InputCadena').on('change',function(){
  let id = $(this).val();
  if (id) {
    $('#data_c').val(id);//cadena
    $('#data_h').val('');//sitio
    alert('select2cadena');
  }
});
/*Hotel*/
$('#InputHotel').on('change',function(){
  let id = $(this).val();
  if (id) {
    $('#data_c').val('');//cadena
    $('#data_h').val(id);//sitio
    alert('select2sitio');
  }
});
