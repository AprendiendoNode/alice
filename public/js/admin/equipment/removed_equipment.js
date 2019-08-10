$(function() {
    $(".select2").select2();
  general_table_equipment();
});

$('#select_one').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();
  if (id != ''){
    general_table_equipment();
  }
  else {
    menssage_toast('Mensaje', '2', 'Seleccione un hotel!' , '3000');
    general_table_equipment();
  }
});

function general_table_equipment() {
  var _token = $('input[name="_token"]').val();
  var indent = $('#select_one').val();
  $.ajax({
      type: "POST",
      url: "/search_rem_equipament_hotel",
      data: { ident: indent,_token : _token },
      success: function (data){
        table_consumption_remove(data, $("#table_qualification"), $("#table_check"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

$(".darbajas").on("click", function () {
  var count= $("#table_qualification").DataTable().rows( '.selected' ).count();
  if ( count != '0') {
    $('#modal-confirmation').modal('show');
  }
  else {
    menssage_toast('Mensaje', '2', 'Operation Abort! - Seleccione uno o mas registros' , '3000');
  }
});

function table_consumption_remove(datajson, table, form){
      table.DataTable().destroy();
      var vartable = table.dataTable(Configuration_table_responsive_checkbox_one);
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
          status.Nombre_estado=='Baja'? "<center><kbd style='background-color:red'>"+status.Nombre_estado+"</kbd></center>":"<center><kbd style='background-color:grey'>"+status.Nombre_estado+"</kbd></center>",
          status.Fecha_Registro,
        ]);
      });
  }

  $(".btn-conf-action").click(function(event) {
    var rows_selected = $("#table_qualification").DataTable().column(0).checkboxes.selected();
    var _token = $('input[name="_token"]').val();
     // Iterate over all selected checkboxes
     var valores= new Array();
     $.each(rows_selected, function(index, rowId){
        valores.push(rowId);
    });
    // Output form data to a console
    // $('#example-console-rows').text(valores.toString());

    $.ajax({
        type: "POST",
        url: "/send_item_drops_hotels",
        data: { idents: JSON.stringify(valores), _token : _token },
        success: function (data){
          console.log(data);
          if (data === 'true') {
            $('#modal-confirmation').modal('toggle');
            menssage_toast('Mensaje', '4', 'Operation complete!' , '3000');
            general_table_equipment();
          }
          if (data === 'false') {
            $('#modal-confirmation').modal('toggle');
             menssage_toast('Mensaje', '2', 'Operation Abort!' , '3000');
            //  general_table_equipment();
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
  });;
