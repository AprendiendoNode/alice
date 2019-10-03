$(function() {
  $(".select2").select2({ width: '80%' });

  $('input[type="radio"]').prop('checked', false); // Unchecks it

  $('input[type="radio"]').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass   : 'iradio_square-blue',
    increaseArea : '20%' // optionales
  });
//Oculta o muestra Equipo individual
  $('input[name="facturitha"]').on('ifClicked', function (event) {
    console.log("funciona");
    if (this.value == 'yes') {
      $('.data_fact').show();
      $('.data_equipament').show();
      $('.data_temporal').show();
      $('.priceadd').show();
      reset_fact();
      if ($('#form_marca').length > 0) { $('#form_marca')[0].reset(); }
      if ($('#form_model').length > 0) { $('#form_model')[0].reset(); }
      if ($('#reg_provider').length > 0) { $('#reg_provider')[0].reset(); }
      // $('#form_marca')[0].reset();
      // $('#form_model')[0].reset();
      // $('#reg_provider')[0].reset();
    }
    if (this.value == 'no') {
      $('.data_fact').hide();
      $('.data_equipament').show();
      $('.data_temporal').show();
      $('.priceadd').hide();
      reset_fact();
      $('#precio').val('');
      $('#coinmonto').prop('selectedIndex',0);
      if ($('#form_marca').length > 0) { $('#form_marca')[0].reset(); }
      if ($('#form_model').length > 0) { $('#form_model')[0].reset(); }
      if ($('#reg_provider').length > 0) { $('#reg_provider')[0].reset(); }
      // $('#form_marca')[0].reset();
      // $('#form_model')[0].reset();
      // $('#reg_provider')[0].reset();
    }
  });

//Oculta o muestra Equipo masivo
$('input[name="factura_masiva"]').on('ifClicked', function (event) {
  if (this.value == 'yes') {
    $('.data_fact_masiva').show();
    $('.priceadd_massive').show();
    reset_fact();
    if ($('#form_marca').length > 0) { $('#form_marca')[0].reset(); }
    if ($('#form_model').length > 0) { $('#form_model')[0].reset(); }
    if ($('#reg_provider').length > 0) { $('#reg_provider')[0].reset(); }
    // $('#form_marca')[0].reset();
    // $('#form_model')[0].reset();
    // $('#reg_provider')[0].reset();
  }
  if (this.value == 'no') {
    $('.data_fact_masiva').hide();
    $('.priceadd_massive').hide();
    reset_fact();
    $('#precio_masivo').val('');
    $('#coinmonto_masivo').prop('selectedIndex',0);
    if ($('#form_marca').length > 0) { $('#form_marca')[0].reset(); }
    if ($('#form_model').length > 0) { $('#form_model')[0].reset(); }
    if ($('#reg_provider').length > 0) { $('#reg_provider')[0].reset(); }
    // $('#form_marca')[0].reset();
    // $('#form_model')[0].reset();
    // $('#reg_provider')[0].reset();
  }
});


  $('#date_fact_masiva').datepicker({
      language: 'es',
      defaultDate: '',
      format: "yyyy-mm-dd",
      autoclose: true
  });
  $('#date_fact').datepicker({
      language: 'es',
      defaultDate: '',
      format: "yyyy-mm-dd",
      autoclose: true
  });


  // $('input[name="grupitho"]').typeahead({
  //   minLength: 0,
  //   items: 9999,
  //   source: function(query, process) {
  //     // console.log(query);
  //       return $.ajax({
  //           url: "/search_key_group",
  //           type: 'post',
  //           data: {key: query, _token : $('input[name="_token"]').val()},
  //           success: function(data) {
  //             var dataArray = [];
  //             $.each(JSON.parse(data), function(index, status){
  //               dataArray.push(status.Nombre_Grupo);
  //             });
  //             // console.log(dataArray);
  //             // var json = JSON.parse(data); // string to json
  //             return process(dataArray);
  //             //console.log(json);
  //           }
  //       });
  //   }
  // });

  //Var vartable = $("#table_temporality").dataTable(Configuration_table_clearx2);
  input_mac('add_mac_eq');
  // input_number('add_num_se');

});

$(".create_grupo").on("click", function () {
  let add_grupitho = $('#add_grupitho').val();
  var objData = $("#form_group").find("select,textarea, input").serialize();

  $obligatorio_a = validarespacioinputlength('add_grupitho', 4);
  if ($obligatorio_a == true) {
    $.ajax({
      type: "POST",
      url: '/insertGrupo',
      data: objData,
      success: function (data) {
        //console.log(data);
        if (data === "1") {
          menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
          $('#add_grupo_1').modal('toggle');
          recargar_grupos();
          $('#form_group')[0].reset();
        }else{
          menssage_toast('Mensaje', '2', 'Hubo un error en la insercion, vuelva a intentar.' , '3000');
        }
      },
      error: function (data) {
       menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
      }
    })
  }
  else {
    menssage_toast('Mensaje', '2', 'Por favor complete todos los campos con "*" y con el numero mínimo de caracteres' , '3000');
  }
});

