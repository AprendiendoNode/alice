$(window).on("load", function() {
$('#BtnGeneral').on('click',function(){
//console.log(allAreas);
table(allAreas,$('#lugares'));
});
function table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table);
  vartable.fnClearTable();
  $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.nombre,
      status.estado,
      status.piso,
      '<div class="row">'+
      '<button id="'+status.id+'" type="button" onclick="changename(this);" class="btn btn-success btn-sm text-white p-0 m-1" ><i class="fas fa-edit"></i></button>'+
      '<button id="'+status.id+'" type="button" onclick="changestatus(this);" class="btn btn-warning btn-sm text-white p-0 m-1" ><i class="fas fa-sync-alt"></i></button>'+
      '<button id="'+status.id+'" type="button" onclick="enviar(this);" class="btn btn-danger btn-sm p-0 m-1"><i class="fas fa-trash-alt"></i></button>'+
      '</div>'
    ]);
  });
}

var Configuration_table = {
  "order": [[ 0, "asc" ]],
  paging: true,
  //"pagingType": "simple",
  Filter: false,
  searching: true,
  ordering: true,
  "select": false,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  "columnDefs": [
      {
          "targets": 0,
          "width": "1%",
          "className": "text-center",
      },
      {
        "targets": 1,
        "width": "1%",
        "className": "text-center",
      },
      {
        "targets": 2,
        "width": "1%",
        "className": "text-center",
      },
      {
        "targets": 3,
        "width": "1%",
        "className": "text-center",
      }
  ],

  bInfo: false,
  dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
"<'row'<'col-sm-12'tr>>" +
"<'row'<'col-sm-612col-md-5'i><'col-sm-12 col-md-7'p>>",

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

function enviar(e){
  var id = e.getAttribute("id");
  //$('#selected_area').val(id);
  elementsarray.push(id);
  $('#VistaGeneral').modal('hide');
  $("#EliminarArea").modal("show");
}

function changestatus(e){
var id = e.getAttribute("id");
//$('#selected_area').val(id);
elementsarray.push(id);
$('#VistaGeneral').modal('hide');
$('#CambiarEstado').modal('show');
}

function changename(e){
var id = e.getAttribute("id");
//$('#selected_area').val(id);
elementsarray.push(id);
$('#VistaGeneral').modal('hide');
$('#CambiarNombre').modal('show');
}
