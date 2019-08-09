var token = $('input[name="_token"]').val();
$(function(){
  // mens_tb(token);
  $('.input-daterange').datepicker({language: 'es', format: "yyyy-mm-dd",});
  var now = moment();
  var monday = now.clone().weekday(1).format("YYYY-MM-DD");
  var friday = now.clone().weekday(5).format("YYYY-MM-DD");
  // var isNowWeekday = now.isBetween(monday, friday, null, '[]');
  $('#date_start').val(monday);
  $('#date_end').val(friday);
  // console.log(monday);
  // console.log(friday);
  // console.log(`is now between monday and friday: ${isNowWeekday}`);
  //mont_facturar(token);
  //mens_tb_all(token);
  //mont_facturar_all(token);
}());

$("#boton-aplica-filtro").click(function(event) {
  mont_facturar_all(token);
  mens_tb_all(token);
});

function mens_tb(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/recordmens_fact",
      data: { _token : _token },
      success: function (data){
        generate_table(data, $("#mens_table"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function mens_tb_all(token) {
  var _token = token;
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/recordmens_fact_all",
      data: objData,
      success: function (data){
        generate_table(data, $("#mens_table"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function mont_facturar_all(token) {
  var _token = token;
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/cxc_mont_fact_uniq_all",
      data: objData,
      success: function (data){
        console.log(data);
        if (data != '' && data != '[]') {
          var data_new = JSON.parse(data);
          if (!data_new[0].suma) {
            $('#total_mxn').val(0);
            $('#total_usd').val(0);
          }else{
            $('#total_mxn').val(data_new[0].suma_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#total_usd').val(data_new[0].suma_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
          }
        }
        else {
          $('#total_mxn').val(0);
          $('#total_usd').val(0);
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function mont_facturar(token) {
  var _token = token;
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/cxc_mont_fact_uniq",
      data: objData,
      success: function (data){
        console.log(data);
        if (data != '' && data != '[]' || data != null) {
          var data_new = JSON.parse(data);
          $('#total_mxn').val(data_new[0].suma.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }
        else {
          $('#total_mxn').val(0);
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function generate_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable({
      "order": [[ 0, "asc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "select": true,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "columnDefs": [
          {
            "targets": 0,
            "checkboxes": {
              'selectRow': true
            },
            "width": "1%",
            "createdCell": function (td, cellData, rowData, row, col){

            }
          },
          // {
          //     "type": "html",
          //     "targets": [5,11,12,13,14,15,16,17,18],
          // }
      ],
      "select": {
          'style': 'multi',
      },
      //ordering: false,
      //"pageLength": 5,
      dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          extend: 'excelHtml5',
          text: '<i class="far fa-file-excel"></i> Excel',
          titleAttr: 'Excel',
          title: function ( e, dt, node, config ) {
            return 'Reporte de mensualidades';
          },
          init: function(api, node, config) {
             $(node).removeClass('btn-default')
          },
          className: 'btn btn-success custombtntable aux',
        },
        {
          text: '<i class="fa fa-check margin-r5"></i> Confirmar cobro.',
          titleAttr: 'Confirmar cobro.',
          className: 'btn btn-warning aux',
          init: function(api, node, config) {
            $(node).removeClass('btn-default')
          },
          action: function ( e, dt, node, config ) {
            // $('#modal-confirmation').modal('show');
            swal({
              title: "¿Estás seguro?",
              text: "Se confirmarán de pago todos los registros seleccionados!"+
              "<br><br><div><label>Fecha de cobro: </label><input style='display: block;' class='datepicker' type='text' placeholder='Fecha del cobro' id='fecha_cobro'></div>"+
              "<div><label>Banco: </label><select class='form-control' style='display: block;' id='banco'></select></div>"+
              "<br><div><label>Factura: </label><input style='display: block;' type='text' placeholder='No. de factura' id='factura'></div>",
              type: "warning",
              html: true,
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Continuar",
              cancelButtonText: "Cancelar",
              closeOnConfirm: false,
              closeOnCancel: false,
              customClass: 'swal-wide'
            },

            function(isConfirm) {
              if (isConfirm != "") {
                var fecha_cobro = $('#fecha_cobro').val();
                var banco = $('#banco').val();
                var factura = $('#factura').val();
                // console.log(semana);
                $('.cancel').prop('disabled', 'disabled');
                $('.confirm').prop('disabled', 'disabled');
                var rows_selected = $("#mens_table").DataTable().column(0).checkboxes.selected();
                var _token = $('input[name="_token"]').val();
                // Iterate over all selected checkboxes
                var valores= new Array();
                // console.log(factura);
                $.each(rows_selected, function(index, rowId){
                  valores.push(rowId);
                });
                console.log(valores);
                if (valores.length === 0){
                  swal("Operación abortada", "Ningún registro seleccionado :(", "error");
                }else if(fecha_cobro === ''){
                  swal("Operación abortada", "Debe seleccionar la fecha del cobro.", "error")
                }else if(banco === ''){
                  swal("Operación abortada", "Debe elegir un banco.", "error")
                }else if(factura === ''){
                  swal("Operación abortada", "Debe ingresar una factura.", "error")
                }
                else{
                  $.ajax({
                    type: "POST",
                    url: "/send_contracts_confirm",
                    data: { idents: JSON.stringify(valores), fecha_cobro: fecha_cobro, banco: banco, factura: factura , _token : _token },
                    success: function (data){
                      console.log(data);
                      if (data === '1') {
                        swal("Operación Completada!", "Los registros seleccionados han sido afectados.", "success");
                        mens_tb_all(token);
                      }else {
                        swal("Operación abortada!", "Los registros seleccionados no han sido afectados.", "error");
                        mens_tb_all(token);
                      }
                    },
                    error: function (data) {
                      console.log('Error:', data);
                    }
                  });


                }

              } else {
                swal("Operación abortada", "Ningun registro afectado", "error");
              }
            });
            $(".swal-wide").scrollTop(0);
            var $options = $("#aux > option").clone();
            $('#banco').append($options);
            $( ".datepicker" ).datepicker();
          }
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
            }
    }
    }
  );
  vartable.fnClearTable();
  // console.log(datajson);
  $.each(JSON.parse(datajson), function(index, data){
    vartable.fnAddData([
        data.id,
        data.cxclassification,
        data.vertical,
        data.cadena,
        data.key,
        data.concepto_sat,
        //'<a href="javascript:void(0);" id="conc_'+data.id+'" name="conc_'+data.id+'" data-type="select" data-pk="'+ data.id + '" data-url="" data-title="Cambiar concepto" data-value="'+ data.concepto+'" class="editable_concept"></a>',
        data.num_mes_actual,
        data.num_mes_saldo,
        data.num_mes_total,
        data.date_real,
        data.date_final,
        data.fecha_cobro,
        data.fecha_vencimineto,
        data.fecha_compromiso,
        data.fecha_factura,
        data.currencies,
        // data.monto,
        // data.descuento,
        // data.subtotal,
        // data.iva_value,
        data.mensualidad_civa.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
        // data.exchange_range_value,
        data.monto_final.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
        //'<a href="javascript:void(0);" onclick="adelete(this)" value="'+data.id+'" class="btn btn-danger btn-xs" role="button" data-target="#modal-deny" title="Eliminar"><span class="fa fa-trash-o"></span></a>',
      ]);
  });
  document.getElementById("mens_table_wrapper").setAttribute("class", "dataTables_wrapper form-inline dt-bootstrap4 no-footer");
  document.getElementById("mens_table_wrapper").childNodes[0].style.width = "100%";
}
function getSelectStatus() {
    var valorsiro = "";
    return $.ajax({
        type: "POST",
        url: "/get_contract_status",
        data: { _token : token },
        //async: false,
        success: function (data){
          valorsiro = data;
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });
}

$(".reload_table").click(function () {
  mens_tb(token);
  swal("Operación Completada!", ":)", "success");
});
