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
get_info_equipments(cadena);


  });

  function get_info_equipments(idcadena) {
    var _token = $('meta[name="csrf-token"]').attr('content');
    var id= idcadena;
    $.ajax({
      type: "POST",
      url: "/get_all_equipmentsbyhotel",
      data: { _token : _token, id: id },
      success: function (data){

        table_equipments(data, $("#all_equipments"));

      },
      error: function (data) {
        console.log('Error:', data);
      }
    });

  }

  function table_equipments(datajson, table){
    table.DataTable().destroy();
    var vartable = table.dataTable(Configuration_table_equipments);
    vartable.fnClearTable();
    $.each(datajson, function(index, status){
      vartable.fnAddData([
        status.especificacions_id,
        status.modelos_id,
        status.MAC,
        status.Serie,
        status.Descripcion,
        status.estados_id,
        status.Fecha_Registro,
        status.Fecha_Baja

      ]);
    });
  }



  var Configuration_table_equipments = {
    "order": [[ 0, "asc" ]],
    paging: true,
    //"pagingType": "simple",
    Filter: true,
    searching: true,
    ordering: true,
    "select": false,
    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
    // "columnDefs": [
    //     {
    //       "targets": 0,
    //       "width": "1%",
    //     },
    // ],
    // "select": {
    //     'style': 'multi',
    // },
    //ordering: false,
    //"pageLength": 5,
    dom: "<'row'<'col-sm-2'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",

    bInfo: true,
    "createdRow": function ( row, data, index ) {

  },
    "footerCallback": function(row, data, start, end, display){

    },
    language:{
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "<i class='fa fa-search'></i> Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
      },
      "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }
  }


});
