var token = $('input[name="_token"]').val();
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
var date_now = yyyy+ '-' + mm + '-' + dd;
$("#date_now").text(date_now);

$(function(){
  // graphTwo();
  // graphThree();
  // graph_four();
  // graph_five();



if(dd<10) { dd = '0'+dd }

if(mm<10) {  mm = '0'+mm }

nContract(date_now, token);

}());

function nContract(date, token){
  var date_now = date;
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/show_dashboard_states",
      data: { date: date_now, _token : _token },
      success: function (data){

        $("#valueOne2").text(data[0].nuevos);
        $("#valueThree").text(data[0].vigentes);
        $("#valueFour").text(data[0].vencidos);
        $("#valueOne").text(data[0].vencidos90dias);
        $("#valueTwo").text(data[0].xVencerAnio);
        $("#valueSix").text(data[0].pausados);
        //console.log(data);
        graphOne(data);

      },
      error: function (data) {
        console.log('Error:', data);
      }
  });

};

function graphOne(data){
  var data_name = [];
  var data_count = [];
  var datos = data;

  data_name = ['Nuevos' + '=' + datos[0].nuevos,'Activos' + '=' + datos[0].vigentes,'Vencidos' + '=' + datos[0].vencidos, 'Vencida a 90 dias' + '=' + datos[0].vencidos90dias,
               'Vencer en este año' + '=' + datos[0].xVencerAnio, 'Pausados' + '=' + datos[0].pausados];

  data_count = [{ value: datos[0].nuevos, name: 'Nuevos' + '=' + datos[0].nuevos} ,{ value: datos[0].vigentes, name: 'Activos' + '=' +  datos[0].vigentes}, { value:datos[0].vencidos, name: 'Vencidos' + '=' + datos[0].vencidos},
                { value: datos[0].vencidos90dias, name: 'Vencida a 90 dias' + '=' + datos[0].vencidos90dias}, { value: datos[0].xVencerAnio, name: 'Vencer en este año' + '=' + datos[0].xVencerAnio},
                { value: datos[0].pausados, name: 'Pausados' + '=' + datos[0].pausados}];
console.log(data_name);
console.log(data_count);
  graph_one_pie_contract('main_graph_contracts',data_name, data_count);

}

function graphTwo(){
  var data_name = [];
  var data_count = [];

  data_name = ['Educación' + '=' + 26,'Hospitalidad' + '=' + 10,'Retail' + '=' + 5];

  data_count = [{ value:16, name: 'Educación' + '=' + 26} ,{ value:10, name: 'Hospitalidad' + '=' + 10}, { value:5, name: 'Retail' + '=' + 5}];


  graph_two_verticals('main_graph_vertical',data_name, data_count);

}

function graphThree(){

  var data_name = [];
  var data_count = [];

  data_name = ['Aeropuerto' + '=' + 15,'Eventos' + '=' + 20,'Parques' + '=' + 8, 'Transporte' + '=' + 12];

  data_count = [{ value:15, name: 'Aeropuerto' + '=' + 15} ,{ value:15, name: 'Eventos' + '=' + 15}, { value:8, name: 'Parques' + '=' + 8}, { value:12, name: 'Transporte' + '=' + 12}];


  graph_three_verticals('main_graph_vertical_customers',data_name, data_count);

}

function graph_four(){
  var data_month = [];
  var data_name = ["Eduación","Hospitalidad","Retail"];
  var value_venue_a = [];
  var value_venue_b = [];
  var value_venue_c = [];
  var data_month = [];

   data_month = ["2018-01-01", "2018-02-01", "2018-03-01", "2018-04-01", "2018-05-01", "2018-06-01",
                 "2018-07-01", "2018-08-01", "2018-09-01", "2018-10-01", "2018-11-01", "2018-12-01"];
   value_venue_a =[70,80,95];
   value_venue_b =[100,80,95];
   value_venue_c =[100,80,95];


  graph_four_vtc('main_graph_vtc',data_name, data_month, value_venue_a, value_venue_b, value_venue_c);
}

function graph_five(){
  var data_sites = [];
  var data_value = [];

  data_sites =  ['Otros', 'UVM', 'Monn Palace', 'UNITEC', 'Sunset', 'Xcaret', 'H10', 'Hard Rock', 'Karisma', 'ALIAT', 'Bluebay'];
  data_value = ['34.26', '10.45', '9.97', '8.11', '6.57', '5.53', '5.28','4.32', '3.66','3.62','2.10'];

  graph_five_fact('main_graph_fact', 'Representación Mensual por Grupo',data_sites, data_value);

}


