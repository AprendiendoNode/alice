var permission = false;
$(function() {
  $(".select2").select2({ width: '100%' });
});
$('#select_one').on('change', function(e){
  payments_table();
});
function payments_table() {
  var objData = $('#form_bank').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/get_table_bk",
      data: objData,
      success: function (data){
        // console.log(data);
        gen_payments_table(data, $("#table_pays"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function gen_payments_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_pay);
  vartable.fnClearTable();
  if (permission) {
    $.each(datajson, function(index, status){
      vartable.fnAddData([
        status.banco,
        status.cuenta,
        status.clabe,
        status.referencia,
        status.moneda,
        status.status,
        '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.provbcoctas_id+'" class="mr-3" role="button" data-target="#modal-concept"><span class="fa fa-eye"></span></a><a href="javascript:void(0);" onclick="enviar_edit(this)" value="'+status.provbcoctas_id+'" role="button" data-target="#EditarServ"><i class="fas fa-pen-square margin-r5"></i></a>',
      ]);
    });
  }else{
    $.each(datajson, function(index, status){
      vartable.fnAddData([
        status.banco,
        status.cuenta,
        status.clabe,
        status.referencia,
        status.moneda,
        status.status,
        '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.provbcoctas_id+'" role="button" data-target="#modal-concept"><span class="fa fa-eye"></span></a>',
      ]);
    });
  }
}

function enviar_edit(e) {
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $('#reg_id_prvcta').val(valor);
  $.ajax({
      type: "POST",
      url: "/get_provbco_data",
      data: { _token : _token, id_provbco: valor },
      success: function (data){
        console.log(data);
        $('#reg_bancos').val(data[0].banco);
        $('#reg_coins').val(data[0].moneda);
        $('#reg_cuenta').val(data[0].cuenta);
        $('#reg_clabe').val(data[0].clabe);
        $('#reg_reference').val(data[0].referencia);

        $('#modal_bank').modal('show');
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function enviar(e){
      var valor= e.getAttribute('value');
      var _token = $('input[name="_token"]').val();
      swal({
        title: "Estás seguro?",
        text: "Se asignará como cuenta por default.!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Continuar.!",
        cancelButtonText: "Cancelar.!",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true,
      },
      function(isConfirm) {
        if (isConfirm) {
              $.ajax({
                  type: "POST",
                  url: "/reasign_cta_bk",
                  data: { ident: valor, _token : _token },
                  success: function (data){
                    if (data === '1') {
                      payments_table();
                      swal("Operación Completada!", ":)", "success");
                    }
                    if (data === '0') {
                      swal("Operación abortada!", "No cuenta con el permiso o esta ya se encuentra denegado :) Nota: Si la solicitud ya esta confirmada no se puede denegar", "success");
                    }
                  },
                  error: function (data) {
                    console.log('Error:', data);
                  }
              });
        }
        else {
          swal("Operación abortada", "Ningúna solicitud afectada :)", "error");
        }
      });
}
$('.btn_bank_edit').on('click', function(){
  var objData = $('#data_account_bank').find("select,textarea, input").serialize();
  swal({
    title: "Estás seguro?",
    text: "Se cambiaran pagos con esta nueva Información y no se puede revertir.!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Continuar.!",
    cancelButtonText: "Cancelar.!",
    closeOnConfirm: false,
    closeOnCancel: false,
    showLoaderOnConfirm: true,
  },
  function(isConfirm) {
    if (isConfirm) {
      $('.cancel').prop('disabled', 'disabled');
      $('.confirm').prop('disabled', 'disabled');
      $.ajax({
          type: "POST",
          url: "/edit_prov_cta",
          data: objData,
          success: function (data){
            // console.log(data);
            if (data === '1') {
              payments_table();
              swal("Operación Completada!", ":)", "success");
              $('#modal_bank').modal('toggle');
            }else{
              swal("Operación abortada!", "Revise con el administrador del sistema.", "error");
              $('#modal_bank').modal('toggle');
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
      });
    }
    else {
      swal("Operación abortada", "Ningúna solicitud afectada :)", "error");
    }
  });
});
var Configuration_table_responsive_pay= {
        "order": [[ 1, "asc" ]],
        "select": true,
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
            },
            {
                "targets": 4,
                "width": "2%",
                "className": "text-center",
            },
            {
                "targets": 5,
                "width": "0.1%",
                "className": "text-center",
            },
            {
                "targets": 6,
                "width": "0.1%",
                "className": "text-center",
            }

        ],
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
          {
            extend: 'excelHtml5',
            text: '<i class="far fa-file-excel"></i> Excel',
            titleAttr: 'Excel',
            title: function ( e, dt, node, config ) {
              var ax = '';
              if( $('#select_one').val() != ''){
                ax= 'CUENTAS DE ' + $('#select_one :selected').text();
              }
              else {
                ax= 'Sin Información';
              }
              return ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-success',
          },
          {
            extend: 'csvHtml5',
            text: '<i class="far fa-file-alt"></i> CSV',
            titleAttr: 'CSV',
            title: function ( e, dt, node, config ) {
              var ax = '';
              if( $('#select_one').val() != ''){
                ax= 'CUENTAS DE ' + $('#select_one :selected').text();
              }
              else {
                ax= 'Sin Información';
              }
              return ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-info',
          },
          {
            extend: 'pdf',
            text: '<i class="far fa-file-pdf"></i>  PDF',
            title: function ( e, dt, node, config ) {
              var ax = '';
              if( $('#select_one').val() != ''){
                ax= 'CUENTAS DE ' + $('#select_one :selected').text();
              }
              else {
                ax= 'Sin Información';
              }
              return ax;
            },
            init: function(api, node, config) {
               $(node).removeClass('btn-default')
            },
            exportOptions: {
                columns: [ 0,1,2,3,4,5 ],
                modifier: {
                    page: 'all',
                }
            },
            className: 'btn btn-danger',
          }
        ],
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
            },
            'select': {
                'rows': {
                    _: "%d Filas seleccionadas",
                    0: "Haga clic en una fila para seleccionarla",
                    1: "Fila seleccionada 1"
                }
            }
        },
};