function reset_fact() {
  $('#nfactura').val('');
  $('#date_fact').val('');
  reset_select2('select_one');
}

function reset_select2(name_d){
  $('#'+name_d).val('').trigger('change');
}

$(".close_marca").on("click", function () { $('#form_marca')[0].reset(); });
$(".close_model").on("click", function () { $('#form_model')[0].reset(); });
$(".delete_provider").on("click", function () { $('#reg_provider')[0].reset(); });

$(".create_provider").on("click", function () {
  let provider_rfc = $('#provider_rfc').val();
  let provider_name = $('#provider_name').val();
  let provider_tf = $('#provider_tf').val();
  let provider_address = $('#provider_address').val();
  let provider_estate = $('#provider_estate').val();
  let provider_country = $('#provider_country').val();
  var objData = $("#reg_provider").find("select,textarea, input").serialize();

  $obligatorio_a = validarespacioinputlength('provider_rfc', 13);
  $obligatorio_b = validarespacioinput('provider_name');
  $obligatorio_c = validarespacioinput('provider_tf');
  $obligatorio_d = validarespacioinput('provider_address');
  $obligatorio_e = validarespacioinput('provider_estate');
  $obligatorio_f = validarespacioinput('provider_country');
  if ($obligatorio_a == true && $obligatorio_b == true && $obligatorio_c == true &&
      $obligatorio_d == true && $obligatorio_e == true && $obligatorio_f == true ) {
    $.ajax({
      type: "POST",
      url: '/insertProveedor',
      data: objData,
      success: function (data) {
        //console.log(data);
        if (data === "1") {
          menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
          $('#add_provider').modal('toggle');
          recargar_proveedor();
          $('#reg_provider')[0].reset();
        }else{
          menssage_toast('Mensaje', '2', 'Hubo un error en la insercion, vuelva a intentar.' , '3000');
        }
      },
      error: function (data) {
       menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
      }
    })
  }
  else {
    menssage_toast('Mensaje', '2', 'Por favor complete todos los campos con "*" y con el numero mínimo de caracteres' , '3000');
  }
});
function recargar_grupos(){
  var _token = $('input[name="_token"]').val();
  let count = 0;
  $.ajax({
    type: "POST",
    url: '/search_grupo',
    data: { _token : _token },
    success: function (data) {
      countH = data.length;
      $('#grupitho').empty();
      $('#grupitho').append('<option value="" selected>Elije</option>');
      if (countH > 0) {
        $.each(JSON.parse(data),function(index, objdata){
          $('#grupitho').append('<option value="'+objdata.id+'">'+ objdata.name +'</option>');
        });
      }
    },
    error: function (data) {
     menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
    }
  })
}


function recargar_proveedor(){
  var _token = $('input[name="_token"]').val();
  let count = 0;
  $.ajax({
    type: "POST",
    url: '/search_provider',
    data: { _token : _token },
    success: function (data) {
      countH = data.length;
      $('#select_one').empty();
      $('#select_one').append('<option value="" selected>Elije</option>');
      if (countH > 0) {
        $.each(JSON.parse(data),function(index, objdata){
          $('#select_one').append('<option value="'+objdata.id+'">'+ objdata.nombre +'</option>');
        });
      }
    },
    error: function (data) {
     menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
    }
  })
}

