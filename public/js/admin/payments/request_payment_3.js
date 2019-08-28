$(".btn-aprobar").click(function(event) {
  swal({
    title: "Estás seguro?",
    text: "Se aprobarán la solicitud seleccionada.!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Continuar.!",
    cancelButtonText: "Cancelar.!",
    closeOnConfirm: false,
    closeOnCancel: false
  },
  function(isConfirm) {
    if (isConfirm) {
      var _token = $('input[name="_token"]').val();
      // Iterate over all selected checkboxes
      $.ajax({
          type: "POST",
          url: "/send_item_pay_authorized_indv",
          data: { idents: $("#id_xs").val(), _token : _token },
          success: function (data){
            console.log(data);
            if (data === '0') {
              $('#modal-view-concept').modal('toggle');
              swal("Operación abortada!", "La solicitud no esta aprobada por los niveles anteriores.", "error");
            }
            if (data === '1') {
              swal("Operación Completada!", "La solicitud han sido aprobada.", "success");
              payments_conf_table();
              $('#modal-view-concept').modal('toggle');
            }
            if (data === '2') {
              $('#modal-view-concept').modal('toggle');
              swal("Operación abortada!", "La solicitud ya esta aprobada.", "error");
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
      });
    } else {
      swal("Operación abortada", "Ningúna solicitud de pago afectada :)", "error");
    }
  });
});

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
  payments_conf_table();
});

$("#boton-aplica-filtro").click(function(event) {
  payments_conf_table();
});

function payments_conf_table() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/view_request_pay_zero",
      data: objData,
      success: function (data){
        gen_payments_conf_table(data, $("#table_pays"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function gen_payments_conf_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_checkbox_move_payment_n3);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
    vartable.fnAddData([
        status.id,
        status.factura,
        status.proveedor,
        '<span class="badge badge-primary badge-pill">'+status.estatus+'</span>',
        status.elaboro,
        status.monto_str,
        status.fecha_solicitud,
        status.fecha_limite,
        '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" class="btn btn-default btn-xs" role="button" data-target="#modal-concept"><span class="fa fa-eye"></span></a><a href="javascript:void(0);" onclick="enviartwo(this)" value="'+status.id+'" class="btn btn-danger btn-xs" role="button" data-target="#modal-deny" title="Denegar pago"><span class="fa fa-ban"></span></a>',
        status.estatus
      ]);
  });
}

var Configuration_table_responsive_checkbox_move_payment_n3= {
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
        if ( cellData > 0 ) {
          if(rowData[9] != 'Autorizo'){
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
      text: '<i class="fa fa-check margin-r5"></i> Confirmar pago Marcados',
      titleAttr: 'Confirmar pago Marcados',
      className: 'btn bg-navy',
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      action: function ( e, dt, node, config ) {
        // $('#modal-confirmation').modal('show');
        swal({
          title: "Estás seguro?",
          text: "Se Confirmar pago de todas las solicitudes seleccionadas.!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Continuar.!",
          cancelButtonText: "Cancelar.!",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm) {
          if (isConfirm) {
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
              swal("Operación abortada", "Ningúna solicitud de pago seleccionada :(", "error");
            }
            else {
              $.ajax({
                type: "POST",
                url: "/send_item_pay_authorized",
                data: { idents: JSON.stringify(valores), _token : _token },
                success: function (data){
                  //console.log(data);
                  if (data === 'true') {
                    swal("Operación Completada!", "Las solicitudes seleccionadas han sido afectadas.", "success");
                    payments_conf_table();
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

          } else {
            swal("Operación abortada", "Ningúna solicitud de pago afectada :)", "error");
          }
        });
      }
    },
    {
      extend: 'excelHtml5',
      text: '<i class="fa fa-file-excel-o"></i> Excel',
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
      text: '<i class="fa fa-file-text-o"></i> CSV',
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
      text: '<i class="fa fa-file-pdf-o"></i>  PDF',
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
$('.btn-export').on('click', function(){
    $("#captura_table_general").hide();

    $(".hojitha").css("border", "");
    html2canvas(document.getElementById("captura_pdf_general")).then(function(canvas) {
      var ctx = canvas.getContext('2d');
      ctx.rect(0, 0, canvas.width, canvas.height);
          var imgData = canvas.toDataURL("image/jpeg", 1.0);
          var correccion_landscape = 0;
          var correccion_portrait = 0;
          if(canvas.height > canvas.width) {
              var orientation = 'portrait';
              correccion_portrait = 1;
              correccion_landscape = 0;
              var imageratio = canvas.height/canvas.width;
          }
          else {
              var orientation = 'landscape';
              correccion_landscape = 0;
              correccion_portrait = 0;
              var imageratio = canvas.width/canvas.height;
          }
          if(canvas.height < 900) {
              fontsize = 16;
          }
          else if(canvas.height < 2300) {
              fontsize = 11;
          }
          else {
              fontsize = 6;
          }

          var margen = 0;//pulgadas

          // console.log(canvas.width);
          // console.log(canvas.height);

         var pdf  = new jsPDF({
                      orientation: orientation,
                      unit: 'in',
                      format: [16+correccion_portrait, (16/imageratio)+margen+correccion_landscape]
                    });

          var widthpdf = pdf.internal.pageSize.width;
          var heightpdf = pdf.internal.pageSize.height;
          pdf.addImage(imgData, 'JPEG', 0, margen, widthpdf, heightpdf-margen);
          pdf.save("Solicitud de pago.pdf");
          $(".hojitha").css("border", "1px solid #ccc");
          $(".hojitha").css("border-bottom-style", "hidden");
    });
  });
