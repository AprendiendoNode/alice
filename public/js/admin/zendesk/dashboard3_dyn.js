$(function() {
  moment.locale('es');
  $(".oculto").hide();  
  $('#datepickerWeek').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    viewMode: "years",
    minViewMode: "days",
    startDate: "2013-01-01",
    endDate: yearnow
  });

  $('#datepickerWeek2').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    viewMode: "years",
    minViewMode: "days",
    startDate: "2013-01-01",
    endDate: yearnow
  });

  $('#datepickerWeek3').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    viewMode: "years",
    minViewMode: "days",
    startDate: "2013-01-01",
    endDate: yearnow
  });

  $('#datepickerWeek4').datepicker({
    language: 'es',
    format: "yyyy-mm-dd",
    viewMode: "years",
    minViewMode: "days",
    startDate: "2013-01-01",
    endDate: yearnow
  });

  $('#datepickerMonth').datepicker({
    language: 'es',
    format: "mm-yyyy",
    viewMode: "years",
    minViewMode: "months",
    startDate: "01-2013",
    endDate: yearnow,
  });

  $('#datepickerMonth2').datepicker({
    language: 'es',
    format: "mm-yyyy",
    viewMode: "years",
    minViewMode: "months",
    startDate: "01-2013",
    endDate: yearnow,
  });

  $('#datepickerMonth3').datepicker({
    language: 'es',
    format: "mm-yyyy",
    viewMode: "years",
    minViewMode: "months",
    startDate: "01-2013",
    endDate: yearnow,
  });

  $('#datepickerMonth4').datepicker({
    language: 'es',
    format: "mm-yyyy",
    viewMode: "years",
    minViewMode: "months",
    startDate: "01-2013",
    endDate: yearnow,
  });

  $('#datepickerMonth5').datepicker({
    language: 'es',
    format: "mm-yyyy",
    viewMode: "years",
    minViewMode: "months",
    startDate: "01-2013",
    endDate: yearnow,
  });

  $('#datepickerYear').datepicker({
    language: 'es',
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    startDate: "2013",
    endDate: yearnow,
  });

  $('#datepickerYear2').datepicker({
    language: 'es',
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    startDate: "2013",
    endDate: yearnow,
  });

  $('#datepickerYear3').datepicker({
    language: 'es',
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    startDate: "2013",
    endDate: yearnow,
  });

  $('#datepickerYear4').datepicker({
    language: 'es',
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    startDate: "2013",
    endDate: yearnow,
  });

  $("#select_one").select2();
  $("#select_two").select2();
  $("#select_three").select2();

  graph_graph1();
  graph_graph2();
  graph_graph3();
  graph_graph4();
  graph_graph5();
  graph_graph6();
  graph_graph7();
  graph_graph8();
});

var yearnow = moment().format("YYYY");
var yearminus = moment().subtract(1, 'years').format('YYYY');
var mesyearnow = moment().format("MM-YYYY");

var mesdaynow = moment().format("YYYY-MM-DD");
var mesdayminus = moment().subtract(2, 'months').format("YYYY-MM-DD");
var mesdayminus2 = moment().subtract(1, 'days').format("YYYY-MM-DD");

//Grafica 1
$('#datepickerYear').val(yearminus);
$('#datepickerYear').children().val(yearminus);

$('#datepickerYear3').val(yearnow);
$('#datepickerYear3').children().val(yearnow);

//Grafica 2
$('#datepickerMonth').val(mesyearnow);
$('#datepickerMonth').children().val(mesyearnow);

//Grafica 3
$('#datepickerMonth2').val(mesyearnow);
$('#datepickerMonth2').children().val(mesyearnow);

//Grafica 4
$('#datepickerYear2').val(yearnow);
$('#datepickerYear2').children().val(yearnow);

//Grafica 5
$('#datepickerWeek').val(mesdayminus);
$('#datepickerWeek').children().val(mesdayminus);

$('#datepickerWeek2').val(mesdaynow);
$('#datepickerWeek2').children().val(mesdaynow);

//Grafica 6
$('#datepickerMonth3').val(mesyearnow);
$('#datepickerMonth3').children().val(mesyearnow);

//Grafica 7
$('#datepickerMonth4').val(mesyearnow);
$('#datepickerMonth4').children().val(mesyearnow);

//Grafica 8
$('#datepickerWeek3').val(mesdayminus2);
$('#datepickerWeek3').children().val(mesdayminus2);

$('#datepickerWeek4').val(mesdaynow);
$('#datepickerWeek4').children().val(mesdaynow);

//Grafica 9

$('.btn_graph1').on('click', function(e){
  graph_graph1();
});
$('.btn_graph2').on('click', function(e){
  graph_graph2();
});
$('.btn_graph3').on('click', function(e){
  graph_graph3();
});
$('.btn_graph4').on('click', function(e){
  graph_graph4();
});
$('.btn_graph5').on('click', function(e){
  graph_graph5();
});
$('.btn_graph6').on('click', function(e){
  graph_graph6();
});
$('.btn_graph7').on('click', function(e){
  graph_graph7();
});
$('.btn_graph8').on('click', function(e){
  graph_graph8();
});