$('#type_equipment').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();

  if (id != ''){
    let parsed;
    let countH = 0;
      $.ajax({
        type: "POST",
        url: "./search_marcas",
        data: { numero : id , _token : _token },
        success: function (data){
          countH = data.length;
          if (countH === 0) {
            $('#Marcas').empty();
            $('#Marcas').append('<option value="" selected>Elija</option>');

            $('#mmodelo').empty();
            $('#mmodelo').append('<option value="" selected>Elija</option>');

          }else{
            $('#Marcas').empty();
            $('#Marcas').append('<option value="" selected>Elija</option>');
            $.each(JSON.parse(data),function(index, objdata){
              $('#Marcas').append('<option value="'+objdata.id+'">'+ objdata.Nombre_marca +'</option>');
            });

            $('#mmodelo').empty();
            $('#mmodelo').append('<option value="" selected>Elija</option>');
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
  }
  else {
      $('#Marcas').empty();
      $('#Marcas').append('<option value="" selected>Elije</option>');
      $("#Marcas").select2({placeholder: "Elija", width: '80%'});

      $('#mmodelo').empty();
      $('#mmodelo').append('<option value="" selected>Elije</option>');
      $("#mmodelo").select2({placeholder: "Elija", width: '80%'});
  }
});

$('#Marcas').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();

  if (id != ''){
    let parsed;
    let countH = 0;
      $.ajax({
        type: "POST",
        url: "./search_modelo",
        data: { numero : id , _token : _token },
        success: function (data){
          countH = data.length;
          if (countH === 0) {
            $('#mmodelo').empty();
            $('#mmodelo').append('<option value="" selected>Elija</option>');
          }else{
            $('#mmodelo').empty();
            $('#mmodelo').append('<option value="" selected>Elija</option>');
            $.each(JSON.parse(data),function(index, objdata){
              $('#mmodelo').append('<option value="'+objdata.id+'">'+ objdata.ModeloNombre +'</option>');
            });
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
  }
  else {
      $('#mmodelo').empty();
      $('#mmodelo').append('<option value="" selected>Elije</option>');
      $("#mmodelo").select2({placeholder: "Elija", width: '80%'});
  }
});
function reset_modelithos(){
  var id= $('#Marcas').val();
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./search_modelo",
    data: { numero : id , _token : _token },
    success: function (data){
      countH = data.length;
      if (countH === 0) {
        $('#mmodelo').empty();
        $('#mmodelo').append('<option value="" selected>Elija</option>');
      }else{
        $('#mmodelo').empty();
        $('#mmodelo').append('<option value="" selected>Elija</option>');
        $.each(JSON.parse(data),function(index, objdata){
          $('#mmodelo').append('<option value="'+objdata.id+'">'+ objdata.ModeloNombre +'</option>');
        });
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
$(".btn_rmd").on("click", function () {
  $('#form_model')[0].reset();
  var _token = $('input[name="_token"]').val();
  let count = 0;
  $.ajax({
    type: "POST",
    url: '/search_marca_all',
    data: { _token : _token },
    success: function (data) {
      countH = data.length;
      $('#marcas_current').empty();
      $('#marcas_current').append('<option value="" selected>Elije</option>');
      if (countH > 0) {
        $.each(JSON.parse(data),function(index, objdata){
          $('#marcas_current').append('<option value="'+objdata.id+'">'+ objdata.Nombre_marca +'</option>');
        });
      }
    },
    error: function (data) {
     menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
    }
  })
});

$(".create_model").on("click", function () {
  let modelitho = $('#add_modelitho').val();
  let marquithas_p = $('#marcas_current').val();

  $obligatorio_a = validarSelect('marcas_current');
  $obligatorio_b = validarespacioinput('add_modelitho');

  var objData = $("#form_model").find("select,textarea, input").serialize();
  console.log(objData);
  if ($obligatorio_a == true && $obligatorio_b == true) {
    $.ajax({
      type: "POST",
      url: '/insertModel',
      data: objData,
      success: function (data) {
        if (data === "1") {
          menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
          $('#add_modelo').modal('toggle');
          reset_modelithos();
          $('#form_model')[0].reset();
        }else{
          menssage_toast('Mensaje', '2', 'Hubo un error en la insercion, vuelva a intentar.' , '3000');
        }
      },
      error: function (data) {
        menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
      }
    })
  }else{
    menssage_toast('Mensaje', '2', 'Por favor complete todos los campos' , '3000');
  }
});
function reset_fact() {
  $('#nfactura').val('');
  $('#date_fact').val('');
  reset_select2('select_one');
}

function validarespacioinputcoin(campo){
  if( $("#"+campo).val().trim()==='' || $("#"+campo).val().length < 1 ) {
    return false;
  }
  else {
    return true;
  }
}
function validarespacioinput(campo){
  if( $("#"+campo).val().trim()==='' || $("#"+campo).val().length < 4 ) {
    return false;
  }
  else {
    return true;
  }
}
function validarespacioinputlength(campo, campob){
  if( $("#"+campo).val().trim()==='' || $("#"+campo).val().length < campob ) {
    return false;
  }
  else {
    return true;
  }
}
function validarSelect(campo) {
  if (campo != '') {
    select=document.getElementById(campo).selectedIndex;
    if( select == null || select == 0 ) {
      return false;
    }
    else {
      return true;
    }
  }
  else {
    return false;
  }
}

$(".btn-save").on("click", function () {
  if ($("input[name='facturitha']:checked").val()  == 'yes') {
    $obligatorio_a = validarespacioinputlength('nfactura',8);
    $obligatorio_b = validarespacioinput('date_fact');
    $obligatorio_c = validarSelect('select_one');

    $obligatorio_d = validarespacioinputlength('add_mac_eq',17);
    $obligatorio_e = validarespacioinputlength('add_num_se', 10);
    $obligatorio_f = validarespacioinput('add_descrip');

    $obligatorio_g = validarSelect('type_equipment');
    $obligatorio_h = validarSelect('Marcas');
    $obligatorio_i = validarSelect('mmodelo');
    $obligatorio_j = validarSelect('add_estado');
    $obligatorio_k = validarSelect('venue');

    $obligatorio_l1 = validarespacioinputcoin('precio');
    $obligatorio_l2 = validarSelect('coinmonto');

    if ($obligatorio_a == true && $obligatorio_b == true && $obligatorio_c == true) {
      if ($obligatorio_d == true && $obligatorio_e == true && $obligatorio_f == true &&
          $obligatorio_g == true && $obligatorio_h == true && $obligatorio_i == true &&
          $obligatorio_j == true && $obligatorio_k == true &&
          $obligatorio_l1 == true && $obligatorio_l2 == true ) {
              /*------------------------------------------------------------------------------------------------------*/
              var objData = $("#add_equipitho").find("select,textarea, input").serialize();
              var $d_venue = $("#venue").select2('data')[0]['text'];
              var $d_type = $("#type_equipment").select2('data')[0]['text'];
              var $d_marcas = $("#Marcas").select2('data')[0]['text'];
              var $d_mac = $('#add_mac_eq').val();
              var $d_num = $('#add_num_se').val();
              var $d_grup = $("#grupitho").select2('data')[0]['text'];
              var $d_desc = $('#add_descrip').val();
              var $d_estado = $("#add_estado").select2('data')[0]['text'];
              var $d_modelo = $("#mmodelo").select2('data')[0]['text'];

              var num_factura = $('#nfactura').val();
              var dat_factura = $('#date_fact').val();
              var num_proveed = $('#select_one').val();
              var order = $('#order').val();

              $.ajax({
                type: "POST",
                url: '/create_equipament_n',
                data: objData + "&nfactura=" + num_factura + "&date_fact=" + dat_factura + "&select_one=" + num_proveed + "&order=" + order+"&masivo="+0,
                success: function (data) {
                  if (data === "3") { menssage_toast('Mensaje', '2', 'Operation Abort- Serie, already registered' , '3000'); }
                  else if (data === "2") { menssage_toast('Mensaje', '2', 'Operation Abort- MAC, already registered' , '3000'); }
                  else if (data === "1") {
                    if ( ! $('#table_temporality').DataTable().data().count() ) {
                        menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
                        $('#table_temporality').DataTable().destroy();
                        $('#table_temporality').DataTable(Configuration_table_clearx2).row.add(
                          [$d_venue, $d_type, $d_marcas, $d_mac, $d_num, $d_grup, $d_desc]
                        ).draw( );
                    }
                    else {
                      menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
                      $('#table_temporality').DataTable().row.add(
                        [$d_venue, $d_type, $d_marcas, $d_mac, $d_num, $d_grup, $d_desc]
                      ).draw();
                    }
                    $('#add_mac_eq').val('');
                    $('#add_num_se').val('');
                    //$('#add_equipitho')[0].reset();
                    //reset_select2('type_equipment');
                    //reset_select2('Marcas');
                    //reset_select2('mmodelo');
                    //reset_select2('add_estado');
                    //reset_select2('venue');
                  }else if(data=='5'){
                    menssage_toast('Mensaje', '4', 'Se insertaron unicamente los datos que no estaban repetidos.' , '3000');
                  }
                  else { menssage_toast('Mensaje', '2', 'Hubo un error en la insercion, vuelva a intentar.' , '3000'); }
                },
                error: function (data) {
                 menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
                }
              });
              /*------------------------------------------------------------------------------------------------------*/
      }
      else {
        menssage_toast('Mensaje', '2', 'Completa los datos de obligatorios, para el registro de equipos' , '3000');
      }
    }
    else {
      menssage_toast('Mensaje', '2', 'Completa los datos de facturación' , '3000');
    }
  }
  if ($("input[name='facturitha']:checked").val() == 'no') {
    $obligatorio_d = validarespacioinputlength('add_mac_eq',17);
    $obligatorio_e = validarespacioinputlength('add_num_se', 10);
    $obligatorio_f = validarespacioinput('add_descrip');

    $obligatorio_g = validarSelect('type_equipment');
    $obligatorio_h = validarSelect('Marcas');
    $obligatorio_i = validarSelect('mmodelo');
    $obligatorio_j = validarSelect('add_estado');
    $obligatorio_k = validarSelect('venue');

    if ($obligatorio_d == true && $obligatorio_e == true && $obligatorio_f == true &&
        $obligatorio_g == true && $obligatorio_h == true && $obligatorio_i == true &&
        $obligatorio_j == true && $obligatorio_k == true) {
          /*------------------------------------------------------------------------------------------------------*/
          var objData = $("#add_equipitho").find("select,textarea, input").serialize();
          var $d_venue = $("#venue").select2('data')[0]['text'];
          var $d_type = $("#type_equipment").select2('data')[0]['text'];
          var $d_marcas = $("#Marcas").select2('data')[0]['text'];
          var $d_mac = $('#add_mac_eq').val();
          var $d_num = $('#add_num_se').val();
          var $d_grup = $("#grupitho").select2('data')[0]['text'];
          var $d_desc = $('#add_descrip').val();
          var $d_estado = $("#add_estado").select2('data')[0]['text'];
          var $d_modelo = $("#mmodelo").select2('data')[0]['text'];
          $.ajax({
            type: "POST",
            url: '/create_equipament_nd',
            data: objData+"&masivo="+0,
            success: function (data) {
              if (data === "3") { menssage_toast('Mensaje', '2', 'Operation Abort- Serie, already registered' , '3000'); }
              else if (data === "2") { menssage_toast('Mensaje', '2', 'Operation Abort- MAC, already registered' , '3000'); }
              else if (data === "1") {
                if ( ! $('#table_temporality').DataTable().data().count() ) {
                    menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
                    $('#table_temporality').DataTable().destroy();
                    $('#table_temporality').DataTable(Configuration_table_clearx2).row.add(
                      [$d_venue, $d_type, $d_marcas, $d_mac, $d_num, $d_grup, $d_desc]
                    ).draw( );
                }
                else {
                  menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
                  $('#table_temporality').DataTable().row.add(
                    [$d_venue, $d_type, $d_marcas, $d_mac, $d_num, $d_grup, $d_desc]
                  ).draw();
                }
                $('#add_mac_eq').val('');
                $('#add_num_se').val('');
                // $('#add_equipitho')[0].reset();
                // reset_select2('type_equipment');
                // reset_select2('Marcas');
                // reset_select2('mmodelo');
                // reset_select2('add_estado');
                // reset_select2('venue');
              }else if(data=='5'){
                menssage_toast('Mensaje', '4', 'Se insertaron unicamente los datos que no estaban repetidos.' , '3000');
              }
              else { menssage_toast('Mensaje', '2', 'Hubo un error en la insercion, vuelva a intentar.' , '3000'); }
            },
            error: function (data) {
             menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
            }
          });
          /*------------------------------------------------------------------------------------------------------*/
    }
    else {
      menssage_toast('Mensaje', '2', 'Completa los datos de obligatorios, para el registro de equipos' , '3000');
    }
  }
});

$(".btn-clear").on("click", function () {
  $('#add_equipitho')[0].reset();
  reset_select2('type_equipment');
  reset_select2('Marcas');
  reset_select2('mmodelo');
  reset_select2('add_estado');
  reset_select2('venue');
});
$(".btn-cancel").on("click", function () {
  reset_fact();

  $('#add_equipitho')[0].reset();
  reset_select2('type_equipment');
  reset_select2('Marcas');
  reset_select2('mmodelo');
  reset_select2('add_estado');
  reset_select2('venue');

  $('input[name="facturitha"]').iCheck('uncheck');

  $('.data_fact').hide();
  $('.data_equipament').hide();
  $('.data_temporal').hide();
  $('.priceadd').hide();
  $('#precio').val('');
  $('#coinmonto').prop('selectedIndex',0);

  $('#table_temporality').DataTable().clear().draw();
  $("#table_temporality").DataTable().destroy();
});


$(".create_marca").on("click", function () {
  let marquita;
  let marcas_select = $('#marcas_select').val();
  let distribuidor = $('#add_distribuidor').val();


  if(marcas_select == ''){
      marquita = $('#add_marquitha').val();


  }else{
      marquita = $("#marcas_select option:selected" ).text();
  }

  $obligatorio_c = validarSelect('modelitho_current')

  var objData = $("#form_marca").find("select,textarea, input").serialize();
  if ($obligatorio_c == true) {
    $.ajax({
      type: "POST",
      url: '/insertMarca',
      data: objData,
       success: function (data) {
        console.log(data);
        if (data === "1") {
          menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
          $('#add_marca_4').modal('toggle');
          recargar_marcas();
          $('#form_marca')[0].reset();
        }else{
          menssage_toast('Mensaje', '2', 'Hubo un error en la insercion, vuelva a intentar.' , '3000');
        }
      },
      error: function (data) {
       menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
      }
    });
  }
   else{
    menssage_toast('Mensaje', '2', 'Por favor complete todos los campos' , '3000');
  }
});

function recargar_marcas(){
  var _token = $('input[name="_token"]').val();
  var type = $('#type_equipment').val();

  let count = 0;
  $.ajax({
    type: "POST",
    url: '/search_marcas',
    data: { numero: type, _token : _token },
    success: function (data) {
      countH = data.length;
      $('#Marcas').empty();
      $('#Marcas').append('<option value="" selected>Elije</option>');
      if (countH > 0) {
        $.each(JSON.parse(data),function(index, objdata){
          $('#Marcas').append('<option value="'+objdata.id+'">'+ objdata.Nombre_marca +'</option>');
        });
      }
    },
    error: function (data) {
     menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
    }
  })
}


//Subida masiva a traves del excel---------------------------------------------------------------------------------

$('#file_excel').on('change', function(e){
  //$('#preview_excel').DataTable().clear().draw();
  handleFile(e);
});

//
function handleFile(e) {
      //Get the files from Upload control
         var files = e.target.files;
         var i, f;
         var excelData = [];
         var datos_raw;
         var result;
      //Loop through files
         for (i = 0, f = files[i]; i != files.length; ++i) {
             var reader = new FileReader();
             var name = f.name;
             reader.onload = function (e) {
                 var data = e.target.result;

                 var result;
                 var workbook = XLSX.read(data, { type: 'binary' });

                 var sheet_name_list = workbook.SheetNames; //Obtenemos los nombres
                 sheet_name_list.some(function (y) { /* iteramos */
                      datos_raw = XLSX.utils.sheet_to_json(workbook.Sheets[y]); //Convertimos los valores a JSON
                     if (datos_raw.length > 0) {
                         result = JSON.stringify(datos_raw);
                         console.log(result);
                         result_json=JSON.parse(result);//Necesario
                        // console.log(result_json);
                        //Pasamos todo a un arreglo

                        //console.log('Elementos en el arreglo');
                        //console.log(excelData);

                        $("#preview_excel").DataTable({
                          //"ajax":result,
                          "pageLength": 5,
                          "bProcessing":true,
                          "data":result_json,
                          "columns" : [
                            {"data": "FACTURA",
                            "defaultContent": "No asignado"},
                            {"data": "NO DE FACTURA",
                            "defaultContent": "No asignado"},
                            {"data": "FECHA",
                            "defaultContent": "No asignado"},
                            {"data": "MAC",
                            "defaultContent": ""},
                            {"data": "SERIE",
                            "defaultContent": ""},
                           {"data": "DESCRIPCION",
                            "defaultContent": ""},
                            {"data": "TIPO",
                            "defaultContent": "No asignado"},
                            {"data": "MARCA",
                            "defaultContent": "No asignado"},
                            {"data": "MODELO",
                            "defaultContent": "No asignado"},
                            {"data": "ESTADO",
                            "defaultContent": "No asignado"},
                            {"data": "SITIO",
                            "defaultContent": "No asignado"},
                            {"data": "PRECIO /PESOS",
                            "defaultContent": "No asignado"},
                            {"data": "GRUPO",
                            "defaultContent": "No asignado"}
                          ],
                          "bDestroy": true
                        });
                         return true;
                     }
                 });


                 //console.log(datos_raw);
             };
             reader.readAsArrayBuffer(f);
         }

     }
//Enviando los datos excel----------------------------------------------------------
//añadir equipos masivo
$(".btn-save-massive").on("click", function () {
  var _token = $('input[name="_token"]').val();
  var excelData =[];
  for(i=0;i<result_json.length;i++){
    if(result_json[i]['MAC']!=''){
    element ={factura:result_json[i]['FACTURA'],nofactura:result_json[i]['NO DE FACTURA'],fecha:result_json[i]['FECHA'],mac:result_json[i]['MAC'].toString().match(/.{2}/g).join(':').toUpperCase(),serie:result_json[i]['SERIE'],descripcion:result_json[i]['DESCRIPCION']};
    excelData.push(element);
    //console.log(excelData);
  } else{
    break
  }
  }
  if ($("input[name='factura_masiva']:checked").val()  == 'yes') {
    $obligatorio_a = validarespacioinputlength('nfactura_masiva',8);
    $obligatorio_b = validarespacioinput('date_fact_masiva');
    $obligatorio_c = validarSelect('select_one_massive');
    //$obligatorio_f = validarespacioinput('add_descrip_masiva'); //Ahora es opcional
    $obligatorio_g = validarSelect('type_equipment_massive');
    $obligatorio_h = validarSelect('Marcas_masiva');
    $obligatorio_i = validarSelect('mmodelo_masivo');
    $obligatorio_j = validarSelect('add_estado_masivo');
    $obligatorio_k = validarSelect('venue_massive');

    $obligatorio_l1 = validarespacioinputcoin('precio_masivo');
    $obligatorio_l2 = validarSelect('coinmonto_masivo');
    //console.log("Imprimiendo desde insertar");
    //console.log(result_json);
    if ($obligatorio_a == true && $obligatorio_b == true && $obligatorio_c == true) {
      if ($obligatorio_g == true && $obligatorio_h == true
          && $obligatorio_i == true &&  $obligatorio_j == true && $obligatorio_k == true
           && $obligatorio_l1 == true && $obligatorio_l2 == true ) {
              /*------------------------------------------------------------------------------------------------------*/
              var objData = $("#add_equipo_masivo").find("select,textarea, input").serialize();
              var $d_venue = $("#venue_massive").select2('data')[0]['text'];
              var $d_type = $("#type_equipment_massive").select2('data')[0]['text'];
              var $d_marcas = $("#Marcas_masiva").select2('data')[0]['text'];
              //var $d_mac = $('#add_mac_eq').val(); no usados, se tomara del json
              //var $d_num = $('#add_num_se').val(); no usados, se tomara del json
              var $d_grup = $("#grupo_masivo").select2('data')[0]['text'];
              //var $d_desc = $('#add_descrip_masiva').val();
              var $d_estado = $("#add_estado_masivo").select2('data')[0]['text'];
              var $d_modelo = $("#mmodelo_masivo").select2('data')[0]['text'];
              //var descripcion =$('#add_descrip_masiva').val();
              var num_factura = $('#nfactura_masiva').val();
              var dat_factura = $('#date_fact_masiva').val();
              var num_proveed = $('#select_one_massive').val();//proveedor
              var order = $('#order_massive').val();
              var descripcion =$('#add_descrip_masiva').val();

              $.ajax({
                type: "POST",
                url: '/create_equipament_n',
                data:{data_excel: excelData,add_descrip:descripcion,objData:objData,masivo:1,nfactura_masiva:num_factura,date_fact_masiva:dat_factura,select_one_massive:num_proveed,order_massive:order,masivo:1, _token : _token },
                //data: objData + "&nfactura_masiva=" + num_factura + "&date_fact_masiva=" + dat_factura + "&select_one_massive=" + num_proveed + "&order_massive=" + order,
                success: function (data) {
                  if (data === "3") { menssage_toast('Mensaje', '2', 'Operation Abort- Serie, already registered' , '3000'); }
                  else if (data === "2") { menssage_toast('Mensaje', '2', 'Operation Abort- MAC, already registered' , '3000'); }
                  else if (data === "1") {
                    if ( ! $('#table_temporality').DataTable().data().count() ) {
                        menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
                        $('#table_temporality').DataTable().destroy();
                        $('#table_temporality').DataTable(Configuration_table_clearx2).row.add(
                          [$d_venue, $d_type, $d_marcas, $d_mac, $d_num, $d_grup, $d_desc]
                        ).draw( );
                    }
                    else {
                      menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
                      $('#table_temporality').DataTable().row.add(
                        [$d_venue, $d_type, $d_marcas, $d_mac, $d_num, $d_grup, $d_desc]
                      ).draw();
                    }
                    //$('#add_mac_eq').val('');
                    //$('#add_num_se').val('');
                    //$('#add_equipitho')[0].reset();
                    //reset_select2('type_equipment');
                    //reset_select2('Marcas');
                    //reset_select2('mmodelo');
                    //reset_select2('add_estado');
                    //reset_select2('venue');
                  }else if(data==5){
                    menssage_toast('Mensaje', '4', 'Se insertaron unicamente los datos que no estaban repetidos.' , '3000');
                  }
                  else { menssage_toast('Mensaje', '2', 'Hubo un error en la insercion, vuelva a intentar.' , '3000'); }
                },
                error: function (data) {
                 menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
                }
              });
              /*------------------------------------------------------------------------------------------------------*/
      }
      else {
        menssage_toast('Mensaje', '2', 'Completa los datos de obligatorios, para el registro de equipos' , '3000');
      }
    }
    else {
      menssage_toast('Mensaje', '2', 'Completa los datos de facturación' , '3000');
    }
  }
  if ($("input[name='factura_masiva']:checked").val() == 'no') {
    console.log("Imprimiendo datos excel");
    console.log(excelData);
    //$obligatorio_f = validarespacioinput('add_descrip_masiva');//Ya no es necesario, se tomará el del excel.
    $obligatorio_g = validarSelect('type_equipment_massive');
    $obligatorio_h = validarSelect('Marcas_masiva');
    $obligatorio_i = validarSelect('mmodelo_masivo');
    $obligatorio_j = validarSelect('add_estado_masivo');
    $obligatorio_k = validarSelect('venue_massive');

    if ( $obligatorio_g == true && $obligatorio_h == true
      && $obligatorio_i == true && $obligatorio_j == true && $obligatorio_k == true) {
          /*------------------------------------------------------------------------------------------------------*/
          var objData = $("#add_equipo_masivo").find("select,textarea, input").serialize();
          var $d_venue = $("#venue_massive").select2('data')[0]['text'];
          var $d_type = $("#type_equipment_massive").select2('data')[0]['text'];
          var $d_marcas = $("#Marcas_masiva").select2('data')[0]['text'];
          //var $d_mac = $('#add_mac_eq').val();
          //var $d_num = $('#add_num_se').val();
          var $d_grup = $("#grupo_masivo").select2('data')[0]['text'];
        //  var $d_desc = $('#add_descrip_masiva').val();
          var $d_estado = $("#add_estado_masivo").select2('data')[0]['text'];
          var $d_modelo = $("#mmodelo_masivo").select2('data')[0]['text'];
          var descripcion =$('#add_descrip_masiva').val();
          console.log(objData);
          console.log(JSON.stringify(excelData));
          $.ajax({
            type: "POST",
            url: '/create_equipament_nd',
            //data: objData+"&data_excel="+JSON.stringify(excelData)+"&masivo="+1,//{data_excel: excelData,descripcion_m: descripcion ,objData,nofactura: num_factura,fechafactura: dat_factura,proveedor:num_proveed,orden: order, _token : _token }, //Falta añadir objData
            //data: {data_excel: excelData,descripcion_m: descripcion ,objData,nofactura: num_factura,fechafactura: dat_factura,proveedor:num_proveed,orden: order, _token : _token }, //Falta añadir objData,//
            data: {data_excel: excelData,add_descrip: descripcion,objData:objData,masivo:1, _token : _token }, //Falta añadir objData,//
            success: function (data) {
              if (data === "3") { menssage_toast('Mensaje', '2', 'Operation Abort- Serie, already registered' , '3000'); }
              else if (data === "2") { menssage_toast('Mensaje', '2', 'Operation Abort- MAC, already registered' , '3000'); }
              else if (data === "1") {
                if ( ! $('#preview_excel').DataTable().data().count() ) {
                    menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
                    $('#preview_excel').DataTable().destroy();
                }
                else {
                  menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
                }
                //$('#add_mac_eq').val('');
                //$('#add_num_se').val('');
                // $('#add_equipitho')[0].reset();
                // reset_select2('type_equipment');
                // reset_select2('Marcas');
                // reset_select2('mmodelo');
                // reset_select2('add_estado');
                // reset_select2('venue');
              }else if(data==5){
                menssage_toast('Mensaje', '4', 'Se insertaron unicamente los datos que no estaban repetidos.' , '3000');
              }
              else { menssage_toast('Mensaje', '2', 'Hubo un error en la insercion, vuelva a intentar.' , '3000'); }
            },
            error: function (data) {
              //alert(xhr.responseText);
              menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
            }


          });
          /*------------------------------------------------------------------------------------------------------*/
    }
    else {
      menssage_toast('Mensaje', '2', 'Completa los datos de obligatorios, para el registro de equipos' , '3000');
    }
  }
});
//limpiar equipos masivo
$(".btn-clear-massive").on("click", function () {
  $('#add_equipo_masivo')[0].reset();
  reset_select2('grupo_masivo');
  reset_select2('type_equipment_massive');
  reset_select2('Marcas_masiva');
  reset_select2('mmodelo_masivo');
  reset_select2('add_estado_masivo');
  reset_select2('venue_massive');
  $('#add_descrip_masiva').val('');
});
//Cancelar equipos masivo
$(".btn-cancel-massive").on("click", function () {
  reset_fact();

  $('#add_equipo_masivo')[0].reset();
  reset_select2('type_equipment_massive');
  reset_select2('Marcas_masiva');
  reset_select2('mmodelo_masivo');
  reset_select2('add_estado_masivo');
  reset_select2('venue_massive');

  $('input[name="factura_masiva"]').iCheck('uncheck');

  $('.data_fact_masiva').hide();
  $('.priceadd_massive').hide();
  $('#precio_masivo').val('');
  $('#coinmonto_masivo').prop('selectedIndex',0);
});
//busca equipo en seccion masiva
$('#type_equipment_massive').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();

  if (id != ''){
    let parsed;
    let countH = 0;
      $.ajax({
        type: "POST",
        url: "./search_marcas",
        data: { numero : id , _token : _token },
        success: function (data){
          countH = data.length;
          if (countH === 0) {
            $('#Marcas_masiva').empty();
            $('#Marcas_masiva').append('<option value="" selected>Elija</option>');

            $('#mmodelo').empty();
            $('#mmodelo').append('<option value="" selected>Elija</option>');

          }else{
            $('#Marcas_masiva').empty();
            $('#Marcas_masiva').append('<option value="" selected>Elija</option>');
            $.each(JSON.parse(data),function(index, objdata){
              $('#Marcas_masiva').append('<option value="'+objdata.id+'">'+ objdata.Nombre_marca +'</option>');
            });

            $('#mmodelo').empty();
            $('#mmodelo').append('<option value="" selected>Elija</option>');
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
  }
  else {
      $('#Marcas_masiva').empty();
      $('#Marcas_masiva').append('<option value="" selected>Elije</option>');
      $("#Marcas_masiva").select2({placeholder: "Elija", width: '80%'});

      $('#mmodelo').empty();
      $('#mmodelo').append('<option value="" selected>Elije</option>');
      $("#mmodelo").select2({placeholder: "Elija", width: '80%'});
  }
});
//busca marcas en seccion masiva
$('#Marcas_masiva').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();

  if (id != ''){
    let parsed;
    let countH = 0;
      $.ajax({
        type: "POST",
        url: "./search_modelo",
        data: { numero : id , _token : _token },
        success: function (data){
          countH = data.length;
          if (countH === 0) {
            $('#mmodelo_masivo').empty();
            $('#mmodelo_masivo').append('<option value="" selected>Elija</option>');
          }else{
            $('#mmodelo_masivo').empty();
            $('#mmodelo_masivo').append('<option value="" selected>Elija</option>');
            $.each(JSON.parse(data),function(index, objdata){
              $('#mmodelo_masivo').append('<option value="'+objdata.id+'">'+ objdata.ModeloNombre +'</option>');
            });
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
  }
  else {
      $('#mmodelo_masivo').empty();
      $('#mmodelo_masivo').append('<option value="" selected>Elije</option>');
      $("#mmodelo_masivo").select2({placeholder: "Elija", width: '80%'});
  }
});
