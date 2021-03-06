$(function() {
  moment.locale('es');
  $('#date_to_search').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '1m',
    autoclose: true,
    clearBtn: true
  });
  $('#date_to_search').val('').datepicker('update');
  payments_table();
});

$("#boton-aplica-filtro").click(function(event) {
  payments_table();
});

function payments_table() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/view_request_pay_zero",
      data: objData,
      success: function (data){
        gen_payments_table(data, $("#table_pays"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

var Configuration_table_responsive_checkbox_move_payment_n1= {
  "order": [[ 1, "asc" ]],
  "select": true,
  "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
  "columnDefs": [
    { //Subida 1
      "targets": 0,
      "checkboxes": {
        'selectRow': true
      },
      "width": "0.2%",
      "createdCell": function (td, cellData, rowData, row, col){
        if ( cellData > 1 ) {
          if(rowData[9] != 'Elaboro'){
            this.api().cell(td).checkboxes.disable();
          }
        }
      }
    },
    {
      "targets": 1,
      "width": "0.5%",
      "className": "text-center",
    },
    {
      "targets": 2,
      "width": "1%",
      "className": "text-center",
    },
    {
      "targets": 3,
      "width": "0.2%",
      "className": "text-center",
    },
    {
      "targets": 4,
      "width": "1%",
      "className": "text-center",
    },
    {
      "targets": 5,
      "width": "1%",
      "className": "text-center",
    },
    {
      "targets": 6,
      "width": "0.3%",
      "className": "text-center",
    },
    {
      "targets": 7,
      "width": "0.5%",
      "className": "text-center",
    },
    {
      "targets": 8,
      "width": "0.1%",
      "className": "text-center",
    },
    {
      "targets": 9,
      "visible": false,
      "searchable": false
    }
  ],
  "select": {
    'style': 'multi',
  },
  dom: "<'row'<'col-sm-6'B><'col-sm-2'l><'col-sm-4'f>>" +
  "<'row'<'col-sm-12'tr>>" +
  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
  buttons: [
    {
      text: '<i class="fa fa-check margin-r5"></i> Revisar Marcados',
      titleAttr: 'Revisar Marcados',
      className: 'btn btn-warning',
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      action: function ( e, dt, node, config ) {
        // $('#modal-confirmation').modal('show');
        Swal.fire({
          title: "¿Estás seguro?",
          text: "Se revisarán todos las solicitudes seleccionadas!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Continuar",
          cancelButtonText: "Cancelar!"
        }).then((result) => {
          if(result.value){
            $('.cancel').prop('disabled', 'disabled');
            $('.confirm').prop('disabled', 'disabled');
            var rows_selected = $("#table_pays").DataTable().column(0).checkboxes.selected();
            var _token = $('input[name="_token"]').val();
            // Iterate over all selected checkboxes
            var valores= new Array();
            $.each(rows_selected, function(index, rowId){
              valores.push(rowId);
            });
            if ( valores.length === 0){
              Swal.fire("Operación abortada", "Ningúna solicitud de pago seleccionada :(", "error");
            }
            else {
              $.ajax({
                type: "POST",
                url: "/send_item_pay_new",
                data: { idents: JSON.stringify(valores), _token : _token },
                success: function (data){
                  if (data === 'true') {
                    Swal.fire("Operación Completada!", "Las solicitudes seleccionadas han sido afectadas.", "success");
                    payments_table();
                  }
                  if (data === 'false') {
                    swal("Operación abortada!", "Las solicitudes seleccionadas no han sido afectadas.", "error");
                  }
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });
            }
          }
        })
      }
    },
    {
      extend: 'excelHtml5',
      text: '<i class="far fa-file-excel"></i> Excel',
      titleAttr: 'Excel',
      title: function ( e, dt, node, config ) {
        var ax = '';
        if($('input[name="date_to_search"]').val() != ''){
          ax= '- Periodo: ' + $('input[name="date_to_search"]').val();
        }
        else {
          txx='- Periodo: ';
          var fecha = new Date();
          var ano = fecha.getFullYear();
          var mes = fecha.getMonth()+1;
          var fechita = ano+'-'+mes;
          ax = txx+fechita;
        }
        return 'Historial de pago '+ax;
      },
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      exportOptions: {
        columns: [ 1,2,3,4,5,6 ],
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
        if($('input[name="date_to_search"]').val() != ''){
          ax= '- Periodo: ' + $('input[name="date_to_search"]').val();
        }
        else {
          txx='- Periodo: ';
          var fecha = new Date();
          var ano = fecha.getFullYear();
          var mes = fecha.getMonth()+1;
          var fechita = ano+'-'+mes;
          ax = txx+fechita;
        }
        return 'Historial de pago '+ax;
      },
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      exportOptions: {
        columns: [ 1,2,3,4,5,6 ],
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
        if($('input[name="date_to_search"]').val() != ''){
          ax= '- Periodo: ' + $('input[name="date_to_search"]').val();
        }
        else {
          txx='- Periodo: ';
          var fecha = new Date();
          var ano = fecha.getFullYear();
          var mes = fecha.getMonth()+1;
          var fechita = ano+'-'+mes;
          ax = txx+fechita;
        }
        return 'Historial de pago '+ax;
      },
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      exportOptions: {
        columns: [ 1,2,3,4,5,6 ],
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

function gen_payments_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_checkbox_move_payment_n1);
  vartable.fnClearTable();
  console.log(datajson);
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
        status.id,
        status.factura,
        status.proveedor,
        '<span class="badge badge-primary badge-pill px-1 text-white">'+status.estatus+'</span>',
        status.elaboro,
        status.monto_str,
        status.fecha_solicitud,
        status.fecha_limite,
        '<a href="javascript:void(0);" onclick="enviar(this, false)" value="'+status.id+'" class="btn btn-default btn-xs" role="button" data-target="#modal-concept"><span class="fa fa-eye"></span></a><a href="javascript:void(0);" onclick="enviartwo(this)" value="'+status.id+'" class="btn btn-danger btn-xs" role="button" data-target="#modal-deny" title="Denegar pago"><span class="fa fa-ban"></span></a>'+
        (puedeEditar ? '<a href="javascript:void(0);" onclick="enviar(this, true)" value="'+status.id+'" class="btn btn-default btn-sm" role="button" data-target="#modal-concept"><span class="fas fa-edit"></span></a>' : ''),
        status.estatus
      ]);
  });
}

function enviartwo(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();

  Swal.fire({
    title: "¿Estás seguro?",
    html: "Se denegara la solicitud.!<br><br><textarea rows='3' placeholder='Añadir comentario' class='form-control' id='comentario'></textarea>",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Continuar",
    cancelButtonText: "Cancelar!",
  }).then((result) => {
    var comment = $('#comentario').val();
    if (comment === "") {
      Swal.fire("Operación abortada!", "Añada un comentario de denegación.", "error");
    }else{
      $.ajax({
          type: "POST",
          url: "/deny_payment",
          data: { idents: valor, comm: comment, _token : _token },
          success: function (data){
            if (data === 'true') {
              Swal.fire("Operación Completada!", "La solicitud ha sido denegado.", "success");
              payments_table();
            }
            if (data === 'false') {
              Swal.fire("Operación abortada!", "No cuenta con el permiso o esta ya se encuentra denegado :) Nota: Si la solicitud ya esta confirmada no se puede denegar", "error");
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
      });
    }
  })

}
