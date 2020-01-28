$(function() {
  generate_table();
  $('#last_level').bootstrapToggle('off');
  $('#status').bootstrapToggle('on');

});

function generate_table() {
  var form = $('#form')[0];
  var formData = new FormData(form);
  $.ajax({
    type: "POST",
    url: "/integration/accounting_account_show",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data){
      if (typeof data !== 'undefined' && data.length > 0) {
        table_filter(data, $("#table_filter"));
      }
    },
    error: function (err) {
      Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: err.statusText,
      });
    }
  });
}

function table_filter(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, information){
    var status = information.estatus;
    var html = "", estatus = "";
    var a01='', a02='', a03='', a04='',a05='',a06='',a07='',a08='';
    a01 = '<div class="btn-group">';
    a02 = '<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>';
    a03 = '<div class="dropdown-menu">';
    a04 = '<a class="dropdown-item" href="javascript:void(0);" onclick="edit_account(this)" value="'+information.id+'" datas="'+information.nombre+'"><i class="far fa-edit"></i> Editar</a>';
    a05 = '<div class="dropdown-divider"></div>';
    if (parseInt(status) == 0) {
      a06 = '<a class="dropdown-item" href="javascript:void(0);"  onclick="link_enable(this)" value="'+information.id+'" datas="'+information.nombre+'"><i class="far fa-thumbs-up"></i> Habilitar</a>';
    }
    if (parseInt(status) == 1) {
      a06 = '<a class="dropdown-item" href="javascript:void(0);"  onclick="link_disable(this)" value="'+information.id+'" datas="'+information.nombre+'"><i class="far fa-thumbs-down"></i> Deshabilitar</a>';
    }
    a07 = '</div>';
    a08 = '</div>';
    var dropdown = a01+a02+a03+a04+a05+a06+a07+a08;
    if (parseInt(status) == '0'){
      estatus = '<i class="fas fa-times text-danger"></i> Dehabilitar';
    }
    else if (parseInt(status) == '1'){
      estatus = '<i class="fas fa-check text-success"></i> Habilitar';
    }
    vartable.fnAddData([
      dropdown,
      information.cuenta,
      information.nombre,
      information.naturaleza,
      information.rubro,
      information.codigo_agrupador,
      estatus,
    ]);
  });
}

var Configuration_table_responsive = {
  dom: "<'row'<'col-sm-5'B><'col-sm-3'l><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    "ordering": false,
    buttons: [
      {
        text: '<i class="fas fa-plus-circle fastable mt-2"></i> Crear nuevo',
        titleAttr: 'Crear nuevo',
        className: 'btn btn-danger btn-sm',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        action: function ( e, dt, node, config ) {
          $('#modal-CreatNew').modal('show');
          if (document.getElementById("createAccount")) {
            $('#createAccount')[0].reset();
            $('#createAccount').data('formValidation').resetForm($('#createAccount'));
            $('#inputCreatOrden').val(0);
          }
        }
      },
      {
        extend: 'excelHtml5',
        title: 'Cuentas contables',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-excel fastable mt-2"></i> Extraer a Excel',
        titleAttr: 'Excel',
        className: 'btn btn-success btn-sm',
        exportOptions: {
            columns: [ 1, 2, 3, 4, 5, 6]
        },
      },
      {
        extend: 'csvHtml5',
        title: 'Cuentas contables',
        init: function(api, node, config) {
           $(node).removeClass('btn-secondary')
        },
        text: '<i class="fas fa-file-csv fastable mt-2"></i> Extraer a CSV',
        titleAttr: 'CSV',
        className: 'btn btn-primary btn-sm',
        exportOptions: {
          columns: [ 1, 2, 3, 4, 5, 6]
        },
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

//Editar cuenta
function edit_account(e) {
  var valor= e.getAttribute('value');
  var folio= e.getAttribute('datas');
  var _token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      type: "POST",
      url: '/sales/accounting_account_edit',
      data: {token_b : valor, _token : _token},
      success: function (data) {
        $("#modal-Edit").modal("show");
        
      },
      error: function (err) {
        Swal.fire({
         type: 'error',
         title: 'Oops...',
         text: err.statusText,
        });
      }
  })
}
//Deshabilitar
function link_disable(e) {
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  var folio = e.getAttribute('datas');
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Se Deshabilitar",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: '/integration/accounting_account_closed',
          data: {token_b : valor, _token : _token},
          success: function (data) {
            if(data.status == 200){
              Swal.fire('Operación completada!', '', 'success')
              .then(()=> {
                location.href ="/integration/accounting_account";
              });
            }
            else {
              Swal.fire({
                 type: 'error',
                 title: 'Oops... Error: '+data.status,
                 text: 'No se ha modificado',
              });
            }
          },
          error: function (err) {
              Swal.fire({
                 type: 'error',
                 title: 'Oops...',
                 text: err.statusText,
              });
          }
        })
    }
  });
}
//Habilitar
function link_enable(e) {
  var valor= e.getAttribute('value');
  var _token = $('meta[name="csrf-token"]').attr('content');
  var folio = e.getAttribute('datas');
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Se Habilitar",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar',
    cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "POST",
          url: '/integration/accounting_account_open',
          data: {token_b : valor, _token : _token},
          success: function (data) {
            if(data.status == 200){
              Swal.fire('Operación completada!', '', 'success')
              .then(()=> {
                location.href ="/integration/accounting_account";
              });
            }
            else {
              Swal.fire({
                 type: 'error',
                 title: 'Oops... Error: '+data.status,
                 text: 'No se ha modificado',
              });
            }
          },
          error: function (err) {
            Swal.fire({
               type: 'error',
               title: 'Oops...',
               text: err.statusText,
            });
          }
        })
    }
  });
}
