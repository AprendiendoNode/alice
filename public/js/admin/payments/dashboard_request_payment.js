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

  var _token = $('input[name="_token"]').val();
  var fecha = $('#date_to_search').val();
  function_data_pral(fecha, _token);
  graph_waypay(fecha, _token);
  graph_current(fecha, _token);
  //table_expense(fecha, _token);
  graph_expense_six_per_month(fecha, _token);
});

function function_data_pral(campoa, campob) {
  $.ajax({
    type: "POST",
    url: "/search_data_payment_genral",
    data: { date : campoa , _token : campob },
    success: function (data){
      datax = JSON.parse(data);
      console.log(datax);
      $("#sol_a").text(datax[0].estatus1);
      $("#sol_b").text(datax[0].estatus2);
      $("#sol_c").text(datax[0].estatus3);
      $("#sol_d").text(datax[0].estatus4);
      $("#sol_e").text(datax[0].estatus5);
      $("#sol_g").text(datax[0].estatus6);
      $("#sol_f").text(datax[0].solicitudes);
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function graph_waypay(campoa, campob) {
  $.ajax({
    type: "POST",
    url: "/search_data_payment_waypay",
    data: { date : campoa , _token : campob },
    success: function (data){
      console.log(data);
      var data_name = [];
      var data_count = [];
      $.each(JSON.parse(data),function(index, objdata){
        data_name.push(objdata.nombre + ' = ' + objdata.cantidad);
        data_count.push({ value: objdata.cantidad, name: objdata.nombre + ' = ' + objdata.cantidad},);
      });
      graph_pie_default_four_with_porcent_background('main_grap_waypay', data_name, data_count, 'Formas de pagos', '', 'left', 'rgba(255,255,255)');
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function graph_current(campoa, campob) {
  $.ajax({
    type: "POST",
    url: "/search_data_payment_current",
    data: { date : campoa , _token : campob },
    success: function (data){
      var data_name = [];
      var data_count = [];
      $.each(JSON.parse(data),function(index, objdata){
        data_name.push(objdata.nombre + ' = ' + parseFloat(objdata.cantidad).toFixed(2));
        data_count.push({ value: objdata.cantidad, name: objdata.nombre + ' = ' + objdata.cantidad},);
      });
      graph_barras_three_background('main_grap_current', data_name, data_count, 'Montos', 'Denominación & Monto','rgba(255,255,255)');

      // graph_pie_default_four_with_porcent_background('main_grap_current', data_name, data_count, 'Formas de pagos', '', 'left', 'rgba(255,255,255)');
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function table_expense(campoa, campob) {
  $.ajax({
      type: "POST",
      url: "/search_data_payment_classifications",
      data: { date : campoa , _token : campob },
      success: function (data){
        table_classification(data, $("#table_classification"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function table_classification(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_exp_pay);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
  vartable.fnAddData([
      status.nombre,
      status.cantidad
    ]);
  });
}
var Configuration_table_responsive_simple_exp_pay={
      "order": [[ 0, "asc" ]],
      paging: false,
      //"pagingType": "simple",
      Filter: false,
      searching: false,
      //"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      //ordering: false,
      //"pageLength": 5,
      bInfo: false,
      language:{
              "sProcessing":     "Procesando...",
              "sLengthMenu":     "Mostrar _MENU_ registros",
              "sZeroRecords":    "No se encontraron resultados",
              "sEmptyTable":     "Ningún dato disponible",
              "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
              "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix":    "",
              "sSearch":         "Buscar:",
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

$("#boton-aplica-filtro").click(function(event) {
  var _token = $('input[name="_token"]').val();
  var fecha = $('#date_to_search').val();
  function_data_pral(fecha, _token);
  graph_waypay(fecha, _token);
  graph_current(fecha, _token);
  //table_expense(fecha, _token);
  graph_expense_six_per_month(fecha, _token);
});

function graph_expense_six_per_month(campoa, campob) {
  $.ajax({
    type: "POST",
    url: "/search_data_payment_six_months",
    data: { date : campoa , _token : campob },
    success: function (data){
      var data_month = [];
      var data_name = ["MXN","USD","DOP","COP"];
      var value_coin_a = [];
      var value_coin_b = [];
      var value_coin_c = [];
      var value_coin_d = [];

      $.each(JSON.parse(data),function(index, objdata){
        data_month.push(objdata.fecha);
        value_coin_a.push(parseFloat(objdata.mnx).toFixed(2));
        value_coin_b.push(parseFloat(objdata.usd).toFixed(2));
        value_coin_c.push(parseFloat(objdata.dop).toFixed(2));
        value_coin_d.push(parseFloat(objdata.cop).toFixed(2));
      })
      graph_bar_with_four_val_insideRight('main_grap_payment_per_month',data_name, data_month, value_coin_a, value_coin_b, value_coin_c, value_coin_d);
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
