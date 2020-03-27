//DASHBOARD DE OPERACIONES

$('#mes').datepicker({
  language: 'es',
  format: "MM-yyyy",
  viewMode: "months",
  minViewMode: "months",
  autoclose: true,
  clearBtn: true,
  orientation: 'bottom'
}).datepicker("setDate",'now');

//graph_nps('graph_nps');
var myFuelGauge;

myFuelGauge = $("div#fuel-gauge").dynameter({
    label:'',
    value: 0,
    min: 0,
    max: 100,
    unit:'<strong style="font-size: 16px;">NPS</strong>',
    regions: {// Value-keys and color-refs
      0:'error',
      80:'warn',
      90:'normal'
    }
});

all_data();

$('#mes').datepicker().on('changeDate', function (ev) {
  all_data();
});

function graph_tickets(title, data) {
  var vals = Object.values(data);
  var chart = document.getElementById(title);
     var myChart = echarts.init(chart);
     var group=[];
     var titles=[];
     var i=0;
     var rotar = 45;
     var tamanio = 12;

     var resizeMainContainer = function () {
       chart.style.width = $("#sitios_results").width() + "px";
       chart.style.height = $("#tiempos").height() * 1.45 + "px";
       myChart.resize();
    };
   resizeMainContainer();

   option = {
     title: {
         text: 'Número de tickets por mes'
     },
     tooltip: {
         trigger: 'axis'
     },
     legend: {
       top: '10%',
         data: ['Cantidad', 'Prom. Semanal']
     },
     grid: {
         containLabel: true
     },
     xAxis: {
         type: 'category',
         boundaryGap: true,
         data: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
         axisTick: {
             alignWithLabel: true
         },
         axisLabel : {
            show: true,
            interval: '0',
            rotate: 90,
            fontSize: 11
         }
     },
     yAxis: {
         type: 'value'
     },
     series: [
         {
             name: 'Cantidad',
             type: 'line',
             data: vals,
             label: {
               show: true
             }
         },
         {
             name: 'Prom. Semanal',
             type: 'line',
             data: vals.map(function(v) { return parseInt(v / 4); }),
             label: {
               show: true
             }
         }
     ],
     color: ['blue','brown']
   };

  myChart.setOption(option);

  $(window).on('resize', function(){
    resizeMainContainer();
  });
}

function graph_nps(title) {
  //$('#'+title).width($('#'+title).width());
  //$('#'+title).height($('#'+title).height());

 var chart = document.getElementById(title);
 var myChart = echarts.init(chart);
 var resizeMainContainer = function () {
   chart.style.width = $("#encuestas_results").width() + "px";
   chart.style.height = $("#detractores").height() * 1.45 + "px";
   myChart.resize();
 };
  resizeMainContainer();

  var option = {
    tooltip : {
        formatter: "{a} <br/>{b} : {c}"
    },
    grid: {
        show : true,
        containLabel: false,
        backgroundColor: 'transparent',
        borderColor: '#ccc',
        borderWidth: 0,
        top: -10,
        x: 5,
        y: 0,
        x2: 5,
        y2: 0,
    },
    toolbox: {
        feature: {
          restore : {show: false, title : 'Recargar'},
          saveAsImage : {show: false , title : 'Guardar'}
        }
    },
    series: [
        {
            name: "",
            type: 'gauge',
            splitNumber: 10,
            min: -100,
            max: 100,
            detail: {formatter:'{value}'},
            data: [{value: 94, name: ""}],
            axisLine: {            // 坐标轴线
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: [[0.85, '#f0120a'],[0.90, '#f5e60c'],[1, '#0fe81e']],
                    width: 30
                }
            },
            axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: 'auto',
                    fontSize: 10,

                }
            },
        }
    ]
  };

  myChart.setOption(option);

  $(window).on('resize', function(){
      if(myChart != null && myChart != undefined){
        resizeMainContainer();

      }
  });
}

//https://www.jqueryscript.net/other/jQuery-Plugin-To-Generate-Animated-Dynamic-Gauges-dynameter.html