/*
**Nuevas funciones
*/
function new_contracts_master_table(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/show_table_active_contracts_master",
      data: { _token : _token },
      success: function (data){
        generate_contracts_info_master_act(data, $("#table_act_master"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function new_anexo_contracts_table(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/show_table_active_anexo_contracts",
      data: { _token : _token },
      success: function (data){
        generate_contracts_info_anexo_act(data, $("#table_act_anexo"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function generate_contracts_info_master_act(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_active_contracts22);
  vartable.fnClearTable();
  // console.log(datajson);
  $.each(JSON.parse(datajson), function(index, data){
    vartable.fnAddData([
        data.key,
        data.classifications,
        data.vertical,
        data.cadena,
        data.resguardo,
        '<a href="javascript:void(0);" onclick="getInvoiceContract(this)" data-file="' + data.file + '" class="btn btn-info btn-xs" role="button"><i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar contrato maestro..</a>'
      ]);
  });
}
function generate_contracts_info_anexo_act(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_active_contracts22);
  vartable.fnClearTable();
  // console.log(datajson);
  $.each(JSON.parse(datajson), function(index, data){
    vartable.fnAddData([
        data.key_annexes,
        data.classifications,
        data.vertical,
        data.cadena,
        data.key_master,
        data.itc,
        '<a href="javascript:void(0);" onclick="getInvoiceContract(this)" data-file="' + data.file + '" class="btn btn-info btn-xs" role="button"><i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar contrato anexo..</a>'
      ]);
  });
}

function new_contracts_master_table_now(datex, token) {
  var date_now_x = datex;
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/show_table_active_contracts_master_now",
      data: { date: date_now_x, _token : _token },
      success: function (data){
        generate_contracts_info_master_act(data, $("#table_act_master_now"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function new_anexo_contracts_table_now(datex, token) {
  var date_now_x = datex;
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/show_table_active_anexo_contracts_now",
      data: { date: date_now_x, _token : _token },
      success: function (data){
        generate_contracts_info_anexo_act(data, $("#table_act_anexo_now"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function vencidos_contracts_master_table(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/show_table_expired_contracts_master",
      data: { _token : _token },
      success: function (data){
        generate_contracts_info_master_act(data, $("#table_ven_master"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function vencidos_anexo_contracts_table(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/show_table_expired_anexo_contracts",
      data: { _token : _token },
      success: function (data){
        generate_contracts_info_anexo_act(data, $("#table_ven_anexo"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function generate_contracts_expired_anexo_act(datajson, table){
  table.DataTable().destroy();
  var vartable = table.dataTable(Configuration_table_active_contracts22);
  vartable.fnClearTable();
  // console.log(datajson);
  $.each(JSON.parse(datajson), function(index, data){
    vartable.fnAddData([
        data.key_annexes,
        data.classifications,
        data.vertical,
        data.cadena,
        data.key_master,
        data.itc,
        data.date_scheduled_end,
        '<a href="javascript:void(0);" onclick="getInvoiceContract(this)" data-file="' + data.file + '" class="btn btn-info btn-xs" role="button"><i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar contrato maestro..</a>'
      ]);
  });
}

function nov_anexo_contracts_table(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/show_table_exp_nov_anexo_contracts",
      data: { _token : _token },
      success: function (data){
        generate_contracts_expired_anexo_act(data, $("#table_noventa_anexo"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function exp_year_anexo_contracts_table(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/show_table_exp_year_anexo_contracts",
      data: { _token : _token },
      success: function (data){
        generate_contracts_expired_anexo_act(data, $("#table_vencer_anexo"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

function pause_contracts_master_table(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/show_table_pause_contracts_master",
      data: { _token : _token },
      success: function (data){
        generate_contracts_info_master_act(data, $("#table_pause_master"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
function pause_anexo_contracts_table(token) {
  var _token = token;
  $.ajax({
      type: "POST",
      url: "/show_table_pause_anexo_contracts",
      data: { _token : _token },
      success: function (data){
        generate_contracts_info_anexo_act(data, $("#table_pause_anexo"));
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}
(function(){
		$('#contOne').on('click', function() {
			$('#modal-verOne').modal('show');
      nov_anexo_contracts_table(token);
		});

    $('#contTwo').on('click', function() {
			$('#modal-verTwo').modal('show');
      exp_year_anexo_contracts_table(token);
		});

    $('#contThree').on('click', function() {
			$('#modal-verThree').modal('show');
      new_contracts_master_table_now(date_now, token);
      new_anexo_contracts_table_now(date_now, token);
		});

    $('#contFour').on('click', function() {
			$('#modal-verFour').modal('show');
      new_contracts_master_table(token);
      new_anexo_contracts_table(token);
		});

    $('#contFive').on('click', function() {
			$('#modal-verFive').modal('show');
      vencidos_contracts_master_table(token);
      vencidos_anexo_contracts_table(token);
		});

    $('#contSix').on('click', function() {
			$('#modal-verSix').modal('show');
      pause_contracts_master_table(token);
      pause_anexo_contracts_table(token);
		});


})();

/*
*  Descarga de facturas
*/

 function getInvoiceContract(ev){
  var token = $('input[name="_token"]').val();
  var file =  $(ev).data('file');
  console.log(file);
  $.ajax({
    type: "POST",
    url: "/downloadInvoiceContract",
    data: { file : file , _token : token },
    xhrFields: {responseType: 'blob'},
    success: function(response, status, xhr){
      console.log(response);
    if(response !== '[object Blob]'){

      var filename = "";
      var disposition = xhr.getResponseHeader('Content-Disposition');

                  if (disposition) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                  }
                  var linkelem = document.createElement('a');
                  try {
                      var blob = new Blob([response], { type: 'application/octet-stream' });

                      if (typeof window.navigator.msSaveBlob !== 'undefined') {
                          //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                          window.navigator.msSaveBlob(blob, filename);
                      } else {
                          var URL = window.URL || window.webkitURL;
                          var downloadUrl = URL.createObjectURL(blob);

                          if (filename) {
                              // use HTML5 a[download] attribute to specify filename
                              var a = document.createElement("a");
                              // safari doesn't support this yet
                              if (typeof a.download === 'undefined') {
                                  window.location = downloadUrl;
                              } else {
                                  a.href = downloadUrl;
                                  a.download = filename;
                                  document.body.appendChild(a);
                                  a.target = "_blank";
                                  a.click();
                              }
                          } else {
                              window.location = downloadUrl;
                          }
                      }

                  } catch (ex) {
                      console.log(ex);
                  }
                }else{
                  menssage_toast('Mensaje', '2', 'Este contrato no tiene un archivo adjunto' , '3000');
                }
              },
              error: function (response) {

              }

        });
}
