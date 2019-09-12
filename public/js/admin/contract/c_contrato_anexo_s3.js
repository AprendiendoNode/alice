$(function() {
  createEventListenerCadenaAnexo (0);
  createEventListenerSiteAnexo (0);
});


var conceptIndexSiteAnexo = 0,
constante_eliminar_site_anexo = [],
max_options_site_anexo = 300;


$(".validation-wizard-anexo").on('click','.addButtonsitiobeta',function(){
  if( constante_eliminar_site_anexo.length === 0) {
    if(conceptIndexSiteAnexo <= max_options_site_anexo) {
      conceptIndexSiteAnexo++;
      var $template = $('#optionTemplateSitioAnexo'),
      $clone  = $template
        .clone()
        .removeClass('hide')
        .removeAttr('id')
        .attr('data-book-indexsitios', conceptIndexSiteAnexo)
        .insertBefore($template);
      // Update the name attributes
      $clone
        .find('[name="cadena_add"]').attr('name', 'c_cadena_add[' + conceptIndexSiteAnexo + '].cadena_add').attr('data_row', conceptIndexSiteAnexo).end()
        .find('[name="hotel_add"]').attr('name', 'c_hotel_add[' + conceptIndexSiteAnexo + '].hotel_add').end()
        .find('[name="idubicacion"]').attr('name', 'c_idubicacion[' + conceptIndexSiteAnexo + '].idubicacion').end();

        $('select[name="c_cadena_add[' + conceptIndexSiteAnexo + '].cadena_add"]').addClass("required");
        $('select[name="c_hotel_add[' + conceptIndexSiteAnexo + '].hotel_add"]').addClass("required");
        createEventListenerCadenaAnexo (conceptIndexSiteAnexo);
        createEventListenerSiteAnexo (conceptIndexSiteAnexo);
    }
    else {
        Swal.fire("Operación abortada", "Excediste el limite de campos permitidos  :(", "error");
    }
  }
  else {
    var ordenando_array_sitios = constante_eliminar_site_anexo.sort();
    index_reutilizado = ordenando_array_sitios[0];

    var $template = $('#optionTemplateSitioAnexo'),
    $clone  = $template
      .clone()
      .removeClass('hide')
      .removeAttr('id')
      .attr('data-book-indexsitios', index_reutilizado)
      .insertBefore($template);
    $clone
          .find('[name="cadena_add"]').attr('name', 'c_cadena_add[' + index_reutilizado + '].cadena_add').attr('data_row', index_reutilizado).end()
          .find('[name="hotel_add"]').attr('name', 'c_hotel_add[' + index_reutilizado + '].hotel_add').end()
          .find('[name="idubicacion"]').attr('name', 'c_idubicacion[' + index_reutilizado + '].idubicacion').end();

          $('select[name="c_cadena_add[' + index_reutilizado + '].cadena_add"]').addClass("required");
          $('select[name="c_hotel_add[' + index_reutilizado + '].hotel_add"]').addClass("required");
          createEventListenerCadenaAnexo (index_reutilizado);
          createEventListenerSiteAnexo (index_reutilizado);

      //Elimino el primero elemento del array
          ordenando_array_sitios.shift();
  }
});

$(".validation-wizard-anexo").on('click','.removeButtonsitiobeta',function(){
  var $row  = $(this).parents('.clone'),
      index = $row.attr('data-book-indexsitios');
  // Remove element containing the option
      $row.remove();
  //Añado el index a reutilizar en la inserción
      constante_eliminar_site_anexo.push(index);
});

function createEventListenerSiteAnexo(id){
  const element = document.querySelector('[name="c_hotel_add['+id+'].hotel_add"]')
  element.addEventListener('change', function() {
    var group = this.value;
    var _token = $('input[name="_token"]').val();
    $.ajax({
      type: "POST",
      url: "/search_idubicacion",
      data: { valor : group , _token : _token },
      success: function (data){
        datax = JSON.parse(data);
        $('[name="c_idubicacion['+id+'].idubicacion"]').val(datax[0].id_ubicacion);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });
}
function createEventListenerCadenaAnexo(id){
  const element = document.querySelector('[name="c_cadena_add['+id+'].cadena_add"]')
  element.addEventListener('change', function() {
    console.log('cadena');
    var _token = $('input[name="_token"]').val();
    $.ajax({
      type: "POST",
      url: "/idproy_search_hotel_by_cadena",
      data: { valor : this.value , _token : _token },
      success: function (data){
        count_data = data.length;
        $('[name="c_hotel_add['+id+'].hotel_add"] option[value!=""]').remove();
        if (count_data > 0) {
          $.each(JSON.parse(data),function(index, objdata){
            $('[name="c_hotel_add['+id+'].hotel_add"]').append('<option value="'+objdata.id+'">'+ objdata.sitio +'</option>');
          });
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });
}
