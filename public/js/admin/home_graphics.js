function graph_barras_uno_zendesk(title, fecha_inicio, fecha_final, totallast, promYearLast2, totalnow, promYearnow2, dataTicketYearLastP, dataTicketYearNowP, titlepral) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    title: {
      text: titlepral,
      subtext: 'Total de tickets en el año ' + fecha_inicio + ': ' + totallast + ' con un promedio de: ' + promYearLast2 + ' por mes' + '\n' + 'Total de tickets en el año ' + fecha_final + ': ' + totalnow + ' con un promedio de: ' + promYearnow2 + ' por mes',
      textStyle: {
        color: '#449D44',
        fontStyle: 'normal',
        fontWeight: 'normal',
        fontFamily: 'sans-serif',
        fontSize: 18,
        align: 'left',
        verticalAlign: 'top',
        width: '100%',
        textBorderColor: 'transparent',
        textBorderWidth: 0,
        textShadowColor: 'transparent',
        textShadowBlur: 0,
        textShadowOffsetX: 0,
        textShadowOffsetY: 0,
      },
    },
    // color: ['#3398DB'],
    tooltip : {
      trigger: 'axis',
      axisPointer : {            // 坐标轴指示器，坐标轴触发有效
        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
      }
    },
    legend: {
      data:['Año ' + fecha_inicio, 'Año ' + fecha_final]
    },
    toolbox: {
      show : false,
      feature : {
        dataView : {show: false, readOnly: false, title : 'Datos', lang: ['Vista de datos', 'Cerrar', 'Actualizar']},
        magicType : {
          show: true,
          type: ['line', 'bar'],
          title : {
            line : 'Gráfico de líneas',
            bar : 'Gráfico de barras',
            stack : 'Acumular',
            tiled : 'Tiled',
            force: 'Cambio de diseño orientado a la fuerza',
            chord: 'Interruptor del diagrama de acordes',
            pie: 'Gráfico circular',
            funnel: 'Gráfico de embudo'
          },
        },
        restore : {show: false, title : 'Recargar'},
        saveAsImage : {show: true , title : 'Guardar'}
      }
    },
    calculable : true,
    grid: {
      left: '3%',
      right: '4%',
      bottom: '3%',
      containLabel: true
    },
    xAxis : [
    {
      type : 'category',
      data : ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
      axisTick: {
        alignWithLabel: true
      },
      axisLabel : {
        show:true,
        interval: 'auto',    // {number}
        rotate: 30,
        margin: 10,
        formatter: '{value}',
        textStyle: {
          //  color: 'blue',
          fontFamily: 'sans-serif',
          fontSize: 10,
          fontStyle: 'italic',
          fontWeight: 'bold'
        }
      }
    }
    ],
    yAxis : [
    {
      type : 'value',
      boundaryGap: [0, 0.1]
    }
    ],
    series : [
    {
      name:'Año ' + fecha_inicio,
      type: 'bar',
      data: dataTicketYearLastP,
      itemStyle: {
        normal: {
          label : {
            show: true,
            position: 'inside',
            formatter: function (params) {
              for (var i = 0, l = option.xAxis[0].data.length; i < l; i++) {
                if (option.xAxis[0].data[i] == params.name) {
                  return dataTicketYearLastP[i];
                }
              }
            },
            textStyle: {
              color: '#fff'
            }
          },
        }
      }
    },
    {
      name:'Año ' + fecha_final,
      type: 'bar',
      data: dataTicketYearNowP,
      itemStyle: {
        normal: {
          label : {
            show: true,
            position: 'inside',
            formatter: function (params) {
              for (var i = 0, l = option.xAxis[0].data.length; i < l; i++) {
                if (option.xAxis[0].data[i] == params.name) {
                  return dataTicketYearNowP[i];
                }
              }
            },
            textStyle: {
              color: '#000'
            }
          },
        }
      },
    }
    ]
  };
  myChart.setOption(option);
  $(window).on('resize', function(){
    if(myChart != null && myChart != undefined){
      myChart.resize();
    }
  });
}

function graph_douhnut_defaultdes(title, titlepral, subtitlepral, campoa, campob){
      var myChart = echarts.init(document.getElementById(title));
      var option = {
        title : {
          show: false,
          text: titlepral,
          subtext: subtitlepral,
          x:'center',
          textStyle: {
            color: '#449D44',
            fontStyle: 'normal',
            fontWeight: 'normal',
            fontFamily: 'sans-serif',
            fontSize: 18,
            align: 'center',
            verticalAlign: 'top',
            width: '100%',
            textBorderColor: 'transparent',
            textBorderWidth: 0,
            textShadowColor: 'transparent',
            textShadowBlur: 0,
            textShadowOffsetX: 0,
            textShadowOffsetY: 0,
          },
        },
        grid: {
          left: 0,
          top: 0,
          right: 0,
          bottom: 0
        },
        tooltip : {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          // type: 'scroll',
          orient: 'horizontal',
          // right: 10,
          // top: 10,
          bottom: 10,
          data: campoa
        },
        color : ['#bda29a','#91c7ae','#0B610B', '#E73231', '#635CD9','#2f4554', '#2C68FA', '#FFBF00','#d48265', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#6e7074', '#546570', '#c4ccd3'],
        series : [
        {
          name: 'Información',
          type: 'pie',
          radius: ['30%', '50%'],
          avoidLabelOverlap: false,
          data:campob,
          itemStyle: {
            emphasis: {
              shadowBlur: 0,
              shadowOffsetX: 0,
              shadowColor: 'rgba(0, 0, 0, 0.5)'
            }
          }
        }
        ]
      };
      myChart.setOption(option);

      $(window).on('resize', function(){
        if(myChart != null && myChart != undefined){
          myChart.resize();
        }
      });
    }

function graph_gauge_dahs(title, grapname, valuemin, valuemax, valor) {
  //function graph_gauge(title, campoa, campob) {
  var myChart = echarts.init(document.getElementById(title));
  var option = {
    tooltip : {
        formatter: "{a} <br/>{b} : {c}"
    },
    grid: {
      top:    10,
      bottom: 10,
      left:   '5%',
      right:  '5%',
    },
    toolbox: {
        feature: {
          restore : {show: false, title : 'Recargar'},
          saveAsImage : {show: false , title : 'Guardar'}
        }
    },
    series: [
        {
            name: grapname,
            type: 'gauge',
            splitNumber: 20,
            min: -valuemin,
            max: valuemax,
            detail: {formatter:'{value}'},
            data: [{value: valor, name: grapname}],
            axisLine: {            // 坐标轴线
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: [[0.85, '#E73231'],[0.90, '#FFBF00'],[1, '#0B610B']],
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
          myChart.resize();
      }
  });
}
