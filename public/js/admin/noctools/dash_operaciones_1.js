graph_tickets('graph_tickets');
//graph_nps('graph_nps');
var $myFuelGauge;

$myFuelGauge = $("div#fuel-gauge").dynameter({
    label:'',
    value: 94,
    min: 0,
    max: 100,
    unit:'<strong style="font-size: 16px;">NPS</strong>',
    regions: {// Value-keys and color-refs
      0:'error',
      80:'warn',
      90:'normal'
    }
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
