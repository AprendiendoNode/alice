
$(function(){
    graph_vert_master();
    graph_vert_anexo();
    graph_vert_aps();
    table_vert_aps() ;
    graph_vert_cont_dos();
    graph_cad_cont_dos();
}());

function graph_vert_master() {
  var data_count = [];
  var data_name = [];
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/show_datavert_contracts_master",
      data: {  _token : _token },
      success: function (data){
        // console.log(data);
        $.each(JSON.parse(data),function(index, objdata){
          data_name.push(objdata.vertical + ' = ' + objdata.cantidad);
          data_count.push({ value: objdata.cantidad, name: objdata.vertical + ' = ' + objdata.cantidad},);
        });
        graph_two_verticals('main_graph_vertical_master',data_name, data_count, 'Contratos', 'Maestros');
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function graph_vert_anexo() {
  var data_count = [];
  var data_name = [];
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/show_datavert_anexo_contracts",
      data: {  _token : _token },
      success: function (data){
        $.each(JSON.parse(data),function(index, objdata){
          data_name.push(objdata.vertical + ' = ' + objdata.cantidad);
          data_count.push({ value: objdata.cantidad, name: objdata.vertical + ' = ' + objdata.cantidad},);
        });
        graph_two_verticals('main_graph_vertical_anexo', data_name, data_count,'Anexos', 'de contratos');
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function graph_vert_aps() {
  var data_count = [];
  var data_name = [];
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/show_grap_ap_x_vertical",
      data: {  _token : _token },
      success: function (data){
        $.each(JSON.parse(data),function(index, objdata){
          data_name.push(objdata.vertical + ' = ' + objdata.cantidad);
          data_count.push({ value: objdata.cantidad, name: objdata.vertical + ' = ' + objdata.cantidad},);
        });
        graph_two_verticals_aps('main_graph_vertical_customers', data_name, data_count);
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function table_vert_aps() {
  var data_count = [];
  var data_name = [];
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/show_table_ap_x_vertical",
      data: {  _token : _token },
      success: function (data){
        table_aps_top(data, $("#tablevertical_aps"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function table_aps_top(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_asc);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){ //Este es el bueno
  // $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.vertical,
      status.cantidad,
      'No disponible'
    ]);
  });
}

function graph_vert_cont_dos() {
  var data_count = [];
  var data_name = [];
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/gen_table_vert_cont",
      data: {  _token : _token },
      success: function (data){
        table_vert_cont_dos(data, $("#table_vertical_contr"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_vert_cont_dos(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_asc);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){ //Este es el bueno
  // $.each(datajson, function(index, status){
    vartable.fnAddData([
      '',
      '',
      '',
      ''
    ]);
  });
}
function graph_cad_cont_dos() {
  var data_count = [];
  var data_name = [];
  var _token = $('input[name="_token"]').val();
  $.ajax({
      type: "POST",
      url: "/gen_table_cad_cont",
      data: {  _token : _token },
      success: function (data){
        table_vert_cont_facts(data, $("#table_fact_cont"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function table_vert_cont_facts(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_responsive_simple_two_asc);
  vartable.fnClearTable();
  $.each(JSON.parse(datajson), function(index, status){ //Este es el bueno
  // $.each(datajson, function(index, status){
    vartable.fnAddData([
      status.cadena,
      status.masters,
      status.annexes,
      status.MXN,
      status.USD,
      status.DOP,
      status.CRC
    ]);
  });
}
