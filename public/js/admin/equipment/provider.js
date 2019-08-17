$(function () {
  table_provider();
});
$(".create_provider").on("click", function () {
  let provider_rfc = $('#provider_rfc').val();
  let provider_name = $('#provider_name').val();
  let provider_tf = $('#provider_tf').val();
  let provider_address = $('#provider_address').val();
  let provider_estate = $('#provider_estate').val();
  let provider_country = $('#provider_country').val();
  let provider_post = $('#provider_postcode').val();

  var objData = $("#reg_provider").find("select,textarea, input").serialize();

  if (provider_rfc === "" || provider_name === "" || provider_post === "") {
    menssage_toast('Mensaje', '2', 'Por favor complete todos los campos con "*"' , '3000');
  }else{
    $.ajax({
      type: "POST",
      url: '/insertProveedor',
      data: objData,
      success: function (data) {
        //console.log(data);
        if (data === "1") {
          menssage_toast('Mensaje', '4', 'Datos insertados con exito' , '3000');
          $('#add_provider').modal('toggle');
          table_provider();
          clean_modal();
        }else{

          menssage_toast('Mensaje', '2', 'Hubo un error en la insercion, vuelva a intentar.' , '3000');
        }
      },
      error: function (data) {
       menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
      }
    })

  }

});

$(".delete_provider").on("click", function () {
  clean_modal();
});

function clean_modal() {
  $('#provider_rfc').val("");
  $('#provider_name').val("");
  $('#provider_tf').val("");
  $('#provider_address').val("");
  $('#provider_estate').val("");
  $('#provider_country').val("");
  $('#provider_municipality').val("");
  $('#provider_postcode').val("");
  $('#provider_phone').val("");
  $('#provider_fax').val("");
  $('#provider_email').val("");
  $('#agent_name').val("");
  $('#agent_phone').val("");
}

function table_provider() {
  var _token = $('input[name="_token"]').val();
  // var data = JSON.stringify([{id:'1', rfc:'Zyxel', fiscal:'Persona Moral', estado:'Quintana Roo'},
  //   {id:'2', rfc:'Fibremex', fiscal:'Persona Fisica', estado:'Quintana Roo'},
  //   {id:'3', rfc:'Anixter', fiscal:'Persona Moral', estado:'Quintana Roo'}
  // ]);
  $.ajax({
      type: "POST",
      url: "/getTableProvider",
      data: { _token : _token },
      success: function (data){

        table_provider_fun(data, $("#table_providers"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function table_provider_fun(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_providers);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
      status.nombre,
      status.rfc,
      status.direccion,
      '<a href="javascript:void(0);" onclick="enviaredit(this)" value="'+status.id+'" class="btn btn-primary btn-xs" role="button" data-target="#EditServ"><i class="fas fa-pencil-alt margin-r5"></i> Editar</a><a href="javascript:void(0);" onclick="enviardelet(this)" value="'+status.id+'" class="btn btn-danger btn-xs" role="button" data-target="#DeletServ"><i class="fas fa-trash-alt margin-r5"></i> Eliminar</a>',
    ]);
  });
  document.getElementById("table_providers_wrapper").childNodes[0].setAttribute("class", "form-inline");
}

function enviaredit(e) {
  var _token = $('input[name="_token"]').val();
  var valor= e.getAttribute('value');
  $('#rec_provider').val(valor);
  $('#edit_provider').modal('show');

  $.ajax({
    type: "POST",
    url: "/show_updateinfo",
    data: { rec_provider : valor, _token: _token},
    success: function (data){
      //console.log(data);
      var datosJ = JSON.parse(data);
      //console.log(datosJ);
      $('#provider_name1').val(datosJ[0].nombre);
      $('#provider_rfc1').val(datosJ[0].rfc);
      $('#provider_address1').val(datosJ[0].direccion);
      $('#provider_tf1').val(datosJ[0].regimen_Fiscal);
      $('#provider_municipality1').val(datosJ[0].municipio);
      $('#provider_estate1').val(datosJ[0].estado);
      $('#provider_country1').val(datosJ[0].pais);
      $('#provider_postcode1').val(datosJ[0].cp);
      $('#provider_phone1').val(datosJ[0].telefono);
      $('#provider_fax1').val(datosJ[0].fax);
      $('#provider_email1').val(datosJ[0].email);
      $('#agent_name1').val(datosJ[0].agente_nombre);
      $('#agent_phone1').val(datosJ[0].agente_telefono);
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

}
function enviardelet(e) {
  var valor= e.getAttribute('value');
  $('#recibidoconf').val(valor);
  $('#del_provider').modal('show');
}

$(".btndelete").on("click", function () {
  var objData = $("#deleteprovidersystem").find("select,textarea, input").serialize();
  //var id = $('#recibidoconf').val();
  //alert(id);
  $.ajax({
       type: "POST",
       url: '/delete_provider',
       data: objData,
       success: function (data) {
        console.log(data);
        if (data == '1') {
          $('#del_provider').modal('toggle');
          table_provider();
          menssage_toast('Mensaje', '4', 'Operation complete!' , '3000');
        }else{
          $('#del_provider').modal('toggle');
          menssage_toast('Mensaje', '2', 'There seems to be an error, try again later.' , '3000');
        }
       },
       error: function (data) {
        console.log(data);
        $('#del_provider').modal('toggle');
        menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
       }
   })
});

$(".update_data").on("click", function () {
  var objData = $("#ed_provider").find("select,textarea, input").serialize();

  let provider_rfc = $('#provider_rfc1').val();
  let provider_name = $('#provider_name1').val();
  let provider_tf = $('#provider_tf1').val();
  let provider_address = $('#provider_address1').val();
  let provider_estate = $('#provider_estate1').val();
  let provider_country = $('#provider_country1').val();
  let provider_post = $('#provider_postcode1').val();

  if (provider_rfc === "" || provider_name === "" || provider_post === "") {
    menssage_toast('Mensaje', '2', 'Por favor complete todos los campos con "*"' , '3000');
  }else{
    $.ajax({
      type: "POST",
      url: '/update_provider',
      data: objData,
      success: function (data) {
        //console.log(data);
        if (data == '1') {
          $('#edit_provider').modal('toggle');
          table_provider();
          menssage_toast('Mensaje', '4', 'Operation complete!' , '3000');
        }else{
          $('#edit_provider').modal('toggle');
          menssage_toast('Mensaje', '2', 'There seems to be an error, try again later.' , '3000');
        }
      },
      error: function (data) {
        console.log(data);
        $('#edit_provider').modal('toggle');
        menssage_toast('Mensaje', '2', 'Operation Abort- Changes not made' , '3000');
      }
    });
  }
});

var Configuration_table_responsive_providers= {
  dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="far fa-file-excel"></i> Excel',
        titleAttr: 'Excel',
        title: function ( e, dt, node, config ) {
          return 'Lista de proveedores';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0,1,2],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-success custombtntable',
      },
      {
        extend: 'csvHtml5',
        text: '<i class="far fa-file-alt"></i> CSV',
        titleAttr: 'CSV',
        title: function ( e, dt, node, config ) {
          return 'Lista de proveedores';
        },
        init: function(api, node, config) {
           $(node).removeClass('btn-default')
        },
        exportOptions: {
            columns: [ 0,1,2],
            modifier: {
                page: 'all',
            }
        },
        className: 'btn btn-info',
      }
  ],
  "processing": true,

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
};
