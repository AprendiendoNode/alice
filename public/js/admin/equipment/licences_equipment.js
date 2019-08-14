$(function() {
    $('.datepicker').datepicker();
    $(".select2").select2();
    general_table_equipment();
});
$('#select_one').on('change', function(e){
  var id= $(this).val();
  if (id != ''){
    general_table_equipment();
  }
  else {
    //menssage_toast('Mensaje', '2', 'Seleccione un hotel!' , '3000');
    //general_table_equipment();
  }
});

function general_table_equipment() {
  var _token = $('input[name="_token"]').val();
  var indent = $('#select_one').val();
  $.ajax({
      type: "POST",
      url: "/get_licences",
      data: { ident: indent, _token : _token },
      success: function (data){
        table_move_equipament(data, $("#table_move"), $("#table_check"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function table_move_equipament(datajson, table, form){
      table.DataTable().destroy();
      var vartable = table.dataTable(Configuration_table_responsive_checkbox_move);
      vartable.fnClearTable();
      $.each(JSON.parse(datajson), function(index, status){
        vartable.fnAddData([
          status.idequipo,
          status.Nombre_hotel,
          status.name,
          status.Nombre_marca,
          status.MAC,
          status.Serie,
          status.ModeloNombre,
          "<center><kbd style='background-color:grey'>"+status.Nombre_estado+"</kbd></center>",
          status.Fecha_Registro,
          status.fecha_vencimiento
        ]);
      });
      document.getElementById("table_move_wrapper").childNodes[0].setAttribute("class", "form-inline");
}

$(".btnconf").on("click", function () {
  var rows_selected = $("#table_move").DataTable().column(0).checkboxes.selected();
  var _token = $('input[name="_token"]').val();
   // Iterate over all selected checkboxes
   var valores= new Array();
   $.each(rows_selected, function(index, rowId){
      valores.push(rowId);
  });
  var fecha = $('.datepicker').val();

  if ( valores.length === 0 || fecha == ''){
    menssage_toast('Mensaje', '2', 'Seleccione una fecha y uno o más equipos a actualizar, para continuar!' , '3000');
  }
  else {
    $('#modal-confirmation').modal('show');
  }
});

$(".btn-conf-action").click(function(event) {
  var rows_selected = $("#table_move").DataTable().column(0).checkboxes.selected();
  var _token = $('input[name="_token"]').val();
   // Iterate over all selected checkboxes
   var valores= new Array();
   $.each(rows_selected, function(index, rowId){
      valores.push(rowId);
  });
  //Extract required data
  var fecha = $('.datepicker').val();

  $.ajax({
      type: "POST",
      url: "/update_date",
      data: { idents1: JSON.stringify(valores), fecha: fecha, _token : _token },
      success: function (data){
        //console.log(data);
        if (data === 'true') {
          $('#modal-confirmation').modal('toggle');
          menssage_toast('Mensaje', '4', 'Operation complete!' , '3000');
          general_table_equipment();
          $('.datepicker').val('').trigger('change');
        }
        if (data === 'false') {
          $('#modal-confirmation').modal('toggle');
           menssage_toast('Mensaje', '2', 'Operation Abort!' , '3000');
           $('.datepicker').val('').trigger('change');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
});;

$("#btn_search_mac1").on("click", function () {
  var mac = $('#mac_input1').val();
  $('#select_one').val('').trigger('change');
  if ( mac == '' || mac.length < 4){
    menssage_toast('Mensaje', '2', 'Ingrese datos en el campo de mac, minimo 4 caracteres.' , '3000');
  }
  else {
    general_tabla_search();
  }
});

function general_tabla_search() {
  var _token = $('input[name="_token"]').val();
  var mac = $('#mac_input1').val();


  $.ajax({
      type: "POST",
      url: "/get_licence_mac",
      data: { _token : _token, mac_input: mac },
      success: function (data){
        //console.log(data);
        //tabla_search_mac(data, $('#table_buscador'));
        table_move_equipament(data, $("#table_move"), $("#table_check"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });

}
