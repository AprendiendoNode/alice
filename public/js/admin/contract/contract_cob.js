var token = $('input[name="_token"]').val();
$(function(){
  // mont_facturar();
  // mont_cobrar();
  // mens_tb(token);
  //
  //
  //
  //mont_facturar();
  mont_cobrar();
  mens_tb_all(token);
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
}());

  $("#boton-aplica-filtro").click(function(event) {
    var objData = $('#search_info').find("select,textarea, input").serialize();
    $.ajax({
      type: "POST",
      url: "/recordmens_cobs_date",
      data: objData,
      success: function (data){
        generate_table(data, $("#mens_table"));
        mont_facturar();
        mont_cobrar();
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });

function mens_tb(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/recordmens_cobs",
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
  // var _token = token;
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/recordmens_cobs_all",
      // data: { _token : _token },
      data: objData,
      success: function (data){
        generate_table(data, $("#mens_table"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function mont_cobrar() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/cxc_mont_cob",
      data: objData,
      success: function (data){
        console.log(data);
        if (data != '' && data != '[]') {
          var data_new = JSON.parse(data);
          if (!data_new[0].suma) {
            // $('#total_cobr').val(0);
            $('#total_cobr_mxn').val(0);
            $('#total_cobr_usd').val(0);
          }
          else {
            // $('#total_cobr').val(data_new[0].suma.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#total_cobr_mxn').val(data_new[0].suma_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#total_cobr_usd').val(data_new[0].suma_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
          }
        }
        else {
          $('#total_cobr_mxn').val(0);
          $('#total_cobr_usd').val(0);
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function mont_facturar() {
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/cxc_mont_fact",
      data: objData,
      success: function (data){
        if (data != '' && data != '[]') {
          var data_new = JSON.parse(data);
          if (!data_new[0].suma) {
            $('#total_mxn').val(0);
            $('#total_cobr').val(0);
          }
          else{
            $('#total_mxn').val(data_new[0].suma_MXN.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#total_cobr').val(data_new[0].suma_USD.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
          }
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
      Filter: true,
      searching: true,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      autoWidth: true,
      /*
      "select": true,
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
      ],
      "select": {
          'style': 'multi',
      },
      */
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
        data.num_mes_actual,
        data.num_mes_saldo,
        data.num_mes_total,
        data.date_real,
        data.date_final,
        data.fecha_cobro_semana,
        data.fecha_vencimineto,
        data.fecha_compromiso,
        data.fecha_factura,
        data.currencies,
        data.mensualidad_civa.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
        data.monto_final.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
      ]);
  });
  document.getElementById("mens_table_wrapper").setAttribute("class", "dataTables_wrapper form-inline dt-bootstrap4 no-footer");
  document.getElementById("mens_table_wrapper").childNodes[0].style.width = "100%";
}

$(".reload_table").click(function () {
  mens_tb_all(token);
  swal("Operación Completada!", ":)", "success");
});
