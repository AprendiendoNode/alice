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

graph_tickets('graph_tickets');
data_nps();

$('#mes').datepicker().on('changeDate', function (ev) {
  graph_tickets('graph_tickets');
  data_nps();
});

function graph_tickets(title) {
  var chart = document.getElementById(title);

     var myChart = echarts.init(chart);
     var group=[];
     var titles=[];
     var i=0;
     var rotar = 45;
     var tamanio = 12;

     var resizeMainContainer = function () {
       chart.style.width = $("#detractores").width() + "px";
       chart.style.height = $("#tiempos").height() * 1.45 + "px";
       myChart.resize();
    };
 resizeMainContainer();


    option = {
      title: {
          text: 'Número de tickets del mes de Marzo 419'
      },
      tooltip: {
          trigger: 'axis'
      },
      legend: {
        top: '10%',
          data: ['Promotores', 'Pasivos', 'Detractores']
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
              data: [1163, 419, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
              label: {
                show: true
              }
          }
      ],
      color: ['brown']
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

function data_nps() {
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
            $("#pro-res").text(parseInt(data[1][0].Count / data[1][5].Count) + "%");
            $("#pas-res").text(parseInt(data[1][1].Count / data[1][5].Count) + "%");
            $("#det-res").text(parseInt(data[1][2].Count / data[1][5].Count) + "%");
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
       },
       error: function (data) {
         console.error(data);
       }
   });
}