function all_data() {
  var _token = $('input[name="_token"]').val();
  var fecha = $('#mes').val();
  $.ajax({
       type: "POST",
       url: '/dash_operacion_nps',
       data: { _token: _token, fecha: fecha },
       success: function (data) {
          //ReporteMensual
          $("#respondieron").text(data[1][5].Count);
          $("#nps").text(data[1][3].Count);
          myFuelGauge.changeValue(data[1][3].Count);
          $(".mes1").text(data[2]);
          $(".mes2").text(data[3]);
          $("#pro1").text(data[0][0].Count);
          $("#pro2").text(data[1][0].Count);
          $("#pro-icon").html(data[0][0].Count < data[1][0].Count ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
          $("#pas1").text(data[0][1].Count);
          $("#pas2").text(data[1][1].Count);
          $("#pas-icon").html(data[0][1].Count < data[1][1].Count ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
          $("#det1").text(data[0][2].Count);
          $("#det2").text(data[1][2].Count);
          $("#det-icon").html(data[0][2].Count < data[1][2].Count ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
          if($("#respondieron").text() != "0") {
            $("#pro-res").text(parseInt((data[1][0].Count / data[1][5].Count)*100) + "%");
            $("#pas-res").text(parseInt((data[1][1].Count / data[1][5].Count)*100) + "%");
            $("#det-res").text(parseInt((data[1][2].Count / data[1][5].Count)*100) + "%");
          } else {
            $("#pro-res").text("0%");
            $("#pas-res").text("0%");
            $("#det-res").text("0%");
          }
          //SitiosEvaluados
          $("#total1").text(data[0][6].Count);
          $("#total2").text(data[1][6].Count);
          if(data[1][6].Count == 0) {
            $("#total-porcentaje").text("0%");
          } else {
            $("#total-porcentaje").text((data[1][6].Count / data[0][6].Count - 1).toFixed(2) * 100 + "%");
          }
          $("#total-icon").html(data[0][6].Count < data[1][6].Count ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
          $("#res1").text(data[0][5].Count);
          $("#res2").text(data[1][5].Count);
          if(data[1][5].Count == 0) {
            $("#res-porcentaje").text("0%");
          } else {
            $("#res-porcentaje").text((data[1][5].Count / data[0][5].Count - 1).toFixed(2) * 100 + "%");
          }
          $("#res-icon").html(data[0][5].Count < data[1][5].Count ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
          $("#sinres1").text(data[0][4].Count);
          $("#sinres2").text(data[1][4].Count);
          if(data[1][4].Count == 0) {
            $("#sinres-porcentaje").text("0%");
          } else {
            $("#sinres-porcentaje").text((data[1][4].Count / data[0][4].Count - 1).toFixed(2) * 100 + "%");
          }
          $("#sinres-icon").html(data[0][4].Count < data[1][4].Count ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
          //Detractores
          var new_row = "";
          var old = 0, act = 0;
          $(".new_detractores_rows").html("");
          for(var i = 0; i < data[4].length ; i++) {
            if(data[4][i].cal_anterior == "D") {
              old++;
              new_row += "<tr id='seek" + (i + 1) + "' class='new_detractores_rows'><td>" + data[4][i].Nombre_hotel + "</td>";
              switch(data[4][i].cal_siguiente) {
                case "Pr":
                  new_row += "<td><span style='color: green;'>Promotor</span></td>";
                  break;
                case "Ps":
                  new_row += "<td><span style='color: orange;'>Pasivo</span></td>";
                  break;
                case "D":
                  new_row += "<td><span style='color: red;'>Detractor</span></td>";
                  break;
                default:
                  new_row += "<td>No hay respuesta</td>";
              }
              new_row += "<td class='actual_detractores'></td></tr>";
            } else if(old > 0) {
              act++;
              if(act > old) {
                new_row += "<tr id='seek" + (i + 1) + "' class='new_detractores_rows'><td></td>";
                new_row += "<td></td>";
                new_row += "<td class='actual_detractores'>" + data[4][i].Nombre_hotel + "</td></tr>";
                $("#seek" + old).after(new_row);
                new_row = "";
                continue;
              } else {
                $(".actual_detractores").eq(act - 1).text(data[4][i].Nombre_hotel);
              }
            } else {
              new_row += "<tr id='seek" + (i + 1) + "' class='new_detractores_rows'><td></td>";
              new_row += "<td></td>";
              new_row += "<td class='actual_detractores'>" + data[4][i].Nombre_hotel + "</td></tr>";
            }
            $("#seek" + i).after(new_row);
            new_row = "";
          }
          $.ajax({
             type: "POST",
             url: '/dash_operacion_tickets',
             data: { _token: _token, fecha: fecha },
             success: function (data) {
               $("#30_1").text(parseInt(data[0][0]['<30'] * 100) + "%");
               $("#30_2").text(parseInt(data[0][1]['<30'] * 100) + "%");
               $("#30_porc").html(data[0][0]['<30'] < data[0][1]['<30'] ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
               $("#30_color").html(0.95 <= data[0][1]['<30'] ? "<span class='green'></span>" : "<span class='red'></span>");
               $("#30_240_1").text(parseInt(data[0][0]['30<240'] * 100) + "%");
               $("#30_240_2").text(parseInt(data[0][1]['30<240'] * 100) + "%");
               $("#30_240_porc").html(data[0][0]['30<240'] < data[0][1]['30<240'] ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
               $("#30_240_color").html(0.03 >= data[0][1]['30<240'] ? "<span class='green'></span>" : "<span class='red'></span>");
               $("#240_1").text(parseInt(data[0][0]['>240'] * 100) + "%");
               $("#240_2").text(parseInt(data[0][1]['>240'] * 100) + "%");
               $("#240_porc").html(data[0][0]['>240'] < data[0][1]['>240'] ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
               $("#240_color").html(0.02 >= data[0][1]['>240'] ? "<span class='green'></span>" : "<span class='red'></span>");
               $("#2hrs_1").text(parseInt(data[0][0]['<2hrs'] * 100) + "%");
               $("#2hrs_2").text(parseInt(data[0][1]['<2hrs'] * 100) + "%");
               $("#2hrs_porc").html(data[0][0]['<2hrs'] < data[0][1]['<2hrs'] ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
               $("#2hrs_color").html(0.9 <= data[0][1]['<2hrs'] ? "<span class='green'></span>" : "<span class='red'></span>");
               $("#2dias_1").text(parseInt(data[0][0]['<2dias'] * 100) + "%");
               $("#2dias_2").text(parseInt(data[0][1]['<2dias'] * 100) + "%");
               $("#2dias_porc").html(data[0][0]['<2dias'] < data[0][1]['<2dias'] ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
               $("#2dias_color").html(0.05 >= data[0][1]['<2dias'] ? "<span class='green'></span>" : "<span class='red'></span>");
               $("#M2dias_1").text(parseInt(data[0][0]['>2dias'] * 100) + "%");
               $("#M2dias_2").text(parseInt(data[0][1]['>2dias'] * 100) + "%");
               $("#M2dias_porc").html(data[0][0]['>2dias'] < data[0][1]['>2dias'] ? "<i class='fas fa-arrow-circle-up'></i>" : "<i class='fas fa-arrow-circle-down'></i>");
               $("#M2dias_color").html(0.05 >= data[0][1]['>2dias'] ? "<span class='green'></span>" : "<span class='red'></span>");
               $.ajax({
                  type: "POST",
                  url: '/graph_operacion_tickets',
                  data: { _token: _token, fecha: fecha },
                  success: function (data) {
                    graph_tickets('graph_tickets', data[0]);
                    $.ajax({
                         type: "POST",
                         url: '/all_disponibilidad',
                         data: { _token: _token, fecha: fecha },
                         success: function (data) {
                           let ado_telmex_sitios = 0;
                           let ado_telmex_sitios_ant = 0;
                           let ado_telmex_disp1 = 0;
                           let ado_telmex_disp2 = 0;
                           let ado_totalplay_sitios = 0;
                           let ado_totalplay_sitios_ant = 0;
                           let ado_totalplay_disp1 = 0;
                           let ado_totalplay_disp2 = 0;
                           let metrobus_bbs_sitios = 0;
                           let metrobus_bbs_sitios_ant = 0;
                           let metrobus_bbs_disp1 = 0;
                           let metrobus_bbs_disp2 = 0;
                           let metrobus_totalplay_sitios = 0;
                           let metrobus_totalplay_sitios_ant = 0;
                           let metrobus_totalplay_disp1 = 0;
                           let metrobus_totalplay_disp2 = 0;
                           let metrorrey_totalplay_sitios = 0;
                           let metrorrey_totalplay_sitios_ant = 0;
                           let metrorrey_totalplay_disp1 = 0;
                           let metrorrey_totalplay_disp2 = 0;
                           let oma_alestra_sitios = 0;
                           let oma_alestra_sitios_ant = 0;
                           let oma_alestra_disp1 = 0;
                           let oma_alestra_disp2 = 0;
                           let oma_telmex_sitios = 0;
                           let oma_telmex_sitios_ant = 0;
                           let oma_telmex_disp1 = 0;
                           let oma_telmex_disp2 = 0;
                           let asur_alestra_sitios = 0;
                           let asur_alestra_sitios_ant = 0;
                           let asur_alestra_disp1 = 0;
                           let asur_alestra_disp2 = 0;
                           let asur_telmex_sitios = 0;
                           let asur_telmex_sitios_ant = 0;
                           let asur_telmex_disp1 = 0;
                           let asur_telmex_disp2 = 0;
                           let asur_otros_sitios = 0;
                           let asur_otros_sitios_ant = 0;
                           let asur_otros_disp1 = 0;
                           let asur_otros_disp2 = 0;
                           let galerias_alestra_sitios = 0;
                           let galerias_alestra_sitios_ant = 0;
                           let galerias_alestra_disp1 = 0;
                           let galerias_alestra_disp2 = 0;
                           let galerias_telmex_sitios = 0;
                           let galerias_telmex_sitios_ant = 0;
                           let galerias_telmex_disp1 = 0;
                           let galerias_telmex_disp2 = 0;
                           let galerias_totalplay_sitios = 0;
                           let galerias_totalplay_sitios_ant = 0;
                           let galerias_totalplay_disp1 = 0;
                           let galerias_totalplay_disp2 = 0;
                           let hosp_telmex_sitios = 0;
                           let hosp_telmex_sitios_ant = 0;
                           let hosp_telmex_disp1 = 0;
                           let hosp_telmex_disp2 = 0;
                           let hosp_totalplay_sitios = 0;
                           let hosp_totalplay_sitios_ant = 0;
                           let hosp_totalplay_disp1 = 0;
                           let hosp_totalplay_disp2 = 0;
                           let hosp_izzi_sitios = 0;
                           let hosp_izzi_sitios_ant = 0;
                           let hosp_izzi_disp1 = 0;
                           let hosp_izzi_disp2 = 0;
                           let hosp_otros_sitios = 0;
                           let hosp_otros_sitios_ant = 0;
                           let hosp_otros_disp1 = 0;
                           let hosp_otros_disp2 = 0;
                           let retail_telmex_sitios = 0;
                           let retail_telmex_sitios_ant = 0;
                           let retail_telmex_disp1 = 0;
                           let retail_telmex_disp2 = 0;
                           let educacion_alestra_sitios = 0;
                           let educacion_alestra_sitios_ant = 0;
                           let educacion_alestra_disp1 = 0;
                           let educacion_alestra_disp2 = 0;
                           let educacion_telmex_sitios = 0;
                           let educacion_telmex_sitios_ant = 0;
                           let educacion_telmex_disp1 = 0;
                           let educacion_telmex_disp2 = 0;
                           $.each(data[1], function (i, e) { //Mes elegido
                             if(e["sitio"].startsWith("ADO")) {
                               if(e["carrier"].toUpperCase() == "TELMEX") {
                                 ado_telmex_sitios++;
                                 ado_telmex_disp2+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TOTALPLAY") {
                                 ado_totalplay_sitios++;
                                 ado_totalplay_disp2+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["vertical"].toUpperCase() == "METROBUS") {
                               if(e["carrier"].startsWith("BBS")) {
                                 metrobus_bbs_sitios++;
                                 metrobus_bbs_disp2+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TOTALPLAY") {
                                 metrobus_totalplay_sitios++;
                                 metrobus_totalplay_disp2+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["sitio"].startsWith("METRORREY")) {
                               if(e["carrier"].toUpperCase() == "TOTALPLAY") {
                                 metrorrey_totalplay_sitios++;
                                 metrorrey_totalplay_disp2+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["sitio"].startsWith("OMA")) {
                               if(e["carrier"].toUpperCase() == "ALESTRA") {
                                 oma_alestra_sitios++;
                                 oma_alestra_disp2+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TELMEX") {
                                 oma_telmex_sitios++;
                                 oma_telmex_disp2+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["sitio"].startsWith("ASUR")) {
                               if(e["carrier"].toUpperCase() == "ALESTRA") {
                                 asur_alestra_sitios++;
                                 asur_alestra_disp2+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TELMEX") {
                                 asur_telmex_sitios++;
                                 asur_telmex_disp2+=parseInt(e["disponibilidad"]);
                               } else {
                                 asur_otros_sitios++;
                                 asur_otros_disp2+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["vertical"].toUpperCase() == "PLAZA") {
                               if(e["carrier"].toUpperCase() == "ALESTRA") {
                                 galerias_alestra_sitios++;
                                 galerias_alestra_disp2+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TELMEX") {
                                 galerias_telmex_sitios++;
                                 galerias_telmex_disp2+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TOTALPLAY") {
                                 galerias_totalplay_sitios++;
                                 galerias_totalplay_disp2+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["vertical"].toUpperCase() == "HOSPITALIDAD") {
                               if(e["carrier"].toUpperCase() == "TELMEX") {
                                 hosp_telmex_sitios++;
                                 hosp_telmex_disp2+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TOTALPLAY") {
                                 hosp_totalplay_sitios++;
                                 hosp_totalplay_disp2+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "IZZI") {
                                 hosp_izzi_sitios++;
                                 hosp_izzi_disp2+=parseInt(e["disponibilidad"]);
                               } else {
                                 hosp_otros_sitios++;
                                 hosp_otros_disp2+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["vertical"].toUpperCase() == "RETAIL") {
                               if(e["carrier"].toUpperCase() == "TELMEX") {
                                 retail_telmex_sitios++;
                                 retail_telmex_disp2+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["vertical"].toUpperCase() == "EDUCACION") {
                               if(e["carrier"].toUpperCase() == "ALESTRA") {
                                 educacion_alestra_sitios++;
                                 educacion_alestra_disp2+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TELMEX") {
                                 educacion_telmex_sitios++;
                                 educacion_telmex_disp2+=parseInt(e["disponibilidad"]);
                               }
                             }
                           });
                           $.each(data[0], function (i, e) { //Mes anterior
                             if(e["sitio"].startsWith("ADO")) {
                               if(e["carrier"].toUpperCase() == "TELMEX") {
                                 ado_telmex_sitios_ant++;
                                 ado_telmex_disp1+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TOTALPLAY") {
                                 ado_totalplay_sitios_ant++;
                                 ado_totalplay_disp1+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["vertical"].toUpperCase() == "METROBUS") {
                               if(e["carrier"].startsWith("BBS")) {
                                 metrobus_bbs_sitios_ant++;
                                 metrobus_bbs_disp1+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TOTALPLAY") {
                                 metrobus_totalplay_sitios_ant++;
                                 metrobus_totalplay_disp1+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["sitio"].startsWith("METRORREY")) {
                               if(e["carrier"].toUpperCase() == "TOTALPLAY") {
                                 metrorrey_totalplay_sitios_ant++;
                                 metrorrey_totalplay_disp1+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["sitio"].startsWith("OMA")) {
                               if(e["carrier"].toUpperCase() == "ALESTRA") {
                                 oma_alestra_sitios_ant++;
                                 oma_alestra_disp1+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TELMEX") {
                                 oma_telmex_sitios_ant++;
                                 oma_telmex_disp1+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["sitio"].startsWith("ASUR")) {
                               if(e["carrier"].toUpperCase() == "ALESTRA") {
                                 asur_alestra_sitios_ant++;
                                 asur_alestra_disp1+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TELMEX") {
                                 asur_telmex_sitios_ant++;
                                 asur_telmex_disp1+=parseInt(e["disponibilidad"]);
                               } else {
                                 asur_otros_sitios_ant++;
                                 asur_otros_disp1+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["vertical"].toUpperCase() == "PLAZA") {
                               if(e["carrier"].toUpperCase() == "ALESTRA") {
                                 galerias_alestra_sitios_ant++;
                                 galerias_alestra_disp1+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TELMEX") {
                                 galerias_telmex_sitios_ant++;
                                 galerias_telmex_disp1+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TOTALPLAY") {
                                 galerias_totalplay_sitios_ant++;
                                 galerias_totalplay_disp1+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["vertical"].toUpperCase() == "HOSPITALIDAD") {
                               if(e["carrier"].toUpperCase() == "TELMEX") {
                                 hosp_telmex_sitios_ant++;
                                 hosp_telmex_disp1+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TOTALPLAY") {
                                 hosp_totalplay_sitios_ant++;
                                 hosp_totalplay_disp1+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "IZZI") {
                                 hosp_izzi_sitios_ant++;
                                 hosp_izzi_disp1+=parseInt(e["disponibilidad"]);
                               } else {
                                 hosp_otros_sitios_ant++;
                                 hosp_otros_disp1+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["vertical"].toUpperCase() == "RETAIL") {
                               if(e["carrier"].toUpperCase() == "TELMEX") {
                                 retail_telmex_sitios_ant++;
                                 retail_telmex_disp1+=parseInt(e["disponibilidad"]);
                               }
                             } else if(e["vertical"].toUpperCase() == "EDUCACION") {
                               if(e["carrier"].toUpperCase() == "ALESTRA") {
                                 educacion_alestra_sitios_ant++;
                                 educacion_alestra_disp1+=parseInt(e["disponibilidad"]);
                               } else if(e["carrier"].toUpperCase() == "TELMEX") {
                                 educacion_telmex_sitios_ant++;
                                 educacion_telmex_disp1+=parseInt(e["disponibilidad"]);
                               }
                             }
                           });
                           let sla_prom_1 = 0;
                           $("#ado_telmex_sitios").text(ado_telmex_sitios);
                           let aux_porc = parseInt(ado_telmex_disp2 / ado_telmex_sitios);
                           $("#ado_telmex_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#ado_telmex_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(ado_telmex_disp1 / ado_telmex_sitios_ant);
                           $("#ado_telmex_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#ado_telmex_arrow").html(parseFloat($("#ado_telmex_disp1").text()) > parseFloat($("#ado_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#ado_telmex_disp1").text()) == parseFloat($("#ado_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_1+=parseFloat($("#ado_telmex_disp2").text());
                           $("#ado_totalplay_sitios").text(ado_totalplay_sitios);
                           aux_porc = parseInt(ado_totalplay_disp2 / ado_totalplay_sitios);
                           $("#ado_totalplay_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#ado_totalplay_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(ado_totalplay_disp1 / ado_totalplay_sitios_ant);
                           $("#ado_totalplay_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#ado_totalplay_arrow").html(parseFloat($("#ado_totalplay_disp1").text()) > parseFloat($("#ado_totalplay_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#ado_totalplay_disp1").text()) == parseFloat($("#ado_totalplay_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_1+=parseFloat($("#ado_totalplay_disp2").text());
                           $("#metrobus_bbs_sitios").text(metrobus_bbs_sitios);
                           aux_porc = parseInt(metrobus_bbs_disp2 / metrobus_bbs_sitios);
                           $("#metrobus_bbs_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#metrobus_bbs_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(metrobus_bbs_disp1 / metrobus_bbs_sitios_ant);
                           $("#metrobus_bbs_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#metrobus_bbs_arrow").html(parseFloat($("#metrobus_bbs_disp1").text()) > parseFloat($("#metrobus_bbs_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#metrobus_bbs_disp1").text()) == parseFloat($("#metrobus_bbs_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_1+=parseFloat($("#metrobus_bbs_disp2").text());
                           $("#metrobus_totalplay_sitios").text(metrobus_totalplay_sitios);
                           aux_porc = parseInt(metrobus_totalplay_disp2 / metrobus_totalplay_sitios);
                           $("#metrobus_totalplay_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#metrobus_totalplay_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(metrobus_totalplay_disp1 / metrobus_totalplay_sitios_ant);
                           $("#metrobus_totalplay_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#metrobus_totalplay_arrow").html(parseFloat($("#metrobus_totalplay_disp1").text()) > parseFloat($("#metrobus_totalplay_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#metrobus_totalplay_disp1").text()) == parseFloat($("#metrobus_totalplay_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_1+=parseFloat($("#metrobus_totalplay_disp2").text());
                           $("#metrorrey_totalplay_sitios").text(metrorrey_totalplay_sitios);
                           aux_porc = parseInt(metrorrey_totalplay_disp2 / metrorrey_totalplay_sitios);
                           $("#metrorrey_totalplay_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#metrorrey_totalplay_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(metrorrey_totalplay_disp1 / metrorrey_totalplay_sitios_ant);
                           $("#metrorrey_totalplay_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#metrorrey_totalplay_arrow").html(parseFloat($("#metrorrey_totalplay_disp1").text()) > parseFloat($("#metrorrey_totalplay_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#metrorrey_totalplay_disp1").text()) == parseFloat($("#metrorrey_totalplay_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_1+=parseFloat($("#metrorrey_totalplay_disp2").text());
                           $("#sla_prom_1").text(parseInt(sla_prom_1 / 5) + "%");
                           let sla_prom_2 = 0;
                           $("#oma_alestra_sitios").text(oma_alestra_sitios);
                           aux_porc = parseInt(oma_alestra_disp2 / oma_alestra_sitios);
                           $("#oma_alestra_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#oma_alestra_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(oma_alestra_disp1 / oma_alestra_sitios_ant);
                           $("#oma_alestra_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#oma_alestra_arrow").html(parseFloat($("#oma_alestra_disp1").text()) > parseFloat($("#oma_alestra_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#oma_alestra_disp1").text()) == parseFloat($("#oma_alestra_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_2+=parseFloat($("#oma_alestra_disp2").text());
                           $("#oma_telmex_sitios").text(oma_telmex_sitios);
                           aux_porc = parseInt(oma_telmex_disp2 / oma_telmex_sitios);
                           $("#oma_telmex_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#oma_telmex_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(oma_telmex_disp1 / oma_telmex_sitios_ant);
                           $("#oma_telmex_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#oma_telmex_arrow").html(parseFloat($("#oma_telmex_disp1").text()) > parseFloat($("#oma_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#oma_telmex_disp1").text()) == parseFloat($("#oma_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_2+=parseFloat($("#oma_telmex_disp2").text());
                           $("#asur_alestra_sitios").text(asur_alestra_sitios);
                           aux_porc = parseInt(asur_alestra_disp2 / asur_alestra_sitios);
                           $("#asur_alestra_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#asur_alestra_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(asur_alestra_disp1 / asur_alestra_sitios_ant);
                           $("#asur_alestra_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#asur_alestra_arrow").html(parseFloat($("#asur_alestra_disp1").text()) > parseFloat($("#asur_alestra_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#asur_alestra_disp1").text()) == parseFloat($("#asur_alestra_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_2+=parseFloat($("#asur_alestra_disp2").text());
                           $("#asur_telmex_sitios").text(asur_telmex_sitios);
                           aux_porc = parseInt(asur_telmex_disp2 / asur_telmex_sitios);
                           $("#asur_telmex_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#asur_telmex_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(asur_telmex_disp1 / asur_telmex_sitios_ant);
                           $("#asur_telmex_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#asur_telmex_arrow").html(parseFloat($("#asur_telmex_disp1").text()) > parseFloat($("#asur_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#asur_telmex_disp1").text()) == parseFloat($("#asur_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_2+=parseFloat($("#asur_telmex_disp2").text());
                           $("#asur_otros_sitios").text(asur_otros_sitios);
                           aux_porc = parseInt(asur_otros_disp2 / asur_otros_sitios);
                           $("#asur_otros_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#asur_otros_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(asur_otros_disp1 / asur_otros_sitios_ant);
                           $("#asur_otros_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#asur_otros_arrow").html(parseFloat($("#asur_otros_disp1").text()) > parseFloat($("#asur_otros_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#asur_otros_disp1").text()) == parseFloat($("#asur_otros_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_2+=parseFloat($("#asur_otros_disp2").text());
                           $("#sla_prom_2").text(parseInt(sla_prom_2 / 5) + "%");
                           let sla_prom_3 = 0;
                           $("#galerias_alestra_sitios").text(galerias_alestra_sitios);
                           aux_porc = parseInt(galerias_alestra_disp2 / galerias_alestra_sitios);
                           $("#galerias_alestra_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#galerias_alestra_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(galerias_alestra_disp1 / galerias_alestra_sitios_ant);
                           $("#galerias_alestra_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#galerias_alestra_arrow").html(parseFloat($("#galerias_alestra_disp1").text()) > parseFloat($("#galerias_alestra_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#galerias_alestra_disp1").text()) == parseFloat($("#galerias_alestra_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_3+=parseFloat($("#galerias_alestra_disp2").text());
                           $("#galerias_telmex_sitios").text(galerias_telmex_sitios);
                           aux_porc = parseInt(galerias_telmex_disp2 / galerias_telmex_sitios);
                           $("#galerias_telmex_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#galerias_telmex_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(galerias_telmex_disp1 / galerias_telmex_sitios_ant);
                           $("#galerias_telmex_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#galerias_telmex_arrow").html(parseFloat($("#galerias_telmex_disp1").text()) > parseFloat($("#galerias_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#galerias_telmex_disp1").text()) == parseFloat($("#galerias_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_3+=parseFloat($("#galerias_telmex_disp2").text());
                           $("#galerias_totalplay_sitios").text(galerias_totalplay_sitios);
                           aux_porc = parseInt(galerias_totalplay_disp2 / galerias_totalplay_sitios);
                           $("#galerias_totalplay_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#galerias_totalplay_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(galerias_totalplay_disp1 / galerias_totalplay_sitios_ant);
                           $("#galerias_totalplay_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#galerias_totalplay_arrow").html(parseFloat($("#galerias_totalplay_disp1").text()) > parseFloat($("#galerias_totalplay_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#galerias_totalplay_disp1").text()) == parseFloat($("#galerias_totalplay_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_3+=parseFloat($("#galerias_totalplay_disp2").text());
                           $("#sla_prom_3").text(parseInt(sla_prom_3 / 3) + "%");
                           let sla_prom_4 = 0;
                           $("#hosp_telmex_sitios").text(hosp_telmex_sitios);
                           aux_porc = parseInt(hosp_telmex_disp2 / hosp_telmex_sitios);
                           $("#hosp_telmex_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#hosp_telmex_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(hosp_telmex_disp1 / hosp_telmex_sitios_ant);
                           $("#hosp_telmex_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#hosp_telmex_arrow").html(parseFloat($("#hosp_telmex_disp1").text()) > parseFloat($("#hosp_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#hosp_telmex_disp1").text()) == parseFloat($("#hosp_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_4+=parseFloat($("#hosp_telmex_disp2").text());
                           $("#hosp_totalplay_sitios").text(hosp_totalplay_sitios);
                           aux_porc = parseInt(hosp_totalplay_disp2 / hosp_totalplay_sitios);
                           $("#hosp_totalplay_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#hosp_totalplay_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(hosp_totalplay_disp1 / hosp_totalplay_sitios_ant);
                           $("#hosp_totalplay_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#hosp_totalplay_arrow").html(parseFloat($("#hosp_totalplay_disp1").text()) > parseFloat($("#hosp_totalplay_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#hosp_totalplay_disp1").text()) == parseFloat($("#hosp_totalplay_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_4+=parseFloat($("#hosp_totalplay_disp2").text());
                           $("#hosp_izzi_sitios").text(hosp_izzi_sitios);
                           aux_porc = parseInt(hosp_izzi_disp2 / hosp_izzi_sitios);
                           $("#hosp_izzi_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#hosp_izzi_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(hosp_izzi_disp1 / hosp_izzi_sitios_ant);
                           $("#hosp_izzi_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#hosp_izzi_arrow").html(parseFloat($("#hosp_izzi_disp1").text()) > parseFloat($("#hosp_izzi_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#hosp_izzi_disp1").text()) == parseFloat($("#hosp_izzi_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_4+=parseFloat($("#hosp_izzi_disp2").text());
                           $("#hosp_otros_sitios").text(hosp_otros_sitios);
                           aux_porc = parseInt(hosp_otros_disp2 / hosp_otros_sitios);
                           $("#hosp_otros_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#hosp_otros_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(hosp_otros_disp1 / hosp_otros_sitios_ant);
                           $("#hosp_otros_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#hosp_otros_arrow").html(parseFloat($("#hosp_otros_disp1").text()) > parseFloat($("#hosp_otros_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#hosp_otros_disp1").text()) == parseFloat($("#hosp_otros_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_4+=parseFloat($("#hosp_otros_disp2").text());
                           $("#sla_prom_4").text(parseInt(sla_prom_4 / 4) + "%");
                           let sla_prom_5 = 0;
                           $("#retail_telmex_sitios").text(retail_telmex_sitios);
                           aux_porc = parseInt(retail_telmex_disp2 / retail_telmex_sitios);
                           $("#retail_telmex_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#retail_telmex_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(retail_telmex_disp1 / retail_telmex_sitios_ant);
                           $("#retail_telmex_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#retail_telmex_arrow").html(parseFloat($("#retail_telmex_disp1").text()) > parseFloat($("#retail_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#retail_telmex_disp1").text()) == parseFloat($("#retail_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_5+=parseFloat($("#retail_telmex_disp2").text());
                           $("#sla_prom_5").text(parseInt(sla_prom_5 / 1) + "%");
                           let sla_prom_6 = 0;
                           $("#educacion_alestra_sitios").text(educacion_alestra_sitios);
                           aux_porc = parseInt(educacion_alestra_disp2 / educacion_alestra_sitios);
                           $("#educacion_alestra_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#educacion_alestra_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(educacion_alestra_disp1 / educacion_alestra_sitios_ant);
                           $("#educacion_alestra_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#educacion_alestra_arrow").html(parseFloat($("#educacion_alestra_disp1").text()) > parseFloat($("#educacion_alestra_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#educacion_alestra_disp1").text()) == parseFloat($("#educacion_alestra_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_6+=parseFloat($("#educacion_alestra_disp2").text());
                           $("#educacion_telmex_sitios").text(educacion_telmex_sitios);
                           aux_porc = parseInt(educacion_telmex_disp2 / educacion_telmex_sitios);
                           $("#educacion_telmex_ball").html(98 > aux_porc ? "<span class='red'></span>" : (isNaN(aux_porc) ? "<span class='red'></span>" : "<span class='green'></span>"));
                           $("#educacion_telmex_disp2").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           aux_porc = parseInt(educacion_telmex_disp1 / educacion_telmex_sitios_ant);
                           $("#educacion_telmex_disp1").text(isNaN(aux_porc) ? "0%" : (aux_porc+"%"));
                           $("#educacion_telmex_arrow").html(parseFloat($("#educacion_telmex_disp1").text()) > parseFloat($("#educacion_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-down'></i>" : (parseFloat($("#educacion_telmex_disp1").text()) == parseFloat($("#educacion_telmex_disp2").text()) ? "<i class='fas fa-arrow-circle-right'></i>" : "<i class='fas fa-arrow-circle-up'></i>"));
                           sla_prom_6+=parseFloat($("#educacion_telmex_disp2").text());
                           $("#sla_prom_6").text(parseInt(sla_prom_6 / 2) + "%");
                         },
                         error: function (data) {
                           console.error(data);
                         }
                    });
                  },
                  error: function (data) {
                    console.error(data);
                  }
                });
             },
             error: function (data) {
               console.error(data);
             }
          });
       },
       error: function (data) {
         console.error(data);
       }
   });
}