var _token = $('meta[name="csrf-token"]').attr('content');

// Grafica - Tickets resueltos en el año.
function graph_graph1() {
  var fecha_inicio = "";
  var fecha_final = "";
  var dataTicketYearNowP = [];
  var dataTicketMesNowP = [];
  var dataTicketYearLastP = [];
  var dataTicketMesLastP = [];
  var promYearnow2 = 0;
  var promYearLast2 = 0;
  var totalnow = 0;
  var totallast = 0;

  var input1 = $('#datepickerYear').val();
  var input2 = $('#datepickerYear3').val();

  if (input1 < input2) {  fecha_inicio = input1;  fecha_final = input2; }
  else{ fecha_inicio = input2;  fecha_final = input1; }

  $.ajax({
    url: "/dataTicketYearNowP",
    type: "POST",
    data: { input : fecha_final, _token : _token },
    success: function (data) {
      $.each(JSON.parse(data), function(index, dataX){
        dataTicketYearNowP.push(dataX.tickets);
        dataTicketMesNowP.push(dataX.MES);
        totalnow = totalnow + parseInt(dataX.tickets);
      });
      promYearnow2 = (totalnow / (dataTicketMesNowP.length)).toFixed(2);
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

  $.ajax({
      type: "POST",
      url: "/dataTicketYearLastP",
      data: { input : fecha_inicio, _token : _token },
      success: function (data){
        $.each(JSON.parse(data), function(index, dataInfo){
          dataTicketYearLastP.push(dataInfo.tickets);
          dataTicketMesLastP.push(dataInfo.MES);
          totallast = totallast + parseInt(dataInfo.tickets);
        });
        promYearLast2 = (totallast / (dataTicketMesLastP.length)).toFixed(2);
        graph_barras_uno_zendesk('maingraphicTicketsR',   fecha_inicio, fecha_final, totallast, promYearLast2, totalnow, promYearnow2, dataTicketYearLastP, dataTicketYearNowP, '');
      },
      error: function (data) {
        console.log('Error:', data);
      }
  });
}

// Grafica - Tickets por agente
function graph_graph2() {
   var dataAgentTickets = [];
   var dataAgentName = [];
   var fecha_inicio = $('#datepickerMonth').val();
   $.ajax({
       type: "POST",
       url: "/dataTicketAgent",
       data: { input : fecha_inicio, _token : _token },
       success: function (data){
         $.each(JSON.parse(data), function(index, dataAgent){
           dataAgentTickets.push(dataAgent.ticketsresueltos);
           dataAgentName.push(dataAgent.email);
         });
         graph_two('maingraphicTicketsAgent', 'Tickets Resueltos por mes', dataAgentName, dataAgentTickets);
       },
       error: function (data) {
         console.log('Error:', data);
       }
   });

 }

// Grafica - Tiempo de respuesta y solución
function graph_graph3() {
  var objData = $("#generate_graph3").find("select,textarea, input").serialize();
  var dataTimesSolucion2 = [];
  var dataTimesFirstR2 = [];
  var dataTimesName2 = [];
  var totalSol = 0;
  var totalPrim = 0;
  var promSol = 0;
  var promPrim = 0;

  $.ajax({
    url: "/dataTicketTimes2",
    type: "POST",
    data: objData,
    success: function (data) {
      $.each(JSON.parse(data), function(index, dataTime){
          totalSol = totalSol + parseInt(dataTime.SolucionMin);
          dataTimesSolucion2.push(dataTime.SolucionMin);
          totalPrim = totalPrim + parseInt(dataTime.PrimeraRespuestaMin);
          dataTimesFirstR2.push(dataTime.PrimeraRespuestaMin);
          dataTimesName2.push(dataTime.name);
        });
        promSol = (totalSol / (dataTimesName2.length)).toFixed(2);
        promPrim = (totalPrim / (dataTimesName2.length)).toFixed(2);

      graph_barras_tres_zendesk('maingraphicTicketsTiempos',  promPrim, promSol, dataTimesName2, dataTimesFirstR2, dataTimesSolucion2, '');

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

  $.ajax({
    url: "/historical_average_time",
    type: "POST",
    data: objData,
    success: function (data) {
      averagetimegen(data, $("#time_reps"));
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function averagetimegen(datajson, table){
	table.DataTable().destroy();
	var vartable = table.dataTable(Configuration_table_responsive_simple_disable_order);
	vartable.fnClearTable();
	$.each(JSON.parse(datajson), function(index, status){
	  table.fnAddData([
	    status.AAAAMM,
	    status.promMesPrimResp,
	    status.promMesTiempoResp
	  ]);
	});
}
var Configuration_table_responsive_simple_disable_order={
      "order": false,
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

// Grafica - Tiempo de primera respuesta por mes
function graph_graph4() {
   var dataTimesRM = [];
   var dataTimesMonthRM = [];
   var dataTimesTotTick = [];
   var fecha_inicio = $('#datepickerYear2').val();
   $.ajax({
       type: "POST",
       url: "/dataTicketFirstRespMonth2",
       data: { input : fecha_inicio, _token : _token },
       success: function (data){
         $.each(JSON.parse(data), function(index, dataRM){
           dataTimesRM.push(dataRM.PrimeraRespuestaMin);
           dataTimesMonthRM.push(dataRM.MONTH);
           dataTimesTotTick.push(dataRM.TotalTickets);
         });
         graph_four('maingraphicTicketsTimeResp',dataTimesRM, dataTimesMonthRM, dataTimesTotTick);
       },
       error: function (data) {
         console.log('Error:', data);
       }
   });

 }

// Grafica - Tiempo de primera respuesta por semana.
function graph_graph5() {
     var objData = $("#omega5").find("select,textarea, input").serialize();
     var dataWeekTickets = [];
     var dataWeekPrimeraRespuesta = [];
     var dataWeekCreated = [];
     var dataWeek = [];
     var momentD = "";
     var totalWeek = 0;
     var promedioW = 0;
     $.ajax({
         type: "POST",
         url: "/dataTicketWeekFRP",
         data: objData,
         success: function (data){
           $.each(JSON.parse(data), function(index, dataWP){
             dataWeekTickets.push(dataWP.TotalTickets);
             dataWeekPrimeraRespuesta.push(dataWP.PrimeraRespuestaMin);
             totalWeek = totalWeek + parseInt(dataWP.PrimeraRespuestaMin);
             momentD = dataWP.created_at;
             momentD = moment(momentD).format("DD-MM-YYYY");
             dataWeekCreated.push(momentD);
             dataWeek.push(dataWP.WEEK);
           });
           promWeek = (totalWeek / (dataWeekCreated.length)).toFixed(2);
           graph_five('maingraphicTicketsTimeRespWeek', promWeek ,dataWeekTickets, dataWeekPrimeraRespuesta, dataWeekCreated, dataWeek);

         },
         error: function (data) {
           console.log('Error:', data);
         }
     });
}

// Grafica - Tickets más comunes por mes.
function graph_graph6() {
  var objData = $("#generate_graph6").find("select,textarea, input").serialize();
  var dataTagsCantidad = [];
  var dataTagName = [];
  var item = [];
  $.ajax({
    url: "/dataTagsP",
    type: "POST",
    data: objData,
    success: function (data) {
      $.each(JSON.parse(data), function(index, dataTag){
        dataTagsCantidad.push(dataTag.Cantidad);
        dataTagName.push(dataTag.Tag);
        item.push({value: dataTag.Cantidad, name: dataTag.Tag});
      });
      graph_pie_uno_zendesk('maingraphicTicketsTags', dataTagName, item, '', '');
      graph_barras_seis_zendesk('maingraphicTicketsTags2', dataTagName, dataTagsCantidad, '');
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

// Grafica - Tickets por dominio (cliente).
function graph_graph7() {
  var objData = $("#generate_graph7").find("select,textarea, input").serialize();
  var dataDomainNameIT = [];
  var dataDomainCantd = [];
  $.ajax({
    url: "/dataDominio",
    type: "POST",
    data: objData,
    success: function (data) {
      $.each(JSON.parse(data), function(index, dataDom){
        dataDomainNameIT.push(dataDom.dominio);
        dataDomainCantd.push(dataDom.tickets);
      });
      graph_barras_siete_zendesk('maingraphicTicketsDominios',  dataDomainNameIT, dataDomainCantd,'');
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
// Grafica -Tickets por horarios.
function graph_graph8() {
  var input1 = $('#datepickerWeek3').val();
  var input2 = $('#datepickerWeek4').val();
  if (input1 < input2) {
    fecha_inicio = input1;
    fecha_final = input2;
  }
  else{
    fecha_inicio = input2;
    fecha_final = input1;
  }
  var dataHorario = [];
  var dataTickets = [];
  var dataHorario2 = [];
  var dataTickets2 = [];

  var dataFecha = [];
  var total = 0;
  var promxhora = 0;

  var objData = $("#generate_graph8").find("select,textarea, input").serialize();
  $.ajax({
    url: "/getHorario",
    type: "POST",
    data: { finicio : fecha_inicio, ffin : fecha_final, _token : _token },
    success: function (data) {
      $.each(JSON.parse(data), function(index, dataHor){
        dataHorario.push(dataHor.Horario);
        dataTickets.push(dataHor.Tickets);
        dataFecha.push(dataHor.FechaC);
        total = total + parseInt(dataHor.Tickets);
      });
      promxhora = (total / 24).toFixed(2);
      graph_barras_ocho_a_zendesk('maingraphicHorarioTickets', total, promxhora, dataFecha, dataTickets, '');
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

  $.ajax({
    url: "/getHorario24p",
    type: "POST",
    data: { finicio : fecha_inicio, ffin : fecha_final, _token : _token },
    success: function (data) {
      $.each(JSON.parse(data), function(index, dataHor2){
        dataHorario2.push(dataHor2.Horas);
        dataTickets2.push(dataHor2.Tickets);
      });
      graph_barras_ocho_b_zendesk('maingraphicHorarioTickets2', total, promxhora, dataHorario2, dataTickets2, '');
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

}
