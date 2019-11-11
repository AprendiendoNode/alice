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
  info_dashboard();
  info_solicitudes();
  info_montos();
});

$("#boton-aplica-filtro").click(function(event) {
  info_dashboard();
  info_solicitudes();
  info_montos();
});


function info_dashboard() {
  var data_count = [];
  var data_name = [];
  var cero = 0;
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/search_info_gen",
      data: objData,
      success: function (data){
        if (data == null || data == '[]') {
          $("#new_answers").text('');
          $("#approved_response").text('');
          $("#answer_pending").text('');
          $("#denied_response").text('');
          $("#verified_answers").text('');
          $("#paid_answers").text('');
          viatics_table(data, $("#table_expense"));
          var data_count = [
            {value: cero, name:'Tpte. Aera = '+ cero},
            {value: cero, name:'Tpte. Terrestre = '+ cero},
            {value: cero, name:'Alimentación = '+ cero},
            {value: cero, name:'Renta auto = '+ cero},
            {value: cero, name:'Tpte. Menores = '+ cero},
            {value: cero, name:'Gasolina = '+ cero},
            {value: cero, name:'Otros = '+ cero}
          ];
          var data_name = [
            "Tpte. Aera = "+ cero,
            "Tpte. Terrestre = "+ cero,
            "Alimentación = "+ cero,
            "Renta auto = "+ cero,
            "Tpte. Menores = "+ cero,
            "Gasolina = "+ cero,
            "Otros = "+ cero
          ];
          graph_barras_four('main_venue',data_name, data_count, 'Total solicitado', 'Conceptos & Costo', 10);
        }
        else {
          if ($.trim(data)){
            datax = JSON.parse(data);
            $("#new_answers").text(datax[0].S_Nueva);
            $("#answer_pending").text(datax[0].S_Pendiente);
            $("#approved_response").text(datax[0].S_Aprobado);
            $("#denied_response").text(datax[0].S_Denegada);
            $("#verified_answers").text(datax[0].S_Verificado);
            $("#paid_answers").text(datax[0].S_Pagada);
            viatics_table(data, $("#table_expense"));

            var data_count = [
              {value: datax[0].C_Tranp_aerea, name:'Tpte. Aera = '+ datax[0].C_Tranp_aerea},
              {value: datax[0].C_Trans_terr, name:'Tpte. Terrestre = '+ datax[0].C_Trans_terr},
              {value: datax[0].C_Hospedaje, name:'Alimentación = '+ datax[0].C_Hospedaje},
              {value: datax[0].C_renta_auto, name:'Renta auto = '+ datax[0].C_renta_auto},
              {value: datax[0].C_trans_menores, name:'Tpte. Menores = '+ datax[0].C_trans_menores},
              {value: datax[0].C_Gasolina, name:'Gasolina = '+ datax[0].C_Gasolina},
              {value: datax[0].C_otros, name:'Otros = '+ datax[0].C_otros}
            ];
            var data_name = [
              "Tpte. Aera = "+ datax[0].C_Tranp_aerea,
              "Tpte. Terrestre = "+ datax[0].C_Trans_terr,
              "Alimentación = "+ datax[0].C_Hospedaje,
              "Renta auto = "+ datax[0].C_renta_auto,
              "Tpte. Menores = "+ datax[0].C_trans_menores,
              "Gasolina = "+ datax[0].C_Gasolina,
              "Otros = "+ datax[0].C_otros
            ];
            graph_barras_four('main_venue',data_name, data_count, 'Total solicitado', 'Conceptos & Costo', 10);
          }
          else{
            $("#new_answers").text('');
            $("#approved_response").text('');
            $("#answer_pending").text('');
            $("#denied_response").text('');
            $("#verified_answers").text('');
            $("#paid_answers").text('');
            viatics_table(data, $("#table_expense"));
            var data_count = [
              {value: cero, name:'Tpte. Aera = '+ cero},
              {value: cero, name:'Tpte. Terrestre = '+ cero},
              {value: cero, name:'Alimentación = '+ cero},
              {value: cero, name:'Renta auto = '+ cero},
              {value: cero, name:'Tpte. Menores = '+ cero},
              {value: cero, name:'Gasolina = '+ cero},
              {value: cero, name:'Otros = '+ cero}
            ];
            var data_name = [
              "Tpte. Aera = "+ cero,
              "Tpte. Terrestre = "+ cero,
              "Alimentación = "+ cero,
              "Renta auto = "+ cero,
              "Tpte. Menores = "+ cero,
              "Gasolina = "+ cero,
              "Otros = "+ cero
            ];
            graph_barras_four('main_venue',data_name, data_count, 'Total solicitado', 'Conceptos & Costo', 10);
          }
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function viatics_table(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
  vartable.fnAddData([
    status.C_Tranp_aerea,
    status.C_Trans_terr,
    status.C_Hospedaje,
    status.C_aliment,
    status.C_renta_auto,
    status.C_trans_menores,
    status.C_Gasolina,
    status.C_otros
    ]);
  });
}

function info_solicitudes() {
  var data_count = [];
  var data_name = [];
  var cero = 0;
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/search_info_gen_solicitud",
      data: objData,
      success: function (data){
        viatics_table_solicitud(data, $("#table_solic"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function info_montos() {
  var data_count = [];
  var data_name = [];
  var cero = 0;
  var objData = $('#search_info').find("select,textarea, input").serialize();
  $.ajax({
      type: "POST",
      url: "/search_info_gen_montos",
      data: objData,
      success: function (data){
        viatics_table_monto(data, $("#table_depart"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}


function viatics_table_solicitud(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
  vartable.fnAddData([
    status.depto,
    status.s_nuevas,
    status.s_aprobadas,
    status.s_pendientes,
    status.s_denegadas,
    status.s_verificadas,
    status.s_pagadas,
    ]);
  });
}

function viatics_table_monto(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){
  vartable.fnAddData([
    status.depto,
    status.trans_aerea,
    status.trans_terr,
    status.hospedaje,
    status.alimentacion,
    status.rent_autos,
    status.trans_menores,
    status.gasolina,
    status.otros
    ]);
  });
}
