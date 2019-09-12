$(function() {
  $(".select2").select2();
  $('#date_to_search').datepicker({
    language: 'es',
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months",
    endDate: '1m',
    autoclose: true,
    clearBtn: true
  });
  /*$('.pickerTab').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    viewMode: "days",
    minViewMode: "days",
    //endDate: '1m',
    autoclose: true,
    clearBtn: true
  });*/
  $('#date_to_search').val('').datepicker('update');

  $('.input-daterange').datepicker({language: 'es', format: "yyyy-mm-dd",});
  var now = moment();
  var monday = now.clone().weekday(1).format("YYYY-MM-DD");
  var friday = now.clone().weekday(5).format("YYYY-MM-DD");
  // var isNowWeekday = now.isBetween(monday, friday, null, '[]');
  $('#date_start').val(monday);
  $('#date_end').val(friday);

  payments_program_table_period();
  payments_confirm_sumas(2);
});

$('#boton-aplica-filtro').on('click', function(){
  payments_program_table();
  payments_confirm_sumas(1);
});

$('#boton-aplica-periodo').on('click', function(){
  payments_program_table_period();
  payments_confirm_sumas(2);
});

function payments_program_table() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/get_confirm_pay_table",
      data: objData,
      success: function (data){
        // console.log(data);
        gen_program_payments_auto_table(data, $("#table_program"));
        /*$('#table_program').find(".pickerTab").datepicker({
          language: 'es',
          format: "yyyy-mm-dd",
          viewMode: "days",
          minViewMode: "days",
          //endDate: '1m',
          autoclose: true,
          clearBtn: true
        });*/
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function payments_program_table_period() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/get_confirm_pay_table_period",
      data: objData,
      success: function (data){
        // console.log(data);
        gen_program_payments_auto_table(data, $("#table_program"));
        /*$('#table_program').find(".pickerTab").datepicker({
          language: 'es',
          format: "yyyy-mm-dd",
          viewMode: "days",
          minViewMode: "days",
          //endDate: '1m',
          autoclose: true,
          clearBtn: true
        });*/
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function payments_confirm_sumas(operation) {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  if (operation === 1) {
    $.ajax({
      type: "POST",
      url: "/get_confirm_pay_table_sums",
      data: objData + '&operation=1',
      success: function (data){
        // console.log(data);
        if (data != '' && data != '[]') {
          // var data_new = JSON.parse(data);
          if (!data[0].suma_MXN) {
            // $('#total_cobr').val(0);
            $('#total_pay_mxn').val(0);
            $('#total_pay_usd').val(0);
          }
          else {
            $('#total_pay_mxn').val(data[0].suma_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#total_pay_usd').val(data[0].suma_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
          }
        }
        else {
            $('#total_pay_mxn').val(0);
            $('#total_pay_usd').val(0);
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }else{
    $.ajax({
        type: "POST",
        url: "/get_confirm_pay_table_sums",
        data: objData + '&operation=2',
        success: function (data){
          // console.log(data);
          if (data != '' && data != '[]') {
            // var data_new = JSON.parse(data);
            if (!data[0].suma_MXN) {
              // $('#total_cobr').val(0);
              $('#total_pay_mxn').val(0);
              $('#total_pay_usd').val(0);
            }
            else {
              $('#total_pay_mxn').val(data[0].suma_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
              $('#total_pay_usd').val(data[0].suma_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
          }
          else {
              $('#total_pay_mxn').val(0);
              $('#total_pay_usd').val(0);
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
  }
}

function gen_program_payments_auto_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_checkbox_move_payment_n3);
  vartable.fnClearTable();
  //console.log(datajson);
  //'<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span><input type="text" class="form-control pickerTab" style="width: 100%;" name="data_table"></div>',
  $.each(datajson, function(index, status){
    vartable.fnAddData([
        status.id,
        status.poliza,
        status.factura,
        status.proveedor,
        '<span class="badge badge-primary">'+status.estatus+'</span>',
        status.elaboro,
        iniciales_status(status.autorizo),
        //status.autorizo,
        status.date_limit,
        status.tipo_gasto + ' - ' + status.key_cc,
        status.tipo_proveedor,
        status.amount,
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
          //console.log('rowdata: ' + rowData[12]);
          switch(rowData[12]){
            case 'Autorizo':
              this.api().cell(td).checkboxes.enable();
              break;
            case 'Programado':
              this.api().cell(td).checkboxes.enable();
              break;
            default:
              this.api().cell(td).checkboxes.disable();
          }
        }
      }
    },
    {
      "targets": 1,
      "width": "0.2%",
      "className": "text-center",
      "visible": false,
    },
    {
      "targets": 2,
      "width": "0.2%",
      "className": "text-center",
    },
    {
      "targets": 3,
      "width": "0.2%",
      "className": "text-center",
    },
    {
      "targets": 4,
      "width": "0.2%",
      "className": "text-center",
    },
    {
      "targets": 5,
      "width": "0.2%",
      "className": "text-center",
      "visible": false,
    },
    {
      "targets": 6,
      "width": "0.2%",
      "className": "text-center",
    },
    {
      "targets": 7,
      "width": "0.2%",
      "className": "text-center",
    },
    {
      "targets": 8,
      "width": "0.2%",
      "className": "text-center",
    },
    {
      "targets": 9,
      "width": "0.2%",
      "className": "text-center",
      "visible": false,
      "searchable": false
    },
    {
      "targets": 10,
      "width": "0.2%",
      "className": "text-center",
    },
    {
      "targets": 11,
      "width": "0.1%",
      "className": "text-center",
    },
    {
      "targets": 12,
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
      text: '<i class="fa fa-check margin-r5"></i> Confirmar(pago) Marcados',
      titleAttr: 'Confirmar(pago) Marcados',
      className: 'btn bg-navy',
      init: function(api, node, config) {
        $(node).removeClass('btn-default')
      },
      action: function ( e, dt, node, config ) {
        // $('#modal-confirmation').modal('show');
        var rows_selected = $("#table_program").DataTable().column(0).checkboxes.selected();
        var _token = $('input[name="_token"]').val();
        // Iterate over all selected checkboxes
        var valores= new Array();
        // console.log(factura);
        $.each(rows_selected, function(index, rowId){
          valores.push(rowId);
        });
        console.log(valores);

        if (valores.length === 0){
          Swal.fire("Operación abortada", "Ningún registro seleccionado :(", "error");
        }else if(valores.length > 1){ // mas de un pago.
          Swal.fire({
            title: "¿Estás seguro?",
            html: "Se confirmarán de pago todos los registros seleccionados!"+
            "<br><br><div><label>Fecha de cobro: </label><input style='display: block;' class='datepicker form-control' type='text' placeholder='Fecha del cobro' id='fecha_cobro'></div>"+
            "<div><label>Banco: </label><select class='form-control' style='display: block;' id='banco'></select></div>",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
            customClass: 'swal-wide'
          }).then((result) => {
            if(result.value){
              var fecha_cobro = $('#fecha_cobro').val();
              var banco = $('#banco').val();
              // console.log(semana);
              $('.cancel').prop('disabled', 'disabled');
              $('.confirm').prop('disabled', 'disabled');

              if(fecha_cobro === ''){
                Swal.fire("Operación abortada", "Debe seleccionar la fecha del cobro.", "error")
              }else if(banco === ''){
                Swal.fire("Operación abortada", "Debe elegir un banco.", "error")
              }else{
                $.ajax({
                  type: "POST",
                  url: "/send_item_pay_authorized",
                  data: { idents: JSON.stringify(valores), fecha_cobro: fecha_cobro, banco: banco, operacion: 0, _token : _token },
                  success: function (data){
                    console.log(data);
                    Swal.fire("Operación abortada!", "Las solicitudes seleccionadas no han sido afectadas.", "error");
                    if (data === 'true') {
                      Swal.fire("Operación Completada!", "Las solicitudes seleccionadas han sido confirmadas.", "success");
                        payments_program_table_period();
                        payments_confirm_sumas(2);

                    }
                    if (data === 'false') {
                      Swal.fire("Operación abortada!", "Las solicitudes seleccionadas no han sido afectadas.", "error");
                        payments_program_table_period();
                        payments_confirm_sumas(2);
                    }
                  },
                  error: function (data) {
                    console.log('Error:', data);
                  }
                });
              }
            }
          })


          $(".swal-wide").scrollTop(0);
          var $options = $("#aux > option").clone();
          $('#banco').append($options);
          $('.datepicker').datepicker({
            language: 'es',
            format: "yyyy-mm-dd",
            viewMode: "days",
            minViewMode: "days",
            //endDate: '1m',
            autoclose: true,
            clearBtn: true
          });
        }else{ // solo un pago.
          //funcion ajax para traer de vuelta la factura.
          $.ajax({
              type: "POST",
              url: "/get_fact_idpay",
              data: { id_payment: valores[0] , _token : _token,  },
              success: function (data){
                // console.log(data);
                if (data[0].pay_status_fact_id == 3) {
                  $('#factura').val(data[0].factura);
                  $("#factura").prop('disabled', true);
                }else{
                  $('#factura').val(data[0].factura);
                  $("#factura").prop('disabled', false);
                }
                $('#aux_fact').val(data[0].pay_status_fact_id);
              },
              error: function (data) {
                console.log('Error:', data);
              }
          });

          Swal.fire({
            title: "¿Estás seguro?",
            html: "Se confirmarán de pago todos los registros seleccionados!"+
            "<br><br><div><label>Fecha de cobro: </label><input style='display: block;' class='datepicker' type='text' placeholder='Fecha del cobro' id='fecha_cobro'></div>"+
            "<div><label>Banco: </label><select class='form-control' style='display: block;' id='banco'></select></div>"+
            "<br><div><label>Factura: </label><input style='display: block;' type='text' placeholder='No. de factura' id='factura'></div>",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
            customClass: 'swal-wide'
          }).then((result) => {
            if(result.value){
              var fecha_cobro = $('#fecha_cobro').val();
              var banco = $('#banco').val();
              var factura = $('#factura').val();
              // console.log(semana);
              $('.cancel').prop('disabled', 'disabled');
              $('.confirm').prop('disabled', 'disabled');

              if(fecha_cobro === ''){
                Swal.fire("Operación abortada", "Debe seleccionar la fecha del cobro.", "error")
              }else if(banco === ''){
                Swal.fire("Operación abortada", "Debe elegir un banco.", "error")
              }else if(factura === ''){
                Swal.fire("Operación abortada", "Debe ingresar una factura.", "error")
              }else{
                $.ajax({
                  type: "POST",
                  url: "/send_item_pay_authorized",
                  data: { idents: JSON.stringify(valores), fecha_cobro: fecha_cobro, banco: banco, factura: factura , operacion: 1 , _token : _token },
                  success: function (data){
                    console.log(data);
                    if (data === 'true') {
                      Swal.fire("Operación Completada!", "Las solicitudes seleccionadas han sido confirmadas.", "success");
                        payments_program_table_period();
                        payments_confirm_sumas(2);
                    }
                    if (data === 'false') {
                      Swal.fire("Operación abortada!", "Las solicitudes seleccionadas no han sido afectadas.", "error");
                        payments_program_table_period();
                        payments_confirm_sumas(2);
                    }
                  },
                  error: function (data) {
                    console.log('Error:', data);
                  }
                });
              }
            }
          })

          $(".swal-wide").scrollTop(0);
          var $options = $("#aux > option").clone();
          $('#banco').append($options);
          // $('#factura').val(name_fact);
          $('.datepicker').datepicker({
            language: 'es',
            format: "yyyy-mm-dd",
            viewMode: "days",
            minViewMode: "days",
            //endDate: '1m',
            autoclose: true,
            clearBtn: true
          });
        }
      }
    },
    {
      extend: 'excelHtml5',
      text: '<i class="fas fa-file-excel"></i>Excel',
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
        return 'Programaciones de pago '+ax;
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
      text: '<i class="fas fa-file-csv"></i>CSV',
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
        return 'Programaciones de pago '+ax;
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
      text: '<i class="fas fa-file-pdf"></i>PDF',
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
        return 'Programaciones de pago '+ax;
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
function iniciales_status(status) {
  if (!status) {
    return 'Sin autorizar.'
  }
  var abreviado_full = "";
  var arrStatus = status.split(' ');
  var cont = arrStatus.length;
  if (isEven(cont)) {
    abreviado_full = abreviado_full + arrStatus[2].charAt(0) + '.' + arrStatus[3].charAt(0) + '.' + arrStatus[0].charAt(0) + '.' + arrStatus[1].charAt(0) + '.';
  }else{
    abreviado_full = abreviado_full + arrStatus[2].charAt(0) + '.' + arrStatus[0].charAt(0) + '.' + arrStatus[1].charAt(0) + '.';
  }
  return abreviado_full;
}
function isEven(n) {
   return n % 2 == 0;
}
function isOdd(n) {
   return Math.abs(n % 2) == 1;
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
    cancelButtonText: "Cancelar!"
  }).then((result) => {
    if(result.value){
      var comment = $('#comentario').val();
      $.ajax({
          type: "POST",
          url: "/deny_payment",
          data: { idents: valor, comm: comment, _token : _token },
          success: function (data){
            if (data === 'true') {
              Swal.fire("Operación Completada!", "La solicitud ha sido denegado.", "success");
              //payments_auto_table();
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
function enviarP(e) {
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "/get_date_pay_program",
    data: { id_payment: valor, _token : _token},
    success: function (data){
      console.log(data);
      if (data[0].date_scheduled_pay != null) {
        $("#programmed_date").val(data[0].date_scheduled_pay);
      }else{
        $("#programmed_date").val('Sin fecha programada');
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
  $('#modal-view-program').modal('show');
  $('#hidden_viatic').val(valor);
}
$('#program_date_p').on('click', function(){
  //var valor= e.getAttribute('value');
  var valor= $('#hidden_viatic').val();
  var _token = $('input[name="_token"]').val();
  var schedule = $('#schedule_date').val();
  if (schedule != '') {
    $.ajax({
      type: "POST",
      url: "/send_item_pay_program",
      data: { idents: valor, _token : _token, schedule: schedule},
      success: function (data){
        console.log(data);
        if (data === 'true') {
          swal("Operación Completada!", "El pago ha sido programado.", "success");
          payments_program_table()
          $('#schedule_date').val('');
          $('#modal-view-program').modal('hide');
        }else{
          swal("Operación abortada!", "No se realizo ningun cambio.", "error");
          $('#schedule_date').val('');
          $('#modal-view-program').modal('hide');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }else{
    swal("Operación abortada!", "Seleccione una fecha para programar pago.", "error");
  }
});
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
